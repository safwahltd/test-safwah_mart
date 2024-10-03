<?php

namespace Module\Inventory\Services;

use Module\Account\Models\Customer;

class CustomerPointService
{
    /*
     |--------------------------------------------------------------------------
     | STORE CUSTOMER POINT TRANSACTION BY AMOUNT METHOD
     |--------------------------------------------------------------------------
    */
    public function storeCustomerPointTransactionByAmount($transactionable, $customer_id, $type, $amount, $remarks = null)
    {
        if (getPoint($amount) > 0) {
            $transactionable->customerPointTransactions()->create([
                'customer_id'   => $customer_id,
                'type'          => $type,
                'point'         => getPoint($amount),
                'remarks'       => $remarks,
            ]);
    
            $point = $type == 'In' ? getPoint($amount) : -abs(getPoint($amount));
    
            $this->updateCustomerPoint($customer_id, $point);
        }
    }





    /*
     |--------------------------------------------------------------------------
     | STORE CUSTOMER POINT TRANSACTION BY POINT METHOD
     |--------------------------------------------------------------------------
    */
    public function storeCustomerPointTransactionByPoint($transactionable, $customer_id, $type, $point, $remarks = null)
    {
        $transactionable->customerPointTransactions()->create([
            'customer_id'   => $customer_id,
            'type'          => $type,
            'point'         => $point,
            'remarks'       => $remarks,
        ]);

        $point = $type == 'In' ? $point : -abs($point);

        $this->updateCustomerPoint($customer_id, $point);
    }





    /*
     |--------------------------------------------------------------------------
     | UPDATE CUSTOMER POINT METHOD
     |--------------------------------------------------------------------------
    */
    public function updateCustomerPoint($customer_id, $point)
    {
        Customer::find($customer_id)->increment('point', $point);
    }
}
