<?php


namespace App\Traits;

use App\Models\Company;
use App\Models\SmsApiSetting;
use Illuminate\Support\Facades\Http;

trait SmsNotification
{
    public function sendSmsNotification($message, $phone)
    {

        $api = SmsApiSetting::first();


        Http::get($api->base_url, [

            "apikey"             => $api->api_key,
            "secretkey"          => '86643d49',
            "callerID"           => $api->sender_id,
            "toUser"             => $phone,
            "messageContent"     => $message,
        ]);
    }
}
