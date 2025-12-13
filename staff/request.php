<?php
session_start();
$currentPage = 'request';

// --- Dummy Data Initialization ---
if (!isset($_SESSION['admin_pickup_requests'])) {
    $_SESSION['admin_pickup_requests'] = [
        [
            'id' => 'REQ001',
            'customer' => 'Sheikh Hafizuddin',
            'address' => 'Kuala Lumpur, WP',
            'items' => [['category' => 'Plastic', 'quantity' => 10]],
            'status' => 'Pending',
            'date' => '2025-12-21',
            'time' => '10:00',
            'remarks' => 'Please call before arrival'
        ],
        [
            'id' => 'REQ002',
            'customer' => 'Auni Fatihah',
            'address' => 'Selangor, MY',
            'items' => [['category' => 'Paper', 'quantity' => 5]],
            'status' => 'Quoted',
            'date' => '2025-12-22',
            'time' => '14:00',
            'remarks' => '',
            'actual_weight' => 5.2,
            'quoted_price' => 2.60
        ],
        [
            'id' => 'REQ003',
            'customer' => 'Bob Marley',
            'address' => 'Penang, MY',
            'items' => [['category' => 'Metal', 'quantity' => 20]],
            'status' => 'Waiting Payment',
            'date' => '2025-12-20',
            'time' => '09:00',
            'remarks' => 'Heavy items',
            'actual_weight' => 21.0,
            'quoted_price' => 63.00
        ],
        [
            'id' => 'REQ004',
            'customer' => 'Alice Williams',
            'address' => 'Johor, MY',
            'items' => [['category' => 'Electronics', 'quantity' => 1]],
            'status' => 'Completed',
            'date' => '2025-12-18',
            'time' => '11:00',
            'remarks' => '',
            'actual_weight' => 2.5,
            'quoted_price' => 50.00
        ],
        [
            'id' => 'REQ005',
            'customer' => 'Charlie Brown',
            'address' => 'Perak, MY',
            'items' => [['category' => 'Glass', 'quantity' => 10]],
            'status' => 'Cancelled',
            'date' => '2025-12-19',
            'time' => '15:00',
            'remarks' => 'Cancelled by user'
        ],
         [
            'id' => 'REQ006',
            'customer' => 'David Beckham',
            'address' => 'Kedah, MY',
            'items' => [['category' => 'Plastic', 'quantity' => 15]],
            'status' => 'Rejected',
            'date' => '2025-12-23',
            'time' => '16:00',
            'remarks' => 'Price too low',
            'actual_weight' => 14.5,
            'quoted_price' => 10.00
        ]
    ];
}

// --- Handle Actions ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    $action = $_POST['action'];
    $index = $_POST['index'] ?? null;

    if ($index !== null && isset($_SESSION['admin_pickup_requests'][$index])) {
        $req = &$_SESSION['admin_pickup_requests'][$index];
        
        if ($action === 'generate_quote') {
            $req['actual_weight'] = floatval($_POST['weight']);
            $req['quoted_price'] = floatval($_POST['price']);
            $req['status'] = 'Quoted';
            echo json_encode(['ok' => true]);
            exit;
        } elseif ($action === 'release_payment') {
            $req['status'] = 'Completed';
            echo json_encode(['ok' => true]);
            exit;
        } elseif ($action === 'reject_request') {
             $req['status'] = 'Cancelled'; // Or specific 'Rejected' status if needed, using Cancelled for now based on flow
             echo json_encode(['ok' => true]);
             exit;
        }
    }
    
    if ($action === 'reset_data') {
        unset($_SESSION['admin_pickup_requests']);
        echo json_encode(['ok' => true]);
        exit;
    }

    echo json_encode(['ok' => false, 'msg' => 'Invalid request']);
    exit;
}

