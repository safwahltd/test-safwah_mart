<?php

namespace Module\Account\Controllers;

use App\Models\Company;
use App\Services\ExportService;
use App\Traits\CheckPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Module\Account\Models\Account;

use Module\Account\Models\AccountGroup;
use Module\Account\Models\AccountSubsidiary;
use Module\Account\Models\Customer;
use Module\Account\Models\Supplier;
use Module\Account\Models\Transaction;
use Module\Account\Services\AccountLedgerReportService;
use Module\Account\Services\DataService;
use Module\Account\Services\JournalLedgerReportService;
use Module\Account\Services\SubsidiaryWiseLedgerReportService;
use Module\Account\Services\SupplierLedgerReportService;
use Module\Account\Services\TransactionLedgerReportService;
use Module\Account\Services\VoucherReportService;

class AccountReportController extends Controller
{
    use CheckPermission;

    private $dataService;

    private $reportService;

    private $journalLedger;

    private $subsidiaryLedger;

    private $transactionLedger;

    private $exportService;










    /*
     |--------------------------------------------------------------------------
     | CONSTRUCTOR
     |--------------------------------------------------------------------------
    */
    public function __construct()
    {
        $this->dataService          = new DataService();

        $this->reportService        = new AccountLedgerReportService();

        $this->journalLedger        = new JournalLedgerReportService();

        $this->transactionLedger    = new TransactionLedgerReportService();

        $this->subsidiaryLedger     = new SubsidiaryWiseLedgerReportService();

        $this->exportService        = new ExportService();
    }











    /*
     |--------------------------------------------------------------------------
     | ACCOUNT LEDGER REPORT
     |--------------------------------------------------------------------------
    */
    public function accountLedgerReport(Request $request)
    {
        $this->hasAccess("report.account-ledger");

        $data1 = $this->dataService->getAccountData(['accounts']);

        $data2 = $this->reportService->getLedger($request);


        $data1['companies']  = Company::userCompanies();

        $view = 'reports.account-ledger.' . ($request->print ? 'print' : 'index');

        if ($request->filled('export_type')) {
            
            $file_name = 'account-ledger-report-' . date('Y-m-d');

            return $this->exportService->exportData($data2, 'reports/account-ledger/export/' , $file_name);
        }

        return view($view, $data1, $data2);
    }











    /*
     |--------------------------------------------------------------------------
     | VOUCHER REPORT
     |--------------------------------------------------------------------------
    */
    public function getVoucherReport(Request $request)
    {
        $this->hasAccess("report.ledger-journal");

        $data1 = $this->dataService->getAccountData(['accounts']);

        $data2 = (new VoucherReportService)->getReportData($request);


        $data1['companies']  = Company::userCompanies();

        $view = 'reports.voucher-reports.' . ($request->print ? 'print' : 'index');


        if ($request->filled('export_type')) {
            
            $file_name = 'Voucher Report-'. date('Y-m-d');

            return $this->exportService->exportData($data2,'reports/voucher-reports/export/', $file_name);
        }

        return view($view, $data1, $data2);
    }











    /*
     |--------------------------------------------------------------------------
     | LEDGER JOURNAL REPORT
     |--------------------------------------------------------------------------
    */
    public function JournalReport(Request $request)
    {
        $this->hasAccess("report.ledger-journal");


        $data = $this->journalLedger->getJournalReport($request);

        $data['companies']  = Company::userCompanies();

        $view = 'reports.journal-report.' . ($request->print ? 'print' : 'index');


        if ($request->filled('export_type')) {

            $file_name = 'journal-ledger-' . date('Y-m-d');

            return $this->exportService->exportData($data, 'reports/journal-report/export/', $file_name);    
        }



        return view($view, $data);
    }












    /*
     |--------------------------------------------------------------------------
     | TRIAL BALANCE
     |--------------------------------------------------------------------------
    */
    public function trialBalanceReport(Request $request)
    {
        $this->hasAccess("report.trial-balance");

        $accountGroups = $this->transactionLedger->getTrialBalanceReportData($request);
        $companies  = Company::userCompanies();

        $view = 'reports.trial-balance.' . ($request->print ? 'print' : 'index');

        return view($view, compact('accountGroups', 'companies'));
    }












