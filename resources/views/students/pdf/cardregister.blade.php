<html>
<head>
  <title>Card Register | PDF</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="icon" sizes="192x192" href="{{ asset('images/pdf-icon.png') }}">
  <style>
  body {
    font-family: 'kalpurush', sans-serif;
  }
  table {
      border-collapse: collapse;
      width: 100%;
  }

  .maintable tr td, .maintable tr th {
      border: 1px solid black;
  }
  .maintable tr th, .maintable tr td{
    padding: 2px;
    font-family: 'kalpurush', sans-serif;
    font-size: 12px;
  }
  .nostyletd {
    border: 0px solid white !important;
  }
  @page {
    header: page-header;
    footer: page-footer;
  }
  </style>
</head>
<body>
  <htmlpageheader name="page-header">
    <table>
      <tr>
        <td width="10%">
          @if(Auth::user()->school->monogram != null || Auth::user()->school->monogram != '')
            <img src="{{ public_path('images/schools/monograms/'.Auth::user()->school->monogram) }}" height="50" width="50" style="float: left !important; margin-top: -25px;">
          @else
            
          @endif
        </td>
        <td>
          <p style="text-align: center; font-size: 22px;">
            <center>
              {{ Auth::user()->school->name_bangla }}<br/>
              <span style="font-size: 15px;">
                ইআইআইএনঃ {{ bangla(Auth::user()->school->eiin) }}, ডাকঘরঃ {{ Auth::user()->school->address }}, উপজেলাঃ {{ Auth::user()->school->upazilla }}, জেলাঃ {{ Auth::user()->school->district }}
              </span>
            </center>
          </p>
        </td>
        <td width="10%"></td>
      </tr>
    </table>
    <table class="">
      <tr>
        <td>
          <center>
            <big>@if($data[1] == 8) JSC @elseif($data[1] > 8) SSC @endif রেজিস্ট্রেশন কার্ড, এডমিট কার্ড, মার্কশিট, সার্টিফিকেট প্রদান রেজিস্টার</big>
          </center>
        </td>
      </tr>
    </table>
  </htmlpageheader>
  <table class="maintable">
    <tr>
      <th>ক্র.<br/>নং</th>
      <th>শিক্ষার্থীর নাম<br/>পিতার নাম<br/>মাতার নাম</th>
      <th>ছবি</th>
      <th>গ্রাম<br/>ডাকঘর<br/>মোবাঃ নম্বর</th>
      <th>@if($data[1] == 8) JSC @elseif($data[1] > 8) SSC @endif রোল<br/>রেজিস্ট্রেশন নং<br/>সেশন</th>
      <th>রেজিস্ট্রেশন কার্ড ও<br/>এডমিট কার্ড<br/>গ্রহণ স্বাক্ষর</th>
      <th>জিপিএ</th>
      <th>মার্কশিট<br/>গ্রহণ<br/>স্বাক্ষর</th>
      <th>সার্টিফিকেট<br/>গ্রহণ<br/>স্বাক্ষর</th>
    </tr>
    @php
      $counter = 1;
    @endphp
    @foreach($students as $student)
    <tr>
      <th width="3%">{{ $counter }}</th>
      <td>{{ $student->name }}<br/>{{ $student->father }}<br/>{{ $student->mother }}</td>
      <td>
        <center>
          @if($student->image != null && $student->image != '')
          <img src="{{ public_path('images/admission-images/'.$student->image) }}" height="40" width="40">
          @else
          <img src="{{ public_path('images/dummy_student.jpg') }}" height="40" width="40">
          @endif
        </center>
      </td>
      <td>{{ $student->village }}<br/>{{ $student->post_office }}<br/>{{ $student->contact }}</td>
      <td width="10%">
        @if($data[1] == 8)
          {{ $student->jsc_roll }}<br/>
          {{ $student->jsc_registration_no }}<br/>
          {{ $student->jsc_session }}
        @elseif($data[1] > 8)
          {{ $student->ssc_roll }}<br/>
          {{ $student->ssc_registration_no }}<br/>
          {{ $student->ssc_session }}
        @endif
      </td>
      <td width="10%"></td>
      <td width="10%" align="center" style="text-align: center;">
        @if($data[1] == 8)
          {{ $student->jsc_result }}
        @elseif($data[1] > 8)
          {{ $student->ssc_result }}
        @endif
      </td>
      <td width="10%"></td>
      <td width="10%"></td>
    </tr>
    @if($counter%10 == 0)
     </table>
     <pagebreak></pagebreak> 
     <table class="maintable">
         <tr>
           <th>ক্র.<br/>নং</th>
           <th>শিক্ষার্থীর নাম<br/>পিতার নাম<br/>মাতার নাম</th>
           <th>ছবি</th>
           <th>গ্রাম<br/>ডাকঘর<br/>মোবাঃ নম্বর</th>
           <th>@if($data[1] == 8) JSC @elseif($data[1] > 8) SSC @endif রোল<br/>রেজিস্টার নং<br/>সেশন</th>
           <th>রেজিস্ট্রেশন কার্ড ও<br/>এডমিট কার্ড<br/>গ্রহণ স্বাক্ষর</th>
           <th>জিপিএ</th>
           <th>মার্কশিট<br/>গ্রহণ<br/>স্বাক্ষর</th>
           <th>সার্টিফিকেট<br/>গ্রহণ<br/>স্বাক্ষর</th>
         </tr>
    @endif
    @php
      $counter++;
    @endphp
    @endforeach
  </table>

  <htmlpagefooter name="page-footer">
    <small style="font-family: Calibri; color: #6D6E6A;">Powered by EasySchool.XYZ</small>
  </htmlpagefooter>
</body>
</html>