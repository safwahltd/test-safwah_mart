<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Module\Product\Models\Product;

class PromoCodeController extends Controller
{
    public function index(Request $request)
    {
        $products = $request->get('products');
        return Product::query()
            ->whereIn('id', $products)
            ->doesntHave('discount')
            ->get(['id'])->pluck('id');
    }
}
