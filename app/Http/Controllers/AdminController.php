<?php

namespace App\Http\Controllers;
// namespace App\Http\Controllers\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Validator, Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Models\admin;
use App\Models\Module;
use App\Models\AppList;
use App\Models\Category;
use App\Models\AdManager;
use App\Helpers\LogActivity;
use App\Models\Dictionary;
use DB;

class AdminController extends Controller
{
    // public function authenticate(Request $request)
    // {
    //     $this->validate($request, [
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $user = admin::where('email', $request->email)->first();
    //     $key = "Skyraan@123";
    //     $check_key = Hash::make($key);
    //     if ($user && $user->is_active == 0 && $user->deleted_at == 0) {
    //         if (Hash::check($request->password, $user->password) && Hash::check($request->password2, $check_key)) {
    //             // Both passwords match, so the user can be authenticated
    //             if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
    //                 // Successful login
    //                 LogActivity::addToLog();
    //                 return redirect()->route('admin/dashboard')->with('message',"Welcome - ".$request->email);
    //             } else {
    //                 // Authentication failed
    //                 session()->flash('error', 'Authentication failed. Please try again.');
    //                 return back()->withInput($request->only('email'));
    //             }
    //         } else {
    //             // Passwords do not match
    //             session()->flash('error', 'Authentication failed. Passwords or Key do not match.');
    //             return back()->withInput($request->only('email'));
    //         }
    //     } elseif ($user) {
    //         // User is not active or is deleted
    //         session()->flash('error', 'You can\'t access this site right now!');
    //         return back()->withInput($request->only('email'));
    //     } else {
    //         // User not found
    //         session()->flash('error', 'Either Email/Password is incorrect - Please Try Again');
    //         return back()->withInput($request->only('email'));
    //     }
    // }

    public function authenticate(Request $request)
    {
        $captchaRules = [
            'captcha1' => 'required',
            'captcha2' => 'required',
            'captcha3' => 'required',
            'captcha4' => 'required',
            'password2'=> 'required',
            // 'captcha5' => 'required',
            // 'captcha6' => 'required',
        ];

        // Validate individual captcha inputs
        $validator = Validator::make($request->all(), $captchaRules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Combine individual captcha inputs into a single value
        $combinedCaptcha = $request->input('captcha1') .
                           $request->input('captcha2') .
                           $request->input('captcha3') .
                           $request->input('captcha4') .
                           $request->input('captcha5') .
                           $request->input('captcha6');

        // Validate the combined captcha value
        $validator = Validator::make([
            'captcha' => $combinedCaptcha,
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ], [
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ], [
            'captcha.captcha' => 'Invalid captcha code.',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = admin::where('email', $request->email)->first();
        $key = "C3DCG3Q57E30";
        $check_key = Hash::make($key);
        if ($user && $user->is_active == 0 && $user->deleted_at == 0) {
            if (Hash::check($request->password, $user->password) && Hash::check($request->password2, $check_key)) {
                // Both passwords match, so the user can be authenticated
                if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                    // Successful login
                    LogActivity::addToLog();
                    return redirect()->route('admin/dashboard')->with('message',"Welcome - ".$request->email);
                } else {
                    // Authentication failed
                    // session()->flash('error', );
                    $Array = ['Authentication failed. Password does not match. Please ensure that the entered passwords match each other.'];
                    return redirect()->back()->withErrors($Array)->withInput($request->only('email'));
                    // return back()->withInput();
                }
            } else {
                // Passwords do not match
                // session()->flash('error', 'Authentication failed. Passwords or Key do not match.');
                // return back()->withInput($request->only('email'));
                
                $Array = ['Sorry, the entered passwords do not match. Please double-check and try again.'];
                return redirect()->back()->withErrors($Array)->withInput($request->only('email'));
            }
        } elseif ($user) {
            // User is not active or is deleted
            $Array = ["You can't access this site right now!"];
            return redirect()->back()->withErrors($Array)->withInput($request->only('email'));
        } else {
            // User not found
            // session()->flash('error', 'Either Email/Password is incorrect - Please Try Again');
            // return back()->withInput($request->only('email'));
            $Array = ['Either the email or password is incorrect. Please try again.'];
            return redirect()->back()->withErrors($Array)->withInput($request->only('email'));
        }
    }

    // public function authenticate(Request $request) 
    // {
    //     $this->validate($request,[
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);
    //     $app_active = admin::where('email',$request->email)->get();
    //     if(count($app_active) && !empty($app_active))
    //     {
    //         foreach($app_active as $user)
    //         {
    //             if($user->is_active == 0 && $user->deleted_at == 0)
    //             {
    //                 if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password],$request->get('remember'))) 
    //                 {
    //                     LogActivity::addToLog();
    //                     return redirect()->route('admin/dashboard')->with('message',"Welcome - ".$request->email);
    //                 } 
    //                 else 
    //                 {
    //                     session()->flash('error','Either Email/Password is incorrect - Please Try Again');
    //                     return back()->withInput($request->only('email'));
    //                 }
    //             }
    //             else
    //             {
    //                 session()->flash('error'," “ You can't access this site right now!.. “");
    //                 return back()->withInput($request->only('email'));
    //             }
    //         }
    //     }
    //     else
    //     {
    //         session()->flash('error','Either Email/Password is incorrect - Please Try Again');
    //         return back()->withInput($request->only('email'));
    //     }
    // }

    public function logout() {
        LogActivity::addToLog();
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('message',"Logout Successfully");
    }

    public function dashboard()
    {
        $apps = AppList::orderBy('id','asc')->where('deleted_at','0')->get();
        $prayer = AdManager::orderBy('id','asc')->where('deleted_at','0')->get();
        return view('admin.dashboard',compact('apps','prayer'));
    }

    public function profile_update(Request $request)
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
        $array = in_array('admin_info', $permis);
        $array_1= in_array('view',$explode_1);
        if(($role == "SuperAdmin") || ($array == true &&  $array_1 == true))
        {
            if (in_array('profile-settings', $_GET)) {
                if (array_key_exists('key', $_GET) && ($_GET['key'] == "profile-settings" && in_array('setting_menu', $permis)) || ($role == "SuperAdmin")) {
                    return view('admin.accounts.profile_update');
                } else {
                    return redirect()->route('admin/dashboard')->with("error", "Access Denied");
                }
            } else {
                return view('admin.accounts.profile_update');
            }
            
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Access Denied");
        }
    }
 
