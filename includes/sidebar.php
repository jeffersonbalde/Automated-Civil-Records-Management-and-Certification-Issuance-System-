<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar - Civil Registration System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="icon" type="image/png" href="../../assets/img/pagadian-logo.png" />

</head>

<div class="dashboard-container">

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <img src="../../assets/img/pagadian-logo.png" alt="Pagadian Logo">
                <div class="sidebar-logo-text">Civil Registry</div>
            </div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="../../modules/dashboard/dashboard.php"
                    class="nav-link <?php echo (strpos($_SERVER['PHP_SELF'], 'dashboard.php') !== false) ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="../../modules/birth/birth.php"
                    class="nav-link <?php echo (strpos($_SERVER['PHP_SELF'], 'birth.php') !== false) ? 'active' : ''; ?>">
                    <i class="fas fa-file-alt"></i>
                    <span>Birth Certificates</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="../../modules/marriage/marriage.php"
                    class="nav-link <?php echo (strpos($_SERVER['PHP_SELF'], 'marriage.php') !== false) ? 'active' : ''; ?>">
                    <i class="fas fa-heart"></i>
                    <span>Marriage Certificates</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="../../modules/death/death.php"
                    class="nav-link <?php echo (strpos($_SERVER['PHP_SELF'], 'death.php') !== false) ? 'active' : ''; ?>">
                    <i class="fas fa-cross"></i>
                    <span>Death Certificates</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="../../modules/users/users.php"
                    class="nav-link <?php echo (strpos($_SERVER['PHP_SELF'], 'users.php') !== false) ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </div>
        </nav>
    </aside>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    </body>

</html>