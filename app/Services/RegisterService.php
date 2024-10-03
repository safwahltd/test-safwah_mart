<?php


namespace App\Services;

use App\Models\User;
use App\Traits\FileSaver;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Module\Account\Models\Customer;

class RegisterService
{

    use FileSaver;

    private $customer;


     /*
     |--------------------------------------------------------------------------
     | OOCIAL STORE USER INFO
     |--------------------------------------------------------------------------
    */
    public function socialStore($request)
    {


        $user = User::updateOrCreate(
            [
                'email'             => $request->email,
            ],
            [
                'social_provider'   => $request->social_provider,
                'company_id'        => 1,
                'name'              => $request->name,
                'type'              => 'Customer',
            ]);


        Customer::updateOrCreate(
            [
                'user_id'      => $user->id,
                'email'        => $request->email,
            ],
            [
                'name'         => $request->name,
                'created_by'   => 1,
            ]);


        if($request->image != NULL){

            $user->update([
                'image'        => $user->image,
            ]);

            $this->uploadFileWithResize($request->image, $user, 'image', 'images/user', 250,250); // ?
        }

        return  User::where('id', $user->id)
                ->with('customer')
                ->first();
    }




     /*
     |--------------------------------------------------------------------------
     | STORE USER INFO
     |--------------------------------------------------------------------------
    */
    public function store($request)
    {

        // dd($request->all());

        $isAddPassword = false;

        $user = User::where('phone', $request->phone)->first();

        if ($user == null) {
            $isAddPassword = true;
        }

        if ($user == null && $request->checkout == 'true') {
            $isAddPassword = true;
        }


        $user = User::updateOrCreate(
            [
                'phone'             => $request->phone,
            ],
            [
                'company_id'        => 1,
                'name'              => $request->name ?? $request->phone,
                'type'              => 'Customer',
                'email'             => $request->email,
            ]);


        Customer::updateOrCreate(
            [
                'user_id'      => $user->id,
                'mobile'       => $request->phone,
            ],
            [
                'name'         => $request->name ?? $request->phone,
                'email'        => $request->email,
                'address'      => $request->address,
                'district_id'  => $request->district_id,
                'area_id'      => $request->area_id,
                'zip_code'     => $request->zip_code,
                'country'      => $request->country,
            ]);


        if ($isAddPassword == true) {

            $user->update([
                'password'     => $request->password ? Hash::make($request->password) : Hash::make(Str::random(8)),
                'image'        => $request->image,
            ]);

            $this->uploadFileWithResize($request->image, $user, 'image', 'images/user', 250, 250);

        }
        else{
            if($request->image != NULL){

                $user->update([
                    'image'        => $user->image,
                ]);

                $this->uploadFileWithResize($request->image, $user, 'image', 'images/user', 250, 250);
            }

        }

        return  User::where('id', $user->id)
                ->with(['customer' => function ($query) {
                    $query->with('district:id,name')
                        ->with('area:id,name');
                }])
                ->first();
    }








     /*
     |--------------------------------------------------------------------------
     | STORE CUSTOMER INFO
     |--------------------------------------------------------------------------
    */
    public function storeCustomer($request, $user_id)
    {
        return  Customer::updateOrCreate(
                [
                    'user_id'      => $user_id,
                    'mobile'       => $request->phone,
                ],
                [
                    'name'         => $request->name ?? $request->phone,
                    'email'        => $request->email,
                    'address'      => $request->address,
                    'district_id'  => $request->district_id,
                    'area_id'      => $request->area_id,
                    'zip_code'     => $request->zip_code,
                    'country'      => $request->country,
                ]);
    }


}
