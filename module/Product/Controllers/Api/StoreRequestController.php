<?php

namespace Module\Product\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Module\Product\Models\StockRequest;

class StoreRequestController extends Controller
{


    
    /*
     |--------------------------------------------------------------------------
     | GET STOCK REQUESTS
     |--------------------------------------------------------------------------
    */
    public function getStockRequests($customer_id)
    {
        try {
            $stockRequests = StockRequest::where('customer_id', $customer_id)->get();

            return response()->json([
                'data'      => $stockRequests,
                'status'    => 1,
                'message'   => 'success',
            ]);

        } catch (\Throwable $th) {

            return response()->json([
                'data'      => '',
                'status'    => 0,
                'message'   => $th->getMessage(),
            ]);
        }
    }





    /*
     |--------------------------------------------------------------------------
     | STORE STOCK REQUEST
     |--------------------------------------------------------------------------
    */
    public function storeStockRequest(Request $request)
    {
        try {
            StockRequest::firstOrCreate([
                'customer_id'           => $request->customer_id,
                'product_id'            => $request->product_id,
                'product_variation_id'  => $request->product_variation_id,
            ]);


            return response()->json([
                'status'    => 1,
                'message'   => 'success',
            ]);

        } catch (\Throwable $th) {

            return response()->json([
                'status'    => 0,
                'message'   => $th->getMessage(),
            ]);
        }
    }
}
