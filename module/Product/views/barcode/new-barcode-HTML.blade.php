<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ __('barcode.print_labels') }}</title>

    <style type="text/css">
        .text-center {
            text-align: center;
        }
        .text-uppercase {
            text-transform: uppercase;
        }
        /*Css related to printing of barcode*/
        .label-border-outer {
            border: 0.1px solid grey !important;
        }
        .label-border-internal {
            /*border: 0.1px dotted grey !important;*/
        }
        .sticker-border {
            border: 0.1px dotted grey !important;
            overflow: hidden;
            box-sizing: border-box;
        }
        #preview_box {
            padding-left: 30px !important;
        }
        @media print {
            .content-wrapper {
                border-left: none !important;
                /*fix border issue on invoice*/
            }

            .label-border-outer {
                border: none !important;
            }

            .label-border-internal {
                border: none !important;
            }

            .sticker-border {
                border: none !important;
            }

            #preview_box {
                padding-left: 0px !important;
            }

            #toast-container {
                display: none !important;
            }

            .tooltip {
                display: none !important;
            }

            .btn {
                display: none !important;
            }
        }

        @media print {
            #preview_body {
                /* display: block !important; */
            }
        }

        @page {

            size: 1.49in 1in;
            width: 1.49in !important;
            height: 1in !important;
            /* page-break-inside : avoid !important; */
            /* page-break-after: always !important; */
            /* page-break-before: always !important; */
        }
    </style>

</head>

<body>



    <div id="preview_body">

            {{-- Actual Paper --}}
            <div style="height:{{ 1.079 * 0.95 }}in !important; width: 1.49in !important; line-height: 16px !important; page-break-after: always;">

                {{-- Paper Internal --}}
                <div class="label-border-internal">

                    <div style="float: left; font-size: 12px; height: 1.079in !important; line-height: 1.079in; width:{{ 1.6 * 0.97 }}in !important; display: inline-block;" class="sticker-border text-center">
                        <div style="display:inline-block; vertical-align:middle; line-height:13px !important;">

                            {{-- Product Name --}}
                            <span style="display: block !important; height: 26px; overflow: hidden">
                                {{ 'product_actual_name' }}
                            </span>

                            {{-- Variation --}}
                            <span style="display: block !important">
                                <b>{{ 'product_variation_name' }}</b>
                            </span>
                            {{-- Barcode --}}
                            <img class="center-block"
                                style="max-width:90%; !important;height: {{ 1.079 * 0.3 }}in !important;"
                                src="data:image/png;base64,{{ DNS1D::getBarcodePNG('02348023', 'C128', 3, 70, [39, 48, 54], false) }}">
                            {{-- Price --}}
                            <p style="margin: 2px">
                                {{ 'sub_sku' }}
                                TK
                                {{ '200' }}
                            </p>
                            {{-- Business Name --}}
                            <span style="display: block !important">monowamart.com</span>

                        </div>
                    </div>

                </div> {{-- Paper Internal --}}


            </div> {{-- Actual Paper --}}

    </div>




    <script>
        setTimeout(function() {
            window.print();
        }, 1000)
    </script>

</body>

</html>
