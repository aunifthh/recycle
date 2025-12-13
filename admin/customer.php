<?php
$currentPage = 'customer';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Management | Greencycle</title>

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

        <section class="content-header">
            <div class="container-fluid">
                <h3 class="mb-2">Customer Management</h3>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Manage Customers</h3>
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

<!-- EDIT MODAL -->
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

                <label>Phone</label>
                <input id="editPhone" type="text" class="form-control mb-2" required>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button id="saveEditBtn" class="btn btn-primary">Update</button>
            </div>
        </form>
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
// Initialize DataTable
let table = $("#customerTable").DataTable();
let selectedRow;
let selectedRowForDelete;

// AUTO GENERATE CUSTOMER ID
let custCounter = 1;

function generateCustID() {
    return "CUS" + String(custCounter).padStart(3, '0');
}

// Add initial 5 sample customers
const initialCustomers = [
    {name: "Sheikh Hafizuddin", email: "hafiz@gmail.com", phone: "0134455667"},
    {name: "Auni Fatihah", email: "auni@gmail.com", phone: "0112233445"},
    {name: "Bob Marley", email: "bob@gmail.com", phone: "0129898989"},
    {name: "Alice Williams", email: "alice@gmail.com", phone: "0187766554"},
    {name: "Charlie Brown", email: "charlie@gmail.com", phone: "0179988776"},
];

initialCustomers.forEach(c => {
    let id = generateCustID();
    table.row.add([
        id,
        c.name,
        c.email,
        c.phone,
        `
        <button class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></button>
        <button class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash"></i></button>
        `
    ]).draw(false);

    custCounter++;
});

// EDIT CUSTOMER
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

    Swal.fire({
        icon: 'success',
        title: 'Updated Successfully',
        text: 'Customer information has been updated.',
        timer: 1500,
        showConfirmButton: false
    });

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

// DELETE CUSTOMER
$("#customerTable tbody").on("click", ".delete-btn", function() {
    selectedRowForDelete = table.row($(this).parents("tr"));

    Swal.fire({
        title: 'Delete Customer?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
    }).then(result => {
        if (result.isConfirmed) {
            selectedRowForDelete.remove().draw(false);

            Swal.fire({
                icon: 'success',
                title: 'Deleted',
                text: 'Customer has been removed.',
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
});
</script>

</body>
</html>
