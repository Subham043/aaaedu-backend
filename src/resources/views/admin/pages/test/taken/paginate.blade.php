@extends('admin.layouts.dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('admin.includes.breadcrumb', ['page'=>'Test Taken', 'page_link'=>route('test.taken.paginate.get'), 'list'=>['List']])
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Test Taken</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div id="customerList">
                            <div class="row g-4 mb-3">
                                <div class="col-sm-auto">
                                </div>
                                <div class="col-sm">
                                    @include('admin.includes.search_list', ['link'=>route('test.taken.paginate.get'), 'search'=>$search])
                                </div>
                            </div>
                            <div class="table-responsive table-card mt-3 mb-1">
                                @if($data->total() > 0)
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="sort" data-sort="customer_name">Test Name</th>
                                            <th class="sort" data-sort="customer_name">Test For Admission</th>
                                            <th class="sort" data-sort="customer_name">User Name</th>
                                            <th class="sort" data-sort="customer_name">User Email</th>
                                            <th class="sort" data-sort="customer_name">User Phone</th>
                                            <th class="sort" data-sort="customer_name">Enrollment Type</th>
                                            <th class="sort" data-sort="customer_name">Amount</th>
                                            <th class="sort" data-sort="customer_name">Test Status</th>
                                            <th class="sort" data-sort="customer_name">Reason</th>
                                            <th class="sort" data-sort="date">Created On</th>
                                            <th class="sort" data-sort="action">Action</th>
                                            </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($data->items() as $item)
                                        <tr>
                                            <td class="customer_name">{{ $item->test->name }}</td>
                                            @if($item->test->is_admission == 1)
                                            <td class="status"><span class="badge badge-soft-success text-uppercase">Yes</span></td>
                                            @else
                                            <td class="status"><span class="badge badge-soft-danger text-uppercase">No</span></td>
                                            @endif
                                            <td class="customer_name">{{ $item->user->name }}</td>
                                            <td class="customer_name">{{ $item->user->email }}</td>
                                            <td class="customer_name">{{ $item->user->phone }}</td>
                                            <td class="customer_name">{{ $item->enrollment_type }}</td>
                                            <td class="customer_name">{{ $item->amount }}</td>
                                            <td class="customer_name">{{ $item->test_status }}</td>
                                            <td class="customer_name">{{ $item->reason }}</td>
                                            <td class="date">{{$item->created_at->diffForHumans()}}</td>
                                            <td>
                                                <div class="d-flex gap-2">

                                                    @if($item->test_status->value=='Completed')
                                                    <div class="edit">
                                                        <a href="{{route('test.taken.report.get', $item->id)}}" class="btn btn-sm btn-warning edit-item-btn">Report</a>
                                                    </div>

                                                    <div class="edit">
                                                        <a href="{{route('test.taken.report.download', $item->id)}}" download class="btn btn-sm btn-dark edit-item-btn">Download Report</a>
                                                    </div>
                                                    @endif

                                                    @can('delete tests')
                                                    <div class="remove">
                                                        <button class="btn btn-sm btn-danger remove-item-btn" data-link="{{route('test.taken.delete.get', $item->id)}}">Delete</button>
                                                    </div>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                @else
                                    @include('admin.includes.no_result')
                                @endif
                            </div>
                            {{$data->onEachSide(5)->links('admin.includes.pagination')}}
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
