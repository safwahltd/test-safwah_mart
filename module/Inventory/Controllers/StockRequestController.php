<?php

namespace Module\Inventory\Controllers;

use App\Models\Area;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Module\Account\Models\Customer;
use Module\Product\Models\Product;
use Module\Product\Models\StockRequest;

class StockRequestController extends Controller
{
    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        $data['districts']      = District::orderBy('name','ASC')->pluck('name', 'id');
        $data['areas']          = Area::orderBy('name','ASC')->pluck('name', 'id');
        $data['customers']      = Customer::get(['id', 'name', 'mobile']);
        $data['products']       = Product::get(['id', 'name', 'code']);
        $data['stockRequests']  = StockRequest::query()
                                ->searchByField('product_id')
                                ->searchByField('customer_id')
                                ->whereHas('customer', function ($q) {
                                    $q->searchByField('district_id')
                                        ->searchByField('area_id');
                                })
                                ->with(['customer' => function ($q) {
                                    $q->with('district:id,name')
                                        ->with('area:id,name')
                                        ->select('id', 'name', 'mobile', 'district_id', 'area_id');
                                }])
                                ->with('product:id,name,code')
                                ->paginate(20);

        return view('stock-request/index', $data);
    }












    /*
     |--------------------------------------------------------------------------
     | DELETE/DESTORY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        try {
            
            StockRequest::destroy($id);

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
        
        return redirect()->back()->withMessage('Stock Request has been Deleted Successfully'); 
    }
}



