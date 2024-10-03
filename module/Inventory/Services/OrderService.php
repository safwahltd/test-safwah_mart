<?php

namespace Module\Inventory\Services;

use App\Models\EcomSetting;
use Illuminate\Support\Facades\DB;
use Module\Account\Models\Account;
use Module\Inventory\Models\Order;
use App\Services\NextInvoiceNoService;
use Module\Account\Models\Customer;
use Module\Product\Models\StockSummary;
use Module\Account\Services\AccountTransactionService;
use Module\Product\Services\StockService;

class OrderService
{
    public $customer;
    public $nextInvoiceNoService;
    private $transactionService;
    public $stockService;
	public $orderDetail;
	public $order;
	public $customerPointService;
	public $customerWalletService;




  	/*
     |--------------------------------------------------------------------------
     | CONSTRUCT METHOD
     |--------------------------------------------------------------------------
    */
    public function __construct()
    {
        $this->nextInvoiceNoService     = new NextInvoiceNoService;
		$this->transactionService       = new AccountTransactionService;
		$this->stockService          	= new StockService;
        $this->customerPointService     = new CustomerPointService;
        $this->customerWalletService    = new CustomerWalletService;
    }





    /*
     |--------------------------------------------------------------------------
     | STORE ORDER METHOD
     |--------------------------------------------------------------------------
    */
    public function storeOrder($request, $customer_id)
    {

		$payable_amount = ($request->subtotal + $request->total_vat_amount + $request->shipping_cost + $request->extra_shipping_cost_amount) - ($request->shipping_cost_discount_amount + $request->total_discount_amount + $request->coupon_discount_amount + $request->point_amount + $request->wallet_amount);

		if ($payable_amount == 0) {
			$payment_status = 'Complete';
		} else if ($request->point_amount > 0 || $request->wallet_amount > 0) {
			$payment_status = 'Partial';
		} else {
			$payment_status = 'Due';
		}


		DB::transaction(function () use ($request, $customer_id, $payment_status) {


            //-------- CALCULATING COD CHARGE START ---------//

            $totalCodCharge     = $this->calculateCodCharge($request);

            //-------- CALCULATING COD CHARGE END ---------//

            $pageSections   = EcomSetting::where('id', 37)->first();
            $isSaleShow     = $pageSections != '' ? optional($pageSections)->value : '';

			$order = Order::create([
				'company_id'                    => 1,
				'warehouse_id'                  => $request->warehouse_id ?? null,
				'customer_id'                   => $customer_id,
				'time_slot_id'                  => $request->time_slot_id ?? null,
				'coupon_id'                     => $request->coupon_id ?? null,
				'date'                          => date('Y-m-d'),
				'delivery_date'                 => $request->delivery_date,
				'order_no'                      => $this->nextInvoiceNoService->getOrderInvoiceNo(1, null),
				'order_source'                  => $request->order_source ?? 'Website',
				'payment_type'                  => $request->payment_type ?? 'COD',
				'payment_method'                => $request->payment_method ?? '',
				'payment_tnx_no'                => $request->payment_tnx_no ?? '',
				'payment_status'                => $request->payment_status ?? $payment_status,
				'total_quantity'                => $request->total_quantity ?? 0,
				'subtotal'                      => $request->subtotal ?? 0,
				'total_vat_amount'              => $request->total_vat_amount ?? 0,
				'shipping_cost'                 => $request->shipping_cost ?? 0,
				'total_cod_charge'              => $totalCodCharge,
				'total_discount_amount'         => $request->total_discount_amount ?? 0,
				'coupon_discount_amount'        => $request->coupon_discount_amount ?? 0,
				'current_status'                => 1,
				'total_weight'                  => $request->total_weight ?? 0,
				'extra_shipping_cost_id'        => $request->extra_shipping_cost_id ?? null,
				'extra_shipping_cost_amount'    => $request->extra_shipping_cost_amount ?? 0,
				'shipping_cost_discount_id'     => $request->shipping_cost_discount_id ?? null,
				'shipping_cost_discount_amount' => $request->shipping_cost_discount_amount ?? 0,
				'point_used'                    => $request->point_used ?? 0,
				'point_amount'                  => $request->point_amount ?? 0,
				'wallet_amount'                 => $request->wallet_amount ?? 0,
                  // 'sold_by'                       => $isSaleShow == 'on' ? $request->sold_by : '',
                'created_by' => $isSaleShow == 'on' ? $request->sold_by : 1,
			]);

			$this->storeOrderCustomerInfo($request, $order);
			$this->storeOrderDetails($request, $order);
			$this->storeOrderStatus($order);

			if ($request->point_used > 0) {
				$this->customerPointService->storeCustomerPointTransactionByPoint($order, $customer_id, 'Out', $request->point_used, null);
			}

			if ($request->wallet_amount > 0) {
				$this->customerWalletService->storeCustomerWalletTransaction($order, $customer_id, 'Out', $request->wallet_amount, null);
			}

			$this->nextInvoiceNoService->setNextInvoiceNo(1, null, 'Order', date('Y'));

			if ($request->coupon_id != null) {
				$order->couponUse()->create([
					'coupon_id'				=> $request->coupon_id,
					'customer_id'			=> $customer_id,
				]);
			}
		});

    }



