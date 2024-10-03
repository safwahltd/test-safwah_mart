<?php

namespace Module\Inventory\Services;

use Module\Account\Services\AccountTransactionService;

class TransactionService
{
    public $transactionService;




    public function __construct()
    {
        $this->transactionService       = new AccountTransactionService;
    }





    /*
     |--------------------------------------------------------------------------
     | STORE TRANSACTION METHOD
     |--------------------------------------------------------------------------
    */
    public function storeTransaction($purchase)
    {
        $cash_account       = $this->transactionService->getCashAccount();          // debit
        $purchase_account   = $this->transactionService->getPurchaseAccount();      // credit
        $supplier_account   = optional($purchase->supplier)->account;               // credit

        $purchase           = $purchase->refresh();
        $invoice_no         = $purchase->invoice_no;
        $date               = $purchase->date;

        $description        = 'Purchase from ' . (optional($purchase->supplier)->name ?? 'Mr. Supplier');


        $this->transactionService->storeTransaction($purchase->company_id, $purchase,    $invoice_no,    $purchase_account,    $purchase->payable_amount, 0,  $date, 'debit',     'Purchase', $description);   //  Payable Amount

        $this->transactionService->storeTransaction($purchase->company_id, $purchase,    $invoice_no,    $cash_account,        0, $purchase->paid_amount,   $date, 'credit',    'P.Payment', $description);    //  Paid Amount

        $this->transactionService->storeTransaction($purchase->company_id, $purchase,    $invoice_no,    $supplier_account,    $purchase->paid_amount, $purchase->payable_amount,   $date, 'credit',    'Supplier Due', $description);    //  Due Amount
    }
    
}
