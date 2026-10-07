<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\AppList;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookExport implements  FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $apps = AppList::orderBy('id','Desc')->where('deleted_at',0)->whereNull('ads_id')->get();
        $resArr = [];
        $array = [];
        foreach($apps as $row)
        {
            $array['app_name'] = $row->app_name;
            $array['app_type'] = $row->app_type;
            $array['package_name'] = $row->package_name;
            $array['apple_id'] = $row->apple_id;
            $array['bundle_id'] = $row->bundle_id;
            array_push($resArr,$array);   
        }
        return collect($resArr);
    }

    public function headings(): array
    {
        return [
            "app_name",
            'app_type',
            "package_name",
            'apple_id',
            'bundle_id',
        ];
    }
}
