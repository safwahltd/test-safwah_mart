@extends('layouts.master')
@section('title', 'Change Order Status')


@section('css')
    
@endsection


@section('content')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <h4 class="pl-2"><i class="far fa-edit"></i> @yield('title')</h4>

    <ul class="breadcrumb mb-1">
        <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
        <li>Order</li>
        <li><a class="text-muted" href="{{ route('inv.order-returns.index') }}">Product Return</a></li>
        <li>Change Status</li>
    </ul>
</div>

    <div class="row">
        <div class="widget-body">
            <div class="widget-main">

                @include('partials._alert_message')

                <form class="form-horizontal" action="{{ route('inv.order-returns.update-status', $orderReturn->id) }}" method="POST">
                    @csrf


                    <!-- OFFER ITEMS TABLE -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="purchaseTable">
                                    <thead style="border-bottom: 3px solid #346cb0 !important">
                                        <tr style="background: #e1ecff !important; color:black !important">
                                            <th width="3%" class="text-center">SN</th>
                                            <th width="36%">Product</th>
                                            <th width="10%">Unit</th>
                                            <th width="8%" class="text-center">Quantity</th>
                                            <th width="8%" class="text-right">Rate</th>
                                            <th width="12%" class="text-right">Discount Price</th>
                                            <th width="10%" class="text-right">Total Amount</th>
                                            <th width="10%" class="text-center">Condition</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orderReturn->orderReturnDetails as $orderReturnDetail)
                                            <input type="hidden" name="order_return_detail_id[]" value="{{ $orderReturnDetail->id }}">
                                            <input type="hidden" name="order_detail_id[]" value="{{ $orderReturnDetail->order_detail_id }}">
                                            <input type="hidden" name="product_id[]" value="{{ $orderReturnDetail->product_id }}">
                                            <input type="hidden" name="product_variation_id[]" value="{{ $orderReturnDetail->product_variation_id }}">
                                            <input type="hidden" name="purchase_price[]" value="{{ $orderReturnDetail->purchase_price }}">
                                            <input type="hidden" name="sale_price[]" value="{{ $orderReturnDetail->sale_price }}">
                                            <input type="hidden" name="quantity[]" value="{{ $orderReturnDetail->quantity }}">
                                            <input type="hidden" name="vat_percent[]" value="{{ $orderReturnDetail->vat_percent }}">
                                            <input type="hidden" name="vat_amount[]" value="{{ $orderReturnDetail->vat_amount }}">
                                            <input type="hidden" name="discount_percent[]" value="{{ $orderReturnDetail->discount_percent }}">
                                            <input type="hidden" name="discount_amount[]" value="{{ $orderReturnDetail->discount_amount }}">
                                            <input type="hidden" name="weight[]" value="{{ $orderReturnDetail->weight }}">
                                            <input type="hidden" name="condition[]" value="{{ $orderReturnDetail->return_type }}">
                                            
                                            @php
                                                $subTextOrMeasurement = '';

                                                if (optional($orderReturnDetail->product)->sub_text != null) {
                                                    $subTextOrMeasurement = optional($orderReturnDetail->product)->sub_text. ' ' . optional(optional($orderReturnDetail->product)->unitMeasure)->name;
                                                }elseif ($orderReturnDetail->measurement_sku) {
                                                    $subTextOrMeasurement = $orderReturnDetail->measurement_title;
                                                }
                                            @endphp

                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ optional($orderReturnDetail->product)->name }}  {{ $orderReturnDetail->product_variation_id ? '(' . optional($orderReturnDetail->productVariation)->name . ')' : '' }}</td>
                                                <td>{{ $subTextOrMeasurement }}</td>
                                                <td class="text-center">{{ $orderReturnDetail->quantity }}</td>
                                                <td class="text-right">{{ $orderReturnDetail->sale_price }}</td>
                                                <td class="text-right">{{ $orderReturnDetail->discount_amount > 0 ? number_format($orderReturnDetail->sale_price - $orderReturnDetail->discount_amount, 2, '.', '') : '' }}</td>
                                                <td class="text-right {{ $orderReturnDetail->exist_in_return == 0 && optional($orderReturnDetail->product)->is_refundable == 'Yes' ? 'total-amount' : '' }}">
                                                    {{ number_format($orderReturnDetail->total_amount, 2, '.', '') }}
                                                </td>
                                                <td class="text-center">{{ $orderReturnDetail->return_type }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="input-group mb-1 width-100">
                                        <span class="input-group-addon width-30" style="background-color: #e1ecff; color: #000000; text-align: left">
                                            Status <span class="label-required">*</span>
                                        </span>
                                        
                                        <select name="status" id="status" class="form-control select2" onchange="assignReturnInfo(this)" required
                                            {{ $orderReturn->status == 'Delivery Done' || $orderReturn->status == 'Cancelled' ? 'disabled' : '' }}
                                        >
                                            <option value="" selected disabled>--- Select ---</option>
                                            @foreach(['Pending', 'Approved', 'Delivery Start', 'Delivery Done', 'Cancelled'] as $status)
                                                <option value="{{ $status }}" {{ old('status', $orderReturn->status) == $status ? 'selected' : '' }}
                                                    {{ $orderReturn->status == 'Delivery Done' || $orderReturn->status == 'Cancelled' ? 'disabled' : '' }}
                                                >{{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div id="assignReturnInfo" style="{{ $orderReturn->status == 'Approved' ? '' : 'display: none' }}">
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="input-group mb-1 width-100">
                                            <input type="text" class="form-control text-center" value="Assign Return Information" readonly style="background-color: #e1ecff !important; color: #000000 !important">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="input-group mb-1 width-100">
                                            <span class="input-group-addon width-30" style="background-color: #e1ecff; color: #000000; text-align: left">
                                                Return Date <span class="label-required">*</span>
                                            </span>
                                            <input type="text" class="form-control date-picker text-center" id="return_date" name="return_date" value="{{ request('return_date', $orderReturn->return_date) }}" autocomplete="off" placeholder="Date" data-date-format="yyyy-mm-dd" style="color: #000000 !important">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="input-group mb-1 width-100">
                                            <span class="input-group-addon width-30" style="background-color: #e1ecff; color: #000000; text-align: left">
                                                Time Slot <span class="label-required">*</span>
                                            </span>
                                            <select name="time_slot_id" id="time_slot_id" class="form-control select2">
                                                <option value="" selected disabled>--- Select ---</option>
                                                @foreach($timeSlots as $timeSlot)
                                                    <option value="{{ $timeSlot->id }}" {{ old('time_slot_id', $orderReturn->time_slot_id) == $timeSlot->id ? 'selected' : '' }}>{{ $timeSlot->starting_time . ' - ' . $timeSlot->ending_time }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="input-group mb-1 width-100">
                                            <span class="input-group-addon width-30" style="background-color: #e1ecff; color: #000000; text-align: left">
                                                Delivery Man <span class="label-required">*</span>
                                            </span>
                                            <select name="delivery_man_id" id="delivery_man_id" class="form-control select2">
                                                <option value="" selected disabled>--- Select ---</option>
                                                @foreach($deliveryMans as $deliveryMan)
                                                    <option value="{{ $deliveryMan->id }}" {{ old('delivery_man_id', $orderReturn->delivery_man_id) == $deliveryMan->id ? 'selected' : '' }}>{{ $deliveryMan->name }} -> {{ $deliveryMan->phone }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="cancelReason" style="{{ $orderReturn->status == 'Cancelled' ? '' : 'display: none' }}">
                                    <div class="col-md-8 col-md-offset-2">
                                        <textarea name="cancel_reason" rows="4" class="form-control note-textarea" placeholder="Cancel Reason ...">{{ old('cancel_reason', $orderReturn->cancel_reason) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-1 mt-41"
                                style="height: 50px;
                                text-align: center;
                                font-size: 18px;
                                color: black;
                                background-color: #e1ecff;
                                /* border: 2px solid #346cb0; */
                                align-items: center;
                                display: flex;
                                justify-content: center;"
                            >
                                Return Total: <span class="ml-1">{{ $orderReturn->total_amount }}</span> TK
                            </div>

                            <div class="btn-group width-100">
                                <button class="btn btn-sm {{ $orderReturn->status == 'Delivery Done' || $orderReturn->status == 'Cancelled' ? 'btn-light' : 'btn-theme' }}" id="submitBtn" style="width: 50%" type="submit"
                                    {{ $orderReturn->status == 'Delivery Done' || $orderReturn->status == 'Cancelled' ? 'disabled' : '' }}
                                > <i class="far fa-edit"></i> UPDATE </button>
                                <a class="btn btn-sm btn-secondary" style="width: 49%; color: #000000 !important" href="{{ route('inv.order-returns.index') }}"> <i class="far fa-bars"></i> LIST </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection





@section('script')
    <script>

        $('.date-picker').datepicker({ 
            startDate: new Date()
        });

        assignReturnInfo($('#status'))
        function assignReturnInfo(obj)
        {
            let status = $(obj).find('option:selected').val();

            if (status == 'Approved') {
                $('#assignReturnInfo').show();
                $('#cancelReason').hide();
                $('.select2').select2();

                $('#return_date').prop('required', true);
                $('#time_slot_id').prop('required', true);
                $('#delivery_man_id').prop('required', true);

                return;
            }
            else if(status == 'Cancelled') {
                $('#cancelReason').show();
                $('#assignReturnInfo').hide();
            }
            else {
                $('#assignReturnInfo').hide();
                $('#cancelReason').hide();
            }

            $('#return_date').prop('required', false);
            $('#time_slot_id').prop('required', false);
            $('#delivery_man_id').prop('required', false);
        }
        
    </script>
@endsection
