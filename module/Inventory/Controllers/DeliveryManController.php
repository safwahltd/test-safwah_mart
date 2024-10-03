<?php

namespace Module\Inventory\Controllers;

use App\Models\Area;
use App\Models\User;
use App\Models\District;
use App\Models\EcomSetting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Module\Inventory\Models\DeliveryMan;
use Module\Permission\Models\Permission;
use Module\Permission\Models\PermissionUser;


class DeliveryManController extends Controller
{


    /*
     |--------------------------------------------------------------------------
     | DELIVERY TYPES METHOD
     |--------------------------------------------------------------------------
    */
    public function deliveryTypes()
    {
        $deliveryTypes = ['Courier', 'Person'];

        return $deliveryTypes;
    }




    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        $data['deliveryMans']   = DeliveryMan::query()
                                ->searchByField('delivery_type')
                                ->searchByField('name')
                                ->searchByField('district_id')
                                ->searchByField('area_id')
                                ->latest()
                                ->paginate(30);

        $data['deliveryTypes']  = $this->deliveryTypes();

        $data['table']          = DeliveryMan::getTableName();
        $data['areas']          = Area::where('status',1)->orderBy('name','ASC')->get();
        $data['districts']      = District::where('status',1)->orderBy('name','ASC')->get();

        return view('delivery-man.index', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('delivery-man/create', [
            'deliveryTypes'     => $this->deliveryTypes(),
            'areas'             => Area::where('status',1)->orderBy('name','ASC')->get(),
            'districts'         => District::where('status',1)->orderBy('name','ASC')->get(),
        ]);
    }




    /*
    |--------------------------------------------------------------------------
    | STORE METHOD
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {

        $request->validate([
            'delivery_type'     => 'required',
            'name'              => 'required',
            'phone'             => 'required|unique:users',
            'email'             => 'nullable|email|unique:users',
            // 'phone'             => 'required|unique:inv_delivery_mans',
            // 'email'             => 'nullable|email|unique:inv_delivery_mans',
        ]);
        // dd($request->all());
        try {
            $user = User::create([

                'type'              => 'Delivery Man',
                'name'              => $request->name,
                'password'          => $request->password ? Hash::make($request->password) : Hash::make(Str::random(8)),
                'phone'             => $request->phone,
                'email'             => $request->email,
                'created_by'        => auth()->id(),
            ]);

            DeliveryMan::create([

                'user_id'           => $user->id,
                'delivery_type'     => $request->delivery_type,
                'name'              => $request->name,
                'district_id'       => $request->district_id,
                'area_id'           => $request->area_id,
                'phone'             => $request->phone,
                'email'             => $request->email,
                'address'           => $request->address,
                'status'            => !empty($request->status) ? 1 : 0,
                'created_by'        => auth()->id(),
            ]);

            return redirect()->route('inv.delivery-mans.index')->withMessage('Delivery Man Successfully Created');

        } catch(\Exception $ex) {
            // return redirect()->back()->withError($ex->getMessage());
            return redirect()->back();
        }
    }




    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        return view('delivery-man.edit', [
                'deliveryMan'       => DeliveryMan::findOrFail($id),
                'deliveryTypes'     => $this->deliveryTypes(),
                'areas'             => Area::where('status',1)->orderBy('name','ASC')->get(),
                'districts'         => District::where('status',1)->orderBy('name','ASC')->get()
            ]);
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $deliveryMan = DeliveryMan::find($id);
        $user = User::find($deliveryMan->user_id);

        $request->validate([
            'delivery_type'     => 'required',
            'name'              => 'required|unique:inv_delivery_mans,name,'.$deliveryMan->id,
            'phone'             => 'required|unique:users,phone,'.$deliveryMan->user_id,
            'email'             => 'nullable|email|unique:users,email,'.$deliveryMan->user_id,
            // 'phone'             => 'required|unique:inv_delivery_mans,phone,'.$deliveryMan->id,
            // 'email'             => 'nullable|email|unique:inv_delivery_mans,email,'.$deliveryMan->id,
        ]);

        try {

            $user->update([
                'name'              => $request->name,
                'phone'             => $request->phone,
                'email'             => $request->email,
                'updated_by'        => auth()->id(),
            ]);


            $deliveryMan->update([

                'delivery_type'     => $request->delivery_type,
                'name'              => $request->name,
                'district_id'       => $request->district_id,
                'area_id'           => $request->area_id,
                'phone'             => $request->phone,
                'email'             => $request->email,
                'address'           => $request->address,
                'status'            => !empty($request->status) ? 1 : 0,
                'updated_by'         => auth()->id(),
            ]);

            return redirect()->route('inv.delivery-mans.index')->withMessage('Delivery Man Successfully Updated');

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
        $deliveryMan = DeliveryMan::find($id);
        DeliveryMan::destroy($id);
        $deliveryMan->user->delete();
        return redirect()->back()->withMessage('Delivery Man Successfully Deleted!');
    }







    /*
     |--------------------------------------------------------------------------
     | GET AREAS BY DISTRICT METHOD
     |--------------------------------------------------------------------------
    */
    public function getAreasByDistrict(Request $request) // id == district_id
    {
        return  Area::query()
                    ->when(request()->filled('district_id') || isset($request->district_id), function($qr) use($request) {
                        $qr->where('district_id', $request->district_id);
                    })
                    ->orderBy('name','ASC')
                    ->get(['id', 'name', 'district_id', 'min_purchase_amount', 'free_delivery_amount']);
    }







