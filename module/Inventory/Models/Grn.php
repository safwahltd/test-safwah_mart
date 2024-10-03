<?php

namespace Module\Inventory\Models;

use App\Model;
use App\Models\Company;
use App\Traits\AutoCreatedUpdated;
use Module\Account\Models\Supplier;

class Grn extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'inv_grn';





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
        return $this->belongsTo(Supplier::class, 'supplier_id');
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
     | PURCHASE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }





    /*
     |--------------------------------------------------------------------------
     | GRN DETAILS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function grnDetails()
    {
        return $this->hasMany(GrnDetail::class, 'grn_id');
    }
}
