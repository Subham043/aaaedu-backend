<?php

namespace App\Modules\Test\Quiz\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\Quiz\Requests\QuizRequest;
use App\Modules\Test\Quiz\Services\QuizService;

class QuizUpdateController extends Controller
{
    private $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->middleware('permission:edit quizs', ['only' => ['get','post']]);
        $this->quizService = $quizService;
    }

    public function get($quiz_id, $id){
        $data = $this->quizService->getByTestIdAndId($quiz_id, $id);
        return view('admin.pages.test.quiz.update', compact(['data', 'quiz_id']));
    }

    public function post(QuizRequest $request, $quiz_id, $id){
        $quiz = $this->quizService->getByTestIdAndId($quiz_id, $id);
        try {
            //code...
            $this->quizService->update(
                $request->validated(),
                $quiz
            );
            return response()->json(["message" => "Test Quiz updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
