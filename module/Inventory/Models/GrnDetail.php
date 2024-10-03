<?php

namespace Module\Inventory\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;
use Module\Product\Models\ProductType;

class GrnDetail extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'inv_grn_details';




    /*
    |--------------------------------------------------------------------------
    | GRN METHOD
    |--------------------------------------------------------------------------
    */
    public function grn()
    {
        return $this->belongsTo(Grn::class);
    }




    /*
    |--------------------------------------------------------------------------
    | SUPPLIER TYPE METHOD
    |--------------------------------------------------------------------------
    */
    public function supplierType()
    {
        return $this->belongsTo(SupplierType::class);
    }




    /*
    |--------------------------------------------------------------------------
    | SUPPLIER METHOD
    |--------------------------------------------------------------------------
    */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }




    /*
    |--------------------------------------------------------------------------
    | WAREHOUSE METHOD
    |--------------------------------------------------------------------------
    */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }




    /*
    |--------------------------------------------------------------------------
    | PURCHASE DETAIL METHOD
    |--------------------------------------------------------------------------
    */
    public function purchaseDetail()
    {
        return $this->belongsTo(PurchaseDetail::class);
    }




    /*
    |--------------------------------------------------------------------------
    | PRODUCT METHOD
    |--------------------------------------------------------------------------
    */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
