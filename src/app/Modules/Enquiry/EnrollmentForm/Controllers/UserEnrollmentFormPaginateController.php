<?php

namespace App\Modules\Enquiry\EnrollmentForm\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Enquiry\EnrollmentForm\Resources\UserEnrollmentFormCollection;
use App\Modules\Enquiry\EnrollmentForm\Services\EnrollmentFormService;
use Illuminate\Http\Request;

class UserEnrollmentFormPaginateController extends Controller
{
    private $enrollmentFormService;

    public function __construct(EnrollmentFormService $enrollmentFormService)
    {
        $this->enrollmentFormService = $enrollmentFormService;
    }

    public function get(Request $request){
        $data = $this->enrollmentFormService->paginate_main($request->total ?? 10);
        return UserEnrollmentFormCollection::collection($data);
    }

}