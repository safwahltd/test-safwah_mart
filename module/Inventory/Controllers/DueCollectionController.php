<?php

namespace Module\Inventory\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemSetting;
use App\Traits\CheckPermission;
use Module\Inventory\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Module\Account\Models\Customer;
use Module\Inventory\Models\Warehouse;
use Module\Inventory\Models\DeliveryMan;
use Module\Account\Services\AccountTransactionService;
use Module\Inventory\Models\CustomerPointTransaction;
use Module\Inventory\Services\CustomerPointService;

class DueCollectionController extends Controller
{
    use CheckPermission;
    public $accTransactionService;
    public $customerPointService;




    /*
     |--------------------------------------------------------------------------
     | CONSTRUCT METHOD
     |--------------------------------------------------------------------------
    */
    public function __construct()
    {
        $this->accTransactionService    = new AccountTransactionService;
        $this->customerPointService     = new CustomerPointService;
    }





    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create()
    {
        $this->hasAccess("inv.due-collections.create");

        $data['deliveryMans']       = DeliveryMan::get(['id', 'name', 'phone']);
        $data['warehouses']         = Warehouse::pluck('name', 'id');

        $receivableDues             = Order::query()
                                    ->receivableDue()
                                    ->searchByField('delivery_man_id')
                                    ->searchByField('warehouse_id')
                                    ->searchByField('date')
                                    ->searchByField('delivery_date')
                                    ->with('customer:id,name,mobile')
                                    ->with('deliveryMan:id,name,phone')
                                    ->with('warehouse:id,name')
                                    ->where('current_status', 5)
                                    ->where('payment_status','!=', 'Paid')
                                    ->select('id', 'order_no', 'grand_total', 'customer_id', 'delivery_man_id', 'warehouse_id', 'date', 'delivery_date');

        $data['totalDueAmount']     = $receivableDues->sum('grand_total');

        $data['receivableDues']     = clone $receivableDues->orderBy('id', 'DESC')->paginate(30);

        $data['invoice1']       = optional(SystemSetting::find(5))->value;
        $data['invoice2']       = optional(SystemSetting::find(6))->value;
        
        return view('due-collection/create', $data);
    }




    public function store(Request $request)
    {
        $this->hasAccess("inv.due-collections.create");
        
        try {
            DB::transaction(function () use ($request) {

                foreach($request->order_id as $order_id) {

                    $order = Order::where('id', $order_id)->with('customer')->first();
    
                    $order->update([
                        'payment_status'    => 'Paid',
                        'due_collected_by'  => auth()->id(),
                        'due_collected_at'  => date('Y-m-d'),
                    ]);

                    $this->customerPointService->storeCustomerPointTransactionByAmount($order, $order->customer_id, 'In', $order->grand_total, null);
    
                    $cash_account       = $this->accTransactionService->getCashAccount();    // credit
                    $sale_account       = $this->accTransactionService->getSaleAccount();    // debit
                    $orderCustomer      = $order->customer->refresh();
                    $customer_account   = optional($orderCustomer)->account;                 // debit
    
                    $order              = $order->refresh();
                    $invoice_no         = $order->order_no;
                    $date               = $order->date;
    
                    $description        = 'Order from ' . (optional($order->customer)->name ?? 'Mr. Customer');
    
                    $this->accTransactionService->storeTransaction($order->company_id ?? 1, $order,    $invoice_no,    $sale_account,      0, $order->grand_total,  $date, 'credit', 'Sale', $description);   //  Payable Amount
    
                    $this->accTransactionService->storeTransaction($order->company_id ?? 1, $order,    $invoice_no,    $cash_account,      $order->grand_total, 0,  $date, 'debit', 'Payment', $description);    //  Paid Amount
    
                    $this->accTransactionService->storeTransaction($order->company_id ?? 1, $order,    $invoice_no,    $customer_account,  $order->grand_total, $order->grand_total,    $date, 'debit', 'Customer Due', $description);    //  Due Amount
                }
            });

            return redirect()->route('inv.due-collections.create')->withMessage('Due Collection Successfully');

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }
}
