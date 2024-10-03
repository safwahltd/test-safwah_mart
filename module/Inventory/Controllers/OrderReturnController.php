<?php

namespace Module\Inventory\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\Inventory\Models\Order;
use App\Http\Controllers\Controller;
use Module\Inventory\Models\TimeSlot;
use App\Services\NextInvoiceNoService;
use Module\Inventory\Models\DeliveryMan;
use Module\Inventory\Models\OrderReturn;
use Module\Inventory\Models\ReturnReason;
use Module\Inventory\Services\CustomerPointService;
use Module\Inventory\Services\OrderReturnService;
use Module\Inventory\Services\ProductDamageService;
use Module\Inventory\Services\CustomerWalletService;

class OrderReturnController extends Controller
{
    public $orderReturnService;
    public $productDamageService;
    public $nextInvoiceNumberService;
    public $customerWalletService;
    public $customerPointService;




    public function __construct()
    {
        $this->orderReturnService                   = new OrderReturnService;
        $this->productDamageService                 = new ProductDamageService;
        $this->nextInvoiceNumberService             = new NextInvoiceNoService;
        $this->customerWalletService                = new CustomerWalletService;
        $this->customerPointService                 = new CustomerPointService;
    }





    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index()
    {
        $data['orderReturns']   = OrderReturn::query()
                                ->orderBy('id', 'DESC')
                                ->paginate(30);

        return view('order-return/index', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create(Request $request)
    {
        $data['order']          = Order::query()
                                ->where('order_no', $request->order_no)
                                ->with('orderDetails')
                                ->with(['customer' => function ($q) {
                                    $q->with('district:id,name')
                                    ->with('area:id,name')
                                    ->select('id', 'name', 'mobile', 'email', 'address', 'district_id', 'area_id', 'zip_code');
                                }])
                                ->first();

        $data['returnReasons']  = ReturnReason::active()->get(['id', 'title']);
        $data['orderNos']       = Order::query()
                                ->whereNotIn('current_status', [1, 6])
                                ->get('order_no');

        return view('order-return/create', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        try {

            $this->orderReturnService->storeOrderReturn($request);

            return redirect()->route('inv.order-returns.index')->withMessage('Product Return has been successfully created');

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }




    /*
     |--------------------------------------------------------------------------
     | SHOW (METHOD)
     |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $data['orderReturn']        = OrderReturn::where('id', $id)->first();
        $data['company']            = Company::first();
        // return $data;
        return view('order-return/invoice', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | CHANGE STATUS METHOD
     |--------------------------------------------------------------------------
    */
    public function changeStatus($id)
    {
        $data['orderReturn']    = OrderReturn::with('orderReturnDetails')->where('id', $id)->first();
        $data['deliveryMans']   = DeliveryMan::active()->get(['id', 'name', 'phone']);
        $data['timeSlots']      = TimeSlot::active()->get(['id', 'starting_time', 'ending_time']);

        return view('order-return/change-status', $data);
    }





    /*
     |--------------------------------------------------------------------------
     | UPDATE STATUS METHOD
     |--------------------------------------------------------------------------
    */
    public function updateStatus(Request $request, $id)
    {
        try {

            $orderReturn = OrderReturn::where('id', $id)->first();

            DB::transaction(function () use ($orderReturn, $request) {
                if ($request->status == 'Approved') {

                    $orderReturn->update([
                        'status'            => $request->status,
                        'return_date'       => $request->return_date,
                        'time_slot_id'      => $request->time_slot_id,
                        'delivery_man_id'   => $request->delivery_man_id,
                        'approved_by'       => auth()->id(),
                        'approved_at'       => date('Y-m-d'),
                    ]);

                } elseif ($request->status == 'Delivery Start') {

                    $orderReturn->update([
                        'status'        => $request->status,
                        'received_at'   => date('Y-m-d'),
                    ]);

                } elseif ($request->status == 'Delivery Done') {

                    $this->orderReturnService->storeGoodProductInStock($request, $orderReturn);

                    $productDamage = $this->productDamageService->storeProductDamage($orderReturn, 'Order Return');

                    if ($productDamage != null) {

                        $this->productDamageService->updateProductDamageAllTotal($productDamage);

                        $this->productDamageService->storeProductDamageTransaction($productDamage);

                        $this->nextInvoiceNumberService->setNextInvoiceNo(optional($orderReturn->order)->company_id ?? optional(auth()->user())->company_id, optional($orderReturn->order)->warehouse_id, 'Product Damage', date('Y'));
                    }

                    $this->customerWalletService->storeCustomerWalletTransaction($orderReturn, $orderReturn->customer_id, 'In', $orderReturn->total_amount, null);
                    
                    $this->customerPointService->storeCustomerPointTransactionByAmount($orderReturn, $orderReturn->customer_id, 'Out', $orderReturn->total_amount, null);

                    $this->orderReturnService->makeTransaction($orderReturn);

                    $orderReturn->update([
                        'status'            => $request->status,
                        'accepted_by'       => auth()->id(),
                        'accepted_at'       => date('Y-m-d'),
                    ]);

                } elseif ($request->status == 'Cancelled') {

                    $orderReturn->update([
                        'status'            => $request->status,
                        'cancelled_by'      => auth()->id(),
                        'cancelled_at'      => date('Y-m-d'),
                        'cancel_reason'     => $request->cancel_reason,
                    ]);
                }
            });

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        return redirect()->back()->withMessage('Order Return has been '. $request->status .' successfully');
    }





    /*
     |--------------------------------------------------------------------------
     | DESTROY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        try {

            $this->orderReturnService->deleteOrderReturn($id);

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }

        return redirect()->back()->withMessage('Order Return has been deleted successfully');
    }
}
