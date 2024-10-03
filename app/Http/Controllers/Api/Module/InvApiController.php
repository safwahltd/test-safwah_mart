<?php

namespace App\Http\Controllers\Api\Module;
use App\Models\User;

use Illuminate\Http\Request;
use App\Services\RegisterService;
use Illuminate\Support\Facades\DB;
use Module\Account\Models\Customer;
use Module\WebsiteCMS\Models\Page;
use Module\WebsiteCMS\Services\JsonResponseService;

class InvApiController
{
    private $jsonResponseService;
    private $service;




    /*
     |--------------------------------------------------------------------------
     | CONSTRUCT
     |--------------------------------------------------------------------------
    */
    public function __construct(JsonResponseService $jsonResponseService, RegisterService $registerService)
    {
        $this->jsonResponseService = $jsonResponseService;
        $this->service = $registerService;

    }



    public function getProfile()
    {

        try{

            $data['page']         = DB::table('web_pages')
                                    ->where('slug', 'checkout')
                                    ->first();


            $data['cms_settings'] = DB::table('ecom_settings')
                                    ->whereIn('id', ['16', '17', '30', '32', '38', '39', '40', '41', '42', '43', '44'])
                                    ->get(['id', 'title', 'value']);


            $data['user']    = User::query()
                                ->with(['customer' => function ($q) {
                                    $q->with('district:id,name')
                                    ->with('area:id,name');
                                }])
                                ->where('id', auth()->id())
                                ->first();

            // $data['page']    = Page::where('slug', 'profile')->first();

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);

        }catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);

        }
    }



    public function updateCustomer(Request $request)
    {
        return $this->service->store($request);
    }




    public function updateSocialUserPhone(Request $request)
    {
        DB::transaction(function() use($request){

            User::find($request->social_id)->update([
                'phone'   => $request->phone_number,
            ]);

            Customer::where('user_id', $request->social_id)->update([
                'mobile'  => $request->phone_number,
            ]);

        });
    }





    /*
     |--------------------------------------------------------------------------
     | MY POINT
     |--------------------------------------------------------------------------
    */
    public function myPoint()
    {
        try{
            $customer   = Customer::query()
                        ->whereHas('user', function ($q) {
                            $q->where('id', auth()->id());
                        })
                        ->select('point')
                        ->first();

            $point = 0;

            if ($customer) {
                $point = $customer->point;
            }

            return response()->json([
                'status'    => 1,
                'message'   => "Success",
                'point'     => $point,
            ]);

        }catch (\Throwable $th) {

            return response()->json([
                'status'    => 0,
                'message'   => "Error",
                'point'     => 0,
            ]);

        }
    }





    /*
     |--------------------------------------------------------------------------
     | MY WALLET
     |--------------------------------------------------------------------------
    */
    public function myWallet()
    {
        try{
            $customer   = Customer::query()
                        ->whereHas('user', function ($q) {
                            $q->where('id', auth()->id());
                        })
                        ->select('wallet')
                        ->first();

            $wallet = 0;

            if ($customer) {
                $wallet = $customer->wallet;
            }

            return response()->json([
                'status'    => 1,
                'message'   => "Success",
                'wallet'    => $wallet,
            ]);

        }catch (\Throwable $th) {

            return response()->json([
                'status'    => 0,
                'message'   => "Error",
                'wallet'    => 0,
            ]);

        }
    }
}
