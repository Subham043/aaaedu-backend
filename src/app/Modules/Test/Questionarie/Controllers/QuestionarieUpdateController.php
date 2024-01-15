<?php

namespace App\Modules\Test\Questionarie\Controllers;

use App\Enums\CorrectAnswer;
use App\Http\Controllers\Controller;
use App\Modules\Test\Questionarie\Requests\QuestionarieRequest;
use App\Modules\Test\Questionarie\Services\QuestionarieService;
use App\Modules\Test\Quiz\Services\QuizService;
use App\Modules\Test\Subject\Services\SubjectService;

class QuestionarieUpdateController extends Controller
{
    private $quizService;
    private $questionService;

    public function __construct(QuestionarieService $questionService, QuizService $quizService)
    {
        $this->middleware('permission:edit tests', ['only' => ['get','post']]);
        $this->quizService = $quizService;
        $this->questionService = $questionService;
    }

    public function get($test_id, $quiz_id, $id){
        $data = $this->questionService->getByQuizIdAndId($quiz_id, $id);
        return view('admin.pages.test.quiz.update', compact(['data', 'test_id', 'quiz_id']))->with([
            'correct_answer' => array_column(CorrectAnswer::cases(), 'value'),
        ]);
    }

    public function post(QuestionarieRequest $request, $test_id, $quiz_id, $id){
        $quiz = $this->questionService->getByQuizIdAndId($quiz_id, $id);
        try {
            //code...
            $this->questionService->update(
                $request->validated(),
                $quiz
            );
            return response()->json(["message" => "Test Questionarie updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
