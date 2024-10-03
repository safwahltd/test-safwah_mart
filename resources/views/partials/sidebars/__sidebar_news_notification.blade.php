
@if(hasAnyPermission(["sms.sends.index", "notices.index"], $slugs) && hasModulePermission('News & Events', $active_modules))
    <li class="{{ request()->segment(1) == "news-events" ? 'open' : '' }}">
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-bullhorn text-primary"></i>
            <span class="menu-text"> News & Events </span>
            <b class="arrow far fa-angle-down"></b>
        </a>
        <b class="arrow"></b>

        <ul class="submenu">

            @if(hasPermission('sms.sends.index', $slugs))
                <li class="{{ request()->is('news-events/sms-api*') || request()->is('news-events/sms-send*') ? 'open' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-right text-primary"></i>
                        <span class="menu-text"> Sms Api </span>
                        <b class="arrow far fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <ul class="submenu">
                        @if (auth()->user()->email == 'admin@gmail.com')
                            <li class="{{ request()->is('news-events/sms-api*') ? 'active' : '' }}">
                                <a href="{{ route('sms-apis.index') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Api List
                                </a>
                                <b class="arrow"></b>
                            </li>
                        @endif

                        @if(hasPermission('sms-sends.create',$slugs))
                            <li class="{{ request()->is('news-events/sms-send*') ? 'active' : '' }}">
                                <a href="{{ route('sms-sends.create') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Send Sms
                                </a>
                                <b class="arrow"></b>
                            </li>
                        @endif

                        @if(hasPermission('sms-sends.manual',$slugs))
                            <li class="{{ request()->is('news-events/sms-send*') ? 'active' : '' }}">
                                <a href="{{ route('sms-sends.manual') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Send Manually
                                </a>
                                <b class="arrow"></b>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif


            @if(hasPermission('notices.index', $slugs))
                <li class="{{ request()->is('news-events/notice*') ? 'open' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-right text-primary"></i>
                        <span class="menu-text"> Notice </span>
                        <b class="arrow far fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>

                    <ul class="submenu">
                        @if(hasPermission('notices.index', $slugs))
                            <li class="{{ request()->is('news-events/notices/create') ? 'active' : '' }}">
                                <a href="{{ route('notices.create') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Notice Create
                                </a>
                                <b class="arrow"></b>
                            </li>
                        @endif

                        @if(hasPermission('notices.index', $slugs))
                            <li class="{{ request()->is('news-events/notices') ? 'active' : '' }}">
                                <a href="{{ route('notices.index') }}">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Notice List
                                </a>
                                <b class="arrow"></b>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
        </ul>
    </li>
@endif