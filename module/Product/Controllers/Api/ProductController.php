<?php

namespace Module\Product\Controllers\Api;

use App\Models\EcomSetting;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Module\Product\Models\Brand;
use Illuminate\Support\Facades\DB;
use Module\Product\Models\Product;
use Module\WebsiteCMS\Models\Page;
use Module\Product\Models\Category;
use App\Http\Controllers\Controller;
use Module\Product\Models\Attribute;
use Module\Product\Models\Offer;
use Module\Product\Models\ProductImage;
use Module\Product\Models\ProductReview;
use Module\Product\Models\ProductVariation;
use Module\Product\Services\CategoryService;
use Module\Product\Models\ProductVariationAttribute;
use Module\Product\Models\Tag;

class ProductController extends Controller
{




    //--------------------------------------------------------------------------//
    //                     CATEGORY WISE PRODUCTS METHOD                        //
    //--------------------------------------------------------------------------//
    public function categoryWiseProducts(Request $request)
    {


        $field_id   = (new CategoryService)->getCategoryIds($request);

        $data['field_id'] = count($field_id);


        $slug       = $request['slug'];

        $data['selectedCategory'] = Category::where('slug', $slug)->first();

        $data['page']           = Page::where('slug', 'product')->first();

        $products       = Product::query()
                                ->active()
                                ->where(function($q) use($slug) {
                                    // if(count($field_id) > 1) {
                                    //     $q->whereIn('category_id', $field_id);
                                    // } else {
                                        $q->whereHas('category', function($qr) use($slug) {
                                            $qr->where('slug', $slug);
                                        });
                                    // }
                                })
                                ->with('discount')
                                ->withCount(['wishlist' => function ($q) use($request) {
                                    $q->where('user_id',$request->user_id);
                                }])
                                ->withSum('stockSummaries as current_stock', 'balance_qty')
                                ->with('unitMeasure:id,name')
                                ->with('category:id,name')
                                ->with('brand:id,name,slug')
                                ->with(['productMeasurements' => function ($q) {
                                    $q->active()->select('id', 'product_id', 'title', 'value', 'sku');
                                }]);

        $product_query = $products;

        $data['products'] = $products->orderBy('id', 'DESC')
                                // ->paginate(optional(EcomSetting::find(2))->value);
                                ->paginate(250);


        $data['categories']    = Category::query()
                                ->where('slug', $slug)
                                ->active()
                                ->with('parentCategories')
                                ->select(['id', 'parent_id', 'name', 'slug'])
                                ->first();

        $data['min_price']      = (int)$data['products']->min('sale_price');
        $data['max_price']      = (int)$product_query->max('sale_price');


        $data['product_min_price']      = 0;
        $data['product_max_price']      = Product::max('sale_price');

        $data['categoriesFilter'] = Category::query()
                                ->active()
                                ->withCount(['products as total_product' => function($q) {
                                    $q->active();
                                }])
                                ->orderBy('name', 'ASC')
                                ->get();

        $data['brands']         = Brand::query()
                                ->active()
                                ->whereHas('products', function ($q1) use ($slug) {
                                    $q1->active()
                                    ->where(function($q) use($slug) {
                                        // if(count($field_id) > 1) {
                                        //     $q->whereIn('category_id', $field_id);
                                        // } else {
                                        //     $q->where('category_id', $field_id);
                                        // }
                                        $q->whereHas('category', function($qr) use($slug) {
                                            $qr->where('slug', $slug);
                                        });
                                    });
                                })
                                ->withCount(['products as total_product' => function($q) use($slug) {
                                    $q->active()
                                    ->where(function($q) use($slug) {
                                        // if(count($field_id) > 1) {
                                        //     $q->whereIn('category_id', $field_id);
                                        // } else {
                                        //     $q->where('category_id', $field_id);
                                        // }
                                        $q->whereHas('category', function($qr) use($slug) {
                                            $qr->where('slug', $slug);
                                        });
                                    });
                                }])
                                ->orderBy('name', 'ASC')
                                ->get();


        return $data;
    }




