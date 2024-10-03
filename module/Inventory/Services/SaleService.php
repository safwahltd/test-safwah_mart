<?php

namespace Module\Inventory\Services;

use Module\Inventory\Models\Sale;
use Illuminate\Support\Facades\DB;
use Module\Account\Models\Account;
use Module\Account\Models\Customer;
use App\Services\NextInvoiceNoService;
use Module\Inventory\Models\SaleDetail;
use Module\Product\Models\StockSummary;
use Module\Inventory\Models\EcomAccount;
use Module\Inventory\Models\SalePayment;
use Module\Product\Services\StockService;
use Module\Account\Services\AccountTransactionService;

class SaleService
{
    public $stockService;
    public $sale;
    public $saleDetail;
    public $nextInvoiceNumberService;
    private $transactionService;






    /*
     |--------------------------------------------------------------------------
     | CONSTRUCT METHOD
     |--------------------------------------------------------------------------
    */
    public function __construct()
    {
        $this->stockService                 = new StockService;
        $this->nextInvoiceNumberService     = new NextInvoiceNoService;
        $this->transactionService           = new AccountTransactionService;

    }





    /*
     |--------------------------------------------------------------------------
     | CREATE SALE METHOD
     |--------------------------------------------------------------------------
    */
    public function createSale($request)
    {
        $this->sale = Sale::create(
        [
            'company_id'                        => $request->company_id ?? optional(auth()->user())->company_id,
            'customer_id'                       => $request->customer_id,
            'warehouse_id'                      => $request->warehouse_id,
            'type'                              => $request->type ?? 'POS',
            'date'                              => $request->date,
            'invoice_no'                        => $this->nextInvoiceNumberService->getSaleInvoiceNo($request->company_id ?? optional(auth()->user())->company_id, $request->warehouse_id),
            'total_cost'                        => $request->total_cost ?? 0,
            'subtotal'                          => $request->subtotal ?? 0,
            'total_vat_percent'                 => $request->total_vat_percent ?? 0,
            'total_vat_amount'                  => $request->total_vat_amount ?? 0,
            'total_discount_percent'            => $request->total_discount_percent ?? 0,
            'total_discount_amount'             => $request->total_discount_amount ?? 0,
            'rounding'                          => $request->rounding ?? 0,
            'payable_amount'                    => $request->payable_amount ?? 0,
            'paid_amount'                       => $request->paid_amount ?? 0,
            'due_amount'                        => $request->due_amount ?? 0,
            'change_amount'                     => $request->change_amount ?? 0,
            'sale_by'                           => $request->sale_by ?? NULL,
        ]);

        $this->customerCurrentbalanceUpdate($request->customer_id, $this->sale);
    }





