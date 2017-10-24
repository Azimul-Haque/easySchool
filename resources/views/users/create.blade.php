@extends('adminlte::page')

@section('title', 'Easy School | Users')

@section('content_header')
    <h1>
        Create User
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
        </div>
    </h1>
@stop

@section('content')
    {{-- @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}
    {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="well">
                <div class="form-group">
                    <strong>Name:</strong>
                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <strong>Email:</strong>
                    {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <strong>Password:</strong>
                    {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <strong>Confirm Password:</strong>
                    {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <strong>Role:</strong>
                    {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                </div>
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop