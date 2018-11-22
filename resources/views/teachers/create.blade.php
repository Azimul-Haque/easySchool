@extends('adminlte::page')

@section('title', 'Easy School | Teachers')

@section('content_header')
    <h1>
        শিক্ষক তৈরি করুন
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('teachers.index') }}"> ফিরে যান</a>
        </div>
    </h1>
@stop

@section('content')
    {!! Form::open(array('route' => 'teachers.store','method'=>'POST')) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="well">
                <div class="form-group">
                    <strong>নাম (ইংরেজিতে)</strong>
                    {!! Form::text('name', null, array('placeholder' => 'ইংরেজিতে নাম','class' => 'form-control', 'id' => 'name', 'required' => '')) !!}
                </div>
                <div class="form-group">
                    <strong>ইমেইল</strong>
                    {!! Form::email('email', null, array('placeholder' => 'ইমেইল','class' => 'form-control', 'required' => '')) !!}
                </div>
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
        </div>
    </div>
    {!! Form::close() !!}
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

