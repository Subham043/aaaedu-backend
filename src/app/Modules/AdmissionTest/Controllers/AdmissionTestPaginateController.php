<?php

namespace App\Modules\AdmissionTest\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AdmissionTest\Services\AdmissionTestService;
use Illuminate\Http\Request;

class AdmissionTestPaginateController extends Controller
{
    private $admissionTestService;

    public function __construct(AdmissionTestService $admissionTestService)
    {
        $this->middleware('permission:list admissions', ['only' => ['get']]);
        $this->admissionTestService = $admissionTestService;
    }

    public function get(Request $request){
        $data = $this->admissionTestService->paginate($request->total ?? 10);
        return view('admin.pages.admission.registration', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
