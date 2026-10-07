<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Auth;
use App\Models\AppList;
use App\Models\Module;
Use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\AdManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Helpers\LogActivity;
use App\Models\LetterCount;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentExport;
use App\Exports\BookExport;
use DataTables;


class AdManagerController extends Controller
{
    function show(Request $request)
    {
        if($request->ajax())
        {
            if(request()->filled('issue_type') == false && request()->filled('app_type') == false)
            {
                $categorys = AdManager::query()->where('deleted_at',0);
                return DataTables::of($categorys)
                    ->addColumn('app_type', function ($category) {
                        return $category->app_type == 1 ? 'Android' : 'IOS';
                    })
                    ->addColumn('app_link', function ($category) {
                        if($category->app_type == 1)
                        {
                            return '<div><span class="fw-bold">Package Name - </span>'.$category->AppList->package_name.'</div>';
                        }else{
                            return '<div><span class="fw-bold">Apple ID - </span>'.$category->AppList->apple_id.'<br><span class="fw-bold">Bundle ID - </span>'.$category->AppList->bundle_id.'</div>';
                        }
                    })
                    ->addColumn('created_at_formatted', function ($category) {
                        return $category->created_at;
                    })
                    ->addColumn('status', function ($category) {
                        return $category->is_active == '0' ? '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>' : '<span class="badge bg-danger rounded-fill"><i class="bi bi-exclamation-octagon me-1"></i> Deactivate</span>';
                    })
                    ->addColumn('action', function ($category) {
                        $editUrl = url("admin/edit_ad_manager/".$category->id);
                        $deleteUrl = url("admin/delete_ad_manager/".$category->id);

                        return '<div class="btn-group">
                                    <form action="'.$editUrl.'" method="POST">'.csrf_field().'
                                        <button type="submit" class="btn btn-icon btn-circle btn-sm btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit App">
                                            <i class="mdi mdi-pencil-box"></i>
                                        </button>
                                    </form>
                                    <form  id="form_submit_'.$category->id.'"   action="'.$deleteUrl.'" method="POST" style="padding-left:5px;">'.csrf_field().'
                                        <input id="disable_'.$category->id.'" type="hidden" name="ad_app_type"  class="form-control" />
                                        <button  type="button" class="btn btn-icon btn-circle btn-sm btn-outline-danger" onclick="return validateform('.$category->id.','.$category->ad_app_type.')"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete App">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                </div>';
                    })
                    ->addColumn('status_update', function ($category) {
                        $statusUpdateUrl = url('admin/ad_manager_status_update');
                        $statusText = $category->is_active == '0' ? 'Enable' : 'Disable';
                        $statusValue = $category->is_active == '0' ? '0' : '1';
                        if($statusValue == 1)
                        {
                            return '<form action="'.$statusUpdateUrl.'" method="POST">'.
                                    csrf_field().
                                    '<input type="hidden" name="cat_id" value="'.$category->id.'">'.
                                    ($category->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                    '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($category->is_active == '0' ? 'enable' : '').'" style="background: #ffad46!important;border-color: #ffad46!important;color: #fff!important;">
                                        <i class="bi bi-check-circle me-1"></i>
                                    </button>
                                </form>';
                        }else{
                            
                        return '<form action="'.$statusUpdateUrl.'" method="POST">'.
                                    csrf_field().
                                    '<input type="hidden" name="cat_id" value="'.$category->id.'">'.
                                    ($category->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                    '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($category->is_active == '0' ? 'enable' : '').'" >
                                        <i class="bi bi-check-circle me-1"></i>
                                    </button>
                                </form>';
                        }
                    })
                    ->addColumn('ad_app_type', function ($category) {
                        if($category->ad_app_type == 1)
                        {
                            return '<div style="display: flex;flex-direction: row;flex-wrap: nowrap;justify-content: space-evenly;">
                                <div class="px-1 fade-disabled" style="cursor: wait !important;"><button  type="button" class="btn btn-icon btn-circle btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{$row->id}}"><i class="fa fa-google"></i></button></div>
                                </div>';
                        } else if ($category->ad_app_type == 2){
                            return '<div style="display: flex;flex-direction: row;flex-wrap: nowrap;justify-content: space-evenly;">
                                <div class="px-1 fade-disabled" style="cursor: wait !important;"><button  type="button" class="btn btn-icon btn-circle btn-sm btn-primary disabled "   data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{$row->id}}"><i class="fa fa-facebook"></i></button></div>
                                </div>';
                        }
                        else{
                            return '<div style="display: flex;flex-direction: row;flex-wrap: nowrap;justify-content: space-evenly;">
                                <div class="px-1 fade-disabled" style="cursor: wait !important;"><button  type="button" class="btn btn-icon btn-circle btn-sm btn-light disabled "   data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{$row->id}}"><i class="fa fa-unity fa-xl" style="font-size: 24px !important;"></i></button></div>
                                </div>';
                        }
                    })
                    ->rawColumns(['app_link', 'status', 'action', 'status_update','ad_app_type'])
                    ->filterColumn('app_type', function ($query, $keyword) {
                        $keyword = strtolower($keyword);
                        if ($keyword == 'android' || $keyword == 'ios') {
                            $query->where('app_type', $keyword == 'android' ? 1 : 2);
                        }
                    })
                    ->filterColumn('app_link', function ($query, $keyword) {
                        $query->whereHas('AppList', function ($query) use ($keyword) {
                            $query->where('package_name', 'like', "%{$keyword}%")
                                ->orWhere('apple_id', 'like', "%{$keyword}%")
                                ->orWhere('bundle_id', 'like', "%{$keyword}%");
                        });
                    })
                    ->orderColumn('app_type', function ($query, $order) {
                        // Convert 'Android' and 'IOS' back to 1 and 2 for sorting
                        $query->orderBy('app_type', $order);
                    })
                    ->orderColumn('ad_app_type', function ($query, $order) {
                        $query->orderBy('ad_app_type', $order);

                    })
                    ->make(true);
            }else{
                $categorys = AdManager::query()->where('deleted_at',0);
                return DataTables::of($categorys)
                    ->addColumn('app_type', function ($category) {
                        return $category->app_type == 1 ? 'Android' : 'IOS';
                    })
                    ->addColumn('app_link', function ($category) {
                        if($category->app_type == 1)
                        {
                            return '<div><span class="fw-bold">Package Name - </span>'.$category->AppList->package_name.'</div>';
                        }else{
                            return '<div><span class="fw-bold">Apple ID - </span>'.$category->AppList->apple_id.'<br><span class="fw-bold">Bundle ID - </span>'.$category->AppList->bundle_id.'</div>';
                        }
                    })
                    ->addColumn('created_at_formatted', function ($category) {
                        return $category->created_at;
                    })
                    ->addColumn('status', function ($category) {
                        return $category->is_active == '0' ? '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>' : '<span class="badge bg-danger rounded-fill"><i class="bi bi-exclamation-octagon me-1"></i> Deactivate</span>';
                    })
                    ->addColumn('action', function ($category) {
                        $editUrl = url("admin/edit_ad_manager/".$category->id);
                        $deleteUrl = url("admin/delete_ad_manager/".$category->id);

                        return '<div class="btn-group">
                                    <form action="'.$editUrl.'" method="POST">'.csrf_field().'
                                        <button type="submit" class="btn btn-icon btn-circle btn-sm btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit App">
                                            <i class="mdi mdi-pencil-box"></i>
                                        </button>
                                    </form>
                                    <form  id="form_submit_'.$category->id.'"   action="'.$deleteUrl.'" method="POST" style="padding-left:5px;">'.csrf_field().'
                                        <button  type="button" class="btn btn-icon btn-circle btn-sm btn-outline-danger" onclick="return validateform('.$category->id.')"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete App">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                </div>';
                    })
                    ->addColumn('status_update', function ($category) {
                        $statusUpdateUrl = url('admin/ad_manager_status_update');
                        $statusText = $category->is_active == '0' ? 'Enable' : 'Disable';
                        $statusValue = $category->is_active == '0' ? '0' : '1';
                        if($statusValue == 1)
                        {
                            return '<form action="'.$statusUpdateUrl.'" method="POST">'.
                                    csrf_field().
                                    '<input type="hidden" name="cat_id" value="'.$category->id.'">'.
                                    ($category->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                    '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($category->is_active == '0' ? 'enable' : '').'" style="background: #ffad46!important;border-color: #ffad46!important;color: #fff!important;">
                                        <i class="bi bi-check-circle me-1"></i>
                                    </button>
                                </form>';
                        }else{
                            
                        return '<form action="'.$statusUpdateUrl.'" method="POST">'.
                                    csrf_field().
                                    '<input type="hidden" name="cat_id" value="'.$category->id.'">'.
                                    ($category->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                    '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($category->is_active == '0' ? 'enable' : '').'" >
                                        <i class="bi bi-check-circle me-1"></i>
                                    </button>
                                </form>';
                        }
                    })
                    
                   ->addColumn('ad_app_type', function ($category) {
                        if($category->ad_app_type == 1)
                        {
                            return '<div style="display: flex;flex-direction: row;flex-wrap: nowrap;justify-content: space-evenly;">
                                <div class="px-1 fade-disabled" style="cursor: wait !important;"><button  type="button" class="btn btn-icon btn-circle btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{$row->id}}"><i class="fa fa-google"></i></button></div>
                                </div>';
                        } else if ($category->ad_app_type == 2){
                            return '<div style="display: flex;flex-direction: row;flex-wrap: nowrap;justify-content: space-evenly;">
                                <div class="px-1 fade-disabled" style="cursor: wait !important;"><button  type="button" class="btn btn-icon btn-circle btn-sm btn-primary disabled "   data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{$row->id}}"><i class="fa fa-facebook"></i></button></div>
                                </div>';
                        }
                        else{
                            return '<div style="display: flex;flex-direction: row;flex-wrap: nowrap;justify-content: space-evenly;">
                                <div class="px-1 fade-disabled" style="cursor: wait !important;"><button  type="button" class="btn btn-icon btn-circle btn-sm btn-light disabled "   data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{$row->id}}"><i class="fa fa-unity fa-xl" style="font-size: 24px !important;"></i></button></div>
                                </div>';
                        }
                    })
                    ->rawColumns(['app_link', 'status', 'action', 'status_update','ad_app_type'])
                    ->filterColumn('app_type', function ($query, $keyword) {
                        $keyword = strtolower($keyword);
                        if ($keyword == 'android' || $keyword == 'ios') {
                            $query->where('app_type', $keyword == 'android' ? 1 : 2);
                        }
                    })
                    ->filterColumn('app_link', function ($query, $keyword) {
                        $query->whereHas('AppList', function ($query) use ($keyword) {
                            $query->where('package_name', 'like', "%{$keyword}%")
                                ->orWhere('apple_id', 'like', "%{$keyword}%")
                                ->orWhere('bundle_id', 'like', "%{$keyword}%");
                        });
                    })
                    ->orderColumn('app_type', function ($query, $order) {
                        // Convert 'Android' and 'IOS' back to 1 and 2 for sorting
                        $query->orderBy('app_type', $order);
                    })
                    ->orderColumn('ad_app_type', function ($query, $order) {
                        $query->orderBy('ad_app_type', $order);

                    })
                    ->filter(function ($query) {
                        if (request()->filled('issue_type')) {
                            $query->where('ad_app_type', request('issue_type'));
                        }
                        if (request()->filled('app_type')) {
                            $query->where('app_type', request('app_type'));
                        }
                    })
                    ->make(true);
            }
        }
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $module = Module::Select(['module_name'])->whereIn('module_name',$explode)->get();
        $permission=[];
        foreach($module as $row)
        {
            $permission[] = $row->module_name;
        }
        $permis = $permission;
        $array = in_array('ads_info', $permis);
        $array_1= in_array('view',$explode_1);
        if(($role == "SuperAdmin") || ($array == true &&  $array_1 == true))
        {
            $category = AdManager::orderBy('id','asc')->where('deleted_at','0')->get();
            return view('admin.category.category_list', ['categorys' => $category]);
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Access Denied");
        }
    }

