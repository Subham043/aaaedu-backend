<?php

namespace App\Modules\Campaign\Enquiry\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\RateLimitService;
use App\Modules\Campaign\Campaign\Services\CampaignService;
use App\Modules\Campaign\Enquiry\Requests\EnquiryRequest;
use App\Modules\Campaign\Enquiry\Resources\UserEnquiryCollection;
use App\Modules\Campaign\Enquiry\Services\EnquiryService;

class EnquiryCreateController extends Controller
{
    private $enquiryService;
    private $campaignService;

    public function __construct(EnquiryService $enquiryService, CampaignService $campaignService)
    {
        $this->enquiryService = $enquiryService;
        $this->campaignService = $campaignService;
    }

    public function post(EnquiryRequest $request, $campaign_id){
        $data = $this->campaignService->getById($campaign_id);
        try {
            //code...
            $campaignEnquiry = $this->enquiryService->create(
                [
                    ...$request->validated(),
                    'campaign_id' => $data->id
                ]
            );
            (new RateLimitService($request))->clearRateLimit();
            return response()->json([
                "message" => "Campaign Enquiry created successfully.",
                "enquiry" => UserEnquiryCollection::make($campaignEnquiry)
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
