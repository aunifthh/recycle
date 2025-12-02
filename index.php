<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Community Recycling Collection System - Login</title>
    <link rel="icon" type="image/png" href="images/truck.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Icons + Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body.login-page {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-box {
            width: 360px;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .login-logo a {
            font-size: 24px;
            font-weight: 600;
            color: #28a745;
            text-decoration: none;
        }

        .card-wider {
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.11);
        }

        .login-card-body {
            padding: 20px;
        }

        .recycle-icon,
        .shield-icon {
            font-size: 4rem;
            display: block;
            text-align: center;
            margin-bottom: 1rem;
        }

        .recycle-icon {
            color: #28a745;
        }

        .shield-icon {
            color: #0d6efd;
        }

        button[type="submit"] {
            border: none;
            transition: 0.3s;
        }

        button.user-btn {
            background: #28a745;
            color: white;
        }


        button.admin-btn {
            background: #0d6efd;
            color: white;
        }
    </style>
</head>

<body class="login-page">

    <div class="login-box">
        <div class="login-logo">
            <a>Community Recycling Collection System</a>
        </div>

        <div class="card card-wider">
            <div class="card-body login-card-body">

                <div class="accordion" id="loginAccordion">

                    <!-- USER LOGIN -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="userHeading">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#userLogin" aria-expanded="true" aria-controls="userLogin">
                                User Login
                            </button>
                        </h2>

                        <div id="userLogin" class="accordion-collapse collapse show" aria-labelledby="userHeading"
                            data-bs-parent="#loginAccordion">
                            <div class="accordion-body">

                                <i class="bi bi-recycle recycle-icon"></i>
                                <p class="text-center text-muted mb-3">Login to continue</p>

                                <form onsubmit="userLogin(event)">
                                    <div class="input-group mb-3">
                                        <input type="email" class="form-control" id="userEmail" placeholder="Email" required>
                                        <div class="input-group-text">
                                            <i class="bi bi-envelope"></i>
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control" placeholder="Password" id="userPass" required>
                                        <div class="input-group-text">
                                            <i class="bi bi-eye-slash" id="toggleUserPass" style="cursor:pointer;"></i>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn user-btn rounded-pill px-4 py-2">Login</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <!-- ADMIN LOGIN -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="adminHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#adminLogin" aria-expanded="false" aria-controls="adminLogin">
                                Staff Login
                            </button>
                        </h2>

                        <div id="adminLogin" class="accordion-collapse collapse" aria-labelledby="adminHeading"
                            data-bs-parent="#loginAccordion">
                            <div class="accordion-body">

                                <i class="bi bi-shield-lock shield-icon"></i>
                                <p class="text-center text-muted mb-3">Staff Access</p>

                                <form onsubmit="adminLogin(event)">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="adminUser" placeholder="Staff Username" required>
                                        <div class="input-group-text">
                                            <i class="bi bi-person-lock"></i>
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control" placeholder="Password" id="adminPass" required>
                                        <div class="input-group-text">
                                            <i class="bi bi-eye-slash" id="toggleAdminPass" style="cursor:pointer;"></i>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn admin-btn rounded-pill px-4 py-2">Login</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div> <!-- End accordion -->

                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // USER LOGIN
        function userLogin(event) {
            event.preventDefault();

            let email = document.getElementById("userEmail").value;
            let pass = document.getElementById("userPass").value;

            if (email === "user@gmail.com" && pass === "user123") {
                window.location.href = "user/dashboard.php";
            } else {
                alert("Incorrect user email or password.");
            }
        }

        // ADMIN LOGIN
        function adminLogin(event) {
            event.preventDefault();

            let username = document.getElementById("adminUser").value;
            let pass = document.getElementById("adminPass").value;

            if (username === "admin" && pass === "admin123") {
                window.location.href = "admin/dashboard.php";
            } else if (username === "staff" && pass === "staff123") {
                window.location.href = "staff/dashboard.php";
            } else {
                alert("Incorrect admin username or password.");
            }
        }

        // Toggle password (User)
        document.getElementById("toggleUserPass").onclick = function () {
            const pw = document.getElementById("userPass");
            pw.type = pw.type === "password" ? "text" : "password";
            this.classList.toggle("bi-eye");
            this.classList.toggle("bi-eye-slash");
        };

        // Toggle password (Admin)
        document.getElementById("toggleAdminPass").onclick = function () {
            const pw = document.getElementById("adminPass");
            pw.type = pw.type === "password" ? "text" : "password";
            this.classList.toggle("bi-eye");
            this.classList.toggle("bi-eye-slash");
        };
    </script>

</body>

</html>
