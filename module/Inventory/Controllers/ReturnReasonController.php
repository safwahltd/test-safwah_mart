<?php

namespace Module\Inventory\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Module\Inventory\Models\ReturnReason;
use App\Traits\CheckPermission;

class ReturnReasonController extends Controller
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

        $data['returnReasons']  = ReturnReason::query()
                                ->likeSearch('title')
                                ->orderBy('serial_no', 'ASC')
                                ->paginate(30);

        $data['table']          = ReturnReason::getTableName();

        return view('return-reason/index', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("inv.config");

        $serial_no = ReturnReason::orderBy('id', 'DESC')->first();
        $next_serial_no = $serial_no ? $serial_no->serial_no + 1 : 1;

        return view('return-reason/create', compact('next_serial_no'));
    }





    /*
    |--------------------------------------------------------------------------
    | STORE METHOD
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|unique:inv_return_reasons',
            'serial_no' => 'required|unique:inv_return_reasons'
         ]);

        try {

            ReturnReason::create([
                'title'         => $request->title,
                'description'   => $request->description,
                'serial_no'     => $request->serial_no,
                'status'        => !empty($request->status) ? 1 : 0,
            ]);

            return redirect()->route('inv.return-reasons.index')->withMessage('Return Reason has been successfully created');

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
        $this->hasAccess("inv.config");

        return view('return-reason/edit', [
            'returnReason' => ReturnReason::find($id),
        ]);
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $returnReason = ReturnReason::find($id);

        $request->validate([
            'title'     => 'required|unique:inv_return_reasons,title,'.$returnReason->id,
            'serial_no' => 'required|unique:inv_return_reasons,serial_no,'.$returnReason->id
        ]);

        try {

            $returnReason->update([
                'title'         => $request->title,
                'description'   => $request->description,
                'serial_no'     => $request->serial_no,
                'status'        => !empty($request->status) ? 1 : 0,
            ]);

            return redirect()->route('inv.return-reasons.index')->withMessage('Return Reason has been successfully updated');

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
            ReturnReason::destroy($id);
        }
        catch(\Exception $ex) {
            return redirect()->back()->withError('You can not this return reason');
        }

        return redirect()->back()->withMessage('Return Reason has been successfully deleted');
    }
}