    /*
     |--------------------------------------------------------------------------
     | INCOME STATEMENT
     |--------------------------------------------------------------------------
    */
    public function incomeStatement(Request $request)
    {
        $this->hasAccess("report.income-statement");


        $data = $this->transactionLedger->getIncomeStatementReportData($request);
        $data['companies']  = Company::userCompanies();

        $view = 'reports.income-statement.' . ($request->print ? 'print' : 'index');

        return view($view, $data);
    }












    /*
     |--------------------------------------------------------------------------
     | EQUITY STATEMENT
     |--------------------------------------------------------------------------
    */
    public function equityStatement(Request $request)
    {
        $this->hasAccess("report.equity-statement");

        $item                       = $this->transactionLedger->getIncomeStatementReportData($request);

        $revenues = $item['revenues']->accountControls->sum(function ($control) {
            return $control->accounts->sum('balance');
        });

        $purchases = $item['purchases']->accountControls->sum(function ($control) {
            return $control->accounts->sum('balance');
        });

        $expenses = $item['expenses']->accountControls->sum(function ($control) {
            return $control->accounts->sum('balance');
        });

        $depreciations = $item['depreciations']->accountControls->sum(function ($control) {
            return $control->accounts->sum('balance');
        });

        $equity = $item['equity']->accountControls->sum(function ($control) {
            return $control->accounts->sum('balance');
        });


        $data['profit_and_loss']    = $revenues - $purchases - $expenses - $depreciations;
        $data['equity']             = $equity;
        $data['companies']          = Company::userCompanies();

        $view                       = 'reports.equity-statement.' . ($request->print ? 'print' : 'index');

        return view($view, $data);
    }












    /*
     |--------------------------------------------------------------------------
     | CHART OF ACCOUNT REPORT
     |--------------------------------------------------------------------------
    */
    public function chartOfAccountReport(Request $request)
    {
        $this->hasAccess("report.chart-of-account");


        $data['companies']  = Company::userCompanies();

        $data['accounts'] = Account::query()
            ->companies()
            ->orderBy('name')
            ->withCount(['transaction_items as debit' => function ($quer) {
                $quer->searchByField('company_id')->select(DB::Raw('SUM(debit_amount)'));
            }])->withCount(['transaction_items as credit' => function ($quer) {
                $quer->searchByField('company_id')->select(DB::Raw('SUM(credit_amount)'));
            }]);

        if ($request->print || $request->export_type) {
            $data['accounts'] = $data['accounts']->get();
        } else {
            $data['accounts'] = $data['accounts']->paginate(30);
        }

        if ($request->filled('export_type')) {

            $file_name = 'chart-of-account-report-' . date('Y-m-d');

            return $this->exportService->exportData($data, 'reports/chart-of-account/export/', $file_name);    
        }

        return view('reports.chart-of-account.' . ($request->print ? 'print' : 'index'), $data);
    }












    /*
     |--------------------------------------------------------------------------
     | CUSTOMER LEDGER
     |--------------------------------------------------------------------------
    */
    public function customerLedgerReport(Request $request)
    {
        $this->hasAccess("report.customer-ledger");


        $customer = Customer::select('name', 'id', 'account_id')->get();

        $transactions = Transaction::query()
            ->searchByField('company_id')
            ->where('account_id', $request->account_id)
            ->where('date', '<',  fdate($request->from ?? today()))
            ->get();



        $data['companies']    = Company::userCompanies();
        $data['balance']      = $transactions->sum('debit_amount') - $transactions->sum('credit_amount');

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

        if ($request->filled('export_type')) {
            $data['transactions'] = $data['transactions']->get();

            $file_name = 'customer-ledger-report-' . date('Y-m-d');
            return $this->exportService->exportData($data, 'reports/customer-ledger/export/', $file_name);
        }
        $data['transactions'] = $request->print
            ? $data['transactions']->get()
            : $data['transactions']->paginate(30);

        return view('reports.customer-ledger.' . ($request->print ? 'print' : 'index'), compact('customer'), $data);
    }












