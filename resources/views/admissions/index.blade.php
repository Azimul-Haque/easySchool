@extends('adminlte::page')

@section('title', 'Easy School | Admissions')

@section('content_header')
    <h1>
    	অ্যাডমিশন
	    <div class="pull-right">
			  <a class="btn btn-success" href="{{ route('admissions.create') }}"> সংযোজন</a>
			</div>
		</h1>
@stop

@section('content')
	<h4>অ্যাডমিশন স্ট্যাটাসঃ <span id="admsn_sts_in_header"></span></h4>
	<label class="switch">
	  <input type="checkbox" id="admissionToggle">
	  <span class="slider round"></span>
	</label>

	<h4>ফর্মগুলো</h4>
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>No</th>
					<th>নাম</th>
					<th>EIIN</th>
					<th>ঠিকানা</th>
					<th>চলতি শিক্ষাবর্ষ</th>
					<th>ক্লাস</th>
					<th>বকেয়া</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($admissions as $admission)
					<tr>
						<td>No</td>
						<td>{{ $admission->name }}</td>
						<td>{{ $admission->eiin }}</td>
						<td>{{ $admission->address }}</td>
						<td>{{ $admission->currentsession }}</td>
						<td>{{ $admission->classes }}</td>
						<td>
							@if($admission->due == 0)
							<span style="color: red;">✘ আছে</span>
							@else
							<span style="color: green;">✔ নেই</span>
							@endif
						</td>
						<td>
							{{-- edit modal--}}
							<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{ $admission->id }}" data-backdrop="static">
								<i class="fa fa-pencil"></i>
							</button>
						  {{-- edit modal--}}
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
			      console.log(response);
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
	        	console.log('School: {{ Auth::User()->school->id }}');
	        	$.ajax({
	        	    url: "/admissiontoggle/on/{{ Auth::User()->school->id }}",
	        	    type: "GET",
	        	    data: {},
	        	    success: function (data) {
	        	      var response = data;
	        	      console.log(response);
	        	      if(response == 'success') {
	        	        toastr.success('অ্যাডমিশন সক্রিয় করা হয়েছে!', 'সফল (SUCCESS)').css('width','400px');
	        	        $('#admsn_sts_in_header').text('সক্রিয়');
	        	      }
	        	    }
	        	});
	        } else {
	        	console.log('School: {{ Auth::User()->school->id }}');
	        	$.ajax({
	        	    url: "/admissiontoggle/off/{{ Auth::User()->school->id }}",
	        	    type: "GET",
	        	    data: {},
	        	    success: function (data) {
	        	      var response = data;
	        	      console.log(response);
	        	      if(response == 'success') {
	        	        toastr.success('অ্যাডমিশন নিষ্ক্রিয় করা হয়েছে!', 'সফল (SUCCESS)').css('width','400px');
	        	        $('#admsn_sts_in_header').text('নিষ্ক্রিয়');
	        	      }
	        	    }
	        	});
	        }
	    });    
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
	</style>
@stop