<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiHit extends Model
{
    use HasFactory;
    
    protected $fillable = ['endpoint', 'hit_count', 'response_duration', 'ip_address', 'http_method', 'user_agent'];

}
