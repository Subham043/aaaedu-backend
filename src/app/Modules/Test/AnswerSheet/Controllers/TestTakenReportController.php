<?php

namespace App\Modules\Test\AnswerSheet\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\AnswerSheet\Services\AnswerSheetService;
use App\Modules\Test\Quiz\Services\QuizService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class TestTakenReportController extends Controller
{
    private $testTakenService;
    private $quizService;

    public function __construct(AnswerSheetService $testTakenService, QuizService $quizService)
    {
        $this->middleware('permission:list tests', ['only' => ['get']]);
        $this->testTakenService = $testTakenService;
        $this->quizService = $quizService;
    }

    public function get(Request $request, $id){
        $report = $this->testTakenService->admin_report($id);
        $total_question_count = $this->quizService->count_main_grouped_by_subjects($report->test->id);
        $total_score = $this->quizService->total_score_main($report->test->id);
        $alloted_score = $this->testTakenService->total_alloted_score($report->id);
        $subject_wise_score = $this->testTakenService->total_alloted_score_grouped_by_subjects($report->id);
        $total_answer_count = $this->testTakenService->answer_count_main($report->id);
        $percentage = round((($alloted_score / $total_score) * 100), 2);
        $grade = 'F';
        if($report->test->is_admission){
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
        }else{
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
        }

        // $quiz = $this->testTakenService->admin_report_quiz($id);
        return view('admin.pages.test.taken.report', compact(['report', 'total_question_count', 'total_score', 'alloted_score', 'subject_wise_score', 'total_answer_count', 'percentage', 'grade']));
    }

    public function download($id){
        $report = $this->testTakenService->admin_report($id);
        $total_question_count = $this->quizService->count_main_grouped_by_subjects($report->test->id);
        $total_score = $this->quizService->total_score_main($report->test->id);
        $alloted_score = $this->testTakenService->total_alloted_score($report->id);
        $subject_wise_score = $this->testTakenService->total_alloted_score_grouped_by_subjects($report->id);
        $total_answer_count = $this->testTakenService->answer_count_main($report->id);
        $percentage = round((($alloted_score / $total_score) * 100), 2);
        $grade = 'F';
        if($report->test->is_admission){
            if (floor($percentage) >= 95 && floor($percentage) <= 100) {
                $grade = 'A';
            } else if (floor($percentage) >= 90 && floor($percentage) <= 94) {
                $grade = 'B';
            } else if (floor($percentage) >= 85 && floor($percentage) <= 89) {
                $grade = 'C';
            } else if (floor($percentage) >= 75 && floor($percentage) <= 84) {
                $grade = 'D';
            } else if (floor($percentage) >= 65 && floor($percentage) <= 74) {
                $grade = 'E';
            } else if (floor($percentage) >= 0 && floor($percentage) <= 64) {
                $grade = 'F';
            }
        }else{
            if (floor($percentage) >= 90 && floor($percentage) <= 100) {
                $grade = 'A';
            } else if (floor($percentage) >= 75 && floor($percentage) <= 89) {
                $grade = 'B';
            } else if (floor($percentage) >= 60 && floor($percentage) <= 74) {
                $grade = 'C';
            } else if (floor($percentage) >= 45 && floor($percentage) <= 59) {
                $grade = 'D';
            } else if (floor($percentage) >= 35 && floor($percentage) <= 44) {
                $grade = 'E';
            } else if (floor($percentage) >= 0 && floor($percentage) <= 34) {
                $grade = 'F';
            }
        }

        $data = [
            'report' => $report,
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

        return response()->download(Storage::path('/reports/'.$fileName.'.pdf'))->deleteFileAfterSend(true);
    }

}
