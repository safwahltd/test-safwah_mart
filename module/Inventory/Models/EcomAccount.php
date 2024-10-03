<?php

namespace Module\Inventory\Models;

use App\Model;
use App\Models\Company;
use App\Traits\AutoCreatedUpdated;
use Module\Inventory\Models\Warehouse;

class EcomAccount extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'inv_ecom_accounts';





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
     | WAREHOUSE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}
