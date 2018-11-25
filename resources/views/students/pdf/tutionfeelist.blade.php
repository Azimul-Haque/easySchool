<html>
<head>
  <title>Tution Fee List | PDF</title>
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
    font-size: 14px;
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
              {{ Auth::user()->school->name_bangla }} | বেতন আদায় রেজিস্টার<br/>
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
        <td>শ্রেণিঃ {{ bangla_class($data[1]) }},</td>
        <td>শাখাঃ {{ bangla_section(Auth::user()->school->section_type, $data[1], $data[2]) }},</td>
        <td>ছাত্র সংখ্যাঃ {{ bangla(count($students->where("gender", "MALE"))) }} জন,</td>
        <td>ছাত্রী সংখ্যাঃ {{ bangla(count($students->where("gender", "FEMALE"))) }} জন,</td>
        <td>মোটঃ {{ bangla($students->count()) }} জন,</td>
        <td>শিক্ষাবর্ষঃ {{ bangla($data[0]) }}</td>
      </tr>
    </table>
  </htmlpageheader>
  <table class="maintable">
    <tr>
      <th rowspan="2">রোল<br/>নং</th>
      <th rowspan="2">আইডি<br/>মোবাইল নং</th>
      <th rowspan="2" colspan="2">শিক্ষার্থীর নাম</th>
      <th rowspan="2">গত<br/>বছরের<br/>বকেয়া</th>
      <th colspan="2">ভর্তি/ সেশন চার্জ</th>
      <th rowspan="2">বার্ষিক ক্রীড়া</th>
      <th rowspan="2">ফুল/হাফ<br/>ফ্রি ফর্ম</th>
      <th rowspan="2">৩ মাস বেতন</th>
      <th rowspan="2">রেজিঃ ফি</th>
      <th rowspan="2">অর্ধবাঃ পরীঃ ফি</th>
      <th rowspan="2">বার্ষিক পরীঃ ফি</th>
      <th rowspan="2">৯ মাসের বেতন</th>
      <th rowspan="2">ফর্ম ফিল আপ</th>
      <th rowspan="2">উন্নয়ন</th>
      <th rowspan="2">বিবিধ</th>
      <th rowspan="2">মোট আদায়</th>
    </tr>
    <tr>
      <th>১ম বার</th>
      <th>২য় বার</th>
    </tr>
    @php
      $counter = 1;
    @endphp
    @foreach($students as $student)
    <tr>
      <td rowspan="2">{{ $student->roll }}</td>
      <td>{{ $student->student_id }}</td>
      <td rowspan="2">{{ $student->name }}</td>
      <td>টাকা</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>{{ $student->contact }}</td>
      <td>রশিদ নং</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    @if($counter%12 == 0)
     </table>
     <pagebreak></pagebreak> 
     <table class="maintable">
       <tr>
         <th rowspan="2">রোল<br/>নং</th>
         <th rowspan="2">আইডি<br/>মোবাইল নং</th>
         <th rowspan="2" colspan="2">শিক্ষার্থীর নাম</th>
         <th rowspan="2">গত<br/>বছরের<br/>বকেয়া</th>
         <th colspan="2">ভর্তি/ সেশন চার্জ</th>
         <th rowspan="2">বার্ষিক ক্রীড়া</th>
         <th rowspan="2">ফুল/হাফ<br/>ফ্রি ফর্ম</th>
         <th rowspan="2">৩ মাস বেতন</th>
         <th rowspan="2">রেজিঃ ফি</th>
         <th rowspan="2">অর্ধবাঃ পরীঃ ফি</th>
         <th rowspan="2">বার্ষিক পরীঃ ফি</th>
         <th rowspan="2">৯ মাসের বেতন</th>
         <th rowspan="2">ফর্ম ফিল আপ</th>
         <th rowspan="2">উন্নয়ন</th>
         <th rowspan="2">বিবিধ</th>
         <th rowspan="2">মোট আদায়</th>
       </tr>
       <tr>
         <th>১ম বার</th>
         <th>২য় বার</th>
       </tr>
    @endif
    @php
      $counter++;
    @endphp
    @endforeach
  </table>
</body>
</html>