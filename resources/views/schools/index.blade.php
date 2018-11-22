@extends('adminlte::page')

@section('title', 'Easy School | Schools')

@section('css')
	<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
  {!!Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css')!!}
  <script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
  
@stop

@section('content_header')
    <h1>
    	School Management
	    <div class="pull-right">
			  <a class="btn btn-success" href="{{ route('schools.create') }}"> Add a New School</a>
			</div>
		</h1>
@stop

@section('content')
	<h4>Schools</h4>
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
					<th>অ্যাাডমিশন</th>
					<th>বকেয়া</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($schools as $school)
					<tr>
						<td>No</td>
						<td>{{ $school->name_bangla }}</td>
						<td>{{ $school->eiin }}</td>
						<td>{{ $school->address }}</td>
						<td>{{ $school->currentsession }}</td>
						<td>{{ $school->classes }}</td>
						<td>{{ $school->isadmissionon }}</td>
						<td>
							@if($school->due == 0)
							<span style="color: red;">✘ আছে</span>
							@else
							<span style="color: green;">✔ নেই</span>
							@endif
						</td>
						<td>
							{{-- edit modal--}}
							<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{ $school->id }}" data-backdrop="static" style="overflow:hidden;">
								<i class="fa fa-pencil"></i>
							</button>
							<!-- Trigger the modal with a button -->
						  <!-- Modal -->
						  <div class="modal fade" id="editModal{{ $school->id }}" role="dialog">
						    <div class="modal-dialog modal-lg">
						      <div class="modal-content">
						        <div class="modal-header modal-header-primary">
						          <button type="button" class="close" data-dismiss="modal">&times;</button>
						          <h4 class="modal-title">{{ $school->name }} সম্পাদনাঃ</h4>
						        </div>
						        {!! Form::model($school, ['route' => ['schools.update', $school->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
						        <div class="modal-body">
						            <div class="row">
						                <div class="col-md-12">
				                        <div class="row">
				                            <div class="col-md-3">
				                                <div class="form-group">
				                                    <strong>প্রতিষ্ঠানের নামঃ (বাংলায়)</strong>
				                                    {!! Form::text('name_bangla', null, array('placeholder' => 'বাংলায় নাম','class' => 'form-control', 'required' => '')) !!}
				                                </div>
				                            </div>
				                            <div class="col-md-3">
				                                <div class="form-group">
				                                    <strong>প্রতিষ্ঠানের নামঃ (ইংরেজিতে)</strong>
				                                    {!! Form::text('name', null, array('placeholder' => 'ইংরেজিতে নাম','class' => 'form-control', 'required' => '')) !!}
				                                </div>
				                            </div>
				                            <div class="col-md-3">
				                                <div class="form-group">
				                                    <strong>ইআইআইএনঃ</strong>
				                                    {!! Form::text('eiin', null, array('placeholder' => 'ইআইআইএন','class' => 'form-control', 'required' => '')) !!}
				                                </div>
				                            </div>
				                            <div class="col-md-3">
						                        	<div class="form-group">
							                          <strong>শাখার সংখ্যা</strong>
							                          <select class="form-control" name="sections" required="">
							                            <option value="" selected disabled>শাখার সংখ্যা নির্ধারণ করুন</option>
							                            <option value="0" @if($school->sections == 0) selected @endif>কোন শাখা নেই</option>
							                            <option value="2" @if($school->sections == 2) selected @endif>দুইটি শাখা</option>
							                            <option value="3" @if($school->sections == 3) selected @endif>তিনটি শাখা</option>
							                          </select>
							                        </div>
								                    </div>
				                        </div>
				                        <div class="row">
			                            <div class="col-md-3">
		                                <div class="form-group">
		                                  <strong>স্থাপিতঃ</strong>
		                                  <select class="form-control" name="established" required="">
		                                    <option value="" selected disabled>স্থাপনার সাল নির্ধারণ করুন</option>
		                                  @php
		                                    $y = date('Y');
		                                    for($y; $y>=1901; $y--) {
		                                  @endphp
		                                      <option value="{{ $y }}"
		                                      @if($school->established == $y)
		                                      selected 
		                                      @endif>{{ $y }}</option>
		                                  @php
		                                    }
		                                  @endphp
		                                  </select>
		                                </div>
			                            </div>
			                            <div class="col-md-3">
		                                <div class="form-group">
		                                  <strong>চলতি অ্যাকাডেমিক সেশনঃ (শিক্ষাবর্ষ)</strong>
		                                  <select class="form-control" name="currentsession" required="">
		                                    <option value="" selected disabled>শিক্ষাবর্ষ নির্ধারণ করুন</option>
		                                  @php
		                                    $y = date('Y')-2;
		                                    for($y; $y<=2038; $y++) {
		                                  @endphp
		                                      <option 
																					@if($school->currentsession == $y)
																					selected 
																					@endif
		                                       value="{{ $y }}">{{ $y }}</option>
		                                  @php
		                                    }
		                                  @endphp
		                                  </select>
		                                </div>
			                            </div>
	                            	  <div class="col-md-3">
    				                        <div class="form-group">
    				                          <strong>পেমেন্ট মেথডঃ</strong>
    				                          <select class="form-control" name="payment_method" required="">
    				                            <option value="" selected disabled>পেমেন্ট মেথড নির্ধারণ করুন</option>
    				                            <option value="manual"
    																		@if($school->payment_method == 'manual')
    																		selected
    																		@endif
    				                            >ম্যানুয়াল</option>
    				                            <option value="online"
    																		@if($school->payment_method == 'online')
    																		selected
    																		@endif
    				                            >অনলাইন</option>
    				                          </select>
    				                        </div> 
	    				                    </div>
	                                <div class="col-md-3">
                                    <div class="form-group">
                                      <strong>চলতি পরীক্ষার নাম নির্ধারণ করুন</strong>
                                      <select class="form-control" name="currentexam">
                                        <option selected disabled>চলতি পরীক্ষার নাম নির্ধারণ করুন</option>
                                        <option value="halfyearly"
    																		@if($school->currentexam == 'halfyearly')
    																		  selected 
    																		@endif
                                        >অর্ধবার্ষিকী/প্রাক-নির্বাচনী পরীক্ষা</option>
                                        <option value="final"
    																		@if($school->currentexam == 'final')
    																		  selected 
    																		@endif
                                        >বার্ষিক/নির্বাচনী পরীক্ষা</option>
                                      </select>
                                    </div>
	                                </div>
				                        </div> 
				                        <div class="row">
				                            <div class="col-md-3">
				                                <div class="form-group">
				                                    <strong>ঠিকানাঃ</strong>
				                                    {!! Form::text('address', null, array('placeholder' => 'ঠিকানা','class' => 'form-control', 'required' => '')) !!}
				                                </div>
				                            </div>
				                            <div class="col-md-3">
							                        <div class="form-group">
							                          <strong>জেলাঃ</strong>
							                          <select class="form-control" id="district{{ $school->id }}" name="district" required="">
							                            <option value="" selected="" disabled="">জেলা নির্ধারণ করুন</option>
							                            @foreach($districts as $district)
							                            <option value="{{ $district }}" @if($school->district == $district) selected="" @endif>{{ $district }}</option>
							                            @endforeach
							                          </select>
							                        </div> 
							                    </div>
							                    <div class="col-md-3">
							                        <div class="form-group">
							                          <strong>উপজেলাঃ</strong>
							                          <select class="form-control" id="upazilla{{ $school->id }}" name="upazilla" required="">
							                            <option value="" disabled>উপজেলা নির্ধারণ করুন</option>
							                            @if($school->upazilla != null || $school->upazilla != '')
																					<option value="{{ $school->upazilla }}" selected>{{ $school->upazilla }}</option>
							                            @endif
							                          </select>
							                        </div> 
							                    </div>
				                            <div class="col-md-3">
				                                <div class="form-group">
				                                  <strong>শেষ সংঘটিত পরীক্ষার ফলাফলঃ</strong>
				                                  <br/>
				                                  <label style="margin-right: 40px;">
				                                  <input type="radio" name="isresultpublished" value="0" 
																					@if($school->isresultpublished == 0)
																					checked="checked" 
																					@endif
				                                  required> বন্ধ আছে</label>
				                                  <label style="margin-right: 40px;">
				                                  <input type="radio" name="isresultpublished" value="1"
																					@if($school->isresultpublished == 1)
																					checked="checked" 
																					@endif
				                                  > দেওয়া হয়েছে</label>
				                                </div> 
				                            </div>
				                        </div>
				                        <div class="form-group">
				                          <strong>ক্লাসঃ</strong>
				                          <br/>
				                          @php
				                          $classes = explode(',', $school->classes);
				                          @endphp
				                          @for($clss = 1;$clss<=10;$clss++)
				                            <label style="margin-right: 15px; float: left;">
				                            <input type="checkbox" name="classes[]" value="{{ $clss }}" class="classes icheck"
																		@if(in_array($clss, $classes)) checked @endif
				                            > Class {{ $clss }}
				                            </label>
				                          @endfor
				                        </div><br/><br/><br/>
				                        <div class="row">
				                        	<div class="col-md-2">
  					                        <div class="form-group">
  					                          <strong>ভর্তি শিক্ষাবর্ষ</strong>
  					                          <select class="form-control" name="admission_session" required="">
  					                            <option value="" selected disabled>শিক্ষাবর্ষ নির্ধারণ করুন</option>
  					                          @php
  					                            $y = date('Y');
  					                            for($y; $y<=2038; $y++) {
  					                          @endphp
  					                              <option value="{{ $y }}"
  																				@if($school->admission_session == $y) selected="" @endif
  					                              >{{ $y }}</option>
  					                          @php
  					                            }
  					                          @endphp
  					                          </select>
  					                        </div>
	  					                    </div>
	  	                            <div class="col-md-2">
  	                                <div class="form-group">
		                                    <strong>ভর্তি পরীক্ষার পূর্ণমান</strong>
		                                    {!! Form::text('admission_total_marks', null, array('placeholder' => 'ভর্তি পরীক্ষার পূর্ণমান','class' => 'form-control')) !!}
		                                </div>
	  	                            </div>
	  	                            <div class="col-md-2">
  	                                <div class="form-group">
		                                    <strong>নম্বর বণ্টন (বাংলা)</strong>
		                                    {!! Form::text('admission_bangla_mark', null, array('placeholder' => 'নম্বর বণ্টন (বাংলা)','class' => 'form-control')) !!}
		                                </div>
	  	                            </div>
	  	                            <div class="col-md-2">
  	                                <div class="form-group">
		                                    <strong>নম্বর বণ্টন (ইংরেজি)</strong>
		                                    {!! Form::text('admission_english_mark', null, array('placeholder' => 'নম্বর বণ্টন (ইংরেজি)','class' => 'form-control')) !!}
		                                </div>
	  	                            </div>
	  	                            <div class="col-md-2">
  	                                <div class="form-group">
		                                    <strong>নম্বর বণ্টন (গণিত)</strong>
		                                    {!! Form::text('admission_math_mark', null, array('placeholder' => 'নম্বর বণ্টন (গণিত)','class' => 'form-control')) !!}
		                                </div>
	  	                            </div>
	  	                            <div class="col-md-2">
  	                                <div class="form-group">
		                                    <strong>নম্বর বণ্টন (সাঃ জ্ঞান)</strong>
		                                    {!! Form::text('admission_gk_mark', null, array('placeholder' => 'নম্বর বণ্টন (সাঃ জ্ঞান)','class' => 'form-control')) !!}
		                                </div>
	  	                            </div>
				                        </div>
				                        <div class="row">
	  	                            <div class="col-md-2">
  	                                <div class="form-group">
  	                                  <strong>ভর্তি প্রক্রিয়াঃ</strong>
  	                                  <br/>
  	                                  <label style="margin-right: 40px;">
  	                                  <input type="radio" name="isadmissionon" value="0" 
  																		@if($school->isadmissionon == 0)
  																		checked="checked" 
  																		@endif
  	                                  required> বন্ধ</label>
  	                                  <label style="margin-right: 40px;">
  	                                  <input type="radio" name="isadmissionon" value="1"
  																		@if($school->isadmissionon == 1)
  																		checked="checked" 
  																		@endif
  	                                  > চলছে</label>
  	                                </div> 
	  	                            </div>
	  	                            <div class="col-md-2">
  	                                <div class="form-group">
		                                    <strong>উত্তীর্ণ নম্বর</strong>
		                                    {!! Form::text('admission_pass_mark', null, array('placeholder' => 'উত্তীর্ণ নম্বর','class' => 'form-control')) !!}
		                                </div>
	  	                            </div>
	  	                            <div class="col-md-2">
  	                                <div class="form-group">
		                                    <strong>ভর্তি আবেদন শুরু</strong>
		                                    {!! Form::text('admission_start_date', null, array('placeholder' => 'ভর্তি আবেদন শুরু','class' => 'form-control', 'id' => 'admission_start_date'.$school->id)) !!}
		                                </div>
	  	                            </div>
	  	                            <div class="col-md-2">
  	                                <div class="form-group">
		                                    <strong>ভর্তি আবেদন শেষ</strong>
		                                    {!! Form::text('admission_end_date', null, array('placeholder' => 'ভর্তি আবেদন শেষ','class' => 'form-control', 'id' => 'admission_end_date'.$school->id)) !!}
		                                </div>
	  	                            </div>
	  	                            <div class="col-md-2">
  	                                <div class="form-group">
		                                    <strong>ভর্তি পরীক্ষার সময়</strong>
		                                    {!! Form::text('admission_test_datetime', null, array('placeholder' => 'ভর্তি পরীক্ষার সময়','class' => 'form-control', 'id' => 'admission_test_datetime'.$school->id)) !!}
		                                </div>
	  	                            </div>
	  	                            <div class="col-md-2">
  	                                <div class="form-group">
		                                    <strong>ভর্তি পরীক্ষার ফিঃ</strong>
		                                    {!! Form::text('admission_form_fee', null, array('placeholder' => 'ভর্তি পরীক্ষার ফি','class' => 'form-control')) !!}
		                                </div>
	  	                            </div>
				                        </div>
				                        <div class="row">
                                  <div class="col-md-3">
                                      <div class="form-group">
                                        <strong>শাখার ধরণ (৯ম-১০ম শ্রেণির জন্য)</strong>
                                        <select class="form-control" name="section_type" required="">
                                          <option value="" selected disabled>শাখার ধরণ নির্ধারণ করুন</option>
                                          <option value="0" @if($school->section_type == 0) selected="" @endif>প্রযোজ্য নয়</option>
                                          <option value="1" @if($school->section_type == 1) selected="" @endif>A(ক), B(খ), C(গ)</option>
                                          <option value="2" @if($school->section_type == 2) selected="" @endif>SCIENCE (বিজ্ঞান), Arts(মানবিক), COMMERCE(বাণিজ্য)</option>
                                        </select>
                                      </div>
                                  </div>
			                            <div class="col-md-5">
			                                <div class="row">
			                                    <div class="col-md-6">
			                                        <div class="form-group">
			                                            <label>প্রধান শিক্ষকের স্বাক্ষর</label>
			                                            <div class="input-group">
			                                                <span class="input-group-btn">
			                                                    <span class="btn btn-default btn-file">
			                                                        ব্রাউজ করুন <input type="file" id="headmaster_sign{{ $school->id }}" name="headmaster_sign">
			                                                    </span>
			                                                </span>
			                                                <input type="text" class="form-control" readonly>
			                                            </div>
			                                        </div>
			                                    </div>
			                                    <div class="col-md-6">
			                                        <img src="https://via.placeholder.com/100x27?text=Sign" id='sign-upload{{ $school->id }}' style="height: 50px; width: 180px; padding: 5px; float: right;" />
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="col-md-4">
			                                <div class="row">
			                                    <div class="col-md-8">
			                                        <div class="form-group">
			                                            <label>মনোগ্রাম</label>
			                                            <div class="input-group">
			                                                <span class="input-group-btn">
			                                                    <span class="btn btn-default btn-file">
			                                                        ব্রাউজ করুন <input type="file" id="monogram{{ $school->id }}" name="monogram">
			                                                    </span>
			                                                </span>
			                                                <input type="text" class="form-control" readonly>
			                                            </div>
			                                        </div>
			                                    </div>
			                                    <div class="col-md-4">
			                                        <img src="https://via.placeholder.com/120x120?text=Monogram" id='img-upload{{ $school->id }}' style="height: 90px; width: auto; padding: 5px; float: right;" />
			                                    </div>
			                                </div>
			                            </div>
				                        </div>
						                </div>
						            </div>
						        </div>
						        <div class="modal-footer">
						          <button type="submit" class="btn  btn-success">Save</button>
						          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						        </div>
						        {!! Form::close() !!}
						      </div>
						    </div>
						  </div>
						  {{-- edit modal--}}
					    {{-- delete modal--}}
					    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $school->id }}" data-backdrop="static"><i class="fa fa-trash" aria-hidden="true"></i></button>
					      	<!-- Trigger the modal with a button -->
				        	<!-- Modal -->
					        <div class="modal fade" id="deleteModal{{ $school->id }}" role="dialog">
					          <div class="modal-dialog modal-md">
					            <div class="modal-content">
					              <div class="modal-header modal-header-danger">
					                <button type="button" class="close" data-dismiss="modal">&times;</button>
					                <h4 class="modal-title">Delete confirmation</h4>
					              </div>
					              <div class="modal-body">
					                Delete school <b>{{ $school->name }}</b>?
					              </div>
					              <div class="modal-footer">
					                {!! Form::model($school, ['route' => ['schools.destroy', $school->id], 'method' => 'DELETE']) !!}
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
					<script type="text/javascript">
					  $(document).ready(function() {
					      $('#district{{ $school->id }}').on('change', function() {
					        $('#upazilla{{ $school->id }}').prop('disabled', true);
					        $('#upazilla{{ $school->id }}').append('<option value="" selected disabled>লোড হচ্ছে...</option>');
					        $.ajax({
					          url: "/schools/getupazillas/api/"+$(this).val(), 
					          type: "GET",
					          success: function(result){
					            $('#upazilla{{ $school->id }}')
					                .find('option')
					                .remove()
					                .end()
					                .prop('disabled', false)
					                .append('<option value="" selected disabled>উপজেলা নির্ধারণ করুন</option>')
					            ;
					            for(var countupazilla = 0; countupazilla < result.length; countupazilla++) {
					              //console.log(result[countupazilla]);
					              $('#upazilla{{ $school->id }}').append('<option value="'+result[countupazilla]+'">'+result[countupazilla]+'</option>')
					            }
					          }
					        });
					      });

					      $(document).on('change', '.btn-file :file', function() {
					      var input = $(this),
					          label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
					      input.trigger('fileselect', [label]);
					      });
					      $('.btn-file :file').on('fileselect', function(event, label) {
					          
					          var input = $(this).parents('.input-group').find(':text'),
					              log = label;
					          
					          if( input.length ) {
					              input.val(log);
					          } else {
					              if( log ) alert(log);
					          }
					      });
					      function readURL(input) {
					          if (input.files && input.files[0]) {
					              var reader = new FileReader();
					              
					              reader.onload = function (e) {
					                  $('#img-upload{{ $school->id }}').attr('src', e.target.result);
					              }
					              
					              reader.readAsDataURL(input.files[0]);
					          }
					      }

					      $("#monogram{{ $school->id }}").change(function(){
					          readURL(this);
					          var filesize = parseInt((this.files[0].size)/1024);
					          if(filesize > 100) {
					            $("#monogram{{ $school->id }}").val('');
					            toastr.warning('File size is: '+filesize+' Kb. try uploading less than 100Kb', 'WARNING').css('width', '400px;');
					              setTimeout(function() {
					                $("#img-upload{{ $school->id }}").attr('src', '{{ asset('images/dummy_student.jpg') }}');
					              }, 1000);
					          }
					      }); 
					      function readSignURL(input) {
					          if (input.files && input.files[0]) {
					              var reader = new FileReader();
					              
					              reader.onload = function (e) {
					                  $('#sign-upload{{ $school->id }}').attr('src', e.target.result);
					              }
					              
					              reader.readAsDataURL(input.files[0]);
					          }
					      }
					      $("#headmaster_sign{{ $school->id }}").change(function(){
					          readSignURL(this);
					          var filesize = parseInt((this.files[0].size)/1024);
					          if(filesize > 100) {
					            $("#headmaster_sign{{ $school->id }}").val('');
					            toastr.warning('File size is: '+filesize+' Kb. try uploading less than 100Kb', 'WARNING').css('width', '400px;');
					              setTimeout(function() {
					                $("#sign-upload{{ $school->id }}").attr('src', '{{ asset('images/dummy_student.jpg') }}');
					              }, 1000);
					          }
					      });
					  });
					</script>
          <script type="text/javascript">
              $(function () {
                  $('#admission_start_date{{ $school->id }}').datetimepicker({
                    format: 'MMMM DD, YYYY hh:mm A',
                    date: new Date('{{ $school->admission_start_date }}')
                  });
                  $('#admission_end_date{{ $school->id }}').datetimepicker({
                    format: 'MMMM DD, YYYY hh:mm A',
                    date: new Date('{{ $school->admission_end_date }}')
                  });
                  $('#admission_test_datetime{{ $school->id }}').datetimepicker({
                    format: 'MMMM DD, YYYY hh:mm A',
                    date: new Date('{{ $school->admission_test_datetime }}')
                  });
              });
          </script>
				@endforeach
			</tbody>
		</table>
	</div>
@stop

@section('js')
	<script type="text/javascript" src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.js') }}"></script>
	<script>
	  $(document).ready(function(){
	    $('.icheck').iCheck({
	      checkboxClass: 'icheckbox_square-blue',
	      increaseArea: '20%' // optional
	    });
	  });
	</script>

@stop