<?php
// session_start();
$currentPage = 'dashboard';
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
    <link rel="stylesheet" href="../app/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../app/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include("../navbar/usernavbar.php"); ?>
        <?php include("../sidebar/usersidebar.php"); ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <h3 class="mb-2">Welcome back, <?php echo htmlspecialchars($_SESSION['name'] ?? 'Nur'); ?>!</h3>
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
                                    <h3 id="total-requests">3</h3>
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
                                    <h3 id="earned-amount">RM 85</h3>
                                    <p>Total Earned</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <a href="" class="small-box-footer">View History <i class="fas fa-arrow-circle-right"></i></a>
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
                                                <th>Request ID</th>
                                                <th>Recyclables</th>
                                                <th>Weight</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Example static rows – replace with dynamic PHP fetch later -->
                                            <tr>
                                                <td>REQ101</td>
                                                <td>Plastic, Paper</td>
                                                <td>4.5 kg</td>
                                                <td><span class="badge badge-warning">Pending</span></td>
                                                <td>2025-11-28</td>
                                                <td><a href="view_request.php?id=REQ101" class="btn btn-sm btn-info">View</a></td>
                                            </tr>
                                            <tr>
                                                <td>REQ098</td>
                                                <td>Metal</td>
                                                <td>2.1 kg</td>
                                                <td><span class="badge badge-success">Completed</span></td>
                                                <td>2025-11-20</td>
                                                <td><a href="view_request.php?id=REQ098" class="btn btn-sm btn-info">View</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

            </section>
            <!-- /.content -->
        </div>

        <?php include("../footer/adminfooter.php"); ?>
    </div>


    <!-- Scripts -->
    <script src="../app/plugins/jquery/jquery.min.js"></script>
    <script src="../app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../app/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../app/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../app/dist/js/adminlte.min.js"></script>

    <script>
        document.getElementById('total-requests').textContent = '2';
        document.getElementById('earned-amount').textContent = 'RM 120';
        document.getElementById('pending-request').textContent = '1';
    </script>

</body>

</html>