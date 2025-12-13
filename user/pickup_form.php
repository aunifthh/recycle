<?php
session_start();

// --- Mock user/session data ---
if (!isset($_SESSION['user_data'])) {
    $_SESSION['user_data'] = [
        'name' => 'Ali Rahman',
        'email' => 'ali@example.com',
        'phone' => '0123456789',
        'password' => '',
        'addresses' => [
            ['id' => 1, 'label' => 'Home', 'address' => '123 Green Street, Kuala Lumpur', 'is_default' => true],
            ['id' => 2, 'label' => 'Office', 'address' => 'Level 5, Eco Tower, Bangsar', 'is_default' => false]
        ]
    ];
}
$user = &$_SESSION['user_data'];

// --- AJAX endpoints ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json; charset=utf-8');
    $action = $_POST['action'];

    if($action === 'save_request'){
        $payload = [
            'items' => $_POST['items'] ?? [],
            'address_id' => $_POST['address_id'] ?? '',
            'address_label' => $_POST['address_label'] ?? '',
            'address' => $_POST['address'] ?? '',
            'date' => $_POST['date'] ?? '',
            'time' => $_POST['time'] ?? '',
            'remarks' => $_POST['remarks'] ?? '',
            'totalPrice' => $_POST['totalPrice'] ?? 0,
            'status' => $_POST['status'] ?? 'Pending',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $_SESSION['pickup_requests'] = $_SESSION['pickup_requests'] ?? [];
        $_SESSION['pickup_requests'][] = $payload;

        echo json_encode(['ok' => true, 'request' => $payload]);
        exit;
    }

    if($action === 'cancel_request'){
        $index = $_POST['index'] ?? null;
        if($index !== null && isset($_SESSION['pickup_requests'][$index])){
            $req = $_SESSION['pickup_requests'][$index];
            $today = new DateTime();
            $pickupDate = new DateTime($req['date']);
            $diffDays = ($pickupDate->getTimestamp() - $today->getTimestamp()) / (60*60*24);

            if($diffDays >= 2){
                $_SESSION['pickup_requests'][$index]['status'] = 'Cancelled';
                echo json_encode(['ok'=>true]);
                exit;
            } else {
                echo json_encode(['ok'=>false,'msg'=>'Cannot cancel within 2 days']);
                exit;
            }
        }
        echo json_encode(['ok'=>false,'msg'=>'Invalid request']);
        exit;
    }

    if($action === 'delete_all_requests'){
        $_SESSION['pickup_requests'] = [];
        echo json_encode(['ok'=>true]);
        exit;
    }

    echo json_encode(['ok'=>false,'msg'=>'Unknown action']);
    exit;
}

