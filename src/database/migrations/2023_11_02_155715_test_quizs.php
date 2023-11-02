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
        Schema::create('test_quizs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 500)->unique()->nullable();
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
            $table->string('difficulty', 500)->nullable();
            $table->string('duration', 500)->nullable();
            $table->string('mark', 500)->nullable();
            $table->string('correct_answer', 500)->nullable();
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->nullOnDelete();
            $table->foreignId('test_id')->nullable()->constrained('tests')->nullOnDelete();
            $table->timestamps();
            $table->index(['id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_quizs');
    }
};
