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
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



  {{-- <!-- Templat{{ asset('e Main CSS File --> --}}
  <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
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
          <li class="breadcrumb-item"><a href="{{url('admin/app_list')}}">App List</a></li>
          <li class="breadcrumb-item active">List of App Table</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row"> 
        <div class="col-12">
          <div class="card recent-sales overflow-auto">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <h5 class="card-title">App List <span>| Today</span></h5>
                </div>  
                <div class="col-md-3"></div>
                <div class="col-md-3">
                  <div class="action-btn" align="right" style="padding-top:20px;padding-right:20px;"> 
                    <a href="{{url('admin/admin_add_app')}}" class="btn btn-sm btn-primary btn-add">
                      <i class="ri-add-line"></i> Add New App</a>
                  </div>
                </div>
              </div>
              <style>
                .fade-disabled {
                    opacity: 0.5; /* Adjust the opacity value as needed */
                    cursor: wait !important; /* Disable pointer events for the faded buttons */
                    transition: opacity 0.3s; /* Add a smooth transition effect */
                }

              </style>
              <br>
              <div class="row mb-1">
                  <div class="col-md-12">
                      <div class="card">
                          <div class="card-body">
                              <div class="card-title">Filter Ads</div>
                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label for="issue_type" class="fw-bold">Ad is Enabled or Disabled</label>
                                          <select class="form-select form-select-sm mt-1 select2" name="issue_type" id="issue_type">
                                              <option value="" selected>Select a Ad Type</option>
                                              <option value="0" >Disable</option>
                                              <option class="text-dark" value="1" data-icon="fa-google" >Google Ad</option>
                                              <option class="text-dark" value="2" data-icon="fa-facebook" >Facebook Ad</option>
                                              <option class="text-dark" value="3" data-icon="fa-unity" >Unity Ad</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label for="app_type" class="fw-bold">App Type</label>
                                          <select class="form-select form-select-sm mt-1 select2" name="app_type" id="app_type">
                                            <option value="" selected>Select a App Type</option>
                                            <option value="2" data-icon="fa-apple">IOS</option>
                                            <option value="1" data-icon="fa-android">Android</option>
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
              <table class="table table-bordered table-hover ads-datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">App Name</th>
                    <th scope="col">App Logo</th>
                    <th scope="col"> App Type</th>
                    <th scope="col"> URL</th>
                    <th scope="col">Package Name or Apple ID</th>
                    <th scope="col">Ad App Type</th>
                    <th scope="col">created_at</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                    <th scope="col">Active</th>
                  </tr>
                </thead>
                <tbody>
                  {{-- @foreach($apps as $row)
                  <tr>
                    <th scope="row"><a href="#">#{{$row->id}}</a></th>
                    <td>{{$row->app_name}}</td>
                    <td>
                      <div class="userDatatable-content ximage">
                        @if($row->app_image == null)   
                          <center><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQdoCQ7-yS62tALBS9_FY5pExwg8Lvvsie6Iml51YO_JQ&s" style="height:50px; width:auto;border-radius:70%;"></center>
                        @elseif($row->app_image_type == 1)
                          <center><a href="{{asset($row->app_image)}}" download onclick="return confirm('So this is for downloading file testing. First of all why do you want to download the file?.. Are you going to do anything with it?');"><img  src="{{asset($row->app_image ) }}" style="width: 55px !important;height: 55px !important; border-radius: 10px !important;box-shadow: 0px 0px 15px #405189 !important;border:2px !important;opacity: 85% !important;"/></center></a>
                        @else
                          <center><a href="{{$row->app_image}}" download onclick="return confirm('So this is for downloading file testing. First of all why do you want to download the file?.. Are you going to do anything with it?');"><img  src="{{$row->app_image}}" style="width: 55px !important;height: 55px !important; border-radius: 10px !important;box-shadow: 0px 0px 15px #405189 !important;border:2px !important;opacity: 85% !important;"/></center></a>
                        @endif
                      </div>
                    </td>
                    <td>
                      <div class="userDatatable-content">
                        @if($row->app_type == 1)   
                          <p>Android</p>
                        @else
                          <p>IOS</p>
                        @endif
                      </div>
                    </td>
                    <td>
                      <div class="userDatatable-content">
                        @if($row->app_type == 1)
                        <a href="{{$row->playstore_url}}" target="_blank" class="btn btn-sm btn-primary text-white btn-outline-dark">Click</a>  
                        @else
                        <a href="{{$row->appstore_url}}" target="_blank"  class="btn btn-sm btn-primary text-white btn-outline-dark">Click</a>
                        @endif
                      </div>
                    </td>
                    <td>
                      <div class="userDatatable-content">
                        @if($row->app_type == 1) 
                        {{$row->package_name}}
                        @else
                        {{$row->apple_id}}
                        @endif
                      </div>
                    </td>
                    <td>
                      <div class="userDatatable-content">
                        {{date('d-m-Y', strtotime($row->created_at))}}
                      </div>
                    </td>
                    <td class="dc" style="padding-top:15px;">
                      @if($row->is_active == '0')
                      <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>
                      @else
                      <span class="badge bg-danger rounded-fill" ><i class="bi bi-exclamation-octagon me-1"></i> Deactivate</span>
                      @endif
                    </td>
                    <td>
                      <div class="btn-group">
                        <div>
                          <form action={{url("admin/edit_app/".$row->id)}} method="POST" style="padding-left:5px;">
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-icon btn-circle btn-sm btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit App"><i class="mdi mdi-pencil-box "></i></button>
                          </form>
                        </div>
                        <div>
                          <form action={{url("admin/delete_app/".$row->id)}} method="POST" style="padding-left:5px;">
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
                      <form action="{{url('admin/app_status_update')}}" method="POST">
                        @csrf
                        <input type="hidden" name="app_id" value="{{$row->id}}">
                        @if($row->is_active == '0')
                            <input type="hidden" name="status" value="0">
                            <button type="submit" data-toggle="tooltip"  data-original-title="Enable" id="enable" name="enable" title="" class="btn_status btn btn-success btn-sm enable">
                                <i class="mdi mdi-debug-step-out"></i>
                            </button>
                        @else
                            <input type="hidden" name="status" value="1">
                            <button type="submit" data-toggle="tooltip" data-original-title="Disable" id="disable" title="" name="disable" class="btn_status btn btn-success btn-sm" style="background: #ffad46!important;border-color: #ffad46!important;color: #fff!important;">
                              <i class="mdi mdi-debug-step-into"></i>
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
                    <th scope="col">App Name</th>
                    <th scope="col">App Logo</th>
                    <th scope="col"> App Type</th>
                    <th scope="col"> URL</th>
                    <th scope="col">Package Name or Apple ID</th>
                    <th scope="col">Ad App Type</th>
                    <th scope="col">created_at</th>
                    <th scope="col">Status</th>
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

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
    </div>
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
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    $(document).ready(function() {
        // Initialize the select2 plugin
        $(".select2").select2({
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
    $(function() {
        var dataTable = $('.ads-datatable').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            order:[[ 0, 'desc' ]],
            scrollX:true,
            ajax: {
              url: '{{ route("admin.dashboard") }}',
              data: function (d) {
                  d.app_type = $('#app_type').val();
                  d.issue_type = $('#issue_type').val();
              }
            },
            columns: [
              { data: 'id', name: 'id' },
              { data: 'app_name', name: 'app_name' },
              { data: 'app_image', name: 'app_image', orderable: false, searchable: false },
              { data: 'app_type', name: 'app_type' },
              { data: 'click_button', name: 'click_button', orderable: false, searchable: false },
              { data: 'package_name', name: 'package_name' },
              { data: 'add_app_type', name: 'add_app_type' , orderable: false, searchable: false },
              { data: 'created_at_formatted', name: 'created_at' },
              { data: 'status', name: 'status' },
              { data: 'action', name: 'action', orderable: false, searchable: false },
              { data: 'status_update', name: 'status_update' }
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