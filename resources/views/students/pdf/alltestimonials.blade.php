<html>
<head>
  <title>@if($data[1] == 9) JSC @elseif($data[1] == 10) SSC @endif Testimonials | PDF</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="icon" sizes="192x192" href="{{ asset('images/pdf-icon.png') }}">
  <style>
  body {
    font-family: 'roboto', sans-serif;
  }
  table {
      border-collapse: collapse;
      width: 100%;
      height: 100%;
      margin:0;
      padding:0;
  }

  table tr td, table tr th {
    border: 0px solid black;
  }
  table tr th, table tr td{
    padding: 4px;
    font-family: 'roboto', sans-serif;
    font-size: 16px !important;
  }
  .page-border{
       width: 100%;
       height: 100%;
       border:2px solid #555;
       border-radius: 10px;
       padding: 10px
   }
  </style>
</head>
<body>
  @foreach($students as $student)
  <div class="page-border">
    <table class="">
      <tr>
        <td width="5%"></td>
        <td width="90%" align="center">
          <span style="font-size: 30px;"><b>{{ Auth::user()->school->name }}</b></span><br/>
          P.O: {{ Auth::user()->school->address }}, Upazilla: {{ Auth::user()->school->upazilla }}, District: {{ Auth::user()->school->district }}, Estd: {{ Auth::user()->school->established }}, School Code: {{ Auth::user()->school->school_code }}<br/>
            EIIN: {{ Auth::user()->school->eiin }}, Email: {{ Auth::user()->school->contact }}, Phone: {{ Auth::user()->school->contact }}
          <br/>
          @if(Auth::user()->school->monogram != null && Auth::user()->school->monogram != '')
          <img src="{{ public_path('images/schools/monograms/'.Auth::user()->school->monogram) }}" width="80" height="80" style="padding: 5px;">
          @endif
        </td>
        <td width="5%"></td>
      </tr>
    </table>
    <table class="">
      <tr>
        <td width="20%"></td>
        <td width="60%" align="center">
          <span style="font-size: 25px;"><u>TESTIMONIAL</u></span><br/>
          <span style="font-size: 20px;">
            @if($data[1] == 9)
            JSC EXAMINATION-{{ $student->jsc_session }}
            @elseif($data[1] == 10)
            SSC EXAMINATION-{{ substr($student->ssc_session, 0, 4) + 2 }}
            @endif
          </span>
        </td>
        <td width="20%" align="center">Sl No - {{ $student->student_id }}</td>
      </tr>
      <tr>
        <td colspan="3" style="display: block; line-height: 1.7;">
          <center><br/>
            This is to certify that<br/>
            <big><u>{{ $student->name }}</u></big>
          </center>
        </td>
      </tr>
      <tr>
        <td colspan="3" style="text-align: justify; text-justify: inter-character;display: block; line-height: 1.7;">
          &ensp;&ensp;&ensp;&ensp;Son/Daughter of <u>{{ $student->father }}</u> &amp;  Mother’s name   <u>{{ $student->mother }}</u>,  Vill- <u>{{ $student->village }}</u>, P.O- <u>{{ $student->post_office }}</u>,  Up-zilla- <u>{{ $student->upazilla }}</u>, Zilla- <u>{{ $student->district }}</u>. He/She has passed the 
          @if($data[1] == 9)
            JSC EXAMINATION-{{ $student->jsc_session }}, Roll Number <u>{{ $student->jsc_roll }}</u>, Registration Number <u>{{ $student->jsc_registration_no }}</u>  &amp; Session <u>{{ $student->session }}</u>  from this school under the Board of Intermediate and Secondary Education, Dinajpur. He/She was securing G.P.A  <u>{{ $student->jsc_gpa }}</u>, in the scale of 5.00, as a regular student of this school.
          @elseif($data[1] == 10)
            SSC EXAMINATION-{{ substr($student->ssc_session, 0, 4) + 2 }}, in <u>{{ english_section(Auth::user()->school->section_type, $data[1], $data[2]) }}</u> Group, Roll Number <u>{{ $student->ssc_roll }}</u>, Registration Number <u>{{ $student->ssc_registration_no }}</u>  &amp; Session <u>{{ $student->session }}</u>  from this school under the Board of Intermediate and Secondary Education, Dinajpur. He/She was securing G.P.A  <u>{{ $student->ssc_gpa }}</u>, in the scale of 5.00, as a regular student of this school.
          @endif His/Her date of birth is <u>{{ date('d-m-Y', strtotime($student->dob)) }}</u>.<br/>

          &ensp;&ensp;&ensp;&ensp;I know that he/she did not take part in any subversive activities of the state while studying in this institution.<br/>
          &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;I wish his/her every success in life.
          <br/><br/><br/><br/><br/>
        </td>
      </tr>
      <tr>
        <td align="left" valign="bottom">
          Compared &amp; Checked by<br/>
          Dated-
        </td>
        <td></td>
        <td align="right">
          ({{ Auth::user()->name }})<br/>
          Head Teacher
        </td>
      </tr>
    </table>
  </div>
  <pagebreak></pagebreak>
  @endforeach
</body>
</html>