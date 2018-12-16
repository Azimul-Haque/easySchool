@extends('adminlte::page')

@section('title', 'Easy School | Users')

@section('content_header')
    <h1>
      শিক্ষক ব্যাবস্থাপনা
      <div class="pull-right">
        <a class="btn btn-success btn-sm" href="{{ route('teachers.create') }}"><i class="fa fa-fw fa-user-plus"></i> নতুন শিক্ষক যোগ করুন</a>
      </div>
    </h1>
    
@stop

@section('content')
  @permission('teacher-management')
  {{-- @if ($message = Session::get('success'))
    <div class="alert alert-success">
      <p>{{ $message }}</p>
    </div>
  @endif --}}
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>ক্র. নং</th>
          <th>নাম</th>
          <th>ইমেইল এড্রেস</th>
          <th>ধরণ</th>
          <th>কার্যকলাপ</th>
        </tr>
      </thead>
      <tbody>
      @php
        $counter = 1;
      @endphp
      @foreach ($teachers as $user)
        <tr>
          <td>{{ $counter }}</td>
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
            {{-- edit modal--}}
            <a class="btn btn-primary btn-sm" href="{{ route('teachers.edit', $user->id) }}">
              <i class="fa fa-pencil"></i>
            </a>
            {{-- delete modal--}}
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $user->id }}" data-backdrop="static"
              @if($user->roles()->where('name', 'superadmin')->exists())  disabled="true"  @endif
              @if($user->roles()->where('name', 'headmaster')->exists())  disabled="true"  @endif
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
                        {!! Form::model($user, ['route' => ['teachers.destroy', $user->id], 'method' => 'DELETE']) !!}
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
        @php
          $counter++;
        @endphp
      @endforeach
      </tbody>
      </table>  
      </div>
  @endpermission
@stop

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.multiple').select2();
        });
    </script>

    <script type="text/javascript">
      $(function () {
        $('#example1').DataTable()
        $('#datatable-headmasters').DataTable({
          'paging'      : true,
          'pageLength'  : 10,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : true,
          columnDefs: [
              { targets: [5], visible: true, searchable: false},
              { targets: '_all', visible: true, searchable: true }
          ]
        })
      })

    </script>
@stop