<?php

namespace App\Modules\Test\Quiz\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\Quiz\Services\QuizService;

class QuizDeleteController extends Controller
{
    private $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->middleware('permission:delete tests', ['only' => ['get']]);
        $this->quizService = $quizService;
    }

    public function get($test_id, $id){
        $quiz = $this->quizService->getByTestIdAndId($test_id, $id);

        try {
            //code...
            $this->quizService->delete(
                $quiz
            );
            return redirect()->back()->with('success_status', 'Test Quiz deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
