<html>
<head>
  <title>Admission Result | PDF</title>
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
        @if(Auth::user()->school->monogram != null || Auth::user()->school->monogram != '')
          <img src="{{ public_path('images/schools/monograms/'.Auth::user()->school->monogram) }}" height="120" width="120" style="float: left !important;">
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
              <span style="font-size: 22px;">
                <b><u>ভর্তি পরীক্ষার ফলাফল</u></b>
              </span><br/><br/>
              <span style="font-size: 18px;">
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
      <td width="25%">মোট আবেদনকারীঃ {{ bangla($data[1]) }} জন</td>
      <td width="25%">অংশগ্রহণকারীঃ {{ bangla($data[2]) }} জন</td>
      <td width="25%">পাশঃ {{ bangla($data[3]) }} জন</td>
      <td width="25%">ফেইলঃ {{ bangla($data[2] - $data[3]) }} জন</td>
    </tr>
  </table><br/>
  <table class="maintable">
    <tr>
      <th>আইডি</th>
      <th>প. রোল</th>
      <th>নাম</th>
      <th>ইংরেজি নাম</th>
      <th>পিতার নাম</th>
      <th>মাতার নাম</th>
      <th>প্রাপ্ত নম্বর</th>
      <th>মেরিট পজিশন</th>
    </tr>
    @foreach($applications as $application)
    <tr>
      <td>{{ $application->application_id }}</td>
      <td>{{ $application->application_roll }}</td>
      <td>{{ $application->name_bangla }}</td>
      <td>{{ $application->name }}</td>
      <td>{{ $application->father }}</td>
      <td>{{ $application->mother }}</td>
      <td>{{ $application->mark_obtained }}</td>
      <td>
        @if($application->merit_position == -1)
          <span style="color: #FF0000;">Failed</span>
        @else
          {{ $application->merit_position }}
        @endif
      </td>
    </tr>
    @endforeach
  </table>
</body>
</html>