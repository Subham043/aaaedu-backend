<?php

namespace App\Modules\Test\Test\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\Test\Requests\TestCreateRequest;
use App\Modules\Test\Test\Services\TestService;

class TestCreateController extends Controller
{
    private $testService;

    public function __construct(TestService $testService)
    {
        $this->middleware('permission:create tests', ['only' => ['get','post']]);
        $this->testService = $testService;
    }

    public function get(){
        return view('admin.pages.test.test.create');
    }

    public function post(TestCreateRequest $request){

        try {
            //code...
            $test = $this->testService->create(
                $request->except(['image'])
            );
            if($request->hasFile('image')){
                $this->testService->saveImage($test);
            }
            return response()->json(["message" => "Test created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
