


<input type="hidden" name="basic_information" value="Yes">

<div class="row">
    <div class="col-md-4">
        <div class="row">
            <!-- VAT APPLICABLE -->
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-md-5 col-xs-6 control-label" for="form-field-1-1"> Variation </label>
                    <div class="col-md-7 col-xs-6">
                        <label style="margin-top: 6px">
                            <input type="checkbox" class="ace ace-switch ace-switch-6" name="is_variation" id="is_variation" @if($product->is_variation == 'Yes') checked @endif disabled>
                            <span class="lbl"></span>
                        </label>
                    </div>
                </div>
            </div>





            <!-- REFUNDABLE -->
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-md-6 col-xs-6 control-label" for="form-field-1-1"> Refundable </label>
                    <div class="col-md-6 col-xs-6">
                        <label style="margin-top: 6px">
                            <input type="checkbox" class="ace ace-switch ace-switch-6" name="is_refundable" id="is_refundable" @if(@old('is_refundable') == true || $product->is_refundable == 'Yes') checked @endif>
                            <span class="lbl"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>






    <div class="col-md-8">
        <div class="row">
            <!-- SUB TEXT VISIBLE -->
            <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-md-8 col-xs-6 control-label" for="form-field-1-1"> Unit Visible </label>
                    <div class="col-md-4 col-xs-6">
                        <label style="margin-top: 6px">
                            <input type="checkbox" class="ace ace-switch ace-switch-6" name="sub_text_visible" id="sub_text_visible" @if(@old('sub_text_visible') == true || $product->sub_text_visible == 1) checked @endif>
                            <span class="lbl"></span>
                        </label>
                    </div>
                </div>
            </div>





            <!-- HIGHLIGHT -->
            <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-md-8 col-xs-6 control-label" for="form-field-1-1"> Stock Visible </label>
                    <div class="col-md-4 col-xs-6">
                        <label style="margin-top: 6px">
                            <input type="checkbox" class="ace ace-switch ace-switch-6" name="stock_visible" id="stock_visible" @if(@old('stock_visible') == true || $product->stock_visible == 1) checked @endif>
                            <span class="lbl"></span>
                        </label>
                    </div>
                </div>
            </div>





            <!-- STATUS -->
            <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-md-8 col-xs-6 control-label" for="form-field-1-1"> Status </label>
                    <div class="col-md-4 col-xs-6">
                        <label style="margin-top: 6px">
                            <input type="checkbox" class="ace ace-switch ace-switch-6" name="status" id="status" @if(@old('status') == true || $product->status == 1) checked @endif>
                            <span class="lbl"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="row">

    @if($systemSettings[2]->value == 1)
        <div class="col-md-12 mb-1">
            <!-- PRODUCT HIGHLIGHT TYPE -->
            <select name="user_id[]" id="user_id" class="form-control select2 " multiple data-placeholder="Assign User" style="width: 100%; border: 0px !important">
                <option></option>
                @foreach($users ?? [] as $id => $name)
                    <option value="{{ $id }}" {{ (collect(old('user_id'))->contains($id)) ? 'selected' : '' }}
                        @foreach($product->productUsers ?? [] as $productUser)
                            @if(optional($productUser->user)->id == $id)
                                selected
                            @endif
                        @endforeach
                    >
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif




    <div class="col-md-12 mb-1">
        <!-- PRODUCT HIGHLIGHT TYPE -->
        <select name="highlight_type_id[]" id="highlight_type_id" class="form-control select2 " multiple data-placeholder="Highlight Type" style="width: 100%; border: 0px !important">
            <option></option>
            @foreach($highlightTypes ?? [] as $id => $name)
                <option value="{{ $id }}" {{ (collect(old('highlight_type_id'))->contains($id)) ? 'selected' : '' }}
                    @foreach($product->productHighlightTypes ?? [] as $productHighlightType)
                        @if(optional($productHighlightType->highlightType)->name == $name)
                            selected
                        @endif
                    @endforeach
                >
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </div>


    <div class="col-md-12 mb-1">
        <!-- PRODUCT HIGHLIGHT TYPE -->
        <select name="tag_id[]" id="tag_id" class="form-control select2 " multiple data-placeholder="Product Tag" style="width: 100%; border: 0px !important">
            <option></option>
            @foreach($tags ?? [] as $id => $name)
                <option value="{{ $id }}" {{ (collect(old('tag_id'))->contains($id)) ? 'selected' : '' }}
                    @foreach($product->productTags ?? [] as $productTags)
                        @if(optional($productTags->tag)->name == $name)
                            selected
                        @endif
                    @endforeach
                >
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </div>





    <div class="col-md-6">

        <!-- PRODUCT TYPE -->
        <div class="input-group width-100 mb-1" style="display: none">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="productTypeLabel">Product Type</span>
                <span class="label-required">*</span>
            </span>
            <select name="product_type_id" id="product_type_id" class="form-control select2" onchange="productTypeData(this)" style="width: 100%" required>
                <option value="">Select</option>
                @foreach($productTypes as $productType)
                    <option value="{{ $productType->id }}"
                        {{ old('product_type_id', $product->product_type_id) == $productType->id ? 'selected' : '' }}>
                        {{ $productType->name }}
                    </option>
                @endforeach
            </select>
        </div>





        <!-- CATEGORY -->
        <div class="input-group width-100 mb-1">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="categoryLabel">Category</span>
                <span class="label-required">*</span>
            </span>
            <select name="category_id" id="category_id" onchange="getProductType(this)" class="form-control select2" data-placeholder="--- Select ---" required style="width: 100%">
                <option></option>
                @foreach ($categories ?? [] as $parentCategory)

                    <option value="{{ $parentCategory->id }}"
                        {{ old('category_id', $product->category_id) == $parentCategory->id ? 'selected' : '' }}
                        data-product_type_id="{{ optional($parentCategory)->product_type_id }}"
                        >{{ $parentCategory->name }}
                    </option>

                    @foreach ($parentCategory->childCategories ?? [] as $childCategory)

                        <option value="{{ $childCategory->id }}"
                            {{ old('category_id', $product->category_id) == $childCategory->id ? 'selected' : '' }}
                            data-product_type_id="{{ optional($parentCategory)->product_type_id }}"
                            >
                            &nbsp;&raquo;&nbsp;{{ $childCategory->name }}
                        </option>

                        @include('product/_inc/edit/_include-category-options', ['childCategory' => $childCategory, 'space' => 1])
                    @endforeach

                @endforeach
            </select>
        </div>





        <!-- BRAND -->
        <div class="input-group width-100 mb-1 fashion-type-field" style="{{ $product->product_type_id == 4 ? 'display: none' : '' }}">
            <span class="input-group-addon width-30" style="text-align: left">
                Brand
            </span>
            <select name="brand_id" id="brand_id" class="form-control select2" style="width: 100%">
                <option value="" selected>--- Select ---</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>





        <!-- UNIT -->
        <div class="input-group width-100 mb-1">
            <span class="input-group-addon width-30" style="text-align: left">
                Unit Measure <span class="label-required">*</span>
            </span>
            @if(!$isProductMeasurement)
                <input type="text" class="form-control text-center" autocomplete="off" style="width: 50%" name="sub_text" id="sub_text" placeholder="e.g. 10" value="{{ old('sub_text', $product->sub_text) }}" required>
            @endif
            <select name="unit_measure_id" id="unit_measure_id" class="form-control select2" data-placeholder="--- Select ---" style="{{ !$isProductMeasurement ? 'width: 50%' : 'width: 100%' }}" required>
                <option></option>
                @foreach($units as $id => $name)
                    <option value="{{ $id }}" {{ old('unit_measure_id', $product->unit_measure_id) == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>





        <!-- COUNTRY ORIGIN -->
        <div class="input-group width-100 mb-1">
            <span class="input-group-addon width-30" style="text-align: left">
                Country Origin
            </span>
            <select name="country_id" id="country_id" class="form-control select2" data-placeholder="--- Select ---" style="width: 100%">
                <option></option>
                @foreach($countries as $id => $name)
                <option value="{{ $id }}" {{ old('country_id', $product->country_id) == $id ? 'selected' : '' }}>
                    {{ $name }}</option>
                @endforeach
            </select>
        </div>





        <!-- WRITER -->
        <div class="input-group width-100 mb-1 book-type-field" style="{{ $product->product_type_id != 4 ? 'display: none' : '' }}">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="writerLabel">Writer</span>
            </span>
            <select name="writer_id" id="writer_id" class="form-control select2" data-placeholder="--- Select ---" style="width: 100%">
                @foreach ($writers as $id => $name)
                    <option></option>
                    <option value="{{ $id }}" {{ old('writer_id', optional($product->bookProduct)->writer_id) == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>





        <!-- PUBLISHER -->
        <div class="input-group width-100 mb-1 book-type-field" style="{{ $product->product_type_id != 4 ? 'display: none' : '' }}">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="publisherLabel">Publisher</span>
            </span>
            <select name="publisher_id" id="publisher_id" class="form-control select2" data-placeholder="--- Select ---" style="width: 100%">
                @foreach ($publishers as $id => $name)
                    <option></option>
                    <option value="{{ $id }}" {{ old('publisher_id', optional($product->bookProduct)->publisher_id) == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>





        <!-- PUBLISHED AT -->
        <div class="input-group width-100 mb-1 book-type-field" style="{{ $product->product_type_id != 4 ? 'display: none' : '' }}">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="publishedAtLabel">Published At</span>
            </span>
            <input type="text" class="form-control date-picker" name="published_at" id="published_at" value="{{ old('published_at', optional($product->bookProduct)->published_at) }}" data-date-format="yyyy-mm-dd" autocomplete="off">
        </div>





        <!-- NAME -->
        <div class="input-group width-100 mb-1">
            <span class="input-group-addon width-30" style="text-align: left">
                {{ $product->product_type_id != 4 ? 'Product' : 'Book' }} Name <span class="label-required">*</span>
            </span>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $product->name) }}" required>
        </div>





        <!-- SLUG -->
        <div class="input-group width-100 mb-1">
            <span class="input-group-addon width-30" style="text-align: left">
                {{ $product->product_type_id != 4 ? 'Product' : 'Book' }} Slug
            </span>
            <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug', $product->slug) }}">
        </div>
        @error('slug')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror





        <!-- CODE -->
        <div class="input-group width-100">
            <span class="input-group-addon width-30" style="text-align: left">
                {{ $product->product_type_id != 4 ? 'Product' : 'Book' }} Code
            </span>
            <input type="text" class="form-control" name="code" id="code" value="{{ old('code', $product->code) }}">
        </div>
        @error('code')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>





    <div class="col-md-6">





        <!-- SKU -->
        <div class="input-group width-100">
            <span class="input-group-addon width-30" style="text-align: left">
                {{ $product->product_type_id != 4 ? 'Product' : 'Book' }} SKU
            </span>
            <input type="text" class="form-control text-center" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" placeholder="SKU" style="width: 70%;">
            <a href="javascript:void(0)" class="form-control text-center" onclick="generateSKU()" style="width: 30%; background-color: #33ffb7; color: #000000; text-decoration: none; border: 1px solid #33ffb7;">
                Generate
            </a>
        </div>
        @error('sku')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror





        <!-- ISBN -->
        <div class="input-group width-100 my-1 book-type-field" style="{{ $product->product_type_id != 4 ? 'display: none' : '' }}">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="isbnLabel">ISBN</span>
            </span>
            <input type="text" class="form-control" name="isbn" id="isbn" value="{{ old('isbn', optional($product->bookProduct)->isbn) }}">
        </div>






        <!-- EDITION -->
        <div class="input-group width-100 mb-1 book-type-field" style="{{ $product->product_type_id != 4 ? 'display: none' : '' }}">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="editionLabel">Edition</span>
            </span>
            <input type="text" class="form-control" name="edition" id="edition" value="{{ old('edition', optional($product->bookProduct)->edition) }}">
        </div>






        <!-- NUMBER OF PAGES -->
        <div class="input-group width-100 mb-1 book-type-field" style="{{ $product->product_type_id != 4 ? 'display: none' : '' }}">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="numberOfPagesLabel">Num of Pages</span>
            </span>
            <input type="number" class="form-control" name="number_of_pages" id="number_of_pages" value="{{ old('number_of_pages', optional($product->bookProduct)->number_of_pages) }}">
        </div>





        <!-- LANGUAGE -->
        <div class="input-group width-100 book-type-field mb-1" style="{{ $product->product_type_id != 4 ? 'display: none' : '' }}">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="languageLabel">Language</span>
            </span>
            <input type="text" class="form-control" name="language" id="language" value="{{ old('language', optional($product->bookProduct)->language) }}">
        </div>





        <!-- MANUFACTURE BARCODE -->
        <div class="input-group width-100 my-1 fashion-type-field" style="{{ $product->product_type_id == 4 ? 'display: none' : '' }}">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="mfgBarcodeLabel">Mfg. Barcode</span>
            </span>
            <input type="text" class="form-control" name="manufacture_barcode" id="manufacture_barcode" value="{{ old('manufacture_barcode', $product->manufacture_barcode) }}">
        </div>
        @error('manufacture_barcode')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror





        <!-- MANUFACTURE MODEL NO -->
        <div class="input-group width-100 mb-1 fashion-type-field" style="{{ $product->product_type_id == 4 ? 'display: none' : '' }}">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="mfgModelNoLabel">Mfg. Model No</span>
            </span>
            <input type="text" class="form-control" name="manufacture_model_no" id="manufacture_model_no" value="{{ old('manufacture_model_no', $product->manufacture_model_no) }}">
        </div>
        @error('manufacture_model_no')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror





        <!-- BARCODE -->
        <div class="input-group width-100 mb-1">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="barcodeLabel">Barcode</span>
            </span>
            <input type="text" class="form-control text-center" style="width: 70%" name="barcode" id="barcode" value="{{ old('barcode', $product->barcode) }}" placeholder="Barcode" autocomplete="off">
            <a href="javascript:void(0)" class="form-control text-center" onclick="generateBarcode()" style="width: 30%; background-color: #33ffb7; color: #000000; text-decoration: none; border: 1px solid #33ffb7;">
                Generate
            </a>
        </div>
        @error('barcode')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror





        <!-- WEIGHT -->
        <div class="input-group width-100 mb-1">
            <span class="input-group-addon width-30" style="text-align: left">
                Weight (KG)
            </span>
            <input type="text" class="form-control" name="weight" id="weight" value="{{ old('weight', number_format($product->weight, 5, '.', '')) }}">
        </div>





        <!-- ALERT QUANTITY -->
        <div class="input-group width-100 mb-1">
            <span class="input-group-addon width-30" style="text-align: left">
                Alert Quantity
            </span>
            <input type="text" class="form-control" name="alert_quantity" id="alert_quantity" value="{{ old('alert_quantity', number_format($product->alert_quantity, 2, '.', '')) }}">
        </div>





        <!-- MAXIMUM ORDER QUANTITY -->
        <div class="input-group width-100 mb-1">
            <span class="input-group-addon width-30" style="text-align: left">
                Max Order Qty
            </span>
            <input type="text" class="form-control" name="maximum_order_quantity" id="maximum_order_quantity" value="{{ old('maximum_order_quantity', number_format($product->maximum_order_quantity, 2, '.', '')) }}">
        </div>
    </div>






    <div class="col-md-12 mt-2" id="productMeasurementDiv" style="{{ count($product->productMeasurements) == 0 ? 'display: none' : '' }}">
        <input type="text" class="form-control text-center mb-1" readonly id="productMeasurementTitle" value="Product Measurements in ({{ optional($product->unitMeasure)->name }})" style="color: #000000">
        <div id="productMeasurement">
            @if (old('product_measurement_value'))
                @foreach(old('product_measurement_value') as $key => $measurement)
                    <div class="input-group width-100 mb-1 product-measurements">
                        <span class="input-group-addon" style="text-align: left">
                            <span>Title</span>
                        </span>
                        <input type="text" class="form-control text-center measurement-title" id="measurementTitle" name="product_measurement_title[]" value="{{ old('product_measurement_title')[$key] }}" autocomplete="off" placeholder="Title" required>

                        <span class="input-group-addon" style="text-align: left">
                            <span>Value</span>
                        </span>
                        <input type="text" class="form-control text-center measurement-value only-number" id="measurementValue" name="product_measurement_value[]" value="{{ old('product_measurement_value')[$key] }}" autocomplete="off" placeholder="e.g. 10" required>

                        <span class="input-group-addon" style="text-align: left">
                            <span>SKU</span>
                        </span>
                        <input type="text" class="form-control text-center measurement-sku f-measurement-sku" id="measurementSKU" name="product_measurement_sku[]" value="{{ old('product_measurement_sku')[$key] }}" autocomplete="off" placeholder="SKU" required readonly>

                        @if ($product->is_variation == 'No')
                            @if($loop->iteration == 1)
                                <a href="javascript:void(0)" id="addMeasurement" class="input-group-addon rounded-0 bg-dark" type="button"style="background-color: #b0ffa3 !important; color: #000000 !important;">
                                    <i class="fa fa-plus"></i>
                                </a>
                            @else
                                <a href="javascript:void(0)" class="input-group-addon rounded-0 bg-dark remove-measurement" style="background-color: #ffbaba !important; color: #000000 !important;">
                                    <i class="fa fa-times"></i>
                                </a>
                            @endif
                        @endif
                    </div>
                @endforeach
            @else
                @foreach($product->productMeasurements as $measurement)
                    <div class="input-group width-100 mb-1 product-measurements">
                        <span class="input-group-addon" style="text-align: left">
                            <span>Title</span>
                        </span>
                        <input type="text" class="form-control text-center measurement-title" id="measurementTitle" name="product_measurement_title[]" value="{{ $measurement->title }}" autocomplete="off" placeholder="Title" required>

                        <span class="input-group-addon" style="text-align: left">
                            <span>Value</span>
                        </span>
                        <input type="text" class="form-control text-center measurement-value only-number" id="measurementValue" name="product_measurement_value[]" value="{{ $measurement->value }}" autocomplete="off" placeholder="e.g. 10" required>

                        <span class="input-group-addon" style="text-align: left">
                            <span>SKU</span>
                        </span>
                        <input type="text" class="form-control text-center measurement-sku" id="measurementSKU" name="product_measurement_sku[]" value="{{ $measurement->sku }}" autocomplete="off" placeholder="SKU" required readonly>

                        @if ($product->is_variation == 'No')
                            @if($loop->iteration == 1)
                                <a href="javascript:void(0)" id="addMeasurement" class="input-group-addon rounded-0 bg-dark" type="button"style="background-color: #b0ffa3 !important; color: #000000 !important;">
                                    <i class="fa fa-plus"></i>
                                </a>
                            @else
                                <a href="javascript:void(0)" class="input-group-addon rounded-0 bg-dark remove-measurement" style="background-color: #ffbaba !important; color: #000000 !important;">
                                    <i class="fa fa-times"></i>
                                </a>
                            @endif
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>


    @if ($isProductMeasurement && count($product->productMeasurements) == 0)
        <div class="col-md-12 mt-2" id="productMeasurementDiv">
            <input type="text" class="form-control text-center mb-1" value="Product Measurements in ({{ optional($product->unitMeasure)->name }})" readonly id="productMeasurementTitle" style="color: #000000">
            <div id="addInEditProductMeasurement">
                <div class="input-group width-100 mb-1 product-measurements">
                    <span class="input-group-addon" style="text-align: left">
                        <span>Title</span>
                    </span>
                    <input type="text" class="form-control text-center measurement-title" id="measurementTitle" name="product_measurement_title[]" autocomplete="off" placeholder="Title" required>

                    <span class="input-group-addon" style="text-align: left">
                        <span>Value</span>
                    </span>
                    <input type="text" class="form-control text-center measurement-value only-number" id="measurementValue" name="product_measurement_value[]" autocomplete="off" placeholder="e.g. 10" required>

                    <span class="input-group-addon" style="text-align: left">
                        <span>SKU</span>
                    </span>
                    <input type="text" class="form-control text-center measurement-sku f-measurement-sku" id="measurementSKU" name="product_measurement_sku[]" autocomplete="off" placeholder="SKU" required readonly>

                    @if ($product->is_variation == 'No')
                        <a href="javascript:void(0)" id="addInEditMeasurement" class="input-group-addon rounded-0 bg-dark" type="button"style="background-color: #b0ffa3 !important; color: #000000 !important;">
                            <i class="fa fa-plus"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
