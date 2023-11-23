<?php

namespace App\Modules\Test\AnswerSheet\Models;

use App\Enums\CorrectAnswer;
use App\Enums\TestAttemptStatus;
use App\Modules\Test\AnswerSheet\Models\TestTaken;
use App\Modules\Test\Quiz\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerSheet extends Model
{
    use HasFactory;

    protected $table = 'test_taken_answer_sheets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'test_taken_id',
        'quiz_id',
        'correct_answer',
        'attempted_answer',
        'marks_alloted',
        'attempt_status',
        'reason',
    ];

    protected $casts = [
        'marks_alloted' => 'int',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'attempt_status' => TestAttemptStatus::class,
        'correct_answer' => CorrectAnswer::class,
        'attempted_answer' => CorrectAnswer::class,
    ];

    protected $attributes = [
        'attempt_status' => TestAttemptStatus::FAILED,
        'correct_answer' => CorrectAnswer::Answer1,
        'attempted_answer' => CorrectAnswer::Answer1,
    ];

    public function test_taken()
    {
        return $this->belongsTo(TestTaken::class, 'test_taken_id')->withDefault();
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id')->withDefault();
    }
}
