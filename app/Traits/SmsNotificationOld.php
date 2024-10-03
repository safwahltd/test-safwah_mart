<?php


namespace App\Traits;
use App\Models\Company;
use App\Models\SmsApiSetting;
use Illuminate\Support\Facades\Http;

trait SmsNotification
{
    public function sendSmsNotification($message, $phone)
    {
        $smsApiSetting = SmsApiSetting::whereId(1)->first();
        $companyInfo = Company::select('name')->whereId(1)->first();

        Http::post($smsApiSetting->base_url, [

            "api_key"       => $smsApiSetting->api_key,
            "senderid"      => $smsApiSetting->sender_id,
            "type"          => "text",
            "msg"           => $message . $companyInfo->name,
            "contacts"      => '88'.$phone
        ]);
    }
}
