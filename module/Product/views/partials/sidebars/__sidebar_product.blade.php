
@if(auth()->user()->type != "Delivery Man")

<!--  PRODUCT CONFIG  -->
<li class="{{
    request()->segment(2) == 'product-config'
    && request()->segment(3) == 'products'
    || request()->segment(3) == 'product-uploads'
    || request()->segment(3) == 'product-variation-uploads'
    || request()->segment(3) == 'discounts'
    || request()->segment(3) == 'offers'
    || request()->segment(3) == 'attribute-types'
    || request()->segment(3) == 'attributes'
    || request()->segment(3) == 'product-types'
    || request()->segment(3) == 'categories'
    || request()->segment(3) == 'brands'
    || request()->segment(3) == 'unit-measures'
    || request()->segment(3) == 'tags'
    || request()->segment(3) == 'books'
    || request()->segment(3) == 'writers'
    || request()->segment(3) == 'highlight-types'
    || request()->segment(3) == 'publishers'
    // || request()->segment(3) == 'products.create'
    ? 'active open' : ''
}}">
    @if (hasAnyPermission(['products.index', 'products.create', 'discounts.index', 'product-variation-uploads', 'product-barcode.index', 'product-offer.index', 'attribute-types.index', 'attributes.index', 'product-book.index', 'product-types.index', 'highlight-types.index', 'categories.index', 'brands.index', 'unit-measures.index'], $slugs))
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-cube"></i>
            <span class="menu-text"> Product </span>

            <b class="arrow far fa-angle-down"></b>
        </a>
    
    <b class="arrow"></b>

    <ul class="submenu">

        <!------------- PRODUCT CREATE ---------------->
        @if ((hasPermission("products.create", $slugs)))
            <li class="">
                <a href="{{ route('pdt.products.create') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Add Product
                </a>
                <b class="arrow"></b>
            </li>
        @endif


        <!------------- PRODUCT INDEX ---------------->
        @if ((hasPermission("products.index", $slugs)))
            <li class="{{ request()->routeIs('pdt.products*') ? 'active' : '' }}">
                <a href="{{ route('pdt.products.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Product
                </a>
                <b class="arrow"></b>
            </li>
        @endif

        <!------------- DISCOUNT  ---------------->
        @if ((hasPermission("discounts.index", $slugs)))  
            <li class="{{ request()->routeIs('discounts*') ? 'active' : '' }}">
                <a href="{{ route('discounts.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Discounts
                </a>

                <b class="arrow"></b>
            </li>
        @endif
        

       <!------------- OFFERS ---------------->
        @if ((hasPermission("product-offer.index", $slugs)))  
            <li class="{{ request()->routeIs('pdt.offers*') ? 'active' : '' }}">
                <a href="{{ route('pdt.offers.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Offer
                </a>

                <b class="arrow"></b>
            </li>
        @endif


        
        <!------------- BARCODE ---------------->
        @if ((hasPermission("product-barcode.index", $slugs)))  
            <li class="{{ request()->routeIs('pdt.unit-measures*') ? 'active' : '' }}">
                <a href="{{ route('pdt.print-barcode') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Barcode
                </a>

                <b class="arrow"></b>
            </li>
        @endif

        <!------------- PRODUCT UPLOAD  ---------------->
        @if ((hasPermission("products.index", $slugs)))  
            <li class="{{ request()->routeIs('pdt.product-uploads*') ? 'active' : '' }}">
                <a href="{{ route('pdt.product-uploads.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Product Upload
                </a>

                <b class="arrow"></b>
            </li>
        @endif

        <!------------- PRODUCT VARIATION UPLOAD ---------------->
        @if ((hasPermission("product-variation-uploads", $slugs)))  
            <li class="{{ request()->routeIs('pdt.product-variation-uploads*') ? 'active' : '' }}">
                <a href="{{ route('pdt.product-variation-uploads.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Variation Upload
                </a>
                <b class="arrow"></b>
            </li>
        @endif

        <!------------- ATTRIBUTE TYPE  ---------------->
        @if ((hasPermission("attribute-types.index", $slugs)))  
            <li class="{{ request()->routeIs('pdt.attribute-types*') ? 'active' : '' }}">
                <a href="{{ route('pdt.attribute-types.index') }}">
                    <span class="menu-text"> Attribute Type </span>
                </a>

                <b class="arrow"></b>
            </li>
        @endif

        <!------------- ATTRIBUTE ---------------->
        @if ((hasPermission("attributes.index", $slugs)))  
           <li class="{{ request()->routeIs('pdt.attributes*') ? 'active' : '' }}">
                <a href="{{ route('pdt.attributes.index') }}">
                    <span class="menu-text"> Attributes </span>
                </a>
                <b class="arrow"></b>
            </li>
        @endif


        <!------------- PRODUCT BOOK ---------------->
        @if ((hasPermission("product-book.index", $slugs)))  

            <li class="{{ request()->routeIs('pdt.books*') ? 'active' : '' }}">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fas fa-list"></i>
                    <span class="menu-text">Book</span>
                    <b class="arrow far fa-angle-down"></b>
                </a>

                <b class="arrow"></b>
                <ul class="submenu">
                    <li class="{{ request()->routeIs('pdt.books*') ? 'active' : '' }}">
                        <a href="{{ route('pdt.books.index') }}">
                            <span class="menu-text"> Book List </span>
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li class="{{ request()->routeIs('pdt.writers*') ? 'active' : '' }}">
                        <a href="{{ route('pdt.writers.index') }}">
                            <span class="menu-text"> Writer </span>
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li class="{{ request()->routeIs('pdt.publishers*') ? 'active' : '' }}">
                        <a href="{{ route('pdt.publishers.index') }}">
                            <span class="menu-text"> Publisher </span>
                        </a>
                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>
        @endif

        <!------------- PRODUCT TYPE ---------------->
        @if ((hasPermission("product-types.index", $slugs)))  
           <li class="{{ request()->routeIs('product-types*') ? 'active' : '' }}">
                <a href="{{ route('product-types.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Product Type
                </a>

                <b class="arrow"></b>
            </li>
        @endif

        <!------------- TAG ---------------->
        @if ((hasPermission("product-tags.index", $slugs)))  
            <li class="{{ request()->routeIs('product-tags*') ? 'active' : '' }}">
                <a href="{{ route('pdt.product-tags.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Tag
                </a>

                <b class="arrow"></b>
            </li>
        @endif

        <!------------- HIGHLIGHT TYPE ---------------->
        @if ((hasPermission("highlight-types.index", $slugs)))  
            <li class="{{ request()->routeIs('pdt.highlight-types*') ? 'active' : '' }}">
                <a href="{{ route('pdt.highlight-types.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Highlight Type
                </a>

                <b class="arrow"></b>
            </li>
        @endif
        
        <!------------- CATEGORY ---------------->
        @if ((hasPermission("categories.index", $slugs)))
            <li class="{{ request()->routeIs('pdt.categories*') ? 'active' : '' }}">
                <a href="{{ route('pdt.categories.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Category
                </a>

                <b class="arrow"></b>
            </li>
        @endif


        <!------------- BRAND ---------------->
        @if ((hasPermission("brands.index", $slugs)))
            <li class="{{ request()->routeIs('pdt.brands*') ? 'active' : '' }}">
                <a href="{{ route('pdt.brands.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Brand
                </a>

                <b class="arrow"></b>
            </li>
        @endif

        <!------------- UNIT MEASURE ---------------->
        @if ((hasPermission("unit-measures.index", $slugs)))  
            <li class="{{ request()->routeIs('pdt.unit-measures*') ? 'active' : '' }}">
                <a href="{{ route('pdt.unit-measures.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Unit Measure
                </a>

                <b class="arrow"></b>
            </li>
        @endif




    </ul>
    @endif

</li>

@endif
