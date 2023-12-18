<?php

namespace App\Modules\JobOpening\JobOpening\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\JobOpening\JobOpening\Requests\JobOpeningCreateRequest;
use App\Modules\JobOpening\JobOpening\Services\JobOpeningService;

class JobOpeningUpdateController extends Controller
{
    private $jobOpeningService;

    public function __construct(JobOpeningService $jobOpeningService)
    {
        $this->middleware('permission:create blogs', ['only' => ['get','post']]);
        $this->jobOpeningService = $jobOpeningService;
    }

    public function get($id){
        $data = $this->jobOpeningService->getById($id);
        return view('admin.pages.job_opening.update', compact(['data']));
    }

    public function post(JobOpeningCreateRequest $request, $id){
        $job = $this->jobOpeningService->getById($id);
        try {
            //code...
            $this->jobOpeningService->update(
                $request->validated(), $job
            );
            return response()->json(["message" => "Job Opening updated successfully."], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
