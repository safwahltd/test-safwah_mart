<?php

namespace Module\Inventory\Controllers;

use PDF;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Area;
use App\Models\Company;
use App\Models\District;
use Illuminate\Http\Request;
use App\Models\SystemSetting;
use Module\Product\Models\Stock;
use Module\Inventory\Models\Sale;
use Illuminate\Support\Facades\DB;
use Module\Inventory\Models\Order;
use Module\Product\Models\Product;
use Module\Inventory\Models\Status;
use Module\Product\Models\Category;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Module\Inventory\Models\Customer;
use Module\Inventory\Models\Warehouse;
use Module\Product\Models\StockSummary;
use Module\Inventory\Models\DeliveryMan;
use Module\Inventory\Models\OrderDetail;
use phpDocumentor\Reflection\Types\Null_;
use Module\Product\Models\ProductVariation;
use Module\Product\Services\ProductService;
use Module\Product\Services\CategoryService;
use Module\Inventory\Exports\ProductOrderExcelExport;
use Module\Inventory\Models\OrderStatus;
use Module\Inventory\Models\SaleDetail;
use Module\WebsiteCMS\Models\CorporateOrder;
use Module\WebsiteCMS\Models\OrderByPicture;

class ReportController extends Controller
{
    public $productService;







    /*
     |--------------------------------------------------------------------------
     | _CONSTRUCT (METHOD)
     |--------------------------------------------------------------------------
    */
    public function __construct()
    {
        $this->productService = new ProductService;
    }





    /*
     |--------------------------------------------------------------------------
     | GET PRODUCTS BY CATEGORY
     |--------------------------------------------------------------------------
    */
    public function getProductsByCategory(Request $request)
    {
        return $this->productService->getProductsByCategory($request);
    }





    /*
     |--------------------------------------------------------------------------
     | GET VARIATIONS BY PRODUCT
     |--------------------------------------------------------------------------
    */
    public function getVariationsByProduct(Request $request)
    {
        return $this->productService->getVariationsByProduct($request);
    }





    /*
     |--------------------------------------------------------------------------
     | SALES REPORT
     |--------------------------------------------------------------------------
    */
    public function salesreport(Request $request)
    {

        $data['customers']                  = Customer::get(['id', 'name', 'mobile', 'register_from']);

        $data['warehouses']                 = Warehouse::query()
                                            ->when(auth()->user()->warehouse_id != '', function ($q) {
                                                $q->where('id', auth()->user()->warehouse_id);
                                            })
                                            ->pluck('name', 'id');

        $data['products']                   = Product::query()
                                            ->with('productVariations:id,product_id,name')
                                            ->get(['id', 'name', 'code']);

        $data['productVariations']          = ProductVariation::pluck('name', 'id');

        $query                              = Order::query()
                                            ->searchByField('customer_id')
                                            ->dateFilter('date')
                                            ->where('order_source','POS')
                                            ->when($request->filled('warehouse_id'), function ($q) use ($request) {
                                                $q->where('warehouse_id', $request->warehouse_id ?? optional(auth()->user())->warehouse_id);
                                            });

        $sales                              = clone $query->get();
        $data['sales']                      = clone $query->latest()->paginate(50);

        $data['grand_purchase_price']       = $sales->sum('total_cost');
        $data['grand_receive_amount']       = $sales->sum('subtotal');
        $data['grand_discount_amount']      = $sales->sum('total_discount_amount');

        $data['grand_total_profit']         = $data['grand_receive_amount'] - $data['grand_purchase_price'] - $data['grand_discount_amount'];

        // dd($data);

        return view('reports/sales-report', $data);
    }






    /*
     |--------------------------------------------------------------------------
     | PRODUCT REPORT
     |--------------------------------------------------------------------------
    */
    public function productReportOld(Request $request)
    {

        $products       = Product::query()->get(['id', 'name', 'code']);


        return $product_orders = Product::query()
                                ->whereHas('orderDetails')
                                ->withSum(
                                    ['orderDetails' => function($q) use ($request) {
                                        $q->whereHas('order', function($q) use ($request){

                                                    $q->when($request->filled('date'), function ($q) use ($request) {

                                                        $q->where('date', $request->date);

                                                    })->when($request->filled('delivery_date'), function ($q) use ($request) {

                                                        $q->where('delivery_date', $request->delivery_date);

                                                    });

                                          });
                                    }],
                                    'quantity'
                                )
                                ->withSum('stockSummaries', 'balance_qty')

                                ->when($request->filled('product_id'), function($q) use($request){

                                    $q->where('id', $request->product_id);

                                })
                                // ->select('id', 'name', 'wholesale_price', 'sale_price', 'supplier_id', 'country_id', 'vat', 'name', 'slug','code','wholesale_price','purchase_price','stock_summaries_sum_balance_qty')
                                ->get();

        return view('reports/product-report', compact('product_orders','products'));

    }


