<?php

namespace App\Modules\AdmissionTest\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AdmissionTest\Services\AdmissionTestService;

class AdmissionTestDeleteController extends Controller
{
    private $admissionTestService;

    public function __construct(AdmissionTestService $admissionTestService)
    {
        $this->middleware('permission:delete admissions', ['only' => ['get']]);
        $this->admissionTestService = $admissionTestService;
    }

    public function get($id){
        $admission = $this->admissionTestService->getById($id);

        try {
            //code...
            $this->admissionTestService->delete(
                $admission
            );
            return redirect()->back()->with('success_status', 'Admission registration deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
