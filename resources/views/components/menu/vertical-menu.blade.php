{{--

/**
*
* Created a new component <x-menu.vertical-menu/>.
*
*/

--}}


<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">

        <div class="navbar-nav theme-brand flex-row  text-center">
            <div class="nav-logo">
                <div class="nav-item theme-text">
                    <a href="{{ route('home') }}" class="nav-link"> E-Procurement </a>
                </div>
            </div>
            <div class="nav-item sidebar-toggle">
                <div class="btn-toggle sidebarCollapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-chevrons-left">
                        <polyline points="11 17 6 12 11 7"></polyline>
                        <polyline points="18 17 13 12 18 7"></polyline>
                    </svg>
                </div>
            </div>
        </div>
        @if (!Request::is('collapsible-menu/*'))
            <div class="profile-info">
                <div class="user-info">
                    <div class="profile-img">
                        <img src="{{ Vite::asset('resources/images/profile.png') }}" alt="avatar">
                    </div>
                    <div class="profile-content">
                        <h6 class="">{{ Auth::user()->name }}</h6>
                        <p class="">{{ Auth::user()->roles->first()->name }}</p>
                    </div>
                </div>
            </div>
        @endif

        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu {{ Request::routeIs('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span>Beranda</span>
                    </div>
                </a>
            </li>

            @if (Auth::user()->can('menu_review_vendor'))
                <li class="menu {{ Request::routeIs('vendor-review.*') ? 'active' : '' }}">
                    <a href="{{ route('vendor-review.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-clipboard">
                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2">
                                </path>
                                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                            </svg>
                            <span>Vendor Review</span>
                        </div>
                    </a>
                </li>
            @endif

            @if (Auth::user()->can('menu_product'))
                <li class="menu {{ Request::routeIs('product-management.*') ? 'active' : '' }}">
                    <a href="{{ route('product-management.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            <span>Product</span>
                        </div>
                    </a>
                </li>
            @endif

            @if (Auth::user()->can('menu_product_catalog'))
                <li class="menu {{ Request::routeIs('product-catalog.*') ? 'active' : '' }}">
                    <a href="{{ route('product-catalog.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-layers">
                                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                <polyline points="2 17 12 22 22 17"></polyline>
                                <polyline points="2 12 12 17 22 12"></polyline>
                            </svg>
                            <span>Product Catalogs</span>
                        </div>
                    </a>
                </li>
            @endif
        </ul>

    </nav>

</div>
