<?php $currentPage = 'pickups'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pickup Request</title>
    <link rel="icon" type="image/png" href="../images/truck.png">

    <!-- AdminLTE & DataTables -->
    <link rel="stylesheet" href="../app/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../app/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../app/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../app/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <?php include("../navbar/usernavbar.php"); ?>
    <?php include("../sidebar/usersidebar.php"); ?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h3 class="mb-2">Pickup Request</h3>
                <a href="pickup_form.php" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add Request
                </a>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Your Pickup Requests</h3>
                    </div>

                    <div class="card-body">
                        <table id="pickupTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Item</th>
                                    <th>Location</th>
                                    <th>Qty</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Total Price (RM)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>

            </div>
        </section>

    </div>

    <?php include("../footer/userfooter.php"); ?>
</div>

<!-- Cancel Confirmation Modal -->
<div class="modal fade" id="cancelModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancel Pickup Request</h5>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this request?</p>
            </div>
            <div class="modal-footer">
                <button id="cancelNo" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button id="cancelYes" class="btn btn-danger">Yes, Cancel</button>
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
let table = $("#pickupTable").DataTable({
    responsive: true,
    autoWidth: false
});

let selectedCancelIndex = null; // Store index to cancel

// LOAD REQUESTS
function loadRequests() {
    let requests = JSON.parse(localStorage.getItem("pickupRequests") || "[]");
    table.clear();

    requests.forEach((req, index) => {
        // Default status
        if (!req.status || req.status.trim() === "") {
            req.status = "Pending";
        }

        let statusBadge = "";
        switch(req.status) {
            case "Pending":
                statusBadge = '<span class="badge badge-warning">Pending Quotation</span>';
                break;
            case "Quoted":
                statusBadge = '<span class="badge badge-info">Quoted</span>';
                break;
            case "Pending Pickup":
                statusBadge = '<span class="badge badge-warning" style="background-color:#fd7e14;">Pending Pickup</span>';
                break;
            case "Completed":
                statusBadge = '<span class="badge badge-success">Complete</span>';
                break;
            case "Cancelled":
                statusBadge = '<span class="badge badge-secondary">Cancelled</span>';
                break;
            default:
                statusBadge = '<span class="badge badge-light">Unknown</span>';
        }

        table.row.add([
            "REQ" + String(index+1).padStart(3,"0"),
            req.category,
            req.address,
            req.quantityEstimate,
            req.date,
            req.time,
            statusBadge,
            req.totalPrice ? "RM " + req.totalPrice : "-",
            `
            <button class='btn btn-danger btn-sm cancelBtn' data-id='${index}' 
                ${req.status === "Cancelled" ? "disabled style='background-color:#6c757d; border-color:#6c757d; cursor:not-allowed;'" : ""}>
                <i class='fas fa-times'></i> Cancel
            </button>
            `
        ]).draw(false);
    });

    localStorage.setItem("pickupRequests", JSON.stringify(requests));
}

loadRequests();

// ================================
//     CANCEL REQUEST BUTTON
// ================================
$(document).on("click", ".cancelBtn", function () {
    selectedCancelIndex = $(this).data("id");
    $("#cancelModal").modal("show");
});

// Confirm Cancel
$("#cancelYes").on("click", function() {
    if (selectedCancelIndex === null) return;
    let requests = JSON.parse(localStorage.getItem("pickupRequests") || "[]");
    requests[selectedCancelIndex].status = "Cancelled";
    localStorage.setItem("pickupRequests", JSON.stringify(requests));
    loadRequests();
    selectedCancelIndex = null;
    $("#cancelModal").modal("hide");
});

// Cancel Modal 'No'
$("#cancelNo").on("click", function() {
    selectedCancelIndex = null;
});
</script>
</body>
</html>
