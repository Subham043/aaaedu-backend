<?php

namespace App\Modules\AdmissionTest\Controllers;

use App\Enums\ExamMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Modules\AdmissionTest\Resources\AdmissionTestCollection;
use App\Modules\AdmissionTest\Services\AdmissionTestService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class AdmissionTestInfoController extends Controller
{
    private $admissionTestService;

    public function __construct(AdmissionTestService $admissionTestService)
    {
        $this->admissionTestService = $admissionTestService;
    }

    public function index(){
        $admissionTest = $this->admissionTestService->getByUserId(auth()->user()->id);
        if($admissionTest && $admissionTest->payment_status == PaymentStatus::PAID){
            $path = $admissionTest->mode == ExamMode::ONLINE ? 'vii-aptitude-test' : null;
            if($admissionTest->mode == ExamMode::ONLINE){
                switch ($admissionTest->class->value ?? '7th') {
                    case '7th':
                        # code...
                        $path = 'vii-aptitude-test';
                        break;
                    case '8th':
                        # code...
                        $path = 'viii-aptitude-test';
                        break;
                    case '9th':
                        # code...
                        $path = 'ix-aptitude-test';
                        break;
                    case '10th':
                        # code...
                        $path = 'x-aptitude-test';
                        break;

                    default:
                        # code...
                        $path = 'vii-aptitude-test';
                        break;
                }
            }
            return response()->json([
                'message' => "Admission Test Info Recieved successfully",
                'admission_completed' => true,
                'online_path' => $path,
                'enrollmentForm' => AdmissionTestCollection::make($admissionTest),
            ], 200);
        }
        return response()->json([
            'message' => "You haven't applied for the admission yet!",
            'admission_completed' => false,
            'enrollmentForm' => AdmissionTestCollection::make($admissionTest),
        ], 400);
    }

    public function download(){
        $admissionTest = $this->admissionTestService->getByUserId(auth()->user()->id);
        if($admissionTest && $admissionTest->payment_status == PaymentStatus::PAID && $admissionTest->mode == ExamMode::OFFLINE){
            $fileName = str()->uuid();
            $data = [
                'admissionTest' => $admissionTest
            ];
            $pdf = Pdf::loadView('pdf.hall_ticket', $data)->setPaper('a4', 'landscape');
            $pdf->save(storage_path('app/public/reports/').$fileName.'.pdf');
            return response()->download(Storage::path('/reports/'.$fileName.'.pdf'))->deleteFileAfterSend(true);
        }
        abort(404);
    }
}
