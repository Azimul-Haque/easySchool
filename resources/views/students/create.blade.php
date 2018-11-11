@extends('adminlte::page')

@section('title', 'Easy School | সরাসরি ভর্তি')

@section('css')
  {!!Html::style('css/bootstrap-datepicker.min.css')!!}
  {!!Html::style('css/select2.min.css')!!}
  <style type="text/css">
    .select2-selection__choice {
     background-color: #3c8dbc !important; 
     border-color: #367fa9 !important;
     padding: 1px 10px !important;
     color: #fff !important;
    }
  </style>
@stop


@section('content_header')
    <h1>সরাসরি শিক্ষার্থী ভর্তি ফর্ম
    <div class="pull-right">
        <a class="btn btn-primary" href="{{ url()->previous() }}"> Back</a>
    </div>
    </h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        {!! Form::open(array('route' => 'students.store','method'=>'POST', 'class' => 'well', 'enctype' => 'multipart/form-data')) !!}
        <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="class">যে শ্রেণীতে ভর্তি হতে ইচ্ছুক</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-users"></i></span>
                            <select class="form-control" name="class" id="class" required="">
                              <option value="" selected disabled>শিক্ষাবর্ষ নির্ধারণ করুন</option>
                              @php
                                $classes = explode(',', Auth::user()->school->classes);
                              @endphp
                              @foreach($classes as $class)
                              <option value="{{ $class }}">Class {{ $class }}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      @if($school->sections > 0)
                      <div class="form-group">
                        <label for="class">শাখা</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-tags"></i></span>
                            <select class="form-control" name="section" id="section" required="">
                              <option value="" selected disabled>শাখা নির্ধারণ করুন</option>
                              <option value="1">A</option>
                              <option value="2">B</option>
                              <option value="3">C</option>
                            </select>
                        </div>
                      </div>
                      @endif
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                          <label for="roll">রোল</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            {!! Form::text('roll', null, array('placeholder' => 'রোল','class' => 'form-control', 'id' => 'roll', 'required' => '')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="session">শিক্ষাবর্ষ</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-tags"></i></span>
                            <select class="form-control" name="session" id="session" required="">
                              <option value="" selected disabled>শিক্ষাবর্ষ নির্ধারণ করুন</option>
                              @for($session_year = date('Y'); $session_year < (date('Y') + 3); $session_year++)
                              <option value="{{ $session_year }}">{{ $session_year }}</option>
                              @endfor
                            </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="name_bangla">আবেদনকারীর নাম (বাংলায়)</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            {!! Form::text('name_bangla', null, array('placeholder' => 'বাংলায় পুরো নাম','class' => 'form-control', 'id' => 'name_bangla', 'required' => '')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="name">Applicants Name (English)</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            {!! Form::text('name', null, array('placeholder' => 'Name in English','class' => 'form-control', 'id' => 'name', 'required' => '')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group" id="birthDateContainer">
                          <label for="dob">জন্মতারিখ</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar-check-o"></i></span>
                            <input type="text" name="dob" class="form-control" id="dob" placeholder="জন্মতারিখ" required="" autocomplete="off">
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                          <label for="father">Father's Name (English)</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-male"></i></span>
                            {!! Form::text('father', null, array('placeholder' => 'Father&#8216;s Name in English','class' => 'form-control', 'id' => 'father', 'required' => '')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                          <label for="mother">Mother's Name (English)</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-female"></i></span>
                            {!! Form::text('mother', null, array('placeholder' => 'Mother&#8216;s Name in English','class' => 'form-control', 'id' => 'mother', 'required' => '')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                          <label for="yearly_income">অভিভাবকের বাৎসরিক আয় (টাকায়)</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-line-chart"></i></span>
                            {!! Form::text('yearly_income', null, array('placeholder' => 'অভিভাবকের বাৎসরিক আয়','class' => 'form-control', 'id' => 'yearly_income', 'required' => '')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="nationality">জাতীয়তা</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                            <select class="form-control" name="nationality" id="nationality" required>
                              <option selected disabled>জাতীয়তা নির্ধারণ করুন</option>
                              <option value="Bangladeshi">Bangladeshi</option>
                              <option value="Others">Others</option>
                            </select>
                            {!! Form::text('nationality', null, array('placeholder' => 'Write Nationality','class' => 'form-control', 'id' => 'nationalityText', 'style' => 'display:none;')) !!}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                          <label for="fathers_occupation">পিতার/ অভিভাবকের পেশা</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-male"></i></span>
                            {!! Form::text('fathers_occupation', null, array('placeholder' => 'পিতা/ অভিভাবকের পেশা','class' => 'form-control', 'id' => 'fathers_occupation', 'required' => '')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                          <label for="mothers_occupation">মাতার পেশা</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-female"></i></span>
                            {!! Form::text('mothers_occupation', null, array('placeholder' => 'মাতার পেশা','class' => 'form-control', 'id' => 'mothers_occupation', 'required' => '')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="contact">অভিভাবকের মোবাইল নম্বর</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                            {!! Form::text('contact', null, array('placeholder' => 'মোবাইল নম্বর লিখুন','class' => 'form-control', 'id' => 'contact', 'required' => '')) !!}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="contact_2">অভিভাবকের আরেকটি মোবাইল নম্বর</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                            {!! Form::text('contact_2', null, array('placeholder' =>'দ্বিতীয় মোবাইল নম্বর লিখুন','class' => 'form-control', 'id' => 'contact_2', 'required' => '')) !!}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                          <label for="religion">ধর্ম</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-flag-o"></i></span>
                            <select class="form-control" name="religion" id="religion" required>
                              <option selected disabled>ধর্ম নির্ধারণ করুন</option>
                              <option value="ইসলাম">ইসলাম</option>
                              <option value="হিন্দু">হিন্দু</option>
                              <option value="বৌদ্ধ">বৌদ্ধ</option>
                              <option value="খ্রিস্টান">খ্রিস্টান</option>
                              <option value="অন্যান্য">অন্যান্য</option>
                            </select>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                          <label for="blood_group">রক্তের গ্রুপ</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-tint"></i></span>
                            <select class="form-control" name="blood_group" id="blood_group" required>
                              <option selected disabled>রক্তের গ্রুপ নির্ধারণ করুন</option>
                              <option value="A+">A+</option>
                              <option value="A-">A-</option>
                              <option value="B+">B+</option>
                              <option value="B-">B-</option>
                              <option value="AB+">AB+</option>
                              <option value="AB-">AB-</option>
                              <option value="O+">O+</option>
                              <option value="O-">O-</option>
                            </select>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="gender">লিঙ্গ</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-venus-mars"></i></span>
                            <select class="form-control" name="gender" id="gender" required="">
                              <option selected disabled value="">লিঙ্গ নির্ধারণ করুন</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                              <option value="Others">Others</option>
                            </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="cocurricular">সহপাঠ্যক্রম (এক বা একাধিক)</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-music"></i></span>
                            <select class="form-control" name="cocurricular[]" id="cocurricular" multiple="multiple" required>
                              <option disabled>সহপাঠ্যক্রম নির্ধারণ করুন</option>
                              <option value="ক্রিকেট">ক্রিকেট</option>
                              <option value="ফুটবল">ফুটবল</option>
                              <option value="ভলিবল">ভলিবল</option>
                              <option value="সাতাঁর">সাতাঁর</option>
                              <option value="নাচ">নাচ</option>
                              <option value="গান">গান</option>
                              <option value="চিত্রাংকন">চিত্রাংকন</option>
                              <option value="অভিনয়">অভিনয়</option>
                              <option value="বক্তৃতা">বক্তৃতা</option>
                              <option value="বির্তক">বির্তক</option>
                            </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                          <label for="village">গ্রাম</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                            {!! Form::text('village', null, array('placeholder' => 'গ্রামের নাম','class' => 'form-control', 'id' => 'village', 'required' => '')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                          <label for="post_office">ডাকঘর</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                            {!! Form::text('post_office', null, array('placeholder' => 'ডাকঘরের নাম','class' => 'form-control', 'id' => 'post_office', 'required' => '')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                          <label for="upazilla">উপজেলা</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                            {!! Form::text('upazilla', null, array('placeholder' => 'উপজেলার নাম','class' => 'form-control', 'id' => 'upazilla', 'required' => '')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                          <label for="district">জেলা</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                            {!! Form::text('district', null, array('placeholder' => 'জেলার নাম','class' => 'form-control', 'id' => 'district', 'required' => '')) !!}
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="previous_school">গতবছরে পঠিত বিদ্যালয়ের নাম</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-university"></i></span>
                            {!! Form::text('previous_school', null, array('placeholder' => 'পূর্ববর্তী স্কুলের নাম লিখুন','class' => 'form-control', 'id' => 'previous_school', 'required' => '')) !!}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="pec_result">সমাপনি পরীক্ষার ফলাফল</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-balance-scale"></i></span>
                            {!! Form::text('pec_result', null, array('placeholder' =>'সমাপনি পরীক্ষার ফলাফল','class' => 'form-control', 'id' => 'pec_result', 'required' => '')) !!}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>আবেদনকারীর ছবি</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        ব্রাউজ করুন <input type="file" id="image" name="image">
                                    </span>
                                </span>
                                <input type="text" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                      <center>
                        <img src="{{ asset('images/dummy_student.jpg')}}" id='img-upload' style="height: 130px; width: auto; padding: 5px;" />
                      </center>
                    </div>
                  </div>
        <button type="submit" class="btn btn-primary">Save</button>
        {!! Form::close() !!}
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">শিক্ষার্থী প্রতিবেদন</div>
            <div class="panel-body">
                
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
    {!!Html::script('js/bootstrap-datepicker.min.js')!!}
    {!!Html::script('js/select2.full.min.js')!!}
    <script type="text/javascript">
        $(function() {
          $("#dob").datepicker({
            format: 'MM dd, yyyy',
            todayHighlight: true,
            autoclose: true,
            container: '#birthDateContainer'
          });
        });
    </script>
    <script type="text/javascript">
      $(document).ready(function() {
          $('#cocurricular').select2();

          $('#name').keyup(function(){
              this.value = this.value.toUpperCase();
          });
          $('#father').keyup(function(){
              this.value = this.value.toUpperCase();
          });
          $('#mother').keyup(function(){
              this.value = this.value.toUpperCase();
          });

          $('#nationality').change(function(){
              if($('#nationality').val() == 'Others') {
                $('#nationality').attr('style', 'display:none;');
                $('#nationalityText').attr('style', 'display:block;');
              } else {
                $('#nationalityText').val($('#nationality').val());
              }
          });
      });
    </script>
    <script type="text/javascript">
        $(document).ready( function() {
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
                      $('#img-upload').attr('src', e.target.result);
                      $('#imagePreview').attr('src', e.target.result);
                  }
                  reader.readAsDataURL(input.files[0]);
              }
          }
          $("#image").change(function(){
              readURL(this);
              var filesize = parseInt((this.files[0].size)/1024);
              if(filesize > 200) {
                $("#image").val('');
                toastr.warning('File size is: '+filesize+' Kb. try uploading less than 200Kb', 'WARNING').css('width', '400px;');
                  setTimeout(function() {
                    $("#img-upload").attr('src', '{{ asset('images/dummy_student.jpg') }}');
                    $("#imagePreview").attr('src', '{{ asset('images/dummy_student.jpg') }}');
                  }, 1000);
              }
          });
        });
    </script>
@stop
