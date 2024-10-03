<?php

namespace Module\Inventory\Services;

use App\Services\NextInvoiceNoService;
use Module\Inventory\Models\ProductDamageDetail;
use Module\Account\Services\AccountTransactionService;

class ProductDamageService
{
    public $productDamage;
    public $transactionService;
    public $nextInvoiceNumberService;





    public function __construct()
    {
        $this->nextInvoiceNumberService     = new NextInvoiceNoService;
        $this->transactionService           = new AccountTransactionService();
    }





    /*
     |--------------------------------------------------------------------------
     | STORE PRODUCT DAMAGE METHOD
     |--------------------------------------------------------------------------
    */
    public function storeProductDamage($source, $type)
    {
        $damages = 0;
        $invoiceNo = '';

        if ($type == 'Order Return') {
            $damages = $source->damageOrExpireReturnDetails;
            $invoiceNo = $this->nextInvoiceNumberService->getProductDamageInvoiceNo($source->company_id ?? optional(auth()->user())->company_id, $source->warehouse_id);
        }

        if (count($damages) > 0) {
            $this->productDamage    =  $source->productDamage()->create([
                'company_id'        => $source->company_id,
                'warehouse_id'      => $source->warehouse_id,
                'invoice_no'        => $invoiceNo,
                'date'              => date('Y-m-d'),
                'note'              => $source->note,
            ]);
            
            $this->storeProductDamageDetails($damages);
        }

        return $this->productDamage;
    }





    /*
     |--------------------------------------------------------------------------
     | STORE PRODUCT DAMAGE DETAILS METHOD
     |--------------------------------------------------------------------------
    */
    public function storeProductDamageDetails($damages)
    {
        foreach($damages as $damage) {
            ProductDamageDetail::create([
                'product_damage_id'     => $this->productDamage->id, 
                'product_id'            => $damage->product_id,
                'product_variation_id'  => $damage->product_variation_id,
                'measurement_title'     => $damage->measurement_title,
                'measurement_sku'       => $damage->measurement_sku,
                'measurement_value'     => $damage->measurement_value,
                'purchase_price'        => $damage->purchase_price,
                'sale_price'            => $damage->sale_price,
                'quantity'              => $damage->quantity,
                'vat_percent'           => $damage->vat_percent,
                'vat_amount'            => $damage->vat_amount,
                'discount_percent'      => $damage->discount_percent,
                'discount_amount'       => $damage->discount_amount,
                'weight'                => $damage->weight,
                'condition'             => $damage->return_type,
            ]);
        }
    }





    /*
     |--------------------------------------------------------------------------
     | UPDATE PRODUCT DAMAGE ALL TOTAL METHOD
     |--------------------------------------------------------------------------
    */
    public function updateProductDamageAllTotal($productDamage)
    {
        $productDamage = $productDamage->refresh();

        $this->productDamage->update([
            'total_quantity'    => array_sum(array_column($productDamage->productDamageDetails->toArray(), 'quantity')),
            'total_weight'      => array_sum(array_column($productDamage->productDamageDetails->toArray(), 'weight')),
            'total_amount'      => array_sum(array_column($productDamage->productDamageDetails->toArray(), 'total_amount')),
        ]);
    }





    /*
     |--------------------------------------------------------------------------
     | STORE PRODUCT DAMAGE TRANSACTION METHOD
     |--------------------------------------------------------------------------
    */
    public function storeProductDamageTransaction($productDamage)
    {
        $damage_account             = $this->transactionService->getDamageAccount();      // credit
        $purchase_account           = $this->transactionService->getPurchaseAccount();      // credit

        $damage                     = $productDamage->refresh();
        $invoice_no                 = $damage->invoice_no;
        $date                       = $damage->date;

        $description                = 'Product Damage';

        $this->transactionService->storeTransaction($damage->company_id, $damage,    $invoice_no,    $damage_account,   $damage->total_amount, 0,  $date, 'debit',     'Product Damage', $description);   //  Payable Amount
        $this->transactionService->storeTransaction($damage->company_id, $damage,    $invoice_no,    $purchase_account, 0,  $damage->total_amount,  $date, 'credit',     'Product Damage', $description);   //  Payable Amount
    }
}
