<html>
<head>
  <title>Admission Information | PDF</title>
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
              {{ Auth::user()->school->name_bangla }} | শিক্ষার্থী ভর্তি রেজিস্টার-{{ bangla($data[0]) }}<br/>
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
        <th width="33%">শ্রেণিঃ {{ bangla_class($data[1]) }},</th>
        <th width="34%">শাখাঃ {{ bangla_section(Auth::user()->school->section_type, $data[1], $data[2]) }},</th>
        <th width="33%">মোট ভর্তিঃ {{ bangla($students->count()) }} জন</th>
      </tr>
    </table>
  </htmlpageheader>
  <table class="maintable">
    <tr>
      <th>ক্র.<br/>নং</th>
      <th>আইডি<br/>রোল<br/>মোবাইল নং</th>
      <th>ছবি</th>
      <th>শিক্ষার্থীর নাম<br/>পিতার নাম<br/>মাতার নাম</th>
      <th>গ্রাম<br/>ডাকঘর<br/>উপজেলা</th>
      <th>পূর্বতন বিদ্যালয়য়ের নাম<br/>ঠিকানা</th>
      <th>জিপিএ<br/>জন্মতারিখ<br/>ভর্তির তারিখ</th>
      <th>ভর্তি<br/>গ্রহণকারীর<br/>স্বাক্ষর</th>
      <th>প্রধান<br/>শিক্ষকের<br/>স্বাক্ষর</th>
      <th>টিসি<br/>সংক্রান্ত<br/>মন্তব্য</th>
    </tr>
    @php
      $counter = 1;
    @endphp
    @foreach($students as $student)
    <tr>
      <td>{{ $counter }}</td>
      <td>{{ $student->student_id }}<br/>{{ $student->roll }}<br/>{{ $student->contact }}</td>
      <td>
        @if($student->image != null && $student->image != '')
        <img src="{{ public_path('images/admission-images/'.$student->image) }}" height="40" width="40">
        @else
        <img src="{{ public_path('images/dummy_student.jpg') }}" height="40" width="40">
        @endif
      </td>
      <td>{{ $student->name }}<br/>{{ $student->father }}<br/>{{ $student->mother }}</td>
      <td>{{ $student->village }}<br/>{{ $student->post_office }}<br/>{{ $student->upazilla }}</td>
      <td>{{ $student->previous_school }}<br/>{{ $student->previous_school_address }}</td>
      <td>{{ $student->pec_result }}<br/>{{ date('d-m-Y', strtotime($student->dob)) }}<br/>{{ date('d-m-Y', strtotime($student->admission_date)) }}</td>
      <td width="7%"></td>
      <td width="7%"></td>
      <td width="7%"></td>
    </tr>
    @if($counter%10 == 0)
     </table>
     <pagebreak></pagebreak> 
     <table class="maintable">
         <tr>
           <th>ক্র.<br/>নং</th>
           <th>আইডি<br/>রোল<br/>মোবাইল নং</th>
           <th>ছবি</th>
           <th>শিক্ষার্থীর নাম<br/>পিতার নাম<br/>মাতার নাম</th>
           <th>গ্রাম<br/>ডাকঘর<br/>উপজেলা</th>
           <th>পূর্বতন বিদ্যালয়য়ের নাম<br/>ঠিকানা</th>
           <th>জিপিএ<br/>জন্মতারিখ<br/>ভর্তির তারিখ</th>
           <th>ভর্তি<br/>গ্রহণকারীর<br/>স্বাক্ষর</th>
           <th>প্রধান<br/>শিক্ষকের<br/>স্বাক্ষর</th>
           <th>টিসি<br/>সংক্রান্ত<br/>মন্তব্য</th>
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