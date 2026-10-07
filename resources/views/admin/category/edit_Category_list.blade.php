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
                      <label for="app_id" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">App <span style="color:red;">&nbsp;*</span></label>
                      <div class="col-sm-9">
                        <select class="js-example-basic-single form-select form-select-white mb-3 text-dark bg-outline-dark border-3 select2" name="app_id" id="app_id" style="width:100%" >
                            <optgroup label="Selected Apps">
                              <option id="font" class="text-dark" value="{{$edit_category_id->app_id}}" selected>{{$edit_category_id->AppList->app_name}} - {{$edit_category_id->AppList->app_type == 1 ? 'Android':'IOS'}} - {{$edit_category_id->AppList->app_type == 1 ? $edit_category_id->AppList->package_name:$edit_category_id->AppList->apple_id}}</option> 
                            </optgroup>
                            <optgroup label="Available Apps">
                                @foreach($apps as $category)
                                    @if($category->id !== $edit_category_id->AppList->id)
                                        <option class="text-dark" value="{{$category->id}}" disabled>{{$category->app_name}} - {{$category->app_type == 1 ? 'Android':'IOS'}} - {{$category->app_type == 1 ? $category->package_name:$category->apple_id}}</option>
                                    @endif  
                              @endforeach
                            </optgroup>
                        </select>
                      </div>
                    </div>
                        

                    <div class="form-group row mb-3">
                      <label for="ad_app_type" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">App Type <span style="color:red;">&nbsp;*</span></label>
                      <div class="col-sm-9">
                        <select class="form-select form-select-white mb-3 text-dark bg-outline-dark border-3 select2" name="ad_app_type" id="ad_app_type" style="width:100%" onchange="ad_app_typess()">
                            <option class="text-dark" value="">Select a Ad App Type *</option>
                            <option class="text-dark" value="1" data-icon="fa-google" {{$edit_category_id->ad_app_type == 1 ? 'selected':''}} {{$edit_category_id->ad_app_type == 2 || $edit_category_id->ad_app_type == 3 ? 'disabled':''}} >Google Ad</option>
                            <option class="text-dark" value="2" data-icon="fa-facebook" {{$edit_category_id->ad_app_type == 2 ? 'selected':''}} {{$edit_category_id->ad_app_type == 1 || $edit_category_id->ad_app_type == 3 ? 'disabled':''}}>Facebook Ad</option>
                            <option class="text-dark" value="3" data-icon="fa-unity" {{$edit_category_id->ad_app_type == 3 ? 'selected':''}} {{$edit_category_id->ad_app_type == 1 || $edit_category_id->ad_app_type == 2 ? 'disabled':''}}>Unity Ad</option>
                          {{-- <option class="text-dark" value="0" data-icon="fa-ban" {{$edit_category_id->ad_app_type == 0 ? 'selected':''}}  >Disable Ad</option> --}}
                        </select>
                      </div>
                    </div>
                      

                    <div class="form-group row mb-3">
                      <div class="col-sm-3 d-flex aling-items-center">
                          <label for="ad_app_id" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Ad App ID </label>
                      </div>
                      <div class="col-sm-9">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="ad_app_id" value="{{$edit_category_id->ad_app_id}}" name="ad_app_id" placeholder="Enter the Ad App ID Video" autocomplete="off">
                          <label for="ad_app_id" style="color:rgb(174, 153, 153)">Ad App ID</label>
                        </div>
                      </div>
                    </div>
    
    
                    <div id="google_open_id"  class="form-group row mb-3">
                      <div class="col-sm-3 d-flex aling-items-center">
                          <label for="app_open_id" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">App Open ID </label>
                      </div>
                      <div class="col-sm-9">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="app_open_id" value="{{$edit_category_id->app_open_id}}" name="app_open_id" placeholder="Enter the App Open ID Video" autocomplete="off">
                          <label for="app_open_id" style="color:rgb(174, 153, 153)">App Open ID</label>
                        </div>
                      </div>
                    </div>

                    

                    <div id="facebook_open_id" style="display:none;">                
                      <div class="form-group row mb-3">
                        <div class="col-sm-3 d-flex aling-items-center">
                            <label for="meadium_rectangle" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Medium Rectangle ID</label>
                        </div>
                        <div class="col-sm-9">
                          <div class="form-floating mb-3">
                            <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="meadium_rectangle" value="{{$edit_category_id->ad_meadium_rectangle_id}}" name="meadium_rectangle" placeholder="Enter the Banner ID" autocomplete="off">
                            <label for="meadium_rectangle" style="color:rgb(174, 153, 153)">Medium Rectangle</label>
                          </div>
                        </div>
                      </div>
                        
                      @php
                        $explode_ss = array_diff(explode(',',$edit_category_id->multiple_medium_rectangle_id),[null]);
                        $multiple_medium_rectangle_id = old('multiple_medium_rectangle_id');
                        if(isset($multiple_medium_rectangle_id))
                        {
                          $array_15 = array_diff($multiple_medium_rectangle_id,$explode_ss);
                        }
                        $count_1 = count($explode_ss);
                      @endphp


                      <div class="form-group row mb-3">
                        <div class="col-sm-3 d-flex aling-items-center">
                            <label for="banner_id" class="col-form-label color-dark fs-14 fw-500 align-center fw-bold">Multiple Medium Rectangle ID </label>
                        </div>
                        <div class="col-sm-9">
                            <table class="table table-bordered" id="dynamicAddRemove-3">
                                <tr>
                                    <th>Multiple Medium Rectangle ID</th>
                                    <th>Action</th>
                                </tr>
                                @if(isset($explode_ss) && count($explode_ss) > 0)
                                    <tr>
                                        <td><input type="text" name="multiple_medium_rectangle_id[]" value='{{$explode_ss[0]}}' placeholder="Enter Multiple Medium Rectangle" class="form-control" /></td>
                                        <td><button type="button" name="add" id="add-btn-3" class="btn btn-success"><i class="mdi mdi-plus"></i></button></td>
                                    </tr>
                                    @foreach($explode_ss as $row_1)
                                        @if($explode_ss[0] != $row_1)
                                            <tr>
                                                <td>
                                                    <input type="text" name="multiple_medium_rectangle_id[]" value="{{$row_1}}" placeholder="Enter multiple_medium_rectangle_id" class="form-control" />
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger remove-tr-3"><i class="mdi mdi-trash-can"></i></button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                  <tr>
                                      <td><input type="text" name="multiple_medium_rectangle_id[]" value="" placeholder="Enter Multiple Medium Rectangle" class="form-control" /></td>
                                      <td><button type="button" name="add" id="add-btn-3" class="btn btn-success"><i class="mdi mdi-plus"></i></button></td>
                                  </tr>
                                @endif
                                @if(isset($array_15))
                                    @foreach($array_15 as $key => $field)
                                        <tr>
                                            <td>
                                                <input type="text" name="multiple_medium_rectangle_id[]" value="{{old('multiple_medium_rectangle_id.'.(int) $key)}}" placeholder="Enter multiple_medium_rectangle_id" class="form-control  @error('multiple_medium_rectangle_id.'.(int) $key) is-invalid @enderror"/>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger remove-tr-3"><i class="mdi mdi-trash-can"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                            <button type="button" class="btn btn-success add-tr-3"><i class="mdi mdi-plus"></i></button>
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
                          <label for="banner_id" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Banner ID </label>
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
                          <label for="banner_id" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Multiple Banner ID </label>
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
                   {{-- naveen --}}
                    <div class="form-group row mb-3">
                        <div class="col-sm-3 d-flex aling-items-center">
                            <label for="audio_banner_id"
                                class="col-form-label color-dark fs-14 fw-500 align-center fw-bold">
                                Audio Banner ID
                            </label>
                        </div>

                        <div class="col-sm-9">
                            <div class="form-floating mb-3">
                                <input type="text"
                                      class="form-control ih-medium ip-light radius-xs b-light px-15"
                                      id="audio_banner_id"
                                      name="audio_banner_id"
                                      value="{{ old('audio_banner_id', $edit_category_id->audio_banner_id ?? '') }}"
                                      placeholder="Enter Audio Banner ID"
                                      autocomplete="off">

                                <label for="audio_banner_id" style="color:rgb(174, 153, 153)">
                                    Audio Banner ID
                                </label>
                            </div>
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
                          <label for="interstitial_id" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Interstitial ID </label>
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
                          <label for="banner_id" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Multiple Interstitial ID</label>
                      </div>
                      <div class="col-sm-9">
                        <table class="table table-bordered" id="dynamicAddRemove_1">  
                          <tr>
                              <th>Multiple Interstitial ID</th>
                              <th>Action</th>
                          </tr>
                          <tr>  
                              <td><input type="text" name="multiple_interstitial_id[]" value="{{ $explode[0] ?? '' }}" placeholder="Enter Multiple Interstitial ID" class="form-control" /></td>
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
                  {{-- naveen --}}
                  <div class="form-group row mb-3">
                      <div class="col-sm-3 d-flex aling-items-center">
                          <label for="audio_interstitial_id"
                              class="col-form-label color-dark fs-14 fw-500 align-center fw-bold">
                              Audio Interstitial ID
                          </label>
                      </div>

                      <div class="col-sm-9">
                          <div class="form-floating mb-3">
                              <input type="text"
                                    class="form-control ih-medium ip-light radius-xs b-light px-15"
                                    id="audio_interstitial_id"
                                    name="audio_interstitial_id"
                                    value="{{ old('audio_interstitial_id', $edit_category_id->audio_interstitial_id ?? '') }}"
                                    placeholder="Enter Audio Interstitial ID"
                                    autocomplete="off">

                              <label for="audio_interstitial_id" style="color:rgb(174, 153, 153)">
                                  Audio Interstitial ID
                              </label>
                          </div>
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
                        <label for="native_advanced_id" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Native Advanced ID </label>
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
                        <label for="banner_id" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Multiple Native Advanced ID </label>
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
    
                    <div class="form-group row mb-3">
                      <div class="col-sm-3 d-flex aling-items-center">
                          <label for="ad_rewards" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Ad Rewards </label>
                      </div>
                      <div class="col-sm-9">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="ad_rewards" value="{{$edit_category_id->ad_rewards}}" name="ad_rewards" placeholder="Enter the Ad Rewards" autocomplete="off">
                          <label for="ad_rewards">Ad Rewards</label>
                        </div>
                      </div>
                    </div>
    
                    <div class="form-group row mb-3">
                      <div class="col-sm-3 d-flex aling-items-center">
                          <label for="rewarded_interstitial" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Rewarded Interstitial </label>
                      </div>
                      <div class="col-sm-9">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="rewarded_interstitial"  value="{{$edit_category_id->ad_rewarded_intencial}}" name="rewarded_interstitial" placeholder="Enter the Rewarded Interstitial" autocomplete="off">
                          <label for="rewarded_interstitial">Rewarded Interstitial</label>
                        </div>
                      </div>
                    </div>
    
                    <div class="form-group row mb-3">
                      <div class="col-sm-3 d-flex aling-items-center">
                          <label for="interstitial_video" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Interstitial Video </label>
                      </div>
                      <div class="col-sm-9">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="interstitial_video" value="{{$edit_category_id->ad_intencial_video}}" name="interstitial_video" placeholder="Enter the Interstitial Video" autocomplete="off">
                          <label for="interstitial_video">Interstitial Video</label>
                        </div>
                      </div>
                    </div>
    
                    <div class="form-group row mb-3">
                      <div class="col-sm-3 d-flex aling-items-center">
                          <label for="native_advance_video" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Native Advanced Video </label>
                      </div>
                      <div class="col-sm-9">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="native_advance_video" value="{{$edit_category_id->ad_native_advanced_video}}" name="native_advance_video" placeholder="Enter the Native Advanced Video" autocomplete="off">
                          <label for="native_advance_video">Native Advanced Video</label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row mb-3">
                      <label for="is_show_ads_biblereading_screen" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">Show ads on the Bible reading screen  <span style="color:red;">&nbsp;*</span></label>
                      <div class="col-sm-9">
                        <select class="form-select form-select-white mb-3 text-dark bg-outline-dark border-3 select2" name="is_show_ads_biblereading_screen" id="is_show_ads_biblereading_screen" style="width:100%">
                          <option class="text-dark" value="">Select a Show ads on the Bible reading screen *</option>
                          <option class="text-dark" {{$edit_category_id->is_show_ads_biblereadingscreen == 1 ? "Selected":""}} value="1">Yes</option>
                          <option class="text-dark" {{$edit_category_id->is_show_ads_biblereadingscreen == 0 ? "Selected":""}} value="0">No</option>
                        </select>
                      </div>
                    </div>

                    
                    <div class="form-group row mb-3">
                      <label for="biblereadingscreen_ads_verse_interval" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">biblereading screen ads verse interval   <span style="color:red;">&nbsp;*</span></label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" name="biblereadingscreen_ads_verse_interval" id="biblereadingscreen_ads_verse_interval" value="{{$edit_category_id->biblereadingscreen_ads_verse_interval}}" placeholder="Enter the verse intervel number here..">
                      </div>
                    </div>
                
                    <div class="form-group row mb-3">
                      <label for="auto_ads_load" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">Auto ads load Enable or Disable <span style="color:red;">&nbsp;*</span></label>
                      <div class="col-sm-9">
                        <select class="form-select form-select-white mb-3 text-dark bg-outline-dark border-3 select2" name="auto_ads_load" id="auto_ads_load" style="width:100%">
                          <option class="text-dark" value="">Select a Auto ads load Enable or Disable *</option>
                          <option class="text-dark" {{$edit_category_id->auto_ads_load == 1 ? "Selected":""}} value="1">Yes</option>
                          <option class="text-dark" {{$edit_category_id->auto_ads_load == 0 ? "Selected":""}} value="0">No</option>
                        </select>
                      </div>
                    </div>

                    
                    <div class="form-group row mb-3">
                      <label for="auto_ads_load_duration" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">Auto Ads load Duration <span style="color:red;">&nbsp;*</span></label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" name="auto_ads_load_duration" id="auto_ads_load_duration" value="{{$edit_category_id->auto_ads_load_duration}}" placeholder="Enter the verse intervel number here.." min="5" max="15">
                      </div>
                    </div>


                    <div class="row mb-4">
                      <label for="adBanner" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">Ads Enable Or Disable<span style="color:red;">&nbsp;*</span></label>
                      
                      <div class="col-md-9">
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" {{$edit_category_id->adBanner == 1 ? "checked":""}} value="1" id="adBanner" name="adBanner">
                            <label class="form-check-label" for="adBanner">Ad Banner</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" {{$edit_category_id->multipleAdBanner == 1 ? "checked":""}} value="1" id="multipleAdBanner" name="multipleAdBanner">
                            <label class="form-check-label" for="multipleAdBanner">Multiple AdBanner</label>
                          </div>
                          <br>
                  
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" {{$edit_category_id->interstitial == 1 ? "checked":""}} value="1" id="interstitial" name="interstitial">
                            <label class="form-check-label" for="interstitial">Interstitial</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" {{$edit_category_id->multipleInterstitial == 1 ? "checked":""}} value="1" id="multipleInterstitial" name="multipleInterstitial">
                            <label class="form-check-label" for="multipleInterstitial">Multiple Interstitial</label>
                          </div>
                          <br>
                        
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" {{$edit_category_id->native == 1 ? "checked":""}} value="1" id="native" name="native">
                            <label class="form-check-label" for="native">Ad Native</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" {{$edit_category_id->multipleNative == 1 ? "checked":""}} value="1" id="multipleNative" name="multipleNative">
                            <label class="form-check-label" for="multipleNative">Ad MultipleNative</label>
                          </div>
                          <br>
                        
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" {{$edit_category_id->rectangle == 1 ? "checked":""}} value="1" id="rectangle" name="rectangle">
                            <label class="form-check-label" for="rectangle">Medium Rectangle</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" {{$edit_category_id->multipleRectangle == 1 ? "checked":""}} value="1" id="multipleRectangle" name="multipleRectangle">
                            <label class="form-check-label" for="multipleRectangle">Multiple Medium Rectangle <b>(For Facebook Ads)</b></label>
                          </div>
                      </div>
                    </div>
    
                    <div class="div float-end mt-4 mb-3">
                      <button type="submit" name="submit" class="btn btn-primary" id="susubmitbmit">Submit</button>
                      <button id="loading" class="btn btn-primary" type="button" disabled=""><span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Loading...</button>
                      <a href="{{url('admin/ad_manager_list')}}" class="btn btn-dark" type="button">cancel</a>
                    </div>

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

    // ad_app_typess();
    // function ad_app_typess()
    // {
    //     var id = $('#ad_app_type option:selected').val();
    //     if(id == 1)
    //     {
    //         $('#google_open_id').show();
    //         $('#facebook_open_id').hide();
    //     }else if(id == 2)
    //     {
    //         $('#google_open_id').hide();
    //         $('#facebook_open_id').show();
    //     }else if(id == 3){
    //         $('#google_open_id').hide();
    //         $('#facebook_open_id').show();
    //     }else{
    //         $('#google_open_id').hide();
    //         $('#facebook_open_id').hide();
    //     }
    // }
