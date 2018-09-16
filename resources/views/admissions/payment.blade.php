@extends('layouts.app')

@section('title', 'Easy School | Payment')

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
<div class="container" style="margin-top: 100px;">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><center><h3><u>ভর্তির আবেদন | আবেদন সফলভাবে করা হয়েছে</u></h3></center></div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-10">
                      <h4>আবেদিত স্কুলঃ <b>{{ $application->school->name }}</b></h4>
                      <big>{{ $application->name }}</big>, পিতাঃ {{ $application->father }}, মাতাঃ {{ $application->mother }} এর আবেদন সফলভাবে সম্পন্ন হয়েছে।<b></b>
                      <h4>অ্যাপলিকেশন আইডিঃ <b><u>{{ $application->application_id }}</u></b></h4>
                      <h4>পেমেন্ট স্ট্যাটাসঃ 
                        @if($application->payment == 0)
                        <b style="color: red;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> পেমেন্ট করা হয়নি</b>
                        @elseif($application->payment == 1)
                        <b style="color: green;"><i class="fa fa-check-circle-o" aria-hidden="true"></i> পেমেন্ট করা হয়েছে</b>
                        @endif
                      </h4>
                      <p>অ্যাপলিকেশন আইডিটি সাবধানে সংরক্ষন করুন।</p>
                    </div>
                    <div class="col-md-2">
                      <img src="{{ url('/images/admission-images/'.$application->image) }}" style="height: 120px; width: auto; border: 1px solid #0196A6;">
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@stop
