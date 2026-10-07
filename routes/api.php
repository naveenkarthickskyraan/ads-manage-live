<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//new Route
Route::get('/app_list_api',[App\Http\Controllers\Api\ApiController::class,'App']);

Route::any('/get_ads_list_by_package_name',[App\Http\Controllers\Api\ApiController::class,'Category']);

Route::any('/get_priority_ads',[App\Http\Controllers\Api\ApiController::class,'get_priority_ads']);


Route::get('/api-hit-logs', function () {
    return \App\Models\ApiHitLog::where('created_at', '>=', now()->subHours(24))
        ->orderBy('created_at', 'desc')
        ->get();
});