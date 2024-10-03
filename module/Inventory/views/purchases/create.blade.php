@extends('layouts.master')
@section('title', 'Add New Purchase')

@section('css')

    <!-------- SEARCH ANY PRODUCT LIST CSS -------->
    <style>
        .search-purchase-product .dropdown-content {
            display: none;
            background-color: #f6f6f6;
            overflow: auto;
            border: 1px solid #ddd;
            z-index: 1;
            max-height: 244px;
            width: 79%;
            margin: 0 auto;
        }
        .search-purchase-product .dropdown-content ul{
            margin-left: 0
        }
        .search-purchase-product .dropdown-content.ace-scroll{
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }

        .search-purchase-product .dropdown-content a {
        color: black;
        text-decoration: none;
        display: flex;
        padding: 5px 8px !important;
            border-bottom: 1px solid lightgray !important;
            transition: 0.3s;
        }

        .search-purchase-product .search-dropdown-list {
            position: absolute;
            top: 50px;
            left: 7px;
        }
        .search-purchase-product .search-dropdown-list a{
            transition: 0.4s;
        }
        .search-purchase-product .search-dropdown-list .scroll-hover{
            opacity: 0 !important;

        }
        .search-purchase-product .search-dropdown-list a:hover{
            color: white !important;
            background-color: rgb(58, 170, 207) !important;
        }
        .search-purchase-product .table-responsive {
            overflow: visible !important;
        }

        .search-purchase-product .dropdown-content a:hover{
            background-color: lightskyblue !important;
            color: black !important;
        }
        .search-purchase-product .show {display: block;}


        .search-purchase-product .search-result{
            color: white !important;
            background-color: rgb(58, 170, 207) !important;
        }
        .search-purchase-product .dropdown-content {
            position: absolute;
            left: 0;
            top: 40px;
            display: block;
            width: 100%;
            z-index: 99;
        }
        .search-purchase-product .dropdown-content .search-product{
            padding-left: 0;
        }
    </style>

