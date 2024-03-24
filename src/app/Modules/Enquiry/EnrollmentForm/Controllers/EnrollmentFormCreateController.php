<?php

namespace App\Modules\Enquiry\EnrollmentForm\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\RateLimitService;
use App\Http\Services\RazorpayService;
use App\Modules\Course\Branch\Services\BranchService;
use App\Modules\Course\Course\Services\CourseService;
use App\Modules\Enquiry\EnrollmentForm\Jobs\EnrollmentFormEmailJob;
use App\Modules\Enquiry\EnrollmentForm\Requests\CancelPaymentRequest;
use App\Modules\Enquiry\EnrollmentForm\Requests\EnrollmentFormRequest;
use App\Modules\Enquiry\EnrollmentForm\Requests\VerifyPaymentRequest;
use App\Modules\Enquiry\EnrollmentForm\Resources\EnrollmentFormCollection;
use App\Modules\Enquiry\EnrollmentForm\Services\EnrollmentFormService;
use Illuminate\Support\Str;

class EnrollmentFormCreateController extends Controller
{
    private $enrollmentFormService;
    private $branchService;
    private $courseService;

    public function __construct(EnrollmentFormService $enrollmentFormService, BranchService $branchService, CourseService $courseService)
    {
        $this->enrollmentFormService = $enrollmentFormService;
        $this->branchService = $branchService;
        $this->courseService = $courseService;
    }

    public function post(EnrollmentFormRequest $request, $course_slug, $branch_slug){
        $branch = $this->branchService->getBySlug($branch_slug);
        $course = $this->courseService->getBySlug($course_slug);
        try {
            //code...
            $receipt = Str::uuid()->toString();
            $enrollmentForm = $this->enrollmentFormService->create(
                [
                    ...$request->validated(),
                    'receipt' => $receipt,
                    'branch_id' => $branch->id,
                    'course_id' => $course->id,
                    'amount' => $course->branch_details[0]->amount,
                    'discount' => $course->branch_details[0]->discount,
                    'discounted_amount' => $course->branch_details[0]->discounted_amount,
                    'razorpay_order_id' => (new RazorpayService)->create_order_id($course->branch_details[0]->discounted_amount, $receipt)
                ]
            );
            (new RateLimitService($request))->clearRateLimit();
            return response()->json([
                'message' => "Enrollment created successfully.",
                'enrollmentForm' => EnrollmentFormCollection::make($enrollmentForm),
            ], 201);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'message' => "Something went wrong. Please try again",
            ], 400);
        }

    }

    public function verify(VerifyPaymentRequest $request){

        try {
            //code...
            $data = $this->enrollmentFormService->verify_payment($request->validated());
            dispatch(new EnrollmentFormEmailJob($data));
            return response()->json([
                'message' => "Payment & Enrollment done successfully.",
                'enrollmentForm' => EnrollmentFormCollection::make($data),
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'message' => "Something went wrong. Please try again",
            ], 400);
        }

    }

    public function cancel(CancelPaymentRequest $request){

        try {
            //code...
            $data = $this->enrollmentFormService->cancel_payment($request->validated());
            return response()->json([
                'message' => "Payment cancelled successfully.",
                'enrollmentForm' => EnrollmentFormCollection::make($data),
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'message' => "Something went wrong. Please try again",
            ], 400);
        }

    }
}