$addresses_json = json_encode($user['addresses']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create Pickup Request | Greencycle</title>
<link rel="icon" type="image/png" href="../images/truck.png">
<link rel="stylesheet" href="../app/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="../app/dist/css/adminlte.min.css">
<style>
    .required { color: red; }
    .item-table th, .item-table td { vertical-align: middle; }
</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php include("../navbar/usernavbar.php"); ?>
<?php include("../sidebar/usersidebar.php"); ?>

<div class="content-wrapper">
<section class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h3 class="mb-2">Pickup Request / Add Request</h3>
        <a href="pickups.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</section>

<section class="content">
<div class="container-fluid">
<div class="card shadow-lg">
<div class="card-header bg-success text-white">
<h4 class="card-title mb-0"><i class="fas fa-recycle"></i> Create Pickup Request</h4>
</div>

<form id="pickupForm">
<div class="card-body">

    <!-- ADD RECYCLABLE ITEM -->
    <div class="form-row align-items-end">
        <div class="col-md-4">
            <label>Recyclable Category <span class="required">*</span></label>
            <select id="categorySelect" class="form-control">
                <option value="" disabled selected>-- Select Category --</option>
                <option value="Paper" data-rate="0.5">Paper — RM0.50 / KG</option>
                <option value="Plastic" data-rate="0.8">Plastic — RM0.80 / KG</option>
                <option value="Metal" data-rate="3.0">Metal — RM3.00 / KG</option>
                <option value="Glass" data-rate="0.2">Glass — RM0.20 / KG</option>
                <option value="Electronics" data-rate="10">Electronics — RM10 / KG</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>Quantity (KG) <span class="required">*</span></label>
            <input type="number" id="itemQty" class="form-control" min="0" step="0.01" placeholder="0.00">
        </div>
        <div class="col-md-2">
            <label>Subtotal (RM)</label>
            <input type="text" id="itemSubtotal" class="form-control" readonly value="0.00">
        </div>
        <div class="col-md-3">
            <button type="button" id="addItemBtn" class="btn btn-success btn-block">
                <i class="fas fa-plus"></i> Add Item
            </button>
        </div>
    </div>

    <!-- ITEMS TABLE -->
    <div class="mt-4">
        <table class="table table-bordered item-table">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Category</th>
                    <th>Quantity (KG)</th>
                    <th>Subtotal (RM)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="itemsBody"></tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-right">Total Price (RM):</th>
                    <th id="totalPrice">0.00</th>
                    <th></th>
                </tr>
            </tfoot>
            <small><strong><small> Please note: Estimated weight/price may differ from the actual quotation. Please weigh items accurately for an exact quote</strong></small>
        </table>
    </div>

    <!-- Pickup Address -->
    <div class="form-group">
        <label>Pickup Address <span class="required">*</span></label>
        <select id="pickupAddress" class="form-control" required>
            <option value="" disabled selected>-- Select Pickup Address --</option>
        </select>
    </div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="pickupDate"><i class="fas fa-calendar-alt"></i> Pickup Date <span class="required">*</span></label>
            <input type="date" id="pickupDate" class="form-control" required>
            <small class="form-text text-muted">
                Pickup requests can be scheduled starting <strong>2 days from today</strong>. 
                Cancellations must be made at least <strong>2 days before</strong> the scheduled pickup.
            </small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="pickupTime"><i class="fas fa-clock"></i> Pickup Time <span class="required">*</span></label>
            <select id="pickupTime" class="form-control" required>
                <option value="" disabled selected>-- Select Time --</option>
            </select>
            <small class="form-text text-muted"> Select an available time slot for your pickup. Each slot can only be booked once. </small>
        </div>
    </div>
</div>

<div class="form-group mt-2">
    <label>Remark</label>
    <textarea id="remarks" class="form-control" placeholder="Optional"></textarea>
</div>

</div>

<div class="card-footer text-right">
    <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Submit Request</button>
</div>
</form>

</div>
</div>
</section>
</div>

<?php include("../footer/userfooter.php"); ?>
</div>

<!-- Add/Edit Address Modal -->
<div class="modal fade" id="addressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add New Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Address Label (e.g., Home, Office)</label>
                    <input type="text" id="addressLabel" class="form-control" placeholder="Home">
                </div>
                <div class="mb-3">
                    <label>Full Address</label>
                    <textarea id="addressText" class="form-control" rows="3" placeholder="Street, City, Postcode, State"></textarea>
                </div>
                <div class="form-check">
                    <input type="checkbox" id="addressDefault" class="form-check-input">
                    <label class="form-check-label">Set as default pickup address</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="saveAddressBtn">Save Address</button>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Submission Modal -->
<div class="modal fade" id="confirmModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-white bg-success">
        <h5 class="modal-title">Confirm Submission</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to submit this pickup request?</p>
      </div>
      <div class="modal-footer">
        <button id="confirmNo" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button id="confirmYes" class="btn btn-success">Yes</button>
      </div>
    </div>
  </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content border-success">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Success!</h5>
      </div>
      <div class="modal-body">
        Pickup request submitted successfully!
      </div>
    </div>
  </div>
</div>

<script src="../app/plugins/jquery/jquery.min.js"></script>
<script src="../app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../app/dist/js/adminlte.min.js"></script>

<script>
const TIME_SLOTS = ["09:00","10:00","11:00","14:00","15:00","16:00"];
const SLOT_CAPACITY = 2;
let savedAddresses = <?php echo $addresses_json; ?>;
let nextAddrId = Math.max(...savedAddresses.map(a=>a.id),0)+1;
let editingId = null;
let items = [];

// --- PICKUP DATE/TIME ---
let minDate = new Date(); minDate.setDate(minDate.getDate()+2);
document.getElementById("pickupDate").min = minDate.toISOString().split("T")[0];

function getAllBooked(){ return JSON.parse(localStorage.getItem("pickupRequests")||"[]"); }
function updateAvailableTimes(date){
    const booked = getAllBooked().filter(r=>r.date===date);
    let timeSelect = $("#pickupTime"); timeSelect.html('<option value="" disabled selected>-- Select Time --</option>');
    TIME_SLOTS.forEach(t=>{
        let disabled = booked.filter(r=>r.time===t).length>=SLOT_CAPACITY?'disabled':''; 
        timeSelect.append(`<option value="${t}" ${disabled}>${t}</option>`);
    });
}
$("#pickupDate").on("input", function(){ updateAvailableTimes(this.value); });

// --- ITEMS ---
function updateItemSubtotal(){
    let rate = parseFloat($('#categorySelect option:selected').data('rate')||0);
    let qty = parseFloat($('#itemQty').val()||0);
    $('#itemSubtotal').val((rate*qty).toFixed(2));
}
function renderItemsTable(){
    const $body = $('#itemsBody'); $body.empty(); let total=0;
    items.forEach((it,idx)=>{
        total+=parseFloat(it.subtotal);
        $body.append(`<tr><td>${idx+1}</td><td>${it.category}</td><td>${it.quantity}</td><td>${it.subtotal}</td><td><button class="btn btn-sm btn-danger removeItemBtn" data-idx="${idx}"><i class="fas fa-trash"></i></button></td></tr>`);
    });
    $('#totalPrice').text(total.toFixed(2));
}
$('#categorySelect,#itemQty').on('change input', updateItemSubtotal);
$('#addItemBtn').on('click', function(){
    let category=$('#categorySelect').val(), qty=parseFloat($('#itemQty').val()), subtotal=parseFloat($('#itemSubtotal').val());
    if(!category||!qty||qty<=0){ alert('Please select category and quantity'); return; }
    items.push({category,quantity:qty,subtotal});
    renderItemsTable();
    $('#categorySelect').val(''); $('#itemQty').val(''); $('#itemSubtotal').val('0.00');
});
$(document).on('click','.removeItemBtn',function(){ items.splice($(this).data('idx'),1); renderItemsTable(); });

// --- ADDRESSES ---
function renderAddressDropdown(){
    const $sel=$('#pickupAddress'); $sel.empty(); $sel.append('<option value="" disabled selected>-- Select Pickup Address --</option>');
    savedAddresses.forEach(a=>$sel.append(`<option value="${a.id}">${a.label} — ${a.address}</option>`));
    $sel.append('<option value="new">+ Add New Address</option>');
}
$('#pickupAddress').on('change', function(){
    if($(this).val()==='new'){
        editingId=null; $('#modalTitle').text('Add New Address');
        $('#addressLabel').val(''); $('#addressText').val(''); $('#addressDefault').prop('checked',false);
        $('#addressModal').modal('show');
    }
});
$('#saveAddressBtn').on('click', function(){
    const label=$('#addressLabel').val().trim(), address=$('#addressText').val().trim(), isDefault=$('#addressDefault').prop('checked');
    if(!label||!address){ alert('Please fill label & address'); return; }
    if(isDefault) savedAddresses.forEach(a=>a.is_default=false);
    if(editingId){
        let addr=savedAddresses.find(a=>a.id===editingId);
        addr.label=label; addr.address=address; addr.is_default=isDefault;
    } else {
        let newAddr={id:nextAddrId++, label, address, is_default:isDefault};
        savedAddresses.push(newAddr);
    }
    $('#addressModal').modal('hide'); renderAddressDropdown();
    $('#pickupAddress').val(savedAddresses[savedAddresses.length-1].id);
});

// --- FORM SUBMIT ---
$('#pickupForm').on('submit', function(e){
    e.preventDefault();
    if(items.length===0){ alert('Please add at least one item'); return; }
    let addressId=$('#pickupAddress').val(); 
    if(!addressId||addressId==='new'){ alert('Please select address'); return; }

    let addrObj=savedAddresses.find(a=>a.id==addressId);
    window.tempPickupPayload = {
        items,
        address_id: addrObj.id,
        address_label: addrObj.label,
        address: addrObj.address,
        date: $('#pickupDate').val(),
        time: $('#pickupTime').val(),
        remarks: $('#remarks').val(),
        totalPrice: parseFloat($('#totalPrice').text()),
        status: "Pending"
    };

    $('#confirmModal').modal('show');
});

// --- CONFIRM YES ---
$('#confirmYes').on('click', function(){
    const payload = window.tempPickupPayload;
    if(!payload) return;

    $.post('pickup_form.php', {action:'save_request', ...payload}, function(res){
        if(res.ok){
            let allRequests = JSON.parse(localStorage.getItem('pickupRequests')||'[]');
            allRequests.push(payload);
            localStorage.setItem('pickupRequests', JSON.stringify(allRequests));

            $('#confirmModal').modal('hide');

            // Show Success Modal
            $('#successModal').modal('show');
            setTimeout(()=> {
                $('#successModal').modal('hide');
                window.location.href='pickups.php';
            }, 2000);

        } else {
            alert('Error: '+(res.msg||'Could not save request'));
        }
    },'json').fail(function(){ alert('AJAX error'); });
});

// INITIAL
renderAddressDropdown();
</script>

</body>
</html>
