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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

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
        $questionarie_set = $quiz->questionaries->pluck('id')->toArray();
        $key = array_rand($questionarie_set);
        $test_taken = TestTaken::create(
            [
                'test_id' => $test->id,
                'current_quiz_id'=> $quiz->id,
                'current_question_id'=> $questionarie_set[$key],
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
            'current_quiz',
            'current_question'
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
            $qry->where('test_status', TestStatus::COMPLETED->value);
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
                'question_id' => $test_question->current_question->id,
                'subject_name' => $test_question->current_quiz->subject->name,
                'difficulty' => $test_question->current_quiz->difficulty,
                'duration' => $test_question->current_quiz->duration,
                'mark' => $test_question->current_quiz->mark,
                'negative_mark' => $test_question->current_quiz->negative_mark,
                'question' => $test_question->current_question->question,
                'question_unfiltered' => $test_question->current_question->question_unfiltered,
                'answer_1' => $test_question->current_question->answer_1,
                'answer_1_unfiltered' => $test_question->current_question->answer_1_unfiltered,
                'answer_2' => $test_question->current_question->answer_2,
                'answer_2_unfiltered' => $test_question->current_question->answer_2_unfiltered,
                'answer_3' => $test_question->current_question->answer_3,
                'answer_3_unfiltered' => $test_question->current_question->answer_3_unfiltered,
                'answer_4' => $test_question->current_question->answer_4,
                'answer_4_unfiltered' => $test_question->current_question->answer_4_unfiltered,
                'correct_answer' => $test_question->current_question->correct_answer->value,
                'marks_alloted' => empty($request->attempted_answer) ? $test_question->current_quiz->negative_mark : ($request->attempted_answer==$test_question->current_question->correct_answer->value ? $test_question->current_quiz->mark : $test_question->current_quiz->negative_mark),
                ...$request->all()
            ]);
            $next_question = $this->get_next_question($test, $test_question->current_quiz->id);
            if(!empty($next_question)){
                $questionarie_set = $next_question->questionaries->pluck('id')->toArray();
                $key = array_rand($questionarie_set);
                $test_question->current_quiz_id=$next_question->id;
                $test_question->current_question_id=$questionarie_set[$key];
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
                'question_id' => $test_question->current_question->id,
                'marks_alloted' => $test_question->current_quiz->negative_mark,
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

    public function cancel_payment(array $data): TestTaken
    {
        $test_taken = TestTaken::where('razorpay_order_id', $data['razorpay_order_id'])->firstOrFail();
        $test_taken->payment_status = PaymentStatus::CANCELLED;
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

    public function total_alloted_score(int $test_taken_id): Int
    {
        return AnswerSheet::where('test_taken_id', $test_taken_id)->sum('marks_alloted');
    }

    public function total_alloted_score_grouped_by_subjects(int $test_taken_id)
    {
        return DB::table('test_subjects')
        ->selectRaw('COUNT(test_subjects.name) AS number_of_question, test_subjects.name, sum(test_quizs.mark) as total_mark_sum, sum(test_taken_answer_sheets.marks_alloted) as total_mark_alloted_sum, CAST(sum(case when test_taken_answer_sheets.attempt_status = "Failed To Answer" then 1 else 0 end) as UNSIGNED) as not_attempt_count, CAST(sum(case when test_taken_answer_sheets.attempt_status = "Attempted" then 1 else 0 end) as UNSIGNED) as attempt_count')
        ->join('test_quizs','test_quizs.subject_id','=','test_subjects.id')
        ->join('test_taken_answer_sheets','test_taken_answer_sheets.quiz_id','=','test_quizs.id')
        ->where(['test_taken_answer_sheets.test_taken_id' => $test_taken_id])
        ->groupBy(['test_subjects.name'])
        ->get();
    }

    public function answer_count_main(int $test_taken_id): Int
    {
        return AnswerSheet::where('test_taken_id', $test_taken_id)->where('attempt_status', TestAttemptStatus::ATTEMPTED->value)->count();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = TestTaken::with([
            'test',
            'user',
            'current_quiz'
        ])->where('is_enrolled', true)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginate_main(Int $total = 10): LengthAwarePaginator
    {
        $query = TestTaken::with([
            'test',
        ])->where('is_enrolled', true)->where('user_id', auth()->user()->id)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): TestTaken|null
    {
        return TestTaken::where('is_enrolled', true)->findOrFail($id);
    }

    public function admin_report(Int $id): TestTaken
    {
        return TestTaken::with([
            'test',
            'user',
        ])->where('id', $id)
        ->where('is_enrolled', true)
        ->where('test_status', TestStatus::COMPLETED->value)
        ->firstOrFail();
    }

    public function admin_report_quiz(Int $id): LengthAwarePaginator
    {
        $query = AnswerSheet::with([
            'quiz'
        ])->where('test_taken_id', $id)->latest();
        return QueryBuilder::for($query)
                ->paginate(1)
                ->appends(request()->query());
    }

    public function delete(TestTaken $event): bool|null
    {
        return $event->delete();
    }
}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('enrollment_type', 'LIKE', '%' . $value . '%')
            ->orWhere('test_status', 'LIKE', '%' . $value . '%')
            ->orWhere('razorpay_order_id', 'LIKE', '%' . $value . '%')
            ->orWhere('razorpay_payment_id', 'LIKE', '%' . $value . '%')
            ->orWhere('amount', 'LIKE', '%' . $value . '%');
        });
    }
}