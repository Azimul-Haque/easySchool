@extends('adminlte::page')

@section('title', 'Easy School | Collection Management')

@section('content_header')
    <h1>বেতন ও অন্যান্য ফি আদায় ব্যবস্থাপনা</h1>
@stop

@section('content')
  {{-- @permission('school-settings') --}}
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <a href="{{ route('collection.input.form') }}" class="small-box bg-aqua">
                <div class="inner">
                    <h3 style="font-size: 30px !important;">ইনপুট ফরম</h3>
                    <p>তথ্য ইনপুট দিতে ক্লিক করুন</p>
                </div>
                <div class="icon">
                    <i class="fa fa-check-square-o"></i>
                </div>
                {{-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> --}}
            </a>
        </div>

        <div class="col-lg-3 col-xs-6">
            <a href="{{ route('collection.list') }}" class="small-box bg-green">
                <div class="inner">
                    <h3 style="font-size: 30px !important;">আদায় তালিকা</h3>
                    <p>তারিখ অনুযায়ী আদায় তালিকা</p>
                </div>
                <div class="icon">
                    <i class="fa fa-list-ul"></i>
                </div>
                {{-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> --}}
            </a>
        </div>

        {{-- <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3 style="font-size: 30px !important;">44</h3>
                    <p>User Registrations</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3 style="font-size: 30px !important;">65</h3>
                    <p>Unique Visitors</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div> --}}
    </div>
  {{-- @endpermission --}}
@stop

@section('js')
<script type="text/javascript">
  $(function(){
   $('a[title]').tooltip();
   $('button[title]').tooltip();
  });
</script>
@stop