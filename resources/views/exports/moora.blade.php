<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan MOORA - PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th, td {
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h2, h3 {
            margin-bottom: 0;
        }
        p {
            margin-top: 2px;
            margin-bottom: 12px;
        }
        .table-container {
            page-break-before: always;
        }
        /* CSS untuk orientasi landscape */
        .landscape {
            page-break-before: always;
            -webkit-transform: rotate(-90deg); /* Safari */
            -moz-transform: rotate(-90deg); /* Firefox */
            -ms-transform: rotate(-90deg); /* IE */
            transform: rotate(-90deg); /* Chrome, Opera, IE 9+ */
            width: 100%;
            height: auto;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <h2>Step-by-Step MOORA Analysis</h2>

    <h3>Step 1: Menentukan Nilai Kriteria dan Bobot</h3>
    <p>Langkah pertama adalah menentukan kriteria yang digunakan beserta bobotnya.</p>
    <table>
        <thead>
            <tr>
                <th>Kriteria</th>
                <th>Bobot</th>
            </tr>
        </thead>
        <tbody>
            @foreach($weights as $key => $weight)
                <tr>
                    <td>{{ $key }}</td>
                    <td>{{ $weight }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Step 2 in Landscape -->
    <div class="landscape">
        <h3>Step 2: Matriks Keputusan</h3>
        <p>Matriks keputusan menunjukkan nilai setiap alternatif (mahasiswa) berdasarkan setiap kriteria.</p>
        <table>
            <thead>
                <tr>
                    <th style="width: 15%;">Nama</th>
                    <th style="width: 10%;">Total Achievements</th>
                    <th style="width: 10%;">Approved Achievements</th>
                    <th style="width: 10%;">Level of Achievements</th>
                    <th style="width: 10%;">Best Ranking</th>
                    <th style="width: 10%;">GPA</th>
                    <th style="width: 10%;">Category Skills</th>
                    <th style="width: 10%;">Total Skills</th>
                    <th style="width: 10%;">Semester</th>
                    <th style="width: 10%;">Pre-University Achievements</th>
                    <th style="width: 10%;">Pre-University Best Rank</th>
                    <th style="width: 10%;">Pre-University Level</th>
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
    </div>

    <!-- Step 3 in Landscape -->
    <div class="landscape">
        <h3>Step 3: Matriks Normalisasi</h3>
        <p>Normalisasi digunakan untuk menyetarakan skala semua kriteria.</p>
        <table>
            <thead>
                <tr>
                    <th style="width: 15%;">Nama</th>
                    @foreach(array_keys($normalizedMatrix[0]['normalized']) as $key)
                        <th style="width: 10%;">{{ $key }}</th>
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
    </div>

    <h3>Step 4: Nilai Optimasi</h3>
    <p>Menghitung total skor dari hasil normalisasi yang dikalikan bobot kriteria.</p>
    <table>
        <thead>
            <tr>
                <th style="width: 70%;">Nama</th>
                <th style="width: 30%;">Skor MOORA</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $result)
                <tr>
                    <td>{{ $result['raw_data']['Name'] }}</td>
                    <td>{{ $result['score'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Step 5: Perangkingan</h3>
    <p>Menentukan urutan berdasarkan skor MOORA tertinggi hingga terendah.</p>
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Peringkat</th>
                <th style="width: 70%;">Nama</th>
                <th style="width: 20%;">Skor</th>
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

</body>
</html>