    //--------------------------------------------------------------------------//
    //                     BRAND WISE PRODUCTS METHOD                           //
    //--------------------------------------------------------------------------//
    public function brandWiseProducts(Request $request)
    {

        $slug       = $request['slug'];
        $field      = $brand = Brand::query()->where('slug', $slug)->first();
        $field_id   = $field->id;


        $data['brand']          = $brand;
        $data['page']           = Page::where('slug', 'product')->first();

        $data['products']       = Product::query()
                                ->active()
                                ->where('brand_id', $field_id)
                                ->with('discount')
                                ->withCount(['wishlist' => function ($q) use($request) {
                                    $q->where('user_id',$request->user_id);
                                }])
                                ->withSum('stockSummaries as current_stock', 'balance_qty')
                                ->with('unitMeasure:id,name')
                                ->with('category:id,name')
                                ->with('brand:id,name,slug')
                                ->with(['productMeasurements' => function ($q) {
                                    $q->active()->select('id', 'product_id', 'title', 'value', 'sku');
                                }])
                                ->orderBy('id', 'DESC')
                                ->paginate(optional(EcomSetting::find(2))->value);



        return $data;
    }




    //--------------------------------------------------------------------------//
    //                     TAG WISE PRODUCTS METHOD                             //
    //--------------------------------------------------------------------------//
    public function tagWiseProducts(Request $request)
    {

        $slug       = $request['slug'];
        $field      = Tag::query()->where('slug', $slug)->first();
        $field_id   = $field->id;

        $data['page']           = Page::where('slug', 'product')->first();

        $data['products']       = Product::query()
                                ->active()
                                ->whereHas('productTags', function ($q) use ($field_id) {
                                    $q->where('tag_id', $field_id);
                                })
                                ->with('discount')
                                ->withCount(['wishlist' => function ($q) use($request) {
                                    $q->where('user_id',$request->user_id);
                                }])
                                ->withSum('stockSummaries as current_stock', 'balance_qty')
                                ->with('unitMeasure:id,name')
                                ->with('category:id,name')
                                ->with('brand:id,name,slug')
                                ->with(['productMeasurements' => function ($q) {
                                    $q->active()->select('id', 'product_id', 'title', 'value', 'sku');
                                }])
                                ->orderBy('id', 'DESC')
                                ->paginate(optional(EcomSetting::find(2))->value);


        return $data;
    }









    /*
     |--------------------------------------------------------------------------
     | CATEGORY OR BRAND WISE PRODUCTS METHOD
     |--------------------------------------------------------------------------
    */
    public function categoryOrBrandWiseProducts(Request $request)
    {

        $type = $request['type'];
        $slug = $request['slug'];


        if ($type == 'category') {

           $field = (new CategoryService)->getCategoryIds($request);

        } elseif ($type == 'brand') {

            $field = Brand::query()->where('slug', $slug)->first();
            $field = $field->id;

        }
        elseif ($type == 'tag') {

            $field = Tag::query()->where('slug', $slug)->first();
            $field = $field->id;

        }

        return $this->getProducts($request, $field, $type, $slug);
    }





    /*
     |--------------------------------------------------------------------------
     | GET PRODUCTS METHOD
     |--------------------------------------------------------------------------
    */
    public function getProducts($request, $field_id, $type, $slug)
    {

        $data['page']           = Page::where('slug', 'product')->first();

        $data['products']       = Product::query()
                                ->active()
                                ->when($request['type'] && $request['type'] == 'brand', function ($q) use ($field_id) {
                                    $q->where('brand_id', $field_id);
                                })
                                ->when($request['type'] && $request['type'] == 'category', function ($q) use ($field_id) {
                                    $q->whereIn('category_id', $field_id);
                                })
                                ->when($request['type'] && $request['type'] == 'tag', function ($q) use ($field_id) {
                                    $q->whereHas('productTags', function ($q) use ($field_id) {
                                        $q->where('tag_id', $field_id);
                                    });
                                })

                                ->with('discount')
                                ->withCount(['wishlist' => function ($q) use($request) {
                                    $q->where('user_id',$request->user_id);
                                }])
                                ->withSum('stockSummaries as current_stock', 'balance_qty')
                                ->with('unitMeasure:id,name')
                                ->with('category:id,name')
                                ->with('brand:id,name,slug')
                                ->with(['productMeasurements' => function ($q) {
                                    $q->active()->select('id', 'product_id', 'title', 'value', 'sku');
                                }])
                                ->orderBy('id', 'DESC')
                                ->paginate(optional(EcomSetting::find(2))->value);


        if ($type == 'category') {

          $data['categories']    = Category::query()
                                ->where('slug', $slug)
                                ->active()
                                ->with('parentCategories')
                                ->select(['id', 'parent_id', 'name', 'slug'])
                                ->first();
        }
        else{
            $data['categories']  ='';
        }


        return $data;
    }



