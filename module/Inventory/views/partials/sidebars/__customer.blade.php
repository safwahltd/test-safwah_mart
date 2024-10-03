@if(auth()->user()->type != "Delivery Man")
    @if (hasAnyPermission(['inv.customers.index', 'inv.customers.create', 'inv.customers.edit', 'inv.customers.delete'], $slugs))

        <li class="{{ request()->segment(2) == 'inventory' && request()->segment(3) == 'customers' ? 'active open' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon far fa-users"></i>
                <span class="menu-text"> Customer </span>

                <b class="arrow far fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">

                {{-- Customer List --}}
                @if (hasPermission('inv.customers.index', $slugs))
                    <li class="{{ request()->routeIs('inv.customers*') ? 'active' : '' }}">
                        <a href="{{ route('inv.customers.index') }}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Customers
                        </a>

                        <b class="arrow"></b>
                    </li>
                @endif

                {{-- Customer Types --}}
                <li class="{{ request()->routeIs('inv.customer-types*') ? 'active' : '' }}">
                    <a href="{{ route('inv.customer-types.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Customer Types
                    </a>

                    <b class="arrow"></b>
                </li>
                
            </ul>
        </li>
    @endif
@endif