<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiHitLog extends Model
{
    protected $fillable = [
        'endpoint',
        'http_method',
        'ip_address',
        'user_agent',
        'payload',
        'response_duration',
    ];
}