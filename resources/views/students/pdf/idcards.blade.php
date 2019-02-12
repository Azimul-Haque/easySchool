<html>
<head>
  <title>Students ID Cards | PDF</title>
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
    width: 80px !important;
    height: 80px !important;
    margin: auto;
    margin-top: 10px;
  }
  

  .containerTable tr td, .containerTable tr th {
      border: 1px solid lightgreen;
  }

  .dataTable tr td, .dataTable tr th {
      border: 1px solid lightgreen;
  }
  @page {
    header: page-header;
    footer: page-footer;
  }
  </style>
</head>
<body>
  <table class="maintable">
    <tr>
    @php
      $counter = 1;
    @endphp
    @foreach($students as $student)
      <td style="padding: 11px;">
        <table class="containerTable" style="width: 100%; background: lightgreen; border: 2px solid #696969; width: 200px; height: 310px;">
          <tr>
            <td>
              <table style="background: #FAFA6C;">
                <tr>
                  <td>
                    <span style="font-size: 15px; padding: 5px; margin-top: 10px; font-family: times"><center><b><!-- <img src="logo.jpg" style="max-height: 40px;"> --> {{ Auth::user()->school->name }}</b></center></span>
                    <span style="font-size: 8px; font-family: times; padding: 2px; margin-top: 1px;">
                      <center>
                        <b>{{ Auth::user()->school->upazilla }}, {{ Auth::user()->school->district }}</b>
                      </center>
                    </span><br/>
                    <table style="width: 75%; border-collapse: collapse; border-radius: 1em; overflow: hidden; margin-bottom: 15px;">
                      <tr>
                        <td style="display: inline-block; font-size: 14px; background: grey; color:white; border-radius: 5px; font-family: Helvetica; margin: auto; padding: 3px; margin-top: 1px;">
                          <center><b>STUDENT ID CARD</b></center>
                        </td>
                      </tr>
                    </table>

                    <div class="thumb1">
                      @if($student->image == '')
                          <img src="{{ public_path('images/dummy_student.jpg') }}" style="height:80px; border: 1px solid green;" alt="N/A">
                      @else
                        @if(file_exists(public_path('images/admission-images/'.$student->image))) 
                          <img src="{{ public_path('images/admission-images/'.$student->image) }}" style="height:80px; border: 1px solid green;" alt="N/A">
                        @else
                          <img src="{{ public_path('images/dummy_student.jpg') }}" style="height:80px; border: 1px solid green;" alt="N/A">
                        @endif
                      @endif
                    </div><br/>

                    <center>
                      @if(strlen($student->name) > 25)
                        <div style="font-size: 10px; font-weight: bold; color: navy; background: #FAFA6C; margin-bottom: 5px;">
                          {{ $student->name }}
                        </div>
                      @else
                        <div style="font-size: 13px; font-weight: bold; color: navy; background: #FAFA6C; margin-bottom: 5px;">
                          {{ $student->name }}
                        </div>
                      @endif
                      <hr/>
                    </center>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table border="0" style="width: 100%; margin-top: 10px;" class="dataTable">
                <tr>
                  <td width="25%" style="width: 25%;"><span style="color: lightgreen;">...</span>Father</td>
                  <td style="">: {{ ucwords(strtolower($student->father)) }}</td>
                </tr>
                <tr>
                  <td style="width: 25%;"><span style="color: lightgreen;">...</span>Mother</td>
                  <td style="">: {{ ucwords(strtolower($student->mother)) }}</td>
                </tr>
                <tr>
                  <td style="width: 25%;"><span style="color: lightgreen;">...</span>Village</td>
                  <td style="">: {{ ucwords(strtolower($student->village)) }}</td>
                </tr>
                <tr>
                  <td style="width: 25%;"><span style="color: lightgreen;">...</span>DoB</td>
                  <td>: {{ date('d-m-Y', strtotime($student->dob)) }}</td>
                </tr>
                <tr>
                  <td style="width: 25%;"><span style="color: lightgreen;">...</span>Contact</td>
                  <td>: {{ $student->contact }}</td>
                </tr>
                <tr>
                  <td style="width: 25%;"><span style="color: lightgreen;">...</span>St. ID</td>
                  <td>: <span style="font-size: 13px; font-weight: bold; color: navy;">{{ $student->student_id }}</span></td>
                </tr>
              </table>
              <br/>
            </td>
          </tr>
        </table>
      </td>
    @if($counter%3 == 0)
      </tr> <tr>
    @endif
    @if($counter%9 == 0)
     </tr>
    </table>
     <pagebreak></pagebreak>
    <table class="maintable">
      <tr>
    @endif
    @php
      $counter++;
    @endphp
    @endforeach
    </tr>
  </table>

  <htmlpagefooter name="page-footer">
    <small style="font-family: Calibri; color: #6D6E6A;">Powered by EasySchool.XYZ</small>
  </htmlpagefooter>
</body>
</html>