<?php

namespace Module\Product\Services;
use Module\Product\Models\Product;
use Module\Product\Models\StockSummary;

class StockService
{
    public $stock;
    public $stockSummary;










    /*
     |--------------------------------------------------------------------------
     | CONSTRUCTOR
     |--------------------------------------------------------------------------
    */
    public function __construct()
    {

    }










    /*
     |--------------------------------------------------------------------------
     | STORE STOCK (METHOD)
     |--------------------------------------------------------------------------
    */
    public function storeStock($stockable, $company_id, $supplier_id, $warehouse_id, $product_id, $product_variation_id, $lot, $ref_no, $date, $stock_type, $purchase_price, $sale_price, $quantity, $expire_date)
    {
        //dd($stockable, $company_id, $supplier_id, $warehouse_id, $product_id, $product_variation_id, $lot, $date, $stock_type, $purchase_price, $sale_price, $quantity);
        return $this->stock = $stockable->stocks()->create(
        [
            'company_id'                    => $company_id,
            'supplier_id'                   => $supplier_id,
            'warehouse_id'                  => $warehouse_id,
            'product_id'                    => $product_id,
            'product_variation_id'          => $product_variation_id,
            'lot'                           => $lot,
            'ref_no'                        => $ref_no,
            'date'                          => $date,
            'expire_date'                   => $expire_date ?? null,
            'stock_type'                    => $stock_type,
            'purchase_price'                => $purchase_price ?? 0,
            'sale_price'                    => $sale_price ?? 0,
            'quantity'                      => $quantity ?? 0,
            'actual_quantity'               => $stock_type == 'In' ? $quantity : '-' . $quantity,
        ]);
    }










    /*
     |--------------------------------------------------------------------------
     | UPDATE OR CREATE STOCK SUMMARY (METHOD)
     |--------------------------------------------------------------------------
    */
    public function updateOrCreateStockSummary($company_id, $supplier_id, $warehouse_id, $product_id, $product_variation_id, $lot, $expire_date, $stock_in_qty, $stock_out_qty, $stock_in_value, $stock_out_value)
    {
        // dd($company_id, $supplier_id, $warehouse_id, $product_id, $product_variation_id, $lot, $expire_date, $stock_in_qty, $stock_out_qty, $stock_in_value, $stock_out_value);
        $stock_summary  = StockSummary::query()
                        ->where([
                            'company_id'                    => $company_id,
                            'supplier_id'                   => $supplier_id,
                            'warehouse_id'                  => $warehouse_id,
                            'product_id'                    => $product_id,
                            'product_variation_id'          => $product_variation_id,
                            'lot'                           => $lot,
                            'expire_date'                   => $expire_date,
                        ])
                        ->select('stock_in_qty', 'stock_out_qty', 'stock_in_value', 'stock_out_value')
                        ->first();

                        // dd($stock_summary);

        $stockInQty     = $stock_summary != null ? $stock_summary->stock_in_qty + $stock_in_qty : $stock_in_qty;
        $stockOutQty    = $stock_summary != null ? $stock_summary->stock_out_qty + $stock_out_qty : $stock_out_qty;
        $stockInValue   = $stock_summary != null ? $stock_summary->stock_in_value + $stock_in_value : $stock_in_value;
        $stockOutValue  = $stock_summary != null ? $stock_summary->stock_out_value + $stock_out_value : $stock_out_value;


        return $this->stockSummary = StockSummary::updateOrCreate(
        [
            'company_id'                    => $company_id,
            'supplier_id'                   => $supplier_id,
            'warehouse_id'                  => $warehouse_id,
            'product_id'                    => $product_id,
            'product_variation_id'          => $product_variation_id,
            'lot'                           => $lot,
            'expire_date'                   => $expire_date,
        ],
        [
            'stock_in_qty'                  => $stockInQty,
            'stock_out_qty'                 => $stockOutQty,
            'stock_in_value'                => $stockInValue,
            'stock_out_value'               => $stockOutValue,
        ]);
    }












    /*
     |--------------------------------------------------------------------------
     | DELETE STOCKS METHOD
     |--------------------------------------------------------------------------
    */
    public function deleteStocks($stockable)
    {
        $stockable->stocks()->delete();
    }













    /*
     |--------------------------------------------------------------------------
     | UPDATE STOCK SUMMARIES METHOD
     |--------------------------------------------------------------------------
    */
    public function updateStockSummaries($company_id, $supplier_id, $warehouse_id, $product_id, $product_variation_id, $lot, $expire_date, $stock_in_qty, $stock_out_qty, $stock_in_value, $stock_out_value)
    {
        // dd($company_id, $supplier_id, $warehouse_id, $product_id, $product_variation_id, $lot, $stock_in_qty, $stock_out_qty, $stock_in_value, $stock_out_value);
        $stockSummary                   = StockSummary::query()
                                        ->where([
                                            'company_id'                    => $company_id,
                                            'supplier_id'                   => $supplier_id,
                                            'warehouse_id'                  => $warehouse_id,
                                            'product_id'                    => $product_id,
                                            'product_variation_id'          => $product_variation_id,
                                            'lot'                           => $lot,
                                        ])
                                        ->select('id', 'stock_in_qty', 'stock_out_qty', 'stock_in_value', 'stock_out_value')
                                        ->first();


        // UPDATE STOCK SUMMARY
        StockSummary::where('id', $stockSummary->id)->update([

            'stock_in_qty'              => $stockSummary->stock_in_qty - $stock_in_qty,
            'stock_out_qty'             => $stockSummary->stock_out_qty - $stock_out_qty,
            'stock_in_value'            => $stockSummary->stock_in_value - $stock_in_value,
            'stock_out_value'           => $stockSummary->stock_out_value - $stock_out_value,
        ]);


        $stockSummary = $stockSummary->refresh();

        // dd($stockSummary);

        return $stockSummary;
    }













    /*
     |--------------------------------------------------------------------------
     | DELETE STOCK SUMMARIES METHOD
     |--------------------------------------------------------------------------
    */
    public function deleteStockSummaries($query)
    {
        $query->stockSummaries()->delete();
    }
}
