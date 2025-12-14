<?php
session_start();

// Reset all pickup requests except one dummy
if (!isset($_SESSION['dummyAdded'])) {
    $dummyRequest = [
        'items' => [
            ['category' => 'Paper', 'quantity' => 25.5, 'subtotal' => 12.75],
            ['category' => 'Plastic', 'quantity' => 18.3, 'subtotal' => 14.64],
        ],
        'address_label' => 'Home',
        'address' => '123 Green Street, Kuala Lumpur',
        'date' => '2025-12-20',
        'time' => '10:00',
        'remarks' => 'Handle carefully',
        'totalPrice' => 27.39,
        'status' => 'Quoted',
        'isDummy' => true
    ];

    $_SESSION['pickupRequests'] = [$dummyRequest];
    $_SESSION['dummyAdded'] = true;
}

// Handle "Delete All" action
if (isset($_POST['deleteAll'])) {
    // Keep only dummy request
    $dummy = $_SESSION['pickupRequests'][0] ?? null;
    $_SESSION['pickupRequests'] = $dummy ? [$dummy] : [];
    header("Location: pickups.php");
    exit;
}

// Handle new user-added requests
if (isset($_POST['pickupData'])) {
    $newRequest = json_decode($_POST['pickupData'], true);
    $newRequest['isDummy'] = false;
    $_SESSION['pickupRequests'][] = $newRequest;

    header("Location: pickups.php");
    exit;
}

// Load requests from session
$requests = $_SESSION['pickupRequests'];
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Pickup Request | Greencycle</title>
        <link rel="icon" href="../images/truck.png">
        <link rel="stylesheet" href="../app/plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="../app/dist/css/adminlte.min.css">
        <link rel="stylesheet" href="../app/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            .badge-status { min-width: 90px; text-align: center; }
            button:disabled { opacity:0.6; cursor:not-allowed; }
        </style>
    </head>
    <body class="hold-transition sidebar-mini">
    <div class="wrapper">

    <?php include("../navbar/usernavbar.php"); ?>
    <?php include("../sidebar/usersidebar.php"); ?>

    <div class="content-wrapper">
        <section class="content-header">
        <div class="container-fluid">
        <h3 class="mb-2">Pickup Request</h3>
        </div>
        </section>

    <section class="content">
        <div class="container-fluid">
        <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <h3 class="card-title mb-0">Manage Recyclable Types</h3>
                                <div class="d-flex gap-2" data-toggle="modal" data-target="#addModal">
                                    <a href="pickup_form.php" class="btn btn-success"><i class="fas fa-plus"></i> Add Request</a>
                                </div>
                            </div>
                        </div>
        <div class="card-body">
            <table id="pickupTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                <th>ID</th><th>Item</th><th>Location</th><th>Qty</th>
                <th>Date</th><th>Time</th><th>Status</th><th>Total (RM)</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($requests as $i=>$r):
                $totalQty = array_sum(array_column($r['items'],'quantity'));
                $itemList = implode('<br>', array_map(fn($x)=>$x['category']." ({$x['quantity']}kg)", $r['items']));
                $badgeClass = ($r['status']=='Quoted') ? 'badge-info' 
                            : (in_array($r['status'], ['Pending Payment','Pending']) ? 'badge-warning' 
                            : (($r['status']=='Cancelled') ? 'badge-secondary' : 'badge-danger'));
                ?>
                <tr data-index="<?= $i ?>">
                <td>REQ<?= str_pad($i+1,3,'0',STR_PAD_LEFT) ?></td>
                <td><?= $itemList ?></td>
                <td><?= $r['address_label'].' — '.$r['address'] ?></td>
                <td><?= number_format($totalQty,2) ?></td>
                <td><?= $r['date'] ?></td>
                <td><?= $r['time'] ?></td>
                <td><span class="badge <?= $badgeClass ?> badge-status status"><?= $r['status'] ?></span></td>
                <td><?= number_format($r['totalPrice'],2) ?></td>
                <td>
                <?php if(isset($r['isDummy']) && $r['isDummy'] === true): ?>
                    <button class="btn btn-info btn-sm viewQuote" <?= in_array($r['status'],['Pending Payment','Quotation Rejected','Cancelled'])?'disabled':'' ?>><i class="fas fa-eye"></i> See Quotation</button>
                <?php else: ?>
                    <button class="btn btn-danger btn-sm cancel" <?= $r['status']=='Cancelled'?'disabled':'' ?>><i class="fas fa-times"></i> Cancel</button>
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

    <!-- Quote Modal -->
    <div class="modal fade" id="quoteModal">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Quotation Details</h5>
            </div>
            <div class="modal-body">
                <ul id="quoteList"></ul>
                <strong>Total: RM <span id="quoteTotal"></span></strong>
            </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="accept">Accept</button>
                    <button class="btn btn-danger" id="reject">Reject</button>
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../app/plugins/jquery/jquery.min.js"></script>
    <script src="../app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../app/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../app/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script>
    $('#pickupTable').DataTable();

    let requests = <?= json_encode($requests) ?>;
    let currentIndex = null;

    // VIEW QUOTE
    $('.viewQuote').click(function(){
        currentIndex = $(this).closest('tr').data('index');
        const r = requests[currentIndex];
        $('#quoteList').html(r.items.map(i=>`<li>${i.category} — ${i.quantity}kg (RM ${i.subtotal})</li>`));
        $('#quoteTotal').text(r.totalPrice.toFixed(2));

        if(['Pending Payment','Quotation Rejected','Cancelled'].includes(r.status)){
            $('#accept,#reject').prop('disabled', true);
        } else {
            $('#accept,#reject').prop('disabled', false);
        }

        $('#quoteModal').modal('show');
    });

    // ACCEPT QUOTE
    $('#accept').click(()=>{
        if(currentIndex===null) return;
        requests[currentIndex].status = "Pending Payment";
        updateRowStatus(currentIndex, "Pending Payment", "badge-warning");
        disableQuoteButton(currentIndex);
        Swal.fire('Accepted','Quotation accepted','success');
        $('#quoteModal').modal('hide');
    });

    // REJECT QUOTE
    $('#reject').click(()=>{
        if(currentIndex===null) return;
        requests[currentIndex].status = "Quotation Rejected";
        updateRowStatus(currentIndex, "Quotation Rejected", "badge-danger");
        disableQuoteButton(currentIndex);
        Swal.fire('Rejected','Quotation rejected','success');
        $('#quoteModal').modal('hide');
    });

    // CANCEL user-added requests
    $('.cancel').click(function(){
        let idx = $(this).closest('tr').data('index');
        Swal.fire({
            title:'Cancel pickup?',
            icon:'warning',
            showCancelButton:true
        }).then(res=>{
            if(res.isConfirmed){
                requests[idx].status = "Cancelled";
                updateRowStatus(idx, "Cancelled", "badge-secondary");
                $(this).prop('disabled',true);
                Swal.fire('Cancelled','Pickup request cancelled','success');
            }
        });
    });

    function updateRowStatus(index, text, badgeClass){
        let row = $('#pickupTable tbody tr').eq(index);
        let $status = row.find('.status');
        $status.removeClass().addClass(`badge ${badgeClass} badge-status`).text(text);
    }

    function disableQuoteButton(index){
        let row = $('#pickupTable tbody tr').eq(index);
        row.find('.viewQuote').prop('disabled',true);
    }
    </script>
    </body>
</html>
