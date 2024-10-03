@extends('layouts.master')
@section('title', 'Create Product Return')


@section('css')
    
@endsection


@section('content')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <h4 class="pl-2"><i class="far fa-undo-alt"></i> @yield('title')</h4>

    <ul class="breadcrumb mb-1">
        <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
        <li>Order</li>
        <li><a class="text-muted" href="{{ route('inv.order-returns.index') }}">Product Return</a></li>
        <li>Create</li>
    </ul>
</div>

    <div class="row">
        <div class="widget-body">
            <div class="widget-main">

                @include('partials._alert_message')

                <form class="form-horizontal" action="{{ route('inv.order-returns.create') }}" method="GET">
                    <div class="row mt-1">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="input-group" style="width: 100%; display: flex; align-items:center">
                                <span class="input-group-addon" style="text-align: left; width: 22%; height: 34px; line-height: 19px; background-color: #e1ecff; color: #000000;">
                                    Order No <span class="label-required">*</span>
                                </span>
                                <select name="order_no" data-placeholder="--- Select ---" class="form-control select2" required>
                                    <option></option>
                                    @foreach($orderNos as $orderNo)
                                        <option value="{{ $orderNo->order_no }}" {{ old('order_no', request('order_no')) == $orderNo->order_no ? 'selected' : '' }}>{{ $orderNo->order_no }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="input-group-addon" style="background-color: #b0ffa3 !important; color: #000000 !important;  width: 15%; height: 34px; line-height: 19px"><i class="fas fa-search"></i> SEARCH</button>
                            </div>
                        </div>
                    </div>
                </form>

                @if(request()->getQueryString() != null)
                    <form class="form-horizontal" action="{{ route('inv.order-returns.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        <div class="row mt-1">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="input-group mb-2">
                                    <span class="input-group-addon" style="background-color: #e1ecff; color: #000000;">
                                        Return Reason <span class="label-required">*</span>
                                    </span>
                                    <select name="return_reason_id" class="form-control select2" required>
                                        <option value="" selected disabled>--- Select ---</option>
                                        @foreach($returnReasons as $returnReason)
                                            <option value="{{ $returnReason->id }}">{{ $returnReason->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row mb-2" style="background-color: #f6f9fe; border: 2px solid #346cb0; border-radius: 5px; margin-left: 2px; margin-right: 2px; padding: 5px">
                                    <div class="col-md-7">
                                        <div class="row">
                                            <div class="col-md-3"><b>Name</b></div>
                                            <div class="col-md-9">: {{ optional($order->customer)->name }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3"><b>Phone</b></div>
                                            <div class="col-md-9">: {{ optional($order->customer)->mobile }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3"><b>Email</b></div>
                                            <div class="col-md-9">: {{ optional($order->customer)->email }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3"><b>Address</b></div>
                                            <div class="col-md-9">: {{ optional($order->customer)->address }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="row">
                                            <div class="col-md-4"><b>Country</b></div>
                                            <div class="col-md-8">: Bangladesh</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4"><b>District</b></div>
                                            <div class="col-md-8">: {{ optional(optional($order->customer)->district)->name }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4"><b>Area</b></div>
                                            <div class="col-md-8">: {{ optional(optional($order->customer)->area)->name }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4"><b>ZIP Code</b></div>
                                            <div class="col-md-8">: {{ optional($order->customer)->zip_code }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- OFFER ITEMS TABLE -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="purchaseTable">
                                        <thead style="border-bottom: 3px solid #346cb0 !important">
                                            <tr style="background: #e1ecff !important; color:black !important">
                                                <th width="3%">
                                                    <div class="checkbox" style="padding-top: 3px !important">
                                                        <label style="padding-left: 12px">
                                                            <input type="checkbox" class="ace check-all-item">
                                                            <span class="lbl"></span>
                                                        </label>
                                                    </div>
                                                </th>
                                                <th width="3%">SN</th>
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
                                            @foreach($order->orderDetails as $orderDetail)
                                                @php
                                                    $subTextOrMeasurement = '';

                                                    if (optional($orderDetail->product)->sub_text != null) {
                                                        $subTextOrMeasurement = optional($orderDetail->product)->sub_text. ' ' . optional(optional($orderDetail->product)->unitMeasure)->name;
                                                    }elseif ($orderDetail->measurement_sku) {
                                                        $subTextOrMeasurement = $orderDetail->measurement_title;
                                                    }
                                                @endphp


                                                <tr>
                                                    <td width="3%" class="text-center">
                                                        @if ($orderDetail->exist_in_return == 0 && optional($orderDetail->product)->is_refundable == 'Yes')
                                                            <div class="checkbox" style="padding-top: 3px !important">
                                                                <label style="padding-left: 12px">
                                                                    <input type="checkbox" name="order_detail_id[]" value="{{ $orderDetail->id }}" class="ace check-item">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </div>
                                                        @elseif (optional($orderDetail->product)->is_refundable == 'No')
                                                            <span class="text-danger"
                                                                data-rel="popover"
                                                                data-placement="bottom"
                                                                data-trigger="hover"
                                                                data-content="<p>Not Refundable Product</p>">
                                                                <i class="far fa-info-circle"></i>
                                                            </span>
                                                        @else
                                                            <span class="text-danger"
                                                                data-rel="popover"
                                                                data-placement="bottom"
                                                                data-trigger="hover"
                                                                data-content="<p>Already Returned</p>">
                                                                <i class="fas fa-undo-alt text-success"></i>
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ optional($orderDetail->product)->name }}  {{ $orderDetail->product_variation_id ? '(' . optional($orderDetail->productVariation)->name . ')' : '' }}</td>
                                                    <td>{{ $subTextOrMeasurement }}</td>
                                                    <td class="text-center">{{ $orderDetail->quantity }}</td>
                                                    <td class="text-right">{{ $orderDetail->sale_price }}</td>
                                                    <td class="text-right">{{ $orderDetail->discount_amount > 0 ? number_format($orderDetail->sale_price - $orderDetail->discount_amount, 2, '.', '') : '' }}</td>
                                                    <td class="text-right {{ $orderDetail->exist_in_return == 0 && optional($orderDetail->product)->is_refundable == 'Yes' ? 'total-amount' : '' }}">
                                                        {{ number_format($orderDetail->total_amount, 2, '.', '') }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if($orderDetail->exist_in_return == 0 && optional($orderDetail->product)->is_refundable == 'Yes')
                                                            <select class="form-control condition" name="condition[]" required disabled>
                                                                <option value="" selected disabled>Select</option>
                                                                @foreach(['Damaged', 'Expired', 'Good'] as $condition)
                                                                    <option value="{{ $condition }}">{{ $condition }}</option>
                                                                @endforeach
                                                            </select>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="col-md-9">
                                
                                <textarea name="note" rows="4" class="form-control note-textarea" placeholder="Note ..."></textarea>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-1 mt-41"
                                    style="height: 50px;
                                    text-align: center;
                                    font-size: 18px;
                                    color: black;
                                    background-color: #e1ecff;
                                    align-items: center;
                                    display: flex;
                                    justify-content: center;"
                                >
                                    Return Total: <span class="ml-1" id="returnTotal"></span> TK
                                </div>

                                <div class="btn-group width-100">
                                    <button class="btn btn-sm btn-light" id="submitBtn" disabled style="width: 50%" type="submit"> <i class="fa fa-save"></i> SUBMIT </button>
                                    <a class="btn btn-sm btn-secondary" style="width: 49%; color: #000000 !important" href="{{ route('inv.order-returns.index') }}"> <i class="fa fa-bars"></i> LIST </a>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection





@section('script')
    <script>

        let returnTotalArr = [];

        $(document).on('click', '.check-all-item', function() {
            let check = $(this).is(':checked');
            if (check) {
                $('.check-item').prop('checked', true);
                $('.check-item').closest('tr').find('.condition').prop('disabled', false);

                returnTotalArr = [];
                $('.total-amount').each(function () {
                    returnTotalArr.push($(this).text());
                })
                returnTotal()
            } else {
                $('.check-item').prop('checked', false);
                $('.check-item').closest('tr').find('.condition').prop('disabled', true);
                returnTotalArr = [];
                returnTotal()
            }
        });

        
        $(document).on('click', '.check-item', function() {
            if($(this).prop("checked") == true){
                $(this).closest('tr').find('.condition').prop('disabled', false);
                let totalAmount = $(this).closest('tr').find('.total-amount').text();
                returnTotalArr.push(totalAmount)
                returnTotal()
            }
            else if($(this).prop("checked") == false) {
                $(this).closest('tr').find('.condition').prop('disabled', true);
                let totalAmount = $(this).closest('tr').find('.total-amount').text();
                returnTotalArr = returnTotalArr.filter(item => !totalAmount.includes(item))
                returnTotal()
            }
        });


        returnTotal()
        function returnTotal()
        {
            let returnTotal = 0;

            $.each(returnTotalArr, function () {
                returnTotal += Number(this);
            })

            if (returnTotal > 0) {
                $('#submitBtn').prop('disabled', false);
                $('#submitBtn').removeClass('btn-light');
                $('#submitBtn').addClass('btn-theme');
            } else {
                $('#submitBtn').prop('disabled', true);
                $('#submitBtn').removeClass('btn-theme');
                $('#submitBtn').addClass('btn-light');
            }

            $('#returnTotal').text(returnTotal)
        }
    </script>
@endsection
