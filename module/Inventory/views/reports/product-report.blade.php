@extends('layouts.master')

@section('title', 'Product Report')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            <a class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="excel()">
                <i class="fa fa-file-excel-o"></i>
                Excel
            </a>
            <a class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="pdf()">
                <i class="fa fa-file-pdf-o"></i>
                PDF
            </a>
        </div>
    </div>


    <form id="filterForm" class="form-horizontal" action="" method="GET">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered">
                    <tr>

                        <!-- PRODUCT -->
                        <td width="34%">
                            <select name="product_id" class="form-control select2" id="product_id" style="width: 100%">
                                <option selected value="">Select All Product</option>

                                @foreach ($products ?? [] as $product)
                                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <input name="type" type="hidden" id="typeId">

                        <!-- ORDER DATE -->
                        <td width="33%">
                            <input type="text" class="form-control date-picker text-center" name="date" id="date" value="{{ request('date') }}" autocomplete="off" placeholder="Order Date" data-date-format="yyyy-mm-dd">
                        </td>

                        <!-- DELIVERY DATE -->
                        <td width="33%">
                            <input type="text" class="form-control date-picker text-center" name="delivery_date" id="delivery_date" value="{{ request('delivery_date') }}" autocomplete="off" placeholder="Delivery Date" data-date-format="yyyy-mm-dd">
                        </td>
                    </tr>


                    <tr>
                        @if($productWiseUser == 1)
                            <!-- PRODUCT -->
                            <td width="34%">
                                <select name="user_id" class="form-control select2" id="user_id" style="width: 100%">
                                    <option selected value="">Select All User</option>

                                    @foreach ($users ?? [] as $user)
                                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        @endif
                        <!-- ACTION -->
                        <td colspan="{{ $productWiseUser == 1 ? 2 : 3 }}" class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" style="padding-top: 6px; padding-bottom: 6px;" type="button" onclick="search()"><i class="fa fa-search"></i> SEARCH</button>
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
                        <th class="text-center">Product Name</th>
                        <th class="text-center">Unit</th>
                        <th class="text-right">Order Quantity</th>
                        <th class="text-right">Stock Quantity</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $total_order_quantity = 0;
                        $total_stock_quantity = 0;

                    @endphp
                    @if (request()->has('product_id'))
                        @forelse ($product_orders as $item)


                            @php
                            $totalQuantity = 0;

                            foreach($item->orderDetails as $orderDetail){
                                $measurement_value = $orderDetail->measurement_value != 0 ? $orderDetail->measurement_value : 1;
                                $totalQuantity += $measurement_value * $orderDetail->quantity;
                            }
                                // $total_order_quantity += $item->order_details_sum_quantity;

                                $total_order_quantity += $totalQuantity;
                                $total_stock_quantity += $item->stock_summaries_sum_balance_qty;
                            @endphp
                            <tr>
                                <td class="text-center"> {{ $item->name }} </td>
                                <td class="text-center"> {{ $item->sub_text != null ? $item->sub_text. ' ' . $item->unitMeasure->name : $item->unitMeasure->name }}</td>
                                {{-- <td class="text-right">{{ number_format($item->order_details_sum_quantity, 2) }} </td> --}}
                                <td class="text-right">{{ $totalQuantity }} </td>
                                <td class="text-right">{{ number_format($item->stock_summaries_sum_balance_qty, 2) }}</td>
                            </tr>
                        @empty
                            <tr colspan="50">
                                <td></td>
                                <td style="color: red; text-align:center">No Data to Show!</td>
                                <td></td>
                            </tr>
                        @endforelse
                    @else
                        <tr colspan="50">
                            <td></td>
                            <td style="color: red; text-align:center">No Data to Show!</td>
                            <td></td>
                        </tr>
                    @endif

                </tbody>
                <tfoot>
                    <tr style="background: #ddd !important; color:black !important">
                        <th colspan="2" class="text-right">Total</th>
                        <th class="text-right">{{ number_format($total_order_quantity, 2) }}</th>
                        <th class="text-right">{{ number_format($total_stock_quantity, 2) }}</th>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
@endsection
@section('script')
    <script>
        function excel() {
            $("#typeId").val("Excel");
            $('#filterForm').submit();
        }

        function pdf() {
            $("#typeId").val("PDF");
            $('#filterForm').submit();
        }

        function search(){
            $("#typeId").val("");
            $('#filterForm').submit();
        }
    </script>
@endsection
