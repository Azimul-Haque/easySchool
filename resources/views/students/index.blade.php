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
	<div class="row">
		<div class="col-md-2">
			<input type="text" name="" placeholder="Name" class="form-control">
		</div>
		<div class="col-md-2">
			<select class="form-control">
				<option selected="" disabled="">Class</option>
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
			</select>
		</div>	
		<div class="col-md-2">
			<select class="form-control">
				<option selected="" disabled="">Year</option>
				<option>2015</option>
				<option>2016</option>
				<option>2017</option>
				<option>2018</option>
				<option>2020</option>
			</select>
		</div>
	</div><br/>
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>No</th>
					<th>Name</th>
					<th>Class</th>
					<th width="280px">Action</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($students as $key => $student)
				@if ($student->class == true)
				
				<tr>
					<td>{{ ++$i }}</td>
					<td>{{ $student->name }}</td>
					<td>{{ $student->class }}</td>
					<td>
						<a class="btn btn-info btn-sm" href="{{ route('students.show',$student->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
						
						<a class="btn btn-primary btn-sm" href="{{ route('students.edit',$student->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
				    {{-- delete modal--}}
				    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $student->id }}" data-backdrop="static"><i class="fa fa-trash" aria-hidden="true"></i></button>
				      	<!-- Trigger the modal with a button -->
			        	<!-- Modal -->
				        <div class="modal fade" id="deleteModal{{ $student->id }}" role="dialog">
				          <div class="modal-dialog modal-md">
				            <div class="modal-content">
				              <div class="modal-header modal-header-danger">
				                <button type="button" class="close" data-dismiss="modal">&times;</button>
				                <h4 class="modal-title">Delete confirmation</h4>
				              </div>
				              <div class="modal-body">
				                Delete student <b>{{ $student->name }}</b>?
				              </div>
				              <div class="modal-footer">
				                {!! Form::model($student, ['route' => ['students.destroy', $student->id], 'method' => 'DELETE']) !!}
				                    <button type="submit" class="btn btn-danger">Delete</button>
				                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				                {!! Form::close() !!}
				              </div>
				            </div>
				          </div>
				        </div>
			      {{-- delete modal--}}
					</td>
				</tr>
				@endif
			@endforeach
			</tbody>
		</table>
	</div>
	{!! $students->render() !!}
	@endpermission
@stop