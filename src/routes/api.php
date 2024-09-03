<?php

use App\Exceptions\CustomExceptions\UnauthenticatedException;
use App\Modules\AboutPage\Main\Controllers\UserAboutMainController;
use App\Modules\Achiever\Category\Controllers\UserCategoryDetailController;
use App\Modules\Achiever\Category\Controllers\UserCategoryAllController;
use App\Modules\Achiever\Student\Controllers\UserStudentPaginateController;
use App\Modules\AdmissionForm\Controllers\AdmissionNotPucFormCreateController;
use App\Modules\AdmissionForm\Controllers\AdmissionPucFormCreateController;
use App\Modules\Authentication\Controllers\UserProfileController;
use App\Modules\Authentication\Controllers\UserForgotPasswordController;
use App\Modules\Authentication\Controllers\UserLoginController;
use App\Modules\Authentication\Controllers\UserLogoutController;
use App\Modules\Authentication\Controllers\UserPasswordUpdateController;
use App\Modules\Authentication\Controllers\UserRegisterController;
use App\Modules\Authentication\Controllers\UserResetPasswordController;
use App\Modules\Authentication\Controllers\VerifyRegisteredUserController;
use App\Modules\Blog\Comment\Controllers\UserBlogCommentCreateController;
use App\Modules\Blog\Comment\Controllers\UserBlogCommentPaginateController;
use App\Modules\Blog\Controllers\UserBlogAllController;
use App\Modules\Blog\Controllers\UserBlogDetailController;
use App\Modules\Blog\Controllers\UserBlogPaginateController;
use App\Modules\Campaign\Campaign\Controllers\UserCampaignAllController;
use App\Modules\Campaign\Campaign\Controllers\UserCampaignDetailController;
use App\Modules\Campaign\Enquiry\Controllers\EnquiryCreateController;
use App\Modules\Counter\Controllers\UserCounterAllController;
use App\Modules\Course\Branch\Controllers\UserBranchAllController;
use App\Modules\Course\Branch\Controllers\UserBranchDetailController;
use App\Modules\Course\Course\Controllers\UserCourseAllController;
use App\Modules\Course\Course\Controllers\UserCourseDetailController;
use App\Modules\Enquiry\ChatbotForm\Controllers\ChatbotFormCreateController;
use App\Modules\Enquiry\ChatbotForm\Controllers\ChatbotFormUpdateController;
use App\Modules\Enquiry\ContactForm\Controllers\ContactFormCreateController;
use App\Modules\Enquiry\CourseRequestForm\Controllers\CourseRequestFormCreateController;
use App\Modules\Enquiry\EnrollmentForm\Controllers\EnrollmentFormCreateController;
use App\Modules\Enquiry\EnrollmentForm\Controllers\UserEnrollmentFormPaginateController;
use App\Modules\Enquiry\ScholarForm\Controllers\ScholarFormCreateController;
use App\Modules\Enquiry\SubscriptionForm\Controllers\SubscriptionFormCreateController;
use App\Modules\Enquiry\VrddhiForm\Controllers\VrddhiFormCreateController;
use App\Modules\Event\Event\Controllers\UserEventAllController;
use App\Modules\Event\Event\Controllers\UserEventDetailController;
use App\Modules\Event\Event\Controllers\UserEventPaginateController;
use App\Modules\ExpertTip\Controllers\UserExpertTipAllController;
use App\Modules\ExpertTip\Controllers\UserExpertTipDetailController;
use App\Modules\ExpertTip\Controllers\UserExpertTipPaginateController;
use App\Modules\Faq\Controllers\UserFaqDetailController;
use App\Modules\Faq\Controllers\UserFaqPaginateController;
use App\Modules\Feature\Controllers\UserFeatureAllController;
use App\Modules\Gallery\Controllers\UserGalleryPaginateController;
use App\Modules\HomePage\Banner\Controllers\UserBannerAllController;
use App\Modules\JobOpening\JobEnquiry\Controllers\UserJobEnquiryCreateController;
use App\Modules\JobOpening\JobOpening\Controllers\UserJobOpeningAllController;
use App\Modules\JobOpening\JobOpening\Controllers\UserJobOpeningPaginateController;
use App\Modules\Legal\Controllers\UserLegalAllController;
use App\Modules\Legal\Controllers\UserLegalDetailController;
use App\Modules\MissionVision\Controllers\UserMissionVisionController;
use App\Modules\Seo\Controllers\UserSeoDetailController;
use App\Modules\Settings\Controllers\General\UserGeneralController;
use App\Modules\TeamMember\Management\Controllers\UserManagementAllController;
use App\Modules\TeamMember\Staff\Controllers\UserStaffPaginateController;
use App\Modules\Test\AnswerSheet\Controllers\UserTestApplyController;
use App\Modules\Test\AnswerSheet\Controllers\UserTestEliminatedController;
use App\Modules\Test\AnswerSheet\Controllers\UserTestFillAnswerController;
use App\Modules\Test\AnswerSheet\Controllers\UserTestQuestionSetController;
use App\Modules\Test\AnswerSheet\Controllers\UserTestReportController;
use App\Modules\Test\AnswerSheet\Controllers\UserTestReportPdfController;
use App\Modules\Test\AnswerSheet\Controllers\UserTestTakenPaginateController;
use App\Modules\Test\Test\Controllers\UserTestAllController;
use App\Modules\Test\Test\Controllers\UserTestDetailController;
use App\Modules\Test\Test\Controllers\UserTestPaginateController;
use App\Modules\Testimonial\Controllers\UserTestimonialPaginateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [UserLoginController::class, 'post'])->name('user.login');
    Route::post('/register', [UserRegisterController::class, 'post'])->name('user.register');
    Route::post('/forgot-password', [UserForgotPasswordController::class, 'post'])->name('user.forgot_password');
    Route::post('/reset-password/{token}', [UserResetPasswordController::class, 'post', 'as' => 'reset_password.post'])->name('user.reset_password');
});

