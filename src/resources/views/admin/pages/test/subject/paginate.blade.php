@extends('admin.layouts.dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('admin.includes.breadcrumb', ['page'=>'Test Subject', 'page_link'=>route('test.subject.paginate.get', $test_id), 'list'=>['List']])
        <!-- end page title -->

        <div class="row">
            @include('admin.includes.back_button', ['link'=>route('test.test.paginate.get')])
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Test Subject</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div id="customerList">
                            <div class="row g-4 mb-3">
                                <div class="col-sm-auto">
                                    <div>
                                        @can('create tests')
                                        <a href="{{route('test.subject.create.get', $test_id)}}" type="button" class="btn btn-success add-btn" id="create-btn"><i class="ri-add-line align-bottom me-1"></i> Create</a>
                                        @endcan
                                    </div>
                                </div>
                                <div class="col-sm">
                                    @include('admin.includes.search_list', ['link'=>route('test.subject.paginate.get', $test_id), 'search'=>$search])
                                </div>
                            </div>
                            <div class="table-responsive table-card mt-3 mb-1">
                                @if($data->total() > 0)
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="sort" data-sort="customer_name">Name</th>
                                            <th class="sort" data-sort="date">Created On</th>
                                            <th class="sort" data-sort="action">Action</th>
                                            </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($data->items() as $item)
                                        <tr>
                                            <td class="customer_name">{{ $item->name }}</td>
                                            <td class="date">{{$item->created_at->diffForHumans()}}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    @can('edit tests')
                                                    <div class="edit">
                                                        <a href="{{route('test.subject.update.get', [$test_id, $item->id])}}" class="btn btn-sm btn-primary edit-item-btn">Edit</a>
                                                    </div>
                                                    @endcan

                                                    @can('delete tests')
                                                    <div class="remove">
                                                        <button class="btn btn-sm btn-danger remove-item-btn" data-link="{{route('test.subject.delete.get', [$test_id, $item->id])}}">Delete</button>
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
