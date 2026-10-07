<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ADS Manager</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/skyraan-technologies.avif') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.0.96/css/materialdesignicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">


    <style>
        .container-wrapper {
            max-width: 900px;
            margin: 0 auto;
        }

        .header-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .header-section h2 {
            color: #2d3748;
            font-weight: 700;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
        }

        .description {
            color: #718096;
            font-size: 15px;
            margin: 0;
        }

        #ad-priority-wrapper {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
        }

        #ad-priority-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .ad-item {
            display: flex;
            align-items: center;
            gap: 15px;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 18px 20px;
            margin-bottom: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: grab;
            position: relative;
            overflow: hidden;
        }

        .ad-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .ad-item:hover {
            background: white;
            border-color: #cbd5e0;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .ad-item:hover::before {
            opacity: 1;
        }

        .ad-item:active {
            cursor: grabbing;
            transform: scale(0.98);
        }

        .ad-item.sortable-ghost {
            opacity: 0.4;
            background: #e2e8f0;
        }

        .ad-item.sortable-drag {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
            transform: rotate(2deg);
        }

        .drag-handle {
            color: #a0aec0;
            font-size: 18px;
            cursor: grab;
            transition: color 0.2s ease;
        }

        .ad-item:hover .drag-handle {
            color: #667eea;
        }

        .ad-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 24px;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .ad-item:hover .ad-icon {
            transform: scale(1.1);
        }

        .ad-icon.google {
            background: #fef2f2;
            color: #dc2626;
        }

        .ad-icon.facebook {
            background: #eff6ff;
            color: #2563eb;
        }

        .ad-icon.unity {
            background: #f9fafb;
            color: #1f2937;
        }

        .ad-icon.disable {
            background: #fef2f2;
            color: #991b1b;
        }

        .ad-content {
            flex: 1;
            min-width: 0;
        }

        .ad-name {
            font-weight: 600;
            color: #2d3748;
            font-size: 16px;
            margin-bottom: 2px;
        }

        .ad-description {
            font-size: 13px;
            color: #718096;
            margin: 0;
        }

        .ad-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .badge-priority-1 {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: #78350f;
            box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3);
        }

        .badge-priority-2 {
            background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(100, 116, 139, 0.3);
        }

        .badge-priority-3 {
            background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(139, 92, 246, 0.3);
        }

        .badge-disabled {
            background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        }

        .tip-box {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 4px solid #f59e0b;
            border-radius: 12px;
            padding: 15px 20px;
            margin-top: 20px;
            display: flex;
            align-items: start;
            gap: 12px;
        }

        .tip-icon {
            color: #d97706;
            font-size: 18px;
            margin-top: 2px;
        }

        .tip-text {
            color: #78350f;
            font-size: 14px;
            margin: 0;
            line-height: 1.6;
        }

        .save-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            margin-top: 20px;
            width: 100%;
        }

        .save-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        .save-button:active {
            transform: translateY(0);
        }

        @media (max-width: 576px) {
            .ad-item {
                padding: 15px;
            }

            .ad-icon {
                width: 40px;
                height: 40px;
                font-size: 20px;
            }

            .ad-name {
                font-size: 14px;
            }

            .ad-badge {
                font-size: 11px;
                padding: 6px 12px;
            }
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #a0aec0;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .ad-item {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
</head>

<body>
    @include('admin.navbar')
    <!-- ======= Sidebar ======= -->
    @include('admin.sidebar')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('admin/app_list') }}">App List</a></li>
                    <li class="breadcrumb-item active">List of App Table</li>
                </ol>
            </nav>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li> <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                @endforeach
            </div>
        @endif
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card" style="background-color: #fff;">
                    <div class="card-body">
                        <h4 class="card-title text-dark">Disable Ads ID App Form</h4>
                        <hr class="text-dark">
                        @foreach ($edit_app_id as $edit_app_id)
                            <form class="forms-sample" role="form"
                                action="{{ url('admin/view_app_list/' . $edit_app_id->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row mb-3">
                                    <div class="col-md-3">
                                        <label for="" class="col-sm-12 col-form-label h2 text-dark fw-bold"
                                            style="padding-left: 10px">App Informations <span
                                                style="color:red;">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <label class="custom-control-label fw-bold" for="description">App Name :
                                        </label>&nbsp;<?php echo $edit_app_id->app_name; ?> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <br>
                                        <label class="custom-control-label fw-bold" for="description">App Package :
                                        </label>&nbsp;<?php echo $edit_app_id->package_name ?? $edit_app_id->apple_id; ?> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <br>
                                        <label class="custom-control-label fw-bold" for="">Device Type :
                                        </label>&nbsp; <?php echo !empty($edit_app_id->app_type) && $edit_app_id->app_type == 1 ? 'Android' : '-'; ?>
                                        &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label fw-bold" for="">Device Type :
                                        </label>&nbsp; <?php echo !empty($edit_app_id->app_type) && $edit_app_id->app_type == 2 ? 'IOS' : '-'; ?>
                                        <br>
                                    </div>
                                </div>

                                <hr>

                                <div class="form-group row mb-3">
                                    <label for="ad_app_type" class="col-sm-3 col-form-label h2 text-dark fw-bold"
                                        style="padding-left: 20px">Ad App Type <span
                                            style="color:red;">&nbsp;*</span></label>
                                    <div class="col-sm-9">
                                        <select
                                            class="form-select form-select-white mb-3 text-dark bg-outline-dark border-3"
                                            name="ad_app_type" id="ad_app_type" style="width:100%"
                                            onchange="ad_app_typess()">
                                            <option class="text-dark" value="">Select a Ad App Type *</option>
                                            <option class="text-dark" value="1" data-icon="fa-google"
                                                {{ $edit_app_id->which_is_active_ads_id == 1 ? 'selected' : '' }}
                                                {{ $edit_app_id->google_ads_id == null ? 'disabled' : '' }}>Google Ad
                                            </option>
                                            <option class="text-dark" value="2" data-icon="fa-facebook"
                                                {{ $edit_app_id->which_is_active_ads_id == 2 ? 'selected' : '' }}
                                                {{ $edit_app_id->facebook_ads_id == null ? 'disabled' : '' }}>Facebook
                                                Ad
                                            </option>
                                            <option class="text-dark" value="3" data-icon="fa-unity"
                                                {{ $edit_app_id->which_is_active_ads_id == 3 ? 'selected' : '' }}
                                                {{ $edit_app_id->unity_ads_id == null ? 'disabled' : '' }}>Unity Ad
                                            </option>
                                            <option class="text-dark" value="0" data-icon="fa-ban"
                                                {{ $edit_app_id->which_is_active_ads_id == 0 ? 'selected' : '' }}>
                                                Disable
                                                Ad</option>
                                        </select>
                                    </div>
                                </div>

                                <hr>

                                {{-- @php
                                    $google_priority = $edit_app_id->google_priority ?? 0;
                                    $facebook_priority = $edit_app_id->facebook_priority ?? 0;
                                    $unity_priority = $edit_app_id->unity_priority ?? 0;
                                    $which_is_active_ads_id = $edit_app_id->which_is_active_ads_id ?? 0;
                                @endphp

                                <div class="form-group row mb-3">
                                    <label for="ad_app_type" class="col-sm-3 col-form-label h2 text-dark fw-bold"
                                        style="padding-left: 20px">Ads Priority Order <span
                                            style="color:red;">&nbsp;*</span></label>
                                    <div class="col-sm-9">

                                        <div class="container-wrapper">
                                            <div id="ad-priority-wrapper">
                                                <div class="section-title">
                                                    <i class="fas fa-layer-group"></i>
                                                    Priority List
                                                </div>
                                                <ul id="ad-priority-list" class="list-unstyled m-0">
                                                    <li class="ad-item" data-ad="google">
                                                        <div class="drag-handle">
                                                            <i class="fas fa-grip-vertical"></i>
                                                        </div>
                                                        <div class="ad-icon google">
                                                            <i class="fab fa-google"></i>
                                                        </div>
                                                        <div class="ad-content">
                                                            <div class="ad-name">Google Ads</div>
                                                            <div class="ad-description">High-performance network</div>
                                                        </div>
                                                        <div class="ad-badge badge-priority-1">
                                                            <i class="fas fa-crown"></i>
                                                            <span class="badge-text">Priority 1</span>
                                                        </div>
                                                    </li>
                                                    <li class="ad-item" data-ad="facebook">
                                                        <div class="drag-handle">
                                                            <i class="fas fa-grip-vertical"></i>
                                                        </div>
                                                        <div class="ad-icon facebook">
                                                            <i class="fab fa-facebook-f"></i>
                                                        </div>
                                                        <div class="ad-content">
                                                            <div class="ad-name">Facebook Ads</div>
                                                            <div class="ad-description">Social media targeting</div>
                                                        </div>
                                                        <div class="ad-badge badge-priority-2">
                                                            <i class="fas fa-star"></i>
                                                            <span class="badge-text">Priority 2</span>
                                                        </div>
                                                    </li>
                                                    <li class="ad-item" data-ad="unity">
                                                        <div class="drag-handle">
                                                            <i class="fas fa-grip-vertical"></i>
                                                        </div>
                                                        <div class="ad-icon unity">
                                                            <i class="fab fa-unity"></i>
                                                        </div>
                                                        <div class="ad-content">
                                                            <div class="ad-name">Unity Ads</div>
                                                            <div class="ad-description">Gaming & app monetization</div>
                                                        </div>
                                                        <div class="ad-badge badge-priority-3">
                                                            <i class="fas fa-medal"></i>
                                                            <span class="badge-text">Priority 3</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>

                                            <input type="hidden" name="ad_priority_order" id="ad_priority_order"
                                                value="">
                                        </div>
                                    </div>
                                </div> --}}

                                @php
                                    $google_priority = $edit_app_id->google_priority ?? 0;
                                    $facebook_priority = $edit_app_id->facebook_priority ?? 0;
                                    $unity_priority = $edit_app_id->unity_priority ?? 0;
                                    $which_is_active_ads_id = $edit_app_id->which_is_active_ads_id ?? 0;
                                @endphp

                                <div class="form-group row mb-3">
                                    <label for="ad_app_type" class="col-sm-3 col-form-label h2 text-dark fw-bold"
                                        style="padding-left: 20px">Ads Priority Order <span
                                            style="color:red;">&nbsp;*</span></label>

                                    <div class="col-sm-9">
                                        <div class="container-wrapper">
                                            <div id="ad-priority-wrapper">
                                                <div class="section-title">
                                                    <i class="fas fa-layer-group"></i>
                                                    Priority List
                                                </div>

                                                <ul id="ad-priority-list" class="list-unstyled m-0">
                                                    <li class="ad-item" data-ad="google">
                                                        <div class="drag-handle"><i class="fas fa-grip-vertical"></i>
                                                        </div>
                                                        <div class="ad-icon google"><i class="fab fa-google"></i>
                                                        </div>
                                                        <div class="ad-content">
                                                            <div class="ad-name">Google Ads</div>
                                                            <div class="ad-description">High-performance network</div>
                                                        </div>
                                                        <div class="ad-badge badge-priority-1">
                                                            <i class="fas fa-crown"></i>
                                                            <span class="badge-text">Priority 1</span>
                                                        </div>
                                                    </li>
                                                    <li class="ad-item" data-ad="facebook">
                                                        <div class="drag-handle"><i class="fas fa-grip-vertical"></i>
                                                        </div>
                                                        <div class="ad-icon facebook"><i
                                                                class="fab fa-facebook-f"></i></div>
                                                        <div class="ad-content">
                                                            <div class="ad-name">Facebook Ads</div>
                                                            <div class="ad-description">Social media targeting</div>
                                                        </div>
                                                        <div class="ad-badge badge-priority-2">
                                                            <i class="fas fa-star"></i>
                                                            <span class="badge-text">Priority 2</span>
                                                        </div>
                                                    </li>
                                                    <li class="ad-item" data-ad="unity">
                                                        <div class="drag-handle"><i class="fas fa-grip-vertical"></i>
                                                        </div>
                                                        <div class="ad-icon unity"><i class="fab fa-unity"></i></div>
                                                        <div class="ad-content">
                                                            <div class="ad-name">Unity Ads</div>
                                                            <div class="ad-description">Gaming & app monetization</div>
                                                        </div>
                                                        <div class="ad-badge badge-priority-3">
                                                            <i class="fas fa-medal"></i>
                                                            <span class="badge-text">Priority 3</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>

                                            <input type="hidden" name="ad_priority_order" id="ad_priority_order"
                                                value="">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" name="submit" class="btn btn-primary"
                                    id="susubmitbmit">Submit</button>
                                <button id="loading" class="btn btn-primary" type="button" disabled=""
                                    style="cursor: pointer;"><span class="spinner-border spinner-border-sm"
                                        role="status" aria-hidden="true"></span>Loading...</button>
                                <a href="{{ url('admin/app_list') }}" class="btn btn-dark" type="button">cancel</a>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const list = document.getElementById('ad-priority-list');

            const adPriorities = {
                google: @json($google_priority),
                facebook: @json($facebook_priority),
                unity: @json($unity_priority)
            };

            const activeAdId = @json($which_is_active_ads_id);
            const adMap = {
                1: 'google',
                2: 'facebook',
                3: 'unity'
            };
            const activeAd = adMap[activeAdId];
            const adItems = Array.from(list.children);

            function reorderByPriority() {
                const allZero = Object.values(adPriorities).every(p => p === 0);
                let sortedItems = [...adItems];

                if (allZero) {
                    // 🔸 All are zero — use activeAdId to decide who comes first
                    if (activeAd) {
                        const activeItem = sortedItems.find(item => item.dataset.ad === activeAd);
                        if (activeItem) {
                            sortedItems.splice(sortedItems.indexOf(activeItem), 1);
                            sortedItems.unshift(activeItem); // Move active ad to top
                        }
                    }
                } else {
                    // 🔸 At least one has priority — sort by priority only
                    sortedItems.sort((a, b) => {
                        const aPriority = adPriorities[a.dataset.ad] || 999;
                        const bPriority = adPriorities[b.dataset.ad] || 999;
                        return aPriority - bPriority;
                    });
                }

                // 🔸 Append to DOM in new order
                sortedItems.forEach(item => list.appendChild(item));
            }

            reorderByPriority();

            // SortableJS setup
            new Sortable(list, {
                animation: 250,
                easing: 'cubic-bezier(0.4, 0, 0.2, 1)',
                ghostClass: 'sortable-ghost',
                dragClass: 'sortable-drag',
                handle: '.drag-handle',
                onEnd: updatePriorityOrder
            });

            function updatePriorityOrder() {
                const items = list.querySelectorAll('.ad-item');
                const order = [];

                items.forEach((item, index) => {
                    const badge = item.querySelector('.ad-badge');
                    const badgeText = badge.querySelector('.badge-text');
                    const icon = badge.querySelector('i');
                    const ad = item.dataset.ad;

                    badge.classList.remove('badge-priority-1', 'badge-priority-2', 'badge-priority-3');

                    const priority = index + 1;
                    badge.classList.add('badge-priority-' + priority);

                    if (icon) {
                        icon.className =
                            priority === 1 ? 'fas fa-crown' :
                            priority === 2 ? 'fas fa-star' :
                            'fas fa-medal';
                    }

                    badgeText.textContent = 'Priority ' + priority;
                    order.push({
                        ad: ad,
                        priority: priority
                    });
                });

                document.getElementById('ad_priority_order').value = JSON.stringify(order);
                console.log('✅ Updated priority order:', order);
            }

            // Initial update on load
            updatePriorityOrder();
        });
    </script>




    <script>
        $(document).ready(function() {
            // Initialize the select2 plugin
            $("#ad_app_type").select2({
                templateResult: formatOption,
                templateSelection: formatOption
            });
        });

        function formatOption(option) {
            if (!option.id) {
                return option.text;
            }

            var iconClass = $(option.element).data('icon');
            if (iconClass) {
                return $('<span><i class="fa ' + iconClass + ' fw-blod"></i> - ' + option.text + '</span>');
            } else {
                return option.text;
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            @if (Session::has('error'))
                toastr.error("{{ Session::get('error') }}");
            @elseif (Session::has('message'))
                toastr.success("{{ Session::get('message') }}");
            @endif
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({});
        });
    </script>

    <script>
        $('#loading').hide();
        $('#susubmitbmit').on('click', function() {
            $('#loading').show();
            $('#susubmitbmit').hide();
        });
    </script>
    <script>
        if ($('#image_3').is(':checked')) {
            $("#Normal_image_type_1").show()
            $('#url_image_type_2').hide();
        }

        $('#image_3').bind('change', function() {
            if ($(this).is(':checked'))
                $("#Normal_image_type_1").show().removeAttr('checked', true)
            $('#url_image_type_2').hide();
        });

        $("#image_4").bind('change', function() {
            if ($(this).is(':checked'))
                $("#Normal_image_type_1").hide();
            $('#url_image_type_2').show().attr('checked', true);
        });
    </script>


</body>

</html>
