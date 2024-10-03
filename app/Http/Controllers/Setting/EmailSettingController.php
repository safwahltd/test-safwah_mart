<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\UpdateEmailSettingRequest;
use App\Models\EmailSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class EmailSettingController extends Controller
{
    /*
     |--------------------------------------------------------------------------
     | UPDATE EMAIL SETTING METHOD
     |--------------------------------------------------------------------------
    */
    public function updateEmailSetting(UpdateEmailSettingRequest $request, $id)
    {

        try {

            EmailSetting::whereId($id)->update([

                'sender_name'           => $request->sender_name,
                'sender_email'          => $request->sender_email,
                'mail_mailer'           => $request->mail_mailer,
                'mail_host'             => $request->mail_host,
                'mail_port'             => $request->mail_port,
                'mail_encryption'       => $request->mail_encryption,
                'mail_username'         => $request->mail_username,
                'mail_password'         => $request->mail_password,
            ]);

            return redirect()->back()->withMessage('Email Setting Successfully Updated');

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }
}
