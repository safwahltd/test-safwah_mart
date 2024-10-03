<?php

namespace Module\Inventory\Controllers;

use Carbon\Carbon;
use App\Models\Area;
use App\Models\User;
use App\Models\Company;
use App\Models\District;
use App\Models\EcomSetting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SystemSetting;
use App\Traits\CheckPermission;
use Module\Product\Models\Stock;
use Module\Inventory\Models\Sale;
use Illuminate\Support\Facades\DB;
use Module\Account\Models\Account;
use Module\Inventory\Models\Order;
use Module\Product\Models\Product;
use Module\Product\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Module\Inventory\Models\Customer;
use App\Services\NextInvoiceNoService;
use Module\Inventory\Models\Warehouse;
use Module\Product\Models\StockSummary;
use Module\Inventory\Models\EcomAccount;
use Module\Inventory\Models\SalePayment;
use Module\Inventory\Models\CustomerType;
use Module\Product\Services\StockService;
use Module\Inventory\Services\SaleService;
use Module\Product\Models\ProductVariation;
use Module\Product\Services\CategoryService;
use Module\Product\Models\ProductMeasurement;
use Module\Inventory\Services\CustomerService;

class SaleController extends Controller
{
    use CheckPermission;


    public $customerService;
    public $saleService;
    public $stockService;
    public $nextInvoiceNumberService;





    public function __construct()
    {
        $this->customerService              = new CustomerService;
        $this->saleService                  = new SaleService;
        $this->stockService                 = new StockService;
        $this->nextInvoiceNumberService     = new NextInvoiceNoService;
    }






    /*
     |--------------------------------------------------------------------------
     | INDEX (METHOD)
     |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $this->hasAccess("sales.index");

        $data['customers']      = Customer::pluck('name', 'id');
        $data['warehouses']     = Warehouse::pluck('name', 'id');

        $data['sales']          = Order::query()
                                        ->with('customer:id,name,mobile')
                                        ->when(($request->filled('from') && $request->filled('to')), function($query) use ($request) {
                                            $query->whereBetween('date', [$request->from, $request->to]);
                                        })
                                        ->where('order_source', 'POS')
                                        ->searchByField('warehouse_id')
                                        ->searchByField('customer_id')
                                        ->searchByField('invoice_no')
                                        ->latest()
                                        ->paginate(30);

    //    return  $data['sales']          = Sale::query()
    //                             ->with('customer:id,name,mobile')
    //                             ->when(($request->filled('from') && $request->filled('to')), function($query) use ($request) {
    //                                 $query->whereBetween('date', [$request->from, $request->to]);
    //                             })
    //                             ->searchByField('warehouse_id')
    //                             ->searchByField('customer_id')
    //                             ->searchByField('invoice_no')
    //                             ->latest()
    //                             ->paginate(30);

        return view('sales.index', $data);
    }






    /*
     |--------------------------------------------------------------------------
     | CREATE (METHOD)
     |--------------------------------------------------------------------------
    */
    public function create(Request $request)
    {
        $this->hasAccess("sales.create");

        // $data['customers']      = Customer::get(['id', 'name', 'mobile', 'email', 'address', 'gender', 'is_default']);
        $data['warehouses']     = Warehouse::with(['ecomAccounts' => function ($q) {
                                    $q->where('status', 1)
                                    ->select('id', 'warehouse_id', 'name', 'account_no', 'is_default');
                                }])
                                ->get(['id', 'name']);


        $data['categories']     = Category::query()
                                ->where('parent_id', null)
                                ->with('childCategories')
                                ->get(['id', 'name']);


        // return $data['products']       = Product::query()
        //                         ->with('category:id,name')
        //                         ->with('unitMeasure:id,name')
        //                         ->with('productMeasurements')
        //                         ->with(['currentDiscount' => function($q){
        //                             $q->where('start_date','<=', today())
        //                             ->where('end_date','>=', today());
        //                         }])

        //                         ->select('id', 'name', 'code', 'category_id', 'unit_measure_id', 'purchase_price', 'sale_price', 'vat', 'vat_type', 'is_variation')
        //                         // ->paginate(1400);
        //                         ->get();

        $data['users']          = User::where('type', 'Admin')->get();
        $data['customer']       = Customer::find(1000000);

        $data['accounts']       = Account::where('account_group_id', 1)
                                ->where('account_control_id', 1)
                                ->where(function($q){
                                    $q->where('account_subsidiary_id', 10)
                                      ->orWhere('account_subsidiary_id', 11);
                                })
                                ->get();

        $data['districts']      = District::get();
        $data['areas']          = Area::get();
        $data['customer_types'] = CustomerType::get();

        $settings               = EcomSetting::whereIn('id', ['37', '38', '39', '40', '41'])->get();
        $data['isSoldByActive'] = $settings->where('id', 37)->where('value', 'on')->first() ? 1 : 0;

        return view('sales/create', $data);
    }






