<?php

namespace Module\Inventory\Services;

use Illuminate\Http\Request;
use Module\Product\Models\Stock;
use Illuminate\Support\Facades\DB;
use Module\Inventory\Models\Order;
use App\Services\NextInvoiceNoService;
use Module\Inventory\Models\OrderDetail;
use Module\Inventory\Models\OrderReturn;
use Module\Inventory\Models\ReturnReason;
use Module\Product\Services\StockService;
use Module\Inventory\Models\OrderReturnDetail;
use Module\Inventory\Services\ProductDamageService;
use Module\Account\Services\AccountTransactionService;

class OrderReturnService
{
    public $orderReturn;
    public $orderReturnDetail;
    public $stockService;
    public $nextInvoiceNumberService;
    public $transactionService;
    public $customerWalletService;
    public $customerPointService;





    /*
     |--------------------------------------------------------------------------
     | CONSTRUCT METHOD
     |--------------------------------------------------------------------------
    */
    public function __construct()
    {
        $this->stockService                     = new StockService;
        $this->nextInvoiceNumberService         = new NextInvoiceNoService;
        $this->transactionService               = new AccountTransactionService;
        $this->customerWalletService            = new CustomerWalletService;
        $this->customerPointService             = new CustomerPointService;
    }





    /*
     |--------------------------------------------------------------------------
     | STORE ORDER RETURN METHOD
     |--------------------------------------------------------------------------
    */
    public function storeOrderReturn($request)
    {
        DB::transaction(function () use ($request) {
            
            $order = Order::where('id', $request->order_id)->first();

            $this->orderReturn      = OrderReturn::create([
                'company_id'        => $order->company_id ?? 1,
                'warehouse_id'      => $order->warehouse_id,
                'order_id'          => $order->id,
                'customer_id'       => $order->customer_id,
                'return_reason_id'  => $request->return_reason_id,
                'invoice_no'        => $this->nextInvoiceNumberService->getOrderReturnInvoiceNo($order->company_id ?? optional(auth()->user())->company_id, $order->warehouse_id),
                'date'              => date('Y-m-d'),
                'note'              => $request->note,
            ]);

            $this->storeOrderReturnDetails($request);

            $this->updateOrderReturnAllTotal($this->orderReturn);

            $this->nextInvoiceNumberService->setNextInvoiceNo($order->company_id ?? optional(auth()->user())->company_id, $order->warehouse_id, 'Order Return', date('Y'));
        });
    }





    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function storeOrderReturnDetails($request)
    {
        foreach($request->order_detail_id as $key => $order_detail_id) {

            $orderDetail = OrderDetail::query()->where('id', $order_detail_id)->first();

            $this->orderReturnDetail    = OrderReturnDetail::create([
                'order_return_id'       => $this->orderReturn->id,
                'order_detail_id'       => $orderDetail->id,
                'product_id'            => $orderDetail->product_id,
                'product_variation_id'  => $orderDetail->product_variation_id,
                'measurement_title'     => $orderDetail->measurement_title,
                'measurement_sku'       => $orderDetail->measurement_sku,
                'measurement_value'     => $orderDetail->measurement_value,
                'purchase_price'        => $orderDetail->purchase_price,
                'sale_price'            => $orderDetail->sale_price,
                'quantity'              => $orderDetail->quantity,
                'vat_percent'           => $orderDetail->vat_percent,
                'vat_amount'            => $orderDetail->vat_amount,
                'discount_percent'      => $orderDetail->discount_percent,
                'discount_amount'       => $orderDetail->discount_amount,
                'weight'                => $orderDetail->weight,
                'return_type'           => $request->condition[$key],
            ]);

            $orderDetail->update([ 'exist_in_return' => 1 ]);
        }
    }





    /*
     |--------------------------------------------------------------------------
     | UPDATE ORDER RETURN ALL TOTAL METHOD
     |--------------------------------------------------------------------------
    */
    public function updateOrderReturnAllTotal($orderReturn)
    {
        $orderReturn = $orderReturn->refresh();

        $this->orderReturn->update([
            'total_quantity'    => array_sum(array_column($orderReturn->orderReturnDetails->toArray(), 'quantity')),
            'total_weight'      => array_sum(array_column($orderReturn->orderReturnDetails->toArray(), 'weight')),
            'total_amount'      => array_sum(array_column($orderReturn->orderReturnDetails->toArray(), 'total_amount')),
        ]);
    }





