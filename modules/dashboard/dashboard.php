<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Civil Registration System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Add ApexCharts -->
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="icon" type="image/png" href="../../assets/img/pagadian-logo.png" />

</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php include '../../includes/sidebar.php'; ?>

        <!-- Top Navigation -->
        <?php include '../../includes/header.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="dashboard-wrapper">
                <!-- Stats Cards Row -->
                <div class="row stats-row">
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-icon birth">
                                <i class="fas fa-baby"></i>
                            </div>
                            <div class="stats-info">
                                <h3>Birth Certificates</h3>
                                <h2>2,345</h2>
                                <p><span class="text-success"><i class="fas fa-arrow-up"></i> 12%</span> vs last month</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-icon marriage">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="stats-info">
                                <h3>Marriage Certificates</h3>
                                <h2>856</h2>
                                <p><span class="text-success"><i class="fas fa-arrow-up"></i> 5%</span> vs last month</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-icon death">
                                <i class="fas fa-cross"></i>
                            </div>
                            <div class="stats-info">
                                <h3>Death Certificates</h3>
                                <h2>432</h2>
                                <p><span class="text-danger"><i class="fas fa-arrow-down"></i> 3%</span> vs last month</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-icon requests">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <div class="stats-info">
                                <h3>Pending Requests</h3>
                                <h2>145</h2>
                                <p><span class="text-warning"><i class="fas fa-minus"></i> No change</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row charts-row">
                    <div class="col-md-8">
                        <div class="chart-card">
                            <div class="chart-header">
                                <h3>Registration Trends</h3>
                                <div class="chart-actions">
                                    <select class="form-select form-select-sm">
                                        <option>Last 7 Days</option>
                                        <option>Last 30 Days</option>
                                        <option>Last 3 Months</option>
                                    </select>
                                </div>
                            </div>
                            <div id="trendsChart"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="chart-card">
                            <div class="chart-header">
                                <h3>Certificate Distribution</h3>
                            </div>
                            <div id="distributionChart"></div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="activity-card">
                            <div class="activity-header">
                                <h3>Recent Activities</h3>
                                <a href="#" class="btn btn-sm btn-primary">View All</a>
                            </div>
                            <div class="activity-list">
                                <div class="activity-item">
                                    <div class="activity-icon birth">
                                        <i class="fas fa-baby"></i>
                                    </div>
                                    <div class="activity-details">
                                        <h4>New Birth Certificate Request</h4>
                                        <p>Requested by John Doe</p>
                                        <span class="activity-time">2 minutes ago</span>
                                    </div>
                                    <div class="activity-status pending">
                                        Pending
                                    </div>
                                </div>
                                <!-- Add more activity items -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/dashboard.js"></script>
</body>

</html>