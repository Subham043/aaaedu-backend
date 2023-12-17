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
            $table->string('difficulty', 500)->nullable();
            $table->string('duration', 500)->nullable();
            $table->string('mark', 500)->nullable();
            $table->string('negative_mark', 500)->default(0);
            $table->foreignId('subject_id')->nullable()->constrained('test_subjects')->nullOnDelete();
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
