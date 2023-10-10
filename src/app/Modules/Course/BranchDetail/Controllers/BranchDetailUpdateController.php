<?php

namespace App\Modules\Course\BranchDetail\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Achiever\Student\Services\StudentService;
use App\Modules\Course\Branch\Services\BranchService;
use App\Modules\Course\BranchDetail\Requests\BranchDetailRequest;
use App\Modules\Course\BranchDetail\Services\BranchDetailService;
use App\Modules\Course\Course\Services\CourseService;
use App\Modules\TeamMember\Staff\Services\StaffService;
use App\Modules\Testimonial\Services\TestimonialService;

class BranchDetailUpdateController extends Controller
{
    private $branchDetailService;
    private $courseService;
    private $branchService;
    private $testimonialService;
    private $achieverService;
    private $staffService;

    public function __construct(BranchDetailService $branchDetailService, CourseService $courseService, BranchService $branchService, TestimonialService $testimonialService, StudentService $achieverService, StaffService $staffService)
    {
        $this->middleware('permission:edit courses', ['only' => ['get','post']]);
        $this->branchDetailService = $branchDetailService;
        $this->courseService = $courseService;
        $this->branchService = $branchService;
        $this->testimonialService = $testimonialService;
        $this->achieverService = $achieverService;
        $this->staffService = $staffService;
    }

    public function get($course_id, $branch_id){
        $course = $this->courseService->getById($course_id);
        $branch = $this->branchService->getById($branch_id);
        $data = $this->branchDetailService->getByCourseIdAndBranchId($course_id, $branch_id);
        $testimonial = $this->testimonialService->all();
        $testimonials = !empty($data) ? $data->testimonials->pluck('id')->toArray() : [];
        $achiever = $this->achieverService->all();
        $achievers = !empty($data) ? $data->achievers->pluck('id')->toArray() : [];
        $staff = $this->staffService->all();
        $staffs = !empty($data) ? $data->staffs->pluck('id')->toArray() : [];
        return view('admin.pages.course.branchDetail.update', compact(['data', 'course_id', 'branch_id', 'course', 'branch', 'testimonial', 'testimonials', 'achiever', 'achievers', 'staff', 'staffs']));
    }

    public function post(BranchDetailRequest $request, $course_id, $branch_id){
        $this->courseService->getById($course_id);
        $this->branchService->getById($branch_id);
        try {
            //code...
            $branchDetail = $this->branchDetailService->createOrUpdate(
                $request->validated(),
                $course_id,
                $branch_id
            );
            if($request->testimonial && count($request->testimonial)>0){
                $this->branchDetailService->save_testimonials($branchDetail, $request->testimonial);
            }else{
                $this->branchDetailService->save_testimonials($branchDetail, []);
            }
            if($request->achiever && count($request->achiever)>0){
                $this->branchDetailService->save_achievers($branchDetail, $request->achiever);
            }else{
                $this->branchDetailService->save_achievers($branchDetail, []);
            }
            if($request->staff && count($request->staff)>0){
                $this->branchDetailService->save_staffs($branchDetail, $request->staff);
            }else{
                $this->branchDetailService->save_staffs($branchDetail, []);
            }
            return response()->json(["message" => "Event BranchDetail updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
