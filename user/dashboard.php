<?php
session_start(); // ✅ Essential for accessing $_SESSION
$currentPage = 'dashboard';

// Optional: Set mock session name if not set (for demo safety)
if (!isset($_SESSION['name'])) {
    $_SESSION['name'] = 'Nur';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard</title>
    <link rel="icon" type="image/png" href="../images/truck.png">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="../app/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../app/dist/css/adminlte.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include("../navbar/usernavbar.php"); ?>
        <?php include("../sidebar/usersidebar.php"); ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <h3 class="mb-2">Welcome back, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h3>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Stats Boxes -->
                    <div class="row">
                        <div class="col-lg-4 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3 id="total-requests">2</h3>
                                    <p>Total Requests</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-recycle"></i>
                                </div>
                                <a href="pickups.php" class="small-box-footer">New Request <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3 id="earned-amount">RM 120</h3>
                                    <p>Total Earned</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <a href="#" class="small-box-footer">View History <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3 id="pending-request">1</h3>
                                    <p>Pending Request</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <a href="pickups.php" class="small-box-footer">Track Requests <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Requests -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-history mr-1"></i>
                                        Your Recent Requests
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Recyclable Type</th>
                                                <th>Quantity</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Static demo data -->
                                            <tr>
                                                <td>REQ101</td>
                                                <td>Plastic, Paper</td>
                                                <td>4.5 kg</td>
                                                <td><span class="badge badge-warning">Pending</span></td>
                                                <td>2025-11-28</td>
                                            </tr>
                                            <tr>
                                                <td>REQ098</td>
                                                <td>Metal</td>
                                                <td>2.1 kg</td>
                                                <td><span class="badge badge-success">Completed</span></td>
                                                <td>2025-11-20</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>

        <?php include("../footer/userfooter.php"); ?>
    </div>

    <!-- Scripts -->
    <script src="../app/plugins/jquery/jquery.min.js"></script>
    <script src="../app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../app/dist/js/adminlte.min.js"></script>

    <!-- Optional: Example SweetAlert usage (commented) -->
    <!--
    <script>
        // Example: Show welcome message on first visit (optional)
        // if (!localStorage.getItem('seenWelcome')) {
        //     Swal.fire({
        //         title: 'Welcome!',
        //         text: 'You can manage your recycling requests here.',
        //         icon: 'info',
        //         timer: 2500,
        //         showConfirmButton: false
        //     });
        //     localStorage.setItem('seenWelcome', 'true');
        // }
    </script>
    -->

</body>

</html>