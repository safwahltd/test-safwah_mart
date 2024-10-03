<?php


namespace Module\Account\Models;
use App\Model;
use App\Models\Area;
use App\Models\District;
use App\Models\User;
use App\Traits\AutoCreatedUpdatedWithCompany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Customer extends Model
{
    use AutoCreatedUpdatedWithCompany;

    protected $table = 'acc_customers';

    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    public function created_user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function sales(){
        return $this->hasMany(Sale::class, 'customer_id');
    }


    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function customer_user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /*
     |--------------------------------------------------------------------------
     | API QUERY
     |--------------------------------------------------------------------------
    */
    public function scopeApiQuery($query)
    {
        $query->active();
    }





    /*
     |--------------------------------------------------------------------------
     | STOCK REQUESTS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function stock_requests()
    {
        return $this->hasMany(StockRequest::class);
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



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
