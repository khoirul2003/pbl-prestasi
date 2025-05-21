<header>
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
          <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
              <span class="icon-menu"></span>
            </button>
          </div>
          <div>
            <a class="navbar-brand brand-logo" href="index.html">
              <p class="h2 link-dark"><strong>PRES</strong>en<strong class="link-primary h1">.</strong></p>
            </a>
            <a class="navbar-brand brand-logo-mini" href="index.html">
              
            </a>
          </div>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-top">
          <ul class="navbar-nav">
            <li class="nav-item fw-semibold d-none d-lg-block ms-0">
              <h1 class="welcome-text">Good Morning, <span class="text-black fw-bold">John Doe</span></h1>
              <h3 class="welcome-sub-text">Your performance summary this week </h3>
            </li>
          </ul>
          <ul class="navbar-nav ms-auto">
            {{-- <li class="nav-item dropdown d-none d-lg-block">
              <a class="nav-link dropdown-bordered dropdown-toggle dropdown-toggle-split" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false"> Select Category </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="messageDropdown">
                <a class="dropdown-item py-3">
                  <p class="mb-0 fw-medium float-start">Select category</p>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-item-content flex-grow py-2">
                    <p class="preview-subject ellipsis fw-medium text-dark">Bootstrap Bundle </p>
                    <p class="fw-light small-text mb-0">This is a Bundle featuring 16 unique dashboards</p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-item-content flex-grow py-2">
                    <p class="preview-subject ellipsis fw-medium text-dark">Angular Bundle</p>
                    <p class="fw-light small-text mb-0">Everything you’ll ever need for your Angular projects</p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-item-content flex-grow py-2">
                    <p class="preview-subject ellipsis fw-medium text-dark">VUE Bundle</p>
                    <p class="fw-light small-text mb-0">Bundle of 6 Premium Vue Admin Dashboard</p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-item-content flex-grow py-2">
                    <p class="preview-subject ellipsis fw-medium text-dark">React Bundle</p>
                    <p class="fw-light small-text mb-0">Bundle of 8 Premium React Admin Dashboard</p>
                  </div>
                </a>
              </div>
            </li> --}}
            <li class="nav-item d-none d-lg-block">
              <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
                <span class="input-group-addon input-group-prepend border-right">
                  <span class="icon-calendar input-group-text calendar-icon"></span>
                </span>
                <input type="text" class="form-control">
              </div>
            </li>
            <li class="nav-item">
              <form class="search-form" action="#">
                <i class="icon-search"></i>
                <input type="search" class="form-control" placeholder="Search Here" title="Search here">
              </form>
            </li>
            {{-- <li class="nav-item dropdown">
              <a class="nav-link count-indicator" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                <i class="icon-bell"></i>
                <span class="count"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
                <a class="dropdown-item py-3 border-bottom">
                  <p class="mb-0 fw-medium float-start">You have 4 new notifications </p>
                  <span class="badge badge-pill badge-primary float-end">View all</span>
                </a>
                <a class="dropdown-item preview-item py-3">
                  <div class="preview-thumbnail">
                    <i class="mdi mdi-alert m-auto text-primary"></i>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject fw-normal text-dark mb-1">Application Error</h6>
                    <p class="fw-light small-text mb-0"> Just now </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item py-3">
                  <div class="preview-thumbnail">
                    <i class="mdi mdi-lock-outline m-auto text-primary"></i>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject fw-normal text-dark mb-1">Settings</h6>
                    <p class="fw-light small-text mb-0"> Private message </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item py-3">
                  <div class="preview-thumbnail">
                    <i class="mdi mdi-airballoon m-auto text-primary"></i>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject fw-normal text-dark mb-1">New user registration</h6>
                    <p class="fw-light small-text mb-0"> 2 days ago </p>
                  </div>
                </a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator" id="countDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="icon-mail icon-lg"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="countDropdown">
                <a class="dropdown-item py-3">
                  <p class="mb-0 fw-medium float-start">You have 7 unread mails </p>
                  <span class="badge badge-pill badge-primary float-end">View all</span>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="assets/images/faces/face10.jpg" alt="image" class="img-sm profile-pic">
                  </div>
                  <div class="preview-item-content flex-grow py-2">
                    <p class="preview-subject ellipsis fw-medium text-dark">Marian Garner </p>
                    <p class="fw-light small-text mb-0"> The meeting is cancelled </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="assets/images/faces/face12.jpg" alt="image" class="img-sm profile-pic">
                  </div>
                  <div class="preview-item-content flex-grow py-2">
                    <p class="preview-subject ellipsis fw-medium text-dark">David Grey </p>
                    <p class="fw-light small-text mb-0"> The meeting is cancelled </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="assets/images/faces/face1.jpg" alt="image" class="img-sm profile-pic">
                  </div>
                  <div class="preview-item-content flex-grow py-2">
                    <p class="preview-subject ellipsis fw-medium text-dark">Travis Jenkins </p>
                    <p class="fw-light small-text mb-0"> The meeting is cancelled </p>
                  </div>
                </a>
              </div>
            </li> --}}
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
              <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="data:image/jpeg;base64,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" alt="Profile image"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" src="data:image/jpeg;base64,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" alt="Profile image">
                  <p class="mb-1 mt-3 fw-semibold">Allen Moreno</p>
                  <p class="fw-light text-muted mb-0">allenmoreno@gmail.com</p>
                </div>
                <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile <span class="badge badge-pill badge-danger">1</span></a>
                <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-message-text-outline text-primary me-2"></i> Messages</a>
                <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-calendar-check-outline text-primary me-2"></i> Activity</a>
                <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-help-circle-outline text-primary me-2"></i> FAQ</a>
                <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out</a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
</header>
