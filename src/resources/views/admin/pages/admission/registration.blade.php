@extends('admin.layouts.dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('admin.includes.breadcrumb', ['page'=>'Admission Registration', 'page_link'=>route('admission.registration.paginate.get'), 'list'=>['List']])
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Admission Registration</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div id="customerList">
                            <div class="row g-4 mb-3">
                                <div class="col-sm-auto">
                                    <a href="{{route('admission.registration.excel.get')}}" download type="button" class="btn btn-info add-btn" id="create-btn"><i class="ri-file-excel-fill align-bottom me-1"></i> Excel Download</a>
                                </div>
                                <div class="col-sm">
                                    @include('admin.includes.search_list', ['link'=>route('admission.registration.paginate.get'), 'search'=>$search])
                                </div>
                            </div>
                            <div class="table-responsive table-card mt-3 mb-1" id="image-container">
                                @if($data->total() > 0)
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="sort" data-sort="customer_name">Name</th>
                                            <th class="sort" data-sort="customer_name">Email</th>
                                            <th class="sort" data-sort="customer_name">School Name</th>
                                            <th class="sort" data-sort="customer_name">Class</th>
                                            <th class="sort" data-sort="customer_name">Father's Name</th>
                                            <th class="sort" data-sort="customer_name">Father's Email</th>
                                            <th class="sort" data-sort="customer_name">Father's Phone</th>
                                            <th class="sort" data-sort="customer_name">Mother's Name</th>
                                            <th class="sort" data-sort="customer_name">Mother's Email</th>
                                            <th class="sort" data-sort="customer_name">Mother's Phone</th>
                                            <th class="sort" data-sort="customer_name">Program</th>
                                            <th class="sort" data-sort="customer_name">Mode</th>
                                            <th class="sort" data-sort="customer_name">Exam Center</th>
                                            <th class="sort" data-sort="customer_name">Exam Date</th>
                                            <th class="sort" data-sort="customer_name">Address</th>
                                            <th class="sort" data-sort="customer_name">Payment Status</th>
                                            <th class="sort" data-sort="customer_name">Image</th>
                                            <th class="sort" data-sort="date">Created On</th>
                                            <th class="sort" data-sort="action">Action</th>
                                            </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($data->items() as $item)
                                        <tr>
                                            <td class="customer_name">{{$item->name}}</td>
                                            <td class="customer_name">{{$item->email}}</td>
                                            <td class="customer_name">{{$item->school_name}}</td>
                                            <td class="customer_name">{{$item->class->value ?? 'N/A'}}</td>
                                            <td class="customer_name">{{$item->father_name}}</td>
                                            <td class="customer_name">{{$item->father_email}}</td>
                                            <td class="customer_name">{{$item->father_phone}}</td>
                                            <td class="customer_name">{{$item->mother_name}}</td>
                                            <td class="customer_name">{{$item->mother_email}}</td>
                                            <td class="customer_name">{{$item->mother_phone}}</td>
                                            <td class="customer_name">{{$item->program}}</td>
                                            <td class="customer_name">{{$item->mode->value ?? 'N/A'}}</td>
                                            <td class="customer_name">{{$item->exam_center}}</td>
                                            <td class="customer_name">{{$item->exam_date}}</td>
                                            <td class="customer_name">{{$item->address}}</td>
                                            <td class="customer_name">{{$item->payment_status->value ?? 'N/A'}}</td>
                                            <td class="customer_name">
                                                @if(!empty($item->image_link))
                                                    <img src="{{$item->image_link}}" alt="" class="img-preview">
                                                @endif
                                            </td>
                                            <td class="date">{{$item->created_at->diffForHumans()}}</td>
                                            <td>
                                                <div class="d-flex gap-2">

                                                    @if($item->payment_status->value == "PAID" && $item->mode->value == "OFFLINE")
                                                    <div class="edit">
                                                        <a href="{{route('admission.registration.download.get', $item->id)}}" download class="btn btn-sm btn-warning edit-item-btn">Hall Ticket</a>
                                                    </div>
                                                    @endif

                                                    @can('delete enquiries')
                                                    <div class="remove">
                                                        <button class="btn btn-sm btn-danger remove-item-btn" data-link="{{route('admission.registration.delete.get', $item->id)}}">Delete</button>
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


@section('javascript')
<script type="text/javascript" nonce="{{ csp_nonce() }}">
    const myViewer = new ImgPreviewer('#image-container',{
      // aspect ratio of image
        fillRatio: 0.9,
        // attribute that holds the image
        dataUrlKey: 'src',
        // additional styles
        style: {
            modalOpacity: 0.6,
            headerOpacity: 0,
            zIndex: 99
        },
        // zoom options
        imageZoom: {
            min: 0.1,
            max: 5,
            step: 0.1
        },
        // detect whether the parent element of the image is hidden by the css style
        bubblingLevel: 0,
    });
</script>
@stop
