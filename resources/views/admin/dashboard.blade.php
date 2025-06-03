@extends('layout.app')

@section('content')
    {{-- Summary Cards --}}
    <div class="row mb-4 gx-4 gy-4">
        @php
            $cards = [
                [
                    'title' => 'Students',
                    'count' => $studentCount,
                    'icon' => 'bi-people',
                    'bg' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                ],
                [
                    'title' => 'Supervisors',
                    'count' => $supervisorCount,
                    'icon' => 'bi-person-badge',
                    'bg' => 'linear-gradient(135deg, #f7971e 0%, #ffd200 100%)',
                ],
                [
                    'title' => 'Competitions',
                    'count' => $competitionCount,
                    'icon' => 'bi-trophy',
                    'bg' => 'linear-gradient(135deg, #43cea2 0%, #185a9d 100%)',
                ],
                [
                    'title' => 'Achievements',
                    'count' => $achievementCount,
                    'icon' => 'bi-award',
                    'bg' => 'linear-gradient(135deg, #ff6a00 0%, #ee0979 100%)',
                ],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="col-md-3">
                <div class="card shadow-lg rounded-4 p-3"
                    style="background: {{ $card['bg'] }};
                           color: white;
                           transition: transform 0.3s ease, box-shadow 0.3s ease;
                           cursor: pointer;"
                    onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 20px rgba(0,0,0,0.3)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.1)';">
                    <div class="d-flex align-items-center">
                        <div class="icon d-flex align-items-center justify-content-center rounded-3 me-3"
                            style="width: 54px; height: 54px; background: rgba(255,255,255,0.25); box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            <i class="bi {{ $card['icon'] }} fs-3"></i>
                        </div>
                        <div>
                            <div class="text-uppercase fw-light" style="font-size: 0.85rem; letter-spacing: 1px;">
                                {{ $card['title'] }}
                            </div>
                            <div class="fw-bold fs-3 mt-1">{{ number_format($card['count']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    {{-- Charts --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card mb-3 h-100">
                <div class="card-header fw-semibold">Achievement Count by Category</div>
                <div class="card-body" style="height: 350px;">
                    <canvas id="achievementCategoryChart" style="width: 100%; height: 100%;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3 h-100">
                <div class="card-header fw-semibold">Achievement Trend by Year</div>
                <div class="card-body" style="height: 350px;">
                    <canvas id="achievementTrendChart" style="width: 100%; height: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card mb-3 h-100">
                <div class="card-header fw-semibold">Students Distribution by Study Program</div>
                <div class="card-body" style="height: 300px;">
                    <canvas id="studentDistributionChart" style="width: 100%; height: 100%;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3 h-100">
                <div class="card-header fw-semibold">Achievement Verification Status</div>
                <div class="card-body" style="height: 300px;">
                    <canvas id="achievementStatusChart" style="width: 100%; height: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Tables --}}
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header fw-semibold">Recent Achievements</div>
                <div class="card-body table-responsive" style="max-height: 300px; overflow-y:auto;">
                    <table class="table table-sm table-hover mb-0">
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
            <div class="card h-100">
                <div class="card-header fw-semibold">Upcoming Competitions</div>
                <div class="card-body table-responsive" style="max-height: 300px; overflow-y:auto;">
                    <table class="table table-sm table-hover mb-0">
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
            <div class="card h-100">
                <div class="card-header fw-semibold">Top Performing Students</div>
                <div class="card-body table-responsive" style="max-height: 300px; overflow-y:auto;">
                    <table class="table table-sm table-hover mb-0">
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
        const achievementCategoryChart = new Chart(document.getElementById('achievementCategoryChart').getContext('2d'), {
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
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: 15
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        const achievementTrendChart = new Chart(document.getElementById('achievementTrendChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: {!! json_encode($achievementTrendYears) !!},
                datasets: [{
                    label: 'Total Achievements',
                    data: {!! json_encode($achievementTrendCounts) !!},
                    borderColor: 'rgba(0, 128, 255, 0.43)',
                    backgroundColor: 'rgba(0, 128, 255, 0.43)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: 15
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0,
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Year'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                interaction: {
                    mode: 'nearest',
                    intersect: false,
                }
            }
        });


        const achievementStatusChart = new Chart(document.getElementById('achievementStatusChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($verificationStatus->pluck('achievement_verified')) !!},
                datasets: [{
                    data: {!! json_encode($verificationStatus->pluck('total')) !!},
                    backgroundColor: ['#FFC107', '#28A745', '#DC3545'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: 15
                },
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        const studentDistributionChart = new Chart(document.getElementById('studentDistributionChart').getContext('2d'), {
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
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: 15
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@endpush
