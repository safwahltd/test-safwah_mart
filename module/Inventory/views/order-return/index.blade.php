@extends('layouts.master')

@section('title', 'Product Return List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">

            <!------------------ CREATE ------------------>
            @if(hasPermission("order-returns.create", $slugs))
            <a class="btn btn-sm btn-primary" href="{{ route('inv.order-returns.create') }}">
                <i class="fa fa-plus-circle"></i>
                Add New
            </a>
            @endif

        </div>
    </div>

    {{-- <form action="{{ route('inv.order-returns.index') }}" method="GET">
        <div style="display: flex; align-items: center; justify-content:center">
            <div class="input-group mb-2 mr-2 width-50">
                <span class="input-group-addon">
                    Title
                </span>
                <input type="text" class="form-control text-center" name="title" placeholder="Title" autocomplete="off" value="{{ request('title') }}">
            </div>
            <div class="text-right">
                <div class="btn-group mb-2">
                    <button type="submit" class="btn btn-sm btn-black" style="height: 33px; width: 35px; border-top-left-radius: 2px; border-bottom-left-radius: 2px"><i class="fa fa-search"></i></button>
                    <button type="button" class="btn btn-sm btn-dark" onclick="location.href='{{ request()->url() }}'" style="height: 33px; width: 35px; border-top-right-radius: 2px; border-bottom-right-radius: 2px"><i class="fa fa-refresh"></i></button>
                </div>
            </div>
        </div>
    </form> --}}

    @include('partials._alert_message')

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" >
                    <thead>
                        <tr class="table-header-bg">
                            <th width="3%" class="text-center">SL</th>
                            <th width="5%">Invoice No</th>
                            <th width="10%">Date</th>
                            <th width="12%">Return At</th>
                            <th width="15%">Customer</th>
                            <th width="8%" class="text-center">Request From</th>
                            <th width="8%" class="text-right">Total Amount</th>
                            <th width="5%" class="text-center">Status</th>
                            <th width="5%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($orderReturns as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->invoice_no }}</td>
                                <td>
                                    {{ $item->date }}
                                </td>
                                <td>
                                    @if ($item->status == 'Pending')
                                        Not Approved
                                    @else
                                        {{ $item->return_date }}
                                        <br>
                                        {{ optional($item->timeSlot)->starting_time . ' - ' . optional($item->timeSlot)->ending_time }}
                                    @endif
                                </td>
                                <td>
                                    {{ optional($item->customer)->name }} -> {{ optional($item->customer)->mobile }}
                                </td>
                                <td class="text-center">
                                    <span class="label
                                        @if(optional($item->requestFrom)->type == 'Admin')
                                            label-info
                                        @elseif (optional($item->requestFrom)->type == 'Customer')
                                            label-primary
                                        @elseif (optional($item->requestFrom)->type == 'Delivery Man')
                                            label-success
                                        @endif
                                    ">
                                        {{ optional($item->requestFrom)->type }}
                                    </span>
                                </td>
                                <td class="text-right">{{ $item->total_amount }}</td>
                                <td class="text-center">
                                    <span class="label
                                        @if($item->status == 'Pending')
                                            label-yellow
                                        @elseif ($item->status == 'Approved')
                                            label-primary
                                        @elseif ($item->status == 'Delivery Start')
                                            label-success
                                        @elseif ($item->status == 'Delivery Done')
                                            label-info
                                        @elseif ($item->status == 'Cancelled')
                                            label-danger
                                        @endif
                                    ">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" class="text-danger fas fa-ellipsis-h" style="font-size: 20px" type="button" data-toggle="dropdown"></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a target="_blank" href="{{ route('inv.order-returns.show', $item->id) }}" title="Show">
                                                    <i class="fa fa-print"></i> Print
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('inv.order-returns.change-status', $item->id) }}" title="Show">
                                                    <i class="fas fa-badge-check"></i> Status
                                                </a>
                                            </li>
                                            <!------------------ DELETE ------------------>
                                            @if(hasPermission("order-returns.delete", $slugs))
                                                <li>
                                                    <a href="javascript:void(0)" title="Delete" onclick="delete_item('{{ route('inv.order-returns.destroy', $item->id) }}')" type="button">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </a>
                                                </li>
                                            @endif
                                            <li class="divider"></li>
                                            <li>
                                                @include('partials._new-user-log', ['data' => $item])
                                            </li>
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

                @include('partials._paginate', ['data'=> $orderReturns])
            </div>
        </div>
    </div>
@endsection
