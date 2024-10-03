<?php


namespace App\Services;

use App\Models\NextInvoiceNo;

class NextInvoiceNoService
{
    /*
     |--------------------------------------------------------------------------
     | SET NEXT INVOICE NO
     |--------------------------------------------------------------------------
    */
    public function setNextInvoiceNo($company_id, $warehouse_id, $type, $year)
    {
        $invoice_no = NextInvoiceNo::query()
            ->firstOrCreate([
                'type'          => $type,
                'year'          => $year,
                'company_id'    => $company_id,
                'warehouse_id'  => $warehouse_id,
            ]);

        $invoice_no->increment('next_id');
    }
    




    /*
     |--------------------------------------------------------------------------
     | PURCHASE INVOICE NO
     |--------------------------------------------------------------------------
    */
    public function getPurchaseInvoiceNo($company_id, $warehouse_id)
    {
        $nextId = optional(NextInvoiceNo::query()
                ->where('type', 'Purchase')
                ->where('year', date('Y'))
                ->where('company_id', $company_id)
                ->where('warehouse_id', $warehouse_id)
                ->first())
                ->next_id;

        if ($nextId == null)
            $nextId = NextInvoiceNo::create([
                'type'          => 'Purchase',
                'year'          => date('Y'),
                'company_id'    => $company_id,
                'warehouse_id'  => $warehouse_id,
                'next_id'       => 1
            ])->next_id;

        return date('y') . date('m') . str_pad($nextId, 6, "0", STR_PAD_LEFT);
    }





    /*
     |--------------------------------------------------------------------------
     | SALE INVOICE NUMBER
     |--------------------------------------------------------------------------
    */
    public function getSaleInvoiceNo($company_id, $warehouse_id)
    {
        $nextId = optional(NextInvoiceNo::query()
                ->where('type', 'Sale')
                ->where('year', date('Y'))
                ->where('company_id', $company_id)
                ->where('warehouse_id', $warehouse_id)
                ->first())
                ->next_id;

        if ($nextId == null)
            $nextId = NextInvoiceNo::create([
                'type'          => 'Sale',
                'year'          => date('Y'),
                'company_id'    => $company_id,
                'warehouse_id'  => $warehouse_id,
                'next_id'       => 1
            ])->next_id;

        return date('y') . date('m') . str_pad($nextId, 6, "0", STR_PAD_LEFT);
    }





    /*
     |--------------------------------------------------------------------------
     | SALE ORDER NUMBER
     |--------------------------------------------------------------------------
    */
    public function getOrderInvoiceNo($company_id, $warehouse_id = null)
    {
        $nextId = optional(NextInvoiceNo::query()
                ->where('type', 'Order')
                ->where('year', date('Y'))
                ->where('company_id', $company_id)
                ->where('warehouse_id', $warehouse_id)
                ->first())
                ->next_id;

        if ($nextId == null)
            $nextId = NextInvoiceNo::create([
                'type'          => 'Order',
                'year'          => date('Y'),
                'company_id'    => $company_id,
                'warehouse_id'  => $warehouse_id ?? null,
                'next_id'       => 1
            ])->next_id;

        return date('y') . date('m') . date('d') . str_pad($nextId, 3, "0", STR_PAD_LEFT);
    }





    /*
     |--------------------------------------------------------------------------
     | ORDER RETURN INVOICE NUMBER
     |--------------------------------------------------------------------------
    */
    public function getOrderReturnInvoiceNo($company_id, $warehouse_id)
    {
        $nextId = optional(NextInvoiceNo::query()
                ->where('type', 'Order Return')
                ->where('year', date('Y'))
                ->where('company_id', $company_id)
                ->where('warehouse_id', $warehouse_id)
                ->first())
                ->next_id;

        if ($nextId == null)
            $nextId = NextInvoiceNo::create([
                'type'          => 'Order Return',
                'year'          => date('Y'),
                'company_id'    => $company_id,
                'warehouse_id'  => $warehouse_id,
                'next_id'       => 1
            ])->next_id;

        return 'OR' . date('y') . date('m') . str_pad($nextId, 4, "0", STR_PAD_LEFT);
    }





    /*
     |--------------------------------------------------------------------------
     | PRODUCT DAMAGE INVOICE NUMBER
     |--------------------------------------------------------------------------
    */
    public function getProductDamageInvoiceNo($company_id, $warehouse_id)
    {
        $nextId = optional(NextInvoiceNo::query()
                ->where('type', 'Product Damage')
                ->where('year', date('Y'))
                ->where('company_id', $company_id)
                ->where('warehouse_id', $warehouse_id)
                ->first())
                ->next_id;

        if ($nextId == null)
            $nextId = NextInvoiceNo::create([
                'type'          => 'Product Damage',
                'year'          => date('Y'),
                'company_id'    => $company_id,
                'warehouse_id'  => $warehouse_id,
                'next_id'       => 1
            ])->next_id;

        return 'PD' . date('y') . date('m') . str_pad($nextId, 4, "0", STR_PAD_LEFT);
    }
}
