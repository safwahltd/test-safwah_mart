<div class="col-md-12 ">
    <div class="auto-complete-div">
        <p class="heading">Search results</p>
        <ul class="item-list">
            @if (isset($posProducts))
                @foreach ($posProducts as $posProduct)
                    @php
                        $availableStock = number_format($posProduct->stock_in_qty - optional($posProduct->product)->stock_out_qty, 2, '.', '');
                    @endphp
                    <li class="item">
                        <a href="javascript:void(0)" class="item-link">
                            <img src="{{ asset('default.png') }}" class="img" alt="">
                            <div class="ms-3 item-info">
                                <div style="display: flex !important; align-items: center !important; justify-content: space-between !important">
                                    <p class="item-name fw-bold mb-2">
                                        {{ optional($posProduct->product)->name }}
                                        @if (optional($posProduct->productVariation)->name != null)
                                            <span class="badge badge-warning ms-3"> {{ optional($posProduct->productVariation)->name }}</span>
                                        @endif
                                    </p>
                                    <p class="text-success item-stock">
                                        <strong>{{ $availableStock }}</strong>
                                    </p>
                                </div>
                                <p>
                                    <span class="badge badge-primary">SKU: {{ optional($posProduct->productVariation)->sku }}</span>
                                    <span class="badge badge-secondary">Code: {{ optional($posProduct->product)->code }}</span>
                                    <span class="badge badge-success">Barcode: {{ optional(optional($posProduct->product)->barcode)->barcode }}</span>
                                </p>
                                <p><strong>Price: 800 TK</strong></p>
                            </div>
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>