<?php

namespace Module\Product\Controllers\Api;

use Illuminate\Http\Request;
use Module\Product\Models\Brand;
use Illuminate\Support\Facades\DB;
use Module\Product\Models\Product;
use Module\WebsiteCMS\Models\Page;
use Module\Product\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\EcomSetting;
use App\Models\MetaInfo;
use Module\Inventory\Models\OrderStatus;
use Module\Product\Models\HighlightType;
use Module\Product\Models\Offer;
use Module\Product\Models\ProductDiscount;
use Module\Product\Models\ProductVariationAttribute;
use Module\WebsiteCMS\Services\JsonResponseService;

class ApiController extends Controller
{
    private $jsonResponseService;





    /*
     |--------------------------------------------------------------------------
     | CONSTRUCT
     |--------------------------------------------------------------------------
    */
    public function __construct(JsonResponseService $jsonResponseService)
    {
        $this->jsonResponseService = $jsonResponseService;
    }








    /*
     |--------------------------------------------------------------------------
     | GET HIGHLIGHTED BRAND
     |--------------------------------------------------------------------------
    */
    public function getHighlightedBrands()
    {
        return $this->jsonResponseService->get(Brand::query()->active()->highlighted()->inRandomOrder()->withCount('products as total_products'), 'brands');
    }



    /*
     |--------------------------------------------------------------------------
     | GET DISCOUNTED PRODUCT
     |--------------------------------------------------------------------------
    */
    public function getDiscountedProducts()
    {
        // return $data['discountedProducts'] = Product::with('discount')->whereHas('discount')->take(25)->get();
        $query = Product::with('discount')->whereHas('discount')->with('brand:id,name,slug')->take(25);

        return $this->jsonResponseService->get($query, 'discounted_products');
        // return $this->jsonResponseService->get($brand, 'brands');
    }






    /*
     |--------------------------------------------------------------------------
     | GET HIGHLIGHTED CATEGORY
     |--------------------------------------------------------------------------
    */
    public function getHighlightedCategories()
    {
        $data['categories'] = Category::query()->whereHas('products')->active()->highlighted()->where('serial_no', '!=', null)->orderBy('serial_no', 'ASC')->take(12)->get();
        $data['all_pdoruct_category'] = EcomSetting::where('id', 53)->where('value', 'on')->exists();


        return response()->json([

            'data'      => $data,
            'message'   => 'success',
            'status'    => 1,
        ]);
    }

    /*
     |--------------------------------------------------------------------------
     | GET HIGHLIGHTED CATEGORY
     |--------------------------------------------------------------------------
    */
    public function getLimitedHighlightedCategories()
    {
        return $this->jsonResponseService->get(Category::query()->whereHas('products')->active()->highlighted()->inRandomOrder()->take(5), 'categories');
    }


    /*
     |--------------------------------------------------------------------------
     | GET HIGHLIGHTED CATEGORY WITH PRODUCTS
     |--------------------------------------------------------------------------
    */
    public function getHighlightedCategoryWithProducts()
    {
        $query = Category::query()
            ->highlighted()
            ->whereHas('products')
            ->with('products', function ($q1) {
                $q1->with('discount')
                    ->with('unitMeasure:id,name')
                    ->with('brand:id,name,slug')
                    ->withSum('stockSummaries as current_stock', 'balance_qty');
            })
            ->inRandomOrder()
            ->take(12)
            ->orderBy('serial_no', 'ASC');

        return $this->jsonResponseService->get($query, 'categories');
    }




    /*
     |--------------------------------------------------------------------------
     | GET HIGHLIGHTED PRODUCTS
     |--------------------------------------------------------------------------
    */
    public function getHighlightedProducts(Request $request)
    {
        return  HighlightType::with(['productHighlightTypes' => function ($q) use ($request) {
            $q->whereHas('product', function ($q) {
                $q->active();
            })
                ->with('product', function ($q1) use ($request) {
                    $q1->with('discount')
                        ->with('unitMeasure:id,name')
                        ->with(['productMeasurements' => function ($q) {
                            $q->active()->select('id', 'product_id', 'title', 'value', 'sku');
                        }])
                        ->with('brand:id,name,slug')
                        ->withCount(['wishlist' => function ($q) use ($request) {
                            $q->where('user_id', $request->user_id);
                        }])
                        ->withSum('stockSummaries as current_stock', 'balance_qty');
                });
        }])->where('status', 1)->get();
    }




