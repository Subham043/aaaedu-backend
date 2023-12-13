<?php

namespace App\Modules\Blog\Comment\Models;

use App\Modules\Blog\Comment\Jobs\BlogCommentEmailJob;
use App\Modules\Blog\Models\Blog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Comment extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'blog_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'comment',
        'is_approved',
        'blog_id',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_approved' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();
        self::created(function ($data) {
            dispatch(new BlogCommentEmailJob($data));
        });
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id')->withDefault();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('blog_comments')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Comment from ".$this->name." has been {$eventName}";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
    }
}
