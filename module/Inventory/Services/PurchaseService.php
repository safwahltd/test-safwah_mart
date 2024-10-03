<?php

namespace Module\Inventory\Services;


use App\Traits\Helper;
use App\Traits\FileSaver;
use Module\Inventory\Models\Purchase;
use App\Services\NextInvoiceNoService;
use Module\Product\Services\StockService;
use Module\Inventory\Models\PurchaseDetail;
use Module\Inventory\Services\TransactionService;

class PurchaseService
{
    use FileSaver, Helper;
    public $purchase;
    public $grn;
    public $stockService;
    public $transactionService;
    public $nextInvoiceNumberService;




    public function __construct()
    {
        $this->stockService                 = new StockService;
        $this->transactionService           = new TransactionService;
        $this->nextInvoiceNumberService     = new NextInvoiceNoService;
    }




    /*
     |--------------------------------------------------------------------------
     | CREATE PURCHASE METHOD
     |--------------------------------------------------------------------------
    */
    public function createPurchase($request)
    {
        $this->purchase = Purchase::create(
        [
            'company_id'                        => $request->company_id ?? optional(auth()->user())->company_id,
            'supplier_id'                       => $request->supplier_id,
            'warehouse_id'                      => $request->warehouse_id,
            'type'                              => $request->type,
            'date'                              => $request->date,
            'invoice_no'                        => $this->nextInvoiceNumberService->getPurchaseInvoiceNo($request->company_id ?? optional(auth()->user())->company_id, $request->warehouse_id),
            'status'                            => $request->type == 'Direct' ? 'Pending' : 'PO Pending',
            'note'                              => $request->note ?? null,
        ]);
    }