    /*
     |--------------------------------------------------------------------------
     | STORE GOOD PRODUCT IN STOCK METHOD
     |--------------------------------------------------------------------------
    */
    public function storeGoodProductInStock($request, $orderReturn)
    {
        foreach($request->order_detail_id as $key => $order_detail_id) {

            $orderReturnDetail      = OrderReturnDetail::query()->where('id', $request->order_return_detail_id[$key])->first();
            $orderDetail            = OrderDetail::query()->where('id', $order_detail_id)->first();
            $stock                  = Stock::where(['stockable_type' => 'Order', 'stockable_id' => $orderDetail->id])->first();

            if ($request->condition[$key] == "Good") {

                $this->stockService->storeStock($orderReturnDetail, $stock->company_id, $stock->supplier_id, $stock->warehouse_id, $stock->product_id, $stock->product_variation_id, $stock->lot ?? 'N/A', $orderReturn->invoice_no, date('Y-m-d'), 'In', $stock->purchase_price, $stock->sale_price, $stock->quantity, $stock->expire_date);
                
                $this->stockService->updateOrCreateStockSummary($stock->company_id, $stock->supplier_id, $stock->warehouse_id, $stock->product_id, $stock->product_variation_id, $stock->lot ?? 'N/A', $stock->expire_date, $stock->quantity, 0, $stock->purchase_price * $stock->quantity, 0);
            }
        }
    }
    




    /*
     |--------------------------------------------------------------------------
     | MAKE TRANSACTION
     |--------------------------------------------------------------------------
    */
    public function makeTransaction($orderReturn)
    {
        $cash_account           = $this->transactionService->getCashAccount();          // debit
        $sale_return_account    = $this->transactionService->getSaleReturnAccount();      // credit
        $customer_account       = optional($orderReturn->customer)->account;         // credit

        $orderReturn            = $orderReturn->refresh();
        $invoice_no             = $orderReturn->invoice_no;
        $date                   = $orderReturn->date;

        $description            = 'Order Return from ' . (optional($orderReturn->customer)->name ?? 'Mr. Customer');

        $this->transactionService->storeTransaction($orderReturn->company_id, $orderReturn,    $invoice_no,    $sale_return_account,      $orderReturn->total_amount, 0,  $date, 'debit',     'Order Return', $description);   //  Payable Amount

        $this->transactionService->storeTransaction($orderReturn->company_id, $orderReturn,    $invoice_no,    $cash_account,             0, $orderReturn->total_amount,   $date, 'credit',    'Acc. Order Return Pay', $description);    //  Paid Amount

        $this->transactionService->storeTransaction($orderReturn->company_id, $orderReturn,    $invoice_no,    $customer_account,         $orderReturn->total_amount, $orderReturn->total_amount,   $date, 'credit',    'Customer Order Return', $description);    //  Due Amount
    }





    /*
     |--------------------------------------------------------------------------
     | DELETE ORDER RETURN METHOD
     |--------------------------------------------------------------------------
    */
    public function deleteOrderReturn($order_return_id)
    {
        DB::transaction(function () use ($order_return_id) {

            $orderReturn = OrderReturn::where('id', $order_return_id)->with('orderReturnDetails.stocks', 'productDamage.productDamageDetails')->first();

            foreach($orderReturn->orderReturnDetails as $orderReturnDetail) {

                OrderDetail::where('id', $orderReturnDetail->order_detail_id)->update(['exist_in_return' => 0]);

                if ($orderReturnDetail->stocks != '[]') {

                    $stock = $orderReturnDetail->stocks[0];

                    $this->stockService->deleteStocks($orderReturnDetail);

                    $this->stockService->updateStockSummaries($stock->company_id, null, $stock->warehouse_id, $stock->product_id, $stock->product_variation_id, $stock->lot, $stock->expire_date, $stock->quantity, 0, $stock->quantity * $stock->purchase_price, 0);
                }

                $orderReturnDetail->delete();
            }


            if($orderReturn->productDamage != null) {
                foreach($orderReturn->productDamage->productDamageDetails as $productDamageDetail) {
                    $productDamageDetail->delete();
                }

                $orderReturn->productDamage->transactions()->delete();

                $orderReturn->productDamage->delete();
            }

            if (count($orderReturn->transactions) > 0) {
                $orderReturn->customerWalletTransactions()->delete();
                $orderReturn->customerPointTransactions()->delete();

                $this->customerWalletService->updateCustomerWallet($orderReturn->customer_id, -abs($orderReturn->total_amount));
                $this->customerPointService->updateCustomerPoint($orderReturn->customer_id, getPoint($orderReturn->total_amount));
            }

            $orderReturn->transactions()->delete();

            $orderReturn->delete();
        });
    }
}
