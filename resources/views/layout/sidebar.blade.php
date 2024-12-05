
<div class="menu">
    <div class="custom-scroll">
        <div class="sidebar-menu">
            <ul>
                <li class="sidebar-title"><span>Menu</span></li>
                <li class="sidebar-item"><a href="index.html" class="sidebar-link active" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard" tabindex="0"><i class="bi bi-grid-fill"></i> <span>Dashboard</span></a></li>
                <li class="sidebar-item has-sub {{ Route::is('product.list') ? 'active' : '' }}">
                    <a role="button" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="right" title="Components" tabindex="0"><i class="bi bi-stack"></i> <span>Product</span></a>
                    <ul class="sub-menu" style="{{ Route::is('product.list') ? 'display: none' : '' }}">
                        <li><a href="{{ route('product.list') }}" class="sub-menu-item">Product List</a></li>
                        <li><a href="component_badge.html" class="sub-menu-item">Product Details</a></li>
                    </ul>
                </li>
                <li class="sidebar-item"><a href="extra_component.html" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="right" title="Extra Components" tabindex="0"><i class="bi bi-collection-fill"></i> <span>Client</span></a></li>

                <li class="sidebar-item has-sub">
                    <a role="button" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="right" title="Icons" tabindex="0"><i class="bi bi-egg-fill"></i> <span>Quotation</span></a>
                    <ul class="sub-menu">
                        <li><a href="bootstrap_icon.html" class="sub-menu-item">Quotation Table </a></li>
                        <li><a href="font_awesome.html" class="sub-menu-item">Quotation Details</a></li>
                    </ul>
                </li>
                <li class="sidebar-item"><a href="chart.html" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="right" title="Charts" tabindex="0"><i class="bi bi-bar-chart-fill"></i> <span>Apexcharts</span></a></li>
                <li class="sidebar-item has-sub">
                    <a role="button" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="right" title="Authentication" tabindex="0"><i class="bi bi-person-badge-fill"></i> <span>Authentication</span></a>
                    <ul class="sub-menu">
                        <li><a href="login.html" class="sub-menu-item">Login</a></li>
                        <li><a href="register.html" class="sub-menu-item">Register</a></li>
                        <li><a href="password.html" class="sub-menu-item">Forgot Password</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>