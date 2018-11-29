@extends('adminlte::page')

@section('title', 'Easy School | Teachers')

@section('content_header')
    <h1>
        বিষয় যোগ করুন
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('subjects.index') }}"> ফিরে যান</a>
        </div>
    </h1>
@stop

@section('content')
    {!! Form::model($subject, ['route' => ['subjects.update', $subject->id], 'method' => 'PUT']) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="well">
                <div class="form-group">
                    <strong>নাম (বাংলায়)</strong>
                    {!! Form::text('name_bangla', null, array('placeholder' => 'বাংলায় বিষয়ের নাম','class' => 'form-control', 'id' => 'name_bangla', 'required' => '')) !!}
                </div>
                <div class="form-group">
                    <strong>নাম (ইংরেজিতে)</strong>
                    {!! Form::text('name_english', null, array('placeholder' => 'ইংরেজিতে বিষয়ের নাম','class' => 'form-control', 'id' => 'name_english', 'required' => '')) !!}
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
        $('#name_english').keyup(function(){
            this.value = this.value.toUpperCase();
        });
    });
</script>
@stop