<?php

namespace Module\Product\Controllers\Api;

use App\Models\EcomSetting;
use Illuminate\Http\Request;
use Module\Product\Models\Brand;
use Module\Product\Models\Product;
use Module\WebsiteCMS\Models\Page;
use Module\Product\Models\Category;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $data['page']           = Page::where('slug', 'product-search')->first();

        $search                 = $request['search'];
        $sort                   = $request['sort'];

        $products               = Product::query()
            ->active()
            ->with('discount')
            ->withCount(['wishlist' => function ($q) use ($request) {
                $q->where('user_id', $request->user_id);
            }])
            ->with('unitMeasure:id,name')
            ->with('category:id,name')
            ->with('brand:id,name,slug')
            ->withSum('stockSummaries as current_stock', 'balance_qty')
            ->with('unitMeasure:id,name')
            ->with(['productMeasurements' => function ($q) {
                $q->active()->select('id', 'product_id', 'title', 'value', 'sku');
            }])
            ->when($request->filled('search'), function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where(function ($q) use ($search) {
                        $q->where('name', 'like', '%' . ' ' . $search . '%')
                            ->orWhere('name', 'like', '%' . $search . ' ' . '%')
                            ->orWhere('name', $search);
                    })
                        ->orWhereHas('category', function ($q) use ($search) {
                            $q->where(function ($q1) use ($search) {
                                // $q1->where('name', 'like', '%' . $search . '%')
                                $q1->where(function ($q) use ($search) {
                                    $q->where('name', 'like', '%' . ' ' . $search . '%')
                                        ->orWhere('name', 'like', '%' . $search . ' ' . '%')
                                        ->orWhere('name', $search);
                                })
                                    ->orWhere('slug', 'like', '%' . $search . '%');
                            });
                        })
                        ->orWhereHas('brand', function ($q) use ($search) {
                            $q->where(function ($q1) use ($search) {
                                // $q1->where('name', 'like', '%' . $search . '%')
                                $q1->where(function ($q) use ($search) {
                                    $q->where('name', 'like', '%' . ' ' . $search . '%')
                                        ->orWhere('name', 'like', '%' . $search . ' ' . '%')
                                        ->orWhere('name', $search);
                                })
                                    ->orWhere('slug', 'like', '%' . $search . '%');
                            });
                        });
                });
            })
            ->when(isset($sort) && $sort != null, function ($query) use ($sort) {
                if ($sort == "latest_products") {
                    $query->orderBy('id', 'DESC');
                } elseif ($sort == "a_z_order") {
                    $query->orderBy('name', 'ASC');
                } elseif ($sort == "z_a_order") {
                    $query->orderBy('name', 'DESC');
                } elseif ($sort == "low_to_high_price") {
                    $query->orderBy('sale_price', 'ASC');
                } elseif ($sort == "high_to_low_price") {
                    $query->orderBy('sale_price', 'DESC');
                } else {
                    $query->orderBy('id', 'DESC');
                }
            })
            ->when($request->filled('brand'), function ($query) use ($request) {
                $query->whereHas('brand', function ($q) use ($request) {
                    $q->whereIn('slug', explode(',', $request['brand']))
                        ->orWhere('slug', $request['brand']);
                });
            })
            ->when($request->filled('category') && $request['category'] != 'undefined', function ($query) use ($request) {
                $query->whereHas('category', function ($q) use ($request) {
                    // dd(explode(',', $request['category']));
                    $q->whereIn('slug', explode(',', $request['category']))
                        ->orWhere('slug', $request['category'])
                        ;
                });
            });


            $product_qury = $products;
            $products = $products
                        ->when(isset($request['min_price']) || isset($request['max_price']), function ($query) use ($request) {
                            $query->whereBetween('sale_price', [$request['min_price'] == '' ? 0 : $request['min_price'], $request['max_price'] == '' ? 9999999999 : $request['max_price']]);
                        });


            $data['category'] = $request->category;

            // return $data;
            // return $request->filled('category') && $request['category'] != 'undefined' ? 'category search' : '';

        $data['product_min_price']      = 0;
        $data['product_max_price']      = Product::max('sale_price');




        // return
        $data['products']       = $products->orderBy('id', 'DESC')
            // ->paginate(EcomSetting::find(2)->value);
            ->paginate(250);

        $data['total_products'] = $products->count();

        $data['categories']     = Category::query()
            ->active()
            ->withCount(['products as total_product' => function($q) {
                $q->active();
            }])
            ->orderBy('name', 'ASC')
            ->get();

        $data['brands']         = Brand::query()
            ->active()
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('products', function ($q1) use ($request) {
                    $q1->active()->whereHas('category', function ($q2) use ($request) {
                        $q2->whereIn('slug', explode(',', $request['category']))
                            ->orWhere('slug', $request['category']);
                    })
                    ->when(isset($request['min_price']) || isset($request['max_price']), function ($query) use ($request) {
                        $query->whereBetween('sale_price', [$request['min_price'] == '' ? 0 : $request['min_price'], $request['max_price'] == '' ? 9999999999 : $request['max_price']]);
                    });
                });
            })
            ->withCount(['products as total_product' => function($q) use($request) {
                $q->when($request->filled('category'), function ($query) use ($request) {
                    $query->active()->whereHas('category', function ($q2) use ($request) {
                        $q2->whereIn('slug', explode(',', $request['category']))
                            ->orWhere('slug', $request['category']);
                    });
                })
                ->when(isset($request['min_price']) || isset($request['max_price']), function ($query) use ($request) {
                    $query->whereBetween('sale_price', [$request['min_price'] == '' ? 0 : $request['min_price'], $request['max_price'] == '' ? 9999999999 : $request['max_price']]);
                })
                ;
            }])
            ->orderBy('name', 'ASC')
            ->get();


        $data['min_price']      = $request->filled('min_price') ? $request->min_price : $data['product_min_price'];
        $data['max_price']      = $request->filled('max_price') ? $request->max_price : $product_qury->max('sale_price');

        if(count($data['products']) > 0) {
            $data['max_price'] = $products->max('sale_price');
        }
        return $data;
    }






    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function monwamartIndex(Request $request)
    {
        $data['page']           = Page::where('slug', 'product-search')->first();

        $search                 = $request['search'];
        $sort                   = $request['sort'];

        $products               = Product::query()
            ->active()
            ->with('discount')
            ->with('unitMeasure:id,name')
            ->with('category:id,name')
            ->with('brand:id,name')
            ->withSum('stockSummaries as current_stock', 'balance_qty')
            ->with('unitMeasure:id,name')
            ->when($request->filled('search'), function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('sku', $search)
                        ->orWhereHas('category', function ($q) use ($search) {
                            $q->where(function ($q1) use ($search) {
                                $q1->where('name', 'like', '%' . $search . '%')
                                    ->orWhere('slug', 'like', '%' . $search . '%');
                            });
                        })
                        ->orWhereHas('brand', function ($q) use ($search) {
                            $q->where(function ($q1) use ($search) {
                                $q1->where('name', 'like', '%' . $search . '%')
                                    ->orWhere('slug', 'like', '%' . $search . '%');
                            });
                        });
                });
            })
            ->when(isset($sort) && $sort != null, function ($query) use ($sort) {
                if ($sort == "latest_products") {
                    $query->orderBy('id', 'DESC');
                } elseif ($sort == "a_z_order") {
                    $query->orderBy('name', 'ASC');
                } elseif ($sort == "z_a_order") {
                    $query->orderBy('name', 'DESC');
                } elseif ($sort == "low_to_high_price") {
                    $query->orderBy('sale_price', 'ASC');
                } elseif ($sort == "high_to_low_price") {
                    $query->orderBy('sale_price', 'DESC');
                } else {
                    $query->orderBy('id', 'DESC');
                }
            })
            ->when(isset($request['min_price']) || isset($request['max_price']), function ($query) use ($request) {
                $query->whereBetween('sale_price', [$request['min_price'] == '' ? 0 : $request['min_price'], $request['max_price'] == '' ? 9999999999 : $request['max_price']]);
            })
            ->when(isset($request['brand']), function ($query) use ($request) {
                $query->whereHas('brand', function ($q) use ($request) {
                    $q->whereIn('slug', explode(',', $request['brand']));
                });
            })
            ->when(isset($request['category']), function ($query) use ($request) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->whereIn('slug', explode(',', $request['category']));
                });
            });


        $data['min_price']      = (int)$products->min('sale_price');
        $data['max_price']      = (int)$products->max('sale_price');

        $data['products']       = $products->orderBy('id', 'DESC')
            ->paginate(EcomSetting::find(2)->value);

        $data['total_products'] = $products->count();

        $category = [];
        if (isset($request['category'])) {
            $category           = Category::query()
                ->active()
                ->whereIn('slug', explode(',', $request['category']))
                ->pluck('id');
        }


        //  $data['categories']     = Category::query()
        //                               ->with('childCategories')

        //                         ->active()


        //                         ->withCount('products as total_product')
        //                         ->orderBy('name', 'ASC')
        //                         ->get();

        //                         $data['categories']  = Category::query()
        //                         ->with('childCategories')
        //                         ->when($request['type'] && $request['type'] == 'category', function ($q) use ($request) {
        //                             $q->where('slug', $request['slug']);
        //                         })
        //                         ->active()
        //                         ->withCount('products as total_product')
        //                         ->orderBy('name', 'ASC')
        //                         ->get();
        $data['categories']     = Category::query()
            ->where('parent_id', null)
            ->active()
            ->withCount('products as total_product')
            ->orderBy('name', 'ASC')
            ->get();

        $data['brands']         = Brand::query()
            ->active()
            ->withCount('products as total_product')
            ->orderBy('name', 'ASC')
            ->get();

        return $data;
    }
}
