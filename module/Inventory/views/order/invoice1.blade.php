<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Invoice</title>

    <style>
        @page {
            header: page-header;
            footer: page-footer;
            sheet-size: Letter;
            margin: 0 !important;
        }

        * {
            margin    : 0;
            padding   : 0;
            box-sizing: border-box;
        }

        body {
            width     : 816px;
            height    : 1056px;
            margin    : 0px auto;
            background: rgb(224, 224, 224);
        }

        @media print {
            body {
                header     : page-header;
                footer     : page-footer;
                sheet-size : Letter;
                margin     : 0 !important;
                background : #efefef;
                font-family: 'Fira Code';
                font-size  : 15px;
                font-weight: 600;
            }

            .invoice {
                margin-top: 0 !important;
                margin-bottom: 0 !important;
            }
        }

        .col-2 {
            float: left;
            width: 16.6666666667%;
        }

        .col-3 {
            float: left;
            width: 25%;
        }

        .col-6 {
            float: left;
            width: 50%;
        }

        .col-9 {
            float: left;
            width: 75%;
        }

        .col-10 {
            float: left;
            width: 83.3333333333%;
        }

        .invoice {
            background   : #ffffff;
            width        : 100%;
            height       : 100%;
            margin       : 0 auto;
            margin-top   : 50px;
            margin-bottom: 50px;
            padding      : 20px;
        }

        .container {
            padding: 5px 50px;
            height: 100%;
            position: relative;
        }

        .company-logo {
            width: 220px;
            height: 80px;
        }

        .company-info-invoice {
            margin-bottom: 28px;
            font-size: 13px;
        }

        .print-copy-info {
            margin-bottom: 15px;
            font-size: 13px;
        }

        .logo {
            width: 100%;
            height: 100%;
        }

        .company-info {
            font-size: 15px;
            text-align: center;
        }

        .receipt-heading {
            text-align   : center;
            font-weight  : 700;
            margin       : 0 auto;
            margin-top   : 10px;
            margin-bottom: 5px;
            max-width    : 450px;
            position     : relative;
        }

        .receipt-heading:before {
            content   : "";
            display   : block;
            width     : 130px;
            height    : 2px;
            background: #18181b;
            left      : 0;
            top       : 50%;
            position  : absolute;
        }

        .receipt-heading:after {
            content   : "";
            display   : block;
            width     : 130px;
            height    : 2px;
            background: #18181b;
            right     : 0;
            top       : 50%;
            position  : absolute;
        }

        .invoice-info {
            margin-bottom: 10px;
        }

        .invoice-info .date {
            text-align: right;
        }

        table {
            width: 100%;
        }

        table,
        th {
            border-top     : 1px solid black;
            border-bottom  : 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .invoice-price {
            padding      : 10px;
            margin-top   : 10px;
            margin-bottom: 10px;
            text-align   : right;
            padding-right: 0 !important;
        }

        .order-note {
            padding      : 10px;
            margin-top   : 10px;
            margin-bottom: 10px;
            text-align   : left;
        }

        .footer {
            position  : absolute;
            right     : 0;
            bottom    : 0 !important;
            left      : 0;
            padding   : 1rem;
            text-align: center;
        }

        .footer-message {
            position  : absolute;
            right     : 0;
            bottom    : 0 !important;
            left      : 0;
            padding   : 1rem;
            text-align: center;
        }

        .barcode-img {
            height: 50 px;
            width: 100 px;
        }

        tr:nth-child(even) {
            background: #ccc
        }

        .copy {
            font-size: 20px;
        }

        .hr {
            width     : 50%;
            float     : right;
            height    : 2px;
            background: #000000;
        }

        #block_container {
            padding-top: 15px;
        }

        #bloc1,
        #bloc2 {
            display: inline;
        }

        .right-side {
            width: 50%;
        }

        .left-side {
            width: 50%;
        }
    </style>

    <style>
        @media print {
            tr.page-break {
                display: block;
                page-break-after: always;
            }
        }
    </style>
