<?php

namespace App\Modules\Test\Test\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\Test\Services\TestService;
use Illuminate\Http\Request;

class TestPaginateController extends Controller
{
    private $testService;

    public function __construct(TestService $testService)
    {
        $this->middleware('permission:list tests', ['only' => ['get']]);
        $this->testService = $testService;
    }

    public function get(Request $request){
        $data = $this->testService->paginate($request->total ?? 10);
        return view('admin.pages.test.test.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
