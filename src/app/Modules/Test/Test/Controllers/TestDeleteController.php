<?php

namespace App\Modules\Test\Test\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\Test\Services\TestService;

class TestDeleteController extends Controller
{
    private $testService;

    public function __construct(TestService $testService)
    {
        $this->middleware('permission:delete tests', ['only' => ['get']]);
        $this->testService = $testService;
    }

    public function get($id){
        $test = $this->testService->getById($id);

        try {
            //code...
            $this->testService->delete(
                $test
            );
            return redirect()->back()->with('success_status', 'Test deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
