<?php

namespace App\Http\Controllers\Api;

use App\Models\OrderSetting;
use App\Models\SystemSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\Inventory\Models\Order;
use Module\WebsiteCMS\Models\Page;

class SettingController extends Controller
{


    //----------------------------------------------//
    //      GET MINIMUM ORDER AMOUNT VALUE          //
    //----------------------------------------------//
    public function getMinimumOrderAmountValue()
    {
        return OrderSetting::where('id', 1)->select('value')->first() ;
    }




    //----------------------------------------------//
    //          CHECKOUT SYSTEM SETTING             //
    //----------------------------------------------//
    public function checkoutSystemSetting(Request $request)
    {
        return SystemSetting::whereIn('id', [2])->get() ;
    }





    //----------------------------------------------//
    //      DELIVERY DATE TIME SLOT SYSTEM SETTING  //
    //----------------------------------------------//
    public function deliveryDateTimeSlotCmsSetting()
    {

        try {

            $data['cms_settings'] = DB::table('ecom_settings')
                                        ->where('id', 16)
                                        ->orWhere('id', 17)
                                        ->get(['id','title','value']);

            return response()->json([
                'data'      => $data,
                'message'   => 'Success',
                'status'    => 1,
            ]);

        } catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => 'Error',
                'status'    => 0,
            ]);
        }

    }




    //----------------------------------------------//
    //       CHECKOUT PAGE CMS SYSTEM SETTING       //
    //----------------------------------------------//
    public function checkoutPageCmsSetting()
    {
        try {

            $data['page']         = DB::table('web_pages')
                                    ->where('slug', 'checkout')
                                    ->first();

            $data['cms_settings'] = DB::table('ecom_settings')
                                    ->whereIn('id', ['16', '17', '30', '32', '38', '39', '40', '41', '42', '43', '44'])
                                    ->get(['id', 'title', 'value']);

            return response()->json([
                'data'      => $data,
                'message'   => 'Success',
                'status'    => 1,
            ]);

        } catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => 'Error',
                'status'    => 0,
            ]);
        }
    }





    //----------------------------------------------//
    //      DELIVERY DATE TIME SLOT SYSTEM SETTING  //
    //----------------------------------------------//
    public function deliveryDateTimeSlotSystemSetting()
    {

        try {

            $data['system_settings'] = DB::table('system_settings')
                                        ->where('id', 7)
                                        ->orWhere('id', 8)
                                        ->get(['id','key','value']);

            return response()->json([
                'data'      => $data,
                'message'   => 'Success',
                'status'    => 1,
            ]);

        } catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => 'Error',
                'status'    => 0,
            ]);
        }

    }





    //----------------------------------------------//
    //      GET LAST ORDER ID //
    //----------------------------------------------//
    public function getLastOrderId()
    {
        try {

            $last_order_id = Order::max('id');

            return response()->json([
                'data'      => ($last_order_id + 1),
                'message'   => 'Success',
                'status'    => 1,
            ]);

        } catch (\Throwable $th) {

            return response()->json([
                'data'      => 1,
                'message'   => 'Success',
                'status'    => 1,
            ]);
        }
    }


}
