<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Module\Inventory\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function subCategories()
    {
        $subCategories = SubCategory::query()
            ->select('id', 'category_id', 'name', 'slug')
            ->where('status', 1)
            ->get();

        return response()->json(["subCategories" => $subCategories], 200);
    }
}
