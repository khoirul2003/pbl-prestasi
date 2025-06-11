@extends('layout.app')

@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h4 class="card-title mb-4">My Achievements</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Filter Tabs --}}
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link {{ $tab !== 'pre' ? 'active' : '' }}"
                   href="{{ route('student.achievements.index') }}">
                    <i class="bi bi-award"></i> Achievements
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $tab === 'pre' ? 'active' : '' }}"
                   href="{{ route('student.achievements.index', ['tab' => 'pre']) }}">
                    <i class="bi bi-clock-history"></i> Pre-University Achievements
                </a>
            </li>
        </ul>

        <div class="mb-3">
            <button class="btn btn-primary btn-rounded btn-fw mb-3"
                    data-bs-toggle="modal"
                    data-bs-target="#addAchievementModal">
                <i class="bi bi-plus-circle me-2"></i> Add Achievement
            </button>
        </div>

        {{-- Table Content Loaded per Tab --}}
        @if ($tab === 'pre')
            @include('student.achievements.partials.table_pre', [
                'achievements' => $achievements,
                'categories' => $categories
            ])
        @else
            @include('student.achievements.partials.table', [
                'achievements' => $achievements,
                'categories' => $categories
            ])
        @endif

        {{-- Modals --}}
        @include('student.achievements.partials.modal_add')
    </div>
</div>
@endsection
