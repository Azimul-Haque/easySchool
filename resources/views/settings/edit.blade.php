@extends('adminlte::page')

@section('title', 'Easy School')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
  {!!Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css')!!}
@endsection

@section('content_header')
    <h1>
      <i class="fa fa-cogs fa-fw"></i> স্কুল সেটিংস
      <div class="pull-right">
        <a class="btn btn-primary" href="{{ route('dashboard') }}"> Back</a>
      </div>
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-12">
      {!! Form::model($school, ['route' => ['settings.update', $school->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'class' => 'well']) !!}
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <strong>প্রতিষ্ঠানের নামঃ (বাংলায়)</strong>
                    {!! Form::text('name_bangla', null, array('placeholder' => 'বাংলায় নাম','class' => 'form-control', 'required' => '')) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <strong>প্রতিষ্ঠানের নাম নামঃ (ইংরেজিতে)</strong>
                    {!! Form::text('name', null, array('placeholder' => 'নাম','class' => 'form-control', 'required' => '')) !!}
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
                  <strong>বিদ্যালয় কোডঃ</strong>
                  {!! Form::text('school_code', null, array('placeholder' => 'বিদ্যালয় কোড','class' => 'form-control', 'required' => '')) !!}
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                  <strong>প্রতিষ্ঠানের সচল যোগাযোগের নম্বরঃ</strong>
                  {!! Form::text('contact', null, array('placeholder' => 'যোগাযোগের নম্বর','class' => 'form-control', 'required' => '')) !!}
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
            <label style="margin-right: 20px;">
            <input type="checkbox" name="classes[]" value="{{ $clss }}" class="classes icheck"
            @if(in_array($clss, $classes)) checked @endif
            > Class {{ $clss }}
            </label>
          @endfor
        </div>  
        <div class="row">
          <div class="col-md-6">
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>প্রধান শিক্ষকের স্বাক্ষর</label>
                          <div class="input-group">
                              <span class="input-group-btn">
                                  <span class="btn btn-default btn-file">
                                      ব্রাউজ করুন <input type="file" id="headmaster_sign" name="headmaster_sign">
                                  </span>
                              </span>
                              <input type="text" class="form-control" readonly>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                    @if($school->monogram != null)
                    <img src="{{ asset('images/schools/signs/'.$school->headmaster_sign) }}" id='sign-upload' style="height: 54px; width: 200px; float: right; border: 1px solid #555555;" />
                    @else
                    <img src="https://via.placeholder.com/100x27?text=Sign" id='sign-upload' style="height: 54px; width: 200px; float: right; border: 1px solid #555555;" />
                    @endif
                  </div>
              </div>
          </div>
          <div class="col-md-4">
              <div class="row">
                  <div class="col-md-8">
                      <div class="form-group">
                          <label>মনোগ্রাম(100Kb এর মধ্যে)</label>
                          <div class="input-group">
                              <span class="input-group-btn">
                                  <span class="btn btn-default btn-file">
                                      ছবি সংযুক্ত করুন <input type="file" id="monogram" name="monogram">
                                  </span>
                              </span>
                              <input type="text" class="form-control" readonly>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-4">
                      @if($school->monogram != null)
                      <img src="{{ asset('images/schools/monograms/'.$school->monogram) }}" id='img-upload' style="width: 70px; height: 70px; float: right; border: 1px solid #555555;" />
                      @else
                      <img src="https://via.placeholder.com/120x120?text=Monogram" id='img-upload' style="width: 70px; height: 70px; float: right; border: 1px solid #555555;" />
                      @endif
                  </div>
              </div>
          </div>
        </div>
        <button type="submit" class="btn  btn-success">Save</button>
      {!! Form::close() !!}
    </div>
    

    <div class="col-md-12">
      <h3>
        <i class="fa fa-wrench fa-fw"></i> ভর্তি প্রক্রিয়া সেটিংস
        <div class="pull-right">
          
        </div>
      </h3>
      {!! Form::model($school, ['route' => ['settings.updateadmission', $school->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'class' => 'well']) !!}
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
                <strong>ভর্তি পরীক্ষার ফিঃ</strong>
                {!! Form::text('admission_form_fee', null, array('placeholder' => 'ভর্তি পরীক্ষার ফি','class' => 'form-control')) !!}
            </div>
          </div>
        </div>
        <div class="row">
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
          <div class="col-md-2">
            <div class="form-group">
                <strong>উত্তীর্ণ নম্বর</strong>
                {!! Form::text('admission_pass_mark', null, array('placeholder' => 'উত্তীর্ণ নম্বর','class' => 'form-control')) !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
                <strong>ভর্তি আবেদন শুরু</strong>
                {!! Form::text('admission_start_date', null, array('placeholder' => 'ভর্তি আবেদন শুরু','class' => 'form-control', 'id' => 'admission_start_date', 'autocomplete' => 'off')) !!}
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
                <strong>ভর্তি আবেদন শেষ</strong>
                {!! Form::text('admission_end_date', null, array('placeholder' => 'ভর্তি আবেদন শেষ','class' => 'form-control' , 'id' => 'admission_end_date', 'autocomplete' => 'off')) !!}
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
                <strong>ভর্তি পরীক্ষার সময়</strong>
                {!! Form::text('admission_test_datetime', null, array('placeholder' => 'ভর্তি পরীক্ষার সময়','class' => 'form-control' , 'id' => 'admission_test_datetime', 'autocomplete' => 'off')) !!}
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
                <strong>ভর্তি পরীক্ষার ফলাফল প্রকাশের সময়</strong>
                {!! Form::text('admission_test_result', null, array('placeholder' => 'ভর্তি পরীক্ষার ফলাফল প্রকাশের সময়','class' => 'form-control' , 'id' => 'admission_test_result', 'autocomplete' => 'off')) !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
                <strong>ভর্তির তারিখ (শুরু)</strong>
                {!! Form::text('admission_final_start', null, array('placeholder' => 'ভর্তির তারিখ (শুরু)','class' => 'form-control' , 'id' => 'admission_final_start', 'autocomplete' => 'off')) !!}
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
                <strong>ভর্তির তারিখ (শেষ)</strong>
                {!! Form::text('admission_final_end', null, array('placeholder' => 'ভর্তির তারিখ (শেষ)','class' => 'form-control' , 'id' => 'admission_final_end', 'autocomplete' => 'off')) !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8">
            <strong>এডমিট কার্ডের 'সাধারণ নির্দেশাবলী' (বাংলা হলে ইউনিকোডে লিখুন, সর্বোচ্চ ৮ লাইন)</strong>
            {!! Form::textarea('admit_card_texts', str_replace('<br />', "", $school->admit_card_texts) , array('placeholder' => 'এডমিট কার্ডের সাধারণ নির্দেশাবলী (বাংলা হলে ইউনিকোডে লিখুন)','class' => 'form-control textarea-long' , 'id' => 'admit_card_texts', 'autocomplete' => 'off')) !!}
          </div>
        </div><br/>
        <button type="submit" class="btn  btn-success">Save</button>
      {!! Form::close() !!}
    </div>
  </div>
@stop

@section('js')
  <script type="text/javascript" src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
{{--   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/locale/bn.js"></script> --}}
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
  <script>
    $(document).ready(function(){
      $('.icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        increaseArea: '20%' // optional
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
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#monogram").change(function(){
            readURL(this);
            var filesize = parseInt((this.files[0].size)/1024);
            if(filesize > 100) {
              $("#monogram").val('');
              toastr.warning('File size is: '+filesize+' Kb. try uploading less than 100Kb', 'WARNING').css('width', '400px;');
                setTimeout(function() {
                  $("#img-upload").attr('src', 'https://via.placeholder.com/120x120?text=Monogram');
                }, 1000);
            }
        });

        function readSignURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#sign-upload').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#headmaster_sign").change(function(){
            readSignURL(this);
            var filesize = parseInt((this.files[0].size)/1024);
            if(filesize > 100) {
              $("#headmaster_sign").val('');
              toastr.warning('File size is: '+filesize+' Kb. try uploading less than 100Kb', 'WARNING').css('width', '400px;');
                setTimeout(function() {
                  $("#sign-upload").attr('src', 'https://via.placeholder.com/100x80?text=sign');
                }, 1000);
            }
        });

      });
  </script>
  <script type="text/javascript">
      $(function () {
          $('#admission_start_date').datetimepicker({
            format: 'MMMM DD, YYYY hh:mm A',
            date: new Date('{{ $school->admission_start_date }}')
          });
          $('#admission_end_date').datetimepicker({
            format: 'MMMM DD, YYYY hh:mm A',
            date: new Date('{{ $school->admission_end_date }}')
          });
          $('#admission_test_datetime').datetimepicker({
            format: 'MMMM DD, YYYY hh:mm A',
            date: new Date('{{ $school->admission_test_datetime }}')
          });
          $('#admission_test_result').datetimepicker({
            format: 'MMMM DD, YYYY hh:mm A',
            date: new Date('{{ $school->admission_test_result }}')
          });
          $('#admission_final_start').datetimepicker({
            format: 'MMMM DD, YYYY hh:mm A',
            date: new Date('{{ $school->admission_final_start }}')
          });
          $('#admission_final_end').datetimepicker({
            format: 'MMMM DD, YYYY hh:mm A',
            date: new Date('{{ $school->admission_final_end }}')
          });
      });
  </script>
@stop