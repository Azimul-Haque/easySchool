<html>
<head>
  <title>Tabulation Sheet | PDF</title>
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
    font-size: 14px;
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
              {{ Auth::user()->school->name_bangla }} | {{ exam($data[0]->name) }} পরীক্ষা {{ bangla($data[0]->exam_session) }} | ট্যাবুলেশন শিট<br/>
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
        <th width="16.66%">শ্রেণিঃ {{ bangla_class($data[1]) }}</th>
        <th width="16.66%">শাখাঃ {{ bangla_section(Auth::user()->school->section_type, $data[1], $data[2]) }}</th>
        <th width="16.66%">মোট পরীক্ষার্থীঃ {{ bangla(count($results)) }} জন</th>
        <th width="16.66%">অংশগ্রহণকারীঃ  {{ bangla(count($results) - count($results->where('total_marks', 0))) }} জন</th>
        <th width="16.66%">উত্তীর্ণঃ {{ bangla(count($results) - count($results->where('grade', 'F'))) }} জন</th>
        <th width="16.66%">অকৃতকার্যঃ {{ bangla((count($results) - count($results->where('total_marks', 0))) - (count($results) - count($results->where('grade', 'F')))) }} জন</th> 
      </tr>
    </table>
  </htmlpageheader>
  <table class="maintable">
    <tr>
      @php
        $ban_en_array = [1, 2, 3, 4];
        $ban_en_single_array = [1, 3];
        $ban_en_single_array_for_gr = [2, 4];
        $rowspan_general = 2;
        foreach($data[3] as $subject) {
          if(in_array($subject->subject_id, $ban_en_array)) {
            $rowspan_general = 3;
          }
        }
      @endphp
      <th rowspan="{{ $rowspan_general }}">রোল<br/>নং</th>
      <th rowspan="{{ $rowspan_general }}">শিক্ষার্থীর নাম</th>
      @foreach($data[3] as $subject)
        @if(in_array($subject->subject_id, $ban_en_array))
          @if(in_array($subject->subject_id, $ban_en_single_array))
            <th colspan="7">{{ strtok($subject->subject->name_bangla, ' ') }}</th>
          @endif
        @else
          @if($rowspan_general > 2)
            <th rowspan="2" colspan="5">{{ $subject->subject->name_bangla }}</th>
          @else
            <th colspan="5">{{ $subject->subject->name_bangla }}</th>
          @endif
        @endif
      @endforeach
       <th rowspan="{{ $rowspan_general }}">মোট</th>
       <th rowspan="{{ $rowspan_general }}">জিপিএ</th>
       <th rowspan="{{ $rowspan_general }}">গ্রেড</th>
    </tr>
    @if($rowspan_general > 2)
    <tr>
      @foreach($data[3] as $subject)
        @if(in_array($subject->subject_id, $ban_en_array))
          <th colspan="3">{{ $subject->subject->name_bangla }}</th>
          @if(in_array($subject->subject_id, $ban_en_single_array_for_gr))
          <th rowspan="2">GR</th>
          @endif
        @else
          
        @endif
      @endforeach
    </tr>
    @endif
    <tr>
      @foreach($data[3] as $subject)
        @if(in_array($subject->subject_id, $ban_en_array))
          <th>WR</th>
          <th>MCQ</th>
          <th>CA</th>
        @else
          <th>WR</th>
          <th>MCQ</th>
          <th>PR</th>
          <th>CA</th>
          <th>GR</th>
        @endif
      @endforeach
    </tr>
    @php
      $counter = 1;
      $ban_en_array = [1, 2, 3, 4];
    @endphp
    @foreach($results as $result)
    <tr>
      <td>{{ $result['roll'] }}</td>
      <td>{{ $result['name'] }}</td>
      @foreach($data[3] as $subject)
        @if(in_array($subject->subject_id, $ban_en_array))
          @foreach($result['subjects_marks'] as $subject_marks)
            @if($subject->subject_id == $subject_marks['subject_id'])
              <td>{{ $subject_marks['written'] }}</td>
              <td>{{ $subject_marks['mcq'] }}</td>
              <td>{{ $subject_marks['ca'] }}</td>
            @endif
          @endforeach
          @if(in_array($subject->subject_id, $ban_en_single_array_for_gr))
            @foreach($result['subjects_marks'] as $subject_marks)
              @if($subject->subject_id == $subject_marks['subject_id'])
                <td>{{ $subject_marks['grade'] }}</td>
              @endif
            @endforeach
          @endif
        @else
          @foreach($result['subjects_marks'] as $subject_marks)
            @if($subject->subject_id == $subject_marks['subject_id'])
              <td>{{ $subject_marks['written'] }}</td>
              <td>{{ $subject_marks['mcq'] }}</td>
              <td>{{ $subject_marks['practical'] }}</td>
              <td>{{ $subject_marks['ca'] }}</td>
              <td>{{ $subject_marks['grade'] }}</td>
            @endif
          @endforeach
        @endif
      @endforeach
      <td>{{ $result['total_marks'] }}</td>
      <td>{{ $result['gpa'] }}</td>
      <td>{{ $result['grade'] }}</td>>
    </tr>
    @if($counter%12 == 0)
     </table>
     <pagebreak></pagebreak> 
     <table class="maintable">
       <tr>
         @php
           $ban_en_array = [1, 2, 3, 4];
           $ban_en_single_array = [1, 3];
           $ban_en_single_array_for_gr = [2, 4];
           $rowspan_general = 2;
           foreach($data[3] as $subject) {
             if(in_array($subject->subject_id, $ban_en_array)) {
               $rowspan_general = 3;
             }
           }
         @endphp
         <th rowspan="{{ $rowspan_general }}">রোল<br/>নং</th>
         <th rowspan="{{ $rowspan_general }}">শিক্ষার্থীর নাম</th>
         @foreach($data[3] as $subject)
           @if(in_array($subject->subject_id, $ban_en_array))
             @if(in_array($subject->subject_id, $ban_en_single_array))
               <th colspan="7">{{ strtok($subject->subject->name_bangla, ' ') }}</th>
             @endif
           @else
             @if($rowspan_general > 2)
               <th rowspan="2" colspan="5">{{ $subject->subject->name_bangla }}</th>
             @else
               <th colspan="5">{{ $subject->subject->name_bangla }}</th>
             @endif
           @endif
         @endforeach
          <th rowspan="{{ $rowspan_general }}">মোট</th>
          <th rowspan="{{ $rowspan_general }}">জিপিএ</th>
          <th rowspan="{{ $rowspan_general }}">গ্রেড</th>
       </tr>
       @if($rowspan_general > 2)
       <tr>
         @foreach($data[3] as $subject)
           @if(in_array($subject->subject_id, $ban_en_array))
             <th colspan="3">{{ $subject->subject->name_bangla }}</th>
             @if(in_array($subject->subject_id, $ban_en_single_array_for_gr))
             <th rowspan="2">GR</th>
             @endif
           @else
             
           @endif
         @endforeach
       </tr>
       @endif
       <tr>
         @foreach($data[3] as $subject)
           @if(in_array($subject->subject_id, $ban_en_array))
             <th>WR</th>
             <th>MCQ</th>
             <th>CA</th>
           @else
             <th>WR</th>
             <th>MCQ</th>
             <th>PR</th>
             <th>CA</th>
             <th>GR</th>
           @endif
         @endforeach
       </tr>
    @endif
    @php
      $counter++;
    @endphp
    @endforeach
  </table>

  <htmlpagefooter name="page-footer">
    <table>
      <tr>
        <td>Signature (Head Master) </td>
        <td>Signature (Scrutineer)</td>
        <td align="center"><b>{PAGENO} / {nbpg}</b></td>
      </tr>
    </table>
  </htmlpagefooter>
</body>
</html>