    /*
     |--------------------------------------------------------------------------
     | DELIVERY DISCOUNT METHOD
     |--------------------------------------------------------------------------
    */
    public function deliveryDiscount()
    {

        if (auth()->id() != 1) {
            $permission_ids = Permission::whereIn('slug', ["orders.free-deliveries", "orders.cod-charge"])->pluck('id')->toArray();
            if (count($permission_ids) > 0) {
                $permission_user = PermissionUser::whereIn('permission_id', $permission_ids)->where('user_id', auth()->id())->first();
                if (!$permission_user) {
                    redirect('/')->send();
                }
            } else {
                redirect('/')->send();
            }
        }

        $ecomSettings = EcomSetting::whereIn('id', [38,39,40,41,42,43,44])->get();

        return view('delivery-discount.index', compact('ecomSettings'));
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE DELIVERY DISCOUNT METHOD
     |--------------------------------------------------------------------------
    */
    public function updateDeliveryDiscountSetting(Request $request)
    {

        try {

            $ecomSettings = $request->except('_token','_method');

            foreach ($ecomSettings['id'] as $idKey => $ecomId) {

                if (isset($ecomSettings['value'][$ecomId])) {

                    if ($ecomId == 39) {
                        EcomSetting::find(39)->update([ 'value' => $ecomSettings['value'][39] ]);
                    }
                    elseif ($ecomId == 41) {
                        EcomSetting::find(41)->update([ 'value' => $ecomSettings['value'][41] ]);
                    }
                    elseif ($ecomId == 43) {
                        EcomSetting::find(43)->update([ 'value' => $ecomSettings['value'][43] ]);
                    }
                    elseif ($ecomId == 44) {
                        EcomSetting::find(44)->update([ 'value' => $ecomSettings['value'][44] ]);
                    }
                    else{
                        EcomSetting::find($ecomId)->update([ 'value' => 'on' ]);
                    }
                }
                else{
                    if($ecomId == 39 || $ecomId == 41 || $ecomId == 43 || $ecomId == 44){
                        continue;
                    }
                    else{
                        EcomSetting::find($ecomId)->update([ 'value' => 'off' ]);
                    }
                }

            }

            return redirect()->back()->withMessage('Delivery Discount Setting Updated Successfully!');

        } catch(\Exception $ex) {

            return redirect()->back()->withError($ex->getMessage());
        }
    }




}
