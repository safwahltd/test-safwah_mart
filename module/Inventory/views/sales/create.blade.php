@extends('layouts.master')
@section('title', 'Add New Sale')

@section('css')
    <style>
        .sn-no {
            padding-left: 5px;
            line-height: 2.5;
        }
    </style>



<style>
    /* .dropdown-content {
        display: none;
        background-color: #f6f6f6;
        overflow: auto;
        border: 1px solid #ddd;
        z-index: 1;
        max-height: 117px;
        width: 95%;
        margin: 0 auto;
    } */
    .dropdown-content {
        display: none;
        background-color: #f6f6f6;
        overflow: auto;
        border: 1px solid #ddd;
        z-index: 1;
        max-height: 244px;
        width: 79%;
        margin: 0 auto;
    }
    .dropdown-content ul{
        margin-left: 0
    }
    .dropdown-content.ace-scroll{
        overflow-y: auto !important;
        overflow-x: hidden !important;
    }
    .dropdown-content a {
      color: black;
      text-decoration: none;
      display: flex;
      padding: 5px 8px !important;
        border-bottom: 1px solid lightgray !important;
        transition: 0.3s;
    }
    .search-dropdown-list {
        position: absolute;
        top: 50px;
        left: 7px;
    }
    .search-dropdown-list a{
        transition: 0.4s;
    }
    .search-dropdown-list .scroll-hover{
        opacity: 0 !important;
    }
    .search-dropdown-list a:hover{
        color: white !important;
        background-color: rgb(58, 170, 207) !important;
    }
    .table-responsive {
        overflow: visible !important;
    }
    .dropdown-content a:hover{
        background-color: #0084db;
        color: white;
    }
    .show {display: block;}
    .search-result{
        color: white !important;
        background-color: rgb(58, 170, 207) !important;
    }
    .dropdown-content {
            position: absolute;
            left: 0;
            top: 40px;
            display: block;
            width: 100%;
            z-index: 99;
        }
</style>
@endsection


