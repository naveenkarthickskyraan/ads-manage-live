<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>ADS Manager</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

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

  {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet"> --}}

  {{-- <!-- Templat{{ asset('e Main CSS File --> --}}
  <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
</head>

<body>
  @include('admin.navbar')
  <!-- ======= Sidebar ======= -->
  @include('admin.sidebar')

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
              <h4 class="card-title text-dark">Ads Manager Form</h4>    
              <hr class="text-dark">
              <form class="forms-sample" action="{{url('admin/ad_manager.insert')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group row mb-3">
                  <label for="app_id" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">App <span style="color:red;">&nbsp;*</span></label>
                  <div class="col-sm-9">
                    <select class="js-example-basic-single form-select form-select-white mb-3 text-dark bg-outline-dark border-3 select2" name="app_id" id="app_id" style="width:100%" >
                        <option class="text-dark" value="">Select a App *</option>
                        @foreach($apps as $apps)
                          <option class="text-dark" value="{{$apps->id}}" {{ old('app_id') == $apps->id ? "selected" : "" }}>{{$apps->app_name}} - {{$apps->app_type == 1 ? 'Android':'IOS'}} - {{$apps->app_type == 1 ? $apps->package_name:$apps->apple_id}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group row mb-3">
                  <div class="col-md-3">

                  </div>
                  <div class="col-md-9">
                    <small> Note -</small><small style="color:red" >  Select App Before AppType Selection *</small>
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <label for="ad_app_type" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">App Type <span style="color:red;">&nbsp;*</span></label>
                  <div class="col-sm-9">
                    <select class="form-select form-select-white mb-3 text-dark bg-outline-dark border-3 select2" name="ad_app_type" id="ad_app_type" style="width:100%" onchange="ad_app_typess()">
                      <option class="text-dark" value="">Select a Ad App Type *</option>
                      <option class="text-dark" value="1" data-icon="fa-google" disabled>Google Ad</option>
                      <option class="text-dark" value="2" data-icon="fa-facebook" disabled>Facebook Ad</option>
                      <option class="text-dark" value="3" data-icon="fa-unity" disabled>Unity Ad</option>
                      {{-- <option class="text-dark" value="0" data-icon="fa-ban" >Disable Ad</option> --}}
                    </select>
                  </div>
                </div>
                
                <div class="form-group row mb-3">
                  <div class="col-sm-3 d-flex aling-items-center">
                      <label for="ad_app_id" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Ad App ID </label>
                  </div>
                  <div class="col-sm-9">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="ad_app_id" value="{{old('ad_app_id')}}" name="ad_app_id" placeholder="Enter the Ad App ID Video" autocomplete="off">
                      <label for="ad_app_id" style="color:rgb(174, 153, 153)">Ad App ID</label>
                    </div>
                  </div>
                </div>


                <div id="google_open_id" class="form-group row mb-3">
                  <div class="col-sm-3 d-flex aling-items-center">
                      <label for="app_open_id" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">App Open ID </label>
                  </div>
                  <div class="col-sm-9">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="app_open_id" value="{{old('app_open_id')}}" name="app_open_id" placeholder="Enter the App Open ID Video" autocomplete="off">
                      <label for="app_open_id" style="color:rgb(174, 153, 153)">App Open ID</label>
                    </div>
                  </div>
                </div>


                <div id="facebook_open_id">                
                  <div class="form-group row mb-3">
                    <div class="col-sm-3 d-flex aling-items-center">
                        <label for="meadium_rectangle" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Medium Rectangle ID</label>
                    </div>
                    <div class="col-sm-9">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="meadium_rectangle" value="{{old('meadium_rectangle')}}" name="meadium_rectangle" placeholder="Enter the Banner ID" autocomplete="off">
                        <label for="meadium_rectangle" style="color:rgb(174, 153, 153)">Medium Rectangle</label>
                      </div>
                    </div>
                  </div>
                    
                  <div class="form-group row mb-3">
                    <label for="radio" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">Multiple Medium Rectangle ID</label>
                    <div class="col-sm-9">
                      <div class="input-group control-group increment-medium" >
                        <input type="text" name="multiple_medium_rectangle_id[]" style="color:rgb(174, 153, 153)" class="form-control" placeholder="Enter the Medium Rectangle ID">
                        <div class="input-group-btn"> 
                          <button class="btn btn-success button-medium" type="button"><i class="mdi mdi-plus"></i></button>
                        </div>
                      </div>
                      <div class="clone-medium hide mb-3">
                        <div class="control-group-medium input-group" style="margin-top:10px">
                          <input type="text" name="multiple_medium_rectangle_id[]" style="color:rgb(174, 153, 153)" class="form-control" placeholder="Enter the Medium Rectangle ID">
                          <div class="input-group-btn"> 
                            <button id="#images" class="btn btn-danger ddd-medium" type="button"><i class="mdi mdi-trash-can"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                           
                <div class="form-group row mb-3">
                  <div class="col-sm-3 d-flex aling-items-center">
                      <label for="banner_id" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Banner ID </label>
                  </div>
                  <div class="col-sm-9">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="banner_id" value="{{old('banner_id')}}" name="banner_id" placeholder="Enter the Banner ID" autocomplete="off">
                      <label for="banner_id" style="color:rgb(174, 153, 153)">Banner ID</label>
                    </div>
                  </div>
                </div>

                <div class="form-group row mb-3">
                  <label for="radio" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">Multiple Banner ID</label>
                  <div class="col-sm-9">
                    <div class="input-group control-group increment" >
                      <input type="text" name="multiple_banner_id[]" style="color:rgb(174, 153, 153)" class="form-control" placeholder="Enter the Banner ID">
                      <div class="input-group-btn"> 
                        <button class="btn btn-success button-image" type="button"><i class="mdi mdi-plus"></i></button>
                      </div>
                    </div>
                    <div class="clone hide mb-3">
                      <div class="control-group input-group" style="margin-top:10px">
                        <input type="text" name="multiple_banner_id[]" style="color:rgb(174, 153, 153)" class="form-control" placeholder="Enter the Banner ID">
                        <div class="input-group-btn"> 
                          <button id="#images" class="btn btn-danger ddd" type="button"><i class="mdi mdi-trash-can"></i></button>
                        </div>
                      </div>
                    </div>
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
                                    value="{{ old('audio_banner_id') }}"
                                    placeholder="Enter Audio Banner ID"
                                    autocomplete="off">

                              <label for="audio_banner_id"
                                    style="color:rgb(174, 153, 153)">
                                  Audio Banner ID
                              </label>
                          </div>
                      </div>
                  </div>

                <div class="form-group row mb-3">
                  <div class="col-sm-3 d-flex aling-items-center">
                      <label for="interstitial_id" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Interstitial ID </label>
                  </div>
                  <div class="col-sm-9">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="interstitial_id" value="{{old('interstitial_id')}}" name="interstitial_id" placeholder="Enter the Interstitial ID" autocomplete="off">
                      <label for="interstitial_id" style="color:rgb(174, 153, 153)">Interstitial ID</label>
                    </div>
                  </div>
                </div>

                <div class="form-group row mb-3">
                  <label for="radio" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">Multiple Interstitial ID</label>
                  <div class="col-sm-9">
                    <div class="input-group control-group-1 increment-1" >
                      <input type="text" name="multiple_interstitial_id[]" style="color:rgb(174, 153, 153)" class="form-control" placeholder="Enter the interstitial ID">
                      <div class="input-group-btn"> 
                        <button id="btn-video-success" class="btn btn-success button-video" type="button"><i class="mdi mdi-plus"></i></button>
                      </div>
                    </div>
                    <div class="clone-1 hide">
                      <div class="control-group-1 input-group" style="margin-top:10px">
                        <input type="text" name="multiple_interstitial_id[]" style="color:rgb(174, 153, 153)" class="form-control" placeholder="Enter the interstitial ID">
                        <div class="input-group-btn"> 
                          <button id="btn-video-danger" class="btn btn-danger ccc" type="button"><i class="mdi mdi-trash-can"></i></button>
                        </div>
                      </div>
                    </div>
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
                                  value="{{ old('audio_interstitial_id') }}"
                                  placeholder="Enter Audio Interstitial ID"
                                  autocomplete="off">

                            <label for="audio_interstitial_id"
                                  style="color:rgb(174, 153, 153)">
                                Audio Interstitial ID
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-3">
                  <div class="col-sm-3 d-flex aling-items-center">
                      <label for="native_advanced_id" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Native Advanced ID </label>
                  </div>
                  <div class="col-sm-9">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="native_advanced_id" value="{{old('native_advanced_id')}}" name="native_advanced_id" placeholder="Enter the Native Advanced ID" autocomplete="off">
                      <label for="native_advanced_id" style="color:rgb(174, 153, 153)">Native Advanced ID</label>
                    </div>
                  </div>
                </div>

                <div class="form-group row mb-3">
                  <label for="radio" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">Multiple Native Advanced ID</label>
                  <div class="col-sm-9">
                    <div class="input-group control-group-2 increment-2" >
                      <input type="text" name="multiple_native_advanced_id[]" style="color:rgb(174, 153, 153)" class="form-control" placeholder="Enter the Advanced ID">
                      <div class="input-group-btn"> 
                        <button id="btn-video-success" class="btn btn-success button-advanced" type="button"><i class="mdi mdi-plus"></i></button>
                      </div>
                    </div>
                    <div class="clone-2 hide">
                      <div class="control-group-2 input-group" style="margin-top:10px">
                        <input type="text" name="multiple_native_advanced_id[]"  class="form-control" placeholder="Enter the Advanced ID" style="color:rgb(174, 153, 153)">
                        <div class="input-group-btn"> 
                          <button id="btn-video-danger" class="btn btn-danger fff" type="button"><i class="mdi mdi-trash-can"></i></button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group row mb-3">
                  <div class="col-sm-3 d-flex aling-items-center">
                      <label for="ad_rewards" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Ad Rewards </label>
                  </div>
                  <div class="col-sm-9">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="ad_rewards" value="{{old('ad_rewards')}}" name="ad_rewards" placeholder="Enter the Ad Rewards" autocomplete="off">
                      <label for="ad_rewards" style="color:rgb(174, 153, 153)">Ad Rewards</label>
                    </div>
                  </div>
                </div>

                <div class="form-group row mb-3">
                  <div class="col-sm-3 d-flex aling-items-center">
                      <label for="rewarded_interstitial" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Rewarded Interstitial </label>
                  </div>
                  <div class="col-sm-9">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="rewarded_interstitial" value="{{old('rewarded_interstitial')}}" name="rewarded_interstitial" placeholder="Enter the Rewarded Interstitial" autocomplete="off">
                      <label for="rewarded_interstitial" style="color:rgb(174, 153, 153)">Rewarded Interstitial</label>
                    </div>
                  </div>
                </div>

                <div class="form-group row mb-3">
                  <div class="col-sm-3 d-flex aling-items-center">
                      <label for="interstitial_video" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Interstitial Video </label>
                  </div>
                  <div class="col-sm-9">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="interstitial_video" value="{{old('interstitial_video')}}" name="interstitial_video" placeholder="Enter the Interstitial Video" autocomplete="off">
                      <label for="interstitial_video" style="color:rgb(174, 153, 153)">Interstitial Video</label>
                    </div>
                  </div>
                </div>

                <div class="form-group row mb-3">
                  <div class="col-sm-3 d-flex aling-items-center">
                      <label for="native_advance_video" class=" col-form-label color-dark fs-14 fw-500 align-center fw-bold">Native Advanced Video </label>
                  </div>
                  <div class="col-sm-9">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15" id="native_advance_video" value="{{old('native_advance_video')}}" name="native_advance_video" placeholder="Enter the Native Advanced Video" autocomplete="off">
                      <label for="native_advance_video" style="color:rgb(174, 153, 153)">Native Advanced Video</label>
                    </div>
                  </div>
                </div>

                <div class="form-group row mb-3">
                  <label for="is_show_ads_biblereading_screen" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">Show ads on the Bible reading screen  <span style="color:red;">&nbsp;*</span></label>
                  <div class="col-sm-9">
                    <select class="form-select form-select-white mb-3 text-dark bg-outline-dark border-3 select2" name="is_show_ads_biblereading_screen" id="is_show_ads_biblereading_screen" style="width:100%">
                      <option class="text-dark" value="">Select a Show ads on the Bible reading screen *</option>
                      <option class="text-dark" {{old('is_show_ads_biblereading_screen') == 1 ? "Selected":""}} value="1">Yes</option>
                      <option class="text-dark" {{old('is_show_ads_biblereading_screen') == 0 ? "Selected":""}} value="0">No</option>
                    </select>
                  </div>
                </div>
                
                <div class="form-group row mb-3">
                  <label for="biblereadingscreen_ads_verse_interval" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">biblereading screen ads verse interval   <span style="color:red;">&nbsp;*</span></label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" name="biblereadingscreen_ads_verse_interval" id="biblereadingscreen_ads_verse_interval" value="{{old('biblereadingscreen_ads_verse_interval')}}" placeholder="Enter the verse intervel number here..">
                  </div>
                </div>

                

                <div class="form-group row mb-3">
                  <label for="auto_ads_load" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">Auto ads load Enable or Disable <span style="color:red;">&nbsp;*</span></label>
                  <div class="col-sm-9">
                    <select class="form-select form-select-white mb-3 text-dark bg-outline-dark border-3 select2" name="auto_ads_load" id="auto_ads_load" style="width:100%">
                      <option class="text-dark" value="">Select a Auto ads load Enable or Disable *</option>
                      <option class="text-dark" {{old('auto_ads_load') == 1 ? "Selected":""}} value="1">Yes</option>
                      <option class="text-dark" {{old('auto_ads_load') == 0 ? "Selected":""}} value="0">No</option>
                    </select>
                  </div>
                </div>

                
                <div class="form-group row mb-3">
                  <label for="auto_ads_load_duration" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">Auto Ads load Duration <span style="color:red;">&nbsp;*</span></label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" name="auto_ads_load_duration" id="auto_ads_load_duration" value="{{old('auto_ads_load_duration')}}" placeholder="Enter the verse intervel number here.." min="5" max="15">
                  </div>
                </div>



                <div class="row mb-4">
                  <label for="adBanner" class="col-sm-3 col-form-label h2 text-dark fw-bold" style="padding-left: 10px">Ads Enable Or Disable<span style="color:red;">&nbsp;*</span></label>
                  
                  <div class="col-md-9">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" checked value="1" id="adBanner" name="adBanner">
                        <label class="form-check-label" for="adBanner">Ad Banner</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" checked value="1" id="multipleAdBanner" name="multipleAdBanner">
                        <label class="form-check-label" for="multipleAdBanner">Multiple AdBanner</label>
                      </div>
                      <br>
              
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" checked value="1" id="interstitial" name="interstitial">
                        <label class="form-check-label" for="interstitial">Interstitial</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" checked value="1" id="multipleInterstitial" name="multipleInterstitial">
                        <label class="form-check-label" for="multipleInterstitial">Multiple Interstitial</label>
                      </div>
                      <br>
                    
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" checked value="1" id="native" name="native">
                        <label class="form-check-label" for="native">Ad Native</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" checked value="1" id="multipleNative" name="multipleNative">
                        <label class="form-check-label" for="multipleNative">Ad MultipleNative</label>
                      </div>
                      <br>
                    
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" checked value="1" id="rectangle" name="rectangle">
                        <label class="form-check-label" for="rectangle">Medium Rectangle</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" checked value="1" id="multipleRectangle" name="multipleRectangle">
                        <label class="form-check-label" for="multipleRectangle">Multiple Medium Rectangle (For Facebook Ads)</label>
                      </div>
                  </div>
                </div>

                <div class="div float-end mt-4 mb-3">
                  <button type="submit" name="submit" class="btn btn-primary" id="susubmitbmit">Submit</button>
                  <button id="loading" class="btn btn-primary" type="button" disabled=""><span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Loading...</button>
                  <a href="{{url('admin/ad_manager_list')}}" class="btn btn-dark" type="button">cancel</a>
                </div>
              </form>
              <br>
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

    $('#google_open_id').hide();
    $('#facebook_open_id').hide();
    
    $('#app_id').on('change', function () {
        var app_id = $(this).val();
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
    
        $.ajax({
            url: "{{ url('admin/get_add_type') }}",
            type: "GET",
            dataType: 'json',
            data: { app_id: app_id },
            success: function (data) {
                console.log(data);
    
                // Enable all options first
                $("#ad_app_type option").prop("disabled", false);
    
                // Disable based on data
                if (data.google) {
                    $("#ad_app_type option[value='1']").prop("disabled", true); // Google Ad
                }
    
                if (data.facebook) {
                    $("#ad_app_type option[value='2']").prop("disabled", true); // Facebook Ad
                }
    
                if (data.unity) {
                    $("#ad_app_type option[value='3']").prop("disabled", true); // Unity Ad
                }
            },
            error: function () {
                console.error("Error fetching ad type status.");
            }
        });
    });

    
    
    function ad_app_typess()
    {
      var id = $('#ad_app_type option:selected').val();
      if(id == 1)
      {
        $('#google_open_id').show();
        $('#facebook_open_id').hide();
      }else if(id == 2)
      {
        $('#google_open_id').hide();
        $('#facebook_open_id').show();
      }else if(id == 3){
        $('#google_open_id').hide();
        $('#facebook_open_id').show();
      }else{
        $('#google_open_id').hide();
        $('#facebook_open_id').hide();
      }
    }
  </script>
    
  <script type="text/javascript">
    $(".button-medium").click(function(){ 
        var html = $(".clone-medium").html();
        var count_element = $('.ddd-medium').length;
        if(count_element == 9)
        { 
          $('.button-medium').attr("disabled","disabled");
        }
        $(".increment-medium").after(html);
    });
    $("body").on("click",".ddd-medium",function(){ 
        $('.button-medium').removeAttr("disabled");
        $(this).parents(".control-group-medium").remove();
    });
  </script>

  <script type="text/javascript">
    $(".button-image").click(function(){ 
        var html = $(".clone").html();
        var count_element = $('.ddd').length;
        if(count_element == 9)
        { 
          $('.button-image').attr("disabled","disabled");
        }
        $(".increment").after(html);
    });
    $("body").on("click",".ddd",function(){ 
        $('.button-image').removeAttr("disabled");
        $(this).parents(".control-group").remove();
    });
  </script>
  <script type="text/javascript">
      $(".button-video").click(function(){ 
          var html_1 = $(".clone-1").html();
          var count_element = $('.ccc').length;
          if(count_element == 9)
          { 
            $('.button-video').attr("disabled","disabled");
          }
          $(".increment-1").after(html_1);
      });
      $("body").on("click",".ccc",function(){ 
          $('.button-video').removeAttr("disabled");
          $(this).parents(".control-group-1").remove();
      });
  </script> 

  <script type="text/javascript">
    $(".button-advanced").click(function(){ 
        var html_1 = $(".clone-2").html();
        var count_element = $('.fff').length;
        if(count_element == 9)
        { 
          $('.button-advanced').attr("disabled","disabled");
        }
        $(".increment-2").after(html_1);
    });
    $("body").on("click",".fff",function(){ 
        $('.button-advanced').removeAttr("disabled");
        $(this).parents(".control-group-2").remove();
    });
  </script>
  <script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
        });
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
