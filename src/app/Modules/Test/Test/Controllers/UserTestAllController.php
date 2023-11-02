<?php

namespace App\Modules\Test\Test\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\Test\Resources\UserTestCollection;
use App\Modules\Test\Test\Services\TestService;

class UserTestAllController extends Controller
{
    private $testService;

    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    public function get(){
        $data = $this->testService->all_main();
        return response()->json([
            'message' => "Tests recieved successfully.",
            'tests' => UserTestCollection::collection($data),
        ], 200);
    }

}
