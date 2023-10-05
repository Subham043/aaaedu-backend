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
        Schema::create('course_branch_details', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->text('description_unfiltered')->nullable();
            $table->boolean('include_testimonial')->default(0);
            $table->text('testimonial_heading')->nullable();
            $table->boolean('include_topper')->default(0);
            $table->text('topper_heading')->nullable();
            $table->boolean('include_staff')->default(0);
            $table->text('staff_heading')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_scripts')->nullable();
            $table->string('amount', 500)->default(0);
            $table->string('discount', 500)->default(0);
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->foreignId('course_id')->nullable()->constrained('courses')->nullOnDelete();
            $table->timestamps();
            $table->index(['id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_branch_details');
    }
};
