<?php


namespace Module\Account\Services;


use App\Models\Company;
use Illuminate\Http\Request;
use Module\Account\Models\Account;
use Module\Account\Models\Purchase;
use Module\Account\Models\Transaction;

class SupplierLedgerReportService
{



    public function getSupplierLedgerReport(Request $request)
    {
        $accounts = Account::where('account_type_id', '=', 3)->get();
        $transactions = Transaction::where('transaction_type_id', '=', 1)->get();
        return view('account::supplier-ledger-report', compact('accounts', 'transactions'));
    }




    public function getLedger(Request $request)
    {
        $per_page = 30;

        $data['selected_account'] = Account::find($request->account_id);

        $data['paginate_debit_balance'] = 0;
        $data['paginate_credit_balance'] = 0;

        $balance = Transaction::query()
            ->searchByField('company_id')
            ->where('account_id', $request->account_id)
            ->where('date', '<',  fdate($request->from ?? date('Y-m-d')))
            ->get();

        $data['debit_balance']  = $balance->sum('debit_amount');
        $data['credit_balance'] = $balance->sum('credit_amount');



        $data['transactions'] = Transaction::query()
            ->with('transactionable')
            ->searchByField('company_id')
            ->where('account_id', $request->account_id)
            ->when($request->from, function ($q) use ($request) {
                $q->where('date', '>=', $request->from);
            })
            ->when($request->to, function ($q) use ($request) {
                $q->where('date', '<=', $request->to);
            });

        $data['transactions'] = ($request->print || $request->export_type)
            ? $data['transactions']->get()
            : $data['transactions']->paginate($per_page);



        if ($request->filled('page')) {
           
            $paginate_balance = Transaction::query()
                ->with('transactionable')
                ->searchByField('company_id')
                ->where('account_id', $request->account_id)
                ->when($request->from, function ($q) use ($request) {
                    $q->where('date', '>=', $request->from);
                })
                ->when($request->to, function ($q) use ($request) {
                    $q->where('date', '<=', $request->to);
                })
                ->limit(($request->page - 1) * $per_page)
                ->get(); 


            $data['paginate_debit_balance'] = $paginate_balance->sum('debit_amount');
            $data['paginate_credit_balance'] = $paginate_balance->sum('credit_amount');
        }

        if(!$request->filled('print') && !$request->filled('export_type')) {

            if($data['transactions']->currentPage() == $data['transactions']->lastPage()) {


            $total_value_query = Transaction::query()
                                ->with('transactionable')
                                ->searchByField('company_id')
                                ->where('account_id', $request->account_id)
                                ->when($request->from, function ($q) use ($request) {
                                    $q->where('date', '>=', $request->from);
                                })
                                ->when($request->to, function ($q) use ($request) {
                                    $q->where('date', '<=', $request->to);
                                }); 

                $data['grand_total_debit_balance'] = (clone $total_value_query)->sum('debit_amount');
                $data['grand_total_credit_balance'] = (clone $total_value_query)->sum('credit_amount');
            }
        }

        return $data;
    }






    public function supplierPurchaseReport($request)
    {

        $data['balances'] = Transaction::query()
            ->searchByField('company_id')
            ->searchByField('account_id')
            ->where('date', '<',  fdate($request->from ?? date('Y-m-d')))
            ->get();




        $purchase                           = Transaction::query()
                                                ->with('transactionable', 'account')
                                                ->searchByField('company_id')
                                                ->searchByField('account_id')
                                                ->whereHas('account', function($query){
                                                    $query->where('account_group_id', 2)
                                                    ->where('account_control_id', 3)
                                                    ->where('account_subsidiary_id', 4);
                                                })
                                                // ->where('transaction_item_type', 'Prod. Purchase')
                                                ->when($request->from, function ($q) use ($request) {
                                                    $q->where('date', '>=', $request->from);
                                                })
                                                ->when($request->to, function ($q) use ($request) {
                                                    $q->where('date', '<=', $request->to);
                                                });
        
        
        $data['total_purchase_paid']        = $purchase->sum('debit_amount');
        $data['total_purchase_cr']          = $purchase->sum('credit_amount');
        $data['total_purchase_amount']      = abs($data['total_purchase_paid'] - $data['total_purchase_cr']);
        
        $data['total_balance']              = abs($data['balances']->sum('debit_amount') - $data['balances']->sum('credit_amount')) + $data['total_purchase_amount'];

                               
        $data['transaction_purchases']      = $request->print ? $purchase->get()->groupBy('account_id') : $purchase->get()->groupBy('account_id');

        $data['companies']                  = Company::userCompanies();
        $data['account_suppliers']          = Account::query()
                                                ->where('account_group_id', 2)
                                                ->where('account_control_id', 3)
                                                ->where('account_subsidiary_id', 4)
                                                ->select('name', 'id')->get();

        return $data;
    }
}
