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
use App\Services\NextInvoiceNoService;
use Module\Inventory\Models\Warehouse;
use Module\Product\Services\StockService;
use Module\Inventory\Models\PurchaseDetail;
use Module\Product\Models\ProductVariation;
use Module\Inventory\Services\PurchaseService;
use Module\Inventory\Services\TransactionService;
use App\Traits\CheckPermission;

class PurchaseController extends Controller
{
    use CheckPermission;

    use Helper, FileSaver;
    public $purchaseService;
    public $stockService;
    public $transactionService;
    public $nextInvoiceNumberService;





    /*
     |--------------------------------------------------------------------------
     | CONSTRUCT METHOD
     |--------------------------------------------------------------------------
    */
    public function __construct()
    {
        $this->purchaseService              = new PurchaseService;
        $this->stockService                 = new StockService;
        $this->transactionService           = new TransactionService;
        $this->nextInvoiceNumberService     = new NextInvoiceNoService;
    }





    /*
     |--------------------------------------------------------------------------
     | INDEX (METHOD)
     |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $this->hasAccess("purchases.index");

        $data['suppliers']      = Supplier::pluck('name', 'id');
        $data['warehouses']     = Warehouse::pluck('name', 'id');
        $data['purchases']      = Purchase::query()
                                ->direct()
                                ->with('supplier:id,name')
                                ->with('warehouse:id,name')
                                ->when(($request->filled('from') && $request->filled('to')), function($query) use ($request) {
                                    $query->whereBetween('date', [$request->from, $request->to]);
                                })
                                ->searchByField('supplier_id')
                                ->searchByField('warehouse_id')
                                ->searchByField('invoice_no')
                                ->latest()
                                ->paginate(50);

        return view('purchases.index', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | CREATE (METHOD)
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("purchases.create");

        $data['suppliers']      = Supplier::pluck('name', 'id');
        $data['warehouses']     = Warehouse::pluck('name', 'id');
        $data['products']       = Product::query()
                                ->with('category:id,name')
                                ->with('unitMeasure:id,name')
                                ->select('id', 'name', 'code', 'category_id', 'unit_measure_id', 'purchase_price')
                                ->get();

        return view('purchases.create', $data);
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
                ->select('id', 'name', 'product_id', 'sku', 'purchase_price')
                ->get();
    }





    /*
     |--------------------------------------------------------------------------
     | STORE VALIDATION (METHOD)
     |--------------------------------------------------------------------------
    */
    protected function storeValidation($request)
    {
        $request->validate([
            'supplier_id'           => 'required',
            'warehouse_id'          => 'required',
            'date'                  => 'required|date',
            'invoice_no'            => 'sometimes',
        ]);
    }





    /*
     |--------------------------------------------------------------------------
     | STORE (METHOD)
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $this->storeValidation($request);

        // return $request->all();
        try {

            DB::transaction(function () use($request) {

                $this->purchaseService->createPurchase($request);

                $this->purchaseService->createPurchaseDetails($request);

                $this->nextInvoiceNumberService->setNextInvoiceNo($request->company_id ?? optional(auth()->user())->company_id, $request->warehouse_id, 'Purchase', date('Y'));
            });

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        return redirect()->route('inv.purchases.index')->withMessage('Purchase has been Created Successfully.');
    }




    /*
     |--------------------------------------------------------------------------
     | EDIT (METHOD)
     |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $this->hasAccess("purchases.edit");

        $data['suppliers']      = Supplier::pluck('name', 'id');
        $data['warehouses']     = Warehouse::pluck('name', 'id');
        $data['purchase']       = $this->getPurchaseData($id);
        $data['products']       = Product::query()
                                ->with('category:id,name')
                                ->with('unitMeasure:id,name')
                                ->select('id', 'name', 'code', 'category_id', 'unit_measure_id', 'purchase_price')
                                ->get();

        return view('purchases.edit', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE (METHOD)
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $this->storeValidation($request);

        try {
            DB::transaction(function () use($request, $id) {

                $purchase = Purchase::find($id);

                $this->purchaseService->updatePurchase($request, $purchase);

                $this->purchaseService->updateOrCreatePurchaseDetails($request);
            });
        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        return redirect()->route('inv.purchases.index')->withMessage('Purchase has been Updated Successfully');
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
                        ->select('id', 'name', 'code', 'sku', 'category_id', 'unit_measure_id');
                    }]);
                }])
                ->first();
    }





    /*
     |--------------------------------------------------------------------------
     | PURCHASE APPROVE AND RECEIVE (METHOD)
     |--------------------------------------------------------------------------
    */
    public function purchaseApproveAndReceive(Request $request, $id)
    {
        if ($request->isMethod('post')) {

            try {

                DB::transaction(function () use ($request, $id) {

                    $purchase = Purchase::with('purchaseDetails')->find($id);

                    $this->purchaseService->approveAndReceivePurchase($request, $purchase);

                    $this->purchaseService->approveAndReceivePurchaseDetails($request, $purchase);

                    if ($request->attachment) {

                        $this->upload_file($request->attachment, $purchase, 'attachment', 'attachment/purchase');
                    }
                });

            } catch(\Exception $ex) {
                return redirect()->back()->withError($ex->getMessage());
            }

            return redirect()->route('inv.purchases.index')->withMessage('Purchase has been Approve & Receive Successfully');

        } else {

            $data['purchase'] = $this->getPurchaseData($id);

            return view('purchases.approve-and-receive', $data);
        }
    }





    /*
     |--------------------------------------------------------------------------
     | PURCHASE ITEMS DESTROY METHOD
     |--------------------------------------------------------------------------
    */
    public function purchaseItemsDestroy($id)
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
     | DESTROY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $this->hasAccess("purchases.delete");

        try {

            DB::transaction(function () use ($id) {

                $purchase = Purchase::find($id);

                if (count($purchase->transactions) > 0) {
                    $purchase->transactions()->delete();
                }

                foreach($purchase->purchaseDetails as $purchaseDetail) {

                    if (count($purchaseDetail->stocks) > 0) {

                        $this->stockService->deleteStocks($purchaseDetail);

                        $this->stockService->updateStockSummaries($purchase->company_id, $purchase->supplier_id, $purchase->warehouse_id, $purchaseDetail->product_id, $purchaseDetail->product_variation_id, $purchaseDetail->lot, null, $purchaseDetail->quantity, 0, $purchaseDetail->quantity * $purchaseDetail->purchase_price, 0);
                    }

                    $purchaseDetail->delete();
                }

                if(file_exists($purchase->attachment))
                {
                    unlink($purchase->attachment);
                }

                $purchase->delete();
            });

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        return redirect()->back()->withMessage('Purchase has been Deleted Successfully.');
    }
}
