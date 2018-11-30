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
    	শিক্ষার্থী তালিকাঃ <span style="color: #008000;">[শিক্ষাবর্ষঃ {{ bangla($sessionsearch) }}, শ্রেণিঃ {{ bangla_class($classsearch) }}, শাখাঃ {{ bangla_section(Auth::user()->school->section_type, $classsearch, $sectionsearch) }}]</span>
    	<div class="pull-right btn-group">
          @if($classsearch == 8)
          <a href="{{ route('students.gettotlist8pdf', [$sessionsearch, $classsearch, $sectionsearch]) }}" class="btn btn-brown btn-sm" title="JSC  TOT List প্রিন্ট করুন" target="_blank">
            <i class="fa fa-print"></i> JSC TOT List
          </a>
          @endif
          @if($classsearch > 8)
          <a href="{{ route('students.gettotlist9pdf', [$sessionsearch, $classsearch, $sectionsearch]) }}" class="btn btn-brown btn-sm" title="SSC  TOT List প্রিন্ট করুন" target="_blank">
            <i class="fa fa-print"></i> SSC TOT List
          </a>
          @endif
          @if($classsearch > 7)
          <a href="{{ route('students.getcardregisterlistpdf', [$sessionsearch, $classsearch, $sectionsearch]) }}" class="btn btn-warning btn-sm" title="@if($classsearch == 8) JSC @elseif($classsearch > 8) SSC @endif  রেজিঃ কার্ড, এডমিট কার্ড, মার্কশিট, সার্টিফিকেট প্রদান রেজিস্টার প্রিন্ট করুন" target="_blank">
            <i class="fa fa-print"></i> @if($classsearch == 8) JSC @elseif($classsearch > 8) SSC @endif কার্ড প্রদান রেজিস্টার
          </a>
          @endif
          <a href="{{ route('students.getstudentlistpdf', [$sessionsearch, $classsearch, $sectionsearch]) }}" class="btn btn-success btn-sm" title="শিক্ষার্থী তালিকা-{{ bangla($sessionsearch) }} তৈরি করুন" target="_blank">
            <i class="fa fa-print"></i> শিক্ষার্থী তালিকা-{{ bangla($sessionsearch) }}
          </a>
	        <a class="btn btn-primary btn-sm" href="{{ route('students.create') }}"><i class="fa fa-user-plus"></i>  সরাসরি শিক্ষার্থী ভর্তি</a>
	        {{-- <button class="btn btn-primary btn-sm" id="showCheckbox" disabled=""><i class="fa fa-graduation-cap"></i> শ্রেণি উন্নীতকরণ</button> --}}
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
      @if(Auth::user()->school->sections > 0)
			<div class="col-md-2">
				<select class="form-control" id="search_section">
					<option selected="" disabled="" value="">সেকশন নির্ধারণ করুন</option>
          @if($classsearch < 9)
  					<option value="1" @if($sectionsearch == 1) selected="" @endif>A</option>
  					<option value="2" @if($sectionsearch == 2) selected="" @endif>B</option>
            @if(Auth::user()->school->sections == 3)
  					<option value="3" @if($sectionsearch == 3) selected="" @endif>C</option>
            @endif
          @else
            @if(Auth::user()->school->section_type == 1)
                <option value="1" @if($sectionsearch == 1) selected="" @endif>A</option>
                <option value="2" @if($sectionsearch == 2) selected="" @endif>B</option>
                @if(Auth::user()->school->sections >2)
                <option value="3" @if($sectionsearch == 3) selected="" @endif>C</option>
                @endif
            @elseif(Auth::user()->school->section_type == 2)
                <option value="1" @if($sectionsearch == 1) selected="" @endif>SCIENCE</option>
                <option value="2" @if($sectionsearch == 2) selected="" @endif>ARTS</option>
                @if(Auth::user()->school->sections >2)
                <option value="3" @if($sectionsearch == 3) selected="" @endif>COMMERCE</option>
                <option value="4" @if($sectionsearch == 4) selected="" @endif>VOCATIONAL</option>
                <option value="5" @if($sectionsearch == 5) selected="" @endif>TECHNICAL</option>
                @endif
            @endif
          @endif
				</select>
			</div>
      @endif
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
	</div><br/>
  <div class="row">
    <div class="col-md-12">
      <div></div>
      <div class="pull-right btn-group">
        @if($classsearch > 8)
        <a href="{{ route('students.gettestimonialsall', [$sessionsearch, $classsearch, $sectionsearch]) }}" class="btn btn-sm btn-success" title="প্রশংসা পত্র তৈরি করুন" target="_blank"><i class="fa fa-print"></i> প্রশংসা পত্র</a>
        @endif
        <a href="{{ route('students.getidcards', [$sessionsearch, $classsearch, $sectionsearch]) }}" class="btn btn-sm btn-warning" title="আইডি কার্ড তৈরি করুন" target="_blank"><i class="fa fa-fw fa-id-card-o"></i> আইডি কার্ড</a>
        <a href="{{ route('students.getadmissioninfo', [$sessionsearch, $classsearch, $sectionsearch]) }}" class="btn btn-sm btn-primary" title="ভর্তি রেজিস্টার তৈরি করুন" target="_blank"><i class="fa fa-print"></i> ভর্তি রেজিস্টার</a>
        <a href="{{ route('students.getinfoall', [$sessionsearch, $classsearch, $sectionsearch]) }}" class="btn btn-sm btn-info" title="শিক্ষার্থী তথ্য তৈরি করুন" target="_blank"><i class="fa fa-print"></i> শিক্ষার্থী তথ্য</a>
        <a href="{{ route('students.getseatplanpdf', [$sessionsearch, $classsearch, $sectionsearch]) }}" class="btn btn-sm btn-dark" title="সিটপ্ল্যান তৈরি করুন" target="_blank"><i class="fa fa-print"></i> সিটপ্ল্যান</a>
        <a href="{{ route('students.getadmitcardpdf', [$sessionsearch, $classsearch, $sectionsearch]) }}" class="btn btn-sm btn-violet" title="এডমিট কার্ড তৈরি করুন" target="_blank"><i class="fa fa-print"></i> এডমিট কার্ড</a>
        <a href="{{ route('students.getstudentsalbumpdf', [$sessionsearch, $classsearch, $sectionsearch]) }}" class="btn btn-sm btn-brown" title="শিক্ষার্থী অ্যালবাম তৈরি করুন" target="_blank"><i class="fa fa-print"></i> শিক্ষার্থী অ্যালবাম</a>
        <a href="{{ route('students.getattendancesheetpdf', [$sessionsearch, $classsearch, $sectionsearch]) }}" class="btn btn-sm btn-warning" title="উপস্থিতি তালিকা (হাজিরা খাতা) তৈরি করুন" target="_blank"><i class="fa fa-print"></i> হাজিরা খাতা</a>
        <a href="{{ route('students.gettutionfeelistpdf', [$sessionsearch, $classsearch, $sectionsearch]) }}" class="btn btn-sm btn-grey" title="বেতন আদায় রেজিস্টার তৈরি করুন" target="_blank"><i class="fa fa-print"></i> বেতন আদায় রেজিস্টার</a>
        <a href="{{ route('students.getbookdistrolistpdf', [$sessionsearch, $classsearch, $sectionsearch]) }}" class="btn btn-sm btn-primary" title="বই বিতরণ তালিকা তৈরি করুন" target="_blank"><i class="fa fa-print"></i> বই বিতরণ তালিকা</a>
        <a href="{{ route('students.getinfolistpdf', [$sessionsearch, $classsearch, $sectionsearch]) }}" class="btn btn-sm btn-info" title="শিক্ষার্থী তথ্য সংগ্রহ তালিকা/ টাকা আদায়ের তালিকা তৈরি করুন" target="_blank"><i class="fa fa-print"></i> তথ্য সংগ্রহ তালিকা</a>
      </div>
    </div>
  </div>

	<div class="table-responsive" style="margin-top: 5px;">
		@if($students == true)
		<table class="table" id="datatable-students">
			<thead>
				<tr>
					<th class="hiddenCheckbox" id="hiddenCheckbox"></th>
          <th>আইডি</th>
          <th>ক্লাস</th>
          <th>শাখা</th>
          <th>রোল</th>
          <th width="20%">নাম</th>
          <th>পিতার নাম</th>
					<th>মাতার নাম</th>
					<th>ছবি</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($students as $key => $student)
				<tr>
					<td class="hiddenCheckbox" id="hiddenCheckbox">
						<input type="checkbox" name="student_check_ids[]" value="{{ $student->id }}">
					</td>
					<td>{{ $student->student_id }}</td>
          <td>{{ $student->class }}</td>
          <td>
              {{ english_section(Auth::user()->school->section_type, $student->class, $student->section) }}
          </td>
					<td>{{ $student->roll }}</td>
          <td>{{ $student->name }}</td>
          <td>{{ $student->father }}</td>
					<td>{{ $student->mother }}</td>
					<td>
						@if($student->image != null || $student->image != '')
            <img src="{{ asset('images/admission-images/'.$student->image) }}" style="width: 35px;">
            @else
            <img src="{{ asset('images/dummy_student.jpg') }}" style="width: 35px;">
            @endif
					</td>
					<td>
            <a class="btn btn-warning btn-sm" href="{{ route('students.getinfosingle',$student->student_id) }}" title="{{ $student->name }}-এর তথ্য প্রিন্ট করুন" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>
            <a class="btn btn-grey btn-sm" href="{{ route('students.getidcardsingle',$student->student_id) }}" title="{{ $student->name }}-এর আইডি কার্ড করুন" target="_blank"><i class="fa fa-id-card-o" aria-hidden="true"></i></a>
            @if($classsearch > 8)
            <a class="btn btn-brown btn-sm" href="{{ route('students.gettestimonialsingle',$student->student_id) }}" title="{{ $student->name }}-এর প্রশংসাপত্র প্রিন্ট করুন" target="_blank"><i class="fa fa-graduation-cap" aria-hidden="true"></i></a>
            @endif
						<a class="btn btn-primary btn-sm" href="{{ route('students.edit',$student->id) }}" title="{{ $student->name }}-এর তথ্য সম্পাদনা করুন"><i class="fa fa-pencil" aria-hidden="true"></i></a>
				    {{-- delete modal--}}
				    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $student->id }}" data-backdrop="static" disabled="" title="{{ $student->name }}-কে ডিলেট করুন"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
  $(function(){
   $('a[title]').tooltip();
   $('button[title]').tooltip();
  });
