<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
                <img src="{{ asset('images/logo/logo.jpeg') }}" alt="navbar brand" class="navbar-brand" height="50" />
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

                {{-- Dashboard (Visible to all roles) --}}
                <li class="nav-item active">
                    <a href="{{ route('admin.dashboard') }}" class="collapsed" aria-expanded="false">
                        <i class="bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a href="" class="collapsed" aria-expanded="false">
                        <i class="fa-solid fa-building"></i>
                        <p>Sites</p>
                    </a>
                </li> --}}

                <li class="nav-item">
                    <a href="{{ route('sitemanagement.list') }}" class="collapsed" aria-expanded="false">
                        <i class="far fa-chart-bar"></i>
                        <p>Site Management</p>
                    </a>
                </li>

                 <li class="nav-item">
                    <a href="{{ route('quotation.form') }}" class="collapsed" aria-expanded="false">
                       <i class="fa-solid fa-file"></i>
                       <p>Generate Quotation</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('customer.list') }}" class="collapsed" aria-expanded="false">
                        <i class="bi bi-people-fill"></i>
                        <p>Customer Management</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#aggregatormenu">
                        <i class="bi bi-person-fill-add"></i>
                        <p>Vendor</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="aggregatormenu">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('vendor.list') }}" class="collapsed" aria-expanded="false">
                                    <span class="sub-item">Vendor Management</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('vendor.dashboard') }}">
                                    <span class="sub-item">Vendor Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('subcontractor.dashboard') }}">
                                    <span class="sub-item">SubContractor Dashboard</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('supervisor.list') }}" class="collapsed" aria-expanded="false">
                        <i class="bi bi-person-plus-fill"></i>
                        <p>Supervisor Creation</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('property-list') }}" class="collapsed" aria-expanded="false">
                        <i class="bi bi-person-plus-fill"></i>
                        <p>Property List</p>
                    </a>
                </li>

                {{-- Logout (Visible to all roles) --}}
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
