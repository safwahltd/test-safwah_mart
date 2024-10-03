<?php

namespace Module\Inventory\Controllers;


use App\Models\Area;
use App\Models\User;
use App\Models\Company;
use App\Models\District;
use Illuminate\Http\Request;
use App\Models\SystemSetting;
use Module\Product\Models\Stock;
use Illuminate\Support\Facades\DB;
use Module\Account\Models\Account;
use Module\Inventory\Models\Order;
use Module\Product\Models\Product;
use Module\Account\Models\Customer;
use Module\Inventory\Models\Status;
use Module\Product\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\EcomSetting;
use Module\Inventory\Models\TimeSlot;
use Module\Inventory\Models\Warehouse;
use Module\Product\Models\StockSummary;
use Module\Inventory\Models\DeliveryMan;
use Module\Inventory\Models\OrderStatus;
use Module\Product\Services\StockService;
use Module\Inventory\Services\SaleService;
use Module\Inventory\Services\OrderService;
use Module\Product\Models\ProductVariation;
use Module\Inventory\Services\TransactionService;
use Module\Account\Services\AccountTransactionService;
use Module\Inventory\Models\CustomerType;
use Module\Inventory\Services\CustomerPointService;
use Module\Inventory\Services\CustomerWalletService;

class OrderController extends Controller
{
    public $nextInvoiceNoService;
    public $orderService;
    public $stockService;
    public $saleService;
    public $customer;
    public $transactionService;
    public $accTransactionService;

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
        $this->orderService             = new OrderService;
        $this->saleService              = new SaleService;
        $this->transactionService       = new TransactionService;
        $this->stockService             = new StockService;
        $this->accTransactionService    = new AccountTransactionService;
        $this->customerPointService     = new CustomerPointService;
        $this->customerWalletService    = new CustomerWalletService;
    }



    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {

        if (auth()->user()->type == 'Delivery Man') {
            $request->delivery_man_id = optional(auth()->user()->deliveryMan)->id;
        }

        $data['orders']         = Order::query()
            ->when(isset($request->delivery_man_id), function ($q) use ($request) {
                $q->where('delivery_man_id', $request->delivery_man_id);
            })
            ->where('order_source', '!=', 'POS')
            ->searchByField('current_status')
            ->searchByField('order_no')
            ->searchByField('customer_id')
            ->with('customer:id,name,mobile')
            ->with('warehouse:id,name')
            ->with('currentStatus:id,name')
            ->with('timeSlot:id,starting_time,ending_time')
            ->when($request->filled('date_type'), function ($q) use ($request) {
                $q->dateFilter($request->date_type);
            })
            ->when(!$request->filled('date_type'), function ($q) use ($request) {
                $q->when(request()->filled('from') || request()->filled('from_date'), function ($qr) use ($request) {
                    $qr->where(function ($q) {
                        $q->where('date', '>=', (request('from') ?? request('from_date')))
                            ->orWhere('delivery_date', '>=', (request('from') ?? request('from_date')));
                    });
                })
                    ->when(request()->filled('to') || request()->filled('to_date'), function ($qr) use ($request) {
                        $qr->where(function ($q) {
                            $q->where('date', '<=', (request('to') ?? request('to_date')))
                                ->orWhere('delivery_date', '<=', (request('to') ?? request('to_date')));
                        });
                    });
            })

            ->when($request->filled('district_id'), function ($query) use ($request) {
                $query->whereHas('orderCustomerInfo', function ($q) use ($request) {
                    $q->where(function ($q1) use ($request) {
                        $q1->where('receiver_district_id', $request->district_id)
                            ->orWhere('district_id', $request->district_id);
                    });
                });
            })
            ->when($request->filled('area_id'), function ($query) use ($request) {
                $query->whereHas('orderCustomerInfo', function ($q) use ($request) {
                    $q->where(function ($q1) use ($request) {
                        $q1->where('receiver_area_id', $request->area_id)
                            ->orWhere('area_id', $request->area_id);
                    });
                });
            })
            ->orderBy('id', 'DESC')
            ->paginate(30);

        $data['customers']      = Customer::get(['id', 'name', 'mobile']);
        $data['statuses']       = Status::pluck('name', 'id');
        $data['districts']      = District::orderBy('name', 'ASC')->pluck('name', 'id');
        $data['areas']          = Area::orderBy('name', 'ASC')->pluck('name', 'id');
        $data['invoice1']       = optional(SystemSetting::find(5))->value;
        $data['invoice2']       = optional(SystemSetting::find(6))->value;

        return view('order/index', $data);
    }









    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $data['warehouses']      = Warehouse::with(['ecomAccounts' => function ($q) {
            $q->where('status', 1)
                ->select('id', 'warehouse_id', 'name', 'account_no', 'is_default');
        }])
            ->get(['id', 'name']);

        $data['categories']      = Category::query()
            ->where('parent_id', null)
            ->with('childCategories')
            ->get(['id', 'name']);

        $data['users']          = User::where('type', 'Admin')->get();
        $data['districts']      = District::orderBy('name', 'ASC')->get();
        $data['areas']          = Area::orderBy('name', 'ASC')->get();
        $data['time_slots']     = TimeSlot::get();
        $data['customer_types'] = CustomerType::get();

        $settings               = EcomSetting::whereIn('id', ['37', '38', '39', '40', '41', '42', '43', '44'])->get();


        // COD CHARGE
        $data['insideDhakaCharge']  = 0;
        $data['outsideDhakaCharge'] = 0;
        $data['insideDhaka']        = $settings->where('id', 38)->where('value', 'on')->first() ? 1 : 0;
        $data['outsideDhaka']       = $settings->where('id', 40)->where('value', 'on')->first() ? 1 : 0;

        if ($data['insideDhaka'] == 1) {
            $data['insideDhakaCharge'] = optional($settings->where('id', 39)->first())->value ?? 0;
        }

        if ($data['outsideDhaka'] == 1) {
            $data['outsideDhakaCharge'] = optional($settings->where('id', 41)->first())->value ?? 0;
        }

        // FREE DELIVERY CHARGE
        $data['globalFreeDeliverySetting']  = $settings->where('id', 42)->where('value', 'on')->first() ? 1 : 0;
        $data['globalMinPurchaseAmount']    = optional($settings->where('id', 43)->first())->value ?? 0;
        $data['globalFreeDeliveryAmount']   = optional($settings->where('id', 44)->first())->value ?? 0;


        // SALE BY IS ACTIVE OR NOT
        $data['isSoldByActive'] = $settings->where('id', 37)->where('value', 'on')->first() ? 1 : 0;

        return view('order-create/create', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | STORE
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        // dd($request->all());
        $order = '';

        try {
            DB::transaction(function () use ($request, $order) {
                $this->order = $this->orderService->storePosOrder($request, $request->customer_id);
                $this->orderService->createSalePayment($request);
            });
        } catch (\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        $url = route('inv.orders.show', $this->order->id) . '?copy=store&print_type=' . ($request->radio == 'pos-print' ? 'pos-print' : 'normal-print');

        return redirect($url)->withMessage('Sale has been Created Successfully.');
    }




    /*
     |--------------------------------------------------------------------------
     | UPDARE ORDERS STATUS
     |--------------------------------------------------------------------------
    */
    function updateOrderStatus($order_id, $status_id)
    {
        $order = Order::find($order_id);
        $order->current_status = $status_id;
        $order->save();

        OrderStatus::create([
            'order_id'    => $order_id,
            'status_id'    => $status_id,
        ]);
        return redirect()->back();
    }









    /*
     |--------------------------------------------------------------------------
     | PENDING ORDERS METHOD
     |--------------------------------------------------------------------------
    */
    public function pendingOrders()
    {
        $pendingOrders = Order::query()
            ->where('status', 'Pending')
            ->searchByField('order_no')
            ->SearchDateFrom('date', 'from')
            ->SearchDateTo('date', 'to')
            ->searchByField('payment_transaction_id')
            ->latest()
            ->get();

        return view('order.pending.index', compact('pendingOrders'));
    }








    /*
     |--------------------------------------------------------------------------
     | CONFIRMED ORDERS METHOD
     |--------------------------------------------------------------------------
    */
    public function confirmedOrders()
    {
        $confirmedOrders   = Order::query()
            ->where('status', 'Confirmed')
            ->searchByField('order_no')
            ->SearchDateFrom('date', 'from')
            ->SearchDateTo('date', 'to')
            ->searchByField('payment_transaction_id')
            ->latest()
            ->paginate(50);

        return view('order.confirmed.index', compact('confirmedOrders'));
    }








    /*
     |--------------------------------------------------------------------------
     | DELIVERY ON GOING ORDERS METHOD
     |--------------------------------------------------------------------------
    */
    public function deliveryOnGoingOrders()
    {
        $deliveryOnGoingOrders = Order::query()
            ->where('status', 'Delivery on going')
            ->searchByField('order_no')
            ->SearchDateFrom('date', 'from')
            ->SearchDateTo('date', 'to')
            ->searchByField('payment_transaction_id')
            ->latest()
            ->paginate(50);

        return view('order.delivery-on-going.index', compact('deliveryOnGoingOrders'));
    }




    /*
     |--------------------------------------------------------------------------
     | DELIVERED ORDERS METHOD
     |--------------------------------------------------------------------------
    */
    public function deliveredOrders()
    {
        $deliveredOrders = Order::query()
            ->where('status', 'Delivered')
            ->searchByField('order_no')
            ->SearchDateFrom('date', 'from')
            ->SearchDateTo('date', 'to')
            ->searchByField('payment_transaction_id')
            ->latest()
            ->paginate(50);

        return view('order.delivered.index', compact('deliveredOrders'));
    }




    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $data['order']          = Order::query()
            ->with('orderCustomerInfo')
            ->with(['orderDetails' => function ($q) {
                $q->with(['product' => function ($q1) {
                    $q1->with('unitMeasure:id,name')
                        ->with('category:id,name')
                        ->with('productVariations')
                        ->select('id', 'category_id', 'unit_measure_id', 'name', 'sku', 'code');
                }]);
                $q->with('productVariation:id,name');
            }])
            ->find($id);

        $data['deliveryMans']   = DeliveryMan::query()
            ->select('id', 'name')
            ->where('status', 1)
            ->orderBy('name', 'ASC')
            ->get();

        $data['warehouses']     = Warehouse::get(['id', 'name']);

        $data['statuses']       = Status::get();

        $data['districts']       = District::orderBy('name', 'ASC')->get();
        $data['areas']           = Area::orderBy('name', 'ASC')->get();
        $data['time_slots']      = TimeSlot::get();



        $settings               = EcomSetting::whereIn('id', ['37', '38', '39', '40', '41', '42', '43', '44'])->get();


        // COD CHARGE
        $data['insideDhakaCharge']  = 0;
        $data['outsideDhakaCharge'] = 0;
        $data['insideDhaka']        = $settings->where('id', 38)->where('value', 'on')->first() ? 1 : 0;
        $data['outsideDhaka']       = $settings->where('id', 40)->where('value', 'on')->first() ? 1 : 0;

        if ($data['insideDhaka'] == 1) {
            $data['insideDhakaCharge'] = optional($settings->where('id', 39)->first())->value ?? 0;
        }

        if ($data['outsideDhaka'] == 1) {
            $data['outsideDhakaCharge'] = optional($settings->where('id', 41)->first())->value ?? 0;
        }

        // FREE DELIVERY CHARGE
        $data['globalFreeDeliverySetting']  = $settings->where('id', 42)->where('value', 'on')->first() ? 1 : 0;
        $data['globalMinPurchaseAmount']    = optional($settings->where('id', 43)->first())->value ?? 0;
        $data['globalFreeDeliveryAmount']   = optional($settings->where('id', 44)->first())->value ?? 0;

        return view('order/edit', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        try {

            DB::transaction(function () use ($request, $id) {

                $this->orderService->updateOrder($request, $id);
            });

            return redirect()->back()->withMessage('Order has been ' . $request->status . ' Successfully');
        } catch (\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }



    public function destroy($id)
    {
        try {

            DB::transaction(function () use ($id) {

                $order = Order::query()
                    ->with('orderDetails')
                    ->with('orderCustomerInfo')
                    ->with('order_status')
                    ->where('id', $id)
                    ->first();

                if ($order->current_status == 5) {
                    $order->transactions()->delete();
                }

                if ($order->current_status != 1 || $order->current_status != 6) {

                    foreach ($order->orderDetails as $orderDetail) {

                        $stocks = Stock::where(['stockable_type' => 'Order', 'stockable_id' => $orderDetail->id])->get();

                        foreach ($stocks ?? [] as $stock) {

                            $this->stockService->updateStockSummaries($stock->company_id, $stock->supplier_id, $stock->warehouse_id, $stock->product_id, $stock->product_variation_id, $stock->lot, $stock->expire_date, 0, $stock->quantity, 0, $stock->purchase_total);
                            $stock->delete();
                        }
                    }
                }

                $order->orderDetails()->delete();

                $order->order_status()->delete();

                $order->orderCustomerInfo()->delete();

                if ($order->wallet_amount > 0) {
                    $order->customerWalletTransactions()->delete();
                    $this->customerWalletService->updateCustomerWallet($order->customer_id, $order->wallet_amount);
                }

                if ($order->point_amount > 0) {
                    $order->customerPointTransactions()->delete();
                    $this->customerPointService->updateCustomerPoint($order->customer_id, $order->point_used);
                }

                $order->delete();
            });

            return redirect()->back()->withMessage('Order has been deleted Successfully');
        } catch (\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }




    /*
     |--------------------------------------------------------------------------
     | SHOW (METHOD)
     |--------------------------------------------------------------------------
    */
    public function show(Request $request, $id)
    {

        $data['order']          = Order::with('orderCustomerInfo', 'orderDetails.product.unitMeasure')->where('id', $id)->first();
        $data['user']           = User::where('id', $data['order']->created_by)->first();
        $data['company']        = Company::first();
        $data['pageSections']   = EcomSetting::whereIn('id', [36, 37, 38, 51, 52])->get();

        if ($request->print_type == 'pos-print') {

            $data['company'] =  Company::first();

            return view('order/pos-print', $data);
        }

        if ($request->type == 'invoice2') {
            return view('order/invoice2', $data);
        }

        return view('order/invoice1', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | CHANGE ORDER STATUS CREATE (METHOD)
     |--------------------------------------------------------------------------
    */
    public function changeOrderStatusCreate($id)
    {
        $data['order']          = Order::query()
            ->where('id', $id)
            ->with('customer:id,name')
            ->with('orderCustomerInfo')
            ->with(['orderDetails' => function ($q) {
                $q->with(['product' => function ($q1) {
                    $q1->with('unitMeasure:id,name')
                        ->select('id', 'name', 'unit_measure_id', 'sub_text', 'category_id', 'sku');
                }]);
                $q->with('productVariation:id,name');
            }])
            ->with('order_status:order_id,status_id')
            ->with('currentStatus:id,name')
            ->with('timeSlot:id,starting_time,ending_time')
            ->first();

        $data['deliveryMans']   = DeliveryMan::query()
            ->select('id', 'name')
            ->where('status', 1)
            ->orderBy('name', 'ASC')
            ->get();

        $data['warehouses']     = Warehouse::get(['id', 'name']);
        if (auth()->user()->type == "Delivery Man") {
            $data['statuses']       = Status::whereIn('id', [5])->get();
        } else {
            $data['statuses']       = Status::get();
        }

        return view('order/show', $data);
    }







    public function changeOrderStatus(Request $request, $id)
    {
        try {
            // dd('request',$request->all(),'id',$id);
            DB::transaction(function () use ($request, $id) {

                $order = Order::query()
                    ->where('id', $id)
                    ->with('orderDetails')
                    ->with('customer')
                    ->first();


                if (isset($request->status_id)) {

                    $condition = $order->current_status == 1 && $request->status_id != 2 && $request->status_id != 6 ? true : false;

                    if ($request->status_id == 2 || $condition) {

                        foreach ($order->orderDetails as $orderDetail) {

                            $calculateQuantity = $orderDetail->measurement_value > 0 ? $orderDetail->quantity * $orderDetail->measurement_value : $orderDetail->quantity;

                            $lotQtyArr = [];

                            $getLotNo = $this->getLotNo($request, $order, $orderDetail);

                            $getLotNumbers = $this->getLotNumbers($request, $order, $orderDetail);

                            if ($getLotNo != null) {

                                $this->stockService->storeStock($orderDetail, $order->company_id ?? 1, null, $request->warehouse_id, $orderDetail->product_id, $orderDetail->product_variation_id, $getLotNo->lot, $order->order_no, $order->date, 'Out', $orderDetail->purchase_price, $orderDetail->sale_price, $calculateQuantity, null);

                                $this->stockService->updateOrCreateStockSummary($order->company_id ?? 1, null, $request->warehouse_id, $orderDetail->product_id, $orderDetail->product_variation_id, $getLotNo->lot, null, 0, $calculateQuantity, 0, $orderDetail->purchase_price * $calculateQuantity);
                            } else {

                                foreach ($getLotNumbers as $key => $lotNumber) {

                                    $balanceQty = $this->checkBalanceQty($request, $lotNumber->lot, $order, $orderDetail);

                                    if ($balanceQty > 0) {

                                        $leftQty = $calculateQuantity - array_sum($lotQtyArr);

                                        $quantity = $lotNumber->balance_qty;

                                        if ($leftQty <= $lotNumber->balance_qty) {
                                            $quantity = $leftQty;
                                        }

                                        if ($calculateQuantity > array_sum($lotQtyArr)) {

                                            $this->stockService->storeStock($orderDetail, $order->company_id ?? 1, null, $request->warehouse_id, $orderDetail->product_id, $orderDetail->product_variation_id, $lotNumber->lot, $order->order_no, $order->date, 'Out', $orderDetail->purchase_price, $orderDetail->sale_price, $quantity, null);

                                            $this->stockService->updateOrCreateStockSummary($order->company_id ?? 1, null, $request->warehouse_id, $orderDetail->product_id, $orderDetail->product_variation_id, $lotNumber->lot, null, 0, $quantity, 0, $orderDetail->purchase_price * $quantity);
                                        }

                                        array_push($lotQtyArr, $quantity);
                                    }
                                }
                            }
                        }

                        if ($order->payment_status == 'Processing' || $order->payment_status == 'Complete') {
                            $this->customerPointService->storeCustomerPointTransactionByAmount($order, $order->customer_id, 'In', $order->grand_total, null);
                        }

                        $account = Account::create([
                            'name'                  => $request->customer_name,
                            'account_group_id'      => 1,
                            'account_control_id'    => 1,
                            'account_subsidiary_id' => 8,
                            'opening_balance'       => 0,
                            'balance_type'          => 'Debit'
                        ]);

                        Customer::where('id', $request->customer_id)->update([
                            'account_id'    => $account->id,
                        ]);
                    }


                    if ($request->status_id == 6) {

                        foreach ($order->orderDetails as $orderDetail) {

                            $stocks = Stock::where(['stockable_type' => 'Order', 'stockable_id' => $orderDetail->id])->get();

                            foreach ($stocks ?? [] as $stock) {

                                $this->stockService->updateStockSummaries($stock->company_id, $stock->supplier_id, $stock->warehouse_id, $stock->product_id, $stock->product_variation_id, $stock->lot, $stock->expire_date, 0, $stock->quantity, 0, $stock->purchase_total);
                                $stock->delete();
                            }
                        }


                        if ($order->wallet_amount > 0) {
                            $order->customerWalletTransactions()->delete();
                            $this->customerWalletService->updateCustomerWallet($order->customer_id, $order->wallet_amount);
                        }

                        if ($order->point_amount > 0) {
                            $order->customerPointTransactions()->delete();
                            $this->customerPointService->updateCustomerPoint($order->customer_id, $order->point_used);
                        }
                    }
                    $request->status_id == 5 ? $order->payment_status = 'Complete' : $order->payment_status = $order->payment_status;
                    $order->update([
                        'warehouse_id'      => $request->warehouse_id,
                        'current_status'    => $request->status_id,
                        'payment_status'    => $order->payment_status
                    ]);

                    $order->order_status()->create([
                        'status_id' => $request->status_id
                    ]);
                }

                $order->update([
                    'delivery_man_id'   => $request->delivery_man_id,
                ]);
            });

            return redirect()->back()->withMessage('Order has been ' . $request->status . ' Successfully');
        } catch (\Exception $ex) {

            return redirect()->back()->withError($ex->getMessage());
        }
    }




    public function getLotNo($request, $order, $orderDetail)
    {
        return  StockSummary::query()
            ->where([
                'company_id'            => $order->company_id ?? 1,
                'warehouse_id'          => $request->warehouse_id,
                'product_id'            => $orderDetail->product_id,
                'product_variation_id'  => $orderDetail->product_variation_id,
            ])
            ->where('balance_qty', '>=', $orderDetail->quantity)
            ->orderBy('id', 'ASC')
            ->first();
    }




    public function checkBalanceQty($request, $lot, $order, $orderDetail)
    {
        return  StockSummary::query()
            ->where([
                'company_id'            => $order->company_id ?? 1,
                'warehouse_id'          => $request->warehouse_id,
                'product_id'            => $orderDetail->product_id,
                'product_variation_id'  => $orderDetail->product_variation_id,
                'lot'                   => $lot,
            ])
            ->orderBy('id', 'ASC')
            ->sum('balance_qty');
    }




    public function getLotNumbers($request, $order, $orderDetail)
    {
        return  StockSummary::query()
            ->where([
                'company_id'            => $order->company_id ?? 1,
                'warehouse_id'          => $request->warehouse_id,
                'product_id'            => $orderDetail->product_id,
                'product_variation_id'  => $orderDetail->product_variation_id,
            ])
            ->orderBy('id', 'ASC')
            ->get();
    }




    public function searchItem(Request $request)
    {
        $search                         = $request->search;
        $product_id                     = '';
        $product_variation_id           = '';

        $data['productVariation']       = ProductVariation::query()
            ->where('sku', $search)
            ->first();

        if ($data['productVariation']) {
            $product_variation_id   = $data['productVariation']->id;
            $product_id             = $data['productVariation']->product_id;
        }

        $data['product']                = Product::query()
            ->where(function ($query) use ($search, $product_id) {
                $query->where('code', $search)
                    ->orWhere->where('sku', $search)
                    ->orWhere->where('barcode', $search)
                    ->orWhere->where('manufacture_barcode', $search)
                    ->orWhere->where('manufacture_model_no', $search)
                    ->orWhere->where('id', $product_id);
            })
            ->first();

        return  StockSummary::query()
            ->where('product_id', $data['product']->id)
            ->where(function ($query) use ($product_variation_id) {
                if ($product_variation_id != '') {
                    $query->where('product_variation_id', $product_variation_id);
                }
            })
            ->first();
    }


    public function deliveryManOrders(Request $request)
    {
        if (auth()->user()->type == "Delivery Man") {

            $data['orders']         = Order::query()
                ->searchByField('current_status')
                ->searchByField('order_no')
                ->searchByField('customer_id')
                ->dateFilter('date')
                ->with('customer:id,name,mobile')
                ->with('warehouse:id,name')
                ->with('currentStatus:id,name')
                ->when($request->filled('area_id'), function ($query) use ($request) {
                    $query->whereHas('orderCustomerInfo', function ($q) use ($request) {
                        $q->where(function ($q1) use ($request) {
                            $q1->where('receiver_area_id', $request->area_id)
                                ->orWhere('area_id', $request->area_id);
                        });
                    });
                })
                ->where('delivery_man_id', auth()->user()->delivery_man->id)
                ->orderBy('id', 'DESC')
                ->paginate(30);

            $data['customers']      = Customer::get(['id', 'name', 'mobile']);
            $data['statuses']       = Status::pluck('name', 'id');
            $data['areas']          = Area::orderBy('name', 'ASC')->pluck('name', 'id');
        }




        return view('delivery-man-order/index', $data);
    }
}
