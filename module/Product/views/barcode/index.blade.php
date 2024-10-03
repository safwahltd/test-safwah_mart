@extends('layouts.master')

@section('title', 'Barcode Print')

@push('style')

    <style>
        /* @import url('https://fonts.googleapis.com/css2?family=Alef:wght@400;700&display=swap'); */
        /* @import url('https://fonts.googleapis.com/css2?family=Alef:wght@400;700&family=IBM+Plex+Serif:wght@500;600&display=swap'); */
        @import url('https://fonts.googleapis.com/css2?family=BIZ+UDPMincho&display=swap');

        @media print {
            * {
                margin: 0px !important;
                padding: 0px !important;
                box-sizing: border-box !important;
                /* font-family: 'Alef', sans-serif; */
                font-family: 'BIZ UDPMincho', serif;
            }

            .page-break {
                display: block;
                page-break-inside: avoid;
            }

            .page-header {
                display: none !important;
            }

            .btn {
                display: none !important;
            }

            .label-print {
                /* padding: 3px !important; */
                text-align: center !important;
                font-size: 12px;
                /* height: 0.98in !important; */
                /* line-height: 0.98in; */
                /* width: 1.552in !important; */
                overflow: hidden;
            }
            #allPrintList {
                text-align: center !important;
                font-size: 7px !important;
                width: 831.49606299px !important;
                height: 1322.8346457px !important;
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                background-color: #efefef !important;
            }

            .all-print {
                width: calc(105.6px + 32.982677165px) !important;
                height: 67.2px !important;
            }

            .barcode--product_name {
                height: 26px !important;
                overflow: hidden !important;
                font-size: 12px !important;
                line-height: 13px !important;
            }

            .barcode--product_image {
                width: 90% !important;
                margin: 0px auto !important;
                height: 0.294in !important;
                font-size: 12px !important;
                line-height: 13px !important;
            }

            .barcode--product_barcode-and-mrp {
                font-size: 10px !important;
                line-height: 13px !important;
                
            }

            .barcode--company-website {
                font-size: 12px !important;
                line-height: 13px !important;
            }
            .variation-name{
                display: block !important;
                font-size: 10px;
                line-height: 13px !important;
                height: 13px !important;
            }
            #labelPrintList{
                font-size: 12px;
            }
        }
    </style>

    <!----------------- SEARCH ANY PRODUCT LIST CSS ---------------->
    <style>
        .search-order-product .dropdown-content {
            display: none;
            background-color: #f6f6f6;
            overflow: auto;
            border: 1px solid #ddd;
            z-index: 1;
            max-height: 244px;
            width: 79%;
            margin: 0 auto;
        }
        .search-order-product .dropdown-content ul{
            margin-left: 0
        }
        .search-order-product .dropdown-content.ace-scroll{
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }

        .search-order-product .dropdown-content a {
        color: black;
        text-decoration: none;
        display: flex;
        padding: 5px 8px !important;
            border-bottom: 1px solid lightgray !important;
            transition: 0.3s;
        }

        .search-order-product .search-dropdown-list {
            position: absolute;
            top: 50px;
            left: 7px;
        }
        .search-order-product .search-dropdown-list a{
            transition: 0.4s;
        }
        .search-order-product .search-dropdown-list .scroll-hover{
            opacity: 0 !important;

        }
        .search-order-product .search-dropdown-list a:hover{
            color: white !important;
            background-color: rgb(58, 170, 207) !important;
        }
        .search-order-product .table-responsive {
            overflow: visible !important;
        }

        .search-order-product .dropdown-content a:hover{
            background-color: lightskyblue !important;
            color: black !important;
        }
        .search-order-product .show {display: block;}


        .search-order-product .search-result{
            color: white !important;
            background-color: rgb(58, 170, 207) !important;
        }
        .search-order-product .dropdown-content {
            position: absolute;
            left: 0;
            top: 40px;
            display: block;
            width: 100%;
            z-index: 99;
        }
        .search-order-product .dropdown-content .search-product{
            padding-left: 0;
        }
    </style>

