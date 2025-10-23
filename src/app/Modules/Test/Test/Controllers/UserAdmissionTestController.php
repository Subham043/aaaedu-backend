<?php

namespace App\Modules\Test\Test\Controllers;

use App\Enums\ExamMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Modules\Test\Test\Resources\UserTestCollection;
use App\Modules\AdmissionTest\Services\AdmissionTestService as AdmissionRegistrationService;
use App\Modules\Test\Test\Services\AdmissionTestService;

class UserAdmissionTestController extends Controller
{
    private $testService;
    private $registrationService;

    public function __construct(AdmissionTestService $testService, AdmissionRegistrationService $registrationService)
    {
        $this->testService = $testService;
        $this->registrationService = $registrationService;
    }

    public function get($slug){
        $admissionTest = $this->registrationService->getByUserId(auth()->user()->id);
        $path = $admissionTest->mode == ExamMode::ONLINE ? 'vii-aptitude-test' : null;
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
        if($admissionTest && $admissionTest->payment_status == PaymentStatus::PAID && $admissionTest->mode == ExamMode::ONLINE && $path==$slug){
            $test = $this->testService->getBySlug($slug);
            return response()->json([
                'message' => "Test recieved successfully.",
                'test' => UserTestCollection::make($test),
            ], 200);
        }
        return response()->json([
            'message' => "Data not found",
        ], 404);
    }
}
