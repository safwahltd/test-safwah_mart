

@if (hasAnyPermission(['orders.index', 'order-returns.index', 'inv.due-collections.create'], $slugs))

<!--  ORDER  -->
<li class="{{

    request()->segment(2) == 'inventory'
    && request()->segment(3) == 'orders'
    || request()->segment(3) == 'stock-requests'
    || request()->segment(3) == 'order-returns'
    || request()->segment(3) == 'due-collections'
    || request()->segment(3) == 'reports'
    || request()->segment(4) == 'receivable-dues'
    ? 'active open' : '' }}">


    <a href="#" class="dropdown-toggle">
        <i class="menu-icon far fa-paste"></i>
        <span class="menu-text"> Order </span>

        <b class="arrow far fa-angle-down"></b>
    </a>

    <b class="arrow"></b>

    <ul class="submenu">

        <!------------------ ORDER ------------------>
        @if(hasPermission("orders.index", $slugs))
            <li class="{{ request()->routeIs('inv.orders*') ? 'active' : '' }}">
                <a href="{{ route('inv.orders.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    <span class="menu-text">
                        Order List
                    </span>
                </a>

                <b class="arrow"></b>
            </li>
        @endif

    <!------------------ ORDER ------------------>
    @if(hasPermission("orders.index", $slugs))
        <li class="{{ request()->routeIs('inv.orders*') ? 'active' : '' }}">
            <a href="{{ route('inv.orders.create') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                <span class="menu-text">
                    Order Create
                </span>
            </a>

            <b class="arrow"></b>
        </li>
    @endif

        @if(auth()->user()->type != "Delivery Man")
            <!------------------ RETURN ------------------>
            @if(hasPermission("order-returns.index", $slugs))
                <li class="{{ request()->routeIs('inv.order-returns*') ? 'active' : '' }}">
                    <a href="{{ route('inv.order-returns.index') }}">
                        <i class="menu-icon far fa-undo-alt"></i>
                        <span class="menu-text">
                            Product Return
                        </span>
                    </a>

                    <b class="arrow"></b>
                </li>
            @endif


            <li class="{{ request()->routeIs('inv.stock-requests*') ? 'active' : '' }}">
                <a href="{{ route('inv.stock-requests.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    <span class="menu-text">
                        Stock Request List
                    </span>
                </a>

                <b class="arrow"></b>
            </li>


            @if (hasPermission("inv.due-collections.create", $slugs))
                <li class="{{ request()->routeIs('inv.due-collections*') ? 'active' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fas fa-dollar-sign"></i>
                        <span class="menu-text">Due Collection</span>
                        <b class="arrow far fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>
                    <ul class="submenu">
                        <li class="{{ request()->routeIs('inv.due-collections.create*') ? 'active' : '' }}">
                            <a href="{{ route('inv.due-collections.create') }}">
                                <span class="menu-text"> Create </span>
                            </a>

                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>
            @endif


            <li class="{{ request()->routeIs('inv.reports*') ? 'active' : '' }}">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fas fa-list"></i>
                    <span class="menu-text">Report</span>
                    <b class="arrow far fa-angle-down"></b>
                </a>

                <b class="arrow"></b>
                <ul class="submenu">
                    <li class="{{ request()->routeIs('inv.reports.receivable-dues*') ? 'active' : '' }}">
                        <a href="{{ route('inv.reports.receivable-dues') }}">
                            <span class="menu-text"> Receivable Due </span>
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li class="{{ request()->routeIs('inv.reports.product-report*') ? 'active' : '' }}">
                        <a href="{{ route('inv.reports.product-report') }}">
                            <span class="menu-text"> Productwise Order </span>
                        </a>

                        <b class="arrow"></b>
                    </li>
                     {{-- Monthly Order Report --}}

                     <li class="{{ request()->routeIs('inv.reports.daily-order-report*') ? 'active' : '' }}">
                        <a href="{{ route('inv.reports.daily-order-report') }}">
                            <i class="menu-text"></i>
                            <span class="menu-text"> Daily Order </span>
                        </a>
                    </li>
                    {{-- Monthly Order Report --}}

                    <li class="{{ request()->routeIs('inv.reports.monthly-order-report*') ? 'active' : '' }}">
                        <a href="{{ route('inv.reports.monthly-order-report') }}">
                            <i class="menu-text"></i>
                            <span class="menu-text"> Monthly Order </span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</li>

