<html>
<head>
  <title>Applicants List | PDF</title>
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
    padding: 3px;
    font-family: 'kalpurush', sans-serif;
    font-size: 13px;
  }
  @page {
    header: page-header;
    footer: page-footer;
  }
  </style>
</head>
<body>
  <table>
    <tr>
      <td width="18%">
        @if(Auth::user()->school->monogram != null || Auth::user()->school->monogram != '')
          <img src="{{ public_path('images/schools/monograms/'.Auth::user()->school->monogram) }}" height="100" width="100" style="float: left !important;">
        @else
          
        @endif
      </td>
      <td>
        <p style="text-align: center; font-size: 22px;">
          <center>
            <b>{{ Auth::user()->school->name_bangla }}</b><br/>
            <span style="font-size: 15px;">
              {{ Auth::user()->school->address }}, {{ Auth::user()->school->upazilla }}, {{ Auth::user()->school->district }} <br/>
              স্থাপিতঃ {{ bangla(Auth::user()->school->established) }} ইংরেজি | ইআইআইএনঃ {{ bangla(Auth::user()->school->eiin) }}<br/><br/>
              <span style="font-size: 20px;">
                <b><u>আবেদনকারীদের তালিকা</u></b>
              </span><br/><br/>
              <span style="font-size: 16px;">
                <u>{{ bangla_class($data[0]) }} শ্রেণিতে ভর্তি পরীক্ষা-{{ bangla(Auth::user()->school->admission_session) }} খ্রিঃ</u>
              </span>
            </span><br/><br/><br/>
          </center>
        </p>
      </td>
      <td width="18%"></td>
    </tr>
  </table>
  <table class="maintable">
    <tr>
      <th width="25%">ছাত্র সংখ্যাঃ {{ bangla(count($applications->where('gender', 'MALE'))) }} জন</th>
      <th width="25%">ছাত্রী সংখ্যাঃ {{ bangla(count($applications->where('gender', 'FEMALE'))) }} জন</th>
      <th width="25%">মোটঃ {{ bangla(count($applications)) }} জন</th>
    </tr>
  </table><br/>
  <table class="maintable">
    <tr>
      <th>ক্র.<br/>নং</th>
      <th>আইডি</th>
      <th>প. রোল</th>
      <th>নাম</th>
      <th>পিতার নাম</th>
      <th>গ্রাম</th>
      <th>সমাপনী/ পূর্বের<br/>বিদ্যালয়ের নাম</th>
      <th>জিপিএ</th>
      <th>অভিভাবকের<br/> মোবাঃ. নম্বর</th>
    </tr>
    @php
      $counter = 1;
    @endphp
    @foreach($applications as $application)
    <tr>
      <th>{{ bangla($counter) }}</th>
      <td>{{ $application->application_id }}</td>
      <th>{{ $application->application_roll }}</th>
      <td>{{ $application->name }}</td>
      <td>{{ $application->father }}</td>
      <td>{{ $application->village }}</td>
      <td>{{ $application->previous_school }}</td>
      <td>{{ $application->pec_result }}</td>
      <td>{{ $application->contact }}</td>
    </tr>

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