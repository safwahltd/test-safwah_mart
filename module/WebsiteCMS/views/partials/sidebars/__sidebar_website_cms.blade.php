
@if(auth()->user()->type != "Delivery Man")

<!--  Website CMS  -->
<li class="{{
    request()->segment(1) == 'website-cms'
    || request()->segment(3) == 'sliders'
    || request()->segment(3) == 'banners'
    || request()->segment(3) == 'faqs'
    || request()->segment(3) == 'contact-message'
    || request()->segment(3) == 'social-links'
    || request()->segment(3) == 'page-sections'
    ? 'active open' : ''
}}">
@if(hasPermission("website-cms.index", $slugs))

    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fas fa-globe"></i>
        <span class="menu-text"> Website CMS </span>
        <b class="arrow far fa-angle-down"></b>
    </a>


    <b class="arrow"></b>
    <ul class="submenu">

        <!--------------- BANNER---------------->
        @if(hasPermission("website-cms.index", $slugs))
            <li class="{{ request()->routeIs('website.banners*') ? 'active' : '' }}">
                <a href="{{ route('website.banners.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Banner
                </a>
                <b class="arrow"></b>
            </li>
        @endif




        <li class="{{ request()->routeIs('website.corporate-order*') || request()->routeIs('website.appointment-booking*') || request()->routeIs('website.orderby-picture*') ? 'active' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fas fa-list"></i>
                <span class="menu-text">Banner Forms </span>
                <b class="arrow far fa-angle-down"></b>
            </a>

            <b class="arrow"></b>
            <ul class="submenu">

                @if(hasPermission("website-cms.index", $slugs))
                    <li class="{{ request()->routeIs('website.corporate-order.index*') ? 'active' : '' }}">
                        <a href="{{ route('website.corporate-order.index') }}">
                            <span class="menu-text"> Corporate Order </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('website.orderby-picture.index*') ? 'active' : '' }}">
                        <a href="{{ route('website.orderby-picture.index') }}">
                            <span class="menu-text"> Order By Picture </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('website.appointment-booking.index*') ? 'active' : '' }}">
                        <a href="{{ route('website.appointment-booking.index') }}">
                            <span class="menu-text"> Appointment Booking </span>
                        </a>
                    </li>
                @endif

            </ul>
        </li>





        <li class="{{ request()->routeIs('website.sliders*') ? 'active' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fas fa-list"></i>
                <span class="menu-text">Slider </span>
                <b class="arrow far fa-angle-down"></b>
            </a>

            <b class="arrow"></b>
            <ul class="submenu">

                <!--------------- SLIDER CREATE---------------->
                @if(hasPermission("website-cms.create", $slugs))
                    <li class="{{ request()->routeIs('website.sliders.create*') ? 'active' : '' }}">
                        <a href="{{ route('website.sliders.create') }}">
                            <span class="menu-text"> Add New </span>
                        </a>

                        <b class="arrow"></b>
                    </li>
                @endif

                  <!--------------- SLIDER LIST---------------->
                @if(hasPermission("website-cms.index", $slugs))
                    <li class="{{ request()->routeIs('website.sliders.index*') ? 'active' : '' }}">
                        <a href="{{ route('website.sliders.index') }}">
                            <span class="menu-text"> Slider List </span>
                        </a>
                        <b class="arrow"></b>
                    </li>
                @endif
            </ul>
        </li>





        <li class="{{ request()->routeIs('website.pages*') ? 'active' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fas fa-list"></i>
                <span class="menu-text">Page </span>
                <b class="arrow far fa-angle-down"></b>
            </a>

            <b class="arrow"></b>
            <ul class="submenu">
                <!--------------- PAGE CREATE---------------->
                @if(hasPermission("website-cms.create", $slugs))
                    <li class="{{ request()->routeIs('website.pages.create*') ? 'active' : '' }}">
                        <a href="{{ route('website.pages.create') }}">
                            <span class="menu-text"> Add New </span>
                        </a>

                        <b class="arrow"></b>
                    </li>
                @endif

                <!--------------- PAGE LIST---------------->
                @if(hasPermission("website-cms.index", $slugs))
                    <li class="{{ request()->routeIs('website.pages.index*') ? 'active' : '' }}">
                        <a href="{{ route('website.pages.index') }}">
                            <span class="menu-text"> Page List </span>
                        </a>
                        <b class="arrow"></b>
                    </li>
                @endif
            </ul>
        </li>




        <!--------------- INSTRUCTION NOTE LIST---------------->
        @if(hasPermission("website-cms.index", $slugs))
            <li class="{{ request()->routeIs('website.instruction-notes.index*') ? 'active' : '' }}">
                <a href="{{ route('website.instruction-notes.index') }}" style="padding-right: 10px;">
                    <span class="menu-text"> Instruction Note</span>
                </a>
                <b class="arrow"></b>
            </li>
        @endif







        {{-- <li class="{{ request()->routeIs('website.page-sections*') ? 'active' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fas fa-list"></i>
                <span class="menu-text">Page Section</span>
                <b class="arrow far fa-angle-down"></b>
            </a>

            <b class="arrow"></b>
            <ul class="submenu">
                <!--------------- PAGE CREATE---------------->
                @if(hasPermission("website-cms.create", $slugs))
                    <li class="{{ request()->routeIs('website.page-sections.create*') ? 'active' : '' }}">
                        <a href="{{ route('website.page-sections.create') }}">
                            <span class="menu-text"> Add New </span>
                        </a>

                        <b class="arrow"></b>
                    </li>
                @endif

                <!--------------- PAGE LIST---------------->
                @if(hasPermission("website-cms.index", $slugs))
                    <li class="{{ request()->routeIs('website.page-sections.index*') ? 'active' : '' }}">
                        <a href="{{ route('website.page-sections.index') }}">
                            <span class="menu-text"> Page Section List </span>
                        </a>
                        <b class="arrow"></b>
                    </li>
                @endif
            </ul>
        </li> --}}





        {{-- <li class="{{ request()->routeIs('website.faqs*') ? 'active' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fas fa-list"></i>
                <span class="menu-text">FAQ </span>
                <b class="arrow far fa-angle-down"></b>
            </a>

            <b class="arrow"></b>
            <ul class="submenu">

                <!--------------- FAQ CREATE---------------->
                @if(hasPermission("website-cms.create", $slugs))
                    <li class="{{ request()->routeIs('website.faqs.create*') ? 'active' : '' }}">
                        <a href="{{ route('website.faqs.create') }}">
                            <span class="menu-text"> Add New </span>
                        </a>

                        <b class="arrow"></b>
                    </li>
                @endif


                <!--------------- FAQ LIST---------------->
                @if(hasPermission("website-cms.index", $slugs))
                    <li class="{{ request()->routeIs('website.faqs.index*') ? 'active' : '' }}">
                        <a href="{{ route('website.faqs.index') }}">
                            <span class="menu-text"> FAQ List </span>
                        </a>
                        <b class="arrow"></b>
                    </li>
                @endif

            </ul>
        </li> --}}





        <li class="{{ request()->routeIs('website.testimonials*') ? 'active' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fas fa-list"></i>
                <span class="menu-text">Testimonial </span>
                <b class="arrow far fa-angle-down"></b>
            </a>

            <b class="arrow"></b>
            <ul class="submenu">

                <!--------------- TESTIMONIAL CREATE---------------->
                @if(hasPermission("website-cms.create", $slugs))
                    <li class="{{ request()->routeIs('website.testimonials.create*') ? 'active' : '' }}">
                        <a href="{{ route('website.testimonials.create') }}">
                            <span class="menu-text"> Add New </span>
                        </a>

                        <b class="arrow"></b>
                    </li>
                @endif

                <!--------------- TESTIMONIAL LIST---------------->
                @if(hasPermission("website-cms.index", $slugs))
                    <li class="{{ request()->routeIs('website.testimonials.index*') ? 'active' : '' }}">
                        <a href="{{ route('website.testimonials.index') }}">
                            <span class="menu-text"> Testimonial List </span>
                        </a>
                        <b class="arrow"></b>
                    </li>
                @endif
            </ul>
        </li>




        {{-- Social Links --}}
        <li class="{{ request()->routeIs('website.social-links*') ? 'active' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fas fa-list"></i>
                <span class="menu-text">Social Link </span>
                <b class="arrow far fa-angle-down"></b>
            </a>

            <b class="arrow"></b>
            <ul class="submenu">

                <!--------------- SOCIAL LINK CREATE---------------->
                @if(hasPermission("website-cms.create", $slugs))
                    <li class="{{ request()->routeIs('website.social-links.create*') ? 'active' : '' }}">
                        <a href="{{ route('website.social-links.create') }}">
                            <span class="menu-text"> Add New </span>
                        </a>

                        <b class="arrow"></b>
                    </li>
                @endif

                <!--------------- SOCIAL LINK LIST---------------->
                @if(hasPermission("website-cms.index", $slugs))
                    <li class="{{ request()->routeIs('website.social-links.index*') ? 'active' : '' }}">
                        <a href="{{ route('website.social-links.index') }}">
                            <span class="menu-text"> Social Link List </span>
                        </a>
                        <b class="arrow"></b>
                    </li>
                @endif
            </ul>
        </li>


        <!--------------- CONTACT MESSAGE ---------------->
        <li class="{{ request()->routeIs('website.contact-message*') ? 'active' : '' }}">
            <a href="{{ route('website.contact-message.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Contact Message
            </a>
            <b class="arrow"></b>
        </li>


        <!--------------- SERVICES---------------->
        @if(hasPermission("website-cms.index", $slugs))
            <li class="{{ request()->routeIs('website.services*') ? 'active' : '' }}">
                <a href="{{ route('website.services.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Services
                </a>

                <b class="arrow"></b>
            </li>
        @endif



        <!--------------- SUBSCRIBER---------------->
        @if(hasPermission("website-cms.index", $slugs))
            <li class="{{ request()->routeIs('website.subscribers*') ? 'active' : '' }}">
                <a href="{{ route('website.subscribers.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Subscribers
                </a>

                <b class="arrow"></b>
            </li>
        @endif


        <!--------------- SUBSCRIBER CONTENT---------------->
        @if(hasPermission("website-cms.index", $slugs))
            <li class="{{ request()->routeIs('website.subscribers-content*') ? 'active' : '' }}">
                <a href="{{ route('website.subscribers-content.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Subscribers Content
                </a>

                <b class="arrow"></b>
            </li>
        @endif


        <!--------------- BLOG LIST---------------->
        @if(hasPermission("website-cms.index", $slugs))
            <li class="{{ request()->routeIs('website.blogs*') ? 'active' : '' }}">
                <a href="{{ route('website.blogs.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Article
                </a>

                <b class="arrow"></b>
            </li>
        @endif

        <!-- SEO MANAGEMENT -->
        @if(hasPermission("website-cms.meta-tag", $slugs))
            <li class="{{ request()->routeIs('website.seo-management.create') ? 'active' : '' }}">
                <a href="{{ route('website.seo-management.create') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Seo Management
                </a>
                <b class="arrow"></b>
            </li>
        @endif
    </ul>
@endif
</li>
@endif