    /*
     |--------------------------------------------------------------------------
     | CREATE SALE DETAILS METHOD
     |--------------------------------------------------------------------------
    */
    public function createSaleDetails($request)
    {
        foreach($request->product_id ?? [] as $key => $product_id) {

            $this->saleDetail = SaleDetail::create([
                'sale_id'                       => $this->sale->id,
                'product_id'                    => $product_id,
                'product_variation_id'          => $request->product_variation_id[$key],
                'measurement_title'             => $request->measurement_title[$key],
                'measurement_sku'               => $request->measurement_sku[$key],
                'measurement_value'             => $request->measurement_value[$key],
                'lot'                           => $request->lot[$key],
                'purchase_price'                => $request->purchase_price[$key] ?? 0,
                'sale_price'                    => $request->sale_price[$key] ?? 0,
                'quantity'                      => $request->quantity[$key] ?? 0,
                'vat_percent'                   => $request->pdt_vat_percent[$key] ?? 0,
                'vat_amount'                    => $request->pdt_vat_amount[$key] ?? 0,
                'discount_percent'              => $request->pdt_discount_percent[$key] ?? 0,
                'discount_amount'               => $request->pdt_total_discount_amount[$key] ?? 0,
            ]);

            $calculateQuantity = $this->saleDetail->measurement_value > 0 ? $this->saleDetail->quantity * $this->saleDetail->measurement_value : $this->saleDetail->quantity;

            if ($request->lot[$key] == null) {

                $lotQtyArr = [];
        
                $getLotNo = $this->getLotNo($request, $this->sale, $this->saleDetail);

                $getLotNumbers = $this->getLotNumbers($request, $this->sale, $this->saleDetail);

                if ($getLotNo != null) {

                    $this->stockService->storeStock($this->saleDetail, $this->sale->company_id ?? 1, null, $this->sale->warehouse_id, $this->saleDetail->product_id, $this->saleDetail->product_variation_id, $getLotNo->lot, $this->sale->invoice_no, $this->sale->date, 'Out', $this->saleDetail->purchase_price, $this->saleDetail->sale_price, $calculateQuantity, null);

                    $this->stockService->updateOrCreateStockSummary($this->sale->company_id ?? 1, null, $this->sale->warehouse_id, $this->saleDetail->product_id, $this->saleDetail->product_variation_id, $getLotNo->lot, null, 0, $calculateQuantity, 0, $this->saleDetail->purchase_price * $calculateQuantity);

                } else {

                    foreach($getLotNumbers as $key => $lotNumber) {

                        $balanceQty = $this->checkBalanceQty($request, $lotNumber->lot, $this->sale, $this->saleDetail);

                        if ($balanceQty > 0) {
                            
                            $leftQty = $calculateQuantity - array_sum($lotQtyArr);

                            $quantity = $lotNumber->balance_qty;
                        
                            if ($leftQty <= $lotNumber->balance_qty) {
                                $quantity = $leftQty;
                            }

                            if ($calculateQuantity > array_sum($lotQtyArr)) {

                                $this->stockService->storeStock($this->saleDetail, $this->sale->company_id ?? 1, null, $this->sale->warehouse_id, $this->saleDetail->product_id, $this->saleDetail->product_variation_id, $lotNumber->lot, $this->sale->invoice_no, $this->sale->date, 'Out', $this->saleDetail->purchase_price, $this->saleDetail->sale_price, $quantity, null);

                                $this->stockService->updateOrCreateStockSummary($this->sale->company_id ?? 1, null, $this->sale->warehouse_id, $this->saleDetail->product_id, $this->saleDetail->product_variation_id, $lotNumber->lot, null, 0, $quantity, 0, $this->saleDetail->purchase_price * $quantity);
                            }

                            array_push($lotQtyArr, $quantity);
                        }
                    }
                }

            } else {
                $this->stockService->storeStock($this->saleDetail, $this->sale->company_id, null, $this->sale->warehouse_id, $product_id, $request->product_variation_id[$key], $request->lot[$key], $this->sale->invoice_no, $this->sale->date, 'Out', $request->purchase_price[$key], $request->sale_price[$key], $calculateQuantity, null);

                $this->stockService->updateOrCreateStockSummary($this->sale->company_id, null, $this->sale->warehouse_id, $product_id, $request->product_variation_id[$key], $request->lot[$key], null, 0, $calculateQuantity, 0, $request->purchase_price[$key] * $calculateQuantity);
            }
        }


        $this->updateTotalQuantity();
    }




    public function getLotNo($request, $order, $saleDetail)
    {
        return  StockSummary::query()
                ->where([
                    'company_id'            => $order->company_id ?? 1,
                    'warehouse_id'          => $request->warehouse_id,
                    'product_id'            => $saleDetail->product_id,
                    'product_variation_id'  => $saleDetail->product_variation_id,
                ])
                ->where('balance_qty', '>=', $saleDetail->quantity)
                ->orderBy('id', 'ASC')
                ->first();
    }




    public function checkBalanceQty($request, $lot, $order, $saleDetail)
    {
        return  StockSummary::query()
                ->where([
                    'company_id'            => $order->company_id ?? 1,
                    'warehouse_id'          => $request->warehouse_id,
                    'product_id'            => $saleDetail->product_id,
                    'product_variation_id'  => $saleDetail->product_variation_id,
                    'lot'                   => $lot,
                ])
                ->orderBy('id', 'ASC')
                ->sum('balance_qty');
    }




    public function getLotNumbers($request, $order, $saleDetail)
    {
        return  StockSummary::query()
                ->where([
                    'company_id'            => $order->company_id ?? 1,
                    'warehouse_id'          => $request->warehouse_id,
                    'product_id'            => $saleDetail->product_id,
                    'product_variation_id'  => $saleDetail->product_variation_id,
                ])
                ->orderBy('id', 'ASC')
                ->get();
    }





