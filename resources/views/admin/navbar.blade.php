<!-- ======= Header ======= -->
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.0.96/css/materialdesignicons.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
    rel="stylesheet">

<style>
    .header {
        background: #012970 !important;
        color: #ffffff;
        height: 65px;
    }

    .header[data-background-color=blue2] {
        background: #012970 !important
    }

    .bi-list::before {
        content: "\f479";
        color: white;
    }

    .header-nav .nav-profile span {
        color: white;
    }

    .logo span {
        color: #ffffff;
    }

    .icon-button {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 35px;
        height: 35px;
        background: #012970;
        color: #ffffff;
        border: none;
        outline: none;
        border-radius: 50%;
        padding-right: 24px !important;
    }

    .icon-button:hover {
        cursor: pointer;
    }

    .icon-button:active {
        background: #012970;
        color: #ffffff;
    }

    .icon-button__badge {
        height: 20px;
        line-height: 16px;
        font-size: 10px;
        font-weight: 700;
        border: 2px solid #fff;
        padding: 0 2px;
        position: absolute;
        top: -4px;
        right: 4px;
        background: #ff002a;
        color: white;
        border-radius: 4px;
        transform: scale(1.1);

    }

    .logo img {
        max-height: 40px;
        margin-right: -1px;
    }
</style>

<style>
    body {
        font-family: 'Montserrat', sans-serif !important;
    }
</style>

<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ url('admin/dashboard') }}" class="logo d-flex align-items-center">
            <span class="me-1"> <img src="{{ asset('assets/img/skyraan-technologies.avif') }}"
                    style="border-radius: 6px;"> </span>
            <span class="d-none d-lg-block"> &nbsp;Admin Dashboard</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->
    
    <style>
      .heading span {
        font-size: 26px;
        font-weight: 700;
        color: #ffffff;
        font-family: "Nunito", sans-serif;
      }
    </style>

    <div class="header-nav ms-auto text-center d-flex justify-content-center align-content-center align-items-center heading">
      <i class="fa fa-solid fa-rectangle-ad" style="font-size: 35px;"></i><span>&nbsp;Management</span>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>

            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    @if (Auth::guard('admin')->user()->image_type == 1)
                        <img src="{{ asset(Auth::guard('admin')->user()->image) }}"alt="Profile" class="rounded-circle">
                    @elseif(Auth::guard('admin')->user()->image_type == 2)
                        <img src="{{ Auth::guard('admin')->user()->image }}" alt="Profile" class="rounded-circle">
                    @endif
                    <br>
                    <br>
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::guard('admin')->user()->name }}</span>
                </a>


                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        @if (Auth::guard('admin')->user()->image_type == 1)
                            <img src="{{ asset(Auth::guard('admin')->user()->image) }}"alt="Profile"
                                class="rounded-circle" style="height:30% !important;width:30% !important;">
                        @elseif(Auth::guard('admin')->user()->image_type == 2)
                            <img src="{{ Auth::guard('admin')->user()->image }}" alt="Profile" class="rounded-circle"
                                style="min-height:40% !important;min-width:40% !important; ">
                        @endif
                        <h6>{{ Auth::guard('admin')->user()->name }}</h6>
                        <span></span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ url('admin/profile_update') }}">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                            <i class="bi bi-gear"></i>
                            <span>Account Settings</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    @if (Auth::guard('admin')->check())
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.logout') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    @endif
                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->
