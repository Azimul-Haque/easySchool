@extends('adminlte::page')

@section('title', 'Easy School | Users')

@section('content_header')
    <h1>
    	Users Management
	    <div class="pull-right">
			  <a class="btn btn-success" href="{{ route('users.create') }}"> Create New Headmaster</a>
			</div>
		</h1>
@stop

@section('content')
  @permission('user-crud')
	{{-- @if ($message = Session::get('success'))
		<div class="alert alert-success">
			<p>{{ $message }}</p>
		</div>
	@endif --}}
	<h4>Super Admin</h4>
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>No</th>
					<th>Name</th>
					<th>Email</th>
					<th>Roles</th>
					<th width="280px">Action</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($superadmins[0]->users as $key => $user)
				<tr>
					<td></td>
					<td><a class="link bold" href="{{ route('users.show',$user->id) }}">{{ $user->name }}</a></td>
					<td>{{ $user->email }}</td>
					<td>
						@if(!empty($user->roles))
							@foreach($user->roles as $v)
								<label class="label label-success">{{ $v->display_name }}</label>
							@endforeach
						@endif
					</td>
					<td>
						<a class="btn btn-primary btn-sm" href="{{ route('users.edit',$user->id) }}">
							<i class="fa fa-pencil"></i>
						</a>
				    {{-- delete modal--}}
				    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $user->id }}" data-backdrop="static"
							@if($user->roles()->where('name', 'superadmin')->exists())  disabled="true"  @endif
				    	><i class="fa fa-trash" aria-hidden="true"></i></button>
				      	<!-- Trigger the modal with a button -->
			        	<!-- Modal -->
				        <div class="modal fade" id="deleteModal{{ $user->id }}" role="dialog">
				          <div class="modal-dialog modal-md">
				            <div class="modal-content">
				              <div class="modal-header modal-header-danger">
				                <button type="button" class="close" data-dismiss="modal">&times;</button>
				                <h4 class="modal-title">Delete confirmation</h4>
				              </div>
				              <div class="modal-body">
				                Delete user <b>{{ $user->name }}</b>?
				              </div>
				              <div class="modal-footer">
				                {!! Form::model($user, ['route' => ['users.destroy', $user->id], 'method' => 'DELETE']) !!}
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

			<h4>Headmasters</h4>
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Email</th>
							<th>Roles</th>
							<th>School</th>
							<th width="280px">Action</th>
						</tr>
					</thead>
					<tbody>
					@foreach ($headmasters[0]->users as $key => $user)
						<tr>
							<td></td>
							<td><a class="link bold" href="{{ route('users.show',$user->id) }}">{{ $user->name }}</a></td>
							<td>{{ $user->email }}</td>
							<td>
								@if(!empty($user->roles))
									@foreach($user->roles as $v)
										<label class="label label-success">{{ $v->display_name }}</label>
									@endforeach
								@endif
							</td>
							<td>{{ $user->school->name }}-{{ $user->school->eiin }}</td>
							<td>
								<a class="btn btn-primary btn-sm" href="{{ route('users.edit',$user->id) }}">
									<i class="fa fa-pencil"></i>
								</a>
						    {{-- delete modal--}}
						    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $user->id }}" data-backdrop="static"
									@if($user->roles()->where('name', 'superadmin')->exists())  disabled="true"  @endif
						    	><i class="fa fa-trash" aria-hidden="true"></i></button>
						      	<!-- Trigger the modal with a button -->
					        	<!-- Modal -->
						        <div class="modal fade" id="deleteModal{{ $user->id }}" role="dialog">
						          <div class="modal-dialog modal-md">
						            <div class="modal-content">
						              <div class="modal-header modal-header-danger">
						                <button type="button" class="close" data-dismiss="modal">&times;</button>
						                <h4 class="modal-title">Delete confirmation</h4>
						              </div>
						              <div class="modal-body">
						                Delete user <b>{{ $user->name }}</b>?
						              </div>
						              <div class="modal-footer">
						                {!! Form::model($user, ['route' => ['users.destroy', $user->id], 'method' => 'DELETE']) !!}
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
	@endpermission
@stop