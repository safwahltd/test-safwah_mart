<?php

namespace Module\Inventory\Models;

use App\Model;
use App\Models\User;
use App\Models\Company;
use App\Traits\AutoCreatedUpdated;
use Module\Account\Models\Supplier;
use Module\Account\Models\Transaction;

class Purchase extends Model
{
    use AutoCreatedUpdated;

    protected $table = 'inv_purchases';





    /*
     |--------------------------------------------------------------------------
     | DIRECT PURCHASE (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeDirect($query)
    {
        $query->where('type', 'Direct');
    }





    /*
     |--------------------------------------------------------------------------
     | PROCEDURE PURCHASE (SCOPE)
     |--------------------------------------------------------------------------
    */
    public function scopeProcedure($query)
    {
        $query->where('type', 'Procedure');
    }





    /*
     |--------------------------------------------------------------------------
     | P.O. CREATED BY (RELATION)
     |--------------------------------------------------------------------------
    */
    public function poCreatedBy()
    {
        return $this->belongsTo(User::class, 'p_o_created_by');
    }




    /*
     |--------------------------------------------------------------------------
     | P.I. CREATED BY (RELATION)
     |--------------------------------------------------------------------------
    */
    public function piCreatedBy()
    {
        return $this->belongsTo(User::class, 'p_i_created_by');
    }




    /*
     |--------------------------------------------------------------------------
     | VERIFIED BY (RELATION)
     |--------------------------------------------------------------------------
    */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }




    /*
     |--------------------------------------------------------------------------
     | APPROVED BY (RELATION)
     |--------------------------------------------------------------------------
    */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
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
     | PURCHASE DETAILS (RELATION)
     |--------------------------------------------------------------------------
    */
    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class, 'purchase_id');
    }




    /*
     |--------------------------------------------------------------------------
     | GRN (RELATION)
     |--------------------------------------------------------------------------
    */
    public function grn()
    {
        return $this->hasMany(Grn::class, 'purchase_id');
    }
    


    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
