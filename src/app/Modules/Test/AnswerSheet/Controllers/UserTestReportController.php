<?php

namespace App\Modules\Test\AnswerSheet\Controllers;

use App\Enums\ExamMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Modules\Test\AnswerSheet\Services\AnswerSheetService;
use App\Modules\Test\Quiz\Services\QuizService;
use App\Modules\Test\Test\Resources\UserTestCollection;
use App\Modules\Test\Test\Services\TestService;
use App\Modules\Test\Test\Services\AdmissionTestService;
use App\Modules\AdmissionTest\Services\AdmissionTestService as AdmissionRegistrationService;

class UserTestReportController extends Controller
{
    private $testService;
    private $answerSheetService;
    private $quizService;
    private $admissionTestService;
    private $registrationService;

    public function __construct(TestService $testService, AnswerSheetService $answerSheetService, QuizService $quizService, AdmissionTestService $admissionTestService, AdmissionRegistrationService $registrationService)
    {
        $this->testService = $testService;
        $this->answerSheetService = $answerSheetService;
        $this->quizService = $quizService;
        $this->admissionTestService = $admissionTestService;
        $this->registrationService = $registrationService;
    }

    public function get($slug){
        $test = $this->testService->getBySlug($slug);
        $test_report = $this->answerSheetService->test_report($test);
        $total_question_count = $this->quizService->count_main_grouped_by_subjects($test->id);
        $total_score = $this->quizService->total_score_main($test->id);
        $alloted_score = $this->answerSheetService->total_alloted_score($test_report->id);
        $subject_wise_score = $this->answerSheetService->total_alloted_score_grouped_by_subjects($test_report->id);
        $total_answer_count = $this->answerSheetService->answer_count_main($test_report->id);

        return response()->json([
            'test' => UserTestCollection::make($test),
            'total_score' => $total_score,
            'alloted_score' => $alloted_score,
            'subject_wise_score' => $subject_wise_score,
            'total_question_count' => $total_question_count,
            'total_answer_count' => $total_answer_count,
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
            $test_report = $this->answerSheetService->test_report($test);
            $total_question_count = $this->quizService->count_main_grouped_by_subjects($test->id);
            $total_score = $this->quizService->total_score_main($test->id);
            $alloted_score = $this->answerSheetService->total_alloted_score($test_report->id);
            $subject_wise_score = $this->answerSheetService->total_alloted_score_grouped_by_subjects($test_report->id);
            $total_answer_count = $this->answerSheetService->answer_count_main($test_report->id);

            return response()->json([
                'test' => UserTestCollection::make($test),
                'total_score' => $total_score,
                'alloted_score' => $alloted_score,
                'subject_wise_score' => $subject_wise_score,
                'total_question_count' => $total_question_count,
                'total_answer_count' => $total_answer_count,
            ], 200);
        }
        return response()->json([
            'message' => "Data not found",
        ], 404);
    }
}
