<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmailSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'sender_name'           => 'required',
            'sender_email'          => 'required|email|regex:/^\S*$/u',
            'mail_mailer'           => 'required',
            'mail_host'             => 'required|regex:/^\S*$/u',
            'mail_port'             => 'required',
            'mail_encryption'       => 'required',
            'mail_username'         => 'required|regex:/^\S*$/u',
            'mail_password'         => 'required|regex:/^\S*$/u',
        ];
    }




    public function messages()
    {
        return [

            'sender_name.required'          => 'Sender Name field is required.',
            'sender_email.required'         => 'Sender Email field is required.',
            'sender_email.email'            => 'Sender Email must be an email.',
            'sender_email.regex'            => 'Can\'t use space between Sender Email.',
            'mail_mailer.required'          => 'Mail Mailer field is required.',
            'mail_host.required'            => 'Mail Host field is required.',
            'mail_host.regex'               => 'Can\'t use space between Mail Host.',
            'mail_port.required'            => 'Mail Port field is required.',
            'mail_encryption.required'      => 'Mail Encryption field is required.',
            'mail_username.required'        => 'Mail Username field is required.',
            'mail_username.regex'           => 'Can\'t use space between Mail Username.',
            'mail_password.required'        => 'Mail Password field is required.',
            'mail_password.regex'           => 'Can\'t use space between Mail Password.',
        ];
    }
}
