@extends('adminlte::page')

@section('title', 'Easy School | Admissions')

@section('content_header')
    <h1>
    	অ্যাডমিশন
	    <div class="pull-right">
        <a class="btn btn-warning" href="{{ route('admissions.applicantslist') }}" target="_blank"><i class="fa fa-print"></i> আবেদনকারীর তালিকা</a>
			  <a class="btn btn-success" href="{{ route('admissions.create') }}" target="_blank"><i class="fa fa-plus"></i> সংযোজন</a>
			</div>
		</h1>
@stop

@section('content')
	<div class="row">
		<div class="col-md-3">
			<h4>অ্যাডমিশন স্ট্যাটাসঃ <span id="admsn_sts_in_header"></span>
			<label class="switch pull-right">
			  <input type="checkbox" id="admissionToggle">
			  <span class="slider round"></span>
			</label></h4>
		</div>
		<div class="col-md-9"></div>
	</div>

	<h4 style="margin-bottom: 15px;">আবেদনগুলো
	<div class="pull-right">
    <a href="{{ route('admissions.pdfadmissionseatplan') }}" class="btn btn-brown btn-sm" title="সিটপ্ল্যান জেনারেট করুন" target="_blank">
      <i class="fa fa-print"></i> সিটপ্ল্যান জেনারেট করুন
    </a>
    <a href="{{ route('admissions.pdfallapplication') }}" class="btn btn-warning btn-sm" title="আবেদনপত্রগুলো প্রিন্ট করুন" target="_blank">
      <i class="fa fa-print"></i> আবেদনপত্রগুলো প্রিন্ট করুন
    </a>
		<button class="btn btn-success btn-sm" id="showCheckbox"><i class="fa fa-check-square-o"></i> পেমেন্ট</button>
		<button class="btn btn-primary btn-sm" id="submitMarkBtn" data-toggle="modal" data-target="#submitMarkModal" data-backdrop="static"><i class="fa fa-bar-chart"></i> নম্বর প্রদান</button>
		<!-- submit mark Modal -->
    <div class="modal fade" id="submitMarkModal" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header modal-header-primary">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">চূড়ান্ত নম্বর দাখিল</h4>
          </div>
          {!! Form::open(array('route' => 'admissions.submitmark','method'=>'POST')) !!}
          <div class="modal-body">
            আপনি কি নিশ্চিতভাবে চেকবক্সে নির্বাচিত আবেদনকারীদের নম্বর দাখিল করতে চান?
            {!! Form::hidden('application_ids_with_marks', null, ['id' => 'application_ids_with_marks', 'required' => '']) !!}
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
    <!-- submit mark Modal -->
    <button class="btn btn-info btn-sm" id="showFinalSelectionCheckbox"><i class="fa fa-graduation-cap"></i> চূড়ান্ত ভর্তি</button>
	</div>
	</h4>
	<div class="table-responsive">
		<table class="table" id="datatable-admissions">
			<thead>
				<tr>
					<th class="hiddenCheckbox" id="hiddenCheckbox"></th>
					<th class="hiddenFinalSelectionCheckbox" id="hiddenFinalSelectionCheckbox"></th>
					<th>ক্লাস</th>
					<th>শাখা</th>
					<th>আইডি</th>
					<th>নাম</th>
					<th>জন্মতারিখ</th>
					<th>শিক্ষাবর্ষ</th>
					<th>পেমেন্ট</th>
					<th>প্রাপ্ত নম্বর</th>
					<th>ভর্তি স্ট্যাটাস</th>
					<th>মেরিট পজিশন</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($admissions as $admission)
					<tr>
						<td class="hiddenCheckbox" id="hiddenCheckbox">
							@if($admission->payment == 0)
              <input type="checkbox" class="icheck" name="application_check_ids[]" value="{{ $admission->application_id }}">
							@endif
						</td>

						<td class="hiddenFinalSelectionCheckbox" id="hiddenFinalSelectionCheckbox">
							@if($admission->mark_obtained > 0) 
							<input type="checkbox" class="icheck" name="application_final_selection_check_ids[]" value="{{ $admission->application_id }}">
							@endif
						</td>
						<td>{{ $admission->class }}</td>
						<td>
							@if( $admission->section == 1)
								A
							@elseif( $admission->section == 2)
								B
							@elseif( $admission->section == 3)
							 	C
							@endif
						</td>
						<td>{{ $admission->application_id }}</td>
						<td>{{ $admission->name }}</td>
						<td>{{ date('F d, Y', strtotime($admission->dob)) }}</td>
						<td>{{ $admission->session }}</td>
						<td>
							@if($admission->payment == 0)
							<span style="color: red;">✘</span>
							@else
							<span style="color: green;">✔</span>
							@endif
						</td>
						<td>
							@if($admission->payment != 0)
							<input type="text" name="" class="form-control" style="width: 50px;" id="mark_obtained{{ $admission->application_id }}" value="{{ $admission->mark_obtained }}" tabindex="{{ $admission->id }}">
							@endif
						</td>
						<td>
							@if($admission->application_status == 'done')
								<span style="color: green;">✔ ভর্তিকৃত</span>
							@else
								ভর্তিচ্ছু
							@endif
						</td>
						<td>{{ $admission->merit_position }}</td>
						<td>
              <a href="{{ route('admissions.pdfapplicantscopy', $admission->application_id) }}" class="btn btn-warning btn-sm" title="{{ $admission->name_bangla }}-এর আবেদনপত্রটি প্রিন্ট করুন" target="_blank">
                <i class="fa fa-print"></i>
              </a>
							{{-- payment modal--}}
							<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#paymentModal{{ $admission->id }}" data-backdrop="static">
								<i class="fa fa-check"></i>
							</button>
							<!-- Trigger the modal with a button -->
				        	<!-- Modal -->
					        <div class="modal fade" id="paymentModal{{ $admission->id }}" role="dialog">
					          <div class="modal-dialog modal-md">
					            <div class="modal-content">
					              <div class="modal-header modal-header-success">
					                <button type="button" class="close" data-dismiss="modal">&times;</button>
					                <h4 class="modal-title">পেমেন্ট নিশ্চিতকরণ</h4>
					              </div>
					              <div class="modal-body">
					                <b>{{ $admission->name }}</b> এর পেমেন্ট দাখিল করবেন?
					              </div>
					              <div class="modal-footer">
					                <a href="{{ route('admissions.updatepayment', $admission->id) }}" class="btn btn-success">Save</a>
					                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					              </div>
					            </div>
					          </div>
					        </div>
						  {{-- payment modal--}}
					    {{-- delete modal--}}
					    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $admission->id }}" data-backdrop="static"><i class="fa fa-trash" aria-hidden="true"></i></button>
					      	<!-- Trigger the modal with a button -->
				        	<!-- Modal -->
					        <div class="modal fade" id="deleteModal{{ $admission->id }}" role="dialog">
					          <div class="modal-dialog modal-md">
					            <div class="modal-content">
					              <div class="modal-header modal-header-danger">
					                <button type="button" class="close" data-dismiss="modal">&times;</button>
					                <h4 class="modal-title">ডিলেট নিশ্চিতকরণ</h4>
					              </div>
					              <div class="modal-body">
					                <b>{{ $admission->name }}</b> কে ডিলেট করবেন?
					              </div>
					              <div class="modal-footer">
					                {!! Form::model($admission, ['route' => ['admissions.destroy', $admission->id], 'method' => 'DELETE']) !!}
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

	{{-- bulk payment modal--}}
	<button class="btn btn-success bulkPaymentSaveBtn" id="bulkPaymentSaveBtn" data-toggle="modal" data-target="#bulkPaymentModal" data-backdrop="static">পেমেন্ট দাখিল করুন</button>
	<!-- Trigger the modal with a button -->
    	<!-- Modal -->
      <div class="modal fade" id="bulkPaymentModal" role="dialog">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header modal-header-success">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">চূড়ান্ত পেমেন্ট দাখিল</h4>
            </div>
            {!! Form::open(array('route' => 'admissions.bulkpayment','method'=>'POST')) !!}
            <div class="modal-body">
              আপনি কি নিশ্চিতভাবে চেকবক্সে নির্বাচিত আবেদনকারীদের পেমেন্ট দাখিল করতে চান?
              {!! Form::hidden('application_ids', null, ['id' => 'application_ids', 'required' => '']) !!}
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Save</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>
  {{-- bulk payment modal--}}
  {{-- final selection modal--}}
  <button class="btn btn-info finalSelectionSubmitBtn" id="finalSelectionSubmitBtn" data-toggle="modal" data-target="#finalSelectionModal" data-backdrop="static"><i class="fa fa-graduation-cap"></i> চূড়ান্ত ভর্তি করুন</button>
		<!-- final selection Modal -->
    <div class="modal fade" id="finalSelectionModal" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header modal-header-info">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">চূড়ান্ত ভর্তি</h4>
          </div>
          {!! Form::open(array('route' => 'admissions.finalselection','method'=>'POST')) !!}
          <div class="modal-body">
            আপনি কি নিশ্চিতভাবে চেকবক্সে নির্বাচিত আবেদনকারীদের চূড়ান্তভাবে ভর্তি করতে চান?
            {!! Form::hidden('application_ids_to_admit', null, ['id' => 'application_ids_to_admit', 'required' => '']) !!}
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-info">Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
    <!-- final selection Modal -->
  {{-- final selection modal--}}
