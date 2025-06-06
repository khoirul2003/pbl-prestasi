@extends('layout.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold">Welcome, {{ $student->user_name }}</h2>

    <!-- Row: Pie Chart + Top Students -->
    <div class="row mb-4">
        <!-- Achievement Status Pie Chart -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white fw-bold">
                    Achievements Status
                </div>
                <div class="card-body">
                    <canvas id="statusPieChart" style="height:260px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Students -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-warning text-white fw-bold">
                    Top Students by Achievements
                </div>
                <div class="card-body">
                    <canvas id="topStudentsChart" style="height:260px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Row: Recent Achievements + Available Competitions -->
    <div class="row mb-4">
        <!-- Recent Achievements -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-info text-white fw-bold">Recent Achievements</div>
                <div class="card-body p-3">
                    @if($recentAchievements->count())
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
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
                        </div>
                    @else
                        <p class="text-muted">No achievements found.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Available Competitions -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-success text-white fw-bold">Available Competitions</div>
                <div class="card-body p-3" style="max-height: 310px; overflow-y: auto;">
                    @if($upcomingCompetitions->count())
                        <ul class="list-group list-group-flush">
                            @foreach($upcomingCompetitions as $competition)
                                <li class="list-group-item px-2 py-2">
                                    <strong>{{ $competition->competition_tittle }}</strong><br>
                                    <small class="text-muted">Deadline: {{ \Carbon\Carbon::parse($competition->competition_registration_deadline)->format('d M Y') }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No competitions available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Charts: Category + Trend -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-secondary text-white fw-bold">
                    Achievements by Category
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" style="height:250px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white fw-bold">
                    Achievement Trends
                </div>
                <div class="card-body">
                    <canvas id="trendChart" style="height:250px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Status Pie Chart
    const statusPieChart = new Chart(document.getElementById('statusPieChart'), {
        type: 'pie',
        data: {
            labels: ['Verified', 'Pending', 'Approved', 'Rejected'],
            datasets: [{
                data: [
                    {{ $achievementVerifiedCount }},
                    {{ $achievementPendingCount }},
                    {{ $achievementApprovedCount }},
                    {{ $achievementRejectedCount }}
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 99, 132, 0.6)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
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
</script>
@endpush
