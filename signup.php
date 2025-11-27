<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up - Community Recycling Collection System</title>
    <link rel="icon" type="image/png" href="images/truck.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Icons + Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body.signup-page {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .signup-box {
            width: 420px;
        }

        .signup-logo {
            text-align: center;
            margin-bottom: 1.2rem;
        }

        .signup-logo a {
            font-size: 24px;
            font-weight: 600;
            color: #28a745;
            text-decoration: none;
        }

        .card-wider {
            border-radius: 10px !important;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.11);
        }

        .signup-card-body {
            padding: 20px;
        }

        .recycle-icon {
            font-size: 4rem;
            color: #28a745;
            display: block;
            text-align: center;
            margin-bottom: 1rem;
        }

        button[type="submit"] {
            background: #28a745;
            border: none;
            color: white;
            transition: 0.3s;
        }

        button[type="submit"]:hover {
            opacity: 0.9;
        }

        .input-group-text {
            background: #fff;
            border-left: none;
        }

        .input-group .form-control {
            border-right: none;
        }
    </style>
</head>

<body class="signup-page">

    <div class="signup-box">
        <div class="signup-logo">
            <a>Create Your Account</a>
        </div>

        <div class="card card-wider">
            <div class="card-body signup-card-body">

                <i class="bi bi-recycle recycle-icon"></i>
                <p class="text-center text-muted mb-3">Join our recycling community</p>

                <form>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Full Name" required>
                        <div class="input-group-text">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" required>
                        <div class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" id="password" required>
                        <div class="input-group-text">
                            <i class="bi bi-eye-slash" id="togglePassword" style="cursor:pointer;"></i>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="tel" class="form-control" placeholder="Phone Number" required>
                        <div class="input-group-text">
                            <i class="bi bi-telephone"></i>
                        </div>
                    </div>

                    <div class="input-group mb-4">
                        <input type="text" class="form-control" placeholder="Home Address" required>
                        <div class="input-group-text">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn rounded-pill px-4 py-2">Sign Up</button>
                    </div>

                </form>

                <div class="text-center mt-3">
                    <p>Already have an account? <a href="index.php">Login</a></p>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Password toggle
        document.getElementById("togglePassword").onclick = function () {
            const pw = document.getElementById("password");
            pw.type = pw.type === "password" ? "text" : "password";
            this.classList.toggle("bi-eye");
            this.classList.toggle("bi-eye-slash");
        };
    </script>

</body>

</html>