@stop

@section('js')
  <script type="text/javascript">
    $(function(){
     $('a[title]').tooltip();
    });
  </script>
  <script type="text/javascript" src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.js') }}"></script>
  <script>
    $(document).ready(function(){
      $('.icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        increaseArea: '20%' // optional
      });
    });
  </script>
	<script type="text/javascript">
		$(document).ready(function() {
			$.ajax({
			    url: "/getadmissionstatus/{{ Auth::User()->school->id }}",
			    type: "GET",
			    data: {},
			    success: function (data) {
			      var response = data;
			      //console.log(response);
			      if(response == 0) {
			        $('#admsn_sts_in_header').text('নিষ্ক্রিয়');
			        $('#admissionToggle').prop('checked', false);
			      } else if(response == 1) {
			        $('#admsn_sts_in_header').text('সক্রিয়');
			        $('#admissionToggle').prop('checked', true);
			      }
			    }
			});

			$('#admissionToggle:checkbox').change(
	    function(){
	        if ($(this).is(':checked')) {
	        	//console.log('School: {{ Auth::User()->school->id }}');
	        	$.ajax({
	        	    url: "/admissiontoggle/on/{{ Auth::User()->school->id }}",
	        	    type: "GET",
	        	    data: {},
	        	    success: function (data) {
	        	      var response = data;
	        	      //console.log(response);
	        	      if(response == 'success') {
	        	        toastr.success('অ্যাডমিশন সক্রিয় করা হয়েছে!', 'সফল (SUCCESS)').css('width','400px');
	        	        $('#admsn_sts_in_header').text('সক্রিয়');
	        	      }
	        	    }
	        	});
	        } else {
	        	//console.log('School: {{ Auth::User()->school->id }}');
	        	$.ajax({
	        	    url: "/admissiontoggle/off/{{ Auth::User()->school->id }}",
	        	    type: "GET",
	        	    data: {},
	        	    success: function (data) {
	        	      var response = data;
	        	      //console.log(response);
	        	      if(response == 'success') {
	        	        toastr.success('অ্যাডমিশন নিষ্ক্রিয় করা হয়েছে!', 'সফল (SUCCESS)').css('width','400px');
	        	        $('#admsn_sts_in_header').text('নিষ্ক্রিয়');
	        	      }
	        	    }
	        	});
	        }
	    });

	    $('#showCheckbox').click(function() {
	    	$('td:nth-child(1)').toggleClass('hiddenCheckbox');
	    	$('th:nth-child(1)').toggleClass('hiddenCheckbox');
	    	$('#bulkPaymentSaveBtn').toggleClass('bulkPaymentSaveBtn');
	    });
	    $('#showFinalSelectionCheckbox').click(function() {
	    	$('td:nth-child(2)').toggleClass('hiddenFinalSelectionCheckbox');
	    	$('th:nth-child(2)').toggleClass('hiddenFinalSelectionCheckbox');
	    	$('#finalSelectionSubmitBtn').toggleClass('finalSelectionSubmitBtn');
	    });

	    $('#bulkPaymentSaveBtn').click(function() {
	    	var checked = [];
				$("input[name='application_check_ids[]']:checked").each(function ()
				{
				    checked.push($(this).val());
				});
				$('#application_ids').val(checked);
				if($('#application_ids').val() == '') {
					toastr.warning('অন্তত একজন আবেদনকারী নির্বাচন করুন!', 'Warning').css('width','400px');
					setTimeout(function() {
            $('#bulkPaymentModal').modal('hide');
          }, 600);
				}
				console.log(checked);
	    });

	    $('#finalSelectionSubmitBtn').click(function() {
	    	var checked_final = [];
				$("input[name='application_final_selection_check_ids[]']:checked").each(function ()
				{
				    checked_final.push($(this).val());
				});
				$('#application_ids_to_admit').val(checked_final);
				if($('#application_ids_to_admit').val() == '') {
					toastr.warning('অন্তত একজন আবেদনকারী নির্বাচন করুন!', 'Warning').css('width','400px');
					setTimeout(function() {
            $('#finalSelectionModal').modal('hide');
          }, 600);
				}
				console.log(checked_final);
	    });

	    $('#submitMarkBtn').click(function() {
	    	var applications = [];
				@foreach($admissions as $admission)
					var mark = 0;
					if((($('#mark_obtained{{ $admission->application_id }}').val() != '') && $('#mark_obtained{{ $admission->application_id }}').val() != undefined) && ({{ $admission->payment }} != 0)) {
						mark = $('#mark_obtained{{ $admission->application_id }}').val();
						var id = {{ $admission->application_id }};
					  applications.push(id+':'+mark);
					} else {
						// toastr.warning('সকল প্রাপ্ত নম্বর ঘরে নম্বর প্রদান করুন!', 'Warning').css('width','400px');
						// setTimeout(function() {
	     //        $('#submitMarkModal').modal('hide');
	     //      }, 600);
					}
				@endforeach
				$('#application_ids_with_marks').val(applications);
				if($('#application_ids_with_marks').val() == '') {
					toastr.warning('অন্তত একজন আবেদনকারীকে নম্বর প্রদান করুন!', 'Warning').css('width','400px');
					setTimeout(function() {
            $('#submitMarkModal').modal('hide');
          }, 600);
				}
				console.log(applications);
	    });

	    $(function () {
    	  $('#example1').DataTable()
    	  $('#datatable-admissions').DataTable({
    	    'paging'      : true,
    	    'pageLength'  : 15,
    	    'lengthChange': true,
    	    'searching'   : true,
    	    'ordering'    : true,
    	    'info'        : true,
    	    'autoWidth'   : true,
    	    'order': [[ 1, "asc" ]],
		       // columnDefs: [
		       //    { targets: [5], type: 'date'}
		       // ]
    	  })
    	})
		});
	</script>
