<?php

namespace Module\Product\Controllers;

use App\Models\User;
use App\Models\Country;
use App\Traits\FileSaver;
use Illuminate\Http\Request;
use App\Models\SystemSetting;
use Module\Product\Models\Tag;
use Module\Product\Models\Brand;
use Module\Product\Models\Writer;
use Illuminate\Support\Facades\DB;


use Module\Product\Models\Product;
use Module\Account\Models\Supplier;
use Module\Product\Models\Category;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Module\Product\Models\Attribute;
use Module\Product\Models\Publisher;
use Module\Inventory\Models\Warehouse;
use Module\Product\Models\BookProduct;
use Module\Product\Models\ProductType;
use Module\Product\Models\UnitMeasure;
use Module\Product\Models\ProductImage;
use Module\Product\Models\AttributeType;
use Module\Product\Models\HighlightType;
use Module\Product\Services\StockService;
use Module\Product\Import\ProductUploadCSV;
use Module\Product\Models\ProductVariation;
use Module\Product\Services\ProductService;
use Module\Product\Exports\MultipleSheetExport;
use Module\Product\Import\ProductUploadDetailCSV;
use Module\Product\Services\ProductVariationService;
use App\Traits\CheckPermission;
use Module\Product\Import\ProductBulkUpdateCSV;

class ProductController extends Controller
{
    use FileSaver;
    use CheckPermission;

    private $productService;
    private $productVariationService;
    private $stockService;










    /*
     |--------------------------------------------------------------------------
     | CONSTRUCTOR
     |--------------------------------------------------------------------------
    */
    public function __construct()
    {
        $this->productService               = new ProductService;
        $this->productVariationService      = new ProductVariationService;
        $this->stockService                 = new StockService;
    }