    /*
     |--------------------------------------------------------------------------
     | CALCULATE COD CHARGE METHOD
     |--------------------------------------------------------------------------
    */
    public function calculateCodCharge($request){

        $totalCodCharge = 0;

        if ( isset($request->payment_type) && $request->payment_type == 'COD') {

            $ecomSettings        = EcomSetting::whereIn('id',[38,39,40,41])->select('id','title','value')->get();

            if ($request->district_id == 47) { // IS Inside DHAKA

                if ($ecomSettings[0]->value == 'on') {

                    $codPercentage   = $ecomSettings[1]->value;
                    $totalCodAmount  = $request->subtotal + $request->shipping_cost - ($request->total_discount_amount ?? 0) - ($request->total_special_discount_amount ?? 0);
                    $totalCodCharge  = ($totalCodAmount * $codPercentage) / 100;

                }
            } else { // IS Ouside DHAKA
                if ($ecomSettings[2]->value == 'on') {

                    $codPercentage   = $ecomSettings[3]->value;
                    $totalCodAmount  = $request->subtotal + $request->shipping_cost - ($request->total_discount_amount ?? 0) - ($request->total_special_discount_amount ?? 0);
                    $totalCodCharge  = ($totalCodAmount * $codPercentage) / 100;
                }
            }
        }

        return $totalCodCharge;
    }



    /*
     |--------------------------------------------------------------------------
     | CALCULATE COD CHARGE METHOD
     |--------------------------------------------------------------------------
    */
    public function calculateCodChargePercent($request)
    {

        $codPercentage = 0;

        if ( isset($request->payment_type) && $request->payment_type == 'COD') {

            $ecomSettings        = EcomSetting::whereIn('id',[38,39,40,41])->select('id','title','value')->get();

            if ($request->district_id == 47) { // IS Inside DHAKA

                if ($ecomSettings[0]->value == 'on') {

                    $codPercentage   = $ecomSettings[1]->value;

                }
            } else{ // IS Ouside DHAKA
                if ($ecomSettings[2]->value == 'on') {

                    $codPercentage   = $ecomSettings[3]->value;
                }
            }

        }

        return $codPercentage;

    }