    /*
     |--------------------------------------------------------------------------
     | CREATE POS SALE (METHOD)
     |--------------------------------------------------------------------------
    */
    public function createPosSale(Request $request)
    {
        Paginator::useBootstrap();

        $data['company']        = Company::find(1);

        $data['customers']      = Customer::get(['id', 'name', 'mobile', 'email', 'address', 'gender', 'is_default']);
        $data['warehouses']     = Warehouse::get(['id', 'name']);

        $data['categories']     = Category::query()
                                ->where('parent_id', null)
                                ->with('childCategories')
                                ->get(['id', 'name']);

        $categories_id          = (new CategoryService)->getCategoryIds($request);

        $productMeasurement     = ProductMeasurement::query()
                                ->when($request->filled('search'), function($q) use ($request) {
                                    $q->where('sku', $request->search);
                                })
                                ->first();

        $warehouses_id          = $this->getWarehousesId($request);

        $productVariation       = ProductVariation::query()
                                ->when($request->filled('search'), function($q) use ($request) {
                                    $q->where('sku', $request->search);
                                })
                                ->withSum(
                                    ['stockSummaries as current_stock' => function($query) use ($warehouses_id) {
                                        $query->whereIn('warehouse_id', $warehouses_id);
                                    }],
                                    'balance_qty'
                                )
                                ->first();

        if ($productVariation && $productVariation->current_stock == null) {
            $productVariation   = null;
        }

        $products_id            = $this->getProductsId($warehouses_id);
        $data['products']       = $this->getProducts($request, $warehouses_id, $products_id, $categories_id, $productMeasurement, $productVariation);

        $data['accounts']       = Account::where('account_group_id', 1)
                                ->where('account_control_id', 1)
                                ->where(function($q){
                                    $q->where('account_subsidiary_id', 10)
                                    ->orWhere('account_subsidiary_id', 11);
                                })
                                ->get();

        if ($request->is_search == 1) {


            $view = view('sales/_inc/_products', ['products' => $data['products']])->render();

            return response()->json([
                'html'                  => $view,
                'products'              => $data['products'],
                'productMeasurement'    => $productMeasurement ?? '',
                'productVariation'      => $productVariation ?? '',
                'warehouse'             => $warehouses_id
            ]);
        }
        $data['customer']       = Customer::find(1000000);
        $data['customer_types'] = CustomerType::get();


        $data['districts']      = District::get();
        $data['areas']          = Area::get();

        return view('sales/pos-sale', $data);
    }






    /*
     |--------------------------------------------------------------------------
     | GET WAREHOUSES ID (METHOD)
     |--------------------------------------------------------------------------
    */
    public function getWarehousesId($request)
    {
        if ($request->warehouse_id != '') {

            $warehouses_id  = [$request->warehouse_id];

        }
        // elseif (auth()->user()->warehouse_id == '') {

        //     $warehouses_id  = Warehouse::get()
        //                     ->map(function ($item) {
        //                         return ['id' => $item->id];
        //                     })
        //                     ->flatten();

        // }
        elseif (auth()->user()->warehouse_id == '') {

            $warehouses_id  = [Warehouse::first()->id];

        } else {
            $warehouses_id  = [auth()->user()->warehouse_id];
        }

        return $warehouses_id;
    }






    /*
     |--------------------------------------------------------------------------
     | GET PRODUCTS ID (METHOD)
     |--------------------------------------------------------------------------
    */
    public function getProductsId($warehouses_id)
    {
        return  StockSummary::query()
                ->whereIn('warehouse_id', $warehouses_id)
                ->get()
                ->map(function ($item) {
                    return ['product_id' => $item->product_id];
                })
                ->flatten();
    }






