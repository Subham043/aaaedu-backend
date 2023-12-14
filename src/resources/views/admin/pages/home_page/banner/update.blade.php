@extends('admin.layouts.dashboard')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @can('list home page content')
        @include('admin.includes.breadcrumb', ['page'=>'Banner', 'page_link'=>route('home_page.banner.paginate.get'), 'list'=>['Update']])
        @endcan
        <!-- end page title -->

        <div class="row" id="image-container">
            @include('admin.includes.back_button', ['link'=>route('home_page.banner.paginate.get')])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('home_page.banner.update.post', $data->id)}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Banner Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.input', ['key'=>'title', 'label'=>'Title', 'value'=>$data->title])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.input', ['key'=>'heading', 'label'=>'Heading', 'value'=>$data->heading])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.input', ['key'=>'button_text', 'label'=>'Button Text', 'value'=>$data->button_text])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.input', ['key'=>'button_link', 'label'=>'Button Link', 'value'=>$data->button_link])
                                    </div>
                                    <div class="col-xxl-12 col-md-12">
                                        @include('admin.includes.textarea', ['key'=>'description', 'label'=>'Description', 'value'=>$data->description])
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="mt-4 mt-md-0">
                                            <div>
                                                <div class="form-check form-switch form-check-right mb-2">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" {{$data->is_active==false ? '' : 'checked'}}>
                                                    <label class="form-check-label" for="is_active">Banner Status</label>
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
                            <h4 class="card-title mb-0">Banner Image</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4" id="image_row">
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.file_input', ['key'=>'banner_image', 'label'=>'Image (757 x 758)'])
                                        @if(!empty($data->banner_image_url))
                                            <img src="{{$data->banner_image_url}}" alt="" class="img-preview">
                                        @endif
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'banner_image_alt', 'label'=>'Image Alt', 'value'=>$data->banner_image_alt])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'banner_image_title', 'label'=>'Image Title', 'value'=>$data->banner_image_title])
                                    </div>

                                </div>
                                <!--end row-->
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header align-items-center d-flex justify-content-between">
                            <h4 class="card-title mb-0">Counter 1</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4" id="image_row">
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.file_input', ['key'=>'counter_image_1', 'label'=>'Image'])
                                        @if(!empty($data->counter_image_one_link))
                                            <img src="{{$data->counter_image_one_link}}" alt="" class="img-preview">
                                        @endif
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'counter_title_1', 'label'=>'Title', 'value'=>$data->counter_title_1])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'counter_description_1', 'label'=>'Description', 'value'=>$data->counter_description_1])
                                    </div>

                                </div>
                                <!--end row-->
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header align-items-center d-flex justify-content-between">
                            <h4 class="card-title mb-0">Counter 2</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4" id="image_row">
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.file_input', ['key'=>'counter_image_2', 'label'=>'Image'])
                                        @if(!empty($data->counter_image_two_link))
                                            <img src="{{$data->counter_image_two_link}}" alt="" class="img-preview">
                                        @endif
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'counter_title_2', 'label'=>'Title', 'value'=>$data->counter_title_2])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'counter_description_2', 'label'=>'Description', 'value'=>$data->counter_description_2])
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
  ])