    /*
     |--------------------------------------------------------------------------
     | ACCOUNT RECEIVABLE
     |--------------------------------------------------------------------------
    */
    public function accountReceivableReport(Request $request)
    {
        $this->hasAccess("report.customer-ledger");


        $data['companies'] = Company::userCompanies();
        $query = Account::query()->asset()->currentAsset()->where('account_subsidiary_id', 8);

        $transactions = (clone $query)
                                ->when($request->filled('account_id'), function($q) use($request) {
                                    $q->where('id', $request->account_id);
                                })
                                ->withCount(['transaction_items as balance' => function ($quer) {
                                    $quer->searchByField('company_id')->select(DB::Raw('SUM(debit_amount - credit_amount)'));
                                }]);

        $data['transactions'] = ($request->print || $request->export_type)
            ? $transactions->get()
            : $transactions->paginate(50);

        $data['accounts'] = $query->get(['name', 'id']);

        if ($request->filled('export_type')) {

            $file_name = 'account-receivable-report-' . date('Y-m-d');
            return $this->exportService->exportData($data, 'reports/account-receivable/export/', $file_name);
        }

        return view('reports.account-receivables.' . ($request->print ? 'print' : 'index'), $data);
    }












    /*
     |--------------------------------------------------------------------------
     | ACCOUNT PAYABLE
     |--------------------------------------------------------------------------
    */
    public function accountPayableReport(Request $request)
    {
        $this->hasAccess("report.customer-ledger");

        $data['companies'] = Company::userCompanies();
        

        $query = Account::query()->liabilities()->where('account_control_id', 3)->where('account_subsidiary_id', 4);

        $transactions = (clone $query)
                                ->when($request->filled('account_id'), function($q) use($request) {
                                    $q->where('id', $request->account_id);
                                })
                                ->withCount(['transaction_items as balance' => function ($quer) {
                                    $quer->searchByField('company_id')->select(DB::Raw('SUM(debit_amount - credit_amount)'));
                                }]);

        $data['transactions'] = ($request->print || $request->export_type)
            ? $transactions->get()
            : $transactions->paginate(50);

        $data['accounts'] = $query->get(['name', 'id']);

        if ($request->filled('export_type')) {

            $file_name = 'account-payables-report-' . date('Y-m-d');
            return $this->exportService->exportData($data, 'reports/account-payables/export/', $file_name);
        }

        return view('reports.account-payables.' . ($request->print ? 'print' : 'index'), $data);
    }











    /*
     |--------------------------------------------------------------------------
     | SUPPLIER LEDGER
     |--------------------------------------------------------------------------
    */
    public function supplierLedgerReport(Request $request)
    {

        $this->hasAccess("report.supplier-ledger");

        // For Supplier Ledger Report
        $data['supplier']   = Supplier::select('name', 'id', 'account_id')->get();
        $data['companies']  = Company::userCompanies();


        $data2 = (new SupplierLedgerReportService)->getLedger($request);

        if ($request->filled('export_type')) {
            
            $file_name  = 'Supplier-Ledger-Report-' . date('Y-m-d');

           return $this->exportService->exportData($data2, 'reports/supplier-ledger/export/', $file_name);
        }

        return view('reports.supplier-ledger.' . ($request->print ? 'print' : 'index'), $data, $data2);
    }





    /*
     |--------------------------------------------------------------------------
     | SUPPLIER REPORT
     |--------------------------------------------------------------------------
    */
    public function supplierReport(Request $request)
    {

        $this->hasAccess("report.supplier-ledger");

        
        $data                   = (new SupplierLedgerReportService)->supplierPurchaseReport($request);
        // return $data;


        if ($request->filled('export_type')) {
            
            $file_name  = 'Supplier-Report-' . date('Y-m-d');

           return $this->exportService->exportData($data, 'reports/supplier/export/', $file_name);
        }
        return view('reports/supplier.' . ($request->print ? 'print' : 'index'), $data);
    }

















