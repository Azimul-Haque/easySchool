@extends('adminlte::page')

@section('title', 'Exam Settings | Easy School')

@section('css')
  <style type="text/css">
    .hiddenCheckbox, .hiddenFinalSaveBtn {
      display:none;
    }
  </style>
@stop

@section('content_header')
    <h1>
      স্কুল পরীক্ষা সেটিংস
      <div class="pull-right btn-group">
          
      </div>  
    </h1>
@stop

@section('content')
  @permission('result-gs')
  <div class="row">
    <div class="col-md-6">
      <h4>
        চলতি পরীক্ষার নামঃ <b>{{ exam(Auth::user()->exam->name) }}-{{ bangla(Auth::user()->exam->exam_session) }}</b>
      </h4>
    </div>
    <div class="col-md-6"></div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th width="20%">শিক্ষকের নাম</th>
              <th width="30%">বণ্টিত বিষয়</th>
              <th>বিষয় বণ্টন</th>
              <th width="10%">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($teachers as $teacher)
            <tr>
              <td>{{ $teacher->name }}</td>
              <td>
                @if(count($teacher->subjectallocations) > 0)
                  @foreach($teacher->subjectallocations as $allocatedsubject)
                  <label class="badge badge-primary" style="font-size: 14px;">
                    {{ bangla_class($allocatedsubject->class) }}
                    {{ bangla_section($teacher->school->section_type, $allocatedsubject->class, $allocatedsubject->section) }}
                    {{ $allocatedsubject->subject->name_bangla }}
                  </label>
                  @endforeach
                @endif
              </td>
              {!! Form::open(array('route' => 'exam.postsubjectallocation','method'=>'POST')) !!}
              <td>
                {!! Form::hidden('user_id', $teacher->id) !!}
                {!! Form::hidden('school_id', $teacher->school_id) !!}
                {!! Form::hidden('exam_id', $teacher->exam_id) !!}
                
                <select name="subjects[]" class="form-control" id="optionsubjects{{ $teacher->id }}" multiple="" data-placeholder="বিষয় বণ্টন করুন" required="">
                  @if(Auth::user()->school->sections > 0)
                    @for($secscount = 1; $secscount <= Auth::user()->school->sections; $secscount++)
                      @foreach(Auth::user()->exam->examsubjects as $subject)
                      <option value="{{ $subject->subject_id }}:{{ $subject->class }}:{{ $secscount }}">{{ bangla_class($subject->class) }} {{ bangla_section(Auth::user()->school->section_type, $subject->class, $secscount) }} {{ $subject->subject->name_bangla }}</option>
                      @endforeach
                    @endfor
                  @else
                    @foreach(Auth::user()->exam->examsubjects as $subject)
                    <option value="{{ $subject->subject_id }}:{{ $subject->class }}">{{ bangla_class($subject->class) }} {{ $subject->subject->name_bangla }}</option>
                    @endforeach
                  @endif
                  
                </select>
              </td>
              <td>
                <button type="submit" class="btn btn-success btn-sm">সংরক্ষণ করুন</button>
              </td>
              {!! Form::close() !!}
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endpermission
@stop

@section('js')
  {!!Html::script('js/select2.min.js')!!}
  <script type="text/javascript">
    $(function () {
      $('#datatable-exams').DataTable({
        'paging'      : true,
        'pageLength'  : 10,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : true,
        'order': [[ 1, "asc" ]],
         // columnDefs: [
         //    { targets: [5], type: 'date'}
         // ]
      })
    })
  </script>
  <script type="text/javascript">
    $(function(){
     $('a[title]').tooltip();
     $('button[title]').tooltip();
    });
    @foreach($teachers as $teacher)
      $('#optionsubjects{{ $teacher->id }}').select2();
    @endforeach
  </script>
@stop