</script>
<script type="text/javascript">
	$(function () {
  	  $('#example1').DataTable()
  	  $('#datatable-students').DataTable({
  	    'paging'      : true,
  	    'pageLength'  : 100,
  	    'lengthChange': true,
  	    'searching'   : true,
  	    'ordering'    : true,
  	    'info'        : true,
  	    'autoWidth'   : true,
  	    'order': [[ 4, "asc" ]],
	       // columnDefs: [
	       //    { targets: [5], type: 'date'}
	       // ]
  	  })
  	})
	  $(document).ready(function() {
	  	$('#search_students_btn').click(function() {
        @if(Auth::user()->school->sections > 0)
  	  		if($('#search_class').val() && $('#search_section').val() && $('#search_session').val()) {
  		  		
            window.location.href = window.location.protocol + "//" + window.location.host + "/students/"+$('#search_session').val()+"/"+$('#search_class').val()+"/"+$('#search_section').val();
  		  	} else {
  		  		toastr.warning('শ্রেণি, শাখা এবং শিক্ষাবর্ষ সবগুলো সিলেক্ট করুন!');
  		  	}
        @else
          window.location.href = window.location.protocol + "//" + window.location.host + "/students/"+$('#search_session').val()+"/"+$('#search_class').val()+"/No_Section";
        @endif
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
<script type="text/javascript">
  $('#search_class').on('change', function() {
    $('#search_section').prop('disabled', true);
    $('#search_section').append('<option value="" selected disabled>লোড হচ্ছে...</option>');

    if($('#search_class').val() < 9) {
      $('#search_section')
            .find('option')
            .remove()
            .end()
            .prop('disabled', false)
            .append('<option value="" selected disabled>শাখা নির্ধারণ করুন</option>');

      $('#search_section').append('<option value="'+1+'">A</option>');
      $('#search_section').append('<option value="'+2+'">B</option>');
      $('#search_section').append('<option value="'+3+'">C</option>');
    } else {
      $('#search_section')
            .find('option')
            .remove()
            .end()
            .prop('disabled', false)
            .append('<option value="" selected disabled>শাখা নির্ধারণ করুন</option>');

      @if(Auth::user()->school->section_type == 1)
        $('#search_section').append('<option value="'+1+'">A</option>');
        $('#search_section').append('<option value="'+2+'">B</option>');
        $('#search_section').append('<option value="'+3+'">C</option>');
      @elseif(Auth::user()->school->section_type == 2)
        $('#search_section').append('<option value="'+1+'">SCIENCE</option>');
        $('#search_section').append('<option value="'+2+'">ARTS</option>');
        $('#search_section').append('<option value="'+3+'">COMMERCE</option>');
        $('#search_section').append('<option value="'+4+'">VOCATIONAL</option>');
        $('#search_section').append('<option value="'+5+'">TECHNICAL</option>');
      @endif
    }
  });
</script>
@stop