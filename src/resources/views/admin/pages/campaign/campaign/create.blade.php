@extends('admin.layouts.dashboard')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @can('list campaigns')
        @include('admin.includes.breadcrumb', ['page'=>'Campaign', 'page_link'=>route('campaign.campaign.paginate.get'), 'list'=>['Create']])
        @endcan
        <!-- end page title -->

        <div class="row">
            @include('admin.includes.back_button', ['link'=>route('campaign.campaign.paginate.get')])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('campaign.campaign.create.post')}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Campaign Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'name', 'label'=>'Name', 'value'=>old('name')])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'heading', 'label'=>'Heading', 'value'=>old('heading')])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'slug', 'label'=>'Slug', 'value'=>old('slug')])
                                    </div>
                                    <div class="col-xxl-12 col-md-12">
                                        @include('admin.includes.quill', ['key'=>'description', 'label'=>'Description', 'value'=>old('description')])
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="mt-4 mt-md-0">
                                            <div>
                                                <div class="form-check form-switch form-check-right mb-2">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" checked>
                                                    <label class="form-check-label" for="is_active">Campaign Status</label>
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
                        <div class="card-header align-items-center d-flex justify-content-between">
                            <h4 class="card-title mb-0">Campaign Testimonial</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4" id="image_row">
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.input', ['key'=>'testimonial_heading', 'label'=>'Heading', 'value'=>old('testimonial_heading')])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.select_multiple', ['key'=>'testimonial', 'label'=>'Testimonials'])
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="mt-4 mt-md-0">
                                            <div>
                                                <div class="form-check form-switch form-check-right mb-2">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="include_testimonial" name="include_testimonial" checked>
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
                        <div class="card-header align-items-center d-flex justify-content-between">
                            <h4 class="card-title mb-0">Campaign Achiever</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4" id="image_row">
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.input', ['key'=>'achiever_heading', 'label'=>'Heading', 'value'=>old('topper_heading')])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.select_multiple', ['key'=>'achiever', 'label'=>'Achievers'])
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="mt-4 mt-md-0">
                                            <div>
                                                <div class="form-check form-switch form-check-right mb-2">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="include_achiever" name="include_achiever" checked>
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
                        <div class="card-header align-items-center d-flex justify-content-between">
                            <h4 class="card-title mb-0">Campaign Form</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4" id="image_row">
                                    <div class="col-xxl-12 col-md-12">
                                        @include('admin.includes.input', ['key'=>'form_heading', 'label'=>'Heading', 'value'=>old('form_heading')])
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="mt-4 mt-md-0">
                                            <div>
                                                <div class="form-check form-switch form-check-right mb-2">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="include_form" name="include_form" checked>
                                                    <label class="form-check-label" for="include_form">Include Form</label>
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
                        <div class="card-header align-items-center d-flex justify-content-between">
                            <h4 class="card-title mb-0">Campaign Image</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4" id="image_row">
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.file_input', ['key'=>'image', 'label'=>'Image'])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'image_alt', 'label'=>'Image Alt', 'value'=>old('image_alt')])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'image_title', 'label'=>'Image Title', 'value'=>old('image_title')])
                                    </div>

                                </div>
                                <!--end row-->
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Campaign Seo Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.textarea', ['key'=>'meta_title', 'label'=>'Meta Title', 'value'=>old('meta_title')])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.textarea', ['key'=>'meta_keywords', 'label'=>'Meta Keywords', 'value'=>old('meta_keywords')])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.textarea', ['key'=>'meta_description', 'label'=>'Meta Description', 'value'=>old('meta_description')])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.textarea', ['key'=>'meta_scripts', 'label'=>'Meta Script', 'value'=>old('meta_scripts')])
                                    </div>
                                    <div class="col-xxl-12 col-md-12">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" id="submitBtn">Create</button>
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
  .addField('#name', [
    {
      rule: 'required',
      errorMessage: 'Name is required',
    },
    {
        rule: 'customRegexp',
        value: COMMON_REGEX,
        errorMessage: 'Name is invalid',
    },
  ])
  .addField('#slug', [
    {
      rule: 'required',
      errorMessage: 'Slug is required',
    },
    {
        rule: 'customRegexp',
        value: COMMON_REGEX,
        errorMessage: 'Slug is invalid',
    },
  ])
  .addField('#heading', [
    {
        rule: 'customRegexp',
        value: COMMON_REGEX,
        errorMessage: 'Heading is invalid',
    },
  ])
  .addField('#description', [
    {
        rule: 'required',
        errorMessage: 'Description is required',
    },
  ])
  .addField('#image', [
    {
        rule: 'minFilesCount',
        value: 0,
    },
    {
        rule: 'maxFilesCount',
        value: 1,
    },
    {
        rule: 'files',
        value: {
        files: {
            extensions: ['jpeg', 'jpg', 'png', 'webp'],
            maxSize: 500000,
            minSize: 1,
            types: ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'],
        },
        },
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
  .addField('#image_title', [
    {
        validator: (value, fields) => true,
    },
  ])
  .addField('#image_alt', [
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
  .addField('#form_heading', [
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
        formData.append('is_active',document.getElementById('is_active').checked ? 1 : 0)
        formData.append('include_form',document.getElementById('include_form').checked ? 1 : 0)
        formData.append('include_topper',document.getElementById('include_achiever').checked ? 1 : 0)
        formData.append('include_testimonial',document.getElementById('include_testimonial').checked ? 1 : 0)
        formData.append('name',document.getElementById('name').value)
        formData.append('slug',document.getElementById('slug').value)
        formData.append('heading',document.getElementById('heading').value)
        formData.append('description',editor.getData())
        formData.append('description_unfiltered',editor.getData().replace(/<[^>]*>/g, ''))
        formData.append('meta_title',document.getElementById('meta_title').value)
        formData.append('meta_keywords',document.getElementById('meta_keywords').value)
        formData.append('meta_description',document.getElementById('meta_description').value)
        formData.append('meta_scripts',document.getElementById('meta_scripts').value)
        formData.append('image_title',document.getElementById('image_title').value)
        formData.append('image_alt',document.getElementById('image_alt').value)
        formData.append('form_heading',document.getElementById('form_heading').value)
        formData.append('testimonial_heading',document.getElementById('testimonial_heading').value)
        formData.append('topper_heading',document.getElementById('achiever_heading').value)
        if((document.getElementById('image').files).length>0){
            formData.append('image',document.getElementById('image').files[0])
        }
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

        const response = await axios.post('{{route('campaign.campaign.create.post')}}', formData)
        successToast(response.data.message)
        event.target.reset();
    }catch (error){
        if(error?.response?.data?.errors?.name){
            validation.showErrors({'#name': error?.response?.data?.errors?.name[0]})
        }
        if(error?.response?.data?.errors?.achiever_heading){
            validation.showErrors({'#achiever_heading': error?.response?.data?.errors?.achiever_heading[0]})
        }
        if(error?.response?.data?.errors?.form_heading){
            validation.showErrors({'#form_heading': error?.response?.data?.errors?.form_heading[0]})
        }
        if(error?.response?.data?.errors?.testimonial_heading){
            validation.showErrors({'#testimonial_heading': error?.response?.data?.errors?.testimonial_heading[0]})
        }
        if(error?.response?.data?.errors?.slug){
            validation.showErrors({'#slug': error?.response?.data?.errors?.slug[0]})
        }
        if(error?.response?.data?.errors?.heading){
            validation.showErrors({'#heading': error?.response?.data?.errors?.heading[0]})
        }
        if(error?.response?.data?.errors?.description){
            validation.showErrors({'#description': error?.response?.data?.errors?.description[0]})
        }
        if(error?.response?.data?.errors?.image){
            validation.showErrors({'#image': error?.response?.data?.errors?.image[0]})
        }
        if(error?.response?.data?.errors?.image_title){
            validation.showErrors({'#image_title': error?.response?.data?.errors?.image_title[0]})
        }
        if(error?.response?.data?.errors?.image_alt){
            validation.showErrors({'#image_alt': error?.response?.data?.errors?.image_alt[0]})
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
        if(error?.response?.data?.errors?.achiever){
            validation.showErrors({'#achiever': error?.response?.data?.errors?.achiever[0]})
        }
        if(error?.response?.data?.errors?.testimonial){
            validation.showErrors({'#testimonial': error?.response?.data?.errors?.testimonial[0]})
        }
        if(error?.response?.data?.message){
            errorToast(error?.response?.data?.message)
        }
    }finally{
        submitBtn.innerHTML =  `
            Create
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
            },
        @endforeach
    ],
    placeholderValue: 'Select testimonials',
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
