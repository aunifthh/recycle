<?php
session_start();
$currentPage = 'pickups';
$user = [
    'name'=>'Ali Rahman',
    'email'=>'ali@example.com',
    'phone'=>'0123456789',
    'addresses'=>[
        ['id'=>1,'label'=>'Home','address'=>'123 Green Street, Kuala Lumpur','is_default'=>true],
        ['id'=>2,'label'=>'Office','address'=>'Level 5, Eco Tower, Bangsar','is_default'=>false]
    ]
];
$addresses_json = json_encode($user['addresses']);
?>
<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
                <title>Create Pickup Request | Greencycle</title>
                <link rel="icon" href="../images/truck.png">
                <link rel="stylesheet" href="../app/plugins/fontawesome-free/css/all.min.css">
                <link rel="stylesheet" href="../app/dist/css/adminlte.min.css">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <style>
                .required { color:red; }
                .item-table th, .item-table td { vertical-align: middle; }
                #pickupDate[readonly] { background-color:#fff !important; cursor:pointer; }
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
                            <a href="pickups.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
                            </div>
                        </section>

                        <section class="content">
                            <div class="container-fluid">
                            <div class="card shadow-lg">
                            <div class="card-header bg-success text-white">
                            <h4 class="card-title mb-0"><i class="fas fa-recycle"></i> Create Pickup Request</h4>
                            </div>

                        <!-- FORM -->
                            <form id="pickupForm" method="post" action="pickups.php">
                            <div class="card-body">

                        <!-- ADD ITEM -->
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
                                <th>#</th><th>Category</th><th>Quantity (KG)</th><th>Subtotal (RM)</th><th>Action</th>
                                </tr>
                                </thead>
                                  <tbody id="itemsBody"></tbody>
                                <tfoot>
                                    <tr>
                                    <th colspan="3" class="text-right">Total Price (RM):</th>
                                    <th id="totalPrice">0.00</th><th></th>
                                    </tr>
                                </tfoot>
                            <small><strong>Please note: Estimated weight/price may differ from actual quotation. Weigh accurately for exact quote.</strong></small>
                            </table>
                        </div>

                        <!-- PICKUP ADDRESS -->
                        <div class="form-group">
                             <label>Pickup Address <span class="required">*</span></label>
                              <select id="pickupAddress" class="form-control" name="pickupAddress" required>
                                 <option value="" disabled selected>-- Select Pickup Address --</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="pickupDate"><i class="fas fa-calendar-alt"></i> Pickup Date <span class="required">*</span></label>
                                <input type="text" id="pickupDate" class="form-control" placeholder="Select pickup date" readonly required name="pickupDate">
                                    <small class="form-text text-muted">
                                    Pickup requests start <strong>2 days from today</strong>. Monday – Friday only. Cancellation ≥ 2 days before pickup.
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pickupTime"><i class="fas fa-clock"></i> Pickup Time <span class="required">*</span></label>
                                    <select id="pickupTime" class="form-control" required name="pickupTime">
                                        <option value="" disabled selected>-- Select Time --</option>
                                    </select>
                                    <small class="form-text text-muted">Each time slot can be booked only once.</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <label>Remark</label>
                            <textarea id="remarks" class="form-control" placeholder="Optional" name="remarks"></textarea>
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

                        <script src="../app/plugins/jquery/jquery.min.js"></script>
                        <script src="../app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                        <script>
                        // ================= CONFIG =================
                        const TIME_SLOTS = ["09:00","11:00","13:00","15:00","17:00"];
                        const SLOT_CAPACITY = 2;
                        let savedAddresses = <?php echo $addresses_json; ?>;
                        let nextAddrId = Math.max(...savedAddresses.map(a => a.id),0)+1;
                        let items = [];

                        // DATE PICKER
                        const today = new Date(); today.setHours(0,0,0,0);
                        const minDate = new Date(today); minDate.setDate(today.getDate()+2);
                        const maxDate = new Date(today); maxDate.setFullYear(today.getFullYear()+1);

                        flatpickr("#pickupDate", {
                            minDate:minDate, maxDate:maxDate, dateFormat:"Y-m-d",
                            disable:[d => d.getDay()===0||d.getDay()===6]
                        });

                        // ITEMS LOGIC
                        function updateItemSubtotal(){
                            let rate=parseFloat($('#categorySelect option:selected').data('rate')||0);
                            let qty=parseFloat($('#itemQty').val()||0);
                            $('#itemSubtotal').val((rate*qty).toFixed(2));
                        }
                        function renderItemsTable(){
                            const $body=$('#itemsBody'); $body.empty(); let total=0;
                            items.forEach((it,idx)=>{
                                total+=parseFloat(it.subtotal);
                                $body.append(`<tr>
                                    <td>${idx+1}</td>
                                    <td>${it.category}</td>
                                    <td>${it.quantity}</td>
                                    <td>${it.subtotal}</td>
                                    <td><button class="btn btn-sm btn-danger removeItemBtn" data-idx="${idx}"><i class="fas fa-trash"></i></button></td>
                                </tr>`);
                            });
                            $('#totalPrice').text(total.toFixed(2));
                        }
                        $('#categorySelect,#itemQty').on('change input',updateItemSubtotal);
                        $('#addItemBtn').on('click',()=>{
                            let category=$('#categorySelect').val(), qty=parseFloat($('#itemQty').val()), subtotal=parseFloat($('#itemSubtotal').val());
                            if(!category||!qty||qty<=0){ alert('Please select category and quantity'); return; }
                            items.push({category,quantity:qty,subtotal});
                            renderItemsTable();
                            $('#categorySelect').val(''); $('#itemQty').val(''); $('#itemSubtotal').val('0.00');
                        });
                        $(document).on('click','.removeItemBtn',function(){ items.splice($(this).data('idx'),1); renderItemsTable(); });

                        // ADDRESSES
                        function renderAddressDropdown(){
                            const $sel=$("#pickupAddress"); $sel.empty();
                            $sel.append('<option value="" disabled selected>-- Select Pickup Address --</option>');
                            savedAddresses.forEach(a=>$sel.append(`<option value="${a.id}">${a.label} — ${a.address}</option>`));
                        }
                        renderAddressDropdown();

                        // TIME SLOTS UPDATE
                        $('#pickupDate').on('change', function(){
                            const date = $(this).val();
                            const booked = JSON.parse(localStorage.getItem("pickupRequests")||"[]").filter(r=>r.date===date);
                            const $sel = $('#pickupTime'); $sel.empty();
                            $sel.append('<option value="" disabled selected>-- Select Time --</option>');
                            TIME_SLOTS.forEach(t=>{
                                const count = booked.filter(r=>r.time===t).length;
                                $sel.append(`<option value="${t}" ${count>=SLOT_CAPACITY?"disabled":""}>${t}</option>`);
                            });
                        });

                        // FORM SUBMIT
                        $('#pickupForm').on('submit', function(e){
                            if(items.length === 0){ Swal.fire('No Items','Add at least one item','warning'); e.preventDefault(); return; }
                            let addrId = $('#pickupAddress').val();
                            if(!addrId){ Swal.fire('Address Required','Select a pickup address','warning'); e.preventDefault(); return; }
                            const addr = savedAddresses.find(a => a.id == addrId);
                            const payload = {
                                items,
                                address_id: addr.id,
                                address_label: addr.label,
                                address: addr.address,
                                date: $('#pickupDate').val(),
                                time: $('#pickupTime').val(),
                                remarks: $('#remarks').val(),
                                totalPrice: parseFloat($('#totalPrice').text()),
                                status: "Pending"
                            };
                            // Save payload in hidden input
                            $('#pickupForm input[name="pickupData"]').remove();
                            $('<input>').attr('type','hidden').attr('name','pickupData').val(JSON.stringify(payload)).appendTo('#pickupForm');
                        });
                    </script>
        </body>
    </html>
