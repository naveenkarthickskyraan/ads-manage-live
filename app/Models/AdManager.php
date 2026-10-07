<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdManager extends Model
{
    use HasFactory;
    
    use \App\Traits\ClearsAdsCache;
    
    protected $fillable =['ad_app_type'];

    public function AppList()
    {
        return $this->belongsTo('App\Models\AppList','app_id','id');
    }
}
