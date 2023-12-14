<?php

namespace App\Modules\Test\Test\Models;

use App\Modules\Authentication\Models\User;
use App\Modules\Test\AnswerSheet\Models\TestTaken;
use App\Modules\Test\Quiz\Models\Quiz;
use App\Modules\Test\Subject\Models\Subject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Test extends Model implements Sitemapable
{
    use HasFactory, LogsActivity;

    protected $table = 'tests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'amount',
        'description',
        'description_unfiltered',
        'image',
        'image_alt',
        'image_title',
        'is_active',
        'is_paid',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_scripts',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_paid' => 'boolean',
        'amount' => 'int',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $image_path = 'tests';

    protected $appends = ['image_link'];

    protected function image(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => 'storage/'.$this->image_path.'/'.$value,
        );
    }

    protected function imageLink(): Attribute
    {
        return new Attribute(
            get: fn () => asset($this->image),
        );
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => str()->slug($value),
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'test_id');
    }

    public function quizes()
    {
        return $this->hasMany(Quiz::class, 'test_id');
    }

    public function test_taken()
    {
        return $this->hasOne(TestTaken::class, 'test_id')->where('user_id', auth()->check() ? auth()->user()->id : null);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('tests')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Test with name ".$this->name." has been {$eventName}";
                    $desc .= auth()->user() ? " by ".auth()->user()->name."<".auth()->user()->email.">" : "";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
    }

    public function toSitemapTag(): Url | string | array
    {
        return route('tests_detail.get', $this->slug);
    }
}
