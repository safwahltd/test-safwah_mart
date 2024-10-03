<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Module\Inventory\Models\ProductType;

class ProductTypeController extends Controller
{
    public function productTypes()
    {
        $productTypes = ProductType::query()
            ->select('id', 'name', 'slug', 'image')
            ->where('status', 1)
            ->get();

        return response()->json(["productTypes" => $productTypes], 200);
    }
}
