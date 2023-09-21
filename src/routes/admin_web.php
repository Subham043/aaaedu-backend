<?php

use App\Modules\AboutPage\Main\Controllers\AboutMainController;
use App\Modules\Achiever\Category\Controllers\CategoryCreateController;
use App\Modules\Achiever\Category\Controllers\CategoryDeleteController;
use App\Modules\Achiever\Category\Controllers\CategoryPaginateController;
use App\Modules\Achiever\Category\Controllers\CategoryUpdateController;
use App\Modules\Achiever\Student\Controllers\StudentCreateController;
use App\Modules\Achiever\Student\Controllers\StudentDeleteController;
use App\Modules\Achiever\Student\Controllers\StudentPaginateController;
use App\Modules\Achiever\Student\Controllers\StudentUpdateController;
use App\Modules\AdmissionForm\Controllers\AdmissionFormDeleteController;
use App\Modules\AdmissionForm\Controllers\AdmissionNotPucFormExcelController;
use App\Modules\AdmissionForm\Controllers\AdmissionNotPucFormPaginateController;
use App\Modules\AdmissionForm\Controllers\AdmissionPucFormExcelController;
use App\Modules\AdmissionForm\Controllers\AdmissionPucFormPaginateController;
use App\Modules\Authentication\Controllers\PasswordUpdateController;
use App\Modules\Authentication\Controllers\ForgotPasswordController;
use App\Modules\Authentication\Controllers\LoginController;
use App\Modules\Authentication\Controllers\LogoutController;
use App\Modules\Authentication\Controllers\ProfileController;
use App\Modules\Authentication\Controllers\ResetPasswordController;
use App\Modules\Blog\Comment\Controllers\BlogCommentDeleteController;
use App\Modules\Blog\Comment\Controllers\BlogCommentPaginateController;
use App\Modules\Blog\Comment\Controllers\BlogCommentStatusController;
use App\Modules\Dashboard\Controllers\DashboardController;
use App\Modules\Enquiry\ContactForm\Controllers\ContactFormDeleteController;
use App\Modules\Enquiry\ContactForm\Controllers\ContactFormExcelController;
use App\Modules\Enquiry\ContactForm\Controllers\ContactFormPaginateController;
use App\Modules\Legal\Controllers\LegalPaginateController;
use App\Modules\Legal\Controllers\LegalUpdateController;
use App\Modules\Blog\Controllers\BlogCreateController;
use App\Modules\Blog\Controllers\BlogDeleteController;
use App\Modules\Blog\Controllers\BlogPaginateController;
use App\Modules\Blog\Controllers\BlogUpdateController;
use App\Modules\Campaign\Campaign\Controllers\CampaignCreateController;
use App\Modules\Campaign\Campaign\Controllers\CampaignDeleteController;
use App\Modules\Campaign\Campaign\Controllers\CampaignPaginateController;
use App\Modules\Campaign\Campaign\Controllers\CampaignUpdateController;
use App\Modules\Campaign\Enquiry\Controllers\EnquiryDeleteController;
use App\Modules\Campaign\Enquiry\Controllers\EnquiryPaginateController;
use App\Modules\Counter\Controllers\CounterCreateController;
use App\Modules\Counter\Controllers\CounterDeleteController;
use App\Modules\Counter\Controllers\CounterPaginateController;
use App\Modules\Counter\Controllers\CounterUpdateController;
use App\Modules\Enquiry\SubscriptionForm\Controllers\SubscriptionFormDeleteController;
use App\Modules\Enquiry\SubscriptionForm\Controllers\SubscriptionFormExcelController;
use App\Modules\Enquiry\SubscriptionForm\Controllers\SubscriptionFormPaginateController;
use App\Modules\Enquiry\VrddhiForm\Controllers\VrddhiFormDeleteController;
use App\Modules\Enquiry\VrddhiForm\Controllers\VrddhiFormExcelController;
use App\Modules\Enquiry\VrddhiForm\Controllers\VrddhiFormPaginateController;
use App\Modules\Event\Event\Controllers\EventCreateController;
use App\Modules\Event\Event\Controllers\EventDeleteController;
use App\Modules\Event\Event\Controllers\EventPaginateController;
use App\Modules\Event\Event\Controllers\EventUpdateController;
use App\Modules\Event\Speaker\Controllers\SpeakerCreateController;
use App\Modules\Event\Speaker\Controllers\SpeakerDeleteController;
use App\Modules\Event\Speaker\Controllers\SpeakerPaginateController;
use App\Modules\Event\Speaker\Controllers\SpeakerUpdateController;
use App\Modules\Event\Specification\Controllers\SpecificationCreateController;
use App\Modules\Event\Specification\Controllers\SpecificationDeleteController;
use App\Modules\Event\Specification\Controllers\SpecificationPaginateController;
use App\Modules\Event\Specification\Controllers\SpecificationUpdateController;
use App\Modules\ExpertTip\Controllers\ExpertTipCreateController;
use App\Modules\ExpertTip\Controllers\ExpertTipDeleteController;
use App\Modules\ExpertTip\Controllers\ExpertTipPaginateController;
use App\Modules\ExpertTip\Controllers\ExpertTipUpdateController;
use App\Modules\Faq\Controllers\FaqCreateController;
use App\Modules\Faq\Controllers\FaqDeleteController;
use App\Modules\Faq\Controllers\FaqPaginateController;
use App\Modules\Faq\Controllers\FaqUpdateController;
use App\Modules\Feature\Controllers\FeatureCreateController;
use App\Modules\Feature\Controllers\FeatureDeleteController;
use App\Modules\Feature\Controllers\FeaturePaginateController;
use App\Modules\Feature\Controllers\FeatureUpdateController;
use App\Modules\Gallery\Controllers\GalleryCreateController;
use App\Modules\Gallery\Controllers\GalleryDeleteController;
use App\Modules\Gallery\Controllers\GalleryPaginateController;
use App\Modules\Gallery\Controllers\GalleryUpdateController;
use App\Modules\Role\Controllers\RoleCreateController;
use App\Modules\Role\Controllers\RoleDeleteController;
use App\Modules\Role\Controllers\RolePaginateController;
use App\Modules\Role\Controllers\RoleUpdateController;
use App\Modules\Settings\Controllers\ActivityLog\ActivityLogDetailController;
use App\Modules\Settings\Controllers\ActivityLog\ActivityLogPaginateController;
use App\Modules\Settings\Controllers\ErrorLogController;
use App\Modules\Settings\Controllers\General\GeneralController;
use App\Modules\Settings\Controllers\SitemapController;
use App\Modules\User\Controllers\UserCreateController;
use App\Modules\User\Controllers\UserDeleteController;
use App\Modules\User\Controllers\UserPaginateController;
use App\Modules\User\Controllers\UserUpdateController;
use App\Modules\Testimonial\Controllers\TestimonialCreateController;
use App\Modules\Testimonial\Controllers\TestimonialDeleteController;
use App\Modules\Testimonial\Controllers\TestimonialPaginateController;
use App\Modules\Testimonial\Controllers\TestimonialUpdateController;
use App\Modules\HomePage\Banner\Controllers\BannerCreateController;
use App\Modules\HomePage\Banner\Controllers\BannerDeleteController;
use App\Modules\HomePage\Banner\Controllers\BannerPaginateController;
use App\Modules\HomePage\Banner\Controllers\BannerUpdateController;
use App\Modules\MissionVision\Controllers\MissionVisionController;
use App\Modules\Seo\Controllers\SeoPaginateController;
use App\Modules\Seo\Controllers\SeoUpdateController;
use App\Modules\TeamMember\Management\Controllers\ManagementCreateController;
use App\Modules\TeamMember\Management\Controllers\ManagementDeleteController;
use App\Modules\TeamMember\Management\Controllers\ManagementPaginateController;
use App\Modules\TeamMember\Management\Controllers\ManagementUpdateController;
use App\Modules\TeamMember\Staff\Controllers\StaffCreateController;
use App\Modules\TeamMember\Staff\Controllers\StaffDeleteController;
use App\Modules\TeamMember\Staff\Controllers\StaffPaginateController;
use App\Modules\TeamMember\Staff\Controllers\StaffUpdateController;
use App\Modules\TextEditorImage\Controllers\TextEditorImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'get', 'as' => 'login.get'])->name('login.get');
    Route::post('/authenticate', [LoginController::class, 'post', 'as' => 'login.post'])->name('login.post');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'get', 'as' => 'forgot_password.get'])->name('forgot_password.get');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'post', 'as' => 'forgot_password.post'])->name('forgot_password.post');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'get', 'as' => 'reset_password.get'])->name('reset_password.get')->middleware('signed');
    Route::post('/reset-password/{token}', [ResetPasswordController::class, 'post', 'as' => 'reset_password.post'])->name('reset_password.post')->middleware('signed');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'get', 'as' => 'dashboard.get'])->name('dashboard.get');

    Route::prefix('/setting')->group(function () {
        Route::get('/general', [GeneralController::class, 'get', 'as' => 'general.settings.get'])->name('general.settings.get');
        Route::post('/general-post', [GeneralController::class, 'post', 'as' => 'general.settings.post'])->name('general.settings.post');
        Route::get('/sitemap', [SitemapController::class, 'get', 'as' => 'sitemap.get'])->name('sitemap.get');
        Route::get('/sitemap-generate', [SitemapController::class, 'generate', 'as' => 'sitemap.generate'])->name('sitemap.generate');
    });

    Route::prefix('/logs')->group(function () {
        Route::get('/error', [ErrorLogController::class, 'get', 'as' => 'error_log.get'])->name('error_log.get');
        Route::prefix('/activity')->group(function () {
            Route::get('/', [ActivityLogPaginateController::class, 'get', 'as' => 'activity_log.paginate.get'])->name('activity_log.paginate.get');
            Route::get('/{id}', [ActivityLogDetailController::class, 'get', 'as' => 'activity_log.detail.get'])->name('activity_log.detail.get');

        });
    });

    Route::prefix('/enquiry')->group(function () {
        Route::prefix('/contact-form')->group(function () {
            Route::get('/', [ContactFormPaginateController::class, 'get', 'as' => 'enquiry.contact_form.paginate.get'])->name('enquiry.contact_form.paginate.get');
            Route::get('/excel', [ContactFormExcelController::class, 'get', 'as' => 'enquiry.contact_form.excel.get'])->name('enquiry.contact_form.excel.get');
            Route::get('/delete/{id}', [ContactFormDeleteController::class, 'get', 'as' => 'enquiry.contact_form.delete.get'])->name('enquiry.contact_form.delete.get');
        });
        Route::prefix('/subscription-form')->group(function () {
            Route::get('/', [SubscriptionFormPaginateController::class, 'get', 'as' => 'enquiry.subscription_form.paginate.get'])->name('enquiry.subscription_form.paginate.get');
            Route::get('/excel', [SubscriptionFormExcelController::class, 'get', 'as' => 'enquiry.subscription_form.excel.get'])->name('enquiry.subscription_form.excel.get');
            Route::get('/delete/{id}', [SubscriptionFormDeleteController::class, 'get', 'as' => 'enquiry.subscription_form.delete.get'])->name('enquiry.subscription_form.delete.get');
        });
        Route::prefix('/vrddhi-form')->group(function () {
            Route::get('/', [VrddhiFormPaginateController::class, 'get', 'as' => 'enquiry.vrddhi_form.paginate.get'])->name('enquiry.vrddhi_form.paginate.get');
            Route::get('/excel', [VrddhiFormExcelController::class, 'get', 'as' => 'enquiry.vrddhi_form.excel.get'])->name('enquiry.vrddhi_form.excel.get');
            Route::get('/delete/{id}', [VrddhiFormDeleteController::class, 'get', 'as' => 'enquiry.vrddhi_form.delete.get'])->name('enquiry.vrddhi_form.delete.get');
        });
    });

    Route::prefix('/admission')->group(function () {
        Route::prefix('/class-8-9-10')->group(function () {
            Route::get('/', [AdmissionNotPucFormPaginateController::class, 'get', 'as' => 'admission.not_puc.paginate.get'])->name('admission.not_puc.paginate.get');
            Route::get('/excel', [AdmissionNotPucFormExcelController::class, 'get', 'as' => 'admission.not_puc.excel.get'])->name('admission.not_puc.excel.get');
            Route::get('/delete/{id}', [AdmissionFormDeleteController::class, 'get', 'as' => 'admission.not_puc.delete.get'])->name('admission.not_puc.delete.get');
        });
        Route::prefix('/puc')->group(function () {
            Route::get('/', [AdmissionPucFormPaginateController::class, 'get', 'as' => 'admission.puc.paginate.get'])->name('admission.puc.paginate.get');
            Route::get('/excel', [AdmissionPucFormExcelController::class, 'get', 'as' => 'admission.puc.excel.get'])->name('admission.puc.excel.get');
            Route::get('/delete/{id}', [AdmissionFormDeleteController::class, 'get', 'as' => 'admission.puc.delete.get'])->name('admission.puc.delete.get');
        });
    });

    Route::prefix('/legal-pages')->group(function () {
        Route::get('/', [LegalPaginateController::class, 'get', 'as' => 'legal.paginate.get'])->name('legal.paginate.get');
        Route::get('/update/{slug}', [LegalUpdateController::class, 'get', 'as' => 'legal.update.get'])->name('legal.update.get');
        Route::post('/update/{slug}', [LegalUpdateController::class, 'post', 'as' => 'legal.update.post'])->name('legal.update.post');
    });

    Route::prefix('/profile')->group(function () {
        Route::get('/', [ProfileController::class, 'get', 'as' => 'profile.get'])->name('profile.get');
        Route::post('/update', [ProfileController::class, 'post', 'as' => 'profile.post'])->name('profile.post');
        Route::post('/profile-password-update', [PasswordUpdateController::class, 'post', 'as' => 'password.post'])->name('password.post');
    });

    Route::prefix('/role')->group(function () {
        Route::get('/', [RolePaginateController::class, 'get', 'as' => 'role.paginate.get'])->name('role.paginate.get');
        Route::get('/create', [RoleCreateController::class, 'get', 'as' => 'role.create.get'])->name('role.create.get');
        Route::post('/create', [RoleCreateController::class, 'post', 'as' => 'role.create.get'])->name('role.create.post');
        Route::get('/update/{id}', [RoleUpdateController::class, 'get', 'as' => 'role.update.get'])->name('role.update.get');
        Route::post('/update/{id}', [RoleUpdateController::class, 'post', 'as' => 'role.update.get'])->name('role.update.post');
        Route::get('/delete/{id}', [RoleDeleteController::class, 'get', 'as' => 'role.delete.get'])->name('role.delete.get');
    });

    Route::prefix('/user')->group(function () {
        Route::get('/', [UserPaginateController::class, 'get', 'as' => 'user.paginate.get'])->name('user.paginate.get');
        Route::get('/create', [UserCreateController::class, 'get', 'as' => 'user.create.get'])->name('user.create.get');
        Route::post('/create', [UserCreateController::class, 'post', 'as' => 'user.create.get'])->name('user.create.post');
        Route::get('/update/{id}', [UserUpdateController::class, 'get', 'as' => 'user.update.get'])->name('user.update.get');
        Route::post('/update/{id}', [UserUpdateController::class, 'post', 'as' => 'user.update.get'])->name('user.update.post');
        Route::get('/delete/{id}', [UserDeleteController::class, 'get', 'as' => 'user.delete.get'])->name('user.delete.get');
    });

    Route::prefix('/blog')->group(function () {
        Route::get('/', [BlogPaginateController::class, 'get', 'as' => 'blog.paginate.get'])->name('blog.paginate.get');
        Route::get('/create', [BlogCreateController::class, 'get', 'as' => 'blog.create.get'])->name('blog.create.get');
        Route::post('/create', [BlogCreateController::class, 'post', 'as' => 'blog.create.post'])->name('blog.create.post');
        Route::get('/update/{id}', [BlogUpdateController::class, 'get', 'as' => 'blog.update.get'])->name('blog.update.get');
        Route::post('/update/{id}', [BlogUpdateController::class, 'post', 'as' => 'blog.update.post'])->name('blog.update.post');
        Route::get('/delete/{id}', [BlogDeleteController::class, 'get', 'as' => 'blog.delete.get'])->name('blog.delete.get');
        Route::prefix('/{blog_id}')->group(function () {
            Route::prefix('/comment')->group(function () {
                Route::get('/', [BlogCommentPaginateController::class, 'get', 'as' => 'blog.comment.paginate.get'])->name('blog.comment.paginate.get');
                Route::get('/update/{id}', [BlogCommentStatusController::class, 'get', 'as' => 'blog.comment.update.get'])->name('blog.comment.update.get');
                Route::get('/delete/{id}', [BlogCommentDeleteController::class, 'get', 'as' => 'blog.comment.delete.get'])->name('blog.comment.delete.get');
            });
        });
    });

    Route::prefix('/expert-tip')->group(function () {
        Route::get('/', [ExpertTipPaginateController::class, 'get', 'as' => 'expert_tip.paginate.get'])->name('expert_tip.paginate.get');
        Route::get('/create', [ExpertTipCreateController::class, 'get', 'as' => 'expert_tip.create.get'])->name('expert_tip.create.get');
        Route::post('/create', [ExpertTipCreateController::class, 'post', 'as' => 'expert_tip.create.post'])->name('expert_tip.create.post');
        Route::get('/update/{id}', [ExpertTipUpdateController::class, 'get', 'as' => 'expert_tip.update.get'])->name('expert_tip.update.get');
        Route::post('/update/{id}', [ExpertTipUpdateController::class, 'post', 'as' => 'expert_tip.update.post'])->name('expert_tip.update.post');
        Route::get('/delete/{id}', [ExpertTipDeleteController::class, 'get', 'as' => 'expert_tip.delete.get'])->name('expert_tip.delete.get');
    });

    Route::prefix('/faq')->group(function () {
        Route::get('/', [FaqPaginateController::class, 'get', 'as' => 'faq.paginate.get'])->name('faq.paginate.get');
        Route::get('/create', [FaqCreateController::class, 'get', 'as' => 'faq.create.get'])->name('faq.create.get');
        Route::post('/create', [FaqCreateController::class, 'post', 'as' => 'faq.create.post'])->name('faq.create.post');
        Route::get('/update/{id}', [FaqUpdateController::class, 'get', 'as' => 'faq.update.get'])->name('faq.update.get');
        Route::post('/update/{id}', [FaqUpdateController::class, 'post', 'as' => 'faq.update.post'])->name('faq.update.post');
        Route::get('/delete/{id}', [FaqDeleteController::class, 'get', 'as' => 'faq.delete.get'])->name('faq.delete.get');
    });

    Route::prefix('/counter')->group(function () {
        Route::get('/', [CounterPaginateController::class, 'get', 'as' => 'counter.paginate.get'])->name('counter.paginate.get');
        Route::get('/create', [CounterCreateController::class, 'get', 'as' => 'counter.create.get'])->name('counter.create.get');
        Route::post('/create', [CounterCreateController::class, 'post', 'as' => 'counter.create.post'])->name('counter.create.post');
        Route::get('/update/{id}', [CounterUpdateController::class, 'get', 'as' => 'counter.update.get'])->name('counter.update.get');
        Route::post('/update/{id}', [CounterUpdateController::class, 'post', 'as' => 'counter.update.post'])->name('counter.update.post');
        Route::get('/delete/{id}', [CounterDeleteController::class, 'get', 'as' => 'counter.delete.get'])->name('counter.delete.get');

    });

    Route::prefix('/testimonial')->group(function () {
        Route::get('/', [TestimonialPaginateController::class, 'get', 'as' => 'testimonial.paginate.get'])->name('testimonial.paginate.get');
        Route::get('/create', [TestimonialCreateController::class, 'get', 'as' => 'testimonial.create.get'])->name('testimonial.create.get');
        Route::post('/create', [TestimonialCreateController::class, 'post', 'as' => 'testimonial.create.post'])->name('testimonial.create.post');
        Route::get('/update/{id}', [TestimonialUpdateController::class, 'get', 'as' => 'testimonial.update.get'])->name('testimonial.update.get');
        Route::post('/update/{id}', [TestimonialUpdateController::class, 'post', 'as' => 'testimonial.update.post'])->name('testimonial.update.post');
        Route::get('/delete/{id}', [TestimonialDeleteController::class, 'get', 'as' => 'testimonial.delete.get'])->name('testimonial.delete.get');
    });

    Route::prefix('/gallery')->group(function () {
        Route::get('/', [GalleryPaginateController::class, 'get', 'as' => 'gallery.paginate.get'])->name('gallery.paginate.get');
        Route::get('/create', [GalleryCreateController::class, 'get', 'as' => 'gallery.create.get'])->name('gallery.create.get');
        Route::post('/create', [GalleryCreateController::class, 'post', 'as' => 'gallery.create.post'])->name('gallery.create.post');
        Route::get('/update/{id}', [GalleryUpdateController::class, 'get', 'as' => 'gallery.update.get'])->name('gallery.update.get');
        Route::post('/update/{id}', [GalleryUpdateController::class, 'post', 'as' => 'gallery.update.post'])->name('gallery.update.post');
        Route::get('/delete/{id}', [GalleryDeleteController::class, 'get', 'as' => 'gallery.delete.get'])->name('gallery.delete.get');
    });

    Route::prefix('/home-page')->group(function () {
        Route::prefix('/banner')->group(function () {
            Route::get('/', [BannerPaginateController::class, 'get', 'as' => 'home_page.banner.paginate.get'])->name('home_page.banner.paginate.get');
            Route::get('/create', [BannerCreateController::class, 'get', 'as' => 'home_page.banner.create.get'])->name('home_page.banner.create.get');
            Route::post('/create', [BannerCreateController::class, 'post', 'as' => 'home_page.banner.create.post'])->name('home_page.banner.create.post');
            Route::get('/update/{id}', [BannerUpdateController::class, 'get', 'as' => 'home_page.banner.update.get'])->name('home_page.banner.update.get');
            Route::post('/update/{id}', [BannerUpdateController::class, 'post', 'as' => 'home_page.banner.update.post'])->name('home_page.banner.update.post');
            Route::get('/delete/{id}', [BannerDeleteController::class, 'get', 'as' => 'home_page.banner.delete.get'])->name('home_page.banner.delete.get');

        });

    });

    Route::prefix('/about-section/{slug}')->group(function () {
        Route::get('/', [AboutMainController::class, 'get', 'as' => 'about.main.get'])->name('about.main.get');
        Route::post('/', [AboutMainController::class, 'post', 'as' => 'about.main.post'])->name('about.main.post');
    });

    Route::prefix('/mission-vision')->group(function () {
        Route::get('/', [MissionVisionController::class, 'get', 'as' => 'mission.main.get'])->name('mission.main.get');
        Route::post('/', [MissionVisionController::class, 'post', 'as' => 'mission.main.post'])->name('mission.main.post');
    });

    Route::prefix('/feature/{page}')->group(function () {
        Route::get('/', [FeaturePaginateController::class, 'get', 'as' => 'feature.paginate.get'])->name('feature.paginate.get');
        Route::get('/create', [FeatureCreateController::class, 'get', 'as' => 'feature.create.get'])->name('feature.create.get');
        Route::post('/create', [FeatureCreateController::class, 'post', 'as' => 'feature.create.post'])->name('feature.create.post');
        Route::get('/update/{id}', [FeatureUpdateController::class, 'get', 'as' => 'feature.update.get'])->name('feature.update.get');
        Route::post('/update/{id}', [FeatureUpdateController::class, 'post', 'as' => 'feature.update.post'])->name('feature.update.post');
        Route::get('/delete/{id}', [FeatureDeleteController::class, 'get', 'as' => 'feature.delete.get'])->name('feature.delete.get');
    });

    Route::prefix('/seo')->group(function () {
        Route::get('/', [SeoPaginateController::class, 'get', 'as' => 'seo.paginate.get'])->name('seo.paginate.get');
        Route::get('/update/{slug}', [SeoUpdateController::class, 'get', 'as' => 'seo.update.get'])->name('seo.update.get');
        Route::post('/update/{slug}', [SeoUpdateController::class, 'post', 'as' => 'seo.update.post'])->name('seo.update.post');
    });

    Route::prefix('/team-member')->group(function () {

        Route::prefix('/management')->group(function () {
            Route::get('/', [ManagementPaginateController::class, 'get', 'as' => 'team_member.management.paginate.get'])->name('team_member.management.paginate.get');
            Route::get('/create', [ManagementCreateController::class, 'get', 'as' => 'team_member.management.create.get'])->name('team_member.management.create.get');
            Route::post('/create', [ManagementCreateController::class, 'post', 'as' => 'team_member.management.create.post'])->name('team_member.management.create.post');
            Route::get('/update/{id}', [ManagementUpdateController::class, 'get', 'as' => 'team_member.management.update.get'])->name('team_member.management.update.get');
            Route::post('/update/{id}', [ManagementUpdateController::class, 'post', 'as' => 'team_member.management.update.post'])->name('team_member.management.update.post');
            Route::get('/delete/{id}', [ManagementDeleteController::class, 'get', 'as' => 'team_member.management.delete.get'])->name('team_member.management.delete.get');
        });

        Route::prefix('/staff')->group(function () {
            Route::get('/', [StaffPaginateController::class, 'get', 'as' => 'team_member.staff.paginate.get'])->name('team_member.staff.paginate.get');
            Route::get('/create', [StaffCreateController::class, 'get', 'as' => 'team_member.staff.create.get'])->name('team_member.staff.create.get');
            Route::post('/create', [StaffCreateController::class, 'post', 'as' => 'team_member.staff.create.post'])->name('team_member.staff.create.post');
            Route::get('/update/{id}', [StaffUpdateController::class, 'get', 'as' => 'team_member.staff.update.get'])->name('team_member.staff.update.get');
            Route::post('/update/{id}', [StaffUpdateController::class, 'post', 'as' => 'team_member.staff.update.post'])->name('team_member.staff.update.post');
            Route::get('/delete/{id}', [StaffDeleteController::class, 'get', 'as' => 'team_member.staff.delete.get'])->name('team_member.staff.delete.get');
        });

    });

    Route::prefix('/achiever')->group(function () {

        Route::prefix('/category')->group(function () {
            Route::get('/', [CategoryPaginateController::class, 'get', 'as' => 'achiever.category.paginate.get'])->name('achiever.category.paginate.get');
            Route::get('/create', [CategoryCreateController::class, 'get', 'as' => 'achiever.category.create.get'])->name('achiever.category.create.get');
            Route::post('/create', [CategoryCreateController::class, 'post', 'as' => 'achiever.category.create.post'])->name('achiever.category.create.post');
            Route::get('/update/{id}', [CategoryUpdateController::class, 'get', 'as' => 'achiever.category.update.get'])->name('achiever.category.update.get');
            Route::post('/update/{id}', [CategoryUpdateController::class, 'post', 'as' => 'achiever.category.update.post'])->name('achiever.category.update.post');
            Route::get('/delete/{id}', [CategoryDeleteController::class, 'get', 'as' => 'achiever.category.delete.get'])->name('achiever.category.delete.get');
        });

        Route::prefix('/student')->group(function () {
            Route::get('/', [StudentPaginateController::class, 'get', 'as' => 'achiever.student.paginate.get'])->name('achiever.student.paginate.get');
            Route::get('/create', [StudentCreateController::class, 'get', 'as' => 'achiever.student.create.get'])->name('achiever.student.create.get');
            Route::post('/create', [StudentCreateController::class, 'post', 'as' => 'achiever.student.create.post'])->name('achiever.student.create.post');
            Route::get('/update/{id}', [StudentUpdateController::class, 'get', 'as' => 'achiever.student.update.get'])->name('achiever.student.update.get');
            Route::post('/update/{id}', [StudentUpdateController::class, 'post', 'as' => 'achiever.student.update.post'])->name('achiever.student.update.post');
            Route::get('/delete/{id}', [StudentDeleteController::class, 'get', 'as' => 'achiever.student.delete.get'])->name('achiever.student.delete.get');
        });

    });

    Route::prefix('/event')->group(function () {

        Route::prefix('/speaker')->group(function () {
            Route::get('/', [SpeakerPaginateController::class, 'get', 'as' => 'event.speaker.paginate.get'])->name('event.speaker.paginate.get');
            Route::get('/create', [SpeakerCreateController::class, 'get', 'as' => 'event.speaker.create.get'])->name('event.speaker.create.get');
            Route::post('/create', [SpeakerCreateController::class, 'post', 'as' => 'event.speaker.create.post'])->name('event.speaker.create.post');
            Route::get('/update/{id}', [SpeakerUpdateController::class, 'get', 'as' => 'event.speaker.update.get'])->name('event.speaker.update.get');
            Route::post('/update/{id}', [SpeakerUpdateController::class, 'post', 'as' => 'event.speaker.update.post'])->name('event.speaker.update.post');
            Route::get('/delete/{id}', [SpeakerDeleteController::class, 'get', 'as' => 'event.speaker.delete.get'])->name('event.speaker.delete.get');
        });

        Route::prefix('/event')->group(function () {
            Route::get('/', [EventPaginateController::class, 'get', 'as' => 'event.event.paginate.get'])->name('event.event.paginate.get');
            Route::get('/create', [EventCreateController::class, 'get', 'as' => 'event.event.create.get'])->name('event.event.create.get');
            Route::post('/create', [EventCreateController::class, 'post', 'as' => 'event.event.create.post'])->name('event.event.create.post');
            Route::get('/update/{id}', [EventUpdateController::class, 'get', 'as' => 'event.event.update.get'])->name('event.event.update.get');
            Route::post('/update/{id}', [EventUpdateController::class, 'post', 'as' => 'event.event.update.post'])->name('event.event.update.post');
            Route::get('/delete/{id}', [EventDeleteController::class, 'get', 'as' => 'event.event.delete.get'])->name('event.event.delete.get');

            Route::prefix('/{event_id}')->group(function () {
                Route::prefix('/specification')->group(function () {
                    Route::get('/', [SpecificationPaginateController::class, 'get', 'as' => 'event.specification.paginate.get'])->name('event.specification.paginate.get');
                    Route::get('/create', [SpecificationCreateController::class, 'get', 'as' => 'event.specification.create.get'])->name('event.specification.create.get');
                    Route::post('/create', [SpecificationCreateController::class, 'post', 'as' => 'event.specification.create.post'])->name('event.specification.create.post');
                    Route::get('/update/{id}', [SpecificationUpdateController::class, 'get', 'as' => 'event.specification.update.get'])->name('event.specification.update.get');
                    Route::post('/update/{id}', [SpecificationUpdateController::class, 'post', 'as' => 'event.specification.update.post'])->name('event.specification.update.post');
                    Route::get('/delete/{id}', [SpecificationDeleteController::class, 'get', 'as' => 'event.specification.delete.get'])->name('event.specification.delete.get');
                });
            });
        });

    });

    Route::prefix('/campaign')->group(function () {
        Route::get('/', [CampaignPaginateController::class, 'get', 'as' => 'campaign.campaign.paginate.get'])->name('campaign.campaign.paginate.get');
        Route::get('/create', [CampaignCreateController::class, 'get', 'as' => 'campaign.campaign.create.get'])->name('campaign.campaign.create.get');
        Route::post('/create', [CampaignCreateController::class, 'post', 'as' => 'campaign.campaign.create.post'])->name('campaign.campaign.create.post');
        Route::get('/update/{id}', [CampaignUpdateController::class, 'get', 'as' => 'campaign.campaign.update.get'])->name('campaign.campaign.update.get');
        Route::post('/update/{id}', [CampaignUpdateController::class, 'post', 'as' => 'campaign.campaign.update.post'])->name('campaign.campaign.update.post');
        Route::get('/delete/{id}', [CampaignDeleteController::class, 'get', 'as' => 'campaign.campaign.delete.get'])->name('campaign.campaign.delete.get');

        Route::prefix('/{campaign_id}')->group(function () {
            Route::prefix('/enquiry')->group(function () {
                Route::get('/', [EnquiryPaginateController::class, 'get', 'as' => 'campaign.enquiry.paginate.get'])->name('campaign.enquiry.paginate.get');
                Route::get('/delete/{id}', [EnquiryDeleteController::class, 'get', 'as' => 'campaign.enquiry.delete.get'])->name('campaign.enquiry.delete.get');
            });
        });
    });

    Route::post('/text-editor-image', [TextEditorImageController::class, 'post', 'as' => 'texteditor_image.post'])->name('texteditor_image.post');
    Route::get('/logout', [LogoutController::class, 'get', 'as' => 'logout.get'])->name('logout.get');

});
