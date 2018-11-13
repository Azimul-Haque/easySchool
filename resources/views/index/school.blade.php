@extends('layouts.schoollayout')

@section('title')
  ইজি স্কুল | {{ $school->name }}
@endsection

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/school-tabs.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-9">
        <div class="board">
          <!-- <h2>Welcome to IGHALO!<sup>™</sup></h2>-->
          <div class="board-inner">
            <ul class="nav nav-tabs shadow-without-bottom">
              <div class="liner"></div>
              <li class="active">
                <a href="#home" data-toggle="tab" title="নীড়">
                 <span class="round-tabs one">
                        <i class="fa fa-home" aria-hidden="true"></i>
                 </span> 
                </a>
              </li>
              <li>
                <a href="#admission" data-toggle="tab" title="অ্যাডমিশন">
                 <span class="round-tabs two">
                     <i class="fa fa-file-text-o" aria-hidden="true"></i>
                 </span> 
                </a>
              </li>
              <li>
                <a href="#result" data-toggle="tab" title="ফলাফল">
                 <span class="round-tabs three">
                      <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                 </span>
                </a>
              </li>

              <li>
                  <a href="#notice" data-toggle="tab" title="নোটিশ">
                   <span class="round-tabs four">
                        <i class="fa fa-bullhorn" aria-hidden="true"></i>
                   </span> 
                  </a>
              </li>

              <li>
                <a href="#others" data-toggle="tab" title="অন্যান্য">
                 <span class="round-tabs five">
                      <i class="fa fa-pagelines" aria-hidden="true"></i>
                 </span>
                </a>
              </li>
             </ul>
          </div>

          <div class="tab-content">
            <div class="tab-pane fade in active" id="home">
                <h3 class="head text-center">
                  <b>{{ $school->name_bangla }}</b>-এ আপনাকে স্বাগতম
                </h3>
                <p class="narrow text-center">
                    বিদ্যালয়টি {{ bangla($school->established) }} সাল থেকে প্রতিষ্ঠার পর থেকে নিষ্ঠার সাথে এ অঞ্চলে নিম্নমাধ্যমিক ও মাধ্যমিক শিক্ষাক্ষেত্রে ব্যাপক ভূমিকা রেখে চলেছে। 
                </p>
            </div>
            <div class="tab-pane fade" id="admission">
                <h3 class="head text-center">অ্যাডমিশন সংক্রান্ত পাতা</h3>
                @if($school->isadmissionon == 1)
                <p class="narrow text-center">
                    ভর্তির আবেদনপত্র গ্রহণ চলছে
                </p>
                
                <p class="text-center">
                    <a href="{{ route('admissions.apply', $school->id)  }}" class="btn btn-success btn-outline-rounded green"> আবেদন করুন <span style="margin-left:10px;" class="glyphicon glyphicon-send"></span></a>
                </p>
                @else
                @endif
            </div>
            <div class="tab-pane fade" id="result">
                <div class="row">
                  <div class="col-md-6">admission result</div>
                  <div class="col-md-6">regular result</div>
                </div>
            </div>
            <div class="tab-pane fade" id="notice">
                <h3 class="head text-center">নোটিশ তালিকা</h3>
                <p class="narrow text-center">
                    <div class="list-group">
                      <a href="#" class="list-group-item">প্রথম নোটিশ</a>
                      <a href="#" class="list-group-item">দ্বিতীয় নোটিশ</a>
                      <a href="#" class="list-group-item">তৃতীয় নোটিশ</a>
                    </div>
                </p>
            </div>
            <div class="tab-pane fade" id="others">
              কাজ চলছে...
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="panel panel-success">
            <div class="panel-heading">স্কুলের তথ্য</div>
            <div class="panel-body">
              <table width="100%">
                <tr>
                  <th width="40%">স্থাপিত</th>
                  <td>{{ bangla($school->established) }} সালে</td>
                </tr>
                <tr>
                  <th width="30%">ইআইআইএন</th>
                  <td>{{ bangla($school->eiin) }}</td>
                </tr>
                <tr>
                  <th width="30%">সেকশন</th>
                  <td>{{ bangla($school->sections) }} টি</td>
                </tr>
                <tr>
                  <th width="30%">চলতি শিক্ষাবর্ষ</th>
                  <td>{{ bangla($school->currentsession) }}</td>
                </tr>
              </table>
            </div>
        </div>
      </div>
    </div>
</div>
@endsection

@section('js')
   <script type="text/javascript">
     $(function(){
      $('a[title]').tooltip();
     });
   </script>
@endsection
