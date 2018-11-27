@extends('adminlte::page')

@section('title', 'Easy School | Search Student')

@section('css')

@stop

@section('content_header')
    <h1>শিক্ষার্থী খুঁজুন</u>
    <div class="pull-right">
        <a class="btn btn-primary" href="{{ url()->previous() }}"> Back</a>
    </div>
    </h1>
@stop

@section('content')
<div class="row">
  <div class="col-md-12">
    {!! Form::open(array('route' => 'students.search','method'=>'GET', 'class' => '')) !!}
      <div class="row">
        <div class="col-md-8">
          <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                {!! Form::text('student_id', null, array('placeholder' => 'স্টুডেন্ট আইডি','class' => 'form-control', 'id' => 'student_id', 'required' => '')) !!}
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                </span>
              </div>
          </div>
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
@stop

@section('js')
   
@stop
