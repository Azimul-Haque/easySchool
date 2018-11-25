@extends('adminlte::page')

@section('title', 'Easy School | Search Student')

@section('css')

@stop

@section('content_header')
    <h1><i class="fa fa-fw fa-search"></i> শিক্ষার্থী খুঁজুন</u>
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

<div class="row">
  <div class="col-md-8">
    <table class="table">
      <thead>
        <tr>
          <th colspan="2"><i class="fa fa-fw fa-address-card"></i> শিক্ষার্থী তথ্য</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="30%">নাম</th>
          <td>{{ $student->name }}</td>
        </tr>
        <tr>
          <th>পিতার নাম</th>
          <td>{{ $student->father }}</td>
        </tr>
        <tr>
          <th>মাতার নাম</th>
          <td>{{ $student->mother }}</td>
        </tr>
        <tr>
          <th>জন্মতারিখ</th>
          <td>{{ date('F d, Y', strtotime($student->dob)) }}</td>
        </tr>
        <tr>
          <th>যোগাযোগ</th>
          <td>{{ $student->contact }}, {{ $student->contact_2 }}</td>
        </tr>
        <tr>
          <th>ঠিকানা</th>
          <td>{{ $student->village }}, {{ $student->post_office }}, {{ $student->upazilla }}, {{ $student->district }}</td>
        </tr>
      </tbody>
    </table>
    <table class="table">
      <thead>
        <tr>
          <th colspan="2"><i class="fa fa-fw fa-book"></i> অ্যাকাডেমিক তথ্য</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="30%">শ্রেণি</th>
          <td>{{ bangla_class($student->class) }}</td>
        </tr>
        <tr>
          <th>শাখা</th>
          <td>{{ bangla_section(Auth::user()->school->section_type , $student->class, $student->section) }}</td>
        </tr>
        <tr>
          <th>রোল</th>
          <td>{{ bangla($student->roll) }}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="col-md-4">
    <center>
      @if(file_exists(public_path('images/admission-images/'.$student->image)))
        <img src="{{ asset('images/admission-images/'.$student->image) }}" class="image150 shadow">
      @else
        <img src="{{ asset('images/dummy_student.jpg') }}" class="image150 shadow">
      @endif
    </center><br/>

    <table class="table">
      <thead>
        <tr>
          <th colspan="2"><i class="fa fa-fw fa-graduation-cap"></i> বিগত বছরের ফলাফল</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th></th>
          <td></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@stop

@section('js')
   
@stop
