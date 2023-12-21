<?php

namespace App\Modules\Enquiry\ChatbotForm\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Enquiry\ChatbotForm\Services\ChatbotFormService;

class ChatbotFormDeleteController extends Controller
{
    private $chatbotFormService;

    public function __construct(ChatbotFormService $chatbotFormService)
    {
        $this->middleware('permission:delete enquiries', ['only' => ['get']]);
        $this->chatbotFormService = $chatbotFormService;
    }

    public function get($id){
        $chatbotRequest = $this->chatbotFormService->getById($id);

        try {
            //code...
            $this->chatbotFormService->delete(
                $chatbotRequest
            );
            return redirect()->back()->with('success_status', 'Chatbot request deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