    /*
     |--------------------------------------------------------------------------
     | TRIAL BALANCE
     |--------------------------------------------------------------------------
    */
    public function transactionLedgerReport(Request $request)
    {
        $this->hasAccess("account.transaction.ledger.reports");

        $accountGroups = $this->transactionLedger->getTrialBalanceReportData($request);

        $view = 'reports.transaction-ledger.category-' . ($request->print ? 'print' : 'index');

        return view($view, compact('accountGroups'));
    }

    public function ledgerJournalReport(Request $request)
    {

        $this->hasAccess("	report.ledger-journal");

        $data = $this->dataService->getAccountData(['accounts']);
        $data2 = $this->journalLedger->getLedger($request);

        $view = 'reports.ledger-journal.' . ($request->print ? 'print' : 'index');



        if ($request->filled('export_type')) {

        
            $file_name = 'ledger-journal' . date('Y-m-d');

        
            return $this->exportService->exportData($data, 'reports/chart-of-account/export/', $file_name);    
        }


        return view($view, $data, $data2);
    }

    public function subsidiaryWiseLedgerReport(Request $request)
    {
        $this->hasAccess("report.subsidiary-wise-ledger");

        $data = $this->dataService->getAccountData(['accountSubsidiaries']);
        $data2 = $this->subsidiaryLedger->getLedger($request);
        $data['companies']  = Company::userCompanies();


        $view = 'reports.subsidiary-wise-ledger.' . ($request->print ? 'print' : 'index');

        return view($view, $data, $data2);
    }

    public function expenseAnalysisReport(Request $request)
    {
        $this->hasAccess("account.expense.analysis.reports");

        $data = $this->dataService->getAccountData(['accountControls', 'accountSubsidiaries']);

        $data['accountSubsidiaries'] = AccountSubsidiary::query()
            ->where('account_control_id', $request->account_control_id)
            ->select('id', 'name')
            ->get();

        $data['accounts'] = Account::query()
            ->when($request->account_subsidiary_id, function ($q) use ($request) {
                $q->where('account_subsidiary_id', $request->account_subsidiary_id);
            })
            ->when($request->account_control_id, function ($q) use ($request) {
                $q->where('account_control_id', $request->account_control_id);
            })
            ->select('id', 'name')
            ->get();

        $data['transaction_items'] = Transaction::query()
            ->whereHas('account', function ($q) use ($request) {
                $q->where('account_group_id', 5)
                    ->with('accountSubsidiary', 'accountControl')
                    ->where('balance_type', 'Debit')
                    ->when($request->account_subsidiary_id, function ($r) use ($request) {
                        $r->where('account_subsidiary_id', $request->account_subsidiary_id);
                    })
                    ->when($request->account_control_id, function ($r) use ($request) {
                        $r->where('account_control_id', $request->account_control_id);
                    })
                    ->when($request->account_id, function ($r) use ($request) {
                        $r->where('account_id', $request->account_id);
                    });
            })
            ->where('date', '>=', $request->from ?? date('Y-m-d'))
            ->where('date', '<=', $request->to ?? date('Y-m-d'))
            ->withCount(['account as account_subsidiary_id' => function ($q) {
                $q->select(DB::raw('SUM(account_subsidiary_id)'));
            }])
            ->withCount(['account as account_control_id' => function ($q) {
                $q->select(DB::raw('SUM(account_control_id)'));
            }]);

        if ($request->print) {
            $data['transaction_items'] = $data['transaction_items']->get();
        } else {
            $data['transaction_items'] = $data['transaction_items']->paginate(30);
        }

        return view('reports.expense-analysis.' . ($request->print ? 'print' : 'index'), $data);
    }













