<?php

namespace Module\Product\Services;

use App\Models\Country;
use App\Models\Supplier;
use App\Traits\FileSaver;
use Module\Product\Models\Brand;
use Illuminate\Support\Facades\DB;
use Module\Product\Models\Product;
use Module\Product\Models\Category;
use Module\Product\Models\Attribute;
use Module\Product\Models\ProductType;
use Module\Product\Models\UnitMeasure;
use Module\Product\Models\ProductUpload;
use Module\Product\Services\StockService;

class ProductUploadService
{
    use FileSaver;

    public $product;
    private $stockService;

   /*
     |--------------------------------------------------------------------------
     | CONSTRUCTOR
     |--------------------------------------------------------------------------
    */
    public function __construct()
    { 
        // $this->productVariationService      = new ProductVariationService;
        $this->stockService                 = new StockService;
    }
    /*
     |--------------------------------------------------------------------------
     | STORE/UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function store()
    {

        $products = ProductUpload::with('productDetailUpload')->take(100)->get();

       

        foreach ($products as $key => $product) {

            try{
                DB::transaction(function () use ($product) {
                    $newProduct = $this->product = Product::create([
                                    'product_type_id'       => $this->getId(ProductType::query(), $product->product_type),
                                    'category_id'           => $this->getOrCreateId('Module\Product\Models\Category', $product->category, $product->product_type),
                                    'brand_id'              => $this->getOrCreateId('Module\Product\Models\Brand', $product->brand, $product->product_type),
                                    'unit_measure_id'       => $this->getOrCreateId('Module\Product\Models\UnitMeasure', $product->unit_measure, 0),
                                    'supplier_id'           => $this->getId(Supplier::query(), $product->supplier),
                                    'country_id'            => $this->getId(Country::query(), $product->country),
                                    'name'                  => $product->name,
                                    'slug'                  => $product->slug,
                                    'purchase_price'        => $product->purchase_price ?? 0,
                                    'wholesale_price'       => $product->wholesale_price ?? 0,
                                    'sale_price'            => $product->sale_price ?? 0,
                                    'weight'                => $product->weight,
                                    'alert_quantity'        => $product->alert_quantity ?? 0,

                                    'maximum_order_quantity'=> $product->maximum_order_quantity ?? 0,
                                    'video_link'            => $product->video_link,
                                    'manufacture_barcode'   => $product->manufacture_barcode,
                                    'manufacture_model_no'  => $product->manufacture_model_no,
                                    'vat'                   => $product->vat ?? 0,
                                    'vat_type'              => $product->vat_type ?? null, 
                                    'stock_visible'         => $product->stock_visible,

                                    'is_variation'          => $product->is_variation,
                                    'is_refundable'         => $product->is_refundable,
                                    'status'                => 1,

                                ]);

                    if ($product->is_variation == 'No' && (int) $product->opening_quantity > 0 && $product->warehouse_id != '') {
                        // STORE STOCK
                        $this->stockService->storeStock($newProduct, optional(auth()->user())->company_id, null, $product->warehouse_id, $product->id, null, 'N/A', null, date('Y-m-d'), 'In', $product->purchase_price, $product->sale_price, $product->opening_quantity, null);

                        
                        // UPDATE OR CREATE STOCK SUMMARY
                        $this->stockService->updateOrCreateStockSummary(optional(auth()->user())->company_id, null, $product->warehouse_id, $newProduct->id, null, 'N/A', null, $product->opening_quantity, 0, $product->purchase_price * $product->opening_quantity, 0);
                    }

                    if ($product->is_variation == 'Yes'){
                    
                        $this->StoreVariation($product, $newProduct);
                    }

                    $product->delete();
                });
            } catch(\Exception $ex) {
                continue;
            }
        }
    }

    public function getId($ModelName, $name){
        if($name != null){
            if (is_numeric($name)) {
                return $name;
            } else {
                $data = $ModelName->where('name', $name)->first();
                if($data){
                    return $data->id;
                }else{
                    return null;
                }
    
            }
        }
    }
    public function getOrCreateId($ModelName, $name, $productType){
        // return $name;

        if (is_numeric($name) || $name == null) {
            if($name == 0){
                return null;
            }
            // if(gettype($name) != 'integer'){
            //     return null;
            // }
            return $name;
        } else {

            if($productType != '0'){

                $productTypeId = $this->getId(ProductType::query(), $productType);

                return $ModelName::firstOrCreate([
                    'product_type_id' => $productTypeId,
                    'name'            => $name,
                    'slug'            => $this->createSlug($name),
                    'created_by'      => auth()->user()->id,
                ])->id;

            }else{

                    return $ModelName::firstOrCreate([
                        'name'       => $name,
                        'created_by' => 1,
                    ])->id;
                
            }
            
        }
    
    }


    public function storeVariation($product, $newProduct){

        foreach ($product->productDetailUpload as $key => $item) {

            $names = explode(',', $item->name);
            $id   = [];
            $addVariation = 'true';
            foreach($names as $name){

                $attributrId = $this->getId(Attribute::query(), trim($name));
    
                if($attributrId != null){
                    array_push($id, $attributrId);
                }else{
                    $addVariation = 'false';
                }
            }

            if($addVariation != 'false'){

                $variation  = $newProduct->productVariations()->updateOrCreate(
                            [   'sku'                   => generateSKU()   ],
                            [
                                'name'                  => $item->name,
                                'purchase_price'        => $item->purchase_price,
                                'sale_price'            => $item->sale_price,
                            ]);
                if ($item->opening_stock > 0 && $item->warehouse_id != '') {

                    // STORE STOCK
                    $this->stockService->storeStock($variation, optional(auth()->user())->company_id, null, $item->warehouse_id, $product->id, $variation->id, 'N/A', null, date('Y-m-d'), 'In', $item->purchase_price, $item->sale_price, $item->opening_stock, null);
                    



                    
                    // UPDATE OR CREATE STOCK SUMMARY
                    $this->stockService->updateOrCreateStockSummary(optional(auth()->user())->company_id, null, $item->warehouse_id, $product->id, $variation->id, 'N/A', null, $item->opening_stock, 0, $item->purchase_price * $item->opening_stock, 0);
                }
                $variation->attributes()->sync($id);
            }
        }
    }


    public static function createSlug($str, $delimiter = '-'){

        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
    
    }
}
