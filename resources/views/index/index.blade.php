@extends('layouts.app')

@section('title', 'Easy School')

@section('css')

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    স্কুল সিলেক্ট করুন
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <div class="form-group">
                              <strong>উপজেলাঃ</strong>
                              <select class="form-control" id="upazilla" name="upazilla" required="" disabled="">
                                <option value="" selected disabled>উপজেলা নির্ধারণ করুন</option>
                              </select>
                            </div>  
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                              <strong>স্কুলঃ</strong>
                              <select class="form-control" id="school" name="school" required="" disabled="">
                                <option value="" selected disabled>স্কুল নির্বাচন করুন</option>
                              </select>
                            </div>  
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary btn-block" id="gotoschoolbtn" disabled="">স্কুলের পাতায় চলুন</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">test</div>
                <div class="panel-body">test</div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">test</div>
                <div class="panel-body">test</div>
            </div>
            <div class="panel panel-warning">
                <div class="panel-heading">test</div>
                <div class="panel-body">test</div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">test</div>
                <div class="panel-body">test</div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">test</div>
                <div class="panel-body">test</div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    {!!Html::script('js/select2.min.js')!!}
    <script type="text/javascript">
      $(document).ready(function() {
        $('#district').select2();
        $('#upazilla').select2();
        $('#school').select2();
        $('#district').on('change', function() {
          $('#upazilla').prop('disabled', true);
          $('#school').prop('disabled', true);
          $('#gotoschoolbtn').prop('disabled', true);
          $('#upazilla').append('<option value="" selected disabled>লোড হচ্ছে...</option>');
          $('#school').find('option').remove().end().append('<option value="" selected disabled>স্কুল নির্বাচন করুন</option>');

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
        $('#upazilla').on('change', function() {
            $('#school').prop('disabled', true);
            $('#school').append('<option value="" selected disabled>লোড হচ্ছে...</option>');
            $.ajax({
              url: "/schools/getschools/api/"+$('#district').val()+'/'+$('#upazilla').val(), 
              type: "GET",
              success: function(result){
                $('#school')
                    .find('option')
                    .remove()
                    .end()
                    .prop('disabled', false)
                    .append('<option value="" selected disabled>স্কুল নির্বাচন করুন</option>')
                ;
                // console.log(result);
                if(result.length > 0) {
                    for(var countschool = 0; countschool < result.length; countschool++) {
                      $('#school').append('<option value="'+result[countschool].token+'">'+result[countschool].name+'</option>')
                    }
                } else {
                    $('#school').prop('disabled', true);
                    toastr.warning('কোন স্কুল পাওয়া যায়নি!', 'WARNING').css('width', '400px;');
                }
              }
            });
        });
        $('#school').on('change', function() {
            if($(this).val() != null) {
                $('#gotoschoolbtn').prop('disabled', false);
            }
        });
        $('#gotoschoolbtn').on('click', function() {
            window.location.href = window.location.protocol + "//" + window.location.host + "/school/" + $('#school').val();
        });
      });
    </script>
@endsection