       /*
     |--------------------------------------------------------------------------
     | CATEGORY OR BRAND WISE PRODUCTS METHOD
     |--------------------------------------------------------------------------
    */
    public function categoryOrBrandWiseProductsWithFilter(Request $request)
    {
        $type = $request['type'];
        $slug = $request['slug'];

        if ($type == 'category') {

          $field = (new CategoryService)->getCategoryIds($request);

        } elseif ($type == 'brand') {
            $field = Brand::query()->where('slug', $slug)->first();
            $field = $field->id;
        }

        return $this->getProductsWithFilter($request, $field);
    }


    public function getProductsWithFilter($request, $field_id)
    {
        $data['page']           = Page::where('slug', 'product')->first();

        $search                 = $request['search'];
        $sort                   = $request['sort'];

        $products               = Product::query()
                                ->active()
                                ->when(!isset($request['brand']) && $request['type'] && $request['type'] == 'brand', function ($q) use ($field_id) {
                                    $q->where('brand_id', $field_id);
                                })
                                ->when(!isset($request['category']) && $request['type'] && $request['type'] == 'category', function ($q) use ($field_id) {
                                    $q->whereIn('category_id', $field_id);
                                })
                                ->with('discount')
                                ->withSum('stockSummaries as current_stock', 'balance_qty')
                                ->with('unitMeasure:id,name')
                                ->with('category:id,name')
                                ->with('brand:id,name')
                                ->when($request->filled('search'), function ($query) use ($search) {
                                    $query->where(function ($q) use ($search) {
                                        $q->where('name', 'like', '%' . $search . '%')
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
                                });;


            $data['min_price']      = (int)$products->min('sale_price');
            $data['max_price']      = (int)$products->max('sale_price');

            $data['products']       = $products->orderBy('id', 'DESC')
                                    ->paginate(EcomSetting::find(2)->value);

            $data['total_products'] = $products->count();

            $data['categories']  = Category::query()
                                        ->with(['childCategories' => function($q){
                                            $q->withCount('products as total_product');
                                        }])
                                        ->when($request['type'] && $request['type'] == 'category', function ($q) use ($request) {
                                            $q->where('slug', $request['slug']);
                                        })
                                        ->active()
                                        ->withCount('products as total_product')
                                        ->orderBy('name', 'ASC')
                                        ->get();

            // $data['brands']         = Brand::query()
            //                         ->active()
            //                         ->withCount('products as total_product')
            //                         ->orderBy('name', 'ASC')
            //                         ->get();
            $productId              = $products->pluck('id');
            $categoryId             = $data['categories']->pluck('id');

            $data['brands']         = Brand::query()
                                    ->whereHas('products' , function($q) use ($productId){
                                        $q->whereIn('id', $productId);
                                    })
                                    ->active()
                                    ->withCount(['products as total_product' =>function($q) use($categoryId){
                                        $q->whereIn('category_id', $categoryId);
                                    }])
                                    ->orderBy('name', 'ASC')
                                    ->get();

        return $data;
    }

    function postReviews(Request $request){

        // $request->validate([
        //     'product_id'              => 'required|unique_with:pdt_product_reviews, product_id,user_id',

        // ]);

        try {

            if($request->user_id){

                DB::transaction(function () use($request) {

                    ProductReview::updateOrCreate([
                        'product_id'    => $request->product_id,
                        'user_id'       => $request->user_id,
                    ],
                    [
                        'rating'        => $request->rate,
                        'comment'       => $request->comment,
                    ]);



                    $rating = ProductReview::where('product_id', $request->product_id)->get();


                    $product = Product::find($request->product_id);

                    $product->update([
                        'avg_rating'        => $rating->avg('rating'),
                        'total_rating_user' => $rating->count(),
                    ]);
                });

            }

            return response()->json([
                'status'    => 1,
                'message'   => "Review added Successfully"
            ]);

        } catch (\Exception $ex) {

            return response()->json([
                'status'    => 0,
                'message'   => $ex->getMessage()
            ]);
        }

    }








    /*
     |--------------------------------------------------------------------------
     | GET OFFER WITH PRODUCTS METHOD
     |--------------------------------------------------------------------------
    */
    public function getOfferWithProducts(Request $request, $slug)
    {

        $offer      = Offer::where('slug',$slug)->first();
        $offer_id   = $offer->id;

        $products           = Product::query()
                            ->active()
                            // ->whereHas('currentDiscount', function ($q) {
                            //     $q->whereHas('offer', function($qr) {
                            //         $qr->active();
                            //     })->where(['show_in_offer' => 1, 'status' => 1]);
                            // })
                            ->whereHas('currentDiscount', function ($q) use($offer_id) {
                                // $q->where(['offer_id' => $offer_id,'show_in_offer' => 1, 'status' => 1]);
                                $q->where('offer_id', $offer_id)->where('show_in_offer', 1)->where('status', 1)->where('end_date', '>=', date('Y-m-d'));
                            })
                            ->with('currentDiscount')
                            ->with(['productMeasurements' => function ($q) {
                                $q->active()->select('id', 'product_id', 'title', 'value', 'sku');
                            }])
                            ->with('unitMeasure:id,name')
                            ->with('category:id,name')
                            ->with('brand:id,name,slug')
                            ->withSum('stockSummaries as current_stock', 'balance_qty')
                            ->with('unitMeasure:id,name')
                            ->withCount(['wishlist' => function ($q) use($request) {
                                $q->where('user_id',$request->user_id);
                            }]);

        $data['products'] = $products->paginate(20);

        return $data;

    }







    /*
     |--------------------------------------------------------------------------
     | OFFER PRODUCTS METHOD
     |--------------------------------------------------------------------------
    */
    public function offerProducts(Request $request)
    {
        $products           = Product::query()
                            ->active()
                            // ->whereHas('discount', function ($q) {
                            //     $q->where(['show_in_offer' => 1, 'status' => 1]);
                            // })
                            ->whereHas('currentDiscount', function ($q) {
                                $q->whereHas('offer', function($qr) {
                                    $qr->active();
                                })->where('show_in_offer', 1)->where('status', 1)->where('end_date', '>=', date('Y-m-d'));
                            })
                            ->with(['productMeasurements' => function ($q) {
                                $q->active()->select('id', 'product_id', 'title', 'value', 'sku');
                            }])
                            ->with('currentDiscount')
                            ->with('unitMeasure:id,name')
                            ->with('category:id,name')
                            ->with('brand:id,name,slug')
                            ->withSum('stockSummaries as current_stock', 'balance_qty')
                            ->with('unitMeasure:id,name')
                            ->withCount(['wishlist' => function ($q) use($request) {
                                $q->where('user_id',$request->user_id);
                            }])
                            ;

        $data['total_products'] = $products->count();
        $data['products'] = $products->paginate(20);

        return $data;
    }





    /*
     |--------------------------------------------------------------------------
     | GET VARIATION DATA
     |--------------------------------------------------------------------------
    */
    public function getVariationData(Request $request)
    {
        $attribute_name = [];
        foreach($request['attributes'] as $key => $attr_id) {
            $attribute_name[$key] = Attribute::where('id', $attr_id)->first()->name;
        }

        $attributeCollection = collect($attribute_name);
        $attributeSorted = $attributeCollection->sort();

        $attribute_result = $attributeSorted->values()->all();

        $productVariations = ProductVariation::get(['id', 'name']);
        $variation_id = '';

        foreach ($productVariations as $productVariation) {

            $name = explode(',', $productVariation->name);

            $variationCollection = collect($name);
            $variationSorted = $variationCollection->sort();

            if ($variationSorted->values()->all() == $attribute_result) {
                $variation_id = $productVariation->id;
            }
        }

        $data['product'] = Product::find($request['product_id']);
        $data['variation']      = ProductVariation::query()
                                ->where('id', $variation_id)
                                ->withSum('stockSummaries as current_stock','balance_qty')
                                ->first();

        $data['variation_id']   = $variation_id;
        $data['product_id']     = $request['product_id'];
        if(isset($request['color']) && $request['color'] != null){
            $get_variation_id       = ProductVariationAttribute::query()
                ->when(isset($request['color']) && $request['color'] != null, function ($q) use ($request) {
                    $q->where('product_id', $request['product_id'])
                    ->where([['attribute_id', $request['color']]]);
                })
                ->get()->map(function ($item) {
                    return [
                        'variation_id' => $item->product_variation_id,
                    ];
                });
            }else{
                $get_variation_id       = ProductVariationAttribute::where('product_id', $request['product_id'])
                ->get()->map(function ($item) {
                    return [
                        'variation_id' => $item->product_variation_id,
                    ];
                });
        }

         $variation_ids          = $get_variation_id->flatten();
         $vid = [];
        foreach($variation_ids as $row=>$val){
            $valid = 0;
            $valid2 = 0;
            $attr       = ProductVariationAttribute::where([['product_variation_id', $val]])->get();

            foreach($attr  as $vs=>$v){
                if($v->attribute_type_id==1){
                    if($v->attribute_id==$request['color']){
                        $valid=1;
                    }else{
                        $valid = 0;
                    }
                }
                else{
                    if($v->attribute_id==$request['size']){
                        $valid2=1;
                    }else{
                        $valid2 = 0;
                    }
                }
            }

            if($valid && $valid2){
                $vid[] = $v->product_variation_id;
            }
        }

        if(isset($request['color']) && $request['color'] != null){
                $data['images']         = ProductImage::query()
                                ->when(isset($request['color']) && $request['color'] != null, function ($q) use ($vid) {
                                    $q->variationImages()
                                    ->whereIn('sourcable_id', $vid);
                                })
                                ->get();
        }else{
            $data['images']       = ProductImage::whereIn('sourcable_id', $vid)->get();
        }
        return $data;
    }





    /*
     |--------------------------------------------------------------------------
     | GET PRODUCT REVIEWS
     |--------------------------------------------------------------------------
    */
    public function getProductReviews($product_id)
    {
        return  ProductReview::query()
                ->where('product_id', $product_id)
                ->with('user:id,name,image')
                ->orderBy('id', 'DESC')
                ->get();
    }





    /*
     |--------------------------------------------------------------------------
     | DELETE PRODUCT REVIEW
     |--------------------------------------------------------------------------
    */
    public function deleteProductReview($id)
    {
        try {

            ProductReview::destroy($id);

            return response()->json([
                'status'    => 1,
                'message'   => "Review has been deleted Successfully"
            ]);

        } catch (\Exception $ex) {

            return response()->json([
                'status'    => 0,
                'message'   => $ex->getMessage()
            ]);
        }
    }





    /*
     |--------------------------------------------------------------------------
     | GET AUTH USER REVIEW
     |--------------------------------------------------------------------------
    */
    public function getAuthUserReview(Request $request)
    {
        return  ProductReview::query()
                ->where('user_id', $request->user_id)
                ->where('product_id', $request->product_id)
                ->first();
    }




    public function autoCompleteSearch(Request $request)
    {
        $products   = Product::query()
                    ->where('name', 'LIKE', '%' . $request->search . '%')
                    ->take(15)
                    ->select('id', 'name', 'slug', 'sku')
                    ->get();

        if (count($products) == 0) {
            return response()->json([
                'status'    => 0,
                'data'      => 'Not Found'
            ]);
        }

        return response()->json([
            'status'    => 1,
            'data'      => $products
        ]);
    }
}
