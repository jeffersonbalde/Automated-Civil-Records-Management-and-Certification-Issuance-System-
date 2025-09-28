<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birth Records - Civil Registration System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="icon" type="image/png" href="../../assets/img/pagadian-logo.png" />
    <link rel="stylesheet" href="../../assets/css/birth.css">
    <link rel="stylesheet" href="../../assets/css/birth-modal.css">
    <link href="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.css" rel="stylesheet">
</head>

<body>
    <div class="birth-container">
        <!-- Sidebar -->
        <?php include '../../includes/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="birth-card animate__animated animate__fadeIn">
                <!-- Header -->
                <div class="birth-header d-flex justify-content-between align-items-center flex-wrap">
                    <div class="header-title">
                        <h2>Birth Records Management</h2>
                        <p>Manage and track birth certificate records</p>
                    </div>
                    <div class="header-actions">
                        <div class="search-box">
                            <input type="text" placeholder="Search by name or registration number..." id="recordSearch">
                            <i class="fas fa-search"></i>
                        </div>
                        <button class="action-btn" data-bs-toggle="modal" data-bs-target="#addBirthModal">
                            <i class="fas fa-plus"></i>
                            <span>New Record</span>
                        </button>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Total Records</h3>
                        <p class="stat-number" data-value="1234">1,234</p>
                        <div class="text-danger">
                            <i class="fas fa-arrow-up"></i> 12.5%
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3>This Month</h3>
                        <p class="stat-number" data-value="56">56</p>
                        <div class="text-danger">
                            <i class="fas fa-arrow-down"></i> 5.0%
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3>Pending Review</h3>
                        <p class="stat-number" data-value="12">12</p>
                        <div class="text-danger">
                            <i class="fas fa-exclamation-triangle"></i> Needs Attention
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3>Certificates Issued</h3>
                        <p class="stat-number" data-value="890">890</p>
                        <div class="text-danger">
                            <i class="fas fa-file-certificate"></i> This Year
                        </div>
                    </div>
                </div>  

                <!-- Filter Section -->
                <div class="filter-section">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Registration Year</label>
                            <select class="form-select" id="yearFilter">
                                <option value="">All Years</option>
                                <option value="2023">2023</option>
                                <option value="2022">2022</option>
                                <option value="2021">2021</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="registered">Registered</option>
                                <option value="pending">Pending</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Sort By</label>
                            <select class="form-select" id="sortFilter">
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="name">Name (A-Z)</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button class="btn btn-secondary w-100" onclick="resetFilters()">
                                <i class="fas fa-redo"></i> Reset Filters
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-container">
                    <table class="table table-custom table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Registration No.</th>
                                <th>Full Name</th>
                                <th>Date of Birth</th>
                                <th>Place of Birth</th>
                                <th>Parents</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="recordsTable">
                            <!-- Records will be populated here -->
                            <tr>
                                <td>1</td>
                                <td>2023-B-001</td>
                                <td>John Michael Doe</td>
                                <td>2023-01-15</td>
                                <td>Pagadian City Medical Center</td>
                                <td>James & Mary Doe</td>
                                <td><span class="badge bg-success">Registered</span></td>
                                <td>
                                    <button class="btn-action btn-view" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action btn-certificate" title="Generate Certificate">
                                        <i class="fas fa-file-certificate"></i>
                                    </button>
                                    <button class="btn-action btn-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action btn-delete" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>2023-B-002</td>
                                <td>Maria Santos Cruz</td>
                                <td>2023-02-20</td>
                                <td>Zamboanga del Sur Medical Center</td>
                                <td>Juan & Elena Cruz</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                                <td>
                                    <button class="btn-action btn-view" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action btn-certificate" title="Generate Certificate" disabled>
                                        <i class="fas fa-file-certificate"></i>
                                    </button>
                                    <button class="btn-action btn-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action btn-delete" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-section">
                    <div class="pagination-controls">
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-semibold">Rows per page:</span>
                            <select class="form-select form-select-sm" style="width: auto;" id="rowsPerPage">
                                <option>5</option>
                                <option selected>10</option>
                                <option>20</option>
                                <option>50</option>
                            </select>
                        </div>
                        
                        <div class="page-info">
                            Showing 1-10 of 1,234 records
                        </div>
                        
                        <div class="pagination-buttons">
                            <button class="page-btn disabled" title="First Page">
                                <i class="fas fa-angle-double-left"></i>
                            </button>
                            <button class="page-btn disabled" title="Previous">
                                <i class="fas fa-angle-left"></i>
                            </button>
                            
                            <button class="page-btn active">1</button>
                            <button class="page-btn">2</button>
                            <button class="page-btn">3</button>
                            <span>...</span>
                            <button class="page-btn">124</button>
                            
                            <button class="page-btn" title="Next">
                                <i class="fas fa-angle-right"></i>
                            </button>
                            <button class="page-btn" title="Last Page">
                                <i class="fas fa-angle-double-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Include the Birth Modal Component -->
    <?php include '../../components/birth-modal.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/birth.js"></script>
    <script src="../../assets/js/birth-modal.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.js"></script>
</body>
</html>