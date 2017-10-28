@extends('adminlte::page')

@section('title', 'Easy School')

@section('content_header')
    <h1>
    	Roles
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
						<a class="btn btn-info btn-sm" href="{{ route('roles.show',$role->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
						<a class="btn btn-primary btn-sm" href="{{ route('roles.edit',$role->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
						{{-- delete modal--}}
						<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $role->id }}" data-backdrop="static"><i class="fa fa-trash" aria-hidden="true"></i></button>
			      	<!-- Trigger the modal with a button -->
		        	<!-- Modal -->
			        <div class="modal fade" id="deleteModal{{ $role->id }}" role="dialog">
			          <div class="modal-dialog modal-md">
			            <div class="modal-content">
			              <div class="modal-header modal-header-danger">
			                <button type="button" class="close" data-dismiss="modal">&times;</button>
			                <h4 class="modal-title">Delete confirmation</h4>
			              </div>
			              <div class="modal-body">
			                Delete role <b>{{ $role->display_name }}</b>?
			              </div>
			              <div class="modal-footer">
			                {!! Form::model($role, ['route' => ['roles.destroy', $role->id], 'method' => 'DELETE']) !!}
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
			@endforeach
			</tbody>
		</table>	
	</div>
	{!! $roles->render() !!}
    @endpermission
@stop