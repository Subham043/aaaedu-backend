@extends('admin.layouts.dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('admin.includes.breadcrumb', ['page'=>'Chatbot Enquiry', 'page_link'=>route('enquiry.chatbot_form.paginate.get'), 'list'=>['List']])
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Chatbot Enquiry</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div id="customerList">
                            <div class="row g-4 mb-3">
                                <div class="col-sm-auto">
                                    <a href="{{route('enquiry.chatbot_form.excel.get')}}" download type="button" class="btn btn-info add-btn" id="create-btn"><i class="ri-file-excel-fill align-bottom me-1"></i> Excel Download</a>
                                </div>
                                <div class="col-sm">
                                    @include('admin.includes.search_list', ['link'=>route('enquiry.chatbot_form.paginate.get'), 'search'=>$search])
                                </div>
                            </div>
                            <div class="table-responsive table-card mt-3 mb-1" id="image-container">
                                @if($data->total() > 0)
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="sort" data-sort="customer_name">Name</th>
                                            <th class="sort" data-sort="customer_name">Email</th>
                                            <th class="sort" data-sort="customer_name">Phone</th>
                                            <th class="sort" data-sort="customer_name">Multiple Choice Query</th>
                                            <th class="sort" data-sort="customer_name">Visit Question</th>
                                            <th class="sort" data-sort="customer_name">Admission Question</th>
                                            <th class="sort" data-sort="customer_name">Contact Question</th>
                                            <th class="sort" data-sort="customer_name">Course Branch Question</th>
                                            <th class="sort" data-sort="customer_name">Course Standard Question</th>
                                            <th class="sort" data-sort="customer_name">Course Name Question</th>
                                            <th class="sort" data-sort="customer_name">Final Callback Question</th>
                                            <th class="sort" data-sort="customer_name">Schedule Callback Question</th>
                                            <th class="sort" data-sort="customer_name">Status</th>
                                            <th class="sort" data-sort="customer_name">IP Address</th>
                                            <th class="sort" data-sort="customer_name">Country</th>
                                            <th class="sort" data-sort="customer_name">Laitude</th>
                                            <th class="sort" data-sort="customer_name">Longitude</th>
                                            <th class="sort" data-sort="customer_name">Browser</th>
                                            <th class="sort" data-sort="customer_name">System Type</th>
                                            <th class="sort" data-sort="customer_name">Page URL</th>
                                            <th class="sort" data-sort="date">Created On</th>
                                            <th class="sort" data-sort="action">Action</th>
                                            </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($data->items() as $item)
                                        <tr>
                                            <td class="customer_name">{{$item->name}}</td>
                                            <td class="customer_name">{{$item->email}}</td>
                                            <td class="customer_name">{{$item->phone}}</td>
                                            <td class="customer_name">{{$item->multiple_choice_query}}</td>
                                            <td class="customer_name">{{$item->visit_question}}</td>
                                            <td class="customer_name">{{$item->admission_question}}</td>
                                            <td class="customer_name">{{$item->contact_question}}</td>
                                            <td class="customer_name">{{$item->course_location_question}}</td>
                                            <td class="customer_name">{{$item->course_standard_question}}</td>
                                            <td class="customer_name">{{$item->school_course_question}}</td>
                                            <td class="customer_name">{{$item->final_callback_question}}</td>
                                            <td class="customer_name">{{$item->schedule_callback_question}}</td>
                                            <td class="customer_name">{{$item->status}}</td>
                                            <td class="customer_name">{{$item->ip_address}}</td>
                                            <td class="customer_name">{{$item->country}}</td>
                                            <td class="customer_name">{{$item->latitude}}</td>
                                            <td class="customer_name">{{$item->longitude}}</td>
                                            <td class="customer_name">{{$item->browser}}</td>
                                            <td class="customer_name">{{$item->is_mobile ? 'Mobile' : 'Desktop'}}</td>
                                            <td class="customer_name">{{$item->page_url}}</td>
                                            <td class="date">{{$item->created_at->diffForHumans()}}</td>
                                            <td>
                                                <div class="d-flex gap-2">

                                                    @can('delete enquiries')
                                                    <div class="remove">
                                                        <button class="btn btn-sm btn-danger remove-item-btn" data-link="{{route('enquiry.chatbot_form.delete.get', $item->id)}}">Delete</button>
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
