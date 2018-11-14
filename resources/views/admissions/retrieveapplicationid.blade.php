@extends('layouts.app')

@section('title', 'Easy School | Admission Form')

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
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><center><h3><u>ভর্তির আবেদন | অ্যাপলিকেশন আইডি উদ্ধার করুন</u></h3></center></div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-12">
                      <center>
                        <div class="form-inline">
                            <div class="input-group" id="birthDateContainer">
                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                              <input type="text" id="dob" class="form-control" placeholder="জন্মতারিখ" required="" autocomplete="off">
                            </div>
                            <div class="input-group" id="birthDateContainer">
                              <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                              <input type="text" id="contact" class="form-control" placeholder="অভিভাবকের ফোন নম্বর" required="">
                            </div>
                            <button class="btn btn-success" id="search"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
                        </div>
                        <h3 id="application_id"></h3>
                      </center>
                    </div>
                  </div>
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
  $(document).ready(function() {
    $('#search').click(function() {
      if($('#dob').val() && $('#contact').val()){
        dob = $('#dob').val();
        contact = $('#contact').val();
        $.ajax({
          url: "/admission/form/retrieve/"+dob+"/"+contact+"",
          type: "GET",
          data: {'dob': dob, 'contact': contact},
          success: function (data) {
            var response = data;
            console.log(response);
            $('#application_id').html('অ্যাপলিকেশন আইডিঃ <b><u>'+response+'</u></b>');
          }
        });
      } else {
        toastr.warning('জন্মতারিখ এবং, অথবা অভিভাবকের ফোন নম্বর দিন!', 'WARNING').css('width','400px');
      }
    });
  });
</script>

@stop