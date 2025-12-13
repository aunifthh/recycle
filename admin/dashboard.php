<?php
session_start();
$currentPage = 'dashboard';

// --- Dummy Data Initialization (if not set) ---
if (!isset($_SESSION['admin_pickup_requests'])) {
    $_SESSION['admin_pickup_requests'] = [
        [
            'id' => 'REQ001',
            'customer' => 'Sheikh Hafizuddin',
            'address' => 'Kuala Lumpur, WP',
            'items' => [['category' => 'Plastic', 'quantity' => 10]],
            'status' => 'Pending',
            'date' => '2025-12-21',
            'time' => '10:00',
            'remarks' => 'Please call before arrival'
        ],
        [
            'id' => 'REQ002',
            'customer' => 'Auni Fatihah',
            'address' => 'Selangor, MY',
            'items' => [['category' => 'Paper', 'quantity' => 5]],
            'status' => 'Quoted',
            'date' => '2025-12-22',
            'time' => '14:00',
            'remarks' => '',
            'actual_weight' => 5.2,
            'quoted_price' => 2.60
        ],
        [
            'id' => 'REQ003',
            'customer' => 'Bob Marley',
            'address' => 'Penang, MY',
            'items' => [['category' => 'Metal', 'quantity' => 20]],
            'status' => 'Waiting Payment',
            'date' => '2025-12-20',
            'time' => '09:00',
            'remarks' => 'Heavy items',
            'actual_weight' => 21.0,
            'quoted_price' => 63.00
        ],
        [
            'id' => 'REQ004',
            'customer' => 'Alice Williams',
            'address' => 'Johor, MY',
            'items' => [['category' => 'Electronics', 'quantity' => 1]],
            'status' => 'Completed',
            'date' => '2025-12-18',
            'time' => '11:00',
            'remarks' => '',
            'actual_weight' => 2.5,
            'quoted_price' => 50.00
        ],
        [
            'id' => 'REQ005',
            'customer' => 'Charlie Brown',
            'address' => 'Perak, MY',
            'items' => [['category' => 'Glass', 'quantity' => 10]],
            'status' => 'Cancelled',
            'date' => '2025-12-19',
            'time' => '15:00',
            'remarks' => 'Cancelled by user'
        ],
         [
            'id' => 'REQ006',
            'customer' => 'David Beckham',
            'address' => 'Kedah, MY',
            'items' => [['category' => 'Plastic', 'quantity' => 15]],
            'status' => 'Rejected',
            'date' => '2025-12-23',
            'time' => '16:00',
            'remarks' => 'Price too low',
            'actual_weight' => 14.5,
            'quoted_price' => 10.00
        ]
    ];
}

$requests = $_SESSION['admin_pickup_requests'];

// --- Calculate Stats ---
$toQuoteCount = count(array_filter($requests, fn($r) => $r['status'] === 'Pending'));
$pendingPickupCount = count(array_filter($requests, fn($r) => $r['status'] === 'Waiting Payment'));
$revenue = array_sum(array_column(array_filter($requests, fn($r) => $r['status'] === 'Completed'), 'quoted_price'));

// --- Get Latest Tasks (First 5) ---
$latestTasks = array_slice($requests, 0, 5);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Greencycle</title>
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
                                <h3><?= $toQuoteCount ?></h3>
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
                                <h3><?= $pendingPickupCount ?></h3>
                                <p>Pending Pickups (Waiting Payment)</p>
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
                                <h3>RM <?= number_format($revenue, 2) ?></h3>
                                <p>Total Revenue</p>
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
                                    Latest Requests
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
                                    <?php foreach ($latestTasks as $task): 
                                        $status = $task['status'];
                                        $badgeClass = 'badge-secondary';
                                        if ($status === 'Pending') $badgeClass = 'badge-warning';
                                        elseif ($status === 'Quoted') $badgeClass = 'badge-info';
                                        elseif ($status === 'Waiting Payment') $badgeClass = 'badge-primary';
                                        elseif ($status === 'Completed') $badgeClass = 'badge-success';
                                        elseif ($status === 'Rejected') $badgeClass = 'badge-danger';

                                        $itemStr = implode(', ', array_map(fn($i) => $i['category'], $task['items']));
                                        $qtyStr = implode(', ', array_map(fn($i) => $i['quantity'] . ' kg', $task['items']));
                                    ?>
                                    <tr>
                                        <td><?= $task['id'] ?></td>
                                        <td><?= $task['customer'] ?></td>
                                        <td><?= $itemStr ?></td>
                                        <td><?= $qtyStr ?></td>
                                        <td><span class="badge <?= $badgeClass ?>"><?= $status ?></span></td>
                                        <td><?= $task['date'] ?></td>
                                    </tr>
                                    <?php endforeach; ?>
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
