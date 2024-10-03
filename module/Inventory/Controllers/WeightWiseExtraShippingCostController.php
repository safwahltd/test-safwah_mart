<?php

namespace Module\Inventory\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Module\Inventory\Models\WeightWiseExtraShippingCost;

class WeightWiseExtraShippingCostController extends Controller
{



    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $data['weightWiseExtraShippingCosts']       = WeightWiseExtraShippingCost::query()
                                                    ->when(request()->filled('from_weight'), function($q) use($request) {
                                                        $q->where('from_weight', '>=', $request->from_weight);
                                                    })
                                                    ->when(request()->filled('to_weight'), function($q) use($request) {
                                                        $q->where('to_weight', '<=', $request->to_weight);
                                                    })
                                                    ->orderBy('id', 'DESC')
                                                    ->paginate(30);

        $data['table']                              = WeightWiseExtraShippingCost::getTableName();

        return view('weight-wise-extra-shipping-cost/index', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('weight-wise-extra-shipping-cost/create');

    }




    /*
    |--------------------------------------------------------------------------
    | STORE METHOD
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {

        $request->validate([
            'from_weight'   => 'required|unique_with:inv_weight_wise_extra_shipping_costs, from_weight, to_weight',
            'to_weight'     => 'required|unique_with:inv_weight_wise_extra_shipping_costs, to_weight, from_weight',
        ]);

        try {

            WeightWiseExtraShippingCost::create([
                'from_weight'           => $request->from_weight,
                'to_weight'             => $request->to_weight,
                'extra_cost'            => $request->extra_cost ?? 0,
                'status'                => !empty($request->status) ? 1 : 0,
            ]);

            return redirect()->route('inv.weight-wise-extra-shipping-costs.index')->withMessage('Weight Wise Extra Shipping Cost Successfully Created');

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
        return view('weight-wise-extra-shipping-cost/edit', [
            'weightWiseExtraShippingCost' => WeightWiseExtraShippingCost::find($id),
        ]);

    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $weightWiseExtraShippingCost = WeightWiseExtraShippingCost::find($id);
       
        $request->validate([
            'from_weight'   => 'required|unique_with:inv_weight_wise_extra_shipping_costs, from_weight, to_weight,' . $weightWiseExtraShippingCost->id,
            'to_weight'     => 'required|unique_with:inv_weight_wise_extra_shipping_costs, to_weight, from_weight,' . $weightWiseExtraShippingCost->id,
        ]);

        try {

            $weightWiseExtraShippingCost->update([
                'from_weight'           => $request->from_weight,
                'to_weight'             => $request->to_weight,
                'extra_cost'            => $request->extra_cost ?? 0,
                'status'                => !empty($request->status) ? 1 : 0,
            ]);

            return redirect()->route('inv.weight-wise-extra-shipping-costs.index')->withMessage('Weight Wise Extra Shipping Cost Successfully Updated');

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
        try {

            $weightWiseExtraShippingCost = WeightWiseExtraShippingCost::where('id', $id)->with('orders')->first();

            if (count($weightWiseExtraShippingCost->orders) > 0) {
                return redirect()->back()->withError('You can not delete this Extra Shipping Cost');
            }

            $weightWiseExtraShippingCost->delete();


        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        return redirect()->back()->withMessage('Weight Wise Extra Shipping Cost Successfully Deleted!');
    }
}
