<?php

namespace App\Modules\Test\AnswerSheet\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\AnswerSheet\Resources\UserTestQuestionSetCollection;
use App\Modules\Test\AnswerSheet\Services\AnswerSheetService;
use App\Modules\Test\Quiz\Services\QuizService;
use App\Modules\Test\Test\Resources\UserTestCollection;
use App\Modules\Test\Test\Services\TestService;

class UserTestQuestionSetController extends Controller
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
}
