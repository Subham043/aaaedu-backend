@extends('admin.layouts.dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('admin.includes.breadcrumb', ['page'=>'Test Taken', 'page_link'=>route('test.taken.paginate.get'), 'list'=>['Report']])
        <!-- end page title -->

        <div class="row">
            @include('admin.includes.back_button', ['link'=>route('test.taken.paginate.get')])
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Test Report</h4>
                    </div><!-- end card header -->

                    <div class="text-center bg-dark py-2">
                        <h4 class="text-light m-0">TEST INFO</h4>
                    </div>
                    <div class="card-body">
                        <div id="customerList">
                            <div class="table-responsive table-card">
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="sort" data-sort="customer_name">Test Name</th>
                                            <th class="sort" data-sort="customer_name">User Name</th>
                                            <th class="sort" data-sort="customer_name">User Email</th>
                                            <th class="sort" data-sort="customer_name">User Phone</th>
                                            <th class="sort" data-sort="customer_name">Enrollment Type</th>
                                            <th class="sort" data-sort="customer_name">Amount</th>
                                            <th class="sort" data-sort="customer_name">Test Status</th>
                                            <th class="sort" data-sort="date">Created On</th>
                                            </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        <tr>
                                            <td class="customer_name">{{ $report->test->name }}</td>
                                            <td class="customer_name">{{ $report->user->name }}</td>
                                            <td class="customer_name">{{ $report->user->email }}</td>
                                            <td class="customer_name">{{ $report->user->phone }}</td>
                                            <td class="customer_name">{{ $report->enrollment_type }}</td>
                                            <td class="customer_name">{{ $report->amount }}</td>
                                            <td class="customer_name">{{ $report->test_status }}</td>
                                            <td class="date">{{$report->created_at->diffForHumans()}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- end card -->

                    <div class="text-center bg-dark py-2">
                        <h4 class="text-light m-0">SUBJECT WISE EVALUATION</h4>
                    </div>
                    <div class="card-body">
                        <div id="customerList">
                            <div class="table-responsive table-card">
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="sort" data-sort="customer_name">Subject</th>
                                            <th class="sort" data-sort="customer_name">Total Questions</th>
                                            <th class="sort" data-sort="customer_name">Questions Attempted</th>
                                            <th class="sort" data-sort="customer_name">Total Marks</th>
                                            <th class="sort" data-sort="customer_name">Marks Alloted</th>
                                            </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach($subject_wise_score as $subject_wise_score)
                                        <tr>
                                            <td class="customer_name">{{ $subject_wise_score->name }}</td>
                                            <td class="customer_name">{{ $subject_wise_score->number_of_question }}</td>
                                            <td class="customer_name">{{ $subject_wise_score->attempt_count }}</td>
                                            <td class="customer_name">{{ $subject_wise_score->total_mark_sum }}</td>
                                            <td class="customer_name">{{ $subject_wise_score->total_mark_alloted_sum }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- end card -->

                    <div class="text-center bg-dark py-2">
                        <h4 class="text-light m-0">TOTAL EVALUATION</h4>
                    </div>
                    <div class="card-body">
                        <div id="customerList">
                            <div class="table-responsive table-card mb-1">
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="sort" data-sort="customer_name">Total Questions</th>
                                            <th class="sort" data-sort="customer_name">Questions Attempted</th>
                                            <th class="sort" data-sort="customer_name">Total Marks</th>
                                            <th class="sort" data-sort="customer_name">Marks Alloted</th>
                                            </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        <tr>
                                            <td class="customer_name">{{ $total_question_count }}</td>
                                            <td class="customer_name">{{ $total_answer_count }}</td>
                                            <td class="customer_name">{{ $total_score }}</td>
                                            <td class="customer_name">{{ $alloted_score }}</td>
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

@stop
