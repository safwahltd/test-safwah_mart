<?php

namespace App\View\Components\Settings;

use Illuminate\View\Component;

class PointSetting extends Component
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
        $pointSettings = \App\Models\PointSetting::get();

        return view('components.settings.point-setting', compact('pointSettings'));
    }
}
