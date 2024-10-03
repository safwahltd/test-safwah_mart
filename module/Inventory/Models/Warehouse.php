<?php

namespace Module\Inventory\Models;

use App\Model;
use App\Models\Area;
use App\Models\Company;
use App\Models\District;
use App\Traits\AutoCreatedUpdated;

class Warehouse extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'inv_warehouses';





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
     | ECOM ACCOUNTS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function ecomAccounts()
    {
        return $this->hasMany(EcomAccount::class, 'warehouse_id');
    }





    /*
     |--------------------------------------------------------------------------
     | WAREHOUSE AREAS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function warehouseAreas()
    {
        return $this->hasMany(WarehouseArea::class, 'warehouse_id');
    }



    /*
     |--------------------------------------------------------------------------
     | GET TABLE NAME
     |--------------------------------------------------------------------------
    */
    public static function getTableName()
    {
        return with(new static)->getTable();
    }


}
