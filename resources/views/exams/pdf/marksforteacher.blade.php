<html>
<head>
  <title>Marks List | PDF</title>
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
  </style>
</head>
<body>
  <table>
    <tr>
      <td width="18%">
      </td>
      <td>
        <p style="text-align: center; font-size: 22px;">
          <center>
            <b>{{ Auth::user()->school->name_bangla }}</b><br/>
            <span style="font-size: 15px;">
              স্থাপিতঃ {{ bangla(Auth::user()->school->established) }} ইংরেজি | ইআইআইএনঃ {{ bangla(Auth::user()->school->eiin) }}<br/><br/>
              <span style="font-size: 18px;">
                <b><u>শ্রেণিঃ {{ bangla_class($data[0]) }}, শাখাঃ {{ bangla_section(Auth::user()->school->section_type, $data[0], $data[1]) }}, পরীক্ষাঃ {{ exam($data[4]) }}, শিক্ষাবর্ষঃ {{ bangla($data[5]) }}</u></b>
              </span><br/>
            </span><br/><br/>
          </center>
        </p>
      </td>
      <td width="18%"></td>
    </tr>
  </table>
  <table class="maintable">
    <tr>
      <th width="25%">মোট পরীক্ষার্থীঃ {{ bangla(count($marks)) }} জন</th>
      <th width="25%">অংশগ্রহণকারীঃ {{ bangla($data[2]) }} জন</th>
      <th width="25%">উত্তীর্ণঃ {{ bangla($data[3]) }} জন</th>
      <th width="25%">অকৃতকার্যঃ {{ bangla(count($marks->where('grade', 'F'))) }} জন</th>
    </tr>
  </table><br/>
  <table class="maintable">
    <tr>
      <th width="5%">রোল</th>
      <th>নাম</th>
      <th width="12%">আইডি</th>
      <th width="7%">লিখিত</th>
      <th width="8%">নৈর্ব্যক্তিক</th>
      <th width="8%">ব্যবহারিক</th>
      <th width="7%">CA/ SBA</th>
      <th width="5%">মোট</th>
      <th width="7%">গ্রেড পয়েন্ট</th>
      <th width="6%">গ্রেড</th>
    </tr>

    @foreach($marks as $mark)
    <tr>
      <td>{{ $mark->roll }}</td>
      <td>
        @php
          if(strlen($mark->student->name) > 30) {
            $name_pieces = explode(" ", $mark->student->name);
            echo $name_pieces[0].' ';
            echo $name_pieces[1].'...';
          } else {
            echo $mark->student->name;
          }
        @endphp
      </td>
      <td>{{ $mark->student_id }}</td>
      <td>{{ $mark->written }}</td>
      <td>{{ $mark->mcq }}</td>
      <td>{{ $mark->practical }}</td>
      <td>{{ $mark->ca }}</td>
      <td>{{ $mark->total }}</td>
      <td>{{ $mark->grade_point }}</td>
      <td>{{ $mark->grade }}</td>
    </tr>
    @endforeach
  </table>
</body>
</html>