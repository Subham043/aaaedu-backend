<?php

namespace App\Modules\Enquiry\ChatbotForm\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\CrmLeadPushService;
use App\Modules\Enquiry\ChatbotForm\Requests\ChatbotFormRequest;
use App\Modules\Enquiry\ChatbotForm\Resources\ChatbotFormCollection;
use App\Modules\Enquiry\ChatbotForm\Services\ChatbotFormService;

class ChatbotFormUpdateController extends Controller
{
    private $chatbotFormService;

    public function __construct(ChatbotFormService $chatbotFormService)
    {
        $this->chatbotFormService = $chatbotFormService;
    }

    public function post(ChatbotFormRequest $request, $id){
        $chatbot = $this->chatbotFormService->getByLeadId($id);
        try {
            //code...
            $chatbotForm = $this->chatbotFormService->update(
                [
                    ...$request->validated(),
                ],
                $chatbot
            );
            // $get_location_data = array_filter(explode(',', $branch->name));
            // (new CrmLeadPushService)->push_lead($chatbotForm->name, $chatbotForm->email, $chatbotForm->phone, $get_location_data[1], $get_location_data[0], $course->name);
            return response()->json([
                'message' => "Chatbot request updated successfully.",
                'chatbotForm' => ChatbotFormCollection::make($chatbotForm),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Something went wrong. Please try again",
            ], 400);
        }

    }
}
