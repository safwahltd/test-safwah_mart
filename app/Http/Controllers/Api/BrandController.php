<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Module\Product\Models\Brand;

class BrandController extends Controller
{
    public function brands()
    {
        $brands = Brand::query()
            ->select('id', 'name', 'slug', 'title', 'logo', 'is_highlight')
            ->where('status', 1)
            ->get();

        return response()->json(["brands" => $brands], 200);
    }
}
