@php
    $companyInfos = \App\Models\Company::select('title', 'favicon_icon')->whereId(1)->first();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title') &mdash; {{ $companyInfos->title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{ asset('assets/front-end/js/unknown.js') }}"></script><link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/front-end/img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset($companyInfos->favicon_icon) }}">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Titillium+Web:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/owl.carousel.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/owl.theme.default.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/floating-label.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/simplebar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/tiny-slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/drift-basic.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/lightgallery.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/master.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/home.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/flash-deal.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/faq.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/product.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/product-details.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/product-dtl.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/user-profile.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/wishlist.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/cart.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/index.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/custom.css') }}" />



    @yield('styles')
</head>

<body class="toolbar-enabled">

@include('front-end.layouts._inc.auth._auth-modal')
@include('front-end.layouts._inc.auth._forgot-password-modal')

@include('front-end.layouts._inc.header')

@yield('content')

@include('front-end.layouts._inc.footer')
@include('front-end.layouts._inc.bottom-menu')

<a class="btn-scroll-top" href="#top" data-scroll>
    <span class="btn-scroll-top-tooltip text-muted font-size-sm mr-2">Top</span><i class="btn-scroll-top-icon czi-arrow-up"> </i>
</a>


<script src="{{ asset('assets/front-end/js/jquery-2.2.4.min.js') }}"></script>
<script src="{{ asset('assets/front-end/js/jquery-ui.js') }}"></script>

<script src="{{ asset('assets/front-end/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/front-end/js/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('assets/front-end/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/front-end/js/tiny-slider.min.js') }}"></script>
<script src="{{ asset('assets/front-end/js/smooth-scroll.polyfills.min.js') }}"></script>
<script src="{{ asset('assets/front-end/js/drift.min.js') }}"></script>
<script src="{{ asset('assets/front-end/js/lightgallery.min.js') }}"></script>
<script src="{{ asset('assets/front-end/js/lg-video.min.js') }}"></script>
<script src="{{ asset('assets/front-end/js/toastr.min.js') }}"></script>
<script src="{{ asset('assets/front-end/js/sweet-alert.min.js') }}"></script>
<script src="{{ asset('assets/front-end/js/theme.min.js') }}"></script>
<script src="{{ asset('assets/front-end/js/slick.min.js') }}"></script>
<script src="{{ asset('assets/front-end/js/prefixfree.min.js') }}"></script>
<script src="{{ asset('assets/front-end/js/category.js') }}"></script>
<script src="{{ asset('assets/front-end/js/contact-us.js') }}"></script>
<script src="{{ asset('assets/front-end/js/product.js') }}"></script>
<script src="{{ asset('assets/front-end/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/front-end/js/brand-category-carousel.js') }}"></script>

<script type="text/javascript">

    $(function () {
        $('.data-tooltip').tooltip()
    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

</script>

@include('front-end.layouts._inc.cart-script')
@include('front-end.layouts._inc.sweet-alert')
@include('front-end.layouts._inc.auth._auth-script')
@include('front-end.layouts._inc.autocomplete-search')

@yield('scripts')
</body>
</html>
