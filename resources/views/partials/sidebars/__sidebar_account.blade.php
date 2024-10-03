@if (hasAnyPermission(['account-setups.ndex', 'account-groups.index', 'account-controls.index', 'account-subsidiaries.index', 'accounts.index', 'fund.transfers.index', 'account.reports.index'], $slugs) && hasModulePermission('Account & Finance', $active_modules))

    <li class="{{ request()->segment(1) == 'account' | request()->segment(2) == 'vouchers' | request()->segment(1) == 'reports'
    | request()->segment(1) == 'product' | request()->segment(1) == 'purchase'| request()->segment(1) == 'sale' | request()->segment(1) == 'setup' ? 'open' : '' }}">
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fas fa-calculator-alt" style="font-weight: bold"></i>
            <span class="menu-text">Accounts</span>
            <b class="arrow far fa-angle-down"></b>
        </a>
        <b class="arrow"></b>

        <ul class="submenu">



            <!-- Account Setup -->
            @if (hasAnyPermission(['account-setups.index', 'account-groups.index', 'account-controls.index', 'account-subsidiaries.index', 'accounts.index'], $slugs))
                <li class="{{ request()->segment(2) == 'setup' ? 'open' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-circle"></i>
                        Setup
                        <b class="arrow far fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>

                    <ul class="submenu">
                        @if (hasPermission('account.setups.index', $slugs) && false)
                            <li class="{{ request()->segment(3) == 'account-groups' ? 'active' : '' }}">
                                <a href="{{ route('account-setups.index') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Account Setup
                                </a>
                            </li>
                        @endif

                        @if (hasPermission('account.groups.index', $slugs))
                            <li class="{{ request()->segment(3) == 'account-groups' ? 'active' : '' }}">
                                <a href="{{ route('account-groups.index') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Account Group
                                </a>
                            </li>
                        @endif

                        @if (hasPermission('account.controls.index', $slugs))
                            <li class="{{ request()->segment(3) == 'account-controls' ? 'active' : '' }}">
                                <a href="{{ route('account-controls.index') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Account Control
                                </a>
                            </li>
                        @endif

                        @if (hasPermission('account.subsidiaries.index', $slugs))
                            <li class="{{ request()->segment(3) == 'account-subsidiaries' ? 'active' : '' }}">
                                <a href="{{ route('account-subsidiaries.index') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Acc. Subsidiary
                                </a>
                            </li>
                        @endif

                        @if (hasPermission('accounts.index', $slugs))
                            <li class="{{ request()->segment(3) == 'accounts' ? 'active' : '' }}">
                                <a href="{{ route('accounts.index') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Account Charts
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif











        <!-- Voucher -->
            <li class="{{ request()->segment(2) == 'voucher' ? 'open' : '' }}">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-circle"></i>
                    Voucher
                    <b class="arrow far fa-angle-down"></b>
                </a>
                <b class="arrow"></b>







                <!-- Payment Voucher -->
                <ul class="submenu">
                    <li class="{{ request()->segment(3) == 'payments' ? 'open' : '' }}">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Payment
                            <b class="arrow far fa-angle-down"></b>
                        </a>
                        <b class="arrow"></b>


                        <ul class="submenu">
                            <li class="{{ request()->routeIs('voucher-payments.create') ? 'active' : '' }}">
                                <a href="{{ route('voucher-payments.create') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Create
                                </a>
                            </li>

                            <li class="{{ request()->routeIs('voucher-payments.index') ? 'active' : '' }}">
                                <a href="{{ route('voucher-payments.index') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    List
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>







                <!-- Receive Voucher -->
                <ul class="submenu">
                    <li class="{{ request()->segment(3) == 'receives' ? 'open' : '' }}">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Receive
                            <b class="arrow far fa-angle-down"></b>
                        </a>
                        <b class="arrow"></b>


                        <ul class="submenu">
                            <li class="{{ request()->routeIs('voucher-receives.create') ? 'active' : '' }}">
                                <a href="{{ route('voucher-receives.create') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Create
                                </a>
                            </li>

                            <li class="{{ request()->routeIs('voucher-receives.index') ? 'active' : '' }}">
                                <a href="{{ route('voucher-receives.index') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    List
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>







                <!-- Contra Voucher -->
                <ul class="submenu">
                    <li class="{{ request()->segment(3) == 'contras' ? 'open' : '' }}">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Contra
                            <b class="arrow far fa-angle-down"></b>
                        </a>
                        <b class="arrow"></b>


                        <ul class="submenu">
                            <li class="{{ request()->routeIs('voucher-contras.create') ? 'active' : '' }}">
                                <a href="{{ route('voucher-contras.create') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Create
                                </a>
                            </li>

                            <li class="{{ request()->routeIs('voucher-contras.index') ? 'active' : '' }}">
                                <a href="{{ route('voucher-contras.index') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    List
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>







                <!-- Journal Voucher -->
                <ul class="submenu">
                    <li class="{{ request()->segment(3) == 'journals' ? 'open' : '' }}">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Journal
                            <b class="arrow far fa-angle-down"></b>
                        </a>
                        <b class="arrow"></b>


                        <ul class="submenu">
                            <li class="{{ request()->routeIs('voucher-journals.create') ? 'active' : '' }}">
                                <a href="{{ route('voucher-journals.create') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Create
                                </a>
                            </li>

                            <li class="{{ request()->routeIs('voucher-journals.index') ? 'active' : '' }}">
                                <a href="{{ route('voucher-journals.index') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    List
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>










            <!-- Products -->
{{--            @if (hasAnyPermission(['products.index', 'units.index', 'categories.index'], $slugs))--}}
{{--                <li--}}
{{--                    class="{{ (request()->segment(2) == 'units') | (request()->segment(2) == 'categories') | (request()->segment(2) == 'products') ? 'open' : '' }}">--}}
{{--                    <a href="#" class="dropdown-toggle">--}}
{{--                        <i class="menu-icon fa fa-circle"></i>--}}
{{--                        Product--}}
{{--                        <b class="arrow far fa-angle-down"></b>--}}
{{--                    </a>--}}
{{--                    <b class="arrow"></b>--}}

