<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\AppList;
use App\Models\Module;
Use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Prayer;
use App\Models\MappedAppCategory;
use App\Helpers\LogActivity;
use DataTables;

use Illuminate\Database\Eloquent\Relations\HasMany;

class AppController extends Controller
{
    public function show(Request $request)
    {
        
        if($request->ajax())
        {
            if(request()->filled('issue_type') == false && request()->filled('app_type') == false)
            {
                $categorys = AppList::query()->where('deleted_at',0);
                return DataTables::of($categorys)
                ->addColumn('app_type', function ($category) {
                    return $category->app_type == 1 ? 'Android' : 'IOS';
                })
                ->addColumn('package_name', function ($category) {
                    if($category->app_type == 1)
                    {
                        return '<div><span class="fw-bold">Package Name - </span>'.$category->package_name.'</div>';
                    }else{
                        return '<div><span class="fw-bold">Apple ID - </span>'.$category->apple_id.'<br><span class="fw-bold">Bundle ID - </span>'.$category->bundle_id.'</div>';
                    }
                })
                ->addColumn('add_app_type', function ($row) {
                    $id = $row->id;
                
                    // Common button class for size & style
                    $btnClass = 'btn btn-icon btn-circle btn-sm';
                    $btnStyle = 'width: 34px; height: 34px; display: flex; align-items: center; justify-content: center;';
                
                    // Icons
                    $googleIcon = '<i class="fa fa-google" style="font-size: 18px !important;"></i>';
                    $facebookIcon = '<i class="fa fa-facebook" style="font-size: 18px !important;"></i>';
                    $unityIcon = '<i class="fa fa-unity" style="font-size: 18px !important;"></i>';
                    $banIcon = '<i class="fa fa-ban" style="font-size: 18px !important;"></i>';
                
                    // Buttons (active)
                    $googleBtn = '<button type="button" class="'.$btnClass.' btn-danger" style="'.$btnStyle.'" data-bs-toggle="tooltip" title="Google">'.$googleIcon.'</button>';
                    $facebookBtn = '<button type="button" class="'.$btnClass.' btn-primary" style="'.$btnStyle.'" data-bs-toggle="tooltip" title="Facebook">'.$facebookIcon.'</button>';
                    $unityBtn = '<button type="button" class="'.$btnClass.' btn-light" style="'.$btnStyle.'" data-bs-toggle="tooltip" title="Unity">'.$unityIcon.'</button>';
                
                    // Buttons (disabled)
                    $googleBtnDisabled = '<button type="button" class="'.$btnClass.' btn-danger disabled" style="'.$btnStyle.'" data-bs-toggle="tooltip" title="Google">'.$googleIcon.'</button>';
                    $facebookBtnDisabled = '<button type="button" class="'.$btnClass.' btn-primary disabled" style="'.$btnStyle.'" data-bs-toggle="tooltip" title="Facebook">'.$facebookIcon.'</button>';
                    $unityBtnDisabled = '<button type="button" class="'.$btnClass.' btn-light disabled" style="'.$btnStyle.'" data-bs-toggle="tooltip" title="Unity">'.$unityIcon.'</button>';
                
                    // Ban button
                    $banBtn = '<button type="button" class="'.$btnClass.' btn-secondary" style="'.$btnStyle.'" data-bs-toggle="tooltip" title="Disable">'.$banIcon.'</button>';
                
                    // Add spacing (gap) using margin-right, except last button
                    $gap = 'style="margin-right: 6px;"';
                
                    // Choose button states based on active ad type
                    if ($row->which_is_active_ads_id == 1) {
                        return '<div style="display: flex; justify-content: center;">'
                            .'<div '.$gap.'>'.$googleBtn.'</div>'
                            .'<div class="px-1 fade-disabled" style="cursor: wait !important;" '.$gap.'>'.$facebookBtnDisabled.'</div>'
                            .'<div class="px-1 fade-disabled" style="cursor: wait !important;" '.$gap.'>'.$unityBtnDisabled.'</div>'
                            .'<div class="px-1 fade-disabled" style="cursor: wait !important;" >'.$banBtn.'</div>'
                        .'</div>';
                    } elseif ($row->which_is_active_ads_id == 2) {
                        return '<div style="display: flex; justify-content: center;">'
                            .'<div class="px-1 fade-disabled" style="cursor: wait !important;" '.$gap.'>'.$googleBtnDisabled.'</div>'
                            .'<div '.$gap.'>'.$facebookBtn.'</div>'
                            .'<div class="px-1 fade-disabled" style="cursor: wait !important;" '.$gap.'>'.$unityBtnDisabled.'</div>'
                            .'<div class="px-1 fade-disabled" style="cursor: wait !important;" >'.$banBtn.'</div>'
                        .'</div>';
                    } elseif ($row->which_is_active_ads_id == 3) {
                        return '<div style="display: flex; justify-content: center;">'
                            .'<div class="px-1 fade-disabled" style="cursor: wait !important;" '.$gap.'>'.$googleBtnDisabled.'</div>'
                            .'<div class="px-1 fade-disabled" style="cursor: wait !important;" '.$gap.'>'.$facebookBtnDisabled.'</div>'
                            .'<div '.$gap.'>'.$unityBtn.'</div>'
                            .'<div class="px-1 fade-disabled" style="cursor: wait !important;" >'.$banBtn.'</div>'
                        .'</div>';
                    } else {
                        return '<div style="display: flex; justify-content: center;">'
                            .'<div  class="px-1 fade-disabled" style="cursor: wait !important;" '.$gap.'>'.$googleBtnDisabled.'</div>'
                            .'<div  class="px-1 fade-disabled" style="cursor: wait !important;" '.$gap.'>'.$facebookBtnDisabled.'</div>'
                            .'<div  class="px-1 fade-disabled" style="cursor: wait !important;" '.$gap.'>'.$unityBtnDisabled.'</div>'
                            .'<div class="px-1 fade-disabled" style="cursor: wait !important;" >'.$banBtn.'</div>'
                        .'</div>';
                    }
                })
                ->addColumn('app_image', function ($row) {
                    if($row->app_image == null)
                    {
                        $app = asset('images/no-camera.png');
                        return '<center><img  src="'.$app.'" style="width: 55px !important;height: 55px !important; border-radius: 10px !important;box-shadow: 0px 0px 15px #405189 !important;border:2px !important;opacity: 85% !important;"></center>';
                    }else if($row->app_image_type == 1)
                    {
                        $app = asset($row->app_image);
                        return '<center><img  src="'.$app.'" style="width: 55px !important;height: 55px !important; border-radius: 10px !important;box-shadow: 0px 0px 15px #405189 !important;border:2px !important;opacity: 85% !important;"/></center>';
                    }else{
                        return '<center><img  src="'.$row->app_image.'" style="width: 55px !important;height: 55px !important; border-radius: 10px !important;box-shadow: 0px 0px 15px #405189 !important;border:2px !important;opacity: 85% !important;"/></center>';
                    }
                })
                ->addColumn('click_button', function ($row) {
                    $url = $row->app_type == 1 ? $row->playstore_url : $row->appstore_url;
                    return '<div class="userDatatable-content"><a href="'.$url.'" target="_blank" class="btn btn-sm btn-primary text-white btn-outline-dark">Click</a></div>';
                })
                ->addColumn('created_at_formatted', function ($category) {
                    return $category->created_at;
                })
                ->addColumn('status', function ($category) {
                    return $category->is_active == '0' ? '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>' : '<span class="badge bg-danger rounded-fill"><i class="bi bi-exclamation-octagon me-1"></i> Deactivate</span>';
                })
                ->addColumn('action', function ($category) {
                    $editUrl = url("admin/edit_app/".$category->id);
                    $deleteUrl = url("admin/delete_app/".$category->id);
                    $view_url = url("/admin/view_app/".$category->id);

                    return '<div class="btn-group">
                                <form action="'.$view_url.'" method="POST">
                                '.csrf_field().'
                                    <input type="hidden" name="view_list" value="'.$category->id.'">
                                    <button  type="submit" class="btn btn-icon btn-circle btn-sm btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{$category->id}}"><i class="mdi mdi-exclamation"></i></button>
                                </form>
                                <form action="'.$editUrl.'" method="POST" style="padding-left:5px;">'.csrf_field().'
                                    <button type="submit" class="btn btn-icon btn-circle btn-sm btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit App">
                                        <i class="mdi mdi-pencil-box"></i>
                                    </button>
                                </form>
                                <form  id="form_submit_'.$category->id.'"  action="'.$deleteUrl.'" method="POST" style="padding-left:5px;">'.csrf_field().'
                                    <button  type="button" class="btn btn-icon btn-circle btn-sm btn-outline-danger" onclick="return validateform('.$category->id.')"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete App">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </form>
                            </div>';
                })
                ->addColumn('status_update', function ($category) {
                    $statusUpdateUrl = url('admin/app_status_update');
                    $statusText = $category->is_active == '0' ? 'Enable' : 'Disable';
                    $statusValue = $category->is_active == '0' ? '0' : '1';
                    if($statusValue == 1)
                    {
                        return '<form action="'.$statusUpdateUrl.'" method="POST">'.
                                csrf_field().
                                '<input type="hidden" name="app_id" value="'.$category->id.'">'.
                                ($category->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($category->is_active == '0' ? 'enable' : '').'" style="background: #ffad46!important;border-color: #ffad46!important;color: #fff!important;">
                                    <i class="bi bi-check-circle me-1"></i>
                                </button>
                            </form>';
                    }else{
                        
                    return '<form action="'.$statusUpdateUrl.'" method="POST">'.
                                csrf_field().
                                '<input type="hidden" name="app_id" value="'.$category->id.'">'.
                                ($category->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($category->is_active == '0' ? 'enable' : '').'" >
                                    <i class="bi bi-check-circle me-1"></i>
                                </button>
                            </form>';
                    }
                })
                ->rawColumns(['add_app_type','app_image','package_name','click_button', 'status', 'action', 'status_update','is_enabled_disabled'])
                ->filterColumn('app_type', function ($query, $keyword) {
                    $keyword = strtolower($keyword);
                    if ($keyword == 'android' || $keyword == 'ios') {
                        $query->where('app_type', $keyword == 'android' ? 1 : 2);
                    }
                })
                ->filterColumn('package_name', function ($query, $keyword) {
                    $query->where('package_name', 'like', "%{$keyword}%")
                        ->orWhere('apple_id', 'like', "%{$keyword}%")
                        ->orWhere('bundle_id', 'like', "%{$keyword}%");
                })
                ->orderColumn('app_type', function ($query, $order) {
                    $query->orderBy('app_type', $order);
                })
                ->make(true);
            }else{
                $categorys = AppList::query()->where('deleted_at',0);
                return DataTables::of($categorys)
                    ->addColumn('app_type', function ($category) {
                        return $category->app_type == 1 ? 'Android' : 'IOS';
                    })
                    ->addColumn('package_name', function ($category) {
                        if($category->app_type == 1)
                        {
                            return '<div><span class="fw-bold">Package Name - </span>'.$category->package_name.'</div>';
                        }else{
                            return '<div><span class="fw-bold">Apple ID - </span>'.$category->apple_id.'<br><span class="fw-bold">Bundle ID - </span>'.$category->bundle_id.'</div>';
                        }
                    })
                    ->addColumn('add_app_type', function ($row) {
                        $id = $row->id;
                    
                        // Common button class for size & style
                        $btnClass = 'btn btn-icon btn-circle btn-sm';
                        $btnStyle = 'width: 34px; height: 34px; display: flex; align-items: center; justify-content: center;';
                    
                        // Icons
                        $googleIcon = '<i class="fa fa-google" style="font-size: 18px !important;"></i>';
                        $facebookIcon = '<i class="fa fa-facebook" style="font-size: 18px !important;"></i>';
                        $unityIcon = '<i class="fa fa-unity" style="font-size: 18px !important;"></i>';
                        $banIcon = '<i class="fa fa-ban" style="font-size: 18px !important;"></i>';
                    
                        // Buttons (active)
                        $googleBtn = '<button type="button" class="'.$btnClass.' btn-danger" style="'.$btnStyle.'" data-bs-toggle="tooltip" title="Google">'.$googleIcon.'</button>';
                        $facebookBtn = '<button type="button" class="'.$btnClass.' btn-primary" style="'.$btnStyle.'" data-bs-toggle="tooltip" title="Facebook">'.$facebookIcon.'</button>';
                        $unityBtn = '<button type="button" class="'.$btnClass.' btn-light" style="'.$btnStyle.'" data-bs-toggle="tooltip" title="Unity">'.$unityIcon.'</button>';
                    
                        // Buttons (disabled)
                        $googleBtnDisabled = '<button type="button" class="'.$btnClass.' btn-danger disabled" style="'.$btnStyle.'" data-bs-toggle="tooltip" title="Google">'.$googleIcon.'</button>';
                        $facebookBtnDisabled = '<button type="button" class="'.$btnClass.' btn-primary disabled" style="'.$btnStyle.'" data-bs-toggle="tooltip" title="Facebook">'.$facebookIcon.'</button>';
                        $unityBtnDisabled = '<button type="button" class="'.$btnClass.' btn-light disabled" style="'.$btnStyle.'" data-bs-toggle="tooltip" title="Unity">'.$unityIcon.'</button>';
                    
                        // Ban button
                        $banBtn = '<button type="button" class="'.$btnClass.' btn-secondary" style="'.$btnStyle.'" data-bs-toggle="tooltip" title="Disable">'.$banIcon.'</button>';
                    
                        // Add spacing (gap) using margin-right, except last button
                        $gap = 'style="margin-right: 6px;"';
                    
                        // Choose button states based on active ad type
                        if ($row->which_is_active_ads_id == 1) {
                            return '<div style="display: flex; justify-content: center;">'
                                .'<div '.$gap.'>'.$googleBtn.'</div>'
                                .'<div class="px-1 fade-disabled" style="cursor: wait !important;" '.$gap.'>'.$facebookBtnDisabled.'</div>'
                                .'<div class="px-1 fade-disabled" style="cursor: wait !important;" '.$gap.'>'.$unityBtnDisabled.'</div>'
                                .'<div class="px-1 fade-disabled" style="cursor: wait !important;" >'.$banBtn.'</div>'
                            .'</div>';
                        } elseif ($row->which_is_active_ads_id == 2) {
                            return '<div style="display: flex; justify-content: center;">'
                                .'<div class="px-1 fade-disabled" style="cursor: wait !important;" '.$gap.'>'.$googleBtnDisabled.'</div>'
                                .'<div '.$gap.'>'.$facebookBtn.'</div>'
                                .'<div class="px-1 fade-disabled" style="cursor: wait !important;" '.$gap.'>'.$unityBtnDisabled.'</div>'
                                .'<div class="px-1 fade-disabled" style="cursor: wait !important;" >'.$banBtn.'</div>'
                            .'</div>';
                        } elseif ($row->which_is_active_ads_id == 3) {
                            return '<div style="display: flex; justify-content: center;">'
                                .'<div class="px-1 fade-disabled" style="cursor: wait !important;" '.$gap.'>'.$googleBtnDisabled.'</div>'
                                .'<div class="px-1 fade-disabled" style="cursor: wait !important;" '.$gap.'>'.$facebookBtnDisabled.'</div>'
                                .'<div '.$gap.'>'.$unityBtn.'</div>'
                                .'<div class="px-1 fade-disabled" style="cursor: wait !important;" >'.$banBtn.'</div>'
                            .'</div>';
                        } else {
                            return '<div style="display: flex; justify-content: center;">'
                                .'<div  class="px-1 fade-disabled" style="cursor: wait !important;" '.$gap.'>'.$googleBtnDisabled.'</div>'
                                .'<div  class="px-1 fade-disabled" style="cursor: wait !important;" '.$gap.'>'.$facebookBtnDisabled.'</div>'
                                .'<div  class="px-1 fade-disabled" style="cursor: wait !important;" '.$gap.'>'.$unityBtnDisabled.'</div>'
                                .'<div class="px-1 fade-disabled" style="cursor: wait !important;" >'.$banBtn.'</div>'
                            .'</div>';
                        }
                    })
                    ->addColumn('app_image', function ($row) {
                        if($row->app_image == null)
                        {
                            return '<center><img  src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQdoCQ7-yS62tALBS9_FY5pExwg8Lvvsie6Iml51YO_JQ&s"/ style="width: 55px !important;height: 55px !important; border-radius: 10px !important;box-shadow: 0px 0px 15px #405189 !important;border:2px !important;opacity: 85% !important;"></center>';
                        }else if($row->app_image_type == 1)
                        {
                            $app = asset($row->app_image);
                            return '<center><img  src="'.$app.'" style="width: 55px !important;height: 55px !important; border-radius: 10px !important;box-shadow: 0px 0px 15px #405189 !important;border:2px !important;opacity: 85% !important;"/></center>';
                        }else{
                            return '<center><img  src="'.$row->app_image.'" style="width: 55px !important;height: 55px !important; border-radius: 10px !important;box-shadow: 0px 0px 15px #405189 !important;border:2px !important;opacity: 85% !important;"/></center>';
                        }
                    })
                    ->addColumn('click_button', function ($row) {
                        $url = $row->app_type == 1 ? $row->playstore_url : $row->appstore_url;
                        return '<div class="userDatatable-content"><a href="'.$url.'" target="_blank" class="btn btn-sm btn-primary text-white btn-outline-dark">Click</a></div>';
                    })
                    ->addColumn('created_at_formatted', function ($category) {
                        return $category->created_at;
                    })
                    ->addColumn('status', function ($category) {
                        return $category->is_active == '0' ? '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>' : '<span class="badge bg-danger rounded-fill"><i class="bi bi-exclamation-octagon me-1"></i> Deactivate</span>';
                    })
                    ->addColumn('action', function ($category) {
                        $editUrl = url("admin/edit_app/".$category->id);
                        $deleteUrl = url("admin/delete_app/".$category->id);
                        $view_url = url("/admin/view_app/".$category->id);
    
                        return '<div class="btn-group">
                                    <form action="'.$view_url.'" method="POST">
                                    '.csrf_field().'
                                        <input type="hidden" name="view_list" value="'.$category->id.'">
                                        <button  type="submit" class="btn btn-icon btn-circle btn-sm btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{$category->id}}"><i class="mdi mdi-exclamation"></i></button>
                                    </form>
                                    <form action="'.$editUrl.'" method="POST" style="padding-left:5px;">'.csrf_field().'
                                        <button type="submit" class="btn btn-icon btn-circle btn-sm btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit App">
                                            <i class="mdi mdi-pencil-box"></i>
                                        </button>
                                    </form>
                                    <form  id="form_submit_'.$category->id.'"  action="'.$deleteUrl.'" method="POST" style="padding-left:5px;">'.csrf_field().'
                                        <button  type="button" class="btn btn-icon btn-circle btn-sm btn-outline-danger" onclick="return validateform('.$category->id.')"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete App">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                </div>';
                    })
                    ->addColumn('status_update', function ($category) {
                        $statusUpdateUrl = url('admin/app_status_update');
                        $statusText = $category->is_active == '0' ? 'Enable' : 'Disable';
                        $statusValue = $category->is_active == '0' ? '0' : '1';
                        if($statusValue == 1)
                        {
                            return '<form action="'.$statusUpdateUrl.'" method="POST">'.
                                    csrf_field().
                                    '<input type="hidden" name="app_id" value="'.$category->id.'">'.
                                    ($category->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                    '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($category->is_active == '0' ? 'enable' : '').'" style="background: #ffad46!important;border-color: #ffad46!important;color: #fff!important;">
                                        <i class="bi bi-check-circle me-1"></i>
                                    </button>
                                </form>';
                        }else{
                            
                        return '<form action="'.$statusUpdateUrl.'" method="POST">'.
                                    csrf_field().
                                    '<input type="hidden" name="app_id" value="'.$category->id.'">'.
                                    ($category->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                    '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($category->is_active == '0' ? 'enable' : '').'" >
                                        <i class="bi bi-check-circle me-1"></i>
                                    </button>
                                </form>';
                        }
                    })
                    ->rawColumns(['add_app_type','app_image','package_name','click_button', 'status', 'action', 'status_update','is_enabled_disabled'])
                    ->filterColumn('app_type', function ($query, $keyword) {
                        $keyword = strtolower($keyword);
                        if ($keyword == 'android' || $keyword == 'ios') {
                            $query->where('app_type', $keyword == 'android' ? 1 : 2);
                        }
                    })
                    ->filterColumn('package_name', function ($query, $keyword) {
                        $query->where('package_name', 'like', "%{$keyword}%")
                            ->orWhere('apple_id', 'like', "%{$keyword}%")
                            ->orWhere('bundle_id', 'like', "%{$keyword}%");
                    })
                    ->orderColumn('app_type', function ($query, $order) {
                        $query->orderBy('app_type', $order);
                    })
                    ->filter(function ($query) {
                        if (request()->filled('issue_type')) {
                            $query->where('which_is_active_ads_id', request('issue_type'));
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
        $array = in_array('app_info', $permis);
        $array_1= in_array('view',$explode_1);
        if(($role == "SuperAdmin") || ($array == true &&  $array_1 == true))
        {
            $app_type = $request->app_type ?? '';
            $apps = AppList::orderBy('id','asc')->where('deleted_at','0')->get();
            $app_active = AppList::where('is_active','1')->get();
            return view('admin.applist.app_list', compact('apps','app_active','app_type'));
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
        $array = in_array('app_info', $permis);
        $array_1= in_array('add',$explode_1);
        if(($role == "SuperAdmin") || ($array  && $array_1== true))
        {
            return view('admin.applist.add_app');
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Access Denied");
        }
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'app_name' => 'required|string|max:255',
            'app_type' => 'required',
        ]);

        $user = new AppList;
        $user->app_name = $request['app_name'];
        if($request['app_type'] == 1)
        {        
            $request->validate([
                'package_name'=>'required',
            ],[
                'package_name.required'=>'Please fill the Package Name'
            ]);

            $user->app_type = $request['app_type'];
            $user->playstore_url = "https://play.google.com/store/apps/details?id=".$request->package_name;
            $user->package_name = $request->package_name;
        }
        if($request['app_type'] == 2)
        {
            $request->validate([
                'apple_id'=>'required',
            ],[
                'apple_id.required'=>'Please fill the Apple ID'
            ]);
            $user->app_type = $request['app_type'];
            $user->appstore_url = "https://itunes.apple.com/app/".$request->apple_id;
            $user->bundle_id = $request->bundle_id;
            $user->apple_id = $request->apple_id;
        }
        if($request->thumb_upload_type == 1)
        {
            $user->app_image_type = $request->thumb_upload_type;
            
            if($request->hasFile('thumb_file'))
            { 
                $image = $request['thumb_file'];
                $image_name = $image->getClientOriginalName();
                $extension = pathinfo($image_name, PATHINFO_EXTENSION);
                $encrpt = round(microtime(true)*1000);
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $charactersLength; $i++) 
                {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                $new_name = ($encrpt).'_'.$randomString.'.'.$extension;
                $image->move(public_path('app_image'),$new_name);
                $new_name_3 = 'app_image/'.$new_name;
                $uploaded_file = $new_name_3 ?? '';
                $user->app_image = $uploaded_file;
            }
        }

        if($request->thumb_upload_type == 2)
        {
            $user->app_image_type = $request->thumb_url_image;
            $user->app_image = $request->thumb_upload_type;
        }
        $user->book_reader_interval = $request['book_reader_interval'];
        $user->book_reader_ad_format_type = $request['book_reader_ad_format_type'];

        $user->save();
        LogActivity::addToLog();
        return back()->with('message','App Created Successfully');
    }

    public function edit($id)
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
        $array = in_array('app_info', $permis);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array  && $array_1== true))
        {
            $edit = AppList::find($id);
            $category = Prayer::where('deleted_at','0')->get();
            $font = Prayer::where('language_code',$edit->language_code)->pluck('font_name')->toArray();
            $mapped_res = MappedAppCategory::select(['category_id'])->where('app_id',$id)->pluck('category_id')->toArray();
            return view('admin.applist.mapped_app_category', ['edit'=> $edit,'category_list'=>$category,'mapped_app'=>$mapped_res]);
        }
        else
        {
            return redirect()->route('admin.dashboard')->with("error","Access Denied");
        }

    }

    public function active(Request $request)
    {
        // LogActivity::addToLog();
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
        $array = in_array('app_info', $permis);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array  && $array_1== true))
        {
            $parent_id = $request->app_id;
            $status = $request->status;
            if($status == 0)
            {
                $app_active = AppList::find($parent_id);
                $app_active->is_active ='1';
                $app_active->save();
                return back()->with('message','App Disabled Successfully');
            }
            if($status == 1)
            {
                $app_active = AppList::find($parent_id);
                $app_active->is_active ='0';
                $app_active->save();
                return back()->with('message','App Enabled Successfully');
            }
        }
        else
        {
            return redirect()->route('admin.dashboard')->with("error","Access Denied");
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
        $array = in_array('app_info', $permis);
        $array_1= in_array('delete',$explode_1);
        if(($role == "SuperAdmin") || ($array  && $array_1== true))
        {
            $Q1 = AppList::find($id);
            $Q1->deleted_at = '1';
            $Q1->save();
            return back()->with('message','Delete Record Successfully');
        }
        else
        {
            return redirect()->route('admin.dashboard')->with("error","Access Denied");
        }
    }

    public function EditApp($id)
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
        $array = in_array('app_info', $permis);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array  && $array_1== true))
        {
            $edit = AppList::find($id);
            $array = array($edit);
            return view('admin.applist.edit_app_list', ['edit_app_id'=> $array]);
        }
        else
        {
            return redirect()->route('admin.dashboard')->with("error","Access Denied");
        }
    }

    public function ViewApp($id)
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
        $array = in_array('app_info', $permis);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array  && $array_1== true))
        {
            $edit = AppList::find($id);
            $array = array($edit);
            return view('admin.applist.disable_app_list', ['edit_app_id'=> $array]);
        }
        else
        {
            return redirect()->route('admin.dashboard')->with("error","Access Denied");
        }
    }
    
    public function EditAppList(Request $request, $id)
    {        
        $request->validate([
            'app_name' => 'required|string|max:255',
            'app_type' => 'required',
        ]);

        $user = AppList::find($id);
        $user->app_name = $request['app_name'];
        if($request['app_type'] == 1)
        {        
            $request->validate([
                'package_name'=>'required',
            ],[
                'package_name.required'=>'Please fill the Package Name'
            ]);

            $user->app_type = $request['app_type'];
            $user->playstore_url = "https://play.google.com/store/apps/details?id=".$request->package_name;
            $user->package_name = $request->package_name;
        }
        if($request['app_type'] == 2)
        {
            $request->validate([
                'apple_id'=>'required',
            ],[
                'apple_id.required'=>'Please fill the Apple ID'
            ]);
            $user->app_type = $request['app_type'];
            $user->appstore_url = "https://itunes.apple.com/app/".$request->apple_id;
            $user->bundle_id = $request->bundle_id;
            $user->apple_id = $request->apple_id;
        }
        if($request->thumb_upload_type == 1)
        {
            $user->app_image_type = $request->thumb_upload_type;
            if($request->hasFile('thumb_file'))
            {
                $image = $request['thumb_file'];
                $image_name = $image->getClientOriginalName();
                $extension = pathinfo($image_name, PATHINFO_EXTENSION);
                $encrpt = round(microtime(true)*1000);
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $charactersLength; $i++) 
                {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                $new_name = ($encrpt).'_'.$randomString.'.'.$extension;
                $image->move(public_path('app_image'),$new_name);
                $new_name_3 = 'app_image/'.$new_name;
                $uploaded_file = $new_name_3 ?? '';
                $user->app_image = $uploaded_file;
            }
        }

        if($request->thumb_upload_type == 2)
        {
            $user->app_image= $request->thumb_url_image; 
            $user->app_image_type = $request->thumb_upload_type;
        }

        $user->book_reader_interval = $request['book_reader_interval'];
        $user->book_reader_ad_format_type = $request['book_reader_ad_format_type'];

        $user->save();
        LogActivity::addToLog();
        return redirect()->route('admin.dashboard')->with('message','App Edit Successfully');
    }

    public function view_app_list(Request $request, $id)
    {        
        $request->validate([
            'ad_app_type' => 'required',
        ]);
        $user = AppList::find($id);
        $user->which_is_active_ads_id = $request->ad_app_type;
        if ($request->filled('ad_priority_order')) {
            $order = json_decode($request->ad_priority_order, true);
            if (is_array($order)) {
                foreach ($order as $item) {
                    if (!isset($item['ad']) || !isset($item['priority'])) {
                        continue;
                    }
                    switch ($item['ad']) {
                        case 'google':
                            $user->google_priority = $item['priority'];
                            break;
                        case 'facebook':
                            $user->facebook_priority = $item['priority'];
                            break;
                        case 'unity':
                            $user->unity_priority = $item['priority'];
                            break;
                    }
                }
            }
        }
        $user->save();
        return redirect()->back()->with('message','App Updated Successfully');
        // return redirect()->route('admin.dashboard')->with('message','App Updated Successfully');
    }
}