    /*
     |--------------------------------------------------------------------------
     | GET PRODUCTS (METHOD)
     |--------------------------------------------------------------------------
    */
    public function getProducts($request, $warehouses_id, $products_id, $categories_id, $productMeasurement, $productVariation)
    {
        return  Product::query()
                ->active()
                // ->whereIn('id', $products_id)
                ->when($request->filled('search'), function($q) use ($request, $productMeasurement, $productVariation) {
                    $q->where(function ($q) use ($request, $productMeasurement, $productVariation) {
                        $q->where('name', 'like', '%'.$request->search.'%')
                            ->orWhere('id', $productMeasurement ? $productMeasurement->product_id : '')
                            ->orWhere('id', $productVariation ? $productVariation->product_id : '')
                            ->orWhere('code', $request->search)
                            ->orWhere('sku', $request->search)
                            ->orWhere('manufacture_barcode', $request->search)
                            ->orWhere('manufacture_model_no', $request->search)
                            ->orWhere('barcode', $request->search);
                    });
                })
                ->when(request()->filled('category_id'), function($q) use ($categories_id) {
                    $q->whereIn('category_id', $categories_id);
                })
                ->with('productMeasurements')
                ->with(['productVariations' => function ($q) use ($warehouses_id) {
                    $q->withSum(
                        ['stockSummaries as current_stock' => function($query) use ($warehouses_id) {
                            $query->whereIn('warehouse_id', $warehouses_id);
                        }],
                        'balance_qty'
                    );
                }])
                ->with(['stockSummaries' => function ($q) use ($warehouses_id) {
                    $q->whereIn('warehouse_id', $warehouses_id)
                    ->with(['productVariation' => function ($q) use ($warehouses_id) {
                        $q->withSum(
                            ['stockSummaries as current_stock' => function($query) use ($warehouses_id) {
                                $query->whereIn('warehouse_id', $warehouses_id);
                            }],
                            'balance_qty'
                        );
                    }]);
                }])
                ->withSum(
                    ['stockSummaries as current_stock' => function($query) use ($warehouses_id) {
                        $query->whereIn('warehouse_id', $warehouses_id);
                    }],
                    'balance_qty'
                )
                ->with('discount')
                ->with('unitMeasure:id,name')
                ->with('category:id,name')
                ->orderBy('id', 'DESC')
                ->paginate(20);
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
                ->withSum(['stockSummaries as current_stock' => function($q) use($request){
                    $q->where('warehouse_id', $request->warehouse_id);
                }], 'balance_qty')
                ->get();

    }





    /*
     |--------------------------------------------------------------------------
     | GET PRODUCT VARIATIONS (AXIOS)
     |--------------------------------------------------------------------------
    */
    public function getProductMeasurements(Request $request)
    {
        return  ProductMeasurement::query()
                ->where('product_id', $request->product_id)
                ->select('id', 'product_id', 'sku', 'title', 'value')
                ->get();

    }
    /*
     |--------------------------------------------------------------------------
     | GET LOTS (AXIOS)
     |--------------------------------------------------------------------------
    */
    public function getLots(Request $request)
    {
        return  StockSummary::where([
                    'warehouse_id'          => $request->warehouse_id,
                    'product_id'            => $request->product_id,
                    'product_variation_id'  => $request->product_variation_id,
                ])->sum('balance_qty');
                // ->groupBy('lot')
                // ->pluck('lot');
    }





    /*
     |--------------------------------------------------------------------------
     | GET ITEM STOCK (AXIOS)
     |--------------------------------------------------------------------------
    */
    public function getItemStock(Request $request)
    {
        return  StockSummary::where([
                    'warehouse_id'          => $request->warehouse_id,
                    'product_id'            => $request->product_id,
                    'product_variation_id'  => $request->product_variation_id,
                    'lot'                   => $request->lot,
                ])
                ->sum('balance_qty');
    }





    /*
     |--------------------------------------------------------------------------
     | SEARCH ITEM (AXIOS)
     |--------------------------------------------------------------------------
    */
    public function searchItem(Request $request)
    {
        return $request->all();
    }





