<?php

namespace Module\Product\Models;

use App\Model;
use Module\Account\Models\Customer;

class StockRequest extends Model
{
    protected $table = 'pdt_stock_requests';



    /*
     |--------------------------------------------------------------------------
     | PRODUCT (RELATION)
     |--------------------------------------------------------------------------
    */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }




    /*
     |--------------------------------------------------------------------------
     | CUSTOMER (RELATION)
     |--------------------------------------------------------------------------
    */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
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




}