</head>

<body>
    @php
        $chunk              = 16;
        $loop_last          = false;
        $is_last            = false;
        $copy               = 'Invoice';
        $isSaleShow         = $pageSections != '' ? optional($pageSections->where('id', 37)->first())->value : '';
        $isShowBinAndMushak = $pageSections != '' ? optional($pageSections->where('id', 51)->first())->value : '';
        $isShowCodeCharge   = $pageSections != '' ? optional($pageSections->where('id', 52)->first())->value : '';

        if (request('copy') == 'customer') {
            $copy = 'Customer Copy';
        } elseif (request('copy') == 'accounts') {
            $copy = 'Accounts Copy';
        } elseif (request('copy') == 'delivery-man') {
            $copy = 'Delivery Man Copy';
        } elseif (request('copy') == 'store') {
            $copy = 'Store Copy';
        }
    @endphp

    @foreach ($order->orderDetails->chunk($chunk) as $key => $details)
        <section class="invoice">

            <div class="container">
                <div id="topPart">
                    <div class="invoice-info" style="margin-top:0 !important">
                        <div class="row">
                            <div class="col-6">
                                <div class="company-logo">
                                    <img src="{{ asset($company->logo) }}" alt="Logo" class="logo">
                                </div>
                                @if (optional($order->orderCustomerInfo)->ship_to_different_address == 'Yes')
                                    <p>
                                        Name &nbsp&nbsp&nbsp&nbsp:
                                        {{ optional($order->orderCustomerInfo)->receiver_name }}
                                    </p>
                                    <p>
                                        Mobile &nbsp&nbsp: {{ optional($order->orderCustomerInfo)->receiver_phone }}
                                    </p>
                                    <p>
                                        Address : {{ optional($order->orderCustomerInfo)->receiver_address }}
                                    </p>
                                    <p>
                                        Area &nbsp&nbsp&nbsp&nbsp&nbsp:
                                        {{ optional(optional($order->orderCustomerInfo)->receiverArea)->name }} |
                                        District :
                                        {{ optional(optional($order->orderCustomerInfo)->receiverDistrict)->name }}
                                    </p>
                                @else
                                    <p>Name &nbsp&nbsp&nbsp&nbsp: {{ optional($order->customer)->name }}</p>
                                    <p>Mobile &nbsp&nbsp: {{ optional($order->customer)->mobile }}</p>
                                    <p>Address : {{ optional($order->orderCustomerInfo)->address }}</p>
                                    <p>
                                        Area &nbsp&nbsp&nbsp&nbsp&nbsp:
                                        {{ optional(optional($order->orderCustomerInfo)->area)->name }} | District :
                                        {{ optional(optional($order->orderCustomerInfo)->district)->name }}
                                    </p>
                                @endif

                                @if ($isSaleShow == 'on' && $order->created_by != null)
                                    {{-- <p>Sales by: {{ optional($order->soldBy)->name }}</p> --}}
                                    <p>Sales by: {{ optional($order->createdBy)->name }}</p>
                                @endif

                            </div>

                            <div class="col-6 date">
                                <div class="print-copy-info">
                                    <div>
                                        <p class="copy">{{ $copy }}</p>
                                        <hr class="hr">
                                    </div>
                                </div>
                                <div class="company-info-invoice">
                                    <p style="font-size: 18px">{{ optional($company)->name }}</p>
                                    <p>{{ optional($company)->address }}</p>
                                    <p>Call: {{ optional($company)->phone ?? optional($company)->hotline }}</p>

                                    @if ($isShowBinAndMushak == 'on')
                                        <p>
                                            <!-- BIN & MUSAK -->
                                            <span>BIN number: {{ $company->bin ?? 'N\A' }}</span> <span>MUSHAK:
                                                {{ $company->musak ?? 'N\A' }}
                                            </span>
                                        </p>
                                    @endif
                                </div>
                                <p>Order Date : {{ date('Y-m-d h:i:s A', strtotime($order->created_at)) }}</p>
                                <p>Delivery Date : {{ $order->delivery_date }}</p>
                                <p>Delivery Time :
                                    {{ optional($order->timeSlot)->starting_time . ' - ' . optional($order->timeSlot)->ending_time }}
                                </p>
                                <p>{{ $order->payment_type == 'COD' ? 'Cash On Delivery' : $order->payment_type }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <p style="font-size: 20px;"> Sales Invoice </p>
                        <p> Order No : {{ $order->order_no }}</p>
                        <img class="pt-1 barcode-img" src="data:image/png;base64, {{ DNS1D::getBarcodePNG($order->order_no, 'C128') }}" alt="barcode" />
                    </div>

                    <div class="product-info">
                        <table>
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th class="text-left">Item Details</th>
                                    <th>Unit</th>
                                    <th>Qty</th>
                                    <th>Rate</th>
                                    <th>Discount</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $skipCount = floor(count($order->orderDetails) / $chunk);
                                    $skip      = $skipCount ? count($order->orderDetails) / $skipCount : $chunk;

                                    if ($loop->last) {
                                        $loop_last = true;
                                    }
                                @endphp

                                @foreach ($details->take($skip) as $detail)
                                    @php
                                        $subTextOrMeasurement = '';
                                        if ($loop_last && $loop->count > 12) {
                                            $is_last = true;
                                        }

                                        if ($detail->measurement_sku != '') {
                                            $subTextOrMeasurement = $detail->measurement_title;
                                        } elseif (optional($detail->product)->sub_text != null) {
                                            $subTextOrMeasurement = optional($detail->product)->sub_text . ' ' . optional(optional($detail->product)->unitMeasure)->name;
                                        }
                                    @endphp

                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td style="line-height: 16px">
                                            {{ optional($detail->product)->name }}
                                            {{ $detail->product_variation_id ? optional($detail->productVariation)->name : '' }}
                                        </td>
                                        <td>{{ $subTextOrMeasurement }}</td>
                                        <td class="text-center">{{ $detail->quantity }}</td>
                                        <td class="text-center">{{ number_format($detail->sale_price, 2, '.', '') }}
                                        </td>
                                        <td class="text-center">
                                            {{ number_format($detail->discount_amount * $detail->quantity, 2, '.', '') }}
                                        </td>
                                        <td class="text-right">
                                            @php
                                                $line_total = $detail->sale_price * $detail->quantity - $detail->discount_amount * $detail->quantity;
                                            @endphp
                                            {{ round($line_total) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="bottomPart" style="height: 350px; display: {{ $loop_last && !$is_last ? '' : 'none' }}">
                    <div class="row" style="display: flex; justify-content:space-between">
                        <div class="col-sm-4 col-lg-4 col-md-4 order-note" style="width: 50%;">
                            <p>
                                <b>Note :</b>
                                {{ optional($order->orderCustomerInfo)->receiver_order_note ?? optional($order->orderCustomerInfo)->order_note }}
                            </p>
                        </div>
                        <div class="col-sm-8 col-lg-8 col-md-8 ">
                            <div class="invoice-price" style="width: 280px;">
                                <div class="row" style="display: flex; justify-content: space-between;">
                                    <div class="left-side">
                                        <p>Subtotal: </p>
                                        <p>VAT:</p>
                                    </div>
                                    <div class="right-side">
                                        <p>{{ number_format($order->subtotal, 2, '.', '') }}</p>
                                        <p>{{ number_format($order->total_vat_amount, 2, '.', '') }}</p>
                                    </div>
                                </div>
                                ------------
                                <div class="row" style="display: flex; justify-content: space-between;">
                                    <div class="left-side">
                                        <p>Shipping Cost: </p>
                                        <p>Discount:</p>
                                        <p>Coupon Discount:</p>
                                        <p>Speical Discount:</p>
                                    </div>
                                    <div class="right-side">
                                        <p>{{ number_format($order->total_shipping_cost, 2, '.', '') }}</p>
                                        <p>(-) {{ number_format($order->total_discount_amount, 2, '.', '') }}</p>
                                        <p>(-) {{ number_format($order->coupon_discount_amount, 2, '.', '') }}</p>
                                        <p>(-) {{ number_format($order->special_discount, 2, '.', '') }}</p>
                                    </div>
                                </div>
                                ------------
                                <div class="row" style="display: flex; justify-content: space-between;">
                                    <div class="left-side">
                                        <p>Total Payable:</p>
                                        @if ($isShowCodeCharge == 'on' || $order->total_cod_charge > 0)
                                            <p>
                                                COD Charge({{ round((100 * $order->total_cod_charge) / $order->grand_total) }}%):
                                            </p>
                                        @endif
                                        <p>Paid Amount: </p>
                                    </div>
                                    <div class="right-side">
                                        <p>{{ round($order->grand_total - $order->total_cod_charge) }}</p>
                                        @if ($isShowCodeCharge == 'on' || $order->total_cod_charge > 0)
                                            <p>{{ number_format($order->total_cod_charge, 2, '.', '') }}</p>
                                        @endif
                                        <p>0</p>
                                    </div>
                                </div>
                                ------------
                                <div class="row" style="display: flex; justify-content: space-between;">
                                    <div class="left-side">
                                        <p>Cash To Collect:</p>
                                    </div>
                                    <div class="right-side">
                                        <p>{{ round($order->grand_total) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="block_container">
                        <div id="bloc1" style="float: left;">
                            <p>___________________________</p>
                            <p style="text-align:center;">Received By</p>
                        </div>
                        <div id="bloc2" style="float: right;">
                            <p>___________________________</p>
                            <p style="text-align:center;">Authorized By</p>
                        </div>
                    </div>

                    <div class="footer-message" style="text-align: justify;">
                        <p style="text-align: justify;">{{ optional($order->company)->bill_footer }}</p>
                    </div>
                </div>
            </div>
        </section>
    @endforeach

    @if ($is_last)
        <section class="invoice" style="bottom: 0px !important;">
            <div class="container">
                <div id="topPart">
                    <div class="invoice-info" style="margin-top:0 !important">
                        <div class="row">
                            <div class="col-6">
                                <div class="company-logo">
                                    <img src="{{ asset($company->logo) }}" alt="Logo" class="logo">
                                </div>
                                <p>Name &nbsp&nbsp&nbsp&nbsp: {{ optional($order->customer)->name }}</p>
                                <p>Mobile &nbsp&nbsp: {{ optional($order->customer)->mobile }}</p>
                                <p>Address :{{ optional($order->orderCustomerInfo)->address }}</p>
                                <p>
                                    Area &nbsp&nbsp&nbsp&nbsp&nbsp:
                                    {{ optional(optional($order->orderCustomerInfo)->area)->name }} | District :
                                    {{ optional(optional($order->orderCustomerInfo)->district)->name }}</p>

                                @if ($isSaleShow == 'on' && $order->created_by != null)
                                    {{-- <p>Sales by: {{ optional($order->soldBy)->name }}</p> --}}
                                    <p>Sales by: {{ optional($order->createdBy)->name }}</p>
                                @endif
                            </div>
                            <div class="col-6 date">
                                <div class="print-copy-info">
                                    <div>
                                        <p class="copy">{{ $copy }}</p>
                                        <hr class="hr">
                                    </div>
                                </div>
                                <div class="company-info-invoice">
                                    <p style="font-size: 18px">{{ optional($company)->name }}</p>
                                    <p>{{ optional($company)->address }}</p>
                                    <p>Call: {{ optional($company)->hotline }}</p>
                                </div>
                                <p>Order Date : {{ date('Y-m-d h:i:s A', strtotime($order->created_at)) }}</p>
                                <p>Delivery Date : {{ $order->delivery_date }}</p>
                                <p>
                                    Delivery Time :
                                    {{ optional($order->timeSlot)->starting_time . ' - ' . optional($order->timeSlot)->ending_time }}
                                </p>
                                <p>{{ $order->payment_type == 'COD' ? 'Cash On Delivery' : '' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <p style="font-size: 20px;"> Sales Invoice </p>
                        <p> Order No : {{ $order->order_no }}</p>
                        <img class="pt-1 barcode-img" src="data:image/png;base64, {{ DNS1D::getBarcodePNG($order->order_no, 'C128') }}" alt="barcode" />
                    </div>
                    <div class="product-info" style="margin-bottom: 220px">
                    </div>
                </div>
                <div id="bottomPart" style="height: 350px">
                    <div class="row" style="display: flex; justify-content:space-between">
                        <div class="col-sm-4 col-lg-4 col-md-4 order-note" style="width: 50%;">
                            <p>
                                <b>Note :</b>
                                {{ optional($order->orderCustomerInfo)->receiver_order_note ?? optional($order->orderCustomerInfo)->order_note }}
                            </p>
                        </div>
                        <div class="col-sm-8 col-lg-8 col-md-8 ">
                            <div class="invoice-price" style="width: 280px;">
                                <div class="row" style="display: flex; justify-content: space-between;">
                                    <div class="left-side">
                                        <p>Subtotal: </p>
                                        <p>VAT:</p>
                                    </div>
                                    <div class="right-side">
                                        <p>{{ number_format($order->subtotal, 2, '.', '') }}</p>
                                        <p>{{ number_format($order->total_vat_amount, 2, '.', '') }}</p>
                                    </div>
                                </div>
                                ------------
                                <div class="row" style="display: flex; justify-content: space-between;">
                                    <div class="left-side">
                                        <p>Shipping Cost: </p>
                                        <p>Discount:</p>
                                        <p>Coupon Discount:</p>
                                        @if ($isShowCodeCharge == 'on' || $order->total_cod_charge > 0)
                                            <p>COD Chage: </p>
                                        @endif
                                    </div>
                                    <div class="right-side">
                                        <p>{{ number_format($order->total_shipping_cost, 2, '.', '') }}</p>
                                        <p>(-) {{ number_format($order->total_discount_amount, 2, '.', '') }}</p>
                                        <p>(-) {{ number_format($order->coupon_discount_amount, 2, '.', '') }}</p>
                                        @if ($isShowCodeCharge == 'on' || $order->total_cod_charge > 0)
                                            <p>{{ number_format($order->total_cod_charge, 2, '.', '') }}</p>
                                        @endif
                                    </div>
                                </div>
                                ------------
                                <div class="row" style="display: flex; justify-content: space-between;">
                                    <div class="left-side">
                                        <p>Total Payable:</p>
                                        <p>Paid Amount: </p>
                                    </div>
                                    <div class="right-side">
                                        <p>{{ round($order->grand_total) }}</p>
                                        <p>0</p>
                                    </div>
                                </div>
                                ------------
                                <div class="row" style="display: flex; justify-content: space-between;">
                                    <div class="left-side">
                                        <p>Cash To Collect:</p>
                                    </div>
                                    <div class="right-side">
                                        <p>{{ round($order->grand_total) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="block_container">
                        <div id="bloc1" style="float: left;">
                            <p>___________________________</p>
                            <p style="text-align:center;">Received By</p>
                        </div>
                        <div id="bloc2" style="float: right;">
                            <p>___________________________</p>
                            <p style="text-align:center;">Authorized By</p>
                        </div>
                    </div>

                    <div class="footer-message" style="text-align: justify;">
                        <p style="text-align: justify;">{{ optional($order->company)->bill_footer }}</p>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <script type="text/javascript">
        window.print();
    </script>
</body>

</html>
