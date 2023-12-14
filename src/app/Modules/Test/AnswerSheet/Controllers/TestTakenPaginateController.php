<?php

namespace App\Modules\Test\AnswerSheet\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\AnswerSheet\Services\AnswerSheetService;
use Illuminate\Http\Request;

class TestTakenPaginateController extends Controller
{
    private $testTakenService;

    public function __construct(AnswerSheetService $testTakenService)
    {
        $this->middleware('permission:list tests', ['only' => ['get']]);
        $this->testTakenService = $testTakenService;
    }

    public function get(Request $request){
        $data = $this->testTakenService->paginate($request->total ?? 10);
        return view('admin.pages.test.taken.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
