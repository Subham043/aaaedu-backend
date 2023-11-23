<?php

namespace App\Modules\Test\Quiz\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\Quiz\Services\QuizService;
use Illuminate\Http\Request;

class QuizPaginateController extends Controller
{
    private $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->middleware('permission:list tests', ['only' => ['get']]);
        $this->quizService = $quizService;
    }

    public function get(Request $request, $test_id){
        $data = $this->quizService->paginate($request->total ?? 10, $test_id);
        return view('admin.pages.test.quiz.paginate', compact(['data', 'test_id']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
