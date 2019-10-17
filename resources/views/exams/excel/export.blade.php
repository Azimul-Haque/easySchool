<input type="text" id="filename" value="A" placeholder="Write file name">
<button>Export to CSV file</button>
<table border="1">
    {{-- <thead>
    <tr>
        <th>Mobile</th>
        <th>Message</th>
    </tr>
    </thead> --}}
    <tbody>
    @php
      $counter = 1;
    @endphp
    @foreach($results as $result)
        <tr>
            <td>{{ $result['mobile'] }}</td>
            <td>
                Jamalpur H School:{{ exam_en($result['exam']) }} Result.{{ $result['name'] }}.Merit:
                @if($result['grade'] == 'F')
                N/A
                @else
                {{ $counter }}
                @endif
                ,GPA:{{ $result['gpa'] }},Details:
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
    @php
      $counter++;
    @endphp
    @endforeach
    </tbody>
</table>

<script type="text/javascript">
    function download_csv(csv, filename) {
        var csvFile;
        var downloadLink;

        // CSV FILE
        csvFile = new Blob([csv], {type: "text/csv"});

        // Download link
        downloadLink = document.createElement("a");

        // File name
        downloadLink.download = filename;

        // We have to create a link to the file
        downloadLink.href = window.URL.createObjectURL(csvFile);

        // Make sure that the link is not displayed
        downloadLink.style.display = "none";

        // Add the link to your DOM
        document.body.appendChild(downloadLink);

        // Lanzamos
        downloadLink.click();
    }

    function export_table_to_csv(html, filename) {
        var csv = [];
        var rows = document.querySelectorAll("table tr");
        
        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td, th");
            
            for (var j = 0; j < cols.length; j++) 
                row.push(cols[j].innerText);
            
            csv.push(row.join(","));        
        }

        // Download CSV
        download_csv(csv.join("\n"), filename);
    }

    document.querySelector("button").addEventListener("click", function () {
        var html = document.querySelector("table").outerHTML;
        var filename = document.getElementById("filename").value;
        if(filename == '') {
            filename = 'file';
        }
        export_table_to_csv(html, filename+".csv");
    });

</script>