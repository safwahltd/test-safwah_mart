<?php


namespace App\Traits;
use App\Models\EmailSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

trait EmailNotification
{
    public function sendEmailNotification()
    {
        $emailInfo = EmailSetting::find(1);
        if (!empty($emailInfo)) {

            Config::set('mail.from.name', $emailInfo->sender_name);
            Config::set('mail.from.address', $emailInfo->sender_email);
            Config::set('mail.default', $emailInfo->mail_mailer);
            Config::set('mail.mailers.smtp.host', $emailInfo->mail_host);
            Config::set('mail.mailers.smtp.port', $emailInfo->mail_port);
            Config::set('mail.mailers.smtp.encryption', $emailInfo->mail_encryption);
            Config::set('mail.mailers.smtp.username', $emailInfo->mail_username);
            Config::set('mail.mailers.smtp.password', $emailInfo->mail_password);

        } else {
            $emailInfo = '';
            Session::flash('error', 'Email Setup Required');
        }
        return $emailInfo;
    }
}
