<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentExport;
use App\Exports\BookExport;
use App\Models\AppList;
use App\Models\AdManager;

class testCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testCron:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Every five minutes delete user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pathToFile = url('skyraan_apps/ads_manager/public/sql/DISABLE.csv');
        
        $rows = [];
        if (($handle = fopen($pathToFile, 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                $rows[] = $data;
            }
            fclose($handle);
        }
        $csvData = [];
        foreach ($rows as $key => $row) {
            $csvData[] = $row[0];
        }
        $AppList = AppList::whereIn('package_name',$csvData)->where('app_type',1)->pluck('id')->toArray(); 
        dd($AppList);
    }
}
