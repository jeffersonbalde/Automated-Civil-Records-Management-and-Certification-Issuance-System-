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
    <!-- <link rel="stylesheet" href="/css/birth.css">
    <link rel="stylesheet" href="/css/birth-modal.css"> -->
    <!-- <link rel="stylesheet" href="../../assets/css/birth.css"> -->
    <!-- <link rel="stylesheet" href="../../assets/css/birth-modal.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.css" rel="stylesheet">
    <style>
        :root {
    --primary: #FF9800;
    --primary-light: #FFE0B2;
    --primary-dark: #F57C00;
    --secondary: #607D8B;
    --light-bg: #FAFAFA;
    --card-bg: #FFFFFF;
    --text: #424242;
    --light-text: #757575;
    --border: #E0E0E0;
    --success: #4CAF50;
    --warning: #FFC107;
    --danger: #F44336;
    --info: #2196F3;
}

body {
    background-color: var(--light-bg);
    font-family: 'Segoe UI', system-ui, sans-serif;
    overflow-x: hidden;
    color: var(--text);
}

.birth-container {
    min-height: 100vh;
    display: flex;
}

.main-content {
    flex: 1;
    overflow-x: hidden;
    overflow-y: auto;
    height: 100vh;
    min-width: 0;
}

.birth-card {
    background-color: #f5f5f5;
    border: 1px solid var(--border);
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    margin: 20px;
}

.birth-header {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    padding: 24px;
    border-bottom: 1px solid var(--border);
}

.header-title h2 {
    color: white;
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 4px;
}

.header-title p {
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 16px;
    align-items: center;
    flex-wrap: wrap;
}

.search-box {
    position: relative;
    min-width: 250px;
}

.search-box input {
    width: 100%;
    padding: 10px 40px 10px 16px;
    border: 1px solid var(--border);
    border-radius: 8px;
    background: white;
    font-size: 14px;
    transition: all 0.3s;
}

.search-box input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.1);
}

.search-box i {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--light-text);
}

.action-btn {
    background: var(--primary);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.action-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(255, 152, 0, 0.3);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px;
}

.stat-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    transition: all 0.3s;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    position: relative;
    overflow: hidden;
    opacity: 0;
    transform: translateY(30px);
}

.stat-card.animated {
    opacity: 1;
    transform: translateY(0);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
}

.stat-card:nth-child(1)::before { background: var(--primary); }
.stat-card:nth-child(2)::before { background: var(--primary); }
.stat-card:nth-child(3)::before { background: var(--primary); }
.stat-card:nth-child(4)::before { background: var(--primary); } 

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.stat-card h3 {
    color: var(--text);
    font-size: 1rem;
    margin-bottom: 12px;
    opacity: 0.8;
    font-weight: bold;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 8px;
    font-variant-numeric: tabular-nums;
    transition: color 0.3s ease;
}

.stat-card:nth-child(1) .stat-number { color: var(--primary); }
.stat-card:nth-child(2) .stat-number { color: var(--primary); }
.stat-card:nth-child(3) .stat-number { color: var(--primary); }
.stat-card:nth-child(4) .stat-number { color: var(--primary); }

.filter-section {
    background: white;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 20px;
    margin: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.table-container {
    border: 1px solid var(--border);
    border-radius: 10px;
    overflow: hidden;
    margin: 20px;
    overflow-x: auto;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.table-custom {
    margin: 0;
    min-width: 900px;
    width: 100%;
}

.table-custom thead {
    background: var(--primary-light);
}

.table-custom th {
    color: var(--text);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    text-align: center;
    padding: 16px;
    white-space: nowrap;
    border-bottom: 2px solid var(--primary);
    background-color: #E8ECEF;
}

.table-custom td {
    padding: 16px;
    vertical-align: middle;
    text-align: center;
    white-space: nowrap;
    border-bottom: 1px solid var(--border);
}

.table-custom tbody tr {
    transition: all 0.2s;
}

.table-custom tbody tr:hover {
    background-color: rgba(255, 152, 0, 0.05);
}

.btn-action {
    padding: 6px 10px;
    margin: 2px;
    border: none;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-edit {
    background: #FFF3E0;
    color: #EF6C00;
    border: 1px solid #FFB74D;
}

.btn-edit:hover {
    background: #FFE0B2;
}

.btn-delete {
    background: #FFEBEE;
    color: #C62828;
    border: 1px solid #EF9A9A;
}

.btn-delete:hover {
    background: #FFCDD2;
}

.btn-view {
    background: #E3F2FD;
    color: #1565C0;
    border: 1px solid #90CAF9;
}

.btn-view:hover {
    background: #BBDEFB;
}

.btn-certificate {
    background: #E8F5E9;
    color: #2E7D32;
    border: 1px solid #A5D6A7;
}

.btn-certificate:hover {
    background: #C8E6C9;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.pagination-section {
    background: white;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 16px;
    margin: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.pagination-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.page-info {
    color: var(--light-text);
    font-weight: 600;
}

.pagination-buttons {
    display: flex;
    gap: 4px;
    align-items: center;
}

.page-btn {
    padding: 8px 12px;
    border: 1px solid var(--border);
    background: white;
    color: var(--text);
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s;
}

.page-btn.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

.page-btn:hover:not(.disabled) {
    background: var(--primary-light);
}

.page-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Loading animation */
.loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid var(--border);
    border-top: 4px solid var(--primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 20px auto;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: var(--light-text);
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.5;
}

@media (max-width: 768px) {
    .birth-card {
        margin: 10px;
    }

    .birth-header {
        padding: 16px;
        flex-direction: column;
        gap: 16px;
    }

    .header-actions {
        width: 100%;
    }

    .search-box {
        min-width: 100%;
    }

    .stats-grid {
        grid-template-columns: 1fr;
        gap: 10px;
        padding: 10px;
    }

    .filter-section {
        margin: 10px;
        padding: 15px;
    }

    .table-container {
        margin: 10px;
    }

    .pagination-section {
        margin: 10px;
    }

    .pagination-controls {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
}

@media (max-width: 576px) {
    .stat-card {
        padding: 15px;
    }

    .stat-number {
        font-size: 2rem;
    }
    
    .btn-action {
        padding: 4px 8px;
        font-size: 0.7rem;
    }
}
    </style>
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