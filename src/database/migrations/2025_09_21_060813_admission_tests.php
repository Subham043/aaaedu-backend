<?php

use App\Enums\ExamMode;
use App\Enums\PaymentStatus;
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
        Schema::create('admission_tests', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500)->nullable();
            $table->string('email', 500)->nullable();
            $table->string('school_name', 500)->nullable();
            $table->string('class', 500)->nullable();
            $table->string('father_name', 500)->nullable();
            $table->string('father_phone', 500)->nullable();
            $table->string('father_email', 500)->nullable();
            $table->string('mother_name', 500)->nullable();
            $table->string('mother_phone', 500)->nullable();
            $table->string('mother_email', 500)->nullable();
            $table->string('image', 500)->nullable();
            $table->string('program', 500)->nullable();
            $table->string('address', 500)->nullable();
            $table->string('mode', 500)->default(ExamMode::OFFLINE->value)->nullable();
            $table->string('exam_date', 500)->nullable();
            $table->string('exam_center', 500)->nullable();
            $table->string('amount', 500)->default(0);
            $table->string('receipt', 255)->nullable();
            $table->string('payment_status', 255)->default(PaymentStatus::PENDING->value)->nullable();
            $table->string('razorpay_signature', 255)->nullable();
            $table->text('razorpay_order_id')->nullable();
            $table->text('razorpay_payment_id')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_tests');
    }
};
