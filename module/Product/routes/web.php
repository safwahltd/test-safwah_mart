<?php

use Illuminate\Support\Facades\Route;
use Module\Product\Controllers\ProductController;;
use Module\Product\Controllers\BarcodeController;



Route::group(['middleware' => 'auth', 'prefix' => '/admin/product-config'], function () {

    /*
     |--------------------------------------------------------------------------
     | PRODUCT ROUTES
     |--------------------------------------------------------------------------
    */
    Route::post('/update-product-status', 'ProductController@updateStatus')->name('product.update-status');

    Route::post('update-product-field', [ProductController::class, 'updateProductField'])->name('pdt.update-product-field');
    Route::get('bulk-update-create', [ProductController::class, 'bulkUpdateCreate'])->name('pdt.bulk-update.create');
    Route::post('bulk-update-store', [ProductController::class, 'bulkUpdateStore'])->name('pdt.bulk-update.store');
    Route::post('bulk-product-delete', [ProductController::class, 'bulkProductDelete'])->name('pdt.bulk-product-delete');

    Route::get('products/alt-text/{id}', [ProductController::class, 'altText'])->name('pdt.products.alt-text');
    Route::put('products/alt-text/{id}', [ProductController::class, 'altTextSave'])->name('pdt.products.alt-text.save');
    Route::resource('products', 'ProductController', ['as' => 'pdt']);
    Route::get('get-multiple-images/{id}', [ProductController::class, 'getMultipleImages'])->name('pdt.get-multiple-images');
    Route::delete('delete-multiple-image/{id}', [ProductController::class, 'deleteMultipleImage'])->name('pdt.delete-multiple-image');

    Route::get('get-variation-images/{id}', [ProductController::class, 'getVariationImages'])->name('pdt.get-variation-images');
    Route::delete('delete-variation/{id}', [ProductController::class, 'deleteVariation'])->name('pdt.delete-variation');
    Route::delete('delete-variation-image/{id}', [ProductController::class, 'deleteVariationImage'])->name('pdt.delete-variation-image');
    Route::delete('delete-video-thumbnail-image/{id}', [ProductController::class, 'deleteVideoThumbnailImage'])->name('pdt.delete-video-thumbnail-image');

    Route::get('auto-suggest-product', [ProductController::class, 'autoSuggestProduct'])->name('pdt.auto-suggest-product');
    Route::get('search-product', [ProductController::class, 'searchProduct'])->name('pdt.search-product');
    Route::get('search-any-product', [ProductController::class, 'searchAnyProduct'])->name('pdt.search-any-product');



    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTE TYPE ROUTES
    |--------------------------------------------------------------------------
    */
    Route::resource('attribute-types', 'AttributeTypeController', ['as' => 'pdt']);





    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTE ROUTES
    |--------------------------------------------------------------------------
    */


    Route::resource('attributes', 'AttributeController', ['as' => 'pdt']);


    Route::post('/sku_combination', 'ProductController@sku_combination')
    ->name('pdt.sku_combination');


    /*
     |--------------------------------------------------------------------------
     | PRODUCT UPLOAD ROUTES
     |--------------------------------------------------------------------------
    */
    Route::post('/upload-product-to-confirm-list', 'ProductUploadController@uploadProductToConfirmList')
        ->name('upload-product-to-confirm-list');

    Route::delete('/delete-all', 'ProductUploadController@deleteAll')
        ->name('delete-all');

    Route::resource('product-uploads', 'ProductUploadController', ['as' => 'pdt']);
    Route::resource('product-variation-uploads', 'ProductVariationUploadController', ['as' => 'pdt']);
    Route::resource('discounts', 'ProductDiscountController');





    /*
     |--------------------------------------------------------------------------
     | PRODUCT TYPE ROUTES
     |--------------------------------------------------------------------------
    */
    Route::get('/product-type-export', 'ProductTypeController@productTypeExport')
        ->name('product-type-export');

    Route::resource('product-types', 'ProductTypeController');


    Route::get('/delete_variant', 'ProductController@delete_variant')
    ->name('delete_variant');




    /*
     |--------------------------------------------------------------------------
     | CATEGORY ROUTES
     |--------------------------------------------------------------------------
    */
    Route::get('/category-export', 'CategoryController@categoryExport')
        ->name('category-export');

    Route::post('/update-category-status', 'CategoryController@updateStatus')
        ->name('category.update-status');

    Route::get('/category-upload', 'CategoryController@categoryUpload')
    ->name('category-upload');

    Route::resource('categories', 'CategoryController', ['as' => 'pdt']);





    /*
     |--------------------------------------------------------------------------
     | BRAND ROUTES
     |--------------------------------------------------------------------------
    */
    Route::get('/brand-export', 'BrandController@brandExport')
        ->name('brand-export');

    Route::post('/update-brand-status', 'BrandController@updateStatus')
        ->name('brand.update-status');

    Route::resource('brands', 'BrandController', ['as' => 'pdt']);






    /*
     |--------------------------------------------------------------------------
     | UNIT MEASURE ROUTES
     |--------------------------------------------------------------------------
    */
    Route::get('/unit-measure-export', 'UnitMeasureController@unitMeasureExport')
        ->name('unit-measure-export');

    Route::post('/update-unit-measure-status', 'UnitMeasureController@updateStatus')
        ->name('unit-measure.update-status');

    Route::resource('unit-measures', 'UnitMeasureController', ['as' => 'pdt']);




    /*
     |--------------------------------------------------------------------------
     | TAG ROUTES
     |--------------------------------------------------------------------------
    */
    Route::get('/tag-export', 'TagController@tagExport')
        ->name('tag-export');

    Route::post('/update-tag-status', 'TagController@updateStatus')
        ->name('tag.update-status');

    Route::resource('tags', 'TagController');



    /*
    |--------------------------------------------------------------------------
    | WRITER ROUTES
    |--------------------------------------------------------------------------
    */
    Route::resource('writers', 'WriterController', ['as' => 'pdt']);





    /*
    |--------------------------------------------------------------------------
    | PUBLISHER ROUTES
    |--------------------------------------------------------------------------
    */
    Route::resource('publishers', 'PublisherController', ['as' => 'pdt']);





    /*
    |--------------------------------------------------------------------------
    | HIGHLIGHT TYPES ROUTES
    |--------------------------------------------------------------------------
    */
    Route::resource('highlight-types', 'HighlightTypeController', ['as' => 'pdt']);




    /*
    |--------------------------------------------------------------------------
    | BOOK ROUTES
    |--------------------------------------------------------------------------
    */
    Route::resource('books', 'BookController', ['as' => 'pdt']);


    Route::get('/unit-measure-export', 'UnitMeasureController@unitMeasureExport')
    ->name('unit-measure-export');
    Route::get('/download-excel-product-upload-data', 'ProductController@downloadExcelProductUploadData')
    ->name('download-excel-product-upload-data');


    /*
    |--------------------------------------------------------------------------
    | BOOK ROUTES
    |--------------------------------------------------------------------------
    */
    Route::resource('product-tags', 'ProductTagController', ['as' => 'pdt']);


    /*
    |--------------------------------------------------------------------------
    | BOOK ROUTES
    |--------------------------------------------------------------------------
    */
    Route::resource('product-tags', 'ProductTagController', ['as' => 'pdt']);





    /*
    |--------------------------------------------------------------------------
    | BARCODE ROUTES
    |--------------------------------------------------------------------------
    */
    Route::get('print-barcode', [BarcodeController::class, 'index'], ['as' => 'pdt'])->name('pdt.print-barcode');

    // Route::get('print-all-barcode', [BarcodeController::class, 'allBarcode'], ['as' => 'pdt'])->name('pdt.print-all-barcode');
    // Route::get('print-label-barcode', [BarcodeController::class, 'labelBarcode'], ['as' => 'pdt'])->name('pdt.print-label-barcode');


    Route::get('get-product-variation', [ProductController::class, 'getProductVariation'], ['as' => 'pdt'])->name('pdt.get-product-variation');








    /*
    |--------------------------------------------------------------------------
    | OFFER ROUTE
    |--------------------------------------------------------------------------
    */
    Route::resource('offers', 'OfferController', ['as' => 'pdt']);
});
