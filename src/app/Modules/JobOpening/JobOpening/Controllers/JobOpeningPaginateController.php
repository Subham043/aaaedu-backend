<?php

namespace App\Modules\JobOpening\JobOpening\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\JobOpening\JobOpening\Services\JobOpeningService;
use Illuminate\Http\Request;

class JobOpeningPaginateController extends Controller
{
    private $jobService;

    public function __construct(JobOpeningService $jobService)
    {
        $this->middleware('permission:list blogs', ['only' => ['get']]);
        $this->jobService = $jobService;
    }

    public function get(Request $request){
        $data = $this->jobService->paginate($request->total ?? 10);
        return view('admin.pages.job_opening.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
