<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Civil Registration System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/png" href="assets/img/pagadian-logo.png" />

</head>

<body>
    <!-- Loader Overlay -->
    <div class="loader-overlay">
        <div class="loader"></div>
    </div>

    <!-- Custom Alert -->
    <div class="custom-alert">
        <div class="alert-icon">
            <i class="fas"></i>
        </div>
        <div class="alert-content">
            <div class="alert-title"></div>
            <div class="alert-message"></div>
        </div>
    </div>

    <div class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4 col-sm-10">
                    <div class="login-form">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>

                        <div class="logo-container">
                            <img src="assets/img/pagadian-logo.png" alt="Pagadian Logo" class="img-fluid">
                            <h1 class="welcome-title">Welcome Back!</h1>
                            <p class="welcome-subtitle">Civil Registration Information System</p>
                        </div>

                        <form method="post" action="handlers/login.php">
                            <div class="form-group mb-3">
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" name="username" placeholder="Username"
                                        required oninvalid="this.setCustomValidity('This field is required')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" name="password" placeholder="Password"
                                        required oninvalid="this.setCustomValidity('This field is required')"
                                        oninput="this.setCustomValidity('')">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword"
                                        aria-label="Toggle password visibility">
                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- <div class="form-footer mb-3 d-flex justify-content-between align-items-center">
                                <div class="form-check mb-0">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                                <a href="#" class="forgot-password" aria-label="Reset Password">
                                    <i class="fas fa-key fa-sm"></i>
                                    <span>Forgot Password?</span>
                                </a>
                            </div> -->

                            <button type="submit" class="btn btn-login w-100 mt-2">
                                Sign In <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </form>

                        <div class="text-center">
                            <p class="help-text">
                                Having trouble? <a href="#" class="contact-support">Contact Support <i
                                        class="fas fa-headset ms-1"></i></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS and other scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show custom alert with optional callback
        function showAlert(type, title, message, callback = null) {
            const alert = document.querySelector('.custom-alert');
            const icon = alert.querySelector('.alert-icon i');

            alert.className = 'custom-alert ' + type;
            alert.querySelector('.alert-icon').className = 'alert-icon ' + type;
            alert.querySelector('.alert-title').textContent = title;
            alert.querySelector('.alert-message').textContent = message;

            icon.className = type === 'success' ? 'fas fa-check' : 'fas fa-times';

            alert.classList.add('show');

            if (callback) {
                setTimeout(callback, 1000);
            }
            setTimeout(() => alert.classList.remove('show'), 2500);
        }

        // Show/hide loader
        function toggleLoader(show) {
            document.querySelector('.loader-overlay').style.display = show ? 'flex' : 'none';
        }

        // Form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            toggleLoader(true);

            fetch('handlers/login.php', {
                    method: 'POST',
                    body: new FormData(this)
                })
                .then(response => response.json())
                .then(data => {
                    toggleLoader(false);
                    if (data.status === 'success') {
                        showAlert('success', 'Welcome!', data.message, () => {
                            window.location.href = 'modules/dashboard/dashboard.php';
                        });
                    } else {
                        showAlert('error', 'Error!', data.message);
                    }
                })
                .catch(error => {
                    toggleLoader(false);
                    showAlert('error', 'Error!', 'An unexpected error occurred');
                });
        });

        // Password toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.querySelector('input[name="password"]');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>

</html>