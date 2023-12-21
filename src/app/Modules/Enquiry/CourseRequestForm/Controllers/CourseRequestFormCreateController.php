<?php

namespace App\Modules\Enquiry\CourseRequestForm\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\CrmLeadPushService;
use App\Http\Services\RateLimitService;
use App\Modules\Course\Branch\Services\BranchService;
use App\Modules\Course\Course\Services\CourseService;
use App\Modules\Enquiry\CourseRequestForm\Requests\CourseRequestFormRequest;
use App\Modules\Enquiry\CourseRequestForm\Resources\CourseRequestFormCollection;
use App\Modules\Enquiry\CourseRequestForm\Services\CourseRequestFormService;

class CourseRequestFormCreateController extends Controller
{
    private $courseRequestFormService;
    private $branchService;
    private $courseService;

    public function __construct(CourseRequestFormService $courseRequestFormService, BranchService $branchService, CourseService $courseService)
    {
        $this->courseRequestFormService = $courseRequestFormService;
        $this->branchService = $branchService;
        $this->courseService = $courseService;
    }

    public function post(CourseRequestFormRequest $request, $course_slug, $branch_slug){
        $branch = $this->branchService->getBySlug($branch_slug);
        $course = $this->courseService->getBySlug($course_slug);
        try {
            //code...
            $courseRequestForm = $this->courseRequestFormService->create(
                [
                    ...$request->validated(),
                    'branch_id' => $branch->id,
                    'course_id' => $course->id,
                ]
            );
            (new RateLimitService($request))->clearRateLimit();
            $get_location_data = array_filter(explode(',', $branch->name));
            (new CrmLeadPushService)->push_lead($courseRequestForm->name, $courseRequestForm->email, $courseRequestForm->phone, $get_location_data[1], $get_location_data[0], $course->name);
            return response()->json([
                'message' => "Course Request created successfully.",
                'courseRequestForm' => CourseRequestFormCollection::make($courseRequestForm),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Something went wrong. Please try again",
            ], 400);
        }

    }
}
