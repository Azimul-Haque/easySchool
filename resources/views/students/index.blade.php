@extends('adminlte::page')

@section('title', 'Easy School')

@section('css')
	<style type="text/css">
		.hiddenCheckbox, .hiddenFinalSaveBtn {
			display:none;
		}
	</style>
@stop

@section('content_header')
    <h1>
    	শিক্ষার্থী তালিকা
    	<div class="pull-right">
	        <a class="btn btn-success btn-sm" href="{{ route('students.create') }}"> সরাসরি শিক্ষার্থী ভর্তি</a>
	        <button class="btn btn-primary btn-sm" id="showCheckbox"><i class="fa fa-graduation-cap"></i> শ্রেণি উন্নীতকরণ</button>
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
				<select class="form-control" id="search_class">
					<option selected="" disabled="" value="">শ্রেণি নির্ধারণ করুন</option>
					@php
						$classes = explode(',', Auth::user()->school->classes);
					@endphp
					@foreach($classes as $class)
					<option value="{{ $class }}" @if($classsearch == $class) selected="" @endif>Class {{ $class }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-2">
				<select class="form-control" id="search_section">
					<option selected="" disabled="" value="">সেকশন নির্ধারণ করুন</option>
					<option value="A" @if($sectionsearch == 'A') selected="" @endif>A</option>
					<option value="B" @if($sectionsearch == 'B') selected="" @endif>B</option>
					<option value="C" @if($sectionsearch == 'C') selected="" @endif>C</option>
				</select>
			</div>	
			<div class="col-md-2">
				<select class="form-control" id="search_session">
					<option selected="" disabled="">শিক্ষাবর্ষ নির্ধারণ করুন</option>
					@for($optionyear = (date('Y')+1) ; $optionyear>=(Auth::user()->school->established); $optionyear--)
					<option value="{{ $optionyear }}" 
					@if($sessionsearch == null)
						@if($optionyear == date('Y')) selected="" @endif
					@else
						@if($sessionsearch == $optionyear) selected="" @endif
					@endif
					>{{ $optionyear }}</option>
					@endfor
				</select>
			</div>
			<div class="col-md-2">
				<button class="btn btn-primary btn-sm" id="search_students_btn"><i class="fa fa-fw fa-search"></i> শিক্ষার্থী তালিকা</button>
			</div>
	</div>

	<div class="table-responsive" style="margin-top: 5px;">
		@if($students == true)
		<table class="table" id="datatable-students">
			<thead>
				<tr>
					<th class="hiddenCheckbox" id="hiddenCheckbox"></th>
					<th>Roll</th>
					<th>Name</th>
					<th>Class</th>
					<th>Section</th>
					<th>Photo</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($students as $key => $student)
				<tr>
					<td class="hiddenCheckbox" id="hiddenCheckbox">
						<input type="checkbox" name="student_check_ids[]" value="{{ $student->id }}">
					</td>
					<td>{{ $student->roll }}</td>
					<td>{{ $student->name }}</td>
					<td>{{ $student->class }}</td>
					<td>{{ $student->section }}</td>
					<td>
						<img src="{{ asset('images/admission-images/'.$student->image) }}" style="width: 35px;">
					</td>
					<td>
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
			@endforeach
			</tbody>
		</table>
		@endif
	</div>
	{{-- final select modal--}}
	<button class="btn btn-success hiddenFinalSaveBtn" id="hiddenFinalSaveBtn" data-toggle="modal" data-target="#promoteModal" data-backdrop="static">নতুন ক্লাসে উন্নীত করুন</button>
	<!-- Trigger the modal with a button -->
    	<!-- Modal -->
      <div class="modal fade" id="promoteModal" role="dialog">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header modal-header-success">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">নতুন শ্রেণিতে উন্নীতকরণ</h4>
            </div>
            {!! Form::open(array('route' => 'students.promotebulk','method'=>'POST')) !!}
            <div class="modal-body">
              আপনি কি নিশ্চিতভাবে চেকবক্সে নির্বাচিত শিক্ষার্থীদের চূড়ান্তভাবে নিম্ননির্ধারিত শ্রেণিতে উন্নীত করতে চান?
              {!! Form::hidden('student_ids', null, ['id' => 'student_ids', 'required' => '']) !!}
              <div class="form-group">
              	<label for="promotion_class"><strong>শ্রেণি নির্ধারণ করুন</strong></label>
								<select class="form-control" id="promotion_class" name="promotion_class">
									<option selected="" disabled="" value="">শ্রেণি নির্ধারণ করুন</option>
									@php
										$classes = explode(',', Auth::user()->school->classes);
									@endphp
									@foreach($classes as $class)
									<option value="{{ $class }}">Class {{ $class }}</option>
									@endforeach
								</select>
							</div>	
							<div class="form-group">
								<label for="promotion_session"><strong>শ্রেণি নির্ধারণ করুন</strong></label>
								<select class="form-control" id="promotion_session" name="promotion_session">
									<option selected="" disabled="">শিক্ষাবর্ষ নির্ধারণ করুন</option>
									@for($optionyear = (date('Y')+1) ; $optionyear>=(Auth::user()->school->established); $optionyear--)
									<option value="{{ $optionyear }}" @if($optionyear == date('Y')) selected="" @endif>{{ $optionyear }}</option>
									@endfor
								</select>
							</div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Save</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>
  {{-- final select modal--}}
	@endpermission
@stop

@section('js')
<script type="text/javascript">
	$(function () {
  	  $('#example1').DataTable()
  	  $('#datatable-students').DataTable({
  	    'paging'      : true,
  	    'pageLength'  : 10,
  	    'lengthChange': true,
  	    'searching'   : true,
  	    'ordering'    : true,
  	    'info'        : true,
  	    'autoWidth'   : true,
  	    'order': [[ 0, "asc" ]],
	       // columnDefs: [
	       //    { targets: [5], type: 'date'}
	       // ]
  	  })
  	})
	  $(document).ready(function() {
	  	$('#search_students_btn').click(function() {
	  		if($('#search_class').val() && $('#search_section').val() && $('#search_session').val()) {
		  		window.location.href = window.location.protocol + "//" + window.location.host + "/students/"+$('#search_session').val()+"/"+$('#search_class').val()+"/"+$('#search_section').val();
		  	} else {
		  		toastr.warning('শ্রেণি, শাখা এবং শিক্ষাবর্ষ সবগুলো সিলেক্ট করুন!');
		  	}
	  	})

	  	$('#showCheckbox').click(function() {
	    	$('td:nth-child(1)').toggleClass('hiddenCheckbox');
	    	$('th:nth-child(1)').toggleClass('hiddenCheckbox');
	    	$('#hiddenFinalSaveBtn').toggleClass('hiddenFinalSaveBtn');
	    });
	    $('#hiddenFinalSaveBtn').click(function() {
	    	var checked = [];
				$("input[name='student_check_ids[]']:checked").each(function ()
				{
				    checked.push($(this).val());
				});
				$('#student_ids').val(checked);
				if($('#student_ids').val() == '') {
					toastr.warning('অন্তত একজন শিক্ষার্থী নির্বাচন করুন!', 'Warning').css('width','400px');
					
					setTimeout(function() {
            $('#promoteModal').modal('hide');
          }, 1000);
				}
				console.log(checked);
	    });

	  })
</script>
@stop