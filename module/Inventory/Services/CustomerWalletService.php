<?php

namespace Module\Inventory\Services;

use Module\Account\Models\Customer;

class CustomerWalletService
{
    /*
     |--------------------------------------------------------------------------
     | STORE CUSTOMER WALLET TRANSACTION METHOD
     |--------------------------------------------------------------------------
    */
    public function storeCustomerWalletTransaction($transactionable, $customer_id, $type, $amount, $remarks = null)
    {
        if ($amount > 0) {
            $transactionable->customerWalletTransactions()->create([
                'customer_id'   => $customer_id,
                'type'          => $type,
                'amount'        => $amount ?? 0,
                'remarks'       => $remarks,
            ]);
            
            $amount = $type == 'In' ? $amount : -abs($amount);

            $this->updateCustomerWallet($customer_id, $amount);
        }
    }





    /*
     |--------------------------------------------------------------------------
     | UPDATE CUSTOMER WALLET METHOD
     |--------------------------------------------------------------------------
    */
    public function updateCustomerWallet($customer_id, $amount)
    {
        Customer::find($customer_id)->increment('wallet', $amount ?? 0);
    }
}
