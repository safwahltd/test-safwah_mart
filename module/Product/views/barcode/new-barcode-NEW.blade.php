@php

    //---------- BARCODE SETTINGS VARIABLE ----------//

    $top_margin = 0;
    $left_margin = 0;

    $paper_width = 1.49;
    $paper_height = 1;

    $width = 1.6;
    // $height                 = 0.98;
    $height = 1.079;

    $stickers_in_one_row = 1;
    $stickers_in_one_sheet = 1;

    $col_distance = 0.1;
    $row_distance = 0;

    $is_continuous = false;

    //---------- PRODUCT DETAILS VARIABLE ----------//

    $product_actual_name = $name;
    $product_variation_name = 'product variation name';
    $variation_name = 'variation_name';

    $sub_sku = 'Sub SKU';
    $barcode = $barcode;
    $barcode_type = 'C128';

    $sell_price_inc_tax = '';
    $default_sell_price = $price;

    $is_dummy = false;

    $quantity = $quantity;

@endphp

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

            size: {{ $paper_width }}in @if (!$is_continuous && $paper_height != 0) {{ $paper_height }}in @endif;
            /* size: {{ $paper_width }}in {{ $paper_height }}in; */

            width: {{ $paper_width }}in !important;
            height: @if ($paper_height != 0) {{ $paper_height }}in !important @else auto @endif;

            /* margin-top: 0in;
            margin-bottom: 0in;
            margin-left: 0in;
            margin-right: 0in; */

            /* page-break-inside : avoid !important; */
            /* page-break-after: always !important; */
            /* page-break-before: always !important; */


            @if($barcode_details->is_continuous)
                /*page-break-inside : avoid !important;*/
            @endif

        }
    </style>

</head>

<body>

    <div id="preview_body">

        @php
            $loop_count = 0;
        @endphp

        @for ($i = 1; $i <= $quantity; $i++)
            @while ($quantity > 0)
                @php
                    $loop_count += 1;
                    $is_new_row = $stickers_in_one_row == 1 || $loop_count % $stickers_in_one_row == 1 ? true : false;

                    $is_new_paper = ($is_continuous && $is_new_row) || (!$is_continuous && $loop_count % $stickers_in_one_sheet == 1);

                    $is_paper_end = ($is_continuous && $loop_count % $stickers_in_one_row == 0) || (!$is_continuous && $loop_count % $stickers_in_one_sheet == 0);

                @endphp

                @if ($is_new_paper)
                    {{-- Actual Paper --}}
                    <div style="@if (!$is_continuous) height:{{ $paper_height * 0.95 }}in !important; @else height:{{ $height * 0.95 }}in !important; @endif width:{{ $paper_width }}in !important; line-height: 16px !important; page-break-after: always;"
                        class="@if (!$is_continuous) label-border-outer @endif">

                        {{-- Paper Internal --}}
                        <div style="@if (!$is_continuous) margin-top:{{ $top_margin }}in !important; margin-bottom:{{ $top_margin }}in !important; margin-left:{{ $left_margin }}in !important;margin-right:{{ $left_margin }}in !important; @endif"
                            class="label-border-internal">
                @endif

                @if (!$is_continuous && $loop_count % $stickers_in_one_sheet <= $stickers_in_one_row)
                    @php $first_row = true @endphp
                @elseif($is_continuous && $loop_count <= $stickers_in_one_row)
                    @php $first_row = true @endphp
                @else
                    @php $first_row = false @endphp
                @endif

                <div style="float: left; font-size: 12px; height:{{ $height }}in !important; line-height: {{ $height }}in; width:{{ $width * 0.97 }}in !important; display: inline-block; @if (!$is_new_row) margin-left:{{ $col_distance }}in !important; @endif @if (!$first_row) margin-top:{{ $row_distance }}in !important; @endif"
                    class="sticker-border text-center">
                    <div style="display:inline-block;vertical-align:middle;line-height:13px !important;">

                        {{-- Product Name --}}
                        <span style="display: block !important; height: 26px; overflow: hidden">
                            {{ $product_actual_name }}
                        </span>

                        {{-- Variation --}}
                        <span style="display: block !important">
                            <b>{{ $product_variation_name }}</b>
                        </span>
                        {{-- Barcode --}}
                        <img class="center-block"
                            style="max-width:90%; !important;height: {{ $height * 0.3 }}in !important;"
                            src="data:image/png;base64,{{ DNS1D::getBarcodePNG($barcode, $barcode_type, 3, 70, [39, 48, 54], false) }}">
                        {{-- Price --}}
                        <p style="margin: 2px">
                            {{ $sub_sku }}
                            TK
                            {{ number_format($default_sell_price, 2) }}
                        </p>
                        {{-- Business Name --}}
                        <span style="display: block !important">monowamart.com</span>
                    </div>
                </div>

                @if ($is_paper_end)
                        {{-- Actual Paper --}}
                        </div>

                    {{-- Paper Internal --}}
                    </div>
                @endif

                @php
                    $quantity = $quantity - 1;
                @endphp

            @endwhile
        @endfor

        @if (!$is_paper_end)
                {{-- Actual Paper --}}
                </div>

            {{-- Paper Internal --}}
            </div>
        @endif


    </div>


    <script>
        setTimeout(function() {
            window.print();
        }, 1000)
    </script>

</body>

</html>
