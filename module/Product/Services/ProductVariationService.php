<?php

namespace Module\Product\Services;

use App\Traits\FileSaver;
use Module\Product\Models\Attribute;
use Module\Product\Services\NextBarcodeService;
use Module\Product\Models\ProductVariationAttribute;

class ProductVariationService
{
    use FileSaver;





    public $productVariation;
    public $nextBarcodeService;
    public $stockService;










    /*
     |--------------------------------------------------------------------------
     | CONSTRUCTOR
     |--------------------------------------------------------------------------
    */
    public function __construct()
    {
        $this->stockService                 = new StockService;
        $this->nextBarcodeService           = new NextBarcodeService;
    }










    /*
     |--------------------------------------------------------------------------
     | PRODUCT VARIATION STORE (METHOD)
     |--------------------------------------------------------------------------
    */
    public function productVariationStore($request, $product)
    {
        foreach ($request->variation_sku as $key => $variation_sku) {

            $id = explode(',', $request->product_variation_id[$key]);


            // CREATE PRODUCT VARIATION
            $variation  = $product->productVariations()->updateOrCreate(
                ['sku'                   => $variation_sku],
                [
                    'name'            => $request->variation_name[$key],
                    'purchase_price'  => $request->variation_purchase_price[$key],
                    'wholesale_price' => $request->variation_wholesale_price[$key],
                    'sale_price'      => $request->variation_sale_price[$key],
                    'expired_date'    => $request->expired_dates[$key],
                ]
            );


            // SYNC ATTRIBUTE PRODUCT VARIATION
            if ($request->is_sync[$key] == 'Yes') {

                foreach ($id as $value) {
                    $attribute_type_id = Attribute::where('id', $value)->first()->attribute_type_id;

                    ProductVariationAttribute::create([
                        'product_id'            => $product->id,
                        'product_variation_id'  => $variation->id,
                        'attribute_type_id'     => $attribute_type_id,
                        'attribute_id'          => $value,
                    ]);
                }
            }


            if ($request->variation_opening_stock[$key] > 0 && $request->is_sync[$key] == 'Yes' && $request->warehouse_id != '') {

                // STORE STOCK
                $this->stockService->storeStock($variation, optional(auth()->user())->company_id ?? 1, null, $request->warehouse_id, $product->id, $variation->id, $request->variation_lot[$key] ?? 'N/A', null, date('Y-m-d'), 'In', $request->variation_purchase_price[$key], $request->variation_sale_price[$key], $request->variation_opening_stock[$key], $variation->expired_date);

                // UPDATE OR CREATE STOCK SUMMARY
                $this->stockService->updateOrCreateStockSummary(optional(auth()->user())->company_id ?? 1, null, $request->warehouse_id, $product->id, $variation->id, $request->variation_lot[$key] ?? 'N/A', null, $request->variation_opening_stock[$key], 0, $request->variation_purchase_price[$key] * $request->variation_opening_stock[$key], 0);
            }

            // dd($request->all());


            // STORE AND UPLOAD VARIATION MULTIPLE IMAGES
            if ($request->has('variation_image_' . $key)) {

                $variation_images = request('variation_image_' . $key);

                foreach ($variation_images as $image) {

                    if ($image != null) {
                        $variationImage = $variation->productImages()->create(['image' => 'default.png']);

                        $this->uploadFileWithResize($image, $variationImage, 'image', 'images/product/variation');
                    }
                }
            }


            if ($request->has('multiple_variation_img_' . $key)) {

                $variation_images = request('multiple_variation_img_' . $key);
                $parent_ids = request('multiple_variation_img_parent_id_' . $key);

                foreach ($variation_images as $key => $image) {

                    if ($image != null) {
                        $variationImage = $variation->productImages()->create([
                            'parent_source_id' => $parent_ids[$key],
                            'image' => $image,
                        ]);
                    }
                }
            }
        }
    }
}
