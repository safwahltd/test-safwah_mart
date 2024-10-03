
@if(auth()->user()->type != "Delivery Man")
    @if (hasPermission('inv.logistic', $slugs))

        <!--  TIME SLOT  -->
        <li class="{{ request()->segment(3) == 'delivery-mans' ? 'active open' : ''}}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fas fa-list"></i>
                <span class="menu-text">Logistics </span>
                <b class="arrow far fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">

                <!-- DELIVERY MAN -->
                <li class="{{ request()->routeIs('inv.delivery-mans.index*') ? 'active' : '' }}">
                    <a href="{{ route('inv.delivery-mans.index') }}">
                        <span class="menu-text"> Delivery Man</span>
                    </a>
                    <b class="arrow"></b>
                </li>

                <!-- DELIVERY DISCOUNT -->

                {{-- <li class="{{ request()->routeIs('inv.delivery-mans.delivery-discount') ? 'active' : '' }}">
                    <a href="{{ route('inv.delivery-mans.delivery-discount') }}">
                        <span class="menu-text"> Delivery Discount</span>
                    </a>
                    <b class="arrow"></b>
                </li> --}}

            </ul>
        </li>

    @endif
@endif
