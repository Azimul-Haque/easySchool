@extends('adminlte::page')

@section('title', 'Easy School | Create School')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
@stop

@section('content_header')
    <h1>
        প্রতিষ্ঠান সংযোজন
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('schools.index') }}"> Back</a>
        </div>
    </h1>
@stop

@section('content')
    {{-- @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}
    {!! Form::open(array('route' => 'schools.store','method'=>'POST', 'enctype' => 'multipart/form-data')) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>প্রতিষ্ঠানের নামঃ (বাংলায়)</strong>
                            {!! Form::text('name', null, array('placeholder' => 'বাংলায় নাম','class' => 'form-control', 'required' => '')) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>প্রতিষ্ঠানের নামঃ (ইংরেজিতে)</strong>
                            {!! Form::text('name_bangla', null, array('placeholder' => 'ইংরেজিতে নাম','class' => 'form-control', 'required' => '')) !!}
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
                          <strong>শাখার সংখ্যাঃ</strong>
                          <select class="form-control" name="sections" required="">
                            <option value="" selected disabled>শাখার সংখ্যা নির্ধারণ করুন</option>
                            <option value="0">কোন শাখা নেই</option>
                            <option value="2">দুইটি শাখা</option>
                            <option value="3">তিনটি শাখা</option>
                          </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                          <strong>শাখার ধরণ (৯ম-১০ম শ্রেণির জন্য)</strong>
                          <select class="form-control" name="section_type" required="">
                            <option value="" selected disabled>শাখার ধরণ নির্ধারণ করুন</option>
                            <option value="0">প্রযোজ্য নয়</option>
                            <option value="1">A(ক), B(খ), C(গ)</option>
                            <option value="2">SCIENCE (বিজ্ঞান), Arts(মানবিক), COMMERCE(বাণিজ্য)</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                          <strong>স্থাপিতঃ</strong>
                          <select class="form-control" name="established" required="">
                            <option value="" selected disabled>স্থাপনার সাল নির্ধারণ করুন</option>
                          @php
                            $y = date('Y');
                            for($y; $y>=1901; $y--) {
                          @endphp
                              <option value="{{ $y }}">{{ $y }}</option>
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
                              <option value="{{ $y }}">{{ $y }}</option>
                          @php
                            }
                          @endphp
                          </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                          <strong>ভর্তি প্রক্রিয়াঃ</strong>
                          <br/>
                          <label style="margin-right: 40px;">
                          <input type="radio" name="isadmissionon" value="0" required> বন্ধ</label>
                          <label style="margin-right: 40px;">
                          <input type="radio" name="isadmissionon" value="1"> চলছে</label>
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
                          <select class="form-control" id="district" name="district" required="">
                            <option value="" selected="" disabled="">জেলা নির্ধারণ করুন</option>
                            @foreach($districts as $district)
                            <option value="{{ $district }}">{{ $district }}</option>
                            @endforeach
                          </select>
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                          <strong>উপজেলাঃ</strong>
                          <select class="form-control" id="upazilla" name="upazilla" required="" disabled="">
                            <option value="" selected disabled>উপজেলা নির্ধারণ করুন</option>
                          </select>
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                          <strong>শেষ সংঘটিত পরীক্ষার ফলাফলঃ</strong>
                          <br/>
                          <label style="margin-right: 40px;">
                          <input type="radio" name="isresultpublished" value="0" required> বন্ধ আছে</label>
                          <label style="margin-right: 40px;">
                          <input type="radio" name="isresultpublished" value="1"> দেওয়া হয়েছে</label>
                        </div> 
                    </div>
                </div>
                <div class="form-group">
                  <strong>ক্লাসঃ</strong>
                  <br/>
                  @for($clss = 1;$clss<=10;$clss++)
                    <label style="margin-right: 25px;">
                    <input type="checkbox" name="classes[]" value="{{ $clss }}" class="classes icheck"> Class {{ $clss }}
                    </label>
                  @endfor
                </div>  
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                          <strong>পেমেন্ট মেথডঃ</strong>
                          <select class="form-control" name="payment_method" required="">
                            <option value="" selected disabled>পেমেন্ট মেথড নির্ধারণ করুন</option>
                            <option value="manual">ম্যানুয়াল</option>
                            <option value="online">অনলাইন</option>
                          </select>
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
                                                ব্রাউজ করুন <input type="file" id="imgInp" name="monogram">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <img src="https://via.placeholder.com/120x120?text=Monogram" id='img-upload' style="height: 110px; width: auto; padding: 5px; float: right;" />
                            </div>
                        </div>
                    </div>
                </div>    
                
                
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
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
  <script type="text/javascript">
    $(document).ready(function() {
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
                .append('<option value="" selected disabled>উপজেলা নির্ধারণ করুন</option>')
            ;
            for(var countupazilla = 0; countupazilla < result.length; countupazilla++) {
              //console.log(result[countupazilla]);
              $('#upazilla').append('<option value="'+result[countupazilla]+'">'+result[countupazilla]+'</option>')
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
                  $('#img-upload').attr('src', e.target.result);
              }
              
              reader.readAsDataURL(input.files[0]);
          }
      }

      $("#imgInp").change(function(){
          readURL(this);
          var filesize = parseInt((this.files[0].size)/1024);
          if(filesize > 100) {
            $("#imgInp").val('');
            toastr.warning('File size is: '+filesize+' Kb. try uploading less than 100Kb', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#img-upload").attr('src', '{{ asset('images/dummy_student.jpg') }}');
              }, 1000);
          }
      });     
    });
  </script>
@stop

