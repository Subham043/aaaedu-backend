@extends('admin.layouts.dashboard')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @can('list events')
        @include('admin.includes.breadcrumb', ['page'=>'Test Quiz', 'page_link'=>route('test.quiz.paginate.get', $test_id), 'list'=>['Create']])
        @endcan
        <!-- end page title -->

        <div class="row">
            @include('admin.includes.back_button', ['link'=>route('test.quiz.paginate.get', $test_id)])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('test.quiz.create.post', $test_id)}}" enctype="multipart/form-data">
                @csrf

                    <div class="card">
                        <div class="card-header align-items-center d-flex justify-content-between">
                            <h4 class="card-title mb-0">Test Quiz Analysis</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4" id="image_row">
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.select', ['key'=>'mark', 'label'=>'Marks'])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.select', ['key'=>'negative_mark', 'label'=>'Negative Marks'])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.select', ['key'=>'duration', 'label'=>'Duration'])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.select', ['key'=>'difficulty', 'label'=>'Difficulty'])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.select', ['key'=>'subject_id', 'label'=>'Subject'])
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

// initialize the validation library
const validation = new JustValidate('#countryForm', {
      errorFieldCssClass: 'is-invalid',
});
// apply rules to form fields
validation
  .addField('#mark', [
    {
        rule: 'required',
        errorMessage: 'Mark is required',
    },
  ])
  .addField('#negative_mark', [
    {
        rule: 'required',
        errorMessage: 'Negative Mark is required',
    },
  ])
  .addField('#duration', [
    {
        rule: 'required',
        errorMessage: 'Duration is required',
    },
  ])
  .addField('#difficulty', [
    {
        rule: 'required',
        errorMessage: 'Difficulty is required',
    },
  ])
  .addField('#subject_id', [
    {
        rule: 'required',
        errorMessage: 'Subject is required',
    },
  ])
  .onSuccess(async (event) => {
    var submitBtn = document.getElementById('submitBtn')
    submitBtn.innerHTML = spinner
    submitBtn.disabled = true;
    try {
        var formData = new FormData();
        formData.append('mark',document.getElementById('mark').value)
        formData.append('negative_mark',document.getElementById('negative_mark').value)
        formData.append('duration',document.getElementById('duration').value)
        formData.append('difficulty',document.getElementById('difficulty').value)
        formData.append('subject_id',document.getElementById('subject_id').value)

        const response = await axios.post('{{route('test.quiz.create.post', $test_id)}}', formData)
        successToast(response.data.message)
        event.target.reset();
        setInterval(location.reload(), 1500);
    }catch (error){
        if(error?.response?.data?.errors?.mark){
            validation.showErrors({'#mark': error?.response?.data?.errors?.mark[0]})
        }
        if(error?.response?.data?.errors?.negative_mark){
            validation.showErrors({'#negative_mark': error?.response?.data?.errors?.negative_mark[0]})
        }
        if(error?.response?.data?.errors?.duration){
            validation.showErrors({'#duration': error?.response?.data?.errors?.duration[0]})
        }
        if(error?.response?.data?.errors?.difficulty){
            validation.showErrors({'#difficulty': error?.response?.data?.errors?.difficulty[0]})
        }
        if(error?.response?.data?.errors?.subject_id){
            validation.showErrors({'#subject_id': error?.response?.data?.errors?.subject_id[0]})
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

  const durationChoice = new Choices('#duration', {
    choices: [
        @for($i=5; $i<=60; $i+=5)
            {
                value: '{{$i}}',
                label: '{{$i}} mins',
            },
        @endfor
    ],
    placeholderValue: 'Select durations',
    ...CHOICE_CONFIG,
    shouldSort: false,
    shouldSortItems: false,
});

const markChoice = new Choices('#mark', {
    choices: [
        @for($i=1; $i<=10; $i++)
            {
                value: '{{$i}}',
                label: '{{$i}}',
            },
        @endfor
    ],
    placeholderValue: 'Select marks',
    ...CHOICE_CONFIG,
    shouldSort: false,
    shouldSortItems: false,
});

const negativeMarkChoice = new Choices('#negative_mark', {
    choices: [
        {
            value: 0,
            label: 0,
        },
        @for($i=1; $i<=10; $i++)
            {
                value: '-{{$i}}',
                label: '-{{$i}}',
            },
        @endfor
    ],
    placeholderValue: 'Select negative marks',
    ...CHOICE_CONFIG,
    shouldSort: false,
    shouldSortItems: false,
});

const difficultyChoice = new Choices('#difficulty', {
    choices: [
        @foreach($difficulty as $val)
            {
                value: '{{$val}}',
                label: '{{$val}}',
            },
        @endforeach
    ],
    placeholderValue: 'Select difficulty',
    ...CHOICE_CONFIG,
    shouldSort: false,
    shouldSortItems: false,
});

const subjectChoice = new Choices('#subject_id', {
    choices: [
        @foreach($subjects as $val)
            {
                value: '{{$val->id}}',
                label: '{{$val->name}}',
            },
        @endforeach
    ],
    placeholderValue: 'Select subject',
    ...CHOICE_CONFIG,
    shouldSort: false,
    shouldSortItems: false,
});

</script>

@stop
