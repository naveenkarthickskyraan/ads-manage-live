@php
    $filename = request()->segments();
    $file = request()->segment(count(request()->segments()));
@endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
    .alert {
        border: 0;
        position: relative;
        padding: 0.95rem 1.25rem;
        border-radius: 1px;
        color: inherit;
        background-color: #fff;
        border-left: 5px solid red !important;
        -webkit-box-shadow: 1px 1px 14px 0 rgba(18, 38, 63, .26);
        -moz-box-shadow: 1px 1px 14px 0 rgba(18, 38, 63, .26);
        box-shadow: 1px 1px 14px 0 rgba(18, 38, 63, .26);
        font-size: 18px;
        text-decoration: underline white;
        color: red;
    }

    .alert-success {
        border: 0;
        position: relative;
        padding: 0.95rem 1.25rem;
        border-radius: 1px;
        color: inherit;
        font-size: 16px;
        background-color: #fff;
        border-left: 5px solid green !important;
        color: green;
        -webkit-box-shadow: 1px 1px 14px 0 rgba(18, 38, 63, .26);
        -moz-box-shadow: 1px 1px 14px 0 rgba(18, 38, 63, .26);
        box-shadow: 1px 1px 14px 0 rgba(18, 38, 63, .26);
    }

    .btn-add {
        background: #012970 !important;
        border-color: #012970 !important;
    }
</style>

