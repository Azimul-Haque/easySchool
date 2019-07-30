<table>
    {{-- <thead>
    <tr>
        <th>Mobile</th>
        <th>Message</th>
    </tr>
    </thead> --}}
    <tbody>
    @foreach($results as $result)
        <tr>
            <td>88{{ $result['mobile'] }}</td>
            <td>
                Jamalpur H School:H. Yearly Result. {{ $result['name'] }}. GPA:{{ $result['gpa'] }},Details:
                
                @php
                    $resultdetails = '';
                @endphp
                @foreach($result['subjects_marks'] as $marks) 
                    @php
                        $resultdetails .= $marks['subject_name'] .':'. $marks['grade'] . ',';
                    @endphp
                @endforeach
                {{ rtrim($resultdetails, ',') }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>