Route::prefix('/email/verify')->group(function () {
    Route::post('/resend-notification', [VerifyRegisteredUserController::class, 'resend_notification', 'as' => 'resend_notification'])->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');
});

Route::prefix('contact-form')->group(function () {
    Route::post('/', [ContactFormCreateController::class, 'post'])->name('user.contact_form.create');
});

Route::prefix('day-scholar-form')->group(function () {
    Route::post('/', [ScholarFormCreateController::class, 'post'])->name('user.scholar_form.create');
});

Route::prefix('subscription-form')->group(function () {
    Route::post('/', [SubscriptionFormCreateController::class, 'post'])->name('user.subscription_form.create');
});

Route::prefix('vrddhi-form')->group(function () {
    Route::post('/', [VrddhiFormCreateController::class, 'post'])->name('user.vrddhi_form.create');
});

Route::prefix('admission')->group(function () {
    Route::post('/puc', [AdmissionPucFormCreateController::class, 'post'])->name('user.admission_puc_form.create');
    Route::post('/not-puc', [AdmissionNotPucFormCreateController::class, 'post'])->name('user.admission_not_puc_form.create');
});

Route::prefix('counter')->group(function () {
    Route::get('/', [UserCounterAllController::class, 'get'])->name('user.counter.all');
});

Route::prefix('testimonial')->group(function () {
    Route::get('/', [UserTestimonialPaginateController::class, 'get'])->name('user.testimonial.all');
});

Route::prefix('gallery')->group(function () {
    Route::get('/', [UserGalleryPaginateController::class, 'get'])->name('user.gallery.all');
});

Route::prefix('feature')->group(function () {
    Route::get('/{page}', [UserFeatureAllController::class, 'get'])->name('user.feature.all');
});

Route::prefix('about-section')->group(function () {
    Route::get('/{slug}', [UserAboutMainController::class, 'get'])->name('user.about.main');
});

