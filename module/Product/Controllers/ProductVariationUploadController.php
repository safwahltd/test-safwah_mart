<?php

namespace Module\Product\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Module\Product\Models\ProductDetailUpload;

class ProductVariationUploadController extends Controller
{
    private $service;


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
        $data['products']   = ProductDetailUpload::latest()->paginate(50);
        return view('variation-uploads/index', $data);
    }













    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $data = [];
        return view('', $data);
    }













    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        # code...
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
        $data['variation'] = ProductDetailUpload::find($id);
        return view('variation-uploads/edit', $data);
    }













    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update($id, Request $request)
    {
        $variation = ProductDetailUpload::find($id);

        $variation->update([
            'product_upload_id'    => $request->product_upload_id,
            'name'                 => $request->name,
            'purchase_price'       => $request->purchase_price,
            'sale_price'           => $request->sale_price,
            'opening_stock'        => $request->opening_stock,
            'warehouse_id'         => $request->warehouse_id,

        ]);

        return redirect()->route('pdt.product-variation-uploads.index')->withMessage('Product added successfully !');    

    }












    /*
     |--------------------------------------------------------------------------
     | DELETE/DESTORY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        ProductDetailUpload::find($id)->delete();

        return redirect()->back()->withMessage('Product delete successfully !');    }
}
