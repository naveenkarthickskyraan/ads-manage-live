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
                          <h4 class="card-title text-dark">Edit App Form</h4>
                          <hr class="text-dark">
                          @foreach ($edit_app_id as $edit_app_id)
                          <form class="forms-sample" role="form" action="{{url('admin/edit_app_list/'.$edit_app_id->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row mb-3">
                              <label for="floatingInput" class="col-sm-3 col-form-label h2 text-dark" style="padding-left: 10px">App Name <span style="color:red;">&nbsp;*</span></label>
                              <div class="col-sm-9">
                                <div class="form-floating mb-3">
                                  <input type="text" class="form-control"  id="floatingInput" name="app_name" value="{{$edit_app_id->app_name}}" placeholder="name@example.com">
                                  <label for="floatingInput">App Name</label>
                                </div>
                              </div>
                            </div>

                            <div class="form-group row mb-3">
                              <div class="col-sm-3 d-flex aling-items-center">
                                <label for="select-alerts2" class=" col-form-label color-dark fs-14 fw-500 align-center">App Type <span style="color:red;">&nbsp;*</span></label>
                              </div>
                              <div class="col-sm-9">
                                <div class="select-style2">
                                  <div class="atbd-select">
                                      <select name="app_type" id="select-alerts2" class="form-control">
                                        <option class="text-dark" value="">Select a App Type *</option>
                                          <option class="text-dark" value="1" {{$edit_app_id->app_type == 1 ? 'selected':''}}>Android</option>
                                          <option class="text-dark" value="2" {{$edit_app_id->app_type == 2 ? 'selected':''}}>IOS </option>
                                      </select>
                                  </div>
                                </div>                                            
                              </div>
                            </div>
              
                            <div id="apple_id_id" class="form-group row mb-3">
                              <div class="col-sm-3 d-flex aling-items-center">
                                  <label for="apple_id" class=" col-form-label color-dark fs-14 fw-500 align-center">APPLE ID <span style="color:red;">&nbsp;*</span></label>
                              </div>
                              <div class="col-sm-9">
                                <div class="form-floating mb-3">
                                  <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="apple_id" value="{{$edit_app_id->apple_id}}" name="apple_id" placeholder="Enter the APPLE ID" autocomplete="off">
                                  <label for="apple_id">APPLE ID</label>
                                </div>
                              </div>
                            </div>
              
                            <div id="bundele_id_id" class="form-group row mb-3">
                              <div class="col-sm-3 d-flex aling-items-center">
                                  <label for="bundle_id" class=" col-form-label color-dark fs-14 fw-500 align-center">Bundle ID </label>
                              </div>
                              <div class="col-sm-9">
                                <div class="form-floating mb-3">
                                  <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="bundle_id" value="{{$edit_app_id->bundle_id}}" name="bundle_id" placeholder="Enter the Bundle ID" autocomplete="off">
                                  <label for="bundle_id">Bundle ID</label>
                                </div>
                              </div>
                            </div>
              
                            <div id="package_name_id" class="form-group row mb-3">
                              <div class="col-sm-3 d-flex aling-items-center">
                                  <label for="package_name" class=" col-form-label color-dark fs-14 fw-500 align-center">Package Name <span style="color:red;">&nbsp;*</span></label>
                              </div>
                              <div class="col-sm-9">
                                <div class="form-floating mb-3">
                                  <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="package_name" value="{{$edit_app_id->package_name}}" name="package_name" placeholder="Enter the Package Name" autocomplete="off">
                                  <label for="package_name">Package Name</label>
                                </div>
                              </div>
                            </div>
              
                            <div class="form-group row mb-4">
                              <label for="exampleInputUsername2" class="col-sm-3 col-form-label h2 text-dark" style="padding-left: 10px">App Icon Upload Type</label>
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
              
                            <div id='Normal_image_type_1' class="form-group row mb-3">
                              <label for="file" class="col-sm-3 col-form-label h2 text-dark" style="padding-left: 10px">App Icon Upload URL<span style="color:red;">&nbsp;*</span></label>
                              <div class="col-sm-9">
                                <input type="File" class="form-control" id="file" name="thumb_file" accept="image/*" placeholder="Choose File">
                              </div>
                            </div>
              
                            <div id="url_image_type_2" class="form-group row mb-3">
                              <label for="file_1" class="col-sm-3 col-form-label h2 text-dark" style="padding-left: 10px">App Icon URL<span style="color:red;">&nbsp;*</span></label>
                              <div class="col-sm-9">
                                <div class="form-floating mb-3">
                                  <input type="url" class="form-control" id="file_1" name="thumb_url_image" placeholder="Copy and past a URL" value="@if($edit_app_id->app_image_type == 2) {{$edit_app_id->app_image}} @endif">
                                  <label for="file_1">Image URL</label>
                                </div>
                              </div>
                            </div>

                            <style>
                              .ximage img{
                                  width: 85px;
                                  height: 85px;
                                  border-radius: 10px;
                                  box-shadow: 0px 0px 15px #405189;
                                  border:2px !important;
                                  opacity: 85%;
                                }
                            </style>
            
                            @if(!empty($edit_app_id->app_image))
                              <div class="form-group row mb-3 ximage">
                                <label for="file_1" class="col-sm-3 col-form-label h2 text-dark" style="padding-left: 10px">Image Preview<span style="color:red;">&nbsp;*</span></label>
                                <div class="col-md-9">
                                  @if($edit_app_id->app_image_type == 1)
                                    <a href="{{asset($edit_app_id->app_image)}}" target="_blank"><img src="{{asset($edit_app_id->app_image)}}" style="height:70px;width:auto;"/></a>
                                  @else
                                    <img src="{{$edit_app_id->app_image}}" style="height:70px;width:auto;">
                                  @endif
                                </div>
                              </div>
                            @endif

                            <div class="form-group row mb-4">
                              <div class="col-sm-3 d-flex aling-items-center">
                                <label for="book_reader_ad_format_type" class=" col-form-label h2 text-dark fw-bold">Book Reader Ad format Type <span style="color:red;">&nbsp;*</span></label>
                              </div>
                              <div class="col-sm-9">
                                <div class="select-style2">
                                  <div class="atbd-select">
                                      <select name="book_reader_ad_format_type" id="book_reader_ad_format_type" class="form-control">
                                        <option class="text-dark" value="">Select a App Type *</option>
                                          <option class="text-dark" value="1" {{ $edit_app_id->book_reader_ad_format_type == 1 ? "selected" : ""}}>Banner</option>
                                          <option class="text-dark" value="2" {{ $edit_app_id->book_reader_ad_format_type == 2 ? "selected" : ""}}>Intertial </option>
                                          <option class="text-dark" value="3"  {{ $edit_app_id->book_reader_ad_format_type == 3 || $edit_app_id->book_reader_ad_format_type == null ? "selected" : ""}}>Native Advance  </option>
                                      </select>
                                  </div>
                                </div>                                            
                              </div>
                            </div>
                            
                            <div class="form-group row mb-5">
                              <label for="book_reader_interval" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">Book Reader Interval count <span style="color:red;">&nbsp;*</span></label>
                              <div class="col-sm-9">
                                <input type="number" class="form-control" name="book_reader_interval" id="book_reader_interval" value="{{$edit_app_id->book_reader_interval ?? 0}}" placeholder="Enter the verse intervel number here.." min="0" max="15">
                              </div>
                            </div>
              
                            <div class="fload-end text-end">
                              <button type="submit" name="submit" class="btn btn-primary" id="susubmitbmit">Submit</button>
                              <button id="loading" class="btn btn-primary" type="button" disabled="" style="cursor: pointer;"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>
                              <a href="{{url('admin/app_list')}}" class="btn btn-dark" type="button">cancel</a>
              
                            </div>
                          </form>
                          @endforeach
                        </div>
                    </div>
                  </div>

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

  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

  <script>
    var thumb_image = {{$edit_app_id->app_image_type ?? 1}};
    test_check_thumb_image(thumb_image);
    function test_check_thumb_image(params)
    {
      if(params == "1")
      {
        $('#image_3').attr("checked",true);
        $('#image_4').attr("checked",false);
        $("#Normal_image_type_1").show()
        $('#url_image_type_2').hide();
      }
      else if(params == "2") 
      { 
        $('#image_4').attr("checked",true);
        $('#image_3').attr("checked",false);
        $("#Normal_image_type_1").hide()
        $('#url_image_type_2').show();
      }
    }
  </script>
  <script>
    var url_type = {{$edit_app_id->app_type}};
    test_check_video_url(url_type)
    function test_check_video_url(params)
    {
      if(params == 1)
      {
        $('#bundele_id_id').hide();
        $('#apple_id_id').hide();
        $('#app_store_id').hide();
        $('#play_store_id').show();
        $('#package_name_id').show();
      }
      else if(params == 2)
      {
        $('#bundele_id_id').show();
        $('#apple_id_id').show();
        $('#app_store_id').show();
        $('#play_store_id').hide();
        $('#package_name_id').hide();
      }
    }
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


  </body>
</html>

