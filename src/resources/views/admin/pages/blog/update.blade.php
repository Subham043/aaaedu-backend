@extends('admin.layouts.dashboard')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @can('list blogs')
        @include('admin.includes.breadcrumb', ['page'=>'Blog', 'page_link'=>route('blog.paginate.get'), 'list'=>['Update']])
        @endcan
        <!-- end page title -->

        <div class="row" id="image-container">
            @include('admin.includes.back_button', ['link'=>route('blog.paginate.get')])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('blog.update.post', $data->id)}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Blog Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.input', ['key'=>'name', 'label'=>'Name', 'value'=>$data->name])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.input', ['key'=>'heading', 'label'=>'Heading', 'value'=>$data->heading])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'slug', 'label'=>'Slug', 'value'=>$data->slug])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'author_name', 'label'=>'Author Name', 'value'=>$data->author_name])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.date', ['key'=>'published_on', 'label'=>'Published On', 'value'=>$data->published_on->format('Y-m-d')])
                                    </div>
                                    <div class="col-xxl-12 col-md-12">
                                        @include('admin.includes.quill', ['key'=>'description', 'label'=>'Description', 'value'=>$data->description])
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="mt-4 mt-md-0">
                                            <div>
                                                <div class="form-check form-switch form-check-right mb-2">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" {{$data->is_active==false ? '' : 'checked'}}>
                                                    <label class="form-check-label" for="is_active">Blog Publish</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="mt-4 mt-md-0">
                                            <div>
                                                <div class="form-check form-switch form-check-right mb-2">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="is_popular" name="is_popular" {{$data->is_popular==false ? '' : 'checked'}}>
                                                    <label class="form-check-label" for="is_popular">Is Blog Popular?</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="mt-4 mt-md-0">
                                            <div>
                                                <div class="form-check form-switch form-check-right mb-2">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="is_updated" name="is_updated" {{$data->is_updated==false ? '' : 'checked'}}>
                                                    <label class="form-check-label" for="is_updated">Is Blog Updated?</label>
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
                            <h4 class="card-title mb-0">Blog Image</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4" id="image_row">
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.file_input', ['key'=>'image', 'label'=>'Image (1429 x 600)'])
                                        @if(!empty($data->image_link))
                                            <img src="{{$data->image_link}}" alt="" class="img-preview">
                                        @endif
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'image_alt', 'label'=>'Image Alt', 'value'=>$data->image_alt])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'image_title', 'label'=>'Image Title', 'value'=>$data->image_title])
                                    </div>

                                </div>
                                <!--end row-->
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Blog Seo Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.textarea', ['key'=>'meta_title', 'label'=>'Meta Title', 'value'=>$data->meta_title])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.textarea', ['key'=>'meta_keywords', 'label'=>'Meta Keywords', 'value'=>$data->meta_keywords])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.textarea', ['key'=>'meta_description', 'label'=>'Meta Description', 'value'=>$data->meta_description])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.textarea', ['key'=>'meta_scripts', 'label'=>'Meta Scripts', 'value'=>$data->meta_scripts])
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

CKEDITOR.ClassicEditor
.create(document.getElementById("description_quill"), CKEDITOR_OPTIONS)
.then( newEditor => {
    editor = newEditor;
    editor.model.document.on( 'change:data', () => {
        document.getElementById('description').value = editor.getData()
    } );
});

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
  .addField('#author_name', [
    {
      rule: 'required',
      errorMessage: 'Author Name is required',
    },
    {
        rule: 'customRegexp',
        value: COMMON_REGEX,
        errorMessage: 'Author Name is invalid',
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
  .addField('#published_on', [
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
        formData.append('is_popular',document.getElementById('is_popular').checked ? 1 : 0)
        formData.append('is_updated',document.getElementById('is_updated').checked ? 1 : 0)
        formData.append('name',document.getElementById('name').value)
        formData.append('author_name',document.getElementById('author_name').value)
        formData.append('published_on',document.getElementById('published_on').value)
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
        if((document.getElementById('image').files).length>0){
            formData.append('image',document.getElementById('image').files[0])
        }

        const response = await axios.post('{{route('blog.update.post', $data->id)}}', formData)
        successToast(response.data.message)
        setInterval(location.reload(), 1500);
    }catch (error){
        if(error?.response?.data?.errors?.name){
            validation.showErrors({'#name': error?.response?.data?.errors?.name[0]})
        }
        if(error?.response?.data?.errors?.author_name){
            validation.showErrors({'#author_name': error?.response?.data?.errors?.author_name[0]})
        }
        if(error?.response?.data?.errors?.published_on){
            validation.showErrors({'#published_on': error?.response?.data?.errors?.published_on[0]})
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
        if(error?.response?.data?.message){
            errorToast(error?.response?.data?.message)
        }
        console.log(error);
    }finally{
        submitBtn.innerHTML =  `
            Update
            `
        submitBtn.disabled = false;
    }
  });

</script>

@stop
