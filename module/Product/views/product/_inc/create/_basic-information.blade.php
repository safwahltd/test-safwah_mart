

<div class="row">
    <div class="col-md-4">
        <div class="row">
            <!-- VAT APPLICABLE -->
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-md-5 col-xs-6 control-label" for="form-field-1-1"> Variation </label>
                    <div class="col-md-7 col-xs-6">
                        <label style="margin-top: 6px">
                            <input type="checkbox" class="ace ace-switch ace-switch-6" name="is_variation" id="is_variation" {{ old('is_variation') == true ? 'checked' : '' }}>
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
                            <input type="checkbox" class="ace ace-switch ace-switch-6" name="is_refundable" id="is_refundable" {{ old('is_refundable') == true ? 'checked' : '' }}>
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
                            <input type="checkbox" class="ace ace-switch ace-switch-6" name="sub_text_visible" id="sub_text_visible" checked {{ old('sub_text_visible') == true ? 'checked' : '' }}>
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
                            <input type="checkbox" class="ace ace-switch ace-switch-6" name="stock_visible" id="stock_visible" {{ old('stock_visible') == true ? 'checked' : '' }}>
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
                            <input type="checkbox" class="ace ace-switch ace-switch-6" name="status" id="status" checked {{ old('status') == true ? 'checked' : '' }}>
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
                @foreach($users ?? [] as $id => $user)
                    <option value="{{ $user->id }}" {{ (collect(old('user_id'))->contains($id)) ? 'selected' : '' }}>
                        {{ $user->name }}
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
                <option value="{{ $id }}" {{ (collect(old('highlight_type_id'))->contains($id)) ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-12 mb-1">
        <!-- PRODUCT TAG -->
        <select name="tag_id[]" id="tag_id" class="form-control select2 " multiple data-placeholder="Product Tag" style="width: 100%; border: 0px !important">
            <option></option>
            @foreach($tags ?? [] as $id => $name)
                <option value="{{ $id }}" {{ (collect(old('tag_id'))->contains($id)) ? 'selected' : '' }}>
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
                        {{ old('product_type_id') == $productType->id ? 'selected' : '' }}>
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
                        data-product_type_id="{{ optional($parentCategory)->product_type_id }}" 
                        {{ old('category_id') == $parentCategory->id ? 'selected' : '' }}
                    >
                        {{ $parentCategory->name }}
                    </option>

                    @foreach ($parentCategory->childCategories ?? [] as $childCategory)
                        <option value="{{ $childCategory->id }}" 
                            data-product_type_id="{{ optional($childCategory)->product_type_id }}"
                            {{ old('category_id') == $childCategory->id ? 'selected' : '' }} 
                        >
                            &nbsp;&raquo;&nbsp;{{ $childCategory->name }}
                        </option>

                        @include('category._inc._include-options', ['childCategory' => $childCategory, 'space' => 1])
                    @endforeach

                @endforeach
            </select>
        </div>





        <!-- BRAND -->
        <div class="input-group width-100 mb-1 fashion-type-field">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="brandLabel">Brand</span>
            </span>
            <select name="brand_id" id="brand_id" class="form-control select2" style="width: 100%">
                <option value="" selected>--- Select ---</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>





        <!-- UNIT -->
        <div class="input-group width-100 mb-1">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="unitLabel">Unit Measure</span>
                <span class="label-required">*</span>
            </span>
            @if(!$isProductMeasurement)
                <input type="text" class="form-control text-center" autocomplete="off" style="width: 50%" name="sub_text" id="sub_text" placeholder="e.g. 10" value="{{ old('sub_text') }}" required>
            @endif
            <select name="unit_measure_id" id="unit_measure_id" class="form-control select2" onchange="addProductMeasurement(this)" data-placeholder="--- Select ---" style="{{ !$isProductMeasurement ? 'width: 50%' : 'width: 100%' }}" required>
                <option></option>
                @foreach($units as $id => $name)
                    <option value="{{ $id }}" {{ old('unit_measure_id') == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>





        <!-- COUNTRY ORIGIN -->
        <div class="input-group width-100 mb-1 fashion-type-field">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="countryOriginLabel">Country Origin</span>
            </span>
            <select name="country_id" id="country_id" class="form-control select2" data-placeholder="--- Select ---" style="width: 100%">
                <option></option>
                @foreach($countries as $id => $name)
                    <option value="{{ $id }}" {{ old('country_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>





        <!-- WRITER -->
        <div class="input-group width-100 mb-1 book-type-field" style="display: none">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="writerLabel">Writer</span>
            </span>
            <select name="writer_id" id="writer_id" class="form-control select2" data-placeholder="--- Select ---" style="width: 100%">
                @foreach ($writers as $id => $name)
                    <option></option>
                    <option value="{{ $id }}" {{ old('writer_id') == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>





        <!-- PUBLISHER -->
        <div class="input-group width-100 mb-1 book-type-field" style="display: none">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="publisherLabel">Publisher</span>
            </span>
            <select name="publisher_id" id="publisher_id" class="form-control select2" data-placeholder="--- Select ---" style="width: 100%">
                @foreach ($publishers as $id => $name)
                    <option></option>
                    <option value="{{ $id }}" {{ old('writer_id') == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
        




        <!-- PUBLISHED AT -->
        <div class="input-group width-100 mb-1 book-type-field" style="display: none">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="publishedAtLabel">Published At</span>
            </span>
            <input type="text" class="form-control date-picker" name="published_at" id="published_at" value="{{ old('published_at') }}" data-date-format="yyyy-mm-dd" autocomplete="off">
        </div>





        <!-- NAME -->
        <div class="input-group width-100 mb-1">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="nameLabel">Product Name</span>
                <span class="label-required">*</span>
            </span>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
        </div>





        <!-- SLUG -->
        <div class="input-group width-100 mb-1">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="slugLabel">Product Slug</span>
            </span>
            <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug') }}" autocomplete="off">
        </div>
        @error('slug')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror





        <!-- CODE -->
        <div class="input-group width-100 my-1">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="codeLabel">Product Code</span>
            </span>
            <input type="text" class="form-control" name="code" id="code" value="{{ old('code') }}">
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
                <span id="skuLabel">Product SKU</span>
            </span>
            <input type="text" class="form-control text-center" name="sku" id="sku" value="{{ old('sku') }}" placeholder="SKU" style="width: 70%;">
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
        <div class="input-group width-100 my-1 book-type-field" style="display: none">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="isbnLabel">ISBN</span>
            </span>
            <input type="text" class="form-control" name="isbn" id="isbn" value="{{ old('isbn') }}">
        </div>
        





        <!-- EDITION -->
        <div class="input-group width-100 mb-1 book-type-field" style="display: none">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="editionLabel">Edition</span>
            </span>
            <input type="text" class="form-control" name="edition" id="edition" value="{{ old('edition') }}">
        </div>
        





        <!-- NUMBER OF PAGES -->
        <div class="input-group width-100 mb-1 book-type-field" style="display: none">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="numberOfPagesLabel">Num of Pages</span>
            </span>
            <input type="number" class="form-control" name="number_of_pages" id="number_of_pages" value="{{ old('number_of_pages') }}">
        </div>
        





        <!-- LANGUAGE -->
        <div class="input-group width-100 book-type-field mb-1" style="display: none">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="languageLabel">Language</span>
            </span>
            <input type="text" class="form-control" name="language" id="language" value="{{ old('language') }}">
        </div>





        <!-- MANUFACTURE BARCODE -->
        <div class="input-group width-100 my-1 fashion-type-field">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="mfgBarcodeLabel">Mfg. Barcode</span>
            </span>
            <input type="text" class="form-control" name="manufacture_barcode" id="manufacture_barcode" value="{{ old('manufacture_barcode') }}">
        </div>
        @error('manufacture_barcode')
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror





        <!-- MANUFACTURE MODEL NO -->
        <div class="input-group width-100 mb-1 fashion-type-field">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="mfgModelNoLabel">Mfg. Model No</span>
            </span>
            <input type="text" class="form-control" name="manufacture_model_no" id="manufacture_model_no" value="{{ old('manufacture_model_no') }}">
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
            <input type="text" class="form-control text-center" style="width: 70%" name="barcode" id="barcode" value="{{ old('barcode') }}" placeholder="Barcode" autocomplete="off">     
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
        <div class="input-group width-100 my-1">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="weightLabel">Weight (KG)</span>
            </span>
            <input type="text" class="form-control" name="weight" id="weight" value="{{ old('weight') }}">
        </div>





        <!-- ALERT QUANTITY -->
        <div class="input-group width-100 mb-1">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="alertQuantityLabel">Alert Quantity</span>
            </span>
            <input type="text" class="form-control only-number" name="alert_quantity" id="alert_quantity" value="{{ old('alert_quantity') }}">
        </div>





        <!-- MAXIMUM ORDER QUANTITY -->
        <div class="input-group width-100 mb-1">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="maxOrderQtyLabel">Max Order Qty</span>
            </span>
            <input type="text" class="form-control only-number" name="maximum_order_quantity" id="maximum_order_quantity" value="{{ old('maximum_order_quantity') }}">
        </div>
    </div>




    @if($isProductMeasurement)
        <div class="col-md-12 mt-2" id="productMeasurementDiv" style="{{ old('product_measurement_value') == '' ? 'display: none' : '' }}">
            <input type="text" class="form-control text-center mb-1" readonly id="productMeasurementTitle" style="color: #000000">
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
                            
                            @if (old('is_variation') == null)
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

                        <a href="javascript:void(0)" id="addMeasurement" class="input-group-addon rounded-0 bg-dark" type="button"style="background-color: #b0ffa3 !important; color: #000000 !important;">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>  
    @endif
</div>