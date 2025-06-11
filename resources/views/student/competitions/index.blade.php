@extends('layout.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">My Competition Requests</h4>

            {{-- Filter Tabs --}}
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == null ? 'active' : '' }}"
                        href="{{ route('student.competitions.index') }}">
                        <i class="bi bi-list"></i> All
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}"
                        href="{{ route('student.competitions.index', ['status' => 'pending']) }}">
                        <i class="bi bi-clock-history"></i> Pending
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'approved' ? 'active' : '' }}"
                        href="{{ route('student.competitions.index', ['status' => 'approved']) }}">
                        <i class="bi bi-check-circle"></i> Approved
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'rejected' ? 'active' : '' }}"
                        href="{{ route('student.competitions.index', ['status' => 'rejected']) }}">
                        <i class="bi bi-x-circle"></i> Rejected
                    </a>
                </li>
            </ul>

            {{-- Add Button --}}
            <div class="mb-3">
                <button class="btn btn-primary btn-rounded btn-fw"
                        data-bs-toggle="modal"
                        data-bs-target="#addCompetitionModal">
                    <i class="bi bi-plus-circle me-2"></i> Add Competition Request
                </button>
            </div>

            {{-- Table Partial --}}
            @include('student.competitions.partials.table', ['requests' => $requests])

            {{-- Modal Add Competition --}}
            @include('student.competitions.partials.modal_add')

            {{-- Modals per Competition Entry --}}
            @foreach ($requests as $item)
                @include('student.competitions.partials.modal_detail', ['item' => $item])

                @if ($item->competition->competition_document)
                    @include('student.competitions.partials.modal_pdf', ['item' => $item])
                @endif
            @endforeach
        </div>
    </div>
@endsection