    /*
     |--------------------------------------------------------------------------
     | INDEX METHOD
     |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $this->hasAccess("products.index");

        $data['types']              = ProductType::select('id', 'name')->get();
        $data['categories']         = Category::query()
                                    ->where('parent_id', null)
                                    ->with('productType:id,name')
                                    ->with('childCategories')
                                    ->get(['id', 'name', 'product_type_id']);

        $data['brands']             = Brand::get(['id', 'name']);
        $data['products']           = Product::query()
                                    ->searchByField('product_type_id')
                                    ->searchByField('brand_id')
                                    ->searchByField('category_id')
                                    ->when($request->filled('search'), function ($q) use ($request) {
                                        $q->where(function ($q) use ($request) {
                                            $q->where('name', 'LIKE', '%' . $request->search . '%')
                                            ->orWhere('sku', 'LIKE', '%' . $request->search . '%');
                                        });
                                    })
                                    ->orderBy('id', 'DESC')
                                    ->paginate(30);

        $data['table']              = Product::getTableName();


        return view('product/index', $data);
    }










    /*
     |--------------------------------------------------------------------------
     | CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function create(Request $request)
    {
        $this->hasAccess("products.create");

        if($request->ajax()) {
            return $attributes = Attribute::where('attribute_type_id', $request->id)->get();
        }

        $data['productTypes']           = ProductType::query()
                                        ->with('categories:id,name,product_type_id')
                                        ->with('brands:id,name,product_type_id')
                                        ->orderBy('id', 'ASC')
                                        ->get();

        $data['countries']              = Country::pluck('name', 'id');
        $data['units']                  = UnitMeasure::pluck('name', 'id');
        $data['suppliers']              = Supplier::pluck('name', 'id');
        $data['attributeTypes']         = AttributeType::with('attributes')->orderBy('name', 'ASC')->get();
        $data['attributes']             = Attribute::pluck('name', 'id');
        $data['warehouses']             = Warehouse::pluck('name', 'id');
        $data['highlightTypes']         = HighlightType::pluck('name', 'id');
        $data['writers']                = Writer::pluck('name', 'id');
        $data['publishers']             = Publisher::pluck('name', 'id');
        $data['tags']                   = Tag::pluck('name', 'id');
        $data['categories']             = Category::query()
                                        ->where('parent_id', null)
                                        ->with('productType:id,name')
                                        ->with('childCategories')
                                        ->get(['id', 'name', 'product_type_id']);
        $data['brands']                 = Brand::get(['id', 'name']);

        $data['isProductMeasurement']   = optional(SystemSetting::find(1))->value ? true : false;

        $data['systemSettings']         = SystemSetting::get(['value']);
        $data['users']                  = User::where('type', 'Admin')->where('id', '!=', 1)->get();

        return view('product/create', $data);
    }










    /*
     |--------------------------------------------------------------------------
     | STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        if ($request->store_type == 'upload') {

            if(!$request->csv_file) {
                return redirect()->back()->withError('Please upload csv file!');
            }

            Excel::import(new ProductUploadCSV(), $request->file('csv_file'));
            return redirect()->route('pdt.product-uploads.index')->withMessage('Product Uploaded Successfully !');

        } else if ($request->store_type == 'upload-variation') {

            if(!$request->csv_file){
                return redirect()->back()->withError('Please upload csv file!');
            }

            Excel::import(new ProductUploadDetailCSV(), $request->file('csv_file'));
            return redirect()->route('pdt.product-variation-uploads.index')->withMessage('Product Uploaded Successfully !');

        } else {

            $request->validate([
                'code'                  => 'nullable|unique:pdt_products,code',
                'sku'                   => 'nullable|unique:pdt_products,sku',
                'slug'                  => 'required|regex:/^[a-zA-Z0-9-]+$/|unique:pdt_products,slug',
                'barcode'               => 'nullable|unique:pdt_products,barcode',
                'manufacture_barcode'   => 'nullable|unique:pdt_products,manufacture_barcode',
                'manufacture_model_no'  => 'nullable|unique:pdt_products,manufacture_model_no',
            ]);


            try {
                $product = collect();

                DB::transaction(function () use ($request, &$product) {
                    $product = $this->productService->productStore($request);


                    if ($request->product_measurement_sku != null) {
                        $this->productService->productMeasurementsStore($request, $product);
                    }

                    if ($request->highlight_type_id != null) {
                        $this->productService->productHighlightTypeStore($request, $product);
                    }


                    if ($request->tag_id != null) {
                        $this->productService->productTagStore($request, $product);
                    }


                    $productWiseUser = SystemSetting::find(3);

                    if($productWiseUser->value == 1){
                        $this->productService->productUserStore($request, $product);
                    }


                    if ($request->product_type_id == 4) {
                        $product->bookProduct()->create([
                            'writer_id'         => $request->writer_id,
                            'publisher_id'      => $request->publisher_id,
                            'published_at'      => $request->published_at,
                            'isbn'              => $request->isbn,
                            'edition'           => $request->edition,
                            'number_of_pages'   => $request->number_of_pages,
                            'language'          => $request->language,
                        ]);
                    }
                });

                session()->put('productCreate', 'yes');

                return redirect()->route('pdt.products.edit', ['tab' => $request->next_tab, 'product' => $product->id]);

            } catch(\Exception $ex) {
                return redirect()->back()->withError($ex->getMessage());
            }
        }
    }



    /*
     |--------------------------------------------------------------------------
     | EDIT METHOD
     |--------------------------------------------------------------------------
    */
    public function edit(Request $request, $id)
    {
        $this->hasAccess("products.edit");

        if($request->ajax()) {
            return Attribute::where('attribute_type_id',$request->id)->get();
        }

        $data['product']            = Product::query()
                                    ->where('id', $id)
                                    ->with('openingStock:quantity,stockable_id,warehouse_id,lot,expire_date')
                                    ->with('productHighlightTypes.highlightType')
                                    ->with('productUsers.user')
                                    ->with('productTags.tag')
                                    ->with('bookProduct')
                                    ->with('productMeasurements')
                                    ->first();

        $data['productTypes']       = ProductType::query()
                                    ->with('categories:id,name,product_type_id')
                                    ->with('brands:id,name,product_type_id')
                                    ->get();

        $productVariationsQuery     = ProductVariation::query()
                                    ->where('product_id', $id);

        $data['productVariations']  = clone $productVariationsQuery;
        $data['productVariations']  = $data['productVariations']
                                    ->with('openingStock:quantity,stockable_id,warehouse_id,lot')
                                    ->with('productVariationImages')
                                    ->get();

        $variationOpening           = $productVariationsQuery->with(['openingStock' => function ($q) {
                                        $q->select('warehouse_id', 'product_variation_id', 'stockable_type', 'stockable_id');
                                    }])
                                    ->first();
        if ($variationOpening) {
            if ($variationOpening->openingStock != null) {
                $data['warehouse']      = Warehouse::select('id', 'name')->where('id', $variationOpening->openingStock->warehouse_id)->first();
            }
        }

        $data['attributeTypes']         = AttributeType::with('attributes')->orderBy('name', 'ASC')->get();
        $data['attributes']             = Attribute::pluck('name', 'id');
        $data['units']                  = UnitMeasure::pluck('name', 'id');
        $data['warehouses']             = Warehouse::pluck('name', 'id');
        $data['suppliers']              = Supplier::pluck('name', 'id');
        $data['countries']              = Country::pluck('name', 'id');
        $data['highlightTypes']         = HighlightType::pluck('name', 'id');
        $data['writers']                = Writer::pluck('name', 'id');
        $data['publishers']             = Publisher::pluck('name', 'id');
        $data['tags']                   = Tag::pluck('name', 'id');
        $data['categories']             = Category::query()
                                        ->where('parent_id', null)
                                        ->with('productType:id,name')
                                        ->with('childCategories')
                                        ->get(['id', 'name', 'product_type_id']);
        $data['brands']                 = Brand::get(['id', 'name']);

        $data['isProductMeasurement']   = optional(SystemSetting::find(1))->value ? true : false;

        $data['systemSettings']         = SystemSetting::get(['value']);
        $data['users']                  = User::where('type', 'Admin')->where('id', '!=', 1)->pluck('name', 'id');
        $data['multipleImages']         = ProductImage::query()->product()->where('sourcable_id', $id)->get();

        return view('product/edit', $data);
    }