    /*
     |--------------------------------------------------------------------------
     | CREATE SALE PAYMENT METHOD
     |--------------------------------------------------------------------------
    */
    public function createSalePayment1($request)
    {
        foreach (array_filter($request->ecom_account_id) as $key => $account_id) {

            $last_key = array_key_last($request->ecom_account_id);

            if ($request->payment_amount[$key] ?? 0 > 0) {

                $balance = $request->payment_amount[$key];

                if ($key == $last_key) {
                    $balance = $request->payment_amount[$key] - $this->sale->change_amount;
                }

                SalePayment::create([

                    'sale_id'               => $this->sale->id,
                    'ecom_account_id'       => $account_id,
                    'amount'                => $balance,
                ]);


                EcomAccount::find($account_id)->increment('balance', $balance ?? 0);
            }
        }
    }




    public function createSalePayment($request)
    {
        foreach ($request->ecom_account_id ?? [] as $key => $account_id) {
            if($request->payment_amount[$key] != '' && $request->payment_amount[$key] != 0){
                $this->makeTransaction($account_id, $request->payment_amount[$key]);
            }
        }
    }






    /*
     |--------------------------------------------------------------------------
     | UPDATE TOTAL QUANTITY METHOD
     |--------------------------------------------------------------------------
    */
    public function updateTotalQuantity()
    {
        $this->sale->update([
            'total_quantity'    => array_sum(array_column($this->sale->saleDetails->toArray(), 'quantity')),
        ]);
    }






    /*
     |--------------------------------------------------------------------------
     | CUSTOMER CURRENT BALANCE UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function customerCurrentbalanceUpdate($customer_id, $sale)
    {
        $customer = Customer::find($customer_id);

        $current_balance = $customer->current_balance - ($sale->payable_amount - ($sale->paid_amount - $sale->change_amount));

        $customer->update([
            'current_balance' => $current_balance,
        ]);
    }



    
    /*
     |--------------------------------------------------------------------------
     | MAKE TRANSACTION
     |--------------------------------------------------------------------------
    */
    public function makeTransaction1()
    {
        $cash_account       = $this->transactionService->getCashAccount();    // credit
        $sale_account       = $this->transactionService->getSaleAccount();    // debit
        $customer_account   = optional($this->sale->customer)->account;       // debit

        $sale               = $this->sale->refresh();
        $invoice_no         = $sale->invoice_no;
        $date               = $sale->date;


        $description        = 'Sale to ' . (optional($sale->customer)->name ?? 'Mr. Customer');


        $this->transactionService->storeTransaction($sale->company_id, $sale,    $invoice_no,    $sale_account,      0, $sale->payable_amount,  $date, 'credit', 'Sale', $description);   //  Payable Amount

        $this->transactionService->storeTransaction($sale->company_id, $sale,    $invoice_no,    $cash_account,      $sale->paid_amount, 0,  $date, 'debit', 'Payment', $description);    //  Paid Amount

        $this->transactionService->storeTransaction($sale->company_id, $sale,    $invoice_no,    $customer_account,  $sale->payable_amount, $sale->paid_amount,    $date, 'debit', 'Customer Due', $description);    //  Due Amount
    }


      public function makeTransaction($myaccount, $amount)
    {

        $myaccount          = Account::find($myaccount);
        $sale_account       = $this->transactionService->getSaleAccount();    // debit
        $customer_account   = optional($this->sale->customer)->account;       // debit

        $sale               = $this->sale->refresh();
        $invoice_no         = $sale->invoice_no;
        $date               = $sale->date;


        $description        = 'Sale to ' . (optional($sale->customer)->name ?? 'Mr. Customer');


        $this->transactionService->storeTransaction($sale->company_id, $sale,    $invoice_no,    $sale_account,      0, $sale->payable_amount,  $date, 'credit', 'Sale', $description);   //  Payable Amount

        $this->transactionService->storeTransaction($sale->company_id, $sale,    $invoice_no,    $myaccount,      $amount, 0,  $date, 'debit', 'Payment', $description);    //  Paid Amount

        $this->transactionService->storeTransaction($sale->company_id, $sale,    $invoice_no,    $customer_account,  $sale->payable_amount, $sale->paid_amount,    $date, 'debit', 'Customer Due', $description);    //  Due Amount

    }

}
