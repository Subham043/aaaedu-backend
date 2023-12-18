<?php

namespace App\Modules\JobOpening\JobOpening\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\JobOpening\JobOpening\Resources\UserJobOpeningCollection;
use App\Modules\JobOpening\JobOpening\Services\JobOpeningService;
use Illuminate\Http\Request;

class UserJobOpeningPaginateController extends Controller
{
    private $jobService;

    public function __construct(JobOpeningService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function get(Request $request){
        $data = $this->jobService->paginateMain($request->total ?? 10);
        return UserJobOpeningCollection::collection($data);
    }

}