    public function getHighlightTypes()
    {
        return $this->jsonResponseService->get(HighlightType::query()->active()->whereHas('productHighlightTypes'), 'highlightTypes');
    }











    /*
     |--------------------------------------------------------------------------
     | GET SIDEBAR CATEGORY
     |--------------------------------------------------------------------------
    */

    public function getSidebarCategories()
    {
        return $this->jsonResponseService->get(Category::query()->where('parent_id', null)->with('childCategories'), 'allCategories');

        return $data['categories'] = Category::query()
            ->where('parent_id', null)
            ->with('childCategories')
            ->get(['id', 'name']);
    }







    /*
     |--------------------------------------------------------------------------
     | GET PRODUCT
     |--------------------------------------------------------------------------
    */

    public function getProducts($filter)
    {
        $categoryId = $this->getCategoryId($filter);
        $brandId    = $this->getBrandId($filter);
        $search     = $this->getSearchData($filter);

        $product = Product::query()
            ->when(!is_null($categoryId), function ($query) use ($categoryId) {
                return $query->whereIn('category_id', $categoryId);
            })
            ->when(!is_null($brandId), function ($query) use ($brandId) {
                return $query->where('brand_id', $brandId);
            });
        return $this->jsonResponseService->get($product, 'products');
    }


    function getCategoryId($slug)
    {

        $categoryId = Category::where('slug', $slug)->select('id')->first();

        if (!is_null($categoryId)) {
            $category   = Category::where('id', $categoryId->id)
                ->orWhere('parent_id', $categoryId->id)
                ->pluck('id');
            return $category;
        }
    }



    function getBrandId($slug)
    {

        $brand = Brand::where('slug', $slug)->select('id')->first();

        if (!is_null($brand)) {
            return $brand->id;
        }
    }

    function getSearchData($slug)
    {
        $brand = Product::where('slug', $slug)->select('id')->first();
        if (!is_null($brand)) {
            return $brand->id;
        }
    }









