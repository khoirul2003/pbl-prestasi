@extends('layout.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Welcome, {{ $student->user_name }}</h1>

    <div class="row">

        <div class="col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body text-center">
                    <h5>Total Achievements</h5>
                    <h2>{{ $achievementCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">Recent Achievements</div>
                <div class="card-body">
                    @if($recentAchievements->count())
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Year</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentAchievements as $achievement)
                                    <tr>
                                        <td>{{ $achievement->achievement_title }}</td>
                                        <td>{{ $achievement->category_name }}</td>
                                        <td>{{ $achievement->achievement_year }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">No achievements found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Achievement by Category -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header">Achievements by Category</div>
                <div class="card-body">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Achievement Trends -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header">Achievement Trends</div>
                <div class="card-body">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Students -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">Top Students by Achievements</div>
                <div class="card-body">
                    <canvas id="topStudentsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Category Chart
    const categoryChart = new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($achievementStats->pluck('category_name')) !!},
            datasets: [{
                label: 'Total',
                data: {!! json_encode($achievementStats->pluck('total')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        }
    });

    // Trend Chart
    const trendChart = new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($achievementTrendYears) !!},
            datasets: [{
                label: 'Achievements per Year',
                data: {!! json_encode($achievementTrendCounts) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.4)',
                borderColor: 'rgba(75, 192, 192, 1)',
                fill: true,
                tension: 0.3
            }]
        }
    });

    // Top Students Chart
    const topStudentsChart = new Chart(document.getElementById('topStudentsChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($topStudents->pluck('student_name')) !!},
            datasets: [{
                label: 'Total Achievements',
                data: {!! json_encode($topStudents->pluck('achievement_count')) !!},
                backgroundColor: 'rgba(255, 159, 64, 0.6)'
            }]
        },
        options: {
            indexAxis: 'y'
        }
    });
</script>
@endpush
