@extends('adminlte::page')

@section('title', 'Easy School | Create School')

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
    {!! Form::open(array('route' => 'schools.store','method'=>'POST')) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>প্রতিষ্ঠানের নাম নামঃ</strong>
                            {!! Form::text('name', null, array('placeholder' => 'নাম','class' => 'form-control', 'required' => '')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>ইআইআইএনঃ</strong>
                            {!! Form::text('eiin', null, array('placeholder' => 'ইআইআইএন','class' => 'form-control', 'required' => '')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
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
                    <div class="col-md-4">
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
                    <div class="col-md-4">
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
                    <div class="col-md-4">
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
                            <option value="manual">ম্যানুয়াল</option>
                            <option value="online">অনলাইন</option>
                          </select>
                        </div> 
                    </div>
                    <div class="col-md-4">
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
                    <label style="margin-right: 40px;">
                    <input type="checkbox" name="classes[]" value="{{ $clss }}" class="classes"> Class {{ $clss }}
                    </label>
                  @endfor
                </div>  
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <strong>চলতি পরীক্ষার নাম নির্ধারণ করুন</strong>
                          <select class="form-control" name="currentexam">
                            <option selected disabled>চলতি পরীক্ষার নাম নির্ধারণ করুন</option>
                            <option value="halfyearly">অর্ধবার্ষিকী/প্রাক-নির্বাচনী পরীক্ষা</option>
                            <option value="final">বার্ষিক/নির্বাচনী পরীক্ষা</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
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
                            <div class="col-md-6">
                                <img src="https://via.placeholder.com/120x120?text=Monogram" id='img-upload' style="height: 120px; width: auto; padding: 5px; float: right;" />
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('.multiple').select2();
        });

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

                $("#imgInp").change(function(){
                    readURL(this);
                });     
            });
    </script>
@stop

