@extends('layouts.master')
@section('title', 'Add New Discount')


@section('css')
    <style>
        .sn-no {
            padding-left: 5px;
            line-height: 2.5;
        }

        .label-primary {
            border: 0px !important;
        }

        .offers>h3{
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            margin-bottom: 30px;
        }

        .card {
            /* box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
            transition: box-shadow .25s;  */
            border: 1px solid rgb(210, 210, 210);
        }
        .card:hover {
            box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
        }

        .card-body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 180px;
            font-size: 26px;
            background-color: #cfffd4;
        }

        .card-footer {
            text-align: center;
            font-size: 16px;
        }

        a {
            text-decoration: none !important;
        }
    </style>
@endsection


@section('content')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <h4 class="pl-2"><i class="far fa-plus-circle"></i> @yield('title')</h4>

    <ul class="breadcrumb mb-1">
        <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
        <li><a class="text-muted" href="{{ route('discounts.index') }}">Discount</a></li>
        <li>Create</li>
    </ul>
</div>

    <div class="row">
        <div class="widget-body">
            <div class="widget-main">

                @include('partials._alert_message')

                @if(request()->getQueryString() == null)
                    <section class="offers">
                        <h3>Chose An Offer</h3>
                        <div class="row">
                            @foreach($offers as $id => $name)
                                <div class="col-md-3 col-sm-6">
                                    <a href="{{ route('discounts.create') }}?offer_id={{ $id }}">
                                        <div class="card">
                                            <div class="card-body">
                                                {{ $name }}
                                            </div>
                                            <div class="card-footer">
                                                <h5>NEXT <i class="far fa-chevron-double-right"></i></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @else
                    <!-- PURCHASE CREATE FORM -->
                    <form class="form-horizontal" action="{{ route('discounts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="offer_id" value="{{ request('offer_id') }}">

                        <div class="row mt-1">
                            <div class="col-md-8 col-md-offset-2 mb-2">
                                <input type="text" class="form-control" readonly value="{{ $offer_name }}" style="height: 50px; text-align: center; font-size: 20px; color: black;">
                            </div>
                            <div class="col-md-8 col-md-offset-2">
                                <div class="input-group mb-2 width-100" style="width: 100%">
                                    <span class="input-group-addon width-10" style="text-align: left">
                                        Product <span class="label-required">*</span>
                                    </span>
                                    <select id="product" data-placeholder="- Select -" tabindex="1" class="form-control select2" required>
                                        <option></option>
                                        <option value="All">All</option>
                                    </select>
                                    <a href="javascript:void(0)" class="input-group-addon width-10" onclick="addDiscount(this)" style="background-color: #b0ffa3 !important; color: #000000 !important; text-decoration: none"><i class="fas fa-plus"></i> ADD</a>
                                </div>
                            </div>
                        </div>

                        <!-- OFFER ITEMS TABLE -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="purchaseTable">
                                        <thead style="border-bottom: 3px solid #346cb0 !important">
                                            <tr style="background: #e1ecff !important; color:black !important">
                                                <th width="3%">SN</th>
                                                <th width="25%">Product</th>
                                                <th width="10%">Category</th>
                                                <th width="10%">Unit</th>
                                                <th width="8%" class="text-right">MRP</th>
                                                <th width="5%" class="text-center">Discount(%)</th>
                                                <th width="5%" class="text-center">Discount(Flat)</th>
                                                <th width="11%">Start Date</th>
                                                <th width="11%">End Date</th>
                                                <th width="12%" class="text-center">Show in Offer</th>
                                                <th width="5%"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="discount-table-body">
                                            @if (old('product_id'))
                                                @foreach (old('product_id') as $key => $value)
                                                <tr class="first-tr">
                                                    <th width="3%" class="text-center">
                                                        <p class="serial" style="margin: 6px 0 10px !important">{{ old('product_id')[$key] + 10000000 }}</p>
                                                    </th>
                                                    <th width="25%">
                                                        <input type="text" name="product_name[]" class="form-control" value="{{ old('product_name')[$key] }}" readonly>
                                                        <input type="hidden" name="product_id[]" class="form-control product-id" value="{{ old('product_id')[$key] }}" readonly>
                                                    </th>
                                                    <th width="10%">
                                                        <input type="text" class="form-control" name="category_name[]" value="{{ old('category_name')[$key] }}" readonly>
                                                    </th>
                                                    <th width="10%">
                                                        <input type="text" class="form-control" name="unit_measure_name[]" value="{{ old('unit_measure_name')[$key] }}" readonly>
                                                    </th>
                                                    <th width="8%">
                                                        <input type="number" name="mrp[]" class="form-control product-price text-right" value="{{ old('mrp')[$key] }}" readonly>
                                                    </th>
                                                    <th width="5%">
                                                        <input type="text" name="discount_percentage[]" max="100" class="form-control only-number discount-percentage" value="{{ old('discount_percentage')[$key] }}" required>
                                                    </th>
                                                    <th width="5%">
                                                        <input type="text" name="discount_flat[]" class="form-control only-number discount-flat" value="{{ old('discount_flat')[$key] }}" required>
                                                    </th>
                                                    <th width="11%">
                                                        <input type="text" name="start_date[]" class="form-control date-picker" value="{{ old('start_date')[$key] }}" autocomplete="off" data-date-format="yyyy-mm-dd" required>
                                                    </th>
                                                    <th width="11%">
                                                        <input type="text" name="end_date[]" class="form-control date-picker" value="{{ old('end_date')[$key] }}" autocomplete="off" data-date-format="yyyy-mm-dd" required>
                                                    </th>
                                                    <th width="12%">
                                                        <div class="material-switch pt-1 pl-3">
                                                            <input type="hidden" name="show_in_offer[]" class="show-in-offer" />
                                                            <input type="checkbox" id="show_in_offer{{ old('product_id')[$key] }}" class="set-show-in-offer" onclick="showInOffer(this)" />
                                                            <label for="show_in_offer{{ old('product_id')[$key] }}" class="badge-primary"></label>
                                                        </div>
                                                    </th>
                                                    <th width="5%" class="text-center">
                                                        <button type="button" class="btn btn-sm btn-danger remove-row" title="Remove"><i class="fa fa-times"></i></button>
                                                    </th>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="col-md-9"></div>
                            <div class="col-md-3">
                                <div class="btn-group width-100">
                                    <button class="btn btn-sm btn-success" style="width: 70%" type="submit"> <i class="fa fa-save"></i> SUBMIT </button>
                                    <a class="btn btn-sm btn-info"  style="width: 29%" href="{{ route('discounts.index') }}"> <i class="fa fa-bars"></i> LIST </a>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection





