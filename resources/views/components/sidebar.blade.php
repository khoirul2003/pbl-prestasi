<nav class="sidebar sidebar-offcanvas" id="sidebar" >
    <ul class="nav" >

        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="mdi bi bi-speedometer2 menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li> --}}


        <li class="nav-item nav-category">UI Elements</li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}" >
                <i class="menu-icon mdi bi bi-speedometer2"></i>
                <span class="menu-title">Dashboard</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                <i class="menu-icon bi bi-person"></i>
                <span class="menu-title">Users</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('supervisors.index') }}">Supervisor</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('students.index') }}">Student</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('departments.index') }}" >
                <i class="menu-icon mdi bi bi-building"></i>
                <span class="menu-title">Departments</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('study_programs.index') }}" >
                <i class="menu-icon mdi bi bi-journal-bookmark"></i>
                <span class="menu-title">Study Programs</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('academic_years.index') }}" >
                <i class="menu-icon mdi bi-calendar3"></i>
                <span class="menu-title">Academic Years</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('periods.index') }}">
                <i class="menu-icon mdi bi bi-clock"></i>
                <span class="menu-title">Periods</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('student_periods.index') }}" >
                <i class="menu-icon mdi bi bi-calendar-range"></i>
                <span class="menu-title">Student Periods</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('competitions.index') }}" >
                <i class="menu-icon mdi bi bi-trophy"></i>
                <span class="menu-title">Competitions</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('achievements.index') }}">
                <i class="menu-icon bi bi-award"></i>
                <span class="menu-title">Achievements</span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="{{ route('categories.index') }}" >
                <i class="menu-icon mdi bi bi-tags"></i>
                <span class="menu-title">Categories</span>

            </a>
        </li>

    </ul>
</nav>
