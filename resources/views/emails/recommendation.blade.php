<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekomendasi Kompetisi</title>
</head>
<body>
    <h1>Halo {{ $student->user_name }},</h1>

    <p>Kami ingin memberitahukan Anda bahwa Anda telah diterima dalam rekomendasi untuk kompetisi berikut:</p>
    <p><strong>Kompetisi:</strong> {{ $competition->competition_tittle }}</p>
    <p><strong>Skor Rekomendasi:</strong> {{ $recommendationResult->recommendation_result_score }}</p>

    <p>Kami berharap Anda dapat mengikuti kompetisi ini dengan baik!</p>

    <a href="{{ url(route('student.recommendations.index')) }}">Lihat Kompetisi</a>

    <p>Terima kasih atas partisipasi Anda dan semoga sukses!</p>
</body>
</html>
