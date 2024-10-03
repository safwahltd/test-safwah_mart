<?php

use Illuminate\Support\Facades\Route;
use Module\Product\Controllers\Api\ApiController;
use Module\Product\Controllers\Api\SearchController;
use Module\Product\Controllers\Api\ProductController;
use Module\Product\Controllers\Api\StoreRequestController;

Route::group(['prefix' => 'api'], function () {

    Route::get('get-highlighted-brands',                        [ApiController::class,                      'getHighlightedBrands']);
    Route::get('get-highlighted-categories',                    [ApiController::class,                      'getHighlightedCategories']);
    Route::get('get-highlighted-category-with-products',        [ApiController::class,                      'getHighlightedCategoryWithProducts']);
    Route::get('get-highlighted-products',                      [ApiController::class,                      'getHighlightedProducts']);
    Route::get('get-highlight-types',                           [ApiController::class,                      'getHighlightTypes']);
    Route::get('get-sidebar-categories',                        [ApiController::class,                      'getSidebarCategories']);
    Route::get('get-products/{slug}',                           [ApiController::class,                      'getProducts']);
    Route::get('get-product-details/{slug}',                    [ApiController::class,                      'getProductDetails']);
    Route::get('get-product-details-with-book/{slug}',          [ApiController::class,                      'getProductDetailsWithBooks']);
    Route::get('get-variation-id',                              [ApiController::class,                      'getVariationId']);
    Route::get('get-categories',                                [ApiController::class,                      'getCategories']);
    Route::get('get-category/{slug}',                           [ProductController::class,                  'getCategory']);
    Route::get('get-sub-categories/{slug}',                     [ApiController::class,                      'getSubCategories']);
    Route::get('get-brands',                                    [ApiController::class,                      'getBrands']);
    Route::get('get-brand-counts',                              [ApiController::class,                      'getBrandCount']);
    Route::get('get-related-products/{category_id}/{id}',       [ApiController::class,                      'getRelatedProducts']);
    Route::get('search-products',                               [SearchController::class,                   'index']);
    Route::get('get-discounted-products',                       [ApiController::class,                      'getDiscountedProducts']);
    Route::get('category-or-brand-wise-products',               [ProductController::class,                  'categoryOrBrandWiseProducts']);

    Route::get('category-wise-products',                        [ProductController::class,                  'categoryWiseProducts']);
    Route::get('brand-wise-products',                           [ProductController::class,                  'brandWiseProducts']);
    Route::get('tag-wise-products',                             [ProductController::class,                  'tagWiseProducts']);

    Route::get('offer-products',                                [ProductController::class,                  'offerProducts']);
    Route::get('get-offers',                                    [ApiController::class,                      'getOffers']);
    Route::get('get-offer-with-products/{slug}',                [ProductController::class,                  'getOfferWithProducts']);
    Route::post('post-reviews',                                 [ProductController::class,                  'postReviews']);
    Route::get('get-variation-data',                            [ProductController::class,                  'getVariationData']);
    Route::get('get-product-reviews/{product_id}',              [ProductController::class,                  'getProductReviews']);
    Route::get('get-auth-user-review',                          [ProductController::class,                  'getAuthUserReview']);
    Route::delete('delete-product-review/{id}',                 [ProductController::class,                  'deleteProductReview']);
    Route::get('auto-complete-search',                          [ProductController::class,                  'autoCompleteSearch']);

    Route::get('category-or-brand-wise-products-with-filter',   [ProductController::class,                  'categoryOrBrandWiseProductsWithFilter']);

    Route::get('monwamart-search-products',                     [SearchController::class,                   'monwamartIndex']);

    Route::get('get-offer-page-info',                           [ApiController::class,                      'getOfferPageInfo']);
    Route::get('get-single-offer-page-info/{slug}',             [ApiController::class,                      'getSingleOfferPageInfo']);
    Route::get('get-discount-page-info',                        [ApiController::class,                      'getDiscountPageInfo']);
    Route::get('get-seo-info/{page_title}',                     [ApiController::class,                      'getSeoInfo']);


    /*
    |----------------------------------------------------------------
    |   MONWA MART API
    |-----------------------------------------------------------------
    */
    Route::get('get-limited-highlighted-categories',                               [ApiController::class,                      'getLimitedHighlightedCategories']);

    Route::get('get-highlighted-categories-limited-products/{category_id}',        [ApiController::class,                      'getHighlightedCategoriesLimitedProducts']);





    /*
    |----------------------------------------------------------------
    |   AUTHENTICATE ROUTE
    |-----------------------------------------------------------------
    */
    Route::middleware('auth:sanctum')->group( function () {

        /*
        |----------------------------------------------------------------
        |   STOCK REQUEST ROUTE
        |-----------------------------------------------------------------
        */
        Route::get('get-stock-requests/{customer_id}',              [StoreRequestController::class, 'getStockRequests']);
        Route::post('store-stock-request',                          [StoreRequestController::class, 'storeStockRequest']);
    });
});
