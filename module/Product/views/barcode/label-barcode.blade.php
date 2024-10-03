@for ($i = 1; $i <= $quantity; $i++)
    <div class="page-break label-print">
        {{-- <p class="label-print--product_name">{{ $name }}</p>
        <img class="label-print--product_image" src="data:image/png;base64, {{ DNS1D::getBarcodePNG($barcode , "C128") }}" alt="barcode" />
        <p class="label-print--product_barcode-and-mrp">{{ $barcode  }} ৳ {{ $price != '' ? $price : 0  }}</p>
        <p class="label-print--company-website">{{ optional(\App\Models\Company::find(1))->website }}</p> --}}
        <p class="barcode--product_name">{{ $name }}</p>
        <span class="variation-name">
            <b>{{ $variation_name }}</b>
        </span>
        <img class="barcode--product_image" src="data:image/png;base64, {{ DNS1D::getBarcodePNG($barcode , "C128") }}" alt="barcode" />
        <p class="barcode--product_barcode-and-mrp">{{ $barcode  }} ৳ {{ $price != '' ? $price : 0  }}</p>
        <p class="barcode--company-website">{{ optional(\App\Models\Company::find(1))->website }}</p>
    </div>
@endfor