@section('script')
    <script>
        let serial = 0;





        /*
        |=========================================================
        |     GET PRODUCT BY AXIOUS
        |=========================================================
        */
        async function getProducts()
        {
            let route       = "{{ route('discounts.create') }}";

            await axios.get(route, {params: {is_axios: 'true'}})
            .then(function (response) {
                $.each(response.data, function (key, item) {
                    if (item.current_stock != null) {
                        $('#product').append(`<option value="${item.id}" data-name="${ item.name }" data-category="${ item.category.name }" data-unit-measure="${ item.unit_measure.name }" data-mrp="${ item.sale_price }">${item.name}</option>`).select2();
                    }
                })
            })
            .catch(function (error) {
                // console.log(error);
            });
        }

        getProducts()








        /*
        |=========================================================
        |     ADD DISCOUNT
        |=========================================================
        */
        function addDiscount(obj)
        {
            let productId           = '';
            let productName         = '';
            let categoryName        = '';
            let unitMeasureName     = '';
            let mrp     = '';
            let selectedProductId   = $('#product').find('option:selected').val();

            if (selectedProductId) {
                if(selectedProductId == 'All') {
                    $("#product option").each(function() {
                        if($(this).val() != 'All' && $(this).val()){

                            serial              += 1;
                            productId           = $(this).val();
                            productName         = $(this).data('name');
                            categoryName        = $(this).data('category');
                            unitMeasureName     = $(this).data('unit-measure');
                            mrp                 = $(this).data('mrp');

                            appendDiscount(productId, productName, categoryName, unitMeasureName, mrp, serial);
                        }
                    });
                } else {

                    serial              += 1;
                    productId           = selectedProductId;
                    productName         = $('#product').find('option:selected').data('name');
                    categoryName        = $('#product').find('option:selected').data('category');
                    unitMeasureName     = $('#product').find('option:selected').data('unit-measure');
                    mrp                 = $('#product').find('option:selected').data('mrp');


                    appendDiscount(productId, productName, categoryName, unitMeasureName, mrp, serial);
                }
            }
        }








        /*
        |=========================================================
        |     APPEND DISCOUNTED PRODUCT
        |=========================================================
        */
        function appendDiscount(productId, productName, categoryName, unitMeasureName, mrp, serial){

            let appendNow    = 'true';

            $('.product-id').each(function() {
                if (productId == $(this).val()) {
                    appendNow = 'false';
                }
            });

            if(appendNow == 'true') {

                $row =  `<tr class="first-tr">
                            <td width="3%" class="text-center">
                                <p class="serial" style="margin: 6px 0 10px !important">${ serial }</p>
                            </td>
                            <td width="25%">
                                <input type="text" name="product_name[]" class="form-control" value="${ productName }" readonly>
                                <input type="hidden" name="product_id[]" class="form-control product-id" value="${ productId }" readonly>
                            </td>
                            <td width="10%">
                                <input type="text" class="form-control" name="category_name[]" value="${ categoryName }" readonly>
                            </td>
                            <td width="10%">
                                <input type="text" class="form-control" name="unit_measure_name[]" value="${ unitMeasureName }" readonly>
                            </td>
                            <td width="8%">
                                <input type="number" name="mrp[]" class="form-control product-price text-right" value="${ mrp }" readonly>
                            </td>
                            <td width="5%">
                                <input type="text" name="discount_percentage[]" max="100" step="0.00" class="form-control only-number discount-percentage text-right" required>
                            </td>
                            <td width="5%">
                                <input type="text" name="discount_flat[]" step="0.00" class="form-control discount-flat only-number text-right" required>
                            </td>
                            <td width="11%">
                                <input type="text" name="start_date[]" class="form-control date-picker start-date data-validation" autocomplete="off" data-date-format="yyyy-mm-dd" required>
                            </td>
                            <td width="11%">
                                <input type="text" name="end_date[]" class="form-control date-picker end-date data-validation" autocomplete="off" data-date-format="yyyy-mm-dd" required>
                            </td>
                            <td width="12%">
                                <div class="material-switch pt-1 pl-3">
                                    <input type="hidden" name="show_in_offer[]" class="show-in-offer" />
                                    <input type="checkbox" id="show_in_offer${productId}" class="set-show-in-offer" onclick="showInOffer(this)" checked />
                                    <label for="show_in_offer${productId}" class="badge-primary"></label>
                                </div>
                            </td>
                            <td width="5%" class="text-center">
                                <button type="button" class="btn btn-sm btn-danger remove-row" title="Remove" onclick="removeRow(this)"><i class="fa fa-times"></i></button>
                            </td>
                        </tr>`;

                $("#discount-table-body").append($row);
                showInOffer($('.set-show-in-offer'))

                $('.date-picker').datepicker();

                rowSerial()
            }
        }


        function showInOffer(obj)
        {
            if($(obj).prop("checked") == true)
            {
                $(obj).closest('tr').find('.show-in-offer').val(1)
            }

            else if($(obj).prop("checked") == false)
            {
                $(obj).closest('tr').find('.show-in-offer').val(0)
            }
        }


        showInOffer($('.set-show-in-offer'))



        function rowSerial()
        {
            $('.serial').each(function (index) {
                $(this).text(index + 1)
            })
        }

        function removeRow(obj){
            $(obj).closest ('tr').remove();
            rowSerial();
        }


        function dateValidation(obj) {

            let _this     = $(obj).closest('.discount-row');

            let startDate = $(this).find('.start-date').val();
            let endDate   = $(this).find('.end-date').val();


            if (new Date(startDate).getTime() >= new Date(endDate).getTime()) {

                alert("End date is smaller then start date");

                $(obj).val('')
            }
        }

        $(document).on('change', '.data-validation', function () {
            let startDate = $(this).closest('tr').find('.start-date').val();
            let endDate   = $(this).closest('tr').find('.end-date').val();

            if (new Date(startDate).getTime() >= new Date(endDate).getTime()) {

                alert("End date is smaller then start date");

                $(this).val('')
            }
        })


        // DISCOUNT PERCENT TO FLAT AMOUNT
        $(document).on('keyup', '.discount-percentage', function() {
            let percent = Number($(this).val())
            let price   = Number($(this).closest('tr').find('.product-price').val())

            if(percent > 100) {
                percent = 100
                $(this).val(100)
            }

            let discount = ((price * percent) / 100).toFixed(2)

            $(this).closest('tr').find('.discount-flat').val(discount)
        })


        // DISCOUNT PERCENT TO FLAT AMOUNT
        $(document).on('keyup', '.discount-flat', function() {
            let flat = Number($(this).val())
            let price   = Number($(this).closest('tr').find('.product-price').val())

            if(flat < 0) {
                flat = 0
                $(this).val(0)
            }

            let discount = ((flat * 100) / price).toFixed(2)

            $(this).closest('tr').find('.discount-percentage').val(discount)
        })
    </script>
@endsection
