<?php

namespace App\Modules\Test\Subject\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\Subject\Requests\SubjectRequest;
use App\Modules\Test\Subject\Services\SubjectService;

class SubjectUpdateController extends Controller
{
    private $subjectService;

    public function __construct(SubjectService $subjectService)
    {
        $this->middleware('permission:edit subjects', ['only' => ['get','post']]);
        $this->subjectService = $subjectService;
    }

    public function get($subject_id, $id){
        $data = $this->subjectService->getByTestIdAndId($subject_id, $id);
        return view('admin.pages.test.subject.update', compact(['data', 'subject_id']));
    }

    public function post(SubjectRequest $request, $subject_id, $id){
        $subject = $this->subjectService->getByTestIdAndId($subject_id, $id);
        try {
            //code...
            $this->subjectService->update(
                $request->validated(),
                $subject
            );
            return response()->json(["message" => "Test Subject updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