Route::prefix('mission-vision')->group(function () {
    Route::get('/', [UserMissionVisionController::class, 'get'])->name('user.mission.main');
});

Route::prefix('home-page-banner')->group(function () {
    Route::get('/', [UserBannerAllController::class, 'get'])->name('user.home_page.banner');
});

Route::prefix('legal')->group(function () {
    Route::get('/', [UserLegalAllController::class, 'get'])->name('user.legal.all');
    Route::get('/{slug}', [UserLegalDetailController::class, 'get'])->name('user.legal.detail');
});

Route::prefix('website-detail')->group(function () {
    Route::get('/', [UserGeneralController::class, 'get'])->name('user.website-detail.all');
});

Route::prefix('job-openings')->group(function () {
    Route::get('/', [UserJobOpeningPaginateController::class, 'get'])->name('user.job.paginate');
    Route::get('/all', [UserJobOpeningAllController::class, 'get'])->name('user.job.all');
    Route::prefix('enquiry')->group(function () {
        Route::post('/{job_id}/create', [UserJobEnquiryCreateController::class, 'post'])->name('user.job.enquiry.create');
    });
});

Route::prefix('blog')->group(function () {
    Route::get('/', [UserBlogPaginateController::class, 'get'])->name('user.blog.paginate');
    Route::get('/all', [UserBlogAllController::class, 'get'])->name('user.blog.all');
    Route::prefix('comment')->group(function () {
        Route::post('/{blog_id}/create', [UserBlogCommentCreateController::class, 'post'])->name('user.blog.comment.create');
        Route::get('/{blog_id}/paginate', [UserBlogCommentPaginateController::class, 'get'])->name('user.blog.comment.paginate');
    });
    Route::get('/{slug}', [UserBlogDetailController::class, 'get'])->name('user.blog.detail');
});

Route::prefix('team-member')->group(function () {
    Route::get('/management', [UserManagementAllController::class, 'get'])->name('user.management.paginate');
    Route::get('/staff', [UserStaffPaginateController::class, 'get'])->name('user.staff.paginate');
});

Route::prefix('expert-tip')->group(function () {
    Route::get('/', [UserExpertTipPaginateController::class, 'get'])->name('user.expert_tip.paginate');
    Route::get('/all', [UserExpertTipAllController::class, 'get'])->name('user.expert_tip.all');
    Route::get('/{slug}', [UserExpertTipDetailController::class, 'get'])->name('user.expert_tip.detail');
});

Route::prefix('achiever')->group(function () {
    Route::get('/category', [UserCategoryAllController::class, 'get'])->name('user.achiever.category.paginate');
    Route::get('/category/{slug}', [UserCategoryDetailController::class, 'get'])->name('user.achiever.category.detail');
    Route::get('/student', [UserStudentPaginateController::class, 'get'])->name('user.achiever.student.paginate');
});

Route::prefix('event')->group(function () {
    Route::get('/', [UserEventPaginateController::class, 'get'])->name('user.event.paginate');
    Route::get('/all', [UserEventAllController::class, 'get'])->name('user.event.all');
    Route::get('/{slug}', [UserEventDetailController::class, 'get'])->name('user.event.detail');
});

Route::prefix('campaign')->group(function () {
    Route::post('/enquiry/{campaign_id}', [EnquiryCreateController::class, 'post'])->name('user.campaign.enquiry.paginate');
    Route::get('/all', [UserCampaignAllController::class, 'get'])->name('user.campaign.all');
    Route::get('/{slug}', [UserCampaignDetailController::class, 'get'])->name('user.campaign.detail');
});

Route::prefix('course')->group(function () {
    Route::get('/', [UserCourseAllController::class, 'get'])->name('user.course.all');
    Route::get('/{course_slug}/branch/{branch_slug}', [UserCourseDetailController::class, 'get'])->name('user.course.detail');
    Route::post('/{course_slug}/branch/{branch_slug}/enroll', [EnrollmentFormCreateController::class, 'post'])->name('user.course.enroll');
    Route::post('/{course_slug}/branch/{branch_slug}/request', [CourseRequestFormCreateController::class, 'post'])->name('user.course.request');
});

