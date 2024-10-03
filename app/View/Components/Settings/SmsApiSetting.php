<?php

namespace App\View\Components\Settings;

use Illuminate\View\Component;

class SmsApiSetting extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $smsApiSetting = \App\Models\SmsApiSetting::whereId(1)->first();
        return view('components.settings.sms-api-setting', compact('smsApiSetting'));
    }
}
