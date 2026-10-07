<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\AppList;
use App\Models\Module;
Use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Helpers\LogActivity;
use App\Models\LetterCount;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentExport;


class CategoryController extends Controller
{

    function show()
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
        $array_1= in_array('view',$explode_1);
        if(($role == "SuperAdmin") || ($array == true &&  $array_1 == true))
        {
            $category = Category::orderBy('id','asc')->where('deleted_at','0')->get();
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
            return view('admin.category.add_category');
        }
        else
        {
            return redirect()->route('category.list')->with("error","Access Denied");
        }
        
    }

    public function store(Request $request)
    {
        
        $valiadte = $request->validate([
            'category_name' => 'required|string|max:255',
            'category_description' => 'required',
            'file' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
        ]);
        $user = new Category;
        $user->language_name = $request['category_name'];
        $user->language_code = $request['category_description'];
        $user->save();
        if($user)
        {
            LogActivity::addToLog();
            return back()->with('message','Category Created Successfully');
        }
        else
        {
            LogActivity::addToLog();
            return back()->with('error','Something Went Wrong');
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
        $array = in_array('ads_info', $permis);
        $array_1= in_array('edit',$explode_1);
        if(($role == "SuperAdmin") || ($array  && $array_1== true))
        {
            $cat_id = $request->cat_id;
            $status = $request->status;
            if($status == 0)
            {
                $app_active = Category::find($cat_id);
                $app_active->is_active ='1';
                $app_active->save();
                return back()->with('message','Category Disabled Successfully');
            }
            if($status == 1)
            {
                $app_active = Category::find($cat_id);
                $app_active->is_active ='0';
                $app_active->save();
                return back()->with('message','Category Enabled Successfully');
            }
        }
        else
        {
            return redirect()->route('category.list')->with("error","Access Denied");
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
            $Q1 = Category::find($id);
            $Q1->deleted_at = '1';
            $Q1->save();
            return back()->with('message','Delete Record Successfully');
        }
        else
        {
            return redirect()->route('category.list')->with("error","Access Denied");
        }
    }

    public function EditCategory($id)
    {
        //     LogActivity::addToLog();
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
            $edit = Category::find($id);
            $array = array($edit);
            return view('admin.category.edit_Category_list', ['edit_category_id'=> $array]);
        }
        else
        {
            return redirect()->route('category.list')->with("error","Access Denied");
        }
       
    }

    public function EditCatList(Request $request, $id)
    {
        $request->validate([
            'editcatname' => 'required|string|max:255',
            'editcatdescription' => 'required',
            'file' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
        ]);

        $user = Category::find($id);
        $user->language_name = $request->input('editcatname');
        $user->language_code = $request->input('editcatdescription');
        $user->save();
        if($user)
        {
            LogActivity::addToLog();
            return back()->with('message','Category Edit Successfully');
        }
        else
        {
            LogActivity::addToLog();
            return back()->with('error','Something Went Wrong');
        }
    }


    public function uploadFile(Request $request)
    {
        $file = $request->file('csvfile');
        
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();
        $valid_extension = array("csv");
    
        $maxFileSize = 4194304; 
        if(in_array(strtolower($extension),$valid_extension))
        {   
            if($fileSize <= $maxFileSize)
            {
                
                $location = 'uploads';
            
                $file->move($location,$filename);
        
                $filepath = public_path($location."/".$filename);
        
                $file = fopen($filepath,"r");
                
                $importData_arr = array();
                $i = 0;
        
                while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) 
                {
                    $num = count($filedata);        
                    
                    for ($c=0; $c < $num; $c++) 
                    {
                        $importData_arr[$i][] = $filedata[$c];
                    }
                    $i++;
                }
                fclose($file);
                $skip = 0;
                foreach($importData_arr as $key =>$importData)
                {
                    $insertData = array(
                        "letters" => $importData[0],
                    );  
                    LetterCount::create($insertData);
                }
                return back()->with('message','Import Successfully!.....');
            }
            else
            {
                return back()->with('error','File too large. File must be less than 4MB.');
            }
        }
        else
        {
            return back()->with('error','Invalid File Extension.');
        }
    }


    public function fileExport($category_id)
    {
        return Excel::download(new StudentExport($category_id), 'Letters-collection.xlsx');
    }
}
