@extends('layouts.app')

@section('title', 'Easy School | Admission Form')

@section('css')
<style type="text/css">
    .panel-default>.panel-heading {
        color: #fff !important;
        background-color: #0097a7 !important;
        border-color: #ddd;
    }
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
<div class="container" style="margin-top: 100px;">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <center>
                @if(isset($school))
                <h2>{{ $school->name }}</h2>
                <h4>স্থাপিতঃ {{ $school->established }} | EIIN: {{ $school->eiin }}</h4>
                @endif
            </center>
            <div class="panel panel-default">
                <div class="panel-heading"><center><h3><u>ভর্তির আবেদন</u></h3></center></div>
                <div class="panel-body" id="admissionformpanelshow">
                  {!! Form::open(array('route' => 'admissions.store','method'=>'POST', 'enctype' => 'multipart/form-data')) !!}
                    @if(isset($school))
                      {!! Form::hidden('school_id', $school->id) !!}
                    @else
                      {!! Form::hidden('school_id', 'manual') !!}
                    @endif
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="name_bangla">আবেদনকারীর নাম (বাংলায়)</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            {!! Form::text('name_bangla', null, array('placeholder' => 'বাংলায় পুরো নাম','class' => 'form-control', 'id' => 'name_bangla')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="name">Applicants Name (English)</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            {!! Form::text('name', null, array('placeholder' => 'Name in English','class' => 'form-control', 'id' => 'name')) !!}
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="father">Father's Name (English)</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-male"></i></span>
                            {!! Form::text('father', null, array('placeholder' => 'Father&#8216;s Name in English','class' => 'form-control', 'id' => 'father')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="mother">Mother's Name (English)</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-female"></i></span>
                            {!! Form::text('mother', null, array('placeholder' => 'Mother&#8216;s Name in English','class' => 'form-control', 'id' => 'mother')) !!}
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
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
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="gender">লিঙ্গ</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-venus-mars"></i></span>
                            <select class="form-control" name="gender" id="gender" required>
                              <option selected disabled>লিঙ্গ নির্ধারণ করুন</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                              <option value="Others">Others</option>
                            </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group" id="birthDateContainer">
                          <label for="dob">জন্মতারিখ</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar-check-o"></i></span>
                            {!! Form::text('dob', null, array('id' => 'dob','placeholder' => 'জন্মতারিখ','class' => 'form-control', 'autocomplete' => 'off')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="address">ঠিকানা</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                            {!! Form::text('address', null, array('placeholder' => 'যোগাযোগের পূর্ণ ঠিকানা','class' => 'form-control', 'id' => 'address')) !!}
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="contact">অভিভাবকের মোবাইল নম্বর</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                            {!! Form::text('contact', null, array('placeholder' => 'Put Mobile Number','class' => 'form-control', 'id' => 'contact')) !!}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="class">যে শ্রেণীতে ভর্তি হতে ইচ্ছুক</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                            <select class="form-control" name="class" id="class" required="">
                              <option value="" selected disabled>শিক্ষাবর্ষ নির্ধারণ করুন</option>
                              @for($clss = 1;$clss<=10;$clss++)
                                <option value="{{ $clss }}">Class {{ $clss }}</option>
                              @endfor
                            </select>
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
                                        ব্রাউজ করুন <input type="file" id="image" name="image" required="">
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
                                    <td>ঠিকানাঃ</td>
                                    <td id="addressPreview"></td>
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
    </div>
</div>
@endsection

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
      @if(isset($school))
        $(document).ready(function() {
          $.ajax({
            url: "/getadmissionstatus/{{$school->id }}",
            type: "GET",
            data: {},
            success: function (data) {
              var response = data;
              console.log(response);
              if(response == 0) {
                $('#admissionformpanelshow').html('আবেদন গ্রহণ বন্ধ আছে।');
              } else if(response == 1) {
                
              }
            }
          });
        });
      @endif
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
@stop
