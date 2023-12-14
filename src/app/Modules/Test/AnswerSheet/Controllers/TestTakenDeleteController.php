<?php

namespace App\Modules\Test\AnswerSheet\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\AnswerSheet\Services\AnswerSheetService;

class TestTakenDeleteController extends Controller
{
    private $testTakenService;

    public function __construct(AnswerSheetService $testTakenService)
    {
        $this->middleware('permission:delete tests', ['only' => ['get']]);
        $this->testTakenService = $testTakenService;
    }

    public function get($id){
        $quiz = $this->testTakenService->getById($id);

        try {
            //code...
            $this->testTakenService->delete(
                $quiz
            );
            return redirect()->back()->with('success_status', 'Test Taken deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
