<?php

namespace App\Models;
use App\Models\MappedAppCategory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppList extends Model
{
    use HasFactory;
    use \App\Traits\ClearsAdsCache;
    protected $fillable = [
        'id',
        'app_name',
        'app_description',
        'app_image',
        'image_type'
    ];


    
    public function get_mapped_cat_count()
    {
        return $this->hasMany('App\Models\MappedAppCategory', 'app_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category','language_code','id');
    }


}
