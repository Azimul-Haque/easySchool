@extends('adminlte::page')

@section('title', 'Easy School')

@section('css')
  {!!Html::style('css/bootstrap-datepicker.min.css')!!}
  
@stop


@section('content_header')
    <h1>Edit Student: Student Id: <u>{{ $student->student_id }}</u>
    <div class="pull-right">
        <a class="btn btn-primary" href="{{ url()->previous() }}"> Back</a>
    </div>
    </h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        {!! Form::model($student, ['method' => 'PATCH','route' => ['students.update', $student->id], 'class' => 'well', 'enctype' => 'multipart/form-data']) !!}
        <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="class">শ্রেণী</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-users"></i></span>
                            <select class="form-control" name="class" id="class" required="">
                              <option value="" selected disabled>শিক্ষাবর্ষ নির্ধারণ করুন</option>
                              @for($clss = 1;$clss<=10;$clss++)
                                <option value="{{ $clss }}" @if($student->class == $clss) selected="" @endif>Class {{ $clss }}</option>
                              @endfor
                            </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      @if($student->school->sections > 0)
                      <div class="form-group">
                        <label for="class">শাখা</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-tags"></i></span>
                            <select class="form-control" name="section" id="section" required="">
                              <option value="" selected disabled>শাখা নির্ধারণ করুন</option>
                              <option value="1" @if($student->section == 1) selected="" @endif>A</option>
                              <option value="2" @if($student->section == 2) selected="" @endif>B</option>
                              @if($student->school->sections == 3)
                              <option value="3" @if($student->section == 3) selected="" @endif>C</option>
                              @endif
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
                              <option value="{{ $session_year }}" @if($student->session == $session_year) selected="" @endif>{{ $session_year }}</option>
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
                            
                            <input type="text" name="dob" class="form-control" id="dob" placeholder="জন্মতারিখ" value="{{ date('F d, Y', strtotime($student->dob)) }}" required="">
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
                              <option value="Bangladeshi" @if($student->nationality == 'Bangladeshi') selected="" @endif>Bangladeshi</option>
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
                              <option value="ইসলাম" @if($student->religion == "ইসলাম") selected="" @endif>ইসলাম</option>
                              <option value="হিন্দু" @if($student->religion == "হিন্দু") selected="" @endif>হিন্দু</option>
                              <option value="বৌদ্ধ" @if($student->religion == "বৌদ্ধ") selected="" @endif>বৌদ্ধ</option>
                              <option value="খ্রিস্টান" @if($student->religion == "খ্রিস্টান") selected="" @endif>খ্রিস্টান</option>
                              <option value="অন্যান্য" @if($student->religion == "অন্যান্য") selected="" @endif>অন্যান্য</option>
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
                              <option value="A+" @if($student->blood_group == "A+") selected="" @endif>A+</option>
                              <option value="A-" @if($student->blood_group == "A-") selected="" @endif>A-</option>
                              <option value="B+" @if($student->blood_group == "B+") selected="" @endif>B+</option>
                              <option value="B-" @if($student->blood_group == "B-") selected="" @endif>B-</option>
                              <option value="AB+" @if($student->blood_group == "AB+") selected="" @endif>AB+</option>
                              <option value="AB-" @if($student->blood_group == "AB-") selected="" @endif>AB-</option>
                              <option value="O+" @if($student->blood_group == "O+") selected="" @endif>O+</option>
                              <option value="O-" @if($student->blood_group == "O-") selected="" @endif>O-</option>
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
                              <option value="Male" @if($student->gender == 0) selected="" @endif>Male</option>
                              <option value="Female" @if($student->gender == 1) selected="" @endif>Female</option>
                              <option value="Others" @if($student->gender == 2) selected="" @endif>Others</option>
                            </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        @php $cocurricular_array = explode(',', $student->cocurricular); @endphp
                        <label for="cocurricular">সহপাঠ্যক্রম (এক বা একাধিক)</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-music"></i></span>
                            <select class="form-control" name="cocurricular[]" id="cocurricular" multiple="multiple" required>
                              <option disabled>সহপাঠ্যক্রম নির্ধারণ করুন</option>
                              <option value="ক্রিকেট" @if(in_array('ক্রিকেট', $cocurricular_array)) selected="" @endif>ক্রিকেট</option>
                              <option value="ফুটবল" @if(in_array('ফুটবল', $cocurricular_array)) selected="" @endif>ফুটবল</option>
                              <option value="ভলিবল" @if(in_array('ভলিবল', $cocurricular_array)) selected="" @endif>ভলিবল</option>
                              <option value="সাতাঁর" @if(in_array('সাতাঁর', $cocurricular_array)) selected="" @endif>সাতাঁর</option>
                              <option value="নাচ" @if(in_array('নাচ', $cocurricular_array)) selected="" @endif>নাচ</option>
                              <option value="গান" @if(in_array('গান', $cocurricular_array)) selected="" @endif>গান</option>
                              <option value="চিত্রাংকন" @if(in_array('চিত্রাংকন', $cocurricular_array)) selected="" @endif>চিত্রাংকন</option>
                              <option value="অভিনয়" @if(in_array('অভিনয়', $cocurricular_array)) selected="" @endif>অভিনয়</option>
                              <option value="বক্তৃতা" @if(in_array('বক্তৃতা', $cocurricular_array)) selected="" @endif>বক্তৃতা</option>
                              <option value="বির্তক" @if(in_array('বির্তক', $cocurricular_array)) selected="" @endif>বির্তক</option>
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
                  @if($student->class > 7)
                  {{-- JSC Row --}}
                  <hr>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="jsc_registration_no">JSC রেজিস্ট্রেশন নম্বর</label>
                        {!! Form::text('jsc_registration_no', null, array('placeholder' => 'JSC রেজিস্ট্রেশন নম্বর','class' => 'form-control', 'id' => 'jsc_registration_no', 'autocomplete' => 'off')) !!}
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="jsc_roll">JSC রোল নম্বর</label>
                        {!! Form::text('jsc_roll', null, array('placeholder' => 'JSC রোল নম্বর','class' => 'form-control', 'id' => 'jsc_roll', 'autocomplete' => 'off')) !!}
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="jsc_session">JSC বোর্ড সেশন</label>
                        {!! Form::text('jsc_session', null, array('placeholder' => 'JSC বোর্ড সেশন','class' => 'form-control', 'id' => 'jsc_session', 'autocomplete' => 'off')) !!}
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="jsc_result">JSC ফলাফল (GPA)</label>
                        {!! Form::text('jsc_result', null, array('placeholder' => 'JSC ফলাফল','class' => 'form-control', 'id' => 'jsc_result', 'autocomplete' => 'off')) !!}
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="jsc_fourth_subject_code">JSC ৪র্থ বিষয় কোড</label>
                        {!! Form::text('jsc_fourth_subject_code', null, array('placeholder' => 'JSC ৪র্থ বিষয় কোড','class' => 'form-control', 'id' => 'jsc_fourth_subject_code', 'autocomplete' => 'off')) !!}
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="jsc_subject_codes">JSC বিষয় কোডসমূহ</label>
                        {!! Form::textarea('jsc_subject_codes', null, array('placeholder' => 'JSC বিষয় কোডসমূহ','class' => 'form-control', 'id' => 'jsc_subject_codes', 'rows' => '3', 'style' => 'resize: none;')) !!}
                      </div>
                    </div>
                  </div>
                  {{-- JSC Row --}}
                  @if($student->class > 8)
                  {{-- SSC Row --}}
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="ssc_registration_no">SSC রেজিস্ট্রেশন নম্বর</label>
                        {!! Form::text('ssc_registration_no', null, array('placeholder' => 'SSC রেজিস্ট্রেশন নম্বর','class' => 'form-control', 'id' => 'ssc_registration_no', 'autocomplete' => 'off')) !!}
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="ssc_roll">SSC রোল নম্বর</label>
                        {!! Form::text('ssc_roll', null, array('placeholder' => 'SSC রোল নম্বর','class' => 'form-control', 'id' => 'ssc_roll', 'autocomplete' => 'off')) !!}
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="ssc_session">SSC বোর্ড সেশন</label>
                        {!! Form::text('ssc_session', null, array('placeholder' => 'SSC বোর্ড সেশন','class' => 'form-control', 'id' => 'ssc_session', 'autocomplete' => 'off')) !!}
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="ssc_result">SSC ফলাফল (GPA)</label>
                        {!! Form::text('ssc_result', null, array('placeholder' => 'SSC ফলাফল','class' => 'form-control', 'id' => 'ssc_result', 'autocomplete' => 'off')) !!}
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="ssc_fourth_subject_code">SSC ৪র্থ বিষয় কোড</label>
                        {!! Form::text('ssc_fourth_subject_code', null, array('placeholder' => 'SSC ৪র্থ বিষয় কোড','class' => 'form-control', 'id' => 'ssc_fourth_subject_code', 'autocomplete' => 'off')) !!}
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="ssc_subject_codes">SSC বিষয় কোডসমূহ</label>
                        {!! Form::textarea('ssc_subject_codes', null, array('placeholder' => 'SSC বিষয় কোডসমূহ','class' => 'form-control', 'id' => 'ssc_subject_codes', 'rows' => '3', 'style' => 'resize: none;')) !!}
                      </div>
                    </div>
                  </div>
                  {{-- SSC Row --}}
                  @endif
                  <hr>
                  @endif

                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="previous_school">পূর্বতন বিদ্যালয়ের নাম</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-university"></i></span>
                            {!! Form::text('previous_school', null, array('placeholder' => 'পূর্ববর্তী স্কুলের নাম লিখুন','class' => 'form-control', 'id' => 'previous_school', 'required' => '')) !!}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="pec_result">সমাপনি পরীক্ষার ফলাফল (৫ম শ্রেণির)</label>
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
                        @if($student->image != null || $student->image != '')
                        <img src="{{ asset('images/admission-images/'.$student->image)}}" id='img-upload' style="height: 130px; width: auto; padding: 5px;" />
                        @else
                        <img src="{{ asset('images/dummy_student.jpg')}}" id='img-upload' style="height: 130px; width: auto; padding: 5px;" />
                        @endif
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
