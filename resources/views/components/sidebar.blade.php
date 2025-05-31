@php
    $role = Auth::user()->role_id;
@endphp

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-category">Menu</li>


        @if ($role == 1)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="menu-icon mdi bi bi-speedometer2"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#usersMenu" href="#">
                    <i class="menu-icon bi bi-person"></i>
                    <span class="menu-title">Users</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="usersMenu">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="{{ route('supervisors.index') }}">Supervisor</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('students.index') }}">Student</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item"><a class="nav-link" href="{{ route('departments.index') }}"><i
                        class="menu-icon mdi bi bi-building"></i><span class="menu-title">Departments</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('study_programs.index') }}"><i
                        class="menu-icon mdi bi bi-journal-bookmark"></i><span class="menu-title">Study
                        Programs</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('academic_years.index') }}"><i
                        class="menu-icon mdi bi-calendar3"></i><span class="menu-title">Academic Years</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('periods.index') }}"><i
                        class="menu-icon mdi bi bi-clock"></i><span class="menu-title">Periods</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('student_periods.index') }}"><i
                        class="menu-icon mdi bi bi-calendar-range"></i><span class="menu-title">Student
                        Periods</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('competitions.index') }}"><i
                        class="menu-icon mdi bi bi-trophy"></i><span class="menu-title">Competitions</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('achievements.index') }}"><i
                        class="menu-icon bi bi-award"></i><span class="menu-title">Achievements</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('pre_university_achievements.index') }}"><i
                        class="menu-icon bi bi-award"></i><span class="menu-title">Pre University
                        Achievements</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}"><i
                        class="menu-icon mdi bi bi-tags"></i><span class="menu-title">Categories</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.recommendations.index') }}"><i
                        class="menu-icon mdi bi bi-lightbulb"></i><span class="menu-title">Recommendations</span></a>
            </li>
            <li class="nav-item"><a class="nav-link" href="{{ route('skills.index') }}"><i
                        class="menu-icon mdi bi bi-tools"></i><span class="menu-title">Skills</span></a></li>
        @endif


        @if ($role == 3)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.dashboard') }}">
                    <i class="menu-icon mdi bi bi-speedometer2"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.profile') }}">
                    <i class="menu-icon mdi bi bi-person"></i>
                    <span class="menu-title">Profile</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.recommendations.index') }}">
                    <i class="menu-icon mdi bi bi-person"></i>
                    <span class="menu-title">Recommendations</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.achievements.index') }}">
                    <i class="menu-icon mdi bi bi-person"></i>
                    <span class="menu-title">Achievements</span>
                </a>
            </li>
        @endif


        <li class="nav-item mt-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link btn btn-link text-start w-100"
                    style="color: inherit; text-decoration: none;">
                    <i class="menu-icon mdi bi bi-box-arrow-right"></i>
                    <span class="menu-title">Logout</span>
                </button>
            </form>
        </li>
    </ul>
</nav>
