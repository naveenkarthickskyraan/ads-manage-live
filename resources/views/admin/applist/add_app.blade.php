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
  {{-- <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet"> --}}
  {{-- <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet"> --}}



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
    
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      @endforeach
    </div>
    @endif
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card" style="background-color: #fff;">
          <div class="card-body">
            <h4 class="card-title text-dark">App Form</h4>
            <hr class="text-dark">
            <form class="forms-sample" action="{{url('admin/insert')}}" method="POST" role="form" enctype="multipart/form-data">
              @csrf
              <div class="form-group row mb-3">
                <label for="floatingInput" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">App Name <span style="color:red;">&nbsp;*</span></label>
                <div class="col-sm-9">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control"  id="floatingInput" name="app_name" placeholder="name@example.com" value="{{old('app_name')}}">
                    <label for="floatingInput">App Name</label>
                  </div>
                </div>
              </div>

              <div class="form-group row mb-4">
                <div class="col-sm-3 d-flex aling-items-center">
                  <label for="select-alerts2" class="  col-form-label h2 text-dark fw-bold">App Type <span style="color:red;">&nbsp;*</span></label>
                </div>
                <div class="col-sm-9">
                  <div class="select-style2">
                    <div class="atbd-select">
                        <select name="app_type" id="select-alerts2" class="form-control">
                          <option class="text-dark" value="">Select a App Type *</option>
                            <option class="text-dark" value="1">Android</option>
                            <option class="text-dark" value="2">IOS </option>
                        </select>
                    </div>
                  </div>                                            
                </div>
              </div>

              <div id="apple_id_id" class="form-group row mb-4">
                <div class="col-sm-3 d-flex aling-items-center">
                    <label for="apple_id" class="  col-form-label h2 text-dark fw-bold">APPLE ID <span style="color:red;">&nbsp;*</span></label>
                </div>
                <div class="col-sm-9">
                  <div class="form-floating mb-4">
                    <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="apple_id" value="{{old('apple_id')}}" name="apple_id" placeholder="Enter the APPLE ID" autocomplete="off">
                    <label for="apple_id">APPLE ID</label>
                  </div>
                </div>
              </div>

              <div id="bundele_id_id" class="form-group row mb-4">
                <div class="col-sm-3 d-flex aling-items-center">
                    <label for="bundle_id" class="  col-form-label h2 text-dark fw-bold">Bundle ID </label>
                </div>
                <div class="col-sm-9">
                  <div class="form-floating mb-4">
                    <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="bundle_id" value="{{old('bundle_id')}}" name="bundle_id" placeholder="Enter the Bundle ID" autocomplete="off">
                    <label for="bundle_id">Bundle ID</label>
                  </div>
                </div>
              </div>

              <div id="package_name_id" class="form-group row mb-4">
                <div class="col-sm-3 d-flex aling-items-center">
                    <label for="package_name" class=" col-form-label h2 text-dark fw-bold">Package Name <span style="color:red;">&nbsp;*</span></label>
                </div>
                <div class="col-sm-9">
                  <div class="form-floating mb-4">
                    <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="package_name" value="{{old('package_name')}}" name="package_name" placeholder="Enter the Package Name" autocomplete="off">
                    <label for="package_name">Package Name</label>
                  </div>
                </div>
              </div>

              <div class="form-group row mb-4">
                <label for="exampleInputUsername2" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">App Icon Upload Type</label>
                <div class="col-sm-9">
                  <div class="form-check-inline h5 text-dark">
                    <input class="form-check-input" type="radio" name="thumb_upload_type" id="image_3" value='1' checked style="font-size:1.00rem;align-items:center;">
                    <label class="form-check-label" for="image_3" style="font-size: 1.00rem;">
                      Image Type
                    </label>
                  </div>
                  <div class="form-check-inline h5 text-dark">
                    <input class="form-check-input" type="radio" name="thumb_upload_type" id="image_4" value='2'style="font-size:1.00rem;align-items:center;" >
                    <label class="form-check-label" for="image_4" style="font-size: 1.00rem;">
                      URL Type
                    </label>
                  </div> 
                </div>
              </div>

              <div id='Normal_image_type_1' class="form-group row mb-4">
                <label for="file" class="col-sm-3  col-form-label h2 text-dark fw-bold" style="padding-left: 10px">App Icon Upload URL<span style="color:red;">&nbsp;*</span></label>
                <div class="col-sm-9">
                  <input type="File" class="form-control" id="file" name="thumb_file" accept="image/*" placeholder="Choose File">
                </div>
              </div>

              <div id="url_image_type_2" class="form-group row mb-4">
                <label for="file_1" class="col-sm-3  col-form-label h2 text-dark fw-bold" style="padding-left: 10px">App Icon URL<span style="color:red;">&nbsp;*</span></label>
                <div class="col-sm-9">
                  <div class="form-floating mb-4">
                    <input type="url" class="form-control" id="file_1" name="thumb_url_image" placeholder="Copy and past a URL" value="{{old('thumb_url_image')}}">
                    <label for="file_1">Image URL</label>
                  </div>
                </div>
              </div>

              <div class="form-group row mb-4">
                <div class="col-sm-3 d-flex aling-items-center">
                  <label for="book_reader_ad_format_type" class=" col-form-label h2 text-dark fw-bold">Book Reader Ad format Type <span style="color:red;">&nbsp;*</span></label>
                </div>
                <div class="col-sm-9">
                  <div class="select-style2">
                    <div class="atbd-select">
                        <select name="book_reader_ad_format_type" id="book_reader_ad_format_type" class="form-control">
                          <option class="text-dark" value="">Select a App Type *</option>
                            <option class="text-dark" value="1">Banner</option>
                            <option class="text-dark" value="2">Intertial </option>
                            <option class="text-dark" value="3" selected>Native Advance  </option>
                        </select>
                    </div>
                  </div>                                            
                </div>
              </div>
              
              <div class="form-group row mb-5">
                <label for="book_reader_interval" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">Auto Ads load Duration <span style="color:red;">&nbsp;*</span></label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" name="book_reader_interval" id="book_reader_interval" value="{{old('book_reader_interval') ?? 0}}" placeholder="Enter the verse intervel number here.." min="0" max="15">
                </div>
              </div>

              <div class="fload-end text-end">
                <button type="submit" name="submit" class="btn btn-primary" id="susubmitbmit">Submit</button>
                <button id="loading" class="btn btn-primary" type="button" disabled="" style="cursor: pointer;"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>
                <a href="{{url('admin/app_list')}}" class="btn btn-dark" type="button">cancel</a>

              </div>
            </form>
          </div>
      </div>
      </div>
    </div>

    </main><!-- End #main -->

                <!-- ======= Footer ======= -->
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

  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  
  <script>
    if($('#image_3').is(':checked'))
    {
      $("#Normal_image_type_1").show()
      $('#url_image_type_2').hide();
    }

    $('#image_3').bind('change', function () {
      if ($(this).is(':checked'))
        $("#Normal_image_type_1").show().removeAttr('checked',true)
        $('#url_image_type_2').hide();
    });
    
    $("#image_4").bind('change', function(){
      if ($(this).is(':checked'))
        $("#Normal_image_type_1").hide();
        $('#url_image_type_2').show().attr('checked',true);
    });
  </script>
  <script>
    $('#bundele_id_id').hide();
    $('#apple_id_id').hide();
    $('#app_store_id').hide();
    $('#play_store_id').hide();
    $('#package_name_id').hide();

    $('#select-alerts2').on('change',function() {
        let id = $('#select-alerts2').val();
        if(id == 2)
        {
          $('#bundele_id_id').show();
          $('#apple_id_id').show();
          $('#app_store_id').show();
          $('#play_store_id').hide();
          $('#package_name_id').hide();
        }
        if(id == 1)
        {
          $('#bundele_id_id').hide();
          $('#apple_id_id').hide();
          $('#app_store_id').hide();
          $('#play_store_id').show();
          $('#package_name_id').show();
        }

    });

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
  <script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
        });
    });
  </script>

  <script>
    $('#loading').hide();
    $('#susubmitbmit').on('click',function(){
      $('#loading').show();
      $('#susubmitbmit').hide();
    });
  </script>

</body>

</html>

{{-- @else --}}
{{-- abort(403, 'Unauthorized action.'); --}}
{{-- @endif --}}


