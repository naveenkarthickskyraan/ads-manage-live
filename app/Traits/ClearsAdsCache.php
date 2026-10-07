<?php

namespace App\Traits;

use App\Models\AppList;
use Illuminate\Support\Facades\Cache;

/**
 * AppList and AdManager model rendulayum add pannunga:
 *
 *     use \App\Traits\ClearsAdsCache;
 *
 * Admin panel-la save / delete pannina automatic-a cache clear aagum.
 */
trait ClearsAdsCache
{
    public static function bootClearsAdsCache()
    {
        $clear = function ($model) {
            // AppList itself, illana AdManager-oda parent app
            $app = $model instanceof AppList ? $model : AppList::find($model->app_id);

            if (!$app) {
                return;
            }

            $appType = $app->app_type;

            // package_name / bundle_id edit pannirundha pazhaya value-um clear pannanum
            $keys = array_filter(array_unique([
                $app->package_name,
                $app->apple_id,
                $app->bundle_id,
                $model instanceof AppList ? $model->getOriginal('package_name') : null,
                $model instanceof AppList ? $model->getOriginal('apple_id') : null,
                $model instanceof AppList ? $model->getOriginal('bundle_id') : null,
            ]));

            foreach ($keys as $key) {
                Cache::forget("ads_list:{$appType}:{$key}");
                Cache::forget("priority_ads:{$appType}:{$key}");
            }
        };

        static::saved($clear);
        static::deleted($clear);
    }
}