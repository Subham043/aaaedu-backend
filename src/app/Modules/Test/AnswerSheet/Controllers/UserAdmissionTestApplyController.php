<?php

namespace App\Modules\Test\AnswerSheet\Controllers;

use App\Enums\ExamMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Modules\Test\AnswerSheet\Resources\UserTestEnrollmentCollection;
use App\Modules\Test\AnswerSheet\Services\AdmissionAnswerSheetService;
use App\Modules\Test\Test\Services\AdmissionTestService;
use App\Modules\AdmissionTest\Services\AdmissionTestService as AdmissionRegistrationService;

class UserAdmissionTestApplyController extends Controller
{
    private $testService;
    private $answerSheetService;
    private $registrationService;

    public function __construct(AdmissionTestService $testService, AdmissionAnswerSheetService $answerSheetService, AdmissionRegistrationService $registrationService)
    {
        $this->testService = $testService;
        $this->registrationService = $registrationService;
        $this->answerSheetService = $answerSheetService;
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
            $check_test_eligibility = $this->answerSheetService->check_test_eligibility($test);
            if($check_test_eligibility['is_eligible'] && $check_test_eligibility['type']=='NEW'){
                $apply_test = $this->answerSheetService->apply_test($test, $admissionTest);
                return response()->json([
                    'message' => "Test applied successfully.",
                    'test_enrollment' => UserTestEnrollmentCollection::make($apply_test),
                ], 200);
            }else{
                return response()->json([
                    'message' => "You have already enrolled for the following online admission test.",
                ], 400);
            }
        }
        return response()->json([
            'message' => "Data not found",
        ], 404);
    }
}
