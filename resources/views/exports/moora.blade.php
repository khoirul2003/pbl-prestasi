<h3>Step 1: Decision Matrix</h3>
<table border="1">
    <thead>
        <tr>
            <th>Name</th>
            @foreach(array_keys($decisionMatrix[0]) as $key)
                @if($key !== 'student' && $key !== 'Name')
                    <th>{{ $key }}</th>
                @endif
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($decisionMatrix as $row)
            <tr>
                <td>{{ $row['Name'] }}</td>
                @foreach($row as $key => $value)
                    @if($key !== 'student' && $key !== 'Name')
                        <td>{{ $value }}</td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

<h3>Step 2: Normalized Matrix</h3>
<table border="1">
    <thead>
        <tr>
            <th>Name</th>
            @foreach(array_keys($normalizedMatrix[0]['normalized']) as $key)
                <th>{{ $key }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($normalizedMatrix as $row)
            <tr>
                <td>{{ $row['raw_data']['Name'] }}</td>
                @foreach($row['normalized'] as $val)
                    <td>{{ round($val, 4) }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

<h3>Step 3: Final Scores</h3>
<table border="1">
    <thead>
        <tr>
            <th>Rank</th>
            <th>Name</th>
            <th>Score</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $index => $result)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $result['raw_data']['Name'] }}</td>
                <td>{{ $result['score'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