@endif

@if(auth()->user()->type == "Delivery Man")
    <li class="{{

        request()->segment(2) == 'inventory'
        && request()->segment(3) == 'orders'
        || request()->segment(3) == 'stock-requests'
        || request()->segment(3) == 'order-returns'
        || request()->segment(3) == 'due-collections'
        || request()->segment(3) == 'reports'
        || request()->segment(4) == 'receivable-dues'
        ? 'active open' : '' }}">


        <a href="#" class="dropdown-toggle">
            <i class="menu-icon far fa-paste"></i>
            <span class="menu-text"> Order </span>

            <b class="arrow far fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">

            <!------------------ ORDER ------------------>
                <li class="{{ request()->routeIs('inv.orders*') ? 'active' : '' }}">
                    <a href="{{ route('inv.orders.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        <span class="menu-text">
                            Order List
                        </span>
                    </a>

                    <b class="arrow"></b>
                </li>
        </ul>
    </li>
@endif


@if(auth()->user()->type != "Delivery Man")
    @if (hasAnyPermission(['sales.index', 'sales.create'], $slugs))

        <!--  SALE  -->
        <li class="{{ request()->segment(2) == 'inventory' && request()->segment(3) == 'sales' ? 'active open' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon far fa-cart-arrow-down"></i>
                <span class="menu-text"> Sale </span>

                <b class="arrow far fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                @if (hasPermission("sales.create", $slugs))

                    <li class="{{ request()->routeIs('inv.sales.create.pos-sale*') ? 'active' : '' }}">
                        <a href="{{ route('inv.sales.create.pos-sale') }}" target="_blank">
                            <i class="menu-icon fa fa-caret-right"></i>
                            <span class="menu-text">
                                POS Sale
                            </span>
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li class="{{ request()->routeIs('inv.sales.create*') ? 'active' : '' }}">
                        <a href="{{ route('inv.sales.create') }}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            <span class="menu-text">
                                New Sale
                            </span>
                        </a>

                        <b class="arrow"></b>
                    </li>

                @endif

                @if (hasPermission("sales.index", $slugs))

                    <li class="{{ request()->routeIs('inv.sales.index*') ? 'active' : '' }}">
                        <a href="{{ route('inv.sales.index') }}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            <span class="menu-text"> Sale List </span>
                        </a>

                        <b class="arrow"></b>
                    </li>

                @endif
            </ul>
        </li>

    @endif


    @if (hasAnyPermission(['purchases.index', 'purchases.create'], $slugs))

        <!--  PURCHASE  -->
        <li class="{{ request()->segment(2) == 'inventory' && request()->segment(3) == 'purchases' ? 'active open' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon far fa-cart-plus"></i>
                <span class="menu-text"> Purchase </span>

                <b class="arrow far fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                @if (hasPermission("purchases.create", $slugs))

                    <li class="{{ request()->routeIs('inv.purchases.create*') ? 'active' : '' }}">
                        <a href="{{ route('inv.purchases.create') }}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            <span class="menu-text"> New Purchase </span>
                        </a>

                        <b class="arrow"></b>
                    </li>

                @endif

                @if (hasPermission("purchases.index", $slugs))

                    <li class="{{ request()->routeIs('inv.purchases.index*') ? 'active' : '' }}">
                        <a href="{{ route('inv.purchases.index') }}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            <span class="menu-text"> Purchase List </span>
                        </a>

                        <b class="arrow"></b>
                    </li>

                @endif


                <!--  P.O.  -->
                {{-- <ul class="submenu">
                    <li class="">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-caret-right"></i>
                            P.O.
                            <b class="arrow far fa-angle-down"></b>
                        </a>

                        <b class="arrow"></b>

                        <ul class="submenu">
                            <li class="">
                                <a href="{{ route('inv.purchases.p-o.create') }}">
                                    <i class="menu-icon fa fa-plus"></i>
                                    Create P.O.
                                </a>

                                <b class="arrow"></b>
                            </li>

                            <li class="">
                                <a href="{{ route('inv.purchases.p-o.list') }}">
                                    <i class="menu-icon fa fa-list"></i>
                                    P.O. List
                                </a>

                                <b class="arrow"></b>
                            </li>
                        </ul>
                    </li>
                </ul> --}}
            </ul>
        </li>

    @endif
@endif