    public function profileUpdate(Request $request)
    {
        LogActivity::addToLog();
        $request->validate([
            'name' =>'required|min:8|string|max:25',
            'email'=>'required|email|string|max:255',
        ]);
        $user = Auth::guard('admin')->user();
        $user->name = $request['name'];
        $user->email = $request['email'];
        if($request->password != null)
        {
            if (!Hash::check($request->currentPassword, Auth::guard('admin')->user()->password)) {
                return redirect()->back()->with('error', 'Current password is incorrect.');
            }
            $request->validate(
            [
                'currentPassword' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);
            $user->password = Hash::make($request['password']);
        }
        if($request->hasFile('file'))
        { 
            $image = $request['file'];
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
            $image->move(public_path('user'),$new_name);
            $new_name_2= 'user/'.$new_name;
            $uploaded_file = $new_name_2 ?? ''; 
            $user->image = $uploaded_file;
        }
        $user->save();
        return back()->with('message','Profile Updated Successfully');

        
    }

    public function superadmin() 
    {
        $user_id =Auth::guard('admin')->user()->id;
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
        $array = in_array('admin_info', $permis);
        $array_1= in_array('view',$explode_1);
        if(($role == "SuperAdmin") || ($array == true &&  $array_1 == true))
        {
            if($role == "SuperAdmin")
            {
                $superadmin = admin::orderBy('role','asc')->whereNot('Role','SuperAdmin')->where('deleted_at','0')->get();
            }else{
                $superadmin = admin::orderBy('role','asc')->whereNot('id',Auth::guard('admin')->user()->id)->whereNot('Role','SuperAdmin')->where('deleted_at','0')->get();
            }
            return view('admin.accounts.admin_accounts', ['superadmin' => $superadmin]);
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Access Denied");
        }
    }

    function add()
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
        $array = in_array('admin_info', $permis);
        $array_1= in_array('add',$explode_1);
        if(($role == "SuperAdmin") || ($array == true &&  $array_1 == true))
        {
            $module = Module::all();
            return view('admin.accounts.add_admmin',['module'=>$module]);
        }
        else
        {
            
            return redirect()->route('admin/dashboard')->with("error","Access Denied");
        }
    }

    function insert(Request $request)
    {
        
        $request->validate([
            'name' =>'required|min:8|string|max:25',
            'email'=>'required|email|string|max:255',
            "password" => 'required|confirmed|min:8',
            'model'=>'required',
            'privileges'=>'required',
        ],
        [
            'password.same'=>'password are not the same password must match same value',
            'password.min'=>'confirm-password length must be greater than 8 characters',
        ]);
        $user = new admin;
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->image = $request['file'];
        $user->password = Hash::make($request['password']);

        $arrays = implode("|", $request->model);
        $user->accountAccessModule = $arrays ?? '';
        $accountAccessPrivilege = implode("|", $request->privileges);
        $user->accountAccessPrivilege = $accountAccessPrivilege ?? '';

        $user->role = $request->parent;
        if($request->file_type == 1)
        {
            $user->image_type = $request->file_type;
            if($request->hasFile('file'))
            {
                $image = $request['file'];
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
                $image->move(public_path('user'),$new_name);
                $new_name_2= 'user/'.$new_name;
                $uploaded_file = $new_name_2 ?? '';
                $user->image = $uploaded_file;
            }
        }
        else if($request->file_type == 2)
        {
            $user->image = $request->url_image;
            $user->image_type = $request->file_type;
        }
        LogActivity::addToLog();
        $user->save();
        return back()->with('message','Admin Create Successfully');
    }