    /*
     |--------------------------------------------------------------------------
     | STORE ORDER METHOD
     |--------------------------------------------------------------------------
    */
    public function storePosOrder($request, $customer_id)
    {

		DB::transaction(function () use ($request, $customer_id) {


            $totalCodCharge     = $this->calculateCodCharge($request);
            $codChargePercent     = $this->calculateCodChargePercent($request);

            $pageSections   = EcomSetting::where('id', 37)->first();
            $isSaleShow     = $pageSections != '' ? optional($pageSections)->value : '';

			$this->order = Order::create([
				'company_id'             		=> 1,
				'warehouse_id'             		=> $request->warehouse_id ?? null,
				'customer_id'             		=> $customer_id,
				'time_slot_id'             		=> $request->time_slot_id ?? null,
				'coupon_id'               		=> $request->coupon_id ?? null,
				'date'                    		=> date('Y-m-d'),
				'delivery_date'         		=> $request->delivery_date,
				'order_no'                		=> $this->nextInvoiceNoService->getOrderInvoiceNo(1, null),
				'order_source'          		=> $request->order_source ?? 'Website',
				'payment_type'            		=> $request->payment_type ?? 'COD',
				'payment_method'            	=> $request->payment_method ?? '',
				'payment_tnx_no'            	=> $request->payment_tnx_no ?? '',
				'payment_status'            	=> $request->payment_status ?? 'Due',
				'total_quantity'          		=> $request->total_quantity ?? 0,
				'subtotal'                		=> $request->subtotal ?? 0,
				'total_vat_amount'        		=> $request->total_vat_amount ?? 0,
				'shipping_cost'           		=> $request->shipping_cost ?? 0,
                'total_cod_charge'      		=> $totalCodCharge,
                'cod_charge_percent'      		=> $codChargePercent,
				'total_discount_amount'   		=> $request->total_discount_amount ?? 0,
				'special_discount'              => $request->total_special_discount_amount ?? 0,
				'coupon_discount_amount'  		=> $request->coupon_discount_amount ?? 0,
				'current_status'          		=> 2,
				'total_weight'          		=> $request->total_weight ?? 0,
				'extra_shipping_cost_id'  		=> $request->extra_shipping_cost_id ?? null,
				'extra_shipping_cost_amount'	=> $request->extra_shipping_cost_amount ?? 0,
				'shipping_cost_discount_id'    	=> $request->shipping_cost_discount_id ?? null,
				'shipping_cost_discount_amount'	=> $request->shipping_cost_discount_amount ?? 0,
				'paid_amount'                   => $request->paid_amount ?? 0,
				'due_amount'                    => $request->due_amount ?? 0,
				'change_amount'                 => $request->change_amount ?? 0,
				// 'sold_by'                       => $isSaleShow == 'on' ? $request->sold_by : '',
                'created_by'                    => $isSaleShow == 'on' ? $request->sold_by : 1,
			]);

			$this->storeOrderCustomerInfo($request, $this->order);
			$this->storePosOrderDetails($request, $this->order);
			$this->storeOrderStatus($this->order);

			$this->nextInvoiceNoService->setNextInvoiceNo(1, null, 'Order', date('Y'));

			if ($request->coupon_id != null) {
				$this->order->couponUse()->create([
					'coupon_id'				=> $request->coupon_id,
					'customer_id'			=> $customer_id,
				]);
			}
		});

		return $this->order;
    }