{{--                    <ul class="submenu">--}}
{{--                        @if (hasPermission('products', $slugs))--}}
{{--                            <li class="{{ request()->is('product/products/create') ? 'active' : '' }}">--}}
{{--                                <a href="{{ route('products.create') }}">--}}
{{--                                    <i class="menu-icon fa fa-caret-right"></i>--}}
{{--                                    Product Create--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="{{ request()->is('product/products') ? 'active' : '' }}">--}}
{{--                                <a href="{{ route('products.index') }}">--}}
{{--                                    <i class="menu-icon fa fa-caret-right"></i>--}}
{{--                                    Product List--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endif--}}



{{--                        @if (hasPermission('categories.index', $slugs))--}}
{{--                            <li--}}
{{--                                class="{{ request()->is('product/categories') || request()->is('product/categories/*/edit') ? 'active' : '' }}">--}}
{{--                                <a href="{{ route('categories.index') }}">--}}
{{--                                    <i class="menu-icon fa fa-caret-right"></i>--}}
{{--                                    Category--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endif--}}



{{--                        @if (hasPermission('units.index', $slugs))--}}
{{--                            <li class="{{ request()->is('product/units') ? 'active' : '' }}">--}}
{{--                                <a href="{{ route('units.index') }}">--}}
{{--                                    <i class="menu-icon fa fa-caret-right"></i>--}}
{{--                                    Units--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endif--}}


