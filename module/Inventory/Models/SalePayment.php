<?php

namespace Module\Inventory\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;

class SalePayment extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'inv_sale_payments';





    /*
     |--------------------------------------------------------------------------
     | SALE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }





    /*
     |--------------------------------------------------------------------------
     | ECOM ACCOUNT (RELATION)
     |--------------------------------------------------------------------------
    */
    public function ecomAccount()
    {
        return $this->belongsTo(EcomAccount::class, 'ecom_account_id');
    }
}
