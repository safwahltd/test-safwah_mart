@extends('layouts.master')

@section('title', 'Item Ledger')


@section('css')
<style>
    .bg-header {
        background: #d1e2fe !important;
        color: #000000 !important;
        border: 2px solid #d1d1d1 !important;
    }

    .bg-opening {
        background: #def2ff !important;
        color: #000000 !important;
        border: 2px solid #d1d1d1 !important;
    }

    .bg-stock-in {
        background: #f3fff1 !important;
        color: #000000 !important;
        border: 2px solid #d1d1d1 !important;
    }

    .bg-stock-out {
        background: #fff4f3 !important;
        color: #000000 !important;
        border: 2px solid #d1d1d1 !important;
    }

    .bg-closing {
        background: #d8ddff !important;
        color: #000000 !important;
        border: 2px solid #d1d1d1 !important;
    }
</style>
@endsection


@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="far fa-analytics"></i> @yield('title')</h4>
    </div>


    <form class="form-horizontal" action="" method="GET">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered">
                    <tr>
                        <!-- WAREHOUSE -->
                        <td width="33%">
                            <select name="warehouse_id" class="form-control select2" id="warehouse_id" {{ auth()->user()->warehouse_id != '' ? 'disabled' : '' }} style="width: 100%">
                                <option selected value="">All Warehouse</option>

                                @foreach ($warehouses as $id => $name)
                                    <option value="{{ $id }}" {{ request('warehouse_id') == $id ? 'selected' : '' }} {{ auth()->user()->warehouse_id != null ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>


                        <!-- CATEGORY -->
                        <td width="34%">
                            <select name="category_id" id="category_id" class="form-control select2" onchange="getProducts(this)" style="width: 100%">
                                <option value="" selected data-products="{{ $products }}">All Category</option>
                                @foreach ($categories ?? [] as $parentCategory)
                                    <option value="{{ $parentCategory->id }}" 
                                        {{ request('category_id') == $parentCategory->id ? 'selected' : '' }}>
                                        {{ $parentCategory->name }}
                                    </option>


                                    @foreach ($parentCategory->childCategories ?? [] as $childCategory)
                                        <option value="{{ $childCategory->id }}"
                                            {{ request('category_id') == $childCategory->id ? 'selected' : '' }}>
                                            &nbsp;&raquo;&nbsp;{{ $childCategory->name }}
                                        </option>

                                        @include('category/_inc/_search-options', ['childCategory' => $childCategory, 'space' => 1])
                                    @endforeach
                                @endforeach
                            </select>
                        </td>


                        <!-- PRODUCT -->
                        <td width="33%" colspan="2">
                            <select name="product_id" class="form-control select2" id="product_id" style="width: 100%" onchange="getProductVariations(this)">
                                <option value="" selected>All Product</option>

                                @foreach ($products ?? [] as $product)
                                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} 
                                        @if ($product->sku)
                                            &mdash; {{ $product->sku }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>





                    <tr>
                        <!-- VARIATION -->
                        <td width="33%">
                            <select name="product_variation_id" class="form-control select2" id="product_variation_id" style="width: 100%">
                                <option value="" selected>All Variation</option>

                                @foreach ($productVariations ?? [] as $id => $name)
                                    <option value="{{ $id }}" {{ request('product_variation_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>


                        <!-- DATE RANGE -->
                        <td width="34%">
                            <div class="input-group">
                                <input type="text" class="form-control date-picker text-center" name="from_date" value="{{ request('from_date') }}" autocomplete="off" placeholder="From Date" data-date-format="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fas fa-exchange"></i></span>
                                <input type="text" class="form-control date-picker text-center" name="to_date" value="{{ request('to_date') }}" autocomplete="off" placeholder="To Date" data-date-format="yyyy-mm-dd">
                            </div>
                        </td>


                        <!-- ACTION -->
                        <td width="33%" class="text-center">
                            <div class="btn-group width-100">
                                <button class="btn btn-sm btn-primary width-50" style="padding-top: 6px; padding-bottom: 6px;"><i class="fa fa-search"></i> SEARCH</button>
                                <a href="{{ request()->url() }}" class="btn btn-sm btn-light" style="width: 49%; padding-top: 6px; padding-bottom: 6px;"><i class="fa fa-refresh"></i> REFRESH</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </form>






    <div class="row">
        <div class="col-xs-12">
            <table class="table table-bordered table-striped table-hover" style="font-size: 11px; font-weight: 600">
                <thead style=" border: 2px solid #ffffff !important; border-bottom: 3px solid #346cb0 !important;">
                    <tr>
                        <th class="text-center bg-header" rowspan="2">Date</th>
                        <th class="text-center bg-opening" colspan="3"quantity>Opening Balance</th>
                        <th class="text-center bg-stock-in" colspan="4"quantity>Stock In</th>
                        <th class="text-center bg-stock-out" colspan="4"quantity>Stock Out</th>
                        <th class="text-center bg-closing" colspan="3"quantity>Closing Balance</th>
                    </tr>
                    <tr>
                        <th class="bg-opening text-center">Quantity</th>
                        <th class="bg-opening text-center">Pur. Price</th>
                        <th class="bg-opening text-right">Amount</th>
                        <th class="bg-stock-in">Invoice No</th>
                        <th class="bg-stock-in text-center">Quantity</th>
                        <th class="bg-stock-in text-center">Pur. Price</th>
                        <th class="bg-stock-in text-right">Amount</th>
                        <th class="bg-stock-out">Invoice No</th>
                        <th class="bg-stock-out text-center">Quantity</th>
                        <th class="bg-stock-out text-center">Purchase Price</th>
                        <th class="bg-stock-out text-right">Amount</th>
                        <th class="bg-closing text-center">Quantity</th>
                        <th class="bg-closing text-center">Rate</th>
                        <th class="bg-closing text-right">Amount</th>
                    </tr>
                </thead>

                <tbody>
                    @if (isset($itemStockDetails))
                        @php
                            $opening_cost = 0;
                            $last_closing_qty = 0;
                        @endphp


                        @foreach($itemStockDetails as $key => $detail)
                            @php
                                $opening_qty      = 0;
                                $opening_price    = 0;
                                $stock_in_qty     = 0;
                                $stock_in_price   = 0;
                                $stock_out_qty    = 0;
                                $stock_out_price  = 0;
                            @endphp
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($detail->date)->format('Y-m-d') }}</td>
                                @if (in_array($detail->stockable_type, ["Product Opening By Product", "Product Opening By Product Variation"]) && $detail->stock_type == 'In')
                                    @php
                                        $opening_qty = $detail->quantity;
                                        $opening_price = $detail->purchase_price;
                                    @endphp
                                    <td class="text-center">{{ number_format($detail->quantity ?? 0, 2, '.', '')  }}</td>
                                    <td class="text-right">{{ number_format($detail->purchase_price, 2, '.', '') }}</td>
                                    <td class="text-right">{{ number_format($detail->quantity * $detail->purchase_price, 2, '.', '') }}</td>
                                @else
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                @endif

                                @if (in_array($detail->stockable_type, ["Direct Purchase"]) && $detail->stock_type == 'In')
                                    @php
                                        $stock_in_qty = $detail->quantity;
                                        $stock_in_price = $detail->purchase_price;
                                    @endphp    
                                    <td>{{ $detail->ref_no }}</td>
                                    <td class="text-center">{{ number_format($detail->quantity, 2, '.', '') }}</td>
                                    <td class="text-right">{{ number_format($detail->purchase_price, 2, '.', '') }}</td>
                                    <td class="text-right">{{ number_format($detail->quantity * $detail->purchase_price, 2, '.', '')  }}</td>
                                @else
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                @endif


                                @if (in_array($detail->stockable_type, ["POS Sale", "Order"]) && $detail->stock_type == 'Out')
                                    @php
                                        $stock_out_qty = $detail->quantity;
                                        $stock_out_price = $detail->sale_price;
                                    @endphp
                                    <td class="text-center">{{ $detail->ref_no }}</td>
                                    <td class="text-center">{{ number_format($detail->quantity, 2, '.', '') }}</td>
                                    <td class="text-right">{{ number_format($detail->purchase_price, 2, '.', '') }}</td>
                                    <td class="text-right">{{ number_format(($detail->quantity * $detail->purchase_price), 2, '.', '') }}</td>
                                @else
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                @endif

                                @php
                                    $closing_qty      = $last_closing_qty + $opening_qty + $stock_in_qty - $stock_out_qty;
                                    $last_closing_qty = $closing_qty;

                                    $closing_amount = (($opening_qty * $opening_price) + ($stock_in_qty * $stock_in_price) - ($stock_out_qty * $stock_out_price));
                                    
                                    if ($closing_qty != 0) {
                                        $closing_rate = $closing_amount / $closing_qty;
                                    } else {
                                        $closing_rate = 0;
                                        $closing_amount = 0;
                                    }

                                    $opening_qty     = $closing_qty;
                                    $opening_cost    = $closing_rate;
                                    $opening_amount  = $closing_amount;
                                @endphp

                                <td class="text-center">{{ number_format($closing_qty ?? 0, 2, '.', '') }}</td>
                                <td class="text-right">{{ number_format($closing_rate, 2, '.', '') }}</td>
                                <td class="text-right">{{ number_format($closing_amount, 2, '.', '') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="15" class="text-center">
                                <b class="text-danger">No records found!</b>
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>

            @include('partials._paginate', ['data' => $itemStockDetails])
        </div>
    </div>
@endsection




@section('script')

    <script>
        $(document).ready(function () {
            $('#sidebar').addClass('menu-min');
        })
    </script>
    
    @include('reports/_inc/script')

@endsection
