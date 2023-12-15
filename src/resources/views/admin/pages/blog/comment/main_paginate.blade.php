@extends('admin.layouts.dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('admin.includes.breadcrumb', ['page'=>'Comment', 'page_link'=>route('blog.comment.main_paginate.get'), 'list'=>['List']])
        <!-- end page title -->

        <div class="row">
            @include('admin.includes.back_button', ['link'=>route('blog.paginate.get')])
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Comments</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div id="customerList">
                            <div class="row g-4 mb-3">
                                <div class="col-sm-auto">
                                    <div>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    @include('admin.includes.search_list', ['link'=>route('blog.comment.main_paginate.get'), 'search'=>$search])
                                </div>
                            </div>
                            <div class="table-responsive table-card mt-3 mb-1">
                                @if($data->total() > 0)
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="sort" data-sort="customer_name">Name</th>
                                            <th class="sort" data-sort="customer_name">Email</th>
                                            <th class="sort" data-sort="customer_name">Comment</th>
                                            <th class="sort" data-sort="customer_name">Blog Name</th>
                                            <th class="sort" data-sort="customer_name">Approved</th>
                                            <th class="sort" data-sort="date">Created On</th>
                                            <th class="sort" data-sort="action">Action</th>
                                            </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($data->items() as $item)
                                        <tr>
                                            <td class="customer_name">{{ $item->name }}</td>
                                            <td class="customer_name">{{ $item->email }}</td>
                                            <td class="customer_name">{{ $item->comment }}</td>
                                            <td class="customer_name">{{ $item->blog->name }}</td>
                                            @if($item->is_approved == 1)
                                            <td class="status"><span class="badge badge-soft-success text-uppercase">Yes</span></td>
                                            @else
                                            <td class="status"><span class="badge badge-soft-danger text-uppercase">No</span></td>
                                            @endif
                                            <td class="date">{{$item->created_at->diffForHumans()}}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    @can('edit events')
                                                    <div class="remove">
                                                        <button class="btn btn-sm btn-primary remove-item-btn" data-link="{{route('blog.comment.update.get', [$item->blog->id, $item->id])}}">
                                                            @if($item->is_approved)
                                                                Disapprove
                                                            @else
                                                                Approve
                                                            @endif
                                                        </button>
                                                    </div>
                                                    @endcan

                                                    @can('delete events')
                                                    <div class="remove">
                                                        <button class="btn btn-sm btn-danger remove-item-btn" data-link="{{route('blog.comment.delete.get', [$item->blog->id, $item->id])}}">Delete</button>
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
