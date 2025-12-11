<?php
session_start();
$currentPage = 'pickups';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pickup Request</title>
<link rel="icon" type="image/png" href="../images/truck.png">
<link rel="stylesheet" href="../app/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="../app/dist/css/adminlte.min.css">
<link rel="stylesheet" href="../app/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../app/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<style>
.cancelBtn {
    width: 90px; /* fixed width */
    padding: 3px 5px; /* smaller padding */
    font-size: 0.8rem; /* smaller text */
}
</style>

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
                    <th>Remark</th> 
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                
            <?php
            $requests = $_SESSION['pickup_requests'] ?? [];
            foreach ($requests as $index => $req):
                $status = $req['status'] ?? 'Pending';
                switch($status){
                    case "Pending": $badge = '<span class="badge badge-warning">Pending</span>'; break;
                    case "Quoted": $badge = '<span class="badge badge-info">Quoted</span>'; break;
                    case "Pending Pickup": $badge = '<span class="badge badge-warning" style="background-color:#fd7e14;">Pending Pickup</span>'; break;
                    case "Completed": $badge = '<span class="badge badge-success">Completed</span>'; break;
                    case "Cancelled": $badge = '<span class="badge badge-secondary">Cancelled</span>'; break;
                    default: $badge='<span class="badge badge-light">Unknown</span>';
                }

                $itemSummary = isset($req['items']) ? implode("<br>", array_map(fn($it)=>$it['category']." ({$it['quantity']} kg)", $req['items'])) : "-";
                $totalQty = isset($req['items']) ? array_sum(array_map(fn($it)=>floatval($it['quantity']), $req['items'])) : 0;

                // check if cancel is allowed (>=2 days before)
                $today = new DateTime();
                $pickupDate = new DateTime($req['date']);
                $diffDays = ($pickupDate->getTimestamp() - $today->getTimestamp()) / (60*60*24);
                $cancelAllowed = ($diffDays >= 2) && ($status != "Cancelled");
            ?>
                <tr>
                    <td>REQ<?= str_pad($index+1, 3, "0", STR_PAD_LEFT) ?></td>
                    <td><?= $itemSummary ?></td>
                    <td><?= $req['address_label'] ?> — <?= $req['address'] ?></td>
                    <td><?= number_format($totalQty, 2) ?></td>
                    <td><?= $req['date'] ?></td>
                    <td><?= $req['time'] ?></td>
                    <td><?= $badge ?></td>
                    <td><?= isset($req['totalPrice']) ? "RM ".number_format($req['totalPrice'],2) : "-" ?></td>
                    <td><?= $req['remarks'] ?? "-" ?></td>
                    <td>
                        <button class='btn btn-danger btn-sm cancelBtn' data-id='<?= $index ?>'
                            <?= $cancelAllowed ? "" : "disabled style='background-color:#6c757d; border-color:#6c757d; cursor:not-allowed;'" ?>>
                            <i class='fas fa-times'></i> Cancel
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</div>
</section>
</div>

<?php include("../footer/userfooter.php"); ?>

<script src="../app/plugins/jquery/jquery.min.js"></script>
<script src="../app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../app/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../app/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../app/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../app/dist/js/adminlte.min.js"></script>

<script>
let table = $("#pickupTable").DataTable({
    responsive: true,
    autoWidth: false,
    columns: Array(10).fill({})
});

let selectedCancelIndex = null;

// CANCEL BUTTON
$(document).on("click",".cancelBtn",function(){
    selectedCancelIndex=$(this).data("id");
    if(confirm("Are you sure you want to cancel this request?")){
        $.post('pickup_form.php',{action:'cancel_request',index:selectedCancelIndex}, function(res){
            if(res.ok) location.reload();
            else alert('Could not cancel request');
        }, 'json');
    }
});
</script>
</body>
</html>
