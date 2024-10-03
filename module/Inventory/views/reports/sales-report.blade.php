@extends('layouts.master')

@section('title', 'Sales Report')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="far fa-analytics"></i> @yield('title')</h4>
    </div>


    <form class="form-horizontal" action="" method="GET">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered">
                    <tr>
                        <!-- CUSTOMER -->
                        <td width="33%">
                            <select name="customer_id" class="form-control select2" id="customer_id" style="width: 100%">
                                <option selected value="">All Customer</option>

                                @foreach ($customers ?? [] as $customer)
                                    <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} &mdash; {{ $customer->phone }}
                                    </option>
                                @endforeach
                            </select>
                        </td>


                        <!-- WAREHOUSE -->
                        <td width="33%">
                            <select name="warehouse_id" class="form-control select2" id="warehouse_id" {{ optional(auth()->user())->warehouse_id != '' ? 'disabled' : '' }} style="width: 100%">
                                <option selected value="">All Warehouse</option>

                                @foreach ($warehouses ?? [] as $id => $name)
                                    <option value="{{ $id }}" {{ request('warehouse_id') == $id ? 'selected' : '' }} {{ optional(auth()->user())->warehouse_id != null ? 'selected' : '' }}>
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
                    </tr>





                    <tr>
                        <!-- ACTION -->
                        <td colspan="3" class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" style="padding-top: 6px; padding-bottom: 6px;"><i class="fa fa-search"></i> SEARCH</button>
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
                        <th class="text-center">SL</th>
                        <th>Date</th>
                        <th>Invoice No</th>
                        <th>Customer Name</th>
                        @if ((hasPermission("show-purchase-price-profit-in-sale-report", $slugs)))
                            <th class="text-right">Purchase Price</th>
                        @endif
                        <th class="text-right">Regular Price</th>
                        <th class="text-right">Discount</th>
                        <th class="text-right">Sale Price</th>
                        @if ((hasPermission("show-purchase-price-profit-in-sale-report", $slugs)))
                            <th class="text-right">Profit</th>
                        @endif
                    </tr>
                </thead>



                <tbody>
                    @php
                        $total_purchase = 0;
                        $sale_price = 0;
                        $total_sale = 0;
                        $total_discount = 0;
                        $total_profit = 0;
                    @endphp

                    @foreach ($sales as $item)
                        @php
                            $total_purchase += $item->total_cost;
                            $sale_price = $item->subtotal - $item->total_discount_amount;
                            $total_sale += $sale_price;
                            $total_discount += $item->total_discount;
                            $total_profit += $sale_price - $item->total_cost;
                        @endphp

                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->date }}</td>
                            <td>
                                <a href="{{ route('inv.sales.show', $item->id) }}" target="_blank">{{ $item->invoice_no }}</a>
                            </td>
                            <td>{{ optional($item->customer)->name }}</td>
                            @if ((hasPermission("show-purchase-price-profit-in-sale-report", $slugs)))
                                <td class="text-right">{{ number_format($item->total_cost, 2) }}</td>
                            @endif
                            <td class="text-right">{{ number_format($item->subtotal, 2) }}</td>
                            <td class="text-right">{{ number_format($item->total_discount_amount, 2) }}</td>
                            <td class="text-right">{{ number_format($sale_price, 2) }}</td>
                            @if ((hasPermission("show-purchase-price-profit-in-sale-report", $slugs)))
                                <td class="text-right">
                                    {{ number_format($sale_price - $item->total_cost, 2) }}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>



                <tfoot>
                    <tr>
                        <th colspan="4" class="text-right">This Page Total</th>
                        @if ((hasPermission("show-purchase-price-profit-in-sale-report", $slugs)))
                            <th class="text-right">{{ number_format($total_purchase, 2) }}</th>
                        @endif
                        <th class="text-right">{{ number_format($sales->sum('subtotal'), 2) }}</th>
                        <th class="text-right">{{ number_format($total_discount, 2) }}</th>
                        <th class="text-right">{{ number_format($total_sale, 2) }}</th>
                        @if ((hasPermission("show-purchase-price-profit-in-sale-report", $slugs)))
                            <th class="text-right">{{ number_format($total_profit, 2) }}</th>
                        @endif
                    </tr>
                    <tr style="background: #ddd !important; color:black !important">
                        <th colspan="4" class="text-right">All Page Total</th>
                        @if ((hasPermission("show-purchase-price-profit-in-sale-report", $slugs)))
                            <th class="text-right">{{ number_format($grand_purchase_price, 2) }}</th>
                        @endif
                        <th class="text-right">{{ number_format($grand_receive_amount, 2) }}</th>
                        <th class="text-right">{{ number_format($grand_discount_amount, 2) }}</th>
                        <th class="text-right">{{ number_format($grand_receive_amount - $grand_discount_amount, 2) }}</th>
                        @if ((hasPermission("show-purchase-price-profit-in-sale-report", $slugs)))
                            <th class="text-right">{{ number_format($grand_total_profit, 2) }}</th>
                        @endif
                    </tr>
                </tfoot>
            </table>


            @include('partials._paginate', ['data' => $sales])
        </div>
    </div>
@endsection
