<?php

namespace Module\Product\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;
use Module\Product\Models\Barcode;
use Module\Product\Models\Attribute;
use Module\Product\Models\ProductImage;

class ProductVariation extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'pdt_product_variations';






    /*
     |--------------------------------------------------------------------------
     | PRODUCT (METHOD)
     |--------------------------------------------------------------------------
    */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }





    /*
     |--------------------------------------------------------------------------
     | PRODUCT IMAGES (METHOD)
     |--------------------------------------------------------------------------
    */
    public function productImages()
    {
        return $this->morphMany(ProductImage::class, 'sourcable');
    }




    public function productVariationImages()
    {
        return $this->hasMany(ProductImage::class, 'sourcable_id')->where(function ($q) {
            $q->where('sourcable_type', 'Product Variation')
            ->orWhere('sourcable_type', 'Product Opening By Product Variation');
        });
    }





    /*
     |--------------------------------------------------------------------------
     | ATTRIBUTES (METHOD)
     |--------------------------------------------------------------------------
    */
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }





    /*
     |--------------------------------------------------------------------------
     | STOCKS (METHOD)
     |--------------------------------------------------------------------------
    */
    public function stocks()
    {
        return $this->morphMany(Stock::class, 'stockable');
    }





    /*
     |--------------------------------------------------------------------------
     | OPENING STOCK (METHOD)
     |--------------------------------------------------------------------------
    */
    public function openingStock()
    {
        return $this->hasOne(Stock::class, 'stockable_id')->where(function ($q) {
            $q->where('stockable_type', 'Product Opening By Product Variation')
            ->orWhere('stockable_type', 'Product Variation');
        });
    }





    /*
     |--------------------------------------------------------------------------
     | STOCK SUMMARIES (METHOD)
     |--------------------------------------------------------------------------
    */
    public function stockSummaries()
    {
        return $this->hasMany(StockSummary::class, 'product_variation_id');
    }




    
    /*
     |--------------------------------------------------------------------------
     | BARCODE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function barcode()
    {
        return $this->hasOne(Barcode::class, 'product_variation_id');
    }




    public function attributeProductVariations()
    {
        return $this->hasMany(AttributeProductVariation::class, 'product_variation_id');
    }




    public function productVariationAttributes()
    {
        return $this->hasMany(ProductVariationAttribute::class, 'product_variation_id');
    }

    /*
     |--------------------------------------------------------------------------
     | PURCHASE DETAILS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class, 'product_id');
    }




    /*
     |--------------------------------------------------------------------------
     | SALE DETAILS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class, 'product_id');
    }



    
    /*
     |--------------------------------------------------------------------------
     | ORDER RETURN DETAILS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function orderReturnDetails()
    {
        return $this->hasMany(OrderReturnDetail::class, 'product_id');
    }
    
    
    
    
    /*
     |--------------------------------------------------------------------------
     | ORDER DETAILS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id');
    }
}
