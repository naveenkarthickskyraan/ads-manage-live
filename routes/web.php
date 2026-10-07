<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('admin.login');
});

Route::get('/api', function () {
    return view('admin.api.api_route_list');
});

Route::get('auth/login', function () {
    return view('auth.login');
});

Route::get('add-to-log', 'App\Http\Controllers\HomeController@myTestAddToLog');


Route::group(['prefix' => 'admin'], function() 
{
	Route::group(['middleware' => 'admin.guest'], function()
    {
		Route::view('/login','admin.login')->name('admin.login');
		Route::post('/login',[App\Http\Controllers\AdminController::class, 'authenticate'])->name('admin.auth');
	});
	
	Route::group(['middleware' => 'admin.auth'], function()
    {

        Route::get('/dashboard', [App\Http\Controllers\AdminController::class,'dashboard'])->name('admin/dashboard');
        
        Route::get('/admin_add_app', [App\Http\Controllers\AppController::class,'Add_list']);

        Route::any('/app_list',[AppController::class,'show'])->name('admin.dashboard');

        Route::post('/insert', [App\Http\Controllers\AppController::class,'store'])->name('admin.insert');

        Route::any('/edit_app/{id}',[App\Http\Controllers\AppController::class,'EditApp'])->name('admin.edit');
        
        Route::any('/view_app/{id}',[App\Http\Controllers\AppController::class,'ViewApp'])->name('admin.view_app');

        Route::post('/delete_app/{id}',[App\Http\Controllers\AppController::class,'delete'])->name('admin.delete');

        Route::any('/edit_app_list/{id}',[App\Http\Controllers\AppController::class,'EditAppList'])->name('admin.update');

        Route::any('/view_app_list/{id}',[App\Http\Controllers\AppController::class,'view_app_list'])->name('admin.view_app_list');

        Route::any('/mapped_app/{id}',[App\Http\Controllers\AppController::class,'edit'])->name('admin.mapping');

        Route::post('/update_map_cat/{id}',[App\Http\Controllers\MappedApp::class,'insert'])->name('admin.mapping_cat');

        Route::post('/app_status_update', [App\Http\Controllers\AppController::class, 'active'])->name('admin.app.status');

        //category

        Route::get('/ad_manager_list',[App\Http\Controllers\AdManagerController::class,'show'])->name('ad_manager.list');

        Route::get('/add_ad_manager', [App\Http\Controllers\AdManagerController::class,'Add_list']);

        Route::post('/ad_manager.insert', [App\Http\Controllers\AdManagerController::class,'store']);

        Route::post('/edit_ad_manager_list/{id}',[App\Http\Controllers\AdManagerController::class,'EditCatList']);

        Route::any('/edit_ad_manager/{id}',[App\Http\Controllers\AdManagerController::class,'EditCategory']);

        Route::post('/delete_ad_manager/{id}',[App\Http\Controllers\AdManagerController::class,'delete']);

        Route::post('/ad_manager_status_update', [App\Http\Controllers\AdManagerController::class, 'active']);

        Route::get('/get_add_type', [App\Http\Controllers\AdManagerController::class,'get_add_type']);

        
        //profile update
        Route::get('/profile_update', function () {return view('admin.accounts.profile_update');});
        
        Route::any('/home','App\Http\Controllers\AdminController@profileUpdate')->name('profileupdate');

        Route::post('/uploadFile', 'App\Http\Controllers\CategoryController@uploadFile');

        //Accounts list
        
        Route::get('/superadmin',[App\Http\Controllers\AdminController::class,'superadmin'])->name('superadmin');
        
        Route::get('/admin_add_sub_admin',[App\Http\Controllers\AdminController::class,'add']);

        Route::post('/admin_insert',[App\Http\Controllers\AdminController::class,'insert']);

        Route::any('/edit_admin/{id}',[App\Http\Controllers\AdminController::class,'edit']);

        Route::any('/edit_admin_list/{id}',[App\Http\Controllers\AdminController::class,'editlist']);

        Route::post('/user_status_update', [App\Http\Controllers\AdminController::class, 'active']);

        Route::post('/delete_admin/{id}',[App\Http\Controllers\AdminController::class,'delete']);

        Route::get('/logActivity', 'App\Http\Controllers\HomeController@logActivity');

        Route::post('/activitydelete',[App\Http\Controllers\AdminController::class,'activitydelete']);

        route::post('/manage/{id}',[App\Http\Controllers\AdminController::class,'manage']);

	}
    );

    Route::get('/logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
});