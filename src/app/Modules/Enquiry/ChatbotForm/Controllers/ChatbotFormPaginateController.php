<?php

namespace App\Modules\Enquiry\ChatbotForm\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Enquiry\ChatbotForm\Services\ChatbotFormService;
use Illuminate\Http\Request;

class ChatbotFormPaginateController extends Controller
{
    private $chatbotFormService;

    public function __construct(ChatbotFormService $chatbotFormService)
    {
        $this->middleware('permission:list enquiries', ['only' => ['get']]);
        $this->chatbotFormService = $chatbotFormService;
    }

    public function get(Request $request){
        $data = $this->chatbotFormService->paginate($request->total ?? 10);
        return view('admin.pages.enquiry.chatbot_form', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
