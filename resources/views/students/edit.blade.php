@extends('adminlte::page')

@section('title', 'Easy School')

@section('css')
  {!!Html::style('css/bootstrap-datepicker.min.css')!!}
@stop


@section('content_header')
    <h1>Edit Student
    <div class="pull-right">
        <a class="btn btn-primary" href="{{ url()->previous() }}"> Back</a>
    </div>
    </h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        {!! Form::model($student, ['method' => 'PATCH','route' => ['students.update', $student->id], 'class' => 'well', 'enctype' => 'multipart/form-data']) !!}
        <div class="row">
            <div class="form-group col-md-4">
                <strong>ইংরেজি নামঃ</strong>
                {!! Form::text('name', null, array('placeholder' => 'ইংরেজি নাম','class' => 'form-control', 'required' => '', 'id' => 'name')) !!}
            </div>
            <div class="form-group col-md-4">
                <strong>বাংলা নামঃ</strong>
                {!! Form::text('name_bangla', null, array('placeholder' => 'বাংলা নাম','class' => 'form-control', 'required' => '', 'id' => 'name_bangla')) !!}
            </div>
            <div class="form-group col-md-4" id="birthDateContainer">
                <strong>জন্মতারিখঃ</strong>
                <input type="text" name="dob" id="dob" value="{{ date('F d, Y', strtotime($student->dob)) }}" class="form-control" required="" placeholder="জন্মতারিখ" autocomplete="off">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <strong>পিতার নামঃ</strong>
                {!! Form::text('father', null, array('placeholder' => 'পিতার নাম','class' => 'form-control', 'required' => '', 'id' => 'father')) !!}
            </div>
            <div class="form-group col-md-4">
                <strong>মাতার নামঃ</strong>
                {!! Form::text('mother', null, array('placeholder' => 'মাতার নাম','class' => 'form-control', 'required' => '', 'id' => 'mother')) !!}
            </div>
            <div class="form-group col-md-4">
                <strong>অভিভাবকের মোবাইল নম্বরঃ</strong>
                {!! Form::text('contact', null, array('placeholder' => 'ঠিকানা','class' => 'form-control', 'required' => '')) !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <strong>ঠিকানাঃ</strong>
                {!! Form::text('address', null, array('placeholder' => 'ঠিকানা','class' => 'form-control', 'required' => '')) !!}
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>শিক্ষার্থীর ছবি</label>
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
                    <div class="col-md-4">
                      <center>
                        <img src="{{ asset('images/dummy_student.jpg')}}" id='img-upload' style="height: 100px; width: auto; padding: 5px;" />
                      </center>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="form-group col-md-3">
                <strong>শ্রেনিঃ</strong>
                <select class="form-control" name="class" required="">
                <option selected="" disabled="" value="">শ্রেণি নির্ধারণ করুন</option>
                @php
                    $classes = explode(',', Auth::user()->school->classes);
                @endphp
                @foreach($classes as $class)
                <option value="{{ $class }}" @if($class == $student->class) selected="" @endif>Class {{ $class }}</option>
                @endforeach
            </select>
            </div>
            <div class="form-group col-md-3">
                <strong>শাখাঃ</strong>
                <select class="form-control" name="section" required="">
                    <option selected="" disabled="" value="">সেকশন নির্ধারণ করুন</option>
                    <option value="A" @if($student->section == 'A') selected="" @endif>A</option>
                    <option value="B" @if($student->section == 'B') selected="" @endif>B</option>
                    <option value="C" @if($student->section == 'C') selected="" @endif>C</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <strong>রোল নংঃ</strong>
                {!! Form::number('roll', null, array('placeholder' => 'রোল নং','class' => 'form-control', 'required' => '', 'id' => 'roll')) !!}
            </div>
            <div class="form-group col-md-3">
                <strong>শিক্ষাবর্ষঃ</strong>
                <select class="form-control" name="session" required="">
                    <option selected="" disabled="">শিক্ষাবর্ষ নির্ধারণ করুন</option>
                    @for($optionyear = (date('Y')+1) ; $optionyear>=(Auth::user()->school->established); $optionyear--)
                    <option value="{{ $optionyear }}" @if($student->session == $optionyear) selected="" @endif>{{ $optionyear }}</option>
                    @endfor
                </select>
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