    public function productReport(Request $request)
    {

        if($request->type == "Excel"){
            return Excel::download(new ProductOrderExcelExport($request->product_id, $request->date, $request->delivery_date, $request->user_id), 'ordered-product-list.xlsx');
        }
        $data['company']         = Company::first();

        $data['products']        = Product::query()->get(['id', 'name', 'code']);


        $productWiseUser         = SystemSetting::find(3);

        $data['product_orders'] = Product::query()
                                ->with('unitMeasure')
                                ->when($request->filled('user_id'), function ($q) use ($request) {
                                    $q->whereHas('productUsers', function($q) use ($request){
                                    // $q->where('user_id', auth()->user()->id);

                                        $q->where('user_id', $request->user_id);

                                    });

                                })
                                ->whereHas('orderDetails', function($q) use ($request){
                                    $q->whereHas('order', function($q) use ($request){

                                        $q->when($request->filled('date'), function ($q) use ($request) {

                                            $q->where('date', $request->date);

                                        })
                                        ->when($request->filled('delivery_date'), function ($q) use ($request) {

                                            $q->where('delivery_date', $request->delivery_date);

                                        });

                                    });
                                })
                            // ->withSum(
                            //     ['orderDetails' => function($q) use ($request) {
                            //         $q->whereHas('order', function($q) use ($request){

                            //             $q->when($request->filled('date'), function ($q) use ($request) {

                            //                 $q->where('date', $request->date);

                            //             })->when($request->filled('delivery_date'), function ($q) use ($request) {

                            //                 $q->where('delivery_date', $request->delivery_date);

                            //             });

                            //         });
                            //     }],
                            //     'quantity'
                            // )
                                ->with(
                                    ['orderDetails' => function($q) use ($request) {
                                        $q->whereHas('order', function($q) use ($request){

                                            $q->when($request->filled('date'), function ($q) use ($request) {

                                                $q->where('date', $request->date);

                                            })->when($request->filled('delivery_date'), function ($q) use ($request) {

                                                $q->where('delivery_date', $request->delivery_date);

                                            });

                                        });
                                    }]

                                )
                                ->withSum('stockSummaries', 'balance_qty')
                                ->when($request->filled('product_id'), function($q) use($request){
                                    $q->where('id', $request->product_id);
                                })->get();




        if($request->type == "PDF"){
            $pdf = \PDF::loadView('reports/product-order/pdf', $data, [],[
                "formate" =>'A4-L',
            ]);
            return $pdf->download('pdf_file.pdf');
        }


        $data['users']                  = User::where('type', 'Admin')->get();
        $data['productWiseUser']        = $productWiseUser->value;



        return view('reports/product-report', $data);

    }



    /*
     |--------------------------------------------------------------------------
     | PRODUCT ORDER EXCEL EXPORT METHOD
     |--------------------------------------------------------------------------
    */
    public function productOrderExcelExport(Request $request)
    {

        return Excel::download(new ProductOrderExcelExport($productId, $date, $deliveryDate), 'ordered-product-list.xlsx');
    }




    /*
     |--------------------------------------------------------------------------
     | PRODUCT ORDER PDF EXPORT METHOD
     |--------------------------------------------------------------------------
    */
    public function productOrderPdfExport(Request $request)
    {

        $data = Product::all();


        // $pdf = PDF::loadView('reports/product-report', $data);
        // return $pdf->stream('ordered-product-list.pdf');



        // $pdf = PDF::loadView('pdf.document', $data);
        // $pdf->getMpdf()->AddPage(...);



        $mpdf = new mPDF();
        $mpdf->WriteHTML($data);
        $mpdf->Output("ordered-product-list.pdf", 'F');
        $mpdf->Output();



    }




