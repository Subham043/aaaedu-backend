<?php

namespace App\Modules\Test\AnswerSheet\Controllers;

use App\Enums\ExamMode;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Modules\Test\AnswerSheet\Requests\AnswerSheetRequest;
use App\Modules\Test\AnswerSheet\Services\AnswerSheetService;
use App\Modules\Test\Test\Services\TestService;
use App\Modules\Test\Test\Services\AdmissionTestService;
use App\Modules\AdmissionTest\Services\AdmissionTestService as AdmissionRegistrationService;

class UserTestFillAnswerController extends Controller
{
    private $testService;
    private $admissionTestService;
    private $answerSheetService;
    private $registrationService;

    public function __construct(TestService $testService, AdmissionTestService $admissionTestService, AnswerSheetService $answerSheetService, AdmissionRegistrationService $registrationService)
    {
        $this->testService = $testService;
        $this->answerSheetService = $answerSheetService;
        $this->admissionTestService = $admissionTestService;
        $this->registrationService = $registrationService;
    }

    public function post(AnswerSheetRequest $request, $slug){
        $test = $this->testService->getBySlug($slug);
        try {
            //code...
            $this->answerSheetService->fill_answer($request, $test);
            return response()->json([
                'message' => 'Answer submitted successfully'
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'Exam is over already!'
            ], 400);
        }
    }

    public function postv2(AnswerSheetRequest $request, $slug){
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
            $test = $this->admissionTestService->getBySlug($slug);
            try {
                //code...
                $this->answerSheetService->fill_answer($request, $test);
                return response()->json([
                    'message' => 'Answer submitted successfully'
                ], 200);
            } catch (\Throwable $th) {
                //throw $th;
                return response()->json([
                    'message' => 'Exam is over already!'
                ], 400);
            }
        }
        return response()->json([
            'message' => "Data not found",
        ], 404);
    }
}
