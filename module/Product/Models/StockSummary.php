<?php

namespace Module\Product\Models;
use App\Model;
use App\Models\Company;
use Module\Product\Models\Stock;
use Module\Account\Models\Supplier;
use Module\Inventory\Models\Warehouse;
use Module\Product\Models\Product;

class StockSummary extends Model
{
    protected $guarded = [];

    protected $table = 'pdt_stock_summaries';





    /*
     |--------------------------------------------------------------------------
     | COMPANY (RELATION)
     |--------------------------------------------------------------------------
    */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }





    /*
     |--------------------------------------------------------------------------
     | SUPPLIER (RELATION)
     |--------------------------------------------------------------------------
    */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'company_id');
    }





    /*
     |--------------------------------------------------------------------------
     | WAREHOUSE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }





    /*
     |--------------------------------------------------------------------------
     | PRODUCT (RELATION)
     |--------------------------------------------------------------------------
    */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }





    /*
     |--------------------------------------------------------------------------
     | PRODUCT VARIATION (RELATION)
     |--------------------------------------------------------------------------
    */
    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'product_id', 'product_id');
    }

}
