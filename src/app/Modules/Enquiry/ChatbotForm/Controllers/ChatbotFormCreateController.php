<?php

namespace App\Modules\Enquiry\ChatbotForm\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\CrmLeadPushService;
use App\Modules\Enquiry\ChatbotForm\Requests\ChatbotFormRequest;
use App\Modules\Enquiry\ChatbotForm\Resources\ChatbotFormCollection;
use App\Modules\Enquiry\ChatbotForm\Services\ChatbotFormService;

class ChatbotFormCreateController extends Controller
{
    private $chatbotFormService;

    public function __construct(ChatbotFormService $chatbotFormService)
    {
        $this->chatbotFormService = $chatbotFormService;
    }

    public function post(ChatbotFormRequest $request){
        try {
            //code...
            $courseRequestForm = $this->chatbotFormService->create(
                [
                    ...$request->validated(),
                ]
            );
            // $get_location_data = array_filter(explode(',', $branch->name));
            // (new CrmLeadPushService)->push_lead($courseRequestForm->name, $courseRequestForm->email, $courseRequestForm->phone, $get_location_data[1], $get_location_data[0], $course->name);
            return response()->json([
                'message' => "Chatbot request created successfully.",
                'courseRequestForm' => ChatbotFormCollection::make($courseRequestForm),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Something went wrong. Please try again",
            ], 400);
        }

    }
}
