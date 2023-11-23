<?php

namespace App\Modules\Test\AnswerSheet\Services;

use App\Enums\PaymentStatus;
use App\Enums\TestEnrollmentType;
use App\Enums\TestStatus;
use App\Http\Services\RazorpayService;
use App\Modules\Test\AnswerSheet\Models\TestTaken;
use App\Modules\Test\AnswerSheet\Models\AnswerSheet;
use App\Modules\Test\Quiz\Services\QuizService;
use App\Modules\Test\Test\Models\Test;
use Illuminate\Support\Str;

class AnswerSheetService
{
    public function apply_test(Test $test): TestTaken
    {
        $quiz = (new QuizService)->getCurrentQuizByTestId($test->id);
        $payment_arr = array();
        if($test->is_paid){
            $receipt = Str::uuid()->toString();
            $payment_arr['receipt'] = $receipt;
            $payment_arr['amount'] = $test->amount;
            $payment_arr['razorpay_order_id'] = (new RazorpayService)->create_order_id($test->amount, $receipt);
            $payment_arr['payment_status'] = PaymentStatus::PENDING->value;
        }
        $test_taken = TestTaken::create(
            [
                'test_id' => $test->id,
                'current_quiz_id'=> $quiz->id,
                'user_id' => auth()->user()->id,
                'uuid' => Str::uuid()->toString(),
                'is_enrolled' => $test->is_paid ? false : true,
                'enrollment_type' => $test->is_paid ? TestEnrollmentType::PURCHASED->value : TestEnrollmentType::FREE->value,
                'test_status' => TestStatus::PENDING->value,
                ...$payment_arr
            ],
        );
        return $test_taken;
    }

    public function test_question(Test $test): TestTaken
    {
        return TestTaken::with([
            'current_quiz'
        ])
        ->where('test_id', $test->id)
        ->where('user_id', auth()->user()->id)
        ->where('is_enrolled', true)
        ->firstOrFail();
    }

    public function current_question_count(int $test_taken_id): int
    {
        return AnswerSheet::where('test_taken_id', $test_taken_id)->count() + 1;
    }

    public function check_test_eligibility(Test $test): array
    {
        $test_taken = TestTaken::where('test_id', $test->id)->where('user_id', auth()->user()->id)->first();
        if(empty($test_taken)){
            return [
                'is_eligible' => true,
                'type' => 'NEW'
            ];
        }else{
            if($test->is_paid){
                if($test_taken->is_enrolled && $test_taken->payment_status == PaymentStatus::PAID){
                    return [
                        'is_eligible' => false,
                        'type' => 'ENROLLMENT_PAID'
                    ];
                }else{
                    return [
                        'is_eligible' => true,
                        'type' => 'PAYMENT_PENDING',
                        'test_taken' => $test_taken
                    ];
                }
            }else{
                return [
                    'is_eligible' => false,
                    'type' => 'ENROLLMENT_FREE'
                ];
            }
        }
    }

    public function verify_payment(array $data): TestTaken
    {
        $test_taken = TestTaken::where('razorpay_order_id', $data['razorpay_order_id'])->firstOrFail();
        $test_taken->razorpay_payment_id = $data['razorpay_payment_id'];
        $test_taken->razorpay_signature = $data['razorpay_signature'];
        $test_taken->payment_status = PaymentStatus::PAID;
        $test_taken->is_enrolled = true;
        $test_taken->save();
        return $test_taken;
    }

}
