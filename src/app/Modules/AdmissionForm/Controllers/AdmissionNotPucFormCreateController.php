<?php

namespace App\Modules\AdmissionForm\Controllers;

use App\Enums\AdmissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Services\RateLimitService;
use App\Modules\AdmissionForm\Jobs\NotPucFormEmailJob;
use App\Modules\AdmissionForm\Requests\AdmissionNotPucFormRequest;
use App\Modules\AdmissionForm\Resources\AdmissionFormCollection;
use App\Modules\AdmissionForm\Services\AdmissionFormService;

class AdmissionNotPucFormCreateController extends Controller
{
    private $admissionFormService;

    public function __construct(AdmissionFormService $admissionFormService)
    {
        $this->admissionFormService = $admissionFormService;
    }

    public function post(AdmissionNotPucFormRequest $request){

        try {
            //code...
            $admissionForm = $this->admissionFormService->create(
                [
                    ...$request->except('marks'),
                    'admission_for' => AdmissionEnum::NOT_PUC
                ]
            );
            if($request->hasFile('marks')){
                $this->admissionFormService->saveImage($admissionForm);
            }
            (new RateLimitService($request))->clearRateLimit();
            dispatch(new NotPucFormEmailJob($admissionForm));

            return response()->json([
                'message' => "Admission created successfully.",
                'admissionForm' => AdmissionFormCollection::make($admissionForm),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Something went wrong. Please try again",
            ], 400);
        }

    }
}
