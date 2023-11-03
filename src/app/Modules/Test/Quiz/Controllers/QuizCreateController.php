<?php

namespace App\Modules\Test\Quiz\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\Test\Services\TestService;
use App\Modules\Test\Quiz\Requests\QuizRequest;
use App\Modules\Test\Quiz\Services\QuizService;

class QuizCreateController extends Controller
{
    private $quizService;
    private $testService;

    public function __construct(QuizService $quizService, TestService $testService)
    {
        $this->middleware('permission:create tests', ['only' => ['get','post']]);
        $this->quizService = $quizService;
        $this->testService = $testService;
    }

    public function get($test_id){
        $this->testService->getById($test_id);
        return view('admin.pages.test.quiz.create', compact(['test_id']));
    }

    public function post(QuizRequest $request, $test_id){

        try {
            //code...
            $testQuiz = $this->quizService->create(
                [
                    ...$request->validated(),
                    'test_id' => $test_id
                ]
            );
            return response()->json(["message" => "Test Quiz created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
