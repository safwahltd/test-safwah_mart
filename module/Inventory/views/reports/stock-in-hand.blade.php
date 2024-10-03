@extends('layouts.master')

@section('title', 'Stock In Hand')

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
                        <td width="25%">
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
                        <td width="30%">
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
                        <td colspan="2">
                            <select name="product_id" class="form-control select2" id="product_id" style="width: 100%" onchange="getProductVariations(this)">
                                <option value="" selected>All Product</option>

                                @foreach ($products ?? [] as $product)
                                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }} data-product-variations="{{ $product->productVariations }}">
                                        {{ $product->name }}
                                        @if ($product->code)
                                            &mdash; {{ $product->code }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>





                    <tr>
                        <!-- VARIATION -->
                        <td width="15%">
                            <select name="product_variation_id" class="form-control select2" id="product_variation_id" style="width: 100%">
                                <option value="" selected>All Variation</option>

                                @foreach ($productVariations ?? [] as $variation)
                                    <option value="{{ $variation->id }}" {{ request('product_variation_id') == $variation->id ? 'selected' : '' }}>
                                        {{ $variation->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>


                        <!-- STOCK RANGE -->
                        <td width="20%">
                            <div class="input-group" style="width: 100%">
                                <input type="text" name="min_stock" class="form-control text-center" autocomplete="off" value="{{ request('min_stock') }}" placeholder="Min Stock">
                                <span class="input-group-addon text-center" style="width: 20%">
                                    TO
                                </span>
                                <input type="text" name="max_stock" class="form-control text-center" autocomplete="off" value="{{ request('max_stock') }}" placeholder="Max Stock">
                            </div>
                        </td>


                        <td style="width: 20%">
                            <select name="expired_type" class="form-control select2" style="width: 100%">
                                <option value="">-All-</option>
                                <option value="Auto" {{ request('expired_type', 'Auto') == 'Auto' ? 'selected' : '' }}>Auto</option>
                                <option value="Manual" {{ request('expired_type') == 'Manual' ? 'selected' : '' }}>Manual</option>
                            </select>
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
            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                <thead style="border-bottom: 3px solid #346cb0 !important">
                    <tr style="background: #e1ecff !important; color:black !important">
                        <th width="5%" class="text-center">SL</th>
                        <th width="30%">Product</th>
                        <th width="30%">Variation</th>
                        <th width="10%" class="text-right">Avg Rate</th>
                        <th width="10%" class="text-center">Stock Qty</th>
                        <th width="15%" class="text-right">Total Stock Value</th>
                    </tr>
                </thead>


                @php
                    $thisPageStock = 0;
                    $thisPageAmount = 0;
                @endphp


                <tbody>
                    @forelse($itemStocks as $item)
                        @php
                            $thisPageStock += $item->balance_qty;
                            $thisPageAmount += $item->total_stock_value;

                            $avg_rate = $item->balance_qty > 0 ? $item->total_stock_value / $item->balance_qty : 0;
                        @endphp

                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ optional($item->product)->name }}</td>
                            <td>{{ optional($item->productVariation)->name }}</td>
                            <td class="text-right">{{ number_format($avg_rate, 2, '.', '') }}</td>
                            <td class="text-center">{{ number_format($item->balance_qty, 2, '.', '') }}</td>
                            <td class="text-right">{{ number_format($item->total_stock_value, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">
                                <b class="text-danger">No records found!</b>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="4" class="text-right"><strong>Total this page: </strong></th>
                        <th class="text-center">{{ number_format($thisPageStock, 2, '.', '') }}</th>
                        <th class="text-right">{{ number_format($thisPageAmount, 2, '.', '') }}</th>
                    </tr>
                    <tr style="background: #ddd !important; color:black !important">
                        <th colspan="4" class="text-right"><strong>Grand Total:</strong></th>
                        <th class="text-center">{{ number_format($totalAvailableStock, 2, '.', '') }}</th>
                        <th class="text-right">{{ number_format($totalStockValue, 2, '.', '') }}</th>
                    </tr>
                </tfoot>
            </table>

            @include('partials._paginate', ['data' => $itemStocks])
        </div>
    </div>
@endsection




@section('script')

    @include('reports/_inc/script')

@endsection