@section('content')

    @include('sales/_inc/_customer-add-modal')
    @include('sales/_inc/_customer-edit-modal')
    @include('script/_customer-add-edit-script')
    @include('script/_customer-search-script')



    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-1"><i class="far fa-plus-circle"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="{{ route('inv.sales.index') }}">Sale</a></li>
            <li>Create</li>
        </ul>
    </div>





    <div class="row">
        <div class="col-12">


            <div class="widget-body">
                <div class="widget-main">

                    @include('partials._alert_message')


                    <!-- PURCHASE CREATE FORM -->
                    <form class="form-horizontal" action="{{ route('inv.orders.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf



                        <div class="row" style="justify-content: space-evenly; display: flex;">
                            <!-- CUSTOMER -->
                            <div class="col-md-3">
                                <div class="input-group mb-2">
                                    <span class="input-group-addon" style="">
									    <a href="#" data-toggle="modal" data-target="#customerAddModal" class=""><i class="fas fa-user-plus"></i></a>
                                    </span>
                                    <select name="customer_id" id="customer_id" class="form-control" style="width: 100%" required>

                                    </select>
                                    <span class="input-group-addon" style="">
									    <a href="#" data-toggle="modal" data-target="#customerEditModal" class="" onclick="showEditCustomer()"><i class="fas fa fa-edit"></i></a>
                                    </span>

                                </div>
                            </div>


                            <!-- WAREHOUSE -->
                            <div class="col-md-3">
                                <div class="input-group mb-2 width-100" style="width: 100%">
                                    <span class="input-group-addon" style="width: 20%; text-align: left">
									    Warehouse<span class="label-required">*</span>
                                    </span>
                                    <select name="warehouse_id" id="warehouse_id" data-placeholder="- Select -" tabindex="2" class="form-control select2" style="width: 100%" required>
                                        <option></option>
                                        @foreach($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}"
                                                {{ count($warehouses) == 1 ? 'selected' : '' }}
                                                {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}
                                                data-ecom-accounts="{{ $warehouse->ecomAccounts }}"
                                            >
                                                {{ $warehouse->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>





                            <!-- DATE -->
                            <div class="col-md-3">
                                <div class="input-group mb-2 width-100" style="width: 100%">
                                    <span class="input-group-addon" style="width: 20%; text-align: left">
									    Date<span class="label-required">*</span>
                                    </span>
                                    <input type="text" name="date" id="date" tabindex="3" class="form-control date-picker" value="{{ old('date', date('Y-m-d')) }}" autocomplete="off" data-date-format="yyyy-mm-dd" required>
                                </div>
                            </div>





                            <!-- SALE BY -->
                            @if ($isSoldByActive == 1)
                                <div class="col-md-3">
                                    <div class="input-group mb-2 width-100" style="width: 100%">
                                        <span class="input-group-addon" style="width: 20%; text-align: left">
                                            Sale By<span class="label-required">*</span>
                                        </span>
                                        <select name="sold_by" id="sale_by" data-placeholder="- Select -" tabindex="2" class="form-control select2" style="width: 100%" required>
                                            <option></option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ $user->id == auth()->id() ? 'selected' : '' }}
                                                    {{ old('sold_by') == $user->id ? 'selected' : '' }}
                                                >
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                        </div>


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
                        <!-- SALE TABLE -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="invoiceSaleTable">
                                        <thead>
                                            <tr class="table-header-bg">
                                                <th width="25%">Product</th>
                                                <th width="15%">Variation/ Measurement</th>
                                                <th width="10%" class="text-center">Sku</th>
                                                <th width="10%" style="display:none;">Lot</th>
                                                <th width="10%" class="text-center">Stock</th>
                                                <th width="7%">Unit</th>
                                                <th width="10%">Unit Price</th>
                                                <th width="8%" class="text-center">Quantity</th>
                                                <th width="10%">Total</th>
                                                <th width="5%" class="text-center">
                                                    <button type="button" class="btn btn-sm btn btn-info" title="ADD" id="addrow" style="padding: 1px 6px; font-size: 16px;"><i class="fas fa-plus" style=""></i></button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (old('product_id') && count(old('product_id')) > 0)
                                                @foreach (old('product_id') as $key => $value)
                                                    <tr class="{{ $loop->first ? 'first-tr' : 'new-tr' }}">
                                                        <input type="hidden" name="sale_detail_id[]" class="purchase-detail-id" value="">
                                                        <th width="25%">
                                                            <input type="hidden" class="product-is-variation" value="false">
                                                            {{-- <input type="text" class="form-control" value="false"> --}}
                                                            <select name="product_id[]" id="product_id" class="form-control products select2" onchange="getProductVariations(this)" required>
                                                                <option value="" selected>- Select -</option>
                                                                @foreach ($products ?? [] as $product)
                                                                    <option value="{{ $product->id }}"
                                                                        data-category              = "{{ optional($product->category)->name }}"
                                                                        data-is-variation          = "{{ $product->is_variation }}"
                                                                        data-unit-measure          = "{{ optional($product->unitMeasure)->name }}"
                                                                        data-sku                   = "{{ $product->sku }}"
                                                                        data-purchase-price        = "{{ number_format($product->purchase_price, 2, '.', '') }}"
                                                                        data-sale-price            = "{{ number_format($product->sale_price, 2, '.', '') }}"
                                                                        data-sale-discount-percent = "{{ getDiscount($product->id) }}"
                                                                        data-vat-percent           = "{{ getVatPercent($product->vat, $product->vat_type, $product->sale_price, getDiscount($product->id)) }}"
                                                                        {{ old('product_id')[$key] == $product->id ? 'selected' : '' }}
                                                                    >{{ $product->name }} &mdash; {{ $product->code }}</option>
                                                                @endforeach
                                                            </select>
                                                        </th>
                                                        <th width="7%">
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
                                                        <th width="10%" style="display:none;">
                                                            <select name="lot[]" id="lot" class="form-control lots select2" onchange="checkItemExistOrNot(this), getItemStock(this)">
                                                                <option value="" selected>- Select -</option>
                                                                @php
                                                                    $lots = \Module\Product\Models\StockSummary::where([
                                                                        'warehouse_id'          => old('warehouse_id'),
                                                                        'product_id'            => old('product_id')[$key],
                                                                        'product_variation_id'  => old('product_variation_id')[$key],
                                                                    ])
                                                                    ->groupBy('lot')
                                                                    ->pluck('lot');
                                                                @endphp
                                                                @foreach ($lots ?? [] as $lot)
                                                                    <option value="{{ $lot }}" {{ old('lot')[$key] == $lot ? 'selected' : '' }}>{{ $lot }}</option>
                                                                @endforeach
                                                            </select>
                                                        </th>
                                                        <th width="10%">
                                                            <input type="text" name="stock[]" id="stock" class="form-control text-center only-number stock" value="{{ old('stock')[$key] }}" readonly>
                                                        </th>
                                                        <th width="10%">
                                                            <input type="text" name="purchase_price[]" id="purchase_price" class="form-control text-right only-number purchase-price" value="{{ old('purchase_price')[$key] }}" autocomplete="off" required>
                                                            <input type="number" name="sale_price[]" id="sale_price" class="form-control text-right only-number sale-price" value="{{ old('sale_price')[$key] }}" autocomplete="off" onkeyup="calculateRowTotal(this)" required>
                                                        </th>
                                                        <th width="8%">
                                                            <input type="number" name="quantity[]" id="quantity" class="form-control text-center quantity pdt-quantity" value="{{ old('quantity')[$key] }}" autocomplete="off" onkeyup="calculateRowTotal(this)" required>
                                                        </th>
                                                        <th width="10%">
                                                            <input type="text"   name="measurement_title[]"     class="measurement-title"          value="{{ old('measurement_title')[$key] }}">
                                                            <input type="text"   name="measurement_sku[]"       class="measurement-sku"            value="{{ old('measurement_sku')[$key] }}">
                                                            <input type="text"   name="measurement_value[]"     class="measurement-value"          value="{{ old('measurement_value')[$key] }}">
                                                            <input type="hidden" name="vat_amount[]"            class="pdt-vat-amount">
                                                            <input type="hidden" name="vat_percent[]"           class="pdt-vat-percent">
                                                            <input type="hidden" name="purchase_total[]"        class="form-control purchase-total text-right" id="purchase_total" value="{{ old('purchase_total')[$key] }}" readonly>
                                                            <input type="text"   name="total[]"                 class="form-control total text-right" value="{{ old('total')[$key] }}" readonly>
                                                            <input type="hidden" name="discount_percent[]"      class="form-control pdt-discount-percent text-right" id="total" value="{{ old('pdt_discount_percent')[$key] }}" readonly>
                                                            <input type="hidden" name="discount_amount[]" class="form-control pdt-total-discount-amount text-right" value="{{ old('pdt_total_discount_amount')[$key] }}" readonly>
                                                        </th>
                                                        <th width="5%" stylw="text-align:center">
                                                            @if ($loop->first)
                                                                <button type="button" class="btn btn-sm btn-danger remove-row" title="Remove" disabled><i class="fa fa-times"></i></button>
                                                            @else
                                                                <button type="button" class="btn btn-sm btn-danger remove-row" title="Remove"><i class="fa fa-times"></i></button>
                                                            @endif
                                                        </th>
                                                    </tr>
                                                @endforeach
                                            @else

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




                            <div class="col-md-9">
                                <table class="table table-bordered table-striped" id="payment-table" @if(!old('ecom_account_id')) style="display: none" @endif>
                                    <tbody>
                                        @if (old('ecom_account_id'))
                                            @foreach (old('ecom_account_id') as $key => $value)
                                                <tr class="{{ $loop->first ? 'first-tr' : 'new-tr' }}">
                                                    <td style="width: 4%"><span class="sn-no">{{ $loop->iteration }}</span></td>
                                                    <td style="width: 50%">
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <label class="input-group-text">
                                                                    Account
                                                                </label>
                                                            </div>
                                                            <select name="ecom_account_id[]" class="form-control select2 ecom-accounts" style="width: 100%">
                                                                <option value="" selected>- Select -</option>
                                                                @foreach ($accounts as $account)
                                                                    <option value="{{ $account->id }}" {{ old('ecom_account_id')[$key] == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>

                                                    <td style="width: 40%">
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <label class="input-group-text">
                                                                    Amount
                                                                </label>
                                                            </div>
                                                            <input type="text" name="payment_amount[]" class="form-control only-number text-right payment-amount" onkeyup="calculatePaymentAmount()" placeholder="Type amount" value="{{ old('payment_amount')[$key] }}" autocomplete="off">
                                                        </div>
                                                    </td>

                                                    <td class="text-center" style="width: 6%">
                                                        <div class="btn-group">
                                                            @if ($loop->first)
                                                                <a href="javascript:void(0)" class="btn btn-sm btn-info" onclick="addAccount()" type="button">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                            @else
                                                                <a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="removeAccount(this)" type="button">
                                                                    <i class="fas fa-times"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="first-tr">
                                                <td style="width: 4%"><span class="sn-no">1</span></td>
                                                <td style="width: 50%">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <label class="input-group-text">
                                                                Account
                                                            </label>
                                                        </div>
                                                        <select name="ecom_account_id[]" class="form-control select2 ecom-accounts" onchange="checkAccountExistOrNot(this)" style="width: 100%">
                                                            <option value="" selected>- Select -</option>
                                                            @foreach ($accounts as $account)
                                                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </td>

                                                <td style="width: 40%">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <label class="input-group-text">
                                                                Amount
                                                            </label>
                                                        </div>
                                                        <input type="text" name="payment_amount[]" class="form-control only-number text-right payment-amount" onkeyup="calculatePaymentAmount()" placeholder="Type amount" autocomplete="off">
                                                    </div>
                                                </td>

                                                <td class="text-center" style="width: 6%">
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-sm btn-info" onclick="addAccount()" type="button">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-right">
                                                <span class="label label-inverse">
                                                    <strong id="total_payment_amount">0</strong>
                                                </span>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>




                            <div class="col-md-5" style="display:none">
                                <div class="input-group mb-1 width-100" style="width: 100%">
                                    <span class="input-group-addon width-40" style="text-align: left;">
                                        Customer Name
                                    </span>

                                    <input type="text" id="customer_name" name="name" tabindex="3" class="form-control" value="" autocomplete="off" style="width: 253px;" required>
                                </div>
                                <div class="input-group mb-1 width-100" style="width: 100%">
                                    <span class="input-group-addon width-40" style="text-align: left;">
                                        Phone
                                    </span>

                                    <input type="text" id="customer_phone" name="phone" tabindex="3" class="form-control" value="" autocomplete="off" style="width: 253px;" required>
                                </div>
                                <div class="input-group mb-1 width-100" style="width: 100%">
                                    <span class="input-group-addon width-40" style="text-align: left;">
                                        Delivery Address
                                    </span>

                                    <input type="text" name="address" id="selectedAddress" tabindex="3" class="form-control"  autocomplete="off" style="width: 253px;" required>
                                </div>

                                <div class="input-group mb-1 width-100" style="width: 100%">
                                    <span class="input-group-addon width-40" style="text-align: left;">
                                        Zip Code
                                    </span>

                                    <input type="text" id="" name="zip_code" tabindex="3" class="form-control" value="" autocomplete="off" style="width: 253px;">
                                </div>
                                <div class="input-group mb-1 width-100" style="width: 100%">
                                    <span class="input-group-addon width-40" style="text-align: left;">
                                        Country
                                    </span>

                                    <input type="text" name="country" tabindex="3" class="form-control" value="Bangladesh" autocomplete="off" style="width: 253px;">
                                </div>
                                <div class="input-group mb-1 width-100" style="width: 100%">
                                    <span class="input-group-addon width-40" style="text-align: left">
                                        Order Date
                                    </span>
                                    <input type="text" id="delivery_date" name="delivery_date" tabindex="3" style="width: 253px;" class="form-control date-picker" value="{{ date('Y-m-d') }}" autocomplete="off" data-date-format="yyyy-mm-dd" required>
                                </div>
                                <div class="input-group mb-1 width-100" style="width: 100%">
                                    <span class="input-group-addon width-40" style="text-align: left">
                                        Delivery Date
                                    </span>
                                    <input type="text" id="delivery_date" name="delivery_date" tabindex="3" style="width: 253px;" class="form-control date-picker" value="{{ date('Y-m-d') }}" autocomplete="off" data-date-format="yyyy-mm-dd" required>
                                </div>


                                <input type="hidden" class="form-control text-right" name="shipping_cost" id="shipping_cost" value="{{ old('discount_amount') }}" onkeyup="calculateDiscountPercent(this)" placeholder="Amount" autocomplete="off">
                                <input type="hidden" class="form-control text-right" name="customer_id" id="selected_customer_id"  value="{{ old('discount_amount') }}" onkeyup="calculateDiscountPercent(this)" placeholder="Amount" autocomplete="off">


                            </div>















                            <div class="col-md-3">
                                <input type="hidden" class="form-control" name="total_cost" id="total_cost" value="{{ old('total_cost') }}" readonly>

                                {{------------ Shipping Charge -----------}}
                                {{-- <div class="input-group mb-1 width-100">
                                    <span class="input-group-addon" style="width: 40%; text-align: left; padding-left: 3px; padding-right: 1px;">
									    Shipping Charge
                                    </span>
                                    <input type="text" class="form-control text-right" name="shipping_charge" id="shipping_charge" value="{{ old('shipping_charge') }}" readonly required>
                                </div> --}}

                                <div class="input-group mb-1 width-100">
                                    <span class="input-group-addon" style="width: 40%; text-align: left">
									    Subtotal
                                    </span>
                                    <input type="text" class="form-control text-right" name="subtotal" id="subtotal" value="{{ old('subtotal') }}" readonly required>
                                </div>
                                <div class="input-group mb-1 width-100">
                                    <span class="input-group-addon" style="width: 40%; text-align: left">
									    VAT
                                    </span>
                                    <input type="hidden" class="form-control text-right" name="total_vat_percent" id="total_vat_percent" value="{{ old('total_vat_percent') }}" readonly>
                                    <input type="text" class="form-control text-right" name="total_vat_amount" id="total_vat_amount" value="{{ old('total_vat_amount') }}" readonly>
                                </div>
                                <div class="input-group mb-1 width-100">
                                    <span class="input-group-addon" style="width:40%; text-align: left">
									    Discount
                                    </span>
                                    <input type="text" class="form-control text-right" name="total_discount_percent" id="total_discount_percent" value="{{ old('total_discount_percent') }}" onkeyup="calculateDiscountAmount(this)" placeholder="%" autocomplete="off">
                                    <span class="input-group-addon width-10" style="width:10%; text-align: left">
									    <i class="far fa-exchange-alt"></i>
                                    </span>
                                    <input type="text" class="form-control text-right" name="total_discount_amount" id="total_discount_amount" value="{{ old('total_discount_amount') }}" onkeyup="calculateDiscountPercent(this)" placeholder="Amount" autocomplete="off">
                                </div>
                                <div class="input-group mb-1 width-100">
                                    <span class="input-group-addon" style="width: 40%; text-align: left">
									    Rounding
                                    </span>
                                    <input type="text" class="form-control text-right" name="rounding" id="rounding" value="{{ old('rounding') }}" readonly>
                                </div>
                                <div class="input-group mb-1 width-100">
                                    <span class="input-group-addon" style="width: 40%; text-align: left">
									    Payable
                                    </span>
                                    <input type="text" class="form-control text-right" name="payable_amount" id="payable_amount" value="{{ old('payable_amount') }}" readonly required>
                                </div>
                                <div class="input-group mb-1 width-100">
                                    <span class="input-group-addon" style="width: 40%; text-align: left">
									    Paid Amount
                                    </span>
                                    <input type="text" class="form-control text-right" name="paid_amount" id="paid_amount" value="{{ old('paid_amount') }}" autocomplete="off">
                                </div>
                                <div class="input-group mb-1 width-100">
                                    <span class="input-group-addon" style="width: 40%; text-align: left">
									    Due Amount
                                    </span>
                                    <input type="text" class="form-control text-right" name="due_amount" id="due_amount" value="{{ old('due_amount') }}" readonly>
                                </div>
                                <div class="input-group mb-1 width-100">
                                    <span class="input-group-addon" style="width: 40%; text-align: left">
									    Change
                                    </span>
                                    <input type="text" class="form-control text-right" name="change_amount" id="change_amount" value="{{ old('change_amount') }}" readonly>
                                </div>

                                <div class="form-control radio mb-1 bg-dark">
                                    <label>
                                        <input name="radio" value="pos-print" type="radio" class="ace" @if(empty(old('radio')) || old('radio') == 'pos-print') checked @else @endif>
                                        <span class="lbl"> POS Print</span>
                                    </label>

                                    <label>
                                        <input name="radio" value="normal-print" type="radio" class="ace" {{ old('radio') == 'normal-print' ? 'checked' : '' }}>
                                        <span class="lbl"> Normal Print</span>
                                    </label>
                                    <input type="hidden" name="order_source" value="POS">

                                </div>




                                <div class="btn-group width-100">
                                    <button class="btn btn-sm btn-success" style="width: 70%" type="submit" formtarget="_blank"> <i class="fa fa-save"></i> SUBMIT </button>
                                    <a class="btn btn-sm btn-info"  style="width: 29%" href="{{ route('inv.sales.index') }}"> <i class="fa fa-bars"></i> LIST </a>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection





@section('script')
    @include('sales/_inc/script')


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
                                data-sku                   = "${ product.sku }"
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
            addItemOnEnter(_this.find('.live-load-content').find('.search-result'))
        }
        function addItemOnEnter(object) {
            $(object).on('keydown', function () {
                alert('ok')
            })
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

                let discount_percentage = $(this).select2('data')[0].current_discount != null ? $(this).select2('data')[0].current_discount.discount_percentage : ($(this).select2('data')[0].discount_percentage > 0 ? $(this).select2('data')[0].discount_percentage : 0)
                $(this).html(`
                    <option value='${ $(this).select2('data')[0].id }'
                        data-id                    = "${ $(this).select2('data')[0].id }"
                        data-name                  = "${ $(this).select2('data')[0].name }"
                        data-category              = "${ $(this).select2('data')[0].category.name }"
                        data-is-variation          = "${ $(this).select2('data')[0].is_variation }"
                        data-unit-measure          = "${ $(this).select2('data')[0].unit_measure.name }"
                        data-sku                   = "${ $(this).select2('data')[0].sku }"
                        data-purchase-price        = "${ Number($(this).select2('data')[0].purchase_price) }"
                        data-sale-price            = "${ Number($(this).select2('data')[0].sale_price) }"
                        data-sale-discount-percent = "${ discount_percentage }"
                        data-vat-percent           = "${ getVatPercent($(this).select2('data')[0].vat, $(this).select2('data')[0].vat_type, $(this).select2('data')[0].sale_price, 0)}"
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
                    url: `{{ route('get-customers') }}`,
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
                placeholder: 'Search Customer(s)',
                minimumInputLength: 1,
                templateResult: formatCustomer,
                templateSelection: formatCustomerSelection
            }).on('change', function(e) {
                setCustomer($(this).select2('data')[0].id, $(this).select2('data')[0].name, $(this).select2('data')[0].mobile, $(this).select2('data')[0].address);

                $(this).html(`
                    <option value='${ $(this).select2('data')[0].id }'
                        data-name                     = '${$(this).select2('data')[0].name}'
                        data-mobile                   = '${$(this).select2('data')[0].mobile}'
                        data-email                    = '${$(this).select2('data')[0].email}'
                        data-address                  = '${$(this).select2('data')[0].address}'
                        data-zip_code                 = '${$(this).select2('data')[0].zip_code}'
                        data-district_id              = '${$(this).select2('data')[0].district_id}'
                        data-area_id                  = '${$(this).select2('data')[0].area_id}'
                        data-customer_type_id         = '${$(this).select2('data')[0].customer_type_id}'
                        data-is_default               = '${$(this).select2('data')[0].is_default}'
                        data-gender                   = '${$(this).select2('data')[0].gender}'
                        data-user_id                  = '${$(this).select2('data')[0].user_id}'
                        selected
                    > ${ $(this).select2('data')[0].name + ' - ' + $(this).select2('data')[0].mobile }
                    </option>
                `);

            });
            function formatCustomer(customer) {
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
                                        result += `<a onclick='appendData(${myProduct}, ${ variation.sku }, 1)'
                                                    data-id                    = "${ product.id }"
                                                    data-name                  = "${ product.name }"
                                                    data-category              = "${ product.category.name }"
                                                    data-is-variation          = "${ product.is_variation }"
                                                    data-unit-measure          = "${ product.unit_measure.name }"
                                                    data-sku                   = "${ product.sku }"
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
                                                    data-sku                   = "${ measurement.sku }"
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
                                    result += `<a onclick='appendData(${myProduct}, ${ myProduct.sku }, 1)'
                                                data-id                    = "${ product.id }"
                                                data-name                  = "${ product.name }"
                                                data-category              = "${ product.category.name }"
                                                data-is-variation          = "${ product.is_variation }"
                                                data-unit-measure          = "${ product.unit_measure.name }"
                                                data-sku                   = "${ sku }"
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
        function appendData(product, searchedValue, isReadonly)
        {
            let discount_percentage = product.current_discount != null ? product.current_discount.discount_percentage : (product.discount_percentage > 0 ? product.discount_percentage : 0)
            let tr = `<tr class="new-tr">
                    <input type="hidden" name="sale_detail_id[]" class="purchase-detail-id" value="">
                    <th width="25%" style="position: relative;">
                        <input type="hidden" class="product-is-variation" value="${ product.product_variations != '' ? "true" : "false" }">
                        <input type="hidden" class="product-is-measurement" value="${ product.product_measurements != '' ? "true" : "false" }">
                        <select name="product_id[]" id="product_id" class="form-control products product_id-${newKey}" onchange="getProductVariations(this)" required>
                            <option value="${ product.id }"
                                data-category              = "${ product.category.name }"
                                data-is-variation          = "${ product.is_variation }"
                                data-unit-measure          = "${ product.unit_measure.name }"
                                data-sku                   = "${ product.sku }"
                                data-purchase-price        = "${ product.purchase_price }"
                                data-sale-price            = "${ product.sale_price }"
                                data-sale-discount-percent = "${ discount_percentage }"
                                data-vat-percent           = "${ product.vat, product.vat_type, product.sale_price}"
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
                    <th width="10%" style="display: none;">
                        <select name="lot[]" id="lot" class="form-control lots select2" onchange="checkItemExistOrNot(this), getItemStock(this)">
                            <option value="" selected>- Select -</option>
                        </select>
                    </th>
                    <th width="10%">
                        <input type="text" name="stock[]" id="stock" class="form-control text-center only-number stock" value="${ product.stock }" readonly>
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
                        <input type="hidden"   name="discount_amount[]" class="form-control pdt-total-discount-amount text-right">
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
                        row.find('.stock').val(productVariation.variation_stock);
                        console.log(row.find('.stock').val());

                    }
                });
                row.find('.sku-code').val(variationSkuCode);
                if(variationSku == 1){
                    checkItemExistOrNot(row.find('.product-variations'));
                }
            }else{
                if(product.product_measurements != ''){
                    // }
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



        function setCustomer(id, name, phone, address){
            $('#customer_name').val(name);
            $('#selected_customer_id').val(id);
            $('#customer_phone').val(phone);
            $('#selectedAddress').val(address);
        }
    </script>
@endsection
