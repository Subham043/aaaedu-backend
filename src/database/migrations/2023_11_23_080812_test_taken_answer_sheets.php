<?php

use App\Enums\CorrectAnswer;
use App\Enums\TestAttemptStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('test_taken_answer_sheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_taken_id')->nullable()->constrained('test_takens')->nullOnDelete();
            $table->foreignId('quiz_id')->nullable()->constrained('test_quizs')->nullOnDelete();
            $table->foreignId('question_id')->nullable()->constrained('test_quiz_questionaries')->nullOnDelete();
            $table->string('subject_name', 500);
            $table->string('difficulty', 500)->nullable();
            $table->string('duration', 500)->nullable();
            $table->string('mark', 500)->nullable();
            $table->string('negative_mark', 500)->default(0);
            $table->text('question')->nullable();
            $table->text('question_unfiltered')->nullable();
            $table->text('answer_1')->nullable();
            $table->text('answer_1_unfiltered')->nullable();
            $table->text('answer_2')->nullable();
            $table->text('answer_2_unfiltered')->nullable();
            $table->text('answer_3')->nullable();
            $table->text('answer_3_unfiltered')->nullable();
            $table->text('answer_4')->nullable();
            $table->text('answer_4_unfiltered')->nullable();
            $table->string('correct_answer', 500)->default(CorrectAnswer::Answer1->value)->nullable();
            $table->string('attempted_answer', 500)->default(CorrectAnswer::Answer1->value)->nullable();
            $table->string('marks_alloted', 500)->nullable();
            $table->string('attempt_status', 500)->default(TestAttemptStatus::FAILED->value)->nullable();
            $table->text('reason')->nullable();
            $table->timestamps();
            $table->index(['id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_taken_answer_sheets');
    }
};