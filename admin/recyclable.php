<?php
// session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recyclable Items</title>
    <link rel="icon" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/icons/recycle.svg">

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
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <div>
                                <h3 class="card-title mb-0">Manage Recyclable Types</h3>
                            </div>
                            <div>
                                <button class="btn btn-success" data-toggle="modal" data-target="#addModal">
                                    <i class="fas fa-plus"></i> Add Item
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="recycleTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Material</th>
                                    <th>Rate / KG (RM)</th>
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

<!-- Add Modal -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Recyclable Item</h5>
            </div>
            <div class="modal-body">

                <label>Material Name</label>
                <input id="addMaterial" type="text" class="form-control mb-2" placeholder="e.g. Plastic" required>

                <label>Rate per KG (RM)</label>
                <input id="addRate" type="number" step="0.01" class="form-control" placeholder="0.00" required>

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button id="addItemBtn" class="btn btn-success">Save</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Recyclable Item</h5>
            </div>
            <div class="modal-body">
                <label>Material Name</label>
                <input id="editMaterial" type="text" class="form-control mb-2" required>

                <label>Rate per KG (RM)</label>
                <input id="editRate" type="number" step="0.01" class="form-control" required>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button id="saveEditBtn" class="btn btn-primary">Save</button>
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

<script>
    let recycleTable = $("#recycleTable").DataTable();

    // ADD ITEM
    $("#addItemBtn").on("click", function() {
        let material = $("#addMaterial").val();
        let rate = $("#addRate").val();

        if(material && rate){
            recycleTable.row.add([
                recycleTable.rows().count() + 1,
                material,
                parseFloat(rate).toFixed(2),
                `
                <button class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash"></i></button>
                `
            ]).draw(false);

            $("#addModal").modal("hide");
            $("#addMaterial").val("");
            $("#addRate").val("");
        }
    });
</script>

<script>
    let selectedRow;

    // OPEN EDIT MODAL
    $("#recycleTable tbody").on("click", ".edit-btn", function() {
        selectedRow = recycleTable.row($(this).parents("tr"));
        let data = selectedRow.data();

        $("#editMaterial").val(data[1]);
        $("#editRate").val(data[2]);

        $("#editModal").modal("show");
    });

    // SAVE EDIT
    $("#saveEditBtn").on("click", function(e) {
        e.preventDefault();

        let newMaterial = $("#editMaterial").val();
        let newRate = $("#editRate").val();

        selectedRow.data([
            selectedRow.data()[0], // ID stays same
            newMaterial,
            parseFloat(newRate).toFixed(2),
            `
            <button class="btn btn-primary btn-sm edit-btn"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash"></i></button>
            `
        ]).draw(false);

        $("#editModal").modal("hide");
    });
</script>

<script>
    // DELETE / ARCHIVE
    $("#recycleTable tbody").on("click", ".delete-btn", function() {
        let row = recycleTable.row($(this).parents("tr"));

        if(confirm("Archive this item?")){
            row.remove().draw(false);
        }
    });
</script>



</body>
</html>
