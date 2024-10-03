<?php

namespace Module\Inventory\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Module\Inventory\Models\TimeSlot;
use App\Traits\CheckPermission;
class TimeSlotController extends Controller
{
    use CheckPermission;

    


    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $this->hasAccess("inv.config");

        $data['timeslots']      = TimeSlot::query()
                                ->when(request()->filled('starting_time'), function($q) use($request) {
                                    $q->where('starting_time', '>=', $request->starting_time);
                                })
                                ->when(request()->filled('ending_time'), function($q) use($request) {
                                    $q->where('ending_time', '<=', $request->ending_time);
                                })
                                ->searchByField('name')
                                ->orderBy('id', 'DESC')
                                ->paginate(30);

        $data['table']          = TimeSlot::getTableName();

        return view('time-slots.index', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("inv.config");

        return view('time-slots.create');

    }




    /*
    |--------------------------------------------------------------------------
    | STORE METHOD
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|unique:time_slots',
            'starting_time'     => 'required|before_or_equal:ending_time',
            'ending_time'       => 'required',
            'disable_at'        => 'required|before_or_equal:ending_time',
        ]);

        try {

            TimeSlot::create([
                'name'                  => $request->name,
                'starting_time'         => date('h:i A', strtotime($request->starting_time)),
                'ending_time'           => date('h:i A', strtotime($request->ending_time)),
                'disable_at'            => date('h:i A', strtotime($request->disable_at)),
                'status'                => !empty($request->status) ? 1 : 0,
            ]);

            return redirect()->route('inv.time-slots.index')->withMessage('Time Slot Successfully Created');

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

        return view('time-slots.edit', [
                'timeSlot'          => TimeSlot::findOrFail($id),
            ]);

    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $timeSlot = TimeSlot::find($id);

        $request->validate([
            'name'              => 'required|unique:time_slots,name,'.$timeSlot->id,
            'starting_time'     => 'required|before_or_equal:ending_time',
            'ending_time'       => 'required',
            'disable_at'        => 'required|before_or_equal:ending_time',
        ]);

        try {

            $timeSlot->update([
                'name'                  => $request->name,
                'starting_time'         => date('h:i A', strtotime($request->starting_time)),
                'ending_time'           => date('h:i A', strtotime($request->ending_time)),
                'disable_at'            => date('h:i A', strtotime($request->disable_at)),
                'status'                => !empty($request->status) ? 1 : 0,
            ]);

            return redirect()->route('inv.time-slots.index')->withMessage('Time Slot Successfully Updated');

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

        TimeSlot::destroy($id);
        return redirect()->back()->withMessage('Time Slot Successfully Deleted!');
    }
}
