<?php

namespace Module\Inventory\Controllers\Api;

use App\Models\User;
use App\Traits\FileSaver;
use Illuminate\Http\Request;
use App\Traits\SmsNotification;
use App\Services\RegisterService;
use Illuminate\Support\Facades\DB;
use Module\Inventory\Models\Order;
use Module\Product\Models\Product;
use Module\Inventory\Models\Coupon;
use Module\Inventory\Models\Cuppon;
use App\Http\Controllers\Controller;
use App\Models\PointSetting;
use Module\Inventory\Models\Customer;
use Module\Inventory\Models\TimeSlot;
use Module\WebsiteCMS\Models\Wishlist;
use Module\Product\Models\StockRequest;
use Module\Inventory\Models\OrderReturn;
use Module\Inventory\Models\OrderStatus;
use Module\Inventory\Models\OrderStauts;
use Module\Product\Models\ProductReview;
use Module\Inventory\Models\ReturnReason;
use Module\Inventory\Services\OrderService;
use Module\WebsiteCMS\Models\CorporateOrder;
use Module\WebsiteCMS\Models\OrderByPicture;
use Module\WebsiteCMS\Models\AppointmentBooking;
use Module\Inventory\Models\ProductSupplyRequest;
use Module\Inventory\Services\OrderReturnService;
use Module\WebsiteCMS\Services\JsonResponseService;
use Module\Account\Models\Customer as AccountCustomer;
use Module\Account\Services\AccountTransactionService;
use Module\Inventory\Models\WeightWiseExtraShippingCost;
use Module\Inventory\Models\ProductSupplyRequestAttachment;
use Module\Inventory\Models\OrderAmountWiseShippingCostDiscount;
use Module\Inventory\Services\CustomerPointService;
use Module\Inventory\Services\CustomerWalletService;

class ApiController extends Controller
{
    use FileSaver;

    use SmsNotification;
    private $registerService, $orderService;
    private $jsonResponseService;
    private $status, $message;
    public $orderReturnService;
    public $accTransactionService;
    public $customerPointService;
    public $customerWalletService;



    /*
     |--------------------------------------------------------------------------
     | CONSTRUCTOR
     |--------------------------------------------------------------------------
    */
    public function __construct(RegisterService $registerService, OrderService $orderService, JsonResponseService $jsonResponseService)
    {
        $this->registerService = $registerService;
        $this->orderService = $orderService;
        $this->jsonResponseService = $jsonResponseService;
        $this->orderReturnService = new OrderReturnService;
        $this->accTransactionService = new AccountTransactionService;
        $this->customerPointService = new CustomerPointService;
        $this->customerWalletService = new CustomerWalletService;
    }



    /*
     |--------------------------------------------------------------------------
     | UPDATE CUSTOMER
     |--------------------------------------------------------------------------
    */

    public function updateCustomer(Request $request)
    {
        return $request->all();
    }





    /*
     |--------------------------------------------------------------------------
     |  OTP
     |--------------------------------------------------------------------------
    */

    public function getOTP($phone)
    {
        $user = User::where('phone', $phone)->first();

        if ($user) {

            $myOTP = random_int(1000, 9999);
            session()->put('myOTP', $myOTP);

            $this->sendSmsNotification("Your Verification OTP is " . $myOTP, $phone);
            return response()->json([
                'success' => 'We will send an OTP in this Phone Number',
                'myOTP' => session()->get('myOTP'),
                'user' => 'Not Exist',
            ]);
        } else {

            $myOTP = random_int(1000, 9999);
            session()->put('myOTP', $myOTP);

            $this->sendSmsNotification("Your Verification OTP is " . $myOTP, $phone);
            return response()->json([
                'success' => 'We will send an OTP in this Phone Number',
                'myOTP' => session()->get('myOTP'),
                'user' => 'Not Exist',
            ]);
        }
    }








