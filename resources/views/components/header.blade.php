<header>
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
            <span class="icon-menu"></span>
          </button>
        </div>
        <div>
          <a class="navbar-brand brand-logo" href="{{ url('/') }}">
            <p class="h2 link-dark"><strong>PRES</strong>en<strong class="link-primary h1">.</strong></p>
          </a>
          <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}"></a>
        </div>
      </div>

      <div class="navbar-menu-wrapper d-flex align-items-top">
        <ul class="navbar-nav">
          <li class="nav-item fw-semibold d-none d-lg-block ms-0">
            <h1 class="welcome-text">Good Morning, <span class="text-black fw-bold">{{ auth()->user()->user_name }}</span></h1>
            <h3 class="welcome-sub-text">Your performance summary this week</h3>
          </li>
        </ul>

        <ul class="navbar-nav ms-auto">
          <li class="nav-item d-none d-lg-block">
            <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
              <span class="input-group-addon input-group-prepend border-right">
                <span class="icon-calendar input-group-text calendar-icon"></span>
              </span>
              <input type="text" class="form-control">
            </div>
          </li>

          @php
            $user = auth()->user();
            $name = $user->user_name;
            $email = $user->user_username . '@gmail.com';
            $role = $user->role_id;
            $defaultPhoto = asset('photos/default.jpg');
            $photoPath = $defaultPhoto;

            if ($role == 3 && $user->detailStudent) {
                $photo = $user->detailStudent->detail_student_photo;
                $photoPath = $photo ? asset('photos/students/' . $photo) : $defaultPhoto;
            } elseif ($role == 2 && $user->detailSupervisor) {
                $photo = $user->detailSupervisor->detail_supervisor_photo;
                $photoPath = $photo ? asset('photos/supervisors/' . $photo) : $defaultPhoto;
            }
          @endphp

          <li class="nav-item dropdown d-none d-lg-block user-dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="UserDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <img class="rounded-circle" src="{{ $photoPath }}" alt="Profile image" style="width: 32px; height: 32px; object-fit: cover;">
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              <div class="dropdown-header text-center">
                <img class="rounded-circle mb-2" src="{{ $photoPath }}" alt="Profile image" style="width: 48px; height: 48px; object-fit: cover;">
                <p class="mb-1 mt-2 fw-semibold">{{ $name }}</p>
                <p class="fw-light text-muted mb-0">{{ $email }}</p>
              </div>
              <a class="dropdown-item" href="{{ route('logout') }}"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </li>
        </ul>

        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>

    {{-- Fallback JS if Bootstrap dropdown doesn't work --}}
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.querySelector('[data-bs-toggle="dropdown"]');
        const menu = document.querySelector('.dropdown-menu');

        if (toggle && menu) {
          toggle.addEventListener('click', function (e) {
            e.preventDefault();
            menu.classList.toggle('show');

            document.addEventListener('click', function outsideClickListener(evt) {
              if (!toggle.contains(evt.target) && !menu.contains(evt.target)) {
                menu.classList.remove('show');
                document.removeEventListener('click', outsideClickListener);
              }
            });
          });
        }
      });
    </script>
  </header>
