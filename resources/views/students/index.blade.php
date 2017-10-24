@extends('adminlte::page')

@section('title', 'Easy School')

@section('content_header')
    <h1>
    	Students
    	<div class="pull-right">
	        <a class="btn btn-success" href="{{ route('students.create') }}"> Create New Student</a>
	    </div>	
    </h1>
@stop

@section('content')
    @permission('student-crud')
	{{-- @if ($message = Session::get('success'))
		<div class="alert alert-success">
			<p>{{ $message }}</p>
		</div>
	@endif --}}
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>No</th>
					<th>Title</th>
					<th>Description</th>
					<th width="280px">Action</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($students as $key => $student)
				<tr>
					<td>{{ ++$i }}</td>
					<td>{{ $student->name }}</td>
					<td>{{ $student->roll }}</td>
					<td>
						<a class="btn btn-info" href="{{ route('students.show',$student->id) }}">Show</a>
						
						<a class="btn btn-primary" href="{{ route('students.edit',$student->id) }}">Edit</a>
						{!! Form::open(['method' => 'DELETE','route' => ['students.destroy', $student->id],'style'=>'display:inline']) !!}
			            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
			        	{!! Form::close() !!}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	{!! $students->render() !!}
	@endpermission
@stop