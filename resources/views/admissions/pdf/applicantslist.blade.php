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
                <b><u>আবেদনকারীদের তালিকা</u></b>
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
      <th>আইডি</th>
      <th>প. রোল</th>
      <th>ইংরেজি নাম</th>
      <th>পিতার নাম</th>
      <th>মাতার নাম</th>
      <th>অভিভাবকের মো. নম্বর</th>
    </tr>
    @foreach($applications as $application)
    <tr>
      <td>{{ $application->application_id }}</td>
      <td>{{ $application->application_roll }}</td>
      <td>{{ $application->name }}</td>
      <td>{{ $application->father }}</td>
      <td>{{ $application->mother }}</td>
      <td>{{ $application->contact }}</td>
    </tr>
    @endforeach
  </table>
</body>
</html>