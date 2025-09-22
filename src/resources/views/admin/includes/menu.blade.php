
            <!-- ========== App Menu ========== -->
            <div class="app-menu navbar-menu">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <!-- Dark Logo-->
                    <a href="{{route('dashboard.get')}}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('admin/images/logo-sm.png')}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('admin/images/logo.png') }}" alt="" height="17">
                        </span>
                    </a>
                    <!-- Light Logo-->
                    <a href="{{route('dashboard.get')}}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('admin/images/logo-sm.png')}}" alt="" height="30">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('admin/images/logo.png') }}" alt="" height="60">
                        </span>
                    </a>
                    <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                        <i class="ri-record-circle-line"></i>
                    </button>
                </div>

                <div id="scrollbar">
                    <div class="container-fluid">

                        <div id="two-column-menu">
                        </div>
                        <ul class="navbar-nav" id="navbar-nav">
                            <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('dashboard.get')) !== false ? 'active' : ''}}" href="{{route('dashboard.get')}}">
                                    <i class="ri-dashboard-fill"></i> <span data-key="t-widgets">Dashboard</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'enquiry') !== false ? 'active' : ''}}" href="#sidebarDashboards8" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'enquiry') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards8">
                                    <i class="ri-survey-line"></i> <span data-key="t-dashboards">Enquiries</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'enquiry') !== false ? 'show' : ''}}" id="sidebarDashboards8">
                                    <ul class="nav nav-sm flex-column">
                                        @can('list enquiries')
                                            <li class="nav-item">
                                                <a href="{{route('enquiry.contact_form.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('enquiry.contact_form.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Contact Form </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="{{route('enquiry.subscription_form.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('enquiry.subscription_form.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Subscription Form </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="{{route('enquiry.vrddhi_form.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('enquiry.vrddhi_form.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Vrddhi Form </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="{{route('enquiry.scholar_form.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('enquiry.scholar_form.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Day Scholar / Residential Form </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="{{route('enquiry.enrollment_form.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('enquiry.enrollment_form.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Enrollment Form </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="{{route('enquiry.courseRequest_form.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('enquiry.courseRequest_form.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Request Callback Form </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="{{route('enquiry.chatbot_form.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('enquiry.chatbot_form.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Chatbot </a>
                                            </li>
                                        @endcan

                                    </ul>
                                </div>
                            </li>

                            @can('list admissions')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'admission') !== false ? 'active' : ''}}" href="#sidebarDashboards9" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'admission') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards9">
                                    <i class="ri-mail-star-line"></i> <span data-key="t-dashboards">Admissions</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'admission') !== false ? 'show' : ''}}" id="sidebarDashboards9">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{route('admission.not_puc.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('admission.not_puc.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Class 8, 9, 10 Form </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('admission.puc.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('admission.puc.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> PUC Form </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('admission.registration.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('admission.registration.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Registration </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                            @endcan

                            @can('list roles')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('role.paginate.get')) !== false ? 'active' : ''}}" href="{{route('role.paginate.get')}}">
                                    <i class="ri-shield-user-fill"></i> <span data-key="t-widgets">Roles</span>
                                </a>
                            </li>
                            @endcan

                            @can('list users')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('user.paginate.get')) !== false ? 'active' : ''}}" href="{{route('user.paginate.get')}}">
                                    <i class="ri-user-add-fill"></i> <span data-key="t-widgets">Users</span>
                                </a>
                            </li>
                            @endcan

                            @can('list counters')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('counter.paginate.get')) !== false ? 'active' : ''}}" href="{{route('counter.paginate.get')}}">
                                    <i class="ri-timer-flash-line"></i> <span data-key="t-widgets">Counters</span>
                                </a>
                            </li>
                            @endcan

                            @can('list testimonials')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('testimonial.paginate.get')) !== false ? 'active' : ''}}" href="{{route('testimonial.paginate.get')}}">
                                    <i class="ri-chat-smile-3-line"></i> <span data-key="t-widgets">Testimonial</span>
                                </a>
                            </li>
                            @endcan

                            @can('list galleries')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('gallery.paginate.get')) !== false ? 'active' : ''}}" href="{{route('gallery.paginate.get')}}">
                                    <i class="ri-image-line"></i> <span data-key="t-widgets">Gallery</span>
                                </a>
                            </li>
                            @endcan

                            @can('list blogs')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'blog') !== false ? 'active' : ''}}" href="#sidebarDashboards12" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'blog') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards12">
                                    <i class="ri-article-line"></i> <span data-key="t-dashboards">Blogs</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'blog') !== false ? 'show' : ''}}" id="sidebarDashboards12">
                                    <ul class="nav nav-sm flex-column">
                                        @can('list blogs')
                                            <li class="nav-item">
                                                <a href="{{route('blog.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('blog.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Blogs </a>
                                            </li>
                                        @endcan

                                        @can('list blogs')
                                            <li class="nav-item">
                                                <a href="{{route('blog.comment.main_paginate.get')}}" class="nav-link {{strpos(url()->current(), route('blog.comment.main_paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Comments </a>
                                            </li>
                                        @endcan

                                    </ul>
                                </div>
                            </li>
                            @endcan

                            @can('list blogs')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'job-openings') !== false ? 'active' : ''}}" href="#sidebarDashboards13" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'job-openings') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards13">
                                    <i class="ri-user-star-fill"></i> <span data-key="t-dashboards">Job</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'job-openings') !== false ? 'show' : ''}}" id="sidebarDashboards13">
                                    <ul class="nav nav-sm flex-column">
                                        @can('list blogs')
                                            <li class="nav-item">
                                                <a href="{{route('job_opening.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('job_opening.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Openings </a>
                                            </li>
                                        @endcan

                                        @can('list blogs')
                                            <li class="nav-item">
                                                <a href="{{route('job_opening.job_enquiry.main_paginate.get')}}" class="nav-link {{strpos(url()->current(), route('job_opening.job_enquiry.main_paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Enquiries </a>
                                            </li>
                                        @endcan

                                    </ul>
                                </div>
                            </li>
                            @endcan

                            @can('list expert tips')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('expert_tip.paginate.get')) !== false ? 'active' : ''}}" href="{{route('expert_tip.paginate.get')}}">
                                    <i class="ri-sticky-note-line"></i> <span data-key="t-widgets">Expert Tips</span>
                                </a>
                            </li>
                            @endcan

                            @can('list faqs')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('faq.paginate.get')) !== false ? 'active' : ''}}" href="{{route('faq.paginate.get')}}">
                                    <i class="ri-questionnaire-line"></i> <span data-key="t-widgets">FAQs</span>
                                </a>
                            </li>
                            @endcan

                            @can('list tests')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'test') !== false ? 'active' : ''}}" href="#sidebarDashboards3" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'test') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards3">
                                    <i class="ri-a-b"></i> <span data-key="t-dashboards">Tests</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'test') !== false ? 'show' : ''}}" id="sidebarDashboards3">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{route('test.test.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('test.test.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Test </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('test.taken.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('test.taken.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Taken </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                            @endcan

                            @can('list legal pages')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('legal.paginate.get')) !== false ? 'active' : ''}}" href="{{route('legal.paginate.get')}}">
                                    <i class="ri-draft-line"></i> <span data-key="t-widgets">Legal Pages</span>
                                </a>
                            </li>
                            @endcan

                            @can('list features')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('feature.paginate.get', 'common')) !== false ? 'active' : ''}}" href="{{route('feature.paginate.get', 'common')}}">
                                    <i class="ri-function-line"></i> <span data-key="t-widgets">Feature</span>
                                </a>
                            </li>
                            @endcan

                            @can('list campaigns')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'campaign') !== false ? 'active' : ''}}" href="#sidebarDashboards11" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'campaign') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards11">
                                    <i class="ri-mail-volume-line"></i> <span data-key="t-dashboards">Campaigns</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'campaign') !== false ? 'show' : ''}}" id="sidebarDashboards11">
                                    <ul class="nav nav-sm flex-column">
                                        @can('list team member managements')
                                            <li class="nav-item">
                                                <a href="{{route('campaign.campaign.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('campaign.campaign.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Campaigns </a>
                                            </li>
                                        @endcan

                                        @can('list team member staffs')
                                            <li class="nav-item">
                                                <a href="{{route('campaign.enquiry.main_paginate.get')}}" class="nav-link {{strpos(url()->current(), route('campaign.enquiry.main_paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Enquiry </a>
                                            </li>
                                        @endcan

                                    </ul>
                                </div>
                            </li>
                            @endcan

                            @can('edit mission vision')
                                <li class="nav-item">
                                    <a href="{{route('mission.main.get')}}" class="nav-link menu-link {{strpos(url()->current(), route('mission.main.get')) !== false ? 'active' : ''}}" data-key="t-analytics">
                                        <i class="ri-focus-3-line"></i> <span data-key="t-widgets">Mission Vision</span>
                                    </a>
                                </li>
                            @endcan

                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'team-member') !== false ? 'active' : ''}}" href="#sidebarDashboards5" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'team-member') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards5">
                                    <i class="ri-group-line"></i> <span data-key="t-dashboards">Team Members</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'team-member') !== false ? 'show' : ''}}" id="sidebarDashboards5">
                                    <ul class="nav nav-sm flex-column">
                                        @can('list team member managements')
                                            <li class="nav-item">
                                                <a href="{{route('team_member.management.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('team_member.management.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Management </a>
                                            </li>
                                        @endcan

                                        @can('list team member staffs')
                                            <li class="nav-item">
                                                <a href="{{route('team_member.staff.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('team_member.staff.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Staffs </a>
                                            </li>
                                        @endcan

                                    </ul>
                                </div>
                            </li>

                            @can('list achievers')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'achiever') !== false ? 'active' : ''}}" href="#sidebarDashboards6" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'achiever') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards6">
                                    <i class="ri-user-follow-line"></i> <span data-key="t-dashboards">Achievers</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'achiever') !== false ? 'show' : ''}}" id="sidebarDashboards6">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{route('achiever.category.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('achiever.category.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Category </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{route('achiever.student.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('achiever.student.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Student </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                            @endcan

                            @can('list events')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'event') !== false ? 'active' : ''}}" href="#sidebarDashboards7" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'event') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards7">
                                    <i class="ri-calendar-event-line"></i> <span data-key="t-dashboards">Events</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'event') !== false ? 'show' : ''}}" id="sidebarDashboards7">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{route('event.speaker.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('event.speaker.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Speaker </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{route('event.event.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('event.event.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Events </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                            @endcan

                            @can('list courses')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'course') !== false || strpos(url()->current(),'branch') !== false ? 'active' : ''}}" href="#sidebarDashboards10" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'course') !== false || strpos(url()->current(),'branch') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards10">
                                    <i class="ri-book-open-line"></i> <span data-key="t-dashboards">Courses</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'course') !== false || strpos(url()->current(),'branch') !== false ? 'show' : ''}}" id="sidebarDashboards10">
                                    <ul class="nav nav-sm flex-column">

                                        <li class="nav-item">
                                            <a href="{{route('course.branch.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('course.branch.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Branches </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{route('course.course.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('course.course.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Courses </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                            @endcan

                            @can('list pages seo')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('seo.paginate.get')) !== false ? 'active' : ''}}" href="{{route('seo.paginate.get')}}">
                                    <i class="ri-ie-line"></i> <span data-key="t-widgets">Seo</span>
                                </a>
                            </li>
                            @endcan

                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'home-page') !== false ? 'active' : ''}}" href="#sidebarDashboards1" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'home-page') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards1">
                                    <i class="ri-home-4-line"></i> <span data-key="t-dashboards">Home Page</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'home-page') !== false ? 'show' : ''}}" id="sidebarDashboards1">
                                    <ul class="nav nav-sm flex-column">
                                        @can('list home page content')
                                            <li class="nav-item">
                                                <a href="{{route('home_page.banner.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('home_page.banner.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Banners Section </a>
                                            </li>
                                        @endcan

                                        @can('list about section content')
                                            <li class="nav-item">
                                                <a href="{{route('about.main.get', 'home-page')}}" class="nav-link {{strpos(url()->current(), route('about.main.get', 'home-page')) !== false ? 'active' : ''}}" data-key="t-analytics"> About Section </a>
                                            </li>
                                        @endcan

                                        @can('list features')
                                            <li class="nav-item">
                                                <a class="nav-link {{strpos(url()->current(),route('feature.paginate.get', 'home-page')) !== false ? 'active' : ''}}" href="{{route('feature.paginate.get', 'home-page')}}">
                                                    Feature
                                                </a>
                                            </li>
                                        @endcan

                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'about-page') !== false ? 'active' : ''}}" href="#sidebarDashboards4" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'about-page') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards4">
                                    <i class="ri-slideshow-line"></i> <span data-key="t-dashboards">About Page</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'about-page') !== false ? 'show' : ''}}" id="sidebarDashboards4">
                                    <ul class="nav nav-sm flex-column">
                                        @can('list about section content')
                                            <li class="nav-item">
                                                <a href="{{route('about.main.get', 'about-page')}}" class="nav-link {{strpos(url()->current(), route('about.main.get', 'about-page')) !== false ? 'active' : ''}}" data-key="t-analytics"> About Section </a>
                                            </li>
                                        @endcan

                                        @can('list features')
                                            <li class="nav-item">
                                                <a class="nav-link {{strpos(url()->current(),route('feature.paginate.get', 'about-page')) !== false ? 'active' : ''}}" href="{{route('feature.paginate.get', 'about-page')}}">
                                                    Feature
                                                </a>
                                            </li>
                                        @endcan

                                    </ul>
                                </div>
                            </li>


                            {{-- <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'setting') !== false ? 'active' : ''}}" href="#sidebarDashboards3" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'setting') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards3">
                                    <i class="ri-tools-line"></i> <span data-key="t-dashboards">Application Settings</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'setting') !== false ? 'show' : ''}}" id="sidebarDashboards3">
                                    <ul class="nav nav-sm flex-column">
                                        @can('view general settings detail')
                                            <li class="nav-item">
                                                <a href="{{route('general.settings.get')}}" class="nav-link {{strpos(url()->current(), route('general.settings.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> General </a>
                                            </li>
                                        @endcan

                                        @can('update sitemap')
                                            <li class="nav-item">
                                                <a href="{{route('sitemap.get')}}" class="nav-link {{strpos(url()->current(), route('sitemap.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Sitemap </a>
                                            </li>
                                        @endcan

                                    </ul>
                                </div>
                            </li> --}}

                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'logs') !== false ? 'active' : ''}}" href="#sidebarDashboards2" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'logs') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards2">
                                    <i class="ri-alarm-warning-line"></i> <span data-key="t-dashboards">Application Logs</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'logs') !== false ? 'show' : ''}}" id="sidebarDashboards2">
                                    <ul class="nav nav-sm flex-column">
                                        @can('list activity logs')
                                            <li class="nav-item">
                                                <a href="{{route('activity_log.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('activity_log.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Activity Logs </a>
                                            </li>
                                        @endcan

                                        @can('view application error logs')
                                            <li class="nav-item">
                                                <a href="{{route('error_log.get')}}" class="nav-link {{strpos(url()->current(), route('error_log.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Error Logs </a>
                                            </li>
                                        @endcan

                                    </ul>
                                </div>
                            </li>

                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->
            <!-- Vertical Overlay-->
            <div class="vertical-overlay"></div>
