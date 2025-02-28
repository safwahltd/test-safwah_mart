@extends('layouts.master')

@section('title', 'Edit ' . $order->order_no)
@section('css')

    <!-------- SEARCH ANY PRODUCT LIST CSS -------->
    <style>
        .dropdown-content {
            display         : none;
            background-color: #f6f6f6;
            overflow        : auto;
            border          : 1px solid #ddd;
            z-index         : 1;
            max-height      : 244px;
            width           : 79%;
            margin          : 0 auto;
        }
        .dropdown-content ul{
            margin-left: 0
        }
        .dropdown-content.ace-scroll{
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }

        .dropdown-content a {
            color          : black;
            text-decoration: none;
            display        : flex;
            padding        : 5px 8px !important;
            border-bottom  : 1px solid lightgray !important;
            transition     : 0.3s;
        }

        .search-dropdown-list {
            position: absolute;
            top     : 50px;
            left    : 7px;
        }
        .search-dropdown-list a{
            transition: 0.4s;
        }
        .search-dropdown-list .scroll-hover{
            opacity: 0 !important;

        }
        .search-dropdown-list a:hover{
            color           : white !important;
            background-color: rgb(58, 170, 207) !important;
        }
        .table-responsive {
            overflow: visible !important;
        }

        .dropdown-content a:hover{
            background-color: lightskyblue !important;
            color: black !important;
        }
        .show {display: block;}


        .search-result{
            color: white !important;
            background-color: rgb(58, 170, 207) !important;
        }
        .dropdown-content {
            position: absolute;
            left    : 0;
            top     : 40px;
            display : block;
            width   : 100%;
            z-index : 99;
        }
        .dropdown-content .search-product{
            padding-left: 0;
        }
    </style>


    <style>
        .search-input {
            position   : relative;
            border     : 2px solid #68b4e0 !important;
            height     : 40px !important;
            text-indent: 32px !important;
            font-size  : 16px !important;
            color      : #000000 !important;
        }
        .search-icon {
            position : absolute;
            top      : 10px;
            left     : 25px;
            font-size: 18px;
            color    : #346cb0
        }
        .search-input:focus {
            border: 2px solid #346cb0 !important;
        }

        .table-search-input {
            border        : 2px solid #dddddd !important;
            color         : #000000 !important;
            background    : white !important;
            padding-bottom: -1px !important;
        }
        .table-search-input:focus {
            border: 2px solid #346cb0 !important;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="far fa-edit"></i> Order No: <b>{{ $order->order_no }}</b></h4>
        <div class="btn-group">

        </div>
    </div>

    @include('partials._alert_message')

    <div id="searchProduct" class="col-sm-12">
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

    <form id="orderEditForm" action="{{ route('inv.orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')


        <div class="row m-2">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="orderTable">
                        <thead style="border-bottom: 3px solid #346cb0 !important">
                            <tr style="background: #e1ecff !important; color:black !important">
                                <th width="3%" class="text-center">SL</th>
                                <th width="25%">Product</th>
                                <th width="25%">Variation</th>
                                <th width="10%">Unit</th>
                                <th width="10%">Category</th>
                                <th width="10%">Price</th>
                                <th width="5%" class="text-center">Quantity</th>
                                <th width="10%">Discount</th>
                                <th width="10%">Line Total</th>
                                <th width="2%" class="text-center"><i class="far fa-trash"></i></th>
                            </tr>
                        </thead>

                        <tbody id="orderTableBody">
                            @foreach ($order->orderDetails as $item)
                                <tr>
                                    <input type="hidden" name="id[]" value="{{ $item->id }}">
                                    <input type="hidden" class="product-id" name="product_id[]" value="{{ $item->product_id }}">
                                    <input type="hidden" name="purchase_price[]" value="{{ $item->purchase_price }}">

                                    <td class="text-center">{{ $loop->iteration }} </td>
                                    <td>
                                        {{ optional($item->product)->name }}  ({{ optional($item->product)->sku }})
                                    </td>
                                    <td>
                                        <select id="variationSelectId" name="product_variation_id[]" data-placeholder="- Select -" tabindex="1" class="form-control select2" style="width: 100%" required>
                                            <option></option>
                                            @foreach ($item->product->productVariations as $productVariation)
                                                <option value="{{ $productVariation->id }}" {{ $item->product_variation_id == $productVariation->id ? 'selected' : ''}}>{{ $productVariation->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>{{ $item->measurement_title != null ? $item->measurement_title : optional(optional($item->product)->unitMeasure)->name }}</td>
                                    <td>{{ optional(optional($item->product)->category)->name }}</td>
                                    <td class="text-right">
                                        <input type="hidden" class="form-control text-center table-search-input row-sale-price" name="sale_price[]" value="{{ number_format($item->sale_price, 2, '.', '') }}" readonly onkeyup="rowTotal(this)">
                                        {{ number_format($item->sale_price, 2, '.', '') }}
                                    </td>
                                    <td>
                                        <input type="number" class="form-control text-center table-search-input row-quantity" name="quantity[]" value="{{ number_format($item->quantity, 2, '.', '') }}" onkeyup="rowTotal(this)">
                                    </td>
                                    <td>
                                        @if(hasPermission("orders.discount", $slugs))
                                            <input type="text" class="form-control text-right table-search-input row-discount-amount" name="discount_amount[]" value="{{ number_format($item->discount_amount * $item->quantity, 2, '.', '') }}" onkeyup="rowTotal(this)">
                                        @else
                                            <input type="text" class="form-control text-right table-search-input row-discount-amount" name="discount_amount[]" value="{{ number_format($item->discount_amount * $item->quantity, 2, '.', '') }}" onkeyup="rowTotal(this)" readonly>
                                        @endif
                                        <input type="hidden" class="row-discount-percentage" name="discount_percent[]" value="{{ number_format($item->discount_percent, 2, '.', '') }}">
                                    </td>
                                    <td class="text-right">
                                        @php
                                            $line_total = ($item->sale_price * $item->quantity) - ($item->discount_amount * $item->quantity);
                                        @endphp
                                        <span class="row-sub-total">{{ number_format($line_total , 2, '.', '') }}</span>
                                        <input type="hidden" class="row-grand-total" name="total_amount[]" value="{{ number_format($line_total , 2, '.', '') }}">
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="text-danger btn-sm" onclick="deleteNow(this)"><i class="far fa-trash"></i></a>
                                        <input type="hidden" class="row-vat-percentage" name="vat_percent[]" value="{{ $item->vat_percent }}">
                                        <input type="hidden" class="row-vat-amount" name="vat_amount[]" value="{{ $item->vat_amount }}">
                                        <input type="hidden" name="measurement_title[]" class="measurement-title" value="{{ old('measurement_title') ?? $item->measurement_title  }}">
                                        <input type="hidden" name="measurement_sku[]" class="measurement-sku" value="{{ old('measurement_sku') ?? $item->vat_amount }}">
                                        <input type="hidden" name="measurement_value[]" class="measurement-value" value="{{ old('measurement_value') ?? $item->measurement_value }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <tbody id="new-item">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-5">
                <div class="input-group mb-1 width-100" style="width: 100%">
                    <span class="input-group-addon width-40" style="text-align: left">
                        District
                    </span>

                    <select name="{{ optional($order->orderCustomerInfo)->receiver_district_id != null ? 'receiver_district_id' : 'district_id'}}" id="district_id" class="form-control select2"  data-placeholder="- Select -" onchange="changeShippingCost(this)">
                        <option></option>
                        @php
                            if(optional($order->orderCustomerInfo)->receiver_district_id != null ){
                                $district_id = optional($order->orderCustomerInfo)->receiver_district_id;
                            }else{
                                $district_id = optional($order->orderCustomerInfo)->district_id;
                            }
                        @endphp
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}" data-shipping_cost="{{ $district->shipping_cost }}" data-shipping_cost_discount_amount="{{ optional($order)->shipping_cost_discount_amount }}"
                                {{ old('district_id', $district->id) == $district_id ? 'selected' : '' }}>{{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-1 width-100" style="width: 100%">
                    <span class="input-group-addon width-40" style="text-align: left">
                        Area
                    </span>
                    <select name="{{ optional($order->orderCustomerInfo)->receiver_area_id != null ? 'receiver_area_id' : 'area_id'}}" id="area_id" class="form-control select2"  data-placeholder="- Select -" required>
                        <option></option>
                        @php
                            if(optional($order->orderCustomerInfo)->receiver_area_id != null ){
                                $area_id = optional($order->orderCustomerInfo)->receiver_area_id;
                            }else{
                                $area_id = optional($order->orderCustomerInfo)->area_id;
                            }
                        @endphp
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}"
                                {{ old('area_id', $area->id) == $area_id? 'selected' : '' }}>{{ $area->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-1 width-100" style="width: 100%">
                    <span class="input-group-addon width-40" style="text-align: left">
                        Address
                    </span>
                    @php
                        if(optional($order->orderCustomerInfo)->receiver_address != null ){
                            $address = optional($order->orderCustomerInfo)->receiver_address;
                        }else{
                            $address = optional($order->orderCustomerInfo)->address;
                        }
                    @endphp
                    <input type="text" id="" name="{{ optional($order->orderCustomerInfo)->receiver_address != null ? 'receiver_address' : 'address'}}" tabindex="3" class="form-control" value="{{ $address }}" autocomplete="off" data-date-format="yyyy-mm-dd" required>
                </div>
                <div class="input-group mb-1 width-100" style="width: 100%">
                    <span class="input-group-addon width-40" style="text-align: left">
                        Date
                    </span>
                    <input type="text" id="delivery_date" name="delivery_date" tabindex="3" class="form-control date-picker" value="{{ $order->date }}" autocomplete="off" data-date-format="yyyy-mm-dd" required>
                </div>
                <div class="input-group mb-1 width-100" style="width: 100%">
                    <span class="input-group-addon width-40" style="text-align: left">
                        Time Slot
                    </span>
                    <select name="time_slot_id" id="time_slot_id" class="form-control select2"  data-placeholder="- Select -" onchange="">
                        <option></option>
                        @foreach ($time_slots as $time_slot)
                            <option value="{{ $time_slot->id }}"
                                {{ old('time_slot_id', $time_slot->id) == $order->time_slot_id ? 'selected' : '' }}>{{ $time_slot->starting_time }} - {{ $time_slot->ending_time }}</option>
                        @endforeach
                    </select>
                </div>
            </div>




            <div class="col-md-4">
                <div class="input-group width-100" style="width: 100%">
                    <span class="input-group-addon width-40" style="text-align: left; border-left: 1px solid lightgray; border-right: 1px solid lightgray;">
                        Order Note
                    </span>
                </div>
                <textarea name="order_note" placeholder="Order note..." cols="30" rows="8" style="width: 100%; padding-left: 12px;">{{  optional($order->orderCustomerInfo)->order_note }}</textarea>
            </div>



            <div class="col-md-3">
                <table class="pull-right mb-3" style="font-weight: bold">
                    <tr>
                        <td>Subtotal</td>
                        <td class="pl-4">: <span class="order-subtototal">{{ number_format($order->subtotal, 2, '.', '') }}</span></td>
                        <input type="hidden" class="order-subtototal" name="subtotal" value="{{ number_format($order->subtotal, 2, '.', '') }}">
                    </tr>
                    <tr>
                        <td>VAT</td>
                        <td class="pl-4">: <span class="order-total-vat">{{ number_format($order->total_vat_amount, 2, '.', '') }}</span></td>
                        <input type="hidden" class="order-total-vat" name="total_vat_amount" value="{{ number_format($order->total_vat_amount, 2, '.', '') }}">
                    </tr>
                    <tr>
                        <td>Shiping Cost</td>
                        <td class="pl-4">:<span class="order-total-shipping-cost"> {{ number_format($order->total_shipping_cost, 2, '.', '') }}</span></td>
                        <input type="hidden" class="order-total-shipping" name="shipping_cost" value="{{ number_format($order->shipping_cost, 2, '.', '') }}">
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td class="pl-4">: <span class="order-total-discount">{{ number_format($order->discount_amount, 2, '.', '') }}</span></td>
                        <input type="hidden" class="order-total-discount" name="total_discount_amount" value="{{ number_format($order->discount_amount, 2, '.', '') }}">
                    </tr>
                    <tr>
                        <td>Special Discount</td>
                        <td class="pl-4">: <span class="order-total-discount">{{ number_format($order->special_discount, 2, '.', '') }}</span></td>
                        <input type="hidden" class="form-control text-right" name="total_special_discount_percent" id="total_special_discount_percent" value="{{ old('total_special_discount_percent') }}" onkeyup="calculateSpecialDiscountAmount(this)" placeholder="%" autocomplete="off">
                        <input type="hidden" class="form-control text-right" name="total_special_discount_amount" id="total_special_discount_amount" value="{{ old('total_special_discount_amount', $order->special_discount) }}" onkeyup="calculateSpecialDiscountPercent(this)" placeholder="Amount" autocomplete="off">
                    </tr>
                    <tr>
                        <td>Coupon Discount</td>
                        <td class="pl-4">: <span class="order-coupon-discount-amount">{{ number_format($order->coupon_discount_amount, 2, '.', '') }}</span></td>
                        <input type="hidden" class="order-coupon-discount-amount" name="coupon_discount_amount" value="{{ number_format($order->coupon_discount_amount, 2, '.', '') }}">
                    </tr>

                    <input type="hidden" name="payment_type" value="{{ $order->payment_type }}">

                    @if($insideDhaka == '1' || $outsideDhaka == '1')
                        <tr>
                            <td>COD Charge</td>
                            <td class="pl-4"> : <span class="cod_charge_text">{{ $order->total_cod_charge }}</span></td>
                            <div hidden class="input-group mb-1 width-100 cod-charge-container" data-inside-charge="{{ $insideDhakaCharge }}" data-outside-charge="{{ $outsideDhakaCharge }}">
                                <span class="input-group-addon" style="width: 40%; text-align: left">

                                </span>
                                <input type="hidden" name="cod_percent" id="cod_percent" value="{{ old('cod_percent', $insideDhakaCharge) }}">
                                <input type="hidden" class="form-control text-right" name="cod_charge" id="cod_charge" value="{{ old('cod_charge', $order->total_cod_charge) }}" readonly>
                            </div>
                        </tr>
                    @endif
                    <tr>
                        <td>Point Amount</td>
                        <td class="pl-4">: {{ number_format($order->point_amount, 2, '.', '') }}</td>
                    </tr>
                    <tr>
                        <td>Wallet Amount</td>
                        <td class="pl-4">: {{ number_format($order->wallet_amount, 2, '.', '') }}</td>
                    </tr>
                    <tr>
                        <td>Grand Total</td>
                        <td class="pl-4">: <span class="order-grand-total">{{ round($order->grand_total) }}</span></td>
                        <input type="hidden" class="order-grand-total" name="grand_total" value="{{ round($order->grand_total) }}">
                    </tr>
                </table>

                <div class="input-group mt-5 mb-2 width-100">
                    <button class="btn btn-primary pull-right update-order-button" id="save__change" type="button">SAVE CHANGES</button>
                </div>
            </div>
        </div>
    </form>
@endsection


@section('script')
    @include('order-create/_inc/script')


    <script>
        $(document).ready(function () {


            $(".product_id").select2({
                ajax: {
                    url     : `{{ route('get-sale-products') }}`,
                    type    : 'GET',
                    dataType: 'json',
                    delay   : 250,
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
                placeholder       : 'Search Product(s)',
                minimumInputLength: 1,
                templateResult    : formatProduct,
                templateSelection : formatProductSelection
            }).on('change', function(e) {

                let discount_percentage = $(this).select2('data')[0].current_discount != null ? $(this).select2('data')[0].current_discount.discount_percentage : ($(this).select2('data')[0].discount_percentage > 0 ? $(this).select2('data')[0].discount_percentage : 0)
                $(this).html(`
                    <option value='${ $(this).select2('data')[0].id }'
                        data-id                     = "${ $(this).select2('data')[0].id }"
                        data-name                   = "${ $(this).select2('data')[0].name }"
                        data-category               = "${ $(this).select2('data')[0].category.name }"
                        data-is-variation           = "${ $(this).select2('data')[0].is_variation }"
                        data-unit-measure           = "${ $(this).select2('data')[0].unit_measure.name }"
                        data-unit-measure           = "${ $(this).select2('data')[0].unit_measure.name }"
                        data-sku                    = "${ Number($(this).select2('data')[0].sku) }"
                        data-sale-price             = "${ Number($(this).select2('data')[0].sale_price) }"
                        data-sale-discount-percent  = "${ discount_percentage }"
                        data-vat-percent            = "${ getVatPercent($(this).select2('data')[0].vat, $(this).select2('data')[0].vat_type, $(this).select2('data')[0].sale_price, 0)}"
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




    <script>
        $(document).ready(function () {
            $("#customer_id").select2({
                ajax: {
                    url     : `{{ route('get-customers') }}`,
                    type    : 'GET',
                    dataType: 'json',
                    delay   : 250,
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
                placeholder       : 'Search Customer(s)',
                minimumInputLength: 1,
                templateResult    : formatCustomer,
                templateSelection : formatCustomerSelection

            }).on('change', function(e) {
                    $(this).html(`
                        <option selected
                            value         = '${ $(this).select2('data')[0].id }'
                            data-name     = '${$(this).select2('data')[0].name}'
                            data-mobile   = '${$(this).select2('data')[0].mobile}'
                            data-email    = '${$(this).select2('data')[0].email}'
                            data-address  = '${$(this).select2('data')[0].address}'
                            data-gender   = '${$(this).select2('data')[0].gender}'
                            data-user_id  = '${$(this).select2('data')[0].user_id}'
                            data-id       = '${$(this).select2('data')[0].id}'
                            data-zip      = '${$(this).select2('data')[0].zip_code}'
                            data-district = '${$(this).select2('data')[0].district_id}'
                            data-area     = '${$(this).select2('data')[0].area_id}'
                            >
                        ${ $(this).select2('data')[0].name + ' - ' + $(this).select2('data')[0].mobile }
                        </option>
                    `);
                });



            function formatCustomer(customer)
            {
                if (customer.loading) {
                    return customer.text;
                }

                var $container = $(`
                    <div class='select2-result-customer clearfix'>
                        <div class='select2-result-customer__title'>
                            ${ customer.name + ' -> ' + customer.mobile }
                        </div>
                    </div>
                `);

                return $container;
            }

            function formatCustomerSelection(customer) {
                return customer.name;
            }
        });





        function changeShippingCost(obj)
        {
            let shippingCost                    = $(obj).find(':selected').data('shipping_cost')
            let shipping_cost                   = Number(shippingCost)
            let shipping_cost_discount_amount   = $(obj).find(':selected').data('shipping_cost_discount_amount')
            let shipping                        = Number(shippingCost) - Number(shipping_cost_discount_amount)

            $('#shipping_cost').val( shipping_cost )
            $('#total_shipping_cost').val( shipping_cost )

            getAreas(obj);
        }



        function getAreas(obj)
        {
            const route = `{{ route('inv.get-areas-by-district') }}`;

            let district_id = $(obj).find('option:selected').val();

            if(district_id == 47 || district_id == '') {
                $('#cod_percent').val($('.cod-charge-container').data('inside-charge'))
            } else {
                $('#cod_percent').val($('.cod-charge-container').data('outside-charge'))
            }


            if(district_id != undefined) {

                axios.get(route, {
                    params: {
                        district_id : district_id
                    }
                })
                .then(function (response) {

                    let data = response.data;
                    $('.append-areas').empty().select2();
                    $('.append-areas').append(`<option value="" selected>Select an Area</option>`).select2();

                    $.each(data, function (key, item) {
                        $('.append-areas').append(`<option  value="${ item.id }"
                                                            data-min_purchase_amount="${ item.min_purchase_amount }"
                                                            data-free_delivery_amount="${ item.free_delivery_amount }"
                                                            >${ item.name }</option>`).select2();
                    })

                    //-------------- CHECKING AREA SELECTED OR NOT -----------------//
                    var selected_option = $('.append-areas').val();

                    if (selected_option == '') {
                        $('#save__change').prop("disabled", true);
                    }

                    calculateAllAmount()

                })
                .catch(function (error) { });

            }else{
                calculateAllAmount()
            }
        }





        function setCustomer(obj)
        {

            let customer = $(obj).find(':selected')

            let id          = customer.data('id')
            let name        = customer.data('name')
            let phone       = customer.data('mobile')
            let address     = customer.data('address')
            let zip_code    = customer.data('zip')
            let district_id = customer.data('district')
            let area_id     = customer.data('area')


            $('#selected_customer_id').val(id)
            $('#customer_name').val(name)
            $('#customer_phone').val(phone)
            $('#selectedAddress').val(address)
            $('#zipCode').val(zip_code)

            $('.input-group #district_id').val(district_id).trigger('change');

            setTimeout(() => {
                $('.input-group #area_id').val(area_id).trigger('change');
            }, 3000);


        }
    </script>




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

                                let discount_percentage = $(this).select2('data')[0].current_discount != null ? $(this).select2('data')[0].current_discount.discount_percentage : ($(this).select2('data')[0].discount_percentage > 0 ? $(this).select2('data')[0].discount_percentage : 0)
                                result += `<a onclick="getProductVariations(this)"
                                data-id                    = "${ product.id }"
                                data-name                  = "${ product.name }"
                                data-category              = "${ product.category.name }"
                                data-is-variation          = "${ product.is_variation }"
                                data-unit-measure          = "${ product.unit_measure.name }"
                                data-purchase-price        = "${ Number(product.purchase_price).toFixed(2) }"
                                data-sale-price            = "${ Number(product.sale_price).toFixed(2) }"
                                data-sale-discount-percent = "${ discount_percentage }"
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
            }


            let _this = $(obj).closest('.search-any-product');

            e.preventDefault()

            _this.find('.live-load-content').find('a').removeClass('search-result')

            var a = _this.find('.live-load-content').find('a')

            var selectedItem


            if (e.which === 40) {

                selectedLiIndex += 1


            } else if (e.which === 38) {

                $("#searchProduct").focusout();

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

            let hideSearchContent   = 0;
            let searchString        = $(obj).val();
            let stringLength        = searchString.length;

            if(stringLength > 3){

                if (event.which != 38 && event.which != 40) {

                    let route  = `{{ route('pdt.search-any-product') }}`;
                    let value  = $(obj).val();

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
                                    } else{
                                        result += `<a onclick='appendData(${myProduct}, ${ myProduct.sku }, 1)'
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

                            } else {
                                $('.dropdown-content').hide();
                            }
                        }).catch(function (error) {

                        });
                    }

                } else {
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

        function appendData(product, searchedValue, isReadonly)
        {
            let discount_percentage = product.current_discount != null ? product.current_discount.discount_percentage : (product.discount_percentage > 0 ? product.discount_percentage : 0);

            let tr = `<tr class="new-tr">
                    <input type="hidden" name="sale_detail_id[]" class="purchase-detail-id" value="">
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
                                data-sale-discount-percent  = "${ discount_percentage }"
                                data-vat-percent            = "${ product.vat, product.vat_type, product.sale_price}"
                                selected
                            >${ product.name } &mdash; ${ product.code }</option>
                        </select>
                    </th>

                    <th width="15%">
                        <select name="" id="product_variation_id" class="form-control product-variations abcd select2" onchange="checkItemExistOrNot(this)" ${ isReadonly == 1 ? 'disabled' : '' }>
                            <option value="" selected>- Select -</option>
                        </select>
                    </th>
                    <th width="7%">
                        <input type="text" name="" id="sku" value="${ product.sku}" class="form-control sku-code" readonly>
                    </th>
                    <th width="10%">
                        <input type="text" name="stock[]" id="stock" class="form-control text-center only-number stock" readonly>
                    </th>
                    <th width="7%">
                        <input type="text" name="unit_measure_id[]" id="unit_measure_id" value="${ product.unit_measure.name }" class="form-control unit-measure" readonly>
                    </th>
                    <th width="10%">
                        <input type="hidden" name="purchase_price[]" id="purchase_price" class="form-control text-right only-number purchase-price" autocomplete="off" value="${ product.purchase_price }" required>
                        <input type="number" name="sale_price[]" id="sale_price" class="form-control text-right only-number sale-price" autocomplete="off" onkeyup="calculateRowTotal(this)" value="${ product.sale_price }" required>
                    </th>
                    <th width="8%">
                        <input type="number" name="quantity[]" id="quantity" class="form-control text-center quantity pdt-quantity" autocomplete="off" onkeyup="calculateRowTotal(this)" required>
                    </th>
                    <th width="10%">
                        <input type="hidden" name="product_variation_id[]" class="product-variation-id" value="">
                        <input type="hidden" name="measurement_title[]" class="measurement-title" value="{{ old('measurement_title') }}">
                        <input type="hidden" name="measurement_sku[]" class="measurement-sku" value="{{ old('measurement_sku') }}">
                        <input type="hidden" name="measurement_value[]" class="measurement-value" value="{{ old('measurement_value') }}">
                        <input type="hidden" name="vat_amount[]" class="pdt-vat-amount">
                        <input type="hidden" name="vat_percent[]" class="pdt-vat-percent" value="${ product.vat }">
                        <input type="hidden" name="purchase_total[]" id="purchase_total" class="form-control purchase-total text-right" readonly>
                        <input type="text"   name="total[]" id="total" class="form-control total text-right" readonly>
                        <input type="hidden" name="discount_percent[]" class="form-control pdt-discount-percent text-right" value="${ discount_percentage }" readonly>
                        <input type="hidden" name="discount_amount[]" class="form-control pdt-total-discount-amount text-right" readonly>
                        </th>
                        <th width="5%" class="text-center">
                            <button type="submit" class="btn btn-sm btn-danger remove-row" title="Remove"><i class="fa fa-times"></i></button>
                        </th>
                </tr>`
            $("#invoiceSaleTable").append( tr );
            let row = $("#invoiceSaleTable tbody tr:last");

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
@endsection