$requests = $_SESSION['admin_pickup_requests'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pickup Request | Greencycle</title>
    <link rel="icon" type="image/png" href="../images/truck.png">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="../app/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../app/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../app/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../app/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <?php include("../navbar/staffnavbar.php"); ?>
    <?php include("../sidebar/staffsidebar.php"); ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h3 class="mb-2">Pickup Request</h3>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">List of Pickup Requests</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer Name</th>
                                        <th>Location</th>
                                        <th>Item</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($requests as $index => $req): 
                                        $status = $req['status'];
                                        $badgeClass = 'badge-secondary';
                                        if ($status === 'Pending') $badgeClass = 'badge-warning'; // Orange-ish
                                        elseif ($status === 'Quoted') $badgeClass = 'badge-info';
                                        elseif ($status === 'Waiting Payment') $badgeClass = 'badge-primary';
                                        elseif ($status === 'Completed') $badgeClass = 'badge-success';
                                        elseif ($status === 'Rejected') $badgeClass = 'badge-danger';
                                        
                                        $itemStr = implode(', ', array_map(fn($i) => $i['category'] . ' (' . $i['quantity'] . 'kg)', $req['items']));
                                    ?>
                                    <tr>
                                        <td><?= $req['id'] ?></td>
                                        <td><?= $req['customer'] ?></td>
                                        <td><?= $req['address'] ?></td>
                                        <td><?= $itemStr ?></td>
                                        <td><span class="badge <?= $badgeClass ?>"><?= $status ?></span></td>
                                        <td>
                                            <?php if ($status === 'Pending'): ?>
                                                <button type="button" class="btn btn-primary btn-sm quoteBtn" data-index="<?= $index ?>">
                                                    <i class="fas fa-file-invoice"></i> Generate Quote
                                                </button>
                                                <!-- <button type="button" class="btn btn-danger btn-sm rejectBtn" data-index="<?= $index ?>">
                                                    <i class="fas fa-times"></i> Reject
                                                </button> -->
                                            <?php elseif ($status === 'Quoted'): ?>
                                                <span class="text-muted font-italic">Waiting for Customer</span>
                                            <?php elseif ($status === 'Waiting Payment'): ?>
                                                <button type="button" class="btn btn-success btn-sm paymentBtn" data-index="<?= $index ?>">
                                                    <i class="fas fa-money-bill-wave"></i> Release Payment
                                                </button>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-default btn-sm detailsBtn" data-index="<?= $index ?>">
                                                    <i class="fas fa-eye"></i> View Details
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <!-- Quote Modal -->
    <div class="modal fade" id="modal-quote">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Generate Quote</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="quoteForm">
                        <input type="hidden" id="quoteIndex">
                        <div class="form-group">
                            <label for="actualWeight">Actual Weight (kg)</label>
                            <input type="number" class="form-control" id="actualWeight" step="0.01" required placeholder="Enter weight">
                        </div>
                        <div class="form-group">
                            <label for="estimatedPrice">Total Value (RM)</label>
                            <input type="number" class="form-control" id="estimatedPrice" step="0.01" required placeholder="Enter amount">
                        </div>
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control" id="remarks" rows="3" placeholder="Enter remarks..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitQuote">Submit Quote</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Release Payment Confirmation Modal -->
    <div class="modal fade" id="modal-release-payment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h4 class="modal-title">Release Payment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to release payment and complete this request?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="confirmReleasePayment">Yes, Release Payment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Modal -->
    <div class="modal fade" id="modal-details">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Request Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="detailsContent">
                    <!-- Content filled by JS -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php include("../footer/adminfooter.php"); ?>
</div>


<!-- Scripts -->
<script src="../app/plugins/jquery/jquery.min.js"></script>
<script src="../app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../app/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../app/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../app/dist/js/adminlte.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });

    const requests = <?= json_encode($requests) ?>;
    let selectedPaymentIndex = null;

    // Open Quote Modal
    $('.quoteBtn').on('click', function() {
        const index = $(this).data('index');
        $('#quoteIndex').val(index);
        $('#actualWeight').val('');
        $('#estimatedPrice').val('');
        $('#remarks').val('');
        $('#modal-quote').modal('show');
    });

    // Submit Quote
    $('#submitQuote').on('click', function() {
        const index = $('#quoteIndex').val();
        const weight = $('#actualWeight').val();
        const price = $('#estimatedPrice').val();

        if(!weight || !price) {
            alert("Please fill in all fields");
            return;
        }

        $.post('request.php', {
            action: 'generate_quote',
            index: index,
            weight: weight,
            price: price
        }, function(res) {
            if(res.ok) {
                location.reload();
            } else {
                alert('Error processing request');
            }
        }, 'json');
    });

    // Release Payment Modal
    $('.paymentBtn').on('click', function() {
        selectedPaymentIndex = $(this).data('index');
        $('#modal-release-payment').modal('show');
    });

    // Confirm Release Payment
    $('#confirmReleasePayment').on('click', function() {
        if(selectedPaymentIndex === null) return;

        $.post('request.php', {
            action: 'release_payment',
            index: selectedPaymentIndex
        }, function(res) {
            if(res.ok) {
                location.reload();
            } else {
                alert('Error processing request');
            }
        }, 'json');
        $('#modal-release-payment').modal('hide');
    });

    // View Details
    $('.detailsBtn').on('click', function() {
        const index = $(this).data('index');
        const req = requests[index];
        
        let html = `
            <p><strong>Request ID:</strong> ${req.id}</p>
            <p><strong>Customer:</strong> ${req.customer}</p>
            <p><strong>Address:</strong> ${req.address}</p>
            <hr>
            <p><strong>Items:</strong></p>
            <ul>
        `;
        req.items.forEach(i => {
            html += `<li>${i.category} - ${i.quantity}kg</li>`;
        });
        html += `</ul>
            <p><strong>Status:</strong> ${req.status}</p>
            <hr>
        `;
        
        if(req.actual_weight) {
            html += `<p><strong>Final Weight:</strong> ${req.actual_weight} kg</p>`;
        }
        if(req.quoted_price) {
            html += `<p><strong>Payout:</strong> RM ${parseFloat(req.quoted_price).toFixed(2)}</p>`;
        }
        
        if(req.remarks) {
             html += `<p><strong>Remarks:</strong> ${req.remarks}</p>`;
        }

        $('#detailsContent').html(html);
        $('#modal-details').modal('show');
    });

  });
</script>

</body>
</html>
