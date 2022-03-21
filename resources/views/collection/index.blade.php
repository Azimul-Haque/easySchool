@extends('adminlte::page')

@section('title', 'Easy School | Collection Management')

@section('content_header')
    <h1>বেতন ও অন্যান্য ফি আদায় ব্যবস্থাপনা</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('collection.index') }}"><i class="fa fa-money"></i> আদায় ব্যবস্থাপনা</a></li>
        {{-- <li><a href="#">UI</a></li>
        <li class="active">Sliders</li> --}}
    </ol>
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
                    <i class="ion ion-compose"></i>
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
                    <i class="ion ion-stats-bars"></i>
                </div>
                {{-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> --}}
            </a>
        </div>

        <div class="col-lg-3 col-xs-6">
            <a href="{{ route('collection.daily.ledger') }}" class="small-box bg-yellow">
                <div class="inner">
                    <h3 style="font-size: 30px !important;">দৈনিক খতিয়ান</h3>
                    <p>দৈনিক খতিয়ান দেখুন</p>
                </div>
                <div class="icon">
                    <i class="ion ion-clock"></i>
                </div>
                {{-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> --}}
            </a>
        </div>

        <div class="col-lg-3 col-xs-6">
            <a href="{{ route('collection.sector.wise') }}" class="small-box bg-red">
                <div class="inner">
                    <h3 style="font-size: 30px !important;">খাতওয়ারী আদায়</h3>
                    <p>খাতওয়ারী আদায় তালিকা দেখুন</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pricetags"></i>
                </div>
                {{-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> --}}
            </a>
        </div>
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