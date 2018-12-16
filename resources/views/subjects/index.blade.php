@extends('adminlte::page')

@section('title', 'Easy School | Subjects')

@section('content_header')
    <h1>
      বিষয় ব্যবস্থাপনা
      <div class="pull-right">
        <a class="btn btn-success btn-sm" href="{{ route('subjects.create') }}"><i class="fa fa-fw fa-book"></i> নতুন বিষয় যোগ করুন</a>
      </div>
    </h1>
    
@stop

@section('content')
  @permission('universal-subjects')
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>No</th>
          <th>নাম (বাংলায়)</th>
          <th>নাম (ইংরেজিতে)</th>
          <th>কার্যকলাপ</th>
        </tr>
      </thead>
      <tbody>
      @php
        $counter = 1;
      @endphp
      @foreach ($subjects as $subject)
        <tr>
          <td>{{ $counter }}</td>
          <td>{{ $subject->name_bangla }}</td>
          <td>{{ $subject->name_english }}</td>
          <td>
            {{-- edit modal--}}
            <a class="btn btn-primary btn-sm" href="{{ route('subjects.edit', $subject->id) }}">
              <i class="fa fa-pencil"></i>
            </a>
            {{-- delete modal--}}
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $subject->id }}" data-backdrop="static"><i class="fa fa-trash" aria-hidden="true"></i></button>
                <!-- Trigger the modal with a button -->
                <!-- Modal -->
                <div class="modal fade" id="deleteModal{{ $subject->id }}" role="dialog">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Delete confirmation</h4>
                      </div>
                      <div class="modal-body">
                        Delete Subject <b>{{ $subject->name_bangla }} ({{ $subject->name_english }})</b>?
                      </div>
                      <div class="modal-footer">
                        {!! Form::model($subject, ['route' => ['subjects.destroy', $subject->id], 'method' => 'DELETE']) !!}
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