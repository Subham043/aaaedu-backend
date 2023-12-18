<?php

namespace App\Modules\JobOpening\JobOpening\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\JobOpening\JobOpening\Resources\UserJobOpeningCollection;
use App\Modules\JobOpening\JobOpening\Services\JobOpeningService;

class UserJobOpeningAllController extends Controller
{
    private $jobService;

    public function __construct(JobOpeningService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function get(){
        $data = $this->jobService->all_main();
        return response()->json([
            'message' => "Job Opening recieved successfully.",
            'blogs' => UserJobOpeningCollection::collection($data),
        ], 200);
    }

}
