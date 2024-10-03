<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice 1</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <style>
        @page {
            header: page-header;
            footer: page-footer;
            sheet-size: Letter;
            margin: 0 !important;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            width: 816px;
            height: 1056px;
            margin: 0px auto;
            background: rgb(224, 224, 224)
        }
        @media print {
            body{
                header: page-header;
                footer: page-footer;
                sheet-size: Letter;
                margin: 0 !important;
                background: #efefef;
                font-family: 'Fira Code';
                font-size: 15px;
                font-weight: 600;
            }
            .invoice {
                margin-top: 0 !important;
                margin-bottom: 0 !important;
            }
        }

        /* .row:after {
            content: "";
            display: table;
            clear: both;
        } */
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
            background: #ffffff;
            width: 831px;
            height: 597px;
            margin: 0 auto;
            margin-top: 50px;
            margin-bottom: 50px;
            padding: 20px;
            overflow: hidden;
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
            height: 100%;
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
            padding: 4px 8px;
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
            padding-right: 0 !important;
        }
        .order-note {
            padding: 10px 0;
            margin-top: 10px;
            margin-bottom: 10px;
            text-align: left;
        }
        .footer {
            position: absolute;
            right: 0;
            bottom: 0 !important;
            left: 0;
            padding: 1rem;
            text-align: center;
        }
        .footer-message {
            /* position: absolute;
            right: 0;
            bottom: 0 !important;
            left: 0; */
            padding: 1rem;
            padding-left: 0;
            text-align: center;
        }
        .barcode-img{
            height : 50px;
            width: 100px;
        }
        tr:nth-child(even) {
            background: #ccc
        }
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
        #block_container
        {
            padding-top: 55px;
        }
        #bloc1, #bloc2
        {
            display:inline;
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
            tr.page-break  { display: block; page-break-after: always; }
        }
    </style>

    <style>
        ul li{
            list-style: none;
        }
        .d-flex{display: flex;}
        .justify-content-between{
            justify-content: space-between;
        }
        .company-info-invoice i{
            margin-right: 4px;
        }
        .company-info-invoice p {
            font-size: 14px;
        }
        table tr th{
            text-align: left;
        }
        table tr td{
            text-align: left;
        }
        .footer-message p {
            margin-bottom: 15px;
            color: #665f5f;
        }
        .footer-message span {
            color: #665f5f;
            display: block;
            text-align: left;
        }
        .balance-to-pay {
            padding: 5px;
            border: 2px solid black;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 10px;
            display: inline-block;
        }
        .left-side {
            text-align: left;
        }
        .straight-line{
            border-bottom: 2px solid black;
            margin: 3px 0;
        }
    </style>