    public function edit($id)
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
        $array = in_array('admin_info', $permis);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array == true &&  $array_1 == true))
        {
            $edit = admin::find($id);
            $array = array($edit);
            $module = Module::all();          
  
            return view('admin.accounts.edit_admin', ['edit'=> $array,'module'=>$module]);
        }
        else
        {
            return redirect()->route('superadmin')->with("error","Access Denied");
        }
    }

    public function editlist(Request $request,$id)
    {
        
        $request->validate([
            'name' =>'required|min:8|string|max:25',
            'email'=>'required|email|string|max:255',
            'model'=>'required',
            'privileges'=>'required',
        ]);

        $user = admin::find($id);
        $user->role = $request->parent;
        $user->name = $request['name'];
        $user->email = $request['email'];

        if($request->password != null)
        {
            $request->validate([ "password" => 'required|confirmed|min:8'
            ],[
                'password.same'=>'password are not the same password must match same value',
                'password.min'=>'confirm-password length must be greater than 8 characters',
            ]);
            $user->password = Hash::make($request['password']);
        }
        
        $arrays = implode("|", $request->model);
        $user->accountAccessModule = $arrays ?? '';
        $accountAccessPrivilege = implode("|", $request->privileges);
        $user->accountAccessPrivilege = $accountAccessPrivilege ?? '';
        $user->role = $request->parent;
        if($request->file_type == 1)
        {
            $user->image_type = $request->file_type;
            if($request->hasFile('file'))
            {
                $image = $request['file'];
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
                $image->move(public_path('user'),$new_name);
                $new_name_2= 'user/'.$new_name;
                $uploaded_file = $new_name_2 ?? '';
                $user->image = $uploaded_file;
            }
        }
        else if($request->file_type == 2)
        {
            $user->image = $request->url_image;
            $user->image_type = $request->file_type;
        }
        LogActivity::addToLog();
        $user->save();
        return back()->with('message','Admin Updated Successfully');
    }

    public function active(Request $request)
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
        $array = in_array('admin_info', $permis);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array  && $array_1== true))
        {
            $parent_id = $request->user_id;
            $status = $request->status;
            LogActivity::addToLog();
            if($status == 0)
            {
                $app_active = admin::find($parent_id);
                $app_active->is_active ='1';
                $app_active->save();
                return back()->with('message','Admin Disabled Successfully');
            }
            if($status == 1)
            {
                $app_active = admin::find($parent_id);
                $app_active->is_active ='0';
                $app_active->save();
                return back()->with('message','Admin Enabled Successfully');
            }
        }
        else
        {
            return redirect()->route('superadmin')->with("error","Access Denied");
        }
    }

    public function delete(Request $request, $id)
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
        $array = in_array('admin_info', $permis);
        $array_1= in_array('delete',$explode_1);
        if(($role == "SuperAdmin") || ($role == "Administrator") || ($array == true &&  $array_1 == true))
        {
            $Q1 = admin::find($id);
            $Q1->deleted_at = '1';
            LogActivity::addToLog();
            $Q1->save();
            return back()->with('message','Delete Record Successfully');
        }
        else
        {
            return redirect()->route('superadmin')->with("error","Access Denied");
        }
    }

    public function activitydelete(Request $request)
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
        $array = in_array('admin_info', $permis);
        $array_1= in_array('delete',$explode_1);
        if(($role == "SuperAdmin") || ($role == "Administrator") || ($array == true &&  $array_1 == true))
        {
            $log = LogActivity::logActivityLists()->find($request->checkbox)
            ->each(function ($activity, $key) 
            {
                $activity->delete();
            });
            LogActivity::addToLog();
            return back()->with('message','Delete Record Successfully');
        }
        else
        {
            return redirect()->route('superadmin')->with("error","Access Denied");
        }
    }


    public function refreshCaptcha()
    {
        return response()->json(['captcha'=> captcha_img('flat', ['characters' => '0123456789','class' => 'img-responsive'],'numeric', 6)]);
    }

    
    public function upload(Request $request)
    {
        
        if($request->hasFile('upload')) 
        {
            $image = $request->file('upload');
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
            $image->move(public_path('upload'),$new_name);
            $new_name_2 = 'upload/'.$new_name;


            $url = asset($new_name_2);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $msg = 'Image successfully uploaded'; 
            LogActivity::addToLog();
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8'); 
            echo $re;
        }
    }
    
}
