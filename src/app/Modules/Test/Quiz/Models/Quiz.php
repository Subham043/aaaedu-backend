<?php

namespace App\Modules\Test\Quiz\Models;

use App\Enums\Difficulty;
use App\Modules\Test\Questionarie\Models\Questionarie;
use App\Modules\Test\Subject\Models\Subject;
use App\Modules\Test\Test\Models\Test;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Quiz extends Model implements Sitemapable
{
    use HasFactory, LogsActivity;

    protected $table = 'test_quizs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'difficulty',
        'duration',
        'mark',
        'negative_mark',
        'subject_id',
        'test_id',
    ];

    protected $casts = [
        'mark' => 'int',
        'negative_mark' => 'int',
        'duration' => 'int',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'difficulty' => Difficulty::class,
    ];

    protected $attributes = [
        'difficulty' => Difficulty::Easy,
        'negative_mark' => 0,
    ];

    protected function uuid(): Attribute
    {
        return Attribute::make(
            set: fn () => str()->uuid(),
        );
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id')->withDefault();
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id')->withDefault();
    }

    public function questionaries()
    {
        return $this->hasMany(Questionarie::class, 'quiz_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('test_quizs')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Quiz has been {$eventName}";
                    $desc .= auth()->user() ? " by ".auth()->user()->name."<".auth()->user()->email.">" : "";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
    }

    public function toSitemapTag(): Url | string | array
    {
        return route('test_quizs_detail.get', $this->slug);
    }
}
