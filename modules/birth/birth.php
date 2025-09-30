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
            --row-grey: #f2f2f2;
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

        .stat-card:nth-child(1)::before {
            background: var(--primary);
        }

        .stat-card:nth-child(2)::before {
            background: var(--primary);
        }

        .stat-card:nth-child(3)::before {
            background: var(--primary);
        }

        .stat-card:nth-child(4)::before {
            background: var(--primary);
        }

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

        .stat-card:nth-child(1) .stat-number {
            color: var(--primary);
        }

        .stat-card:nth-child(2) .stat-number {
            color: var(--primary);
        }

        .stat-card:nth-child(3) .stat-number {
            color: var(--primary);
        }

        .stat-card:nth-child(4) .stat-number {
            color: var(--primary);
        }

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
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
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

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        /* Fade in animation for table rows */
        .table-custom tbody tr {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Stats animation */
        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-number {
            transition: all 0.5s ease;
        }

        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 4px;
        }

        .skeleton-text {
            height: 1rem;
            margin-bottom: 0.5rem;
        }

        .skeleton-number {
            height: 2.5rem;
            width: 80px;
            margin: 0 auto 0.5rem auto;
        }

        .skeleton-stat {
            height: 1.5rem;
            width: 60px;
            margin: 0 auto;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        /* Table loading state */
        .table-loading {
            text-align: center;
            padding: 40px 20px;
            color: var(--light-text);
        }

        .table-loading .loading-spinner {
            margin: 0 auto 20px auto;
        }

        /* Stats grid loading state */
        .stats-grid.loading .stat-card {
            opacity: 1;
            transform: translateY(0);
        }

        /* Sort controls */
        .sort-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sort-btn {
            background: none;
            border: 1px solid var(--border);
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.8rem;
        }

        .sort-btn:hover {
            background: var(--primary-light);
            border-color: var(--primary);
        }

        .sort-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .sort-btn i {
            font-size: 0.7rem;
        }

        /* Striped table rows */
        .table-custom tbody tr:nth-child(odd) td {
            background-color: #ffffff !important;
            /* white */
        }

        .table-custom tbody tr:nth-child(even) td {
            background-color: #f7f7f7 !important;
            /* light grey */
        }

        /* Hover effect */
        .table-custom tbody tr:hover td {
            background-color: #D2D2D2 !important;
            /* light orange tint */
            transition: background 0.2s ease-in-out;
        }

        .modal-loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1050;
            border-radius: 8px;
        }

        #addBirthModal .modal-body {
            position: relative;
            min-height: 200px;
        }

        /* Add to your existing CSS */
        .custom-swal-confirm-danger {
            background-color: #d33 !important;
            border-color: #d33 !important;
        }

        .custom-swal-confirm-danger:hover {
            background-color: #c53030 !important;
            border-color: #c53030 !important;
            transform: translateY(-1px);
        }

        /* Delete button loading state */
        .btn-delete.loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .btn-delete.loading i {
            animation: spin 1s linear infinite;
        }

        /* SweetAlert customizations */
        .custom-swal-popup {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .swal2-html-container {
            font-size: 1rem;
            line-height: 1.5;
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
                <div class="stats-grid" id="statsGrid">
                    <div class="stat-card">
                        <h3>Total Records</h3>
                        <div class="skeleton skeleton-number" id="totalRecordsSkeleton"></div>
                        <p class="stat-number" id="totalRecords" style="display: none;">0</p>
                        <div class="text-muted">
                            <i class="fas fa-database"></i> All time
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3>This Month</h3>
                        <div class="skeleton skeleton-number" id="monthRecordsSkeleton"></div>
                        <p class="stat-number" id="monthRecords" style="display: none;">0</p>
                        <div class="text-muted">
                            <i class="fas fa-calendar"></i> Current month
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3>Pending Review</h3>
                        <div class="skeleton skeleton-number" id="pendingRecordsSkeleton"></div>
                        <p class="stat-number" id="pendingRecords" style="display: none;">0</p>
                        <div class="text-muted">
                            <i class="fas fa-clock"></i> Awaiting action
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3>Certified</h3>
                        <div class="skeleton skeleton-number" id="certifiedRecordsSkeleton"></div>
                        <p class="stat-number" id="certifiedRecords" style="display: none;">0</p>
                        <div class="text-muted">
                            <i class="fas fa-file-certificate"></i> Completed
                        </div>
                    </div>
                </div>

                <!-- Add Sort Controls after the Stats Grid -->
                <div class="filter-section">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <div class="sort-controls">
                                <span class="fw-semibold">Sort by:</span>
                                <button class="sort-btn active" data-sort="newest">
                                    <i class="fas fa-arrow-down"></i> Newest First
                                </button>
                                <button class="sort-btn" data-sort="oldest">
                                    <i class="fas fa-arrow-up"></i> Oldest First
                                </button>
                                <button class="sort-btn" data-sort="name">
                                    <i class="fas fa-sort-alpha-down"></i> Name A-Z
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="text-muted">
                                <small id="searchInfo">Showing all records</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Replace the Loading Indicator section with this: -->
                <div id="loadingIndicator" class="table-loading" style="display: none;">
                    <div class="loading-spinner"></div>
                    <p class="mt-2 text-muted">Loading records...</p>
                </div>

                <!-- Table Container -->
                <div class="table-container" id="tableContainer">
                    <table class="table table-custom table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Registration No.</th>
                                <th>Full Name</th>
                                <th>Date of Birth</th>
                                <th>Place of Birth</th>
                                <th>Parents</th>
                                <th>Date Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="recordsTable">
                            <!-- Records will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>

                <!-- Empty State -->
                <div id="emptyState" class="empty-state" style="display: none;">
                    <i class="fas fa-folder-open"></i>
                    <h4>No records found</h4>
                    <p>No birth records match your search criteria.</p>
                </div>

                <!-- Pagination -->
                <div class="pagination-section" id="paginationSection" style="display: none;">
                    <div class="pagination-controls">
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-semibold">Rows per page:</span>
                            <select class="form-select form-select-sm" style="width: auto;" id="rowsPerPage">
                                <option value="5">5</option>
                                <option value="10" selected>10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                            </select>
                        </div>

                        <div class="page-info" id="pageInfo">
                            Showing 0-0 of 0 records
                        </div>

                        <div class="pagination-buttons" id="paginationButtons">
                            <!-- Pagination buttons will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Duplicate Records Modal -->
        <div class="modal fade" id="duplicateRecordsModal" tabindex="-1" aria-labelledby="duplicateRecordsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title" id="duplicateRecordsModalLabel">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Similar Records Found
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Content will be loaded dynamically -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include the Birth Modal Component -->
    <?php include '../../components/birth-modal.php'; ?>

    <?php include '../../components/birth-details-modal.php'; ?>

    <?php include '../../components/birth-certificate-modal.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/birth.js"></script>
    <script src="../../assets/js/birth-modal.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.js"></script>

    <script>
        class BirthRecordsManager {
            constructor() {
                this.currentPage = 1;
                this.rowsPerPage = 10;
                this.searchTerm = '';
                this.isLoading = false;
                this.totalPages = 1;
                this.currentSort = 'newest'; // Default sort=

                // NEW: Track modal state and pending requests
                this.isModalLoading = false;
                this.pendingEditRequest = null;
                this.currentEditId = null;

                // NEW: Track delete state to prevent multiple operations
                this.isDeleting = false;

                // Remove the conflicting birth.js script
                this.removeConflictingScript();

                this.initializeEventListeners();
                this.showInitialLoading();
                this.loadRecords();
            }

            removeConflictingScript() {
                const scripts = document.querySelectorAll('script[src*="birth.js"]');
                scripts.forEach(script => {
                    if (script.src.includes('birth.js') && !script.src.includes('birth-modal.js')) {
                        script.remove();
                    }
                });
            }

            initializeEventListeners() {
                // Search input with debounce
                const searchInput = document.getElementById('recordSearch');
                if (searchInput) {
                    let searchTimeout;
                    searchInput.addEventListener('input', (e) => {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(() => {
                            this.searchTerm = e.target.value;
                            this.currentPage = 1;
                            this.updateSearchInfo();
                            this.loadRecords();
                        }, 500);
                    });
                }

                // Rows per page change
                const rowsPerPage = document.getElementById('rowsPerPage');
                if (rowsPerPage) {
                    rowsPerPage.addEventListener('change', (e) => {
                        this.rowsPerPage = parseInt(e.target.value);
                        this.currentPage = 1;
                        this.loadRecords();
                    });
                }

                // Sort buttons
                document.querySelectorAll('.sort-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const sortType = e.currentTarget.dataset.sort;
                        this.setSort(sortType);
                    });
                });
            }

            setSort(sortType) {
                // Update active state
                document.querySelectorAll('.sort-btn').forEach(btn => {
                    btn.classList.toggle('active', btn.dataset.sort === sortType);
                });

                this.currentSort = sortType;
                this.currentPage = 1;
                this.loadRecords();
            }

            updateSearchInfo() {
                const searchInfo = document.getElementById('searchInfo');
                if (searchInfo) {
                    if (this.searchTerm) {
                        searchInfo.textContent = `Searching for: "${this.searchTerm}"`;
                    } else {
                        searchInfo.textContent = 'Showing all records';
                    }
                }
            }

            showInitialLoading() {
                // Show skeleton for stats - ensure this works properly
                const statNumbers = document.querySelectorAll('.stat-number');
                const skeletonNumbers = document.querySelectorAll('.skeleton-number');

                statNumbers.forEach(el => {
                    el.style.display = 'none';
                });
                skeletonNumbers.forEach(el => {
                    el.style.display = 'block';
                });

                // Show loading for table
                this.showTableLoading();

                // Add loading class to stats grid
                const statsGrid = document.getElementById('statsGrid');
                if (statsGrid) {
                    statsGrid.classList.add('loading');

                    // Ensure stat cards are visible but showing skeletons
                    const statCards = statsGrid.querySelectorAll('.stat-card');
                    statCards.forEach(card => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    });
                }
            }

            showTableLoading() {
                const tbody = document.getElementById('recordsTable');
                const loadingIndicator = document.getElementById('loadingIndicator');
                const tableContainer = document.getElementById('tableContainer');
                const paginationSection = document.getElementById('paginationSection');
                const emptyState = document.getElementById('emptyState');

                if (tbody) tbody.innerHTML = '';
                if (loadingIndicator) loadingIndicator.style.display = 'block';
                if (tableContainer) tableContainer.style.display = 'none';
                if (paginationSection) paginationSection.style.display = 'none';
                if (emptyState) emptyState.style.display = 'none';
            }

            hideTableLoading() {
                const loadingIndicator = document.getElementById('loadingIndicator');
                if (loadingIndicator) loadingIndicator.style.display = 'none';
            }

            async loadRecords() {
                if (this.isLoading) return;

                this.isLoading = true;
                this.showTableLoading();

                try {
                    const params = new URLSearchParams({
                        search: this.searchTerm,
                        page: this.currentPage,
                        limit: this.rowsPerPage,
                        sort: this.currentSort
                    });

                    const response = await fetch(`../../handlers/fetch-birth-records.php?${params}`);

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();

                    if (data.success) {
                        this.updateStats(data.stats);
                        this.renderTable(data.records);
                        this.updatePagination(data.totalRecords, data.currentPage, data.totalPages);

                        if (data.records.length === 0) {
                            this.showEmptyState();
                        } else {
                            this.hideEmptyState();
                        }
                    } else {
                        throw new Error(data.message);
                    }
                } catch (error) {
                    console.error('Error loading records:', error);
                    this.showError('Failed to load records: ' + error.message);
                    this.showEmptyState();
                } finally {
                    this.isLoading = false;
                    this.hideTableLoading();
                }
            }

            updateStats(stats) {
                // Hide skeletons and show actual numbers
                document.querySelectorAll('.stat-number').forEach(el => {
                    el.style.display = 'block';
                });
                document.querySelectorAll('.skeleton-number').forEach(el => {
                    el.style.display = 'none';
                });

                const totalEl = document.getElementById('totalRecords');
                const monthEl = document.getElementById('monthRecords');
                const pendingEl = document.getElementById('pendingRecords');
                const certifiedEl = document.getElementById('certifiedRecords');

                if (totalEl) totalEl.textContent = this.formatNumber(stats.total);
                if (monthEl) monthEl.textContent = this.formatNumber(stats.thisMonth);
                if (pendingEl) pendingEl.textContent = this.formatNumber(stats.pending);
                if (certifiedEl) certifiedEl.textContent = this.formatNumber(stats.certified);

                // Animate stats
                document.querySelectorAll('.stat-card').forEach(card => {
                    card.classList.add('animated');
                });

                // Remove loading class from stats grid
                document.getElementById('statsGrid').classList.remove('loading');
            }

            renderTable(records) {
                const tbody = document.getElementById('recordsTable');
                const tableContainer = document.getElementById('tableContainer');

                if (!tbody || !tableContainer) return;

                tbody.innerHTML = '';
                tableContainer.style.display = 'block';

                if (records.length === 0) {
                    this.showEmptyState();
                    return;
                }

                records.forEach((record, index) => {
                    const rowNumber = (this.currentPage - 1) * this.rowsPerPage + index + 1;
                    const row = this.createTableRow(record, rowNumber);
                    tbody.appendChild(row);
                });
            }

            // ENHANCED createTableRow method in BirthRecordsManager class
            createTableRow(record, rowNumber) {
                const tr = document.createElement('tr');
                tr.id = `birth-record-${record.birth_id}`;

                // Store record data in data attributes for quick access
                tr.dataset.recordId = record.birth_id;
                tr.dataset.fullName = record.full_name ? record.full_name.replace(/\s+/g, ' ').trim() : '';
                tr.dataset.regNumber = record.registry_number || '';

                // Safely handle null values and clean up full name
                const fullName = record.full_name ?
                    record.full_name.replace(/\s+/g, ' ').trim() : 'N/A';

                tr.innerHTML = `
    <td>${rowNumber}</td>
    <td>${record.registry_number || 'N/A'}</td>
    <td>${fullName}</td>
    <td>${record.date_of_birth ? this.formatDate(record.date_of_birth) : 'N/A'}</td>
    <td>${record.place_of_birth || 'N/A'}</td>
    <td>${record.parents && record.parents !== ' & ' ? record.parents : 'N/A'}</td>
    <td>${record.date_registered ? this.formatDate(record.date_registered) : 'N/A'}</td>
    <td>
        <button class="btn-action btn-view" title="View Details" onclick="birthManager.viewRecord(${record.birth_id || 0})">
            <i class="fas fa-eye"></i>
        </button>
        <button class="btn-action btn-certificate" title="Generate Certificate" onclick="birthManager.generateCertificate(${record.birth_id || 0})">
            <i class="fas fa-certificate"></i>
        </button>
        <button class="btn-action btn-edit" title="Edit" onclick="birthManager.editRecord(${record.birth_id || 0})">
            <i class="fas fa-edit"></i>
        </button>
        <button class="btn-action btn-delete" title="Delete" onclick="birthManager.deleteRecord(${record.birth_id || 0})" data-record-id="${record.birth_id}">
            <i class="fas fa-trash"></i>
        </button>
    </td>
    `;

                return tr;
            }

            updatePagination(totalRecords, currentPage, totalPages) {
                this.totalPages = totalPages;

                const pageInfo = document.getElementById('pageInfo');
                const paginationSection = document.getElementById('paginationSection');
                const paginationButtons = document.getElementById('paginationButtons');

                if (!pageInfo || !paginationSection || !paginationButtons) return;

                const startRecord = totalRecords > 0 ? (currentPage - 1) * this.rowsPerPage + 1 : 0;
                const endRecord = Math.min(currentPage * this.rowsPerPage, totalRecords);

                pageInfo.textContent = `Showing ${startRecord}-${endRecord} of ${this.formatNumber(totalRecords)} records`;
                paginationButtons.innerHTML = '';

                if (totalRecords === 0) {
                    paginationSection.style.display = 'none';
                    return;
                }

                paginationSection.style.display = 'block';

                // Previous buttons
                paginationButtons.appendChild(this.createPageButton('first', 'fas fa-angle-double-left', currentPage === 1));
                paginationButtons.appendChild(this.createPageButton('prev', 'fas fa-angle-left', currentPage === 1));

                // Page numbers
                const startPage = Math.max(1, currentPage - 2);
                const endPage = Math.min(totalPages, currentPage + 2);

                if (startPage > 1) {
                    paginationButtons.appendChild(this.createPageButton(1, 1, false));
                    if (startPage > 2) {
                        const ellipsis = document.createElement('span');
                        ellipsis.textContent = '...';
                        ellipsis.className = 'mx-1';
                        paginationButtons.appendChild(ellipsis);
                    }
                }

                for (let i = startPage; i <= endPage; i++) {
                    paginationButtons.appendChild(this.createPageButton(i, i, false, i === currentPage));
                }

                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        const ellipsis = document.createElement('span');
                        ellipsis.textContent = '...';
                        ellipsis.className = 'mx-1';
                        paginationButtons.appendChild(ellipsis);
                    }
                    paginationButtons.appendChild(this.createPageButton(totalPages, totalPages, false));
                }

                // Next buttons
                paginationButtons.appendChild(this.createPageButton('next', 'fas fa-angle-right', currentPage === totalPages));
                paginationButtons.appendChild(this.createPageButton('last', 'fas fa-angle-double-right', currentPage === totalPages));
            }

            createPageButton(action, content, disabled, active = false) {
                const button = document.createElement('button');
                button.className = `page-btn ${disabled ? 'disabled' : ''} ${active ? 'active' : ''}`;
                button.innerHTML = typeof content === 'number' ? content : `<i class="${content}"></i>`;
                button.disabled = disabled;

                if (!disabled) {
                    button.onclick = () => this.handlePageChange(action);
                }

                return button;
            }

            handlePageChange(action) {
                switch (action) {
                    case 'first':
                        this.currentPage = 1;
                        break;
                    case 'prev':
                        if (this.currentPage > 1) this.currentPage--;
                        break;
                    case 'next':
                        if (this.currentPage < this.totalPages) this.currentPage++;
                        break;
                    case 'last':
                        this.currentPage = this.totalPages;
                        break;
                    default:
                        this.currentPage = action;
                }

                this.loadRecords();
            }

            showEmptyState() {
                const tableContainer = document.getElementById('tableContainer');
                const emptyState = document.getElementById('emptyState');
                const paginationSection = document.getElementById('paginationSection');

                if (tableContainer) tableContainer.style.display = 'none';
                if (emptyState) emptyState.style.display = 'block';
                if (paginationSection) paginationSection.style.display = 'none';
            }

            hideEmptyState() {
                const tableContainer = document.getElementById('tableContainer');
                const emptyState = document.getElementById('emptyState');

                if (tableContainer) tableContainer.style.display = 'block';
                if (emptyState) emptyState.style.display = 'none';
            }

            formatNumber(num) {
                return new Intl.NumberFormat().format(num);
            }

            formatDate(dateString) {
                try {
                    return new Date(dateString).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                } catch (e) {
                    return 'Invalid Date';
                }
            }

            showError(message) {
                if (typeof Toastify !== 'undefined') {
                    Toastify({
                        text: message,
                        duration: 5000,
                        gravity: "top",
                        position: "right",
                        style: {
                            background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                        },
                        stopOnFocus: true
                    }).showToast();
                } else {
                    alert(message);
                }
            }

            viewRecord(id) {
                if (id && id > 0) {
                    this.openBirthDetailsModal(id);
                } else {
                    this.showError('Invalid record ID');
                }
            }

            async openBirthDetailsModal(birthId) {
                try {
                    // Show modal and loading state
                    const modal = new bootstrap.Modal(document.getElementById('birthDetailsModal'));
                    this.resetModalState();
                    modal.show();

                    // Fetch record details
                    const response = await fetch(`../../handlers/fetch-birth-details.php?birth_id=${birthId}`);
                    const data = await response.json();

                    if (data.success) {
                        this.displayModalRecordDetails(data.data);
                    } else {
                        this.showModalError(data.message);
                    }
                } catch (error) {
                    console.error('Error loading record details:', error);
                    this.showModalError('Failed to load record details');
                }
            }

            resetModalState() {
                document.getElementById('modalLoadingState').style.display = 'block';
                document.getElementById('modalRecordDetails').style.display = 'none';
                document.getElementById('modalErrorState').style.display = 'none';
            }

            displayModalRecordDetails(data) {
                const birth = data.birth_record;
                const mother = data.mother_info;
                const father = data.father_info;
                const marriage = data.marriage_info;
                const attendant = data.attendant_info;
                const informant = data.informant_info;

                // Hide loading, show details
                document.getElementById('modalLoadingState').style.display = 'none';
                document.getElementById('modalRecordDetails').style.display = 'block';

                // Child Information
                document.getElementById('modalRegistryNumber').textContent = birth.registry_number || 'N/A';
                document.getElementById('modalChildFullName').textContent = this.formatFullName(
                    birth.child_first_name,
                    birth.child_middle_name,
                    birth.child_last_name
                );
                document.getElementById('modalChildSex').textContent = birth.sex || 'N/A';
                document.getElementById('modalDateOfBirth').textContent = this.formatDate(birth.date_of_birth);
                document.getElementById('modalTimeOfBirth').textContent = this.formatTime(birth.time_of_birth);
                document.getElementById('modalBirthWeight').textContent = birth.birth_weight ? `${birth.birth_weight} kg` : 'N/A';
                document.getElementById('modalTypeOfBirth').textContent = birth.type_of_birth || 'N/A';
                document.getElementById('modalBirthOrder').textContent = birth.birth_order || 'N/A';
                document.getElementById('modalPlaceOfBirth').textContent = birth.place_of_birth || 'N/A';
                document.getElementById('modalBirthAddress').textContent = this.formatAddress(
                    birth.birth_address_house,
                    birth.birth_address_barangay,
                    birth.birth_address_city
                );
                document.getElementById('modalBirthNotes').textContent = birth.birth_notes || 'No additional notes';

                // Mother's Information
                document.getElementById('modalMotherFullName').textContent = this.formatFullName(
                    mother.first_name,
                    mother.middle_name,
                    mother.last_name
                );
                document.getElementById('modalMotherCitizenship').textContent = mother.citizenship || 'N/A';
                document.getElementById('modalMotherReligion').textContent = mother.religion || 'N/A';
                document.getElementById('modalMotherOccupation').textContent = mother.occupation || 'N/A';
                document.getElementById('modalMotherAge').textContent = mother.age_at_birth ? `${mother.age_at_birth} years old` : 'N/A';
                document.getElementById('modalMotherChildrenBorn').textContent = mother.children_born_alive || '0';
                document.getElementById('modalMotherChildrenLiving').textContent = mother.children_still_living || '0';
                document.getElementById('modalMotherChildrenDeceased').textContent = mother.children_deceased || '0';
                document.getElementById('modalMotherAddress').textContent = this.formatAddress(
                    mother.house_no,
                    mother.barangay,
                    mother.city,
                    mother.province,
                    mother.country
                );

                // Father's Information
                document.getElementById('modalFatherFullName').textContent = this.formatFullName(
                    father.first_name,
                    father.middle_name,
                    father.last_name
                );
                document.getElementById('modalFatherCitizenship').textContent = father.citizenship || 'N/A';
                document.getElementById('modalFatherReligion').textContent = father.religion || 'N/A';
                document.getElementById('modalFatherOccupation').textContent = father.occupation || 'N/A';
                document.getElementById('modalFatherAge').textContent = father.age_at_birth ? `${father.age_at_birth} years old` : 'N/A';
                document.getElementById('modalFatherAddress').textContent = this.formatAddress(
                    father.house_no,
                    father.barangay,
                    father.city,
                    father.province,
                    father.country
                );

                // Marriage Information
                if (marriage && (marriage.marriage_date || marriage.marriage_place_city)) {
                    document.getElementById('modalMarriageSection').style.display = 'block';
                    document.getElementById('modalMarriageDate').textContent = this.formatDate(marriage.marriage_date);
                    document.getElementById('modalMarriagePlace').textContent = this.formatMarriagePlace(marriage);
                } else {
                    document.getElementById('modalMarriageSection').style.display = 'none';
                }

                // Attendant Information
                document.getElementById('modalAttendantType').textContent = attendant.attendant_type || 'N/A';
                document.getElementById('modalAttendantName').textContent = attendant.attendant_name || 'N/A';
                document.getElementById('modalAttendantLicense').textContent = attendant.attendant_license || 'N/A';
                document.getElementById('modalAttendantTitle').textContent = attendant.attendant_title || 'N/A';
                document.getElementById('modalAttendantAddress').textContent = attendant.attendant_address || 'N/A';
                document.getElementById('modalAttendantCertification').textContent = attendant.attendant_certification || 'N/A';

                // Informant Information
                document.getElementById('modalInformantFullName').textContent = this.formatFullName(
                    informant.first_name,
                    informant.middle_name,
                    informant.last_name
                );
                document.getElementById('modalInformantRelationship').textContent = informant.relationship || 'N/A';
                document.getElementById('modalInformantAddress').textContent = informant.address || 'N/A';
                document.getElementById('modalInformantCertified').textContent = informant.certification_accepted ? 'Yes' : 'No';

                // Registration Information
                document.getElementById('modalDateRegistered').textContent = this.formatDateTime(birth.date_registered);
                document.getElementById('modalRecordId').textContent = birth.birth_id || 'N/A';

                // Set up print button
                document.getElementById('modalPrintBtn').onclick = () => this.printModalRecord();
            }

            showModalError(message) {
                document.getElementById('modalLoadingState').style.display = 'none';
                document.getElementById('modalErrorState').style.display = 'block';
                document.getElementById('modalErrorMessage').textContent = message;
            }

            formatFullName(first, middle, last) {
                const names = [first, middle, last].filter(name => name && name.trim() !== '');
                return names.length > 0 ? names.join(' ') : 'N/A';
            }

            formatTime(timeString) {
                if (!timeString) return 'N/A';
                try {
                    return new Date(`2000-01-01T${timeString}`).toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });
                } catch (e) {
                    return 'Invalid Time';
                }
            }

            formatDateTime(dateTimeString) {
                if (!dateTimeString) return 'N/A';
                try {
                    return new Date(dateTimeString).toLocaleString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });
                } catch (e) {
                    return 'Invalid Date/Time';
                }
            }

            formatAddress(house, barangay, city, province, country) {
                const addressParts = [house, barangay, city, province, country].filter(part => part && part.trim() !== '');
                return addressParts.length > 0 ? addressParts.join(', ') : 'N/A';
            }

            formatMarriagePlace(marriage) {
                const placeParts = [marriage.marriage_place_city, marriage.marriage_place_province, marriage.marriage_place_country]
                    .filter(part => part && part.trim() !== '');
                return placeParts.length > 0 ? placeParts.join(', ') : 'N/A';
            }

            printModalRecord() {
                const modalContent = document.getElementById('modalRecordDetails').cloneNode(true);
                const printWindow = window.open('', '_blank');

                printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Birth Record - ${document.getElementById('modalRegistryNumber').textContent}</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body { padding: 20px; font-family: Arial, sans-serif; }
                .section-card { border: 1px solid #ddd; border-radius: 8px; padding: 15px; margin-bottom: 15px; }
                .section-title { color: #FF9800; font-weight: bold; border-bottom: 2px solid #FFE0B2; padding-bottom: 8px; margin-bottom: 15px; }
                .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 10px; }
                .info-label { font-weight: bold; color: #666; font-size: 0.9rem; }
                @media print { body { padding: 0; } }
            </style>
        </head>
        <body>
            <h2 class="text-center mb-4">Birth Record Details</h2>
            ${modalContent.innerHTML}
        </body>
        </html>
    `);

                printWindow.document.close();
                printWindow.focus();
                setTimeout(() => {
                    printWindow.print();
                    printWindow.close();
                }, 500);
            }

            generateCertificate(id) {
                if (id && id > 0) {
                    this.openBirthCertificateModal(id);
                } else {
                    this.showError('Invalid record ID');
                }
            }

            async openBirthCertificateModal(birthId) {
                try {
                    // Show modal and loading state
                    const modal = new bootstrap.Modal(document.getElementById('birthCertificateModal'));
                    this.resetCertificateModalState();
                    modal.show();

                    // Fetch record details for certificate
                    const response = await fetch(`../../handlers/fetch-birth-details.php?birth_id=${birthId}`);
                    const data = await response.json();

                    if (data.success) {
                        this.displayCertificatePreview(data.data);
                    } else {
                        this.showCertificateError(data.message);
                    }
                } catch (error) {
                    console.error('Error loading certificate data:', error);
                    this.showCertificateError('Failed to load certificate data');
                }
            }

            resetCertificateModalState() {
                document.getElementById('certificateLoadingState').style.display = 'block';
                document.getElementById('certificatePreview').style.display = 'none';
                document.getElementById('certificateErrorState').style.display = 'none';
                document.getElementById('generatePdfBtn').style.display = 'none';
                document.getElementById('printCertificateBtn').style.display = 'none';
            }

            displayCertificatePreview(data) {
                const birth = data.birth_record;
                const mother = data.mother_info;
                const father = data.father_info;
                const marriage = data.marriage_info;
                const attendant = data.attendant_info;
                const informant = data.informant_info;

                // Hide loading, show preview
                document.getElementById('certificateLoadingState').style.display = 'none';
                document.getElementById('certificatePreview').style.display = 'block';
                document.getElementById('generatePdfBtn').style.display = 'inline-block';
                document.getElementById('printCertificateBtn').style.display = 'inline-block';

                // Set up button events
                document.getElementById('generatePdfBtn').onclick = () => this.generatePDF(data);
                document.getElementById('printCertificateBtn').onclick = () => this.printCertificate(data);

                // Generate certificate HTML
                const certificateHTML = this.generateCertificateHTML(data);
                document.getElementById('certificateContent').innerHTML = certificateHTML;
            }

            generateCertificateHTML(data) {
                const birth = data.birth_record;
                const mother = data.mother_info || {};
                const father = data.father_info || {};
                const marriage = data.marriage_info || {};
                const attendant = data.attendant_info || {};
                const informant = data.informant_info || {};

                // Format dates
                const birthDate = birth.date_of_birth ? new Date(birth.date_of_birth) : null;
                const marriageDate = marriage && marriage.marriage_date ? new Date(marriage.marriage_date) : null;

                // Helper function to safely display data
                const safeDisplay = (value) => value || '';

                return `
        <div class="certificate-header">
            <div class="certificate-title">(Revised August 2016) Republic of the Philippines</div>
            <div class="certificate-subtitle">OFFICE OF THE CIVIL REGISTRAR GENERAL</div>
            <div class="certificate-main-title">CERTIFICATE OF LIVE BIRTH</div>
        </div>

        <div class="form-grid-3-top">
            <div class="form-section">
                <div class="form-label">Province</div>
                <div class="form-value">${safeDisplay(birth.birth_address_province)}</div>
            </div>
            <div class="form-section">
                <div class="form-label">Registry No.</div>
                <div class="form-value">${safeDisplay(birth.registry_number)}</div>
            </div>
            <div class="form-section">
                <div class="form-label">City/Municipality</div>
                <div class="form-value">${safeDisplay(birth.birth_address_city)}</div>
            </div>
        </div>

        <!-- Child Information -->
        <div class="form-section">
            <div class="form-label">1. NAME (First) (Middle) (Last)</div>
            <div class="form-value-long">${safeDisplay(birth.child_first_name)} ${safeDisplay(birth.child_middle_name)} ${safeDisplay(birth.child_last_name)}</div>
        </div>

        <div class="form-grid-2">
            <div class="form-section">
                <div class="form-label">2. SEX (Male / Female)</div>
                <div class="form-value">${safeDisplay(birth.sex)}</div>
            </div>
            <div class="form-section">
                <div class="form-label">3. DATE OF BIRTH (Day) (Month) (Year)</div>
                <div class="form-value">
                    ${birthDate ? `${birthDate.getDate()} ${birthDate.toLocaleDateString('en-US', {month: 'long'})} ${birthDate.getFullYear()}` : ''}
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-label">4. PLACE OF BIRTH (Name of Hospital/Clinic/Institution) (City/Municipality) (Province)</div>
            <div class="form-value-long">${safeDisplay(birth.place_of_birth)}</div>
        </div>

        <div class="form-section">
            <div class="form-label">House No., St. Barangay</div>
            <div class="form-value-long">${safeDisplay(birth.birth_address_house)} ${safeDisplay(birth.birth_address_barangay)} ${safeDisplay(birth.birth_address_city)} ${safeDisplay(birth.birth_address_province)} ${safeDisplay(birth.birth_address_region)}: ${safeDisplay(birth.birth_address_zip)}</div>
        </div>

        <div class="form-grid-3">
            <div class="form-section">
                <div class="form-label">5a. TYPE OF BIRTH (Single Twin Triplet, etc.)</div>
                <div class="form-value">${safeDisplay(birth.type_of_birth)}</div>
            </div>
            <div class="form-section">
                <div class="form-label">5b. IF MULTIPLE BIRTH, CHILD WAS (First, Second, Third, etc.)</div>
                <div class="form-value">
                    ${birth.birth_order === '1' ? 'First' : birth.birth_order === '2' ? 'Second' : birth.birth_order === '3' ? 'Third' : safeDisplay(birth.birth_order)}
                </div>
            </div>
            <div class="form-section">
                <div class="form-label">5c. BIRTH ORDER (First, Second, Third, etc.)</div>
                <div class="form-value">${safeDisplay(birth.birth_order)}</div>
            </div>
        </div>

        <!-- Mother's Information -->
        <div class="form-section">
            <div class="form-label">7. MAIDEN NAME (First) (Middle) (Last)</div>
            <div class="form-value-long">${safeDisplay(mother.first_name)} ${safeDisplay(mother.middle_name)} ${safeDisplay(mother.last_name)}</div>
        </div>

        <div class="form-grid-2">
            <div class="form-section">
                <div class="form-label">8. CITIZENSHIP</div>
                <div class="form-value">${safeDisplay(mother.citizenship)}</div>
            </div>
            <div class="form-section">
                <div class="form-label">9. RELIGION/RELIGIOUS SECT</div>
                <div class="form-value">${safeDisplay(mother.religion)}</div>
            </div>
        </div>

        <div class="form-grid-5">
            <div class="form-section">
                <div class="form-label">10a. Children born alive</div>
                <div class="form-value">${safeDisplay(mother.children_born_alive) || '0'}</div>
            </div>
            <div class="form-section">
                <div class="form-label">10b. Children still living</div>
                <div class="form-value">${safeDisplay(mother.children_still_living) || '0'}</div>
            </div>
            <div class="form-section">
                <div class="form-label">10c. Children deceased</div>
                <div class="form-value">${safeDisplay(mother.children_deceased) || '0'}</div>
            </div>
            <div class="form-section">
                <div class="form-label">11. OCCUPATION</div>
                <div class="form-value">${safeDisplay(mother.occupation)}</div>
            </div>
            <div class="form-section">
                <div class="form-label">12. AGE</div>
                <div class="form-value">${safeDisplay(mother.age_at_birth)}</div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-label">13. RESIDENCE (House No., St. Barangay) (City/Municipality) (Province) (Country)</div>
            <div class="form-value-long">${safeDisplay(mother.house_no)} ${safeDisplay(mother.barangay)} ${safeDisplay(mother.city)} ${safeDisplay(mother.province)} ${safeDisplay(mother.country)}</div>
        </div>

        <!-- Father's Information -->
        <div class="form-section">
            <div class="form-label">14. NAME (First) (Middle) (Last)</div>
            <div class="form-value-long">${safeDisplay(father.first_name)} ${safeDisplay(father.middle_name)} ${safeDisplay(father.last_name)}</div>
        </div>

        <div class="form-grid-4">
            <div class="form-section">
                <div class="form-label">15. CITIZENSHIP</div>
                <div class="form-value">${safeDisplay(father.citizenship)}</div>
            </div>
            <div class="form-section">
                <div class="form-label">16. RELIGION/RELIGIOUS SECT</div>
                <div class="form-value">${safeDisplay(father.religion)}</div>
            </div>
            <div class="form-section">
                <div class="form-label">17. OCCUPATION</div>
                <div class="form-value">${safeDisplay(father.occupation)}</div>
            </div>
            <div class="form-section">
                <div class="form-label">18. AGE at the time of this birth</div>
                <div class="form-value">${safeDisplay(father.age_at_birth)}</div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-label">19. RESIDENCE (House No., St. Barangay) (City/Municipality) (Province) (Country)</div>
            <div class="form-value-long">${safeDisplay(father.house_no)} ${safeDisplay(father.barangay)} ${safeDisplay(father.city)} ${safeDisplay(father.province)} ${safeDisplay(father.country)}</div>
        </div>

        <!-- Marriage Information -->
        <div class="form-section">
            <div class="form-label-bold">MARRIAGE OF PARENTS (If not married, accomplish Affidavit of Acknowledgment/Admission of Paternity at the back.)</div>
        </div>

        <div class="form-grid-2">
            <div class="form-section">
                <div class="form-label">20a. DATE (Month) (Day) (Year)</div>
                <div class="form-value">
                    ${marriageDate ? `${marriageDate.toLocaleDateString('en-US', {month: 'long', day: 'numeric', year: 'numeric'})}` : ''}
                </div>
            </div>
            <div class="form-section">
                <div class="form-label">20b. PLACE (City / Municipality) (Province) (Country)</div>
                <div class="form-value">${safeDisplay(marriage.marriage_place_city)} ${safeDisplay(marriage.marriage_place_province)} ${safeDisplay(marriage.marriage_place_country)}</div>
            </div>
        </div>
    `;
            }

            generatePDF(data) {
                // Open PDF in new window
                window.open(`../../handlers/generate-birth-certificate-pdf.php?birth_id=${data.birth_record.birth_id}`, '_blank');
            }

            printCertificate(data) {
                const printWindow = window.open('', '_blank');
                const certificateHTML = this.generateCertificateHTML(data);

                printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Certificate of Live Birth - ${data.birth_record.registry_number}</title>
            <style>
                body { 
                    font-family: 'Times New Roman', Times, serif;
                    margin: 0;
                    padding: 20px;
                    line-height: 1.4;
                    color: #000;
                    background: white;
                }
                .certificate-header {
                    text-align: center;
                    margin-bottom: 20px;
                    border-bottom: 2px solid #000;
                    padding-bottom: 10px;
                }
                .certificate-title {
                    font-size: 16px;
                    font-weight: bold;
                    margin-bottom: 5px;
                }
                .form-section {
                    margin-bottom: 15px;
                }
                .form-label {
                    font-weight: bold;
                    font-size: 12px;
                    display: block;
                    margin-bottom: 2px;
                }
                .form-value {
                    border-bottom: 1px solid #000;
                    min-height: 18px;
                    padding: 0 5px;
                    font-size: 12px;
                }
                .form-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 10px;
                    margin-bottom: 10px;
                }
                .signature-section {
                    margin-top: 30px;
                    border-top: 1px solid #000;
                    padding-top: 10px;
                }
                .signature-line {
                    border-bottom: 1px solid #000;
                    margin-bottom: 25px;
                    padding-bottom: 5px;
                }
                @media print {
                    body { padding: 10px; }
                    .certificate-container { border: none; }
                }
            </style>
        </head>
        <body>
            <div class="certificate-container">
                ${certificateHTML}
            </div>
            <script>
                window.onload = function() {
                    window.print();
                };
            <\/script>
        </body>
        </html>
    `);

                printWindow.document.close();
            }

            showCertificateError(message) {
                document.getElementById('certificateLoadingState').style.display = 'none';
                document.getElementById('certificateErrorState').style.display = 'block';
                document.getElementById('certificateErrorMessage').textContent = message;
            }

            // REPLACE THE editRecord METHOD
            editRecord(id) {
                if (id && id > 0) {
                    // Cancel any pending edit request
                    if (this.pendingEditRequest) {
                        this.pendingEditRequest = null;
                    }

                    // Close modal if already open and loading different record
                    if (this.currentEditId && this.currentEditId !== id) {
                        this.closeEditModal();
                    }

                    this.currentEditId = id;
                    this.openEditBirthModal(id);
                } else {
                    this.showError('Invalid record ID');
                }
            }


            // REPLACE THE openEditBirthModal METHOD
            async openEditBirthModal(birthId) {
                // Prevent multiple simultaneous edit requests
                if (this.isModalLoading) {
                    console.log('Modal is already loading, skipping request for:', birthId);
                    return;
                }

                try {
                    this.isModalLoading = true;

                    // Check if modal exists
                    const modalElement = document.getElementById('addBirthModal');
                    if (!modalElement) {
                        throw new Error('Add birth modal not found');
                    }

                    // Get modal instance
                    const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);

                    // Change modal title for editing
                    const modalTitle = document.querySelector('#addBirthModal .modal-title');
                    if (modalTitle) {
                        modalTitle.textContent = 'Loading Record...';
                    }

                    // Show loading state in modal - with proper state management
                    this.showEditModalLoading(true);

                    // Reset form first and set current edit ID
                    this.resetEditModalState();
                    this.setEditMode(birthId);

                    // Show modal AFTER setting up loading state
                    modal.show();

                    // Create abort controller for request cancellation
                    const abortController = new AbortController();
                    this.pendingEditRequest = abortController;

                    // Fetch record details for editing
                    const response = await fetch(`../../handlers/fetch-birth-details.php?birth_id=${birthId}`, {
                        signal: abortController.signal
                    });

                    // Clear pending request
                    this.pendingEditRequest = null;

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();

                    if (data.success) {
                        // Update title to editing mode
                        if (modalTitle) {
                            modalTitle.textContent = 'Edit Birth Record';
                        }

                        this.populateEditForm(data.data);

                        // Hide loading state
                        this.showEditModalLoading(false);

                        // Mark as completed loading
                        this.isModalLoading = false;
                    } else {
                        throw new Error(data.message || 'Failed to load record data');
                    }
                } catch (error) {
                    // Only handle error if it's not an abort error
                    if (error.name !== 'AbortError') {
                        console.error('Error loading record for editing:', error);
                        this.showError('Failed to load record for editing: ' + error.message);

                        // Close modal on error
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addBirthModal'));
                        if (modal) {
                            modal.hide();
                        }
                    }

                    this.isModalLoading = false;
                    this.showEditModalLoading(false);
                }
            }

            // NEW METHOD: Close edit modal properly
            closeEditModal() {
                const modal = bootstrap.Modal.getInstance(document.getElementById('addBirthModal'));
                if (modal) {
                    modal.hide();
                }

                // Cancel any pending request
                if (this.pendingEditRequest) {
                    this.pendingEditRequest.abort();
                    this.pendingEditRequest = null;
                }

                this.isModalLoading = false;
                this.currentEditId = null;
            }

            // Add this new method to show/hide loading state in edit modal
            // IMPROVED showEditModalLoading METHOD
            showEditModalLoading(show) {
                const modalBody = document.querySelector('#addBirthModal .modal-body');
                const form = document.getElementById('birthCertForm');

                if (!modalBody) return;

                if (show) {
                    // Create loading overlay if it doesn't exist
                    let loadingOverlay = modalBody.querySelector('.modal-loading-overlay');
                    if (!loadingOverlay) {
                        loadingOverlay = document.createElement('div');
                        loadingOverlay.className = 'modal-loading-overlay';
                        loadingOverlay.innerHTML = `
                <div class="text-center py-5">
                    <div class="loading-spinner mb-3"></div>
                    <p class="text-muted">Loading record details...</p>
                </div>
            `;
                        modalBody.appendChild(loadingOverlay);
                    }

                    loadingOverlay.style.display = 'flex';
                    if (form) form.style.display = 'none';

                    // Disable close button during loading
                    const closeBtn = document.querySelector('#addBirthModal .btn-close');
                    if (closeBtn) {
                        closeBtn.style.pointerEvents = 'none';
                        closeBtn.style.opacity = '0.5';
                    }
                } else {
                    const loadingOverlay = modalBody.querySelector('.modal-loading-overlay');
                    if (loadingOverlay) {
                        loadingOverlay.style.display = 'none';
                    }
                    if (form) form.style.display = 'block';

                    // Re-enable close button
                    const closeBtn = document.querySelector('#addBirthModal .btn-close');
                    if (closeBtn) {
                        closeBtn.style.pointerEvents = 'auto';
                        closeBtn.style.opacity = '1';
                    }
                }
            }

            // IMPROVED resetEditModalState METHOD
            resetEditModalState() {
                // Clear any existing data
                const form = document.getElementById('birthCertForm');
                if (form) {
                    form.reset();
                }

                // Reset to first step
                const steps = document.querySelectorAll('.form-step');
                const stepIndicators = document.querySelectorAll('.step');

                // Hide all steps except first
                steps.forEach((step, index) => {
                    if (index === 0) {
                        step.classList.add('active');
                    } else {
                        step.classList.remove('active');
                    }
                });

                // Reset step indicators
                stepIndicators.forEach((step, index) => {
                    if (index === 0) {
                        step.classList.add('active');
                        step.classList.remove('completed');
                    } else {
                        step.classList.remove('active', 'completed');
                    }
                });

                // Reset navigation buttons
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');
                const submitBtn = document.getElementById('submitBtn');

                if (prevBtn) prevBtn.style.display = 'none';
                if (nextBtn) nextBtn.style.display = 'block';
                if (submitBtn) {
                    submitBtn.classList.add('d-none');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Save Record';
                }

                // Clear any validation errors
                const errors = document.querySelectorAll('.invalid-feedback');
                errors.forEach(error => error.remove());

                const invalidFields = document.querySelectorAll('.is-invalid');
                invalidFields.forEach(field => field.classList.remove('is-invalid'));
            }

            setEditMode(birthId) {
                // Store the birth ID for updating
                const form = document.getElementById('birthCertForm');
                if (form) {
                    form.dataset.editId = birthId;
                }

                // Change submit button text - ensure it's visible and updated
                const submitBtn = document.getElementById('submitBtn');
                if (submitBtn) {
                    submitBtn.textContent = 'Update Record';
                    submitBtn.classList.remove('d-none'); // Make sure it's visible
                }

                // Update modal title
                const modalTitle = document.querySelector('#addBirthModal .modal-title');
                if (modalTitle) {
                    modalTitle.textContent = 'Edit Birth Record';
                }
            }

            populateEditForm(data) {
                const birth = data.birth_record;
                const mother = data.mother_info || {};
                const father = data.father_info || {};
                const marriage = data.marriage_info || {};
                const attendant = data.attendant_info || {};
                const informant = data.informant_info || {};

                // Child Information
                this.setValue('child_first_name', birth.child_first_name);
                this.setValue('child_middle_name', birth.child_middle_name);
                this.setValue('child_last_name', birth.child_last_name);
                this.setValue('sex', birth.sex);
                this.setValue('date_of_birth', this.formatDateForInput(birth.date_of_birth));
                this.setValue('place_of_birth', birth.place_of_birth);
                this.setValue('birth_address_house', birth.birth_address_house);
                this.setValue('birth_address_barangay', birth.birth_address_barangay);
                this.setValue('birth_address_city', birth.birth_address_city);
                this.setValue('type_of_birth', birth.type_of_birth);
                this.setValue('multiple_birth_order', birth.multiple_birth_order);
                this.setValue('birth_order', birth.birth_order);
                this.setValue('birth_weight', birth.birth_weight);
                this.setValue('birth_notes', birth.birth_notes);
                this.setValue('time_of_birth', birth.time_of_birth);

                // Mother's Information
                this.setValue('mother_first_name', mother.first_name);
                this.setValue('mother_middle_name', mother.middle_name);
                this.setValue('mother_last_name', mother.last_name);
                this.setValue('mother_citizenship', mother.citizenship);
                this.setValue('mother_religion', mother.religion);
                this.setValue('mother_occupation', mother.occupation);
                this.setValue('mother_age_at_birth', mother.age_at_birth);
                this.setValue('mother_children_born_alive', mother.children_born_alive);
                this.setValue('mother_children_still_living', mother.children_still_living);
                this.setValue('mother_children_deceased', mother.children_deceased);
                this.setValue('mother_house_no', mother.house_no);
                this.setValue('mother_barangay', mother.barangay);
                this.setValue('mother_city', mother.city);
                this.setValue('mother_province', mother.province);
                this.setValue('mother_country', mother.country);

                // Father's Information
                this.setValue('father_first_name', father.first_name);
                this.setValue('father_middle_name', father.middle_name);
                this.setValue('father_last_name', father.last_name);
                this.setValue('father_citizenship', father.citizenship);
                this.setValue('father_religion', father.religion);
                this.setValue('father_occupation', father.occupation);
                this.setValue('father_age_at_birth', father.age_at_birth);
                this.setValue('father_house_no', father.house_no);
                this.setValue('father_barangay', father.barangay);
                this.setValue('father_city', father.city);
                this.setValue('father_province', father.province);
                this.setValue('father_country', father.country);

                // Marriage Information
                if (marriage) {
                    this.setValue('marriage_date', this.formatDateForInput(marriage.marriage_date));
                    this.setValue('marriage_place_city', marriage.marriage_place_city);
                    this.setValue('marriage_place_province', marriage.marriage_place_province);
                    this.setValue('marriage_place_country', marriage.marriage_place_country);
                }

                // Attendant Information
                this.setValue('attendant_type', attendant.attendant_type);
                this.setValue('attendant_name', attendant.attendant_name);
                this.setValue('attendant_license', attendant.attendant_license);
                this.setValue('attendant_certification', attendant.attendant_certification);
                this.setValue('attendant_address', attendant.attendant_address);
                this.setValue('attendant_title', attendant.attendant_title);

                // Informant Information
                this.setValue('informant_first_name', informant.first_name);
                this.setValue('informant_middle_name', informant.middle_name);
                this.setValue('informant_last_name', informant.last_name);
                this.setValue('informant_relationship', informant.relationship);
                this.setValue('informant_address', informant.address);

                // SET CHECKBOXES AS CHECKED BY DEFAULT IN EDIT MODE - WITH SAFE CHECKS
                const informantCertCheckbox = document.getElementById('informantCertification');
                const finalizeCertCheckbox = document.getElementById('finalizeCertification');
                const confirmAccuracyCheckbox = document.getElementById('confirmAccuracy');

                if (informantCertCheckbox) {
                    informantCertCheckbox.checked = true;
                }
                if (finalizeCertCheckbox) {
                    finalizeCertCheckbox.checked = true;
                }
                if (confirmAccuracyCheckbox) {
                    confirmAccuracyCheckbox.checked = true;
                }

                // Enable multiple birth order if applicable
                if (birth.type_of_birth && birth.type_of_birth !== 'Single') {
                    document.getElementById('multipleBirthOrder').disabled = false;
                } else {
                    document.getElementById('multipleBirthOrder').disetEditModesabled = true;
                }

                // Mark all steps as completed for better UX
                document.querySelectorAll('.step').forEach(step => {
                    step.classList.add('completed');
                });
            }

            setValue(fieldName, value) {
                const element = document.querySelector(`[name="${fieldName}"]`);
                if (element && value !== null && value !== undefined) {
                    if (element.type === 'checkbox') {
                        element.checked = value;
                    } else {
                        element.value = value;
                    }
                }
            }

            formatDateForInput(dateString) {
                if (!dateString) return '';
                try {
                    const date = new Date(dateString);
                    return date.toISOString().split('T')[0];
                } catch (e) {
                    return '';
                }
            }

            // REPLACE THE deleteRecord METHOD IN BirthRecordsManager CLASS
            async deleteRecord(id) {
                if (!id || id <= 0) {
                    this.showError('Invalid record ID');
                    return;
                }

                // Prevent multiple simultaneous delete requests
                if (this.isDeleting) {
                    console.log('Delete operation already in progress, skipping request');
                    return;
                }

                try {
                    this.isDeleting = true;

                    // Get basic record info from the table row (no API call needed)
                    const row = document.querySelector(`#birth-record-${id}`);
                    let recordInfo = 'this record';

                    if (row) {
                        const nameCell = row.cells[2]; // Full Name column
                        const regNumberCell = row.cells[1]; // Registration Number column
                        const fullName = nameCell.textContent.trim();
                        const regNumber = regNumberCell.textContent.trim();

                        recordInfo = `${fullName} (${regNumber !== 'N/A' ? regNumber : 'No Registry Number'})`;
                    }

                    // Show immediate confirmation dialog (no API delay)
                    const result = await Swal.fire({
                        title: 'Delete Birth Record',
                        html: `
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle text-warning mb-3" style="font-size: 3rem;"></i>
                    <h4 class="text-danger">Are you sure?</h4>
                    <p>You are about to delete the birth record for:<br>
                    <strong>${recordInfo}</strong></p>
                    <p class="text-muted small">This action cannot be undone and will permanently remove all associated data including parent information, marriage details, and attendant records.</p>
                </div>
            `,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        customClass: {
                            popup: 'custom-swal-popup',
                            confirmButton: 'custom-swal-confirm-danger',
                            cancelButton: 'custom-swal-cancel'
                        },
                        background: 'var(--bg-color, #fff)',
                        color: 'var(--text-color, #000)'
                    });

                    if (result.isConfirmed) {
                        // Show loading state immediately
                        Swal.fire({
                            title: 'Deleting Record',
                            text: 'Please wait while we delete the record...',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Send delete request
                        const deleteResponse = await fetch('../../handlers/delete-birth-record.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                action: 'delete_birth_record',
                                birth_id: id
                            })
                        });

                        const deleteData = await deleteResponse.json();

                        // Close loading state
                        Swal.close();

                        if (deleteData.success) {
                            // Show success message
                            await Swal.fire({
                                title: 'Deleted!',
                                text: 'Birth record has been deleted successfully.',
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK',
                                timer: 2000,
                                timerProgressBar: true
                            });

                            // Refresh the table data
                            this.refreshAllData();

                            // Show Toastify notification
                            Toastify({
                                text: 'Birth record deleted successfully!',
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                style: {
                                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                                },
                                stopOnFocus: true
                            }).showToast();

                        } else {
                            throw new Error(deleteData.message);
                        }
                    }
                } catch (error) {
                    console.error('Error deleting record:', error);

                    // Show error message
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to delete record: ' + error.message,
                        icon: 'error',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                } finally {
                    // Reset deleting state
                    this.isDeleting = false;
                }
            }

            // ADD THIS METHOD TO YOUR BirthRecordsManager CLASS in birth.php
            refreshAllData() {
                // Show loading for both stats and table
                this.showInitialLoading();
                this.loadRecords();
            }

            // ADD THIS METHOD TO BirthRecordsManager CLASS
            handleDeleteError(error, recordId) {
                console.error('Delete error:', error);

                // Remove loading state from button
                const deleteBtn = document.querySelector(`.btn-delete[data-record-id="${recordId}"]`);
                if (deleteBtn) {
                    deleteBtn.classList.remove('loading');
                    deleteBtn.disabled = false;
                }

                // Show specific error messages based on error type
                let errorMessage = 'Failed to delete record. ';

                if (error.message.includes('foreign key constraint')) {
                    errorMessage += 'This record is referenced by other data and cannot be deleted.';
                } else if (error.message.includes('connection') || error.message.includes('network')) {
                    errorMessage += 'Network error. Please check your connection and try again.';
                } else {
                    errorMessage += error.message;
                }

                this.showError(errorMessage);
            }
        }

        // Initialize the birth records manager when page loads
        let birthManager;
        document.addEventListener('DOMContentLoaded', function() {
            birthManager = new BirthRecordsManager();

            // Initialize modal print button
            document.getElementById('modalPrintBtn').addEventListener('click', function() {
                birthManager.printModalRecord();
            });

            // Reset modal when closed
            document.getElementById('birthDetailsModal').addEventListener('hidden.bs.modal', function() {
                birthManager.resetModalState();
            });

            // Reset certificate modal when closed
            document.getElementById('birthCertificateModal').addEventListener('hidden.bs.modal', function() {
                birthManager.resetCertificateModalState();
            });
        });

        // Reset edit mode when modal is closed
        document.getElementById('addBirthModal').addEventListener('hidden.bs.modal', function() {
            const form = document.getElementById('birthCertForm');
            if (form && form.dataset.editId) {
                delete form.dataset.editId;
            }

            const modalTitle = document.querySelector('#addBirthModal .modal-title');
            if (modalTitle) {
                modalTitle.textContent = 'Add New Birth Record';
            }

            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn) {
                submitBtn.textContent = 'Save Record';
            }
        });
    </script>
</body>

</html>