@endpush

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="far fa-print"></i> @yield('title')</h4>
    </div>

    <div class="row">
        <div class="col-md-12" style="margin: 0px; padding: 0px">
            @include('partials._alert_message')

            <form class="hidden-print" action="" method="GET">
                <div class="col-md-12">
                    <table class="table table-bordered mb-2">
                        <tr style="background: #E1ECFF; border: 2px solid #2c6aa0">
                            <td width="35%" style="border-right: 2px solid #2c6aa0">
                                <select name="product_id" id="product_id" class="form-control select2" style="width: 100%;" onchange="findVariation(this)">
                                    <option value="">All Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ $product->id == 7 ? 'selected' : '' }} data-barcode="{{ $product->barcode }}" data-name="{{ $product->name }}" data-price="{{ $product->sale_price }}">{{ $product->name }} - {{ $product->barcode }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td width="35%" style="border-right: 2px solid #2c6aa0">
                                <select name="brand_id" id="variation_id" class="form-control select2" style="width: 100%">
                                    <option value="" selected>All Variations</option>
                                </select>
                            </td>
                            <td width="30%">
                                <input type="number" class="form-control" id="printQuantity" placeholder="Print Quantity" value="5">
                            </td>
                        </tr>
                    </table>


                    <div id="searchProduct" class="col-sm-12 search-order-product">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2 search-any-product">
                                <div class="input-group mb-1 width-100" style="width: 100%">
                                    <span class="input-group-addon width-10" style="text-align: left; background-color: #e1ecff; color: #000000;">
                                        Search By Barcode <span class="label-required"></span>
                                    </span>
                                    <div style="position: relative;">
                                        <input type="text" class="form-control" name="product_search" id="searchProductField"  placeholder="Scan Your Barcode or SKU" onkeyup="searchAnyProduct(this, event)">

                                        <div class="dropdown-content live-load-content">


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Additional top margin (In Inches): *</label>
                                <div class="input-group mb-2 width-100" style="width: 100%">
                                    <span class="input-group-addon">
                                        <i class="fas fa-arrow-alt-to-top"></i>
                                    </span>
                                    <input type="text" class="form-control" name="additionalTopMargin">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                    </div> --}}
                </div>
            </form>


            {{-- Table --}}
            <div class="col-md-12 hidden-print">
                <table class="table table-striped table-bordered table-hover" id="barcode_table">
                    <thead style="border-bottom: 3px solid #346cb0 !important">
                        <tr style="background: #e1ecff !important; color:black !important">
                            {{-- <th class="text-center" width="10%">SL</th> --}}
                            <th width="50%">Product</th>
                            <th width="11%">SKU</th>
                            <th width="11%">Unit</th>
                            <th class="text-right" width="12%">Available Quantity</th>
                            <th class="text-right" width="11%">Print Quantity</th>
                            <th width="4%">Action</th>
                        </tr>
                    </thead>



                    <tbody id="barcode-table-body">
                        {{-- <tr class="first-tr">
                             <td class="text-center">
                                <span class="sn-no">1</span>
                            </td>
                            <td>Product Name</td>
                            <td class="text-right">100</td>
                            <td class="text-right">
                                <input type="text" value="50" class="form-control text-right" style="width: 60%; margin-left: auto;">
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-button" onclick="removeBarcodeRow(this)" type="button">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>--}}
                    </tbody>

                    {{-- <tfoot>
                        <tr>
                            <th></th>
                            <th class="text-right">This Page Total</th>
                            <th class="text-right">100</th>
                            <th class="text-right">50</th>
                            <th></th>
                        </tr>
                    </tfoot> --}}

                </table>

            </div>






            <div class="row" style="width: 100%; margin: 0px">
                <div class="col-sm-12">
                    <div style="display: flex; align-items:center; justify-content:space-between; margin-bottom: 20px">
                        <div></div>
                        <div class="btn-group">
                            {{-- <a class="btn btn-sm btn-theme" type="button" onclick="barcodeAllPrint()">
                                <i class="far fa-print"></i> Print
                            </a> --}}
                            <a class="btn btn-sm btn-warning" style="color: #000000 !important" onclick="barcodeLabelPrint()">
                                <i class="far fa-print"></i> Print
                            </a>
                            <a class="btn btn-sm btn-light" href="">
                                <i class="far fa-sync-alt"></i> Reset
                            </a>
                        </div>
                    </div>


                    <div id="allPrintList"></div>
                    <div class="d-none" id="labelPrintList"></div>
                </div>
            </div>


        </div>
    </div>
@endsection





@section('js')



    <!------- START ------- FOR SEARCH ANY PRODUCT ------>

    <script>

        let product_si      = 0;
        let selectedLiIndex = -1;

        function autoSearch(obj, event){

            let value = $(obj).val();
            if (event.which != 38 && event.which != 40) {
                if(value){
                    let route  = `{{ route('pdt.auto-suggest-product') }}`;
                    axios.get(route, {
                        params: {
                            search : value
                        }
                    })
                    .then(function (response) {
                            if(response.data.length > 0){
                                selectedLiIndex = -1;

                            let result = '';
                            $.each( response.data, function( key, product ) {

                                result += `<a onclick="getProductVariations(this)"
                                data-id                    = "${ product.id }"
                                data-name                  = "${ product.name }"
                                data-category              = "${ product.category.name }"
                                data-is-variation          = "${ product.is_variation }"
                                data-unit-measure          = "${ product.unit_measure.name }"
                                data-purchase-price        = "${ Number(product.purchase_price).toFixed(2) }"
                                data-sale-price            = "${ Number(product.sale_price).toFixed(2) }"
                                data-sale-discount-percent = "${ $(this).select2('data')[0].current_discount != null ? $(this).select2('data')[0].current_discount.discount_percentage : 0 }"
                                data-vat-percent           = "${ getVatPercent(product.vat, product.vat_type, product.sale_price, 0)}"
                                >${ product.name }</a>`;

                            });

                            $(obj).closest('tr').find('.live-load-content').html(result);
                            $(obj).closest('tr').find('.dropdown-content').show();
                        }else{
                            $('.dropdown-content').hide();
                        }

                    }).catch(function (error) {

                    });
                }else{
                    $('.dropdown-content').hide();
                }
            }

            $(obj).blur(function(){
                setTimeout(function(){
                    // $('.live-load-content').hide();
                }, 500);
            })

            arrowUpDownInit(event, obj);

        }




        function getVatPercent(vat, vatType,salePrice, discount){
            let vatPercent = 0;
            let saleP     = salePrice - discount;

            if(vatType == 'Percentage'){
                vatPercent = vat;
            }else{
                vatPercent = (vat * 100) / salePrice;
            }
            return vatPercent;

        }



        function arrowUpDownInit(e, obj) {
            if (e.which === 13) {
                // alert("ok");
            }


            let _this = $(obj).closest('.search-any-product');

            e.preventDefault()

            _this.find('.live-load-content').find('a').removeClass('search-result')

            var a = _this.find('.live-load-content').find('a')

            var selectedItem


            if (e.which === 40) {
                console.log('down')

                selectedLiIndex += 1


            } else if (e.which === 38) {

                $("#searchProduct").focusout();
                console.log('down')

                selectedLiIndex -= 1

                if (selectedLiIndex < 0) {
                    selectedLiIndex = 0
                }

            }



            if (a.length <= selectedLiIndex) {
                selectedLiIndex = 0
            }


            if (e.which == 40 || e.which == 38) {

                selectedItem = _this.find('.live-load-content').find(`a:eq(${selectedLiIndex})`).addClass('background').focus();
                select(selectedItem)

            }
            // addItemOnEnter(tr.find('.live-load-content').closest(`a:eq(${selectedLiIndex})`), e)
            addItemOnEnter(_this.find('.live-load-content').find('.search-result'))
        }


        // function addItemOnEnter(object, e) {
        function addItemOnEnter(object) {

            // console.log(object);

            $(object).on('keydown', function () {
                alert('ok')
            })

            // if (e.which == 13) {
            //     // alert("ok");

            //     getProductVariations(object);
            // }
        }



        function select(el) {

            var ul = $('.live-load-content')

            var elHeight = $(el).height()
            var scrollTop = ul.scrollTop()
            var viewport = scrollTop + ul.height()
            var elOffset = (elHeight + 10) * selectedLiIndex

            if (elOffset < scrollTop || (elOffset + elHeight) > viewport)
                $(ul).scrollTop(elOffset)
            selectedItem = $('.live-load-content').find(`a:eq(${selectedLiIndex})`);

            // selectedItem.attr("style", "color: green;");
            selectedItem.addClass('search-result');
        }

    </script>





    <script>

        function searchAnyProduct(obj, event){

            let hideSearchContent = 0;
            let searchString = $(obj).val();
            let stringLength = searchString.length;

            if(stringLength > 3){
                if (event.which != 38 && event.which != 40) {
                let route  = `{{ route('pdt.search-any-product') }}`;
                let value = $(obj).val();
                // $(obj).val('');

                if(value != ''){
                    axios.get(route, {
                        params: {
                            search : value
                        }
                    })
                    .then(function (response) {

                        if(response.data.length > 0){

                            selectedLiIndex = -1;

                            let result = '';
                            result = `<ul class="search-product" role="menu" style="z-index:99999">`

                            $.each( response.data, function( key, product ) {
                                let myProduct = `${ JSON.stringify(product) }`;
                                let image = product.thumbnail_image;
                                if(image != null){
                                    image = image.replace("./", "/");
                                }
                                let sku   = product.sku != null ? product.sku : '';

                                if(product.product_variations != ''){
                                    $.each( product.product_variations, function( key, variation ) {
                                        result += `<a onclick='appendData(this, ${myProduct}, ${ variation.sku }, 1)'
                                                    data-id                    = "${ product.id }"
                                                    data-name                  = "${ product.name }"
                                                    data-product-title         = "${ variation.name }"
                                                    data-category              = "${ product.category.name }"
                                                    data-is-variation          = "${ product.is_variation }"
                                                    data-unit-measure          = "${ product.unit_measure.name }"
                                                    data-purchase-price        = "${ Number(product.purchase_price).toFixed(2) }"
                                                    data-sale-price            = "${ Number(product.sale_price).toFixed(2) }"
                                                    data-sale-discount-percent = "0"
                                                    data-vat-percent           = "${ getVatPercent(product.vat, product.vat_type, product.sale_price, 0)}"
                                                    >
                                                    <div style=" margin-right: 5px;">
                                                        <img src="${image != 'http://127.0.0.1:8000/' ? image : '/default-image.jpg'}" alt="" height="45" width="50">
                                                    </div>
                                                    ${ product.name +' - '+ variation.name + ' - SKU : ' + variation.sku }
                                                    </a>`;
                                        if(response.data.length == 1 && product.product_variations.length == 1){
                                            appendData(response.data[0], value, 1);
                                            hideSearchContent = 1;
                                        }
                                    })


                                }else if(product.product_measurements != ''){
                                    $.each( product.product_measurements, function( key, measurement ) {
                                        result += `<a onclick='appendData(this, ${myProduct}, ${ measurement.sku }, 1)'
                                                    data-id                    = "${ product.id }"
                                                    data-name                  = "${ product.name }"
                                                    data-product-title         = "${ measurement.title }"
                                                    data-category              = "${ product.category.name }"
                                                    data-is-variation          = "${ product.is_variation }"
                                                    data-unit-measure          = "${ product.unit_measure.name }"
                                                    data-purchase-price        = "${ Number(product.purchase_price).toFixed(2) }"
                                                    data-sale-price            = "${ Number(product.sale_price).toFixed(2) }"
                                                    data-sale-discount-percent = "0"
                                                    data-vat-percent           = "${ getVatPercent(product.vat, product.vat_type, product.sale_price, 0)}"
                                                    >
                                                    <div style=" margin-right: 5px;">
                                                        <img src="${image != 'http://127.0.0.1:8000/' ? image : '/default-image.jpg'}" alt="" height="45" width="50">
                                                    </div>
                                                    ${ product.name +' - '+ measurement.title + ' - SKU : ' + measurement.sku }

                                                    </a>`;
                                        if(response.data.length == 1 && product.product_measurements.length == 1){
                                            appendData(response.data[0], value, 1);
                                            hideSearchContent = 1;
                                        }
                                    })
                                }


                                else{



                                    result += `<a onclick='appendData(this, ${myProduct}, ${ sku }, 1)'
                                                data-id                    = "${ product.id }"
                                                data-name                  = "${ product.name }"
                                                data-product-title         = "${ product.name }"
                                                data-category              = "${ product.category.name }"
                                                data-is-variation          = "${ product.is_variation }"
                                                data-unit-measure          = "${ product.unit_measure.name }"
                                                data-purchase-price        = "${ Number(product.purchase_price).toFixed(2) }"
                                                data-sale-price            = "${ Number(product.sale_price).toFixed(2) }"
                                                data-sale-discount-percent = "0"
                                                data-vat-percent           = "${ getVatPercent(product.vat, product.vat_type, product.sale_price, 0)}"
                                                >
                                                <div style=" margin-right: 5px;">
                                                    <img src="${image != 'http://127.0.0.1:8000/' ? image : '/default-image.jpg'}" alt="" height="45" width="50">
                                                </div>
                                                ${ product.name +' - SKU : '+ sku }
                                                </a>`;
                                    if(response.data.length == 1){
                                        appendData(response.data[0], value, 1);
                                        $('#searchProductField').val('');
                                        hideSearchContent = 1;

                                    }

                                }



                            });
                            result += '</ul>'
                            if(hideSearchContent == 0){
                                $('.live-load-content').html(result);
                                $('.dropdown-content').show();
                            }else{
                                $('.dropdown-content').hide()
                            }

                        }else{
                            $('.dropdown-content').hide();
                        }

                        // appendData(response.data, value);

                    }).catch(function (error) {

                    });
                }

            }else{
                $('.dropdown-content').hide();
            }
            $(obj).blur(function(){
                setTimeout(function(){
                    $('.live-load-content').hide();
                }, 500);
            })
            arrowUpDownInit(event, obj);
            }



        }


        let newKey = 0;



        function appendData(obj, product, searchedValue, isReadonly){

            let tr              = '';
            let product_title   = obj.getAttribute("data-product-title");

            if(product.product_variations != ''){

                tr = `<tr class="new-tr">

                    <input type="hidden" name="sale_detail_id[]" class="purchase-detail-id" value="">

                    <th width="25%" style="position: relative;">
                        <input type="hidden" class="product-is-variation" value="${ product.product_variations != '' ? "true" : "false" }">
                        <input type="hidden" class="product-is-measurement" value="${ product.product_measurements != '' ? "true" : "false" }">
                        ${ product.name } &mdash; ${ product_title }
                    </th>

                    <th class="text-left">
                        ${searchedValue}
                    </th>

                    <th class="text-left">
                        ${product.unit_measure.name}
                    </th>

                    <th class="text-right">
                        ${product.stock}
                    </th>

                    <th class="text-right">
                        <input type="text" value="0" class="form-control text-right" style="width: 80%; margin-left: auto;">
                    </th>

                    <th class="text-center">
                        <div class="btn-group">
                            <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-button" onclick="removeBarcodeRow(this)" type="button">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </th>

                </tr>`

            }else if(product.product_measurements != ''){

                tr = `<tr class="new-tr">

                    <input type="hidden" name="sale_detail_id[]" class="purchase-detail-id" value="">

                    <th width="25%" style="position: relative;">
                        <input type="hidden" class="product-is-variation" value="${ product.product_variations != '' ? "true" : "false" }">
                        <input type="hidden" class="product-is-measurement" value="${ product.product_measurements != '' ? "true" : "false" }">
                        ${ product.name } &mdash; ${ product_title }
                    </th>

                    <th class="text-left">
                        ${searchedValue}
                    </th>

                    <th class="text-left">
                        ${product.unit_measure.name}
                    </th>


                    <th class="text-right">
                        ${product.stock}
                    </th>

                    <th class="text-right">
                        <input type="text" value="0" class="form-control text-right" style="width: 80%; margin-left: auto;">
                    </th>

                    <th class="text-center">
                        <div class="btn-group">
                            <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-button" onclick="removeBarcodeRow(this)" type="button">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </th>

                </tr>`
            }
            else{

                tr = `<tr class="new-tr">

                    <input type="hidden" name="sale_detail_id[]" class="purchase-detail-id" value="">

                    <th width="25%" style="position: relative;">
                        ${ product.name }
                    </th>

                    <th class="text-left">
                        ${searchedValue}
                    </th>

                    <th class="text-left">
                        ${product.unit_measure.name}
                    </th>

                    <th class="text-right">
                        ${product.stock}
                    </th>

                    <th class="text-right">
                        <input type="text" value="0" class="form-control text-right" style="width: 80%; margin-left: auto;">
                    </th>

                    <th class="text-center">
                        <div class="btn-group">
                            <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-button" onclick="removeBarcodeRow(this)" type="button">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </th>

                </tr>`
            }




            $("#barcode_table").append( tr );
            let row = $("#barcode_table tbody tr:last");

            if(product.is_variation == "Yes"){
                let variation = product.product_variations;
                let variationSku = 0;
                let variationSkuCode = '';

                variation.map(function(productVariation, index) {
                    row.find('.product-variations').append(`<option value="${ productVariation.id }" data-variation-purchase-price="${ productVariation.purchase_price }" data-variation-sale-price="${ productVariation.sale_price }" data-variation-current-stock="0" data-is-variation="Yes" ${ productVariation.sku == searchedValue ? 'selected' : ''}>${ productVariation.name }</option>`);

                    if(productVariation.sku == searchedValue)
                    {
                        variationSku = 1;
                        variationSkuCode = productVariation.sku;
                    }

                });
                row.find('.sku-code').val(variationSkuCode);

                if(variationSku == 1){

                    checkItemExistOrNot(row.find('.product-variations'));
                }
            }else{
                if(product.product_measurements != ''){


                    let measurement  = product.product_measurements;
                    let measurementSku = 0;
                    let measurementSkuCode = '';

                    measurement.map(function(productMeasurement, index) {

                        if(product.product_measurements.length != 1){
                            if(productMeasurement.sku == searchedValue){
                                keepSelected        = 1;
                                measurementSkuCode  = productMeasurement.sku;
                            }
                        }

                        row.find('.product-variations').append(`<option value="${ productMeasurement.id }" data-measurement-value="${ productMeasurement.value }" data-measurement-title="${ productMeasurement.title }" data-measurement-sku="${ productMeasurement.sku }" data-is-variation="Yes" ${ productMeasurement.sku == searchedValue ? 'selected' : ''} >${ productMeasurement.title }</option>`);
                        if(productMeasurement.sku == searchedValue)
                        {
                            measurementSku = 1;
                        }
                    });
                    row.find('.sku-code').val(measurementSkuCode);

                    if(measurementSku == 1)
                    {
                        checkItemExistOrNot(row.find('.product-variations'));
                    }

                }

                getLots(row.find('.product-variations'), product.id);

                checkItemExistOrNot(row.find('.products'));

            }
            $('#searchProductField').val('');





            $('.product-variations').select2()


        }


        $(document).on('change', '.abcd', function () {
            $(this).closest('tr').find('.lots').prop('required', false);
            $(this).closest('tr').find('.lots').empty().select2();
            $(this).closest('tr').find('.lots').append(`<option value="" selected>- Select -</option>`).select2();

            checkItemExistOrNot($(this));
        })



    </script>

    <!----------------------- END ------------------------->





    {{-- ADD REMOVE BARCODE TABLE TR --}}
    <script>

        // const barcodeRow =  `
        //     <tr class="new-tr">

        //         <td>
        //             <span class="sn-no">1</span>
        //         </td>
        //         <td>Product Name</td>
        //         <td class="text-right">100</td>
        //         <td class="text-right">50</td>
        //         <td class="text-center">
        //             <div class="btn-group">
        //                 <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-button" onclick="removeBarcodeRow(this)" type="button">
        //                     <i class="fas fa-times"></i>
        //                 </a>
        //             </div>
        //         </td>

        //     </tr>`;


        // function addBarcodeRow()
        // {
        //     $('#barcode-table-body').append(barcodeRow)

        //     serial()
        // }


        function removeBarcodeRow(obj)
        {
            $(obj).closest("tr").remove();
            serial();
        }




        function serial()
        {
            $('.sn-no').each(function(index) {
                $(this).text(index + 1)
            })
        }


    </script>




    <script>
        /*
         |----------------------------------------------------
         |   ALL BARCODE PRINT METHOD
         |-----------------------------------------------------
        */
        function barcodeAllPrint(){
            $('head').append(`
                <style>
                    @media print {
                        @page
                        {
                            size: 22cm 35cm;
                        }
                    }
                </style>
            `);

            ajaxBarcode("All");
        }





        /*
         |----------------------------------------------------
         |   LABEL BARCODE PRINT METHOD
         |-----------------------------------------------------
        */
        function barcodeLabelPrint(){
            $('head').append(`
                <style>
                    @media print {
                        @page {
                            size: 1.49in 1in;
                        }
                    }
                </style>
            `);

            ajaxBarcode("Label");
        }






        /*
         |----------------------------------------------------
         |   COMMON PRINT METHOD
         |-----------------------------------------------------
        */
        function ajaxBarcode(printType)
        {
            if($('#printQuantity').val() == '' || $('printQuantity').val() == 0){
                alert("Please enter a valid quantity");
                return;
            }

            let variation   = $('#variation_id option').length;
            let quantity    = $('#printQuantity').val() ?? 0;

            if(variation > 1 && $('#variation_id option:selected').val() == ''){
                alert("Please select a variation");
                return;
            }

            let barcode         = '';
            let price           = 0;
            let name            = '';
            let variation_name  = '';

            let _this      = $('#product_id').find(':selected');
            name           = _this.data('name');

            if(variation > 1 && $('#variation_id option:selected').val() != ''){
                _this          = $('#variation_id').find(':selected');
                name           = name;
                variation_name = _this.data('name');
                barcode        = _this.data('barcode');
                price          = _this.data('price');
            }else{
                barcode        = _this.data('barcode');
                price          = _this.data('price');
            }

            if(barcode != '')
            {
                $.ajax({
                    url: "{{ route('pdt.print-barcode') }}",
                    type: "GET",
                    data: {
                        name            : name,
                        variation_name  : variation_name,
                        barcode         : barcode,
                        price           : price,
                        printType       : printType,
                        quantity        : quantity
                    },
                    success: function(response) {

                        if(printType == 'All'){
                            $('#allPrintList').show();
                            $('#allPrintList').html(response);
                            $('#labelPrintList').hide();
                        } else {
                            $('#labelPrintList').show();
                            $('#labelPrintList').html(response);
                            $('#allPrintList').hide();
                        }

                        setTimeout(function(){
                            window.print();
                        }, 1000)

                    },
                    error: function(xhr) {
                        //Do Something to handle error
                    }
                });

            } else {
                alert("No barcode is assingned");
            }
        }







        /*
         |----------------------------------------------------
         |   FIND VARIATION METHOD
         |-----------------------------------------------------
        */
        function findVariation(obj)
        {
            $('#allPrintList').html('');
            $('#labelPrintList').html('');
            $("#printQuantity").val('');

            let _this = $(obj).find('option:selected');

            let route = `{{ route('pdt.get-product-variation') }}`;
            let search = _this.val();

            axios.get(route, {
                params: {
                    search : search
                }
            })
            .then(function (response) {
                let vOptions = '<option value="" selected>Select Variations</option>';

                $.each( response.data.product_variations, function( key, value ) {
                    vOptions += `<option value="${ value.id }" data-barcode="${ value.sku }" data-name=${ value.name } data-price="${ value.sale_price }">${ value.name }</option>`;
                });

                $('#variation_id').html(vOptions);
                $('.select2').select2();

            })
            .catch(function (error) {

            });
        }
    </script>




@endsection
