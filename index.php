<?php
// Start session to handle login
session_start();

// Redirect to dashboard if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: views/dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="container bg-white p-4 rounded shadow" style="max-width: 400px;">
        <ul class="nav nav-tabs mb-3" id="auth-tabs">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#login-tab">Login</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#register-tab">Register</button>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Login Form -->
            <div class="tab-pane fade show active" id="login-tab">
                <form method="POST" action="handlers/loginHandler.php">
                    <h2 class="text-center">Login</h2>
                    <div class="mb-3">
                        <label for="login-username" class="form-label">Username:</label>
                        <input type="text" id="login-username" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="login-password" class="form-label">Password:</label>
                        <input type="password" id="login-password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>

            <!-- Register Form -->
            <div class="tab-pane fade" id="register-tab">
                <form method="POST" action="handlers/registerHandler.php">
                    <h2 class="text-center">Register</h2>
                    <div class="mb-3">
                        <label for="register-username" class="form-label">Username:</label>
                        <input type="text" id="register-username" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="register-password" class="form-label">Password:</label>
                        <input type="password" id="register-password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role:</label>
                        <select name="role" id="role" class="form-select">
                            <option value="standard">Standard</option>
                            <option value="premium">Premium</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Register</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>