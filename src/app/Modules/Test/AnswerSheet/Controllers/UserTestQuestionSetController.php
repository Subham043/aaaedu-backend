<?php

namespace App\Modules\Test\AnswerSheet\Controllers;

use App\Enums\ExamMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Modules\Test\AnswerSheet\Resources\UserTestQuestionSetCollection;
use App\Modules\Test\AnswerSheet\Services\AnswerSheetService;
use App\Modules\Test\Quiz\Services\QuizService;
use App\Modules\Test\Test\Resources\UserTestCollection;
use App\Modules\Test\Test\Services\TestService;
use App\Modules\Test\Test\Services\AdmissionTestService;
use App\Modules\AdmissionTest\Services\AdmissionTestService as AdmissionRegistrationService;

class UserTestQuestionSetController extends Controller
{
    private $testService;
    private $admissionTestService;
    private $answerSheetService;
    private $quizService;
    private $registrationService;

    public function __construct(TestService $testService, AdmissionTestService $admissionTestService, AnswerSheetService $answerSheetService, QuizService $quizService, AdmissionRegistrationService $registrationService)
    {
        $this->testService = $testService;
        $this->admissionTestService = $admissionTestService;
        $this->answerSheetService = $answerSheetService;
        $this->quizService = $quizService;
        $this->registrationService = $registrationService;
    }

    public function get($slug){
        $test = $this->testService->getBySlug($slug);
        $test_question = $this->answerSheetService->test_question($test);
        $total_question_count = $this->quizService->count_main_grouped_by_subjects($test->id);
        $current_question_count = $this->answerSheetService->current_question_count($test_question->id);
        return response()->json([
            'test' => UserTestCollection::make($test),
            'question_set' => UserTestQuestionSetCollection::make($test_question),
            'total_question_count' => $total_question_count,
            'current_question_count' => $current_question_count,
        ], 200);
    }

    public function getv2($slug){
        $admissionTest = $this->registrationService->getByUserId(auth()->user()->id);
        $path = $admissionTest->mode == ExamMode::ONLINE ? 'vii-aptitude-test' : null;
        switch ($admissionTest->class->value ?? '7th') {
            case '7th':
                # code...
                $path = 'vii-aptitude-test';
                break;
            case '8th':
                # code...
                $path = 'viii-aptitude-test';
                break;
            case '9th':
                # code...
                $path = 'ix-aptitude-test';
                break;
            case '10th':
                # code...
                $path = 'x-aptitude-test';
                break;

            default:
                # code...
                $path = 'vii-aptitude-test';
                break;
        }
        if($admissionTest && $admissionTest->payment_status == PaymentStatus::PAID && $admissionTest->mode == ExamMode::ONLINE && $path==$slug){
            $test = $this->admissionTestService->getBySlug($slug);
            $test_question = $this->answerSheetService->test_question($test);
            $total_question_count = $this->quizService->count_main_grouped_by_subjects($test->id);
            $current_question_count = $this->answerSheetService->current_question_count($test_question->id);
            return response()->json([
                'test' => UserTestCollection::make($test),
                'question_set' => UserTestQuestionSetCollection::make($test_question),
                'total_question_count' => $total_question_count,
                'current_question_count' => $current_question_count,
            ], 200);
        }
        return response()->json([
            'message' => "Data not found",
        ], 404);
    }
}