    function Add_list()
    {
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $module = Module::Select(['module_name'])->whereIn('module_name',$explode)->get();
        $permission=[];
        foreach($module as $row)
        {
            $permission[] = $row->module_name;
        }
        $permis = $permission;
        $array = in_array('ads_info', $permis);
        $array_1= in_array('add',$explode_1);
        if(($role == "SuperAdmin") || ($array  && $array_1== true))
        {
            $ads = AdManager::pluck('app_id')->toArray();
            $apps = AppList::where('deleted_at',0)->where('is_active',0)->get();
            // $apps = AppList::where('deleted_at',0)->whereNotIn('id',$ads)->get();
            return view('admin.category.add_category', compact('apps'));
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Access Denied");
        }
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'app_id' => 'required|string|max:255',
            "ad_app_type" => "required",
            "multiple_banner_id.*" => "required",
            "multiple_interstitial_id.*" => "required",
            "multiple_native_advanced_id.*" => "required"
        ]);
        
        
        $user = new AdManager;
        $user->app_id = $request['app_id'];
        $app_list = AppList::find($request['app_id']);
        $user->app_type = $app_list->app_type;
        
        $user->ad_app_type = $request->ad_app_type;
        $user->app_open_id = $request->app_open_id;
        $user->ad_app_id = $request->ad_app_id ?? 1;

        if(!empty($request->meadium_rectangle))
        {
            $user->ad_meadium_rectangle_id = $request->meadium_rectangle;
        }

        $array_1 = array_diff($request->multiple_medium_rectangle_id,[null]);
        if(!empty($array_1))
        {
            $array = array_diff($request->multiple_medium_rectangle_id,[null]);
            $user->multiple_medium_rectangle_id  = implode(',',$array);
        }
        else
        {
            $user->multiple_medium_rectangle_id  = '';
        }

        if(!empty($request->banner_id))
        {
            $user->ad_banner_id = $request->banner_id;
        }

        $array_1 = array_diff($request->multiple_banner_id,[null]);
        if(!empty($array_1))
        {
            $array = array_diff($request->multiple_banner_id,[null]);
            $user->multiple_banner_id  = implode(',',$array);
        }
        else
        {
            $user->multiple_banner_id  = '';
        }

        if(!empty($request->interstitial_id))
        {
            $user->ad_intercial_id = $request->interstitial_id;
        }

        $array_2 = array_diff($request->multiple_interstitial_id,[null]);
        if(!empty($array_2))
        {
            $multiple_interstitial_id = array_diff($request->multiple_interstitial_id,[null]);
            $user->multiple_interstitial_id  = implode(',',$multiple_interstitial_id);
        }
        else
        {
            $user->multiple_interstitial_id  = '';
        }

        if(!empty($request->native_advanced_id))
        {
            $user->ad_native_advanced = $request->native_advanced_id;
        }
        
        $array_3 = array_diff($request->multiple_native_advanced_id,[null]);
        if(!empty($array_3))
        {
            $multiple_native_advanced_id = array_diff($request->multiple_native_advanced_id,[null]);
            $user->multiple_advanced_id  = implode(',',$multiple_native_advanced_id);
        }
        else
        {
            $user->multiple_advanced_id  = '';
        }
        //naveen
        $user->audio_banner_id = $request->audio_banner_id ?? '';
        $user->audio_interstitial_id = $request->audio_interstitial_id ?? '';
        $user->ad_rewards = $request->ad_rewards ?? '';
        $user->ad_rewarded_intencial = $request->rewarded_interstitial ?? '';
        $user->ad_intencial_video = $request->interstitial_video ?? '';
        $user->ad_native_advanced_video	 = $request->native_advance_video ?? '';

        $user->is_show_ads_biblereadingscreen = $request->is_show_ads_biblereading_screen ?? 0;
        $user->biblereadingscreen_ads_verse_interval = $request->biblereadingscreen_ads_verse_interval ?? '';
        
        $user->auto_ads_load = $request->auto_ads_load ?? 0;
        $user->auto_ads_load_duration = $request->auto_ads_load_duration ?? 5;
        
        
        //Field Refrence added 
        $user->adBanner = $request->adBanner ?? '2';
        $user->multipleAdBanner = $request->multipleAdBanner ?? '2';
        $user->interstitial = $request->interstitial ?? '2';
        $user->multipleInterstitial = $request->multipleInterstitial ?? '2';
        $user->native = $request->native ?? '2';
        $user->multipleNative = $request->multipleNative ?? '2';
        $user->rectangle = $request->rectangle ?? '2';
        $user->multipleRectangle = $request->multipleRectangle ?? '2';

        $user->save();
        if($user)
        {
            $id = $user->id;
            $ad_app_type = $request->ad_app_type;
            if($ad_app_type == 1)
            {   
                $app_list = AppList::find($request['app_id']);
                $app_list->google_ads_id = $id;
                $app_list->save();
                
            }else if($ad_app_type == 2){
                $app_list = AppList::find($request['app_id']);
                $app_list->facebook_ads_id = $id;
                $app_list->save();
                
            }if($ad_app_type == 3){
                $app_list = AppList::find($request['app_id']);
                $app_list->unity_ads_id = $id;
                $app_list->save();
                
            }
            else{
                $app_list = AppList::find($request['app_id']);
                $app_list->save();
            }

        }
        return back()->with('message','Ads Created Successfully');
    }

    public function active(Request $request)
    {
        LogActivity::addToLog();
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $module = Module::Select(['module_name'])->whereIn('module_name',$explode)->get();
        $permission=[];
        foreach($module as $row)
        {
            $permission[] = $row->module_name;
        }
        $permis = $permission;
        $array = in_array('ads_info', $permis);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array  && $array_1== true))
        {
            $cat_id = $request->cat_id;
            $is_enabled_disabled = $request->is_enabled_disabled;
            $status = $request->status;
            if($is_enabled_disabled == null)
            {
                if($status == 0)
                {
                    $app_active = AdManager::find($cat_id);
                    $app_active->is_active ='1';
                    $app_active->save();
                    return back()->with('message','Ads Disabled Successfully');
                }
                if($status == 1)
                {
                    $app_active = AdManager::find($cat_id);
                    $app_active->is_active ='0';
                    $app_active->save();
                    return back()->with('message','Ads Enabled Successfully');
                }
            }else{
                
                if($status == 0)
                {
                    $app_active = AdManager::find($is_enabled_disabled);
                    $app_active->ad_app_type ='1';
                    $app_active->save();
                    return back()->with('message','Ads Disabled Successfully');
                }
                if($status == 1)
                {
                    $app_active = AdManager::find($is_enabled_disabled);
                    $app_active->ad_app_type ='0';
                    $app_active->save();
                    return back()->with('message','Ads Enabled Successfully');
                }
            }
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Access Denied");
        }
    }

    public function delete(Request $request, $id)
    {
        LogActivity::addToLog();
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $module = Module::Select(['module_name'])->whereIn('module_name',$explode)->get();
        $permission=[];
        foreach($module as $row)
        {
            $permission[] = $row->module_name;
        }
        $permis = $permission;
        $array = in_array('ads_info', $permis);
        $array_1= in_array('delete',$explode_1);
        if(($role == "SuperAdmin") || ($array  && $array_1== true))
        {
            $request->validate([
                'ad_app_type'=>'required',
            ],[
                'ad_app_type.required' => "Do you want to delete the Ads ID? Please select an Ad App Type before proceeding..",
            ]);
            $Q1 = AdManager::find($id);
            $Q1->deleted_at = '1';
            $Q1->save();
            $app_id = AppList::find($Q1->app_id);
            if($request->ad_app_type == 1)
            {
                if($app_id->google_ads_id != null)
                {
                    $app_id->which_is_active_ads_id = 1;
                    $app_id->facebook_ads_id = null;
                    $app_id->save();
                }else{
                    $app_id->which_is_active_ads_id = 0;
                    $app_id->facebook_ads_id = null;
                    $app_id->save();
                }
            }
            else if($request->ad_app_type == 2)
            {
                if($app_id->facebook_ads_id != null)
                {
                    $app_id->which_is_active_ads_id = 2;
                    $app_id->google_ads_id = null;
                    $app_id->save();
                }else{
                    $app_id->which_is_active_ads_id = 0;
                    $app_id->google_ads_id = null;
                    $app_id->save();
                }
            }else{
                $app_id->which_is_active_ads_id = 0;
                $app_id->save();
            }
            return back()->with('message','Delete Record Successfully');
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Access Denied");
        }
    }

    public function EditCategory($id)
    {
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $module = Module::Select(['module_name'])->whereIn('module_name',$explode)->get();
        $permission=[];
        foreach($module as $row)
        {
            $permission[] = $row->module_name;
        }
        $permis = $permission;
        $array = in_array('ads_info', $permis);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array  && $array_1== true))
        {
            $edit = AdManager::find($id);
            $array = array($edit);
            $apps = AppList::where('deleted_at',0)->where('is_active',0)->get();
            return view('admin.category.edit_Category_list', ['edit_category_id'=> $array,'apps'=>$apps]);
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Access Denied");
        }
       
    }

    public function EditCatList(Request $request,$id)
    {
        $request->validate([
            'app_id' => 'required|string|max:255',
            "ad_app_type" => "required",
            "multiple_banner_id.*" => "required",
            "multiple_interstitial_id.*" => "required",
            "multiple_native_advanced_id.*" => "required"
        ],
        [
            "multiple_banner_id.*.required"=>'Please Fill Muliple Banner ID Field',
            "multiple_interstitial_id.*.required"=>'Please Fill Muliple Interstitial ID Field',
            "multiple_native_advanced_id.*.required"=>'Please Fill Muliple Native Advanced ID Field'
        ]);

        $user = AdManager::find($id);
        $user->app_id = $request['app_id'];
        $app_list = AppList::find($request['app_id']);
        $user->app_type = $app_list->app_type;
        $user->ad_app_type = $request->ad_app_type;
        $user->app_open_id = $request->app_open_id;
        $user->ad_app_id = $request->ad_app_id ?? 1;

        if(!empty($request->meadium_rectangle))
        {
            $user->ad_meadium_rectangle_id = $request->meadium_rectangle;
        }

        $array_1 = array_diff($request->multiple_medium_rectangle_id,[null]);
        if(!empty($array_1))
        {
            $array = array_diff($request->multiple_medium_rectangle_id,[null]);
            $user->multiple_medium_rectangle_id  = implode(',',$array);
        }
        else
        {
            $user->multiple_medium_rectangle_id  = '';
        }

        if(!empty($request->banner_id))
        {
            $user->ad_banner_id = $request->banner_id;
        }

        $array_1 = array_diff($request->multiple_banner_id,[null]);
        if(!empty($array_1))
        {
            $array = array_diff($request->multiple_banner_id,[null]);
            $user->multiple_banner_id  = implode(',',$array);
        }
        else
        {
            $user->multiple_banner_id  = '';
        }

        if(!empty($request->interstitial_id))
        {
            $user->ad_intercial_id = $request->interstitial_id;
        }

        $array_2 = array_diff($request->multiple_interstitial_id,[null]);
        if(!empty($array_2))
        {
            $multiple_interstitial_id = array_diff($request->multiple_interstitial_id,[null]);
            $user->multiple_interstitial_id  = implode(',',$multiple_interstitial_id);
        }
        else
        {
            $user->multiple_interstitial_id  = '';
        }

        if(!empty($request->native_advanced_id))
        {
            $user->ad_native_advanced = $request->native_advanced_id;
        }

        $array_3 = array_diff($request->multiple_native_advanced_id,[null]);
        if(!empty($array_3))
        {
            $multiple_native_advanced_id = array_diff($request->multiple_native_advanced_id,[null]);
            $user->multiple_advanced_id  = implode(',',$multiple_native_advanced_id);
        }
        else
        {
            $user->multiple_advanced_id  = '';
        }
        // naveen
        $user->audio_banner_id = $request->audio_banner_id;
        $user->audio_interstitial_id = $request->audio_interstitial_id;
        $user->ad_rewards = $request->ad_rewards ?? '';
        $user->ad_rewarded_intencial = $request->rewarded_interstitial ?? '';
        $user->ad_intencial_video = $request->interstitial_video ?? '';
        $user->ad_native_advanced_video	 = $request->native_advance_video ?? '';

        $user->is_show_ads_biblereadingscreen = $request->is_show_ads_biblereading_screen ?? 0;
        $user->biblereadingscreen_ads_verse_interval = $request->biblereadingscreen_ads_verse_interval ?? '';
        
        $user->auto_ads_load = $request->auto_ads_load ?? 0;
        $user->auto_ads_load_duration = $request->auto_ads_load_duration ?? 5;
        
        //Field Refrence added 
        $user->adBanner = $request->adBanner ?? '2';
        $user->multipleAdBanner = $request->multipleAdBanner ?? '2';
        $user->interstitial = $request->interstitial ?? '2';
        $user->multipleInterstitial = $request->multipleInterstitial ?? '2';
        $user->native = $request->native ?? '2';
        $user->multipleNative = $request->multipleNative ?? '2';
        $user->rectangle = $request->rectangle ?? '2';
        $user->multipleRectangle = $request->multipleRectangle ?? '2';

        $user->save();
        
        if($user)
        {
            $id = $user->id;
            $ad_app_type = $request->ad_app_type;
            if($ad_app_type == 1)
            {
                $app_list = AppList::find($request['app_id']);
                if($app_list->facebook_ads_id != $id && $app_list->unity_ads_id != $id)
                {
                    $app_list->google_ads_id = $id;
                }
                $app_list->save();
            }else if($ad_app_type == 2){
                $app_list = AppList::find($request['app_id']);
                if($app_list->google_ads_id != $id && $app_list->unity_ads_id != $id)
                {
                    $app_list->facebook_ads_id = $id;
                }
                $app_list->save();
            }else if($ad_app_type == 3){
                $app_list = AppList::find($request['app_id']);
                if($app_list->google_ads_id != $id && $app_list->facebook_ads_id != $id)
                {
                    $app_list->unity_ads_id = $id;
                }
                $app_list->save();
            }

        }

        return back()->with('message','Ads Edited Successfully');
    }

    // function get_add_type(Request $request)
    // {
    //     $app_id = $request->app_id;
    //     if(!empty($app_id) && $app_id != null)
    //     {
    //         $google_id = AdManager::where('app_id',$app_id)->where('ad_app_type',1)->where('deleted_at',0)->count();
    //         $facebook_id = AdManager::where('app_id',$app_id)->where('ad_app_type',2)->where('deleted_at',0)->count();
    //         // dd($google_id,$facebook_id);
    //         if($google_id == 1 && $facebook_id == 1)
    //         {
    //             echo 3; 
    //         }else if($google_id == 0 && $facebook_id == 1)
    //         {
    //             echo 2;
    //         }else if($google_id == 1 && $facebook_id == 0)
    //         {
    //             echo 1; 
    //         }else{
    //             echo 0;
    //         }
    //     }
    // }
    
    function get_add_type(Request $request)
    {
        $app_id = $request->app_id;
    
        if (!empty($app_id) && $app_id != null) {
            $google_exists = AdManager::where('app_id', $app_id)
                                      ->where('ad_app_type', 1)
                                      ->where('deleted_at', 0)
                                      ->exists();
    
            $facebook_exists = AdManager::where('app_id', $app_id)
                                        ->where('ad_app_type', 2)
                                        ->where('deleted_at', 0)
                                        ->exists();
    
            $unity_exists = AdManager::where('app_id', $app_id)
                                     ->where('ad_app_type', 3)
                                     ->where('deleted_at', 0)
                                     ->exists();
    
            return response()->json([
                'google' => $google_exists,
                'facebook' => $facebook_exists,
                'unity' => $unity_exists
            ]);
        }
    
        return response()->json([
            'google' => false,
            'facebook' => false,
            'unity' => false
        ]);
    }
}