    /*
     |--------------------------------------------------------------------------
     | CREATE PO METHOD
     |--------------------------------------------------------------------------
    */
    public function createPO($request)
    {
        // $this->purchase = Purchase::create(
        // [
        //     'company_id'                        => $request->company_id ?? auth()->user()->company_id,
        //     'supplier_id'                       => $request->supplier_id,
        //     'warehouse_id'                      => $request->warehouse_id,
        //     'p_o_date'                          => $request->p_o_date ?? null,
        //     'p_o_no'                            => $request->p_o_no,
        //     'p_o_created_by'                    => $request->p_o_created_by ?? auth()->id(),
        // ]);
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE PO METHOD
     |--------------------------------------------------------------------------
    */
    public function updatePurchase($request, $purchase)
    {
        $purchase->update(
        [
            'company_id'                        => $request->company_id ?? auth()->user()->company_id,
            'supplier_id'                       => $request->supplier_id,
            'warehouse_id'                      => $request->warehouse_id,
            'date'                              => $request->date ?? null,
            'note'                              => $request->note ?? null,
        ]);


        $this->purchase = $purchase->refresh();
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE PO METHOD
     |--------------------------------------------------------------------------
    */
    public function updatePO($request, $purchase)
    {
        // $purchase->update(
        // [
        //     'company_id'                        => $request->company_id ?? auth()->user()->company_id,
        //     'supplier_id'                       => $request->supplier_id,
        //     'warehouse_id'                      => $request->warehouse_id,
        //     'p_o_date'                          => $request->p_o_date ?? null,
        //     'note'                              => $request->note ?? null,
        // ]);


        // $this->purchase = $purchase->refresh();
    }




    /*
     |--------------------------------------------------------------------------
     | PI VERIFICATION METHOD
     |--------------------------------------------------------------------------
    */
    public function piVerification($request, $status)
    {
        Purchase::whereId($request->purchaseId)->update([

            'authorized_by'             => $request->authorizedBy,
            'date_of_approval'          => $request->dateOfApproval,
            'status'                    => $status,
            'note'                      => $request->note,
        ]);
    }




    /*
     |--------------------------------------------------------------------------
     | CREATE PURCHASE DETAILS METHOD
     |--------------------------------------------------------------------------
    */
    public function createPurchaseDetails($request)
    {
        foreach ($request->product_id as $key => $product_id) {

            $this->purchaseDetailCreate($request, $product_id, $key);
        }

        $this->updateTotalQuantityAndSubtotal();
    }




    public function purchaseDetailCreate($request, $product_id, $key)
    {
        PurchaseDetail::create([
            'purchase_id'          => $this->purchase->id,
            'product_id'           => $product_id,
            'product_variation_id' => $request->product_variation_id[$key],
            'lot'                  => $request->lot[$key],
            'purchase_price'       => $request->purchase_price[$key] ?? 0,
            'quantity'             => $request->quantity[$key] ?? 0,
            'expired_date'         => $request->expired_dates[$key],
            'special_comment'      => $request->special_comment[$key],
        ]);
    }



    public function updateOrCreatePurchaseDetails($request)
    {
        foreach ($request->product_id as $key => $product_id) {

            if ($request->purchase_detail_id[$key] != null) {

                PurchaseDetail::where('id', $request->purchase_detail_id[$key])->update([
                    'lot'             => $request->lot[$key],
                    'purchase_price'  => $request->purchase_price[$key] ?? 0,
                    'expired_date'    => $request->expired_dates[$key],
                    'quantity'        => $request->quantity[$key] ?? 0,
                    'special_comment' => $request->special_comment[$key],
                ]);

            } else {

                $this->purchaseDetailCreate($request, $product_id, $key);
            }

        }

        $this->updateTotalQuantityAndSubtotal();
    }





    public function updateTotalQuantityAndSubtotal()
    {
        $this->purchase->update([
            'total_quantity'    => array_sum(array_column($this->purchase->purchaseDetails->toArray(), 'quantity')),
            'subtotal'          => array_sum(array_column($this->purchase->purchaseDetails->toArray(), 'total_amount')),
        ]);
    }








    /*
     |--------------------------------------------------------------------------
     | APPROVE AND RECEIVE PURCHASE
     |--------------------------------------------------------------------------
    */
    public function approveAndReceivePurchase($request, $purchase)
    {
        $purchase->update([
            'approved_at'               => date('Y-m-d'),
            'approved_by'               => auth()->id(),
            'status'                    => 'Received',
            'total_discount_percent'    => $request->total_discount_percent,
            'total_discount_amount'     => $request->total_discount_amount,
            'payable_amount'            => $request->payable_amount,
            'paid_amount'               => $request->paid_amount,
            'due_amount'                => $request->due_amount,
        ]);
    }








    /*
     |--------------------------------------------------------------------------
     | APPROVE AND RECEIVE PURCHASE DETAILS
     |--------------------------------------------------------------------------
    */
    public function approveAndReceivePurchaseDetails($request, $purchase)
    {
        foreach($request->purchase_detail_id as $key => $purchase_detail_id) {

            $purchaseDetail = PurchaseDetail::find($purchase_detail_id);

            $purchaseDetail->update([
                'received_quantity' => $request->quantity[$key],
                'expired_date'    => $request->expired_dates[$key],
            ]);


            // STORE STOCK
            $this->stockService->storeStock($purchaseDetail, $purchase->company_id, $purchase->supplier_id, $purchase->warehouse_id, $request->product_id[$key], $request->product_variation_id[$key], $request->lot[$key] ?? 'N/A', $purchase->invoice_no, date('Y-m-d'), 'In', $request->purchase_price[$key], 0, $request->quantity[$key], $purchaseDetail->expired_date);


            // UPDATE OR CREATE STOCK SUMMARY
            $this->stockService->updateOrCreateStockSummary($purchase->company_id, $purchase->supplier_id, $purchase->warehouse_id, $request->product_id[$key], $request->product_variation_id[$key], $request->lot[$key] ?? 'N/A', null, $request->quantity[$key], 0, $request->purchase_price[$key] * $request->quantity[$key], 0);


            $this->transactionService->storeTransaction($purchase);
        }
    }
}
