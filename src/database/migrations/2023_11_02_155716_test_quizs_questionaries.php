<?php

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
        Schema::create('test_quiz_questionaries', function (Blueprint $table) {
            $table->id();
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
            $table->string('correct_answer', 500)->nullable();
            $table->foreignId('quiz_id')->nullable()->constrained('test_quizs')->nullOnDelete();
            $table->timestamps();
            $table->index(['id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_quiz_questionaries');
    }
};
