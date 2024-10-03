<?php

namespace Module\Inventory\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Module\Inventory\Models\CustomerType;

class CustomerTypeController extends Controller
{

    /*
     |-------------------------------------------------------
     |             INDEX METHOD
     |-------------------------------------------------------
    */
    public function index()
    {
        $data['customerTypes']      = CustomerType::query()
                                    ->searchByField('name')
                                    ->searchByField('percentage')
                                    ->latest()
                                    ->paginate(30);

        $data['table']      = CustomerType::getTableName();

        return view('customer-types.index', $data);
    }




     /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('customer-types.create');
    }








    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {

        try {

            DB::transaction(function () use ($request) {

                $customerType = CustomerType::create([
                    'name'              => $request->name,
                    'percentage'        => $request->percentage,
                    'status'            => !empty($request->status) ? 1 : 0,
                    'created_by'        => auth()->id()

                ]);

            });

            return redirect()->route('inv.customer-types.index')->withMessage('Customer Type Successfully Created');

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
        $data['customerType']      = CustomerType::findOrFail($id);


        return view('customer-types.edit', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $customerType = CustomerType::find($id);

        try {

            DB::transaction(function () use ($request, $customerType) {

                $customerType->update([
                    'name'              => $request->name,
                    'percentage'        => $request->percentage,
                    'status'            => !empty($request->status) ? 1 : 0,
                    'updated_by'        => auth()->id()
                ]);

            });

            return redirect()->route('inv.customer-types.index')->withMessage('Customer Type Successfully Updated');

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
        $customerType = CustomerType::find($id);

        $customerType->destroy($id);

        return redirect()->route('inv.customer-types.index')->withMessage('Customer Type Successfully Deleted!');
    }





}
