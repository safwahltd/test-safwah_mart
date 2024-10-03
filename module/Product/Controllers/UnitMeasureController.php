<?php

namespace Module\Product\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Module\Product\Exports\UnitMeasureExport;
use Module\Product\Models\UnitMeasure;
use Module\Product\Exports\MultipleSheetExport;
use App\Traits\CheckPermission;

class UnitMeasureController extends Controller
{
    use CheckPermission;

    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        
        $this->hasAccess("unit-measures.index");

        $data['unitMeasures']       = UnitMeasure::query()
                                    ->likeSearch('name')
                                    ->latest()
                                    ->paginate(50);

       $data['table']               = UnitMeasure::getTableName();

        return view('unit-measure/index', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("unit-measures.create");

        return view('unit-measure.create');
    }




    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:pdt_unit_measures',
        ]);

        try {

            UnitMeasure::create([
                'name'              => $request->name,
                'description'       => $request->description,
                'status'            => !empty($request->status) ? 1 : 0,
            ]);

            return redirect()->route('pdt.unit-measures.index')->withMessage('Unit Measure Successfully Created');

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
        $this->hasAccess("unit-measures.edit");

        return view('unit-measure.edit', ['unitMeasure' => UnitMeasure::findOrFail($id)]);
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $unitMeasure = UnitMeasure::find($id);

        $request->validate([
            'name' => 'required|unique:pdt_unit_measures,name,'.$unitMeasure->id,
        ]);

        try {

            $unitMeasure->update([
                'name'              => $request->name,
                'description'       => $request->description,
                'status'            => !empty($request->status) ? 1 : 0,
            ]);

            return redirect()->route('pdt.unit-measures.index')->withMessage('Unit Measure Successfully Updated');

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
        $this->hasAccess("unit-measures.delete");

        UnitMeasure::destroy($id);
        return redirect()->back()->withMessage('Unit Measure Successfully Deleted!');
    }




    /*
     |--------------------------------------------------------------------------
     | UNIT EXPORT METHOD
     |--------------------------------------------------------------------------
    */
    public function unitMeasureExport()
    {
        return Excel::download(new UnitMeasureExport, 'unit-collection.xlsx');

    }




   
 
}
