<?php

namespace App\Console\Commands;

use App\Models\ApiHitLog;
use Illuminate\Console\Command;

class TruncateApiHitLogs extends Command
{
    protected $signature   = 'apihitlogs:truncate';
    protected $description = 'Truncate the api_hit_logs table';

    public function handle()
    {
        ApiHitLog::truncate();

        $this->info('api_hit_logs table truncated successfully.');
    }
}