<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="mdi bi bi-speedometer2 menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item nav-category">UI Elements</li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                <i class="menu-icon mdi mdi-chart-line"></i>
                <span class="menu-title">Users</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="">Supervisor</a></li>
                    <li class="nav-item"> <a class="nav-link" href="">Student</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('departments.index') }}" aria-expanded="false"
                aria-controls="form-elements">
                <i class="menu-icon mdi bi bi-building"></i>
                <span class="menu-title">Departments</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('study_programs.index') }}" aria-expanded="false"
                aria-controls="form-elements">
                <i class="menu-icon mdi bi bi-journal-bookmark"></i>
                <span class="menu-title">Study Programs</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('academic_years.index') }}" aria-expanded="false"
                aria-controls="form-elements">
                <i class="menu-icon mdi bi bi-calendar"></i>
                <span class="menu-title">Academic Years</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('periods.index') }}" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon mdi bi bi-clock"></i>
                <span class="menu-title">Periods</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon mdi bi bi-person-fill"></i>
                <span class="menu-title">Student Periods</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon mdi bi bi-trophy"></i>
                <span class="menu-title">Competitions</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon mdi bi bi-award"></i>
                <span class="menu-title">Achievements</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('categories.index') }}" aria-expanded="false"
                aria-controls="form-elements">
                <i class="menu-icon mdi bi bi-tags"></i>
                <span class="menu-title">Categories</span>

            </a>
        </li>

    </ul>
</nav>
