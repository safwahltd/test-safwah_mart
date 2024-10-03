<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\District;
use App\Traits\CheckPermission;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    use CheckPermission;


    /*
     |-------------------------------------------------------
     |             INDEX METHOD
     |-------------------------------------------------------
    */
    public function index(Request $request)
    {
        $this->hasAccess("orders.areas");

        $orderBy = $request->order_by ?? 'name';
        $orderType = $request->order_type ?? 'ASC';

        $data['areas']      = Area::query()
                                  ->searchByField('name')
                                  ->searchByField('district_id')
                                  ->orderBy($orderBy, $orderType)
                                  ->paginate(30);

        $data['orderByFields'] = [
            'name' => 'Name',
            'min_purchase_amount' => 'Min Purchase Amount',
            'free_delivery_amount' => 'Free Delivery Amount',
        ];

        $data['orderTypes'] = [
            'ASC' => 'Ascending Order',
            'DESC' => 'Descending Order',
        ];

        $data['districts']  =  District::where('status',1)->orderBy('name', 'ASC')->get();

        $data['table']      = Area::getTableName();

        return view('areas.index', $data);
    }





    /*
     |-------------------------------------------------------
     |             UPDATE AREAS DATA METHOD
     |-------------------------------------------------------
    */
    public function updateAreasData(Request $request){

        $this->hasAccess("orders.areas");
        try {

            foreach ($request->id ?? [] as $key => $id) {
                Area::find($id)->update([
                    'min_purchase_amount'   => $request->min_purchase_amount[$key],
                    'free_delivery_amount'  => $request->free_delivery_amount[$key],
                ]);
            }

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }

        return redirect()->route('areas.index')->with('success', 'Data updated successfully!');

    }






    /*
     |-------------------------------------------------------
     |             CREATE METHOD
     |-------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("orders.areas");
        $districts  =  District::where('status',1)->orderBy('name','ASC')->get();
        return view('areas.create', compact('districts'));
    }





    /*
     |-------------------------------------------------------
     |             STORE METHOD
     |-------------------------------------------------------
    */
    public function store(Request $request)
    {
        $this->hasAccess("orders.areas");

        try {
                Area::create([
                        'name'          => $request->name,
                        'status'        => !empty($request->status) ? 1 : 0,
                        'district_id'   => $request->district_id,
                        'created_by'    => auth()->id()
                ]);

        } catch (\Throwable $th) {

            throw $th;

        }
        return redirect()->route('areas.index')->withMessage('Success');

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
        $this->hasAccess("orders.areas");
        $data['area']       = Area::find($id);
        $data['districts']  = District::where('status',1)->orderBy('name','ASC')->get();

        return view('areas.edit', $data);
    }




    /*
     |-------------------------------------------------------
     |             UPDATE METHOD
     |-------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $this->hasAccess("orders.areas");
        try {
            $area = Area::find($id);
            $area->update([
                'name'                     => $request->name,
                'district_id'              => $request->district_id,
                'status'                   => !empty($request->status) ? 1 : 0,
                'updated_by'               => auth()->id()
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->route('areas.index')->withMessage('Success');

    }





    /*
     |-------------------------------------------------------
     |             DESTROY METHOD
     |-------------------------------------------------------
    */
    public function destroy($id)
    {
        $this->hasAccess("orders.areas");
        Area::destroy($id);
        return redirect()->back()->withMessage('Area Successfully Deleted!');
    }



}
