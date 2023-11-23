<?php

namespace App\Modules\Test\AnswerSheet\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\Quiz\Resources\UserQuizTakenCollection;
use App\Modules\Test\Quiz\Services\QuizService;
use App\Modules\Test\Test\Resources\UserTestCollection;
use App\Modules\Test\Test\Services\TestService;

class UserTestApplyController extends Controller
{
    private $testService;
    private $quizService;

    public function __construct(TestService $testService, QuizService $quizService)
    {
        $this->testService = $testService;
        $this->quizService = $quizService;
    }

    public function get($slug){
        $test = $this->testService->getBySlug($slug);
        $quiz = $this->quizService->all($test->id);
        return response()->json([
            'message' => "Test applied successfully.",
            'test' => UserTestCollection::make($test),
            'quiz' => UserQuizTakenCollection::collection($quiz),
        ], 200);
    }
}
