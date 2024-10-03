@extends('layouts.master')

@section('title', 'P.O. List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <a class="btn btn-sm btn-primary" href="{{ route('inv.purchases.p-o.create') }}">
            <i class="fa fa-plus-circle"></i>
            Add New
        </a>
    </div>


    <form action="{{ route('inv.purchases.p-o.list') }}" method="GET">
        <div class="row">
            <div class="col-md-3">
                <div class="input-group mb-2 width-100" style="width: 100%">
                    <span class="input-group-addon" style="width: 40%; text-align: left">
                        Supplier
                    </span>
                    <select name="supplier_id" id="supplier_id" class="form-control select2" style="width: 100%">
                        <option value="" selected>- Select -</option>
                        @foreach($suppliers ?? [] as $id => $name)
                            <option value="{{ $id }}" {{ request('supplier_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group mb-2 width-100" style="width: 100%">
                    <span class="input-group-addon" style="width: 40%; text-align: left">
                        Warehouse
                    </span>
                    <select name="warehouse_id" id="warehouse_id" class="form-control select2" style="width: 100%">
                        <option value="" selected>- Select -</option>
                        @foreach($warehouses ?? [] as $id => $name)
                            <option value="{{ $id }}" {{ request('warehouse_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-daterange input-group mb-2">
                    <input type="text" name="from" class="form-control date-picker" value="{{ request('from') }}" autocomplete="off" placeholder="From Date" style="cursor: pointer" data-date-format="yyyy-mm-dd">
                    <span class="input-group-addon">
                        <i class="fa fa-exchange"></i>
                    </span>
                    <input type="text" name="to" class="form-control date-picker" value="{{ request('to') }}" autocomplete="off" placeholder="To Date" style="cursor: pointer" data-date-format="yyyy-mm-dd">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group mb-2 width-100" style="width: 100%">
                    <span class="input-group-addon" style="width: 40%; text-align: left">
                        P.O. No
                    </span>
                    <input type="text" class="form-control" name="p_o_no" value="{{ request('p_o_no') }}" autocomplete="off">
                </div>
            </div>


            
            <div class="row">
                <div class="col-md-12" style="text-align: center">
                    <div class="btn-group mb-2">
                        <button type="submit" class="btn-xs btn-primary"><i class="fa fa-search"></i> SEARCH</button>
                        <button type="button" class="btn-xs btn-dark" style="color: white !important" onclick="location.href='{{ request()->url() }}'">
                            <i class="fal fa-sync-alt"></i> REFRESH
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
    </form>


    @include('partials._alert_message')



    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" >
                    <thead>
                        <tr class="table-header-bg">
                            <th width="5%" class="text-center">SL</th>
                            <th width="10%">P.O. No</th>
                            <th width="15%">Supplier</th>
                            <th width="15%">Warehouse</th>
                            <th width="15%">P.O. Date</th>
                            <th width="10%" class="text-center">Total Qty</th>
                            <th width="15%" class="text-center">Status</th>
                            <th width="15%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($purchases as $purchase)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $purchase->p_o_no }}</td>
                                <td>{{ optional($purchase->supplier)->name }}</td>
                                <td>{{ optional($purchase->warehouse)->name }}</td>
                                <td>{{ $purchase->p_o_date }}</td>
                                <td class="text-center">{{ number_format($purchase->total_quantity, 2, '.', '') }}</td>
                                <td class="text-center">
                                    <div class="badge
                                        @if($purchase->status == 'PO Pending')
                                            label-warning
                                        @elseif($purchase->status == 'PI Pending')
                                            label-warning
                                        @elseif($purchase->status == 'Verified')
                                            label-success
                                        @elseif($purchase->status == 'Approved')
                                            label-primary
                                        @elseif($purchase->status == 'Received')
                                            label-inverse arrowed-in arrowed-in-right
                                        @endif
                                        ">{{ $purchase->status }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-corner">
                                        <span class="btn btn-info btn-xs popover-success"
                                            data-rel="popover"
                                            data-placement="top"
                                            data-trigger="hover"
                                            data-original-title="<i class='ace-icon fa fa-info-circle green'></i> Log Information"
                                            data-content="<div style='width: 220px'>
                                                            <p><b>P.O. Created By:</b> {{ optional($purchase->poCreatedBy)->name }}.</p>
                                                            <p><b>P.I. Created By:</b> {{ optional($purchase->piCreatedBy)->name }}.</p>
                                                            <p><b>Verified By:</b> {{ optional($purchase->verifiedBy)->name }}.</p>
                                                            <p><b>Approved By:</b> {{ optional($purchase->approvedBy)->name }}.</p>
                                                        </div>"
                                            >
                                            <i class="fal fa-info-circle"></i>
                                        </span>


                                        @if ($purchase->verified_by == null)
                                            <a href="{{ route('inv.purchases.p-o.edit', $purchase->id) }}" class="btn btn-xs btn-primary" title="PO Edit">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        @endif


                                        @if($purchase->status == 'PO Pending')
                                            <a href="{{ route('inv.purchases.p-o.verification', $purchase->id) }}" class="btn btn-xs btn-warning" title="PO Verify!">
                                                <i class="fad fa-thumbs-up"></i>
                                            </a>
                                        @elseif($purchase->status == 'Verified')
                                            <a href="javascript:void(0)" class="btn btn-xs btn-success" title="PO Verified">
                                                <i class="fad fa-thumbs-up"></i>
                                            </a>
                                        @endif
                                        
                                        <button type="button" class="btn btn-xs btn-danger" title="Delete" onclick="delete_item('{{ route('inv.purchases.p-o.destroy', $purchase->id) }}')">
                                            <i class="fad fa-trash"></i>
                                        </button>
                                        {{-- 
                                            <a href="javascript:void(0)" class="btn btn-xs
                                                @if($purchase->status == 'PO Pending')
                                                    btn-warning
                                                @elseif($purchase->status == 'PI Pending')
                                                    btn-warning
                                                @elseif($purchase->status == 'Verified')
                                                    btn-success
                                                @elseif($purchase->status == 'Approved')
                                                    btn-primary
                                                @elseif($purchase->status == 'Received')
                                                    btn-black
                                                @endif
                                                "
                                                title="
                                                    @if($purchase->status == 'PO Pending')
                                                        PO Pending
                                                    @elseif($purchase->status == 'PI Pending')
                                                        PI Pending
                                                    @elseif($purchase->status == 'Verified')
                                                        Verified
                                                    @elseif($purchase->status == 'Approved')
                                                        Approved
                                                    @elseif($purchase->status == 'Received')
                                                        Received
                                                    @endif
                                                "
                                                style="cursor: not-allowed;">
                                                <i class="fa fa-check"></i>
                                            </a> --}}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="font-size: 16px" class="text-center text-danger">
                                    NO RECORDS FOUND!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @include('partials._paginate',['data'=> $purchases])
            </div>
        </div>
    </div>
@endsection
