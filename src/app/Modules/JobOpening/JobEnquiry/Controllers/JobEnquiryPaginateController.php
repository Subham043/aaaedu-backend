<?php

namespace App\Modules\JobOpening\JobEnquiry\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\JobOpening\JobEnquiry\Services\JobEnquiryService;
use Illuminate\Http\Request;

class BlogCommentPaginateController extends Controller
{
    private $enquiryService;

    public function __construct(JobEnquiryService $enquiryService)
    {
        $this->middleware('permission:list blogs', ['only' => ['get']]);
        $this->enquiryService = $enquiryService;
    }

    public function get(Request $request, $job_id){
        $data = $this->enquiryService->paginate($request->total ?? 10, $job_id);
        return view('admin.pages.job_opening.enquiry.paginate', compact(['data', 'job_id']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
