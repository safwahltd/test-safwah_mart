

<div id="cart_items" class="cart-top">
    <div class="navbar-tool dropdown ml-3" style="margin-right: 6px">
        <a class="navbar-tool-icon-box bg-secondary dropdown-toggle"
           href="javascript:void(0)">
               <span class="navbar-tool-label cart-item-count" id="cart-item-count">

               </span>
            <i class="navbar-tool-icon czi-cart this-cart"></i>
        </a>
        <a class="navbar-tool-text" href="javascript:void(0)">
            <small>My cart</small>
            @if(isset($cart_data))
                @if(\Illuminate\Support\Facades\Cookie::get('my_cart'))
                    @php $total = []; @endphp
                    @foreach($cart_data as $item)
                        @php $total[] = $item['item_price'] * $item['item_quantity']; @endphp
                    @endforeach
                    @php $total = array_sum($total); @endphp
                @endif
            @endif
            {{ $total ?? 0 }}৳
        </a>

        <div class="dropdown-menu dropdown-menu-right" style="width: 20rem;">
            <div class="widget widget-cart px-3 pt-2 pb-3">
                <div style="height: 15rem;" data-simplebar="init" data-simplebar-auto-hide="false">
                    <div class="simplebar-wrapper" style="margin: 0px;">
                        <div class="simplebar-height-auto-observer-wrapper">
                            <div class="simplebar-height-auto-observer"></div>
                        </div>
                        <div class="simplebar-mask">
                            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                <div class="simplebar-content-wrapper"
                                     style="height: auto !important; overflow-y: auto;">

                                    <div class="simplebar-content all-cart-item" id="cartContent"
                                         style="padding: 0px; height: auto !important;">
                                        @if(isset($cart_data))
                                            @if(Cookie::get('my_cart'))
                                                @php $total = []; @endphp
                                                @forelse($cart_data as $item)
                                                    <div class="widget-cart-item pb-2"
                                                         style="height: 80px">
                                                        <button style="top: 62px !important;"
                                                                class="close text-danger"
                                                                type="button"
                                                                onclick="deleteFromCart(this)"
                                                                data-product-id="{{ $item['item_id'] }}"
                                                                aria-label="Remove"><span
                                                                aria-hidden="true">×</span>
                                                        </button>
                                                        <div class="media pb-2"
                                                             style="height: 80px; padding-top: 10px; background: transparent !important">
                                                            <a class="d-block mr-2"
                                                               href="{{ route('non-prescriptions', $item['item_slug']) }}">
                                                                <img width="60"
                                                                     src="{{ asset($item['item_image'] ?? 'assets/images/default/product/default.png') }}"
                                                                     alt="Product">
                                                            </a>
                                                            <div style="height: 80px !important;">
                                                                <div class="media-body"
                                                                     style="height: 80px !important;">
                                                                    <a href="{{ route('non-prescriptions', $item['item_slug']) }}"
                                                                       style="font-size: 14px;">
                                                                        {{ Str::limit($item['item_name'], 30) }}
                                                                    </a>
                                                                    <div class="widget-product-meta">
                                                                        <span class="text-muted mr-2" style="font-size: 14px">{{ $item['item_quantity'] }} x</span>
                                                                        <span class="text-accent mr-2" style="font-size: 14px">
                                                                            @php $itemPrice = $item['item_price'] - ($item['item_price'] * $item['item_discount'] / 100) @endphp
                                                                            {{ number_format($itemPrice, 2) }}৳
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php $total[] = $itemPrice * $item['item_quantity']; @endphp
                                                @empty
                                                    <div class="text-center pt-5">
                                                        <p class="pt-5"><strong>Your Cart is
                                                                Empty!</strong></p>
                                                    </div>
                                                @endforelse
                                                @php $total = array_sum($total); @endphp
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="simplebar-placeholder" style="width: 0px; height: 0px;"></div>
                    </div>
                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                        <div class="simplebar-scrollbar simplebar-visible"
                             style="width: 0px; display: none;"></div>
                    </div>
                    <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                        <div class="simplebar-scrollbar simplebar-visible"
                             style="height: 0px; display: none;"></div>
                    </div>
                </div>
                <hr>
                <div class="d-flex flex-wrap justify-content-between align-items-center py-3">
                    <div class="font-size-sm mr-2 float-right py-2 ">
                        <span class="">Subtotal :</span>
                        <span class="text-accent font-size-base ml-1">
                            {{ number_format($total ?? 0, 2, '.', '') }}৳
                        </span>
                    </div>
                    <a class="btn btn-outline-secondary btn-sm"
                       href="{{ route('cart') }}">
                        Cart<i class="czi-arrow-right ml-1 mr-n1"></i>
                    </a>
                </div>
                <a class="btn btn-primary btn-sm btn-block"
                   @if (Cookie::get('my_cart') == null)
                        href="{{ route('index') }}"
                   @else
                        href="{{ route('checkouts.create') }}"
                   @endif
                >
                    <i class="czi-card mr-2 font-size-base align-middle"></i>Checkout
                </a>
            </div>
        </div>
    </div>
</div>


<script>
    $('.cart-item-count').html(`{{ $totalcart }}`);
</script>
