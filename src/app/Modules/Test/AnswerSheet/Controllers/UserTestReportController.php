<?php

namespace App\Modules\Test\AnswerSheet\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\AnswerSheet\Services\AnswerSheetService;
use App\Modules\Test\Quiz\Services\QuizService;
use App\Modules\Test\Test\Resources\UserTestCollection;
use App\Modules\Test\Test\Services\TestService;

class UserTestReportController extends Controller
{
    private $testService;
    private $answerSheetService;
    private $quizService;

    public function __construct(TestService $testService, AnswerSheetService $answerSheetService, QuizService $quizService)
    {
        $this->testService = $testService;
        $this->answerSheetService = $answerSheetService;
        $this->quizService = $quizService;
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
}
