@extends('layouts.master')

@section('title', 'Order List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
          
        </div>
    </div>

    @include('partials._alert_message')

    <div class="row">
        <form action="" method="GET">
            <div class="col-sm-12">
                <table class="table table-bordered">
                    {{-- <tr>
                        <!-- DISTRICT -->
                        <td width="33%">
                            <select name="district_id" id="district_id" class="form-control select2" style="width: 100%">
                                <option value="">All District</option>
                                @foreach($districts as $id => $name)
                                    <option value="{{ $id }}" {{ request('district_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>


                        


                        <!-- AREA -->
                        <td width="34%">
                            <select name="area_id" id="area_id" class="form-control select2" style="width: 100%">
                                <option value="">All Area</option>
                                @foreach($areas as $id => $name)
                                    <option value="{{ $id }}" {{ request('area_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>





                        <!-- CUSTOMER -->
                        <td width="33%">
                            <select name="customer_id" id="customer_id" class="form-control select2" style="width: 100%">
                                <option value="">All Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} -> {{ $customer->mobile }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr> --}}



                    <tr>
                        <!-- ORDER NO -->
                        <td width="33%">
                            <input type="text" class="form-control" name="order_no" value="{{ request('order_no') }}" placeholder="Order No">
                        </td>


                        


                        <!-- DATE RANGE -->
                        <td width="34%">
                            <div class="input-group">
                                <input type="text" class="form-control date-picker text-center" name="from_date" value="{{ request('from_date') }}" autocomplete="off" placeholder="From Date" data-date-format="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fas fa-exchange"></i></span>
                                <input type="text" class="form-control date-picker text-center" name="to_date" value="{{ request('to_date') }}" autocomplete="off" placeholder="To Date" data-date-format="yyyy-mm-dd">
                            </div>
                        </td>
                        




                        <!-- STATUS -->
                        <td width="33%">
                            <select name="current_status" id="current_status" class="form-control select2" style="width: 100%">
                                <option value="" selected>All Status</option>
                                @foreach($statuses as $id => $name)
                                    <option value="{{ $id }}" {{ request('current_status') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
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



        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="table-header-bg">
                            <th width="3%" class="text-center">SL</th>
                            <th width="10%">Order No</th>
                            <th width="10%">Date</th>
                            <th width="35%">Customer</th>
                            <th width="10%" class="text-right">Total Amount</th>
                            <th width="10%" class="text-center">Payment Type</th>
                            <th width="7%" class="text-center">Source</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="5%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($orders as $item)
                            <tr>
                                <td class="text-center">{{ $orders->firstItem()+$loop->index }}</td>
                                <td>{{ $item->order_no }}</td>
                                <td>{{ $item->date }}</td>
                                <td>
                                    {{ optional($item->customer)->name }} -> <b>{{ optional($item->customer)->mobile }}</b>
                                </td>
                                <td class="text-right">{{ number_format($item->grand_total, 2, '.', '') }}</td>
                                <td class="text-center">
                                    <span class="label arrowed-in arrowed-in-right
                                        @if($item->payment_type == 'COD')
                                            label-yellow
                                        @elseif ($item->payment_type == 'Online')
                                            label-primary
                                        @endif
                                    ">{{ $item->payment_type }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="label
                                        @if($item->order_source == 'App')
                                            label-info
                                        @elseif ($item->order_source == 'Website')
                                            label-success
                                        @endif
                                    ">{{ $item->order_source }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="label arrowed arrowed-right
                                        @if($item->current_status == 1)
                                            label-yellow
                                        @elseif ($item->current_status == 2)
                                            label-primary
                                        @elseif ($item->current_status == 3)
                                            label-process
                                        @elseif ($item->current_status == 4)
                                            label-info
                                        @elseif ($item->current_status == 5)
                                            label-success
                                        @elseif ($item->current_status == 6)
                                            label-danger
                                        @endif
                                    ">{{ optional($item->currentStatus)->name }}</span>
                                </td>
                                {{-- <td>
                                    <div style="display: flex; justify-content: space-between;">
                                        <select class="form-control select2" name="type" id="orderStatus" data-placeholder="- Select -" style="width: 100%">
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->id }}" {{ $item->current_status == $status->id ? 'selected' : ''}}>{{ $status->name }}</option>
                                            @endforeach
    
                                        </select>
                                        <button class="btn btn-sm btn-primary" style="margin-left:2px" onclick="orderStatusChange({{ $item->id }})"> <i class="fa fa-save"></i> Update </button>
                                    </div>
                                </td> --}}
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" class="text-danger fas fa-ellipsis-h" type="button" data-toggle="dropdown" style="font-size: 18px"></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a target="_blank" href="{{ route('inv.orders.show', $item->id) }}" title="Show">
                                                    <i class="fa fa-print"></i> Print
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('inv.orders.change-order-status.create', $item->id) }}" title="Show">
                                                    <i class="fas fa-badge-check"></i> Status
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                @include('partials._new-user-log', ['data' => $item])
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @include('partials._paginate', ['data'=> $orders])
                
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function cantDeleteAlert() {
            Swal.fire('<p style="font-size:15px;">You can\'t delete this Product. Because there are one or more time Purchased this Product.</p>')
        }

        function orderStatusChange(orderId){
            let statusId = $('#orderStatus').val();

            var url = '{{ route("update-order-status", ["order_id", "status_id"]) }}';
            url = url.replace('order_id', orderId);
            url = url.replace('status_id', statusId);

            document.location.href = url;     
        }
    </script>
@endsection
