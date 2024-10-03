<?php

namespace App\View\Components\Settings;

use Illuminate\View\Component;

class OrderSetting extends Component
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
        $orderSettings = \App\Models\OrderSetting::get();

        return view('components.settings.order-setting', compact('orderSettings'));
    }
}