$('#ad_app_type').on('change', function(){
  ad_app_typess(true);
});

 ad_app_typess(false); 

  function ad_app_typess(shouldClear)
  {
      var id = $('#ad_app_type option:selected').val();
      if(id == 1) {
          // Google Ad
          $('#google_open_id').show();
          $('#facebook_open_id').hide();
          if (shouldClear) $('#facebook_open_id').find('input').val('');
      } else if(id == 2 || id == 3) {
          // Facebook Ad / Unity Ad
          $('#google_open_id').hide();
          if (shouldClear) $('#google_open_id').find('input').val('');
          $('#facebook_open_id').show();
      } else {
          $('#google_open_id').hide();
          $('#facebook_open_id').hide();
      }
  }
  </script>
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

  <script type="text/javascript">
    $('.add-tr-3').hide();
    var i = 0;
    $("#add-btn-3").click(function(){
      ++i;
      $('.add-tr-3').show();
      $("#dynamicAddRemove-3").append('<tr><td><input type="text" name="multiple_medium_rectangle_id[]" placeholder="Enter Multiple Medium Rectangle ID" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr-3"><i class="mdi mdi-trash-can"></i></button></td></tr>');
    });
    $(document).on('click', '.remove-tr-3', function(){  
      $(this).parents('tr').remove();
    });
    $(document).on('click', '.add-tr-3', function(){
        ++i;
        $("#dynamicAddRemove-3").append('<tr><td><input type="text" name="multiple_medium_rectangle_id[]" placeholder="Enter Multiple Medium Rectangle ID" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr-3"><i class="mdi mdi-trash-can"></i></button></td></tr>');
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