.addField('#heading', [
    {
      rule: 'required',
      errorMessage: 'Heading is required',
    },
  ])
  .addField('#button_link', [
    {
        validator: (value, fields) => true,
    },
  ])
  .addField('#button_link', [
    {
        validator: (value, fields) => true,
    },
  ])
  .addField('#description', [
    {
      rule: 'required',
      errorMessage: 'Description is required',
    },
  ])
  .addField('#banner_image_title', [
        {
            validator: (value, fields) => true,
        },
    ])
    .addField('#banner_image_alt', [
        {
            validator: (value, fields) => true,
        },
    ])
    .addField('#banner_image', [
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
  .addField('#counter_title_1', [
        {
            validator: (value, fields) => true,
        },
    ])
    .addField('#counter_description_1', [
        {
            validator: (value, fields) => true,
        },
    ])
    .addField('#counter_image_1', [
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
  .addField('#counter_title_2', [
        {
            validator: (value, fields) => true,
        },
    ])
    .addField('#counter_description_2', [
        {
            validator: (value, fields) => true,
        },
    ])
    .addField('#counter_image_2', [
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
        formData.append('is_active',document.getElementById('is_active').checked ? 1 : 0)
        formData.append('title',document.getElementById('title').value)
        formData.append('heading',document.getElementById('heading').value)
        formData.append('button_text',document.getElementById('button_text').value)
        formData.append('button_link',document.getElementById('button_link').value)
        formData.append('banner_image_title',document.getElementById('banner_image_title').value)
        formData.append('banner_image_alt',document.getElementById('banner_image_alt').value)
        formData.append('description',document.getElementById('description').value)
        if((document.getElementById('banner_image').files).length>0){
            formData.append('banner_image',document.getElementById('banner_image').files[0])
        }
        formData.append('counter_title_1',document.getElementById('counter_title_1').value)
        formData.append('counter_description_1',document.getElementById('counter_description_1').value)
        if((document.getElementById('counter_image_1').files).length>0){
            formData.append('counter_image_1',document.getElementById('counter_image_1').files[0])
        }
        formData.append('counter_title_2',document.getElementById('counter_title_2').value)
        formData.append('counter_description_2',document.getElementById('counter_description_2').value)
        if((document.getElementById('counter_image_2').files).length>0){
            formData.append('counter_image_2',document.getElementById('counter_image_2').files[0])
        }

        const response = await axios.post('{{route('home_page.banner.update.post', $data->id)}}', formData)
        successToast(response.data.message)
        setInterval(location.reload(), 1500);
    }catch (error){
        if(error?.response?.data?.errors?.title){
            validation.showErrors({'#title': error?.response?.data?.errors?.title[0]})
        }
        if(error?.response?.data?.errors?.heading){
            validation.showErrors({'#heading': error?.response?.data?.errors?.heading[0]})
        }
        if(error?.response?.data?.errors?.button_text){
            validation.showErrors({'#button_text': error?.response?.data?.errors?.button_text[0]})
        }
        if(error?.response?.data?.errors?.button_link){
            validation.showErrors({'#button_link': error?.response?.data?.errors?.button_link[0]})
        }
        if(error?.response?.data?.errors?.banner_image_title){
            validation.showErrors({'#banner_image_title': error?.response?.data?.errors?.banner_image_title[0]})
        }
        if(error?.response?.data?.errors?.banner_image_alt){
            validation.showErrors({'#banner_image_alt': error?.response?.data?.errors?.banner_image_alt[0]})
        }
        if(error?.response?.data?.errors?.banner_image){
            validation.showErrors({'#banner_image': error?.response?.data?.errors?.banner_image[0]})
        }
        if(error?.response?.data?.errors?.counter_title_1){
            validation.showErrors({'#counter_title_1': error?.response?.data?.errors?.counter_title_1[0]})
        }
        if(error?.response?.data?.errors?.counter_description_1){
            validation.showErrors({'#counter_description_1': error?.response?.data?.errors?.counter_description_1[0]})
        }
        if(error?.response?.data?.errors?.counter_image_1){
            validation.showErrors({'#counter_image_1': error?.response?.data?.errors?.counter_image_1[0]})
        }
        if(error?.response?.data?.errors?.counter_title_2){
            validation.showErrors({'#counter_title_2': error?.response?.data?.errors?.counter_title_2[0]})
        }
        if(error?.response?.data?.errors?.counter_description_2){
            validation.showErrors({'#counter_description_2': error?.response?.data?.errors?.counter_description_2[0]})
        }
        if(error?.response?.data?.errors?.counter_image_2){
            validation.showErrors({'#counter_image_2': error?.response?.data?.errors?.counter_image_2[0]})
        }
        if(error?.response?.data?.errors?.description){
            validation.showErrors({'#description': error?.response?.data?.errors?.description[0]})
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
