<?php

namespace Module\Inventory\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Module\Inventory\Models\Warehouse;
use Module\Inventory\Models\WarehouseArea;
use App\Traits\CheckPermission;

class WarehouseController extends Controller
{
    use CheckPermission;

    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        $this->hasAccess("inv.config");

        $data['warehouses'] = Warehouse::query()
                    ->searchByField('name')
                    ->latest()
                    ->paginate(50);

        $data['table']          = Warehouse::getTableName();

        return view('warehouse/index', $data );
    }





    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("inv.config");

        return view('warehouse.create', [
            'areas' => Area::orderBy('name','ASC')->pluck('name', 'id'),
        ]);
    }





    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        
        $request->validate([ 'name' => 'required|unique:inv_warehouses' ]);

        try {

            DB::transaction(function () use ($request) {

                $warehouse = Warehouse::create([
                    'company_id'            => auth()->user()->company_id,
                    'name'                  => $request->name,
                    'phone'                 => $request->phone,
                    'bin_no'                => $request->bin_no,
                    'address'               => $request->address,
                ]);


                foreach ($request->area_id as $area) {

                    $district = Area::find($area)->district_id;

                    WarehouseArea::create([
                        'warehouse_id'      => $warehouse->id,
                        'area_id'           => $area,
                        'district_id'       => $district,
                    ]);
                }

            });

            return redirect()->route('inv.warehouses.index')->withMessage('Warehouse has been Created Successfully');

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }





    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function edit(Warehouse $warehouse)
    {
        $this->hasAccess("inv.config");

        $data['areas']          = Area::orderBy('name','ASC')->get();
        $data['warehouse']      = $warehouse;
        $data['warehouseAreas'] = WarehouseArea::with('area')->where('warehouse_id',$warehouse->id)->get();

        
        return view('warehouse.edit', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, Warehouse $warehouse)
    {

        $request->validate([
            'name' => 'required|unique:inv_warehouses,name,'.$warehouse->id,
        ]);

        try {

            $warehouse->update([
                'company_id'        => auth()->user()->company_id,
                'name'              => $request->name,
                'phone'             => $request->phone,
                'bin_no'            => $request->bin_no,
                'address'           => $request->address,
            ]);

            $totalWarehouseArea = WarehouseArea::where('warehouse_id', $warehouse->id)->count();

            for ($i=0; $i < $totalWarehouseArea; $i++) {
                WarehouseArea::where('warehouse_id', $warehouse->id)->delete();
            }

            foreach ($request->area_id as $area) {

                $district = Area::find($area)->district_id;

                WarehouseArea::create([
                    'warehouse_id'      => $warehouse->id,
                    'area_id'           => $area,
                    'district_id'       => $district,
                ]);
            }

            return redirect()->route('inv.warehouses.index')->withMessage('Warehouse has been Updated Successfully');

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
        $this->hasAccess("inv.config");

        try {

            $warehouse = Warehouse::find($id);

            $warehouse->warehouseAreas()->delete();

            $warehouse->delete();

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        return redirect()->back()->withMessage('Warehouse has been Successfully Deleted!');
    }
}
