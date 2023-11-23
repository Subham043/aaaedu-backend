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
