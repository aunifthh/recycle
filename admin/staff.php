<?php
$currentPage = 'staff';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Management | Greencycle</title>

    <link rel="icon" type="image/png" href="../images/truck.png">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="../app/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../app/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../app/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../app/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                            <h3 class="card-title mb-0">Manage Staff</h3>
                            <button class="btn btn-success" data-toggle="modal" data-target="#addModal">
                                <i class="fas fa-user-plus"></i> Add Staff
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="userTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Staff ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <!-- Preloaded demo staff -->
                                <tr>
                                    <td>STF001</td>
                                    <td>Fareez Fauzi</td>
                                    <td>fareez@gmail.com</td>
                                    <td>012-3456789</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>STF002</td>
                                    <td>Nur Ain Nadhirah</td>
                                    <td>ainnad@gmail.com</td>
                                    <td>019-9988776</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>STF003</td>
                                    <td>Arnie Sabila</td>
                                    <td>arnie@gmail.com</td>
                                    <td>017-2244668</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash"></i></button>
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


<!-- ADD USER MODAL -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Staff</h5>
            </div>
            <div class="modal-body">
                <label>Name</label>
                <input id="addName" type="text" class="form-control mb-2" required>

                <label>Email</label>
                <input id="addEmail" type="email" class="form-control mb-2" required>

                <label>Phone Number</label>
                <input id="addPhone" type="text" class="form-control mb-2" required>

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
                <h5 class="modal-title">Edit Staff</h5>
            </div>
            <div class="modal-body">

                <input id="editID" type="text" class="form-control mb-2" readonly>

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


<!-- SCRIPTS -->
<script src="../app/plugins/jquery/jquery.min.js"></script>
<script src="../app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../app/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../app/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../app/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../app/dist/js/adminlte.min.js"></script>

<script>
let table = $("#userTable").DataTable();
let selectedRow;

// Generate Staff ID
function generateStaffID(number) {
    return "STF" + number.toString().padStart(3, "0");
}

// ADD STAFF
$("#addUserBtn").on("click", function(e) {
    e.preventDefault();

    let name = $("#addName").val();
    let email = $("#addEmail").val();
    let phone = $("#addPhone").val();

    if (name && email && phone) {

        let newID = generateStaffID(table.rows().count() + 1);

        table.row.add([
            newID,
            name,
            email,
            phone,
            `
            <button class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash"></i></button>
            `
        ]).draw(false);

        $("#addModal").modal("hide");
        $("#addName").val("");
        $("#addEmail").val("");
        $("#addPhone").val("");

        Swal.fire({
            icon: 'success',
            title: 'Staff added!',
            text: 'New staff has been successfully created.',
            timer: 1500,
            showConfirmButton: false
        });
    }
});


// EDIT STAFF
$("#userTable tbody").on("click", ".edit-btn", function() {
    selectedRow = table.row($(this).parents("tr"));
    let data = selectedRow.data();

    $("#editID").val(data[0]);
    $("#editName").val(data[1]);
    $("#editEmail").val(data[2]);
    $("#editPhone").val(data[3]);

    $("#editModal").modal("show");
});

// SAVE EDIT
$("#saveEditBtn").on("click", function(e) {
    e.preventDefault();

    selectedRow.data([
        $("#editID").val(),
        $("#editName").val(),
        $("#editEmail").val(),
        $("#editPhone").val(),
        `
        <button class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></button>
        <button class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash"></i></button>
        `
    ]).draw(false);

    $("#editModal").modal("hide");

    Swal.fire({
        icon: 'success',
        title: 'Staff updated!',
        text: 'Changes saved successfully.',
        timer: 1500,
        showConfirmButton: false
    });
});


// DELETE STAFF
$("#userTable tbody").on("click", ".delete-btn", function() {

    let row = table.row($(this).parents("tr"));

    Swal.fire({
        title: "Delete this staff?",
        text: "This action cannot be undone.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete"
    }).then((result) => {
        if (result.isConfirmed) {

            row.remove().draw(false);

            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: 'Staff has been removed.',
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
});

</script>

</body>
</html>
