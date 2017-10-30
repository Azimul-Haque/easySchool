@extends('adminlte::page')

@section('title', 'Easy School')

@section('content_header')
    <h1>
      School Settings
      <div class="pull-right">
        <a class="btn btn-primary" href="{{ route('dashboard') }}"> Back</a>
      </div>
    </h1>
@stop

@section('content')
  {!! Form::model($settings, ['method' => 'PATCH','route' => ['settings.update', $settings->id]]) !!}
  <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Current Session</strong>
                <select class="form-control" name="currentsession">
                @php
                  $y = 2012;
                  for($y; $y<=2038; $y++) {
                @endphp
                    <option value="{{ $y }}" @if($y == $settings->currentsession) {{ 'selected' }} @endif>{{ $y }}</option>
                @php
                  }
                @endphp
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Classes:</strong>
                <br/>
                @php
                $classes = explode(',', $settings->classes);
                @endphp
                @for($clss = -2;$clss<=10;$clss++)
                  <label style="margin-right: 40px;">
                  <input type="checkbox" name="classes[]" value="{{ $clss }}" class="classes" 
                  @if(in_array($clss, $classes)) {{ 'checked' }} @endif
                  /> {{ $clss }}
                  </label>
                @endfor
            </div>    
        </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
        </div>
  </div>
  {!! Form::close() !!}
@stop