    /*
     |--------------------------------------------------------------------------
     | ALT TEXT METHOD
     |--------------------------------------------------------------------------
    */
    public function altText(Request $request, $id)
    {
        $this->hasAccess("products.edit");

        $data['multipleImages'] = ProductImage::query()->product()->where('sourcable_id', $id)->get();
        $data['product']        = Product::query()
                                    ->where('id', $id)
                                    ->first();

        return view('product/alt-text', $data);
    }



    /*
     |--------------------------------------------------------------------------
     | ALT TEXT SAVE METHOD
     |--------------------------------------------------------------------------
    */
    public function altTextSave(Request $request, $id)
    {
        $this->hasAccess("products.edit");

        try {
            foreach ($request->alt_texts as $image_id => $altText) {
                ProductImage::query()->where('id', $image_id)->update(['alt_text' => $altText]);
            }

            return redirect()->back()->withMessage('Alter text successfully updated');

        } catch (\Throwable $th) {

            return redirect()->back()->withInput()->withError($th->getMessage());
        }
    }












    /*
     |--------------------------------------------------------------------------
     | UPDATE METHOD
     |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();

        $request->validate([
            'code'                  => 'nullable|unique:pdt_products,code,'.$product->id,
            'sku'                   => 'nullable|unique:pdt_products,sku,'.$product->id,
            'slug'                  => 'nullable|regex:/^[a-zA-Z0-9-]+$/|unique:pdt_products,slug,'.$product->id,
            'barcode'               => 'nullable|unique:pdt_products,barcode,'.$product->id,
            'manufacture_barcode'   => 'nullable|unique:pdt_products,manufacture_barcode,'.$product->id,
            'manufacture_model_no'  => 'nullable|unique:pdt_products,manufacture_model_no,'.$product->id,
        ]);

        try {

            DB::transaction(function () use ($request, $product) {
                $this->productService->productUpdate($request, $product);

                $product = $product->refresh();

                if ($request->variation_sku != null) {
                    $this->productVariationService->productVariationStore($request, $product);
                }

                if ($request->product_measurement_sku != null) {
                    $this->productService->productMeasurementsStore($request, $product);
                }


                if ($request->highlight_type_id != null) {
                    $this->productService->productHighlightTypeStore($request, $product);
                }


                if ($request->tag_id != null) {
                    $this->productService->productTagStore($request, $product);
                }


                $productWiseUser = SystemSetting::find(3);

                if($productWiseUser->value == 1 && $request->user_id != null){
                    $this->productService->productUserStore($request, $product);
                }


                if ($product->product_type_id == 4) {
                    $bookProduct = BookProduct::updateOrCreate(
                    [
                        'product_id'        => $product->id
                    ],
                    [
                        'writer_id'         => $request->writer_id,
                        'publisher_id'      => $request->publisher_id,
                        'published_at'      => $request->published_at,
                        'isbn'              => $request->isbn,
                        'edition'           => $request->edition,
                        'number_of_pages'   => $request->number_of_pages,
                        'language'          => $request->language,
                    ]);

                    $this->upload_file($request->attachment, $bookProduct, 'attachment', 'images/product/attachment');
                }


                if ($request->multiple_image != null) {

                    foreach($request->multiple_image as $image) {

                        $multipleImage = $product->productImages()->create([ 'image' => 'default.png' ]);

                        $this->uploadFileWithResizeForProduct($image, $multipleImage, 'image', 'images/product', 515, 515);
                    }
                }


                if($request->video_thumbnail) {
                    $this->upload_file($request->video_thumbnail, $product, "video_thumbnail", "uploads/video-thumbnail-images");
                }


                if ($request->thumbnail_image) {

                    if(file_exists($product->image)) {
                        unlink($product->image);
                    }

                    if(file_exists($product->thumbnail_image)) {
                        unlink($product->thumbnail_image);
                    }

                    $product->update([
                        'thumbnail_image' => $product->thumbnail_image,
                        'image' => $product->image
                    ]);

                    $this->uploadFileWithResizeForProduct($request->thumbnail_image, $product, 'image', 'images/product', 515, 515);
                    $this->uploadFileWithResizeForProduct($request->thumbnail_image, $product, 'thumbnail_image', 'images/product/thumbnail', 515, 515);
                }

                if ($product->is_variation == 'No' && $request->opening_quantity > 0 && $request->warehouse_id != '') {

                    // STORE STOCK
                    $this->stockService->storeStock($product, optional(auth()->user())->company_id ?? 1, null, $request->warehouse_id, $product->id, null, $request->lot ?? 'N/A', null, date('Y-m-d'), 'In', $product->purchase_price, $product->sale_price, $request->opening_quantity, $request->expire_date);

                    // UPDATE OR CREATE STOCK SUMMARY
                    $this->stockService->updateOrCreateStockSummary(optional(auth()->user())->company_id ?? 1, null, $request->warehouse_id, $product->id, null, $request->lot ?? 'N/A', null, $request->opening_quantity, 0, $product->purchase_price * $request->opening_quantity, 0);
                }
            });

            return redirect()->route('pdt.products.edit', ['tab' => $request->next_tab, 'product' => $product->id]);

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }













    // public function update(Request $request, $id)
    // {
    //     $product = Product::find($id);
    //     $request->validate([
    //         'code'      => 'nullable|unique:pdt_products,code,'.$product->id,
    //         'sku'       => 'nullable|unique:pdt_products,sku,'.$product->id,
    //         'slug'      => 'required|regex:/^[a-zA-Z0-9-]+$/|unique:pdt_products,slug,'.$product->id,
    //         'barcode'   => 'nullable|unique:pdt_products,barcode,'.$request->product_id,
    //     ]);

    //     try {

    //         $product = $this->productService->productUpdateOrCreate($request);

    //         $this->productService->productMeasurementsUpadteOrCreate($request, $product);

    //         if ($request->product_id != null) {
    //             $this->productVariationService->productVariationStore($request, $product);
    //         }

    //         $this->productService->productHighlightTypeStore($request);
    //         $this->productService->productTagStore($request);

    //         $productWiseUser         = SystemSetting::find(3);

    //         if($productWiseUser->value == 1){
    //             $this->productService->productUserStore($request, $product);
    //         }


    //         if ($request->product_type_id == 4) {
    //             $book = BookProduct::updateOrCreate(
    //                 [
    //                     'product_id'        => $product->id
    //                 ],
    //                 [
    //                     'writer_id'         => $request->writer_id,
    //                     'publisher_id'      => $request->publisher_id,
    //                     'published_at'      => $request->published_at,
    //                     'isbn'              => $request->isbn,
    //                     'edition'           => $request->edition,
    //                     'number_of_pages'   => $request->number_of_pages,
    //                     'language'          => $request->language,
    //                 ]
    //             );

    //             $this->upload_file_base64($request->attachment, 'images/product/attachment', $book, 'attachment');
    //         }

    //         foreach($request->multiple_image as $image) {

    //             $image = (object) $image;

    //             $multipleImage = $product->productImages()->create([ 'image' => 'default.png' ]);

    //             // $this->upload_file_base64($image->pdt_multiple_images, 'images/product', $multipleImage, 'image');
    //             $this->uploadBase64FileWithResize($image->pdt_multiple_images, 'images/product', $multipleImage, 'image', 515, 515);
    //         }


    //         // $this->upload_file_base64($request->image, 'images/product', $product, 'image');
    //         $this->uploadBase64FileWithResize($request->image, 'images/product', $product, 'image', 515, 515);
    //         $this->uploadBase64FileWithResize($request->image, 'images/product/thumbnail', $product, 'thumbnail_image', 515, 515);

    //         return response()->json(['status' => 200, 'product_id' => $product->id]);

    //     } catch(\Exception $ex) {

    //         return $ex;
    //     }
    // }












    /*
     |--------------------------------------------------------------------------
     | GET MULTIPLE IMAGES METHOD
     |--------------------------------------------------------------------------
    */
    public function getMultipleImages($id)
    {
        $data['productImages'] = ProductImage::query()->product()->where('sourcable_id', $id)->get();
        $data['product'] = Product::find($id);

        return $data;
    }












