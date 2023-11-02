<?php

namespace App\Modules\Test\Test\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\Test\Requests\TestUpdateRequest;
use App\Modules\Test\Test\Services\TestService;

class TestUpdateController extends Controller
{
    private $testService;

    public function __construct(TestService $testService)
    {
        $this->middleware('permission:edit tests', ['only' => ['get','post']]);
        $this->testService = $testService;
    }

    public function get($id){
        $data = $this->testService->getById($id);
        return view('admin.pages.test.test.update', compact(['data']));
    }

    public function post(TestUpdateRequest $request, $id){
        $test = $this->testService->getById($id);
        try {
            //code...
            $this->testService->update(
                $request->except(['image']),
                $test
            );
            if($request->hasFile('image')){
                $this->testService->saveImage($test);
            }
            return response()->json(["message" => "Test updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
