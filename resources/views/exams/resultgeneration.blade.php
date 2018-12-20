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
      ফলাফল তৈরি
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
    <div class="col-md-3">
      <div class="box box-primary">
        <div class="box-header with-border text-blue">
          <i class="fa fa-fw fa-graduation-cap"></i>
          <h3 class="box-title">ফলাফল তৈরি করুন</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {{-- {!! Form::open(['route' => 'reports.getcommoditypdf', 'method' => 'GET']) !!}
            <div class="form-group">
              {!! Form::text('from', null, array('class' => 'form-control text-blue', 'required' => '', 'placeholder' => 'Enter From Date', 'id' => 'fromcomexDate', 'autocomplete' => 'off')) !!}
            </div>
            <div class="form-group">
              {!! Form::text('to', null, array('class' => 'form-control text-blue', 'required' => '', 'placeholder' => 'Enter To Date', 'id' => 'tocomexDate', 'autocomplete' => 'off')) !!}
            </div>
          <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> Get Report</button>
          {!! Form::close() !!} --}}
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-3">
      <div class="box box-success">
        <div class="box-header with-border text-green">
          <i class="fa fa-fw fa-list-alt"></i>
          <h3 class="box-title">ট্যাবুলেশন শিট তৈরি করুন</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {{-- {!! Form::open(['route' => 'reports.getcommoditypdf', 'method' => 'GET']) !!}
            <div class="form-group">
              {!! Form::text('from', null, array('class' => 'form-control text-green', 'required' => '', 'placeholder' => 'Enter From Date', 'id' => 'fromcomexDate', 'autocomplete' => 'off')) !!}
            </div>
            <div class="form-group">
              {!! Form::text('to', null, array('class' => 'form-control text-green', 'required' => '', 'placeholder' => 'Enter To Date', 'id' => 'tocomexDate', 'autocomplete' => 'off')) !!}
            </div>
          <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> Get Report</button>
          {!! Form::close() !!} --}}
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-3">
      <div class="box box-warning">
        <div class="box-header with-border text-orange">
          <i class="fa fa-fw fa-file-text-o"></i>
          <h3 class="box-title">নম্বরপত্র (মার্কশিট) তৈরি করুন</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {{-- {!! Form::open(['route' => 'reports.getcommoditypdf', 'method' => 'GET']) !!}
            <div class="form-group">
              {!! Form::text('from', null, array('class' => 'form-control text-orange', 'required' => '', 'placeholder' => 'Enter From Date', 'id' => 'fromcomexDate', 'autocomplete' => 'off')) !!}
            </div>
            <div class="form-group">
              {!! Form::text('to', null, array('class' => 'form-control text-orange', 'required' => '', 'placeholder' => 'Enter To Date', 'id' => 'tocomexDate', 'autocomplete' => 'off')) !!}
            </div>
          <button class="btn btn-warning" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> Get Report</button>
          {!! Form::close() !!} --}}
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
  @endpermission
@stop

@section('js')
  {{-- {!!Html::script('js/select2.min.js')!!} --}}
  <script type="text/javascript">
    $(function(){
     $('a[title]').tooltip();
     $('button[title]').tooltip();
    });
  </script>
@stop