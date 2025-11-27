<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
        <img
            src="../images/truck.png"
            alt="Recycle Logo"
            class="brand-image"
        />
        <span class="brand-text font-weight-light">Recycle</span>
    </a>


    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a class="d-block"><i class="bi bi-shield-lock shield-icon" style="margin-right:3px;"></i>Admin</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                <li class="nav-item">
                    <a href="../admin/dashboard.php" class="nav-link <?= ($currentPage == 'dashboard' ? 'active' : '') ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="../admin/recyclable.php" class="nav-link <?= ($currentPage == 'recyclable' ? 'active' : '') ?>">
                        <i class="nav-icon fas fa-recycle"></i>
                        <p>Recyclable Items</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="../admin/pickups.php" class="nav-link <?= ($currentPage == 'pickups' ? 'active' : '') ?>">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>Pickup Requests</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="../admin/users.php" class="nav-link <?= ($currentPage == 'users' ? 'active' : '') ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
</aside>
