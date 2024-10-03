<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\Account\Models\Account;
use Module\Inventory\Models\Order;
use Module\Inventory\Models\CustomerType;
use Module\Inventory\Models\OrderDetail;
use Module\Product\Models\Product;

class CustomQueryController extends Controller
{


    /*
     |-------------------------------------------------------
     | ADD THUMBNAIL IMAGE FROM IMAGE IN PdtProducts QUERY
     |-------------------------------------------------------
    */
    public function addThumbnailImageFromImageInPdtProducts(){

        $products = Product::where('thumbnail_image', Null)->get();

        foreach ($products as $key => $product) {

            $product->update(['thumbnail_image' => $product->image]);

        }

        return redirect()->route('home')->withMessage('Successfully Add Thumbnail Image in Product Table');
    }



    /*
     |-------------------------------------------------------
     | ADD AccCustomers FROM IN InvCustomers QUERY
     |-------------------------------------------------------
    */
    public function addAccCustomersFromInvCustomers()
    {
        DB::transaction(function () {
            $invCustomers = \Module\Inventory\Models\Customer::with('customer_type')->orderBy('id', 'ASC')->get();

            foreach ($invCustomers as $invCustomer) {

                $account = Account::create([

                    'name'                  => $invCustomer->name,
                    'account_group_id'      => 1,
                    'account_control_id'    => 1,
                    'account_subsidiary_id' => 8,
                    // 'opening_balance'       => $request->opening_balance ?? 0,
                    'opening_balance'       => 0,
                    'balance_type'          => 'Debit'
                ]);

                if ($invCustomer->customer_type != null) {
                    CustomerType::updateOrCreate(['id' => $invCustomer->customer_type_id], [
                        'name' => optional($invCustomer->customer_type)->name,
                        'percentage' => optional($invCustomer->customer_type)->percentage,
                        'status' => optional($invCustomer->customer_type)->status,
                    ]);
                }

                $customer = \Module\Account\Models\Customer::updateOrCreate(['id' => $invCustomer->id], [
                    'account_id'        => $account->id,
                    'user_id'           => $invCustomer->user_id,
                    'register_from'     => $invCustomer->register_from,
                    'name'              => $invCustomer->name,
                    'email'             => $invCustomer->email,
                    'mobile'            => $invCustomer->phone,
                    'gender'            => $invCustomer->gender,
                    'address'           => $invCustomer->address,
                    'country'           => $invCustomer->country,
                    'zip_code'          => $invCustomer->zip_code,
                    'is_default'        => $invCustomer->is_default,
                    'opening_balance'   => $invCustomer->opening_balance,
                    'current_balance'   => $invCustomer->current_balance,
                    'created_at'        => $invCustomer->created_at,
                    'updated_at'        => $invCustomer->updated_at,
                ]);

                // $customer->update(['customer_type_id' => $invCustomer->customer_type_id]);

            }
        });

        return redirect()->back()->withMessage('Add Acc Customer from Inv Customer Successfully');
    }






    /*
     |-------------------------------------------------------
     | ADD CURRENT STATUS VALUE IN InvOrders QUERY
     |-------------------------------------------------------
    */
    public function addCurrentStatusValueInInvOrders()
    {
        DB::transaction(function () {
            $invOrders = Order::with('order_status')->get();

            foreach ($invOrders as $invOrder) {

                $invOrder->update(['current_status' => 1, 'payment_type' => 'COD']);

                $invOrder->order_status()->delete();

                $invOrder->order_status()->create([
                    'status_id'     => 1
                ]);
            }
        });
        return redirect()->back()->withMessage('Add Current Status Value in Inv Orders Successfully');
    }






    /*
     |-------------------------------------------------------
     |  SOLVE 220627521 ORDER ISSUE
     |-------------------------------------------------------
    */
    public function solve220627521OrderIssue()
    {
        OrderDetail::where('id', '1951')->update([
            'discount_percent' => 0,
            'discount_amount' => 0,
        ]);

        Order::where('id', '732')->update([
            'total_discount_amount' => 0
        ]);
    }






    /*
     |-------------------------------------------------------
     |  SOLVE ORDERS DISCOUNT ISSUE
     |-------------------------------------------------------
    */
    public function solveOrdersDiscountIssue()
    {
        DB::transaction(function () {
            $orders = Order::with('orderDetails')->get();

            foreach($orders as $order) {
                $totalDiscountAmount = 0;
    
                foreach($order->orderDetails as $orderDetail) {
                    $discountAmount = $orderDetail->discount_percent > 0 ? $orderDetail->sale_price - ($orderDetail->sale_price - ( $orderDetail->sale_price * $orderDetail->discount_percent / 100 )) : 0;
                    $totalDiscountAmount += $discountAmount;
    
                    $orderDetail->update([
                        'discount_amount' => $discountAmount
                    ]);
                }
    
                $order->update([
                    'total_discount_amount' => $totalDiscountAmount
                ]);
            }
        });

        return redirect()->back()->withMessage('Order Discount Issue Solved Successfully');
    }






    /*
     |-------------------------------------------------------
     | ADD SHIPPING COST IN 220717712 ORDER
     |-------------------------------------------------------
    */
    public function addShippingCostIn220717712Order()
    {
        Order::where('order_no', 220717712)->update(['shipping_cost' => 19]);

        return redirect()->back()->withMessage('ADD SHIPPING COST IN 220717712 ORDER SUCCESSFULLY');
    }






    /*
     |-------------------------------------------------------
     | ADD QUANTITY IN 2985 ORDER DETAIL
     |-------------------------------------------------------
    */
    public function addQuantityIn2985OrderDetail()
    {
        $orderDetail = OrderDetail::where('id', 2985)->first();
        $discountAmount = $orderDetail->sale_price - ($orderDetail->sale_price - ( $orderDetail->sale_price * $orderDetail->discount_percent / 100 ));
        
        $orderDetail->update([
            'quantity' => 1,
            'discount_amount' => $discountAmount,
        ]);


        $order = Order::where('id', 1047)->with('orderDetails')->first();

        $subtotal = 0;
        $total_discount_amount = 0;

        foreach($order->orderDetails as $orderDtl) {
            $subtotal += $orderDtl->sale_price * $orderDtl->quantity;
            $total_discount_amount += $orderDtl->discount_amount * $orderDtl->quantity;
        }
        
        $order->update([
            'subtotal'              => $subtotal,
            'total_discount_amount' => $total_discount_amount,
        ]);

        return redirect()->back()->withMessage('ADD QUANTITY IN 2985 ORDER DETAIL SUCCESSFULLY');
    }
}
