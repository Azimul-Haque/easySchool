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
  <table>
    <tr>
      <td width="18%">
        @if($application->school->monogram != null || $application->school->monogram != '')
          <img src="{{ public_path('images/schools/monograms/'.$application->school->monogram) }}" height="120" width="120" style="float: left !important;">
        @else
          
        @endif
      </td>
      <td>
        <p style="text-align: center; font-size: 22px;">
          <center>
            <b>{{ $application->school->name_bangla }}</b><br/>
            <span style="font-size: 15px;">
              {{ $application->school->address }}, {{ $application->school->upazilla }}, {{ $application->school->district }} <br/>
              স্থাপিতঃ {{ bangla($application->school->established) }} ইংরেজি | ইআইআইএনঃ {{ bangla($application->school->eiin) }}<br/><br/>
              <span style="font-size: 22px;">
                <b><u>আবেদনপত্র</u></b>
              </span><br/><br/>
              <span style="font-size: 18px;">
                <u>{{ bangla_class($application->class) }} শ্রেণিতে ভর্তি পরীক্ষা-{{ bangla($application->school->admission_session) }} খ্রিঃ</u>
              </span>
            </span><br/><br/><br/>
          </center>
        </p>
      </td>
      <td width="18%">
        @if($application->image != null || $application->image != '')
          <img src="{{ public_path('images/admission-images/'.$application->image) }}" height="120" width="120" style="float: right !important; border: 1px solid #666;">
        @else
          <img src="{{ public_path('images/dummy_student.jpg') }}" height="120" width="120" style="float: right !important; border: 1px solid #666;">
        @endif
      </td>
    </tr>
  </table>
  <table class="maintable">
    <tr>
      <td align="right"><b>অ্যাপ্লিকেশন আইডিঃ</b> <big>{{ $application->application_id }}</big></td>
      <td><b>ভর্তিচ্ছু শ্রেণি ও শাখাঃ</b> 
        {{ bangla_class($application->class) }}
        @if($application->class < 9)
                @if( $application->section == 1)
                  {{ bangla_section('A') }}
                @elseif( $application->section == 2)
                  {{ bangla_section('B') }}
                @elseif( $application->section == 3)
                  {{ bangla_section('C') }}
                @endif
              @else
                @if( $application->section == 1)
                  {{ bangla_section('SCIENCE') }}
                @elseif( $application->section == 2)
                  {{ bangla_section('ARTS') }}
                @elseif( $application->section == 3)
                  {{ bangla_section('COMMERCE') }}
                @elseif( $application->section == 4)
                  {{ bangla_section('VOCATIONAL') }}
                @elseif( $application->section == 5)
                  {{ bangla_section('TECHNICAL') }}
                @endif
              @endif
      </td>
    </tr>
    <tr>
      <th align="right">ভর্তি শিক্ষাবর্ষঃ</th>
      <td>{{ bangla($application->session) }}</td>
    </tr>
    <tr>
      <th align="right">আবেদনকারী শিক্ষার্থীর নামঃ</th>
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
      <th align="right">পিতা/ অভিভাবকের বাৎসরিক আয়ঃ</th>
      <td>{{ bangla($application->yearly_income) }}/-</td>
    </tr>
    <tr>
      <th align="right">মোবাইল নম্বরঃ</th>
      <td>{{ $application->contact }}, {{ $application->contact_2 }}</td>
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
      <th align="right">লিঙ্গঃ</th>
      <td>{{ $application->gender }}</td>
    </tr>
    <tr>
      <th align="right">রক্তের গ্রুপঃ</th>
      <td>{{ $application->blood_group }}</td>
    </tr>
    <tr>
      <th align="right">সহপাঠ্যক্রমঃ</th>
      <td>{{ $application->cocurricular }}</td>
    </tr>
    <tr>
      <th align="right">পূর্বতন বিদ্যালয়ের নামঃ</th>
      <td>{{ $application->previous_school }}</td>
    </tr>
    <tr>
      <th align="right">সমাপনী পরীক্ষার ফলাফলঃ</th>
      <td>{{ $application->pec_result }}</td>
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