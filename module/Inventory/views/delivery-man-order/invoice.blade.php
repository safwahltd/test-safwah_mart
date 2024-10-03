<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Sale Invoice</title>




        <style>
            @page {
                header: page-header;
                footer: page-footer;
                sheet-size: A4;
                margin: 0 !important;
            }
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            @media print {
                body{
                    header: page-header;
                    footer: page-footer;
                    sheet-size: A4;
                    margin: 0 !important;
                    background: #efefef;
                    font-family: 'Fira Code';
                    font-size: 15px;
                    font-weight: 600;
                }
                #invoice {
                    margin-top: 0 !important;
                    margin-bottom: 0 !important;
                }
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

            #invoice {
                background: #ffffff;
                width: 210mm;
                height: 279mm;
                margin: 0 auto;
                margin-top: 50px;
                margin-bottom: 50px;
                padding: 20px;
            }

            .container {
                padding: 5px 50px;
                height: 100%;
                position: relative;
            }

            .company-logo {
                width: 220px;
            }
            .company-info-invoice{
                margin-bottom: 28px;
                font-size: 13px;
            }
            .print-copy-info{
                margin-bottom: 15px;
                font-size: 13px;
            }

            .logo {
                width: 100%;
            }

            .company-info {
                font-size: 15px;
                text-align: center;
            }

            .receipt-heading {
                text-align: center;
                font-weight: 700;
                margin: 0 auto;
                margin-top: 10px;
                margin-bottom: 5px;
                max-width: 450px;
                position: relative;
            }

            .receipt-heading:before {
                content: "";
                display: block;
                width: 130px;
                height: 2px;
                background: #18181b;
                left: 0;
                top: 50%;
                position: absolute;
            }

            .receipt-heading:after {
                content: "";
                display: block;
                width: 130px;
                height: 2px;
                background: #18181b;
                right: 0;
                top: 50%;
                position: absolute;
            }

            .invoice-info {
                /* margin-top: 10px; */
                margin-bottom: 10px;
            }

            .invoice-info .date {
                text-align: right;
            }

            table {
                width: 100%;
            }

            table, th {
                border-top: 1px solid black;
                border-bottom: 1px solid black;
                border-collapse: collapse;
            }

            th, td {
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
                padding: 10px;
                margin-top: 10px;
                margin-bottom: 10px;
                text-align: right;
            }

            .footer {
                position: absolute;
                right: 0;
                bottom: 0 !important;
                left: 0;
                padding: 1rem;
                text-align: center;
            }
            .barcode-img{
                height : 50 px;
                width: 100 px;
            }

            tr:nth-child(even) {background: #ccc}
            #print-div {
                /* visibility: hidden; */
                /* display:none; */

                }

            .copy {
                font-size:20px;
            }

            .hr {
                width: 50%;
                float: right;
                /* width: 130px; */
                height: 2px;
                background: #000000;
            }

        </style>


    </head>

    <body>




            @for($i=1; $i<=4; $i++)
                @php
                    if($i == 1)
                    {
                        $copy = "Customer Copy";
                    }elseif($i == 2){
                        $copy = "Accounts Copy";
                    }elseif($i == 3){
                        $copy = "Delivery Man Copy";
                    }else{
                        $copy = "Store Copy";
                    }

                @endphp
                <section id="invoice">

                    <div class="container">
                        <div class="invoice-info" style="margin-top:0 !important">
                            <div class="row">
                                <div class="col-6">
                                    <div class="company-logo">
                                        <img src="{{ asset($company->logo) }}" alt="Logo" class="logo">
                                    </div>
                                    <p>Name &nbsp&nbsp&nbsp&nbsp: {{ optional($order->customer)->name }}</p>
                                    <p>Mobile &nbsp&nbsp: {{ optional($order->customer)->mobile }}</p>
                                    <p>Address :{{ optional($order->orderCustomerInfo)->address }}</p>
                                    <p>Area &nbsp&nbsp&nbsp&nbsp&nbsp: {{ optional(optional($order->orderCustomerInfo)->area)->name }} | District : {{ optional(optional($order->orderCustomerInfo)->district)->name }}</p>
                                </div>
                                <div class="col-6 date">
                                    <div class="print-copy-info">
                                        <div>
                                            <p class="copy">{{ $copy }}</p>
                                            <hr class="hr">
                                        </div>
                                        {{-- <p>Tax Invoice (Mushak 6.3)</p> --}}
                                    </div>
                                    <div class="company-info-invoice">
                                        <p style="font-size: 18px">{{ optional($company)->name }}</p>
                                        <p>{{ optional($company)->address }}</p>
                                        <p>{{ optional($company)->hotline }}</p>
                                        {{-- <p>Tax Invoice (Mushak 6.3)</p> --}}
                                    </div>

                                    <p>
                                        {{-- Shipment : {{ optional($order->warehouse)->bin_no }} |  --}}
                                        {{-- Order : {{ $order->order_no }} --}}
                                    </p>
                                    <p>Created : {{ date('Y-m-d h:i:s A', strtotime($order->created_at)) }}</p>
                                    <p>Delivery Date : {{ date('Y-m-d', strtotime($order->delivery_date)) }}</p>
                                    <p>Delivery Time: {{ optional($order->timeSlot)->starting_time . ' - ' . optional($order->timeSlot)->ending_time }}</p>
                                    <p>{{ $order->payment_type == 'COD' ? 'Cash On Delivery' : '' }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="receipt-heading"> --}}
                        <div class="text-center">
                            <p style="font-size: 20px;"> Sales Invoice </p>
                            <p > Order No : {{ $order->order_no }}</p>
                            <img class="barcode-img pt-1" src="data:image/png;base64,{{ DNS1D::getBarcodePNG($order->order_no, "C128") }}" alt="barcode" />

                        </div>

                        <div class="product-info">
                            <table>
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th class="text-left">Item Details</th>
                                        <th>Qty</th>
                                        <th>Rate</th>
                                        <th>Discounted Price</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($order->orderDetails as $detail)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td style="line-height: 11px">
                                                {{ optional($detail->product)->name }}
                                                <br>
                                                {{ (optional($detail->productVariation)->name) }}
                                                <br>
                                                {{ optional($detail->product)->sub_text != null ? '('.optional($detail->product)->sub_text. ' ' . optional(optional($detail->product)->unitMeasure)->name .')' : '' }}
                                            </td>
                                            <td class="text-center">{{ number_format($detail->quantity, 2, '.', '') }}</td>
                                            <td class="text-center">{{ number_format($detail->sale_price, 2, '.', '') }}</td>
                                            <td class="text-center">{{$detail->discount_amount != 0 ? number_format($detail->sale_price-$detail->discount_amount, 2, '.', '') : '' }}</td>
                                            <td class="text-right">{{ number_format($detail->quantity * $detail->sale_price, 2, '.', '') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>


                            <div class="invoice-price">
                                <div class="row">
                                    <div class="col-10">
                                        <p>Subtotal: </p>
                                        <p>VAT:</p>
                                    </div>
                                    <div class="col-2">
                                        <p>{{ number_format($order->subtotal, 2, '.', '') }}</p>
                                        <p>{{ number_format($order->total_vat_amount, 2, '.', '') }}</p>
                                    </div>
                                </div>
                                ------------
                                <div class="row">
                                    <div class="col-10">
                                        <p>Shipping Cost : </p>
                                        <p>Discount:</p>
                                    </div>
                                    <div class="col-2">
                                        <p>{{ number_format($order->shipping_cost, 2, '.', '') }}</p>
                                        <p>(-) {{ number_format($order->discount_amount, 2, '.', '') }}</p>
                                    </div>
                                </div>


                                ------------
                                <div class="row">
                                    <div class="col-10">
                                        <p>Total Payable:</p>
                                        <p>Paid Amount: </p>
                                    </div>
                                    <div class="col-2">
                                        <p>{{ number_format($order->grand_total, 2, '.', '') }}</p>
                                        <p>0.0</p>
                                    </div>
                                </div>
                                ------------
                                <div class="row">
                                    <div class="col-10">
                                        <p>Cash To Collect:</p>
                                    </div>
                                    <div class="col-2">
                                        <p>{{ number_format($order->grand_total, 2, '.', '') }}</p>
                                    </div>
                                </div>

                            </div>

                        </div>




                        {{-- <div class="footer">
                            <p>Thanks for shopping with {{ optional($order->company)->name }}</p>
                            <p>Please visit {{ optional($order->company)->website }} for home delivery</p>
                            <p>For any queries complaints or feedback.</p>
                            <p>Please call {{ optional($order->company)->phone }}</p>
                        </div> --}}
                    </div>
                </section>
            @endfor

        <script type="text/javascript">
            // window.onafterprint = window.close;
            window.print();
        </script>
    </body>

</html>
