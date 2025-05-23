@extends('layout.app')

@section('content')
    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Students</h5>
                    <h2>{{ $studentCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Supervisors</h5>
                    <h2>{{ $supervisorCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Competitions</h5>
                    <h2>{{ $competitionCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Achievements</h5>
                    <h2>{{ $achievementCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik Chart.js --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Achievement Count by Category</div>
                <div class="card-body">
                    <canvas id="achievementCategoryChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Achievement Trend by Year</div>
                <div class="card-body">
                    <canvas id="achievementTrendChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Students Distribution by Study Program</div>
                <div class="card-body">
                    <canvas id="studentDistributionChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Achievement Verification Status</div>
                <div class="card-body">
                    <canvas id="achievementStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Data --}}
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Recent Achievements</div>
                <div class="card-body table-responsive" style="max-height: 300px; overflow-y:auto;">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentAchievements as $item)
                                <tr>
                                    <td>{{ $item->student_name }}</td>
                                    <td>{{ $item->category_name }}</td>
                                    <td>{{ $item->achievement_title }}</td>
                                    <td>{{ $item->achievement_year }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Upcoming Competitions</div>
                <div class="card-body table-responsive" style="max-height: 300px; overflow-y:auto;">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Organizer</th>
                                <th>Deadline</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($upcomingCompetitions as $comp)
                                <tr>
                                    <td>{{ $comp->competition_tittle }}</td>
                                    <td>{{ $comp->competition_organizer }}</td>
                                    <td>{{ \Carbon\Carbon::parse($comp->competition_registration_deadline)->format('d M Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Top Performing Students</div>
                <div class="card-body table-responsive" style="max-height: 300px; overflow-y:auto;">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Total Achievements</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topStudents as $student)
                                <tr>
                                    <td>{{ $student->student_name }}</td>
                                    <td>{{ $student->achievement_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Bar Chart: Achievement Count by Category
        const ctxCategory = document.getElementById('achievementCategoryChart').getContext('2d');
        const achievementCategoryChart = new Chart(ctxCategory, {
            type: 'bar',
            data: {
                labels: {!! json_encode($achievementStats->pluck('category_name')) !!},
                datasets: [{
                    label: 'Achievement Count',
                    data: {!! json_encode($achievementStats->pluck('total')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.7)'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });

        // Line Chart: Achievement Trend by Year
        const ctxTrend = document.getElementById('achievementTrendChart').getContext('2d');
        const achievementTrendChart = new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: {!! json_encode($trendYears) !!},
                datasets: [
                    @foreach ($trendData as $category => $data)
                        {
                            label: '{{ $category }}',
                            data: {!! json_encode($data) !!},
                            fill: false,
                            borderColor: getRandomColor(),
                            tension: 0.1
                        },
                    @endforeach
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });

        // Pie Chart: Achievement Verification Status
        const ctxStatus = document.getElementById('achievementStatusChart').getContext('2d');
        const achievementStatusChart = new Chart(ctxStatus, {
            type: 'pie',
            data: {
                labels: {!! json_encode($verificationStatus->pluck('achievement_verified')) !!},
                datasets: [{
                    data: {!! json_encode($verificationStatus->pluck('total')) !!},
                    backgroundColor: ['#FFC107', '#28A745', '#DC3545'],
                }]
            }
        });

        // Bar Chart: Student Distribution by Study Program
        const ctxStudentDist = document.getElementById('studentDistributionChart').getContext('2d');
        const studentDistributionChart = new Chart(ctxStudentDist, {
            type: 'bar',
            data: {
                labels: {!! json_encode($studentDistribution->pluck('study_program_name')) !!},
                datasets: [{
                    label: 'Students',
                    data: {!! json_encode($studentDistribution->pluck('total')) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.7)'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });

        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    </script>
@endpush
