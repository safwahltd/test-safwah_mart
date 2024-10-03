<?php

namespace Module\Product\Services;
use Module\Product\Models\Barcode;
use Module\Product\Models\Product;
use Mews\Purifier\Facades\Purifier;
use Module\product\Models\ProductTag;
use Module\Product\Models\ProductUser;
use Module\Product\Models\ProductVariation;
use Module\Product\Models\ProductMeasurement;
use Module\Product\Models\ProductHighlightType;
use Module\Product\Services\NextBarcodeService;

class ProductService
{
    public $product;
    private $nextBarcodeService;










    /*
     |--------------------------------------------------------------------------
     | CONSTRUCTOR
     |--------------------------------------------------------------------------
    */
    public function __construct()
    {
        $this->nextBarcodeService           = new NextBarcodeService;
    }










    /*
     |--------------------------------------------------------------------------
     | PRODUCT INDEX
     |--------------------------------------------------------------------------
    */

    public function index(){

        $product        = Product::likeSearch('name')
                         ->searchByField('product_type_id')
                         ->searchByField('category_id')
                         ->searchByField('brand_id')
                         ->latest()
                         ->paginate(50);
        return $product;

    }










    /*
     |--------------------------------------------------------------------------
     | PRODUCT STORE (METHOD)
     |--------------------------------------------------------------------------
    */
    public function productStore($request)
    {
        return Product::create([
            'product_type_id'           => $request->product_type_id,
            'category_id'               => $request->category_id,
            'brand_id'                  => $request->brand_id,
            'unit_measure_id'           => $request->unit_measure_id,
            'country_id'                => $request->country_id,
            'name'                      => $request->name,
            'slug'                      => $request->slug,
            'code'                      => $request->code,
            'sku'                       => $request->sku,
            'sub_text'                  => $request->sub_text,
            'weight'                    => $request->weight ?? 0,
            'alert_quantity'            => $request->alert_quantity ?? 0,
            'maximum_order_quantity'    => $request->maximum_order_quantity ?? 0,
            'manufacture_barcode'       => $request->manufacture_barcode,
            'manufacture_model_no'      => $request->manufacture_model_no,
            'barcode'                   => $request->barcode,
            'is_variation'              => !empty($request->is_variation) ? 'Yes' : 'No',
            'is_refundable'             => !empty($request->is_refundable) ? 'Yes' : 'No',
            'status'                    => !empty($request->status) ? 1 : 0,
            'sub_text_visible'          => !empty($request->sub_text_visible) ? 1 : 0,
            'stock_visible'             => !empty($request->stock_visible) ? 1 : 0,
        ]);
    }






    public function productUpdate($request, $product)
    {
        $is_refundable    = (!empty($request->is_refundable) && $request->basic_information == 'Yes') ? "Yes" : (($request->is_refundable == null && $request->basic_information == 'Yes') ? 'No' : $product->is_refundable);
        $sub_text_visible = (!empty($request->sub_text_visible) && $request->basic_information == 'Yes') ? 1 : (($request->sub_text_visible == null && $request->basic_information == 'Yes') ? 0 : $product->sub_text_visible);
        $stock_visible    = (!empty($request->stock_visible) && $request->basic_information == 'Yes') ? 1 : (($request->stock_visible == null && $request->basic_information == 'Yes') ? 0 : $product->stock_visible);
        $status           = (!empty($request->status) && $request->basic_information == 'Yes') ? 1 : (($request->status == null && $request->basic_information == 'Yes') ? 0 : $product->status);

        $product->update([
            'product_type_id'        => $request->product_type_id ?? $product->product_type_id,
            'category_id'            => $request->category_id ?? $product->category_id,
            'brand_id'               => $request->brand_id ?? $product->brand_id,
            'unit_measure_id'        => $request->unit_measure_id ?? $product->unit_measure_id,
            'supplier_id'            => $request->supplier_id ?? $product->supplier_id,
            'country_id'             => $request->country_id ?? $product->country_id,
            'name'                   => $request->name ?? $product->name,
            'slug'                   => $request->slug ?? $product->slug,
            'code'                   => $request->code ?? $product->code,
            'sku'                    => $request->sku ?? $product->sku,
            'alt_text'               => $request->alt_text ?? $product->alt_text,
            'meta_title'             => $request->meta_title ?? $product->meta_title,
            'meta_description'       => $request->meta_description ?? $product->meta_description,
            'sub_text'               => $request->sub_text ?? $product->sub_text,
            'purchase_price'         => $request->purchase_price ?? $product->purchase_price,
            'wholesale_price'        => $request->wholesale_price ?? $product->wholesale_price,
            'sale_price'             => $request->sale_price ?? $product->sale_price,
            'discount_percentage'    => $request->discount_percentage ?? $product->discount_percentage,
            'discount_flat'          => $request->discount_flat ?? $product->discount_flat,
            'weight'                 => $request->weight ?? $product->weight,
            'alert_quantity'         => $request->alert_quantity ?? $product->alert_quantity,
            'maximum_order_quantity' => $request->maximum_order_quantity ?? $product->maximum_order_quantity,
            'is_variation'           => $product->is_variation,
            'is_refundable'          => $is_refundable,
            'manufacture_barcode'    => $request->manufacture_barcode ?? $product->manufacture_barcode,
            'manufacture_model_no'   => $request->manufacture_model_no ?? $product->manufacture_model_no,
            'vat'                    => $request->vat ?? $product->vat,
            'vat_type'               => $request->vat_type ?? $product->vat_type,
            'barcode'                => $request->barcode ?? $product->barcode,
            'status'                 => $status,
            'sub_text_visible'       => $sub_text_visible,
            'stock_visible'          => $stock_visible,
            'short_description'      => $request->short_description ?? $product->short_description,
            'description'            => $request->description ?? $product->description,
            'expired_note'           => isset($request->expired_note) ? $request->expired_note : $product->expired_note,
        ]);

        if($request->next_tab == 'advance') {
            $product->update(['video_link' => $request->video_link]);
        }
    }




