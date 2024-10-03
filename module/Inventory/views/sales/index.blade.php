@extends('layouts.master')

@section('title', 'Sale List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        @if (hasPermission("sales.create", $slugs))

            <a class="btn btn-sm btn-primary" href="{{ route('inv.sales.create') }}">
                <i class="fa fa-plus-circle"></i>
                Add New
            </a>

        @endif
    </div>





    @include('partials._alert_message')



    <div class="row">
        <form action="{{ route('inv.sales.index') }}" method="GET">
            <div class="col-sm-12">
                <table class="table table-bordered">
                    <tr>
                        <!-- WAREHOUSE -->
                        <td width="25%">
                            <select name="warehouse_id" id="warehouse_id" class="form-control select2" style="width: 100%">
                                <option value="" selected>All Warehouse</option>
                                @foreach($warehouses ?? [] as $id => $name)
                                    <option value="{{ $id }}" {{ request('warehouse_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </td>


                        <!-- CUSTOMER -->
                        <td width="25%">
                            <select name="customer_id" id="customer_id" class="form-control select2" style="width: 100%">
                                <option value="" selected>All Customer</option>
                                @foreach($customers ?? [] as $id => $name)
                                    <option value="{{ $id }}" {{ request('customer_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </td>


                        <!-- DATE RANGE -->
                        <td width="25%">
                            <div class="input-group">
                                <input type="text" class="form-control date-picker text-center" name="from_date" value="{{ request('from_date') }}" autocomplete="off" placeholder="From Date" data-date-format="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fas fa-exchange"></i></span>
                                <input type="text" class="form-control date-picker text-center" name="to_date" value="{{ request('to_date') }}" autocomplete="off" placeholder="To Date" data-date-format="yyyy-mm-dd">
                            </div>
                        </td>


                        <!-- DATE RANGE -->
                        <td width="25%">
                            <input type="text" class="form-control" name="invoice_no" value="{{ request('invoice_no') }}" placeholder="Invoice No" autocomplete="off">
                        </td>
                    </tr>





                    <tr>
                        <!-- ACTION -->
                        <td colspan="4" class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" style="padding-top: 6px; padding-bottom: 6px;"><i class="fa fa-search"></i> SEARCH</button>
                                <a href="{{ request()->url() }}" class="btn btn-sm btn-light" style="width: 49%; padding-top: 6px; padding-bottom: 6px;"><i class="fa fa-refresh"></i> REFRESH</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </form>




        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" >
                    <thead>
                        <tr class="table-header-bg">
                            <th width="5%" class="text-center">SL</th>
                            <th width="15%">Invoice No</th>
                            <th width="15%">Customer</th>
                            <th width="10%">Date</th>
                            <th width="10%" class="text-center">Total Qty</th>
                            <th width="10%" class="text-right">Payable</th>
                            <th width="10%" class="text-right">Paid</th>
                            <th width="10%" class="text-right">Due</th>
                            <th width="10%" class="text-right">Change</th>
                            <th width="5%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($sales as $sale)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $sale->order_no }}</td>
                                <td>{{ optional($sale->customer)->name }} <br> <b>{{ optional($sale->customer)->mobile }}</b></td>
                                <td>{{ $sale->date }}</td>
                                <td class="text-center">{{ number_format($sale->total_quantity, 2, '.', '') }}</td>
                                <td class="text-right">{{ number_format($sale->payable_amount, 2, '.', '') }}</td>
                                <td class="text-right">{{ number_format($sale->paid_amount, 2, '.', '') }}</td>
                                <td class="text-right">{{ number_format($sale->due_amount, 2, '.', '') }}</td>
                                <td class="text-right">{{ number_format($sale->change_amount, 2, '.', '') }}</td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" class="text-danger fas fa-ellipsis-h" type="button" data-toggle="dropdown"></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                {{-- <a title="Show Detail" href="{{ route('inv.sales.show', $sale->id) . '?print_type=normal-print' }}" target="_blank">
                                                    <i class="fa fa-eye"></i> Show
                                                </a> --}}
                                                <a title="Show Detail" href="{{ route('inv.orders.show', $sale->id) . '?print_type=normal-print' }}" target="_blank">
                                                    <i class="fa fa-eye"></i> Show
                                                </a>
                                            </li>
                                            @if (hasPermission("sales.print", $slugs))
                                                <li>
                                                    {{-- <a title="Print" href="{{ route('inv.sales.show', $sale->id) . '?print_type=pos-print' }}" target="_blank">
                                                        <i class="fa fa-print"></i> Print
                                                    </a> --}}
                                                    <a title="Print" href="{{ route('inv.orders.show', $sale->id) . '?print_type=pos-print' }}" target="_blank">
                                                        <i class="fa fa-print"></i> POS Print
                                                    </a>
                                                </li>
                                            @endif
                                            @if (hasPermission("sales.print", $slugs))
                                                <li>
                                                    <a title="Print" href="{{ route('inv.orders.show', $sale->id) . '?print_type=normal-print' }}" target="_blank">
                                                        <i class="fa fa-print"></i> Normal Print
                                                    </a>
                                                </li>
                                            @endif

                                            @if (hasPermission("sales.delete", $slugs))
                                                <li>
                                                    {{-- <a href="javascript:void(0)" type="button" title="Delete" onclick="delete_item('{{ route('inv.sales.destroy', $sale->id) }}')">
                                                        <i class="fad fa-trash"></i> Delete
                                                    </a> --}}
                                                    <a href="javascript:void(0)" type="button" title="Delete" onclick="delete_item('{{ route('inv.orders.destroy', $sale->id) }}')">
                                                        <i class="fad fa-trash"></i> Delete
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="30" style="font-size: 16px" class="text-center text-danger">
                                    NO RECORDS FOUND!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @include('partials._paginate', ['data'=> $sales])
            </div>
        </div>
    </div>
@endsection
