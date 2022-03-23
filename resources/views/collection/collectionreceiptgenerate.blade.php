@extends('adminlte::page')

@section('title', 'Easy School | Input Form')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
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
        padding: 5px;
        -moz-appearance:textfield; /* Firefox */
    } 
  </style>
@stop

@section('content_header')
    <h1>
        কাজ চলছে...
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('collection.index') }}"><i class="fa fa-money"></i> আদায় ব্যবস্থাপনা</a></li>
      <li class="active">রশিদ ডাউনলোড</li>
    </ol>
@stop

@section('content')
  @permission('student-crud')
    
  @endpermission
@stop

@section('js')

@stop