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
              <th width="">মো
                ট ({{ $examsubject->total }})</th>
            </tr>
          </thead>
          <tbody>
            @foreach($students as $student)
              <tr>
                <td>{{ $student->roll }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->student_id }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
          <h3 class="box-title">নম্বর প্রদান রিপোর্ট</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          test
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