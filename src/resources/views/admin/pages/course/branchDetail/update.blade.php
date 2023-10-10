@extends('admin.layouts.dashboard')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('admin.includes.breadcrumb', ['page'=>$branch->name.' Detail', 'page_link'=>route('course.branch_detail.update.get', [$course_id, $branch_id]), 'list'=>['Update']])
        <!-- end page title -->

        <div class="row" id="image-container">
            @include('admin.includes.back_button', ['link'=>route('course.course.paginate.get')])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('course.branch_detail.update.post', [$course_id, $branch_id])}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">{{$course->name}} ({{$branch->name}}) Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-12 col-md-12">
                                        @include('admin.includes.quill', ['key'=>'description', 'label'=>'Description', 'value'=>!empty($data) ? (old('description') ? old('description') : $data->description) : old('description')])
                                    </div>

                                </div>
                                <!--end row-->
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">{{$course->name}} ({{$branch->name}}) Payment Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.input', ['key'=>'amount', 'label'=>'Amount', 'value'=>!empty($data) ? (old('amount') ? old('amount') : $data->amount) : old('amount')])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.input', ['key'=>'discount', 'label'=>'Discount', 'value'=>!empty($data) ? (old('discount') ? old('discount') : $data->discount) : old('discount')])
                                    </div>

                                </div>
                                <!--end row-->
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">{{$course->name}} ({{$branch->name}}) Testimonial Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.input', ['key'=>'testimonial_heading', 'label'=>'Heading', 'value'=>!empty($data) ? (old('testimonial_heading') ? old('testimonial_heading') : $data->testimonial_heading) : old('testimonial_heading')])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.select_multiple', ['key'=>'testimonial', 'label'=>'Testimonial'])
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="mt-4 mt-md-0">
                                            <div>
                                                <div class="form-check form-switch form-check-right mb-2">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="include_testimonial" name="include_testimonial" {{!empty($data) && $data->include_testimonial==false ? '' : 'checked'}}>
                                                    <label class="form-check-label" for="include_testimonial">Include Testimonial</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <!--end row-->
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">{{$course->name}} ({{$branch->name}}) Achiever Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.input', ['key'=>'achiever_heading', 'label'=>'Heading', 'value'=>!empty($data) ? (old('topper_heading') ? old('topper_heading') : $data->topper_heading) : old('topper_heading')])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.select_multiple', ['key'=>'achiever', 'label'=>'Achiever'])
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="mt-4 mt-md-0">
                                            <div>
                                                <div class="form-check form-switch form-check-right mb-2">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="include_achiever" name="include_achiever" {{!empty($data) && $data->include_topper==false ? '' : 'checked'}}>
                                                    <label class="form-check-label" for="include_achiever">Include Achiever</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <!--end row-->
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">{{$course->name}} ({{$branch->name}}) Staff Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.input', ['key'=>'staff_heading', 'label'=>'Heading', 'value'=>!empty($data) ? (old('staff_heading') ? old('staff_heading') : $data->staff_heading) : old('staff_heading')])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.select_multiple', ['key'=>'staff', 'label'=>'Staff'])
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="mt-4 mt-md-0">
                                            <div>
                                                <div class="form-check form-switch form-check-right mb-2">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="include_staff" name="include_staff" {{!empty($data) && $data->include_staff==false ? '' : 'checked'}}>
                                                    <label class="form-check-label" for="include_staff">Include Staff</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <!--end row-->
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">{{$course->name}} ({{$branch->name}}) Seo Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.textarea', ['key'=>'meta_title', 'label'=>'Meta Title', 'value'=>!empty($data) ? (old('meta_title') ? old('meta_title') : $data->meta_title) : old('meta_title')])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.textarea', ['key'=>'meta_keywords', 'label'=>'Meta Keywords', 'value'=>!empty($data) ? (old('meta_keywords') ? old('meta_keywords') : $data->meta_keywords) : old('meta_keywords')])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.textarea', ['key'=>'meta_description', 'label'=>'Meta Description', 'value'=>!empty($data) ? (old('meta_description') ? old('meta_description') : $data->meta_description) : old('meta_description')])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.textarea', ['key'=>'meta_scripts', 'label'=>'Meta Scripts', 'value'=>!empty($data) ? (old('meta_scripts') ? old('meta_scripts') : $data->meta_scripts) : old('meta_scripts')])
                                    </div>
                                    <div class="col-xxl-12 col-md-12">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" id="submitBtn">Update</button>
                                    </div>

                                </div>
                                <!--end row-->
                            </div>

                        </div>
                    </div>

                </form>
            </div>
            <!--end col-->
        </div>
        <!--end row-->



    </div> <!-- container-fluid -->
