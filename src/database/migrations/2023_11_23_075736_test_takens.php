<?php

use App\Enums\PaymentStatus;
use App\Enums\TestEnrollmentType;
use App\Enums\TestStatus;
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
        Schema::create('test_takens', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 500)->unique()->nullable();
            $table->foreignId('test_id')->nullable()->constrained('tests')->nullOnDelete();
            $table->foreignId('current_quiz_id')->nullable()->constrained('test_quizs')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_enrolled')->default(0);
            $table->string('enrollment_type', 500)->default(TestEnrollmentType::FREE->value)->nullable();
            $table->string('test_status', 500)->default(TestStatus::PENDING->value)->nullable();
            $table->text('reason')->nullable();
            $table->string('amount', 500)->default(0);
            $table->string('receipt', 255)->nullable();
            $table->string('payment_status', 255)->default(PaymentStatus::PENDING->value)->nullable();
            $table->string('razorpay_signature', 255)->nullable();
            $table->text('razorpay_order_id')->nullable();
            $table->text('razorpay_payment_id')->nullable();
            $table->timestamps();
            $table->index(['id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_takens');
    }
};
