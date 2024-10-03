<?php

namespace Module\Inventory\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Module\Inventory\Models\OrderAmountWiseShippingCostDiscount;

class OrderAmountWiseShippingCostDiscountController extends Controller
{



    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $data['items']      = OrderAmountWiseShippingCostDiscount::query()
                            ->when(request()->filled('from_amount'), function($q) use($request) {
                                $q->where('from_amount', '>=', $request->from_amount);
                            })
                            ->when(request()->filled('to_amount'), function($q) use($request) {
                                $q->where('to_amount', '<=', $request->to_amount);
                            })
                            ->orderBy('id', 'DESC')
                            ->paginate(30);

        $data['table']      = OrderAmountWiseShippingCostDiscount::getTableName();

        return view('order-amount-wise-shipping-cost-discount/index', $data);
    }




    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('order-amount-wise-shipping-cost-discount/create');
    }




    /*
    |--------------------------------------------------------------------------
    | STORE METHOD
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {

        $request->validate([
            'from_amount'   => 'required|unique_with:inv_order_amount_wise_shipping_cost_discounts, from_amount, to_amount',
            'to_amount'     => 'required|unique_with:inv_order_amount_wise_shipping_cost_discounts, to_amount, from_amount',
            'discount'      => 'required',
        ]);

        try {

            OrderAmountWiseShippingCostDiscount::create([
                'from_amount'           => $request->from_amount,
                'to_amount'             => $request->to_amount,
                'discount'              => $request->discount ?? 0,
                'status'                => !empty($request->status) ? 1 : 0,
            ]);

            return redirect()->route('inv.shipping-cost-discounts.index')->withMessage('Order Amount Wise Shipping Cost Discount Successfully Created');

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
        return view('order-amount-wise-shipping-cost-discount/edit', [
            'item' => OrderAmountWiseShippingCostDiscount::find($id),
        ]);

    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $item = OrderAmountWiseShippingCostDiscount::find($id);
       
        $request->validate([
            'from_amount'   => 'required|unique_with:inv_order_amount_wise_shipping_cost_discounts, from_amount, to_amount,' . $item->id,
            'to_amount'     => 'required|unique_with:inv_order_amount_wise_shipping_cost_discounts, to_amount, from_amount,' . $item->id,
            'discount'      => 'required'
        ]);

        try {

            $item->update([
                'from_amount'           => $request->from_amount,
                'to_amount'             => $request->to_amount,
                'discount'              => $request->discount ?? 0,
                'status'                => !empty($request->status) ? 1 : 0,
            ]);

            return redirect()->route('inv.shipping-cost-discounts.index')->withMessage('Order Amount Wise Shipping Cost Discount Successfully Updated');

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
            $orderAmountWiseShippingCostDiscount = OrderAmountWiseShippingCostDiscount::where('id', $id)->with('orders')->first();

            if (count($orderAmountWiseShippingCostDiscount->orders) > 0) {
                return redirect()->back()->withError('You can not delete this Discount');
            }

            $orderAmountWiseShippingCostDiscount->delete();

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        return redirect()->back()->withMessage('Order Amount Wise Shipping Cost Discount Successfully Deleted!');
    }
}
