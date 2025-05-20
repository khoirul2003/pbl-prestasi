<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item nav-category">UI Elements</li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('departments.index') }}" aria-expanded="false"
                aria-controls="form-elements">
                <i class="menu-icon mdi mdi-card-text-outline"></i>
                <span class="menu-title">Departments</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('study_programs.index') }}" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon mdi mdi-card-text-outline"></i>
                <span class="menu-title">Study Programs</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('academic_years.index') }}" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon mdi mdi-card-text-outline"></i>
                <span class="menu-title">Academic Years</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('periods.index') }}" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon mdi mdi-card-text-outline"></i>
                <span class="menu-title">Periods</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('student_periods.index') }}" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon mdi mdi-card-text-outline"></i>
                <span class="menu-title">Student Periods</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon mdi mdi-card-text-outline"></i>
                <span class="menu-title">Competitions</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon mdi mdi-card-text-outline"></i>
                <span class="menu-title">Achievements</span>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('categories.index') }}" aria-expanded="false"
                aria-controls="form-elements">
                <i class="menu-icon mdi mdi-card-text-outline"></i>
                <span class="menu-title">Categories</span>

            </a>
        </li>

    </ul>
</nav>
