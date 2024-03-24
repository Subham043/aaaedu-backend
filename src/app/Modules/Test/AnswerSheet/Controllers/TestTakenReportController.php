<?php

namespace App\Modules\Test\AnswerSheet\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\AnswerSheet\Services\AnswerSheetService;
use App\Modules\Test\Quiz\Services\QuizService;
use Illuminate\Http\Request;

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
        // $quiz = $this->testTakenService->admin_report_quiz($id);
        return view('admin.pages.test.taken.report', compact(['report', 'total_question_count', 'total_score', 'alloted_score', 'subject_wise_score', 'total_answer_count']));
    }

}