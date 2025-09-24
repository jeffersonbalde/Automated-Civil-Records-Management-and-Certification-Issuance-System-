<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birth Certs - Civil Registration System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/birth.css">
    <link rel="icon" type="image/png" href="../../assets/img/pagadian-logo.png" />

</head>

<body>
    <div class="birth-container">
        <!-- Sidebar -->
        <?php include '../../includes/sidebar.php'; ?>

        <!-- Top Navigation -->
        <?php include '../../includes/header.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="birth-card">
                <div class="birth-header">
                    <div>
                        <h2 class="mb-1">Birth Certificates Management</h2>
                        <p class="text-muted">Manage and track birth certificate records</p>
                    </div>
                    <div class="header-actions d-flex align-items-center gap-3">
                        <div class="search-box">
                            <input type="text" placeholder="Search records...">
                            <i class="fas fa-search"></i>
                        </div>
                        <button class="action-btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
                            data-bs-target="#addBirthModal">
                            <i class="fas fa-plus"></i>
                            <span>New Record</span>
                        </button>
                    </div>
                </div>

                <div class="birth-grid mb-4">
                    <div class="stat-card">
                        <h3 class="text-muted mb-3">Total Records</h3>
                        <p class="stat-number mb-0">1,234</p>
                        <div class="mt-2 text-success">
                            <i class="fas fa-arrow-up"></i> 12.5%
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3 class="text-muted mb-3">This Month</h3>
                        <p class="stat-number mb-0">56</p>
                        <div class="mt-2 text-danger">
                            <i class="fas fa-arrow-down"></i> 5.0%
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3 class="text-muted mb-3">Pending</h3>
                        <p class="stat-number mb-0">12</p>
                        <div class="mt-2 text-warning">
                            <i class="fas fa-exclamation-triangle"></i> Review
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>Registration No.</th>
                                <th>Full Name</th>
                                <th>Date of Birth</th>
                                <th>Place of Birth</th>
                                <th>Parents</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Sample row -->
                            <tr>
                                <td>2023-001</td>
                                <td>John Doe</td>
                                <td>2023-01-01</td>
                                <td>City Hospital</td>
                                <td>James & Mary Doe</td>
                                <td><span class="badge bg-success">Registered</span></td>
                                <td>
                                    <button class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Birth Certificate Modal -->
    <div class="modal fade" id="addBirthModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Add New Birth Certificate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="birthCertForm" class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="firstName" placeholder="First Name">
                                <label for="firstName">First Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="lastName" placeholder="Last Name">
                                <label for="lastName">Last Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="dateOfBirth">
                                <label for="dateOfBirth">Date of Birth</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="placeOfBirth" placeholder="Place of Birth">
                                <label for="placeOfBirth">Place of Birth</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" id="address" placeholder="Address"
                                    style="height: 100px"></textarea>
                                <label for="address">Complete Address</label>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2">Save Recoxrd</button>
                            <button type="button" class="btn btn-light px-4 py-2" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>