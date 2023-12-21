<?php

namespace App\Modules\Enquiry\ChatbotForm\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Enquiry\ChatbotForm\Exports\ChatbotFormExport;
use Maatwebsite\Excel\Facades\Excel;

class ChatbotFormExcelController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:list enquiries', ['only' => ['get']]);
    }

    public function get(){
        return Excel::download(new ChatbotFormExport, 'chatbot_form.xlsx');
    }

}