{{--                        --}}{{--                        @if (hasPermission('products', $slugs))--}}
{{--                        --}}{{--                            <li class="{{ request()->segment(2) == 'products' ? 'open' : '' }}">--}}
{{--                        --}}{{--                                <a href="#" class="dropdown-toggle">--}}
{{--                        --}}{{--                                    <i class="menu-icon fa fa-circle"></i>--}}
{{--                        --}}{{--                                    Product--}}
{{--                        --}}{{--                                    <b class="arrow far fa-angle-down"></b>--}}
{{--                        --}}{{--                                </a>--}}
{{--                        --}}{{--                                <b class="arrow"></b>--}}
{{--                        --}}{{--                                <ul class="submenu">--}}
{{--                        --}}{{--                                    <li class="{{ request()->is('product/products/create') ? 'active' : '' }}">--}}
{{--                        --}}{{--                                        <a href="{{ route('products.create') }}">--}}
{{--                        --}}{{--                                            <i class="menu-icon fa fa-caret-right"></i>--}}
{{--                        --}}{{--                                            Product Create--}}
{{--                        --}}{{--                                        </a>--}}
{{--                        --}}{{--                                    </li>--}}
{{--                        --}}{{--                                    <li class="{{ request()->is('product/products') ? 'active' : '' }}">--}}
{{--                        --}}{{--                                        <a href="{{ route('products.index') }}">--}}
{{--                        --}}{{--                                            <i class="menu-icon fa fa-caret-right"></i>--}}
{{--                        --}}{{--                                            Product List--}}
{{--                        --}}{{--                                        </a>--}}
{{--                        --}}{{--                                    </li>--}}
{{--                        --}}{{--                                </ul>--}}
{{--                        --}}{{--                            </li>--}}
{{--                        --}}{{--                        @endif--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--            @endif--}}







        <!-- Party -->
           @if (hasAnyPermission(['acc-customers.index', 'acc-suppliers.index'], $slugs))

               <li class="{{ request()->segment(1) == 'party' ? 'open' : '' }}">
                   <a href="#" class="dropdown-toggle">
                       <i class="menu-icon fa fa-circle"></i>
                       Party
                       <b class="arrow far fa-angle-down"></b>
                   </a>
                   <b class="arrow"></b>

                   <ul class="submenu">




                       <!-- Customer -->
                       {{-- @if (hasPermission('acc_customers.index', $slugs))
                           <li class="{{ request()->segment(2) == 'acc-customers' ? 'open' : '' }}">
                               <a href="#" class="dropdown-toggle">
                                   <i class="menu-icon fa fa-circle"></i>
                                   Customer
                                   <b class="arrow far fa-angle-down"></b>
                               </a>
                               <b class="arrow"></b>

                               <ul class="submenu">
                                   <li class="{{ request()->routeIs('acc-customers.create') ? 'active' : '' }}">
                                       <a href="{{ route('acc-customers.create') }}">
                                           <i class="menu-icon fa fa-caret-right"></i>
                                           Create
                                       </a>
                                   </li>
                                   <li class="{{ request()->routeIs('acc-customers.index') ? 'active' : '' }}">
                                       <a href="{{ route('acc-customers.index') }}">
                                           <i class="menu-icon fa fa-caret-right"></i>
                                           List
                                       </a>
                                   </li>
                               </ul>
                           </li>
                       @endif --}}




                   <!-- Supplier -->
                       @if (hasPermission('acc_suppliers.index', $slugs))
                           <li class="{{ request()->segment(2) == 'acc-suppliers' ? 'open' : '' }}">
                               <a href="#" class="dropdown-toggle">
                                   <i class="menu-icon fa fa-circle"></i>
                                   Supplier
                                   <b class="arrow far fa-angle-down"></b>
                               </a>
                               <b class="arrow"></b>

                               <ul class="submenu">
                                   <li class="{{ request()->routeIs('acc-suppliers.create') ? 'active' : '' }}">
                                       <a href="{{ route('acc-suppliers.create') }}">
                                           <i class="menu-icon fa fa-caret-right"></i>
                                           Create
                                       </a>
                                   </li>
                                   <li class="{{ request()->routeIs('acc-suppliers.index') ? 'active' : '' }}">
                                       <a href="{{ route('acc-suppliers.index') }}">
                                           <i class="menu-icon fa fa-caret-right"></i>
                                           List
                                       </a>
                                   </li>
                               </ul>
                           </li>
                       @endif
                   </ul>
               </li>
           @endif







        <!-- Purchase -->
{{--            @if (hasAnyPermission(['acc_purchases.index', 'acc_payments.index'], $slugs))--}}
{{--                <li--}}
{{--                    class="{{ request()->segment(2) == 'acc-payments' || request()->segment(2) == 'acc-purchases' ? 'open' : '' }}">--}}
{{--                    <a href="#" class="dropdown-toggle">--}}
{{--                        <i class="menu-icon fa fa-circle"></i>--}}
{{--                        Purchase--}}
{{--                        <b class="arrow far fa-angle-down"></b>--}}
{{--                    </a>--}}
{{--                    <b class="arrow"></b>--}}

