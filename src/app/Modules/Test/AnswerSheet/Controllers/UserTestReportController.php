<?php

namespace App\Modules\Test\AnswerSheet\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\AnswerSheet\Resources\UserTestQuestionSetCollection;
use App\Modules\Test\AnswerSheet\Services\AnswerSheetService;
use App\Modules\Test\Quiz\Services\QuizService;
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
        return response()->json([
        ], 200);
    }
}
