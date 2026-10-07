<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\AppList;
use App\Models\Category;
use App\Models\MappedAppCategory;
use App\Models\SubCategory;
use App\Models\AdManager;
use App\Models\ApiHit;


use App\Shop;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;   // <-- CACHE ADDED
use App\Models\ApiHitLog;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    
    public function __construct()
    {
        $this->startTime = microtime(true);
    }
    
    // private function logApiHit(Request $request, $endpoint, $duration)
    // {
    //     $apiHit = ApiHit::where('endpoint', $endpoint)->first();
    
    //     if ($apiHit) {
    //         // Check if created_at within 24 hours
    //         $hoursDiff = now()->diffInHours($apiHit->created_at);
    
    //         $apiHit->increment('hit_count');
    //         // Update other fields
    //         $apiHit->response_duration = $duration;
    //         $apiHit->ip_address = $request->ip();
    //         $apiHit->http_method = $request->method();
    //         $apiHit->user_agent = $request->header('User-Agent');
    //         $apiHit->save();
    
    //     } else {
    //         // First time — create new record
    //         ApiHit::create([
    //             'endpoint'          => $endpoint,
    //             'hit_count'         => 1,
    //             'response_duration' => $duration,
    //             'ip_address'        => $request->ip(),
    //             'http_method'       => $request->method(),
    //             'user_agent'        => $request->header('User-Agent'),
    //         ]);
    //     }
    // }
    
    public function App(Request $request)
    {
        $resArr=[];
        $responseArr = array('result' => '0' ,'message'=>'failed','data'=> []);
        
        $app = AppList::Select('id','app_name','package_name')->where('deleted_at','0')->get();
        
        if(!empty($app) && count($app) )
        {
            foreach($app as $row)
            {   
                $temp['app_id'] = (string) $row->id ?? '';
                $temp['app_name'] = $row->app_name ?? '';
                $temp['package_name'] = $row->package_name ?? 'https://picsum.photos/200'; 
                $temp['language_code'] = $row->category->language_code ?? '' ;
                array_push($resArr, $temp);
            }
            
            if(!empty($resArr)){
                $responseArr = array('result'=>'1', 'data'=> $resArr, 'message'=>'Success');
            }else{
                $responseArr = array('result'=>'0', 'data'=> $resArr, 'message'=>'No Data Found');
            }
        }
        else
        {
            $responseArr = array('result' => '0' ,'data'=> [] ,'message'=>'No Data Found',);
        }   
        
        // End timer and calculate duration in minutes
        $endTime = microtime(true);
        $duration = ($endTime - $this->startTime) / 60;

        // Log the hit with additional details
        $this->logApiHit($request, request()->path(), $duration);


        return response()->json($responseArr);
    }
    
    public function Category(Request $request)
    {
        $package_name = $request->package_name;
        $app_type = $request->app_type;

        // ================= CACHE ADDED (START) =================
        $cacheKey = "ads_list:{$app_type}:{$package_name}";

        // Cache irundha DB hit illa, log-um illa
        if (Cache::has($cacheKey)) {
            return response()->json(Cache::get($cacheKey));
        }
        // ================= CACHE ADDED (END) ===================

        $resArr = [];
        $responseArr = array('result' => '0' ,'data'=> $resArr ,'message'=>'No Data Found');
        if($app_type == 1){
            $app_id = AppList::orderBy('id','desc')->where('package_name',$package_name)->where('app_type',$app_type)->where('deleted_at',0)->pluck('id')->toArray();
            $resArr = [];
            $responseArr = array('result' => '0' ,'data'=> [] ,'message'=>'No Data Found',);
            if(!empty($app_id) && count($app_id) > 0)
            {
                if(array_key_exists(0,$app_id))
                {
                    $app_list = AppList::find($app_id[0]);
                    if($app_list->which_is_active_ads_id == 1){
                        $AdManager = AdManager::orderBy('id','desc')->whereIn('app_id', $app_id)->where('ad_app_type',$app_list->which_is_active_ads_id)->where('deleted_at',0)->where('is_active',0)->get();

                        foreach($AdManager as $row)
                        {
                            $temp['ad_app_type'] = $row->ad_app_type ?? '';
                            $temp['app_open_id']  = $row->app_open_id ?? '';
                            $temp['ad_app_id'] = $row->ad_app_id ?? '';
                            $temp['ad_banner_id'] = $row->adBanner == "1" ? ($row->ad_banner_id != null ? $row->ad_banner_id : "") : "";
                            // $temp['ad_banner_id'] = $row->ad_banner_id ?? '';
                            $explode = explode(',',$row->multiple_banner_id);
                            //naveen
                            $temp['audio_banner_id'] = $row->audio_banner_id ?? '';

                            $temp['audio_interstitial_id'] = $row->audio_interstitial_id ?? '';
                            $temp['multiple_banner_id'] = $row->multipleAdBanner == "1" ? ($row->multiple_banner_id != null ? $row->multiple_banner_id : "") : "";
                            // $temp['multiple_banner_id'] = $row->multiple_banner_id ?? '';
                            $temp['ad_meadium_rectangle_id'] = $row->rectangle == "1" ? ($row->ad_meadium_rectangle_id != null ? $row->ad_meadium_rectangle_id : "") : "";
                            // $temp['ad_meadium_rectangle_id'] = $row->ad_meadium_rectangle_id ?? '';
                            $temp['multiple_medium_rectangle_id'] = $row->multipleRectangle == "1" ? ($row->multiple_medium_rectangle_id != null ? $row->multiple_medium_rectangle_id : "") : "";
                            // $temp['multiple_medium_rectangle_id'] = $row->multiple_medium_rectangle_id ?? '';
                            $temp['ad_interstitial_id'] = $row->interstitial == "1" ? ($row->ad_intercial_id != null ? $row->ad_intercial_id : "") : "";
                            // $temp['ad_interstitial_id'] =$row->ad_intercial_id ?? ''; 
                            $temp['multiple_interstitial_id'] = $row->multipleInterstitial == "1" ? ($row->multiple_interstitial_id != null ? $row->multiple_interstitial_id : "") : "";
                            // $temp['multiple_interstitial_id'] = $row->multiple_interstitial_id ?? '';
                            $temp['ad_native_advanced_id'] = $row->native == "1" ? ($row->ad_native_advanced != null ? $row->ad_native_advanced : "") : "";
                            // $temp['ad_native_advanced_id'] = $row->ad_native_advanced ?? '' ;
                            $temp['multiple_native_advanced_id'] = $row->multipleNative == "1" ? ($row->multiple_advanced_id != null ? $row->multiple_advanced_id : "") : "";
                            // $temp['multiple_native_advanced_id'] = $row->multiple_advanced_id ?? '';
                            $temp['ad_rewards_id'] = $row->ad_rewards ?? '' ;
                            $temp['ad_rewarded_interstitial_id'] = $row->ad_rewarded_intencial ?? '' ;
                            $temp['ad_native_advanced_video_id'] = $row->ad_native_advanced_video ?? '';
                            $temp['ad_interstitial_video_id'] = $row->ad_intencial_video ?? '' ;
                            $temp['is_show_ads_biblereadingscreen'] =(string) $row->is_show_ads_biblereadingscreen ?? 0;
                            $temp['biblereadingscreen_ads_verse_interval'] = $row->biblereadingscreen_ads_verse_interval ?? '';
                            $temp['auto_ads_load'] =(string) $row->auto_ads_load ?? 0;
                            $temp['auto_ads_load_duration'] =(string) $row->auto_ads_load_duration ?? 0;

                            //to changes the
                            $temp['book_reader_interval'] =(int) $app_list->book_reader_interval ?? 0;
                            $temp['book_reader_ad_format_type'] =(string) $app_list->book_reader_ad_format_type != null ? $app_list->book_reader_ad_format_type : (string) 3;

                            array_push($resArr, $temp);
                        }
    
                        if(!empty($resArr))
                        {
                            $responseArr = array('result'=>'1', 'data'=> $resArr, 'message'=>'Success');
                        }
                        else{
                            $responseArr = array('result'=>'0', 'data'=> $resArr, 'message'=>'No Data Found');
                        }

                    }else if($app_list->which_is_active_ads_id == 2){
                        $AdManager = AdManager::whereIn('app_id', $app_id)->where('ad_app_type',$app_list->which_is_active_ads_id)->where('deleted_at',0)->where('is_active',0)->latest()->get();

                        foreach($AdManager as $row)
                        {
                            $temp['ad_app_type'] = $row->ad_app_type ?? '';
                            $temp['app_open_id']  = $row->app_open_id ?? '';
                            $temp['ad_app_id'] = $row->ad_app_id ?? '';
                            $temp['ad_banner_id'] = $row->adBanner == "1" ? ($row->ad_banner_id != null ? $row->ad_banner_id : "") : "";
                            // $temp['ad_banner_id'] = $row->ad_banner_id ?? '';
                            // $temp['multiple_banner_id'] = $row->multipleAdBanner == "1" ? ($row->multiple_banner_id != null ? $row->multiple_banner_id : "") : "";
                            
                            $explode = explode(',',$row->multiple_banner_id);
                            //naveen
                            $temp['audio_banner_id'] = $row->audio_banner_id ?? '';

                            $temp['audio_interstitial_id'] = $row->audio_interstitial_id ?? '';
                            $temp['multiple_banner_id'] = $row->multipleAdBanner == "1" ? ($row->multiple_banner_id != null ? $row->multiple_banner_id : "") : "";
                            
                            // $temp['multiple_banner_id'] = $row->multiple_banner_id ?? '';
                            $temp['ad_meadium_rectangle_id'] = $row->rectangle == "1" ? ($row->ad_meadium_rectangle_id != null ? $row->ad_meadium_rectangle_id : "") : "";
                            // $temp['ad_meadium_rectangle_id'] = $row->ad_meadium_rectangle_id ?? '';
                            $temp['multiple_medium_rectangle_id'] = $row->multipleRectangle == "1" ? ($row->multiple_medium_rectangle_id != null ? $row->multiple_medium_rectangle_id : "") : "";
                            // $temp['multiple_medium_rectangle_id'] = $row->multiple_medium_rectangle_id ?? '';
                            $temp['ad_interstitial_id'] = $row->interstitial == "1" ? ($row->ad_intercial_id != null ? $row->ad_intercial_id : "") : "";
                            // $temp['ad_interstitial_id'] =$row->ad_intercial_id ?? ''; 
                            $temp['multiple_interstitial_id'] = $row->multipleInterstitial == "1" ? ($row->multiple_interstitial_id != null ? $row->multiple_interstitial_id : "") : "";
                            // $temp['multiple_interstitial_id'] = $row->multiple_interstitial_id ?? '';
                            $temp['ad_native_advanced_id'] = $row->native == "1" ? ($row->ad_native_advanced != null ? $row->ad_native_advanced : "") : "";
                            // $temp['ad_native_advanced_id'] = $row->ad_native_advanced ?? '' ;
                            $temp['multiple_native_advanced_id'] = $row->multipleNative == "1" ? ($row->multiple_advanced_id != null ? $row->multiple_advanced_id : "") : "";
                            // $temp['multiple_native_advanced_id'] = $row->multiple_advanced_id ?? '';
                            $temp['ad_rewards_id'] = $row->ad_rewards ?? '' ;
                            $temp['ad_rewarded_interstitial_id'] = $row->ad_rewarded_intencial ?? '' ;
                            $temp['ad_native_advanced_video_id'] = $row->ad_native_advanced_video ?? '';
                            $temp['ad_interstitial_video_id'] = $row->ad_intencial_video ?? '' ;
                            $temp['is_show_ads_biblereadingscreen'] =(string) $row->is_show_ads_biblereadingscreen ?? 0;
                            $temp['biblereadingscreen_ads_verse_interval'] = $row->biblereadingscreen_ads_verse_interval ?? '';
                            $temp['auto_ads_load'] =(string) $row->auto_ads_load ?? 0;
                            $temp['auto_ads_load_duration'] =(string) $row->auto_ads_load_duration ?? 0;

                            //to change 
                            $temp['book_reader_interval'] =(int) $app_list->book_reader_interval ?? 0;
                            $temp['book_reader_ad_format_type'] =(string) $app_list->book_reader_ad_format_type != null ? $app_list->book_reader_ad_format_type : (string) 3;

                            array_push($resArr, $temp);
                        }
    
                        if(!empty($resArr))
                        {
                            $responseArr = array('result'=>'1', 'data'=> $resArr, 'message'=>'Success');
                        }
                        else{
                            $responseArr = array('result'=>'0', 'data'=> $resArr, 'message'=>'No Data Found');
                        }

                    }else if($app_list->which_is_active_ads_id == 3){
                        $AdManager = AdManager::whereIn('app_id', $app_id)->where('ad_app_type',$app_list->which_is_active_ads_id)->where('deleted_at',0)->where('is_active',0)->latest()->get();

                        foreach($AdManager as $row)
                        {
                            $temp['ad_app_type'] = $row->ad_app_type ?? '';
                            $temp['app_open_id']  = $row->app_open_id ?? '';
                            $temp['ad_app_id'] = $row->ad_app_id ?? '';
                            $temp['ad_banner_id'] = $row->adBanner == "1" ? ($row->ad_banner_id != null ? $row->ad_banner_id : "") : "";
                            // $temp['ad_banner_id'] = $row->ad_banner_id ?? '';
                            // $temp['multiple_banner_id'] = $row->multipleAdBanner == "1" ? ($row->multiple_banner_id != null ? $row->multiple_banner_id : "") : "";
                            
                            $explode = explode(',',$row->multiple_banner_id);
                            
                            $temp['multiple_banner_id'] = $row->multipleAdBanner == "1" ? ($row->multiple_banner_id != null ? $row->multiple_banner_id : "") : "";
                            //naveen
                            $temp['audio_banner_id'] = $row->audio_banner_id ?? '';

                            $temp['audio_interstitial_id'] = $row->audio_interstitial_id ?? '';
                            // $temp['multiple_banner_id'] = $row->multiple_banner_id ?? '';
                            $temp['ad_meadium_rectangle_id'] = $row->rectangle == "1" ? ($row->ad_meadium_rectangle_id != null ? $row->ad_meadium_rectangle_id : "") : "";
                            // $temp['ad_meadium_rectangle_id'] = $row->ad_meadium_rectangle_id ?? '';
                            $temp['multiple_medium_rectangle_id'] = $row->multipleRectangle == "1" ? ($row->multiple_medium_rectangle_id != null ? $row->multiple_medium_rectangle_id : "") : "";
                            // $temp['multiple_medium_rectangle_id'] = $row->multiple_medium_rectangle_id ?? '';
                            $temp['ad_interstitial_id'] = $row->interstitial == "1" ? ($row->ad_intercial_id != null ? $row->ad_intercial_id : "") : "";
                            // $temp['ad_interstitial_id'] =$row->ad_intercial_id ?? ''; 
                            $temp['multiple_interstitial_id'] = $row->multipleInterstitial == "1" ? ($row->multiple_interstitial_id != null ? $row->multiple_interstitial_id : "") : "";
                            // $temp['multiple_interstitial_id'] = $row->multiple_interstitial_id ?? '';
                            $temp['ad_native_advanced_id'] = $row->native == "1" ? ($row->ad_native_advanced != null ? $row->ad_native_advanced : "") : "";
                            // $temp['ad_native_advanced_id'] = $row->ad_native_advanced ?? '' ;
                            $temp['multiple_native_advanced_id'] = $row->multipleNative == "1" ? ($row->multiple_advanced_id != null ? $row->multiple_advanced_id : "") : "";
                            // $temp['multiple_native_advanced_id'] = $row->multiple_advanced_id ?? '';
                            $temp['ad_rewards_id'] = $row->ad_rewards ?? '' ;
                            $temp['ad_rewarded_interstitial_id'] = $row->ad_rewarded_intencial ?? '' ;
                            $temp['ad_native_advanced_video_id'] = $row->ad_native_advanced_video ?? '';
                            $temp['ad_interstitial_video_id'] = $row->ad_intencial_video ?? '' ;
                            $temp['is_show_ads_biblereadingscreen'] =(string) $row->is_show_ads_biblereadingscreen ?? 0;
                            $temp['biblereadingscreen_ads_verse_interval'] = $row->biblereadingscreen_ads_verse_interval ?? '';
                            $temp['auto_ads_load'] =(string) $row->auto_ads_load ?? 0;
                            $temp['auto_ads_load_duration'] =(string) $row->auto_ads_load_duration ?? 0;

                            //to change 
                            $temp['book_reader_interval'] =(int) $app_list->book_reader_interval ?? 0;
                            $temp['book_reader_ad_format_type'] =(string) $app_list->book_reader_ad_format_type != null ? $app_list->book_reader_ad_format_type : (string) 3;

                            array_push($resArr, $temp);
                        }
    
                        if(!empty($resArr))
                        {
                            $responseArr = array('result'=>'1', 'data'=> $resArr, 'message'=>'Success');
                        }
                        else{
                            $responseArr = array('result'=>'0', 'data'=> $resArr, 'message'=>'No Data Found');
                        }

                    }
                    else{
                        if($app_list->google_ads_id != null || $app_list->facebook_ads_id != null){
                            $AdManager = AdManager::Select(
                                ['id as ads_id',
                                'app_type',
                                'ad_app_type',
                                'app_open_id', 
                                'ad_app_id',
                                'ad_banner_id',
                                'audio_banner_id',
                                'audio_interstitial_id',
                                'ad_intercial_id',
                                'ad_native_advanced',
                                'ad_rewards',
                                'ad_meadium_rectangle_id',
                                'multiple_medium_rectangle_id',
                                'ad_rewarded_intencial',
                                'ad_native_advanced_video',
                                'ad_intencial_video',
                                'multiple_banner_id',
                                'multiple_interstitial_id',
                                'multiple_advanced_id',
                                'is_show_ads_biblereadingscreen',
                                'biblereadingscreen_ads_verse_interval'])->whereIn('app_id', $app_id)->where('deleted_at',0)->where('is_active',0)->latest()->take(1)->get();
    
                            foreach($AdManager as $row)
                            {
                                $temp['ad_app_type'] = (string) $app_list->which_is_active_ads_id ?? 0;
                                $temp['app_open_id']  = (string) '';
                                $temp['ad_app_id'] =  (string) '';
                                $temp['audio_banner_id'] = (string) '';
                                $temp['audio_interstitial_id'] =  (string) '';
                                $temp['ad_banner_id'] = (string) '';
                                $temp['ad_meadium_rectangle_id'] = (string) '';
                                $temp['multiple_medium_rectangle_id'] =  (string) '';
                                $temp['ad_interstitial_id'] = (string) '';
                                $temp['ad_native_advanced_id'] =  (string) '';
                                $temp['ad_rewards_id'] =  (string) '';
                                $temp['ad_rewarded_interstitial_id'] =  (string) '';
                                $temp['ad_native_advanced_video_id'] =  (string) '';
                                $temp['ad_interstitial_video_id'] = (string) '';
                                $temp['multiple_banner_id'] = (string) '';
                                $temp['multiple_banner_id'] = (string) '';
                                $temp['multiple_interstitial_id'] = (string) '';
                                $temp['multiple_native_advanced_id'] = (string) '';
                                $temp['is_show_ads_biblereadingscreen'] =(string) 0;
                                $temp['biblereadingscreen_ads_verse_interval'] = (string) '';
                                $temp['auto_ads_load'] = (string) 0;
                                $temp['auto_ads_load_duration'] = (string) 0;

                                //to change 
                                $temp['book_reader_interval'] =(int) 0;
                                $temp['book_reader_ad_format_type'] =(string) 3;

                                array_push($resArr, $temp);
                            }
        
                            if(!empty($resArr))
                            {
                                $responseArr = array('result'=>'1', 'data'=> $resArr, 'message'=>'Success');
                            }
                            else{
                                $responseArr = array('result'=>'0', 'data'=> $resArr, 'message'=>'No Data Found');
                            }
                        }
                    }
                }
                else
                {
                    $responseArr = array('result'=>'0', 'data'=> $resArr, 'message'=>'No Data Found');
                }
            }
        }
        elseif($app_type == 2){
            $app_id = AppList::orderBy('id', 'desc')
                        ->where(function ($query) use ($package_name) {
                            $query->where('apple_id', $package_name)
                                  ->orWhere('bundle_id', $package_name);
                        })
                        ->where('app_type', $app_type)
                        ->where('deleted_at',0) // Assuming 'deleted_at' is a nullable timestamp
                        ->pluck('id')
                        ->toArray();

            // $app_id = AppList::orderBy('id','desc')->Where('apple_id',$package_name)->orWhere('bundle_id',$package_name)->where('app_type',$app_type)->where('deleted_at',0)->pluck('id')->toArray();
            $resArr = [];
            $responseArr = array('result' => '0' ,'data'=> [] ,'message'=>'No Data Found',);
            if(!empty($app_id) && count($app_id) > 0)
            {
                if(array_key_exists(0,$app_id))
                {
                    $app_list = AppList::find($app_id[0]);
                    if($app_list->which_is_active_ads_id == 1){
                        $AdManager = AdManager::orderBy('id','desc')->whereIn('app_id', $app_id)->where('ad_app_type',$app_list->which_is_active_ads_id)->where('deleted_at',0)->where('is_active',0)->get();

                        foreach($AdManager as $row)
                        {
                            $temp['ad_app_type'] = $row->ad_app_type ?? '';
                            $temp['app_open_id']  = $row->app_open_id ?? '';
                            $temp['ad_app_id'] = $row->ad_app_id ?? '';
                            $temp['ad_banner_id'] = $row->adBanner == "1" ? ($row->ad_banner_id != null ? $row->ad_banner_id : "") : "";
                            // $temp['ad_banner_id'] = $row->ad_banner_id ?? '';
                            // $temp['multiple_banner_id'] = $row->multipleAdBanner == "1" ? ($row->multiple_banner_id != null ? $row->multiple_banner_id : "") : "";
                            
                            $explode = explode(',',$row->multiple_banner_id);
                            
                            $temp['multiple_banner_id'] = $row->multipleAdBanner == "1" ? ($row->multiple_banner_id != null ? $row->multiple_banner_id : "") : "";
                            //naveen
                            $temp['audio_banner_id'] = $row->audio_banner_id ?? '';

                            $temp['audio_interstitial_id'] = $row->audio_interstitial_id ?? '';
                            // $temp['multiple_banner_id'] = $row->multiple_banner_id ?? '';
                            $temp['ad_meadium_rectangle_id'] = $row->rectangle == "1" ? ($row->ad_meadium_rectangle_id != null ? $row->ad_meadium_rectangle_id : "") : "";
                            // $temp['ad_meadium_rectangle_id'] = $row->ad_meadium_rectangle_id ?? '';
                            $temp['multiple_medium_rectangle_id'] = $row->multipleRectangle == "1" ? ($row->multiple_medium_rectangle_id != null ? $row->multiple_medium_rectangle_id : "") : "";
                            // $temp['multiple_medium_rectangle_id'] = $row->multiple_medium_rectangle_id ?? '';
                            $temp['ad_interstitial_id'] = $row->interstitial == "1" ? ($row->ad_intercial_id != null ? $row->ad_intercial_id : "") : "";
                            // $temp['ad_interstitial_id'] =$row->ad_intercial_id ?? ''; 
                            $temp['multiple_interstitial_id'] = $row->multipleInterstitial == "1" ? ($row->multiple_interstitial_id != null ? $row->multiple_interstitial_id : "") : "";
                            // $temp['multiple_interstitial_id'] = $row->multiple_interstitial_id ?? '';
                            $temp['ad_native_advanced_id'] = $row->native == "1" ? ($row->ad_native_advanced != null ? $row->ad_native_advanced : "") : "";
                            // $temp['ad_native_advanced_id'] = $row->ad_native_advanced ?? '' ;
                            $temp['multiple_native_advanced_id'] = $row->multipleNative == "1" ? ($row->multiple_advanced_id != null ? $row->multiple_advanced_id : "") : "";
                            // $temp['multiple_native_advanced_id'] = $row->multiple_advanced_id ?? '';
                            $temp['ad_rewards_id'] = $row->ad_rewards ?? '' ;
                            $temp['ad_rewarded_interstitial_id'] = $row->ad_rewarded_intencial ?? '' ;
                            $temp['ad_native_advanced_video_id'] = $row->ad_native_advanced_video ?? '';
                            $temp['ad_interstitial_video_id'] = $row->ad_intencial_video ?? '' ;
                            $temp['is_show_ads_biblereadingscreen'] =(string) $row->is_show_ads_biblereadingscreen ?? 0;
                            $temp['biblereadingscreen_ads_verse_interval'] = $row->biblereadingscreen_ads_verse_interval ?? '';
                            $temp['auto_ads_load'] =(string) $row->auto_ads_load ?? 0;
                            $temp['auto_ads_load_duration'] =(string) $row->auto_ads_load_duration ?? 0;

                            //to changes the
                            $temp['book_reader_interval'] =(int) $app_list->book_reader_interval ?? 0;
                            $temp['book_reader_ad_format_type'] =(string) $app_list->book_reader_ad_format_type != null ? $app_list->book_reader_ad_format_type : (string) 3;

                            array_push($resArr, $temp);
                        }
    
                        if(!empty($resArr))
                        {
                            $responseArr = array('result'=>'1', 'data'=> $resArr, 'message'=>'Success');
                        }
                        else{
                            $responseArr = array('result'=>'0', 'data'=> $resArr, 'message'=>'No Data Found');
                        }
                    }else if($app_list->which_is_active_ads_id == 2){
                        $AdManager = AdManager::whereIn('app_id', $app_id)->where('ad_app_type',$app_list->which_is_active_ads_id)->where('deleted_at',0)->where('is_active',0)->latest()->get();

                        foreach($AdManager as $row)
                        {
                            $temp['ad_app_type'] = $row->ad_app_type ?? '';
                            $temp['app_open_id']  = $row->app_open_id ?? '';
                            $temp['ad_app_id'] = $row->ad_app_id ?? '';
                            $temp['ad_banner_id'] = $row->adBanner == "1" ? ($row->ad_banner_id != null ? $row->ad_banner_id : "") : "";
                            // $temp['ad_banner_id'] = $row->ad_banner_id ?? '';
                            // $temp['multiple_banner_id'] = $row->multipleAdBanner == "1" ? ($row->multiple_banner_id != null ? $row->multiple_banner_id : "") : "";
                            
                            $explode = explode(',',$row->multiple_banner_id);
                            
                            $temp['multiple_banner_id'] = $row->multipleAdBanner == "1" ? ($row->multiple_banner_id != null ? $row->multiple_banner_id : "") : "";
                            $temp['audio_banner_id'] = $row->audio_banner_id ?? '';

                            $temp['audio_interstitial_id'] = $row->audio_interstitial_id ?? '';
                            // $temp['multiple_banner_id'] = $row->multiple_banner_id ?? '';
                            $temp['ad_meadium_rectangle_id'] = $row->rectangle == "1" ? ($row->ad_meadium_rectangle_id != null ? $row->ad_meadium_rectangle_id : "") : "";
                            // $temp['ad_meadium_rectangle_id'] = $row->ad_meadium_rectangle_id ?? '';
                            $temp['multiple_medium_rectangle_id'] = $row->multipleRectangle == "1" ? ($row->multiple_medium_rectangle_id != null ? $row->multiple_medium_rectangle_id : "") : "";
                            // $temp['multiple_medium_rectangle_id'] = $row->multiple_medium_rectangle_id ?? '';
                            $temp['ad_interstitial_id'] = $row->interstitial == "1" ? ($row->ad_intercial_id != null ? $row->ad_intercial_id : "") : "";
                            // $temp['ad_interstitial_id'] =$row->ad_intercial_id ?? ''; 
                            $temp['multiple_interstitial_id'] = $row->multipleInterstitial == "1" ? ($row->multiple_interstitial_id != null ? $row->multiple_interstitial_id : "") : "";
                            // $temp['multiple_interstitial_id'] = $row->multiple_interstitial_id ?? '';
                            $temp['ad_native_advanced_id'] = $row->native == "1" ? ($row->ad_native_advanced != null ? $row->ad_native_advanced : "") : "";
                            // $temp['ad_native_advanced_id'] = $row->ad_native_advanced ?? '' ;
                            $temp['multiple_native_advanced_id'] = $row->multipleNative == "1" ? ($row->multiple_advanced_id != null ? $row->multiple_advanced_id : "") : "";
                            // $temp['multiple_native_advanced_id'] = $row->multiple_advanced_id ?? '';
                            $temp['ad_rewards_id'] = $row->ad_rewards ?? '' ;
                            $temp['ad_rewarded_interstitial_id'] = $row->ad_rewarded_intencial ?? '' ;
                            $temp['ad_native_advanced_video_id'] = $row->ad_native_advanced_video ?? '';
                            $temp['ad_interstitial_video_id'] = $row->ad_intencial_video ?? '' ;
                            $temp['is_show_ads_biblereadingscreen'] =(string) $row->is_show_ads_biblereadingscreen ?? 0;
                            $temp['biblereadingscreen_ads_verse_interval'] = $row->biblereadingscreen_ads_verse_interval ?? '';
                            $temp['auto_ads_load'] =(string) $row->auto_ads_load ?? 0;
                            $temp['auto_ads_load_duration'] =(string) $row->auto_ads_load_duration ?? 0;

                            //to changes the
                            $temp['book_reader_interval'] =(int) $app_list->book_reader_interval ?? 0;
                            $temp['book_reader_ad_format_type'] =(string) $app_list->book_reader_ad_format_type != null ? $app_list->book_reader_ad_format_type : (string) 3;

                            array_push($resArr, $temp);
                        }
    
                        if(!empty($resArr))
                        {
                            $responseArr = array('result'=>'1', 'data'=> $resArr, 'message'=>'Success');
                        }
                        else{
                            $responseArr = array('result'=>'0', 'data'=> $resArr, 'message'=>'No Data Found');
                        }
                    }else if($app_list->which_is_active_ads_id == 3){
                        $AdManager = AdManager::whereIn('app_id', $app_id)->where('ad_app_type',$app_list->which_is_active_ads_id)->where('deleted_at',0)->where('is_active',0)->latest()->get();

                        foreach($AdManager as $row)
                        {
                            $temp['ad_app_type'] = $row->ad_app_type ?? '';
                            $temp['app_open_id']  = $row->app_open_id ?? '';
                            $temp['ad_app_id'] = $row->ad_app_id ?? '';
                            $temp['ad_banner_id'] = $row->adBanner == "1" ? ($row->ad_banner_id != null ? $row->ad_banner_id : "") : "";
                            // $temp['ad_banner_id'] = $row->ad_banner_id ?? '';
                            // $temp['multiple_banner_id'] = $row->multipleAdBanner == "1" ? ($row->multiple_banner_id != null ? $row->multiple_banner_id : "") : "";
                            
                            $explode = explode(',',$row->multiple_banner_id);
                            
                            $temp['multiple_banner_id'] = $row->multipleAdBanner == "1" ? ($row->multiple_banner_id != null ? $row->multiple_banner_id : "") : "";
                            $temp['audio_banner_id'] = $row->audio_banner_id ?? '';

                            $temp['audio_interstitial_id'] = $row->audio_interstitial_id ?? '';
                            // $temp['multiple_banner_id'] = $row->multiple_banner_id ?? '';
                            $temp['ad_meadium_rectangle_id'] = $row->rectangle == "1" ? ($row->ad_meadium_rectangle_id != null ? $row->ad_meadium_rectangle_id : "") : "";
                            // $temp['ad_meadium_rectangle_id'] = $row->ad_meadium_rectangle_id ?? '';
                            $temp['multiple_medium_rectangle_id'] = $row->multipleRectangle == "1" ? ($row->multiple_medium_rectangle_id != null ? $row->multiple_medium_rectangle_id : "") : "";
                            // $temp['multiple_medium_rectangle_id'] = $row->multiple_medium_rectangle_id ?? '';
                            $temp['ad_interstitial_id'] = $row->interstitial == "1" ? ($row->ad_intercial_id != null ? $row->ad_intercial_id : "") : "";
                            // $temp['ad_interstitial_id'] =$row->ad_intercial_id ?? ''; 
                            $temp['multiple_interstitial_id'] = $row->multipleInterstitial == "1" ? ($row->multiple_interstitial_id != null ? $row->multiple_interstitial_id : "") : "";
                            // $temp['multiple_interstitial_id'] = $row->multiple_interstitial_id ?? '';
                            $temp['ad_native_advanced_id'] = $row->native == "1" ? ($row->ad_native_advanced != null ? $row->ad_native_advanced : "") : "";
                            // $temp['ad_native_advanced_id'] = $row->ad_native_advanced ?? '' ;
                            $temp['multiple_native_advanced_id'] = $row->multipleNative == "1" ? ($row->multiple_advanced_id != null ? $row->multiple_advanced_id : "") : "";
                            // $temp['multiple_native_advanced_id'] = $row->multiple_advanced_id ?? '';
                            $temp['ad_rewards_id'] = $row->ad_rewards ?? '' ;
                            $temp['ad_rewarded_interstitial_id'] = $row->ad_rewarded_intencial ?? '' ;
                            $temp['ad_native_advanced_video_id'] = $row->ad_native_advanced_video ?? '';
                            $temp['ad_interstitial_video_id'] = $row->ad_intencial_video ?? '' ;
                            $temp['is_show_ads_biblereadingscreen'] =(string) $row->is_show_ads_biblereadingscreen ?? 0;
                            $temp['biblereadingscreen_ads_verse_interval'] = $row->biblereadingscreen_ads_verse_interval ?? '';
                            $temp['auto_ads_load'] =(string) $row->auto_ads_load ?? 0;
                            $temp['auto_ads_load_duration'] =(string) $row->auto_ads_load_duration ?? 0;

                            //to changes the
                            $temp['book_reader_interval'] =(int) $app_list->book_reader_interval ?? 0;
                            $temp['book_reader_ad_format_type'] =(string) $app_list->book_reader_ad_format_type != null ? $app_list->book_reader_ad_format_type : (string) 3;

                            array_push($resArr, $temp);
                        }
    
                        if(!empty($resArr))
                        {
                            $responseArr = array('result'=>'1', 'data'=> $resArr, 'message'=>'Success');
                        }
                        else{
                            $responseArr = array('result'=>'0', 'data'=> $resArr, 'message'=>'No Data Found');
                        }
                    }else{
                        if($app_list->google_ads_id != null || $app_list->facebook_ads_id != null){
                            $AdManager = AdManager::Select(
                                ['id as ads_id',
                                'app_type',
                                'ad_app_type',
                                'app_open_id', 
                                'ad_app_id',
                                'audio_banner_id',
                                'audio_interstitial_id',
                                'ad_banner_id',
                                'ad_intercial_id',
                                'ad_native_advanced',
                                'ad_rewards',
                                'ad_meadium_rectangle_id',
                                'multiple_medium_rectangle_id',
                                'ad_rewarded_intencial',
                                'ad_native_advanced_video',
                                'ad_intencial_video',
                                'multiple_banner_id',
                                'multiple_interstitial_id',
                                'multiple_advanced_id',
                                'is_show_ads_biblereadingscreen',
                                'biblereadingscreen_ads_verse_interval'])
                                ->where('app_id', $app_list->id)->where('deleted_at',0)->where('is_active',0)->latest()->take(1)->get();
                            foreach($AdManager as $row)
                            {
                                $temp['ad_app_type'] = (string) $app_list->which_is_active_ads_id ?? 0;
                                $temp['app_open_id']  = (string) '';
                                $temp['ad_app_id'] =  (string) '';
                                $temp['ad_banner_id'] = (string) '';
                                $temp['audio_banner_id'] = (string) '';
                                $temp['audio_interstitial_id'] =  (string) '';
                                $temp['ad_meadium_rectangle_id'] = (string) '';
                                $temp['multiple_medium_rectangle_id'] =  (string) '';
                                $temp['ad_interstitial_id'] = (string) '';
                                $temp['ad_native_advanced_id'] =  (string) '';
                                $temp['ad_rewards_id'] =  (string) '';
                                $temp['ad_rewarded_interstitial_id'] =  (string) '';
                                $temp['ad_native_advanced_video_id'] =  (string) '';
                                $temp['ad_interstitial_video_id'] = (string) '';
                                $temp['multiple_banner_id'] = (string) '';
                                $temp['multiple_banner_id'] = (string) '';
                                $temp['multiple_interstitial_id'] = (string) '';
                                $temp['multiple_native_advanced_id'] = (string) '';
                                $temp['is_show_ads_biblereadingscreen'] =(string) 0;
                                $temp['biblereadingscreen_ads_verse_interval'] = (string) '';
                                $temp['auto_ads_load'] = (string) 0;
                                $temp['auto_ads_load_duration'] = (string) 0;
                                
                                //to change 
                                $temp['book_reader_interval'] =(int) 0;
                                $temp['book_reader_ad_format_type'] =(string) 3;
                                array_push($resArr, $temp);
                            }
        
                            if(!empty($resArr))
                            {
                                $responseArr = array('result'=>'1', 'data'=> $resArr, 'message'=>'Success');
                            }
                            else{
                                $responseArr = array('result'=>'0', 'data'=> $resArr, 'message'=>'No Data Found');
                            }
                        }
                    }
                }
                else
                {
                    $responseArr = array('result'=>'0', 'data'=> $resArr, 'message'=>'No Data Found');
                }
            }
        }
        else{
            $responseArr = array('result'=>'0', 'data'=> $resArr, 'message'=>'No Data Found');
        }

        // ================= CACHE ADDED (START) =================
        // Success-na 96 hours, no data-na 1 min (random package_name spam protect)
        if (($responseArr['result'] ?? '0') == '1') {
            Cache::put($cacheKey, $responseArr, now()->addHours(96));
        } else {
            Cache::put($cacheKey, $responseArr, now()->addMinutes(1));
        }
        // ================= CACHE ADDED (END) ===================
        
        // End timer and calculate duration in minutes
        $endTime = microtime(true);
        $duration = ($endTime - $this->startTime) / 60;

        // Log the hit with additional details (cache miss => DB hit mattum)
        $this->logApiHit($request, request()->path(), $duration);
        
        return response()->json($responseArr);
    }

    public function get_priority_ads(Request $request)
    {
        $package_name = $request->package_name;
        $app_type = $request->app_type;

        if (!$package_name || !$app_type) {
            return response()->json([
                'result' => '0',
                'data' => [],
                'message' => 'Package Name or App Type missing'
            ]);
        }
        if($app_type != 1 && $app_type !=2){
            return response()->json([
                'result' => '0',
                'data' => [],
                'message' => 'Invalid App Type'
            ]);
        }

        // ================= CACHE ADDED (START) =================
        $cacheKey = "priority_ads:{$app_type}:{$package_name}";

        // Cache irundha DB hit illa, log-um illa
        if (Cache::has($cacheKey)) {
            return response()->json(Cache::get($cacheKey));
        }
        // ================= CACHE ADDED (END) ===================

        // ---- Fetch App Setting ----
        if($app_type == 1){
            $app_list = AppList::where('package_name', $package_name)
                ->where('app_type', $app_type)
                ->where('deleted_at', 0)
                ->first();
        } else {
            $app_list = AppList::where(function ($query) use ($package_name) {
                    $query->where('apple_id', $package_name)
                          ->orWhere('bundle_id', $package_name);
                })
                ->where('app_type', $app_type)
                ->where('deleted_at', 0)
                ->first();
        }

        if (!$app_list) {
            return response()->json([
                'result' => '0',
                'data' => [],
                'message' => 'App not found'
            ]);
        }

         // ---- Priority Values ----
        $google_priority = (int) ($app_list->google_priority ?? 0);
        $facebook_priority = (int) ($app_list->facebook_priority ?? 0);
        $unity_priority = (int) ($app_list->unity_priority ?? 0);
        $which_is_active_ads_id = (int) ($app_list->which_is_active_ads_id ?? 0);

        // ---- Step 1: Check if all priorities are zero ----
        $allZero = ($google_priority === 0 && $facebook_priority === 0 && $unity_priority === 0);

        // ---- Step 2: Prepare active ads list ----
        $activeAdsData = [];

        // Map ad type IDs
        $adTypeMap = [
            1 => 'google',
            2 => 'facebook',
            3 => 'unity',
        ];

        // Priority mapping (lower number = higher priority)
        $priorities = [
            1 => $google_priority,
            2 => $facebook_priority,
            3 => $unity_priority,
        ];

        // ---- Step 3: Determine order ----
        if ($allZero) {
            // All priorities 0 → use only active ad
            $order = [$which_is_active_ads_id];
        } else {
            // Sort by priority (1,2,3)
            asort($priorities);
            $order = array_keys($priorities);
        }

        // ---- Step 4: Fetch Ads in Priority Order ----
        $displayPriority = 1;

        foreach ($order as $adTypeId) {
            $ads = AdManager::where('app_id', $app_list->id)
                ->where('ad_app_type', $adTypeId)
                ->where('deleted_at', 0)
                ->where('is_active', 0)
                ->latest()
                ->get();

            if ($ads->count() > 0) {
                foreach ($ads as $row) {
                    $temp['ad_app_type'] = (string) $adTypeId ?? '';
                    $temp['app_open_id'] = $row->app_open_id ?? '';
                    $temp['ad_app_id'] = $row->ad_app_id ?? '';
                    $temp['audio_banner_id'] = $row->audio_banner_id ?? '';
                    $temp['audio_interstitial_id'] = $row->audio_interstitial_id ?? '';
                    $temp['ad_banner_id'] = $row->adBanner == "1" ? ($row->ad_banner_id ?? '') : '';
                    $temp['multiple_banner_id'] = $row->multipleAdBanner == "1" ? ($row->multiple_banner_id ?? '') : '';
                    $temp['ad_meadium_rectangle_id'] = $row->rectangle == "1" ? ($row->ad_meadium_rectangle_id ?? '') : '';
                    $temp['multiple_medium_rectangle_id'] = $row->multipleRectangle == "1" ? ($row->multiple_medium_rectangle_id ?? '') : '';
                    $temp['ad_interstitial_id'] = $row->interstitial == "1" ? ($row->ad_intercial_id ?? '') : '';
                    $temp['multiple_interstitial_id'] = $row->multipleInterstitial == "1" ? ($row->multiple_interstitial_id ?? '') : '';
                    $temp['ad_native_advanced_id'] = $row->native == "1" ? ($row->ad_native_advanced ?? '') : '';
                    $temp['multiple_native_advanced_id'] = $row->multipleNative == "1" ? ($row->multiple_advanced_id ?? '') : '';
                    $temp['ad_rewards_id'] = $row->ad_rewards ?? '';
                    $temp['ad_rewarded_interstitial_id'] = $row->ad_rewarded_intencial ?? '';
                    $temp['ad_native_advanced_video_id'] = $row->ad_native_advanced_video ?? '';
                    $temp['ad_interstitial_video_id'] = $row->ad_intencial_video ?? '';
                    $temp['is_show_ads_biblereadingscreen'] = (string)($row->is_show_ads_biblereadingscreen ?? 0);
                    $temp['biblereadingscreen_ads_verse_interval'] = $row->biblereadingscreen_ads_verse_interval ?? '';
                    $temp['auto_ads_load'] = (string)($row->auto_ads_load ?? 0);
                    $temp['auto_ads_load_duration'] = (string)($row->auto_ads_load_duration ?? 0);
                    $temp['book_reader_interval'] = (int)($app_list->book_reader_interval ?? 0);
                    $temp['book_reader_ad_format_type'] = (string)($app_list->book_reader_ad_format_type ?? 3);

                    // Added priority number
                    $temp['priority'] = $displayPriority;

                    $activeAdsData[] = $temp;
                }

                $displayPriority++; // Increase for next ad set
            }
        }
        
        if($app_list->which_is_active_ads_id == 0){
            $activeAdsData = [];
        }

        // ---- Step 5: If no active ads found ----
        if (empty($activeAdsData)) {
            $activeAdsData[] = [
                'ad_app_type' => '0',
                'app_open_id' => '',
                'ad_app_id' => '',
                'ad_banner_id' => '',
                'multiple_banner_id' => '',
                'ad_meadium_rectangle_id' => '',
                'multiple_medium_rectangle_id' => '',
                'ad_interstitial_id' => '',
                'multiple_interstitial_id' => '',
                'ad_native_advanced_id' => '',
                'multiple_native_advanced_id' => '',
                'ad_rewards_id' => '',
                'ad_rewarded_interstitial_id' => '',
                'ad_native_advanced_video_id' => '',
                'ad_interstitial_video_id' => '',
                'is_show_ads_biblereadingscreen' => '0',
                'biblereadingscreen_ads_verse_interval' => '',
                'auto_ads_load' => '0',
                'auto_ads_load_duration' => '0',
                'book_reader_interval' => 0,
                'book_reader_ad_format_type' => '3',
                'priority' => 0,
            ];
        }

        // ================= CACHE ADDED (START) =================
        // (final response-ah variable-la eduthukitten, cache panna)
        $finalResponse = [
            'result' => !empty($activeAdsData) ? '1' : '0',
            'data' => $activeAdsData,
            'message' => !empty($activeAdsData) ? 'Success' : 'No Data Found'
        ];

        Cache::put($cacheKey, $finalResponse, now()->addHours(96));
        // ================= CACHE ADDED (END) ===================
        
        // End timer and calculate duration in minutes
        $endTime = microtime(true);
        $duration = ($endTime - $this->startTime) / 60;

        // Log the hit with additional details (cache miss => DB hit mattum)
        $this->logApiHit($request, request()->path(), $duration);

        // ---- Step 6: Final response ----
        return response()->json($finalResponse);
    }
    private function logApiHit(Request $request, $endpoint, $duration)
{
        $duration = round($duration * 1000, 2);
    $apiHit  = ApiHit::where('endpoint', $endpoint)->first();
    $payload = json_encode($request->all());

    if ($apiHit) {
        $apiHit->increment('hit_count');
        $apiHit->response_duration = $duration;
        $apiHit->ip_address        = $request->ip();
        $apiHit->http_method       = $request->method();
        $apiHit->user_agent        = $request->header('User-Agent');
        $apiHit->save();
    } else {
        ApiHit::create([
            'endpoint'          => $endpoint,
            'hit_count'         => 1,
            'response_duration' => $duration,
            'ip_address'        => $request->ip(),
            'http_method'       => $request->method(),
            'user_agent'        => $request->header('User-Agent'),
        ]);
    }

    ApiHitLog::create([
        'endpoint'          => $endpoint,
        'http_method'       => $request->method(),
        'ip_address'        => $request->ip(),
        'user_agent'        => $request->header('User-Agent'),
        'payload'           => $payload,
        'response_duration' => $duration,
    ]);
}

}
