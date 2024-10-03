@php
    $isDeliveryShow = $pageSections != '' ? $pageSections[0]->value : '';
    $isSaleShow = $pageSections != '' ? $pageSections[1]->value : '';
    $isShowBinAndMushak = $pageSections != '' ? $pageSections[3]->value : '';
    $isShowCodeCharge = $pageSections != '' ? $pageSections[4]->value : '';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300;400;500;600;700&display=swap" rel="stylesheet"> --}}
    <link href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"
        rel="stylesheet">
    <title>Order no {{ $order->order_no }}</title>

    <style>
        @font-face {
            font-family: "Segoe UI Historic";
            /* src: url("font/Segoe\ ui\ historic.ttf") format("woff"); */
            src: url("../../../../public/assets/fonts/Segoe ui historic.ttf") format("woff");
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @media print {
            #invoice {
                margin-top: 0 !important;
                margin-bottom: 0 !important;
                padding-top: 2px !important;
            }

            .company-logo {
                margin-top: 0 !important;
                padding-top: 0 !important;
            }


            .no-print,
            .no-print * {
                display: none !important;
            }

            table,
            tr,
            th,
            td {
                /* border: none !important; */
            }
        }

        body {
            background: #efefef;
            /* font-family: 'Fira Code', monospace; */
            font-family: "Segoe UI Historic", sans-serif;
            font-size: 11px;
            font-weight: 500;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .col-2 {
            float: left;
            width: 16.6666666667%;
        }

        .col-3 {
            float: left;
            width: 25%;
        }

        .col-4 {
            float: left;
            width: 33.3333333333%;
        }

        .col-6 {
            float: left;
            width: 50%;
        }

        .col-8 {
            float: left;
            width: 66.6666666666%;
        }

        .col-9 {
            float: left;
            width: 75%;
        }

        .col-10 {
            float: left;
            width: 83.3333333333%;
        }

        #invoice {
            background: #ffffff;
            width: 302.36px;
            min-height: 100px;
            margin: 0 auto;
            margin-top: 10px;
            margin-bottom: 50px;
            padding: 5px;
        }

        .container {
            height: 100%;
        }

        .company-logo {
            width: 160px;
            margin: 0px auto;
            margin-top: 5px;
        }

        .logo {
            width: 100%;
        }

        .company-info {
            font-size: 9px;
            font-weight: 400;
            text-align: center;
        }

        .receipt-heading {
            text-align: center;
            font-weight: 700;
            margin: 0 auto;
            margin-top: 0px;
            max-width: 450px;
            position: relative;
            margin-top: -1px;
        }

        .receipt-heading:after {
            content: "";
            display: block;
            width: 100%;
            height: 1.2px;
            background: #18181b;
            right: 0;
            top: 50%;
            position: absolute;
        }

        .invoice-info {
            margin-top: 10px;
            margin-bottom: 0px;
        }

        .invoice-info .date {
            text-align: right;
        }

        table {
            width: 100%;
        }

        table,
        th {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
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
            padding: 5px;
            margin-top: 0;
            padding-top: 0;
            margin-bottom: 10px;
            text-align: right;
        }

        .footer {
            margin-top: 0;
            font-size: 10px;
            padding: 5px 5px;
            text-align: justify;
            padding-top: 0;
        }

        .no-print {
            text-align: center;
            margin-top: 10px;
            display: flex;
            justify-content: center;
        }

        .no-print .btn {
            border: none;
            color: white;
            padding: 2px 5px;
            text-align: center;
            line-height: 1.5;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            cursor: pointer;
            border-radius: 0px;
            font-weight: normal;
        }

        .no-print .btn.btn-print {
            background-color: #4CAF50;
        }

        .no-print .btn.btn-back {
            background-color: rgb(201 45 45 / 89%);
        }

        .barcode-img {
            height: 30px;
            width: 100%;
        }

        .company-logo>h1 {
            text-transform: uppercase;
        }

        .product-info table {
            border: 1px solid black;
        }

        .product-info table thead tr th {
            border: 1px solid black;
        }

        .product-info table tbody tr td {
            border: 1px solid black;
        }

        .divider-line {
            width: 283px;
            height: 1px;
            margin-top: -2px;
            background: black;
        }
    </style>