    /*
     |--------------------------------------------------------------------------
     | STORE VALIDATION (METHOD)
     |--------------------------------------------------------------------------
    */
    protected function storeValidation($request)
    {
        $request->validate([
            'customer_id'           => 'required',
            'warehouse_id'          => 'required',
            'date'                  => 'required|date',
        ]);
    }





    /*
     |--------------------------------------------------------------------------
     | STORE (METHOD)
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        // return $request->all();
        // dd($request->all());

        $this->storeValidation($request);

        try {
            DB::transaction(function () use($request) {

                $this->saleService->createSale($request);

                $this->saleService->createSaleDetails($request);

                $this->saleService->createSalePayment($request);

                // $this->saleService->makeTransaction();

                $this->nextInvoiceNumberService->setNextInvoiceNo($request->company_id ?? optional(auth()->user())->company_id, $request->warehouse_id, 'Sale', date('Y'));
            });

            $url = route('inv.sales.show', $this->saleService->sale->id) . '?print_type=' . ($request->radio == 'pos-print' ? 'pos-print' : 'normal-print');

        } catch(\Exception $ex) {
            return redirect()->back()->withInput()->withError($ex->getMessage());
        }

        return redirect($url)->withMessage('Sale has been Created Successfully.');
    }





    /*
     |--------------------------------------------------------------------------
     | SHOW (METHOD)
     |--------------------------------------------------------------------------
    */
    public function show(Sale $sale, Request $request)
    {
        $customer = $sale->customer;

        $invoice2       = optional(SystemSetting::find(6))->value;
        $company        = Company::first();

        if ($invoice2 == 1) {
            return view('sales.invoice2', compact('sale', 'customer', 'company'));
        }


        if ($request->print_type == 'normal-print') {

            if ($invoice2 == 1) {
                return view('sales.invoice2', compact('sale', 'customer', 'company'));
            }
            return view('sales.invoice', compact('sale'));
        }



        return view('sales.pos-print', compact('sale', 'customer'));
    }






    /*
     |--------------------------------------------------------------------------
     | CREATE CUSTOMER (AXIOS)
     |--------------------------------------------------------------------------
    */
    public function createCustomer(Request $request)
    {
        try {

            $is_new = 'No';
            $data   = '';
            $status = 0;

            DB::transaction(function () use ($request, &$is_new, &$data, &$status) {

                $user   = User::where([
                            'phone' => $request->phone,
                            'email' => $request->email,
                        ])
                        ->first();

                // if ($user == null) {
                //     $data = Customer::where('user_id', $user->id)->first();

                //     if ($data != null) {
                //         $status = 1;
                //     }
                // }

                if($user == null) {

                    $account = Account::create([
                        'name'                  => $request->name ?? $request->phone,
                        'account_group_id'      => 1,
                        'account_control_id'    => 1,
                        'account_subsidiary_id' => 8,
                        'opening_balance'       => 0,
                        'balance_type'          => 'Debit'
                    ]);

                    $user = User::create([
                        'company_id'        => 1,
                        'name'              => $request->name ?? $request->phone,
                        'phone'             => $request->phone,
                        'email'             => $request->email,
                        'password'          => Hash::make(Str::random(8)),
                        'type'              => 'Customer',
                    ]);

                    $data = Customer::create([
                        'register_from'     => 'Showroom',
                        'name'              => $request->name,
                        'mobile'            => $request->phone,
                        'email'             => $request->email,
                        'gender'            => $request->gender,
                        'address'           => $request->address,
                        'account_id'        => $account->id,
                        'user_id'           => $user->id,
                        'zip_code'          => $request->zip_code,
                        'district_id'       => $request->district_id,
                        'area_id'           => $request->area_id,
                        'customer_type_id'  => $request->customer_type_id,
                    ]);

                    $this->customerService->makeDefault($request, $data);

                    $is_new = 'Yes';
                    $status = 1;
                }
            });
            // return $is_new;

        } catch (\Exception $ex) {

            return response()->json($ex->getMessage());
        }


        return response()->json([
            'status'    => $status,
            'data'      => $data,
            'is_new'    => $is_new,
        ]);
    }





