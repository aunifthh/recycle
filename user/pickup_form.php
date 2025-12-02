<?php $currentPage = 'pickups'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pickup Request / Add Request</title>
    <link rel="icon" type="image/png" href="../images/truck.png">

    <link rel="stylesheet" href="../app/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../app/dist/css/adminlte.min.css">
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

                            <div class="form-group">
                                <label>Recyclable Category</label>
                                <select class="form-control" id="recyclableID" required>
                                    <option value="" disabled selected>-- Select Item --</option>
                                    <option value="Paper" data-rate="0.5">Paper — RM0.50 / KG</option>
                                    <option value="Plastic" data-rate="0.8">Plastic — RM0.80 / KG</option>
                                    <option value="Metal" data-rate="3.0">Aluminum — RM3.00 / KG</option>
                                    <option value="Glass" data-rate="0.2">Glass — RM0.20 / KG</option>
                                    <option value="Electronics" data-rate="10">Electronics — RM10 / KG</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Quantity Type</label>
                                <select class="form-control" id="quantityType" required>
                                    <option value="" disabled selected>-- Select Type --</option>
                                    <option value="kg">KG</option>
                                    <option value="unit">Unit</option>
                                    <option value="bundle">Bundle</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Estimated Quantity</label>
                                <input type="number" id="quantityEstimate" class="form-control" placeholder="Enter estimated quantity" required>
                            </div>

                            <!-- Total Price Display -->
                            <div class="form-group">
                                <label>Total Estimated Price (RM)</label>
                                <input type="text" id="totalPrice" class="form-control" readonly value="0.00">
                            </div>

                            <div class="form-group">
                            <label>Pickup Location</label>
                            <textarea id="pickupAddress" class="form-control" rows="2" placeholder="Enter your full pickup address here" required></textarea>
                        </div>

                            <div class="form-group">
                                <label>Pickup Date</label>
                                <input type="date" id="pickupDate" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Pickup Time</label>
                                <input type="time" id="pickupTime" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Remarks (Optional)</label>
                                <textarea id="remarks" class="form-control" rows="2"></textarea>
                            </div>

                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-paper-plane"></i> Submit Request
                            </button>
                        </div>

                    </form>

                </div>

            </div>
        </section>

    </div>

    <?php include("../footer/userfooter.php"); ?>
</div>

<script src="../app/plugins/jquery/jquery.min.js"></script>
<script src="../app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../app/dist/js/adminlte.min.js"></script>

<script>
// Show manual address field
$("#pickupAddress").on("change", function () {
    if ($(this).val() === "other") {
        $("#manualAddressContainer").removeClass("d-none");
    } else {
        $("#manualAddressContainer").addClass("d-none");
    }
});

// Calculate total price
function calculateTotal() {
    let selectedOption = $("#recyclableID option:selected");
    let rate = parseFloat(selectedOption.data("rate")) || 0;
    let qty = parseFloat($("#quantityEstimate").val()) || 0;
    let total = rate * qty;
    $("#totalPrice").val(total.toFixed(2));
}

// Trigger calculation on category or quantity change
$("#recyclableID, #quantityEstimate").on("input change", calculateTotal);

// Handle form submit
$("#pickupForm").on("submit", function(e){
    e.preventDefault();

    let request = {
        category: $("#recyclableID").val(),
        quantityType: $("#quantityType").val(),
        quantityEstimate: $("#quantityEstimate").val(),
        totalPrice: $("#totalPrice").val(),
        address: $("#pickupAddress").val() === "other" ? $("#manualAddress").val() : $("#pickupAddress").val(),
        date: $("#pickupDate").val(),
        time: $("#pickupTime").val(),
        remarks: $("#remarks").val()
    };

    // Save to localStorage
    let requests = JSON.parse(localStorage.getItem("pickupRequests") || "[]");
    requests.push(request);
    localStorage.setItem("pickupRequests", JSON.stringify(requests));

    // Redirect back to pickups.php
    window.location.href = "pickups.php";
});
</script>
</body>
</html>
