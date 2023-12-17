<?php

namespace App\Modules\Test\Questionarie\Controllers;

use App\Enums\CorrectAnswer;
use App\Http\Controllers\Controller;
use App\Modules\Test\Test\Services\TestService;
use App\Modules\Test\Questionarie\Requests\QuestionarieRequest;
use App\Modules\Test\Questionarie\Services\QuestionarieService;
use App\Modules\Test\Quiz\Services\QuizService;

class QuestionarieCreateController extends Controller
{
    private $quizService;
    private $questionService;
    private $testService;

    public function __construct(QuestionarieService $questionService, QuizService $quizService, TestService $testService)
    {
        $this->middleware('permission:create tests', ['only' => ['get','post']]);
        $this->quizService = $quizService;
        $this->questionService = $questionService;
        $this->testService = $testService;
    }

    public function get($test_id, $quiz_id){
        $this->testService->getById($test_id);
        $this->quizService->getByTestIdAndId($test_id, $quiz_id);
        return view('admin.pages.test.questionarie.create', compact(['test_id', 'quiz_id']))->with([
            'correct_answer' => array_column(CorrectAnswer::cases(), 'value'),
        ]);
    }

    public function post(QuestionarieRequest $request, $test_id, $quiz_id){

        try {
            //code...
            $testQuestionarie = $this->questionService->create(
                [
                    ...$request->validated(),
                    'quiz_id' => $quiz_id
                ]
            );
            return response()->json(["message" => "Test Questionarie created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