    /*
     |--------------------------------------------------------------------------
     | CREATE CUSTOMER (AXIOS)
     |--------------------------------------------------------------------------
    */
    public function editCustomer(Request $request)
    {

        if($request->check_user){
           $user   = User::where('phone', $request->phone)
                            ->where('id', '!=', $request->user_id)
                            ->first();
            return $user != '' ? 1 : 0;
        }else{


            try{
                DB::transaction(function() use($request){



                    $updateUser = User::find($request->user_id);

                    $updateUser->update([
                                    'name'              => $request->name ?? $request->phone,
                                    'phone'             => $request->phone,
                                    'email'             => $request->email,
                                ]);

                    $data = $updateUser->customer->update([
                                            'name'              => $request->name,
                                            'mobile'            => $request->phone,
                                            'email'             => $request->email,
                                            'gender'            => $request->gender,
                                            'address'           => $request->address,
                                            'zip_code'          => $request->zip_code,
                                            'district_id'       => $request->district_id,
                                            'area_id'           => $request->area_id,
                                            'customer_type_id'  => $request->customer_type_id,
                                        ]);
                    // $this->customerService->makeDefault($request, $data);

                });
            }catch (\Exception $ex) {

                    return response()->json($ex->getMessage());
            }

        }






    }











    /*
     |--------------------------------------------------------------------------
     | DESTROY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $this->hasAccess("sales.delete");

        // try {

            return DB::transaction(function () use ($id) {

                $sale = Sale::with('saleDetails')->find($id);

                dd($sale);
                $salePayments = SalePayment::where('sale_id', $id)->get();

                foreach ($salePayments as $payment) {

                    $ecomAccount = EcomAccount::find($payment->ecom_account_id);

                    $ecomAccount->update([
                        'balance' => $ecomAccount->balance - $payment->amount
                    ]);

                    $payment->delete();
                }

                foreach ($sale->saleDetails as $saleDetail) {

                    $stocks = Stock::where(['stockable_type' => 'POS Sale', 'stockable_id' => $saleDetail->id])->get();

                    foreach ($stocks ?? [] as $stock) {

                        $this->stockService->updateStockSummaries($stock->company_id, $stock->supplier_id, $stock->warehouse_id, $stock->product_id, $stock->product_variation_id, $stock->lot, $stock->expire_date, 0, $stock->quantity, 0, $stock->purchase_total);
                        $stock->delete();
                    }

                    $saleDetail->delete();
                }

                // $current_balance = $sale->payable_amount - ($sale->paid_amount - $sale->change_amount);

                // Customer::find($sale->customer_id)->increment('current_balance', $current_balance ?? 0);

                $sale->transactions()->delete();

                $sale->delete();
            });

            return redirect()->back()->withMessage('Sale Successfully Deleted!');

        // } catch (\Throwable $th) {

        //     return redirect()->back()->withError($th->getMessage());
        // }
    }




    public function getCustomers(Request $request)
    {
        return  Customer::query()
                ->when($request->q, function($q) use ($request) {
                    $q->where(function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->q . '%')
                            ->orWhere('mobile', 'like', '%' . $request->q . '%');
                    });
                })
                ->orderBy('name')
                ->paginate(10, ['*'], 'page', $request->page);
    }




    public function getSaleProducts(Request $request)
    {
        return  Product::query()
                ->when($request->q, function($q) use ($request) {
                    $q->where(function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->q . '%')
                            ->orWhere('sku', 'like', '%' . $request->q . '%');
                    });
                })->with('productVariations')
                ->with(['currentDiscount' => function($q){
                    $q->where('start_date','<=', today())
                    ->where('end_date','>=', today());
                }])
                ->with('category:id,name')
                ->with('unitMeasure:id,name')
                ->with('productMeasurements')
                ->with('category:id,name')
                ->orderBy('name')
                ->paginate(10, ['*'], 'page', $request->page);
    }






    public function recentTransaction(Request $request){


        if ($request->date == '' || $request->date == null) {

            $date = Carbon::now()->format('Y-m-d');

            $recent_transactions   = Sale::where([
                                        'date' => $date,
                                    ])
                                    ->with('customer')
                                    ->get();

            return $recent_transactions;
        }
        else{

            $recent_transactions   = Sale::where([
                                        'date' => $request->date,
                                    ])
                                    ->with('customer')
                                    ->get();

            return $recent_transactions;
        }


    }









}
