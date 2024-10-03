<?php

namespace Module\Inventory\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Module\Inventory\Models\Coupon;
use App\Traits\CheckPermission;

class CouponController extends Controller
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

        $data['coupons']    = Coupon::orderBy('id', 'DESC')->paginate(30);
        $data['table']      = Coupon::getTableName();

        return view('coupon/index', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("inv.config");

        return view('coupon/create');
    }





    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'use_type'           => 'required',
            'name'               => 'required|unique:inv_coupons',
            'code'               => 'required|unique:inv_coupons',
            'discount_type'      => 'required',
            'amount'             => 'required',
            'max_price_discount' => 'nullable',
            'start_date'         => 'required',
            'end_date'           => 'required',
        ]);

        try {

            Coupon::create([
                'use_type'            => $request->use_type,
                'name'                => $request->name,
                'code'                => $request->code,
                'discount_type'       => $request->discount_type,
                'amount'              => $request->amount,
                'max_price_discount'  => $request->max_price_discount ?? 0,
                'start_date'          => $request->start_date,
                'end_date'            => $request->end_date,
                'is_highlight'        => !empty($request->is_highlight) ? 'Yes' : 'No',
                'description'         => $request->description,
                'status'              => !empty($request->status) ? 1 : 0,
                'coupon_apply_status' => !empty($request->coupon_apply_status) ? 1 : 0,
            ]);
        } catch (\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        return redirect()->route('inv.coupons.index')->withMessage('Coupon Successfully Created');
    }





    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $this->hasAccess("inv.config");

        $data['coupon']    = Coupon::find($id);
        return view('coupon/edit', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $coupon    = Coupon::find($id);

        $request->validate([
            'use_type'           => 'required',
            'name'               => 'required|unique:inv_coupons,name,' . $coupon->id,
            'code'               => 'required|unique:inv_coupons,code,' . $coupon->id,
            'discount_type'      => 'required',
            'amount'             => 'required',
            'max_price_discount' => 'nullable',
            'start_date'         => 'required',
            'end_date'           => 'required',
        ]);

        try {

            $coupon->update([
                'use_type'            => $request->use_type,
                'name'                => $request->name,
                'code'                => $request->code,
                'discount_type'       => $request->discount_type,
                'amount'              => $request->amount,
                'max_price_discount'  => $request->max_price_discount ?? 0,
                'start_date'          => $request->start_date,
                'end_date'            => $request->end_date,
                'is_highlight'        => !empty($request->is_highlight) ? 'Yes' : 'No',
                'description'         => $request->description,
                'status'              => !empty($request->status) ? 1 : 0,
                'coupon_apply_status' => !empty($request->coupon_apply_status) ? 1 : 0,
            ]);
        } catch (\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        return redirect()->route('inv.coupons.index')->withMessage('Coupon Successfully Created');
    }




    /*
     |--------------------------------------------------------------------------
     | DELETE/DESTORY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $this->hasAccess("inv.config");

        try {
            Coupon::find($id)->delete();
        } catch (\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        return redirect()->back()->withMessage('Coupon Successfully Deleted!');
    }
}
