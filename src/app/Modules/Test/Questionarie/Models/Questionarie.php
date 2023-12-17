<?php

namespace App\Modules\Test\Questionarie\Models;

use App\Enums\CorrectAnswer;
use App\Modules\Test\Quiz\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Questionarie extends Model implements Sitemapable
{
    use HasFactory, LogsActivity;

    protected $table = 'test_quiz_questionaries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question',
        'question_unfiltered',
        'answer_1',
        'answer_1_unfiltered',
        'answer_2',
        'answer_2_unfiltered',
        'answer_3',
        'answer_3_unfiltered',
        'answer_4',
        'answer_4_unfiltered',
        'correct_answer',
        'quiz_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'correct_answer' => CorrectAnswer::class,
    ];

    protected $attributes = [
        'correct_answer' => CorrectAnswer::Answer1,
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id')->withDefault();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('test_quizs')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Questionarie has been {$eventName}";
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
