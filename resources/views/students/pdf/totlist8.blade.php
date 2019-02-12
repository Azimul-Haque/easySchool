<html>
<head>
  <title>TOT List | PDF</title>
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
        <td>
          <p style="text-align: center; font-size: 15px;">
            <center>
              <span>{{ bangla($data[0]) }}-ইং সালের জে এস সি পরীক্ষার নিবন্ধনের জন্য সম্ভাব্য শিক্ষার্থীদের তালিকা প্রেরণের ছক</span><br/>
              বিদ্যালয়ের নামঃ {{ Auth::user()->school->name_bangla }}, কোডঃ {{ bangla(Auth::user()->school->school_code) }}, EIIN: {{ Auth::user()->school->eiin }}, ডাকঘরঃ {{ Auth::user()->school->address }}, উপজেলাঃ {{ Auth::user()->school->upazilla }}, জেলাঃ {{ Auth::user()->school->district }}<br/>
              নিজস্ব প্রতিষ্ঠান থেকে ৭ম শ্রেণিতে উত্তীর্ণ  শিক্ষার্থীর সংখ্যাঃ _ _ _ জন, অন্য প্রতিষ্ঠান হতে আগত ৭ম শ্রেণিতে উত্তীর্ণ  শিক্ষার্থীর সংখ্যাঃ _ _ _ জন<br/>
              ছাত্র সংখ্যাঃ {{ bangla(count($students->where("gender", "MALE"))) }} জন, ছাত্রী সংখ্যাঃ {{ bangla(count($students->where("gender", "FEMALE"))) }} জন, মোটঃ {{ bangla($students->count()) }} জন, প্রতিষ্ঠানের সচল মোবাইল নম্বরঃ {{ bangla(Auth::user()->school->contact) }}
            </center>
          </p>
        </td>
      </tr>
    </table>
  </htmlpageheader>
  <htmlpagefooter name="page-footer">
    <table>
      <tr>
        <td width="80%"></td>
        <td width="20%">
          <center>
            @if(file_exists(public_path('images/schools/signs/'.Auth::user()->school->headmaster_sign)))
              <img src="{{ public_path('images/schools/signs/'.Auth::user()->school->headmaster_sign) }}" height="50">
            @endif
          </center>
          প্রধান শিক্ষকের স্বাক্ষর
        </td>
      </tr>
    </table>
  </htmlpagefooter>
  <table class="maintable">
    <tr>
      <th width="3%">ক্র.<br/>নং</th>
      <th>শিক্ষার্থীর নাম</th>
      <th>পিতার নাম</th>
      <th>মাতার নাম</th>
      <th>জন্মতারিখ<br/>(পিইসি সনদ অনুযায়ী)</th>
      <th>শ্রেণি রোল<br/>শাখা</th>
      <th width="15%">পঠিত বিষয়ের কোড</th>
      <th width="10%">৪র্থ বিষয়ের কোড<br/>ধর্ম বিষয়ের কোড</th>
      <th width="10%">স্বাক্ষর</th>
    </tr>
    @php
      $counter = 1;
    @endphp
    @foreach($students as $student)
    <tr>
      <th>{{ $counter }}</th>
      <td>
        @if(strlen($student->name) > 30)
          <span style="font-size: 11px;">{{ $student->name }}</span>
        @else
          {{ $student->name }}
        @endif
      </td>
      <td>{{ $student->father }}</td>
      <td>{{ $student->mother }}</td>
      <td>{{ date('d-m-Y', strtotime($student->dob)) }}</td>
      <td>{{ $student->roll }}<br/>{{ english_section(Auth::user()->school->section_type, $student->class, $student->section) }}</td>
      <td>{{ $student->jsc_subject_codes }}</td>
      <td>{{ $student->jsc_fourth_subject_code }}<br/>--</td>
      <td></td>
    </tr>
    @if($counter%10 == 0)
     </table>
     <pagebreak></pagebreak> 
     <table class="maintable">
        <tr>
          <th width="3%">ক্র.<br/>নং</th>
          <th>শিক্ষার্থীর নাম</th>
          <th>পিতার নাম</th>
          <th>মাতার নাম</th>
          <th>জন্মতারিখ<br/>(পিইসি সনদ অনুযায়ী)</th>
          <th>শ্রেণি রোল<br/>শাখা</th>
          <th width="15%">পঠিত বিষয়ের কোড</th>
          <th width="10%">৪র্থ বিষয়ের কোড<br/>ধর্ম বিষয়ের কোড</th>
          <th width="10%">স্বাক্ষর</th>
        </tr>
    @endif
    @php
      $counter++;
    @endphp
    @endforeach
  </table>

  <htmlpagefooter name="page-footer">
    <small style="font-family: Calibri; color: #6D6E6A;">Powered by EasySchool.XYZ</small>
  </htmlpagefooter>
</body>
</html>