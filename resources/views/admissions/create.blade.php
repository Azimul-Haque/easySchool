@extends('layouts.app')

@section('title', 'Easy School')

@section('css')
<style type="text/css">
    .panel-default>.panel-heading {
        color: #fff !important;
        background-color: #0097a7 !important;
        border-color: #ddd;
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
                {{ $school->name }}
                @endif
            </center>
            <div class="panel panel-default">
                <div class="panel-heading"><h4>ভর্তির আবেদনপত্র</h4></div>
                <div class="panel-body" id="admissionformpanelshow">
                  {!! Form::open(array('route' => 'admissions.store','method'=>'POST')) !!}
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
                          <label for="name_bangla">আবেদনকারীর নাম (বাংলায়)</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            {!! Form::text('name', null, array('placeholder' => 'বাংলায় পুরো নাম','class' => 'form-control', 'id' => 'name_bangla')) !!}
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="datepicker1">জন্মতারিখ</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            {!! Form::text('dob', null, array('id' => 'datepicker1','placeholder' => 'Date of Birth','class' => 'form-control')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="name_bangla">আবেদনকারীর নাম (বাংলায়)</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            {!! Form::text('name', null, array('placeholder' => 'বাংলায় পুরো নাম','class' => 'form-control', 'id' => 'name_bangla')) !!}
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="gender">লিঙ্গ</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-venus-mars"></i></span>
                            <select class="form-control" name="gender" id="gender" required>
                              <option selected disabled>লিঙ্গ নির্বাচন করুন</option>
                              <option value="পুরুষ">পুরুষ</option>
                              <option value="মহিলা">মহিলা</option>
                              <option value="অন্যান্য">অন্যান্য</option>
                            </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="image">ছবি (jpg/png format, less than 100KB)</label>
                        <div class="input-group">
                          <span class="input-group-addon" id="imageCheck"><i class="fa fa-picture-o"></i></span>
                          <input type="file" class="form-control" name="image" id="image" accept="image/*" required>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Address:</strong>
                            {!! Form::textarea('address', null, array('placeholder' => 'Address','class' => 'form-control textarea', 'rows' => '5')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Contact:</strong>
                            {!! Form::text('contact', null, array('placeholder' => 'Contact','class' => 'form-control')) !!}
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Session:</strong>
                            {!! Form::number('session', '2017', array('placeholder' => 'Session','class' => 'form-control')) !!}
                        </div>
                    </div>
                  </div>

                    {{--<div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Description:</strong>
                            {!! Form::textarea('description', null, array('placeholder' => 'Description','class' => 'form-control','style'=>'height:100px')) !!}
                        </div>
                    </div> --}}
                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
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
        $('#datepicker1').datepicker({
            format: 'MM dd, yyyy',
            autoclose: true,
            todayHighlight: true,
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
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
    
@stop
