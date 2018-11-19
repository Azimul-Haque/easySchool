@extends('layouts.app')

@section('title', 'Easy School | Admission Form')

@section('css')
<style type="text/css">
    .btn-file {
        position: relative;
        overflow: hidden;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
    #img-upload{
        width: 100%;
    }
</style>
  {!!Html::style('css/bootstrap-datepicker.min.css')!!}
@stop

@section('content')
<div class="container">
    <div class="row">
        @if($school->isadmissionon == 1)
        <div class="col-md-10 col-md-offset-1">
            <center>
                @if(isset($school))
                <h2>{{ $school->name_bangla }}</h2>
                <h4>{{ $school->address }}, {{ $school->upazilla }}, {{ $school->district }}</h4>
                <h4>স্থাপিতঃ {{ bangla($school->established) }} খ্রিঃ | ইআইআইএনঃ {{ bangla($school->eiin) }}</h4>
                @endif
            </center>
            <div class="panel panel-default">
                <div class="panel-heading"><center><span style="font-size: 25px;"><u>ভর্তির আবেদন ফর্ম</u></span></center></div>
                <div class="panel-heading" style="background: lightblue !important; color: black !important;">
                  <small>নির্দেশনাঃ</small><br>
                  <ul>
                    <li><small>ভর্তি শিক্ষাবর্ষঃ {{ bangla($school->admission_session) }}</small></li>
                    <li><small>সকল তথ্য ইংরেজিতে দিতে হবে।</small></li>
                  </ul>
                </div>
                <div class="panel-body" id="admissionformpanelshow">
                  {!! Form::open(array('route' => 'admissions.store','method'=>'POST', 'enctype' => 'multipart/form-data')) !!}
                    {!! Form::hidden('school_id', $school->id) !!}
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="class">যে শ্রেণীতে ভর্তি হতে ইচ্ছুক</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-users"></i></span>
                            <select class="form-control" name="class" id="class" required="">
                              <option value="" selected disabled>শ্রেণী নির্ধারণ করুন</option>
                              @php
                                $classes = explode(',', $school->classes);
                              @endphp
                              @foreach($classes as $class)
                              <option value="{{ $class }}" {{ (old("class") == $class ? "selected":"") }}>Class {{ $class }}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="name">আবেদনকারীর নামঃ (ইংরেজিতে)</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            {!! Form::text('name', old('name'), array('placeholder' => 'Name in English','class' => 'form-control', 'id' => 'name', 'required' => '')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="father">পিতার নামঃ (ইংরেজিতে)</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-male"></i></span>
                            {!! Form::text('father', old('father'), array('placeholder' => 'Father&#8216;s Name in English','class' => 'form-control', 'id' => 'father', 'required' => '')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="mother">মাতার নামঃ (ইংরেজিতে)</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-female"></i></span>
                            {!! Form::text('mother', old('mother'), array('placeholder' => 'Mother&#8216;s Name in English','class' => 'form-control', 'id' => 'mother', 'required' => '')) !!}
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="fathers_occupation">পিতার/ অভিভাবকের পেশাঃ (ইংরেজিতে)</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-male"></i></span>
                            {!! Form::text('fathers_occupation', old('fathers_occupation'), array('placeholder' => 'পিতা/ অভিভাবকের পেশা','class' => 'form-control', 'id' => 'fathers_occupation', 'required' => '')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="yearly_income">অভিভাবকের বাৎসরিক আয়ঃ (টাকায়)</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-line-chart"></i></span>
                            {!! Form::text('yearly_income', old('yearly_income'), array('placeholder' => 'অভিভাবকের বাৎসরিক আয়','class' => 'form-control', 'id' => 'yearly_income', 'required' => '')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="religion">ধর্মঃ</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-flag-o"></i></span>
                            <select class="form-control" name="religion" id="religion" required>
                              <option selected disabled>ধর্ম নির্ধারণ করুন</option>
                              <option value="ISLAM" {{ (old("religion") == 'ISLAM' ? "selected":"") }}>ISLAM</option>
                              <option value="HINDU" {{ (old("religion") == 'HINDU' ? "selected":"") }}>HINDU</option>
                              <option value="BUDDHIST" {{ (old("religion") == 'BUDDHIST' ? "selected":"") }}>BUDDHIST</option>
                              <option value="CHRISTIAN" {{ (old("religion") == 'CHRISTIAN' ? "selected":"") }}>CHRISTIAN</option>
                              <option value="OTHERS" {{ (old("religion") == 'OTHERS' ? "selected":"") }}>OTHERS</option>
                            </select>
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group" id="birthDateContainer">
                          <label for="dob">জন্মতারিখঃ</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar-check-o"></i></span>
                            {!! Form::text('dob', old('dob'), array('id' => 'dob','placeholder' => 'জন্মতারিখ','class' => 'form-control', 'autocomplete' => 'off', 'required' => '')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="gender">লিঙ্গঃ</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-venus-mars"></i></span>
                            <select class="form-control" name="gender" id="gender" required>
                              <option selected disabled>লিঙ্গ নির্ধারণ করুন</option>
                              <option value="MALE" {{ (old("gender") == 'MALE' ? "selected":"") }}>MALE</option>
                              <option value="FEMALE" {{ (old("gender") == 'FEMALE' ? "selected":"") }}>FEMALE</option>
                              <option value="OTHERS" {{ (old("gender") == 'OTHERS' ? "selected":"") }}>OTHERS</option>
                            </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="cocurricular">সহপাঠ্যক্রমঃ (এক বা একাধিক)</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-music"></i></span>
                            <select class="form-control" name="cocurricular[]" id="cocurricular" multiple="multiple" data-placeholder="সহপাঠ্যক্রম নির্বাচন করুন"  required>
                              <option disabled>সহপাঠ্যক্রম নির্ধারণ করুন</option>
                              <option value="CRICKET" {{ (collect(old('cocurricular'))->contains('CRICKET')) ? 'selected':'' }}>CRICKET</option>
                              <option value="FOOTBALL" {{ (collect(old('cocurricular'))->contains('FOOTBALL')) ? 'selected':'' }}>FOOTBALL</option>
                              <option value="VOLLEYBAL" {{ (collect(old('cocurricular'))->contains('VOLLEYBAL')) ? 'selected':'' }}>VOLLEYBALL</option>
                              <option value="SWIMMING" {{ (collect(old('cocurricular'))->contains('SWIMMING')) ? 'selected':'' }}>SWIMMING</option>
                              <option value="DANCE" {{ (collect(old('cocurricular'))->contains('DANCE')) ? 'selected':'' }}>DANCE</option>
                              <option value="SINGING" {{ (collect(old('cocurricular'))->contains('SINGING')) ? 'selected':'' }}>SINGING</option>
                              <option value="DRAWING" {{ (collect(old('cocurricular'))->contains('CRICKET')) ? 'selected':'' }}>DRAWING</option>
                              <option value="DRAWING" {{ (collect(old('cocurricular'))->contains('CRICKET')) ? 'selected':'' }}>DRAWING</option>
                              <option value="ACTING" {{ (collect(old('cocurricular'))->contains('ACTING')) ? 'selected':'' }}>ACTING</option>
                              <option value="EXTEMPORE SPEECH" {{ (collect(old('cocurricular'))->contains('EXTEMPORE SPEECH')) ? 'selected':'' }}>EXTEMPORE SPEECH</option>
                              <option value="DEBATE" {{ (collect(old('cocurricular'))->contains('DEBATE')) ? 'selected':'' }}>DEBATE</option>
                            </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                          <label for="village">গ্রামঃ (ইংরেজিতে)</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                            {!! Form::text('village', old('village'), array('placeholder' => 'গ্রামের নাম','class' => 'form-control', 'id' => 'village', 'required' => '')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                          <label for="post_office">ডাকঘরঃ (ইংরেজিতে)</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                            {!! Form::text('post_office', old('post_office'), array('placeholder' => 'ডাকঘরের নাম','class' => 'form-control', 'id' => 'post_office', 'required' => '')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                          <label for="district">জেলাঃ</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                            <select class="form-control" id="district" name="district" required="">
                              <option value="" selected="" disabled="">জেলা নির্ধারণ করুন</option>
                              @foreach($districts as $district)
                              <option value="{{ $district }}" {{ (old("district") == $district ? "selected":"") }}>{{ $district }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                          <label for="district">উপজেলাঃ</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                            <select class="form-control" id="upazilla" name="upazilla" required="" disabled="">
                              @if(old('upazilla', null) != null)
                              <option value="{{ old('upazilla') }}" selected>{{ old('upazilla') }}</option>
                              @else
                              <option value="" selected disabled>উপজেলা নির্ধারণ করুন</option>
                              @endif
                            </select>
                          </div>
                        </div>  
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="contact">অভিভাবকের মোবাইল নম্বরঃ (ইংরেজিতে)</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                            {!! Form::text('contact', old('contact'), array('placeholder' => 'মোবাইল নম্বর লিখুন','class' => 'form-control', 'id' => 'contact', 'required' => '')) !!}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="contact_2">অভিভাবকের আরেকটি মোবাইল নম্বরঃ (ইংরেজিতে)</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                            {!! Form::text('contact_2', old('contact_2'), array('placeholder' =>'দ্বিতীয় মোবাইল নম্বর লিখুন','class' => 'form-control', 'id' => 'contact_2', 'required' => '')) !!}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="nationality">জাতীয়তাঃ</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                            <select class="form-control" name="nationality" id="nationality" required>
                              <option selected disabled>জাতীয়তা নির্ধারণ করুন</option>
                              <option value="BANGLADESHI" {{ (old("nationality") == 'BANGLADESHI' ? "selected":"") }}>BANGLADESHI</option>
                              <option value="OTHERS">OTHERS</option>
                            </select>
                            {!! Form::text('nationality', null, array('placeholder' => 'Write Nationality','class' => 'form-control', 'id' => 'nationalityText', 'style' => 'display:none;')) !!}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="blood_group">রক্তের গ্রুপঃ (জানা না থাকলে এড়িয়ে যান)</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-tint"></i></span>
                            <select class="form-control" name="blood_group" id="blood_group">
                              <option selected disabled>রক্তের গ্রুপ নির্ধারণ করুন</option>
                              <option value="A+" {{ (old("blood_group") == 'A+' ? "selected":"") }}>A+</option>
                              <option value="A-" {{ (old("blood_group") == 'A-' ? "selected":"") }}>A-</option>
                              <option value="B+" {{ (old("blood_group") == 'B+' ? "selected":"") }}>B+</option>
                              <option value="B-" {{ (old("blood_group") == 'B-' ? "selected":"") }}>B-</option>
                              <option value="AB+" {{ (old("blood_group") == 'AB+' ? "selected":"") }}>AB+</option>
                              <option value="AB-" {{ (old("blood_group") == 'AB-' ? "selected":"") }}>AB-</option>
                              <option value="O+" {{ (old("blood_group") == 'O+' ? "selected":"") }}>O+</option>
                              <option value="O-" {{ (old("blood_group") == 'O-' ? "selected":"") }}>O-</option>
                            </select>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="previous_school">গতবছরে পঠিত বিদ্যালয়ের নামঃ (ইংরেজিতে)</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-university"></i></span>
                            {!! Form::text('previous_school', old('previous_school'), array('placeholder' => 'পূর্ববর্তী স্কুলের নাম লিখুন','class' => 'form-control', 'id' => 'previous_school', 'required' => '')) !!}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="pec_result">সমাপনি/ সর্বশেষ বার্ষিক পরীক্ষার ফলাফল</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-balance-scale"></i></span>
                            {!! Form::text('pec_result', old('pec_result'), array('placeholder' =>'সমাপনি/ সর্বশেষ বার্ষিক পরীক্ষার ফলাফল','class' => 'form-control', 'id' => 'pec_result', 'required' => '')) !!}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>আবেদনকারীর ছবি</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        ছবি যুক্ত করুন <input type="file" id="image" name="image">
                                    </span>
                                </span>
                                <input type="text" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                      <center>
                        <img src="{{ asset('images/dummy_student.jpg')}}" id='img-upload' style="height: 130px; width: auto; padding: 5px;" />
                      </center>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <button type="button" class="btn btn-warning btn-block" id="submitPreview" data-toggle="modal" data-target="#preview_data" data-backdrop="static">প্রাকদর্শন</button>
                        <div class="modal fade" id="preview_data" role="dialog">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header modal-header-primary">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">
                                  <center>
                                    <p style="font-size: 20px;">
                                      @if(isset($school))
                                        {{ $school->name }}
                                      @endif
                                    </p>
                                    <p style="font-size: 15px;"><u>ভর্তির আবেদন ফর্ম</u></p>
                                  </center>
                                </h4>
                              </div>
                              <div class="modal-body">
                                <table class="table table-hover table-striped table-bordered">
                                  <tr>
                                    <td width="35%">আবেদনকারীর নামঃ (বাংলায়)</td>
                                    <td id="aplicantnameBPreview"></td>
                                  </tr>
                                  <tr>
                                    <td>আবেদনকারীর নামঃ (ইংরেজিতে)</td>
                                    <td id="aplicantnameEPreview"></td>
                                  </tr>
                                  <tr>
                                    <td>বাবার নামঃ</td>
                                    <td id="faNamePreview"></td>
                                  </tr>
                                  <tr>
                                    <td>মা'র নামঃ</td>
                                    <td id="moNamePreview"></td>
                                  </tr>
                                  <tr>
                                    <td>জাতীয়তাঃ</td>
                                    <td id="nationalityPreview"></td>
                                  </tr>
                                  <tr>
                                    <td>লিঙ্গঃ</td>
                                    <td id="genderPreview"></td>
                                  </tr>
                                  <tr>
                                    <td>জন্মতারিখঃ</td>
                                    <td id="dobPreview"></td>
                                  </tr>
                                  <tr>
                                    <td>অভিভাবকের মোবাইল নম্বরঃ</td>
                                    <td id="contactPreview"></td>
                                  </tr>
                                  <tr>
                                    <td>যে শ্রেণীতে ভর্তি হতে ইচ্ছুকঃ</td>
                                    <td id="classToAdmitPreview"></td>
                                  </tr>
                                  <tr>
                                    <td>আবেদনকারীর ছবিঃ</td>
                                    <td id="">
                                      <img src="{{ asset('images/dummy_student.jpg')}}" id="imagePreview" style="height: 130px; width: auto; padding: 5px;">
                                    </td>
                                  </tr>
                                </table>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">ঠিক আছে</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                      <button type="submit" class="btn btn-primary btn-block">দাখিল করুন</button>
                    </div>
                  </div>
                  {!! Form::close() !!}
                </div>
            </div>
        </div>
        @else
        <div class="col-md-12">
          <center>আবেদন গ্রহণ বন্ধ আছে...</center>
        </div>
        @endif
    </div>
</div>
@endsection

@section('js')
    {!!Html::script('js/bootstrap-datepicker.min.js')!!}
    {!!Html::script('js/select2.min.js')!!}
    
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
          $('#name').keyup(function(){
              this.value = this.value.toUpperCase();
          });
          $('#father').keyup(function(){
              this.value = this.value.toUpperCase();
          });
          $('#mother').keyup(function(){
              this.value = this.value.toUpperCase();
          });
          $('#fathers_occupation').keyup(function(){
              this.value = this.value.toUpperCase();
          });
          $('#village').keyup(function(){
              this.value = this.value.toUpperCase();
          });
          $('#post_office').keyup(function(){
              this.value = this.value.toUpperCase();
          });
          $('#nationalityText').keyup(function(){
              this.value = this.value.toUpperCase();
          });
          $('#previous_school').keyup(function(){
              this.value = this.value.toUpperCase();
          });

          $('#nationality').change(function(){
              if($('#nationality').val() == 'OTHERS') {
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


          // update the preview table
          $("#submitPreview").click(function(){                     
            $("#aplicantnameBPreview").html($("#name_bangla").val());
            $("#aplicantnameEPreview").html($("#name").val());
            $("#faNamePreview").html($("#father").val());
            $("#moNamePreview").html($("#mother").val());
            $("#dobPreview").html($("#dob").val());
            $("#nationalityPreview").html($("#nationality").val());
            $("#genderPreview").html($("#gender").val());
            $("#contactPreview").html($("#contact").val());
            $("#classToAdmitPreview").html($("#class").val());
            $("#addressPreview").html($("#address").val());
          }); 
        });
    </script>

    <script type="text/javascript">
      $('#cocurricular').select2();
      $('#district').select2();
      $('#upazilla').select2();

      $('#district').on('change', function() {
        $('#upazilla').prop('disabled', true);
        $('#upazilla').append('<option value="" selected disabled>লোড হচ্ছে...</option>');
        $.ajax({
          url: "/schools/getupazillas/api/"+$(this).val(), 
          type: "GET",
          success: function(result){
            $('#upazilla')
                .find('option')
                .remove()
                .end()
                .prop('disabled', false)
                .append('<option value="" selected disabled>উপজেলা নির্ধারণ করুন</option>');
            for(var countupazilla = 0; countupazilla < result.length; countupazilla++) {
              //console.log(result[countupazilla]);
              $('#upazilla').append('<option value="'+result[countupazilla]+'">'+result[countupazilla]+'</option>')
            }
          }
        });
      });
    </script>
    <script type="text/javascript">
      $('#class').on('change', function() {
        $('#section').prop('disabled', true);
        $('#section').append('<option value="" selected disabled>লোড হচ্ছে...</option>');

        if($('#class').val() < 9) {
          $('#section')
                .find('option')
                .remove()
                .end()
                .prop('disabled', false)
                .append('<option value="" selected disabled>শাখা নির্ধারণ করুন</option>');

          $('#section').append('<option value="'+1+'">A</option>');
          $('#section').append('<option value="'+2+'">B</option>');
          $('#section').append('<option value="'+3+'">C</option>');
        } else {
          $('#section')
                .find('option')
                .remove()
                .end()
                .prop('disabled', false)
                .append('<option value="" selected disabled>শাখা নির্ধারণ করুন</option>');

          $('#section').append('<option value="'+1+'">SCIENCE</option>');
          $('#section').append('<option value="'+2+'">ARTS</option>');
          $('#section').append('<option value="'+3+'">COMMERCE</option>');
          $('#section').append('<option value="'+4+'">VOCATIONAL</option>');
          $('#section').append('<option value="'+5+'">TECHNICAL</option>');
        }
      });
    </script>
@stop
