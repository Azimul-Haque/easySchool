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
      নম্বর প্রদানঃ <b>{{ exam(Auth::user()->exam->name) }}-{{ bangla(Auth::user()->exam->exam_session) }}, {{ bangla_class($subjectdata->class) }} {{ bangla_section(Auth::user()->school->section_type, $subjectdata->class, $subjectdata->section) }} {{ $examsubject->subject->name_bangla }}</b>
      <div class="pull-right btn-group">
          
      </div>  
    </h1>
@stop

@section('content')
  <div class="row">
    {!! Form::open(array('route' => 'exam.storemakrs', 'method'=>'POST')) !!}
    <div class="col-md-9">
      <div class="panel panel-danger">
        <div class="panel-heading">
          <i class="fa fa-exclamation-triangle"></i> গুরুত্বপূর্ণ নির্দেশাবলী
        </div>
        <div class="panel-body">
          <ul>
            <li>সঠিক ঘরে নম্বর প্রদান করুন</li>
            <li>নম্বর প্রদান হয়ে গেলে পাশের ঘরের নীল <big><b>'নম্বর দাখিল করুন'</b></big> বাটনে ক্লিক করুন</li>
          </ul>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th width="5%">রোল</th>
              <th width="25%">নাম</th>
              <th width="">আইডি</th>
              <th width="">লিখিত<br/>({{ $examsubject->written }})</th>
              <th width="">নৈর্ব্যক্তিক<br/>({{ $examsubject->mcq }})</th>
              <th width="">ব্যবহারিক<br/>({{ $examsubject->practical }})</th>
              <th width="">CA/ SBA<br/>({{ $examsubject->ca }})</th>
              <th width="">মোট<br/>({{ $examsubject->total }})</th>
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
                  @if($examsubject->written > 0)
                    @php
                      $written = '';
                      $mcq = '';
                      $practical = '';
                      $ca = '';
                      $total = '';
                      $grade_point = '';
                      $gpa = '';
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
                            $gpa = $mark->gpa;
                          @endphp
                        @endif
                      @endforeach
                    @endif
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
                <td>
                  {{ $total }}
                </td>
                <td>
                  {{ $grade_point }}
                </td>
                <td>
                  {{ $gpa }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-md-3">
      <div class="box box-primary">
        <div class="box-header with-border text-blue">
          <i class="fa fa-fw fa-bar-chart"></i>
          <h3 class="box-title">নম্বর প্রদান কার্যক্রম</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#submitMarks" data-backdrop="static">নম্বর দাখিল করুন</button>
          
          <button type="button" class="btn btn-success btn-block margin-top-10" data-toggle="modal" data-target="#submitMarks" data-backdrop="static">নম্বরপত্র প্রিন্ট করুন</button>
          <button type="button" class="btn btn-warning btn-block margin-top-10" data-toggle="modal" data-target="#submitMarks" data-backdrop="static">নম্বর দাখিল করুন</button>

          {{-- submit marks modal --}}
          <!-- Modal -->
          <div class="modal fade" id="submitMarks" role="dialog">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <div class="modal-header modal-header-primary">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">চূড়ান্ত নম্বর দাখিল</h4>
                </div>
                
                <div class="modal-body">
                  আপনি কি নিশ্চিতভাবে নম্বর প্রদান করতে চান?
                  {!! Form::hidden('school_id', Auth::user()->school_id) !!}
                  {!! Form::hidden('exam_id', $subjectdata->exam_id) !!}
                  {!! Form::hidden('subject_id', $subjectdata->subject_id) !!}
                  {!! Form::hidden('class', $subjectdata->class) !!}
                  {!! Form::hidden('section', $subjectdata->class) !!}
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">দাখিল করুন</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                
                </div>
              </div>
            </div>
          </div>
          {{-- submit marks modal --}}
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    {!! Form::close() !!}
  </div>
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