    /*
     |--------------------------------------------------------------------------
     | PRODUCT PRODUCT TAG STORE
     |--------------------------------------------------------------------------
    */
    public function productTagStore($request, $product)
    {
        $product->productTags()->delete();

        foreach($request->tag_id ?? [] as $tag_id) {

            $product->productTags()->create([
                'tag_id' => $tag_id,
            ]);
        }
    }






    /*
     |--------------------------------------------------------------------------
     | PRODUCT TAG STORE
     |--------------------------------------------------------------------------
    */
    public function productHighlightTypeStore($request, $product)
    {
        $product->productHighlightTypes()->delete();

        foreach($request->highlight_type_id ?? [] as $highlight_type_id) {

            $product->productHighlightTypes()->create([
                'highlight_type_id'=> $highlight_type_id,
            ]);
        }
    }






    /*
     |--------------------------------------------------------------------------
     | PRODUCT USER ASSIGN
     |--------------------------------------------------------------------------
    */
    public function productUserStore($request, $product)
    {
        $product->productUsers()->delete();

        foreach($request->user_id ?? [] as $user_id) {

            $product->productUsers()->create([
                'user_id' => $user_id,
            ]);
        }
    }






    /*
     |--------------------------------------------------------------------------
     | PRODUCT UPDATE
     |--------------------------------------------------------------------------
    */
    public function updateProduct()
    {

        $request = request();

        $product = Product::find($request->id);

        $product->update([
            'category_id'        => $request->category_id,
            'brand_id'           => $request->brand_id,
            'unit_measure_id'    => $request->unit_measure_id,
            'supplier_id'        => $request->supplier_id,
            'country_id'         => $request->country_id,
            'name'               => $request->name,
            'slug'               => $request->slug,
            'purchase_price'     => $request->purchase_price ?? 0,
            'sale_price'         => $request->sale_price ?? 0,
            'vat_applicable'     => !empty($request->vat_applicable) ? 'Yes' : 'No',
            'weight'             => $request->weight,
            'code'               => $request->code,
            'description'        => $request->description,
            'is_refundable'      => !empty($request->is_refundable) ? 'Yes' : 'No',
            'status'             => !empty($request->status) ? 1 : 0,
            'is_highlight'       => !empty($request->is_highlight) ? 'Yes' : 'No',
        ]);

        return $product;
    }








    /*
     |--------------------------------------------------------------------------
     | GET PRODUCTS BY CATEGORY
     |--------------------------------------------------------------------------
    */
    public function getProductsByCategory($request)
    {
        $categories_id = (new CategoryService)->getCategoryIds($request);

        return  Product::query()
                ->with('productVariations:id,product_id,name')
                ->whereIn('category_id', $categories_id)
                ->get(['id', 'name', 'code']);
    }








    /*
     |--------------------------------------------------------------------------
     | GET VARIATIONS BY PRODUCT
     |--------------------------------------------------------------------------
    */
    public function getVariationsByProduct($request)
    {
        return  ProductVariation::query()
                ->when(request()->filled('product_id'), function($qr) use($request) {
                    $qr->where('product_id', $request->product_id);
                })
                ->get(['id', 'name']);
    }










    /*
     |--------------------------------------------------------------------------
     | PRODUCT MEASUREMENTS STORE (METHOD)
     |--------------------------------------------------------------------------
    */
    public function productMeasurementsStore($request, $product)
    {
        $product->productMeasurements()->delete();

        foreach ($request->product_measurement_sku as $key => $sku) {

            $product->productMeasurements()->create([
                'sku'           => $sku,
                'value'         => $request->product_measurement_value[$key],
                'title'         => $request->product_measurement_title[$key],
            ]);
        }
    }
}
