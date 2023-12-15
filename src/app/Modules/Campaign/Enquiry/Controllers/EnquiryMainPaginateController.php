<?php

namespace App\Modules\Campaign\Enquiry\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Campaign\Enquiry\Services\EnquiryService;
use Illuminate\Http\Request;

class EnquiryMainPaginateController extends Controller
{
    private $enquiryService;

    public function __construct(EnquiryService $enquiryService)
    {
        $this->middleware('permission:list campaigns', ['only' => ['get']]);
        $this->enquiryService = $enquiryService;
    }

    public function get(Request $request){
        $data = $this->enquiryService->admin_main_paginate($request->total ?? 10);
        return view('admin.pages.campaign.enquiry.main_paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
