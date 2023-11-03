@extends('admin.layouts.dashboard')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @can('list events')
        @include('admin.includes.breadcrumb', ['page'=>'Test Quiz', 'page_link'=>route('test.quiz.paginate.get', $test_id), 'list'=>['Update']])
        @endcan
        <!-- end page title -->

        <div class="row" id="image-container">
            @include('admin.includes.back_button', ['link'=>route('test.quiz.paginate.get', $test_id)])
            <div class="col-lg-12">
                <form id="countryForm" method="post" action="{{route('test.quiz.update.post', [$test_id, $data->id])}}" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Test Quiz Detail</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="col-xxl-12 col-md-12">
                                    @include('admin.includes.quill', ['key'=>'question', 'label'=>'Question', 'value'=>$data->question])
                                </div>
                                <div class="col-xxl-12 col-md-12">
                                    @include('admin.includes.quill', ['key'=>'answer_1', 'label'=>'Answer 1', 'value'=>$data->answer_1])
                                </div>
                                <div class="col-xxl-12 col-md-12">
                                    @include('admin.includes.quill', ['key'=>'answer_2', 'label'=>'Answer 2', 'value'=>$data->answer_2])
                                </div>
                                <div class="col-xxl-12 col-md-12">
                                    @include('admin.includes.quill', ['key'=>'answer_3', 'label'=>'Answer 3', 'value'=>$data->answer_3])
                                </div>
                                <div class="col-xxl-12 col-md-12">
                                    @include('admin.includes.quill', ['key'=>'answer_4', 'label'=>'Answer 4', 'value'=>$data->answer_4])
                                </div>
                                <!--end row-->
                            </div>

                        </div>
                    </div>

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
                                        @include('admin.includes.select', ['key'=>'duration', 'label'=>'Duration'])
                                    </div>
                                    <div class="col-xxl-4 col-md-4">
                                        @include('admin.includes.select', ['key'=>'difficulty', 'label'=>'Difficulty'])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.select', ['key'=>'correct_answer', 'label'=>'Correct Answer'])
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        @include('admin.includes.select', ['key'=>'subject_id', 'label'=>'Subject'])
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
let editor1;
CKEDITOR.ClassicEditor
.create(document.getElementById("question_quill"), CKEDITOR_OPTIONS)
.then( newEditor1 => {
    editor1 = newEditor1;
    editor1.model.document.on( 'change:data', () => {
        document.getElementById('question').value = editor1.getData()
    } );
});

let editor2;
CKEDITOR.ClassicEditor
.create(document.getElementById("answer_1_quill"), CKEDITOR_OPTIONS)
.then( newEditor2 => {
    editor2 = newEditor2;
    editor2.model.document.on( 'change:data', () => {
        document.getElementById('answer_1').value = editor2.getData()
    } );
});

let editor3;
CKEDITOR.ClassicEditor
.create(document.getElementById("answer_2_quill"), CKEDITOR_OPTIONS)
.then( newEditor3 => {
    editor3 = newEditor3;
    editor3.model.document.on( 'change:data', () => {
        document.getElementById('answer_2').value = editor3.getData()
    } );
});

let editor4;
CKEDITOR.ClassicEditor
.create(document.getElementById("answer_3_quill"), CKEDITOR_OPTIONS)
.then( newEditor4 => {
    editor4 = newEditor4;
    editor4.model.document.on( 'change:data', () => {
        document.getElementById('answer_3').value = editor4.getData()
    } );
});

let editor5;
CKEDITOR.ClassicEditor
.create(document.getElementById("answer_4_quill"), CKEDITOR_OPTIONS)
.then( newEditor5 => {
    editor5 = newEditor5;
    editor5.model.document.on( 'change:data', () => {
        document.getElementById('answer_4').value = editor5.getData()
    } );
});

