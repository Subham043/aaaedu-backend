@extends('admin.layouts.dashboard')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('admin.includes.breadcrumb', ['page'=>$slug, 'page_link'=>route('about.main.get', $slug), 'list'=>['About Section']])
        <!-- end page title -->

        <div class="row" id="image-container">
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('about.main.post', $slug)}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">About Section Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.input', ['key'=>'title', 'label'=>'Title', 'value'=>!empty($data) ? (old('title') ? old('title') : $data->title) : old('title')])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.input', ['key'=>'heading', 'label'=>'Heading', 'value'=>!empty($data) ? (old('heading') ? old('heading') : $data->heading) : old('heading')])
                                    </div>
                                    <div class="col-xxl-12 col-md-12">
                                        @include('admin.includes.quill', ['key'=>'description', 'label'=>'Description', 'value'=>!empty($data) ? (old('description') ? old('description') : $data->description) : old('description')])
                                    </div>

                                </div>
                                <!--end row-->
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header align-items-center d-flex justify-content-between">
                            <h4 class="card-title mb-0">Image</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4" id="image_row">
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.file_input', ['key'=>'image', 'label'=>'Image (781 x 758)'])
                                        @if(!empty($data->image_link))
                                            <img src="{{$data->image_link}}" alt="" class="img-preview">
                                        @endif
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'image_alt', 'label'=>'Image Alt', 'value'=>!empty($data) ? (old('image_alt') ? old('image_alt') : $data->image_alt) : old('image_alt')])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'image_title', 'label'=>'Image Title', 'value'=>!empty($data) ? (old('image_title') ? old('image_title') : $data->image_title) : old('image_title')])
                                    </div>

                                </div>
                                <!--end row-->
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header align-items-center d-flex justify-content-between">
                            <h4 class="card-title mb-0">Counter</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4" id="image_row">
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.file_input', ['key'=>'counter_image', 'label'=>'Image (512 x 512)'])
                                        @if(!empty($data->counter_image_link))
                                            <img src="{{$data->counter_image_link}}" alt="" class="img-preview">
                                        @endif
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'counter_title', 'label'=>'Title', 'value'=>!empty($data) ? (old('counter_title') ? old('counter_title') : $data->counter_title) : old('counter_title')])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'counter_description', 'label'=>'Description', 'value'=>!empty($data) ? (old('counter_description') ? old('counter_description') : $data->counter_description) : old('counter_description')])
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
.addField('#title', [
    {
      rule: 'required',
      errorMessage: 'Title is required',
    },
    {
        rule: 'customRegexp',
        value: COMMON_REGEX,
        errorMessage: 'Title is invalid',
    },
  ])
.addField('#heading', [
    {
      rule: 'required',
      errorMessage: 'Heading is required',
    },
    {
        rule: 'customRegexp',
        value: COMMON_REGEX,
        errorMessage: 'Heading is invalid',
    },
  ])
  .addField('#description', [
    {
        rule: 'required',
        errorMessage: 'Description Link is required',
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
        errorMessage: 'Only One Image is required',
    },
    {
        rule: 'files',
        value: {
        files: {
            extensions: ['jpeg', 'jpg', 'png', 'webp'],
            maxSize: 500000,
            types: ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'],
        },
        },
        errorMessage: 'Images with jpeg,jpg,png,webp extensions are allowed! Image size should not exceed 500kb!',
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
    .addField('#counter_title', [
        {
            validator: (value, fields) => true,
        },
    ])
    .addField('#counter_description', [
        {
            validator: (value, fields) => true,
        },
    ])
    .addField('#counter_image', [
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
  .onSuccess(async (event) => {
    var submitBtn = document.getElementById('submitBtn')
    submitBtn.innerHTML = spinner
    submitBtn.disabled = true;
    try {
        var formData = new FormData();
        formData.append('title',document.getElementById('title').value)
        formData.append('heading',document.getElementById('heading').value)
        formData.append('description',editor.getData())
        formData.append('description_unfiltered',editor.getData().replace(/<[^>]*>/g, ''))
        formData.append('image_title',document.getElementById('image_title').value)
        formData.append('image_alt',document.getElementById('image_alt').value)
        if((document.getElementById('image').files).length>0){
            formData.append('image',document.getElementById('image').files[0])
        }
        formData.append('counter_title',document.getElementById('counter_title').value)
        formData.append('counter_description',document.getElementById('counter_description').value)
        if((document.getElementById('counter_image').files).length>0){
            formData.append('counter_image',document.getElementById('counter_image').files[0])
        }

        const response = await axios.post('{{route('about.main.post', $slug)}}', formData)
        successToast(response.data.message)
        setInterval(location.reload(), 1500);
    }catch (error){
        if(error?.response?.data?.errors?.heading){
            validation.showErrors({'#heading': error?.response?.data?.errors?.heading[0]})
        }
        if(error?.response?.data?.errors?.title){
            validation.showErrors({'#title': error?.response?.data?.errors?.title[0]})
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
        if(error?.response?.data?.errors?.counter_title){
            validation.showErrors({'#counter_title': error?.response?.data?.errors?.counter_title[0]})
        }
        if(error?.response?.data?.errors?.counter_description){
            validation.showErrors({'#counter_description': error?.response?.data?.errors?.counter_description[0]})
        }
        if(error?.response?.data?.errors?.counter_image){
            validation.showErrors({'#counter_image': error?.response?.data?.errors?.counter_image[0]})
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
</script>
@stop
