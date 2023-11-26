<?php

namespace App\Modules\Test\AnswerSheet\Services;

use App\Enums\PaymentStatus;
use App\Enums\TestAttemptStatus;
use App\Enums\TestEnrollmentType;
use App\Enums\TestStatus;
use App\Http\Services\RazorpayService;
use App\Modules\Test\AnswerSheet\Models\TestTaken;
use App\Modules\Test\AnswerSheet\Models\AnswerSheet;
use App\Modules\Test\AnswerSheet\Requests\AnswerSheetRequest;
use App\Modules\Test\AnswerSheet\Requests\EliminatedRequest;
use App\Modules\Test\Quiz\Models\Quiz;
use App\Modules\Test\Quiz\Services\QuizService;
use App\Modules\Test\Test\Models\Test;
use Error;
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

    public function test_report(Test $test): TestTaken
    {
        return TestTaken::where('test_id', $test->id)
        ->where('user_id', auth()->user()->id)
        ->where('is_enrolled', true)
        ->where(function($qry){
            $qry->where('test_status', TestStatus::COMPLETED->value)->orWhere('test_status', TestStatus::ELIMINATED->value);
        })
        ->firstOrFail();
    }

    public function fill_answer(AnswerSheetRequest $request, Test $test): void
    {
        $test_question = $this->test_question($test);
        if($test_question->test_status->value==TestStatus::ONGOING->value || $test_question->test_status->value==TestStatus::PENDING->value){
            AnswerSheet::create([
                'test_taken_id' => $test_question->id,
                'quiz_id' => $test_question->current_quiz->id,
                'correct_answer' => $test_question->current_quiz->correct_answer->value,
                'marks_alloted' => empty($request->attempted_answer) ? 0 : ($request->attempted_answer==$test_question->current_quiz->correct_answer->value ? $test_question->current_quiz->mark : 0),
                ...$request->all()
            ]);
            $next_question = $this->get_next_question($test, $test_question->current_quiz->id);
            if(!empty($next_question)){
                $test_question->current_quiz_id=$next_question->id;
                $test_question->test_status=TestStatus::ONGOING->value;
            }else{
                $test_question->test_status=TestStatus::COMPLETED->value;
            }
            $test_question->save();
            return;
        }
        throw new Error("Exam is over already!", 400);
    }

    public function eliminated(EliminatedRequest $request, Test $test): void
    {
        $test_question = $this->test_question($test);
        if($test_question->test_status->value==TestStatus::ONGOING->value || $test_question->test_status->value==TestStatus::PENDING->value){
            AnswerSheet::create([
                'test_taken_id' => $test_question->id,
                'quiz_id' => $test_question->current_quiz->id,
                'marks_alloted' => 0,
                'attempt_status' => TestAttemptStatus::ELIMINATED->value,
                'reason' => $request->reason
            ]);
            $test_question->update([
                ...$request->all()
            ]);
            return;
        }
        throw new Error("Exam is over already!", 400);
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

    public function get_next_question(Test $test, Int $current_question_id): Quiz|null
    {
        $all_questions = ((new QuizService)->all_main_grouped_by_subjects($test->id));
        foreach($all_questions as $k=>$v){
            if($v->id==$current_question_id){
                $index = $k+1;
                if($index<count($all_questions)){
                    return $all_questions[$index];
                }
            }
        }
        return null;
    }

}
