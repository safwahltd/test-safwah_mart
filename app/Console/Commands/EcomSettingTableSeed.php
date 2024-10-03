<?php

namespace App\Console\Commands;

use App\Models\EcomSetting;
use Illuminate\Console\Command;

class EcomSettingTableSeed extends Command
{
    protected $signature = 'ecom:seed';

    protected $description = 'Ecom Setting Table Seeded Successfully';

    public function handle()
    {
        \App\Models\EcomSetting::firstOrCreate(['id' => 34], [
            'title' => 'Notification Popup Display Limit(Min)',
            'value' => 2
        ]);

        \App\Models\EcomSetting::firstOrCreate(['id' => 35], [
            'title' => 'Brand',
            'value' => 'on'
        ]);

        \App\Models\EcomSetting::firstOrCreate(['id' => 36], [
            'title' => 'Delivery Date & Time in print',
            'value' => 'on'
        ]);

        \App\Models\EcomSetting::firstOrCreate(['id' => 37], [
            'title' => 'Sale by',
            'value' => 'on'
        ]);


        \App\Models\EcomSetting::firstOrCreate(['id' => 38], [
            'title' => 'COD Inside Dhaka',
            'value' => 'on'
        ]);

        \App\Models\EcomSetting::firstOrCreate(['id' => 39], [
            'title' => 'Inside COD Charge',
            'value' => 1
        ]);

        \App\Models\EcomSetting::firstOrCreate(['id' => 40], [
            'title' => 'COD Outside Dhaka',
            'value' => 'on'
        ]);

        \App\Models\EcomSetting::firstOrCreate(['id' => 41], [
            'title' => 'Outside COD Charge',
            'value' => 1
        ]);


        // FREE DELIVERY SETTING
        \App\Models\EcomSetting::updateOrCreate(['id' => 42], [
            'title' => 'Free Delivery',
            'value' => 'on'
        ]);

        \App\Models\EcomSetting::updateOrCreate(['id' => 43], [
            'title' => 'Min Purchase Amount',
            'value' => 1000
        ]);

        \App\Models\EcomSetting::updateOrCreate(['id' => 44], [
            'title' => 'Free Delivery Amount',
            'value' => 100
        ]);

        $ecomsetting45 = EcomSetting::find(45);
        if ($ecomsetting45) {
            $ecomsetting45->delete();
        }
        $ecomsetting46 = EcomSetting::find(46);
        if ($ecomsetting46) {
            $ecomsetting46->delete();
        }
        $ecomsetting47 = EcomSetting::find(47);
        if ($ecomsetting47) {
            $ecomsetting47->delete();
        }


        \App\Models\EcomSetting::firstOrCreate(['id' => 51], [
            'title' => 'Bin & Musak Print',
            'value' => 'on'
        ]);

        \App\Models\EcomSetting::firstOrCreate(['id' => 52], [
            'title' => 'COD charge Print',
            'value' => 'on'
        ]);

        \App\Models\EcomSetting::firstOrCreate(['id' => 53], [
            'title' => 'All product category',
            'value' => 'on'
        ]);


        $this->info('Ecom Setting Table Seeded Successfully!');
    }
}
