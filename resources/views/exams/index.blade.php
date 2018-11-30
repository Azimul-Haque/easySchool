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
          <a href="{{ route('exams.create') }}" class="btn btn-success btn-sm">নতুন পরীক্ষা যোগ করুন</a>
      </div>  
    </h1>
@stop

@section('content')
  
@stop

@section('js')

@stop