    /*
     |--------------------------------------------------------------------------
     | GET VARIATION IMAGES METHOD
     |--------------------------------------------------------------------------
    */
    public function getVariationImages($id)
    {
        return ProductImage::query()->productVariation()->where('sourcable_id', $id)->get();
    }












    /*
     |--------------------------------------------------------------------------
     | DELETE/DESTORY METHOD
     |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $this->hasAccess("products.delete");
        try {

            DB::transaction(function () use ($id) {

                $product = Product::with('productVariations.productVariationImages', 'productImages')->where('id', $id)->first();

                if(file_exists($product->image)) {
                    unlink($product->image);
                }

                if(file_exists($product->thumbnail_image)) {
                    unlink($product->thumbnail_image);
                }

                foreach($product->productImages ?? [] as $item) {

                    if(file_exists($item->image)) {
                        unlink($item->image);
                    }

                    $item->delete();
                }


                foreach($product->productVariations ?? [] as $variation) {

                    foreach($variation->productVariationImages ?? [] as $item) {

                        if(file_exists($item->image)) {
                            unlink($item->image);
                        }

                        $item->delete();
                    }

                    $variation->openingStock()->delete();

                    $this->stockService->deleteStocks($variation);

                    $this->stockService->deleteStockSummaries($variation);

                    $variation->productVariationAttributes()->delete();

                    $variation->delete();
                }

                $this->stockService->deleteStocks($product);

                $this->stockService->deleteStockSummaries($product);

                $product->productMeasurements()->delete();

                $product->productHighlightTypes()->delete();

                $product->productTags()->delete();

                if(file_exists(optional($product->bookProduct)->attachment)) {
                    unlink(optional($product->bookProduct)->attachment);
                }

                $product->bookProduct()->delete();

                $product->delete();
            });

            return redirect()->route('pdt.products.index')->withMessage('Product has been Deleted Successfully');

        } catch(\Exception $ex) {

            return redirect()->back()->withError($ex->getMessage());
        }
    }

















    /*
     |--------------------------------------------------------------------------
     | DELETE MULTIPLE IMAGE METHOD
     |--------------------------------------------------------------------------
    */
    public function deleteMultipleImage($id)
    {
        try {

            $productImage = ProductImage::where('id', $id)->first();

            if(file_exists($productImage->image))
            {
                unlink($productImage->image);
            }

            $productImage->destroy($id);

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }












    /*
     |--------------------------------------------------------------------------
     | DELETE VARIATION METHOD
     |--------------------------------------------------------------------------
    */
    public function deleteVariation($id)
    {
        try {
            $variation = ProductVariation::where('id', $id)->with('productImages', 'product')->first();

            DB::transaction(function () use ($variation) {
                foreach($variation->productImages ?? [] as $item)
                {
                    if(file_exists($item->image) && $item->parent_source_id == null)
                    {
                        unlink($item->image);
                    }

                    $item->delete();
                }

                $variation->openingStock()->delete();

                $this->stockService->deleteStocks($variation);

                $this->stockService->deleteStockSummaries($variation);

                $variation->productVariationAttributes()->delete();

                $variation->delete();
            });

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }












    /*
     |--------------------------------------------------------------------------
     | DELETE PRODUCT VIDEO THUMBNAIL IMAGE METHOD
     |--------------------------------------------------------------------------
    */
    public function deleteVideoThumbnailImage($id)
    {
        try {

            $videoThumbnailImage = Product::where('id', $id)->first();

            if(file_exists($videoThumbnailImage->video_thumbnail))
            {
                unlink($videoThumbnailImage->video_thumbnail);
            }

            $videoThumbnailImage->update([
                'video_thumbnail' => null
            ]);

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }




    /*
     |--------------------------------------------------------------------------
     | DELETE VARIATION IMAGE METHOD
     |--------------------------------------------------------------------------
    */
    public function deleteVariationImage($id)
    {
        try {

            $variationImage = ProductImage::where('id', $id)->first();

            if(file_exists($variationImage->image) && $variationImage->parent_source_id == null)
            {
                unlink($variationImage->image);
            }

            $variationImage->destroy($id);

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }








    /*
     |--------------------------------------------------------------------------
     | BLUK UPLOAD REQUIRED DATA EXCEL
     |--------------------------------------------------------------------------
    */
    function downloadExcelProductUploadData(){
        return Excel::download(new MultipleSheetExport, 'product-upload-required-data.xlsx');
    }

    function searchProduct(Request $request){

        if($request->search){
            $search =  ProductVariation::query()
                        ->with(['product' => function ($q) {
                            $q->with('productVariations')
                               ->with('unitMeasure:id,name')
                               ->with('category:id,name');
                        }])
                        ->where('sku', $request->search)
                        ->first();

            if($search){
                $data['product'] = $search;
                $data['type']    = 'Variation';
            }else{
                $search = Product::with('productVariations')
                        ->with('unitMeasure:id,name')
                        ->with('category:id,name')
                        ->where('sku', $request->search)
                        ->orWhere('code', $request->search)
                        ->first();
                $data['product'] = $search;
                $data['type']    = 'product';
            }
            return $data;
        }
    }

    public function autoSuggestProduct(Request $request){

        if($request->search){

            $search = Product::with('productVariations')
                    ->with('category:id,name')
                    ->with('unitMeasure:id,name')
                    ->with('productMeasurements')
                    ->with('category:id,name')
                    ->where('name', 'like', $request->search.'%')
                    ->orWhere('sku', $request->search)
                    ->orWhere('code', $request->search)
                    ->get();



            return $search;
        }
    }


    function getProductVariation(Request $request){

        if($request->search){
             return $product = Product::with('productVariations')->find($request->search);
        }
    }












    /*
     |--------------------------------------------------------------------------
     | UPDATE PRODUCT FIELD METHOD
     |--------------------------------------------------------------------------
    */
    public function updateProductField(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                foreach ($request->product_ids as $key => $id) {

                    $product = Product::where('id', $id)->first();

                    if ($request->field_name == 'thumbnail_image') {
                        if(file_exists($product->image)) {
                            unlink($product->image);
                        }

                        if(file_exists($product->thumbnail_image)) {
                            unlink($product->thumbnail_image);
                        }

                        $product->update([
                            'thumbnail_image' => $product->thumbnail_image,
                            'image' => $product->image
                        ]);

                        $this->uploadFileWithResizeForProduct($request->change_value, $product, 'image', 'images/product', 515, 515);
                        $this->uploadFileWithResizeForProduct($request->change_value, $product, 'thumbnail_image', 'images/product/thumbnail', 515, 515);

                    } elseif($request->field_name == 'category_id') {
                        $product_type_id = optional(Category::where('id', $request->change_value)->first())->product_type_id;

                        $product->update([
                            'product_type_id' => $product_type_id,
                            'category_id' => $request->change_value,
                        ]);
                    } else {
                        $product->update([
                            $request->field_name => $request->change_value
                        ]);
                    }
                }
            });

            return redirect()->route('pdt.products.index')->withMessage($request->field_name . ' field has been updated successfully');

        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }












    /*
     |--------------------------------------------------------------------------
     | BULK PRODUCT CREATE METHOD
     |--------------------------------------------------------------------------
    */
    public function bulkUpdateCreate()
    {
        return view('product.create-bulk-update');
    }












    /*
     |--------------------------------------------------------------------------
     | BULK PRODUCT STORE METHOD
     |--------------------------------------------------------------------------
    */
    public function bulkUpdateStore(Request $request)
    {
        try {
            Excel::import(new ProductBulkUpdateCSV(), $request->file('csv_file'));
            return redirect()->route('pdt.products.index')->withMessage('Bulk update successfully');
        } catch(\Exception $ex) {
            return redirect()->back()->withError($ex->getMessage());
        }
    }












    /*
     |--------------------------------------------------------------------------
     | BULK PRODUCT DELETE METHOD
     |--------------------------------------------------------------------------
    */
    public function bulkProductDelete(Request $request)
    {
        $this->hasAccess("products.delete");

        try {
            foreach ($request->product_ids as $id) {
                DB::transaction(function () use ($id) {

                    $product = Product::with('productVariations.productImages')->where('id', $id)->first();

                    foreach($product->productVariations ?? [] as $variation) {

                        foreach($variation->productImages ?? [] as $item) {

                            if(file_exists($item->image)) {
                                unlink($item->image);
                            }

                            $item->delete();
                        }

                        $this->stockService->deleteStocks($variation);

                        $this->stockService->deleteStockSummaries($variation);

                        $variation->productVariationAttributes()->delete();

                        $variation->delete();
                    }

                    $this->stockService->deleteStocks($product);

                    $this->stockService->deleteStockSummaries($product);

                    $product->productMeasurements()->delete();

                    $product->productHighlightTypes()->delete();

                    $product->productTags()->delete();

                    if(file_exists($product->image)) {
                        unlink($product->image);
                    }

                    if(file_exists($product->thumbnail_image)) {
                        unlink($product->thumbnail_image);
                    }

                    $product->delete();

                });
            }

            return redirect()->route('pdt.products.index')->withMessage('Product has been Deleted Successfully');

        } catch(\Exception $ex) {

            return redirect()->back()->withError($ex->getMessage());
        }
    }


    public function searchAnyProduct(Request $request){

        $product = Product::where(function($q) use ($request){
            $q->where('barcode',  'like', '%'.$request->search.'%')
            ->orWhere('sku', 'like', '%'.$request->search.'%')
            ->orWhere('name', 'like', '%'.$request->search.'%');
        }) ->get();

        if($product->count() > 0){
            return Product::with(['productVariations'=> function($q) use($request){
                                $q->withSum('stockSummaries as variation_stock', 'balance_qty');
                            }])
                            ->with('productMeasurements')
                            ->withSum('stockSummaries as stock', 'balance_qty')
                            ->with('category:id,name')
                            ->with('unitMeasure:id,name')
                            ->with('category:id,name')
                            ->with(['discount' => function($q){
                                $q->where('start_date','<=', today())
                                ->where('end_date','>=', today());
                            }])
                            ->where(function($q) use ($request){
                                $q->where('barcode',  'like', '%'.$request->search.'%')
                                ->orWhere('sku', 'like', '%'.$request->search.'%')
                                ->orWhere('name', 'like', '%'.$request->search.'%');
                            })->limit(10)->get();
        }else{

            return Product::with(['productVariations'=> function($q) use($request){
                                $q->withSum('stockSummaries as variation_stock', 'balance_qty')->where('sku',  'like', '%'.$request->search.'%');
                            }])
                            ->with(['productMeasurements'=> function($q) use($request){
                                $q->where('sku',  'like', '%'.$request->search.'%');
                            }])
                            ->withSum('stockSummaries as stock', 'balance_qty')
                            ->with('category:id,name')
                            ->with('unitMeasure:id,name')
                            ->with('category:id,name')
                            ->with(['discount' => function($q){
                                $q->where('start_date','<=', today())
                                ->where('end_date','>=', today());
                            }])
                            ->orWhereHas('productVariations', function($q) use($request){
                                $q->where('sku',  'like', '%'.$request->search.'%');
                            })
                            ->orWhereHas('productMeasurements', function($q) use($request){
                                $q->where('sku', 'like', '%'.$request->search.'%');
                            })
                            ->limit(10)
                            ->get();

        }
    }
}
