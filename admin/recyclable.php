<?php
// session_start();
// include('../auth/check_admin.php'); // Optional
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recyclable Items</title>

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
                <h3 class="mb-2">Recyclable Items</h3>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Manage Recyclable Types</h3>

                        <button class="btn btn-success float-right" data-toggle="modal" data-target="#addModal">
                            <i class="fas fa-plus"></i> Add Item
                        </button>
                    </div>

                    <div class="card-body">
                        <table id="recycleTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Material</th>
                                    <th>Rate / KG (RM)</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Sample data (Replace with database) -->
                                <tr>
                                    <td>1</td>
                                    <td>Plastic</td>
                                    <td>1.20</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </section>
    </div>

    <?php include("../footer/adminfooter.php"); ?>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Recyclable Item</h5>
            </div>
            <div class="modal-body">

                <label>Material Name</label>
                <input type="text" class="form-control mb-2" placeholder="e.g. Plastic" required>

                <label>Rate per KG (RM)</label>
                <input type="number" step="0.01" class="form-control" placeholder="0.00" required>

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button class="btn btn-success">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="../app/plugins/jquery/jquery.min.js"></script>
<script src="../app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../app/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../app/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../app/dist/js/adminlte.min.js"></script>

<script>
    $("#recycleTable").DataTable();
</script>

</body>
</html>
