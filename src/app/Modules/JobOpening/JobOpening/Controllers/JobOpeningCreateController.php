<?php

namespace App\Modules\JobOpening\JobOpening\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\JobOpening\JobOpening\Requests\JobOpeningCreateRequest;
use App\Modules\JobOpening\JobOpening\Services\JobOpeningService;

class JobOpeningCreateController extends Controller
{
    private $jobOpeningService;

    public function __construct(JobOpeningService $jobOpeningService)
    {
        $this->middleware('permission:create blogs', ['only' => ['get','post']]);
        $this->jobOpeningService = $jobOpeningService;
    }

    public function get(){
        return view('admin.pages.job_opening.create');
    }

    public function post(JobOpeningCreateRequest $request){

        try {
            //code...
            $blog = $this->jobOpeningService->create(
                $request->validated()
            );
            return response()->json(["message" => "Job Opening created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
