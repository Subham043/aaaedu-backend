<!doctype html>
    <html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="sm-hover" data-sidebar-image="none" data-preloader="disable" data-sidebar-visibility="show" data-layout-style="default" data-layout-mode="light" data-layout-width="fluid" data-layout-position="fixed">

    <head>

        <meta charset="utf-8" />
        <title>ARJUNAA ACADEMY FOR ACHIEVERS</title>

        <style nonce="{{ csp_nonce() }}">

            @page {
                margin:0px;
            }
            .text-center {
                text-align: center !important;
            }
            .bg-danger {
                --vz-bg-opacity: 1;
                background-color: #fa896b !important;
            }
            .bg-warning {
                --vz-bg-opacity: 1;
                background-color: #f7b84b !important;
            }
            .bg-primary {
                --vz-bg-opacity: 1;
                background-color: #74b107 !important;
            }
                        .py-2 {
                            padding-top: .5rem !important;
                            padding-bottom: .5rem !important;
                        }
                        h4 {
                            font-size: 1.3125rem;
                        }
                        .m-0 {
                            margin: 0 !important;
                        }
                        .text-light {
                            --vz-text-opacity: 1;
                            color: white !important;
                        }

            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .align-middle {
                vertical-align: middle !important;
            }
            .table {
                width: 100%;
                margin-bottom: 0;
                color: #222;
                vertical-align: top;
                border-color: #e9ebec;
            }
            table {
                caption-side: bottom;
                border-collapse: collapse;
            }
            .table .table-light {
                color: #212529;
                border-color: #e9ebec;
                background-color: #f3f6f9;
            }

            .table>thead {
                border-color: #e9ebec;
            }
            .table>thead {
                vertical-align: bottom;
            }
            .table-light {
                color: #000;
                border-color: #dbdde0;
            }
            .table-card td:first-child, .table-card th:first-child {
                padding-left: 16px;
            }
            .table-nowrap td, .table-nowrap th {
                white-space: nowrap;
                padding: 10px 5px;
                text-align: center;
            }
            .table th {
                font-weight: 600;
            }
            .table>:not(caption)>*>* {
                /* padding: .75rem .6rem; */
                background-color: #f3f6f9;
                border-bottom-width: 1px;
                -webkit-box-shadow: inset 0 0 0 9999px #00000000;
                box-shadow: inset 0 0 0 9999px #00000000;
            }
            .table-card .table>:not(:first-child) {
                border-top-width: 1px;
            }
            .table>:not(:first-child) {
                border-top-width: 1px;
            }
            .table>:not(:first-child) {
                border-top: 2px solid #e9ebec;
            }
            .table>tbody {
                vertical-align: inherit;
            }

            .card {
                margin-bottom: 1.5rem;
                -webkit-box-shadow: 0 1px 2px rgba(56,65,74,.15);
                box-shadow: 0 1px 2px #38414a26;
            }
            .card {
                position: relative;
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
                min-width: 0;
                word-wrap: break-word;
                background-color: var(--vz-card-bg);
                background-clip: border-box;
                border: 0 solid rgba(0, 0, 0, .125);
                border-radius: .25rem;
            }
            .logo{
                width: 270px;
                object-fit: contain;
                margin: auto;
                padding: 10px 5px;
                margin-bottom: 10px;
            }
            .card-body{
                margin-bottom: 10px;
            }

        </style>

    </head>

    <body>

        <!-- Begin page -->
        <div id="layout-wrapper">

             <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="logo-container text-center">
                                        <img src="https://www.aaaedu.in/_ipx/f_webp&q_80/images/logos/new-logo.webp" class="logo">
                                    </div>
                                    <div class="text-center bg-danger py-2">
                                        <h4 class="text-light m-0">TEST INFORMATION</h4>
                                    </div>
                                    <div class="card-body pb-0">
                                        <div>
                                            <div class="table-responsive table-card">
                                                <table class="table align-middle table-nowrap" id="customerTable" border="1">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="sort" data-sort="customer_name">Name</th>
                                                            <th class="sort" data-sort="customer_name">Test</th>
                                                            <th class="sort" data-sort="customer_name">Enrollment Type</th>
                                                            <th class="sort" data-sort="customer_name">Amount</th>
                                                            <th class="sort" data-sort="customer_name">Test Status</th>
                                                            </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">
                                                        <tr>
                                                            <td class="customer_name">{{ $report->user->name }}</td>
                                                            <td class="customer_name">{{ $report->test->name }}</td>
                                                            <td class="customer_name">{{ $report->enrollment_type }}</td>
                                                            <td class="customer_name">{{ $report->amount }}</td>
                                                            <td class="customer_name">{{ $report->test_status }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div><!-- end card -->

                                    <div class="text-center bg-warning py-2">
                                        <h4 class="text-light m-0">SUBJECT WISE EVALUATION</h4>
                                    </div>
                                    <div class="card-body pb-0">
                                        <div>
                                            <div class="table-responsive table-card">
                                                <table class="table align-middle table-nowrap" id="customerTable" border="1">
                                                    <thead class="table-light text-center">
                                                        <tr>
                                                            <th class="sort" data-sort="customer_name">Subject</th>
                                                            <th class="sort" data-sort="customer_name">Total Questions</th>
                                                            <th class="sort" data-sort="customer_name">Questions Attempted</th>
                                                            <th class="sort" data-sort="customer_name">Total Marks</th>
                                                            <th class="sort" data-sort="customer_name">Marks Alloted</th>
                                                            </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all text-center">
                                                        @foreach($subject_wise_score as $val)
                                                        <tr>
                                                            <td class="customer_name">{{ $val->name }}</td>
                                                            <td class="customer_name">{{ $val->number_of_question }}</td>
                                                            <td class="customer_name">{{ $val->attempt_count }}</td>
                                                            <td class="customer_name">{{ $val->total_mark_sum }}</td>
                                                            <td class="customer_name">{{ $val->total_mark_alloted_sum }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div><!-- end card -->

                                    <div class="text-center bg-primary py-2">
                                        <h4 class="text-light m-0">TOTAL EVALUATION</h4>
                                    </div>
                                    <div class="card-body pb-0">
                                        <div>
                                            <div class="table-responsive table-card">
                                                <table class="table align-middle table-nowrap" id="customerTable" border="1">
                                                    <thead class="table-light text-center">
                                                        <tr>
                                                            <th class="sort" data-sort="customer_name">Total Questions</th>
                                                            <th class="sort" data-sort="customer_name">Questions Attempted</th>
                                                            <th class="sort" data-sort="customer_name">Total Marks</th>
                                                            <th class="sort" data-sort="customer_name">Marks Alloted</th>
                                                            <th class="sort" data-sort="customer_name">Percentage</th>
                                                            <th class="sort" data-sort="customer_name">Grade</th>
                                                            </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all text-center">
                                                        <tr>
                                                            <td class="customer_name">{{ $total_question_count }}</td>
                                                            <td class="customer_name">{{ $total_answer_count }}</td>
                                                            <td class="customer_name">{{ $total_score }}</td>
                                                            <td class="customer_name">{{ $alloted_score }}</td>
                                                            <td class="customer_name">{{ $percentage }}</td>
                                                            <td class="customer_name">{{ $grade }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div><!-- end card -->

                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div>
                </div>


            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->


    </body>


</html>