    /*
     |--------------------------------------------------------------------------
     | STORE ORDER CUSTOMER INFOS METHOD
     |--------------------------------------------------------------------------
    */
    public function storeOrderCustomerInfo($request, $order)
    {
		if($request->order_source == 'POS'){
			$customer = Customer::find($request->customer_id);
			$a = $order->orderCustomerInfo()->create([
				'name'                      => $customer->name,
				'phone'                     => $customer->mobile,
				'email'                     => $customer->email,
				'country'                   => $customer->country,
				'address'                   => $customer->address,
				'area_id'                   => $customer->area_id,
				'district_id'               => $customer->district_id,
				'zip_code'                  => $customer->zip_code,
				'order_note'                => $request->order_note,
				'ship_to_different_address' => $request->ship_to_different_address ?? 'No',
				'receiver_name'             => $request->receiver_name,
				'receiver_phone'            => $request->receiver_phone,
				'receiver_email'            => $request->receiver_email,
				'receiver_country'          => $request->receiver_country,
				'receiver_address'          => $request->receiver_address,
				'receiver_area_id'          => $request->receiver_area_id,
				'receiver_district_id'      => $request->receiver_district_id,
				'receiver_zip_code'         => $request->receiver_zip_code,
				'receiver_order_note'       => $request->receiver_order_note,
			]);
		}else{
			$a = $order->orderCustomerInfo()->create([
				'name'                      => $request->name,
				'phone'                     => $request->phone,
				'email'                     => $request->email,
				'country'                   => $request->country,
				'address'                   => $request->address,
				'area_id'                   => $request->area_id,
				'district_id'               => $request->district_id,
				'zip_code'                  => $request->zip_code,
				'order_note'                => $request->order_note,
				'ship_to_different_address' => $request->ship_to_different_address ?? 'No',
				'receiver_name'             => $request->receiver_name,
				'receiver_phone'            => $request->receiver_phone,
				'receiver_email'            => $request->receiver_email,
				'receiver_country'          => $request->receiver_country,
				'receiver_address'          => $request->receiver_address,
				'receiver_area_id'          => $request->receiver_area_id,
				'receiver_district_id'      => $request->receiver_district_id,
				'receiver_zip_code'         => $request->receiver_zip_code,
				'receiver_order_note'       => $request->receiver_order_note,
			]);
		}

    }





    /*
     |--------------------------------------------------------------------------
     | STORE ORDER DETAILS METHOD
     |--------------------------------------------------------------------------
    */
    public function storeOrderDetails($request, $order)
    {
		foreach($request->product_id as $key => $value)
		{
			$order->OrderDetails()->create([

				'product_id'           => $request->product_id[$key],
				'product_variation_id' => $request->product_variation_id[$key] != 0 ? $request->product_variation_id[$key] : null,
				'measurement_title'    => $request->measurement_title[$key],
				'measurement_sku'      => $request->measurement_sku[$key],
				'measurement_value'    => $request->measurement_value[$key] ?? 0,
				'purchase_price'       => $request->purchase_price[$key] ?? 0,
				'sale_price'           => $request->sale_price[$key] ?? 0,
				'quantity'             => $request->quantity[$key] ?? 0,
				'vat_percent'          => $request->vat_percent[$key] ?? 0,
				'vat_amount'           => $request->vat_amount[$key] ?? 0,
				'discount_percent'     => $request->discount_percent[$key] ?? 0,
				'discount_amount'      => $request->discount_amount[$key] ?? 0,
				'weight'               => $request->weight[$key] ?? 0,
			]);
		}
    }




