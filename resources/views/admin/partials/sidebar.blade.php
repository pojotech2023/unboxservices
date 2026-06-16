<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
                <img src="{{ asset('img/logo.jpg') }}" alt="navbar brand" class="navbar-brand" height="50" style="width: 194px;" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">

                {{-- Dashboard --}}
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Mobile Management --}}
                <li class="nav-item {{ request()->routeIs('brands.*') || request()->routeIs('mobile.*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#mobileMenu" 
                       class="{{ request()->routeIs('brands.*') || request()->routeIs('mobile.*') ? '' : 'collapsed' }}"
                       aria-expanded="{{ request()->routeIs('brands.*') || request()->routeIs('mobile.*') ? 'true' : 'false' }}">
                        <i class="bi bi-phone"></i>
                        <p>Mobile Management</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('brands.*') || request()->routeIs('mobile.*') ? 'show' : '' }}" id="mobileMenu">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('brands.index') ? 'active' : '' }}">
                                <a href="{{ route('brands.index') }}">
                                    <span class="sub-item">Mobile Brands</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('brands.models.variants.questions.index') ? 'active' : '' }}">
                                <a href="{{ route('brands.models.variants.questions.index') }}">
                                    <span class="sub-item">Mobile Questions</span>
                                </a>
                            </li>
                             <li class="{{ request()->routeIs('admin.evaluations.mobile.*') ? 'active' : '' }}">
                                <a href="{{ route('admin.evaluations.mobile.index') }}">
                                    <span class="sub-item">Confirmed Orders</span>
                                </a>
                            </li>
                            
                    
                        </ul>
                    </div>
                </li>

                {{-- Laptop Management --}}
                <li class="nav-item {{ request()->routeIs('laptop.*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#laptopMenu"
                       class="{{ request()->routeIs('laptop.*') ? '' : 'collapsed' }}"
                       aria-expanded="{{ request()->routeIs('laptop.*') ? 'true' : 'false' }}">
                        <i class="bi bi-laptop"></i>
                        <p>Laptop Management</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('laptop.*') ? 'show' : '' }}" id="laptopMenu">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('laptop.index') ? 'active' : '' }}">
                                <a href="{{ route('laptop.brands.index') }}">
                                    <span class="sub-item">Laptop Brands</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.laptop.questions.index') ? 'active' : '' }}">
                                <a href="{{ route('admin.laptop.questions.index') }}">
                                    <span class="sub-item">Laptop Questions</span>
                                </a>
                            </li>
                             <li class="{{ request()->routeIs('admin.laptop-evaluations.index') ? 'active' : '' }}">
                                <a href="{{ route('admin.laptop-evaluations.index') }}">
                                    <span class="sub-item">Confirmed Orders </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Logout --}}
                <li class="nav-item">
                    <a href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <p>Sign Out</p>
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>
        </div>
    </div>
</div>