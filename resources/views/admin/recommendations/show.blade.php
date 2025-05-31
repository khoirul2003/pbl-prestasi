@extends('layout.app')

@section('title', 'Student Recommendations - ' . $competition->competition_tittle)

@section('content')

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h4 class="card-title mb-4">Student Recommendations</h4>
        <p class="text-muted mb-4">Competition: <strong>{{ $competition->competition_tittle }}</strong></p>

        <div class="mb-3">
            <a href="{{ route('admin.recommendations.index') }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Back to Competitions List
            </a>
        </div>

        @if(empty($results) || count($results) === 0)
            <div class="alert alert-warning d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <div>No student recommendations data available for this competition.</div>
            </div>
        @else
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <i class="bi bi-info-circle me-2"></i>
                <div>Found {{ count($results) }} recommended students, sorted by highest MOORA score.</div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle table-sm">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 50px;">Rank</th>
                            <th>Student Name</th>
                            <th class="text-center">Total Achievements</th>
                            <th class="text-center">Approved Achievements</th>
                            <th class="text-center">Competition Level</th>
                            <th class="text-center">Best Rank</th>
                            <th class="text-center">GPA</th>
                            <th class="text-center">Category Skills</th>
                            <th class="text-center">Total Skills</th>
                            <th class="text-center">Semester</th>
                            <th class="text-center">Pre-Uni Achievements</th>
                            <th class="text-center">Pre-Uni Rank</th>
                            <th class="text-center">Pre-Uni Level</th>
                            <th class="text-center bg-primary text-white" style="min-width: 100px;">MOORA Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $index => $result)
                            @php
                                $student = $result['student'];
                                $rawData = $result['raw_data'];
                                $levels = [0 => '-', 1 => 'Regional', 2 => 'Nasional', 3 => 'Internasional'];
                                $rankClass = '';
                                if($index == 0) $rankClass = 'table-success';
                                elseif($index == 1) $rankClass = 'table-info';
                                elseif($index == 2) $rankClass = 'table-warning';
                            @endphp
                            <tr class="{{ $rankClass }}">
                                <td class="text-center fw-bold">
                                    @if($index == 0)
                                        <i class="bi bi-trophy text-warning"></i>
                                    @endif
                                    {{ $index + 1 }}
                                </td>
                                <td>
                                    <strong>{{ $student->user_name }}</strong>
                                    @if($student->detailStudent)
                                        <br><small class="text-muted">{{ $student->detailStudent->nim ?? '' }}</small>
                                    @endif
                                </td>
                                <td class="text-center">{{ $rawData['jumlah_prestasi'] ?? 0 }}</td>
                                <td class="text-center">
                                    <span class="badge bg-success">{{ $rawData['jumlah_prestasi_disetujui'] ?? 0 }}</span>
                                </td>
                                <td class="text-center">
                                    @php $level = $rawData['level_kompetisi'] ?? 0; @endphp
                                    @if($level > 0)
                                        <span class="badge {{ $level == 3 ? 'bg-danger' : ($level == 2 ? 'bg-warning text-dark' : 'bg-info text-dark') }}">
                                            {{ $levels[$level] }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $ranking = $rawData['peringkat_kompetisi'] ?? 6; @endphp
                                    @if($ranking < 6)
                                        <span class="badge bg-primary">{{ $ranking }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center fw-bold">
                                    {{ number_format($rawData['ipk'] ?? 0, 2) }}
                                </td>
                                <td class="text-center">{{ $rawData['skill_sesuai_kategori'] ?? 0 }}</td>
                                <td class="text-center">{{ $rawData['total_skill'] ?? 0 }}</td>
                                <td class="text-center">{{ $rawData['semester'] ?? '-' }}</td>
                                <td class="text-center">{{ $rawData['pre_uni_jumlah'] ?? 0 }}</td>
                                <td class="text-center">
                                    @php $preRank = $rawData['pre_uni_peringkat'] ?? 6; @endphp
                                    @if($preRank < 6)
                                        {{ $preRank }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $preLevel = $rawData['pre_uni_level'] ?? 0; @endphp
                                    @if($preLevel > 0)
                                        <span class="badge {{ $preLevel == 3 ? 'bg-danger' : ($preLevel == 2 ? 'bg-warning text-dark' : 'bg-info text-dark') }}">
                                            {{ $levels[$preLevel] }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center fw-bold text-primary">
                                    {{ number_format($result['score'], 4) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <small class="text-muted d-block mt-3">
                <strong>Note:</strong> Rankings are based on the MOORA algorithm (Multi-Objective Optimization on the basis of Ratio Analysis).
                The highest score indicates the best candidate.
            </small>
        @endif
    </div>
</div>

@endsection
