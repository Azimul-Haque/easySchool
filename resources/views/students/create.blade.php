@extends('adminlte::page')

@section('title', 'Easy School')

@section('css')
    {!!Html::style('css/bootstrap-datepicker.min.css')!!}
@stop

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2>Create New Student</h2>
	        </div>
	        <div class="pull-right">
	            <a class="btn btn-primary" href="{{ route('students.index') }}"> Back</a>
	        </div>
	    </div>
	</div>
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	{!! Form::open(array('route' => 'students.store','method'=>'POST')) !!}
	<div class="row">
		<div class="col-md-6">
            <div class="form-group">
                <strong>Name:</strong>
                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <strong>Class:</strong>
                {!! Form::number('class', null, array('placeholder' => 'Class','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <strong>Roll:</strong>
                {!! Form::number('roll', null, array('placeholder' => 'Roll','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <strong>Date of Birth:</strong>
                {!! Form::text('dob', null, array('id' => 'datepicker1','placeholder' => 'Date of Birth','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <strong>Father:</strong>
                {!! Form::text('father', null, array('placeholder' => 'Father','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <strong>Mother:</strong>
                {!! Form::text('mother', null, array('placeholder' => 'Mother','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <strong>Address:</strong>
                {!! Form::textarea('address', null, array('placeholder' => 'Address','class' => 'form-control textarea', 'rows' => '5')) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <strong>Contact:</strong>
                {!! Form::text('contact', null, array('placeholder' => 'Contact','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <strong>Session:</strong>
                {!! Form::number('session', '2017', array('placeholder' => 'Session','class' => 'form-control')) !!}
            </div>
        </div>

        {{--<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                {!! Form::textarea('description', null, array('placeholder' => 'Description','class' => 'form-control','style'=>'height:100px')) !!}
            </div>
        </div> --}}
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
				<button type="submit" class="btn btn-primary">Submit</button>
        </div>
	</div>
	{!! Form::close() !!}
@stop

@section('js')
    {!!Html::script('js/bootstrap-datepicker.min.js')!!}
    <script type="text/javascript">
        $('#datepicker1').datepicker({
            format: 'MM dd, yyyy',
            autoclose: true,
            todayHighlight: true,
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
    </script>
@stop