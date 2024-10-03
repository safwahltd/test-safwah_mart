<div class="bottom-menu">
    <div class="menu d-flex align-items-center justify-content-between fixed-bottom text-center text-light font-weight-bold px-4">
        <a href="javascript:void(0)" class="">
            <i class="navbar-tool-icon czi-document mt-1"></i>
            <p style="margin-top: -10px">Upload Rx</p>
        </a>
{{--        <a class="text-center"--}}
{{--            href="{{ route('cus-auth.wishlist', auth()->guard('customer')->user()->id) }}">--}}
{{--            <i class="navbar-tool-icon czi-heart mt-1"></i>--}}
{{--            <span class="menu-tool-label">--}}
{{--                <span class="wishlist">0</span>--}}
{{--            </span>--}}
{{--            <p style="margin-top: -10px">Wishlist</p>--}}
{{--        </a>--}}
        <a class="text-center"
           @if(!empty(auth()->guard('customer')->user()->id))
            href="{{ route('cus-auth.my-profile') }}"
           @else
               href="javascript:void(0)"
               data-toggle="modal" data-type="login" onclick="changeModalType(this)" data-target="#authModal"
           @endif

        >
            <i class="navbar-tool-icon czi-user mt-1"></i>
            <p style="margin-top: -10px">Account</p>
        </a>
        <a class="text-center" href="{{ route('cart') }}">
            <i class="navbar-tool-icon czi-cart mt-1"></i>
            <span class="menu-tool-label">
                <span class="cart">0</span>
            </span>
            <p style="margin-top: -10px">Cart</p>
        </a>
    </div>
</div>

