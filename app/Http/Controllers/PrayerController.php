<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\AppList;
use App\Models\Module;
Use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Prayer;
use App\Helpers\LogActivity;
use App\Models\Category;
use App\Models\Image;

class PrayerController extends Controller
{
    public function show()
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
        $array = array_intersect($explode, $permis);
        $array_1= in_array('view',$explode_1);
        if(($role == "SuperAdmin") || ($array == true &&  $array_1 == true))
        {
            $questions = Prayer::orderBy('id','asc')->where('deleted_at','0')->get();
            return view('admin.prayer.prayer_list',['questions'=> $questions]);
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
        $array = array_intersect($explode, $permis);
        $array_1= in_array('add',$explode_1);
        if(($role == "SuperAdmin") || ($array  && $array_1== true))
        {
            $category = Category::where('deleted_at','0')->get();
            return view('admin.prayer.add_prayer', ['language' => $category]);
        }
        else
        {
            return redirect()->route('admin.question')->with("error","Access Denied");
        }
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
        $array = array_intersect($explode, $permis);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array  && $array_1== true))
        {
            $cat_id = $request->app_id;
            $status = $request->status;
            if($status == 0)
            {
                $app_active = Prayer::find($cat_id);
                $app_active->is_active ='1';
                $app_active->save();
                return back()->with('message','Font Disabled Successfully');
            }
            if($status == 1)
            {
                $app_active = Prayer::find($cat_id);
                $app_active->is_active ='0';
                $app_active->save();
                return back()->with('message','Font Enabled Successfully');
            }
        }
        else
        {
            return redirect()->route('admin.question')->with("error","Access Denied");
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'language'=>'required',
            'font_name'=>'required',
            'file' =>'required'
        ],[
            'language.required'=>'Please Select Atleast one language',
            'font_name.required'=>'Please Fill the Font Name',
            'file.required'=>'Font File is Required',
        ]);
    
        $id = Auth::guard('admin')->user()->id;
        $user = new Prayer;
        $user->font_name = $request->font_name;
        $user->language_code = $request->language;

        $user->admin_id = $id;
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
            $image->move(public_path('font'),$new_name);
            $new_name_2 = 'font/'.$new_name;
            $uploaded_file = $new_name_2 ?? '';        
            $user->font_file = $uploaded_file;
        }

        LogActivity::addToLog();
        $user->save();
        return back()->with('message','Font Created Successfully!....');
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
        $array = array_intersect($explode, $permis);
        $array_1= in_array('delete',$explode_1);
        if(($role == "SuperAdmin") || ($array  && $array_1== true))
        {
            $Q1 = Prayer::find($id);
            $Q1->deleted_at = '1';
            $Q1->save();
            return back()->with('message','Delete Record Successfully');
        }
        else
        {
            return back()->with("error","Permission Denied");
        }
    }
    public function EditQuestion($id)
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
        $array = array_intersect($explode, $permis);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array  && $array_1== true))
        {
            $edit = Prayer::find($id);
            $category = Category::where('deleted_at','0')->get();
            $array = array($edit);
            return view('admin.prayer.edit_prayer_list', ['edit_question_id'=> $array],['category_id' => $category]);
        }
        else
        {
            return redirect()->route('admin.question')->with("error","Access Denied");
        }
    }

    public function EditQuestionList(Request $request, $id)
    {
        $request->validate([
            'language'=>'required',
            'font_name'=>'required',
        ],[
            'language.required'=>'Please Select Atleast one language',
            'font_name.required'=>'Please Fill the Font Name',
        ]);
    
        $asdmin_id = Auth::guard('admin')->user()->id;
        $file = Prayer::where('id',$id)->get();

        foreach($file as $row)
        {
            $files_list = $row->font_file;
        }

        $user = Prayer::find($id);
        $user->font_name = $request->font_name;
        $user->language_code = $request->language;

        $user->admin_id = $asdmin_id;
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
            $image->move(public_path('font'),$new_name);
            $new_name_2 = 'font/'.$new_name;
            $uploaded_file = $new_name_2 ?? '';        
            $user->font_file = $uploaded_file;
        }
        else
        {
            $user->font_file = $files_list;
        }

        LogActivity::addToLog();
        $user->save();
        return back()->with('message','Font Edited Successfully!....');
    }
    public function upload(Request $request)
    {
        
        if($request->hasFile('upload')) 
        {
            $filenamewithextension = $request->file('upload')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $filenametostore = $filename.'_'.time().'.'.$extension;
            $filename_change = $request->file('upload')->storeAs('public/files/ckeditor_image',$filenametostore);
            $new_name = 'files/ckeditor_image/'.$filenametostore;
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/'.$new_name); 
            $msg = 'Image successfully uploaded'; 
            LogActivity::addToLog();
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8'); 
            echo $re;
        }
    }
}