@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="far fa-plus-circle"></i> @yield('title')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li><a class="text-muted" href="{{ route('inv.purchases.index') }}">Purchase</a></li>
                    <li>Create</li>
                </ul>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    @include('partials._alert_message')


                    <!-- PURCHASE CREATE FORM -->
                    <form id="" class="form-horizontal" action="{{ route('inv.purchases.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="type" value="Direct">



                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group mb-2 width-100" style="width: 100%">
                                    <span class="input-group-addon" style="width: 40%; text-align: left">
									    Supplier<span class="label-required">*</span>
                                    </span>
                                    <select name="supplier_id" id="supplier_id" data-placeholder="- Select -" tabindex="1" class="form-control select2" style="width: 100%" required>
                                        <option></option>
                                        @foreach($suppliers as $id => $name)
                                            <option value="{{ $id }}" {{ old('supplier_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-2 width-100" style="width: 100%">
                                    <span class="input-group-addon" style="width: 40%; text-align: left">
									    Warehouse<span class="label-required">*</span>
                                    </span>
                                    <select name="warehouse_id" id="warehouse_id" data-placeholder="- Select -" tabindex="2" class="form-control select2" style="width: 100%" required>
                                        <option></option>
                                        @foreach($warehouses as $id => $name)
                                            <option value="{{ $id }}" {{ old('warehouse_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-2 width-100" style="width: 100%">
                                    <span class="input-group-addon" style="width: 40%; text-align: left">
									    Date<span class="label-required">*</span>
                                    </span>
                                    <input type="text" name="date" id="date" tabindex="3" class="form-control date-picker" value="{{ old('date', date('Y-m-d')) }}" autocomplete="off" data-date-format="yyyy-mm-dd">
                                </div>
                            </div>

                            <div id="searchProduct" class="col-sm-12 search-purchase-product">
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

                        </div>


                        <!-- PURCHASE TABLE -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="purchaseTable">
                                        <thead>
                                            <tr class="table-header-bg">
                                                <th width="15%">Product</th>
                                                <th width="12%">Variation</th>
                                                <th width="8%">Sku</th>
                                                <th width="8%">Category</th>
                                                <th width="6%">Unit</th>
                                                <th width="8%">Lot</th>
                                                <th width="10%" class="text-center">Unit Cost</th>
                                                <th width="10%" class="text-center">Qty</th>
                                                <th width="10%" class="text-center">Expired</th>
                                                <th width="10%">Comment</th>
                                                <th width="5%" class="text-center">
                                                    <button type="button" class="btn btn-sm btn btn-info" title="ADD" id="addrow" style="padding: 1px 6px; font-size: 16px;"><i class="fas fa-plus" style=""></i></button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (old('product_id'))
                                                @foreach (old('product_id') as $key => $value)
                                                    <tr>
                                                        @php $product = \Module\Product\Models\Product::with('productVariations')->find(old('product_id')[$key]); @endphp
                                                        <input type="hidden" name="purchase_detail_id[]" value="{{ old('purchase_detail_id')[$key] }}">
                                                        <input type="hidden" class="product_is_variation" value="{{ count($product->productVariations) > 0 ? 'true' : 'false' }}">

                                                        <th width="25%">
                                                            <select name="product_id[]" id="product_id" class="form-control products select2" data-placeholder="- Select -" onchange="getProductVariations(this)" required>
                                                                <option></option>
                                                                @foreach ($products ?? [] as $product)
                                                                    <option value="{{ $product->id }}"
                                                                        data-category="{{ optional($product->category)->name }}"
                                                                        data-unit-measure="{{ optional($product->unitMeasure)->name }}"
                                                                        data-purchase-price="{{ number_format($product->purchase_price, 2, '.', '') }}"
                                                                        {{ old('product_id')[$key] == $product->id ? 'selected' : '' }}
                                                                    >{{ $product->name . ' - ' . $product->code }}</option>
                                                                @endforeach
                                                            </select>
                                                        </th>
                                                        <th width="10%">
                                                            <input type="text" name="category_id[]" id="category_id" class="form-control category" value="{{ old('category_id')[$key] }}" readonly>
                                                        </th>
                                                        <th width="10%">
                                                            <input type="text" name="unit_measure_id[]" id="unit_measure_id" class="form-control unit-measure" value="{{ old('unit_measure_id')[$key] }}" readonly>
                                                        </th>
                                                        <th width="15%">
                                                            <select name="product_variation_id[]" id="product_variation_id" class="form-control product-variations select2" onchange="checkItemExistOrNot(this)">
                                                                <option value="" selected>- Select -</option>
                                                                @php $product = \Module\Product\Models\Product::with('productVariations')->find(old('product_id')[$key]); @endphp
                                                                @foreach ($product->productVariations as $variation)
                                                                    <option value="{{ $variation->id }}" {{ old('product_variation_id')[$key] == $variation->id ? 'selected' : '' }}>{{ $variation->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </th>
                                                        <th width="10%">
                                                            <input type="text" name="lot[]" id="lot" class="form-control lot" value="{{ old('lot')[$key] }}" autocomplete="off">
                                                        </th>
                                                        <th width="10%">
                                                            <input type="text" name="purchase_price[]" id="purchase_price" class="form-control text-right only-number purchase-price" value="{{ old('purchase_price')[$key] }}" autocomplete="off" required>
                                                        </th>
                                                        <th width="10%">
                                                            <input type="number" name="quantity[]" id="quantity" class="form-control text-center quantity" value="{{ old('quantity')[$key] }}" autocomplete="off" required>
                                                        </th>
                                                        <th>
                                                            <input type="text" name="expired_dates[]" data-date-format="yyyy-mm-dd" class="form-control date-picker" readonly="" autocomplete="off">
                                                        </th>
                                                        <th width="10%">
                                                            <input type="text" name="special_comment[]" id="special_comment" class="form-control special_comment" value="{{ old('special_comment')[$key] }}" autocomplete="off">
                                                        </th>
                                                        <th width="5%" class="text-center">
                                                            <button type="button" class="btn btn-sm btn-danger remove-row" title="Remove" {{ $loop->first ? 'disabled' : '' }}><i class="fa fa-times"></i></button>
                                                        </th>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="9" class="text-center">
                                                    {{-- <a href="javascript:void(0)" type="button" class="btn btn-xs btn-block btn-light" style="color: #0084db !important" id="addrow">
                                                        <i class="fas fa-plus-circle"></i> ADD MORE
                                                    </a> --}}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>





                        <div class="btn-group" style="float: right">
                            <button class="btn btn-sm btn-success"> <i class="fa fa-save"></i> SUBMIT </button>
                            <a class="btn btn-sm btn-info" href="{{ route('inv.purchases.index') }}"> <i class="fa fa-bars"></i> LIST </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection





@section('script')
    <script>
     $(document).ready(function () {


    $(".product_id").select2({
        ajax: {
            url: `{{ route('get-sale-products') }}`,
            type: 'GET',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term, // search term
                    page: params.current_page
                };
            },
            processResults: function(data, params) {
                params.current_page = params.current_page || 1;

                return {
                    results: data.data,
                    pagination: {
                        more: (params.current_page * 30) < data.total
                    }
                };
            },
            autoWidth: true,
            cache: true
        },
        placeholder: 'Search Product(s)',
        minimumInputLength: 1,
        templateResult: formatProduct,
        templateSelection: formatProductSelection
    }).on('change', function(e) {
        console.log($(this).select2('data')[0]);

        $(this).append(`
            <option value='${ $(this).select2('data')[0].id }'
                data-sku               = "${ $(this).select2('data')[0].sku }"
                data-category               = "${ $(this).select2('data')[0].category.name }"
                data-unit-measure           = "${ $(this).select2('data')[0].unit_measure.name }"
                data-purchase-price         = "${ Number($(this).select2('data')[0].purchase_price) }"
                selected
            > ${ $(this).select2('data')[0].name + ' - ' + $(this).select2('data')[0].sku }
            </option>
        `);
    });


    function formatProduct(product) {
        if (product.loading) {
            return product.text;
        }

        var $container = $(`
            <div class='select2-result-product clearfix'>
                <div class='select2-result-product__title'>
                    ${ product.name + ' -> ' + product.sku }
                </div>
            </div>
        `);

        return $container;
    }

    function formatProductSelection(product) {
        return product.name;
    }
});
    </script>
    @include('purchases._inc.script')





<!------- START ------- FOR SEARCH ANY PRODUCT ------>

<script>
    let product_si = 0;

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

        if(stringLength > 2){
            if (event.which != 38 && event.which != 40) {
            let route  = `{{ route('pdt.search-any-product') }}`;
            let value = $(obj).val();
            // $(obj).val('');

            if(value != ''){
                axios.get(route, {
                    params: {
                        search : value,
                        type: 'purchase'
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
                                        result += `<a onclick='appendData(${myProduct}, ${ variation.sku }, 1)'
                                                    data-id                    = "${ product.id }"
                                                    data-name                  = "${ product.name }"
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
                                        result += `<a onclick='appendData(${myProduct}, ${ measurement.sku }, 1)'
                                                    data-id                    = "${ product.id }"
                                                    data-name                  = "${ product.name }"
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

                                    result += `<a onclick="appendData(response.data)"
                                                data-id                    = "${ product.id }"
                                                data-name                  = "${ product.name }"
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
                                                ${ product.name +' - '+ sku }
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

    function appendData(product, searchedValue, isReadonly){
        let tr = `<tr class="new-tr">

                   <input type="hidden" name="purchase_detail_id[]" value="">

                    <th width="25%" style="position: relative;">
                        <input type="hidden" class="product-is-variation" value="${ product.product_variations != '' ? "true" : "false" }">
                        <input type="hidden" class="product-is-measurement" value="${ product.product_measurements != '' ? "true" : "false" }">
                        <select name="product_id[]" id="product_id" class="form-control products product_id-${newKey}" onchange="getProductVariations(this)" required>
                            <option value="${ product.id }"
                                data-category               = "${ product.category.name }"
                                data-is-variation           = "${ product.is_variation }"
                                data-unit-measure           = "${ product.unit_measure.name }"
                                data-purchase-price         = "${ product.purchase_price }"
                                data-sale-price             = "${ product.sale_price }"
                                data-sale-discount-percent  = "${ product.current_discount != null ? product.current_discount.discount_percentage : 0 }"
                                data-vat-percent            = "${ product.vat, product.vat_type, product.sale_price}"
                                selected
                            >${ product.name } &mdash; ${ product.code }</option>
                        </select>
                    </th>

                    <th width="15%">
                        <select  class="form-control product-variations abcd select2" onchange="checkItemExistOrNot(this)" ${ isReadonly == 1 ? 'disabled' : '' }>
                        </select>
                        <input type="hidden" name="product_variation_id[]" class="form-control product-variation-id-input" readonly>

                    </th>

                    <th width="7%">

                        <input type="text" name="" id="sku[]" value="${ product.sku}" class="form-control sku-code" readonly>
                    </th>

                    <th width="8%">
                        <input type="number" name="category_id[]"  value="${ product.category.name }" class="form-control text-center" autocomplete="off">
                    </th>

                    <th width="7%">
                        <input type="text" name="unit_measure_id[]" id="unit_measure_id" value="${ product.unit_measure.name }" class="form-control unit-measure" readonly>
                    </th>

                    <th width="10%">
                        <input type="text" name="lot[]" id="lot" class="form-control lot" autocomplete="off">
                    </th>

                    <th width="10%">
                        <input type="hidden" name="purchase_price[]" id="purchase_price" class="form-control text-right only-number purchase-price" autocomplete="off" value="${ product.purchase_price }" required>
                        <input type="number" name="sale_price[]" id="sale_price" class="form-control text-right only-number sale-price" autocomplete="off" onkeyup="calculateRowTotal(this)" value="${ product.sale_price }" required>
                    </th>

                    <th width="8%">
                        <input type="number" name="quantity[]" id="quantity" class="form-control text-center quantity pdt-quantity" autocomplete="off" onkeyup="calculateRowTotal(this)" required>
                    </th>
                    <th>
                        <input type="text" name="expired_dates[]" data-date-format="yyyy-mm-dd" class="form-control date-picker" readonly="" autocomplete="off">
                    </th>

                    <th width="10%">
                        <input type="text" name="special_comment[]" id="special_comment" class="form-control special_comment" autocomplete="off">
                    </th>

                    <th width="5%" class="text-center">
                        <button type="submit" class="btn btn-sm btn-danger remove-row" title="Remove"><i class="fa fa-times"></i></button>
                    </th>

                </tr>`




        $("#purchaseTable").append( tr );
        let row = $("#purchaseTable tbody tr:last");

        if(product.is_variation == "Yes"){
            let variation = product.product_variations;
            let variationSku = 0;
            let variationSkuCode = product.sku;

            variation.map(function(productVariation, index) {
                row.find('.product-variations').append(`<option value="${ productVariation.id }" data-variation-purchase-price="${ productVariation.purchase_price }" data-variation-sale-price="${ productVariation.sale_price }" data-variation-current-stock="0" data-is-variation="Yes" ${ productVariation.sku == searchedValue ? 'selected' : ''}>${ productVariation.name }</option>`);

                if(productVariation.sku == searchedValue)
                {
                    variationSku = 1;
                    variationSkuCode = productVariation.sku;
                    $('.product-variation-id-input').val(productVariation.id);
                }

            });
            row.find('.sku-code').val(variationSkuCode);

            if(variationSku == 1){

                checkItemExistOrNot(row.find('.product-variations'));
            }
        }
        $('#searchProductField').val('');



        $('.product-variations').select2();
    }


    $(document).on('change', '.abcd', function () {
        $(this).closest('tr').find('.lots').prop('required', false);
        $(this).closest('tr').find('.lots').empty().select2();
        $(this).closest('tr').find('.lots').append(`<option value="" selected>- Select -</option>`).select2();

        checkItemExistOrNot($(this));
    })

</script>
<!----------------------- END ------------------------->




@endsection