</head>
<body>
    <section class="invoice">
        <div class="container">

            {{-- TOP PART OF INVOICE --}}
            <div id="topPart">


                {{-- INVOICE HEADER --}}
                <div class="invoice-info" style="margin-top:0 !important">

                    <div class="row d-flex justify-content-between">
                        <div class="col-4" style="width: 33.33%">
                            <div class="company-logo">
                                <img src="{{ asset('assets/images/2022/Jul/11656733886-830961.webp') }}" alt="Logo" class="logo">
                            </div>
                        </div>
                        <div class="col-4" style="width: 33.33%">
                            <div class="print-copy-info">
                                <p style="font-size: 20px; text-align:center; text-transform: uppercase;"> Invoice </p>
                                <div class="text-center">
                                    <img class="barcode-img pt-1" src="https://barcode.tec-it.com/barcode.ashx?data=ABC-abc-1234&code=Code128&translate-esc=on" alt="barcode" />
                                </div>
                            </div>
                        </div>
                        <div class="col-4" style="width: 33.33%; text-align:right;">
                            <div class="company-info-invoice">
                                <ul>
                                    <li class="d-flex">
                                        <i class="fab fa-facebook-square"></i>
                                        <p>facebook.com/monowamart</p>
                                    </li>
                                    <li class="d-flex">
                                        <i class="fas fa-globe"></i>
                                        <p>https://monowamart.com</p>
                                    </li>
                                    <li class="d-flex">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <p>lasdf sdlfjldsjf, dhaka, 1200</p>
                                    </li>
                                    <li class="d-flex">
                                        <i class="fas fa-envelope"></i>
                                        <p>monowamart@gmail.com</p>
                                        </li>
                                    <li class="d-flex">
                                        <i class="fas fa-phone-square"></i>
                                        <p>3402340232</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-between">
                        <div class="col-4" style="width: 30%">
                            <div class="user-info">
                                <p>Name</p>
                                <p>address</p>
                                <p>Mob: <b>40340128340</b></p>
                            </div>
                        </div>
                        <div class="col-4" style="width: 30%">
                            <div class="shipping-address">
                                <b>Shipping Address</b>
                                <p>address</p>
                            </div>
                        </div>
                        <div class="col-4" style="width: 40%; text-align:right;">
                            <div class="company-info-invoice">
                                <div class="">
                                    <div class="d-flex">
                                        <div class="text-side">
                                            <p class="text-left">Invoice No:</p>
                                            <p class="text-left">Order Date:</p>
                                            <p class="text-left">Payment Method:</p>
                                        </div>
                                        <div class="info-side" style="margin-left: 30px;">
                                            <span style="display: block; text-align:left;"><b>3204830</b></span>
                                            <span style="display: block; text-align:left;">March 13, 2022</span>
                                            <span style="display: block; text-align:left;">Cash on delivery</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                {{-- INVOICE TABLE --}}
                <div class="product-info">
                    <table>
                        <thead>
                            <tr>
                                <th width="7%">NO</th>
                                <th width="15%">SKU</th>
                                <th width="35%">PRODUCT</th>
                                <th width="8%" class="text-center">QTY</th>
                                <th width="20%" class="text-right">UNIT PRICE</th>
                                <th width="15%" class="text-right">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-left">1</td>
                                <td class="text-left">12323</td>
                                <td class="text-left">Product Name</td>
                                <td class="text-center">
                                    1
                                </td>
                                <td class="text-right">
                                    190.00
                                </td>

                                <td class="text-right">
                                    180.00
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">1</td>
                                <td class="text-left">12323</td>
                                <td class="text-left">Product Name</td>
                                <td class="text-center">
                                    1
                                </td>
                                <td class="text-right">
                                    190.00
                                </td>

                                <td class="text-right">
                                    180.00
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">1</td>
                                <td class="text-left">12323</td>
                                <td class="text-left">Product Name</td>
                                <td class="text-center">
                                    1
                                </td>
                                <td class="text-right">
                                    190.00
                                </td>

                                <td class="text-right">
                                    180.00
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">1</td>
                                <td class="text-left">12323</td>
                                <td class="text-left">Product Name</td>
                                <td class="text-center">
                                    1
                                </td>
                                <td class="text-right">
                                    190.00
                                </td>

                                <td class="text-right">
                                    180.00
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


            </div>

            {{-- BOTTOM CALCULATION PART OF INVOICE --}}
            <div id="bottomPart" style="height: 350px">
                <div class="row" style="display: flex; justify-content:space-between">

                    <div class="col-sm-4 col-lg-4 col-md-4 order-note" style="width: 50%;">
                        <p>Quantity Total : <span>3</span></p>
                        <div class="balance-to-pay">
                            Balance to pay : 800.00
                        </div>
                    </div>

                    <div class="col-sm-8 col-lg-8 col-md-8 ">
                        <div class="invoice-price" style="width: 280px;">
                            <div class="row" style="display: flex; justify-content: space-between;">
                                <div class="left-side">
                                    <p><b>Subtotal:</b> </p>
                                </div>
                                <div class="right-side">
                                    <p>400.00</p>
                                </div>
                            </div>
                            <p class="straight-line"></p>
                            <div class="row" style="display: flex; justify-content: space-between;">
                                <div class="left-side">
                                    <p><b>Shipping:</b> </p>
                                </div>
                                <div class="right-side">
                                    <p>400.00</p>
                                </div>
                            </div>
                            <p class="straight-line"></p>
                            <div class="row" style="display: flex; justify-content: space-between;">
                                <div class="left-side">
                                    <p><b>Total:</b> </p>
                                </div>
                                <div class="right-side">
                                    <p>400.00</p>
                                </div>
                            </div>
                            <p class="straight-line"></p>
                            <div class="row" style="display: flex; justify-content: space-between;">
                                <div class="left-side">
                                    <p><b>Advance:</b> </p>
                                </div>
                                <div class="right-side">
                                    <p>400.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="footer-message">
                    <p>Thank you For Shopping With Us! Enjoy Shopping @ www.monowamart.com</p>
                    <span>Prepared by: azad</span>
                </div>

            </div>


        </div>
    </section>

    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>
