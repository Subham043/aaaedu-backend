<?php

namespace App\Modules\Dashboard\Controllers;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Modules\Dashboard\Services\DashboardService;
use App\Modules\Enquiry\ContactForm\Models\ContactForm;
use App\Modules\Enquiry\CourseRequestForm\Models\CourseRequestForm;
use App\Modules\Enquiry\EnrollmentForm\Models\EnrollmentForm;
use App\Modules\Enquiry\ScholarForm\Models\ScholarForm;
use App\Modules\Enquiry\SubscriptionForm\Models\SubscriptionForm;
use App\Modules\Enquiry\VrddhiForm\Models\VrddhiForm;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function get(Request $request){
        $health = $this->dashboardService->getAppHealthResult($request);
        $lastRanAt  = new Carbon($health?->finishedAt);
        return view('admin.pages.dashboard.index', compact(['health', 'lastRanAt']))->with(([
            'total_enquiries' => ContactForm::count(),
            'total_course_request' => CourseRequestForm::count(),
            'total_vrddhi_request' => VrddhiForm::count(),
            'total_subscription' => SubscriptionForm::count(),
            'total_scholar_request' => ScholarForm::count(),
            'total_enrollment' => EnrollmentForm::where('payment_status', PaymentStatus::PAID)->count(),
        ]));
    }
}
