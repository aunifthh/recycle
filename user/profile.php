<?php
session_start();

if (!isset($_SESSION['user_data'])) {
    $_SESSION['user_data'] = [
        'name' => 'Ain Nazirah',
        'email' => 'naz@gmail.com',
        'phone' => '0123456789',
        'password' => '',
        'addresses' => [
            ['id' => 1, 'label' => 'Home', 'address' => '123 Green Street, Kuala Lumpur', 'is_default' => true],
            ['id' => 2, 'label' => 'Office', 'address' => 'Level 5, Eco Tower, Bangsar', 'is_default' => false]
        ]
    ];
}
$user = &$_SESSION['user_data'];
$currentPage = 'profile';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profile Management</title>
    <link rel="icon" type="image/png" href="../images/truck.png">

    <!-- AdminLTE + Bootstrap Icons -->
    <link rel="stylesheet" href="../app/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../app/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>
        .address-card {
            border-left: 4px solid #007bff;
            padding: 14px;
            border-radius: 6px;
            margin-bottom: 16px;
            background-color: #fafafa;
        }

        .address-card.default {
            border-left-color: #28a745;
            background-color: #f0f9f2;
        }

        .badge-default {
            background-color: #28a745;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include("../navbar/usernavbar.php"); ?>
        <?php include("../sidebar/usersidebar.php"); ?>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <h1>Profile Management</h1>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">

                    <!-- Profile Section -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-user-edit mr-1"></i> Edit Profile</h3>
                                </div>
                                <div class="card-body">
                                    <div class="input-group mb-3">
                                        <input type="text" id="nameInput" class="form-control" placeholder="Full Name" value="<?= htmlspecialchars($user['name']) ?>" required>
                                        <div class="input-group-text"><i class="bi bi-person"></i></div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <input type="email" id="emailInput" class="form-control" placeholder="Email" value="<?= htmlspecialchars($user['email']) ?>" required>
                                        <div class="input-group-text"><i class="bi bi-envelope"></i></div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <input type="tel" id="phoneInput" class="form-control" placeholder="Phone Number" value="<?= htmlspecialchars($user['phone']) ?>" required>
                                        <div class="input-group-text"><i class="bi bi-telephone"></i></div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <input type="password" id="passwordInput" class="form-control" placeholder="New Password (optional)">
                                        <div class="input-group-text">
                                            <i class="bi bi-eye-slash" id="togglePassword" style="cursor:pointer;"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button id="saveProfileBtn" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Save Profile
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Addresses Section -->
                        <div class="col-md-6">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-map-marker-alt mr-1"></i> Saved Addresses</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-4">
                                        <button id="openAddAddressBtn" class="btn btn-success btn-lg w-100">
                                            <i class="fas fa-plus-circle mr-2"></i><strong>Add New Pickup Address</strong>
                                        </button>
                                        <p class="text-muted text-sm mt-2">Save home, office, or other locations for recycling pickups.</p>
                                    </div>

                                    <div id="addressesList">
                                        <!-- Addresses will be rendered by JS -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
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
                            <input type="text" id="addressLabel" class="form-control" placeholder="Home" required>
                        </div>
                        <div class="mb-3">
                            <label>Full Address</label>
                            <textarea id="addressText" class="form-control" rows="3" placeholder="Street, City, Postcode, State" required></textarea>
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

        <?php include("../footer/userfooter.php"); ?>
    </div>

    <!-- Scripts -->
    <script src="../app/plugins/jquery/jquery.min.js"></script>
    <script src="../app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../app/dist/js/adminlte.min.js"></script>

    <script>
        // Profile Management
        document.getElementById('saveProfileBtn').addEventListener('click', function() {
            const name = document.getElementById('nameInput').value.trim();
            const email = document.getElementById('emailInput').value.trim();
            const phone = document.getElementById('phoneInput').value.trim();

            if (!name || !email || !phone) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Information',
                    text: 'Please fill in all required fields.',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            Swal.fire({
                icon: 'success',
                title: 'Profile Updated!',
                text: 'Your profile has been successfully updated.',
                timer: 1500,
                showConfirmButton: false
            });
        });

        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const pwd = document.getElementById('passwordInput');
            const icon = this;
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                pwd.type = 'password';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            }
        });

        // Address Management 
        let addresses = <?php echo json_encode($user['addresses']); ?>;
        let nextId = Math.max(...addresses.map(a => a.id), 0) + 1;
        let editingId = null;

        function renderAddresses() {
            const container = document.getElementById('addressesList');
            if (addresses.length === 0) {
                container.innerHTML = '<div class="text-center text-muted py-3">No saved addresses yet.</div>';
                return;
            }

            container.innerHTML = addresses.map(addr => {
                return `
                <div class="address-card ${addr.is_default ? 'default' : ''}">
                    <div class="d-flex justify-content-between align-items-start">
                        <div style="flex: 1; min-width: 0;">
                            <strong>${escapeHtml(addr.label)}</strong><br>
                            <small class="text-muted">${escapeHtml(addr.address)}</small>
                        </div>
                        <div class="ml-3 text-right" style="white-space: nowrap;">
                            ${addr.is_default ? 
                                '<span class="badge badge-success">Default</span>' : 
                                '<button class="btn btn-sm btn-outline-success mb-1" onclick="setAsDefault(' + addr.id + ')">Set Default</button>'
                            }<br>
                            <button class="btn btn-sm btn-warning mb-1" onclick="editAddress(${addr.id})">Edit</button><br>
                            <button class="btn btn-sm btn-danger" onclick="deleteAddress(${addr.id})">Delete</button>
                        </div>
                    </div>
                </div>
            `;
            }).join('');
        }

        function openAddAddressModal() {
            editingId = null;
            document.getElementById('modalTitle').textContent = 'Add New Address';
            document.getElementById('addressLabel').value = '';
            document.getElementById('addressText').value = '';
            document.getElementById('addressDefault').checked = false;
            $('#addressModal').modal('show');
        }

        function saveAddress() {
            const label = document.getElementById('addressLabel').value.trim();
            const address = document.getElementById('addressText').value.trim();
            const isDefault = document.getElementById('addressDefault').checked;

            if (!label || !address) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Form',
                    text: 'Please fill in both label and address.',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            if (isDefault) {
                addresses.forEach(a => a.is_default = false);
            }

            // Use strict check against null so 0 isn't treated as falsy accidentally
            if (editingId !== null) {
                const addr = addresses.find(a => a.id === editingId);
                if (addr) {
                    addr.label = label;
                    addr.address = address;
                    addr.is_default = isDefault;
                }
            } else {
                addresses.push({
                    id: nextId++,
                    label: label,
                    address: address,
                    is_default: isDefault
                });
            }

            // Reset editing state
            editingId = null;

            renderAddresses();
            $('#addressModal').modal('hide');
            Swal.fire({
                icon: 'success',
                title: editingId !== null ? 'Address Updated!' : 'Address Added!',
                text: editingId !== null ? 'Your address has been updated.' : 'New address has been saved.',
                timer: 1500,
                showConfirmButton: false
            });
        }

        function editAddress(id) {
            const addr = addresses.find(a => a.id === id);
            if (!addr) return;

            editingId = id;
            document.getElementById('modalTitle').textContent = 'Edit Address';
            document.getElementById('addressLabel').value = addr.label;
            document.getElementById('addressText').value = addr.address;
            document.getElementById('addressDefault').checked = addr.is_default;
            $('#addressModal').modal('show');
        }

        function deleteAddress(id) {
            Swal.fire({
                title: 'Delete Address?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    addresses = addresses.filter(a => a.id !== id);
                    renderAddresses();
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Address has been removed.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        }

        function setAsDefault(id) {
            addresses.forEach(a => {
                a.is_default = (a.id === id);
            });
            renderAddresses();
        }

        // small utility to avoid HTML injection when rendering
        function escapeHtml(text) {
            return String(text)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        // Bind buttons
        document.getElementById('openAddAddressBtn').addEventListener('click', openAddAddressModal);
        document.getElementById('saveAddressBtn').addEventListener('click', saveAddress);

        // Initial render
        renderAddresses();
    </script>

</body>

</html>