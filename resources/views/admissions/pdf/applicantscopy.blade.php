<html>
<head>
  <title>{{ $application->application_id }} | Applicants Copy | PDF</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="shortcut icon" type="image/png" sizes="192x192" href="{{ asset('images/pdf-icon.png') }}">
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
    padding: 5px;
    font-family: 'kalpurush', sans-serif;
    font-size: 14px;
  }
  </style>
</head>
<body>
  <p style="text-align: center; font-size: 25px;">
    <b>{{ $application->school->name_bangla }}</b><br/>
    <span style="font-size: 15px;">
      {{ $application->school->address }}, {{ $application->school->upazilla }}, {{ $application->school->district }} <br/>
      স্থাপিতঃ {{ bangla($application->school->established) }} ইংরেজি | ইআইআইএনঃ {{ bangla($application->school->eiin) }}<br/><br/>
      <span style="font-size: 22px;">
        <b><u>{{ bangla($application->class) }}@if($application->class == 6)ষ্ঠ @else ম @endif শ্রেণিতে ভর্তি পরীক্ষার আবেদন ফর্ম-{{ bangla($application->school->admission_session) }} খ্রিঃ</u></b>
      </span>
    </span><br/>
  </p>
  <table class="maintable">
    <tr>
      <td align="right"><b>অ্যাপ্লিকেশন আইডিঃ</b> <big>{{ $application->application_id }}</big></td>
      <td><b>ভর্তিচ্ছু শ্রেণি ও শাখাঃ</b> 
        {{ bangla($application->class) }}@if($application->class == 6)ষ্ঠ@elseম@endif 
        @if($application->section == 1) ক @elseif($application->section ==2) খ @elseif($application->section == 3) গ @endif
      </td>
    </tr>
    <tr>
      <th width="40%" align="right">আবেদনকারী শিক্ষার্থীর নামঃ (বাংলায়)</th>
      <td>{{ $application->name_bangla }}</td>
    </tr>
    <tr>
      <th align="right">আবেদনকারী শিক্ষার্থীর নামঃ (ইংরেজিতে)</th>
      <td>{{ $application->name }}</td>
    </tr>
    <tr>
      <th align="right">পিতার নামঃ</th>
      <td>{{ $application->father }}</td>
    </tr>
    <tr>
      <th align="right">মাতার নামঃ</th>
      <td>{{ $application->mother }}</td>
    </tr>
    <tr>
      <th align="right">ঠিকানাঃ</th>
      <td>
        <span style="width: 50%">গ্রামঃ {{ $application->village }}</span>,
        <span style="width: 50%">পোঃ {{ $application->post_office }}</span>,<br/>
        <span style="width: 50%">উপজেলাঃ {{ $application->upazilla }}</span>,
        <span style="width: 50%">জেলাঃ {{ $application->district }}</span>
      </td>
    </tr>
    <tr>
      <th align="right">পিতা/ অভিভাবকের পেশাঃ</th>
      <td>{{ $application->fathers_occupation }}</td>
    </tr>
    <tr>
      <th align="right">মাতার পেশাঃ</th>
      <td>{{ $application->fathers_occupation }}</td>
    </tr>
    <tr>
      <th align="right">মোবাইল নম্বরঃ</th>
      <td>{{ $application->contact }}</td>
    </tr>
    <tr>
      <th align="right">প্রার্থীর জন্মতারিখঃ</th>
      <td>{{ bangla(date('d-m-Y', strtotime($application->dob))) }}, কথায়ঃ {{ bangla(date('F d, Y', strtotime($application->dob))) }} খ্রিঃ</td>
    </tr>
    <tr>
      <th align="right">ধর্মঃ</th>
      <td>{{ $application->religion }}</td>
    </tr>
    <tr>
      <th align="right">জাতীয়তাঃ</th>
      <td>{{ $application->nationality }}</td>
    </tr>
    <tr>
      <th align="right">অভিভাবকের বার্ষিক আয়ঃ</th>
      <td>{{ $application->yearly_income }}</td>
    </tr>
    <tr>
      <th align="right">পূর্বতন বিদ্যালয়ের নামঃ</th>
      <td>{{ $application->previous_school }}</td>
    </tr>
    <tr>
      <th align="right">সমাপনী পরীক্ষার ফলাফলঃ</th>
      <td>{{ $application->pec_result }}</td>
    </tr>
    <tr>
      <th align="right">ছবিঃ</th>
      <td>
        @if($application->image != null || $application->image != '')
          <img src="{{ public_path('images/admission-images/'.$application->image) }}" style="height: 150px; width: auto;">
        @else
          <img src="{{ public_path('images/dummy_student.jpg') }}" style="height: 150px; width: auto;">
        @endif
      </td>
    </tr>
  </table>
  <p style="text-align: center; font-size: 17px;">
    <b>:ছাত্র/ছাত্রীর অঙ্গিকার নামা:</b><br/>
    <span style="text-align: left; font-size: 15px;">আমি এই মর্মে অঙ্গিকার ও স্বীকার করিতেছি উপরে বর্ণিত সকল তথ্য সঠিক। কোন রকম ভূল তথ্য সরবরাহ করিলে আমি ব্যক্তিগত ভাবে দায়ি থাকিব।</span>
  </p>
  <br/><br/>
  <table>
    <tr>
      <td align="left">
        <span style="border-top: 1px solid #000;">পিতা/ অভিভাবকের স্বাক্ষর</span>
      </td>
      <td align="right">
        <span style="border-top: 1px solid #000;">আবেদনকারী শিক্ষার্থীর স্বাক্ষর</span>
      </td>
    </tr>
  </table>
</body>
</html>