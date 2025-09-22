<?php

namespace App\Modules\AdmissionTest\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AdmissionTest\Exports\AdmissionTestExport;
use Maatwebsite\Excel\Facades\Excel;

class AdmissionTestExcelController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:list admissions', ['only' => ['get']]);
    }

    public function get(){
        return Excel::download(new AdmissionTestExport, 'admission_registartion.xlsx');
    }

}