Route::post('/enrollment/verify', [EnrollmentFormCreateController::class, 'verify'])->name('user.enroll.verify');
Route::post('/enrollment/cancelled', [EnrollmentFormCreateController::class, 'cancel'])->name('user.enroll.cancel');

Route::prefix('branch')->group(function () {
    Route::get('/all', [UserBranchAllController::class, 'get'])->name('user.branch.all');
    Route::get('/{slug}', [UserBranchDetailController::class, 'get'])->name('user.branch.detail');
});

Route::prefix('faq')->group(function () {
    Route::get('/', [UserFaqPaginateController::class, 'get'])->name('user.faq.paginate');
    Route::get('/{id}', [UserFaqDetailController::class, 'get'])->name('user.faq.detail');
});

Route::prefix('seo')->group(function () {
    Route::get('/{slug}', [UserSeoDetailController::class, 'get'])->name('user.seo.detail');
});

Route::prefix('tests')->group(function () {
    Route::get('/', [UserTestPaginateController::class, 'get'])->name('user.test.paginate');
    Route::middleware(['auth:sanctum'])->get('/main-paginate', [UserTestPaginateController::class, 'get'])->name('user.test.paginate.main');
    Route::get('/all', [UserTestAllController::class, 'get'])->name('user.test.all');
    Route::get('/{slug}', [UserTestDetailController::class, 'get'])->name('user.test.detail');
});

Route::prefix('artibot-request')->group(function () {
    Route::post('/create', [ChatbotFormCreateController::class, 'post'])->name('chatbot.create.request');
    Route::post('/update/{lead_id}', [ChatbotFormUpdateController::class, 'post'])->name('chatbot.update.request');
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::prefix('profile')->group(function () {
        Route::get('/', [UserProfileController::class, 'get', 'as' => 'profile.get'])->name('user.profile.get');
        Route::post('/update', [UserProfileController::class, 'post', 'as' => 'profile.post'])->name('user.profile.post');
        Route::post('/update-password', [UserPasswordUpdateController::class, 'post', 'as' => 'password.post'])->name('user.password.post');
    });

    Route::get('/courses-enrolled', [UserEnrollmentFormPaginateController::class, 'get'])->name('user.course_enrolled.all');
    Route::get('/tests-enrolled', [UserTestTakenPaginateController::class, 'get'])->name('user.test_enrolled.all');


    Route::prefix('tests')->group(function () {
        Route::prefix('{slug}')->group(function () {
            Route::get('/main-detail', [UserTestDetailController::class, 'get'])->name('user.test.detail.main');
            Route::get('/apply', [UserTestApplyController::class, 'get'])->name('user.test.apply');
            Route::post('/apply/payment-verification', [UserTestApplyController::class, 'verify'])->name('user.test.apply.verify');
            Route::post('/apply/payment-cencelled', [UserTestApplyController::class, 'cancel'])->name('user.test.apply.cancel');
            Route::get('/question-set', [UserTestQuestionSetController::class, 'get'])->name('user.test.question');
            Route::post('/fill-answer', [UserTestFillAnswerController::class, 'post'])->name('user.test.answer');
            Route::post('/eliminated', [UserTestEliminatedController::class, 'post'])->name('user.test.eliminated');
            Route::get('/report', [UserTestReportController::class, 'get'])->name('user.test.report');
            Route::get('/report-download-request', [UserTestReportPdfController::class, 'get'])->name('user.test.report_download_request');
        });
    });

    Route::get('/auth/logout', [UserLogoutController::class, 'post', 'as' => 'logout'])->name('user.logout');

});

Route::get('/unauthenticated', function () {
    throw new UnauthenticatedException("Unauthenticated", 401);
 })->name('unauthenticated');
