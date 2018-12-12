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
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1" style="min-height: 400px;">
            <div class="panel panel-default">
                <div class="panel-heading"><center><h3><u>ভর্তির আবেদন | পেমেন্ট ও এডমিট কার্ড</u></h3></center></div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                      <div class="form-inline">
                          <label for="application_id">অ্যাপলিকেশন আইডিঃ</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" id="application_id" class="form-control" placeholder="অ্যাপলিকেশন আইডিঃ" required="">
                          </div>
                          <button class="btn btn-success" id="search"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
  $(document).ready(function() {
    $('#search').click(function() {
      if($('#application_id').val()){
        application_id = $('#application_id').val();
        window.location = '/admission/form/payment/'+application_id;
      } else {
        toastr.warning('অ্যাপলিকেশন আইডিটি দিন!', 'WARNING').css('width','400px');
      }
    });
  });
</script>
@stop