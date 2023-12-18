<?php

namespace App\Modules\JobOpening\JobEnquiry\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\JobOpening\JobEnquiry\Services\JobEnquiryService;
use Illuminate\Http\Request;

class JobEnquiryMainPaginateController extends Controller
{
    private $enquiryService;

    public function __construct(JobEnquiryService $enquiryService)
    {
        $this->middleware('permission:list blogs', ['only' => ['get']]);
        $this->enquiryService = $enquiryService;
    }

    public function get(Request $request){
        $data = $this->enquiryService->admin_main_paginate($request->total ?? 10);
        return view('admin.pages.job_opening.enquiry.main_paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
