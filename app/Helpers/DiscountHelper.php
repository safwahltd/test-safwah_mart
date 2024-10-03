<?php
use Carbon\Carbon;
use Module\Product\Models\Product;
use Module\Product\Models\ProductSaleDiscount;


function getDiscount($product_id)
{
    $saleDiscount   = ProductSaleDiscount::where('product_id', $product_id)
                    ->where('start_date','<=', today())
                    ->where('end_date','>=', today())
                    ->select('discount_percentage')
                    ->first();

    $discount = 0;

    if ($saleDiscount) {
        $discount = $saleDiscount->discount_percentage;
    } else {
        $product = Product::find($product_id);

        if($product->discount_percentage > 0) {
            return $product->discount_percentage;
        }
    }


    return $discount;
}

function getDiscountAmount($price = 0, $percent = 0)
{
    $discount_amount = round((($price * $percent) / 100) - 0.12);

    return $price - $discount_amount;

}

