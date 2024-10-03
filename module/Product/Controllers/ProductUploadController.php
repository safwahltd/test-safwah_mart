<?php

namespace Module\Product\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Module\Account\Models\Supplier;
use App\Http\Controllers\Controller;
use Module\Product\Models\ProductType;
use Module\Product\Models\UnitMeasure;
use Module\Product\Models\ProductUpload;
use Module\Product\Services\ProductUploadService;

class ProductUploadController extends Controller
{
    private $service;

    /*
     |--------------------------------------------------------------------------
     | CONSTRUCTOR
     |--------------------------------------------------------------------------
    */
    public function __construct(ProductUploadService $productService)
    {
        $this->service = $productService;
    }








    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {       
        $data['products']   = ProductUpload::latest()->paginate(50);
        return view('product-uploads/index', $data);
    }

 











    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $data = [];
        return view('product-uploads/create', $data);
    }













    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        try {
            $this->service->store();
        }  catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        return redirect()->back()->withMessage('Product added successfully !');    }
    












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
        $data['product']            = ProductUpload::find($id);
        $data['units']              = UnitMeasure::pluck('name', 'id');                 
        $data['suppliers']          = Supplier::pluck('name', 'id');
        $data['countries']          = Country::pluck('name', 'id');
        $data['productType'] = ProductType::query()
                                     ->where(function ($q) use ($data) {
                                         $q->where('id', $data['product']->product_type)
                                         ->orWhere('name', $data['product']->product_type);
                                     })
                                     ->with('categories:id,name,product_type_id')
                                     ->with('brands:id,name,product_type_id')
                                     ->first();
        
        return view('product-uploads/edit', $data);
    }













    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update($id, Request $request)
    {
        $product = ProductUpload::find($id);
        $product->update([
                'product_type'        => $request->product_type,
                'category'            => $request->category,
                'brand'               => $request->brand,
                'unit_measure'        => $request->unit_measure,
                'supplier'            => $request->supplier,
                'country'             => $request->country,
                'name'                => $request->name,
                'slug'                => $request->slug,
                'code'                => $request->code,
                'purchase_price'      => $request->purchase_price,
                'sale_price'          => $request->sale_price,
                'weight'              => $request->weight,
                'is_variation'        => $request->is_variation ? 'Yes':'No',
                'vat_applicable'      => $request->vat_applicable ? 'Yes':'No',
                'is_refundable'       => $request->is_refundable ? 'Yes':'No',
                'is_highlight'        => $request->is_highlight ? 'Yes':'No',
                'opening_quantity'    => $request->opening_quantity,
                'warehouse_id'        => $request->warehouse_id,
        ]);
        
        return redirect()->route('pdt.product-uploads.index')->withMessage('Product added successfully !');    
    }












    /*
     |--------------------------------------------------------------------------
     | DELETE/DESTORY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        ProductUpload::find($id)->delete();

        return redirect()->back()->withMessage('Product delete successfully !');

    }
}
