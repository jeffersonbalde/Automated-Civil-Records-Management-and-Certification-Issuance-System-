<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marriage Records - Civil Registration System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="icon" type="image/png" href="../../assets/img/pagadian-logo.png" />
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

        .marriage-container {
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

        .marriage-card {
            background-color: #F8F9FC;
            /* border: 1px solid var(--border); */
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin: 20px;
        }

        .marriage-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 20px;
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
            /* border: 1px solid var(--border); */
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
            color: var(--info);
        }

        .stat-card:nth-child(2) .stat-number {
            color: var(--primary);
        }

        .stat-card:nth-child(3) .stat-number {
            color: var(--warning);
        }

        .stat-card:nth-child(4) .stat-number {
            color: var(--success);
        }

        .filter-section {
            background: white;
            /* border: 1px solid var(--border); */
            border-radius: 10px;
            padding: 20px;
            margin: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .table-container {
            /* border: 1px solid var(--border); */
            border-radius: 10px;
            overflow: hidden;
            margin: 20px;
            overflow-x: auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            font-size: 0.9rem;
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
            padding: 5px;
            vertical-align: middle;
            text-align: center;
            white-space: nowrap;
            /* border-bottom: 1px solid var(--border); */
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
            /* border: 1px solid var(--border); */
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
            .marriage-card {
                margin: 10px;
            }

            .marriage-header {
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

        #addMarriageModal .modal-body {
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

        /* Badge styles */
        .badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .bg-success {
            background-color: var(--success) !important;
        }

        .bg-warning {
            background-color: var(--warning) !important;
            color: #000;
        }

        .bg-secondary {
            background-color: var(--secondary) !important;
        }

        /* Button group styling */
        .btn-group {
            display: flex;
            gap: 2px;
        }

        .btn-group .btn-action {
            margin: 0;
        }

        /* Date Filter Styles */
        .date-filter-section .input-group-text {
            border-right: none;
            transition: all 0.3s ease;
        }

        .date-filter-section .form-control {
            border-left: none;
            transition: all 0.3s ease;
        }

        .date-filter-section .input-group:focus-within .input-group-text {
            background-color: var(--primary-light);
            border-color: var(--primary);
        }

        .date-filter-section .input-group:focus-within .form-control {
            border-color: var(--primary);
        }

        .date-filter-section .form-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .date-filter-section .form-text {
            font-size: 0.7rem;
            color: var(--light-text);
            margin-top: 2px;
        }

        /* Clear filter button */
        #clearDateFilters {
            font-size: 0.75rem;
            padding: 4px 8px;
            transition: all 0.3s ease;
        }

        #clearDateFilters:hover {
            background-color: var(--primary-light);
            border-color: var(--primary);
            color: var(--primary-dark);
        }

        /* Active date filter indicator */
        .date-filter-active {
            border-left: 3px solid var(--primary) !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .date-filter-section .col-md-6 {
                margin-bottom: 10px;
            }

            .date-filter-section .form-text {
                display: none;
            }
        }

        .stat-card:nth-child(1)::before {
            background: var(--info);
        }

        .stat-card:nth-child(2)::before {
            background: var(--primary);
        }

        .stat-card:nth-child(3)::before {
            background: var(--warning);
        }

        .stat-card:nth-child(4)::before {
            background: var(--success);
        }

        .table-custom tbody tr:nth-child(even) td {
            background-color: #f7f7f7 !important;
        }

        .table-custom tbody tr:hover td {
            background-color: #D2D2D2 !important;
            transition: background 0.2s ease-in-out;
        }

        /* Add this new rule for bold first column */
        .table-custom tbody tr td:first-child {
            font-weight: bold;
        }

        /* Horizontal button group styling for marriage table */
.btn-group.btn-group-sm {
    gap: 2px;
    flex-wrap: nowrap;
}

.btn-group .btn-action {
    margin: 0;
    padding: 4px 8px;
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 32px;
    height: 32px;
}

.btn-group .btn-action i {
    font-size: 0.8rem;
}

/* Ensure the action column has proper width for horizontal layout */
.table-custom th:nth-child(2),
.table-custom td:nth-child(2) {
    width: 160px;
    min-width: 160px;
    max-width: 160px;
    text-align: center;
}

/* Remove text labels from buttons to make them more compact */
.btn-group .btn-action {
    font-size: 0; /* Hide text */
}

.btn-group .btn-action i {
    font-size: 0.8rem; /* Show only icons */
}

/* Optional: Add tooltips for better UX */
.btn-action {
    position: relative;
}

/* .btn-action:hover::after {
    content: attr(title);
    position: absolute;
    bottom: -30px;
    left: 50%;
    transform: translateX(-50%);
    background: #333;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.7rem;
    white-space: nowrap;
    z-index: 1000;
} */
    </style>
</head>

<body>
    <div class="marriage-container">
        <!-- Sidebar -->
        <?php include '../../includes/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="marriage-card animate__animated animate__fadeIn">
                <!-- Header -->
                <div class="marriage-header d-flex justify-content-between align-items-center flex-wrap">
                    <div class="header-title">
                        <h2>Marriage Records Management</h2>
                        <p>Manage and track marriage certificate records</p>
                    </div>
                    <div class="header-actions">
                        <div class="search-box">
                            <input type="text" placeholder="Search by name or registration number..." id="recordSearch">
                            <i class="fas fa-search"></i>
                        </div>
                        <button class="action-btn" data-bs-toggle="modal" data-bs-target="#addMarriageModal">
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

                <!-- Enhanced Filter Section -->
                <div class="filter-section">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
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
                        <div class="col-md-5">
                            <div class="date-filter-section">
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-muted mb-1">
                                            <i class="fas fa-calendar-day me-1"></i>
                                            Marriage Date From
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-play text-primary"></i>
                                            </span>
                                            <input type="date" class="form-control" id="dateFrom"
                                                placeholder="Start date"
                                                title="Filter records from this marriage date">
                                        </div>
                                        <div class="form-text small">Start of marriage date range</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-muted mb-1">
                                            <i class="fas fa-calendar-day me-1"></i>
                                            Marriage Date To
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-flag text-primary"></i>
                                            </span>
                                            <input type="date" class="form-control" id="dateTo"
                                                placeholder="End date"
                                                title="Filter records up to this marriage date">
                                        </div>
                                        <div class="form-text small">End of marriage date range</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 text-end">
                            <div class="d-flex flex-column align-items-end">
                                <div class="text-muted mb-1">
                                    <small id="searchInfo">Showing all records</small>
                                </div>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="clearDateFilters"
                                    style="display: none;" title="Clear date filters">
                                    <i class="fas fa-times me-1"></i> Clear Dates
                                </button>
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
        <th>Action</th>
        <th>Registry No.</th>
        <th>Husband Name</th>
        <th>Wife Name</th>
        <th>Date of Marriage</th>
        <th>Place of Marriage</th>
        <th>Husband Age</th>
        <th>Wife Age</th>
        <th>Date Registered</th>
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
                    <p>No marriage records match your search criteria.</p>
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

    <!-- Include the Marriage Modal Component -->
    <?php include '../../components/marriage-modal.php'; ?>

    <?php include '../../components/marriage-details-modal.php'; ?>

    <?php include '../../components/marriage-certificate-modal.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.js"></script>
    <script src="../../assets/js/marriage.js"></script>
    <script src="../../assets/js/marriage-modal.js"></script>

    <script>
        class MarriageRecordsManager {
            constructor() {
                this.currentPage = 1;
                this.rowsPerPage = 10;
                this.searchTerm = '';
                this.isLoading = false;
                this.totalPages = 1;
                this.currentSort = 'newest'; // Default sort

                // Track modal state and pending requests
                this.isModalLoading = false;
                this.pendingEditRequest = null;
                this.currentEditId = null;

                // Track delete state to prevent multiple operations
                this.isDeleting = false;

                this.initializeEventListeners();
                this.initializePrintFunctionality(); // Add this line
                this.showInitialLoading();
                this.loadRecords();
            }

            // Add this method
            initializePrintFunctionality() {
                this.printMarriageDetails();
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

                // Date range filters with clear functionality
                const dateFrom = document.getElementById('dateFrom');
                const dateTo = document.getElementById('dateTo');
                const clearDateFilters = document.getElementById('clearDateFilters');

                if (dateFrom) {
                    dateFrom.addEventListener('change', () => {
                        this.currentPage = 1;
                        this.updateDateFilterIndicators();
                        this.loadRecords();
                    });
                }

                if (dateTo) {
                    dateTo.addEventListener('change', () => {
                        this.currentPage = 1;
                        this.updateDateFilterIndicators();
                        this.loadRecords();
                    });
                }

                if (clearDateFilters) {
                    clearDateFilters.addEventListener('click', () => {
                        this.clearDateFilters();
                    });
                }
            }

            // Update date filter indicators
            updateDateFilterIndicators() {
                const dateFrom = document.getElementById('dateFrom');
                const dateTo = document.getElementById('dateTo');
                const clearDateFilters = document.getElementById('clearDateFilters');
                const searchInfo = document.getElementById('searchInfo');

                const hasDateFilter = dateFrom.value || dateTo.value;

                // Show/hide clear button
                if (clearDateFilters) {
                    clearDateFilters.style.display = hasDateFilter ? 'inline-block' : 'none';
                }

                // Update search info with date range
                if (searchInfo) {
                    if (hasDateFilter) {
                        let dateInfo = '';
                        if (dateFrom.value && dateTo.value) {
                            dateInfo = ` from ${this.formatDisplayDate(dateFrom.value)} to ${this.formatDisplayDate(dateTo.value)}`;
                        } else if (dateFrom.value) {
                            dateInfo = ` from ${this.formatDisplayDate(dateFrom.value)}`;
                        } else if (dateTo.value) {
                            dateInfo = ` up to ${this.formatDisplayDate(dateTo.value)}`;
                        }

                        if (this.searchTerm) {
                            searchInfo.textContent = `Searching for: "${this.searchTerm}"${dateInfo}`;
                        } else {
                            searchInfo.textContent = `Showing records${dateInfo}`;
                        }
                    } else {
                        if (this.searchTerm) {
                            searchInfo.textContent = `Searching for: "${this.searchTerm}"`;
                        } else {
                            searchInfo.textContent = 'Showing all records';
                        }
                    }
                }

                // Add visual indicators for active filters
                if (dateFrom) {
                    if (dateFrom.value) {
                        dateFrom.parentElement.classList.add('date-filter-active');
                    } else {
                        dateFrom.parentElement.classList.remove('date-filter-active');
                    }
                }

                if (dateTo) {
                    if (dateTo.value) {
                        dateTo.parentElement.classList.add('date-filter-active');
                    } else {
                        dateTo.parentElement.classList.remove('date-filter-active');
                    }
                }
            }

            // Clear date filters
            clearDateFilters() {
                const dateFrom = document.getElementById('dateFrom');
                const dateTo = document.getElementById('dateTo');
                const clearDateFilters = document.getElementById('clearDateFilters');

                if (dateFrom) dateFrom.value = '';
                if (dateTo) dateTo.value = '';
                if (clearDateFilters) clearDateFilters.style.display = 'none';

                // Remove visual indicators
                if (dateFrom) dateFrom.parentElement.classList.remove('date-filter-active');
                if (dateTo) dateTo.parentElement.classList.remove('date-filter-active');

                this.currentPage = 1;
                this.updateSearchInfo();
                this.loadRecords();
            }

            // Helper method to format dates for display
            formatDisplayDate(dateString) {
                try {
                    return new Date(dateString).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                } catch (e) {
                    return dateString;
                }
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
                this.updateDateFilterIndicators(); // This will handle both search and date info
            }

            showInitialLoading() {
                // Show skeleton for stats
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
                    const dateFrom = document.getElementById('dateFrom')?.value || '';
                    const dateTo = document.getElementById('dateTo')?.value || '';

                    const params = new URLSearchParams({
                        search: this.searchTerm,
                        page: this.currentPage,
                        limit: this.rowsPerPage,
                        sort: this.currentSort,
                        date_from: dateFrom,
                        date_to: dateTo
                    });

                    const response = await fetch(`../../handlers/fetch-marriage-records.php?${params}`);

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
                const statsGrid = document.getElementById('statsGrid');
                if (statsGrid) {
                    statsGrid.classList.remove('loading');
                }
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

createTableRow(record, rowNumber) {
    const tr = document.createElement('tr');
    tr.id = `marriage-record-${record.marriage_id}`;

    // Store record data in data attributes for quick access
    tr.dataset.recordId = record.marriage_id;
    tr.dataset.husbandName = record.husband_full_name ? record.husband_full_name.replace(/\s+/g, ' ').trim() : '';
    tr.dataset.wifeName = record.wife_full_name ? record.wife_full_name.replace(/\s+/g, ' ').trim() : '';
    tr.dataset.regNumber = record.registry_number || '';

    // Calculate ages
    const husbandAge = record.husband_birthdate ? this.calculateAge(record.husband_birthdate) : 'N/A';
    const wifeAge = record.wife_birthdate ? this.calculateAge(record.wife_birthdate) : 'N/A';

    // Safely handle null values and clean up names
    const husbandName = record.husband_full_name ?
        record.husband_full_name.replace(/\s+/g, ' ').trim() : 'N/A';
    const wifeName = record.wife_full_name ?
        record.wife_full_name.replace(/\s+/g, ' ').trim() : 'N/A';

    tr.innerHTML = `
        <td>${rowNumber}</td>
        <td>
            <div class="btn-group btn-group-sm" role="group">
                <button class="btn-action btn-view" title="View Details" onclick="marriageManager.viewRecord(${record.marriage_id || 0})">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn-action btn-certificate" title="Generate Certificate" onclick="marriageManager.generateCertificate(${record.marriage_id || 0})">
                    <i class="fas fa-certificate"></i>
                </button>
                <button class="btn-action btn-edit" title="Edit" onclick="marriageManager.editRecord(${record.marriage_id || 0})">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn-action btn-delete" title="Delete" onclick="marriageManager.deleteRecord(${record.marriage_id || 0})" data-record-id="${record.marriage_id}">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
        <td>${record.registry_number || 'N/A'}</td>
        <td>${husbandName}</td>
        <td>${wifeName}</td>
        <td>${record.date_of_marriage ? this.formatDate(record.date_of_marriage) : 'N/A'}</td>
        <td>${record.place_of_marriage || 'N/A'}</td>
        <td>${husbandAge}</td>
        <td>${wifeAge}</td>
        <td>${record.date_registered ? this.formatDate(record.date_registered) : 'N/A'}</td>
    `;

    return tr;
}

            // Add this helper method to calculate age
            calculateAge(birthdate) {
                try {
                    const birthDate = new Date(birthdate);
                    const today = new Date();
                    let age = today.getFullYear() - birthDate.getFullYear();
                    const monthDiff = today.getMonth() - birthDate.getMonth();

                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }
                    return age;
                } catch (e) {
                    return 'N/A';
                }
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
                    this.openMarriageDetailsModal(id);
                } else {
                    this.showError('Invalid record ID');
                }
            }

            generateCertificate(id) {
                if (id && id > 0) {
                    this.openMarriageCertificateModal(id);
                } else {
                    this.showError('Invalid record ID');
                }
            }

            editRecord(id) {
                if (id && id > 0) {
                    console.log('Opening edit marriage modal for ID:', id);

                    // Cancel any previous pending request
                    if (this.pendingEditRequest) {
                        this.pendingEditRequest.abort();
                        this.pendingEditRequest = null;
                    }

                    const modalElement = document.getElementById('addMarriageModal');
                    if (!modalElement) {
                        console.error('Modal element not found');
                        this.showError('Modal not found');
                        return;
                    }

                    // Get or create Bootstrap modal instance
                    const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

                    // Reset form and set up for editing BEFORE showing modal
                    this.resetEditModalState();
                    this.setEditMode(id);

                    // Show loading state in modal BEFORE fetching data
                    this.showEditModalLoading(true);

                    // Update modal title immediately to show loading state
                    const modalTitle = document.querySelector('#addMarriageModal .modal-title');
                    if (modalTitle) {
                        modalTitle.textContent = 'Loading Record...';
                    }

                    // Show the modal FIRST so user sees loading state
                    modal.show();

                    // Then load the data asynchronously
                    this.loadRecordDataForEdit(id);

                } else {
                    this.showError('Invalid record ID');
                }
            }

            // Simple method to load record data for editing
            async loadRecordDataForEdit(marriageId) {
                try {
                    console.log('Loading record data for ID:', marriageId);
                    this.isModalLoading = true;

                    // Create abort controller for request cancellation
                    const abortController = new AbortController();
                    this.pendingEditRequest = abortController;

                    const response = await fetch(`../../handlers/fetch-marriage-details.php?marriage_id=${marriageId}`, {
                        signal: abortController.signal
                    });

                    // Clear pending request
                    this.pendingEditRequest = null;

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    console.log('Received data:', data);

                    if (data.success) {
                        // Update title to editing mode
                        const modalTitle = document.querySelector('#addMarriageModal .modal-title');
                        if (modalTitle) {
                            modalTitle.textContent = 'Edit Marriage Record';
                        }

                        this.populateEditForm(data.data);

                        // FIX: Initialize step indicators after populating form
                        this.initializeStepIndicatorsAfterEdit();

                        console.log('Form populated successfully');
                    } else {
                        throw new Error(data.message || 'Failed to load record data');
                    }
                } catch (error) {
                    // Only handle error if it's not an abort error
                    if (error.name !== 'AbortError') {
                        console.error('Error loading record for editing:', error);
                        this.showError('Failed to load record for editing: ' + error.message);

                        // Close modal on error
                        const modalElement = document.getElementById('addMarriageModal');
                        if (modalElement) {
                            const modal = bootstrap.Modal.getInstance(modalElement);
                            if (modal) {
                                modal.hide();
                            }
                        }
                    }
                } finally {
                    this.isModalLoading = false;
                    this.showEditModalLoading(false);
                }
            }

            // NEW METHOD: Initialize step indicators after editing
            initializeStepIndicatorsAfterEdit() {
                // Force update of step indicators
                if (typeof updateStepIndicators !== 'undefined') {
                    updateStepIndicators();
                }

                // Also manually mark all steps as completed for better UX in edit mode
                const steps = document.querySelectorAll('#marriageCertForm .step');
                steps.forEach(step => {
                    step.classList.add('completed');
                    step.classList.remove('incomplete', 'active');
                });

                // Set first step as active
                if (steps.length > 0) {
                    steps[0].classList.add('active');
                }

                // Ensure form steps are properly shown
                const formSteps = document.querySelectorAll('#marriageCertForm .form-step');
                formSteps.forEach((step, index) => {
                    if (index === 0) {
                        step.classList.add('active');
                    } else {
                        step.classList.remove('active');
                    }
                });

                // Reset navigation buttons to first step
                const prevBtn = document.getElementById('prevMarriageBtn');
                const nextBtn = document.getElementById('nextMarriageBtn');
                const submitBtn = document.getElementById('submitMarriageBtn');

                if (prevBtn) prevBtn.style.display = 'none';
                if (nextBtn) nextBtn.style.display = 'block';
                if (submitBtn) {
                    submitBtn.classList.add('d-none');
                }

                // Reset current step in the modal JS
                if (typeof currentStep !== 'undefined') {
                    currentStep = 0;
                }
            }

            showEditModalLoading(show) {
                const modalBody = document.querySelector('#addMarriageModal .modal-body');
                const form = document.getElementById('marriageCertForm');

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
                            <p class="text-muted">Loading marriage record details...</p>
                        </div>
                    `;
                        modalBody.appendChild(loadingOverlay);
                    }

                    loadingOverlay.style.display = 'flex';
                    if (form) form.style.opacity = '0.3';

                    // Disable form interactions during loading
                    if (form) {
                        form.querySelectorAll('input, select, textarea, button').forEach(element => {
                            element.disabled = true;
                        });
                    }

                } else {
                    const loadingOverlay = modalBody.querySelector('.modal-loading-overlay');
                    if (loadingOverlay) {
                        loadingOverlay.style.display = 'none';
                    }
                    if (form) {
                        form.style.opacity = '1';
                        // Re-enable form interactions
                        form.querySelectorAll('input, select, textarea, button').forEach(element => {
                            element.disabled = false;
                        });
                    }
                }
            }

            resetEditModalState() {
                const form = document.getElementById('marriageCertForm');
                if (form) {
                    form.reset();
                }

                // Clear any validation errors
                const errors = document.querySelectorAll('.invalid-feedback');
                errors.forEach(error => error.remove());

                const invalidFields = document.querySelectorAll('.is-invalid');
                invalidFields.forEach(field => field.classList.remove('is-invalid'));

                // Reset step indicators to first step - IMPROVED
                const steps = document.querySelectorAll('#marriageCertForm .form-step');
                const stepIndicators = document.querySelectorAll('#marriageCertForm .step');

                steps.forEach((step, index) => {
                    if (index === 0) {
                        step.classList.add('active');
                    } else {
                        step.classList.remove('active');
                    }
                });

                stepIndicators.forEach((step, index) => {
                    // Remove all classes first
                    step.classList.remove('active', 'completed', 'incomplete');

                    // Set first step as active only
                    if (index === 0) {
                        step.classList.add('active');
                    }
                });

                // Reset navigation buttons
                const prevBtn = document.getElementById('prevMarriageBtn');
                const nextBtn = document.getElementById('nextMarriageBtn');
                const submitBtn = document.getElementById('submitMarriageBtn');

                if (prevBtn) prevBtn.style.display = 'none';
                if (nextBtn) nextBtn.style.display = 'block';
                if (submitBtn) {
                    submitBtn.classList.add('d-none');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Save Marriage Record';
                }

                // Reset current step in the modal JS
                if (typeof currentStep !== 'undefined') {
                    currentStep = 0;
                }

                // Update step indicators if the function exists
                if (typeof updateStepIndicators !== 'undefined') {
                    updateStepIndicators();
                }
            }

            setEditMode(marriageId) {
                // Store the marriage ID for updating
                const form = document.getElementById('marriageCertForm');
                if (form) {
                    form.dataset.editId = marriageId;
                }

                // Change submit button text
                const submitBtn = document.getElementById('submitMarriageBtn');
                if (submitBtn) {
                    submitBtn.textContent = 'Update Marriage Record';
                }

                // Update modal title
                const modalTitle = document.querySelector('#addMarriageModal .modal-title');
                if (modalTitle) {
                    modalTitle.textContent = 'Edit Marriage Record';
                }
            }

            populateEditForm(data) {
                const marriage = data.marriage_record;

                // Basic Information
                this.setValue('date_of_marriage', this.formatDateForInput(marriage.date_of_marriage));
                this.setValue('time_of_marriage', marriage.time_of_marriage);
                this.setValue('province', marriage.province);
                this.setValue('city_municipality', marriage.city_municipality);
                this.setValue('place_of_marriage', marriage.place_of_marriage);
                this.setValue('marriage_type', marriage.marriage_type);
                this.setValue('license_number', marriage.license_number);
                this.setValue('license_date', this.formatDateForInput(marriage.license_date));
                this.setValue('license_place', marriage.license_place);
                this.setValue('property_regime', marriage.property_regime);

                // Husband's Information
                this.setValue('husband_first_name', marriage.husband_first_name);
                this.setValue('husband_middle_name', marriage.husband_middle_name);
                this.setValue('husband_last_name', marriage.husband_last_name);
                this.setValue('husband_birthdate', this.formatDateForInput(marriage.husband_birthdate));
                this.setValue('husband_birthplace', marriage.husband_birthplace);
                this.setValue('husband_sex', marriage.husband_sex);
                this.setValue('husband_citizenship', marriage.husband_citizenship);
                this.setValue('husband_religion', marriage.husband_religion);
                this.setValue('husband_civil_status', marriage.husband_civil_status);
                this.setValue('husband_occupation', marriage.husband_occupation);
                this.setValue('husband_address', marriage.husband_address);
                this.setValue('husband_father_name', marriage.husband_father_name);
                this.setValue('husband_father_citizenship', marriage.husband_father_citizenship);
                this.setValue('husband_mother_name', marriage.husband_mother_name);
                this.setValue('husband_mother_citizenship', marriage.husband_mother_citizenship);
                this.setValue('husband_consent_giver', marriage.husband_consent_giver);
                this.setValue('husband_consent_relationship', marriage.husband_consent_relationship);
                this.setValue('husband_consent_address', marriage.husband_consent_address);

                // Wife's Information
                this.setValue('wife_first_name', marriage.wife_first_name);
                this.setValue('wife_middle_name', marriage.wife_middle_name);
                this.setValue('wife_last_name', marriage.wife_last_name);
                this.setValue('wife_birthdate', this.formatDateForInput(marriage.wife_birthdate));
                this.setValue('wife_birthplace', marriage.wife_birthplace);
                this.setValue('wife_sex', marriage.wife_sex);
                this.setValue('wife_citizenship', marriage.wife_citizenship);
                this.setValue('wife_religion', marriage.wife_religion);
                this.setValue('wife_civil_status', marriage.wife_civil_status);
                this.setValue('wife_occupation', marriage.wife_occupation);
                this.setValue('wife_address', marriage.wife_address);
                this.setValue('wife_father_name', marriage.wife_father_name);
                this.setValue('wife_father_citizenship', marriage.wife_father_citizenship);
                this.setValue('wife_mother_name', marriage.wife_mother_name);
                this.setValue('wife_mother_citizenship', marriage.wife_mother_citizenship);
                this.setValue('wife_consent_giver', marriage.wife_consent_giver);
                this.setValue('wife_consent_relationship', marriage.wife_consent_relationship);
                this.setValue('wife_consent_address', marriage.wife_consent_address);

                // Marriage Details
                this.setValue('officiating_officer', marriage.officiating_officer);
                this.setValue('officiant_title', marriage.officiant_title);
                this.setValue('officiant_license', marriage.officiant_license);
                this.setValue('license_number_ceremony', marriage.license_number_ceremony);
                this.setValue('license_date_ceremony', this.formatDateForInput(marriage.license_date_ceremony));
                this.setValue('license_place_ceremony', marriage.license_place_ceremony);
                this.setValue('legal_basis', marriage.legal_basis);
                this.setValue('legal_basis_article', marriage.legal_basis_article);
                this.setValue('marriage_remarks', marriage.marriage_remarks);

                // Witness Information
                this.setValue('witness1_name', marriage.witness1_name);
                this.setValue('witness1_address', marriage.witness1_address);
                this.setValue('witness1_relationship', marriage.witness1_relationship);
                this.setValue('witness2_name', marriage.witness2_name);
                this.setValue('witness2_address', marriage.witness2_address);
                this.setValue('witness2_relationship', marriage.witness2_relationship);

                // SET CHECKBOXES AS CHECKED BY DEFAULT IN EDIT MODE
                const confirmAccuracyCheckbox = document.getElementById('confirmMarriageAccuracy');
                if (confirmAccuracyCheckbox) {
                    confirmAccuracyCheckbox.checked = true;
                }
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

            closeEditModal() {
                const modalElement = document.getElementById('addMarriageModal');
                if (modalElement) {
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) {
                        modal.hide();
                    }
                }

                // Cancel any pending request
                if (this.pendingEditRequest) {
                    this.pendingEditRequest.abort();
                    this.pendingEditRequest = null;
                }

                this.isModalLoading = false;
                this.currentEditId = null;

                // Reset the form completely
                this.resetEditModalState();
            }

            async deleteRecord(id) {
                if (!id || id <= 0) {
                    this.showError('Invalid record ID');
                    return;
                }

                if (this.isDeleting) {
                    console.log('Delete operation already in progress, skipping request');
                    return;
                }

                try {
                    this.isDeleting = true;

                    // Get basic record info from the table row
                    const row = document.querySelector(`#marriage-record-${id}`);
                    let recordInfo = 'this record';

                    if (row) {
                        const husbandCell = row.cells[2]; // Husband Name column
                        const wifeCell = row.cells[3]; // Wife Name column
                        const regNumberCell = row.cells[1]; // Registration Number column
                        const husbandName = husbandCell.textContent.trim();
                        const wifeName = wifeCell.textContent.trim();
                        const regNumber = regNumberCell.textContent.trim();

                        recordInfo = `${husbandName} & ${wifeName} (${regNumber !== 'N/A' ? regNumber : 'No Registry Number'})`;
                    }

                    // Show confirmation dialog
                    const result = await Swal.fire({
                        title: 'Delete Marriage Record',
                        html: `
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle text-warning mb-3" style="font-size: 3rem;"></i>
                        <h4 class="text-danger">Are you sure?</h4>
                        <p>You are about to delete the marriage record for:<br>
                        <strong>${recordInfo}</strong></p>
                        <p class="text-muted small">This action cannot be undone and will permanently remove all associated data.</p>
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
                        const deleteResponse = await fetch('../../handlers/delete-marriage-record.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                action: 'delete_marriage_record',
                                marriage_id: id
                            })
                        });

                        const deleteData = await deleteResponse.json();

                        // Close loading state
                        Swal.close();

                        if (deleteData.success) {
                            // Show success message
                            await Swal.fire({
                                title: 'Deleted!',
                                text: 'Marriage record has been deleted successfully.',
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
                                text: 'Marriage record deleted successfully!',
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

            refreshAllData() {
                // Show loading for both stats and table
                this.showInitialLoading();
                this.loadRecords();
            }

            async openMarriageDetailsModal(marriageId) {
                try {
                    // Show modal and loading state
                    const modal = new bootstrap.Modal(document.getElementById('marriageDetailsModal'));
                    this.resetMarriageModalState();
                    modal.show();

                    // Fetch record details
                    const response = await fetch(`../../handlers/fetch-marriage-details.php?marriage_id=${marriageId}`);
                    const data = await response.json();

                    if (data.success) {
                        this.displayMarriageModalRecordDetails(data.data);
                    } else {
                        this.showMarriageModalError(data.message);
                    }
                } catch (error) {
                    console.error('Error loading marriage details:', error);
                    this.showMarriageModalError('Failed to load marriage details');
                }
            }

            resetMarriageModalState() {
                document.getElementById('marriageModalLoadingState').style.display = 'block';
                document.getElementById('marriageModalRecordDetails').style.display = 'none';
                document.getElementById('marriageModalErrorState').style.display = 'none';
            }

            displayMarriageModalRecordDetails(data) {
                const marriage = data.marriage_record;

                // Hide loading, show details
                document.getElementById('marriageModalLoadingState').style.display = 'none';
                document.getElementById('marriageModalRecordDetails').style.display = 'block';

                // Basic Information
                document.getElementById('marriageModalRegistryNumber').textContent = marriage.registry_number || 'N/A';
                document.getElementById('marriageModalDate').textContent = this.formatDate(marriage.date_of_marriage);
                document.getElementById('marriageModalTime').textContent = this.formatTime(marriage.time_of_marriage);
                document.getElementById('marriageModalPlace').textContent = marriage.place_of_marriage || 'N/A';
                document.getElementById('marriageModalType').textContent = marriage.marriage_type || 'N/A';
                document.getElementById('marriageModalPropertyRegime').textContent = marriage.property_regime || 'N/A';

                // Husband Information
                document.getElementById('marriageModalHusbandName').textContent = this.formatFullName(
                    marriage.husband_first_name,
                    marriage.husband_middle_name,
                    marriage.husband_last_name
                );
                document.getElementById('marriageModalHusbandBirthdate').textContent = this.formatDate(marriage.husband_birthdate);
                document.getElementById('marriageModalHusbandBirthplace').textContent = marriage.husband_birthplace || 'N/A';
                document.getElementById('marriageModalHusbandCitizenship').textContent = marriage.husband_citizenship || 'N/A';
                document.getElementById('marriageModalHusbandReligion').textContent = marriage.husband_religion || 'N/A';
                document.getElementById('marriageModalHusbandCivilStatus').textContent = marriage.husband_civil_status || 'N/A';
                document.getElementById('marriageModalHusbandOccupation').textContent = marriage.husband_occupation || 'N/A';
                document.getElementById('marriageModalHusbandAddress').textContent = marriage.husband_address || 'N/A';

                // Wife Information
                document.getElementById('marriageModalWifeName').textContent = this.formatFullName(
                    marriage.wife_first_name,
                    marriage.wife_middle_name,
                    marriage.wife_last_name
                );
                document.getElementById('marriageModalWifeBirthdate').textContent = this.formatDate(marriage.wife_birthdate);
                document.getElementById('marriageModalWifeBirthplace').textContent = marriage.wife_birthplace || 'N/A';
                document.getElementById('marriageModalWifeCitizenship').textContent = marriage.wife_citizenship || 'N/A';
                document.getElementById('marriageModalWifeReligion').textContent = marriage.wife_religion || 'N/A';
                document.getElementById('marriageModalWifeCivilStatus').textContent = marriage.wife_civil_status || 'N/A';
                document.getElementById('marriageModalWifeOccupation').textContent = marriage.wife_occupation || 'N/A';
                document.getElementById('marriageModalWifeAddress').textContent = marriage.wife_address || 'N/A';

                // Parents Information
                document.getElementById('marriageModalHusbandFather').textContent = marriage.husband_father_name || 'N/A';
                document.getElementById('marriageModalHusbandMother').textContent = marriage.husband_mother_name || 'N/A';
                document.getElementById('marriageModalWifeFather').textContent = marriage.wife_father_name || 'N/A';
                document.getElementById('marriageModalWifeMother').textContent = marriage.wife_mother_name || 'N/A';

                // Ceremony Details
                document.getElementById('marriageModalOfficiatingOfficer').textContent = marriage.officiating_officer || 'N/A';
                document.getElementById('marriageModalWitness1').textContent = marriage.witness1_name || 'N/A';
                document.getElementById('marriageModalWitness2').textContent = marriage.witness2_name || 'N/A';

                // Registration Information
                document.getElementById('marriageModalDateRegistered').textContent = this.formatDateTime(marriage.date_registered);
                document.getElementById('marriageModalRecordId').textContent = marriage.marriage_id || 'N/A';
            }

            showMarriageModalError(message) {
                document.getElementById('marriageModalLoadingState').style.display = 'none';
                document.getElementById('marriageModalErrorState').style.display = 'block';
                document.getElementById('marriageModalErrorMessage').textContent = message;
            }

            // Helper methods
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

            // Placeholder methods for other modals
            openMarriageCertificateModal(id) {
                if (id && id > 0) {
                    console.log('Opening marriage certificate for ID:', id);
                    // Implementation for certificate generation
                } else {
                    this.showError('Invalid record ID');
                }
            }

            openEditMarriageModal(id) {
                if (id && id > 0) {
                    console.log('Opening edit marriage modal for ID:', id);
                    // Implementation similar to birth modal edit functionality
                } else {
                    this.showError('Invalid record ID');
                }
            }

            // Add this method to your MarriageRecordsManager class
            printMarriageDetails() {
                const printBtn = document.getElementById('marriageModalPrintBtn');
                if (printBtn) {
                    printBtn.onclick = () => {
                        this.handlePrintMarriageDetails();
                    };
                }
            }

            handlePrintMarriageDetails() {
                try {
                    // Get the modal content
                    const modalContent = document.getElementById('marriageModalRecordDetails');

                    if (!modalContent || modalContent.style.display === 'none') {
                        this.showError('No record details available to print');
                        return;
                    }

                    // Create a new window for printing
                    const printWindow = window.open('', '_blank');
                    if (!printWindow) {
                        this.showError('Please allow pop-ups for printing');
                        return;
                    }

                    // Get the current record data for printing
                    const recordData = this.getCurrentRecordDataForPrint();

                    // Generate print-friendly HTML
                    const printHTML = this.generatePrintHTML(recordData);

                    printWindow.document.write(printHTML);
                    printWindow.document.close();

                    // Wait for content to load before printing
                    printWindow.onload = () => {
                        printWindow.focus();
                        printWindow.print();
                        // Don't close immediately - let user decide to close after printing
                    };

                } catch (error) {
                    console.error('Error printing marriage details:', error);
                    this.showError('Failed to print record details');
                }
            }

            getCurrentRecordDataForPrint() {
                // Extract data from the currently displayed modal
                return {
                    registryNumber: document.getElementById('marriageModalRegistryNumber')?.textContent || 'N/A',
                    dateOfMarriage: document.getElementById('marriageModalDate')?.textContent || 'N/A',
                    timeOfMarriage: document.getElementById('marriageModalTime')?.textContent || 'N/A',
                    placeOfMarriage: document.getElementById('marriageModalPlace')?.textContent || 'N/A',
                    marriageType: document.getElementById('marriageModalType')?.textContent || 'N/A',
                    propertyRegime: document.getElementById('marriageModalPropertyRegime')?.textContent || 'N/A',
                    dateRegistered: document.getElementById('marriageModalDateRegistered')?.textContent || 'N/A',
                    recordId: document.getElementById('marriageModalRecordId')?.textContent || 'N/A',

                    // Husband information
                    husbandName: document.getElementById('marriageModalHusbandName')?.textContent || 'N/A',
                    husbandBirthdate: document.getElementById('marriageModalHusbandBirthdate')?.textContent || 'N/A',
                    husbandBirthplace: document.getElementById('marriageModalHusbandBirthplace')?.textContent || 'N/A',
                    husbandCitizenship: document.getElementById('marriageModalHusbandCitizenship')?.textContent || 'N/A',
                    husbandReligion: document.getElementById('marriageModalHusbandReligion')?.textContent || 'N/A',
                    husbandCivilStatus: document.getElementById('marriageModalHusbandCivilStatus')?.textContent || 'N/A',
                    husbandOccupation: document.getElementById('marriageModalHusbandOccupation')?.textContent || 'N/A',
                    husbandAddress: document.getElementById('marriageModalHusbandAddress')?.textContent || 'N/A',

                    // Wife information
                    wifeName: document.getElementById('marriageModalWifeName')?.textContent || 'N/A',
                    wifeBirthdate: document.getElementById('marriageModalWifeBirthdate')?.textContent || 'N/A',
                    wifeBirthplace: document.getElementById('marriageModalWifeBirthplace')?.textContent || 'N/A',
                    wifeCitizenship: document.getElementById('marriageModalWifeCitizenship')?.textContent || 'N/A',
                    wifeReligion: document.getElementById('marriageModalWifeReligion')?.textContent || 'N/A',
                    wifeCivilStatus: document.getElementById('marriageModalWifeCivilStatus')?.textContent || 'N/A',
                    wifeOccupation: document.getElementById('marriageModalWifeOccupation')?.textContent || 'N/A',
                    wifeAddress: document.getElementById('marriageModalWifeAddress')?.textContent || 'N/A',

                    // Parents information
                    husbandFather: document.getElementById('marriageModalHusbandFather')?.textContent || 'N/A',
                    husbandMother: document.getElementById('marriageModalHusbandMother')?.textContent || 'N/A',
                    wifeFather: document.getElementById('marriageModalWifeFather')?.textContent || 'N/A',
                    wifeMother: document.getElementById('marriageModalWifeMother')?.textContent || 'N/A',

                    // Ceremony details
                    officiatingOfficer: document.getElementById('marriageModalOfficiatingOfficer')?.textContent || 'N/A',
                    witness1: document.getElementById('marriageModalWitness1')?.textContent || 'N/A',
                    witness2: document.getElementById('marriageModalWitness2')?.textContent || 'N/A'
                };
            }

            generatePrintHTML(data) {
                const currentDate = new Date().toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                return `
<!DOCTYPE html>
<html>
<head>
    <title>Marriage Record Details - ${data.registryNumber}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .header .subtitle {
            color: #7f8c8d;
            font-size: 16px;
        }
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .section-title {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-left: 4px solid #3498db;
            margin-bottom: 15px;
            font-weight: bold;
            color: #2c3e50;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }
        .col-md-6 {
            flex: 0 0 50%;
            padding: 0 10px;
            box-sizing: border-box;
        }
        .detail-item {
            margin-bottom: 8px;
            padding: 5px 0;
        }
        .detail-item strong {
            color: #2c3e50;
            min-width: 150px;
            display: inline-block;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #7f8c8d;
            font-size: 12px;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
            .section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>MARRIAGE RECORD DETAILS</h1>
        <div class="subtitle">Civil Registration System</div>
        <div class="subtitle">Printed on: ${currentDate}</div>
    </div>

    <div class="section">
        <div class="section-title">BASIC INFORMATION</div>
        <div class="row">
            <div class="col-md-6">
                <div class="detail-item"><strong>Registry Number:</strong> ${data.registryNumber}</div>
                <div class="detail-item"><strong>Date of Marriage:</strong> ${data.dateOfMarriage}</div>
                <div class="detail-item"><strong>Time of Marriage:</strong> ${data.timeOfMarriage}</div>
            </div>
            <div class="col-md-6">
                <div class="detail-item"><strong>Place of Marriage:</strong> ${data.placeOfMarriage}</div>
                <div class="detail-item"><strong>Type of Marriage:</strong> ${data.marriageType}</div>
                <div class="detail-item"><strong>Property Regime:</strong> ${data.propertyRegime}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">REGISTRATION INFORMATION</div>
        <div class="detail-item"><strong>Date Registered:</strong> ${data.dateRegistered}</div>
        <div class="detail-item"><strong>Record ID:</strong> ${data.recordId}</div>
    </div>

    <div class="section">
        <div class="section-title">HUSBAND'S INFORMATION</div>
        <div class="row">
            <div class="col-md-6">
                <div class="detail-item"><strong>Full Name:</strong> ${data.husbandName}</div>
                <div class="detail-item"><strong>Date of Birth:</strong> ${data.husbandBirthdate}</div>
                <div class="detail-item"><strong>Place of Birth:</strong> ${data.husbandBirthplace}</div>
                <div class="detail-item"><strong>Citizenship:</strong> ${data.husbandCitizenship}</div>
            </div>
            <div class="col-md-6">
                <div class="detail-item"><strong>Religion:</strong> ${data.husbandReligion}</div>
                <div class="detail-item"><strong>Civil Status:</strong> ${data.husbandCivilStatus}</div>
                <div class="detail-item"><strong>Occupation:</strong> ${data.husbandOccupation}</div>
                <div class="detail-item"><strong>Address:</strong> ${data.husbandAddress}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">WIFE'S INFORMATION</div>
        <div class="row">
            <div class="col-md-6">
                <div class="detail-item"><strong>Full Name:</strong> ${data.wifeName}</div>
                <div class="detail-item"><strong>Date of Birth:</strong> ${data.wifeBirthdate}</div>
                <div class="detail-item"><strong>Place of Birth:</strong> ${data.wifeBirthplace}</div>
                <div class="detail-item"><strong>Citizenship:</strong> ${data.wifeCitizenship}</div>
            </div>
            <div class="col-md-6">
                <div class="detail-item"><strong>Religion:</strong> ${data.wifeReligion}</div>
                <div class="detail-item"><strong>Civil Status:</strong> ${data.wifeCivilStatus}</div>
                <div class="detail-item"><strong>Occupation:</strong> ${data.wifeOccupation}</div>
                <div class="detail-item"><strong>Address:</strong> ${data.wifeAddress}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">PARENTS INFORMATION</div>
        <div class="row">
            <div class="col-md-6">
                <div class="section-title" style="font-size: 14px; margin-bottom: 10px;">HUSBAND'S PARENTS</div>
                <div class="detail-item"><strong>Father's Name:</strong> ${data.husbandFather}</div>
                <div class="detail-item"><strong>Mother's Name:</strong> ${data.husbandMother}</div>
            </div>
            <div class="col-md-6">
                <div class="section-title" style="font-size: 14px; margin-bottom: 10px;">WIFE'S PARENTS</div>
                <div class="detail-item"><strong>Father's Name:</strong> ${data.wifeFather}</div>
                <div class="detail-item"><strong>Mother's Name:</strong> ${data.wifeMother}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">CEREMONY DETAILS</div>
        <div class="detail-item"><strong>Officiating Officer:</strong> ${data.officiatingOfficer}</div>
        <div class="detail-item"><strong>Witness 1:</strong> ${data.witness1}</div>
        <div class="detail-item"><strong>Witness 2:</strong> ${data.witness2}</div>
    </div>

    <div class="footer">
        <p>This is a computer-generated document. No signature is required.</p>
        <p>Pagadian City Civil Registry Office</p>
    </div>
</body>
</html>`;
            }

            // ============ CERTIFICATE GENERATION METHODS ============

            async generateCertificate(id) {
                if (id && id > 0) {
                    try {
                        // Show loading state
                        Swal.fire({
                            title: 'Generating Certificate',
                            text: 'Please wait while we generate the marriage certificate...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Fetch marriage record data
                        const response = await fetch(`../../handlers/fetch-marriage-details.php?marriage_id=${id}`);
                        const data = await response.json();

                        if (data.success) {
                            Swal.close();
                            this.displayCertificate(data.data);
                        } else {
                            throw new Error(data.message || 'Failed to load certificate data');
                        }
                    } catch (error) {
                        console.error('Error generating certificate:', error);
                        Swal.close();
                        this.showError('Failed to generate certificate: ' + error.message);
                    }
                } else {
                    this.showError('Invalid record ID');
                }
            }

            // Method to display the certificate
            displayCertificate(data) {
                const marriage = data.marriage_record;

                // Create certificate window
                const certificateWindow = window.open('', '_blank', 'width=1000,height=1200,scrollbars=yes');

                if (!certificateWindow) {
                    this.showError('Please allow pop-ups to view the certificate');
                    return;
                }

                // Generate certificate HTML based on the template
                const certificateHTML = this.generateCertificateHTML(marriage);

                certificateWindow.document.write(certificateHTML);
                certificateWindow.document.close();

                // Add print functionality
                certificateWindow.focus();
            } // <-- This closes the generateCertificateHTML method


            generateCertificateHTML(marriage) {
                // Format dates properly
                const marriageDate = marriage.date_of_marriage ? new Date(marriage.date_of_marriage) : new Date();
                const husbandBirthdate = marriage.husband_birthdate ? new Date(marriage.husband_birthdate) : null;
                const wifeBirthdate = marriage.wife_birthdate ? new Date(marriage.wife_birthdate) : null;

                // Calculate ages
                const husbandAge = husbandBirthdate ? this.calculateAge(husbandBirthdate) : '';
                const wifeAge = wifeBirthdate ? this.calculateAge(wifeBirthdate) : '';

                return `
<!DOCTYPE html>
<html>
<head>
    <title>Certificate of Marriage - ${marriage.registry_number || 'N/A'}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 20px;
            background: white;
            color: black;
            line-height: 1.4;
        }
        .certificate-container {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #000;
            padding: 30px;
            position: relative;
        }
        .certificate-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }
        .certificate-header h1 {
            font-size: 24px;
            font-weight: bold;
            margin: 0 0 10px 0;
            text-transform: uppercase;
        }
        .certificate-header h2 {
            font-size: 18px;
            font-weight: normal;
            margin: 0;
        }
        .form-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .form-table td {
            padding: 8px;
            vertical-align: top;
            border: 1px solid #000;
        }
        .form-table th {
            padding: 8px;
            border: 1px solid #000;
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: left;
        }
        .section-title {
            font-weight: bold;
            background-color: #f0f0f0;
            padding: 5px;
            margin: 20px 0 10px 0;
            border: 1px solid #000;
        }
        .signature-section {
            margin-top: 40px;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 40px;
            padding-top: 5px;
            text-align: center;
        }
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            z-index: 1000;
        }
        .print-button:hover {
            background: #0056b3;
        }
        @media print {
            .print-button {
                display: none;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">Print Certificate</button>
    
    <div class="certificate-container">
        <div class="certificate-header">
            <h1>Certificate of Marriage</h1>
            <h2>Republic of the Philippines</h2>
        </div>

        <table class="form-table">
            <tr>
                <td style="width: 50%"><strong>Province:</strong> ${marriage.province || ''}</td>
                <td style="width: 50%"><strong>Registry No:</strong> ${marriage.registry_number || ''}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>City/Municipality:</strong> ${marriage.city_municipality || ''}</td>
            </tr>
        </table>

        <!-- Contracting Parties Section -->
        <div class="section-title">1. NAME OF CONTRACTING PARTIES</div>
        <table class="form-table">
            <tr>
                <th style="width: 50%">HUSBAND</th>
                <th style="width: 50%">WIFE</th>
            </tr>
            <tr>
                <td>
                    <strong>First:</strong> ${marriage.husband_first_name || ''}<br>
                    <strong>Middle:</strong> ${marriage.husband_middle_name || ''}<br>
                    <strong>Last:</strong> ${marriage.husband_last_name || ''}
                </td>
                <td>
                    <strong>First:</strong> ${marriage.wife_first_name || ''}<br>
                    <strong>Middle:</strong> ${marriage.wife_middle_name || ''}<br>
                    <strong>Last:</strong> ${marriage.wife_last_name || ''}
                </td>
            </tr>
        </table>

        <!-- Date of Birth and Age -->
        <div class="section-title">2. DATE OF BIRTH AND AGE</div>
        <table class="form-table">
            <tr>
                <td style="width: 50%">
                    <strong>Husband:</strong><br>
                    Date of Birth: ${husbandBirthdate ? husbandBirthdate.toLocaleDateString() : ''}<br>
                    Age: ${husbandAge}
                </td>
                <td style="width: 50%">
                    <strong>Wife:</strong><br>
                    Date of Birth: ${wifeBirthdate ? wifeBirthdate.toLocaleDateString() : ''}<br>
                    Age: ${wifeAge}
                </td>
            </tr>
        </table>

        <!-- Place of Birth -->
        <div class="section-title">3. PLACE OF BIRTH</div>
        <table class="form-table">
            <tr>
                <td style="width: 50%">
                    <strong>Husband:</strong><br>
                    ${marriage.husband_birthplace || ''}
                </td>
                <td style="width: 50%">
                    <strong>Wife:</strong><br>
                    ${marriage.wife_birthplace || ''}
                </td>
            </tr>
        </table>

        <!-- Sex and Citizenship -->
        <div class="section-title">4. SEX AND CITIZENSHIP</div>
        <table class="form-table">
            <tr>
                <td style="width: 50%">
                    <strong>Sex:</strong> ${marriage.husband_sex || ''}<br>
                    <strong>Citizenship:</strong> ${marriage.husband_citizenship || ''}
                </td>
                <td style="width: 50%">
                    <strong>Sex:</strong> ${marriage.wife_sex || ''}<br>
                    <strong>Citizenship:</strong> ${marriage.wife_citizenship || ''}
                </td>
            </tr>
        </table>

        <!-- Residence -->
        <div class="section-title">5. RESIDENCE</div>
        <table class="form-table">
            <tr>
                <td style="width: 50%">${marriage.husband_address || ''}</td>
                <td style="width: 50%">${marriage.wife_address || ''}</td>
            </tr>
        </table>

        <!-- Religion and Civil Status -->
        <div class="section-title">6. RELIGION / RELIGIOUS SECT</div>
        <table class="form-table">
            <tr>
                <td style="width: 50%">${marriage.husband_religion || ''}</td>
                <td style="width: 50%">${marriage.wife_religion || ''}</td>
            </tr>
        </table>

        <div class="section-title">7. CIVIL STATUS</div>
        <table class="form-table">
            <tr>
                <td style="width: 50%">${marriage.husband_civil_status || ''}</td>
                <td style="width: 50%">${marriage.wife_civil_status || ''}</td>
            </tr>
        </table>

        <!-- Parents Information -->
        <div class="section-title">8. NAME OF FATHER</div>
        <table class="form-table">
            <tr>
                <td style="width: 50%">${marriage.husband_father_name || ''}</td>
                <td style="width: 50%">${marriage.wife_father_name || ''}</td>
            </tr>
        </table>

        <div class="section-title">10. MAIDEN NAME OF MOTHER</div>
        <table class="form-table">
            <tr>
                <td style="width: 50%">${marriage.husband_mother_name || ''}</td>
                <td style="width: 50%">${marriage.wife_mother_name || ''}</td>
            </tr>
        </table>

        <!-- Place and Date of Marriage -->
        <div class="section-title">15. PLACE OF MARRIAGE</div>
        <table class="form-table">
            <tr>
                <td colspan="2">${marriage.place_of_marriage || ''}</td>
            </tr>
        </table>

        <div class="section-title">16. DATE OF MARRIAGE & 17. TIME OF MARRIAGE</div>
        <table class="form-table">
            <tr>
                <td style="width: 50%">
                    <strong>Date:</strong> ${marriageDate.toLocaleDateString()}
                </td>
                <td style="width: 50%">
                    <strong>Time:</strong> ${marriage.time_of_marriage || ''}
                </td>
            </tr>
        </table>

        <!-- Certification Sections -->
        <div class="section-title">18. CERTIFICATION OF THE CONTRACTING PARTIES</div>
        <div style="margin-bottom: 20px; padding: 10px; border: 1px solid #000;">
            THIS IS TO CERTIFY: That I, <strong>${marriage.husband_first_name || ''} ${marriage.husband_last_name || ''}</strong> 
            and I, <strong>${marriage.wife_first_name || ''} ${marriage.wife_last_name || ''}</strong>, both of legal age, 
            of our own free will and accord, and in the presence of the person solemnizing this marriage and of the witnesses named below, 
            take each other as husband and wife...
        </div>

        <div class="signature-section">
            <div style="float: left; width: 45%;">
                <div class="signature-line">
                    Signature of Husband
                </div>
            </div>
            <div style="float: right; width: 45%;">
                <div class="signature-line">
                    Signature of Wife
                </div>
            </div>
            <div style="clear: both;"></div>
        </div>

        <!-- Solemnizing Officer Section -->
        <div class="section-title">19. CERTIFICATION OF THE SOLEMNIZING OFFICER</div>
        <div style="margin-bottom: 20px; padding: 10px; border: 1px solid #000;">
            THIS IS TO CERTIFY: THAT BEFORE ME, on the date and place above-written, personally appeared the above-mentioned parties, 
            with their mutual consent, lawfully joined together in marriage which was solemnized by me in the presence of the witnesses named below, all of legal age.
        </div>

        <!-- Witnesses -->
        <div class="section-title">20. WITNESSES</div>
        <table class="form-table">
            <tr>
                <td style="width: 50%">
                    <strong>Name:</strong> ${marriage.witness1_name || ''}<br>
                    <strong>Address:</strong> ${marriage.witness1_address || ''}
                </td>
                <td style="width: 50%">
                    <strong>Name:</strong> ${marriage.witness2_name || ''}<br>
                    <strong>Address:</strong> ${marriage.witness2_address || ''}
                </td>
            </tr>
        </table>

        <!-- Receiving and Registration -->
        <div class="signature-section">
            <div style="float: left; width: 45%;">
                <div class="signature-line">
                    Received By<br>
                    <small>Signature over Printed Name</small>
                </div>
            </div>
            <div style="float: right; width: 45%;">
                <div class="signature-line">
                    Registered By Civil Registrar<br>
                    <small>Signature over Printed Name</small>
                </div>
            </div>
            <div style="clear: both;"></div>
        </div>

    </div>

</body>

</html>`;
            } // <-- This closes the generateCertificateHTML method
        } // <-- This closes the MarriageRecordsManager class

        // Initialize the marriage records manager when page loads
        let marriageManager;
        document.addEventListener('DOMContentLoaded', function() {
            marriageManager = new MarriageRecordsManager();
        });
    </script>
</body>

</html>