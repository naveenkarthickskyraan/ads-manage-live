<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>ADS Manager</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/skyraan-technologies.avif')}}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.0.96/css/materialdesignicons.min.css">
  {{-- <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet"> --}}
  {{-- <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet"> --}}



  {{-- <!-- Templat{{ asset('e Main CSS File --> --}}
  <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
  <style>
    #loader{
        position: fixed;
        width: 100%;
        height: 100vh;
        background: hsl(201deg 87% 94%) url('https://mir-s3-cdn-cf.behance.net/project_modules/max_632/8a1f1813765711.56277edb36b94.gif') no-repeat center;
        z-index: 999;
    }
  </style>
</head>

<body>
  @include('admin.navbar')
  <!-- ======= Sidebar ======= -->
  @include('admin.sidebar')
  <div id="loader"></div>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Ads Manager</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/ad_manager_list')}}">Ads Manager List</a></li>
          <li class="breadcrumb-item active">List of Ads Manager Table</li>
        </ol>
      </nav>
    </div>
      <section class="section dashboard">
          <!-- Recent Sales -->
          <div class="col-12">
            <div class="row">
              @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                @endforeach
              </div>
              @endif
            <div class="card recent-sales overflow-auto">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <h5 class="card-title">Ads Manager List <span>| Today</span></h5>
                  </div>
                  <div class="col-md-3"></div>
                  <div class="col-md-3">
                    <div class="action-btn" align="right" style="padding-top:20px;padding-right:20px;"> 
                      <a href="{{url('admin/add_ad_manager')}}" class="btn btn-sm btn-primary btn-add">
                        <i class="ri-add-line"></i> Add New Ads Manager </a>
                    </div>
                  </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">Filter Ads</div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="issue_type">Ad is Type or Disabled</label>
                                            <select class="form-select form-select-sm mt-1" name="issue_type" id="issue_type">
                                                <option value="" selected>Select a Ad Type</option>
                                                <option value="1">Google AD</option>
                                                <option value="2">Facebook AD</option>
                                                <option value="3">Unity AD</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="app_type">Project Name</label>
                                            <select class="form-select form-select-sm mt-1" name="app_type" id="app_type">
                                              <option value="" selected>App Type</option>
                                              <option value="2">IOS</option>
                                              <option value="1">Android</option>
                                          </select>                                
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-primary" id="filter-btn">Filter</button>
                                <button class="btn btn-secondary" id="reset-btn">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-hover ads-datatable table-responsive">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">App type</th>
                      <th scope="col">App Name</th>
                      <th scope="col">created_at</th>
                      <th scope="col">Status</th>
                      <th scope="col">Ad App Type</th>
                      <th scope="col">Action</th>
                      <th scope="col">Active</th>
                    </tr>
                  </thead>
                  <style>
                    .btn_status 
                    {
                      font-size: .70rem;
                      font-weight: 500;
                      letter-spacing: 1px;
                      padding: 5px 10px;
                      border-radius: 0.25rem;
                      text-transform: uppercase;
                      box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 8%);
                    }
                  </style>
                  <tbody>
                    {{-- @foreach($categorys as $category)
                    <tr>
                      <th scope="row"><a href="#">#{{$category->id}}</a></th>
                      <td>
                        <div class="userDatatable-content">
                          @if($category->app_type == 1)   
                            <p>Android</p>
                          @else
                            <p>IOS</p>
                          @endif
                        </div>
                      </td>
                      <td><a href="#" class="text-primary">{{$category->AppList->package_name ?? $category->AppList->bundle_id}}</a></td>
                      <td>
                        <div class="userDatatable-content">
                          {{date('d-m-Y', strtotime($category->created_at))}}
                        </div>
                      </td>
                      <td class="dc" style="padding-top:15px;">
                        @if($category->is_active == '0')
                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>
                        @else
                        <span class="badge bg-danger rounded-fill" ><i class="bi bi-exclamation-octagon me-1"></i> Deactivate</span>
                        @endif
                      </td>
                      <td>
                        <div class="btn-group">
                        <div>
                          <form action={{url("admin/edit_ad_manager/".$category->id)}} method="POST">
                          {{csrf_field()}}
                          <button  type="submit" class="btn btn-icon btn-circle btn-sm btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit App"><i class="mdi mdi-pencil-box "></i></button>
                        </form>
                        </div>
                        <div>
                          <form action={{url("admin/delete_ad_manager/".$category->id)}} method="POST" style="padding-left:5px;">
                          {{csrf_field()}}
                          <button  type="submit" class="btn btn-icon btn-circle btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this item?');" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete App"><i class="mdi mdi-delete"></i></button>
                        </form>
                        </div>
                        </div>
                      </td>
                      <style>
                        .btn_status 
                        {
                          font-size: .70rem;
                          font-weight: 500;
                          letter-spacing: 1px;
                          padding: 5px 10px;
                          border-radius: 0.25rem;
                          text-transform: uppercase;
                          box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 8%);
                        }
                      </style>
                      <td>
                        <form action="{{url('admin/ad_manager_status_update')}}" method="POST">
                          @csrf
                          <input type="hidden" name="cat_id" value="{{$category->id}}">
                          @if($category->is_active == '0')
                              <input type="hidden" name="status" value="0">
                              <button type="submit" data-toggle="tooltip"  data-original-title="Enable" id="enable" name="enable" title="" class="btn_status btn btn-success btn-sm enable">
                                <i class="bi bi-check-circle me-1"></i>
                              </button>
                          @else
                              <input type="hidden" name="status" value="1">
                              <button type="submit" data-toggle="tooltip" data-original-title="Disable" id="disable" title="" name="disable" class="btn_status btn btn-success btn-sm" style="background: #ffad46!important;border-color: #ffad46!important;color: #fff!important;">
                                <i class="bi bi-exclamation-octagon me-1"></i>
                              </button>
                          @endif
                        </form>
                      </td>
                    </tr>
                    @endforeach --}}
                  </tbody>
                  <tfoot>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">App type</th>
                      <th scope="col">App Name</th>
                      <th scope="col">created_at</th>
                      <th scope="col">Status</th>
                      <th scope="col">Ad App Type</th>
                      <th scope="col">Action</th>
                      <th scope="col">Active</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div><!-- End Recent Sales -->
        </div>
      </section>

            </div>
            <!-- content-wrapper ends -->
            
            <!-- partial:partials/_footer.html -->
            {{-- <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2021</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin template</a> from Bootstrapdash.com</span>
                </div>
            </footer> --}}
            <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
        <footer id="footer" class="footer">
          <div class="copyright">
          </div>
          <!-- <div class="credits"> -->
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
          </div> -->
        </footer><!-- End Footer -->
      
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
      
        <!-- Vendor JS Files -->
        <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{ asset('assets/vendor/chart.js/chart.min.js')}}"></script>
        <script src="{{ asset('assets/vendor/echarts/echarts.min.js')}}"></script>
        <script src="{{ asset('assets/vendor/quill/quill.min.js')}}"></script>
        <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
        <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
        <script src="{{ asset('assets/vendor/php-email-form/validate.js')}}"></script>
      
        <!-- Template Main JS File -->
        <script src="{{ asset('assets/js/main.js')}}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
      
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.all.min.js"></script>

        <script>
        
          function validateform(val, ad_app_type) {
            let actionMessage = '';
            let dropdownOptions = `
              <option value="">Select a Ad Type</option>
              <option value="1" ${ad_app_type === 1 ? 'disabled' : ''}>Google Ads</option>
              <option value="2" ${ad_app_type === 2 ? 'disabled' : ''}>Facebook Ads</option>
              <option value="3" ${ad_app_type === 3 ? 'disabled' : ''}>Unity Ads</option>
              <option value="0">Disable</option>
            `;
        
            if (ad_app_type === 1) {
              actionMessage = 'Do you want to delete Google ID?';
            } else if (ad_app_type === 2) {
              actionMessage = 'Do you want to delete Facebook ID?';
            } else if (ad_app_type === 3) {
              actionMessage = 'Do you want to delete Unity ID?';
            }
        
            Swal.fire({
              title: 'Confirmation',
              text: actionMessage,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Delete',
              cancelButtonText: 'Cancel',
              html: `
                <div class="mb-2 text-dark fw-bold">${actionMessage}</div>
                <div class="mb-2">If you wish to change another Ad ID, please select from the dropdown.</div>
                <div>
                  <select class="form-select" id="action_select" required>
                    ${dropdownOptions}
                  </select>
                </div>
              `,
            }).then((result) => {
              if (result.isConfirmed) {
                const selectedAction = document.getElementById('action_select').value;
                $('#disable_'+val).val(selectedAction);
                $('#form_submit_'+val).submit();
              }
            });
          }
        </script>
        
        
        {{-- <script>
          function validateform(val, ad_app_type) {
            Swal.fire({
              title: 'Select Action',
              html: `
                <select class="form-select" id="action_select">
                  <option value="">Please Select an Ad type before Submitting</option>
                  <option value="google" ${ad_app_type == 1 ? 'disabled' : ''}>Google ID</option>
                  <option value="facebook" ${ad_app_type == 2 ? 'disabled' : ''}>Facebook</option>
                  <option value="Disabled">Disabled</option>
                </select>
              `,
              icon: 'info',
              showCancelButton: true,
              confirmButtonText: 'Confirm',
              cancelButtonText: 'Cancel',
            }).then((result) => {
              if (result.isConfirmed) {
                const selectedAction = document.getElementById('action_select').value;
                if (selectedAction === 'google') {
                  // Handle the Google ID action
                  // This will only be enabled when ad_app_type is not 1
                } else if (selectedAction === 'facebook') {
                  // Handle the Facebook action
                  // This will only be enabled when ad_app_type is not 2
                } else if (selectedAction === 'edit') {
                  // Handle the edit action (you can add your logic here)
                } else if (selectedAction === 'cancel') {
                  // Handle the cancel action (you can add your logic here)
                }
              }
            });
          }
        </script>
         --}}
        
        
        
        {{-- <script>
          function validateform(val){
            Swal.fire({
              title: 'Confirmation',
              text: 'Are you sure you want to delete?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Delete',
              cancelButtonText: 'Cancel'
            }).then((result) => {
              if (result.isConfirmed) {
                $('#form_submit_'+val).submit();
              }
            });
          }
        </script> --}}
        <script>
          $(function() {
              var dataTable =  $('.ads-datatable').DataTable({
                  processing: true,
                  serverSide: true,
                  stateSave:true,
                  order:[[ 0, 'desc' ]],
                  ajax: {
                    url: '{{ route("ad_manager.list") }}',
                    data: function (d) {
                        d.app_type = $('#app_type').val();
                        d.issue_type = $('#issue_type').val();
                    }
                  },
                  columns: [
                    { data: 'id', name: 'id' },
                    { data: 'app_type', name: 'app_type', searchable: true }, 
                    { data: 'app_link', name: 'app_link' },
                    { data: 'created_at_formatted', name: 'created_at' },
                    { data: 'status', name: 'status' },
                    { data: 'ad_app_type', name: 'ad_app_type' },
                    { data: 'action', name: 'action' },
                    { data: 'status_update', name: 'is_active' }
                  ]
              });
              
              // Filter button click event
              $('#filter-btn').on('click', function () {
                  dataTable.draw();
              });
              $('#reset-btn').on('click', function () {
                  $('#app_type').val('');
                  $('#issue_type').val('');
                  dataTable.draw();
              });
          });
        </script>
        <script>
          var preloader = document.getElementById('loader');
          const fadeOutEffect = setInterval(() => {
            if (!preloader.style.opacity) {
              preloader.style.opacity = 0.7;
            }
            if (preloader.style.opacity > 0) {
              preloader.style.opacity -=0.5;
            } else {
              preloader.style.display = 'none';
            }
            }, 300);
        </script>
        <script>
          $(document).ready(function() {
              toastr.options =
              {
                "closeButton" : true,
                "progressBar" : true
              }
              @if (Session::has('error'))
                  toastr.error("{{ Session::get('error') }}");
              @elseif(Session::has('message'))
                  toastr.success("{{Session::get('message')}}");
              @endif
          });
      
        </script>
      
      </body>
      
      </html>