    /*
     |--------------------------------------------------------------------------
     |  GET COUPON
     |--------------------------------------------------------------------------
    */
    public function getCoupon(Request $request)
    {
        try {

            $coupon         = Coupon::query()
                ->where('code', $request->coupon_code)
                ->withCount(['couponUses' => function ($q) use ($request) {
                    $q->where('customer_id', $request->customer_id);
                }]);

            $cloneCoupon    = clone $coupon;

            $isExpired      = $cloneCoupon->where('start_date', '<=', date('Y-m-d'))
                ->where('end_date', '>=', date('Y-m-d'))
                ->first();

            $coupon         = $coupon->first();

            if ($coupon == null) {

                return response()->json([
                    'status'    => 0,
                    'message'   => 'Coupon Not Found!',
                    'data'      => ''
                ]);
            }

            if ($coupon != null && $isExpired == null) {

                return response()->json([
                    'status'    => 0,
                    'message'   => 'Coupon has been Expired!',
                    'data'      => ''
                ]);
            }

            if ($coupon != null) {

                if ($coupon->status == 0) {
                    return response()->json([
                        'status'    => 0,
                        'message'   => 'Coupon Not Available!',
                        'data'      => ''
                    ]);
                }

                if ($coupon->use_type == 'Once' && $coupon->coupon_uses_count > 0) {
                    return response()->json([
                        'status'    => 0,
                        'message'   => 'Coupon Already Used!',
                        'data'      => ''
                    ]);
                }

                return response()->json([
                    'status'    => 1,
                    'message'   => 'Coupon has been applied successfully!',
                    'data'      => $coupon
                ]);
            }
        } catch (\Throwable $th) {

            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
                'data' => ''
            ]);
        }
    }






    /*
     |--------------------------------------------------------------------------
     | SUBMIT ORDER
     |--------------------------------------------------------------------------
    */
    public function submitOrder(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {

                $user = $this->registerService->store($request);

                $customer = $this->registerService->storeCustomer($request, $user->id);

                $this->orderService->storeOrder($request, $customer->id);
            });

            $this->status   = 1;
            $this->message  = 'Order has been placed successfully!';
        } catch (\Throwable $th) {

            $this->status   = 0;
            $this->message  = 'Something went wrong! ' . $th->getMessage();
        }

        return response()->json([
            'status'    => $this->status,
            'message'   => $this->message,
        ]);
    }







    /*
     |--------------------------------------------------------------------------
     | CUSTOMER ORDERS
     |--------------------------------------------------------------------------
    */
    public function getCustomerOrders($id)
    {
        $orders = Order::query()->where('customer_id', $id);

        return $this->jsonResponseService->get($orders, 'orders');
    }











    /*
     |--------------------------------------------------------------------------
     | ORDER SHOW
     |--------------------------------------------------------------------------
    */
    public function orderShow($id)
    {
        $order = Order::query()
            ->with('company', 'customer', 'timeSlot')
            ->with(['orderCustomerInfo' => function ($q) {
                $q->with('district:id,name')
                    ->with('area:id,name');
            }])
            ->with(['order_status' => function ($q) {

                $q->with('status');
            }])->with(['orderDetails' => function ($q) {

                $q->with('product', 'productVariation');
            }])->where('id', $id);


        return $this->jsonResponseService->find($order, 'order');
    }









    /*
     |--------------------------------------------------------------------------
     | CUSTOMER WISHLISTS
     |--------------------------------------------------------------------------
    */

    public function customerWishlists($id)
    {
        $wishlists = Wishlist::query()
            ->with(['product' => function ($q) {
                $q->with('unitMeasure:id,name')
                    ->with(['discount' => function ($q) {
                        $q->active()
                            ->select('id', 'product_id', 'discount_percentage', 'discount_amount', 'start_date', 'end_date');
                    }])
                    ->withSum('stockSummaries as current_stock', 'balance_qty')
                    ->with('productMeasurements');
            }])
            ->where('user_id', $id);

        return $this->jsonResponseService->get($wishlists, 'wishlists');
    }


    /*
     |--------------------------------------------------------------------------
     | GET ALL ORDERS BY CUSTOMER
     |--------------------------------------------------------------------------
    */
    public function getAllOrdersByCustomer($customer_id)
    {
        $orders = Order::query()
            ->where('customer_id', $customer_id)
            ->with('order_status', function ($q) {
                $q->with('status');
            })
            ->with(['orderDetails' => function ($q) {
                $q->with(['product' => function ($q) {
                    $q->with('unitMeasure:id,name');
                }]);
            }])
            ->with('customer', 'orderCustomerInfo')
            ->orderBy('id', 'DESC');


        return $this->jsonResponseService->get($orders, 'orders');
    }








    /*
     |--------------------------------------------------------------------------
     | GET SINGLE ORDER BY ORDER ID
     |--------------------------------------------------------------------------
    */
    public function getSingleOrder($order_id)
    {
        $orders = Order::query()
            ->with('customer', 'orderCustomerInfo')
            ->with(['order_status' => function ($q) {

                $q->with('status');
            }])->with(['orderDetails' => function ($q) {

                $q->with(['product' => function ($q) {
                    $q->with('unitMeasure:id,name');
                }])
                    ->with('productVariation');
            }])->where('id', $order_id);

        return $this->jsonResponseService->find($orders, 'order');
    }






    public function updateSingleOrder(Request $request, $order_id)
    {
        try {

            $order = Order::find($order_id);

            if ($request->ship_to_different_address == "Yes") {

                $order->orderCustomerInfo->update([
                    'receiver_name'             => $request->name,
                    'receiver_email'            => $request->email,
                    'receiver_phone'            => $request->phone,
                    'receiver_district_id'      => $request->district_id,
                    'receiver_area_id'          => $request->area_id,
                    'receiver_address'          => $request->address,
                    'receiver_order_note'       => $request->order_note,
                    'receiver_zip_code'         => $request->zip_code,
                ]);
            } else {

                $order->orderCustomerInfo->update([

                    'name'              => $request->name,
                    'email'             => $request->email,
                    'district_id'       => $request->district_id,
                    'area_id'           => $request->area_id,
                    'address'           => $request->address,
                    'order_note'        => $request->order_note,
                    'zip_code'          => $request->zip_code,
                ]);


                $order->customer->update([
                    'name'          => $request->name,
                    'email'         => $request->email,
                    'district_id'   => $request->district_id,
                    'area_id'       => $request->area_id,
                    'address'       => $request->address,
                    'zip_code'      => $request->zip_code,
                ]);


                $order->customer->user->update([
                    'name'          => $request->name,
                    'email'         => $request->email
                ]);
            }


            $order->update([
                'shipping_cost' => $request->shipping_cost
            ]);


            return response()->json([
                'status'    => 1,
                'message'   => 'Order has been updated successfully',
            ]);
        } catch (\Exception $ex) {

            return response()->json([
                'status'    => 0,
                'message'   => 'Order has not updated',
            ]);
        }
    }



    public function changeOrderStatus($id)
    {
        DB::transaction(function () use ($id) {

            $order = Order::where('id', $id)->first();

            $order->update([
                'current_status'    => 6,
            ]);

            $order->order_status()->create([
                'status_id' => 6
            ]);


            if ($order->wallet_amount > 0) {
                $order->customerWalletTransactions()->delete();
                $this->customerWalletService->updateCustomerWallet($order->customer_id, $order->wallet_amount);
            }

            if ($order->point_amount > 0) {
                $order->customerPointTransactions()->delete();
                $this->customerPointService->updateCustomerPoint($order->customer_id, $order->point_used);
            }
        });
    }






    /*
     |--------------------------------------------------------------------------
     | GET ALL STOCK REQUEST BY CUSTOMER
     |--------------------------------------------------------------------------
    */
    public function getAllStockRequestByCustomer($customer_id)
    {
        return $stockRequests   = StockRequest::query()
            ->with(['product' => function ($q) {
                $q->withSum('stockSummaries as current_stock', 'balance_qty');
            }])
            ->where('customer_id', $customer_id)
            ->orderBy('id', 'DESC')
            ->get();
    }



    /*
     |--------------------------------------------------------------------------
     | TIME SLOTS
     |--------------------------------------------------------------------------
    */
    public function timeSlots()
    {
        $timeSlots = TimeSlot::query();

        return $this->jsonResponseService->get($timeSlots, 'timeSlots');
    }






    /*
     |--------------------------------------------------------------------------
     | GET ORDER STATUS
     |--------------------------------------------------------------------------
    */
    public function getOrderStatus($id)
    {
        $orderStatus = OrderStatus::query()->with('order', 'status')->where('id', $id);

        return $this->jsonResponseService->find($orderStatus, 'orderStatus');
    }






    /*
     |--------------------------------------------------------------------------
     | SUBMIT SUPPLIER REQUEST
     |--------------------------------------------------------------------------
    */
    public function corporateOrderStore(Request $request)
    {
        try {
            $corporateOrder = CorporateOrder::create([
                'name'        => $request->name,
                'institution_name'        => $request->institution_name,
                'email'       => $request->email,
                'phone'       => $request->phone,
                'address'     => $request->address ?? '',
                'description' => $request->description ?? '',

            ]);

            if (isset($request->attachment)) {
                $this->upload_file($request->attachment, $corporateOrder, 'attachment', 'attachment/corporate-order');
            }

            return response()->json([
                'status'    => 1,
                'message'   => 'Data Submitted Successfully',
            ]);
        } catch (\Exception $ex) {

            return response()->json([
                'status'    => 0,
                'message'   => 'Something went wrong!',
            ]);
        }
    }




    /*
     |--------------------------------------------------------------------------
     | SUBMIT SUPPLIER REQUEST
     |--------------------------------------------------------------------------
    */
    public function orderByPictureStore(Request $request)
    {

        try {
            $orderByPicture = OrderByPicture::create([
                'name'        => $request->name,
                'email'       => $request->email,
                'phone'       => $request->phone,
                'address'     => $request->address,
                'description' => $request->description,
            ]);

            if (isset($request->attachment)) {
                $this->upload_file($request->attachment, $orderByPicture, 'attachment', 'attachment/orderby-picture');
            }

            return response()->json([
                'status'    => 1,
                'message'   => 'Data Submitted Successfully',
            ]);
        } catch (\Exception $ex) {

            return response()->json([
                'status'    => 0,
                'message'   => 'Something went wrong!',
            ]);
        }
    }




    /*
     |--------------------------------------------------------------------------
     | SUBMIT SUPPLIER REQUEST
     |--------------------------------------------------------------------------
    */
    public function appointmentBookingStore(Request $request)
    {
        try {
            AppointmentBooking::create([
                'name'        => $request->name,
                'email'       => $request->email,
                'phone'       => $request->phone,
                'description' => $request->description,
            ]);

            return response()->json([
                'status'    => 1,
                'message'   => 'Data Submitted Successfully',
            ]);
        } catch (\Exception $ex) {

            return response()->json([
                'status'    => 0,
                'message'   => 'Something went wrong!',
            ]);
        }
    }




    /*
     |--------------------------------------------------------------------------
     | SUBMIT SUPPLIER REQUEST
     |--------------------------------------------------------------------------
    */
    public function submitSupplierRequest(Request $request)
    {
        $ProductSupplyRequest = ProductSupplyRequest::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'address'     => $request->address,
            'description' => $request->description,

        ]);

        $this->uploadFileWithResize($request->attachment, $ProductSupplyRequest,  'attachment', 'attachment/supplier-request', 300, 300);
    }






    /*
     |--------------------------------------------------------------------------
     | GET WEIGHT WISE EXTRA SHIPPING COST
     |--------------------------------------------------------------------------
    */
    public function getWeightWiseExtraShippingCost(Request $request)
    {
        $extraShippingCost  = WeightWiseExtraShippingCost::query()
            ->where('from_weight', '<=', $request->weight)
            ->where('to_weight', '>=', $request->weight)
            ->active()
            ->select('id', 'extra_cost')
            ->first();

        $data['extra_shipping_cost_id'] = '';
        $data['extra_shipping_cost_amount'] = 0;

        if ($extraShippingCost) {
            $data['extra_shipping_cost_id'] = $extraShippingCost->id;
            $data['extra_shipping_cost_amount'] = $extraShippingCost->extra_cost;
        }

        return $data;
    }






    /*
     |--------------------------------------------------------------------------
     | GET ORDER AMOUNT WISE SHIPPING COST DISCOUNT
     |--------------------------------------------------------------------------
    */
    public function getOrderAmountWiseShippingCostDiscount(Request $request)
    {
        $shippingDiscount   = OrderAmountWiseShippingCostDiscount::query()
            ->where('from_amount', '<=', $request->subtotal)
            ->where('to_amount', '>=', $request->subtotal)
            ->active()
            ->select('id', 'discount')
            ->first();

        $data['shipping_cost_discount_id'] = '';
        $data['shipping_cost_discount_amount'] = 0;

        if ($shippingDiscount) {
            $data['shipping_cost_discount_id'] = $shippingDiscount->id;
            $data['shipping_cost_discount_amount'] = $shippingDiscount->discount;
        }

        return $data;
    }






    /*
     |--------------------------------------------------------------------------
     | REQUIRE POINT BY GRAND TOTAL
     |--------------------------------------------------------------------------
    */
    public function requirePointByGrandTotal(Request $request)
    {
        try {
            return response()->json([
                'status' => 1,
                'point' => requirePoint($request->grand_total)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'point' => 0
            ]);
        }
    }






    /*
     |--------------------------------------------------------------------------
     | GET POINT RATE
     |--------------------------------------------------------------------------
    */
    public function getPointRate()
    {
        try {
            $pointSetting = PointSetting::find(1);

            return response()->json([
                'status' => 1,
                'rate' => $pointSetting->value
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'rate' => 0
            ]);
        }
    }






    /*
     |--------------------------------------------------------------------------
     | GET MINIMUM POINT FOR WITHDRAW
     |--------------------------------------------------------------------------
    */
    public function getMinimumPointForWithdraw()
    {
        try {
            $pointSetting = PointSetting::find(2);

            return response()->json([
                'status' => 1,
                'min_point' => $pointSetting->value
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'min_point' => 0
            ]);
        }
    }




    /*
     |--------------------------------------------------------------------------
     | GET ORDER RETURNS (BY CUSTOMER)
     |--------------------------------------------------------------------------
    */
    public function getOrderReturns($id)
    {
        return  OrderReturn::query()
            ->with('timeSlot:id,starting_time,ending_time')
            ->with('deliveryMan:id,name,phone')
            ->where('customer_id', $id)
            ->get();
    }





    /*
     |--------------------------------------------------------------------------
     | SHOW ORDER RETURN (BY ID)
     |--------------------------------------------------------------------------
    */
    public function showOrderReturn($id)
    {
        return  OrderReturn::query()
            ->with(['orderReturnDetails' => function ($q) {
                $q->with(['product' => function ($q) {
                    $q->with('unitMeasure:id,name')
                        ->select('id', 'unit_measure_id', 'name', 'sku');
                }])
                    ->with('productVariation');
            }])
            ->with('timeSlot:id,starting_time,ending_time')
            ->with('deliveryMan:id,name,phone')
            ->with('company', 'order')
            ->with(['customer' => function ($q) {
                $q->with('area:id,name', 'district:id,name');
            }])
            ->where('id', $id)
            ->first();
    }





    /*
     |--------------------------------------------------------------------------
     | CREATE ORDER RETURN METHOD
     |--------------------------------------------------------------------------
    */
    public function createOrderReturn(Request $request)
    {
        $data['order']          = Order::query()
            ->where('order_no', $request->order_no)
            ->with(['orderDetails' => function ($q) {
                $q->with(['product' => function ($q) {
                    $q->with('unitMeasure:id,name')
                        ->select('id', 'unit_measure_id', 'name', 'sku', 'is_refundable', 'sub_text');
                }])
                    ->with('productVariation');
            }])
            ->with('customer:id,name')
            ->first();

        $data['returnReasons']  = ReturnReason::active()->get(['id', 'title']);

        return $data;
    }






    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function storeOrderReturn(Request $request)
    {
        try {

            $this->orderReturnService->storeOrderReturn($request);

            return response()->json([
                'status'    => 1,
                'message'   => 'Success',
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'status'    => 0,
                'message'   => $th->getMessage(),
            ]);
        }
    }






    /*
     |--------------------------------------------------------------------------
     | ORDER RETURN INVOICE METHOD
     |--------------------------------------------------------------------------
    */
    public function orderReturnInvoice($id)
    {
        return  OrderReturn::query()
            ->where('id', $id)
            ->first();
    }





    /*
     |--------------------------------------------------------------------------
     | DELETE ORDER RETURN METHOD
     |--------------------------------------------------------------------------
    */
    public function deleteOrderReturn($id)
    {
        try {

            $this->orderReturnService->deleteOrderReturn($id);

            return response()->json([
                'status'    => 1,
                'message'   => 'Success',
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'status'    => 0,
                'message'   => $th->getMessage(),
            ]);
        }
    }











    /*
     |--------------------------------------------------------------------------
     | ORDER HISTORIES
     |--------------------------------------------------------------------------
    */
    public function orderHistories($id)
    {
        return  Order::query()
            ->where('id', $id)
            ->with(['orderStatuses' => function ($q) {
                $q->with('status:id,name');
            }])
            ->first(['id', 'order_no']);
    }











    /*
     |--------------------------------------------------------------------------
     | PRODUCT REVIEWS
     |--------------------------------------------------------------------------
    */
    public function productReviews($id)
    {
        return  ProductReview::query()
            ->where('user_id', $id)
            ->with('product:id,name,sku,slug')
            ->get();
    }











    /*
     |--------------------------------------------------------------------------
     | GET ORDER CURRENT STATUS
     |--------------------------------------------------------------------------
    */
    public function getOrderCurrentStatus(Request $request)
    {
        $orders = Order::query()
            ->when($request->filled('order_no'), function ($q) use ($request) {
                $q->where('order_no', $request->order_no);
            })
            ->where(function ($q) use ($request) {
                $q->whereHas('customer', function ($qr) use ($request) {
                    $qr->where('mobile', $request->phone_or_email)
                        ->orWhere('email', $request->phone_or_email);
                })
                    ->whereHas('orderCustomerInfo', function ($qr) use ($request) {
                        $qr->where('phone', $request->phone_or_email)
                            ->orWhere('email', $request->phone_or_email);
                    });
            })
            ->with('currentStatus:id,name')
            ->select('current_status', 'order_no', 'id')
            ->orderBy('order_no', 'DESC')
            ->take(200)
            ->get();

        return response()->json([
            'status'      => 1,
            'orders'      => $orders,
            'order_count' => $orders->count()
        ]);
    }











    /*
     |--------------------------------------------------------------------------
     | GET CUSTOMER TYPE WISE DISCOUNT
     |--------------------------------------------------------------------------
    */
    public function getCustomerTypeWiseDiscount(Request $request)
    {
        try {
            $customer   = Customer::where('id', $request->customer_id)
                ->whereHas('customer_type', function ($q) {
                    $q->where('status', 1);
                })
                ->with('customer_type:id,name,percentage')
                ->first();

            $discount = 0;

            if ($customer) {
                $customerTypeDiscount = optional($customer->customer_type)->percentage;
                $discount = $request->grand_total * $customerTypeDiscount / 100;
            }

            return response()->json([
                'status' => 1,
                'message' => 'success',
                'discount' => $discount,
                'type' => $discount,
                'discount' => $discount
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => 'error',
                'discount' => 0
            ]);
        }
    }




    public function getOrderByTnxNo($tnx_no)
    {
        return Order::where('payment_tnx_no', $tnx_no)->select('payment_status')->first();
    }




    public function updateOrderPaymentStatus(Request $request)
    {
        // return $request->all();
        try {
            DB::transaction(function () use ($request) {
                $order = Order::where('payment_tnx_no', $request->payment_tnx_no)->with('customer')->first();
                $order->update(['payment_status' => $request->payment_status]);

                $request->request->add(['created_by' => optional(optional($order->customer)->user)->id]);

                if ($request->payment_status == 'Processing' || $request->payment_status == 'Complete') {
                    $cash_account       = $this->accTransactionService->getCashAccount();    // credit
                    $sale_account       = $this->accTransactionService->getSaleAccount();    // debit
                    $orderCustomer      = $order->customer->refresh();
                    $customer_account   = optional($orderCustomer)->account;

                    $invoice_no         = $order->order_no;
                    $date               = $order->date;

                    $description        = 'Order from ' . ($orderCustomer->name ?? 'Mr. Customer');

                    $this->accTransactionService->storeTransaction($order->company_id ?? 1, $order,    $invoice_no,    $sale_account,      0, $order->grand_total,  $date, 'credit', 'Sale', $description);   //  Payable Amount

                    $this->accTransactionService->storeTransaction($order->company_id ?? 1, $order,    $invoice_no,    $cash_account,      $order->grand_total, 0,  $date, 'debit', 'Payment', $description);    //  Paid Amount
                    if($orderCustomer->account !== null) {
                    $this->accTransactionService->storeTransaction($order->company_id ?? 1, $order,    $invoice_no,    $customer_account,  $order->grand_total, $order->grand_total,    $date, 'debit', 'Customer Due', $description);    //  Due Amount
                    }
                }
            });

            return response()->json([
                'status' => 1,
                'message' => 'success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => 'error: ' . $th
            ]);
        }
    }
}
