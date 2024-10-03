

@if(auth()->user()->type != "Delivery Man")

    @if (hasAnyPermission(['inv.config', 'orders.free-deliveries', 'orders.cod-charge'], $slugs))



        <li class="{{
            request()->segment(2) == 'districts'
                || request()->segment(2) == 'areas'
                || request()->segment(2) == 'point-configs'
                || request()->segment(3) == 'time-slots'
                || request()->segment(3) == 'delivery-man-time-slots'
                || request()->segment(3) == 'weight-wise-extra-shipping-costs'
                || request()->segment(3) == 'shipping-cost-discounts'
                || request()->segment(3) == 'cuppons'
                || request()->segment(3) == 'return-reasons'
                || request()->segment(3) == 'warehouses'
                ? 'active open' : ''
            }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-cog"></i>
                <span class="menu-text"> Config </span>

                <b class="arrow far fa-angle-down"></b>
            </a>
            <b class="arrow"></b>




            <ul class="submenu">





                @if (hasAnyPermission(['inv.config'], $slugs))

                    <!--  TIME SLOT  -->
                    <li class="{{ request()->segment(3) == 'time-slots' || request()->segment(3) == 'delivery-man-time-slots' ? 'active open' : '' }}">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fas fa-list"></i>
                            <span class="menu-text">Time Slot </span>
                            <b class="arrow far fa-angle-down"></b>
                        </a>

                        <b class="arrow"></b>
                        <ul class="submenu">
                            <li class="{{ request()->routeIs('inv.time-slots.create*') ? 'active' : '' }}">
                                <a href="{{ route('inv.time-slots.create') }}">
                                    <span class="menu-text"> Add New </span>
                                </a>

                                <b class="arrow"></b>
                            </li>
                            <li class="{{ request()->routeIs('inv.time-slots.index*') ? 'active' : '' }}">
                                <a href="{{ route('inv.time-slots.index') }}">
                                    <span class="menu-text"> Time Slot List </span>
                                </a>
                                <b class="arrow"></b>
                            </li>
                            {{-- <li class="{{ request()->routeIs('inv.delivery-man-time-slots*') ? 'active' : '' }}">
                                <a href="{{ route('inv.delivery-man-time-slots.index') }}">
                                    <span class="menu-text"> Assign Delivery Man </span>
                                </a>
                                <b class="arrow"></b>
                            </li> --}}
                        </ul>
                    </li>





                    <!--  RETURN REASON  -->
                    <li class="{{ request()->routeIs('inv.return-reasons*') ? 'active' : '' }}">
                        <a href="{{ route('inv.return-reasons.index') }}">
                            <i class="menu-icon far fa-undo-alt"></i>
                            Return Reason
                        </a>

                        <b class="arrow"></b>
                    </li>





                    <!--  WEIGHT WISE EXTRA SHIPPING COSTS  -->
                    <li class="{{ request()->routeIs('inv.weight-wise-extra-shipping-costs*') ? 'active' : '' }}">
                        <a href="{{ route('inv.weight-wise-extra-shipping-costs.index') }}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Extra Ship. Cost
                        </a>

                        <b class="arrow"></b>
                    </li>





                    <!--  WEIGHT WISE EXTRA SHIPPING COSTS  -->
                    <li class="{{ request()->routeIs('inv.shipping-cost-discounts*') ? 'active' : '' }}">
                        <a href="{{ route('inv.shipping-cost-discounts.index') }}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Shipping Cost Disc.
                        </a>

                        <b class="arrow"></b>
                    </li>




                    <!--  COUPON  -->
                    <li class="{{ request()->routeIs('inv.coupons*') ? 'active' : '' }}">
                        <a href="{{ route('inv.coupons.index') }}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Coupon
                        </a>

                        <b class="arrow"></b>
                    </li>





                    <!--  POINT CONFIGS  -->
                    <li class="{{ request()->routeIs('point-configs*') ? 'active' : '' }}">
                        <a href="{{ route('point-configs.index') }}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Point
                        </a>

                        <b class="arrow"></b>
                    </li>





                    <!--  WAREHOUSE  -->
                    <li class="{{ request()->routeIs('inv.warehouses*') ? 'active' : '' }}">
                        <a href="{{ route('inv.warehouses.index') }}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Warehouse
                        </a>

                        <b class="arrow"></b>
                    </li>
                @endif



                @if(hasAnyPermission(['orders.districts'], $slugs))
                    <!--  DISTRICT  -->
                    <li class="{{ request()->routeIs('districts*') ? 'active' : '' }}">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fas fa-list"></i>
                            <span class="menu-text">District </span>
                            <b class="arrow far fa-angle-down"></b>
                        </a>

                        <b class="arrow"></b>
                        <ul class="submenu">
                            <li class="{{ request()->routeIs('districts.create*') ? 'active' : '' }}">
                                <a href="{{ route('districts.create') }}">
                                    <span class="menu-text"> Add New </span>
                                </a>

                                <b class="arrow"></b>
                            </li>
                            <li class="{{ request()->routeIs('districts.index*') ? 'active' : '' }}">
                                <a href="{{ route('districts.index') }}">
                                    <span class="menu-text"> District List </span>
                                </a>
                                <b class="arrow"></b>
                            </li>
                        </ul>
                    </li>
                @endif





                @if(hasAnyPermission(['orders.areas'], $slugs))
                    <!--  AREA  -->
                    <li class="{{ request()->routeIs('areas*') ? 'active' : '' }}">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fas fa-list"></i>
                            <span class="menu-text">Area </span>
                            <b class="arrow far fa-angle-down"></b>
                        </a>

                        <b class="arrow"></b>
                        <ul class="submenu">
                            <li class="{{ request()->routeIs('areas.create*') ? 'active' : '' }}">
                                <a href="{{ route('areas.create') }}">
                                    <span class="menu-text"> Add New </span>
                                </a>

                                <b class="arrow"></b>
                            </li>
                            <li class="{{ request()->routeIs('areas.index*') ? 'active' : '' }}">
                                <a href="{{ route('areas.index') }}">
                                    <span class="menu-text"> Area List </span>
                                </a>
                                <b class="arrow"></b>
                            </li>
                        </ul>
                    </li>
                @endif



                @if(hasAnyPermission(['orders.free-deliveries', 'orders.cod-charge'], $slugs))
                    <!-- DELIVERY DISCOUNT -->
                    <li class="{{ request()->routeIs('inv.delivery-mans.delivery-discount') ? 'active' : '' }}">
                        <a href="{{ route('inv.delivery-mans.delivery-discount') }}">
                            <span class="menu-text"> Delivery Discount</span>
                        </a>
                        <b class="arrow"></b>
                    </li>
                @endif
            </ul>
        </li>
    @endif
@endif
