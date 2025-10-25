<?php

namespace App\Modules\Test\AnswerSheet\Controllers;

use App\Enums\ExamMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Modules\Test\AnswerSheet\Services\AnswerSheetService;
use App\Modules\Test\Quiz\Services\QuizService;
use App\Modules\Test\Test\Services\TestService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Modules\Test\Test\Services\AdmissionTestService;
use App\Modules\AdmissionTest\Services\AdmissionTestService as AdmissionRegistrationService;

class UserTestReportPdfController extends Controller
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
        $percentage = (($alloted_score / $total_score) * 100);
        $grade = 'F';
        if ($percentage >= 90 && $percentage <= 100) {
            $grade = 'A';
        } else if ($percentage >= 75 && $percentage <= 89) {
            $grade = 'B';
        } else if ($percentage >= 60 && $percentage <= 74) {
            $grade = 'C';
        } else if ($percentage >= 45 && $percentage <= 59) {
            $grade = 'D';
        } else if ($percentage >= 35 && $percentage <= 44) {
            $grade = 'E';
        } else if ($percentage >= 0 && $percentage <= 34) {
            $grade = 'F';
        }

        $data = [
            'report' => $test_report,
            'total_question_count' => $total_question_count,
            'total_score' => $total_score,
            'alloted_score' => $alloted_score,
            'subject_wise_score' => $subject_wise_score,
            'total_answer_count' => $total_answer_count,
            'percentage' => $percentage,
            'grade' => $grade,
        ];
        $fileName = str()->uuid();
        $pdf = Pdf::loadView('report.report', $data)->setPaper('a4', 'landscape');
        $pdf->save(storage_path('app/public/reports/').$fileName.'.pdf');
        return response()->json(['file_key' => $fileName], 200);
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
            $percentage = (($alloted_score / $total_score) * 100);
            $grade = 'F';
            if ($percentage >= 95 && $percentage <= 100) {
                $grade = 'A';
            } else if ($percentage >= 90 && $percentage <= 94) {
                $grade = 'B';
            } else if ($percentage >= 85 && $percentage <= 89) {
                $grade = 'C';
            } else if ($percentage >= 75 && $percentage <= 84) {
                $grade = 'D';
            } else if ($percentage >= 65 && $percentage <= 74) {
                $grade = 'E';
            } else if ($percentage >= 0 && $percentage <= 64) {
                $grade = 'F';
            }

            $data = [
                'report' => $test_report,
                'total_question_count' => $total_question_count,
                'total_score' => $total_score,
                'alloted_score' => $alloted_score,
                'subject_wise_score' => $subject_wise_score,
                'total_answer_count' => $total_answer_count,
                'percentage' => $percentage,
                'grade' => $grade,
            ];
            $fileName = str()->uuid();
            $pdf = Pdf::loadView('report.report', $data)->setPaper('a4', 'landscape');
            $pdf->save(storage_path('app/public/reports/').$fileName.'.pdf');
            return response()->json(['file_key' => $fileName], 200);
        }
        return response()->json([
            'message' => "Data not found",
        ], 404);
    }

    public function download($fileName){
        try {
            //code...
            return response()->download(Storage::path('/reports/'.$fileName.'.pdf'))->deleteFileAfterSend(true);
        } catch (\Throwable $th) {
            //throw $th;
            abort(404);
        }
    }
}
