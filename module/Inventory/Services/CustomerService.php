<?php

namespace Module\Inventory\Services;

use Module\Inventory\Models\Customer;


class CustomerService
{
    public $customer;





    /*
     |--------------------------------------------------------------------------
     | STORE CUSTOMER METHOD
     |--------------------------------------------------------------------------
    */
    public function storeCustomer($request)
    {
        return $this->customer  = Customer::create([

            'register_from'     => 'Showroom',
            'name'              => $request->name ?? 'Unknown Person',
            'phone'             => $request->phone,
            'email'             => $request->email,
            'gender'            => $request->gender,
            'address'           => $request->address,
        ]);
    }





    /*
     |--------------------------------------------------------------------------
     | MAKE DEFAULT METHOD
     |--------------------------------------------------------------------------
    */
    public function makeDefault($request, $customer)
    {
        if (!empty($request->is_default)) {

            foreach (Customer::get() ?? [] as $item) {

                $item->update([ 'is_default' => 0 ]);
            }
        }
        
        Customer::whereId($customer->id)->update([ 'is_default' => !empty($request->is_default) ? 1 : 0 ]);
    }
    
}
