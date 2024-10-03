<?php

namespace App\View\Components\Settings;

use Illuminate\View\Component;

class EmailSetting extends Component
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
        $data['emailSetting'] = \App\Models\EmailSetting::whereId(1)->first();
        $data['mailEncryptions'] = ['tls', 'ssl'];

        return view('components.settings.email-setting', $data);
    }
}
