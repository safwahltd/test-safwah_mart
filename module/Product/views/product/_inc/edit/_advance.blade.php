

@if ($product->is_variation == 'Yes')
    <div id="productVariationDiv">
        @include('product._inc.edit._variation')
    </div>
@else
    <div id="productOpeningDiv">
        @include('product._inc.edit._opening')
    </div>
@endif