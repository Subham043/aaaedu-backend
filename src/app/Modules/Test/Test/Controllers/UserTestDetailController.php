<?php

namespace App\Modules\Test\Test\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\Test\Resources\UserTestCollection;
use App\Modules\Test\Test\Services\TestService;

class UserTestDetailController extends Controller
{
    private $testService;

    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    public function get($slug){
        $test = $this->testService->getBySlug($slug);
        return response()->json([
            'message' => "Test recieved successfully.",
            'test' => UserTestCollection::make($test),
        ], 200);
    }
}