{{--                    <ul class="submenu">--}}
{{--                        --}}{{--                        @if (hasPermission('acc_payments.index', $slugs))--}}
{{--                        --}}{{--                            <li class="{{ request()->routeIs('acc-payments') ? 'active' : '' }}">--}}
{{--                        --}}{{--                                <a href="{{ route('acc-payments.index') }}">--}}
{{--                        --}}{{--                                    <i class="menu-icon fa fa-caret-right"></i>--}}
{{--                        --}}{{--                                    Payments--}}
{{--                        --}}{{--                                </a>--}}
{{--                        --}}{{--                            </li>--}}
{{--                        --}}{{--                        @endif--}}

{{--                        @if (hasPermission('acc_purchases.index', $slugs))--}}
{{--                            <li class="{{ request()->routeIs('acc-purchases.create') ? 'active' : '' }}">--}}
{{--                                <a href="{{ route('acc-purchases.create') }}">--}}
{{--                                    <i class="menu-icon fa fa-caret-right"></i>--}}
{{--                                    Create--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="{{ request()->routeIs('acc-purchases.index') ? 'active' : '' }}">--}}
{{--                                <a href="{{ route('acc-purchases.index') }}">--}}
{{--                                    <i class="menu-icon fa fa-caret-right"></i>--}}
{{--                                    List--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endif--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--            @endif--}}









        <!-- Sale -->
{{--            @if (hasAnyPermission(['acc_sales.index', 'acc_collections.index'], $slugs))--}}
{{--                <li class="{{ request()->segment(1) == 'sale' ? 'open' : '' }}">--}}
{{--                    <a href="#" class="dropdown-toggle">--}}
{{--                        <i class="menu-icon fa fa-circle"></i>--}}
{{--                        Sale--}}
{{--                        <b class="arrow far fa-angle-down"></b>--}}
{{--                    </a>--}}
{{--                    <b class="arrow"></b>--}}

{{--                    <ul class="submenu">--}}
{{--                        --}}{{--                        @if (hasPermission('acc_collections.index', $slugs))--}}
{{--                        --}}{{--                            <li class="{{ request()->is('account/sale/acc_collections') ? 'active' : '' }}">--}}
{{--                        --}}{{--                                <a href="{{ route('acc_collections.index') }}">--}}
{{--                        --}}{{--                                    <i class="menu-icon fa fa-caret-right"></i>--}}
{{--                        --}}{{--                                    Collections--}}
{{--                        --}}{{--                                </a>--}}
{{--                        --}}{{--                            </li>--}}
{{--                        --}}{{--                        @endif--}}