    /*
     |--------------------------------------------------------------------------
     | GET PRODUCT DETAILS
     |--------------------------------------------------------------------------
    */
    function getProductDetails(Request $request, $slug)
    {
        try {

            $data['product']                    = Product::query()
                ->where('slug', $slug)
                ->active()
                ->with(['category' => function ($query) {
                    $query->with('parentCategories')->select('id', 'parent_id', 'name', 'slug');
                }])
                ->with('unitMeasure:id,name')
                ->with('brand:id,name,slug')
                ->with('productImages')
                ->with(['productMeasurements' => function ($q) {
                    $q->active()->select('id', 'product_id', 'title', 'value', 'sku');
                }])
                ->with(['productVariations' => function ($query) {
                    $query->with(['productImages' => function ($q) {
                        $q->variationImages();
                    }])->select('id', 'product_id');
                }])
                ->with(['productReviews' => function ($q) {
                    $q->with('user');
                }])
                ->with(['discount' => function ($q) {
                    $q->active()
                        ->select('id', 'product_id', 'discount_percentage', 'discount_amount', 'start_date', 'end_date');
                }])
                ->withSum('stockSummaries as current_stock', 'balance_qty')
                ->with(['productTags' => function ($q) {
                    $q->with('tag:id,name,slug')
                        ->select('product_id', 'tag_id');
                }])
                ->withCount(['wishlist' => function ($q) use ($request) {
                    $q->where('user_id', $request->user_id);
                }])
                ->first();


            $data['variationAttributeTypes']    = ProductVariationAttribute::query()
                ->where('product_id', $data['product']->id)
                ->with(['attributeType' => function ($q) use ($data) {
                    $q->with(['productVariationAttributes' => function ($q) use ($data) {
                        $q
                            ->where('product_id', $data['product']->id)
                            ->with('attribute:id,name,color_code')
                            ->groupBy('attribute_id')
                            ->select('id', 'attribute_id', 'attribute_type_id');
                    }])->select('id', 'name');
                }])
                ->groupBy('attribute_type_id')
                ->get(['id', 'attribute_type_id']);


            $data['recommendedProducts']        = Product::where('category_id', '!=', $data['product']->category_id)
                ->active()
                ->with('category:id,name,slug')
                ->with('unitMeasure:id,name')
                ->with('brand:id,name,slug')
                ->with(['productMeasurements' => function ($q) {
                    $q->active()->select('id', 'product_id', 'title', 'value', 'sku');
                }])
                ->with(['productReviews' => function ($q) {
                    $q->with('user');
                }])
                ->with(['discount' => function ($q) {
                    $q->active()
                        ->select('id', 'product_id', 'discount_percentage', 'discount_amount', 'start_date', 'end_date');
                }])
                ->withSum('stockSummaries as current_stock', 'balance_qty')
                ->with(['productTags' => function ($q) {
                    $q->with('tag:id,name,slug')
                        ->select('product_id', 'tag_id');
                }])
                ->withCount(['wishlist' => function ($q) use ($request) {
                    $q->where('user_id', $request->user_id);
                }])
                ->take(2)
                ->groupBy()
                ->inRandomOrder()
                ->get();

            $data['page']                       = Page::where('slug', 'product-details')->first();

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);
        }
    }







    /*
     |--------------------------------------------------------------------------
     | GET PRODUCT DETAILS WITH BOOKS
     |--------------------------------------------------------------------------
    */
    function getProductDetailsWithBooks($slug)
    {

        try {

            $data['product']                    = Product::query()
                ->where('slug', $slug)
                ->active()
                ->with('category:id,name,slug')
                ->with('unitMeasure:id,name')
                ->with('brand:id,name,slug')
                ->with('productImages')
                ->with(['bookProduct' => function ($q) {
                    $q->with('writer')->with('publisher');
                }])
                ->with(['productReviews' => function ($q) {
                    $q->with('user');
                }])
                ->with(['discount' => function ($q) {
                    $q->active()
                        ->select('id', 'product_id', 'discount_percentage', 'discount_amount', 'start_date', 'end_date');
                }])
                ->withSum('stockSummaries as current_stock', 'balance_qty')
                ->with(['productTags' => function ($q) {
                    $q->with('tag:id,name,slug')
                        ->select('product_id', 'tag_id');
                }])
                ->first();


            $data['variationAttributeTypes']    = ProductVariationAttribute::query()
                ->where('product_id', $data['product']->id)
                ->with(['attributeType' => function ($q) {
                    $q->with(['productVariationAttributes' => function ($q) {
                        $q->with('attribute:id,name,color_code')
                            ->groupBy('attribute_id')
                            ->select('id', 'attribute_id', 'attribute_type_id');
                    }])->select('id', 'name');
                }])
                ->groupBy('attribute_type_id')
                ->get(['id', 'attribute_type_id']);


            $data['recommendedProducts']        = Product::where('category_id', '!=', $data['product']->category_id)
                ->active()
                ->with('category:id,name,slug')
                ->with('unitMeasure:id,name')
                ->with('brand:id,name,slug')
                ->with(['productReviews' => function ($q) {
                    $q->with('user');
                }])
                ->with(['discount' => function ($q) {
                    $q->active()
                        ->select('id', 'product_id', 'discount_percentage', 'discount_amount', 'start_date', 'end_date');
                }])
                ->withSum('stockSummaries as current_stock', 'balance_qty')
                ->with(['productTags' => function ($q) {
                    $q->with('tag:id,name,slug')
                        ->select('product_id', 'tag_id');
                }])
                ->take(2)
                ->groupBy()
                ->inRandomOrder()
                ->get();

            $data['page']                       = Page::where('slug', 'product-details')->first();

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);
        }
    }






    public function getVariationId(Request $request)
    {
    }










    /*
     |--------------------------------------------------------------------------
     | GET BRAND
     |--------------------------------------------------------------------------
    */
    public function getBrands()
    {
        try {

            $data['seoInfo']    = MetaInfo::where('page_title', 'Brand')->first();
            $data['brands']     =  Brand::query()->withCount('products as total_products')->get();

            $data['page']      = Page::where('slug', 'brand')->first();

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);
        }
    }






    /*
     |--------------------------------------------------------------------------
     | GET BRAND COUNT
     |--------------------------------------------------------------------------
    */
    public function getBrandCount()
    {
        try {

            $brand_count     =  Brand::query()->count();

            return response()->json([
                'data'      => $brand_count,
                'message'   => "Success",
                'status'    => 1,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);
        }
    }






    /*
     |--------------------------------------------------------------------------
     | GET SUB CATEGORY
     |--------------------------------------------------------------------------
    */

    public function getSubCategories($slug)
    {

        try {

            $data['seoInfo']    = MetaInfo::where('page_title', 'Category')->first();
            $data['category']       = Category::query()
                ->where('slug', $slug)
                ->active()
                ->with('subCategories')
                ->with('parentCategories')
                ->first();

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);
        }
    }








    /*
     |--------------------------------------------------------------------------
     | GET CATEGORIES
     |--------------------------------------------------------------------------
    */

    public function getCategories()
    {
        try {

            $data['seoInfo']    = MetaInfo::where('page_title', 'Category')->first();

            $data['categories']     = Category::query()
                ->active()
                // ->showOnMenu()
                ->with('childCategories')
                ->withCount('products as total_products')
                ->withCount('childCategories as totalSubCategories')
                ->get();

            $data['page']           = Page::where('slug', 'category')->first();

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);
        }
    }






    /*
     |--------------------------------------------------------------------------
     | GET OFFER PAGE INFO
     |--------------------------------------------------------------------------
    */
    public function getOfferPageInfo()
    {
        try {

            $data['seoInfo']    = MetaInfo::where('page_title', 'Offer')->first();

            $data['page']       = Page::where('slug', 'Offer')->first();

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);
        }
    }




    /*
     |--------------------------------------------------------------------------
     | GET SINGLE OFFER PAGE INFO
     |--------------------------------------------------------------------------
    */
    public function getSingleOfferPageInfo($slug)
    {
        try {
            $explodes = explode("-", $slug);

            $implode = implode(" ", $explodes);

            $data['seoInfo']    = MetaInfo::where('page_title', 'like', '%' . $implode . '%')->first();
            $data['offerSetting'] = Offer::whereSlug($slug)->first();
            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);
        }
    }



    /*
     |--------------------------------------------------------------------------
     | GET DISCOUNT PAGE INFO
     |--------------------------------------------------------------------------
    */
    public function getDiscountPageInfo()
    {
        try {

            $data['seoInfo']    = MetaInfo::where('page_title', 'Discount')->first();

            $data['page']       = Page::where('slug', 'Discount')->first();

            return response()->json([
                'data'      => $data,
                'message'   => "Success",
                'status'    => 1,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'data'      => $th->getMessage(),
                'message'   => "Error",
                'status'    => 0,
            ]);
        }
    }










    /*
     |--------------------------------------------------------------------------
     | GET SEO INFO
     |--------------------------------------------------------------------------
    */
    public function getSeoInfo($page_title)
    {
        $data = MetaInfo::where('page_title', $page_title)->first();

        return response()->json([
            'data'      => $data,
            'message'   => "Success",
            'status'    => 1,
        ]);
    }








    /*
     |--------------------------------------------------------------------------
     | GET PRODUCT
     |--------------------------------------------------------------------------
    */

    public function getRelatedProducts(Request $request, $categpry_id, $id)
    {
        $product    = Product::query()
            ->with('discount')
            ->with('unitMeasure:id,name')
            ->withSum('stockSummaries as current_stock', 'balance_qty')
            ->where('category_id', $categpry_id)
            ->with(['productMeasurements' => function ($q) {
                $q->active()->select('id', 'product_id', 'title', 'value', 'sku');
            }])
            ->with('brand:id,name,slug')
            ->withCount(['wishlist' => function ($q) use ($request) {
                $q->where('user_id', $request->user_id);
            }])
            ->where('id', '!=', $id)
            ->take(20);

        return $this->jsonResponseService->get($product, 'products');
    }








    /*
     |--------------------------------------------------------------------------
     | GET HIGHLIGHTED CATEGORY WITH LIMITED PRODUCTS
     |--------------------------------------------------------------------------
    */
    public function getHighlightedCategoriesLimitedProducts($category_id)
    {
        $query   = Product::query()
            ->with('discount')
            ->with('unitMeasure:id,name')
            ->withSum('stockSummaries as current_stock', 'balance_qty')
            ->where('category_id', $category_id)
            ->with('brand:id,name,slug')
            ->inRandomOrder()
            ->take(6);


        return $this->jsonResponseService->get($query, 'products');
    }




    /*
     |--------------------------------------------------------------------------
     | GET OFFERS METHOD
     |--------------------------------------------------------------------------
    */
    public function getOffers()
    {
        $query = Offer::query()
            ->select('id', 'name', 'slug', 'serial_no')
            ->withCount([
                'productDiscounts' => function ($query) {
                    $query->where('show_in_offer', 1)
                        ->where('status', 1)
                        ->where('end_date', '>=', date('Y-m-d'));
                }
            ]);


        return $this->jsonResponseService->get($query, 'offers');
    }
}
