<?php
session_start();
$currentPage = 'pickups';

// --- Dummy Data (cannot be deleted or canceled) ---
$dummyRequest = [
    'items' => [
        ['category' => 'Paper', 'quantity' => 25.5, 'subtotal' => 12.75],
        ['category' => 'Plastic', 'quantity' => 18.3, 'subtotal' => 14.64]
    ],
    'address_label' => 'Home',
    'address' => '123 Green Street, Kuala Lumpur',
    'date' => '2025-12-20',
    'time' => '10:00',
    'remarks' => 'Handle carefully',
    'totalPrice' => 10.0,
    'status' => 'Quoted',
    'quoted_price' => 10.0,
    'is_dummy' => true
];

// Add dummy request if not present
if (!isset($_SESSION['pickup_requests'])) $_SESSION['pickup_requests'] = [];
$exists = false;
foreach ($_SESSION['pickup_requests'] as $req) {
    if (isset($req['is_dummy']) && $req['is_dummy'] === true) {
        $exists = true;
        break;
    }
}
if (!$exists) array_unshift($_SESSION['pickup_requests'], $dummyRequest);

// Handle Accept/Reject Quotation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json; charset=utf-8');
    $action = $_POST['action'];
    $index = $_POST['index'] ?? null;

    if ($index !== null && isset($_SESSION['pickup_requests'][$index])) {
        switch ($action) {
            case 'accept_quote':
                $_SESSION['pickup_requests'][$index]['status'] = 'Waiting Payment';
                $_SESSION['pickup_requests'][$index]['accepted_at'] = date('Y-m-d H:i:s');
                echo json_encode(['ok' => true]);
                exit;
            case 'reject_quote':
                $_SESSION['pickup_requests'][$index]['status'] = 'Rejected';
                echo json_encode(['ok' => true]);
                exit;
        }
    }
    echo json_encode(['ok' => false, 'msg' => 'Invalid request']);
    exit;
}

