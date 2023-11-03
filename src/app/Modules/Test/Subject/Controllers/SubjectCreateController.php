<?php

namespace App\Modules\Test\Subject\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\Test\Services\TestService;
use App\Modules\Test\Subject\Requests\SubjectRequest;
use App\Modules\Test\Subject\Services\SubjectService;

class SubjectCreateController extends Controller
{
    private $subjectService;
    private $testService;

    public function __construct(SubjectService $subjectService, TestService $testService)
    {
        $this->middleware('permission:create tests', ['only' => ['get','post']]);
        $this->subjectService = $subjectService;
        $this->testService = $testService;
    }

    public function get($test_id){
        $this->testService->getById($test_id);
        return view('admin.pages.test.subject.create', compact(['test_id']));
    }

    public function post(SubjectRequest $request, $test_id){

        try {
            //code...
            $testSubject = $this->subjectService->create(
                [
                    ...$request->validated(),
                    'test_id' => $test_id
                ]
            );
            return response()->json(["message" => "Test Subject created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
