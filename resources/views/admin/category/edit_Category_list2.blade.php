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
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.0.96/css/materialdesignicons.min.css">
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
          <li class="breadcrumb-item"><a href="{{url('admin/ad_manager_list')}}">Ads Manager List</a></li>
          <li class="breadcrumb-item active">List of Ads Manager Table</li>
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
              <div class="card"  style="background-color: #fff;">
                <div class="card-body">
                  <h4 class="card-title text-dark">Edit Ads Manager Form</h4>
                  <hr class="text-dark">
                  @foreach ($edit_category_id as $edit_category_id)
                  <form class="forms-sample" action="{{url('admin/edit_ad_manager_list/'.$edit_category_id->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row mb-3">
                      <label for="app_id" class="col-sm-3 col-form-label h2 text-dark" style="padding-left: 10px">App <span style="color:red;">&nbsp;*</span></label>
                      <div class="col-sm-9">
                        <select class="js-example-basic-single form-select form-select-white mb-3 text-dark bg-outline-dark border-3 select2" name="app_id" id="app_id" style="width:100%" >
                            <optgroup label="Selected Apps">
                              <option id="font" class="text-dark" value="{{$edit_category_id->app_id}}" selected>{{$edit_category_id->AppList->app_name}} - {{$edit_category_id->AppList->app_type == 1 ? 'Android':'IOS'}} - {{$edit_category_id->AppList->app_type == 1 ? $edit_category_id->AppList->package_name:$edit_category_id->AppList->apple_id}}</option> 
                            </optgroup>
                            <optgroup label="Available Apps">
                              @foreach($apps as $category)
                                @if($category->id !== $edit_category_id->AppList->id)
                                <option class="text-dark" value="{{$category->id}}">{{$category->app_name}} - {{$category->app_type == 1 ? 'Android':'IOS'}} - {{$category->app_type == 1 ? $category->package_name:$category->apple_id}}</option>
                                  @endif  
                              @endforeach
                            </optgroup>
                        </select>
                      </div>
                    </div>

                    <div class="form-group row mb-3">
                      <div class="col-sm-3 d-flex aling-items-center">
                          <label for="ad_app_id" class=" col-form-label color-dark fs-14 fw-500 align-center">Ad App ID </label>
                      </div>
                      <div class="col-sm-9">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="ad_app_id" value="{{$edit_category_id->ad_app_id}}" name="ad_app_id" placeholder="Enter the Ad App ID Video" autocomplete="off">
                          <label for="ad_app_id" style="color:rgb(174, 153, 153)">Ad App ID</label>
                        </div>
                      </div>
                    </div>
    
    
                    <div class="form-group row mb-3">
                      <div class="col-sm-3 d-flex aling-items-center">
                          <label for="app_open_id" class=" col-form-label color-dark fs-14 fw-500 align-center">App Open ID </label>
                      </div>
                      <div class="col-sm-9">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="app_open_id" value="{{$edit_category_id->app_open_id}}" name="app_open_id" placeholder="Enter the App Open ID Video" autocomplete="off">
                          <label for="app_open_id" style="color:rgb(174, 153, 153)">App Open ID</label>
                        </div>
                      </div>
                    </div>

                    @php 
                      $explode_1 = array_diff(explode(',',$edit_category_id->multiple_banner_id),[null]);
                      $multiple_banner_id = old('multiple_banner_id');
                      if(isset($multiple_banner_id))
                      {
                        $array_14 = array_diff($multiple_banner_id,$explode_1);
                      }
                      $count_1 = count($explode_1);

                    @endphp
                    <div class="form-group row mb-3">
                      <div class="col-sm-3 d-flex aling-items-center">
                          <label for="banner_id" class=" col-form-label color-dark fs-14 fw-500 align-center">Banner ID </label>
                      </div>
                      <div class="col-sm-9">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="banner_id" value="{{$edit_category_id->ad_banner_id}}"  name="banner_id" placeholder="Enter the Banner ID" autocomplete="off">
                          <label for="banner_id">Banner ID</label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-sm-3 d-flex aling-items-center">
                          <label for="banner_id" class=" col-form-label color-dark fs-14 fw-500 align-center">Multiple Banner ID </label>
                      </div>
                      <div class="col-sm-9">
                        <table class="table table-bordered" id="dynamicAddRemove">  
                          <tr>
                              <th>Multiple Banner ID</th>
                              <th>Action</th>
                          </tr>
                          <tr>  
                              <td><input type="text" name="multiple_banner_id[]" value='{{$explode_1[0]}}' placeholder="Enter Multiple Banner" class="form-control" /></td>
                              <td><button type="button" name="add" id="add-btn" class="btn btn-success"><i class="mdi mdi-plus"></i></button></td>
                          </tr>  
                          @foreach($explode_1 as $row_1)
                            @if($explode_1[0] != $row_1)
                              <tr>
                                <td>
                                  <input type="text" name="multiple_banner_id[]" value="{{$row_1}}" placeholder="Enter multiple_banner_id" class="form-control" />
                                </td>
                                <td>
                                  <button type="button" class="btn btn-danger remove-tr"><i class="mdi mdi-trash-can"></i></button>
                                </td>
                              </tr>
                            @endif
                          @endforeach
                          @if(isset($array_14))
                            @foreach($array_14 as $key => $field)
                            <tr>
                              <td>
                                <input type="text" name="multiple_banner_id[]" value="{{old('multiple_banner_id.'.(int) $key)}}" placeholder="Enter multiple_banner_id" class="form-control  @error('multiple_banner_id.'.(int) $key) is-invalid @enderror"/>
                              </td>
                              <td>
                                <button type="button" class="btn btn-danger remove-tr"><i class="mdi mdi-trash-can"></i></button>
                              </td>
                            </tr>
                            @endforeach
                          @endif
                        </table>
                          <button type="button" class="btn btn-success add-tr"><i class="mdi mdi-plus"></i></button>
                      </div>
                    </div>

                    @php 
                      $explode = array_diff(explode(',',$edit_category_id->multiple_interstitial_id),[null]);
                      $multiple_interstitial_id = old('multiple_interstitial_id');
                      if(isset($multiple_interstitial_id))
                      {
                        $array_13 = array_diff($multiple_interstitial_id,$explode);
                      }
                      $count = count($explode);
                     @endphp
                    <div class="form-group row mb-3">
                      <div class="col-sm-3 d-flex aling-items-center">
                          <label for="interstitial_id" class=" col-form-label color-dark fs-14 fw-500 align-center">Interstitial ID </label>
                      </div>
                      <div class="col-sm-9">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="interstitial_id" value="{{$edit_category_id->ad_intercial_id}}" name="interstitial_id" placeholder="Enter the Interstitial ID" autocomplete="off">
                          <label for="interstitial_id">Interstitial ID</label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-sm-3 d-flex aling-items-center">
                          <label for="banner_id" class=" col-form-label color-dark fs-14 fw-500 align-center">Multiple Interstitial ID ID </label>
                      </div>
                      <div class="col-sm-9">
                        <table class="table table-bordered" id="dynamicAddRemove_1">  
                          <tr>
                              <th>Multiple Interstitial ID</th>
                              <th>Action</th>
                          </tr>
                          <tr>  
                              <td><input type="text" name="multiple_interstitial_id[]" value='{{$explode[0]}}' placeholder="Enter Multiple Interstitial ID" class="form-control" /></td>
                              <td><button type="button" name="add" id="add-btn-1" class="btn btn-success"><i class="mdi mdi-plus"></i></button></td>
                          </tr>  
                          @foreach($explode as $row_1)
                            @if($explode[0] != $row_1)
                              <tr>
                                <td>
                                  <input type="text" name="multiple_interstitial_id[]" value="{{$row_1}}" placeholder="Enter Multiple Interstitial ID" class="form-control" />
                                </td>
                                <td>
                                  <button type="button" class="btn btn-danger remove-tr-1"><i class="mdi mdi-trash-can"></i></button>
                                </td>
                              </tr>
                            @endif
                          @endforeach
                          @if(isset($array_13))
                            @foreach($array_13 as $key => $field)
                            <tr>
                              <td>
                                <input type="text" name="multiple_interstitial_id[]" value="{{old('multiple_interstitial_id.'.(int) $key)}}" placeholder="Enter Multiple Interstitial ID" class="form-control  @error('multiple_interstitial_id.'.(int) $key) is-invalid @enderror"/>
                              </td>
                              <td>
                                <button type="button" class="btn btn-danger remove-tr-1"><i class="mdi mdi-trash-can"></i></button>
                              </td>
                            </tr>
                            @endforeach
                          @endif
                        </table>
                          <button type="button" class="btn btn-success add-tr-1"><i class="mdi mdi-plus"></i></button>
                      </div>
                    </div>


                    @php 
                    $explode_2 = array_diff(explode(',',$edit_category_id->multiple_advanced_id),[null]);
                    $multiple_native_advanced_id = old('multiple_native_advanced_id');
                    if(isset($multiple_native_advanced_id))
                    {
                      $array_12 = array_diff($multiple_native_advanced_id,$explode_2);
                    }
                    $count_2 = count($explode_2);
                  @endphp

                  <div class="form-group row mb-3">
                    <div class="col-sm-3 d-flex aling-items-center">
                        <label for="native_advanced_id" class=" col-form-label color-dark fs-14 fw-500 align-center">Native Advanced ID </label>
                    </div>
                    <div class="col-sm-9">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="native_advanced_id" value="{{$edit_category_id->ad_native_advanced}}" name="native_advanced_id" placeholder="Enter the Native Advanced ID" autocomplete="off">
                        <label for="native_advanced_id">Native Advanced ID</label>
                      </div>
                    </div>
                  </div>
  
                  <div class="form-group row mb-3">
                    <div class="col-sm-3 d-flex aling-items-center">
                        <label for="banner_id" class=" col-form-label color-dark fs-14 fw-500 align-center">Multiple Native Advanced ID </label>
                    </div>
                    <div class="col-sm-9">
                      <table class="table table-bordered" id="dynamicAddRemove-2">  
                        <tr>
                            <th>Multiple Native Advanced ID</th>
                            <th>Action</th>
                        </tr>
                        <tr>  
                            <td><input type="text" name="multiple_native_advanced_id[]" value='{{$explode_2[0]}}' placeholder="Enter Multiple Native Advanced ID" class="form-control" /></td>
                            <td><button type="button" name="add" id="add-btn-2" class="btn btn-success"><i class="mdi mdi-plus"></i></button></td>
                        </tr>  
                        @foreach($explode_2 as $row_1)
                          @if($explode_2[0] != $row_1)
                            <tr>
                              <td>
                                <input type="text" name="multiple_native_advanced_id[]" value="{{$row_1}}" placeholder="Enter Multiple Native Advanced ID" class="form-control" />
                              </td>
                              <td>
                                <button type="button" class="btn btn-danger remove-tr-2"><i class="mdi mdi-trash-can"></i></button>
                              </td>
                            </tr>
                          @endif
                        @endforeach
                        @if(isset($array_12))
                          @foreach($array_12 as $key => $field)
                          <tr>
                            <td>
                              <input type="text" name="multiple_native_advanced_id[]" value="{{old('multiple_native_advanced_id.'.(int) $key)}}" placeholder="Enter Multiple Native Advanced ID" class="form-control  @error('multiple_native_advanced_id.'.(int) $key) is-invalid @enderror"/>
                            </td>
                            <td>
                              <button type="button" class="btn btn-danger remove-tr-2"><i class="mdi mdi-trash-can"></i></button>
                            </td>
                          </tr>
                          @endforeach
                        @endif
                      </table>
                        <button type="button" class="btn btn-success add-tr-2"><i class="mdi mdi-plus"></i></button>
                    </div>
                  </div>
                    
                    
                    <button type="submit" name="submit" class="btn btn-primary" id="susubmitbmit">Submit</button>
                    <button id="loading" class="btn btn-primary" type="button" disabled=""><span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Loading...</button>
                    <a href="{{url('admin/ad_manager_list')}}" class="btn btn-dark" type="button">cancel</a>
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

  <script type="text/javascript">
    $('.add-tr').hide();
    var i = 0;
    $("#add-btn").click(function(){
      ++i;
      $('.add-tr').show();
      $("#dynamicAddRemove").append('<tr><td><input type="text" name="multiple_banner_id[]" placeholder="Enter Multiple Banner ID" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr"><i class="mdi mdi-trash-can"></i></button></td></tr>');
    });
    $(document).on('click', '.remove-tr', function(){  
      $(this).parents('tr').remove();
    });
    $(document).on('click', '.add-tr', function(){
        ++i;
        $("#dynamicAddRemove").append('<tr><td><input type="text" name="multiple_banner_id[]" placeholder="Enter Multiple Banner ID" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr"><i class="mdi mdi-trash-can"></i></button></td></tr>');
    });
  </script>

  <script type="text/javascript">
    $('.add-tr-1').hide();
    var i = 0;
    $("#add-btn-1").click(function(){
      ++i;
      $('.add-tr-1').show();
      $("#dynamicAddRemove_1").append('<tr><td><input type="text" name="multiple_interstitial_id[]" placeholder="Enter Multiple Interstitial ID" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr-1"><i class="mdi mdi-trash-can"></i></button></td></tr>');
    });
    $(document).on('click', '.remove-tr-1', function(){  
      $(this).parents('tr').remove();
    });
    $(document).on('click', '.add-tr-1', function(){
        ++i;
        $("#dynamicAddRemove_1").append('<tr><td><input type="text" name="multiple_interstitial_id[]" placeholder="Enter Multiple Interstitial ID" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr-1"><i class="mdi mdi-trash-can"></i></button></td></tr>');
    });
  </script>

  <script type="text/javascript">
    $('.add-tr-2').hide();
    var i = 0;
    $("#add-btn-2").click(function(){
      ++i;
      $('.add-tr-2').show();
      $("#dynamicAddRemove-2").append('<tr><td><input type="text" name="multiple_native_advanced_id[]" placeholder="Enter Multiple Native Advanced ID" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr-2"><i class="mdi mdi-trash-can"></i></button></td></tr>');
    });
    $(document).on('click', '.remove-tr-2', function(){  
      $(this).parents('tr').remove();
    });
    $(document).on('click', '.add-tr-2', function(){
        ++i;
        $("#dynamicAddRemove-2").append('<tr><td><input type="text" name="multiple_native_advanced_id[]" placeholder="Enter Multiple Native Advanced ID" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr-2"><i class="mdi mdi-trash-can"></i></button></td></tr>');
    });
  </script>

  
  <script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
        });
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
    $('#loading').hide();
    $('#susubmitbmit').on('click',function(){
      $('#loading').show();
      $('#susubmitbmit').hide();
    });
  </script>

</body>

</html>