// initialize the validation library
const validation = new JustValidate('#countryForm', {
      errorFieldCssClass: 'is-invalid',
});
// apply rules to form fields
validation
.addField('#question', [
    {
        rule: 'required',
        errorMessage: 'Question is required',
    },
  ])
  .addField('#answer_1', [
    {
        rule: 'required',
        errorMessage: 'Answer 1 is required',
    },
  ])
  .addField('#answer_2', [
    {
        rule: 'required',
        errorMessage: 'Answer 2 is required',
    },
  ])
  .addField('#answer_3', [
    {
        rule: 'required',
        errorMessage: 'Answer 3 is required',
    },
  ])
  .addField('#answer_4', [
    {
        rule: 'required',
        errorMessage: 'Answer 4 is required',
    },
  ])
  .addField('#mark', [
    {
        rule: 'required',
        errorMessage: 'Mark is required',
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
  .addField('#correct_answer', [
    {
        rule: 'required',
        errorMessage: 'Correct Answer is required',
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
        formData.append('question',editor1.getData())
        formData.append('question_unfiltered',editor1.getData().replace(/<[^>]*>/g, ''))
        formData.append('answer_1',editor2.getData())
        formData.append('answer_1_unfiltered',editor2.getData().replace(/<[^>]*>/g, ''))
        formData.append('answer_2',editor3.getData())
        formData.append('answer_2_unfiltered',editor3.getData().replace(/<[^>]*>/g, ''))
        formData.append('answer_3',editor4.getData())
        formData.append('answer_3_unfiltered',editor4.getData().replace(/<[^>]*>/g, ''))
        formData.append('answer_4',editor5.getData())
        formData.append('answer_4_unfiltered',editor5.getData().replace(/<[^>]*>/g, ''))
        formData.append('mark',document.getElementById('mark').value)
        formData.append('duration',document.getElementById('duration').value)
        formData.append('difficulty',document.getElementById('difficulty').value)
        formData.append('correct_answer',document.getElementById('correct_answer').value)
        formData.append('subject_id',document.getElementById('subject_id').value)

        const response = await axios.post('{{route('test.quiz.update.post', [$test_id, $data->id])}}', formData)
        successToast(response.data.message)
        setInterval(location.reload(), 1500);
    }catch (error){
        if(error?.response?.data?.errors?.mark){
            validation.showErrors({'#mark': error?.response?.data?.errors?.mark[0]})
        }
        if(error?.response?.data?.errors?.duration){
            validation.showErrors({'#duration': error?.response?.data?.errors?.duration[0]})
        }
        if(error?.response?.data?.errors?.difficulty){
            validation.showErrors({'#difficulty': error?.response?.data?.errors?.difficulty[0]})
        }
        if(error?.response?.data?.errors?.correct_answer){
            validation.showErrors({'#correct_answer': error?.response?.data?.errors?.correct_answer[0]})
        }
        if(error?.response?.data?.errors?.subject_id){
            validation.showErrors({'#subject_id': error?.response?.data?.errors?.subject_id[0]})
        }
        if(error?.response?.data?.errors?.question){
            validation.showErrors({'#question': error?.response?.data?.errors?.question[0]})
        }
        if(error?.response?.data?.errors?.answer_1){
            validation.showErrors({'#answer_1': error?.response?.data?.errors?.answer_1[0]})
        }
        if(error?.response?.data?.errors?.answer_2){
            validation.showErrors({'#answer_2': error?.response?.data?.errors?.answer_2[0]})
        }
        if(error?.response?.data?.errors?.answer_3){
            validation.showErrors({'#answer_3': error?.response?.data?.errors?.answer_3[0]})
        }
        if(error?.response?.data?.errors?.answer_4){
            validation.showErrors({'#answer_4': error?.response?.data?.errors?.answer_4[0]})
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

  const durationChoice = new Choices('#duration', {
    choices: [
        @for($i=5; $i<=60; $i+=5)
            {
                value: '{{$i}}',
                label: '{{$i}} mins',
                selected: {{$data->duration==$i ? 'true' : 'false'}}
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
                selected: {{$data->mark==$i ? 'true' : 'false'}}
            },
        @endfor
    ],
    placeholderValue: 'Select marks',
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
                selected: {{$data->difficulty->value==$val ? 'true' : 'false'}}
            },
        @endforeach
    ],
    placeholderValue: 'Select difficulty',
    ...CHOICE_CONFIG,
    shouldSort: false,
    shouldSortItems: false,
});

const correctAnswerChoice = new Choices('#correct_answer', {
    choices: [
        @foreach($correct_answer as $val)
            {
                value: '{{$val}}',
                label: '{{$val}}',
                selected: {{$data->correct_answer->value==$val ? 'true' : 'false'}}
            },
        @endforeach
    ],
    placeholderValue: 'Select correct answer',
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
                selected: {{$data->subject->id==$val->id ? 'true' : 'false'}}
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
