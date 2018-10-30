@extends('adminlte::page')

@section('title', 'Easy School | Admissions')

@section('content_header')
    <h1>
    	অ্যাডমিশন
	    <div class="pull-right">
			  <a class="btn btn-success" href="{{ route('admissions.create') }}" target="_blank"> সংযোজন</a>
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
		<button class="btn btn-primary btn-sm" id="showCheckbox"><i class="fa fa-graduation-cap"></i> চূড়ান্ত ভর্তি</button>
	</div>
	</h4>
	<div class="table-responsive">
		<table class="table" id="datatable-admissions">
			<thead>
				<tr>
					<th class="hiddenCheckbox" id="hiddenCheckbox"></th>
					<th>নাম</th>
					<th>পিতা</th>
					<th>মাতা</th>
					<th>জন্মতারিখ</th>
					<th>শিক্ষাবর্ষ</th>
					<th>ক্লাস</th>
					<th>পেমেন্ট</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($admissions as $admission)
					<tr>
						<td class="hiddenCheckbox" id="hiddenCheckbox">
							<input type="checkbox" name="application_check_ids[]" value="{{ $admission->application_id }}" @if($admission->payment == 0) disabled @endif>
						</td>
						<td>{{ $admission->name }}</td>
						<td>{{ $admission->father }}</td>
						<td>{{ $admission->mother }}</td>
						<td>{{ date('F d, Y', strtotime($admission->dob)) }}</td>
						<td>{{ $admission->session }}</td>
						<td>{{ $admission->class }}</td>
						<td>
							@if($admission->payment == 0)
							<span style="color: red;">✘</span>
							@else
							<span style="color: green;">✔</span>
							@endif
						</td>
						<td>
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
					                <h4 class="modal-title">Payment confirmation</h4>
					              </div>
					              <div class="modal-body">
					                Confirm payment of <b>{{ $admission->name }}</b>?
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
					                <h4 class="modal-title">Delete confirmation</h4>
					              </div>
					              <div class="modal-body">
					                Delete admission <b>{{ $admission->name }}</b>?
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

	{{-- final select modal--}}
	<button class="btn btn-success hiddenFinalSaveBtn" id="hiddenFinalSaveBtn" data-toggle="modal" data-target="#finalSelectModal" data-backdrop="static">চূড়ান্তভাবে নির্বাচন করুন</button>
	<!-- Trigger the modal with a button -->
    	<!-- Modal -->
      <div class="modal fade" id="finalSelectModal" role="dialog">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header modal-header-success">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">চূড়ান্ত নির্বাচন</h4>
            </div>
            {!! Form::open(array('route' => 'admissions.finalselection','method'=>'POST')) !!}
            <div class="modal-body">
              আপনি কি নিশ্চিতভাবে চেকবক্সে নির্বাচিত আবেদনকারীদের চূড়ান্ত নির্বাচন করতে চান?
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
  {{-- final select modal--}}
@stop

@section('js')
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
	    	$('#hiddenFinalSaveBtn').toggleClass('hiddenFinalSaveBtn');
	    });

	    $('#hiddenFinalSaveBtn').click(function() {
	    	var checked = [];
				$("input[name='application_check_ids[]']:checked").each(function ()
				{
				    checked.push($(this).val());
				});
				$('#application_ids').val(checked);
				if($('#application_ids').val() == '') {
					toastr.success('অন্তত একটি আবেদনকারী নির্বাচন করুন!', 'সফল (SUCCESS)').css('width','400px');
					
					setTimeout(function() {
            $('#finalSelectModal').modal('hide');
          }, 1000);
				}
				console.log(checked);
	    });

	    $(function () {
    	  $('#example1').DataTable()
    	  $('#datatable-admissions').DataTable({
    	    'paging'      : true,
    	    'pageLength'  : 3,
    	    'lengthChange': true,
    	    'searching'   : true,
    	    'ordering'    : true,
    	    'info'        : true,
    	    'autoWidth'   : true,
    	    'order': [[ 6, "desc" ]],
		       // columnDefs: [
		       //    { targets: [5], type: 'date'}
		       // ]
    	  })
    	})
		});
	</script>
@stop


@section('css')
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

	.hiddenCheckbox, .hiddenFinalSaveBtn {
		display:none;
	}
	</style>
@stop