<?php

namespace App\Modules\Test\Test\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\Test\Resources\UserTestCollection;
use App\Modules\Test\Test\Services\TestService;
use Illuminate\Http\Request;

class UserTestPaginateController extends Controller
{
    private $testService;

    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    public function get(Request $request){
        $data = $this->testService->paginateMain($request->total ?? 10);
        return UserTestCollection::collection($data);
    }

}
