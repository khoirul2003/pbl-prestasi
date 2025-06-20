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

    <div class="table-container">
        <h3>Step 2: Matriks Keputusan</h3>
        <p>Matriks keputusan menunjukkan nilai setiap alternatif (mahasiswa) berdasarkan setiap kriteria.</p>
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 10%;">TA</th>
                    <th style="width: 9%;">AA</th>
                    <th style="width: 9%;">LA</th>
                    <th style="width: 9%;">BR</th>
                    <th style="width: 9%;">GPA</th>
                    <th style="width: 9%;">CS</th>
                    <th style="width: 9%;">TS</th>
                    <th style="width: 9%;">S</th>
                    <th style="width: 9%;">P-UA</th>
                    <th style="width: 9%;">P-UBR</th>
                    <th style="width: 9%;">P-UL</th>
                </tr>
            </thead>
            <tbody>
                @foreach($decisionMatrix as $row)
                    <tr>
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

    <div class="table-container">
        <h3>Step 3: Matriks Normalisasi</h3>
        <p>Normalisasi digunakan untuk menyetarakan skala semua kriteria.</p>
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 10%;">Name</th>
                    <th style="width: 10%;">TA</th>
                    <th style="width: 9%;">AA</th>
                    <th style="width: 9%;">LA</th>
                    <th style="width: 9%;">BR</th>
                    <th style="width: 9%;">GPA</th>
                    <th style="width: 9%;">CS</th>
                    <th style="width: 9%;">TS</th>
                    <th style="width: 9%;">S</th>
                    <th style="width: 9%;">P-UA</th>
                    <th style="width: 9%;">P-UBR</th>
                    <th style="width: 9%;">P-UL</th>
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

    <div class="table-container">
        <h3>Step 4: Nilai Optimasi</h3>
        <p>Menghitung total skor dari hasil normalisasi yang dikalikan bobot kriteria.</p>
        <table style="width: 100%;">
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
    </div>

    <div class="table-container">
        <h3>Step 5: Perangkingan</h3>
        <p>Menentukan urutan berdasarkan skor MOORA tertinggi hingga terendah.</p>
        <table style="width: 100%;">
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
    </div>

</body>
</html>
