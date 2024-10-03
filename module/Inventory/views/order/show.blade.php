@extends('layouts.master')

@section('title', $order->order_no)

@section('content')

    <div class="page-header">
        <h4 class="page-title"><i class="far fa-paste"></i> Order No: <b>@yield('title')</b></h4>
        <div class="btn-group">

        </div>
    </div>

    @include('partials._alert_message')

    <div class="row my-3">

        <div class="col-md-4">
            <table>
                <tr><th colspan="2">&mdash; Customer</th></tr>
                <tr>
                    <td>Name</td>
                    <td>: {{ optional($order->orderCustomerInfo)->name }}</td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td>: {{ optional($order->orderCustomerInfo)->phone }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>: {{ optional($order->orderCustomerInfo)->email }}</td>
                </tr>
                <tr>
                    <td>Country</td>
                    <td>: {{ optional($order->orderCustomerInfo)->country }}</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>: {{ optional($order->orderCustomerInfo)->address }}</td>
                </tr>
                <tr>
                    <td>District</td>
                    <td>: {{ optional(optional($order->orderCustomerInfo)->district)->name }}</td>
                </tr>
                <tr>
                    <td>Area</td>
                    <td>: {{ optional(optional($order->orderCustomerInfo)->area)->name }}</td>
                </tr>
                <tr>
                    <td>ZIP Code</td>
                    <td>: {{ optional($order->orderCustomerInfo)->zip_code }}</td>
                </tr>
            </table>
        </div>

        <div class="col-md-4">
            @if (optional($order->orderCustomerInfo)->ship_to_different_address == 'Yes')
                <table class="ml-5">
                    <tr><th colspan="2">&mdash; Receiver</th></tr>
                    <tr>
                        <td>Name</td>
                        <td>: {{ optional($order->orderCustomerInfo)->receiver_name }}</td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td>: {{ optional($order->orderCustomerInfo)->receiver_phone }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>: {{ optional($order->orderCustomerInfo)->receiver_email }}</td>
                    </tr>
                    <tr>
                        <td>Country</td>
                        <td>: {{ optional($order->orderCustomerInfo)->receiver_country }}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>: {{ optional($order->orderCustomerInfo)->address }}</td>
                    </tr>
                    <tr>
                        <td>District</td>
                        <td>: {{ optional(optional($order->orderCustomerInfo)->receiverDistrict)->name }}</td>
                    </tr>
                    <tr>
                        <td>Area</td>
                        <td>: {{ optional(optional($order->orderCustomerInfo)->receiverArea)->name }}</td>
                    </tr>
                    <tr>
                        <td>ZIP Code</td>
                        <td>: {{ optional($order->orderCustomerInfo)->receiver_zip_code }}</td>
                    </tr>
                </table>
            @endif
        </div>

        <div class="col-md-4">
            <table class="pull-right">
                <tr><th colspan="2">&mdash; Order</th></tr>
                <tr>
                    <td>Order No</td>
                    <td>: {{ $order->order_no }}</td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td>: {{ $order->date }}</td>
                </tr>
                <tr>
                    <td>Delivery Date</td>
                    <td>: {{ $order->delivery_date }}</td>
                </tr>
                <tr>
                    <td>Delivery Time</td>
                    <td>: {{ optional($order->timeSlot)->starting_time . ' - ' . optional($order->timeSlot)->ending_time }}</td>
                </tr>
                <tr>
                    <td>Payment Type</td>
                    <td>: {{ $order->payment_type == '' || $order->payment_type == 'COD' ? 'Cash On Delivery' : '' }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td style="font-weight: bold; color:
                        @if($order->current_status == 1)
                            #ffc107
                        @elseif($order->current_status == 2)
                            #0D6EFD
                        @elseif($order->current_status == 3)
                            #07ff24
                        @elseif($order->current_status == 4)
                            #48dcf9
                        @elseif($order->current_status == 5)
                            #198754
                        @elseif($order->current_status == 6)
                            #fb3c3c
                        @endif
                    ">: {{ optional($order->currentStatus)->name }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row">

        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead style="border-bottom: 3px solid #346cb0 !important">
                        <tr style="background: #e1ecff !important; color:black !important">
                            <th width="3%" class="text-center">SL</th>
                            <th width="30%">Product</th>
                            <th width="10%">SKU</th>
                            <th width="10%">Unit</th>
                            <th width="10%" class="text-right">Unit Price</th>
                            <th width="10%" class="text-right">Discount</th>
                            <th width="10%" class="text-center">Qty</th>
                            <th width="10%" class="text-right">Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($order->orderDetails as $item)

                            @php
                                $subTextOrMeasurement = '';

                                if (optional($item->product)->sub_text != null) {
                                    $subTextOrMeasurement = optional($item->product)->sub_text. ' ' . optional(optional($item->product)->unitMeasure)->name;
                                }elseif ($item->measurement_sku) {
                                    $subTextOrMeasurement = $item->measurement_title;
                                }
                            @endphp

                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    {{ optional($item->product)->name }} {{ $item->product_variation_id ? '(' . optional($item->productVariation)->name . ')' : '' }}
                                </td>
                                <td>{{optional($item->product)->sku}}</td>
                                <td>{{ $subTextOrMeasurement }}</td>
                                <td class="text-right">{{ number_format($item->sale_price, 2, '.', '') }}</td>
                                <td class="text-right">{{ number_format($item->discount_amount * $item->quantity, 2, '.', '') }}</td>
                                <td class="text-center">{{ number_format($item->quantity, 2, '.', '') }}</td>
                                <td class="text-right">
                                    @php
                                        $line_total = ($item->sale_price * $item->quantity) - ($item->discount_amount * $item->quantity);
                                    @endphp
                                    {{ round($line_total) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <form action="{{ route('inv.orders.change-order-status', $order->id) }}" method="POST">
        @csrf

        <input type="hidden" name="customer_id" value="{{ $order->customer_id }}">
        <input type="hidden" name="customer_name" value="{{ optional($order->customer)->name }}">



        <div class="row">
            <div class="col-md-5">
                    <div class="input-group mb-1 width-100" style="width: 100%">
                        <span class="input-group-addon width-40" style="text-align: left">
                            Status
                        </span>
                        @php
                            $statusArr = [];
                            for ($i = $order->current_status; $i >= 1; $i--) {
                                array_push($statusArr, $i);
                            }
                        @endphp
                        <select name="status_id" id="status_id" class="form-control select2" {{ in_array($order->current_status, [5, 6]) ? 'disabled' : '' }} data-placeholder="- Select -" onchange="statusConfirm(this)">
                            <option></option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}"
                                    @if (in_array($status->id, $statusArr))
                                        disabled
                                    @endif
                                    @if ($order->current_status == 5)
                                        {{ $status->id == 6 ? 'disabled' : '' }}
                                    @endif
                                    {{ old('status_id', $status->id) == $order->current_status ? 'selected' : '' }}>{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(auth()->user()->type != "Delivery Man")
                        @if (count($warehouses) > 1)
                            <div class="input-group mb-1 width-100" id="orderWarehouse" style="width: 100%; @if ($order->current_status == 1) display: none @endif">
                                <span class="input-group-addon width-40" style="text-align: left">
                                    Warehouse
                                </span>
                                <select name="warehouse_id" id="warehouse_id" class="form-control select2" {{ in_array($order->current_status, [5, 6]) ? 'disabled' : '' }} data-placeholder="- Select -">
                                    <option></option>
                                    @if($order->warehouse_id != null)
                                        <option value="{{ $order->warehouse_id }}" selected>{{ optional($order->warehouse)->name }}</option>
                                    @else
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}"
                                                {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }} {{ $order->warehouse_id == $warehouse->id ? 'selected' : '' }}
                                            >{{ $warehouse->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="warehouse_id" value="{{ $order->warehouse_id ?? 1 }}">
                        @endif

                        <div class="input-group mb-2 width-100" id="orderDeliveryMan" style="width: 100%; {{ $order->delivery_man_id == null && $order->current_status == 1 ? 'display: none' : '' }}">
                            <span class="input-group-addon width-40" style="text-align: left">
                                Assign Delivery Man
                            </span>
                            <select name="delivery_man_id" id="delivery_man_id" {{ in_array($order->current_status, [5, 6]) ? 'disabled' : '' }} class="form-control select2">
                                <option value="" selected>- Select -</option>
                                @foreach ($deliveryMans as $deliveryMan)
                                    <option value="{{ $deliveryMan->id }}" {{ old('delivery_man_id', $order->delivery_man_id) == $deliveryMan->id ? 'selected' : '' }}>{{ $deliveryMan->name }} -> {{ $deliveryMan->phone }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="warehouse_id" value="{{ $order->warehouse_id ?? 1 }}">
                        <input type="hidden" name="delivery_man_id" value="{{ $order->delivery_man_id }}">
                    @endif
                    @if (!in_array($order->current_status, [5, 6]))
                        <div class="input-group mb-2 width-100">
                            <button class="btn btn-primary pull-right" type="submit">SAVE CHANGES</button>
                        </div>
                    @endif

            </div>
            <div class="col-md-3"></div>
            <div class="col-md-4">
                <table class="pull-right" style="font-weight: bold">
                    <tr>
                        <td>Subtotal</td>
                        <td class="pl-4">: {{ number_format($order->subtotal, 2, '.', '') }}</td>
                    </tr>
                    <tr>
                        <td>VAT</td>
                        <td class="pl-4">: {{ number_format($order->total_vat_amount, 2, '.', '') }}</td>
                    </tr>
                    <tr>
                        <td>Shiping Cost</td>
                        <td class="pl-4">: {{ number_format($order->total_shipping_cost, 2, '.', '') }}</td>
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td class="pl-4">: {{ number_format($order->total_discount_amount, 2, '.', '') }}</td>
                    </tr>
                    <tr>
                        <td>Coupon Discount</td>
                        <td class="pl-4">: {{ number_format($order->coupon_discount_amount, 2, '.', '') }}</td>
                    </tr>
                    <tr>
                        <td>Point Amount</td>
                        <td class="pl-4">: {{ number_format($order->point_amount, 2, '.', '') }}</td>
                    </tr>
                    <tr>
                        <td>Wallet Amount</td>
                        <td class="pl-4">: {{ number_format($order->wallet_amount, 2, '.', '') }}</td>
                    </tr>
                    <tr>
                        <td>Grand Total</td>
                        <td class="pl-4">: {{ round($order->grand_total) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </form>


@endsection

@section('script')
    <script>
        function statusConfirm(obj)
        {
            let status_id = $(obj).find('option:selected').val();

            if (status_id != 1) {
                $('#orderWarehouse').show();
                $('#orderDeliveryMan').show();

                $('.select2').select2();
            } else {
                $('#orderWarehouse').hide();
                $('#orderDeliveryMan').hide();

                $('.select2').select2();
            }
        }
    </script>
@endsection
