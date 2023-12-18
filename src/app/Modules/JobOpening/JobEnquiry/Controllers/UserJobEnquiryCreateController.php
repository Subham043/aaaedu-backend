<?php

namespace App\Modules\JobOpening\JobEnquiry\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\RateLimitService;
use App\Modules\JobOpening\JobEnquiry\Requests\JobEnquiryRequest;
use App\Modules\JobOpening\JobEnquiry\Resources\UserJobEnquiryCollection;
use App\Modules\JobOpening\JobEnquiry\Services\JobEnquiryService;
use App\Modules\JobOpening\JobOpening\Services\JobOpeningService;

class UserJobEnquiryCreateController extends Controller
{
    private $enquiryService;
    private $jobService;

    public function __construct(JobEnquiryService $enquiryService, JobOpeningService $jobService)
    {
        $this->enquiryService = $enquiryService;
        $this->jobService = $jobService;
    }

    public function post(JobEnquiryRequest $request, $job_id){

        $this->jobService->getById($job_id);
        try {
            //code...
            $blogJobEnquiry = $this->enquiryService->create(
                [
                    ...$request->validated(),
                    'job_id' => $job_id
                ]
            );
            if($request->hasFile('cv')){
                $this->enquiryService->saveCv($blogJobEnquiry);
            }
            (new RateLimitService($request))->clearRateLimit();
            return response()->json([
                "message" => "Job Enquiry created successfully.",
                "job_enquiry" => UserJobEnquiryCollection::make($blogJobEnquiry)
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
