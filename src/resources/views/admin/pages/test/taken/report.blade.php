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

                    <div class="text-center bg-danger py-2">
                        <h4 class="text-light m-0">TEST INFO</h4>
                    </div>
                    <div class="card-body pb-0">
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

                    <div class="text-center bg-warning py-2">
                        <h4 class="text-light m-0">SUBJECT WISE EVALUATION</h4>
                    </div>
                    <div class="card-body pb-0">
                        <div id="customerList">
                            <div class="table-responsive table-card">
                                <table class="table align-middle table-nowrap" id="customerTable">
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
                    <div class="w-100 p-2 d-flex justify-content-center">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <canvas id="subject-wise-id"></canvas>
                        </div>
                    </div>

                    <div class="text-center bg-primary py-2">
                        <h4 class="text-light m-0">TOTAL EVALUATION</h4>
                    </div>
                    <div class="card-body pb-0">
                        <div id="customerList">
                            <div class="table-responsive table-card">
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th class="sort" data-sort="customer_name">Total Questions</th>
                                            <th class="sort" data-sort="customer_name">Questions Attempted</th>
                                            <th class="sort" data-sort="customer_name">Total Marks</th>
                                            <th class="sort" data-sort="customer_name">Marks Alloted</th>
                                            </tr>
                                    </thead>
                                    <tbody class="list form-check-all text-center">
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

                    <div class="w-100 p-2 d-flex justify-content-center">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <canvas id="total-wise-id"></canvas>
                        </div>
                    </div>

                </div>
                <!-- end col -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </div>
</div>

@stop

@section('javascript')
<script src="{{ asset('admin/js/pages/plugins/chart.umd.min.js') }}"></script>
<script type="text/javascript" nonce="{{ csp_nonce() }}">
    const subject_wise_score_data = @json($subject_wise_score);
    const labels = subject_wise_score_data.map(item => item.name);
    const data = {
        labels: labels,
        datasets: [{
            label: 'Subject Wise Evaluation (%)',
            data: subject_wise_score_data.map(item => ((item.total_mark_alloted_sum / item.total_mark_sum)*100).toFixed(2)),
        }]
    };
    const config = {
        type: 'bar',
        data: data,
        options: {
            // indexAxis: 'y',
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    beginAtZero: true,
                    stacked: true
                }
            }
        },
    };
    new Chart(document.getElementById('subject-wise-id'), config);

    const total_data = {{$total_score}};
    const alloted_data = {{$alloted_score}};
    const data2 = {
        labels: [
            'Total %',
            'Alloted %'
        ],
        datasets: [{
            label: 'Total Evaluation (%)',
            data: [
                ((total_data/total_data)*100).toFixed(2),
                ((alloted_data/total_data)*100).toFixed(2)
            ],
        }]
    };
    const config2 = {
        type: 'pie',
        data: data2,
    };
    new Chart(document.getElementById('total-wise-id'), config2);
</script>
@stop
