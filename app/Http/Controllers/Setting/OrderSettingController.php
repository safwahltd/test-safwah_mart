<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\OrderSetting;
use Illuminate\Http\Request;

class OrderSettingController extends Controller
{


    /*
     |--------------------------------------------------------------------------
     | UPDATE ORDER SETTING METHOD
     |--------------------------------------------------------------------------
    */
    public function updateOrderSetting(Request $request)
    {
        try {
            foreach ($request->value as $key => $value) {

                OrderSetting::where('id', $request->id[$key])->update([ 'value' => $value ]);
            }

            return redirect()->back()->withMessage('Order Setting Successfully Updated');

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }
}
