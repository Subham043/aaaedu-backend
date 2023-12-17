<?php

namespace App\Modules\Test\AnswerSheet\Models;

use App\Enums\TestStatus;
use App\Enums\TestEnrollmentType;
use App\Enums\PaymentStatus;
use App\Modules\Authentication\Models\User;
use App\Modules\Test\Questionarie\Models\Questionarie;
use App\Modules\Test\Quiz\Models\Quiz;
use App\Modules\Test\Test\Models\Test;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class TestTaken extends Model
{
    use HasFactory;

    protected $table = 'test_takens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'test_id',
        'current_quiz_id',
        'current_question_id',
        'user_id',
        'is_enrolled',
        'enrollment_type',
        'test_status',
        'reason',
        'amount',
        'receipt',
        'payment_status',
        'razorpay_signature',
        'razorpay_order_id',
        'razorpay_payment_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_enrolled' => 'boolean',
        'enrollment_type' => TestEnrollmentType::class,
        'test_status' => TestStatus::class,
        'payment_status' => PaymentStatus::class,
    ];

    protected $attributes = [
        'enrollment_type' => TestEnrollmentType::FREE,
        'test_status' => TestStatus::PENDING,
        'payment_status' => PaymentStatus::PENDING,
    ];

    protected function uuid(): Attribute
    {
        return Attribute::make(
            set: fn () => str()->uuid(),
        );
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id')->withDefault();
    }

    public function current_quiz()
    {
        return $this->belongsTo(Quiz::class, 'current_quiz_id')->withDefault();
    }

    public function current_question()
    {
        return $this->belongsTo(Questionarie::class, 'current_question_id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }
}