    /*
     |--------------------------------------------------------------------------
     | STORE ORDER DETAILS METHOD
     |--------------------------------------------------------------------------
    */
    public function storePosOrderDetails($request, $order)
    {
		foreach($request->product_id as $key => $value)
		{
			$this->orderDetail = $order->OrderDetails()->create([

				'product_id'           => $request->product_id[$key],
				'product_variation_id' => $request->product_variation_id[$key] != 0 ? $request->product_variation_id[$key] : null,
				'measurement_title'    => $request->measurement_title[$key],
				'measurement_sku'      => $request->measurement_sku[$key],
				'measurement_value'    => $request->measurement_value[$key] ?? 0,
				'purchase_price'       => $request->purchase_price[$key] ?? 0,
				'sale_price'           => $request->sale_price[$key] ?? 0,
				'quantity'             => $request->quantity[$key] ?? 0,
				'vat_percent'          => $request->vat_percent[$key] ?? 0,
				'vat_amount'           => $request->vat_amount[$key] ?? 0,
				'discount_percent'     => $request->discount_percent[$key] ?? 0,
				'discount_amount'      => $request->discount_amount[$key] ?? 0,
				'weight'               => $request->weight[$key] ?? 0,
			]);

			$calculateQuantity = $this->orderDetail->measurement_value > 0 ? $this->orderDetail->quantity * $this->orderDetail->measurement_value : $this->orderDetail->quantity;

            if (isset($request->lot[$key]) && $request->lot[$key] == null) {

                $lotQtyArr = [];

                $getLotNo = $this->getLotNo($request, $this->order, $this->orderDetail);

                $getLotNumbers = $this->getLotNumbers($request, $this->order, $this->orderDetail);

                if ($getLotNo != null) {

                    $this->stockService->storeStock($this->orderDetail, $this->order->company_id ?? 1, null, $this->order->warehouse_id, $this->orderDetail->product_id, $this->orderDetail->product_variation_id, $getLotNo->lot, $this->order->invoice_no, $this->order->date, 'Out', $this->orderDetail->purchase_price, $this->orderDetail->sale_price, $calculateQuantity, null);

                    $this->stockService->updateOrCreateStockSummary($this->order->company_id ?? 1, null, $this->order->warehouse_id, $this->orderDetail->product_id, $this->orderDetail->product_variation_id, $getLotNo->lot, null, 0, $calculateQuantity, 0, $this->orderDetail->purchase_price * $calculateQuantity);

                } else {

                    foreach($getLotNumbers as $key => $lotNumber) {

                        $balanceQty = $this->checkBalanceQty($request, $lotNumber->lot, $this->order, $this->orderDetail);

                        if ($balanceQty > 0) {

                            $leftQty = $calculateQuantity - array_sum($lotQtyArr);

                            $quantity = $lotNumber->balance_qty;

                            if ($leftQty <= $lotNumber->balance_qty) {
                                $quantity = $leftQty;
                            }

                            if ($calculateQuantity > array_sum($lotQtyArr)) {

                                $this->stockService->storeStock($this->orderDetail, $this->order->company_id ?? 1, null, $this->order->warehouse_id, $this->orderDetail->product_id, $this->orderDetail->product_variation_id, $lotNumber->lot, $this->order->invoice_no, $this->order->date, 'Out', $this->orderDetail->purchase_price, $this->orderDetail->sale_price, $quantity, null);

                                $this->stockService->updateOrCreateStockSummary($this->order->company_id ?? 1, null, $this->order->warehouse_id, $this->orderDetail->product_id, $this->orderDetail->product_variation_id, $lotNumber->lot, null, 0, $quantity, 0, $this->orderDetail->purchase_price * $quantity);
                            }

                            array_push($lotQtyArr, $quantity);
                        }
                    }
                }

            } else {

                $lot = isset($request->lot[$key]) ? $request->lot[$key] : null;
                $this->stockService->storeStock($this->orderDetail, $this->order->company_id, null, $this->order->warehouse_id, $value, $request->product_variation_id[$key], $lot, $this->order->invoice_no, $this->order->date, 'Out', $request->purchase_price[$key], $request->sale_price[$key], $calculateQuantity, null);

                $this->stockService->updateOrCreateStockSummary($this->order->company_id, null, $this->order->warehouse_id, $value, $request->product_variation_id[$key], $lot, null, 0, $calculateQuantity, 0, $request->purchase_price[$key] * $calculateQuantity);
            }
		}
    }







