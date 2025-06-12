@php
    $role = Auth::user()->role_id;
@endphp

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-category fs-6">Menu</li>

        @if ($role == 1)
            <li class="nav-item">
                <a class="nav-link fs-6" href="{{ route('admin.dashboard') }}">
                    <i class="menu-icon mdi bi-speedometer2"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link fs-6" href="{{ route('admin.users.index', ['role' => 'student']) }}">
                    <i class="menu-icon mdi bi bi-person"></i>
                    <span class="menu-title">Users</span>
                </a>
            </li>

            <li class="nav-item"><a class="nav-link fs-6" href="{{ route('departments.index') }}"><i
                        class="menu-icon mdi bi bi-building"></i><span class="menu-title">Departments</span></a></li>
            <li class="nav-item"><a class="nav-link fs-6" href="{{ route('study_programs.index') }}"><i
                        class="menu-icon mdi bi bi-journal-bookmark"></i><span class="menu-title">Study
                        Programs</span></a></li>
            <li class="nav-item"><a class="nav-link fs-6" href="{{ route('admin.academics.index') }}"><i
                        class="menu-icon mdi bi-calendar3"></i><span class="menu-title">Academic</span></a></li>
            <li class="nav-item"><a class="nav-link fs-6" href="{{ route('admin.student_periods.index') }}"><i
                        class="menu-icon mdi bi-calendar3"></i><span class="menu-title">Student Period</span></a></li>
            <li class="nav-item"><a class="nav-link fs-6" href="{{ route('admin.periods.index') }}"><i
                        class="menu-icon mdi bi-calendar3"></i><span class="menu-title">Period</span></a></li>
            <li class="nav-item"><a class="nav-link fs-6" href="{{ route('skills.index') }}"><i
                        class="menu-icon mdi bi bi-tools"></i><span class="menu-title">Skills</span></a></li>

            <li class="nav-item">
                <a class="nav-link fs-6" href="{{ route('admin.competitions.index') }}">
                    <i class="menu-icon mdi bi bi-trophy"></i><span class="menu-title">Competitions</span>
                </a>
            </li>
            <li class="nav-item"><a class="nav-link fs-6" href="{{ route('admin.recommendations.index') }}"><i
                class="menu-icon mdi bi bi-lightbulb"></i><span class="menu-title">Recommendations</span></a>
    </li>

            <li class="nav-item"><a class="nav-link fs-6" href="{{ route('categories.index') }}"><i
                        class="menu-icon mdi bi bi-tags"></i><span class="menu-title">Categories</span></a></li>

            <li class="nav-item"><a class="nav-link fs-6" href="{{ route('achievements.index') }}"><i
                        class="menu-icon bi bi-award"></i><span class="menu-title">Achievements</span></a></li>
            <li class="nav-item"><a class="nav-link fs-6" href="{{ route('pre_university_achievements.index') }}"><i
                        class="menu-icon bi bi-award"></i><span class="menu-title">Pre University
                        Achievements</span></a></li>


        @endif

        @if ($role == 2)
            <li class="nav-item">
                <a class="nav-link fs-6" href="{{ route('supervisor.dashboard') }}">
                    <i class="menu-icon mdi bi bi-speedometer2"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link fs-6" href="{{ route('supervisor.profile') }}">
                    <i class="menu-icon mdi bi bi-person"></i>
                    <span class="menu-title">Profile</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link fs-6" href="{{ route('supervisor.competitions.index') }}">
                    <i class="menu-icon mdi bi bi-trophy"></i>
                    <span class="menu-title">Competition</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fs-6" href="{{ route('supervisor.recommendations.index') }}">
                    <i class="menu-icon mdi bi bi-trophy"></i>
                    <span class="menu-title">Recommendation</span>
                </a>
            </li>
        @endif


        @if ($role == 3)
            <li class="nav-item">
                <a class="nav-link fs-6" href="{{ route('student.dashboard') }}">
                    <i class="menu-icon mdi bi bi-speedometer2"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link fs-6" href="{{ route('student.profile') }}">
                    <i class="menu-icon mdi bi bi-person"></i>
                    <span class="menu-title">Profile</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link fs-6" href="{{ route('student.competitions.index') }}">
                    <i class="menu-icon mdi bi bi-trophy"></i>
                    <span class="menu-title">Competition</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link fs-6" href="{{ route('student.recommendations.index') }}">
                    <i class="menu-icon mdi bi bi-lightbulb"></i>
                    <span class="menu-title">Recommendations</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link fs-6" href="{{ route('student.achievements.index') }}">
                    <i class="menu-icon mdi bi bi-award"></i>
                    <span class="menu-title">Achievements</span>
                </a>
            </li>
        @endif



    </ul>
</nav>

<!-- Custom CSS -->
<style>
    /* Custom styles for smaller font */
    .sidebar .nav-item .nav-link,
    .sidebar .nav-item .menu-title {
        font-size: 0.80rem !important;
        /* Make text smaller */
    }
.sidebar .nav-link .menu-title {
  white-space: normal;
}
</style>
