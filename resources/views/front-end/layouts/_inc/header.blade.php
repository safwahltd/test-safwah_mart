@php
    $menus = \Module\Website\Models\Menu::with('activeSubMenus')
            ->select('id', 'icon', 'name')
            ->where('status', 1)
            ->orderBy('id', 'ASC')
            ->get();

    $categories = \Module\Inventory\Models\Category::select('name', 'slug', 'title', 'image')
            ->where(['is_medicine' => 'No', 'is_highlight' => 'Yes', 'status' => 1])
            ->orderBy('id', 'ASC')
            ->limit(8)
            ->get();

    $companyLogo = \App\Models\Company::select('logo')->whereId(1)->first();
@endphp

<header class="box-shadow-sm m-menu-b">
    <div class="navbar-sticky mobile-head m-menu">
        <div class="navbar navbar-expand-md bg-light">
            <div class="container ">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                        style="color: #000000 !important;">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand d-none d-md-block mr-3 flex-shrink-0 tab-logo" href="{{ route('index') }}"
                   style="min-width: 7rem;">
                    <div style="!important; width: 150px">
                        <img src="{{ asset($companyLogo->logo) }}" alt="Logo">
                    </div>
                </a>
                <div class="input-group-overlay mx-4 search-form" style="position: relative">
                    <form action="{{ route('catalog-search.result') }}" method="GET">
                        <div class="input-group">
                            <div class="custom-file">
                                <div class="search-dropdown d-none d-md-block" style=" width: 25%;">
                                    <div class="dropdown"
                                         style="height: 49px !important; border: 2px solid #FF4747 !important; border-right: transparent !important; border-bottom-left-radius: 5px; border-top-left-radius: 5px;">
                                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Delivery Address
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        </div>
                                    </div>
                                </div>
                                <input type="text" name="q" id="q" onkeyup="autocompleteSearch(this)"
                                       class="form-control search-bar-input" autocomplete="off"
                                       placeholder="Search for medicine & wellness products"
                                       style="border: 2px solid #FF4747 !important; border-left: 1px solid #efefef !important; position: relative;width: 75%;">
                                <i class="czi-search"
                                   style="color: #000000 !important; position: absolute; right: 0; padding-right: 15px;"></i>

                            </div>
                        </div>
                        <div id="autoCompleteDiv"
                             style="background-color: #ffffff; border: 2px solid #eeeeee; overflow-y: scroll; overflow-x: hidden;  display: none; width: 75%; right:0; min-height: 100px; max-height: 300px; z-index: 10000 !important; position: absolute; margin-top: 5px; border-bottom-right-radius: 5px; border-bottom-left-radius: 10px">

                            <table class="table-hover" width="100%">
                                <tbody id="productRow">

                                </tbody>
                            </table>
                            <table>
                                <div style="height: 30px; text-align: center">
                                    <button class="btn font-weight-bold" style="color: #FF4747">VIEW ALL</button>
                                </div>
                            </table>
                        </div>
                    </form>
                </div>

                <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center imp-btn">
                    <a class="navbar-tool navbar-stuck-toggler text-light" href="#">
                        <span class="navbar-tool-tooltip">Expand menu</span>
                        <div class="navbar-tool-icon-box text-light">
                            <i class="navbar-tool-icon czi-menu"></i>
                        </div>
                    </a>
                    <div class="navbar-tool dropdown ml-3 mr-5">
                        <a class="navbar-tool-icon-box dropdown-toggle" href="javascript:void(0)"
                           style="color: #000000 !important;">
                            <i class="navbar-tool-icon czi-document"></i>
                            Upload Rx
                        </a>
                    </div>



                    @if(auth()->guard('customer')->check())

                        {{--                    <div class="navbar-tool dropdown ml-3">--}}
                        {{--                        <a class="navbar-tool-icon-box text-light dropdown-toggle" href="{{ route('cus-auth.wishlist') }}">--}}
                        {{--                            <span class="navbar-tool-label">--}}
                        {{--                                <span class="countWishlist">0</span>--}}
                        {{--                            </span>--}}
                        {{--                            <i class="navbar-tool-icon czi-heart"></i>--}}
                        {{--                        </a>--}}
                        {{--                    </div>--}}

                    <div class="dropdown">
                        <a class="navbar-tool ml-4 mr-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="navbar-tool-icon-box bg-secondary">
                                <div class="navbar-tool-icon-box bg-secondary">
                                    <img style="width: 40px; height: 40px" src="{{ asset(!empty(auth()->guard('customer')->user()->image) ? auth()->guard('customer')->user()->image : 'assets/front-end/img/avatar.webp') }}" class="img-profile rounded-circle">
                                </div>
                            </div>
                            <div class="navbar-tool-text">
                                <small style="">Hi, {{ !empty(auth()->guard('customer')->user()->name) ? Str::limit(auth()->guard('customer')->user()->name, 10) : '' }}</small>
                                Welcome
                            </div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('cus-auth.my-orders') }}"> My Orders </a>
                            <a class="dropdown-item" href="{{ route('cus-auth.my-profile') }}"> My Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('cus-auth.logout') }}">Logout</a>
                        </div>
                    </div>

                    @else

                    <div class="dropdown">
                        <a class="navbar-tool ml-4" type="button" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            <div class="navbar-tool-icon-box text-light">
                                <div class="navbar-tool-icon-box text-light">
                                    <i class="navbar-tool-icon czi-user"></i>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-type="login" onclick="changeModalType(this)" data-target="#authModal">
                                <i class="fa fa-sign-in mr-2"></i> Login
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-type="register" onclick="changeModalType(this)" data-target="#authModal">
                                <i class="fa fa-user-circle mr-2"></i> Register
                            </a>
                        </div>
                    </div>

                    @endif

                    <div id="myHeaderCart">
{{--                        @include('front-end.layouts._inc.header-cart')--}}
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar navbar-expand-md navbar-stuck-menu" style="background-color:#fff">
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ul-nav" style="width: 75%; margin: 0 auto;">
                        @foreach($menus ?? [] as $menu)
                            <li class="nav-item">
                                @if(count($menu->activeSubMenus) > 0)
                                
                                    <div class="ul-nav-item">
                                        <img
                                            src="{{ !empty($menu->icon) ? asset($menu->icon) : asset('assets/images/default/menu/icon.png') }}"
                                            alt="" class="rounded-circle img-icon">
                                        <div class="dropdown">
                                            <button class="btn dropdown-toggle menu-text" type="button"
                                                    id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" style="margin-top: 5px; color: #000000">
                                                {{ $menu->name }}
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1"
                                                style="min-width: 165px !important;">
                                                @foreach($menu->activeSubMenus as $subMenu)
                                                    <a class="dropdown-item" href="{{ route('prescriptions') }}">
                                                        <b>{{ $subMenu->name }}</b>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex align-items-center justify-content-start">
                                        <img
                                            src="{{ !empty($menu->icon) ? asset($menu->icon) : asset('assets/images/default/menu/icon.png') }}"
                                            alt="" class="rounded-circle img-icon">
                                        <a class="nav-link single-menu" href="javascript:void(0)"
                                        style="color: #000000 !important;">{{ $menu->name }}</a>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="navbar bgc-primary navbar-expand-md box-shadow-0 navbar-stuck-menu" style="height: 40px">
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav w-75 d-flex justify-content-md-start align-items-center extra-menu">
                        @foreach($categories ?? [] as $category)
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="{{ route('non-prescriptions', $category->slug) }}">{{ $category->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