</div><!-- End Page-content -->



@stop


@section('javascript')
<script src="{{ asset('admin/js/pages/choices.min.js') }}"></script>

<script type="text/javascript" nonce="{{ csp_nonce() }}">

CKEDITOR.ClassicEditor
.create(document.getElementById("description_quill"), CKEDITOR_OPTIONS)
.then( newEditor => {
    editor = newEditor;
    editor.model.document.on( 'change:data', () => {
        document.getElementById('description').value = editor.getData()
    } );
});

// initialize the validation library
const validation = new JustValidate('#countryForm', {
      errorFieldCssClass: 'is-invalid',
});
// apply rules to form fields
validation
  .addField('#description', [
    {
        rule: 'required',
        errorMessage: 'Description Link is required',
    },
  ])
  .addField('#amount', [
    {
        rule: 'required',
        errorMessage: 'Amount is required',
    },
  ])
  .addField('#discount', [
    {
        rule: 'required',
        errorMessage: 'Discount is required',
    },
  ])
  .addField('#meta_title', [
    {
        validator: (value, fields) => true,
    },
  ])
  .addField('#meta_keywords', [
    {
        validator: (value, fields) => true,
    },
  ])
  .addField('#meta_description', [
    {
        validator: (value, fields) => true,
    },
  ])
  .addField('#meta_scripts', [
    {
        validator: (value, fields) => true,
    },
  ])
  .addField('#testimonial_heading', [
    {
        validator: (value, fields) => true,
    },
  ])
  .addField('#testimonial', [
    {
        validator: (value, fields) => true,
    },
  ])
  .addField('#achiever_heading', [
    {
        validator: (value, fields) => true,
    },
  ])
  .addField('#achiever', [
    {
        validator: (value, fields) => true,
    },
  ])
  .addField('#staff_heading', [
    {
        validator: (value, fields) => true,
    },
  ])
  .addField('#staff', [
    {
        validator: (value, fields) => true,
    },
  ])
  .onSuccess(async (event) => {
    var submitBtn = document.getElementById('submitBtn')
    submitBtn.innerHTML = spinner
    submitBtn.disabled = true;
    try {
        var formData = new FormData();
        formData.append('include_staff',document.getElementById('include_staff').checked ? 1 : 0)
        formData.append('include_topper',document.getElementById('include_achiever').checked ? 1 : 0)
        formData.append('include_testimonial',document.getElementById('include_testimonial').checked ? 1 : 0)
        formData.append('description',editor.getData())
        formData.append('description_unfiltered',editor.getData().replace(/<[^>]*>/g, ''))
        formData.append('amount',document.getElementById('amount').value)
        formData.append('discount',document.getElementById('discount').value)
        formData.append('meta_title',document.getElementById('meta_title').value)
        formData.append('meta_keywords',document.getElementById('meta_keywords').value)
        formData.append('meta_description',document.getElementById('meta_description').value)
        formData.append('meta_scripts',document.getElementById('meta_scripts').value)
        formData.append('staff_heading',document.getElementById('staff_heading').value)
        formData.append('testimonial_heading',document.getElementById('testimonial_heading').value)
        formData.append('topper_heading',document.getElementById('achiever_heading').value)

        if(document.getElementById('testimonial')?.length>0){
            for (let index = 0; index < document.getElementById('testimonial').length; index++) {
                formData.append('testimonial[]',document.getElementById('testimonial')[index].value)
            }
        }
        if(document.getElementById('achiever')?.length>0){
            for (let index = 0; index < document.getElementById('achiever').length; index++) {
                formData.append('achiever[]',document.getElementById('achiever')[index].value)
            }
        }
        if(document.getElementById('staff')?.length>0){
            for (let index = 0; index < document.getElementById('staff').length; index++) {
                formData.append('staff[]',document.getElementById('staff')[index].value)
            }
        }

        const response = await axios.post('{{route('course.branch_detail.update.post', [$course_id, $branch_id])}}', formData)
        successToast(response.data.message)
        setInterval(location.reload(), 1500);
    }catch (error){
        if(error?.response?.data?.errors?.description){
            validation.showErrors({'#description': error?.response?.data?.errors?.description[0]})
        }
        if(error?.response?.data?.errors?.amount){
            validation.showErrors({'#amount': error?.response?.data?.errors?.amount[0]})
        }
        if(error?.response?.data?.errors?.discount){
            validation.showErrors({'#discount': error?.response?.data?.errors?.discount[0]})
        }
        if(error?.response?.data?.errors?.meta_title){
            validation.showErrors({'#meta_title': error?.response?.data?.errors?.meta_title[0]})
        }
        if(error?.response?.data?.errors?.meta_keywords){
            validation.showErrors({'#meta_keywords': error?.response?.data?.errors?.meta_keywords[0]})
        }
        if(error?.response?.data?.errors?.meta_description){
            validation.showErrors({'#meta_description': error?.response?.data?.errors?.meta_description[0]})
        }
        if(error?.response?.data?.errors?.meta_scripts){
            validation.showErrors({'#meta_scripts': error?.response?.data?.errors?.meta_scripts[0]})
        }
        if(error?.response?.data?.errors?.achiever_heading){
            validation.showErrors({'#achiever_heading': error?.response?.data?.errors?.achiever_heading[0]})
        }
        if(error?.response?.data?.errors?.staff_heading){
            validation.showErrors({'#staff_heading': error?.response?.data?.errors?.staff_heading[0]})
        }
        if(error?.response?.data?.errors?.testimonial_heading){
            validation.showErrors({'#testimonial_heading': error?.response?.data?.errors?.testimonial_heading[0]})
        }
        if(error?.response?.data?.errors?.achiever){
            validation.showErrors({'#achiever': error?.response?.data?.errors?.achiever[0]})
        }
        if(error?.response?.data?.errors?.testimonial){
            validation.showErrors({'#testimonial': error?.response?.data?.errors?.testimonial[0]})
        }
        if(error?.response?.data?.errors?.staff){
            validation.showErrors({'#staff': error?.response?.data?.errors?.staff[0]})
        }
        if(error?.response?.data?.message){
            errorToast(error?.response?.data?.message)
        }
    }finally{
        submitBtn.innerHTML =  `
            Update
            `
        submitBtn.disabled = false;
    }
  });

  const testimonialChoice = new Choices('#testimonial', {
    choices: [
        @foreach($testimonial as $testimonial)
            {
                value: '{{$testimonial->id}}',
                label: '{{$testimonial->name}}~{{$testimonial->designation}}',
                selected: {{ (in_array($testimonial->id, $testimonials)) ? 'true' : 'false'}}
            },
        @endforeach
    ],
    placeholderValue: 'Select testimonials',
    ...CHOICE_CONFIG,
    shouldSort: false,
    shouldSortItems: false,
});
  const staffChoice = new Choices('#staff', {
    choices: [
        @foreach($staff as $staff)
            {
                value: '{{$staff->id}}',
                label: '{{$staff->name}}~{{$staff->designation}}',
                selected: {{ (in_array($staff->id, $staffs)) ? 'true' : 'false'}}
            },
        @endforeach
    ],
    placeholderValue: 'Select staffs',
    ...CHOICE_CONFIG,
    shouldSort: false,
    shouldSortItems: false,
});
  const achieverChoice = new Choices('#achiever', {
    choices: [
        @foreach($achiever as $achiever)
            {
                value: '{{$achiever->id}}',
                label: '{{$achiever->name}}~{{$achiever->college}}',
                selected: {{ (in_array($achiever->id, $achievers)) ? 'true' : 'false'}}
            },
        @endforeach
    ],
    placeholderValue: 'Select achievers',
    ...CHOICE_CONFIG,
    shouldSort: false,
    shouldSortItems: false,
});
</script>
@stop
