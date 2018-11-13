@extends('adminlte::page')

@section('title', 'Easy School')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container">
      <div class="row">
          <div class="col-md-8 col-md-offset-1" style="background-color:;" align="center">
            <div class="btn-group-vertical">
              <div class"row">
                <div class="btn-group">
                  <a class="btn btn-default dashboard-box-button" title="কাজ চলছে">
                    <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Administration
                  </a>
                  <a href="{{ route('admissions.index') }}" class="btn btn-default dashboard-box-button" title="ভর্তি প্রক্রিয়ার পাতায় চলুন" style="color: #FDBD2F;">
                    <i class="fa fa-user-plus dashboard-icon" aria-hidden="true"></i><br/>ভর্তি প্রক্রিয়া
                  </a>
                  <a href="{{ route('students.index') }}" class="btn btn-default dashboard-box-button" title="শিক্ষার্থী ব্যবস্থাপনার পাতায় চলুন" style="color: #F0685E;">
                    <i class="fa fa-users dashboard-icon" aria-hidden="true"></i><br/>শিক্ষার্থী ব্যবস্থাপনা
                  </a>
                  <a class="btn btn-default dashboard-box-button" title="কাজ চলছে" style="color: #3E5E99;">
                    <i class="fa fa-graduation-cap dashboard-icon" aria-hidden="true"></i><br/>ফলাফল
                  </a>
                </div>
              </div>
              <div class"row">
                <div class="btn-group">
                  <a class="btn btn-default dashboard-box-button" title="কাজ চলছে">
                    <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                  </a>
                  <a class="btn btn-default dashboard-box-button" title="কাজ চলছে">
                    <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                  </a>
                  <a class="btn btn-default dashboard-box-button" title="কাজ চলছে">
                    <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                  </a>
                  <a class="btn btn-default dashboard-box-button" title="কাজ চলছে">
                    <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                  </a>
                </div>
              </div>
              <div class"row">
                <div class="btn-group">
                  <a class="btn btn-default dashboard-box-button" title="কাজ চলছে">
                    <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                  </a>
                  <a class="btn btn-default dashboard-box-button" title="কাজ চলছে">
                    <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                  </a>
                  <a class="btn btn-default dashboard-box-button" title="কাজ চলছে">
                    <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                  </a>
                  <a class="btn btn-default dashboard-box-button" title="কাজ চলছে">
                    <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                  </a>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
@stop

@section('js')
<script type="text/javascript">
  $(function(){
   $('a[title]').tooltip();
  });
</script>
@stop