$requests = $_SESSION['pickup_requests'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pickup Request | Greencycle</title>
<link rel="icon" type="image/png" href="../images/truck.png">
<link rel="stylesheet" href="../app/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="../app/dist/css/adminlte.min.css">
<link rel="stylesheet" href="../app/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../app/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<style>
.cancelBtn { width: 90px; padding: 3px 5px; font-size: 0.8rem; }
</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php include("../navbar/usernavbar.php"); ?>
<?php include("../sidebar/usersidebar.php"); ?>

<div class="content-wrapper">
<section class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h3 class="mb-2">Pickup Request</h3>
        <div class="d-flex gap-2">
            <a href="pickup_form.php" class="btn btn-success"><i class="fas fa-plus"></i> Add Request</a>
            <button id="deleteAllBtn" class="btn btn-danger" <?= empty($requests) ? 'disabled' : '' ?>><i class="fas fa-trash"></i> Delete All</button>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">
<div class="card">
    <div class="card-header"><h3 class="card-title">Your Pickup Requests</h3></div>
    <div class="card-body">
        <table id="pickupTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th><th>Item</th><th>Location</th><th>Qty</th>
                    <th>Date</th><th>Time</th><th>Status</th><th>Total Price (RM)</th>
                    <th>Remark</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($requests as $index => $req):
                $status = $req['status'] ?? 'Pending';
                switch($status){
                    case "Pending": $badge = '<span class="badge badge-warning">Pending</span>'; break;
                    case "Quoted": $badge = '<span class="badge badge-info">Quoted</span>'; break;
                    case "Waiting Payment": $badge = '<span class="badge badge-warning" style="background-color:#fd7e14;">Waiting Payment</span>'; break;
                    case "Completed": $badge = '<span class="badge badge-success">Completed</span>'; break;
                    case "Cancelled": $badge = '<span class="badge badge-secondary">Cancelled</span>'; break;
                    case "Rejected": $badge = '<span class="badge badge-danger">Rejected</span>'; break;
                    default: $badge='<span class="badge badge-light">Unknown</span>';
                }
                $itemSummary = isset($req['items']) ? implode("<br>", array_map(fn($it)=>$it['category']." ({$it['quantity']} kg)", $req['items'])) : "-";
                $totalQty = isset($req['items']) ? array_sum(array_map(fn($it)=>floatval($it['quantity']), $req['items'])) : 0;
                $isDummy = $req['is_dummy'] ?? false;
                $cancelAllowed = !$isDummy && ($status != "Cancelled");
            ?>
                <tr>
                    <td>REQ<?= str_pad($index+1,3,"0",STR_PAD_LEFT) ?></td>
                    <td><?= $itemSummary ?></td>
                    <td><?= $req['address_label'] ?> — <?= $req['address'] ?></td>
                    <td><?= number_format($totalQty,2) ?></td>
                    <td><?= $req['date'] ?></td>
                    <td><?= $req['time'] ?></td>
                    <td><?= $badge ?></td>
                    <td><?= isset($req['totalPrice']) ? "RM ".number_format($req['totalPrice'],2) : "-" ?></td>
                    <td><?= $req['remarks'] ?? "-" ?></td>
                    <td>
                        <?php if($status==="Quoted" || $status==="Waiting Payment"): ?>
                            <button class="btn btn-sm btn-info viewQuoteBtn" data-index="<?= $index ?>"><i class="fas fa-eye"></i> View Quote</button>
                        <?php else: ?>
                            <button class='btn btn-danger btn-sm cancelBtn' data-id='<?= $index ?>'
                                <?= $cancelAllowed ? "" : "disabled style='background-color:#6c757d; border-color:#6c757d; cursor:not-allowed;'" ?>>
                                <i class='fas fa-times'></i> Cancel
                            </button>
                        <?php endif; ?>
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

<!-- QQUOTATION MODAL -->
<div class="modal fade" id="quoteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">Quotation Details</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="quoteContent"></div>
      <div class="modal-footer">
        <button class="btn btn-success" id="acceptQuoteBtn">Accept</button>
        <button class="btn btn-danger" id="rejectQuoteBtn">Reject</button>
        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- ACCEPT QUOTE MODAL -->
<div class="modal fade" id="acceptQuoteModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Accept Quotation</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">Are you sure you want to accept this quotation?</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="confirmAcceptQuote">Yes, Accept</button>
      </div>
    </div>
  </div>
</div>

<!-- REJECT QUOTE MODAL -->
<div class="modal fade" id="rejectQuoteModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Reject Quotation</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">Are you sure you want to reject this quotation?</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmRejectQuote">Yes, Reject</button>
      </div>
    </div>
  </div>
</div>

<!-- CANCEL PICKUP MODAL -->
<div class="modal fade" id="cancelPickupModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cancel Pickup Request</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        Are you sure you want to cancel this pickup request?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Keep</button>
        <button type="button" class="btn btn-danger" id="confirmCancelPickup">Yes, Cancel</button>
      </div>
    </div>
  </div>
</div>


<script src="../app/plugins/jquery/jquery.min.js"></script>
<script src="../app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../app/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../app/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../app/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../app/dist/js/adminlte.min.js"></script>

<script>
let table = $("#pickupTable").DataTable({responsive:true,autoWidth:false});
let selectedQuoteIndex = null;
const requests = <?= json_encode($requests) ?>;


// DELETE ALL
$('#deleteAllBtn').on('click', function(){
    if(confirm("Are you sure you want to delete ALL pickup requests? This cannot be undone.")){
        $.post('pickup_form.php', {action: 'delete_all_requests'}, function(res){
            if(res.ok) location.reload();
            else alert('Could not delete requests');
        }, 'json');
    }
});

// --- OPEN CANCEL PICKUP MODAL ---
$(document).on("click", ".cancelBtn", function(){
    selectedCancelIndex = $(this).data("id");
    $('#cancelPickupModal').modal('show');
});

// --- CONFIRM CANCEL PICKUP MODAL ---
$('#confirmCancelPickup').on('click', function(){
    if(selectedCancelIndex === null) return;
    $.post('pickup_form.php', {action:'cancel_request', index:selectedCancelIndex}, function(res){
        if(res.ok) location.reload();
        else alert('Could not cancel request');
    }, 'json');
    $('#cancelPickupModal').modal('hide');
});

// VIEW QUOTE MODAL
$(document).on('click', '.viewQuoteBtn', function(){
    selectedQuoteIndex = $(this).data('index');
    const req = requests[selectedQuoteIndex];
    let html = '<ul>';
    req.items.forEach(it => {
        html += `<li>${it.category} — ${it.quantity} kg (Subtotal: RM ${it.subtotal.toFixed(2)})</li>`;
    });
    html += '</ul>';
    html += `<p><strong>Total Price: RM ${req.totalPrice.toFixed(2)}</strong></p>`;
    $('#quoteContent').html(html);
    $('#quoteModal').modal('show');
});

// --- ACCEPT MODAL ---
$('#acceptQuoteBtn').on('click', function() {
    if(selectedQuoteIndex===null) return;
    $('#quoteModal').modal('hide');
    $('#acceptQuoteModal').modal('show');
});
$('#confirmAcceptQuote').on('click', function() {
    $.post('pickups.php', {action:'accept_quote', index:selectedQuoteIndex}, function(res){
        if(res.ok) location.reload();
        else alert('Could not accept quotation');
    }, 'json');
    $('#acceptQuoteModal').modal('hide');
});

// --- REJECT MODAL ---
$('#rejectQuoteBtn').on('click', function() {
    if(selectedQuoteIndex===null) return;
    $('#quoteModal').modal('hide');
    $('#rejectQuoteModal').modal('show');
});
$('#confirmRejectQuote').on('click', function() {
    $.post('pickups.php', {action:'reject_quote', index:selectedQuoteIndex}, function(res){
        if(res.ok) location.reload();
        else alert('Could not reject quotation');
    }, 'json');
    $('#rejectQuoteModal').modal('hide');
});
</script>
</body>
</html>
