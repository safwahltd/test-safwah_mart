<?php

namespace Module\Product\Controllers;

use Illuminate\Http\Request;
use Module\Product\Models\Brand;
use Module\Product\Models\Offer;
use Illuminate\Support\Facades\DB;
use Module\Product\Models\Product;
use Module\Product\Models\Category;
use App\Http\Controllers\Controller;
use Module\Product\Models\ProductType;
use Module\Product\Models\UnitMeasure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Module\Product\Models\ProductDiscount;
use App\Traits\CheckPermission;

class ProductDiscountController extends Controller
{
    private $service;
    use CheckPermission;



    /*
     |--------------------------------------------------------------------------
     | CONSTRUCTOR
     |--------------------------------------------------------------------------
    */
    public function __construct()
    {

    }












    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        $this->hasAccess("discounts.index");

        if(request()->filled('sync')) {
            $discounts = ProductDiscount::query()
                                    ->with(['product' => function($q) {
                                        $q->select('id', 'name', 'code', 'brand_id', 'category_id', 'unit_measure_id', 'sale_price');
                                    }])
                                    ->where('discount_percentage', '>', 0)->where('discount_flat', 0)
                                    ->get();

            foreach ($discounts as $key => $discountProduct) {
                $flat_discount = ($discountProduct->discount_percentage * $discountProduct->product->sale_price) / 100;


                $discountProduct->update(['discount_flat' => $flat_discount]);
            }
        }
        // $data['types']              = ProductType::pluck('name', 'id');
        $data['offers']             = Offer::pluck('name', 'id');
        $data['categories']         = Category::pluck('name', 'id');
        $data['products']           = Product::pluck('name', 'id');
        $data['brands']             = Brand::pluck('name', 'id');
        $data['discounts']          = ProductDiscount::query()
                                    ->searchByField('offer_id')
                                    ->whereHas('product', function ($q) {
                                        $q->searchByField('id')
                                        ->searchByField('product_type_id')
                                        ->searchByField('category_id')
                                        ->searchByField("brand_id");
                                    })
                                    ->with(['product' => function($q){
                                        $q->with('brand:id,name')
                                        ->with('category:id,name')
                                        ->with('unitMeasure:id,name')
                                        ->select('id', 'name', 'code', 'brand_id', 'category_id', 'unit_measure_id', 'sale_price');
                                    }])
                                    ->with('offer:id,name')
                                    ->paginate(30);

        $data['table']              = ProductDiscount::getTableName();



        return view('discount/index', $data);
    }













    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create(Request $request)
    {

        $this->hasAccess("discounts.create");

        if($request->is_axios == 'true')
        {
            return  Product::query()
                    ->whereDoesntHave('productDiscounts')
                    ->withSum('stockSummaries as current_stock', 'balance_qty')
                    ->with('category:id,name')
                    ->with('unitMeasure:id,name')
                    ->get(['id', 'name', 'code', 'sku', 'category_id', 'unit_measure_id', 'sale_price']);
        }

        $offer          = Offer::query()
                        ->when($request->filled('offer_id'), function ($q) use ($request) {
                            $q->where('id', $request->offer_id);
                        })
                        ->first();

        $data['offer_name'] = $offer ? $offer->name . ' Offer' : '';

        $data['offers'] = Offer::pluck('name', 'id');

        return view('discount/create', $data);
    }













    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'offer_id'              => 'required',
            'product_id.*'          => 'required',
            'discount_percentage'   => 'required',
            'start_date'            => 'required',
            'end_date'              => 'required',
        ]);


        try {
            foreach($request->product_id as $key => $id) {
                ProductDiscount::create([
                    'offer_id'            => $request->offer_id,
                    'product_id'          => $id,
                    'discount_percentage' => $request->discount_percentage[$key],
                    'discount_flat'       => $request->discount_flat[$key],
                    'start_date'          => $request->start_date[$key],
                    'end_date'            => $request->end_date[$key],
                    'show_in_offer'       => $request->show_in_offer[$key],
                ]);
            }
        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        return redirect()->route('discounts.index')->withMessage('Discount has been Added Successfully.');
    }













    /*
     |--------------------------------------------------------------------------
     | SHOW METHOD
     |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        # code...
    }













    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $this->hasAccess("discounts.edit");

        $data['offers']     = Offer::pluck('name', 'id');
        $data['discount']   = ProductDiscount::with('product:id,name,code,sale_price')->with('offer:id,name')->find($id);

        return view('discount/edit', $data);
    }













    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update($id, Request $request)
    {
        $discount = ProductDiscount::find($id);

        $request->validate([
            'offer_id'              => 'required',
            'discount_percentage'   => 'required',
            'start_date'            => 'required',
            'end_date'              => 'required',
        ]);

        try {

            $discount->update([
                'offer_id'            => $request->offer_id,
                'discount_percentage' => $request->discount_percentage,
                'discount_flat'       => $request->discount_flat,
                'start_date'          => $request->start_date,
                'end_date'            => $request->end_date,
                'show_in_offer'       => $request->show_in_offer ? 1 : 0,
            ]);

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        return redirect()->route('discounts.index')->withMessage('Discount has been Updated Successfully.');
    }












    /*
     |--------------------------------------------------------------------------
     | DELETE/DESTORY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $this->hasAccess("discounts.delete");

        try {

            ProductDiscount::destroy($id);

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        return redirect()->back()->withMessage('Discount has been Deleted Successfully');
    }
}
