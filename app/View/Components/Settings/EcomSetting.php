<?php

namespace App\View\Components\Settings;

use Illuminate\View\Component;

class EcomSetting extends Component
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
        $ecomSettings = \App\Models\EcomSetting::whereNotIn('id', [38,39,40,41,42,43,44,45,46,47])->get();

        return view('components.settings.ecom-setting', compact('ecomSettings'));
    }
}
