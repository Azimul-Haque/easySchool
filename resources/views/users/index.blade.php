@extends('adminlte::page')

@section('title', 'Easy School | Users')

@section('content_header')
    <h1>
    	Users Management
	    <div class="pull-right">
		    <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
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
			@foreach ($data as $key => $user)
				<tr>
					<td>{{ ++$i }}</td>
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
						{!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
			            <button class="btn btn-danger btn-sm" type="submit">
							<i class="fa fa-trash-o"></i>
						</button>
			        	{!! Form::close() !!}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>	
	</div>
	{!! $data->render() !!}
    @endpermission
@stop