@stop


@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
	<style>
	.switch {
	  position: relative;
	  display: inline-block;
	  width: 56px;
	  height: 30px;
	}

	.switch input {display:none;}

	.slider {
	  position: absolute;
	  cursor: pointer;
	  top: 0;
	  left: 0;
	  right: 0;
	  bottom: 0;
	  background-color: #ccc;
	  -webkit-transition: .4s;
	  transition: .4s;
	}

	.slider:before {
	  position: absolute;
	  content: "";
	  height: 22px;
	  width: 22px;
	  left: 4px;
	  bottom: 4px;
	  background-color: white;
	  -webkit-transition: .4s;
	  transition: .4s;
	}

	input:checked + .slider {
	  background-color: #2196F3;
	}

	input:focus + .slider {
	  box-shadow: 0 0 1px #2196F3;
	}

	input:checked + .slider:before {
	  -webkit-transform: translateX(26px);
	  -ms-transform: translateX(26px);
	  transform: translateX(26px);
	}

	/* Rounded sliders */
	.slider.round {
	  border-radius: 30px;
	}

	.slider.round:before {
	  border-radius: 50%;
	}

	.hiddenCheckbox, .bulkPaymentSaveBtn {
		display:none;
	}
	.hiddenFinalSelectionCheckbox, .finalSelectionSubmitBtn {
		display:none;
	}
	</style>
@stop