{{--                        @if (hasPermission('acc_sales.index', $slugs))--}}
{{--                            <li class="{{ request()->routeIs('acc-sales.create') ? 'active' : '' }}">--}}
{{--                                <a href="{{ route('acc-sales.create') }}">--}}
{{--                                    <i class="menu-icon fa fa-caret-right"></i>--}}
{{--                                    Create--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="{{ request()->routeIs('acc-sales.index') ? 'active' : '' }}">--}}
{{--                                <a href="{{ route('acc-sales.index') }}">--}}
{{--                                    <i class="menu-icon fa fa-caret-right"></i>--}}
{{--                                    List--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endif--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--            @endif--}}










        <!-- Reports -->
            @if (hasPermission('account.reports.index', $slugs))
                <li class="{{ request()->segment(2) == 'reports' ? 'open' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-circle"></i>
                        Report
                        <b class="arrow far fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>

                    <ul class="submenu">
                        @if (hasPermission('account.chart.of.account.reports', $slugs))
                            <li class="{{ request()->routeIs('report.chart-of-account') ? 'active' : '' }}">
                                <a href="{{ route('report.chart-of-account') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Chart Of Account
                                </a>
                            </li>
                        @endif

                        @if (hasPermission('account.ledger.journal.reports', $slugs))
                            <li class="{{ request()->routeIs('report.ledger-journal') ? 'active' : '' }}">
                                <a href="{{ route('report.ledger-journal') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Ledger Journal
                                </a>
                            </li>
                        @endif

                        {{-- @if (hasPermission('account.ledger.journal.reports', $slugs))
                            <li class="{{ request()->is('reports/journal-report') ? 'active' : '' }}">
                                <a href="{{ route('report.journal-report') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Journal Report
                                </a>
                            </li>
                        @endif --}}

                        {{-- @if (hasPermission('account.transaction.ledger.reports', $slugs))
                            <li class="{{ request()->is('reports/transaction-ledger') ? 'active' : '' }}">
                                <a href="{{ route('report.transaction-ledger') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Transaction Ledger
                                </a>
                            </li>
                        @endif --}}

                        @if (hasPermission('account.account.ledger.reports', $slugs))
                            <li class="{{ request()->routeIs('report.account-ledger') ? 'active' : '' }}">
                                <a href="{{ route('report.account-ledger') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Account Ledger
                                </a>
                            </li>
                        @endif


                        @if (hasPermission('account.account.ledger.reports', $slugs))
                            <li class="{{ request()->RouteIs('report.customer-ledger') ? 'active' : '' }}">
                                <a href="{{ route('report.customer-ledger') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Customer Ledger
                                </a>
                            </li>
                        @endif

                        @if (hasPermission('account.account.ledger.reports', $slugs))
                            <li class="{{ request()->RouteIs('report.supplier-ledger') ? 'active' : '' }}">
                                <a href="{{ route('report.supplier-ledger') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Supplier Ledger
                                </a>
                            </li>
                        @endif


                        @if (hasPermission('account.subsidiary.ledger.reports', $slugs))
                            <li class="{{ request()->RouteIs('report.subsidiary-wise-ledger') ? 'active' : '' }}">
                                <a href="{{ route('report.subsidiary-wise-ledger') }}"
                                   title="Subsidiary Wise Ledger">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Subsidiary Ledger
                                </a>
                            </li>
                        @endif

                        {{-- @if (hasPermission('account.reports.index', $slugs)) --}}
                        {{-- <li class="hidden {{ request()->is('reports/nominal-account-ledger') ? 'active' : '' }}"> --}}
                        {{-- <a href="{{ route('report.nominal-account-ledger') }}" title="Nominal Account Ledger"> --}}
                        {{-- <i class="menu-icon fa fa-caret-right"></i> --}}
                        {{-- Nominal Ledger --}}
                        {{-- </a> --}}
                        {{-- </li> --}}
                        {{-- @endif --}}

                        {{-- @if (hasPermission('account.reports.index', $slugs)) --}}
                        {{-- <li class="hidden {{ request()->is('reports/revenue-analysis') ? 'active' : '' }}"> --}}
                        {{-- <a href="{{ route('report.revenue-analysis') }}"> --}}
                        {{-- <i class="menu-icon fa fa-caret-right"></i> --}}
                        {{-- Revenue Analysis --}}
                        {{-- </a> --}}
                        {{-- </li> --}}
                        {{-- @endif --}}

                        @if (hasPermission('account.expense.analysis.reports', $slugs))
                            {{-- <li class="{{ request()->is('reports/expense-analysis') ? 'active' : '' }}">
                                <a href="{{ route('report.expense-analysis') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Expense Analysis
                                </a>
                            </li> --}}
                        @endif

                        {{-- @if (hasPermission('account.reports.index', $slugs)) --}}
                        {{-- <li class="hidden {{ request()->is('reports/ratio-analysis') ? 'active' : '' }}"> --}}
                        {{-- <a href="{{ route('report.ratio-analysis') }}"> --}}
                        {{-- <i class="menu-icon fa fa-caret-right"></i> --}}
                        {{-- Ratio Analysis --}}
                        {{-- </a> --}}
                        {{-- </li> --}}
                        {{-- @endif --}}

                        {{-- @if (hasPermission('account.reports.index', $slugs)) --}}
                        {{-- <li class="hidden {{ request()->is('reports/received-payment-statement') ? 'active' : '' }}"> --}}
                        {{-- <a href="{{ route('report.received-payment-statement') }}" title="Received Payment Statement"> --}}
                        {{-- <i class="menu-icon fa fa-caret-right"></i> --}}
                        {{-- Received Payment --}}
                        {{-- </a> --}}
                        {{-- </li> --}}
                        {{-- @endif --}}

                    <!-- financial report -->
                        @if (hasAnyPermission(['account.trial.balance.reports', 'account.balance.sheet.reports', 'account.profit.and.loss.reports'], $slugs))
                            <li class="{{ request()->segment(3) == 'financial-statements' ? 'open' : '' }}">
                                <a href="#" class="dropdown-toggle" data-toggle="tooltip" title="Financial Statements">
                                    <i class="menu-icon fa fa-circle"></i>
                                    Financial
                                    <b class="arrow far fa-angle-down"></b>
                                </a>
                                <b class="arrow"></b>

                                <ul class="submenu">
                                    @if (hasPermission('account.trial.balance.reports', $slugs))
                                        <li
                                            class="{{ request()->routeIs('report.trial-balance') ? 'active' : '' }}">
                                            <a href="{{ route('report.trial-balance') }}">
                                                <i class="menu-icon fa fa-caret-right"></i>
                                                Trial Balance
                                            </a>
                                        </li>
                                    @endif

                                    @if (hasPermission('account.income.statement.reports', $slugs))
                                        <li
                                            class="{{ request()->routeIs('report.income-statement') ? 'active' : '' }}">
                                            <a href="{{ route('report.income-statement') }}">
                                                <i class="menu-icon fa fa-caret-right"></i>
                                                Income Statement
                                            </a>
                                        </li>
                                    @endif

                                    @if (hasPermission('account.balance.sheet.reports', $slugs))
                                        {{-- <li
                                            class="{{ request()->is('reports/financial-statements/balance-sheet') ? 'active' : '' }}">
                                            <a href="{{ route('report.balance-sheet') }}">
                                                <i class="menu-icon fa fa-caret-right"></i>
                                                Balance Sheet
                                            </a>
                                        </li> --}}
                                    @endif
                                </ul>
                            </li>
                        @endif

{{--                            <li>--}}
{{--                                <a href="#" class="dropdown-toggle" data-toggle="tooltip" title="Financial Statements">--}}
{{--                                    <i class="menu-icon fa fa-circle"></i>--}}
{{--                                    Inventory--}}
{{--                                    <b class="arrow far fa-angle-down"></b>--}}
{{--                                </a>--}}
{{--                                <b class="arrow"></b>--}}

{{--                                <ul class="submenu">--}}
{{--                                    <li>--}}
{{--                                        <a href="{{ route('account.stock-in-hand') }}">--}}
{{--                                            <i class="menu-icon fa fa-caret-right"></i>--}}
{{--                                            Stock In Hand--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <a href="{{ route('account.item-ledger') }}">--}}
{{--                                            <i class="menu-icon fa fa-caret-right"></i>--}}
{{--                                            Item Ledger--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </li>--}}
                    </ul>
                </li>
            @endif
        </ul>
    </li>
@endif
