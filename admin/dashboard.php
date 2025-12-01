<?php
// session_start();
$currentPage = 'dashboard';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="icon" type="image/png" href="../images/truck.png">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="../app/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../app/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../app/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../app/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <?php include("../navbar/adminnavbar.php"); ?>
    <?php include("../sidebar/adminsidebar.php"); ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h3 class="mb-2">Dashboard</h3>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>12</h3>
                                <p>To Quote (Pending)</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <a href="request.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>5</h3>
                                <p>Pending Pickups</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-truck-loading"></i>
                            </div>
                            <a href="request.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>RM 450</h3>
                                <p>Today's Revenue</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->

                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-12 connectedSortable">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Urgent Tasks
                                </h3>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer</th>
                                        <th>Recyclable Type</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>REQ001</td>
                                        <td>Sheikh Hafizuddin</td>
                                        <td>Plastic</td>
                                        <td>5 kg</td>
                                        <td><span class="badge badge-warning">Pending</span></td>
                                        <td>2023-10-25</td>
                                    </tr>
                                    <tr>
                                        <td>REQ003</td>
                                        <td>Bob Marley</td>
                                        <td>Metal</td>
                                        <td>2 kg</td>
                                        <td><span class="badge badge-info">Pending Pickup</span></td>
                                        <td>2023-10-26</td>
                                    </tr>
                                    <tr>
                                        <td>REQ005</td>
                                        <td>Charlie Brown</td>
                                        <td>Glass</td>
                                        <td>8 kg</td>
                                        <td><span class="badge badge-warning">Pending</span></td>
                                        <td>2023-10-25</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </section>
                    <!-- /.Left col -->
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
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



</body>
</html>
