<?php

namespace App\View\Components\Settings;

use App\Models\Company;
use Illuminate\View\Component;

class CompanySetting extends Component
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
        $companyInfos = Company::whereId(1)->first();

        return view('components.settings.company-setting', compact('companyInfos'));
    }
}
