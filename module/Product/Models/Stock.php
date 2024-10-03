<?php

namespace Module\Product\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;
use Module\Inventory\Models\Warehouse;
use Module\Inventory\Models\SaleDetail;
use Module\Inventory\Models\PurchaseDetail;
use Illuminate\Database\Eloquent\Relations\Relation;
use Module\Inventory\Models\OrderDetail;
use Module\Inventory\Models\OrderReturnDetail;

Relation::morphMap([

    'Product Opening By Product'            => Product::class,
    'Product Opening By Product Variation'  => ProductVariation::class,
    'Direct Purchase'                       => PurchaseDetail::class,
    'POS Sale'                              => SaleDetail::class,
    'Order'                                 => OrderDetail::class,
    'Order Return Detail'                   => OrderReturnDetail::class,

]);





class Stock extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'pdt_stocks';

    



    /*
     |--------------------------------------------------------------------------
     | STOCK IN (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeStockIn($query)
    {
        $query->where('stock_type', 'In');
    }

    



    /*
     |--------------------------------------------------------------------------
     | STOCK OUT (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeStockOut($query)
    {
        $query->where('stock_type', 'Out');
    }

    



    /*
     |--------------------------------------------------------------------------
     | STOCKABLE IN TYPES (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeStockableInTypes($query)
    {
        $query->where(function ($q) {
            $q->where('stockable_type', 'Product Opening By Product')
            ->orWhere('stockable_type', 'Product Opening By Product Variation')
            ->orWhere('stockable_type', 'Direct Purchase');
        });
    }

    



    /*
     |--------------------------------------------------------------------------
     | STOCKABLE OUT TYPES (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeStockableOutTypes($query)
    {
        $query->where(function ($q) {
            $q->where('stockable_type', 'POS Sale')
            ->orWhere('stockable_type', 'Order');
        });
    }

    



    /*
     |--------------------------------------------------------------------------
     | STOCKABLE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function stockable()
    {
        return $this->morphTo();
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

}
