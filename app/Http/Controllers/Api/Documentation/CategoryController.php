<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Module\Inventory\Models\Category;

class CategoryController extends Controller
{
    public function categories()
    {
        $categories = Category::query()
            ->select('id', 'name', 'slug', 'title', 'image', 'is_medicine', 'is_highlight', 'show_on_menu')
            ->where('status', 1)
            ->get();

        return response()->json(["categories" => $categories], 200);
    }
}
