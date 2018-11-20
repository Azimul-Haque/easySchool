@extends('layouts.app')

@section('title', 'Easy School | Payment')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1 full-width-col">
            <div class="panel panel-default">
                <div class="panel-heading"><center><h3><u>ভর্তির আবেদন | আবেদন সফলভাবে করা হয়েছে</u></h3></center></div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-9">
                      <h4>আবেদিত স্কুলঃ <b>{{ $application->school->name }}</b></h4>
                      <big>{{ $application->name }}</big><br/>
                      পিতাঃ {{ $application->father }}<br/>
                      মাতাঃ {{ $application->mother }}<br/>
                      </h4>
                      <h4>অ্যাপলিকেশন আইডিঃ <b><u>{{ $application->application_id }}</u></b></h4>
                      <h4>পেমেন্ট স্ট্যাটাসঃ 
                        @if($application->payment == 0)
                        <b style="color: red;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> পেমেন্ট করা হয়নি</b><br/><br/>
                          @if($application->school->payment_method == 'online')
                            <button class="btn btn-primary">এই বাটনে ক্লিক করে Aamarpay এর মাধ্যোমে {{ $application->school->admission_form_fee }} টাকা পরিশোধ করুন</button>
                          @else
                            স্কুলে গিয়ে {{ $application->school->admission_form_fee }} টাকা পরিশোধ করুন
                          @endif
                        @elseif($application->payment == 1)
                        <b style="color: green;"><i class="fa fa-check-circle-o" aria-hidden="true"></i> পেমেন্ট করা হয়েছে</b><br/><br/>
                        <h4>ভর্তি পরীক্ষার রোলঃ <b>{{ $application->application_roll }}</b><br/><br/>
                        <a href="{{ route('admissions.pdfadmitcard', $application->application_id) }}" target="_blank" class="btn btn-primary"><i class="fa fa-print fa-fw"></i> এডমিট কার্ড প্রিন্ট করুন</a>
                        @endif
                      </h4>
                      <p>* অ্যাপলিকেশন আইডিটি সাবধানে সংরক্ষন করুন।</p>
                    </div>
                    <div class="col-md-3">
                      @if($application->image != null || $application->image != '')
                      <center><img src="{{ url('/images/admission-images/'.$application->image) }}" style="height: 120px; width: auto; border: 1px solid #0196A6;"></center>
                      @else
                      <center><img src="{{ url('images/dummy_student.jpg') }}" style="height: 120px; width: auto; border: 1px solid #0196A6;"></center>
                      @endif
                      <br>
                      <br>
                      <center><a class="btn btn-success btn-block" href="{{ route('admissions.pdfapplicantscopy', $application->application_id) }}" target="_blank"><i class="fa fa-print"></i> আবেদনটি প্রিন্ট করুন</a></center>
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

@section('css')
<style type="text/css">
    .panel-default>.panel-heading {
        color: #fff !important;
        background-color: #0097a7 !important;
        border-color: #ddd;
    }
    @media print {
     .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
          float: left;
     }
     .col-md-12 {
          width: 100%;
     }
     .col-md-11 {
          width: 91.66666667%;
     }
     .col-md-10 {
          width: 83.33333333%;
     }
     .col-md-9 {
          width: 75%;
     }
     .col-md-8 {
          width: 66.66666667%;
     }
     .col-md-7 {
          width: 58.33333333%;
     }
     .col-md-6 {
          width: 50%;
     }
     .col-md-5 {
          width: 41.66666667%;
     }
     .col-md-4 {
          width: 33.33333333%;
     }
     .col-md-3 {
          width: 25%;
     }
     .col-md-2 {
          width: 16.66666667%;
     }
     .col-md-1 {
          width: 8.33333333%;
     }
     .full-width-col {
      width: 100%;
     }
  }
</style>
@stop
