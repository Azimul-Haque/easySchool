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

  table, td, th {
      border: 1px solid black;
  }
  th, td{
    padding: 5px;
    font-family: 'kalpurush', sans-serif;
    font-size: 12px;
  }
  </style>
</head>
<body>
  <h2 align="center"><b>{{ Auth::user()->school->name }}</b></h2>
  <h4 align="center">Established: {{ Auth::user()->school->established }} | EIIN: {{ Auth::user()->school->eiin }}<br/>
  ভর্তি শিক্ষাবর্ষঃ {{ Auth::user()->school->admission_session }}</h4>
  <h2 align="center"><u><b>আবেদনকারীদের তালিকা</b></u></h2>
  <table>
    <tr>
      <th>শ্রেণি</th>
      <th>শাখা</th>
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
      <td>{{ $application->class }}</td>
      <td>{{ $application->section }}</td>
      <td>{{ $application->application_id }}</td>
      <td>{{ $application->application_roll }}</td>
      <td>{{ $application->name_bangla }}</td>
      <td>{{ $application->name }}</td>
      <td>{{ $application->father }}</td>
      <td>{{ $application->mother }}</td>
      <td>{{ $application->mark_obtained }}</td>
      <td>{{ $application->merit_position }}</td>
    </tr>
    @endforeach
  </table>
</body>
</html>