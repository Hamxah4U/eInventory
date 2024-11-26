<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-win"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
            Smart billing
            <!-- <img src="../../img/dhslogo.png" alt="" style="width: 50%;"> -->
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            Dashboard</a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
     <?php  if($_SESSION['role'] == 'Admin'):?>
                <li class="nav-item active">
                    <a class="nav-link" href="/users">
                        <i class="fas fa-fw fa-user"></i>
                        Manage Users</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="/unit">
                    <i class="fas fa-folder"></i>
                    Manage Unit</a>
                </li>

                <!-- <li class="nav-item active">
                    <a class="nav-link" href="/product">
                    <i class="fas fa-shopping-cart"></i>
                    Manage Product</a>
                </li> -->
                
                <li class="nav-item active">
                    <a class="nav-link" href="/supply">
                    <i class="fas fa-truck"></i>
                    Manage Supply</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="/inventoryreport">
                    <i class="fas fa-search"></i>
                    Inventory Report</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="report">
                    <i class="fas fa-chart-pie"></i>
                    Report</a>
                </li>
            <?php else: ?>
                <li class="nav-item active">
                    <a class="nav-link" href="/billing">
                        <i class="fas fa-money-bill"></i>
                       Billing</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="/nhisbilling">
                        <i class="fas fa-file-invoice"></i> NHIS</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="/finance">
                        <i class="fas fa-money-bill"></i>
                         Finance
                    </a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="/billing">
                        <i class="fas fa-chart-pie"></i> 
                        Report
                    </a>
                </li>

            <?php endif; ?>

            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link" href="/logout">
                <i class="fas fa-sign-out-alt"></i>
                Logout</a>
            </li>


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

            <!-- Sidebar Message -->
</ul>