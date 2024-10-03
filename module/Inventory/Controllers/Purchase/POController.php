<?php

namespace Module\Inventory\Controllers\Purchase;

use App\Traits\Helper;
use App\Traits\FileSaver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\Product\Models\Product;
use Module\Account\Models\Supplier;
use App\Http\Controllers\Controller;
use Module\Inventory\Models\Purchase;
use Module\Inventory\Models\Warehouse;
use Module\Inventory\Models\PurchaseDetail;
use Module\Inventory\Services\StockService;
use Module\Product\Models\ProductVariation;
use Module\Inventory\Services\PurchaseService;
use Module\Inventory\Services\TransactionService;

class POController extends Controller
{
    use Helper, FileSaver;
    public $purchaseService;
    public $stockService;
    public $transactionService;



    

    /*
     |--------------------------------------------------------------------------
     | CONSTRUCT METHOD
     |--------------------------------------------------------------------------
    */
    public function __construct()
    {
        $this->purchaseService      = new PurchaseService;
        $this->stockService         = new StockService;
        $this->transactionService   = new TransactionService;
    }





    /*
     |--------------------------------------------------------------------------
     | PO LIST METHOD
     |--------------------------------------------------------------------------
    */
    public function poList(Request $request)
    {
        $data['suppliers']      = Supplier::pluck('name', 'id');
        $data['warehouses']     = Warehouse::pluck('name', 'id');
        $data['purchases']      = Purchase::query()
                                ->with('supplier:id,name')
                                ->with('warehouse:id,name')
                                ->when(($request->filled('from') && $request->filled('to')), function($query) use ($request) {
                                    $query->whereBetween('p_o_date', [$request->from, $request->to]);
                                })
                                ->searchByField('supplier_id')
                                ->searchByField('warehouse_id')
                                ->searchByField('p_o_no')
                                ->latest()
                                ->paginate(50);

        return view('purchases.p-o.index', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | PO CREATE (METHOD)
     |--------------------------------------------------------------------------
    */
    public function poCreate()
    {
        $data['suppliers']      = Supplier::pluck('name', 'id');
        $data['warehouses']     = Warehouse::pluck('name', 'id');
        $data['products']       = Product::query()
                                ->with('category:id,name')
                                ->with('unitMeasure:id,name')
                                ->select('id', 'name', 'code', 'category_id', 'unit_measure_id', 'purchase_price', 'sale_price')
                                ->get();

        return view('purchases.p-o.create', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | GET PRODUCT VARIATIONS (AXIOS)
     |--------------------------------------------------------------------------
    */
    public function getProductVariations(Request $request)
    {
        return  ProductVariation::query()
                ->where('product_id', $request->product_id)
                ->select('id', 'name', 'product_id', 'sku', 'purchase_price', 'sale_price')
                ->get();
    }





    /*
     |--------------------------------------------------------------------------
     | PO STORE VALIDATION (METHOD)
     |--------------------------------------------------------------------------
    */
    protected function poStoreValidation($request)
    {
        $request->validate([
            'supplier_id'           => 'required',
            'warehouse_id'          => 'required',
            'p_o_date'              => 'required|date',
            'p_o_no'                => 'required',
        ]);
    }
    

    


    /*
     |--------------------------------------------------------------------------
     | PO STORE (METHOD)
     |--------------------------------------------------------------------------
    */
    public function poStore(Request $request)
    {
        $this->poStoreValidation($request);

        try {

            DB::transaction(function () use($request) {
                $this->purchaseService->createPO($request);
                $this->purchaseService->createPurchaseDetails($request);
            });

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        return redirect()->route('inv.purchases.p-o.list')->withMessage('P.O. has been Created Successfully.');
    }




    /*
     |--------------------------------------------------------------------------
     | PO EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function poEdit($id)
    {
        $data['suppliers']      = Supplier::pluck('name', 'id');
        $data['warehouses']     = Warehouse::pluck('name', 'id');
        $data['purchase']       = $this->getPurchaseData($id);
        $data['products']       = Product::query()
                                ->with('category:id,name')
                                ->with('unitMeasure:id,name')
                                ->select('id', 'name', 'code', 'category_id', 'unit_measure_id', 'purchase_price', 'sale_price')
                                ->get();

        return view('purchases.p-o.edit', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | PO UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function poUpdate(Request $request, $id)
    {
        $this->poStoreValidation($request);

        try {
            DB::transaction(function () use($request, $id) {

                $purchase = Purchase::find($id);

                $this->purchaseService->updatePO($request, $purchase);

                $this->purchaseService->updateOrCreatePurchaseDetails($request);
            });
        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        return redirect()->route('inv.purchases.p-o.list')->withMessage('P.O. has been Updated Successfully');
    }





    /*
     |--------------------------------------------------------------------------
     | GET PURCHASE DATA
     |--------------------------------------------------------------------------
    */
    public function getPurchaseData($id)
    {
        return  Purchase::query()
                ->where('id', $id)
                ->with('supplier:id,name')
                ->with('warehouse:id,name')
                ->with(['purchaseDetails' => function ($q1) {
                    $q1->with('productVariation:id,name')
                    ->with(['product' => function ($q2) {
                        $q2->with('category:id,name')
                        ->with('unitMeasure:id,name')
                        ->select('id', 'name', 'code', 'category_id', 'unit_measure_id');
                    }]);
                }])
                ->first();
    }








    /*
     |--------------------------------------------------------------------------
     | PO VERIFICATION METHOD
     |--------------------------------------------------------------------------
    */
    public function poVerification(Request $request, $id)
    {
        if ($request->isMethod('post')) {

            try {

                Purchase::where('id', $id)->update([
                    'verified_at'   => date('Y-m-d'),
                    'verified_by'   => auth()->id(),
                    'status'        => 'Verified'
                ]);

            } catch(\Exception $ex) {
                return redirect()->back()->withError($ex->getMessage());
            }

            return redirect()->route('inv.purchases.p-o.list')->withMessage('P.O. has been Verified Successfully');

        } else {
            
            $data['purchase'] = $this->getPurchaseData($id);

            return view('purchases.p-o.verification', $data);
        }
    }







    public function poItemsDestroy($id)
    {
        try {

            $purchaseDetail = PurchaseDetail::find($id);
            $purchaseDetail->delete();

            $purchase = Purchase::with('purchaseDetails')->find($purchaseDetail->purchase_id);
            $purchase->update([
                'total_quantity' => array_sum(array_column($purchase->purchaseDetails->toArray(), 'quantity'))
            ]);

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        return redirect()->back()->withMessage('Item has been Deleted Successfully.');
    }




    /*
    |--------------------------------------------------------------------------
    | PO DESTROY METHOD
    |--------------------------------------------------------------------------
    */
    public function poDestroy($id)
    {
        try {
            $purchase = Purchase::find($id);

            foreach($purchase->purchaseDetails as $purchaseDetail) {
                $purchaseDetail->delete();
            }

            $purchase->delete();

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        return redirect()->back()->withMessage('P.O. has been Deleted Successfully.');
    }
}
