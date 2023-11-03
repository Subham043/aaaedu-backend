@extends('admin.layouts.dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('admin.includes.breadcrumb', ['page'=>'Test Quiz', 'page_link'=>route('test.quiz.paginate.get', $test_id), 'list'=>['List']])
        <!-- end page title -->

        <div class="row">
            @include('admin.includes.back_button', ['link'=>route('test.test.paginate.get')])
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Test Quiz</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div id="customerList">
                            <div class="row g-4 mb-3">
                                <div class="col-sm-auto">
                                    <div>
                                        @can('create tests')
                                        <a href="{{route('test.quiz.create.get', $test_id)}}" type="button" class="btn btn-success add-btn" id="create-btn"><i class="ri-add-line align-bottom me-1"></i> Create</a>
                                        @endcan
                                    </div>
                                </div>
                                <div class="col-sm">
                                    @include('admin.includes.search_list', ['link'=>route('test.quiz.paginate.get', $test_id), 'search'=>$search])
                                </div>
                            </div>
                            <div class="table-responsive table-card mt-3 mb-1">
                                @if($data->total() > 0)
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="sort" data-sort="customer_name">Question</th>
                                            <th class="sort" data-sort="customer_name">Marks</th>
                                            <th class="sort" data-sort="customer_name">Duration</th>
                                            <th class="sort" data-sort="customer_name">Difficulty</th>
                                            <th class="sort" data-sort="customer_name">Correct Answer</th>
                                            <th class="sort" data-sort="customer_name">Subject</th>
                                            <th class="sort" data-sort="date">Created On</th>
                                            <th class="sort" data-sort="action">Action</th>
                                            </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($data->items() as $item)
                                        <tr>
                                            <td class="customer_name">{{ Str::limit($item->question_unfiltered, 20) }}</td>
                                            <td class="customer_name">{{ $item->mark }}</td>
                                            <td class="customer_name">{{ $item->duration }} mins</td>
                                            <td class="customer_name">{{ $item->difficulty }}</td>
                                            <td class="customer_name">{{ $item->correct_answer }}</td>
                                            <td class="customer_name">{{ $item->subject->name }}</td>
                                            <td class="date">{{$item->created_at->diffForHumans()}}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    @can('edit tests')
                                                    <div class="edit">
                                                        <a href="{{route('test.quiz.update.get', [$test_id, $item->id])}}" class="btn btn-sm btn-primary edit-item-btn">Edit</a>
                                                    </div>
                                                    @endcan

                                                    @can('delete tests')
                                                    <div class="remove">
                                                        <button class="btn btn-sm btn-danger remove-item-btn" data-link="{{route('test.quiz.delete.get', [$test_id, $item->id])}}">Delete</button>
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
