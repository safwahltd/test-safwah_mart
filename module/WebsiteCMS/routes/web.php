<?php

use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;
use Module\WebsiteCMS\Controllers\AppointmentBookingController;
use Module\WebsiteCMS\Controllers\FaqController;
use Module\WebsiteCMS\Controllers\MenuController;
use Module\WebsiteCMS\Controllers\PageController;
use Module\WebsiteCMS\Controllers\PostController;
use Module\WebsiteCMS\Controllers\TestimonialController;
use Module\WebsiteCMS\Controllers\MenuCategoryController;
use Module\WebsiteCMS\Controllers\SocialLinkController;
use Module\WebsiteCMS\Controllers\SliderController;
use Module\WebsiteCMS\Controllers\BannerController;
use Module\WebsiteCMS\Controllers\SubscribersController;
use Module\WebsiteCMS\Controllers\SubscribersContentController;
use Module\WebsiteCMS\Controllers\BlogController;
use Module\WebsiteCMS\Controllers\ContactMessageController;
use Module\WebsiteCMS\Controllers\CorporateOrderController;
use Module\WebsiteCMS\Controllers\OrderByPictureController;
use Module\WebsiteCMS\Controllers\ServicesController;
use Module\WebsiteCMS\Controllers\PageSectionController;
use Module\WebsiteCMS\Controllers\InstructionNoteController;
use Module\WebsiteCMS\Controllers\SeoInfoController;

Route::group(['middleware' => 'auth', 'prefix' => 'website-cms', 'as' => 'website.'], function () {
    Route::resource('sliders',              SliderController::class);
    Route::resource('banners',              BannerController::class);
    Route::resource('menu-categories',      MenuCategoryController::class);
    Route::resource('widget-menus',         MenuController::class);
    Route::resource('posts',                PostController::class);
    Route::resource('pages',                PageController::class);
    Route::resource('instruction-notes',    InstructionNoteController::class);
    Route::resource('page-sections',        PageSectionController::class);
    Route::resource('corporate-order',      CorporateOrderController::class);
    Route::resource('orderby-picture',      OrderByPictureController::class);
    Route::resource('appointment-booking',  AppointmentBookingController::class);
    Route::resource('testimonials',         TestimonialController::class);
    Route::resource('faqs',                 FaqController::class);
    Route::resource('social-links',         SocialLinkController::class);
    Route::resource('subscribers',          SubscribersController::class);
    Route::resource('subscribers-content',  SubscribersContentController::class);
    Route::resource('blogs',                BlogController::class);
    Route::resource('services',             ServicesController::class);
    Route::resource('contact-message',      ContactMessageController::class);

    Route::get('seo-infos-create/{page_title}',         [SeoInfoController::class, 'create'])->name('seo-infos.create');
    Route::post('seo-infos-store/{page_title}',         [SeoInfoController::class, 'store'])->name('seo-infos.store');
    Route::get('seo-management/create',                 [SeoInfoController::class, 'bulkCreate'])->name('seo-management.create');
    Route::post('seo-management/store',                 [SeoInfoController::class, 'bulkStore'])->name('seo-management.store');
});
