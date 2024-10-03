@if(auth()->user()->type != "Delivery Man")
@if (hasAnyPermission(['inv.report.sales', 'inv.report.daily-sales', 'inv.report.stock-in-hand', 'inv.report.item-ledger'], $slugs))

    <li class="{{ request()->segment(2) == 'inventory' && request()->segment(4) == 'sales-report' || request()->segment(4) == 'stock-in-hand' || request()->segment(4) == 'product-report' || request()->segment(4) == 'item-ledger' ? 'active open' : '' }}">
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon far fa-analytics"></i>
            <span class="menu-text"> Inv Report </span>

            <b class="arrow far fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">
            @if (hasPermission("inv.report.sales", $slugs))

                <li class="{{ request()->routeIs('inv.reports.sales-report*') ? 'active' : '' }}">
                    <a href="{{ route('inv.reports.sales-report') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        <span class="menu-text"> Sales Report </span>
                    </a>
                </li>

            @endif

            @if (hasPermission("inv.report.daily-sales", $slugs))

                <li class="{{ request()->routeIs('inv.reports.daily-sales-report*') ? 'active' : '' }}">
                    <a href="{{ route('inv.reports.daily-sales-report') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        <span class="menu-text"> Daily Sales Report </span>
                    </a>
                </li>

            @endif

            @if (hasPermission("sales.create", $slugs))
                {{-- Product Report --}}
                <li class="{{ request()->routeIs('inv.reports.product-report*') ? 'active' : '' }}">
                    <a href="{{ route('inv.reports.product-report') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        <span class="menu-text"> Product Order Report </span>
                    </a>
                </li>
            @endif

            @if (hasPermission("inv.report.stock-in-hand", $slugs))
                <li class="{{ request()->routeIs('inv.reports.stock-in-hand*') ? 'active' : '' }}">
                    <a href="{{ route('inv.reports.stock-in-hand') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        <span class="menu-text"> Stock In Hand </span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('inv.reports.product-alert*') ? 'active' : '' }}">
                    <a href="{{ route('inv.reports.product-alert') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        <span class="menu-text"> Product Alert </span>
                    </a>
                </li>
            @endif

            @if (hasPermission("inv.report.product-expire-report", $slugs))
                <li class="{{ request()->routeIs('inv.reports.product-expire-report*') ? 'active' : '' }}">
                    <a href="{{ route('inv.reports.product-expire-report') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        <span class="menu-text"> Product Expire Report </span>
                    </a>
                </li>
            @endif

            @if (hasPermission("inv.report.item-ledger", $slugs))
                <li class="{{ request()->routeIs('inv.reports.item-ledger*') ? 'active' : '' }}">
                    <a href="{{ route('inv.reports.item-ledger') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        <span class="menu-text"> Item Ledger </span>
                    </a>
                </li>
            @endif
        </ul>
    </li>

@endif

    @if (hasAnyPermission(['website-cms.supply-request'], $slugs))
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon far fa-users"></i>
                <span class="menu-text"> Supply Request </span>

                <b class="arrow far fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">

                {{-- Customer List --}}
                <li class="{{ request()->routeIs('inv.customers*') ? 'active' : '' }}">
                    <a href="{{ route('inv.supplier-request.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Request List
                    </a>

                    <b class="arrow"></b>
                </li>



            </ul>
        </li>
    @endif

@endif
