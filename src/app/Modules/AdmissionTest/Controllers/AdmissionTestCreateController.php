<?php

namespace App\Modules\AdmissionTest\Controllers;

use App\Enums\ExamMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Services\RateLimitService;
use App\Http\Services\RazorpayService;
use App\Modules\AdmissionTest\Jobs\AdmissionTestEmailJob;
use App\Modules\AdmissionTest\Requests\AdmissionTestRequest;
use App\Modules\AdmissionTest\Requests\VerifyPaymentRequest;
use App\Modules\AdmissionTest\Resources\AdmissionTestCollection;
use App\Modules\AdmissionTest\Services\AdmissionTestService;
use App\Modules\User\Services\UserService;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class AdmissionTestCreateController extends Controller
{
    private $admissionTestService;
    private $userService;

    public function __construct(AdmissionTestService $admissionTestService, UserService $userService)
    {
        $this->admissionTestService = $admissionTestService;
        $this->userService = $userService;
    }

    public function post(AdmissionTestRequest $request){

        try {
            //code...
            $admissionTest = $this->admissionTestService->findByEmail($request->email);
            if(!$admissionTest){
                $receipt = Str::uuid()->toString();
                $userByEmail = $this->userService->findByEmail($request->email);
                if( !$userByEmail ){
                    $user = $this->userService->create([
                        'email' => $request->email,
                        'name' => $request->name,
                        'password' => $request->password,
                        'phone' => null,
                    ]);
                }else{
                    $user = $userByEmail;
                }
                $admissionTest = $this->admissionTestService->create(
                    [
                        ...$request->except('image'),
                        'amount' => '99',
                        'receipt' => $receipt,
                        "payment_status" => PaymentStatus::PAID,
                        // 'razorpay_order_id' => (new RazorpayService)->create_order_id(99.00, $receipt),
                        'user_id' => $user->id
                    ]
                );
                // if($request->hasFile('image')){
                //     $this->admissionTestService->saveImage($admissionTest);
                // }
                (new RateLimitService($request))->clearRateLimit();
                dispatch(new AdmissionTestEmailJob($admissionTest));
            }else{
                if($admissionTest->payment_status == PaymentStatus::PENDING){
                    $admissionTest = $this->admissionTestService->update([
                        // 'razorpay_order_id' => (new RazorpayService)->create_order_id(99.00, $admissionTest->receipt),
                        "payment_status" => PaymentStatus::PAID,
                    ], $admissionTest);
                    dispatch(new AdmissionTestEmailJob($admissionTest));
                }
            }

            return response()->json([
                'message' => "Admission registered successfully.",
                'data' => AdmissionTestCollection::make($admissionTest),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Something went wrong. Please try again",
            ], 400);
        }

    }

    public function verify(VerifyPaymentRequest $request){

        try {
            //code...
            $admissionTest = $this->admissionTestService->verify_payment($request->validated());
            dispatch(new AdmissionTestEmailJob($admissionTest));
            return response()->json([
                'message' => "Payment done successfully.",
                'enrollmentForm' => AdmissionTestCollection::make($admissionTest),
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'message' => "Something went wrong. Please try again",
            ], 400);
        }

    }

    public function download($id){
        $admissionTest = $this->admissionTestService->getById($id);
        if($admissionTest->payment_status == PaymentStatus::PAID && $admissionTest->mode == ExamMode::OFFLINE){
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
