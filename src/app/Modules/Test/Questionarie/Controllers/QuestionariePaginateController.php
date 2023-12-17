<?php

namespace App\Modules\Test\Questionarie\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\Questionarie\Services\QuestionarieService;
use Illuminate\Http\Request;

class QuestionariePaginateController extends Controller
{
    private $questionService;

    public function __construct(QuestionarieService $questionService)
    {
        $this->middleware('permission:list tests', ['only' => ['get']]);
        $this->questionService = $questionService;
    }

    public function get(Request $request, $test_id, $quiz_id){
        $data = $this->questionService->paginate($request->total ?? 10, $quiz_id);
        return view('admin.pages.test.questionarie.paginate', compact(['data', 'test_id', 'quiz_id']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
