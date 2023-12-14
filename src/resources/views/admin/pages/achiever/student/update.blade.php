@extends('admin.layouts.dashboard')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- colleget page title -->
        @can('list achievers')
        @include('admin.includes.breadcrumb', ['page'=>'Student', 'page_link'=>route('achiever.student.paginate.get'), 'list'=>['Update']])
        @endcan
        <!-- end page title -->

        <div class="row" id="image-container">
            @include('admin.includes.back_button', ['link'=>route('achiever.student.paginate.get')])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('achiever.student.update.post', $data->id)}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Student Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.input', ['key'=>'name', 'label'=>'Name', 'value'=>$data->name])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.input', ['key'=>'rank', 'label'=>'Rank', 'value'=>$data->rank])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.input', ['key'=>'college', 'label'=>'College', 'value'=>$data->college])
                                    </div>
                                    <div class="col-xxl-3 col-md-3">
                                        @include('admin.includes.select_multiple', ['key'=>'category', 'label'=>'Categories'])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.file_input', ['key'=>'image', 'label'=>'Image (177 x 199)'])
                                        @if(!empty($data->image_link))
                                            <img src="{{$data->image_link}}" alt="" class="img-preview">
                                        @endif
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'image_title', 'label'=>'Image Title', 'value'=>$data->image_title])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.input', ['key'=>'image_alt', 'label'=>'Image Alt', 'value'=>$data->image_alt])
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="mt-4 mt-md-0">
                                            <div>
                                                <div class="form-check form-switch form-check-right mb-2">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" {{$data->is_active==false ? '' : 'checked'}}>
                                                    <label class="form-check-label" for="is_active">Student Status</label>
                                                </div>
                                            </div>

                                        </div>
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
  .addField('#rank', [
    {
      rule: 'required',
      errorMessage: 'Rank is required',
    },
    {
        rule: 'customRegexp',
        value: COMMON_REGEX,
        errorMessage: 'Rank is invalid',
    },
  ])
  .addField('#college', [
    {
        validator: (value, fields) => true,
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
  .addField('#image_title', [
    {
        rule: 'customRegexp',
        value: COMMON_REGEX,
        errorMessage: 'Image Title is invalid',
    },
  ])
  .addField('#image_alt', [
    {
        rule: 'customRegexp',
        value: COMMON_REGEX,
        errorMessage: 'Image Alt is invalid',
    },
  ])
  .addField('#category', [
    {
        rule: 'required',
        errorMessage: 'Category is required',
    },
  ])
  .onSuccess(async (event) => {
    var submitBtn = document.getElementById('submitBtn')
    submitBtn.innerHTML = spinner
    submitBtn.disabled = true;
    try {
        var formData = new FormData();
        formData.append('is_active',document.getElementById('is_active').checked ? 1 : 0)
        formData.append('name',document.getElementById('name').value)
        formData.append('rank',document.getElementById('rank').value)
        formData.append('college',document.getElementById('college').value)
        formData.append('image_alt',document.getElementById('image_alt').value)
        formData.append('image_title',document.getElementById('image_title').value)
        if((document.getElementById('image').files).length>0){
            formData.append('image',document.getElementById('image').files[0])
        }
        if(document.getElementById('category')?.length>0){
            for (let index = 0; index < document.getElementById('category').length; index++) {
                formData.append('category[]',document.getElementById('category')[index].value)
            }
        }
        const response = await axios.post('{{route('achiever.student.update.post', $data->id)}}', formData)
        successToast(response.data.message)
        setInterval(location.reload(), 1500);
    }catch (error){
        if(error?.response?.data?.errors?.name){
            validation.showErrors({'#name': error?.response?.data?.errors?.name[0]})
        }
        if(error?.response?.data?.errors?.rank){
            validation.showErrors({'#rank': error?.response?.data?.errors?.rank[0]})
        }
        if(error?.response?.data?.errors?.college){
            validation.showErrors({'#college': error?.response?.data?.errors?.college[0]})
        }
        if(error?.response?.data?.errors?.category){
            validation.showErrors({'#category': error?.response?.data?.errors?.category[0]})
        }
        if(error?.response?.data?.errors?.image_alt){
            validation.showErrors({'#image_alt': error?.response?.data?.errors?.image_alt[0]})
        }
        if(error?.response?.data?.errors?.image_title){
            validation.showErrors({'#image_title': error?.response?.data?.errors?.image_title[0]})
        }
        if(error?.response?.data?.errors?.image){
            validation.showErrors({'#image': error?.response?.data?.errors?.image[0]})
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

  const categoryChoice = new Choices('#category', {
    choices: [
        @foreach($category as $category)
            {
                value: '{{$category->id}}',
                label: '{{$category->name}}',
                selected: {{ (in_array($category->id, $categories)) ? 'true' : 'false'}}
            },
        @endforeach
    ],
    placeholderValue: 'Select categories',
    ...CHOICE_CONFIG,
    shouldSort: false,
    shouldSortItems: false,
});
</script>
@stop
