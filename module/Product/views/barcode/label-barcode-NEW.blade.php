<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>

        @import url('https://fonts.googleapis.com/css2?family=BIZ+UDPMincho&display=swap');

        * {
            margin: 0px !important;
            padding: 0px !important;
            box-sizing: border-box !important;
            /* font-family: 'Alef', sans-serif; */
            font-family: 'BIZ UDPMincho', serif;
        }

        .page-break {
            display: block;
            page-break-inside: avoid;
        }

        .page-header {
            display: none !important;
        }

        .btn {
            display: none !important;
        }

        .label-print {
            padding: 3px !important;
            text-align: center !important;
            font-size: 1.05rem;
        }
        #allPrintList {
            text-align: center !important;
            font-size: 7px !important;
            width: 831.49606299px !important;
            height: 1322.8346457px !important;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            background-color: #efefef !important;
        }

        .all-print {
            width: calc(105.6px + 32.982677165px) !important;
            height: 67.2px !important;
        }

        .barcode--product_name {
            line-height: 11px;
            margin-bottom: 3px !important;
            margin-top: 2px !important;
        }

        .barcode--product_image {
            width: 83%;
            margin: 0px auto;
            height: 20px
        }

        .barcode--product_barcode-and-mrp {
            font-size: .9rem;
        }

        .barcode--company-website {
            font-size: .9rem !important;
        }

        @media print {
            @page {
                /* size: 22cm 35cm; */
                size: 1.49in 1in;
            }
        }


        .main-body {
            display: flex;
            flex-wrap: wrap;
        }
        .main-body .page-break {
            /* width: 143.04px !important; */
            width: 138.582677165px !important;
            /* height: 96px !important; */
            height: 75px !important;
            text-align: center !important;
            margin: 14px 6px !important;
        }


    </style>

</head>
<body>

    <div class="main-body">


        @for ($i = 1; $i <= $quantity; $i++)
            <div class="page-break all-print">
                {{-- <p class="all-print--product_name">{{ $name }}</p>
                <img class="all-print--product_image" src="data:image/png;base64, {{ DNS1D::getBarcodePNG($barcode , "C128") }}" alt="barcode" />
                <p class="all-print--product_barcode-and-mrp">{{ $barcode  }} ৳ {{ $price != '' ? $price : 0  }}</p>
                <p class="all-print--company-website">{{ optional(\App\Models\Company::find(1))->website }}</p> --}}
                <p class="barcode--product_name">{{ $name }}</p>
                <img class="barcode--product_image" src="data:image/png;base64, {{ DNS1D::getBarcodePNG($barcode , "C128") }}" alt="barcode" />
                <p class="barcode--product_barcode-and-mrp">{{ $barcode  }} ৳ {{ $price != '' ? $price : 0  }}</p>
                <p class="barcode--company-website">{{ optional(\App\Models\Company::find(1))->website }}</p>
            </div>
        @endfor


    </div>


    <script>
        setTimeout(function(){
            window.print();
        }, 1000)
    </script>

</body>
</html>
