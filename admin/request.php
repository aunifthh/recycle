<?php
// session_start();
$currentPage = 'request';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pickup Request | Greencycle</title>
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
                <h3 class="mb-2">Pickup Request</h3>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">List of Pickup Requests</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer Name</th>
                                        <th>Location</th>
                                        <th>Item</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Pending Request -->
                                    <tr>
                                        <td>REQ001</td>
                                        <td>Sheikh Hafizuddin</td>
                                        <td>Kuala Lumpur, WP</td>
                                        <td>Plastic</td>
                                        <td><span class="badge badge-warning">Pending Quotation</span></td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-quote">
                                                <i class="fas fa-file-invoice"></i> Generate Quote
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Quoted Request -->
                                    <tr>
                                        <td>REQ002</td>
                                        <td>Auni Fatihah</td>
                                        <td>Selangor, MY</td>
                                        <td>Paper</td>
                                        <td><span class="badge badge-info">Quoted</span></td>
                                        <td>
                                            <span class="text-muted font-italic">Waiting for User Decision</span>
                                        </td>
                                    </tr>
                                    <!-- Pending Pickup Request -->
                                    <tr>
                                        <td>REQ003</td>
                                        <td>Bob Marley</td>
                                        <td>Penang, MY</td>
                                        <td>Metal</td>
                                        <td><span class="badge badge-warning" style="background-color: #fd7e14; color: white;">Pending Pickup</span></td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i> Complete Job
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Completed Request -->
                                    <tr>
                                        <td>REQ004</td>
                                        <td>Alice Williams</td>
                                        <td>Johor, MY</td>
                                        <td>Electronics</td>
                                        <td><span class="badge badge-success">Complete</span></td>
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-details">
                                                <i class="fas fa-eye"></i> View Details
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Cancelled Request -->
                                    <tr>
                                        <td>REQ005</td>
                                        <td>Charlie Brown</td>
                                        <td>Perak, MY</td>
                                        <td>Glass</td>
                                        <td><span class="badge badge-secondary">Cancelled</span></td>
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-details">
                                                <i class="fas fa-eye"></i> View Details
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <!-- Quote Modal -->
    <div class="modal fade" id="modal-quote">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Generate Quote</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="actualWeight">Actual Weight (kg)</label>
                            <input type="number" class="form-control" id="actualWeight" placeholder="Enter weight">
                        </div>
                        <div class="form-group">
                            <label for="estimatedPrice">Total Value (RM)</label>
                            <input type="number" class="form-control" id="estimatedPrice" placeholder="Enter amount">
                        </div>
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control" id="remarks" rows="3" placeholder="Enter remarks..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Submit Quote</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Modal -->
    <div class="modal fade" id="modal-details">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Request Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Request ID:</strong> REQ004</p>
                    <p><strong>Customer:</strong> Alice Williams</p>
                    <p><strong>Address:</strong> 456 Blue Avenue, Johor, 81000</p>
                    <hr>
                    <p><strong>Item:</strong> Electronics</p>
                    <p><strong>Quantity:</strong> 1 unit</p>
                    <p><strong>Status:</strong> Complete</p>
                    <hr>
                    <p><strong>Final Weight:</strong> 2.5 kg</p>
                    <p><strong>Payout:</strong> RM 50.00</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
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
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
</script>



</body>
</html>
