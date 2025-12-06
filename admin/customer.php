<?php
$currentPage = 'customer';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Management</title>

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

    <div class="content-wrapper">

        <!-- Page Header -->
        <section class="content-header">
            <div class="container-fluid">
                <h3 class="mb-2">Customer Management</h3>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title mb-0">Manage Customers</h3>
                        <!-- No Add Customer button -->
                    </div>

                    <div class="card-body">
                        <table id="customerTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>

            </div>
        </section>

    </div>

    <?php include("../footer/adminfooter.php"); ?>
</div>

<!-- EDIT CUSTOMER MODAL -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Customer</h5>
            </div>
            <div class="modal-body">
                <label>Name</label>
                <input id="editName" type="text" class="form-control mb-2" required>

                <label>Email</label>
                <input id="editEmail" type="email" class="form-control mb-2" required>

                <label>Phone Number</label>
                <input id="editPhone" type="text" class="form-control mb-2" required>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button id="saveEditBtn" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Customer</h5>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this customer?</p>
            </div>
            <div class="modal-footer">
                <button id="cancelDelete" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button id="confirmDelete" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="../app/plugins/jquery/jquery.min.js"></script>
<script src="../app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../app/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../app/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../app/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../app/dist/js/adminlte.min.js"></script>

<script>
// Initialize table
let table = $("#customerTable").DataTable();
let selectedRow;
let selectedRowForDelete;

// Fake sample data (frontend only)
table.row.add([1, "Ali Ahmad", "ali@gmail.com", "0123456789", 
`
<button class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></button>
<button class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash"></i></button>
`
]).draw(false);

table.row.add([2, "Siti Aminah", "siti@gmail.com", "0198882233", 
`
<button class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></button>
<button class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash"></i></button>
`
]).draw(false);

// Edit:
$("#customerTable tbody").on("click", ".edit-btn", function() {
    selectedRow = table.row($(this).parents("tr"));
    let data = selectedRow.data();

    $("#editName").val(data[1]);
    $("#editEmail").val(data[2]);
    $("#editPhone").val(data[3]);

    $("#editModal").modal("show");
});

$("#saveEditBtn").on("click", function(e) {
    e.preventDefault();

    selectedRow.data([
        selectedRow.data()[0],
        $("#editName").val(),
        $("#editEmail").val(),
        $("#editPhone").val(),
        `
        <button class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></button>
        <button class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash"></i></button>
        `
    ]).draw(false);

    $("#editModal").modal("hide");
});

// Delete:
$("#customerTable tbody").on("click", ".delete-btn", function() {
    selectedRowForDelete = table.row($(this).parents("tr"));
    $("#deleteModal").modal("show");
});

$("#confirmDelete").on("click", function() {
    selectedRowForDelete.remove().draw(false);
    $("#deleteModal").modal("hide");
});

$("#cancelDelete").on("click", function() {
    selectedRowForDelete = null;
});
</script>

</body>
</html>
