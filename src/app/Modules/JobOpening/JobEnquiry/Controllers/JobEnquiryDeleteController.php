<?php

namespace App\Modules\JobOpening\JobEnquiry\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\JobOpening\JobEnquiry\Services\JobEnquiryService;

class JobEnquiryDeleteController extends Controller
{
    private $enquiryService;

    public function __construct(JobEnquiryService $enquiryService)
    {
        $this->middleware('permission:delete blogs', ['only' => ['get']]);
        $this->enquiryService = $enquiryService;
    }

    public function get($blog_id, $id){
        $enquiry = $this->enquiryService->getByBlogIdAndId($blog_id, $id);

        try {
            //code...
            $this->enquiryService->delete(
                $enquiry
            );
            return redirect()->back()->with('success_status', 'Job Enquiry deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
