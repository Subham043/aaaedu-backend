@extends('admin.layouts.dashboard')

@section('css')

<style nonce="{{ csp_nonce() }}">

.pp-relative{
    position: relative;
}

.featured-badge {
  --badge-size: 4rem;
  height: var(--badge-size);
  width: var(--badge-size);
  position: absolute;
  right: 0;
  bottom: 5px;
}
/* add ribbons */
.featured-badge::before,
.featured-badge::after {
  content: '';
  position: absolute;
  top: 50%;
  width: calc(var(--badge-size) / 4);
  height: calc(var(--badge-size) * 0.75);
  background: #ff0000;
  border-width: 0 calc(var(--badge-size) / 16);
  border-color: #140037;
  border-style: solid;
  clip-path: polygon(0 0, 100% 0, 100% 100%, 50% 90%, 0% 100%);
}
.featured-badge::before {
  left: 0; transform: translateX(100%) rotate(25deg);
  z-index:1;
}
.featured-badge::after {
  right: 0; transform: translateX(-100%) rotate(-25deg);
  z-index: 1;
}
/* text */
.featured-badge span {
  position: absolute;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  width: var(--badge-size);
  height: var(--badge-size);
  font-size: calc(var(--badge-size) / 3);
  font-weight: bold;
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  background: #f0c808;
  box-shadow: 0.025em 0.025em 0.1em #303030;
  border-radius: 50%;
}
.feature-badge-color-1 span {
  background: #f0c808;
  background-color: #f0c808;
  z-index:2;
}
/* text area */
.featured-badge span::before {
  content: '';
  position: absolute;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  width: 85%; height: 85%;
  background: #c4a408;
  box-shadow: 0.025em 0.025em 0.1em #303030 inset;
  border-radius: 50%;
  z-index: -1;
}
.feature-badge-color-1 span::before {
  background: #c4a408;
  background-color: #c4a408;
}
</style>

@stop


@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('admin.includes.breadcrumb', ['page'=>'Test Taken', 'page_link'=>route('test.taken.paginate.get'), 'list'=>['Report']])
        <!-- end page title -->

        <div class="row">
            <div class="row g-4 mb-3 w-80">
                <div class="col-sm-auto">
                    <div>
                        <a href="{{route('test.taken.paginate.get')}}" type="button" class="btn btn-dark add-btn" id="create-btn"><i class="ri-arrow-go-back-line align-bottom me-1"></i> Go Back</a>
                    </div>
                </div>
                <div class="col-sm-auto mr-5">
                    <div>
                        <a href="{{route('test.taken.report.download', $report->id)}}" download="" type="button" class="btn btn-warning add-btn" id="create-btn"><i class="ri-file-download-line align-bottom me-1"></i> Download Report</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">

                    <div class="text-center bg-danger py-2 pp-relative">
                        <h4 class="text-light m-0">TEST INFO</h4>
                        <div class="featured-badge feature-badge-color-1">
                            <span>{{ $grade }}</span>
                        </div>
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
