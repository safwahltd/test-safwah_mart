@extends('layouts.master')

@section('title', 'Product Expired Report')


@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}" />
@endpush

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
                        <td width="20%">
                            <select name="product_variation_id" class="form-control select2" id="product_variation_id" style="width: 100%">
                                <option value="" selected>All Variation</option>

                                @foreach ($productVariations ?? [] as $variation)
                                    <option value="{{ $variation->id }}" {{ request('product_variation_id') == $variation->id ? 'selected' : '' }}>
                                        {{ $variation->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control date-picker" readonly name="expired_date" data-date-format="yyyy-mm-dd" value="{{ request('expired_date', date('Y-m-d')) }}">
                        </td>

                        <td>
                            <select name="expired_type" class="form-control select2" style="width: 100%">
                                <option value="Auto" {{ request('expired_type', 'Auto') == 'Auto' ? 'selected' : '' }}>Auto</option>
                                <option value="Manual" {{ request('expired_type') == 'Manual' ? 'selected' : '' }}>Manual</option>
                            </select>
                        </td>


                        <!-- ACTION -->
                        <td width="20%" class="text-center">
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






    @if(request('expired_type') == 'Manual')
        <div class="row">
            <div class="col-xs-12">
                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    <thead style="border-bottom: 3px solid #346cb0 !important">
                        <tr style="background: #e1ecff !important; color:black !important">
                            <th width="5%" class="text-center">SL</th>
                            <th width="30%">Product</th>
                            <th width="40%" class="text-center">Note</th>
                        </tr>
                    </thead>


                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->expired_note }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    <b class="text-danger">No records found!</b>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-xs-12">
                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    <thead style="border-bottom: 3px solid #346cb0 !important">
                        <tr style="background: #e1ecff !important; color:black !important">
                            <th width="5%" class="text-center">SL</th>
                            <th width="30%">Product</th>
                            <th width="30%">Variation</th>
                            <th width="10%" class="text-center">Non Expired Qty</th>
                            <th width="10%" class="text-center">Stock Qty</th>
                            <th width="10%" class="text-center">Expired Qty</th>
                        </tr>
                    </thead>


                    <tbody>
                        @forelse($itemStocks as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ optional($item->product)->name }}</td>
                                <td>{{ optional($item->productVariation)->name }}</td>
                                <td class="text-center">{{ number_format($item->non_expired_qty ?? 0, 2, '.', '') }}</td>
                                <td class="text-center">{{ number_format($item->balance_qty, 2, '.', '') }}</td>
                                <td class="text-center">{{ number_format($item->balance_qty - $item->non_expired_qty, 2, '.', '') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    <b class="text-danger">No records found!</b>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection


@section('script')

    @include('reports/_inc/script')

@endsection
