@extends('adminlte::page')

@section('title', 'Exam Settings | Easy School')

@section('css')
  <style type="text/css">
    .hiddenCheckbox, .hiddenFinalSaveBtn {
      display:none;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }
    input[type=number]{
        width: 45px;
        -moz-appearance:textfield; /* Firefox */
    } 
  </style>
@stop

@section('content_header')
    <h1>
      নম্বর প্রদানঃ <b>{{ exam(Auth::user()->exam->name) }}-{{ bangla(Auth::user()->exam->exam_session) }}, {{ bangla_class($subjectdata->class) }} {{ bangla_section(Auth::user()->school->section_type, $subjectdata->class, $subjectdata->section) }} {{ $examsubject->subject->name_bangla }}</b>
      <div class="pull-right btn-group">
          
      </div>  
    </h1>
@stop

@section('content')
  {!! Form::open(array('route' => 'exam.storemakrs', 'method'=>'POST')) !!}
  <div class="row">
      <div class="col-md-8">
        <div class="panel panel-danger">
          <div class="panel-heading">
            <i class="fa fa-exclamation-triangle"></i> গুরুত্বপূর্ণ নির্দেশাবলী
          </div>
          <div class="panel-body">
            <ul>
              <li>সঠিক ঘরে নম্বর প্রদান করুন</li>
              <li>নম্বর প্রদান হয়ে গেলে পাশের ঘরের নীল রঙের <big><b>'নম্বর দাখিল করুন'</b></big> বাটনে ক্লিক করুন</li>
              <li>নম্বর তালিকা প্রিন্ট করে নিরীক্ষা শেষ হলে এবং আপনি নিশ্চিত হলে কমলা রঙের <big><b>'চূড়ান্ত নম্বর দাখিল'</b></big> বাটনে ক্লিক করুন</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="box box-primary">
          <div class="box-header with-border text-blue">
            <i class="fa fa-fw fa-bar-chart"></i>
            <h3 class="box-title">নম্বর প্রদান কার্যক্রম</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#submitMarks" data-backdrop="static" title="শিক্ষার্থীদের প্রাপ্ত নম্বর দাখিল করুন">নম্বর দাখিল করুন</button>
            <br/>
            <a href="{{ route('exam.pdfmarks', [Auth::user()->school_id, $subjectdata->exam_id, $subjectdata->subject_id, $subjectdata->class, $subjectdata->section]) }}" class="btn btn-success btn-block" target="_blank" title="দাখিলকৃত নম্বরের তালিকা প্রিন্ট করুন">নম্বর তালিকা প্রিন্ট করুন</a>
            <br/>
            <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#confirmSubmitMarks" data-backdrop="static" title="চূড়ান্তভাবে প্রধানশিক্ষক বরাবর নম্বর দাখিল করুন">চূড়ান্ত নম্বর দাখিল</button>

            {{-- submit marks modal --}}
            <!-- Modal -->
            <div class="modal fade" id="submitMarks" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">নম্বর দাখিল</h4>
                  </div>
                  
                  <div class="modal-body">
                    আপনি কি নিশ্চিতভাবে নম্বর প্রদান করতে চান?
                    {!! Form::hidden('school_id', Auth::user()->school_id) !!}
                    {!! Form::hidden('exam_id', $subjectdata->exam_id) !!}
                    {!! Form::hidden('subject_id', $subjectdata->subject_id) !!}
                    {!! Form::hidden('class', $subjectdata->class) !!}
                    {!! Form::hidden('section', $subjectdata->section) !!}
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">দাখিল করুন</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  
                  </div>
                </div>
              </div>
            </div>
            {{-- submit marks modal --}}

            {{-- submit confirm modal --}}
            <!-- Modal -->
            <div class="modal fade" id="confirmSubmitMarks" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-warning">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">চূড়ান্ত নম্বর দাখিল</h4>
                  </div>
                  
                  <div class="modal-body">
                    আপনি কি নিশ্চিতভাবে নম্বর প্রদান করতে চান?
                    {!! Form::hidden('school_id', Auth::user()->school_id) !!}
                    {!! Form::hidden('exam_id', $subjectdata->exam_id) !!}
                    {!! Form::hidden('subject_id', $subjectdata->subject_id) !!}
                    {!! Form::hidden('class', $subjectdata->class) !!}
                    {!! Form::hidden('section', $subjectdata->section) !!}
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">দাখিল করুন</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  
                  </div>
                </div>
              </div>
            </div>
            {{-- submit confirm modal --}}
          </div>
          <!-- /.box-body -->
        </div>
      </div>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th width="5%">রোল</th>
          <th width="20%">নাম</th>
          <th width="">আইডি</th>
          <th width="">লিখিত<br/>({{ $examsubject->written }})</th>
          <th width="">নৈর্ব্যক্তিক<br/>({{ $examsubject->mcq }})</th>
          <th width="">ব্যবহারিক<br/>({{ $examsubject->practical }})</th>
          <th width="">CA/ SBA<br/>({{ $examsubject->ca }})</th>
          @if($othersubject != null)
          <th width="">লিখিত <br/>({{ $othersubject->subject->name_bangla }})</th>
          <th width="">নৈর্ব্যক্তিক <br/>({{ $othersubject->subject->name_bangla }})</th>
          <th width="">ব্যবহারিক <br/>({{ $othersubject->subject->name_bangla }})</th>
          <th width="">CA/ SBA<br/>({{ $othersubject->subject->name_bangla }})</th>
          @endif
          <th width="">
            মোট<br/>
            @if($othersubject != null)
              ({{ $examsubject->total + $othersubject->total }})
            @else
              ({{ $examsubject->total }})
            @endif
          </th>
          <th width="">গ্রেড পয়েন্ট</th>
          <th width="">জিপিএ</th>
        </tr>
      </thead>
      <tbody>
        @foreach($students as $student)
          <tr>
            <td>
              {{ $student->roll }}
              {!! Form::hidden('student_id'.$student->student_id, $student->student_id) !!}
              {!! Form::hidden('roll'.$student->student_id, $student->roll) !!}
            </td>
            <td>{{ $student->name }}</td>
            <td>{{ $student->student_id }}</td>
            <td>
              @php
                $written = '';
                $mcq = '';
                $practical = '';
                $ca = '';
                $total = '';
                $grade_point = '';
                $grade = '';
              @endphp
              @if($marks->count() > 0)
                @foreach($marks as $mark)
                  @if($student->student_id == $mark->student_id)
                    @php
                      $written = $mark->written;
                      $mcq = $mark->mcq;
                      $practical = $mark->practical;
                      $ca = $mark->ca;
                      $total = $mark->total;
                      $grade_point = $mark->grade_point;
                      $grade = $mark->grade;
                    @endphp
                  @endif
                @endforeach
              @endif
              @if($examsubject->written > 0)
                <input type="number" name="written{{ $student->student_id }}" value="{{ $written }}" class="form-control" min="0" max="{{ $examsubject->written }}" step="any">
              @endif
            </td>
            <td>
              @if($examsubject->mcq > 0)
              <input type="number" name="mcq{{ $student->student_id }}" value="{{ $mcq }}" class="form-control" min="0" max="{{ $examsubject->mcq }}" step="any">
              @endif
            <td>
              @if($examsubject->practical > 0)
              <input type="number" name="practical{{ $student->student_id }}" value="{{ $practical }}" class="form-control" min="0" max="{{ $examsubject->practical }}" step="any">
              @endif
            </td>
            <td>
              @if($examsubject->ca > 0)
              <input type="number" name="ca{{ $student->student_id }}" value="{{ $ca }}" class="form-control" min="0" max="{{ $examsubject->ca }}" step="any">
              @endif
            </td>
            @if($othersubject != null)
              @php
                $otherwritten = '';
                $othermcq = '';
                $otherpractical = '';
                $otherca = '';
              @endphp
              @if($otherpapermarks->count() > 0)
                @foreach($otherpapermarks as $mark)
                  @if($student->student_id == $mark->student_id)
                    @php
                      $otherwritten = $mark->written;
                      $othermcq = $mark->mcq;
                      $otherpractical = $mark->practical;
                      $otherca = $mark->ca;
                    @endphp
                  @endif
                @endforeach
              @endif
            <td>
              @if($othersubject->written > 0)
                {{ $otherwritten }}
              @endif
            </td>
            <td>
              @if($othersubject->mcq > 0)
                {{ $othermcq }}
              @endif
            </td>
            <td>
              @if($othersubject->practical > 0)
                {{ $otherpractical }}
              @endif
            </td>
            <td>
              @if($othersubject->ca > 0)
                {{ $otherca }}
              @endif
            </td>
            @endif

            <td>
              {{ $total }}
            </td>
            <td>
              {{ $grade_point }}
            </td>
            <td>
              {{ $grade }}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {!! Form::close() !!}
@stop

@section('js')
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
  </script>
  <script type="text/javascript">
    @foreach($students as $student)
      // $('#written{{ $student->student_id }}').on('input',function() {
      //   console.log({{ $student->student_id }}+':'+$(this).val());
      // });
    @endforeach
  </script>
@stop