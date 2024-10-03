

@if(auth()->user()->type != "Delivery Man")
    @if (hasPermission('inv.config', $slugs))

    <li class="{{
        request()->segment(2) == 'districts'
        || request()->segment(2) == 'areas'
        || request()->segment(3) == 'delivery-mans'
        || request()->segment(3) == 'time-slots'
        || request()->segment(3) == 'delivery-man-time-slots'
        || request()->segment(3) == 'cuppons'
        || request()->segment(3) == 'warehouses'
        ? 'active open' : ''
    }}">
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-cog"></i>
            <span class="menu-text"> Config11 </span>

            <b class="arrow far fa-angle-down"></b>
        </a>
        <b class="arrow"></b>




        <ul class="submenu">
        





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
                    <li class="{{ request()->routeIs('inv.delivery-man-time-slots*') ? 'active' : '' }}">
                        <a href="{{ route('inv.delivery-man-time-slots.index') }}">
                            <span class="menu-text"> Assign Delivery Man </span>
                        </a>
                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>

            <!--  COUPON  -->
            <li class="{{ request()->routeIs('inv.coupons*') ? 'active' : '' }}">
                <a href="{{ route('inv.coupons.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Coupon
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
        </ul>
    </li>

    @endif
@endif