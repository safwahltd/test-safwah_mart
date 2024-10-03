<?php

namespace Module\Inventory\Models;

use App\Model;
use App\Models\Area;
use App\Models\Company;
use App\Models\User;
use App\Traits\AutoCreatedUpdated;
use App\Traits\AutoUpdatedBy;
use Module\Account\Models\Customer;
use Module\Account\Models\Transaction;
use Module\Inventory\Models\CouponUse;
use Module\Inventory\Models\OrderStatus;
use Module\Inventory\Models\OrderEmailMessageStatus;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Order extends Model
{
    // use AutoCreatedUpdated;
    use AutoUpdatedBy;

    protected $table = 'inv_orders';


    public function scopeCashOnDelivery($query)
    {
        $query->where('payment_type', 'COD');
    }


    public function scopeReceivableDue($query)
    {
        $query->where(function ($q) {
            $q->where('payment_status', 'Due')
            ->orWhere('payment_status', 'Pending')
            ->orWhere('payment_status', null)
            ->orWhere('payment_status', '');
        });
    }




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
     | API QUERY
     |--------------------------------------------------------------------------
    */
    public function scopeApiQuery($query)
    {
        $query;
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
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }







    /*
     |--------------------------------------------------------------------------
     | DELIVERY MAN (RELATION)
     |--------------------------------------------------------------------------
    */
    public function deliveryMan()
    {
        return $this->belongsTo(DeliveryMan::class, 'delivery_man_id');
    }





    /*
     |--------------------------------------------------------------------------
     | ORDER CUSTOMER (RELATION)
     |--------------------------------------------------------------------------
    */
    public function orderCustomerInfo()
    {
        return $this->hasOne(OrderCustomerInfo::class, 'order_id')->latest();
    }





    /*
     |--------------------------------------------------------------------------
     | ORDER DETAILS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }





    /*
     |--------------------------------------------------------------------------
     | SALE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function sale()
    {
        return $this->hasOne(Sale::class, 'order_id');
    }


    public function order_status(){
        return $this->hasMany(OrderStatus::class);
    }


    public function currentStatus()
    {
        return $this->belongsTo(Status::class, 'current_status');
    }



    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }





    public function couponUse()
    {
        return $this->morphOne(CouponUse::class, 'sourcable');
    }



     /*
     |--------------------------------------------------------------------------
     | ORDER DETAILS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }
    /*
     |--------------------------------------------------------------------------
     | ORDER (RELATION)
     |--------------------------------------------------------------------------
    */
    public function order_email_message_status()
    {
        return $this->hasOne(OrderEmailMessageStatus::class, 'order_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function soldBy()
    {
        return $this->belongsTo(User::class, 'sold_by');
    }



    public function scopePending($query)
    {
        $query->where('current_status', 1);
    }


    public function scopeAccepted($query)
    {
        $query->where('current_status', 2);
    }


    public function scopeProcessing($query)
    {
        $query->where('current_status', 3);
    }


    public function scopeOnTheWay($query)
    {
        $query->where('current_status', 4);
    }


    public function scopeDelivered($query)
    {
        $query->where('current_status', 5);
    }


    public function scopeCancelled($query)
    {
        $query->where('current_status', 6);
    }



    public function orderStatuses()
    {
        return $this->hasMany(OrderStatus::class, 'order_id');
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