<style>
    .sidebar-nav .nav-link.collapse {
        background: #012970 !important;
        color: #ffffff !important;
        text-transform: uppercase !important;
    }

    .sidebar-nav .nav-link.collapse i {
        color: #ffffff !important;
        text-transform: uppercase !important;
    }

    .sidebar-nav .nav-content a {
        color: #7e87a2 !important;
    }

    .sidebar-nav .nav-content a:hover {
        background: rgba(199, 199, 199, .2);
        color: #0f47aa !important;
        border-radius: 5px;
    }

    .sidebar-nav .nav-link {
        padding-left: 6px;
    }

    .sidebar-nav .nav-link.collapse {
        /* background: #012970 !important; */
        background: #012970 !important;
        color: #ffffff !important;
        text-transform: uppercase !important;
        box-shadow: 4px 4px 10px 0 rgba(0, 0, 0, .1), 4px 4px 15px -5px rgba(21, 114, 232, .4) !important;
        padding: 8px 14px !important;
        /* margin-left: 10px; */
    }

    .sidebar-nav .nav-link.collapsed {
        padding: 8px 14px !important;
        border-radius: 5px !important;
        /* margin-left: 10px; */
    }

    .sidebar-nav .nav-link.collapsed span {
        font-size: 16px;
        padding-left: 6px;
        /* margin-left: 10px; */
    }

    .sidebar-nav .nav-link.collapse span {
        margin-top: 0px !important;
        font-size: 16px;
        padding-left: 6px;
    }

    .sidebar-nav .nav-link.collapse i {
        color: #ffffff !important;
        text-transform: uppercase !important;
    }

    .sidebar-nav .nav-link {
        height: 51px;
        padding: 0 15px !important;
    }

    /* .sidebar-nav .nav-link span {
          margin-top: 5px !important;
      } */

    .sidebar-nav .nav-content a.active {
        background: rgba(199, 199, 199, .2);
        color: #0f47aa !important;
        border-radius: 5px;
    }

    .color-id {
        color: #4154f1 !important;
        background: #f6f9ff !important;
    }

    .form-select:focus, input[type="text"]:focus, input[type="number"]:focus, input[type="password"]:focus, input[type="email"]:focus {
        border-color: #007BFF;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }
</style>

<aside id="sidebar" class="sidebar">

    @php $AccessModule = Auth::guard('admin')->user()->accountAccessModule @endphp
    @php $explode_1 = explode('|',$AccessModule);@endphp
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link @php echo ($file == 'dashboard') ? 'collapse':'collapsed' @endphp"
                href="{{ url('admin/dashboard') }}" class="@php echo ($file == 'dashboard') ? 'active':'' @endphp">
                <i style="margin-top: -6px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <defs>
                            <path id="solarHomeBold0" fill="currentColor"
                                d="M10.75 9.5a1.25 1.25 0 1 1 2.5 0a1.25 1.25 0 0 1-2.5 0Z" />
                        </defs>
                        <path fill="currentColor" d="M18.5 3H16a.5.5 0 0 0-.5.5v.059l3.5 2.8V3.5a.5.5 0 0 0-.5-.5Z" />
                        <use href="#solarHomeBold0" fill-rule="evenodd" clip-rule="evenodd" />
                        <path fill="currentColor" fill-rule="evenodd"
                            d="m20.75 10.96l.782.626a.75.75 0 0 0 .936-1.172l-8.125-6.5a3.75 3.75 0 0 0-4.686 0l-8.125 6.5a.75.75 0 0 0 .937 1.172l.781-.626v10.29H2a.75.75 0 0 0 0 1.5h20a.75.75 0 0 0 0-1.5h-1.25V10.96ZM9.25 9.5a2.75 2.75 0 1 1 5.5 0a2.75 2.75 0 0 1-5.5 0Zm2.8 3.75c.664 0 1.237 0 1.696.062c.492.066.963.215 1.345.597s.531.853.597 1.345c.058.43.062.96.062 1.573v4.423h-1.5V17c0-.728-.002-1.2-.048-1.546c-.044-.325-.114-.427-.172-.484c-.057-.057-.159-.128-.484-.172c-.347-.046-.818-.048-1.546-.048c-.728 0-1.2.002-1.546.048c-.325.044-.427.115-.484.172c-.057.057-.128.159-.172.484c-.046.347-.048.818-.048 1.546v4.25h-1.5v-4.3c0-.664 0-1.237.062-1.696c.066-.492.215-.963.597-1.345s.854-.531 1.345-.597c.459-.062 1.032-.062 1.697-.062h.098Z"
                            clip-rule="evenodd" />
                        <use href="#solarHomeBold0" fill-rule="evenodd" clip-rule="evenodd" />
                    </svg>
                </i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- End Dashboard Nav -->

        @if (Auth::guard('admin')->user()->role == 'SuperAdmin' || in_array('app_info', $explode_1))
            <li class="nav-item">
                <a class="nav-link @php echo ($file == 'app_list' || $file == 'admin_add_app' || $filename[1] == 'edit_app' || ($filename[1] == 'view_app')) ? 'collapse':'collapsed' @endphp"
                    data-bs-target="#components-nav" data-bs-toggle="collapse"
                    @if ($file == 'app_list' || $file == 'admin_add_app' || $filename[1] == 'edit_app' || $filename[1] == 'view_app') {{ 'aria-expanded="true"' ?? 'aria-expanded="false"' }} @endif
                    href="{{ url('admin/app_list') }}">
                    <i class="fas fa-mobile-alt fa-solid fa-xl pt-1"
                        style="font-size: 24px;margin-top:-5px;margin-left:3px;"></i>
                    <span>Apps</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav"
                    class="nav-content collapse @if ($file == 'app_list' || $file == 'admin_add_app' || $filename[1] == 'edit_app' || $filename[1] == 'view_app') {{ 'show' ?? '' }} @endif"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ url('admin/app_list') }}"
                            class="@php echo ($file == 'app_list') ? 'active':'' @endphp">
                            <i class="bi bi-circle"></i><span>List</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/admin_add_app') }}"
                            class="@php echo ($file == 'admin_add_app') ? 'active':'' @endphp">
                            <i class="bi bi-circle"></i><span>Add</span>
                        </a>
                    </li>
                    @if ($filename[1] == 'edit_app')
                        <li>
                            <a href="/admin/edit_app/{{ $file }}"
                                class="@php echo ($filename[1] == 'edit_app') ? 'active':'' @endphp">
                                <i class="bi bi-circle"></i><span>Manage</span>
                            </a>
                        </li>
                    @endif
                    @if ($filename[1] == 'view_app')
                        <li>
                            <a href="/admin/view_app/{{ $file }}"
                                class="@php echo ($filename[1] == 'view_app') ? 'active':'' @endphp">
                                <i class="bi bi-circle"></i><span>Manage Ads</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li><!-- End Components Nav -->
        @endif
        @if (Auth::guard('admin')->user()->role == 'SuperAdmin' || in_array('ads_info', $explode_1))

            <li class="nav-item">
                <a class="nav-link  @php echo ($file == 'ad_manager_list' || $file == 'add_ad_manager' || $filename[1] == 'edit_ad_manager') ? 'collapse':'collapsed' @endphp"
                    data-bs-target="#forms-nav" data-bs-toggle="collapse"
                    @if ($file == 'ad_manager_list' || $file == 'add_ad_manager' || $filename[1] == 'edit_ad_manager') {{ 'aria-expanded="true"' ?? 'aria-expanded="false"' }} @endif
                    href="{{ url('admin/ad_manager_list') }}">
                    <i class="fa fa-adversal fa-solid fa-xl pt-1"
                        style="font-size: 24px;margin-top:-5px;margin-left:3px;"></i>
                    Ads Manager</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav"
                    class="nav-content collapse @if ($file == 'ad_manager_list' || $file == 'add_ad_manager' || $filename[1] == 'edit_ad_manager') {{ 'show' ?? '' }} @endif"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ url('admin/ad_manager_list') }}"
                            class="@php echo ($file == 'ad_manager_list') ? 'active':'' @endphp">
                            <i class="bi bi-circle"></i><span>List</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/add_ad_manager') }}"
                            class="@php echo ($file == 'add_ad_manager') ? 'active':'' @endphp">
                            <i class="bi bi-circle"></i><span>Add</span>
                        </a>
                    </li>
                    @if ($filename[1] == 'edit_ad_manager')
                        <li>
                            <a href="/admin/edit_ad_manager/{{ $file }}"
                                class="@php echo ($filename[1] == 'edit_ad_manager') ? 'active':'' @endphp">
                                <i class="bi bi-circle"></i><span>Manage</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
        @if (Auth::guard('admin')->user()->role == 'SuperAdmin' || in_array('admin_info', $explode_1))
            <li class="nav-item">
                <a class="nav-link @php echo ($file == 'superadmin' || $file == 'admin_add_sub_admin' || $filename[1] == 'edit_admin') ? 'collapse':'collapsed' @endphp"
                    data-bs-target="#admin-nav" data-bs-toggle="collapse" href="#">
                    <i class="fa fa-users fa-solid fa-xl pt-1"
                        style="font-size: 20px;margin-top:-5px;margin-left:3px;"></i>
                    <span>Admin</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="admin-nav"
                    class="nav-content collapse @if ($file == 'superadmin' || $file == 'admin_add_sub_admin' || $filename[1] == 'edit_admin') {{ 'show' ?? '' }} @endif"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ url('admin/superadmin') }}"
                            class="@php echo ($file == 'superadmin') ? 'active':'' @endphp">
                            <i class="bi bi-circle"></i><span>List</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/admin_add_sub_admin') }}"
                            class="@php echo ($file == 'admin_add_sub_admin') ? 'active':'' @endphp">
                            <i class="bi bi-circle"></i><span>Add</span>
                        </a>
                    </li>
                    @if ($filename[1] == 'edit_admin')
                        <li>
                            <a href="/admin/edit_admin/{{ $file }}"
                                class="@php echo ($filename[1] == 'edit_admin') ? 'active':'' @endphp">
                                <i class="bi bi-circle"></i><span>Manage</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
        <!-- End Charts Nav -->


        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link @php echo ($file == 'profile_update') ? 'collapse':'collapsed' @endphp"
                href="{{ url('admin/profile_update') }}"
                class="@php echo ($file == 'profile_update') ? 'active':'' @endphp">
                <i class="fa fa-user fa-solid fa-xl pt-1"
                    style="font-size: 24px;margin-top:-5px;margin-left:3px;"></i>
                <span>My Profile</span>
            </a>
        </li><!-- End Profile Page Nav -->


        <!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.logout') }}">
                <i class="fa fa-sign-out fa-xl pt-1" style="font-size: 24px;margin-top:-5px;margin-left:3px;"></i>
                <span>Logout</span>
            </a>
        </li>

    </ul>

</aside><!-- End Sidebar-->
