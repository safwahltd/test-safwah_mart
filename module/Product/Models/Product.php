<?php

namespace Module\Product\Models;

use App\Model;
use App\Models\Country;
use Module\Product\Models\Brand;
use App\Traits\AutoCreatedUpdated;
use Module\Account\Models\Supplier;
use Module\Product\Models\Category;
use Module\Product\Models\ProductType;
use Module\Product\Models\ProductTag;
use Module\Product\Models\ProductAttribute;
use Module\Product\Models\ProductVariation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Module\Inventory\Models\OrderDetail;
use Module\Inventory\Models\OrderReturnDetail;
use Module\Inventory\Models\PurchaseDetail;
use Module\Inventory\Models\SaleDetail;
use Module\WebsiteCMS\Models\Wishlist;

class Product extends Model
{
    use AutoCreatedUpdated, HasFactory;

    protected $table = 'pdt_products';


    /*
     |--------------------------------------------------------------------------
     | BOOK PRODUCTS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function bookProducts()
    {
        return $this->hasMany(BookProduct::class);
    }


    /*
     |--------------------------------------------------------------------------
     | API QUERY (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeApiQuery($query)
    {
        $query->active();
    }





    /*
     |--------------------------------------------------------------------------
     | NO VARIATION (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeNoVariation($query)
    {
        $query->where('is_variation', 'No');
    }





    /*
     |--------------------------------------------------------------------------
     | PRODUCT ATTRIBUTE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function productAttribute()
    {
        return $this->hasOne(ProductAttribute::class);
    }





    /*
     |--------------------------------------------------------------------------
     | PRODUCT VARIATIONS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function productVariations()
    {
        return $this->hasMany(ProductVariation::class);
    }





    /*
     |--------------------------------------------------------------------------
     | PRODUCT TYPE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }





    /*
     |--------------------------------------------------------------------------
     | CATEGORY (RELATION)
     |--------------------------------------------------------------------------
    */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }





    /*
     |--------------------------------------------------------------------------
     | UNIT MEASURE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function unitMeasure()
    {
        return $this->belongsTo(UnitMeasure::class);
    }





    /*
     |--------------------------------------------------------------------------
     | PRODUCT MEASUREMENTS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function productMeasurements()
    {
        return $this->hasMany(ProductMeasurement::class, 'product_id');
    }





    /*
     |--------------------------------------------------------------------------
     | BRAND (RELATION)
     |--------------------------------------------------------------------------
    */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }





    /*
     |--------------------------------------------------------------------------
     | SUPPLIER (RELATION)
     |--------------------------------------------------------------------------
    */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }





    /*
     |--------------------------------------------------------------------------
     | COUNTRY (RELATION)
     |--------------------------------------------------------------------------
    */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }





    /*
     |--------------------------------------------------------------------------
     | STOCKS (MORPH RELATION)
     |--------------------------------------------------------------------------
    */
    public function stocks()
    {
        return $this->morphMany(Stock::class, 'stockable');
    }





    /*
     |--------------------------------------------------------------------------
     | PRODUCT STOCKS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function productStocks()
    {
        return $this->hasMany(Stock::class);
    }





    /*
     |--------------------------------------------------------------------------
     | STOCK REQUESTS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function stock_requests()
    {
        return $this->hasMany(StockRequest::class);
    }





    /*
     |--------------------------------------------------------------------------
     | OPENING STOCK (RELATION)
     |--------------------------------------------------------------------------
    */
    public function openingStock()
    {
        return $this->hasOne(Stock::class, 'stockable_id')->where('stockable_type', 'Product Opening By Product');
    }





    /*
     |--------------------------------------------------------------------------
     | STOCK SUMMARIES (RELATION)
     |--------------------------------------------------------------------------
    */
    public function stockSummaries()
    {
        return $this->hasMany(StockSummary::class, 'product_id');
    }



 /*
     |--------------------------------------------------------------------------
     | GET ONLY STOCK FROM STOCK SUMMARIES (RELATION)
     |--------------------------------------------------------------------------
    */
    public function getStock()
    {
        return $this->hasMany(StockSummary::class, 'product_id')->sum('balance_quantity');
    }


    /*
     |--------------------------------------------------------------------------
     | PRODUCT DISCOUNTS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function productDiscounts()
    {
        return $this->hasMany(ProductDiscount::class);
    }





    /*
     |--------------------------------------------------------------------------
     | BARCODE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function barcode()
    {
        return $this->hasOne(Barcode::class, 'product_id');
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





    /*
     |--------------------------------------------------------------------------
     | CURRENT DISCOUNT (RELATION)
     |--------------------------------------------------------------------------
    */
    public function currentDiscount()
    {
        return $this->hasOne(ProductDiscount::class, 'product_id');
    }





    /*
     |--------------------------------------------------------------------------
     | DISCOUNT (RELATION)
     |--------------------------------------------------------------------------
    */
    public function discount()
    {
        return $this->hasOne(ProductDiscount::class)->orderBy('id', 'DESC')->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->where('status', 1);
    }





    /*
     |--------------------------------------------------------------------------
     | PRODUCT HIGHLIGHT TYPES (RELATION)
     |--------------------------------------------------------------------------
    */
    public function productHighlightTypes()
    {
        return $this->hasMany(ProductHighlightType::class, 'product_id');
    }


    /*
     |--------------------------------------------------------------------------
     | PRODUCT HIGHLIGHT TYPES (RELATION)
     |--------------------------------------------------------------------------
    */
    public function productUsers()
    {
        return $this->hasMany(ProductUser::class, 'product_id');
    }





    /*
     |--------------------------------------------------------------------------
     | PRODUCT HIGHLIGHT TYPES (RELATION)
     |--------------------------------------------------------------------------
    */
    public function productTags()
    {
        return $this->hasMany(ProductTag::class, 'product_id');
    }



  /*
     |--------------------------------------------------------------------------
     | PRODUCT REVIEWS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
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



    /*
     |--------------------------------------------------------------------------
     | BOOK PRODUCT (RELATION)
     |--------------------------------------------------------------------------
    */
    public function bookProduct()
    {
        return $this->hasOne(BookProduct::class, 'product_id');
    }



    public function getImageAttribute()
    {
        $image = $this->attributes['image'];

        if (file_exists(public_path($image))) {
            return $image;
        }else{
            return 'default-img.jpg';
        }

    }




    public function productVariationAttributes()
    {
        return $this->hasMany(ProductVariationAttribute::class, 'product_id');
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
     | WISHLIST (RELATION)
     |--------------------------------------------------------------------------
    */
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    // public function getThumbnailImageAttribute()
    // {
    //     return asset($this->attributes['thumbnail_image']);
    // }

     public function getProductThumbnailImageAttribute()
    {
        return asset($this->attributes['thumbnail_image']);
    }


}
