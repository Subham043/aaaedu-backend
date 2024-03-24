<?php

namespace App\Modules\Test\AnswerSheet\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\AnswerSheet\Jobs\TestApplyEmailJob;
use App\Modules\Test\AnswerSheet\Requests\CancelPaymentRequest;
use App\Modules\Test\AnswerSheet\Requests\VerifyPaymentRequest;
use App\Modules\Test\AnswerSheet\Resources\UserTestEnrollmentCollection;
use App\Modules\Test\AnswerSheet\Services\AnswerSheetService;
use App\Modules\Test\Test\Services\TestService;

class UserTestApplyController extends Controller
{
    private $testService;
    private $answerSheetService;

    public function __construct(TestService $testService, AnswerSheetService $answerSheetService)
    {
        $this->testService = $testService;
        $this->answerSheetService = $answerSheetService;
    }

    public function get($slug){
        $test = $this->testService->getBySlug($slug);
        $check_test_eligibility = $this->answerSheetService->check_test_eligibility($test);
        if($check_test_eligibility['is_eligible'] && $check_test_eligibility['type']=='NEW'){
            $apply_test = $this->answerSheetService->apply_test($test);
            dispatch(new TestApplyEmailJob($apply_test));
            return response()->json([
                'message' => "Test applied successfully.",
                'test_enrollment' => UserTestEnrollmentCollection::make($apply_test),
            ], 200);
        }elseif($check_test_eligibility['is_eligible'] && $check_test_eligibility['type']=='PAYMENT_PENDING'){
            return response()->json([
                'message' => "Test applied successfully.",
                'test_enrollment' => UserTestEnrollmentCollection::make($check_test_eligibility['test_taken']),
            ], 200);
        }else{
            return response()->json([
                'message' => "You have already enrolled for the following online test.",
            ], 400);
        }
    }

    public function verify(VerifyPaymentRequest $request, $slug){
        $this->testService->getBySlug($slug);

        try {
            //code...
            $data = $this->answerSheetService->verify_payment($request->validated());
            dispatch(new TestApplyEmailJob($data));
            return response()->json([
                'message' => "Payment & Test Enrollment done successfully.",
                'enrollmentForm' => UserTestEnrollmentCollection::make($data),
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'message' => "Something went wrong. Please try again",
            ], 400);
        }

    }

    public function cancel(CancelPaymentRequest $request, $slug){
        $this->testService->getBySlug($slug);

        try {
            //code...
            $data = $this->answerSheetService->cancel_payment($request->validated());
            return response()->json([
                'message' => "Payment cancelled successfully.",
                'enrollmentForm' => UserTestEnrollmentCollection::make($data),
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'message' => "Something went wrong. Please try again",
            ], 400);
        }

    }
}