</head>

<body>
    <div class="no-print">
        <a href="{{ url()->previous() }}" class="btn btn-back">
            <i class="far fa-arrow-alt-left" style="margin-right: -4px;"></i>
            Back
        </a>
        <a href="javascript:void(0)" onclick="window.print()" class="btn btn-print">
            Print
            <i class="far fa-print"></i>
        </a>
    </div>

    <section id="invoice">
        <div class="container">

            <!-- COMPANY LOGO/NAME -->
            <div class="text-center company-logo">
                {{-- @if ($company->logo != null) --}}
                {{-- <img src="{{ asset($company->logo) }}" alt="Logo" class="logo"> --}}
                {{-- @endif --}}
                <h1>{{ $company->name }}</h1>
            </div>


            <!-- COMPANY INFORMATION -->
            <div class="company-info">
                <p>{{ $company->address }}</p>
                <h1><strong>www.safwahmart.com</strong></h1>
            </div>

            @if ($isShowBinAndMushak == 'on')
                <!-- BIN & MUSAK -->
                <div style="display: flex; justify-content:space-between;">
                    <span>BIN number: {{ $company->bin ?? 'N\A' }}</span> <span>MUSHAK:
                        {{ $company->musak ?? 'N\A' }}</span>
                </div>
            @endif

            <p class="receipt-heading"></p>


            <!-- INVOICE INFO -->
            <div class="invoice-info">
                <div class="row" style="display: flex; justify-content:space-between">
                    <div class="invoice-no" style="width: 40%">
                        <p>Invoice: {{ $order->order_no }}</p>
                        <p>Name: {{ optional($order->customer)->name }}</p>
                    </div>
                    <div class="date" style="width: 60%">
                        <p>Created: {{ date('d-m-y,h:ia', strtotime($order->created_at)) }}</p>
                        @if ($isDeliveryShow == 'on')
                            <p>Delivery: {{ date('d-m-y,h:ia', strtotime($order->delivery_date)) }}</p>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="invoice-no">
                        <p>
                            Address: {{ optional($order->customer)->address }},
                            {{ optional(optional($order->orderCustomerInfo)->area)->name ?? optional(optional($order->customer)->area)->name }},
                            {{ optional($order->customer->district)->name }}
                        </p>
                    </div>
                </div>
                <div class="row" style="display: flex; justify-content:space-between">
                    <div class="invoice-no" style="width: 50%">
                        <p>Mobile: {{ optional($order->customer)->mobile }}</p>
                    </div>
                    <div class="date" style="width: 50%">
                        @if ($isSaleShow == 'on' && $order->created_by != null)
                            {{-- <p>Sales by: {{ optional($order->soldBy)->name }}</p> --}}
                            <p>Sales by: {{ optional($order->createdBy)->name }}</p>
                        @endif
                    </div>
                </div>
            </div>



            <div class="product-info">

                <!-- INVOICE TABLE -->
                <table>
                    <tbody>
                        <tr>
                            <th class="text-left"><b>Product name</b></th>
                            <th><b>Qty</b></th>
                            <th><b>Price</b></th>
                            <th><b>D.Price</b></th>
                            <th><b>Total</b></th>
                        </tr>
                        @foreach ($order->orderDetails as $detail)
                            <tr>
                                <td style="vertical-align: top">
                                    {{-- {{ $detail->weight }} --}}
                                    {{ $loop->iteration . '.' . optional($detail->product)->name }}
                                    {{ optional($detail->productVariation)->name }}
                                    {{ optional($detail->product)->sub_text . optional(optional($detail->product)->unitMeasure)->name . '(sku-' . optional($detail->product)->sku . ')' }}
                                </td>
                                <td style="vertical-align: top" class="text-center">
                                    {{ number_format($detail->quantity) }}
                                </td>
                                <td style="vertical-align: top" class="text-right">
                                    {{ number_format($detail->quantity * $detail->sale_price + $detail->vat_amount, 0, '.', '') }}
                                </td>
                                <td style="vertical-align: top" class="text-center">
                                    {{ number_format($detail->total_amount, 0, '.', '') }}
                                </td>
                                <td style="vertical-align: top" class="text-center">
                                    {{ number_format($detail->total_amount, 0, '.', '') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


                <!-- CALCULATION AREA -->
                <div class="invoice-price">
                    <div class="row">
                        <div class="col-9">
                            <p>Subtotal: </p>
                            <p>VAT:</p>
                        </div>
                        <div class="col-3">
                            <p>৳ {{ number_format($order->subtotal, 2, '.', '') }}</p>
                            <p>
                                <span style="font-size: 7px"></span>৳
                                {{ number_format($order->total_vat_amount, 2, '.', '') }}
                            </p>
                        </div>
                    </div>
                    <div class="divider-line"></div>
                    <div class="row">
                        <div class="col-9">
                            <p>Total (incl. vat):</p>
                        </div>
                        <div class="col-3">
                            <p>
                                @php
                                    $price_after_vat = number_format($order->subtotal + $order->total_vat_amount, 2, '.', '');
                                @endphp

                                ৳ {{ $price_after_vat }}
                            </p>
                        </div>
                    </div>
                    <div class="divider-line"></div>
                    <div class="row">
                        <div class="col-9">
                            <p>Shipping cost:</p>
                            <p>Discount:</p>
                            <p>Coupon discount:</p>
                            <p>Special discount:</p>
                            <p>Total payable:</p>
                            @if ($isShowCodeCharge == 'on' || $order->total_cod_charge > 0)
                                <p>
                                    COD charge
                                    ({{ round((100 * $order->total_cod_charge) / $order->grand_total) }}%):
                                </p>
                            @endif
                            <p>Paid amount:</p>
                            <p>Cash to collect:</p>
                        </div>

                        <div class="col-3">
                            <p>
                                <span style="font-size: 7px"></span>৳
                                {{ number_format($order->shipping_cost, 2, '.', '') }}
                            </p>
                            <p>
                                <span style="font-size: 7px"></span>৳
                                {{ number_format($order->total_discount_amount, 2, '.', '') }}
                            </p>
                            <p>
                                <span style="font-size: 7px"></span>৳
                                {{ number_format($order->coupon_discount_amount, 2, '.', '') }}
                            </p>
                            <p>
                                <span style="font-size: 7px"></span>৳
                                {{-- {{ number_format($order->total_vat_amount, 2, '.', '') }} --}}
                                {{ number_format($order->special_discount, 2, '.', '') }}
                            </p>
                            <p>
                                <span style="font-size: 7px"></span>৳
                                {{ number_format($order->grand_total - $order->total_cod_charge, 2, '.', '') }}
                            </p>
                            @if ($isShowCodeCharge == 'on' || $order->total_cod_charge > 0)
                                <p>
                                    <span style="font-size: 7px"></span>৳
                                    {{ number_format($order->total_cod_charge, 2, '.', '') }}
                                </p>
                            @endif
                            <p>
                                <span style="font-size: 7px"></span>৳
                                {{ number_format($order->paid_amount, 2, '.', '') }}
                            </p>
                            <p>
                                <span style="font-size: 7px;"></span>৳
                                {{ number_format($order->grand_total, 0, '.', '') }}
                            </p>
                        </div>
                    </div>
                    <div class="divider-line"></div>
                    <div class="text-left" style="text-align: left">
                        <span>{{ $order->payment_type == 'COD' ? 'Cash on delivery' : 'Online payment' }}</span>
                    </div>
                    <div class="divider-line"></div>
                    <div class="text-left" style="text-align: left">
                        <span>Helpline:{{ $company->phone }}</span>
                    </div>
                    <div class="divider-line"></div>
                </div>
            </div>


            <!-- INVOICE FOOTER -->
            <div class="footer" style="text-align: justify;">
                <span style="text-align: justify;">
                    @if ($company->bill_footer != '')
                        {{ $company->bill_footer }}
                    @else
                        Thanks for choosing Safwah Mart (A concern of Safwah Ltd). Product
                        return only allowed, if physical damage during delivery with appropriate
                        proof & invoice within 24hrs after receiving the products. (Condition applied)
                        *Total is inclusive of VAT (Calculated as per GO 02/Mushak/2019). This is a
                        system generate invoice and no signature or seal is required.
                    @endif
                </span>
            </div>
        </div>
    </section>

    <script>
        // window.print()
    </script>
</body>

</html>
