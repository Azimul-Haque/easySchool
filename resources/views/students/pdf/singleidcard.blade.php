<html>
<head>
  <title>Students ID Card | PDF</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="icon" sizes="192x192" href="{{ asset('images/pdf-icon.png') }}">
  <style>
  body {
    font-family: 'Helvetica', sans-serif;
  }
  table {
      border-collapse: collapse;
      width: 100%;
  }

  .maintable tr td, .maintable tr th {
      border: 1px solid white;
  }
  .maintable tr th, .maintable tr td{
    padding: 2px;
    font-family: 'Helvetica', sans-serif;
    font-size: 12px;
  }
  .nostyletd {
    border: 0px solid white !important;
  }
  .thumb1 { 
    width: 100%;
    height: 95px !important;
    margin: 5px;
    margin-top: 10px;
    float: left;

    background: red;
  }
  .thumb2 { 
    width: 60px;
    height: 60px !important;
    /*margin: 5px;*/
    float: left;
  }
  

  .containerTable tr td, .containerTable tr th {
      border: 1px solid lightgreen;
  }

  .dataTable tr td, .dataTable tr th {
      border: 1px solid lightgreen;
  }
  .data_td_parents_left {
    padding-left: 5px;
    font-size: 12.5px;
  }
  .data_td_parents_right {
    font-size: 12.5px;
  }
  @page {
    header: page-header;
    footer: page-footer;
  }
  </style>
</head>
<body>
  <div style="height: 290px; width: 200px; background: #183172; border: 1px solid #183172; float: left; margin-bottom: 15px;">
    <div style="height: 290px; width: 200px; background: #fff; border-radius: 50px 0px 50px 0px; padding: 10px 5px 10px 5px;">
      <center><p style="font-size: 15px; margin-top: 10px; text-align: center; margin: auto;"><b>{{ Auth::user()->school->name }}</b></p></center>
      <p style="font-size: 9px; font-family: times; padding: 0px; margin-top: 1px; text-align: center;">
        <b>{{ Auth::user()->school->upazilla }}, {{ Auth::user()->school->district }}</b>
      </p>
      <table>
        <tr>
          <td width="60%" style="padding: 5px;">
            @if($student->image == '')
                <img src="{{ public_path('images/dummy_student.jpg') }}" style="height:95px; border: 2px solid #000;" alt="N/A">
            @else
              @if(file_exists(public_path('images/admission-images/'.$student->image))) 
                <img src="{{ public_path('images/admission-images/'.$student->image) }}" style="height:95px; border: 2px solid #000;" alt="N/A">
              @else
                <img src="{{ public_path('images/dummy_student.jpg') }}" style="height:95px; border: 2px solid #000;" alt="N/A">
              @endif
            @endif
          </td>
          <td style="padding: 5px;">
            @if(Auth::user()->school->monogram == '')
                {{-- <img src="{{ public_path('images/dummy_student.jpg') }}" style="height:60px;" alt="N/A"> --}}
            @else
              @if(file_exists(public_path('images/schools/monograms/'.Auth::user()->school->monogram))) 
                <img src="{{ public_path('images/schools/monograms/'.Auth::user()->school->monogram) }}" style="height:60px;" alt="N/A">
              @else
                {{-- <img src="{{ public_path('images/dummy_student.jpg') }}" style="height:60px;" alt="N/A"> --}}
              @endif
            @endif
          </td>
        </tr>
      </table>

      <p style="font-size: 11.5px; font-weight: bold; color: navy; margin: 5px; border-bottom: 1px solid navy; text-align: center;">
        {{ $student->name }}
      </p>

      <table border="0" >
        <tr>
          <td class="data_td_parents_left">Father</td>
          <td class="data_td_parents_right">: {{ ucwords(strtolower($student->father)) }}</td>
        </tr>
        <tr>
          <td class="data_td_parents_left">Mother</td>
          <td class="data_td_parents_right">: {{ ucwords(strtolower($student->mother)) }}</td>
        </tr>
        <tr>
          <td class="data_td_parents_left">Village</td>
          <td class="data_td_parents_right">: {{ ucwords(strtolower($student->village)) }}</td>
        </tr>
        <tr>
          <td class="data_td_parents_left">DoB</td>
          <td class="data_td_parents_right">: {{ date('d-m-Y', strtotime($student->dob)) }}</td>
        </tr>
        <tr>
          <td class="data_td_parents_left">Contact</td>
          <td class="data_td_parents_right">: {{ $student->contact }}</td>
        </tr>
        <tr>
          <td class="data_td_parents_left">St. ID</td>
          <td class="data_td_parents_right">: <span style="font-size: 14px; font-weight: bold; color: navy;">{{ $student->student_id }}</span></td>
        </tr>
      </table>
      
    </div>
  </div>
  <div style="height: 290px; width: 10px; float: left; padding: 0px;"></div>
  
  

  <htmlpagefooter name="page-footer">
    <small style="font-family: Calibri; color: #6D6E6A;">Powered by EasySchool.XYZ</small>
  </htmlpagefooter>
</body>
</html>