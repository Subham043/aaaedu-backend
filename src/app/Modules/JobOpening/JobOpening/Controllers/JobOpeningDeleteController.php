<?php

namespace App\Modules\JobOpening\JobOpening\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\JobOpening\JobOpening\Services\JobOpeningService;

class JobOpeningDeleteController extends Controller
{
    private $jobService;

    public function __construct(JobOpeningService $jobService)
    {
        $this->middleware('permission:delete blogs', ['only' => ['get']]);
        $this->jobService = $jobService;
    }

    public function get($id){
        $job = $this->jobService->getById($id);

        try {
            //code...
            $this->jobService->delete(
                $job
            );
            return redirect()->back()->with('success_status', 'Job Opening deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
