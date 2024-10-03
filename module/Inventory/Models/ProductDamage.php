<?php

namespace Module\Inventory\Models;

use App\Model;
use App\Models\Company;
use App\Traits\AutoCreatedUpdated;
use Module\Account\Models\Transaction;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\MorphMany;

Relation::morphMap([
    'Order Return' => OrderReturn::class,
]);

class ProductDamage extends Model
{
    use AutoCreatedUpdated;
    
    protected $table = 'inv_product_damages';





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
     | PRODUCT DAMAGE DETAILS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function productDamageDetails()
    {
        return $this->hasMany(ProductDamageDetail::class, 'product_damage_id');
    }

    



    /*
     |--------------------------------------------------------------------------
     | SOURCABLE (RELATION)
     |--------------------------------------------------------------------------
    */
    public function sourcable()
    {
        return $this->morphTo();
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
}
