<html>
<head>
  <title>Attenfance Sheet | PDF</title>
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
    padding: 1px;
    font-family: 'kalpurush', sans-serif;
    font-size: 11px;
  }
  </style>
</head>
<body>
  <table class="">
    <tr>
      <td width="18%">
        @if(Auth::user()->school->monogram != null || Auth::user()->school->monogram != '')
          <img src="{{ public_path('images/schools/monograms/'.Auth::user()->school->monogram) }}" height="50" width="50" style="float: left !important;">
        @else
          
        @endif
      </td>
      <td>
        <p style="text-align: center; font-size: 22px;">
          <center>
            <b>{{ Auth::user()->school->name_bangla }}</b><br/>
            <span style="font-size: 15px;">
              {{ Auth::user()->school->address }}, {{ Auth::user()->school->upazilla }}, {{ Auth::user()->school->district }} <br/>
              স্থাপিতঃ {{ bangla(Auth::user()->school->established) }} ইংরেজি | ইআইআইএনঃ {{ bangla(Auth::user()->school->eiin) }}
            </span>
          </center>
        </p>
      </td>
      <td width="18%"></td>
    </tr>
    <tr>
      <td colspan="3">
        <center>
          <span style="font-size: 17px;">
            উপস্থিতি তালিকা/ হাজিরা খাতা
          </span>
        </center>
      </td>
    </tr>
    <tr>
      <td>
        শ্রেণিঃ {{ bangla_class($data[1]) }}
      </td>
      <td>
        শাখাঃ {{ bangla_section(Auth::user()->school->section_type, $data[1], $data[2]) }}
      </td>
      <td>
        মোট শিক্ষার্থীঃ {{ bangla($students->count()) }}
      </td>
    </tr>
    <tr>
      <td>
        মাসঃ
      </td>
      <td>
        ................
      </td>
      <td>
        সালঃ ................
      </td>
    </tr>
  </table>
  <table class="maintable">
    <tr>
      <th>শিক্ষার্থীর নাম</th>
      <th>রোল</th>
      @for($counter = 1; $counter <= 31; $counter++)
      <th>{{ bangla(str_pad($counter, 2, '0', STR_PAD_LEFT)) }}</th>
      @endfor
      <th>মোট উপ<br/>স্থিতি</th>
    </tr>
    @foreach($students as $student)
    <tr>
      <td>{{ $student->name }}</td>
      <th>{{ $student->roll }}</th>
      @for($counter = 1; $counter <= 31; $counter++)
      <td></td>
      @endfor
      <td></td>
    </tr>
    @endforeach
  </table>
</body>
</html>