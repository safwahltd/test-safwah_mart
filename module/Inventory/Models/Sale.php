<?php

namespace Module\Inventory\Models;

use App\Model;
use App\Models\Company;
use App\Traits\AutoCreatedUpdated;
use Module\Account\Models\Customer;
use Module\Account\Models\Transaction;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Sale extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'inv_sales';





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





    /*
     |--------------------------------------------------------------------------
     | CUSTOMER (RELATION)
     |--------------------------------------------------------------------------
    */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }





    /*
     |--------------------------------------------------------------------------
     | ORDER (RELATION)
     |--------------------------------------------------------------------------
    */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }





    /*
     |--------------------------------------------------------------------------
     | SALE DETAILS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class, 'sale_id');
    }



    // new
    // public function scopeApiQuery($query)
    // {
    //     $query->active();
    // }




    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }


}
