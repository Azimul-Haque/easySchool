<html>
<head>
  <title>{{ $application->application_id }} | Admit Card | PDF</title>
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
    font-size: 14px;
  }
  </style>
</head>
<body>
  <h2 align="center"><b>{{ $application->school->name }}</b></h2>
  <h4 align="center">Established: {{ $application->school->established }} | EIIN: {{ $application->school->eiin }}<br/>
  Admission {{ $application->school->currentsession }}</h4>
  <h2 align="center"><u><b>Admit Card</b></u></h2>
  <table>
    <tr>
      <th>Applicant Name: (English)</th>
      <td>{{ $application->name }}</td>
    </tr>
    <tr>
      <th>Applicant Name: (Bangla)</th>
      <td>{{ $application->name_bangla }}</td>
    </tr>
    <tr>
      <th>Father's Name:</th>
      <td>{{ $application->father }}</td>
    </tr>
    <tr>
      <th>Mother's Name:</th>
      <td>{{ $application->mother }}</td>
    </tr>
    <tr>
      <th>Application Id:</th>
      <td><big>{{ $application->application_id }}</big></td>
    </tr>
    <tr>
      <th>Photo:</th>
      <td>
        <img src="{{ public_path('images/admission-images/'.$application->image) }}" style="height: 200px; width: auto;">
      </td>
    </tr>
  </table>
</body>
</html>