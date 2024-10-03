<?php

namespace Module\Inventory\Models;

use App\Model;
use App\Models\User;
use App\Models\Company;
use App\Traits\AutoCreatedUpdated;
use Module\Account\Models\Customer;
use Module\Account\Models\Transaction;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class OrderReturn extends Model
{
    use AutoCreatedUpdated;
    
    protected $table = 'inv_order_returns';





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
     | ORDER (RELATION)
     |--------------------------------------------------------------------------
    */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
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
     | RETURN REASON (RELATION)
     |--------------------------------------------------------------------------
    */
    public function returnReason()
    {
        return $this->belongsTo(ReturnReason::class, 'return_reason_id');
    }





    /*
     |--------------------------------------------------------------------------
     | ORDER RETURN DETAILS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function orderReturnDetails()
    {
        return $this->hasMany(OrderReturnDetail::class, 'order_return_id');
    }





    /*
     |--------------------------------------------------------------------------
     | ORDER RETURN DETAILS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function damageOrExpireReturnDetails()
    {
        return $this->hasMany(OrderReturnDetail::class, 'order_return_id')->where(function ($q) {
            $q->where('return_type', 'Damaged')
                ->orWhere('return_type', 'Expired');
        });
    }
    




    /*
     |--------------------------------------------------------------------------
     | PRODUCT DAMAGE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function productDamage()
    {
        return $this->morphOne(ProductDamage::class, 'sourcable');
    }
    




    /*
     |--------------------------------------------------------------------------
     | REQUEST FROM (RELATION)
     |--------------------------------------------------------------------------
    */
    public function requestFrom()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    




    /*
     |--------------------------------------------------------------------------
     | TIME SLOT (RELATION)
     |--------------------------------------------------------------------------
    */
    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }
    




    /*
     |--------------------------------------------------------------------------
     | DELIVERY MAN (RELATION)
     |--------------------------------------------------------------------------
    */
    public function deliveryMan()
    {
        return $this->belongsTo(DeliveryMan::class);
    }
    




    /*
     |--------------------------------------------------------------------------
     | TRANSACTION (RELATION)
     |--------------------------------------------------------------------------
    */
    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
    




    /*
     |--------------------------------------------------------------------------
     | CUSTOMER WALLET TRANSACTIONS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function customerWalletTransactions()
    {
        return $this->morphMany(CustomerWalletTransaction::class, 'transactionable');
    }
    




    /*
     |--------------------------------------------------------------------------
     | CUSTOMER POINT TRANSACTIONS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function customerPointTransactions()
    {
        return $this->morphMany(CustomerPointTransaction::class, 'transactionable');
    }
}
