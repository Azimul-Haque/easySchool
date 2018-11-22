@extends('adminlte::page')

@section('title', 'Easy School | Edit Teacher')

@section('content_header')
    <h1>
        শিক্ষক {{ $teacher->name }}-এর তথ্য সম্পাদনা করুন 
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('teachers.index') }}"> ফিরে যান</a>
        </div>
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3">
            {!! Form::model($teacher, ['route' => ['teachers.resetpassword', $teacher->id], 'method' => 'PUT']) !!}
                <div class="well">
                    <span style="font-size: 20px;">পাসওয়ার্ড পরিবর্তন করুন</span>
                    <div class="form-group">
                        <strong>পাসওয়ার্ড</strong>
                        {!! Form::password('password', array('placeholder' => 'পাসওয়ার্ড','class' => 'form-control', 'required' => '')) !!}
                    </div>
                    <div class="form-group">
                        <strong>কনফার্ম পাসওয়ার্ড</strong>
                        {!! Form::password('confirm-password', array('placeholder' => 'কনফার্ম পাসওয়ার্ড','class' => 'form-control', 'required' => '')) !!}
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">দাখিল করুন</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('#name').keyup(function(){
            this.value = this.value.toUpperCase();
        });
    });
</script>
@stop

