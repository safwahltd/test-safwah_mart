<div id="sidebar" class="sidebar responsive ace-save-state sidebar-fixed sidebar-scroll">
    {{-- <script type="text/javascript">
        try {
            ace.settings.loadState('sidebar')
        } catch (e) {}
    </script> --}}


    <ul class="nav nav-list">
        <li class="{{ request()->is('home') ? 'active' : '' }}">
            <a href="{{ url('home') }}">
                <i class="menu-icon fa fa-tachometer"></i>
                <span class="menu-text"> Dashboard </span>
            </a>
            <b class="arrow"></b>
        </li>


        @include('partials/sidebars/__sidebar_inventory')


        @include('partials/sidebars/__sidebar_product')


        @include('partials/sidebars/__customer')


        @if (hasModulePermission('Account & Finance', $active_modules) && file_exists(base_path() . '/module/Account/routes/web_account.php') && hasModulePermission('Account & Finance', $active_modules))
            @include('partials.sidebars.__sidebar_account_finance')
        @endif


        @include('partials/sidebars/__report')

        @include('partials/sidebars/__sidebar_website_cms')

        @include('partials/sidebars/__sidebar_user_access')

        @include('partials/sidebars/__logistics')

        @include('partials/sidebars/__config')
        @if(auth()->user()->type != "Delivery Man")

            @if (hasAnyPermission(['website-cms.popup-notification'], $slugs))
                <li class="{{ request()->is('settings.popup-notifications.index') ? 'active' : '' }}">
                    <a href="{{ route('settings.popup-notifications.index') }}">
                        <i class="menu-icon fa fa-cogs"></i>
                        <span class="menu-text"> Popup Notification </span>
                    </a>
                    <b class="arrow"></b>
                </li>
            @endif

            @if (hasAnyPermission(['settings.company', 'settings.order', 'settings.email', 'settings.cms'], $slugs))

                <li class="{{ request()->is('settings.index') ? 'active' : '' }}">
                    <a href="{{ route('settings.index') }}">
                        <i class="menu-icon fa fa-cogs"></i>
                        <span class="menu-text"> Settings </span>
                    </a>
                    <b class="arrow"></b>
                </li>
            @endif
        @endif
    </ul>


    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div>
