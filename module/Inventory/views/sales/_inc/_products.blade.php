@if (isset($products))
    @foreach ($products as $product)

        @php
            $discountPercent   = 0;
            $discountPrice     = 0;

            if ($product->discount) {
                $discountPercent   = $product->discount->discount_percentage;
                // $discountPrice     = round($product->sale_price - getDiscount($product->id));
                $discountPrice = getDiscountAmount($product->sale_price, $product->discount->discount_percentage);
            } else if($product->discount_percentage > 0) {
                $discountPercent   = $product->discount_percentage;
                // $discountPrice     = getDiscountAmount($product->sale_price, $discountPercent);
                $discountPrice = getDiscountAmount($product->sale_price, $product->discount_percentage);
            }

            $vatPercent = $product->vat ?? 0;

            if($product->vat != null && $product->vat_type == 'Percent') {
                $price = $discountPrice != 0 ? $discountPrice : $product->sale_price;
                $vatPercent = ($product->vat / $price) * 100;
            }
        @endphp


        <div class="col-md-3 mb-2">
            <div class="product">

                <input type="hidden" class="item-id" value="{{ $product->id }}">
                <input type="hidden" class="item-name" value="{{ $product->name }}">
                <input type="hidden" class="item-sku" value="{{ $product->sku }}">
                <input type="hidden" class="item-purchase-price" value="{{ $product->purchase_price }}">
                <input type="hidden" class="item-sale-price" value="{{ $product->sale_price }}">
                <input type="hidden" class="item-discount-price" value="{{ $discountPrice }}">
                <input type="hidden" class="item-vat-percent" value="{{ $vatPercent }}">
                <input type="hidden" class="item-discount-percent" value="{{ $discountPercent }}">
                <input type="hidden" class="item-unit" value="{{ optional($product->unitMeasure)->name }}">
                <input type="hidden" class="item-sub-text" value="{{ $product->sub_text }}">
                <input type="hidden" class="item-is-variation" value="{{ $product->is_variation }}">
                <input type="hidden" class="item-is-measurement" value="{{ count($product->productMeasurements) > 0 ? 'Yes' : 'No' }}">
                <input type="hidden" class="item-current-stock" value="{{ $product->current_stock ?? 0 }}">

                <a href="javascript:void(0)" class="card-info">
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="p-name">
                                {{-- {{ Str::limit($product->name, 35, '...') }} --}}
                                {{ $product->name }}
                            </div>

                            <div class="d-flex justify-content-between">
                                @if ($discountPercent != 0)
                                    <del>
                                        <small>
                                            {{ number_format($product->sale_price, 2, '.', '') }}
                                        </small>
                                    </del>
                                    <b>
                                        {{ $discountPrice }} ৳
                                    </b>
                                @else
                                    <b>
                                        {{ number_format($product->sale_price, 2, '.', '') }} ৳
                                    </b>
                                @endif
                                <span class="badge {{ $product->current_stock == 0 ? 'bg-danger' : 'bg-success' }}">{{ $product->current_stock == 0 ? 'Stock Out' : number_format($product->current_stock, 2, '.', '') }}</span>
                            </div>
                        </div>
                    </div>
                </a>

                @if ($product->current_stock == 0)
                    <a href="javascript:void(0)" class="card-overlay" type="button">
                        <i class="fas fa-exclamation-circle add-icon-stock-out position-absolute"></i>
                    </a>
                @elseif ($product->is_variation == 'Yes')
                    <a href="javascript:void(0)" type="button" class="card-overlay" data-bs-toggle="modal" onclick="appendVariationToModal({{ $product }})">
                        <i class="fas fa-plus add-icon position-absolute"></i>
                    </a>
                @elseif (count($product->productMeasurements) > 0)
                    <a href="javascript:void(0)" type="button" class="card-overlay" data-bs-toggle="modal" onclick="appendMeaurementToModal({{ $product }})">
                        <i class="fas fa-plus add-icon position-absolute"></i>
                    </a>
                @else
                    <a href="javascript:void(0)" class="card-overlay" type="button" onclick="addItem(this)">
                        <i class="fas fa-plus add-icon position-absolute"></i>
                    </a>
                @endif
            </div>
        </div>
    @endforeach


    <div class="d-flex justify-content-center">
        {!! $products->links() !!}
    </div>
@endif