	public function getLotNo($request, $order, $saleDetail)
    {
        return StockSummary::query()
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
                    'company_id'           => $order->company_id ?? 1,
                    'warehouse_id'         => $request->warehouse_id,
                    'product_id'           => $saleDetail->product_id,
                    'product_variation_id' => $saleDetail->product_variation_id,
                ])
                ->orderBy('id', 'ASC')
                ->get();
    }

	/*
     |--------------------------------------------------------------------------
     | STORE ORDER STAUTS HISTORY
     |--------------------------------------------------------------------------
    */
    public function storeOrderStatus($order)
    {
		$order->order_status()->create([
			'status_id'    => 1,
		]);
    }




    /*
     |--------------------------------------------------------------------------
     | STORE ORDER METHOD
     |--------------------------------------------------------------------------
    */
    public function updateOrder($request, $id)
    {
		$order = Order::find($id);

        $order->update([
			'time_slot_id'          => $request->time_slot_id,
			'delivery_date'         => $request->delivery_date ?? "",
			'shipping_cost'         => $request->shipping_cost,
			'subtotal'              => $request->subtotal,
			'total_vat_amount'      => $request->total_vat_amount,
			'total_discount_amount' => $request->total_discount_amount,
		]);

		$this->updateOrderCustomerInfo($request, $order);
		$this->updateOrderDetails($request, $order);
    }


  /*
     |--------------------------------------------------------------------------
     | STORE ORDER CUSTOMER INFOS METHOD
     |--------------------------------------------------------------------------
    */
    public function updateOrderCustomerInfo($request, $order)
    {
		if($request->receiver_district_id){
			$order->orderCustomerInfo()->update([
				'receiver_address'     => $request->receiver_address,
				'receiver_area_id'     => $request->receiver_area_id,
				'receiver_district_id' => $request->receiver_district_id,
				'order_note'           => $request->order_note ?? '',
			]);
		}else{
			$order->orderCustomerInfo()->update([
				'address'     => $request->address,
				'area_id'     => $request->area_id,
				'district_id' => $request->district_id,
				'order_note'  => $request->order_note ?? '',
			]);
		}

    }



	/*
     |--------------------------------------------------------------------------
     | UPDATE ORDER DETAILS METHOD
     |--------------------------------------------------------------------------
    */
    public function updateOrderDetails($request, $order)
    {
		$order->OrderDetails()->delete();

		foreach($request->product_id as $key => $value) {

			$order->OrderDetails()->create([

				'product_id'             	=> $request->product_id[$key],
				'product_variation_id'   	=> $request->product_variation_id[$key] != 0 ? $request->product_variation_id[$key] : null,
				'measurement_title'   		=> $request->measurement_title[$key],
				'measurement_sku'   		=> $request->measurement_sku[$key],
				'measurement_value'   		=> $request->measurement_value[$key] ?? 0,
				'purchase_price'         	=> $request->purchase_price[$key] ?? 0,
				'sale_price'             	=> $request->sale_price[$key] ?? 0,
				'quantity'               	=> $request->quantity[$key] ?? 0,
				'vat_percent'            	=> $request->vat_percent[$key] ?? 0,
				'vat_amount'             	=> $request->vat_amount[$key] ?? 0,
				'discount_percent'          => $request->discount_percent[$key],
				'discount_amount'           => $request->discount_amount[$key] / $request->quantity[$key],
				'weight'        		 	=> $request->weight[$key] ?? 0,
			]);
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


	public function makeTransaction($myaccount, $amount)
    {

        $myaccount          = Account::find($myaccount);
        $sale_account       = $this->transactionService->getSaleAccount();    // debit
        $customer_account   = optional($this->order->customer)->account;       // debit

        $sale               = $this->order->refresh();
        $invoice_no         = $sale->order_no;
        $date               = $sale->date;


        $description        = 'Sale to ' . (optional($sale->customer)->name ?? 'Mr. Customer');


        $this->transactionService->storeTransaction($sale->company_id, $sale,    $invoice_no,    $sale_account,      0, $sale->grand_total,  $date, 'credit', 'Sale', $description);   //  Payable Amount

        $this->transactionService->storeTransaction($sale->company_id, $sale,    $invoice_no,    $myaccount,      $amount, 0,  $date, 'debit', 'Payment', $description);    //  Paid Amount

        $this->transactionService->storeTransaction($sale->company_id, $sale,    $invoice_no,    $customer_account,  $sale->grand_total, $sale->paid_amount,    $date, 'debit', 'Customer Due', $description);    //  Due Amount

    }

}
