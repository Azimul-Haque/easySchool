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
    <div class="col-md-8">
      <div class="panel panel-danger">
        <div class="panel-heading">
          <i class="fa fa-exclamation-triangle"></i> গুরুত্বপূর্ণ নির্দেশাবলী
        </div>
        <div class="panel-body">
          <ul>
            <li>সঠিক ঘরে নম্বর প্রদান করুন</li>
            <li>নম্বর প্রদান হয়ে গেলে পাশের ঘরের নীল 'নম্বর দাখিল করুন' বাটনে ক্লিক করুন</li>
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
              <th width="">লিখিত ({{ $examsubject->written }})</th>
              <th width="">নৈর্ব্যক্তিক ({{ $examsubject->mcq }})</th>
              <th width="">ব্যবহারিক ({{ $examsubject->practical }})</th>
              <th width="">CA/ SBA ({{ $examsubject->ca }})</th>
              <th width="">মোট ({{ $examsubject->total }})</th>
            </tr>
          </thead>
          <tbody>
            @foreach($students as $student)
              <tr>
                <td>{{ $student->roll }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->student_id }}</td>
                <td>
                  @if($examsubject->written > 0)
                  <input type="text" name="" class="form-control">
                  @endif
                </td>
                <td>
                  @if($examsubject->mcq > 0)
                  <input type="text" name="" class="form-control">
                  @endif
                <td>
                  @if($examsubject->practical > 0)
                  <input type="text" name="" class="form-control">
                  @endif
                </td>
                <td>
                  @if($examsubject->ca > 0)
                  <input type="text" name="" class="form-control">
                  @endif
                </td>
                <td></td>
              </tr>
            @endforeach
          </tbody>
        </table>
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
          <button class="btn btn-primary" data-toggle="modal" data-target="#submitMarks" data-backdrop="static">নম্বর দাখিল করুন</button>
          {{-- submit marks modal --}}
          <!-- Modal -->
          <div class="modal fade" id="submitMarks" role="dialog">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <div class="modal-header modal-header-primary">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">চূড়ান্ত নম্বর দাখিল</h4>
                </div>
                {!! Form::open(array('route' => 'exam.storemakrs','method'=>'POST')) !!}
                <div class="modal-body">
                  আপনি কি নিশ্চিতভাবে চেকবক্সে নির্বাচিত আবেদনকারীদের পেমেন্ট দাখিল করতে চান?
                  {!! Form::hidden('application_ids', null, ['id' => 'application_ids', 'required' => '']) !!}
                  {!! Form::hidden('class', null) !!}
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                {!! Form::close() !!}
                </div>
              </div>
            </div>
          </div>
          {{-- submit marks modal --}}
        </div>
        <!-- /.box-body -->
      </div>
    </div>
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
@stop