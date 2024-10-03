<?php

use \Illuminate\Support\Facades\Route;
use Module\Account\Controllers\InventoryReportController;
use Module\Account\Controllers\AccountController;


Route::group(['prefix' => 'setup'], function () {

    Route::get('account-setups',                'AccountSetupController@index')->name('account-setups.index');
    Route::get('account-groups',                'AccountGroupController@index')->name('account-groups.index');


    Route::resource('accounts',                 'AccountController');
    Route::resource('account-controls',         'AccountControlController');
    Route::resource('account-subsidiaries',     'AccountSubsidiaryController');
    Route::resource('account-opening-balances', 'AccountOpeningBalanceController');


    // AJAX
    Route::get('account-control-data',                  'AccountAjaxController@getAccountControlsByAccountGroup')->name('ajax.account-controls');
    Route::get('account-subsidiary-data',               'AccountAjaxController@getAccountSubsidiariesByAccountControl')->name('ajax.account-subsidiaries');
    Route::get('account-data',                          'AccountAjaxController@getAccountsByAccountControlAndAccountSubsidiary')->name('ajax.accounts-by-control-and-subsidiary');
    Route::get('account-subsidiary-and-account-data',   'AccountAjaxController@getAccountSubsidiariesAndAccountsByAccountControl')->name('ajax.subsidiaries-and-accounts-by-control');
});





Route::resource('fund-transfers', 'FundTransferController');
Route::post('fund-transfers/{fundTransfer}/approve', 'FundTransferController@approveFundTransfer')->name('fund-transfers.approve.update');



Route::group(['prefix' => 'reports'], function () {


    Route::get('account-ledger', 'AccountReportController@accountLedgerReport')->name('report.account-ledger');




    Route::get('chart-of-account', 'AccountReportController@chartOfAccountReport')->name('report.chart-of-account');
    Route::get('ledger-journal', 'AccountReportController@JournalReport')->name('report.ledger-journal');
    Route::get('transaction-ledger', 'AccountReportController@transactionLedgerReport')->name('report.transaction-ledger');
    Route::get('subsidiary-wise-ledger', 'AccountReportController@subsidiaryWiseLedgerReport')->name('report.subsidiary-wise-ledger');
    Route::get('nominal-account-ledger', 'AccountReportController@nominalAccountLedgerReport')->name('report.nominal-account-ledger');


    Route::get('customer-ledger', 'AccountReportController@customerLedgerReport')->name('report.customer-ledger');
    Route::get('supplier-ledger', 'AccountReportController@supplierLedgerReport')->name('report.supplier-ledger');
    
    Route::get('supplier-report', 'AccountReportController@supplierReport')->name('report.supplier');


    Route::get('account-receivable', 'AccountReportController@accountReceivableReport')->name('report.account-receivable');
    Route::get('account-payable', 'AccountReportController@accountPayableReport')->name('report.account-payable');


    Route::get('revenue-analysis', 'AccountReportController@revenueAnalysisReport')->name('report.revenue-analysis');
    Route::get('expense-analysis', 'AccountReportController@expenseAnalysisReport')->name('report.expense-analysis');
    Route::get('ratio-analysis', 'AccountReportController@ratioAnalysisReport')->name('report.ratio-analysis');
    Route::get('received-payment-statement', 'AccountReportController@receivedPaymentStatementReport')->name('report.received-payment-statement');



    Route::get('voucher-report', 'AccountReportController@getVoucherReport')->name('report.voucher-report');







    Route::group(['prefix' => 'financial-statements'], function () {

        Route::get('trial-balance',         'AccountReportController@trialBalanceReport'    )->name('report.trial-balance');
        Route::get('income-statement',      'AccountReportController@incomeStatement'       )->name('report.income-statement');
        Route::get('equity-statement',      'AccountReportController@equityStatement'       )->name('report.equity-statement');
        Route::get('balance-sheet',         'AccountReportController@balanceSheetReport'    )->name('report.balance-sheet');
        Route::get('cash-flow',             'AccountReportController@cashFlowReport'        )->name('report.cash.flow');
    });



    Route::group(['prefix' => 'inventory'], function () {


        Route::get('item-ledger',   [InventoryReportController::class, 'getItemLedger'])->name('account.item-ledger');
        Route::get('stock-in-hand', [InventoryReportController::class, 'getStockInHand'])->name('account.stock-in-hand');
        
    });
});











// Product
Route::group(['prefix' => 'product'], function () {
    Route::resource('units', 'UnitController');
    Route::resource('categories', 'CategoryController');
    Route::resource('products', 'ProductController');
    Route::resource('damages', 'DamageController');
});










// Party
Route::group(['prefix' => 'party'], function () {
    Route::resource('acc-customers', 'CustomerController');
    Route::resource('acc-suppliers', 'SupplierController');
});










// Purchase
Route::group(['prefix' => 'purchase'], function () {
    Route::resource('acc-payments', 'PaymentController');
    Route::resource('acc-purchases', 'PurchaseController');
    Route::resource('acc-purchase-returns', 'PurchaseReturnController');

    Route::get('acc-returnable-purchase-invoices', 'PurchaseReturnController@getReturnablePurchaseInvoices')->name('acc-returnable-purchase-invoices');
    Route::get('acc-returnable-purchase-items', 'PurchaseReturnController@getReturnablePurchaseItems')->name('acc-returnable-purchase-items');
});










// Sale
Route::group(['prefix' => 'sale'], function () {
    Route::resource('acc_collections', 'CollectionController');
    Route::resource('acc-sales', 'SaleController');
    Route::resource('acc-sale-returns', 'SaleReturnController');

    Route::get('acc-returnable-sale-invoices', 'SaleReturnController@getReturnableSaleInvoices')->name('acc-returnable-sale-invoices');
    Route::get('acc-returnable-sale-items', 'SaleReturnController@getReturnableSaleItems')->name('acc-returnable-sale-items');
});






// Voucher
Route::group(['prefix' => 'voucher', 'as' => 'voucher-'], function () {


    // Receive
    Route::post('receives/{receive}/approve', 'ReceiveVoucherController@approveReceiveVoucher')->name('receives.approve');
    Route::resource('receives', 'ReceiveVoucherController');


    // Payment
    Route::post('payments/{payment}/approve', 'PaymentVoucherController@approvePaymentVoucher')->name('payments.approve');
    Route::resource('payments', 'PaymentVoucherController');


    // Contra
    Route::post('contras/{contra}/approve', 'ContraVoucherController@approveContraVoucher')->name('contras.approve');
    Route::resource('contras', 'ContraVoucherController');


    // Journal
    Route::post('journals/{journal}/approve', 'JournalVoucherController@approveJournalVoucher')->name('journals.approve');
    Route::resource('journals', 'JournalVoucherController');
});
