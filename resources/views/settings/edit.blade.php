@extends('adminlte::page')

@section('title', 'Easy School')

@section('content_header')
    <h1>
      School Settings
      <div class="pull-right">
        <a class="btn btn-primary" href="{{ route('dashboard') }}"> Back</a>
      </div>
    </h1>
@stop

@section('content')
{!! Form::model($school, ['route' => ['settings.update', $school->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
  <div class="row">
    <div class="col-md-10 col-md-offset-1 well">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <strong>প্রতিষ্ঠানের নাম নামঃ</strong>
                    {!! Form::text('name', null, array('placeholder' => 'নাম','class' => 'form-control', 'required' => '')) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <strong>ইআইআইএনঃ</strong>
                    {!! Form::text('eiin', null, array('placeholder' => 'ইআইআইএন','class' => 'form-control', 'required' => '')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
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
            <div class="col-md-4">
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
            <div class="col-md-4">
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
        </div> 
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <strong>ঠিকানাঃ</strong>
                    {!! Form::text('address', null, array('placeholder' => 'ঠিকানা','class' => 'form-control', 'required' => '')) !!}
                </div>
            </div>
            <div class="col-md-4">
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
            <div class="col-md-4">
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
            <input type="checkbox" name="classes[]" value="{{ $clss }}" class="classes"
            @if(in_array($clss, $classes)) checked @endif
            > Class {{ $clss }}
            </label>
          @endfor
        </div>  
        <div class="row">
            <div class="col-md-4">
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
            <div class="col-md-4">
                <div class="form-group">
                    <strong>এডমিশন ফর্ম ফি</strong>
                    {!! Form::number('admission_form_fee', null, array('placeholder' => 'এডমিশন ফর্ম ফি','class' => 'form-control', 'required' => '')) !!}
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
                                        ব্রাউজ করুন <input type="file" id="monogram" name="monogram">
                                    </span>
                                </span>
                                <input type="text" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        @if($school->monogram != null)
                        <img src="{{ asset('images/schools/'.$school->monogram) }}" id='img-upload' style="width: 70px; height: 70px; padding: 5px; float: right;" />
                        @else
                        <img src="https://via.placeholder.com/120x120?text=Monogram" id='img-upload' style="width: 70px; height: 70px; padding: 5px; float: right;" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn  btn-success">Save</button>
    </div>
  </div>
{!! Form::close() !!}
@stop

@section('js')
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

      });
  </script>
@stop