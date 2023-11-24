<?php

namespace App\Modules\Test\AnswerSheet\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\AnswerSheet\Requests\EliminatedRequest;
use App\Modules\Test\AnswerSheet\Services\AnswerSheetService;
use App\Modules\Test\Test\Services\TestService;

class UserTestEliminatedController extends Controller
{
    private $testService;
    private $answerSheetService;

    public function __construct(TestService $testService, AnswerSheetService $answerSheetService)
    {
        $this->testService = $testService;
        $this->answerSheetService = $answerSheetService;
    }

    public function post(EliminatedRequest $request, $slug){
        $test = $this->testService->getBySlug($slug);
        $this->answerSheetService->eliminated($request, $test);
        return response()->json([
            'message' => 'Eliminated successfully'
        ], 200);
    }
}
