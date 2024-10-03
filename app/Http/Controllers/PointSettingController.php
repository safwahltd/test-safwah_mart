<?php

namespace App\Http\Controllers;

use App\Models\PointSetting;
use Illuminate\Http\Request;

class PointSettingController extends Controller
{
    /*
     |--------------------------------------------------------------------------
     | UPDATE POINT SETTING METHOD
     |--------------------------------------------------------------------------
    */
    public function updatePointSetting(Request $request)
    {
        try {
            foreach ($request->value as $key => $value) {

                PointSetting::where('id', $request->id[$key])->update([ 'value' => $value ]);
            }

            return redirect()->back()->withMessage('Point Setting Successfully Updated');

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }
}
