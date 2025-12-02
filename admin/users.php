<?php
$currentPage = 'users';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>

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
                <h3 class="mb-2">User Management</h3>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="card">

                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h3 class="card-title mb-0">Manage Users</h3>
                            <button class="btn btn-success" data-toggle="modal" data-target="#addModal">
                                <i class="fas fa-user-plus"></i> Add User
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="userTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
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

<!-- ADD USER MODAL -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add User</h5>
            </div>
            <div class="modal-body">
                <label>Name</label>
                <input id="addName" type="text" class="form-control mb-2" required>

                <label>Email</label>
                <input id="addEmail" type="email" class="form-control mb-2" required>

                <label>Phone Number</label>
                <input id="phoneNumber" type="text" class="form-control mb-2" required>

                <label>Role</label>
                <select id="addRole" class="form-control mb-2">
                    <option value="customer">Customer</option>
                    <option value="staff">Staff</option>
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button id="addUserBtn" class="btn btn-success">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- EDIT USER MODAL -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
            </div>
            <div class="modal-body">
                <label>Name</label>
                <input id="editName" type="text" class="form-control mb-2" required>

                <label>Email</label>
                <input id="editEmail" type="email" class="form-control mb-2" required>

                <label>Role</label>
                <select id="editRole" class="form-control mb-2">
                    <option value="customer">Customer</option>
                    <option value="staff">Staff</option>
                </select>
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
                <h5 class="modal-title">Delete User</h5>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this user?</p>
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
let table = $("#userTable").DataTable();
let selectedRowForDelete;

// Add User
$("#addUserBtn").on("click", function(e) {
    e.preventDefault();

    let name = $("#addName").val();
    let email = $("#addEmail").val();
    let role = $("#addRole").val();

    if(name && email) {
        table.row.add([
            table.rows().count() + 1,
            name,
            email,
            role,
            `
            <button class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash"></i></button>
            `
        ]).draw(false);

        $("#addModal").modal("hide");
        $("#addName").val("");
        $("#addEmail").val("");
    }
});

// Edit User
let selectedRow;
$("#userTable tbody").on("click", ".edit-btn", function() {
    selectedRow = table.row($(this).parents("tr"));
    let data = selectedRow.data();

    $("#editName").val(data[1]);
    $("#editEmail").val(data[2]);
    $("#editRole").val(data[3]);

    $("#editModal").modal("show");
});

$("#saveEditBtn").on("click", function(e) {
    e.preventDefault();

    selectedRow.data([
        selectedRow.data()[0],
        $("#editName").val(),
        $("#editEmail").val(),
        $("#editRole").val(),
        `
        <button class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></button>
        <button class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash"></i></button>
        `
    ]).draw(false);

    $("#editModal").modal("hide");
});

// Delete User - show modal
$("#userTable tbody").on("click", ".delete-btn", function() {
    selectedRowForDelete = table.row($(this).parents("tr"));
    $("#deleteModal").modal("show");
});

// Confirm Delete
$("#confirmDelete").on("click", function() {
    if(selectedRowForDelete) {
        selectedRowForDelete.remove().draw(false);
        selectedRowForDelete = null;
    }
    $("#deleteModal").modal("hide");
});

// Cancel Delete
$("#cancelDelete").on("click", function() {
    selectedRowForDelete = null;
});
</script>

</body>
</html>
