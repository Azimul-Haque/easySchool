@extends('adminlte::page')

@section('title', 'Easy School')

@section('content_header')
    <h1>
    	Dashboard
    	<div class="pull-right">
	        <a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role</a>
	    </div>
    </h1>
@stop

@section('content')
    @permission('role-crud')
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
					<th>Name</th>
					<th>Description</th>
					<th width="280px">Action</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($roles as $key => $role)
				<tr>
					<td>{{ ++$i }}</td>
					<td>{{ $role->display_name }}</td>
					<td>{{ $role->description }}</td>
					<td>
						<a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
						<a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
						{!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
			            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
			        	{!! Form::close() !!}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>	
	</div>
	{!! $roles->render() !!}
    @endpermission
@stop