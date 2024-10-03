@extends('layouts.master')
@section('css')

{{-- <style>
    fieldset {
        overflow: hidden
        }
        
        .some-class {
        float: left;
        clear: none;
        }
        
        label {
        float: left;
        clear: none;
        display: block;
        padding: 0px 1em 0px 8px;
        }
        
        input[type=radio],
        input.radio {
        float: left;
        clear: none;
        margin: 2px 0 0 2px;
        }
</style> --}}

<style>
    [type="radio"]:checked,
    [type="radio"]:not(:checked) {
        position: absolute;
        left: -9999px;
    }
    [type="radio"]:checked + label,
    [type="radio"]:not(:checked) + label
    {
        position: relative;
        padding-left: 28px;
        cursor: pointer;
        line-height: 20px;
        display: inline-block;
        color: #666;
    }
    [type="radio"]:checked + label:before,
    [type="radio"]:not(:checked) + label:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 18px;
        height: 18px;
        border: 1px solid #ddd;
        border-radius: 100%;
        background: #fff;
    }
    [type="radio"]:checked + label:after,
    [type="radio"]:not(:checked) + label:after {
        content: '';
        width: 12px;
        height: 12px;
        background: #5a1ee8;
        position: absolute;
        top: 4px;
        left: 4px;
        border-radius: 100%;
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
    }
    [type="radio"]:not(:checked) + label:after {
        opacity: 0;
        -webkit-transform: scale(0);
        transform: scale(0);
    }
    [type="radio"]:checked + label:after {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1);
    }
</style>

@endsection
@section('title', 'Monthly Order')

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
                            <input type="text" class="form-control date-picker" name="month" value="{{ request('month') }}" placeholder="Select Month">

                            {{-- <div class="input-group">
                                <input type="text" class="form-control date-picker text-center" name="from_date" value="{{ request('from_date') }}" autocomplete="off" placeholder="From Date" data-date-format="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fas fa-exchange"></i></span>
                                <input type="text" class="form-control date-picker text-center" name="to_date" value="{{ request('to_date') }}" autocomplete="off" placeholder="To Date" data-date-format="yyyy-mm-dd">
                            </div> --}}
                        </td>
                        




                        <!-- STATUS -->
                        <td width="33%">
                            {{-- <label for="html" style="font-size; 16 px; font-weight:600;">Date Type : </label>

                            <input class="ml-1" type="radio" id="html" name="date_type" id="date_type" value="">
                            <label for="html">All</label>
                            <input class="ml-1" type="radio" id="html" name="date_type" id="date_type" value="date" {{ request('date_type') == "date" ? 'checked' : '' }} checked>
                            <label for="html">Order</label>
                            <input class="ml-1" type="radio" id="html" name="date_type" id="date_type" value="delivery_date" {{ request('date_type') == "delivery_date" ? 'selected' : '' }}>
                            <label for="html">Delivery</label> --}}
                            <p>
                                <label for="html" style="font-size; 16 px; font-weight:600;">Type : </label>
                                <input type="radio" id="test1" name="date_type" value="" checked>
                                <label for="test1">All</label>
                                <input type="radio" id="test2" name="date_type" value="date" {{ request('date_type') == "date" ? 'checked' : '' }} >
                                <label for="test2">Order</label>
                                <input type="radio" id="test3" name="date_type" value="delivery_date" {{ request('date_type') == "delivery_date" ? 'checked' : '' }}>
                                <label for="test3">Delivery</label> 
                            </p>
                            
                            {{-- <select name="date_type" id="date_type" class="form-control select2" style="width: 100%">
                                <option value="" selected>Date Type</option>
                                <option value="date" {{ request('date_type') == "date" ? 'selected' : '' }}>Order Date</option>
                                <option value="delivery_date" {{ request('date_type') == "delivery_date" ? 'selected' : '' }}>Delivery Date</option>
                            </select> --}}
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
        </form>



        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="table-header-bg">
                            <th width="3%" class="text-center">SL</th>
                            <th width="10%">Order No</th>
                            <th width="10%">Order At</th>
                            <th width="17%">Delivery At</th>
                            <th width="23%">Customer</th>
                            <th width="11%" class="text-right">Total Amount</th>
                            {{-- <th width="11%" class="text-center">Payment Type</th>
                            <th width="7%" class="text-center">Source</th>
                            <th width="10%" class="text-center">Status</th> --}}
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $total = 0;         
                        @endphp
                        @foreach ($orders as $item)
                            @php
                                $total += number_format($grandTotal, 2, '.', '') ;         
                            @endphp
                            <tr>
                                <td class="text-center">{{ $orders->firstItem()+$loop->index }}</td>
                                <td>{{ $item->order_no }}</td>
                                <td>
                                    {{ date('Y-m-d g:i A', strtotime($item->created_at)) }}
                                </td>
                                <td>
                                    {{ $item->delivery_date }}
                                    <br>
                                    {{ optional($item->timeSlot)->starting_time . ' - ' . optional($item->timeSlot)->ending_time }}
                                </td>
                                <td>
                                    {{ optional($item->customer)->name }} -> <b>{{ optional($item->customer)->mobile }}</b>
                                </td>
                                <td class="text-right">{{ number_format($item->grand_total, 2, '.', '') }}</td>
                                {{-- <td class="text-center">
                                    <span class="label arrowed-in arrowed-in-right
                                        @if($item->payment_type == 'COD')
                                            label-yellow
                                        @elseif ($item->payment_type == 'Online')
                                            label-primary
                                        @elseif ($item->payment_type == 'Self Receive')
                                            label-success
                                        @endif
                                    ">{{ $item->payment_type }}</span>
                                </td> --}}
                                {{-- <td class="text-center">
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
                                </td> --}}
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
                                
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" style="text-align: right;">Total : </td>
                            <td colspan="5" style="text-align: right;">{{ $total }} TK</td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: right;">Grand Total : </td>
                            <td colspan="5" style="text-align: right;">{{ number_format($orders->sum('grand_total'), 2, '.', '') }} TK</td>
                        </tr>
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

        $('.date-picker').datepicker({
            autoclose: true,
            format:'yyyy-mm',
            viewMode: "months",
            minViewMode: "months",
        })
    </script>
@endsection
