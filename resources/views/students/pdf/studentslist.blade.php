<html>
<head>
  <title>Students List | PDF</title>
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
    padding: 2px;
    font-family: 'kalpurush', sans-serif;
    font-size: 12px;
  }
  .nostyletd {
    border: 0px solid white !important;
  }
  @page {
    header: page-header;
    footer: page-footer;
  }
  </style>
</head>
<body>
  <htmlpageheader name="page-header">
    <table>
      <tr>
        <td width="10%">
          @if(Auth::user()->school->monogram != null || Auth::user()->school->monogram != '')
            <img src="{{ public_path('images/schools/monograms/'.Auth::user()->school->monogram) }}" height="50" width="50" style="float: left !important; margin-top: -25px;">
          @else
            
          @endif
        </td>
        <td>
          <p style="text-align: center; font-size: 22px;">
            <center>
              {{ Auth::user()->school->name_bangla }} | শিক্ষার্থী তালিকা-{{ bangla($data[0]) }}<br/>
              <span style="font-size: 15px;">
                ইআইআইএনঃ {{ bangla(Auth::user()->school->eiin) }}, ডাকঘরঃ {{ Auth::user()->school->address }}, উপজেলাঃ {{ Auth::user()->school->upazilla }}, জেলাঃ {{ Auth::user()->school->district }}
              </span>
            </center>
          </p>
        </td>
        <td width="10%"></td>
      </tr>
    </table>
    <table class="">
      <tr>
        <td>শ্রেণিঃ {{ bangla_class($data[1]) }},</td>
        <td>শাখাঃ {{ bangla_section(Auth::user()->school->section_type, $data[1], $data[2]) }},</td>
        <td>ছাত্র সংখ্যাঃ {{ bangla(count($students->where("gender", "MALE"))) }} জন,</td>
        <td>ছাত্রী সংখ্যাঃ {{ bangla(count($students->where("gender", "FEMALE"))) }} জন,</td>
        <td>মোটঃ {{ bangla($students->count()) }} জন,</td>
        <td>ইসলামঃ {{ bangla(count($students->where("religion", "ISLAM"))) }} জন,</td>
        <td>হিন্দু {{ bangla(count($students->where("religion", "HINDU"))) }} জন,</td>
        <td>উচ্চতরঃ -{{ bangla(count($students->where("religion", "HINDU"))) }} জন,</td>
        <td>কৃষিঃ - জন</td>
      </tr>
    </table>
  </htmlpageheader>
  <table class="maintable">
    <tr>
      <th>ক্র.<br/>নং</th>
      <th>আইডি<br/>শাখা<br/>রোল</th>
      <th>ছবি</th>
      <th>শিক্ষার্থীর নাম<br/>পিতার নাম<br/>মাতার নাম</th>
      <th>গ্রাম<br/>ডাকঘর<br/>উপজেলা</th>
      <th>জন্মতারিখ<br/>মোবাইল নং ১<br/>মোবাইল নং ২</th>
      <th>৪র্থ বিষয়<br/>ধর্ম</th>
      <th>পিতার পেশা</th>
      <th>সুবিধাভোগী</th>
      <th>প্রঃ শিঃ<br/>মন্তব্য</th>
    </tr>
    @php
      $counter = 1;
    @endphp
    @foreach($students as $student)
    <tr>
      <td>{{ $counter }}</td>
      <td>{{ $student->student_id }}<br/>{{ english_section(Auth::user()->school->section_type, $student->class, $student->section) }}<br/>{{ $student->roll }}</td>
      <td>
        @if($student->image != null && $student->image != '')
        <img src="{{ public_path('images/admission-images/'.$student->image) }}" height="40" width="40">
        @else
        <img src="{{ public_path('images/dummy_student.jpg') }}" height="40" width="40">
        @endif
      </td>
      <td>{{ $student->name }}<br/>{{ $student->father }}<br/>{{ $student->mother }}</td>
      <td>{{ $student->village }}<br/>{{ $student->post_office }}<br/>{{ $student->upazilla }}</td>
      <td>{{ date('d-m-Y', strtotime($student->dob)) }}<br/>{{ $student->contact }}<br/>{{ $student->contact_2 }}</td>
      <td>
        @if($student->class == 8)
          {{ $student->jsc_fourth_subject_code }}<br/>
        @elseif($student->class > 8)
          {{ $student->ssc_fourth_subject_code }}<br/>
        @else
          N/A<br/>
        @endif
        {{ $student->religion }}
      </td>
      <td>{{ $student->fathers_occupation }}</td>
      <td>
        @if($student->facility == 0)
        প্রযোজ্য নয়
        @elseif($student->facility == 1)
        উপবৃত্তি (UPOBRITTI)
        @elseif($student->facility == 2)
        হাফ-ফ্রি (HALF-FREE)
        @elseif($student->facility == 3)
        ফুল-ফ্রি (FULL-FREE)
        @endif
      </td>
      <td width="10%"></td>
    </tr>
    @if($counter%10 == 0)
     </table>
     <pagebreak></pagebreak> 
     <table class="maintable">
         <tr>
           <th>ক্র.<br/>নং</th>
           <th>আইডি<br/>শাখা<br/>রোল</th>
           <th>ছবি</th>
           <th>শিক্ষার্থীর নাম<br/>পিতার নাম<br/>মাতার নাম</th>
           <th>গ্রাম<br/>ডাকঘর<br/>উপজেলা</th>
           <th>জন্মতারিখ<br/>মোবাইল নং ১<br/>মোবাইল নং ২</th>
           <th>৪র্থ বিষয়<br/>ধর্ম</th>
           <th>পিতার পেশা</th>
           <th>সুবিধাভোগী</th>
           <th>প্রঃ শিঃ<br/>মন্তব্য</th>
         </tr>
    @endif
    @php
      $counter++;
    @endphp
    @endforeach
  </table>
</body>
</html>