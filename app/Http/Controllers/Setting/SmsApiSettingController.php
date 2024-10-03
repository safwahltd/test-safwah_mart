<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\SmsApiSetting;
use Illuminate\Http\Request;

class SmsApiSettingController extends Controller
{
    /*
     |--------------------------------------------------------------------------
     | UPDATE SMS API SETTING METHOD
     |--------------------------------------------------------------------------
    */
    public function updateSmsApiSetting(Request $request, $id)
    {
        $request->validate([

            'base_url'      => 'required',
            'api_key'       => 'required',
            'sender_id'     => 'required',
        ]);



        try {

            SmsApiSetting::whereId($id)->update([

                'base_url'          => $request->base_url,
                'api_key'           => $request->api_key,
                'sender_id'         => $request->sender_id,
            ]);

            return redirect()->back()->withMessage('SMS API Setting Successfully Updated');

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }
}
