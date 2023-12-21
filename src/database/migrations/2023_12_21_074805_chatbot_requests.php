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
        Schema::create('chatbot_requests', function (Blueprint $table) {
            $table->id();
            $table->string('email', 500)->nullable();
            $table->string('name', 500)->nullable();
            $table->string('phone', 500)->nullable();
            $table->string('lead_id', 500)->nullable();
            $table->string('ip_address', 500)->nullable();
            $table->string('country', 500)->nullable();
            $table->string('latitude', 500)->nullable();
            $table->string('longitude', 500)->nullable();
            $table->string('browser', 500)->nullable();
            $table->string('is_mobile', 500)->nullable();
            $table->string('visit_question', 500)->nullable();
            $table->string('admission_question', 500)->nullable();
            $table->string('contact_question', 500)->nullable();
            $table->string('multiple_choice_query', 500)->nullable();
            $table->string('school_course_question', 500)->nullable();
            $table->string('course_location_question', 500)->nullable();
            $table->string('course_standard_question', 500)->nullable();
            $table->string('final_callback_question', 500)->nullable();
            $table->string('schedule_callback_question', 500)->nullable();
            $table->string('status', 500)->nullable();
            $table->string('page_url', 500)->nullable();
            $table->timestamps();
            $table->index(['id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_requests');
    }
};