    /*
     |--------------------------------------------------------------------------
     | DAILY SALES REPORT
     |--------------------------------------------------------------------------
    */
    public function dailySalesReport(Request $request)
    {
        $data['customers']                  = Customer::get(['id', 'name', 'mobile', 'register_from']);

        $data['warehouses']                 = Warehouse::query()
                                            ->when(auth()->user()->warehouse_id != '', function ($q) {
                                                $q->where('id', auth()->user()->warehouse_id);
                                            })
                                            ->pluck('name', 'id');

        $data['products']                   = Product::query()
                                            ->with('productVariations:id,product_id,name')
                                            ->get(['id', 'name', 'code']);

        $data['productVariations']          = ProductVariation::pluck('name', 'id');

        $query                              = Order::query()
                                            ->where('order_source','POS')
                                            ->searchByField('customer_id')
                                            ->dateFilter('date')
                                            ->when($request->filled('warehouse_id'), function ($q) use ($request) {
                                                $q->where('warehouse_id', $request->warehouse_id ?? optional(auth()->user())->warehouse_id);
                                            })
                                            ->select('date',
                                               DB::raw('SUM(subtotal) AS subtotal'),
                                               DB::raw('SUM(total_discount_amount) AS total_discount_amount'))
                                            ->groupBy('date');

        $sales                              = clone $query->get();
        $data['sales']                      = clone $query->latest()->paginate(50);

        $data['grand_purchase_price']       = $sales->sum('total_cost');
        $data['grand_receive_amount']       = $sales->sum('subtotal') - $sales->sum('total_discount_amount');
        $data['grand_discount_amount']      = $sales->sum('total_discount_amount');

        $data['grand_total_profit']         = $data['grand_receive_amount'] - $data['grand_purchase_price'] - $data['grand_discount_amount'];

        // dd($data);

        return view('reports/daily-sales-report', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | STOCK IN HAND METHOD
     |--------------------------------------------------------------------------
    */
    public function stockInHand(Request $request)
    {
        if($request->filled('sync') && $request->sync == 1) {
            OrderDetail::truncate();
            Order::truncate();
            OrderStatus::truncate();

            CorporateOrder::truncate();
            OrderByPicture::truncate();
            DB::table('inv_sale_details')->truncate();
            SaleDetail::truncate();
            Sale::truncate();
            Stock::where('stockable_type', '<>', 'Product Opening By Product')->orWhereIn('id', [65, 127])->delete();
            StockSummary::truncate();

            $products = Product::with('openingStock')->get();

            foreach ($products as $key => $product) {
                StockSummary::firstOrCreate([
                    'company_id'   => 1,
                    'product_id'   => $product->id,
                    'warehouse_id' => 1,
                ],[
                    'lot'               => optional($product->openingStock)->lot,
                    'stock_in_qty'      => $quantity = optional($product->openingStock)->quantity ?? 0,
                    'stock_out_qty'     => 0,
                    'stock_in_value'    => $quantity * ($product->purchase_price ?? 0),
                    'stock_out_value'   => 0,

                ]);
            }
        }

        $data['categories']                 = Category::query()
                                            ->where('parent_id', null)
                                            ->with('childCategories')
                                            ->get(['id', 'name']);

        $data['warehouses']                 = Warehouse::query()
                                            ->when(auth()->user()->warehouse_id != '', function ($q) {
                                                $q->where('id', auth()->user()->warehouse_id);
                                            })
                                            ->pluck('name', 'id');

        $data['products']                   = Product::query()
                                            ->whereHas('stockSummaries')
                                            ->with('productVariations:id,product_id,name')
                                            ->get(['id', 'name', 'code']);

        $data['productVariations']          = ProductVariation::query()
                                            ->whereHas('stockSummaries')
                                            ->get(['id', 'product_id', 'name', 'sku']);

        $categories_id                      = (new CategoryService)->getCategoryIds($request);

        $stockInHands                       = StockSummary::query()
                                            ->when($request->filled('warehouse_id'), function ($q) use ($request) {
                                                $q->where('warehouse_id', $request->warehouse_id ?? optional(auth()->user())->warehouse_id);
                                            })
                                            ->whereHas('product', function ($q) use ($categories_id, $request) {
                                                $q->when(request()->filled('category_id'), function($q) use ($categories_id, $request) {
                                                    $q->whereIn('category_id', $categories_id);
                                                })
                                                ->when($request->filled('expired_type') && $request->expired_type == 'Manual', function($qr) {
                                                    $qr->whereNotNull('expired_note');
                                                })
                                                ->when($request->filled('expired_type') && $request->expired_type == 'Auto', function($qr) {
                                                    $qr->whereNull('expired_note');
                                                });
                                            })
                                            ->searchByField('product_id')
                                            ->searchByField('product_variation_id')
                                            ->when(request()->filled('min_stock'), function($q) use ($request) {
                                                $q->where('balance_qty', '>=', $request->min_stock ?? -9999);
                                            })
                                            ->when(request()->filled('max_stock'), function($q) use ($request) {
                                                $q->where('balance_qty', '<=', $request->max_stock ?? 999999999);
                                            })
                                            ->with('warehouse:id,name')
                                            ->with('product:id,name,code')
                                            ->with('productVariation:id,name')
                                            ->groupBy('product_id', 'product_variation_id')
                                            ->select('company_id', 'supplier_id', 'warehouse_id', 'product_id', 'product_variation_id', DB::Raw('Sum(`balance_qty`) as balance_qty'), DB::Raw('Sum(`total_stock_value`) as total_stock_value'));

        $data['totalAvailableStock']        = $stockInHands->get()->sum('balance_qty');
        $data['totalStockValue']            = $stockInHands->get()->sum('total_stock_value');
        $data['itemStocks']                 = $stockInHands->paginate(30);


        return view('reports/stock-in-hand', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | ALERT REPORT METHOD
     |--------------------------------------------------------------------------
    */
    public function productAlertReport(Request $request)
    {
        $data['categories']                 = Category::query()
                                                ->where('parent_id', null)
                                                ->with('childCategories')
                                                ->get(['id', 'name']);

        $data['warehouses']                 = Warehouse::query()
                                                ->when(auth()->user()->warehouse_id != '', function ($q) {
                                                    $q->where('id', auth()->user()->warehouse_id);
                                                })
                                                ->pluck('name', 'id');

        $data['products']                   = Product::query()
                                                ->whereHas('stockSummaries')
                                                ->with('productVariations:id,product_id,name')
                                                ->get(['id', 'name', 'code']);

        $data['productVariations']          = ProductVariation::query()
                                                ->whereHas('stockSummaries')
                                                ->get(['id', 'product_id', 'name', 'sku']);

        $categories_id                      = (new CategoryService)->getCategoryIds($request);

        $stockInHands                       = StockSummary::query()
                                                ->when($request->filled('warehouse_id'), function ($q) use ($request) {
                                                    $q->where('warehouse_id', $request->warehouse_id ?? optional(auth()->user())->warehouse_id);
                                                })
                                                ->when(request()->filled('category_id'), function($q) use ($categories_id) {
                                                    $q->whereHas('product', function ($q) use ($categories_id) {
                                                        $q->whereIn('category_id', $categories_id);
                                                    });
                                                })
                                                ->whereHas('product', function($q) use($request) {
                                                    $q->where('alert_quantity', '>', 0)
                                                    ->whereNotNull('alert_quantity');
                                                })
                                                ->searchByField('product_id')
                                                ->searchByField('product_variation_id')
                                                ->with('product:id,name,code,alert_quantity')
                                                ->with('productVariation:id,name')
                                                ->groupBy('product_id', 'product_variation_id')
                                                ->select('company_id', 'supplier_id', 'warehouse_id', 'product_id', 'product_variation_id', DB::Raw('Sum(`balance_qty`) as balance_qty'))

                                                ->withCount(["product as alert_quantity" => function($q) {
                                                    $q->select(DB::Raw('SUM(alert_quantity)'));
                                                }]);
        $data['itemStocks']                 = $stockInHands->get()->reject(function($item) {
                                                            return $item->alert_quantity <= $item->balance_qty;
                                                        });


        return view('reports/product-alert', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | PRODUCT EXPIRED REPORT
     |--------------------------------------------------------------------------
    */
    public function productExpiredReport(Request $request)
    {
        $data['categories']                 = Category::query()
                                                ->where('parent_id', null)
                                                ->with('childCategories')
                                                ->get(['id', 'name']);

        $data['warehouses']                 = Warehouse::query()
                                                ->when(auth()->user()->warehouse_id != '', function ($q) {
                                                    $q->where('id', auth()->user()->warehouse_id);
                                                })
                                                ->pluck('name', 'id');

        $data['products']                   = Product::query()
                                                ->whereHas('stockSummaries')
                                                ->with('productVariations:id,product_id,name')
                                                ->get(['id', 'name', 'code']);

        $data['productVariations']          = ProductVariation::query()
                                                ->whereHas('stockSummaries')
                                                ->get(['id', 'product_id', 'name', 'sku']);

        $categories_id                      = (new CategoryService)->getCategoryIds($request);

        if($request->filled('expired_type') && $request->expired_type == 'Manual') {
            $data['products'] = Product::whereNotNull('expired_note')
            ->when(request()->filled('category_id'), function($q) use ($categories_id) {
                $q->whereIn('category_id', $categories_id);
            })
            ->select(['id', 'name', 'expired_note'])
            ->get();
        } else {

            $expire_date = $request->expired_date ?? date('Y-m-d');

            $stockInHands                       = StockSummary::query()
                                                    ->when($request->filled('warehouse_id'), function ($q) use ($request) {
                                                        $q->where('warehouse_id', $request->warehouse_id ?? optional(auth()->user())->warehouse_id);
                                                    })
                                                    ->when(request()->filled('category_id'), function($q) use ($categories_id) {
                                                        $q->whereHas('product', function ($q) use ($categories_id) {
                                                            $q->whereIn('category_id', $categories_id);
                                                        });
                                                    })
                                                    ->searchByField('product_id')
                                                    ->searchByField('product_variation_id')
                                                    ->with('product:id,name,code,alert_quantity')
                                                    ->with('productVariation:id,name')
                                                    ->groupBy('product_id', 'product_variation_id')
                                                    ->select('company_id', 'supplier_id', 'warehouse_id', 'product_id', 'product_variation_id', DB::Raw('Sum(`balance_qty`) as balance_qty'))
                                                    ->withCount(['stocks as non_expired_qty' => function($q) use($expire_date) {
                                                        $q->where('expire_date', '>=', $expire_date)
                                                            ->where('stock_type', 'In')
                                                            ->select(DB::Raw('SUM(quantity)'));
                                                    }]);

            $data['itemStocks']                 = $stockInHands->get()->reject(function($item) {
                                                            return $item->non_expired_qty >= $item->balance_qty || $item->balance_qty < 1;
                                                        });

        }

        return view('reports/product-expired-report', $data);
    }







    /*
     |--------------------------------------------------------------------------
     | ITEM LEDGER
     |--------------------------------------------------------------------------
    */
    public function itemLedger(Request $request)
    {
        $data['categories']                 = Category::query()
                                            ->where('parent_id', null)
                                            ->with('childCategories')
                                            ->get(['id', 'name']);

        $data['warehouses']                 = Warehouse::query()
                                            ->when(auth()->user()->warehouse_id != '', function ($q) {
                                                $q->where('id', auth()->user()->warehouse_id);
                                            })
                                            ->pluck('name', 'id');

        $data['products']                   = Product::query()
                                            ->with('productVariations:id,product_id,name')
                                            ->get(['id', 'name', 'code', 'sku']);

        $data['productVariations']          = ProductVariation::pluck('name', 'id');

        $data['selectedItem']               = Product::query()
                                            ->when($request->filled('product_id'), function ($q) use ($request) {
                                                $q->where('id', $request->product_id);
                                            })
                                            ->first();

        $categories_id                      = (new CategoryService)->getCategoryIds($request);

        $data['itemStockDetails']           = Stock::query()
                                            ->when($request->filled('warehouse_id'), function ($q) use ($request) {
                                                $q->where('warehouse_id', $request->warehouse_id ?? optional(auth()->user())->warehouse_id);
                                            })
                                            ->when(request()->filled('category_id'), function($q) use ($categories_id) {
                                                $q->whereHas('product', function ($q) use ($categories_id) {
                                                    $q->whereIn('category_id', $categories_id);
                                                });
                                            })
                                            ->searchByField('product_id')
                                            ->searchByField('product_variation_id')
                                            ->dateFilter('date')
                                            ->paginate(50);

        return view('reports/item-ledger', $data);
    }







    /*
     |--------------------------------------------------------------------------
     | RECEIVABLE DUES
     |--------------------------------------------------------------------------
    */
    public function receivableDues()
    {
        $data['deliveryMans']       = DeliveryMan::get(['id', 'name', 'phone']);
        $data['warehouses']         = Warehouse::pluck('name', 'id');

        $receivableDues             = Order::query()
                                    ->receivableDue()
                                    ->where('order_source','!=', 'POS')
                                    ->searchByField('delivery_man_id')
                                    ->searchByField('warehouse_id')
                                    ->searchByField('date')
                                    ->searchByField('delivery_date')
                                    ->with('customer:id,name,mobile')
                                    ->with('deliveryMan:id,name,phone')
                                    ->with('warehouse:id,name')
                                    ->select('id', 'order_no', 'grand_total', 'customer_id', 'delivery_man_id', 'warehouse_id', 'date', 'delivery_date');

        $data['totalDueAmount']     = $receivableDues->sum('grand_total');

        $data['receivableDues']     = clone $receivableDues->orderBy('id', 'DESC')->paginate(30);

        $data['invoice1']       = optional(SystemSetting::find(5))->value;
        $data['invoice2']       = optional(SystemSetting::find(6))->value;

        return view('reports/receivable-dues', $data);
    }





      /*
     |--------------------------------------------------------------------------
     | MONTHLY ORDER
     |--------------------------------------------------------------------------
    */
    public function monthlyOrder(Request $request)
    {
        if (auth()->user()->type == 'Delivery Man') {
            $request->delivery_man_id = optional(auth()->user()->deliveryMan)->id;
        }

        $data['orders']         = Order::query()
                                ->when(isset($request->delivery_man_id), function ($q) use ($request) {
                                    $q->where('delivery_man_id', $request->delivery_man_id);
                                })
                                ->where('order_source','!=', 'POS')
                                ->searchByField('current_status')
                                ->searchByField('order_no')
                                ->searchByField('customer_id')
                                ->with('customer:id,name,mobile')
                                ->with('warehouse:id,name')
                                ->with('currentStatus:id,name')
                                ->with('timeSlot:id,starting_time,ending_time')
                                ->when($request->filled('date_type'), function($q) use ($request){
                                    $q->when(request()->filled('month'), function($qr) use($request) {
                                        $qr->where($request->date_type, 'like', (request('month')).'%');
                                     });
                                })
                                ->when(!$request->filled('date_type'), function($q) use ($request){
                                    $q->when(request()->filled('month'), function($qr) use($request) {
                                        $qr->where(function($q){
                                            $q->where('date', 'like', (request('month')).'%')
                                            ->orWhere('delivery_date', 'like', (request('month')).'%');
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
                                ->orderBy('id', 'DESC');

        $data['orders']         =  $data['orders']->paginate(30);
        $data['grandTotal']     =  $data['orders']->sum('grand_total');


        $data['customers']      = Customer::get(['id', 'name', 'mobile']);
        $data['statuses']       = Status::pluck('name', 'id');
        $data['districts']      = District::orderBy('name','ASC')->pluck('name', 'id');
        $data['areas']          = Area::orderBy('name','ASC')->pluck('name', 'id');



        return view('reports/monthly-order/index', $data);
    }


      /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function dailyOrder(Request $request)
    {
        if (auth()->user()->type == 'Delivery Man') {
            $request->delivery_man_id = optional(auth()->user()->deliveryMan)->id;
        }

        $data['orders']         = Order::query()
                                ->when(isset($request->delivery_man_id), function ($q) use ($request) {
                                    $q->where('delivery_man_id', $request->delivery_man_id);
                                })
                                ->where('order_source','!=', 'POS')
                                ->searchByField('current_status')
                                ->searchByField('order_no')
                                ->searchByField('customer_id')
                                ->with('customer:id,name,mobile')
                                ->with('warehouse:id,name')
                                ->with('currentStatus:id,name')
                                ->with('timeSlot:id,starting_time,ending_time')
                                ->when($request->filled('date_type'), function($q) use ($request){
                                    $q->when(request()->filled('date'), function($qr) use($request) {
                                        $qr->where($request->date_type, $request->date);
                                     });
                                })
                                ->when(!$request->filled('date_type'), function($q) use ($request){
                                    $q->when(request()->filled('date'), function($qr) use($request) {
                                        $qr->where(function($q) use($request){
                                            $q->where('date', $request->date)
                                            ->orWhere('delivery_date', $request->date);
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
                                ->orderBy('id', 'DESC');

        $data['orders']         =  $data['orders']->paginate(30);
        $data['grandTotal']     =  $data['orders']->sum('grand_total');


        $data['customers']      = Customer::get(['id', 'name', 'mobile']);
        $data['statuses']       = Status::pluck('name', 'id');
        $data['districts']      = District::orderBy('name','ASC')->pluck('name', 'id');
        $data['areas']          = Area::orderBy('name','ASC')->pluck('name', 'id');



        return view('reports/daily-order/index', $data);
    }
}
