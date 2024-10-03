<?php

use Illuminate\Support\Facades\Route;
use Module\WebsiteCMS\Controllers\Api\ApiController;
use Module\WebsiteCMS\Controllers\Api\BlogController;
use Module\WebsiteCMS\Controllers\Api\CommonSectionController;


Route::group(['prefix' => 'api'], function () {

    /*
    |----------------------------------------------------------------
    |   COMMON SECTION DATA ROUTE
    |-----------------------------------------------------------------
    */
    Route::get('get-common-section-data/{user_id?}',                    [CommonSectionController::class, 'getCommonSectionData']);

    Route::get('get-common-section-data-v2/{user_id?}',                 [CommonSectionController::class, 'getCommonSectionDataV2']);

    Route::get('get-company-info',                                      [CommonSectionController::class, 'getCompanyInfo']);

    Route::get('get-pages-show-on-quick-links',                         [CommonSectionController::class, 'getPagesShowOnQuickLinks']);

    Route::get('get-sidebar-categories-show-on-menu',                   [CommonSectionController::class, 'getSidebarCategoriesShowOnMenu']);

    Route::get('get-total-wishlists/{user_id?}',                        [CommonSectionController::class, 'getTotalWishlists']);

    Route::get('get-time-slots-data',                                   [CommonSectionController::class, 'getTimeSlotsData']);

    Route::get('get-districts-data',                                    [CommonSectionController::class, 'getDistrictsData']);

    /*
    |----------------------------------------------------------------
    |   HOME PAGE ROUTE
    |-----------------------------------------------------------------
    */
    Route::get('get-homepage-data',                                     [ApiController::class, 'getHomepageData']);
    Route::get('get-services',                                          [ApiController::class, 'getServices']);
    Route::get('get-subscribers-content',                               [ApiController::class, 'getSubscribersContent']);
    Route::post('submit-subscriber-email',                              [ApiController::class, 'submitSubscriberEmail']);


    /*
    |----------------------------------------------------------------
    |   BLOG ROUTE
    |-----------------------------------------------------------------
    */
    Route::get('get-blogs',                                             [BlogController::class, 'getBlogs']);
    Route::get('get-highlighted-blogs',                                 [ApiController::class, 'getHighlightedBlogs']);
    Route::get('get-latest-highlighted-blogs',                          [ApiController::class, 'getLatestHighlightedBlogs']);
    Route::get('get-blog-details/{slug}',                               [BlogController::class, 'getBlogDetails']);

    Route::post('submit-contact-form',                                  [ApiController::class, 'submitContactForm']);

    Route::get('get-social-links',                                      [ApiController::class, 'getSocialLinks']);
    Route::get('get-testimonials',                                      [ApiController::class, 'getTestimonials']);

    Route::get('get-sliders',                                           [ApiController::class, 'getSliders']);
    Route::get('get-pages',                                             [ApiController::class, 'getPages']);
    Route::get('get-banners',                                           [ApiController::class, 'getBanners']);
    Route::get('get-promo-part-one',                                    [ApiController::class, 'getPromoPartOne']);
    Route::get('get-promo-part-two',                                    [ApiController::class, 'getPromoPartTwo']);
    Route::get('get-page/{slug}',                                       [ApiController::class, 'getPage']);
    Route::get('get-page-sections',                                     [ApiController::class, 'PageSections']);
    Route::get('get-page-section/{slug}',                               [ApiController::class, 'getPageSection']);
    Route::get('get-instruction-notes/{slug}',                          [ApiController::class, 'getInstructionNotes']);

    Route::get('get-checkout-page-data',                                [ApiController::class, 'getCheckoutPageData']);


    Route::get('get-promo-part-one-three-banner',                       [ApiController::class, 'getPromoPartOneThreeBanner']);
    Route::get('get-promo-part-two-one-banner',                         [ApiController::class, 'getPromoPartTwoOneBanner']);
    Route::get('get-promo-part-three-three-banner',                     [ApiController::class, 'getPromoPartthreeThreeBanner']);
    Route::get('get-promo-part-four-three-banner',                      [ApiController::class, 'getPromoPartFourThreeBanner']);

    /*
    |----------------------------------------------------------------
    |   AUTHENTICATE ROUTE
    |-----------------------------------------------------------------
    */
    Route::middleware('auth:sanctum')->group( function () {

        /*
        |----------------------------------------------------------------
        |   WISHLIST ROUTE
        |-----------------------------------------------------------------
        */
        Route::post('add-to-wishlist',                                          [ApiController::class, 'addToWishlist']);
        Route::get('get-wishlist/{user_id}',                                    [ApiController::class, 'getWishlist']);
        Route::get('delete-from-wishlist/{id}',                                 [ApiController::class, 'deleteFromWishlist']);
        Route::get('delete-from-stock-request/{id}',                            [ApiController::class, 'deleteFromStockRequest']);
    });

    Route::get('get-customer-wishlist-by-product/{user_id}/{product_id}',   [ApiController::class, 'getCustomerWishlistByProduct']); // only for checking the product has on wishlist or not

});