    /*
     |--------------------------------------------------------------------------
     | BALANCE SHEET
     |--------------------------------------------------------------------------
    */
    public function balanceSheetReport(Request $request)
    {
        $this->hasAccess("report.balance-sheet");


        $item                       = $this->transactionLedger->getIncomeStatementReportData($request);


        $revenues = $item['revenues']->accountControls->sum(function ($control) {
            return $control->accounts->sum('balance');
        });

        $purchases = $item['purchases']->accountControls->sum(function ($control) {
            return $control->accounts->sum('balance');
        });

        $expenses = $item['expenses']->accountControls->sum(function ($control) {
            return $control->accounts->sum('balance');
        });

        $depreciations = $item['depreciations']->accountControls->sum(function ($control) {
            return $control->accounts->sum('balance');
        });

        $equity = $item['equity']->accountControls->sum(function ($control) {
            return $control->accounts->sum('balance');
        });

        $data['equity_balance']     = $revenues + $equity - $purchases - $expenses - $depreciations;
        $data['companies']          = Company::userCompanies();


        $data['accountGroups'] = AccountGroup::with(['accountControls' => function ($q) use ($request) {
            $q->with(['accounts' => function ($qr) use ($request) {
                $qr->withCount(['transaction_items as debit_balance' => function ($qur) use ($request) {
                    return $qur
                        ->searchByField('company_id')
                        ->where('date', '<=', fdate($request->date ?? today()))
                        ->select(DB::Raw('SUM(debit_amount)'));
                }])
                    ->withCount(['transaction_items as credit_balance' => function ($qur) use ($request) {
                        return $qur
                            ->searchByField('company_id')
                            ->where('date', '<=', fdate($request->date ?? today()))
                            ->select(DB::Raw('SUM(credit_amount)'));
                    }]);
            }]);
        }])
        ->get();


        $view = 'reports.balance-sheet.' . ($request->print ? 'print' : 'index');

        return view($view, $data);
    }









    /*
     |--------------------------------------------------------------------------
     | CASH FLOW
     |--------------------------------------------------------------------------
    */
    public function cashFlowReport(Request $request)
    {
        $this->hasAccess("report.cash.flow");


        $item                       = $this->transactionLedger->getIncomeStatementReportData($request);


        $revenues = $item['revenues']->accountControls->sum(function ($control) {
            return $control->accounts->sum('balance');
        });

        $purchases = $item['purchases']->accountControls->sum(function ($control) {
            return $control->accounts->sum('balance');
        });

        $expenses = $item['expenses']->accountControls->sum(function ($control) {
            return $control->accounts->sum('balance');
        });

        $depreciations = $item['depreciations']->accountControls->sum(function ($control) {
            return $control->accounts->sum('balance');
        });

        $data['equity_balance']     = $revenues - $purchases - $expenses - $depreciations;
        $data['depreciations']      = $depreciations;
        $data['companies']          = Company::userCompanies();

        $data['accountGroups'] = AccountGroup::with(['accountControls' => function ($q) use ($request) {
            $q->with(['accounts' => function ($qr) use ($request) {
                $qr->withCount(['transaction_items as debit_balance' => function ($qur) use ($request) {
                    return $qur
                        ->searchByField('company_id')
                        ->where('date', '<=', fdate($request->date ?? today()))
                        ->select(DB::Raw('SUM(debit_amount)'));
                }])
                    ->withCount(['transaction_items as credit_balance' => function ($qur) use ($request) {
                        return $qur
                            ->searchByField('company_id')
                            ->where('date', '<=', fdate($request->date ?? today()))
                            ->select(DB::Raw('SUM(credit_amount)'));
                    }]);
            }]);
        }])
            ->get();

        $asset = $data['accountGroups']->where('id', 1)->first();
        $liabilities = $data['accountGroups']->where('id', 2)->first();

        $data['asset'][0] = 0;
        $data['asset'][1] = 0;


        foreach ($asset->accountControls as $key => $accountControl) {

            $data['asset'][$key] = $accountControl->accounts->sum('debit_balance') - $accountControl->accounts->sum('credit_balance');
        }

        $data['liabilities'][0] = 0;
        $data['liabilities'][1] = 0;

        foreach ($liabilities->accountControls as $key => $accountControl) {

            $data['liabilities'][$key] = $accountControl->accounts->sum('credit_balance') - $accountControl->accounts->sum('debit_balance');
        }


        $view = 'reports.cash-flow.' . ($request->print ? 'print' : 'index');

        return view($view, $data);
    }
}
