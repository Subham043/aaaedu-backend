<?php

namespace App\Modules\Campaign\Enquiry\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Campaign\Enquiry\Exports\CampaignEnquiryExport;
use Maatwebsite\Excel\Facades\Excel;

class EnquiryMainExcelController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:list campaigns', ['only' => ['get']]);
    }

    public function get(){
        return Excel::download(new CampaignEnquiryExport, 'campaign_enquiry_form.xlsx');
    }

}
