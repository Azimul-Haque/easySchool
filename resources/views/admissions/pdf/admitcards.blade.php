<html>
<head>
  <title>Admit Cards | PDF</title>
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
    padding: 2px;
    font-family: 'kalpurush', sans-serif;
    font-size: 13px;
  }
  .wrapper {
    border: 1px solid #333333;
    border-radius: 5px;
    padding: 5px;
    margin-bottom: 40px;
  }
  </style>
</head>
<body>
  @php
    $counter = 1;
  @endphp
  @foreach($applications as $application)
    <div class="wrapper">
      <table>
        <tr>
          <td width="17%">
            @if($application->school->monogram != null || $application->school->monogram != '')
              <img src="{{ public_path('images/schools/monograms/'.$application->school->monogram) }}" height="120" width="120" style="float: left !important;">
            @else
              
            @endif
          </td>
          <td style="padding: 5px;">
            <p style="text-align: center; font-size: 22px;">
              <center>
                <b>{{ $application->school->name_bangla }}</b><br/>
                <span style="font-size: 15px;">
                  {{ $application->school->address }}, {{ $application->school->upazilla }}, {{ $application->school->district }} <br/>
                  স্থাপিতঃ {{ bangla($application->school->established) }} ইংরেজি | ইআইআইএনঃ {{ bangla($application->school->eiin) }}<br/>
                  <p style="font-size: 20px;">
                    <u><b><span>প্রবেশপত্র</span></b></u>
                  </p>
                  <span style="font-size: 18px;">
                    <u>{{ bangla_class($application->class) }} শ্রেণিতে ভর্তি পরীক্ষা-{{ bangla($application->school->admission_session) }} খ্রিঃ</u>
                  </span>
                </span>
              </center>
            </p>
          </td>
          <td width="17%">
            @if($application->image != null || $application->image != '')
              <img src="{{ public_path('images/admission-images/'.$application->image) }}" height="110" width="110" style="float: right; border: 1px solid #666;">
            @else
              <img src="{{ public_path('images/dummy_student.jpg') }}" height="110" width="110" style="float: right; border: 1px solid #666;">
            @endif
          </td>
        </tr>
      </table>
      <table class="maintable" style="margin-bottom: 5px;">
        <tr>
          <td width="40%">আবেদনকারী শিক্ষার্থীর নামঃ (ইংরেজিতে)</td>
          <td>{{ $application->name }}</td>
        </tr>
        <tr>
          <td>পিতার নামঃ (ইংরেজিতে)</td>
          <td>{{ $application->father }}</td>
        </tr>
        <tr>
          <td>আবেদন আইডিঃ</td>
          <td>{{ $application->application_id }}</td>
        </tr>
        <tr>
          <td>ভর্তি পরীক্ষার রোলঃ</td>
          <td>{{ $application->application_roll }}</td>
        </tr>
      </table>
      <span style="font-size: 13px;">
        <small>
          <i>সাধারণ নির্দেশাবলীঃ<br/>
            {!! $application->school->admit_card_texts !!}
          </i>
        </small>
      </span>
      <table style="margin-top: -10px;">
        <tr>
          <td width="80%"></td>
          <td>
            <center>
              @if($application->school->headmaster_sign != null && $application->school->headmaster_sign != '')
              <img src="{{ public_path('images/schools/signs/'.$application->school->headmaster_sign) }}">
              @endif
              প্রধান শিক্ষক
            </center>
          </td>
        </tr>
      </table>
    </div>
    @if($counter%2 == 0)
      <pagebreak></pagebreak>
    @endif
    @php
      $counter++;
    @endphp
  @endforeach
</body>
</html>