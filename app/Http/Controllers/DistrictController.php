<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Traits\CheckPermission;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    use CheckPermission;



    /*
     |-------------------------------------------------------
     |             INDEX METHOD
     |-------------------------------------------------------
    */
    public function index(Request $request)
    {
        $this->hasAccess("orders.districts");

        $orderBy = $request->order_by ?? 'name';
        $orderType = $request->order_type ?? 'ASC';

        $data['districts'] = District::query()
                                          ->likeSearch('name')
                                          ->orderBy($orderBy, $orderType)
                                          ->paginate(30);

        $data['table']     = District::getTableName();

        $data['orderByFields'] = [
            'name' => 'Name',
            'min_purchase_amount' => 'Min Purchase Amount',
            'free_delivery_amount' => 'Free Delivery Amount',
        ];

        $data['orderTypes'] = [
            'ASC' => 'Ascending Order',
            'DESC' => 'Descending Order',
        ];

        return view('districts.index', $data);
    }





    /*
     |-------------------------------------------------------
     |             UPDATE DISTRICTS DATA METHOD
     |-------------------------------------------------------
    */
    public function updateDistrictsData(Request $request){

        $this->hasAccess("orders.districts");

        try {

            foreach ($request->id ?? [] as $key => $id) {
                District::find($id)->update([
                    'min_purchase_amount'   => $request->min_purchase_amount[$key],
                    'free_delivery_amount'  => $request->free_delivery_amount[$key],
                ]);
            }

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }


        return redirect()->route('districts.index')->with('success', 'Data updated successfully!');


    }





    /*
     |-------------------------------------------------------
     |             CREATE METHOD
     |-------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("orders.districts");

        return view('districts.create');
    }





    /*
     |-------------------------------------------------------
     |             STORE METHOD
     |-------------------------------------------------------
    */
    public function store(Request $request)
    {
        $this->hasAccess("orders.districts");

        try {
                District::create([
                    'name'                  => $request->name,
                    'shipping_cost'         => $request->shipping_cost,
                    'free_delivery_amount'  => $request->free_delivery_amount,
                    'status'                => !empty($request->status) ? 1 : 0,
                    'created_by'            => auth()->id()
                ]);

        } catch (\Throwable $th) {

            throw $th;

        }
        return redirect()->route('districts.index')->withMessage('Success');

    }





    /*
     |-------------------------------------------------------
     |             SHOW METHOD
     |-------------------------------------------------------
    */
    public function show($id)
    {
        //
    }





    /*
     |-------------------------------------------------------
     |             EDIT METHOD
     |-------------------------------------------------------
    */
    public function edit($id)
    {
        $this->hasAccess("orders.districts");

        $district  = District::find($id);
        return view('districts.edit', compact('district'));
    }




    /*
     |-------------------------------------------------------
     |             UPDATE METHOD
     |-------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $this->hasAccess("orders.districts");

        try {

            $district = District::find($id);

            $district->update([
                'name'                  => $request->name,
                'shipping_cost'         => $request->shipping_cost,
                'free_delivery_amount'  => $request->free_delivery_amount,
                'status'                => !empty($request->status) ? 1 : 0,
                'updated_by'            => auth()->id()
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->route('districts.index')->withMessage('Success');

    }





    /*
     |-------------------------------------------------------
     |             DESTROY METHOD
     |-------------------------------------------------------
    */
    public function destroy($id)
    {
        $this->hasAccess("orders.districts");

        District::destroy($id);
        return redirect()->back()->withMessage('District Successfully Deleted!');
    }



}
