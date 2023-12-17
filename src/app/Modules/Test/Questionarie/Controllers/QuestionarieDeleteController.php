<?php

namespace App\Modules\Test\Questionarie\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\Questionarie\Services\QuestionarieService;

class QuestionarieDeleteController extends Controller
{
    private $questionService;

    public function __construct(QuestionarieService $questionService)
    {
        $this->middleware('permission:delete tests', ['only' => ['get']]);
        $this->questionService = $questionService;
    }

    public function get($test_id, $quiz_id, $id){
        $quiz = $this->questionService->getByQuizIdAndId($quiz_id, $id);

        try {
            //code...
            $this->questionService->delete(
                $quiz
            );
            return redirect()->back()->with('success_status', 'Test Questionarie deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
