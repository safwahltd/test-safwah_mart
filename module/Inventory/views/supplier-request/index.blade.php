@extends('layouts.master')

@section('title', 'Supplier Request')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">

        </div>
    </div>

    @include('partials._alert_message')

    <div class="row">
        {{-- <form action="" method="GET">
            <div class="col-sm-12">
                <table class="table table-bordered">
                    <tr>
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
                    </tr>





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
                            <select name="date_type" id="date_type" class="form-control select2" style="width: 100%">
                                <option value="" selected>Date Type</option>
                                <option value="date" {{ request('date_type') == "date" ? 'selected' : '' }}>Order Date</option>
                                <option value="delivery_date" {{ request('date_type') == "delivery_date" ? 'selected' : '' }}>Delivery Date</option>
                            </select>
                        </td>
                    </tr>





                    <tr>
                          <!-- STATUS -->
                          <td width="33%">
                            <select name="current_status" id="current_status" class="form-control select2" style="width: 100%">
                                <option value="" selected>All Status</option>
                                @foreach($statuses as $id => $name)
                                    <option value="{{ $id }}" {{ request('current_status') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </td>
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
        </form> --}}


        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="table-header-bg">
                            <th width="3%" class="text-center">SL</th>
                            <th width="10%">Name</th>
                            <th width="10%">Mobile</th>
                            <th width="10%">Address</th>
                            <th width="35%">Description</th>
                            <th width="35%">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($orders ?? [] as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->address }}</td>
                                <td>
                                    {{ Str::limit($item->description, 130) }}
                                    <a href="{{ route('inv.supplier-request.show',$item->id) }}" class="text-blue">Continue reading</a>
                                    {{-- @if (mb_strlen($item->description) < 125)
                                        {{ $item->description }}
                                    @else
                                        {{ Str::limit($item->description, 130) }}
                                        <a href="{{ route('inv.supplier-request.show',$item->id) }}" class="text-blue">Continue reading</a>
                                    @endif --}}
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" class="text-danger fas fa-ellipsis-h" type="button" data-toggle="dropdown" style="font-size: 18px"></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                {{-- <a target="_blank" href="{{ URL::to('/').'/'.$item->attachment }}" title="Show"> --}}
                                                <a href="{{ route('inv.supplier-request.show',$item->id) }}" title="Show">
                                                    <i class="fa fa-print"></i> Show
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" title="Delete" onclick="delete_item('{{ route('inv.supplier-request.destroy', $item->id) }}')" type="button">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </li>
                                            {{-- <li>
                                                <a href="{{ route('inv.orders.change-order-status.create', $item->id) }}" title="Show">
                                                    <i class="fas fa-badge-check"></i> Status
                                                </a>
                                            </li>
                                            @if(auth()->user()->type != "Delivery Man")
                                                @if($item->current_status == 1)
                                                    <li>
                                                        <a href="{{ route('inv.orders.edit', $item->id) }}" title="Edit">
                                                            <i class="fa fa-pencil-square-o"></i> Edit
                                                        </a>
                                                    </li>
                                                @endif

                                                <li class="divider"></li>
                                                <li>
                                                    @include('partials._new-user-log', ['data' => $item])
                                                </li>
                                            @endif --}}
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
