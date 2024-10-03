<?php

namespace Module\Product\Services;

use Module\Product\Models\Category;

class CategoryService
{
    /*
     |--------------------------------------------------------------------------
     | GET CATEGORY IDS
     |--------------------------------------------------------------------------
    */
    public function getCategoryIds($request)
    {
        $categoryIds        = Category::query()
                            ->when(request()->filled('category_id'), function ($q) use ($request) {
                                $q->with('childCategories')
                                ->where('id', $request->category_id);
                            })
                            ->when(request()->filled('slug'), function ($q) use ($request) {
                                $q->with('childCategories')
                                ->where('slug', $request->slug);
                            })
                            ->get()->map(function ($item) {
                                return [
                                    'id'            => $item->id,
                                    'category_id'   => $this->getChildCategoriesId($item->childCategories)
                                ];
                            });

        $categories_id      = $categoryIds->flatten();

        return $categories_id;
    }








    /*
     |--------------------------------------------------------------------------
     | GET CHILD CATEGORIES ID METHOD
     |--------------------------------------------------------------------------
    */
    public function getChildCategoriesId($childCategories)
    {   
        $category_ids = [];

        $childCategories->map(function($item) use(&$category_ids) {

            $item->childCategories->map(function($item) use(&$category_ids) {
                return $category_ids[] = $item->id;
            });

            return $category_ids[] = $item->id;
            
        });

        return $category_ids;
    }
}
