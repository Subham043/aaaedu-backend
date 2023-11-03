<?php

namespace App\Modules\Test\Quiz\Controllers;

use App\Enums\CorrectAnswer;
use App\Enums\Difficulty;
use App\Http\Controllers\Controller;
use App\Modules\Test\Quiz\Requests\QuizRequest;
use App\Modules\Test\Quiz\Services\QuizService;
use App\Modules\Test\Subject\Services\SubjectService;

class QuizUpdateController extends Controller
{
    private $quizService;
    private $subjectService;

    public function __construct(QuizService $quizService, SubjectService $subjectService)
    {
        $this->middleware('permission:edit tests', ['only' => ['get','post']]);
        $this->quizService = $quizService;
        $this->subjectService = $subjectService;
    }

    public function get($test_id, $id){
        $data = $this->quizService->getByTestIdAndId($test_id, $id);
        return view('admin.pages.test.quiz.update', compact(['data', 'test_id']))->with([
            'correct_answer' => array_column(CorrectAnswer::cases(), 'value'),
            'difficulty' => array_column(Difficulty::cases(), 'value'),
            'subjects' => $this->subjectService->all($test_id),
        ]);
    }

    public function post(QuizRequest $request, $test_id, $id){
        $quiz = $this->quizService->getByTestIdAndId($test_id, $id);
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
