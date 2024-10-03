<?php

namespace Module\Inventory\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Module\Inventory\Models\DeliveryMan;
use Module\Inventory\Models\DeliveryManTimeSlot;
use Module\Inventory\Models\TimeSlot;

class DeliveryManTimeSlotController extends Controller
{



    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        $data['deliveryManTimeslots']       = DeliveryManTimeSlot::query()
                                                ->searchByField('time_slot_id')
                                                ->searchByField('delivery_man_id')
                                                ->latest()
                                                ->paginate(30);

        $data['table']                      = DeliveryManTimeSlot::getTableName();
        $data['timeSlots']                  = TimeSlot::where('status',1)->latest()->get();
        $data['delivery_mans']              = DeliveryMan::where('status',1)->latest()->get();

        return view('delivery-man-time-slots.index', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $data['timeSlots']          = TimeSlot::where('status',1)->latest()->get();
        $data['delivery_mans']      = DeliveryMan::where('status',1)->latest()->get();

        return view('delivery-man-time-slots.create', $data);

    }




    /*
    |--------------------------------------------------------------------------
    | STORE METHOD
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {

        $request->validate([
            'time_slot_id'          => 'required',
            'delivery_man_id'       => 'required',
        ]);

        try {

            DeliveryManTimeSlot::create([
                'time_slot_id'          => $request->time_slot_id,
                'delivery_man_id'       => $request->delivery_man_id,
                'status'                => !empty($request->status) ? 1 : 0,
                'created_by'            => auth()->id(),
            ]);

            return redirect()->route('inv.delivery-man-time-slots.index')->withMessage('Delivery Man Time Slot Successfully Created');

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
        $data['deliveryManTimeSlot']    = DeliveryManTimeSlot::findOrFail($id);
        $data['timeSlots']              = TimeSlot::where('status',1)->latest()->get();
        $data['delivery_mans']          = DeliveryMan::where('status',1)->latest()->get();

        return view('delivery-man-time-slots.edit', $data);

    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $deliveryManTimeSlot = DeliveryManTimeSlot::find($id);


        $request->validate([
            'time_slot_id'          => 'required',
            'delivery_man_id'       => 'required',
        ]);

        try {

            $deliveryManTimeSlot->update([
                'time_slot_id'          => $request->time_slot_id,
                'delivery_man_id'       => $request->delivery_man_id,
                'status'                => !empty($request->status) ? 1 : 0,
                'updated_by'            => auth()->id(),
            ]);

            return redirect()->route('inv.delivery-man-time-slots.index')->withMessage('Delivery Man Time Slot Successfully Updated');

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
        DeliveryManTimeSlot::destroy($id);
        return redirect()->back()->withMessage('Delivery Man Time Slot Successfully Deleted!');
    }
}
