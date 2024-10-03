<?php

namespace Module\Inventory\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\District;
use App\Models\User;
use App\Traits\CheckPermission;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Module\Account\Models\Customer;
use Module\Account\Models\Account;
use Module\Account\Services\AccountTransactionService;
use Module\Inventory\Models\CustomerType;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    use CheckPermission;

    private $transactionService;




    /*
     |--------------------------------------------------------------------------
     | CONSTRUCTOR
     |--------------------------------------------------------------------------
    */
    public function __construct()
    {
        $this->transactionService   = new AccountTransactionService();
    }






    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {

        $this->hasAccess("inv.customers.index");
        

        $customers = Customer::where('account_id', null)->take(1000)->get();
        foreach($customers as $customer){

            $account = Account::create([
                    'name'                  => $customer->name,
                    'account_group_id'      => 1,
                    'account_control_id'    => 1,
                    'account_subsidiary_id' => 8,
                    'opening_balance'       => 0,
                    'balance_type'          => 'Debit'
            ]);

            $customer->update([
                'account_id' => $account->id,
            ]);
        }

        $data['customers']      = Customer::query()
                                ->searchByField('district_id')
                                ->searchByField('area_id')
                                ->LikeSearch('name')
                                ->searchByField('email')
                                ->searchByField('mobile')
                                ->orderBy('id','DESC')
                                ->paginate(30);

        $data['table']          = Customer::getTableName();
        $data['districts']          = District::orderBy('name','ASC')->get();
        $data['areas']              = Area::orderBy('name','ASC')->get();

        return view('customer/index', $data);
    }






    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("customers.create");

        $data['customerTypes']      = CustomerType::get();
        $data['districts']          = District::orderBy('name','ASC')->get();
        $data['areas']              = Area::orderBy('name','ASC')->get();
        $data['accounts']           = Account::get();

        return view('customer/create', $data );
    }







    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $this->hasAccess("customers.create");

        $request->validate([
            'name'      => 'required',
            'mobile'    => 'required|unique:acc_customers'
        ]);

      
        try {
            DB::transaction(function () use ($request) {

                $account = Account::create([
                        'name'                  => $request->name,
                        'account_group_id'      => 1,
                        'account_control_id'    => 1,
                        'account_subsidiary_id' => 8,
                        'opening_balance'       => 0,
                        'balance_type'          => 'Debit'
                ]);

                $user = User::create([
                    'company_id '       => 1,
                    'name'              => $request->name ?? $request->mobile,
                    'phone'             => $request->mobile,
                    'email'             => $request->email,
                    // 'password'          => Hash::make(Str::random(8)),
                    'password'          => Hash::make($request->password),
                    'type'              => 'Customer',
                ]);

                Customer::create([
                    'user_id'           => $user->id,
                    'name'              => $request->name,
                    'mobile'            => $request->mobile,
                    'email'             => $request->email,
                    'address'           => $request->address,
                    'opening_balance'   => $request->opening_balance ?? 0,
                    'current_balance'   => $request->current_balance ?? 0,
                    'account_id'        => $account->id,
                    // 'previous_due'      => $request->previous_due ? $request->previous_due : 0.00,
                    'customer_type_id'  => $request->customer_type_id,
                    'register_from'     => $request->register_from ?? 'Showroom',
                    'gender'            => $request->gender,
                    'country'           => $request->country,
                    'district_id'       => $request->district_id,
                    'area_id'           => $request->area_id,
                    'zip_code'          => $request->zip_code,
                    'is_default'        => $request->is_default == 'on' ? 1 : 0,
                    'status'            => $request->status     == 'on' ? 1 : 0,
                ]);

            });

            return redirect()->route('inv.customers.index')->withMessage('Customer Data Successfully Added');

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }






    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $this->hasAccess("account-customers.edit");

        $data['customer']           = Customer::query()->find($id);
        $data['customerTypes']      = CustomerType::get();
        $data['districts']          = District::orderBy('name','ASC')->get();
        $data['areas']              = Area::orderBy('name','ASC')->get();
        $data['accounts']           = Account::get();

        return view('customer/edit', $data );
    }






    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {

        $this->hasAccess("account-customers.edit");

        $request->validate([
            'name'      => 'required',
            'mobile'    => 'required'
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $password_add   = false;
                $customer       = Customer::find($id);
                $user           = User::where('id',$customer->user_id)->first();


                if ($user == null) {
                    $password_add = true;
                }

                $customer->account()->update([
                    'name' => $request->name
                ]);

                $user->update([
                    'company_id'    => 1,
                    'name'          => $request->name ?? $request->mobile,
                    'type'          => 'Customer',
                    'email'         => $request->email,
                    'phone'         => $request->mobile,
                    'password'      => $request->password != '' ? Hash::make($request->password) : $user->password,
                ]);

                $customer->update([
                    'name'              => $request->name,
                    'mobile'            => $request->mobile,
                    'email'             => $request->email,
                    'address'           => $request->address,
                    'opening_balance'   => $request->opening_balance ?? 0,
                    'current_balance'   => $request->current_balance ?? 0,
                    'previous_due'      => $request->previous_due ?? 0,
                    'customer_type_id'  => $request->customer_type_id,
                    'register_from'     => $request->register_from ?? 'Showroom',
                    'gender'            => $request->gender,
                    'country'           => $request->country,
                    'district_id'       => $request->district_id,
                    'area_id'           => $request->area_id,
                    'zip_code'          => $request->zip_code,
                    'is_default'        => $request->is_default == 'on' ? 1 : 0,
                    'status'            => $request->status     == 'on' ? 1 : 0,
                ]);

                if ($password_add == true) {

                    $user->update([
                        'password' => Hash::make(Str::random(8)),
                    ]);

                    $customer->update([
                        'user_id' => $user->id,
                    ]);

                }
            });

            return redirect()->route('inv.customers.index')->withMessage('Customer Data Successfully Edited');

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

    }





    /*
     |--------------------------------------------------------------------------
     | DESTROY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $this->hasAccess("account-customers.delete");

        try {

            DB::transaction(function () use($id) {

                $customer = Customer::where('id', $id)->with('user', 'account')->first();

                $customer->delete();
                
                $customer->user()->delete();

                $customer->account()->delete();

            });

            return redirect()->route('inv.customers.index')->with('message', 'Customer Successfully Deleted!');

        } catch (\Exception $ex) {

            return redirect()->back()->withErrors($ex->getMessage());
        }
    }



    /*
     |--------------------------------------------------------------------------
     | GET AREAS BY DISTRICT METHOD
     |--------------------------------------------------------------------------
    */
    public function getAreasByDistrict(Request $request) // id == district_id
    {
        return  Area::query()->when(request()->filled('district_id'), function($qr) use($request) {

                                    $qr->where('district_id', $request->district_id);

                              })->get(['id', 'name']);
    }



}
