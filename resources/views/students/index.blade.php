@extends('adminlte::page')

@section('title', 'Easy School')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2>Students CRUD</h2>
	        </div>
	        <div class="pull-right">
	        	@permission('student-create')
	            <a class="btn btn-success" href="{{ route('students.create') }}"> Create New Student</a>
	            @endpermission
	        </div>
	    </div>
	</div>
	@if ($message = Session::get('success'))
		<div class="alert alert-success">
			<p>{{ $message }}</p>
		</div>
	@endif
	<table class="table table-bordered">
		<tr>
			<th>No</th>
			<th>Title</th>
			<th>Description</th>
			<th width="280px">Action</th>
		</tr>
	@foreach ($students as $key => $student)
	<tr>
		<td>{{ ++$i }}</td>
		<td>{{ $student->name }}</td>
		<td>{{ $student->roll }}</td>
		<td>
			<a class="btn btn-info" href="{{ route('students.show',$student->id) }}">Show</a>
			@permission('student-edit')
			<a class="btn btn-primary" href="{{ route('students.edit',$student->id) }}">Edit</a>
			@endpermission
			@permission('student-delete')
			{!! Form::open(['method' => 'DELETE','route' => ['students.destroy', $student->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
        	{!! Form::close() !!}
        	@endpermission
     
		</td>
	</tr>
	@endforeach
	</table>
	{!! $students->render() !!}
@stop