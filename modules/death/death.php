<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Death Records - Civil Registration System</title>
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

        .death-container {
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

        .death-card {
            background-color: #F8F9FC;
            /* border: 1px solid var(--border); */
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin: 20px;
        }

        .death-header {
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
            .death-card {
                margin: 10px;
            }

            .death-header {
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

        #addDeathModal .modal-body {
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

        /* Horizontal button group styling for death table */
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
    <div class="death-container">
        <!-- Sidebar -->
        <?php include '../../includes/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="death-card animate__animated animate__fadeIn">
                <!-- Header -->
                <div class="death-header d-flex justify-content-between align-items-center flex-wrap">
                    <div class="header-title">
                        <h2>Death Records Management</h2>
                        <p>Manage and track death certificate records</p>
                    </div>
                    <div class="header-actions">
                        <div class="search-box">
                            <input type="text" placeholder="Search by name or registration number..." id="recordSearch">
                            <i class="fas fa-search"></i>
                        </div>
                        <button class="action-btn" data-bs-toggle="modal" data-bs-target="#addDeathModal">
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
                                            Death Date From
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-play text-primary"></i>
                                            </span>
                                            <input type="date" class="form-control" id="dateFrom"
                                                placeholder="Start date"
                                                title="Filter records from this death date">
                                        </div>
                                        <div class="form-text small">Start of death date range</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-muted mb-1">
                                            <i class="fas fa-calendar-day me-1"></i>
                                            Death Date To
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-flag text-primary"></i>
                                            </span>
                                            <input type="date" class="form-control" id="dateTo"
                                                placeholder="End date"
                                                title="Filter records up to this death date">
                                        </div>
                                        <div class="form-text small">End of death date range</div>
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

                <!-- Loading Indicator -->
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
        <th>Deceased Name</th>
        <th>Sex</th>
        <th>Date of Death</th>
        <th>Date of Birth</th>
        <th>Age</th>
        <th>Place of Death</th>
        <th>Civil Status</th>
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
                    <p>No death records match your search criteria.</p>
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

    <!-- Include the Death Modal Component -->
    <?php include '../../components/death-modal.php'; ?>

    <!-- Include the Death Details Modal Component -->
    <?php include '../../components/death-details-modal.php'; ?>

    <?php include '../../components/death-certificate-modal.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.js"></script>
    <script src="../../assets/js/death.js"></script>
    <script src="../../assets/js/death-modal.js"></script>

    <script>
        class DeathRecordsManager {
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
                this.initializePrintFunctionality();
                this.showInitialLoading();
                this.loadRecords();
            }

            initializePrintFunctionality() {
                this.printDeathDetails();
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
                document.querySelectorAll('.sort-btn').forEach(btn => {
                    btn.classList.toggle('active', btn.dataset.sort === sortType);
                });

                this.currentSort = sortType;
                this.currentPage = 1;
                this.loadRecords();
            }

            updateSearchInfo() {
                this.updateDateFilterIndicators();
            }

            showInitialLoading() {
                const statNumbers = document.querySelectorAll('.stat-number');
                const skeletonNumbers = document.querySelectorAll('.skeleton-number');

                statNumbers.forEach(el => {
                    el.style.display = 'none';
                });
                skeletonNumbers.forEach(el => {
                    el.style.display = 'block';
                });

                this.showTableLoading();

                const statsGrid = document.getElementById('statsGrid');
                if (statsGrid) {
                    statsGrid.classList.add('loading');

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

                    const response = await fetch(`../../handlers/fetch-death-records.php?${params}`);

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

                document.querySelectorAll('.stat-card').forEach(card => {
                    card.classList.add('animated');
                });

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
    tr.id = `death-record-${record.death_id}`;

    tr.dataset.recordId = record.death_id;
    tr.dataset.deceasedName = record.first_name && record.last_name ?
        `${record.first_name} ${record.middle_name || ''} ${record.last_name}`.replace(/\s+/g, ' ').trim() : '';
    tr.dataset.regNumber = record.registry_number || '';

    const deceasedName = record.first_name && record.last_name ?
        `${record.first_name} ${record.middle_name || ''} ${record.last_name}`.replace(/\s+/g, ' ').trim() : 'N/A';

    const age = this.calculateAge(record.date_of_birth, record.date_of_death);

    tr.innerHTML = `
        <td>${rowNumber}</td>
        <td>
            <div class="btn-group btn-group-sm" role="group">
                <button class="btn-action btn-view" title="View Details" onclick="deathManager.viewRecord(${record.death_id || 0})">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn-action btn-certificate" title="Generate Certificate" onclick="deathManager.generateCertificate(${record.death_id || 0})">
                    <i class="fas fa-certificate"></i>
                </button>
                <button class="btn-action btn-edit" title="Edit" onclick="deathManager.editRecord(${record.death_id || 0})">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn-action btn-delete" title="Delete" onclick="deathManager.deleteRecord(${record.death_id || 0})" data-record-id="${record.death_id}">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
        <td>${record.registry_number || 'N/A'}</td>
        <td>${deceasedName}</td>
        <td>${record.sex || 'N/A'}</td>
        <td>${record.date_of_death ? this.formatDate(record.date_of_death) : 'N/A'}</td>
        <td>${record.date_of_birth ? this.formatDate(record.date_of_birth) : 'N/A'}</td>
        <td>${age}</td>
        <td>${record.place_of_death || 'N/A'}</td>
        <td>${record.civil_status || 'N/A'}</td>
        <td>${record.date_registered ? this.formatDate(record.date_registered) : 'N/A'}</td>
    `;

    return tr;
}

            calculateAge(birthdate, deathdate) {
                try {
                    const birthDate = new Date(birthdate);
                    const deathDate = new Date(deathdate);

                    let age = deathDate.getFullYear() - birthDate.getFullYear();
                    const monthDiff = deathDate.getMonth() - birthDate.getMonth();

                    if (monthDiff < 0 || (monthDiff === 0 && deathDate.getDate() < birthDate.getDate())) {
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
                    this.openDeathDetailsModal(id);
                } else {
                    this.showError('Invalid record ID');
                }
            }

            generateCertificate(id) {
                if (id && id > 0) {
                    this.openDeathCertificateModal(id);
                } else {
                    this.showError('Invalid record ID');
                }
            }

            editRecord(id) {
                if (id && id > 0) {
                    console.log('Opening edit death modal for ID:', id);

                    if (this.pendingEditRequest) {
                        this.pendingEditRequest.abort();
                        this.pendingEditRequest = null;
                    }

                    const modalElement = document.getElementById('addDeathModal');
                    if (!modalElement) {
                        console.error('Modal element not found');
                        this.showError('Modal not found');
                        return;
                    }

                    const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

                    this.resetEditModalState();
                    this.setEditMode(id);

                    this.showEditModalLoading(true);

                    const modalTitle = document.querySelector('#addDeathModal .modal-title');
                    if (modalTitle) {
                        modalTitle.textContent = 'Loading Record...';
                    }

                    modal.show();

                    this.loadRecordDataForEdit(id);

                } else {
                    this.showError('Invalid record ID');
                }
            }

            async loadRecordDataForEdit(deathId) {
                try {
                    console.log('Loading record data for ID:', deathId);
                    this.isModalLoading = true;

                    const abortController = new AbortController();
                    this.pendingEditRequest = abortController;

                    const response = await fetch(`../../handlers/fetch-death-details.php?death_id=${deathId}`, {
                        signal: abortController.signal
                    });

                    this.pendingEditRequest = null;

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    console.log('Received data:', data);

                    if (data.success) {
                        const modalTitle = document.querySelector('#addDeathModal .modal-title');
                        if (modalTitle) {
                            modalTitle.textContent = 'Edit Death Record';
                        }

                        this.populateEditForm(data.data);

                        this.initializeStepIndicatorsAfterEdit();

                        console.log('Form populated successfully');
                    } else {
                        throw new Error(data.message || 'Failed to load record data');
                    }
                } catch (error) {
                    if (error.name !== 'AbortError') {
                        console.error('Error loading record for editing:', error);
                        this.showError('Failed to load record for editing: ' + error.message);

                        const modalElement = document.getElementById('addDeathModal');
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

            initializeStepIndicatorsAfterEdit() {
                if (typeof updateStepIndicators !== 'undefined') {
                    updateStepIndicators();
                }

                const steps = document.querySelectorAll('#deathCertForm .step');
                steps.forEach(step => {
                    step.classList.add('completed');
                    step.classList.remove('incomplete', 'active');
                });

                if (steps.length > 0) {
                    steps[0].classList.add('active');
                }

                const formSteps = document.querySelectorAll('#deathCertForm .form-step');
                formSteps.forEach((step, index) => {
                    if (index === 0) {
                        step.classList.add('active');
                    } else {
                        step.classList.remove('active');
                    }
                });

                const prevBtn = document.getElementById('prevDeathBtn');
                const nextBtn = document.getElementById('nextDeathBtn');
                const submitBtn = document.getElementById('submitDeathBtn');

                if (prevBtn) prevBtn.style.display = 'none';
                if (nextBtn) nextBtn.style.display = 'block';
                if (submitBtn) {
                    submitBtn.classList.add('d-none');
                }

                if (typeof currentStep !== 'undefined') {
                    currentStep = 0;
                }
            }

            showEditModalLoading(show) {
                const modalBody = document.querySelector('#addDeathModal .modal-body');
                const form = document.getElementById('deathCertForm');

                if (!modalBody) return;

                if (show) {
                    let loadingOverlay = modalBody.querySelector('.modal-loading-overlay');
                    if (!loadingOverlay) {
                        loadingOverlay = document.createElement('div');
                        loadingOverlay.className = 'modal-loading-overlay';
                        loadingOverlay.innerHTML = `
                        <div class="text-center py-5">
                            <div class="loading-spinner mb-3"></div>
                            <p class="text-muted">Loading death record details...</p>
                        </div>
                    `;
                        modalBody.appendChild(loadingOverlay);
                    }

                    loadingOverlay.style.display = 'flex';
                    if (form) form.style.opacity = '0.3';

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
                        form.querySelectorAll('input, select, textarea, button').forEach(element => {
                            element.disabled = false;
                        });
                    }
                }
            }

            resetEditModalState() {
                const form = document.getElementById('deathCertForm');
                if (form) {
                    form.reset();
                }

                const errors = document.querySelectorAll('.invalid-feedback');
                errors.forEach(error => error.remove());

                const invalidFields = document.querySelectorAll('.is-invalid');
                invalidFields.forEach(field => field.classList.remove('is-invalid'));

                const steps = document.querySelectorAll('#deathCertForm .form-step');
                const stepIndicators = document.querySelectorAll('#deathCertForm .step');

                steps.forEach((step, index) => {
                    if (index === 0) {
                        step.classList.add('active');
                    } else {
                        step.classList.remove('active');
                    }
                });

                stepIndicators.forEach((step, index) => {
                    step.classList.remove('active', 'completed', 'incomplete');

                    if (index === 0) {
                        step.classList.add('active');
                    }
                });

                const prevBtn = document.getElementById('prevDeathBtn');
                const nextBtn = document.getElementById('nextDeathBtn');
                const submitBtn = document.getElementById('submitDeathBtn');

                if (prevBtn) prevBtn.style.display = 'none';
                if (nextBtn) nextBtn.style.display = 'block';
                if (submitBtn) {
                    submitBtn.classList.add('d-none');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Save Death Record';
                }

                if (typeof currentStep !== 'undefined') {
                    currentStep = 0;
                }

                if (typeof updateStepIndicators !== 'undefined') {
                    updateStepIndicators();
                }
            }

            setEditMode(deathId) {
                const form = document.getElementById('deathCertForm');
                if (form) {
                    form.dataset.editId = deathId;
                }

                const submitBtn = document.getElementById('submitDeathBtn');
                if (submitBtn) {
                    submitBtn.textContent = 'Update Death Record';
                }

                const modalTitle = document.querySelector('#addDeathModal .modal-title');
                if (modalTitle) {
                    modalTitle.textContent = 'Edit Death Record';
                }
            }

            populateEditForm(data) {
                const death = data.death_record;

                // Personal Information
                this.setValue('first_name', death.first_name);
                this.setValue('middle_name', death.middle_name);
                this.setValue('last_name', death.last_name);
                this.setValue('sex', death.sex);
                this.setValue('date_of_death', this.formatDateForInput(death.date_of_death));
                this.setValue('date_of_birth', this.formatDateForInput(death.date_of_birth));

                // Age calculation
                if (death.date_of_birth && death.date_of_death) {
                    const age = this.calculateAge(death.date_of_birth, death.date_of_death);
                    this.setValue('age_years', age >= 1 ? age : '');
                    this.setValue('age_months', age < 1 ? '0' : '');
                }

                this.setValue('place_of_death', death.place_of_death);
                this.setValue('civil_status', death.civil_status);
                this.setValue('religion', death.religion);
                this.setValue('citizenship', death.citizenship);
                this.setValue('residence', death.residence);
                this.setValue('occupation', death.occupation);
                this.setValue('father_name', death.father_name);
                this.setValue('mother_maiden_name', death.mother_maiden_name);

                // Medical Certificate
                this.setValue('immediate_cause', death.immediate_cause);
                this.setValue('antecedent_cause', death.antecedent_cause);
                this.setValue('underlying_cause', death.underlying_cause);
                this.setValue('other_significant_conditions', death.other_significant_conditions);

                // Maternal condition (for females 15-49)
                if (death.sex === 'Female') {
                    this.setValue('maternal_condition', death.maternal_condition);
                }

                this.setValue('manner_of_death', death.manner_of_death);
                this.setValue('place_of_occurrence', death.place_of_occurrence);
                this.setValue('autopsy', death.autopsy);
                this.setValue('attendant', death.attendant);
                this.setValue('attendant_other', death.attendant_other);
                this.setValue('attended_from', this.formatDateForInput(death.attended_from));
                this.setValue('attended_to', this.formatDateForInput(death.attended_to));

                // Death Certification
                this.setValue('certifier_signature', death.certifier_signature);
                this.setValue('certifier_name', death.certifier_name);
                this.setValue('certifier_title', death.certifier_title);
                this.setValue('certifier_address', death.certifier_address);
                this.setValue('certifier_date', this.formatDateForInput(death.certifier_date));
                this.setValue('attended_deceased', death.attended_deceased);
                this.setValue('death_occurred_time', death.death_occurred_time);

                // Corpse Disposal
                this.setValue('corpse_disposal', death.corpse_disposal);
                this.setValue('burial_permit_number', death.burial_permit_number);
                this.setValue('burial_permit_date', this.formatDateForInput(death.burial_permit_date));
                this.setValue('transfer_permit_number', death.transfer_permit_number);
                this.setValue('transfer_permit_date', this.formatDateForInput(death.transfer_permit_date));
                this.setValue('cemetery_name', death.cemetery_name);
                this.setValue('cemetery_address', death.cemetery_address);

                // Informant Certification
                this.setValue('informant_signature', death.informant_signature);
                this.setValue('informant_name', death.informant_name);
                this.setValue('informant_relationship', death.informant_relationship);
                this.setValue('informant_address', death.informant_address);
                this.setValue('informant_date', this.formatDateForInput(death.informant_date));

                // Prepared By
                this.setValue('prepared_by_signature', death.prepared_by_signature);
                this.setValue('prepared_by_name', death.prepared_by_name);
                this.setValue('prepared_by_title', death.prepared_by_title);
                this.setValue('prepared_by_date', this.formatDateForInput(death.prepared_by_date));

                // Confirm accuracy checkbox
                const confirmAccuracyCheckbox = document.getElementById('confirmDeathAccuracy');
                if (confirmAccuracyCheckbox) {
                    confirmAccuracyCheckbox.checked = true;
                }
            }

            setValue(fieldName, value) {
                const element = document.querySelector(`[name="${fieldName}"]`);
                if (element && value !== null && value !== undefined) {
                    if (element.type === 'checkbox') {
                        element.checked = value;
                    } else if (element.type === 'radio') {
                        const radioElement = document.querySelector(`[name="${fieldName}"][value="${value}"]`);
                        if (radioElement) {
                            radioElement.checked = true;
                        }
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
                const modalElement = document.getElementById('addDeathModal');
                if (modalElement) {
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) {
                        modal.hide();
                    }
                }

                if (this.pendingEditRequest) {
                    this.pendingEditRequest.abort();
                    this.pendingEditRequest = null;
                }

                this.isModalLoading = false;
                this.currentEditId = null;

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

                    const row = document.querySelector(`#death-record-${id}`);
                    let recordInfo = 'this record';

                    if (row) {
                        const nameCell = row.cells[2];
                        const regNumberCell = row.cells[1];
                        const deceasedName = nameCell.textContent.trim();
                        const regNumber = regNumberCell.textContent.trim();

                        recordInfo = `${deceasedName} (${regNumber !== 'N/A' ? regNumber : 'No Registry Number'})`;
                    }

                    const result = await Swal.fire({
                        title: 'Delete Death Record',
                        html: `
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle text-warning mb-3" style="font-size: 3rem;"></i>
                        <h4 class="text-danger">Are you sure?</h4>
                        <p>You are about to delete the death record for:<br>
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

                        const deleteResponse = await fetch('../../handlers/delete-death-record.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                action: 'delete_death_record',
                                death_id: id
                            })
                        });

                        const deleteData = await deleteResponse.json();

                        Swal.close();

                        if (deleteData.success) {
                            await Swal.fire({
                                title: 'Deleted!',
                                text: 'Death record has been deleted successfully.',
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK',
                                timer: 2000,
                                timerProgressBar: true
                            });

                            this.refreshAllData();

                            Toastify({
                                text: 'Death record deleted successfully!',
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

                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to delete record: ' + error.message,
                        icon: 'error',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                } finally {
                    this.isDeleting = false;
                }
            }

            refreshAllData() {
                this.showInitialLoading();
                this.loadRecords();
            }

            async openDeathDetailsModal(deathId) {
                try {
                    const modal = new bootstrap.Modal(document.getElementById('deathDetailsModal'));
                    this.resetDeathModalState();
                    modal.show();

                    const response = await fetch(`../../handlers/fetch-death-details.php?death_id=${deathId}`);
                    const data = await response.json();

                    if (data.success) {
                        this.displayDeathModalRecordDetails(data.data);
                    } else {
                        this.showDeathModalError(data.message);
                    }
                } catch (error) {
                    console.error('Error loading death details:', error);
                    this.showDeathModalError('Failed to load death details');
                }
            }

            resetDeathModalState() {
                document.getElementById('deathModalLoadingState').style.display = 'block';
                document.getElementById('deathModalRecordDetails').style.display = 'none';
                document.getElementById('deathModalErrorState').style.display = 'none';
            }

            displayDeathModalRecordDetails(data) {
                const death = data.death_record;

                document.getElementById('deathModalLoadingState').style.display = 'none';
                document.getElementById('deathModalRecordDetails').style.display = 'block';

                // Registry Information
                document.getElementById('deathModalRegistryNumber').textContent = death.registry_number || 'N/A';
                document.getElementById('deathModalRecordId').textContent = death.death_id || 'N/A';
                document.getElementById('deathModalDateRegistered').textContent = this.formatDateTime(death.date_registered);

                // Personal Information
                document.getElementById('deathModalDeceasedName').textContent = this.formatFullName(
                    death.first_name,
                    death.middle_name,
                    death.last_name
                );
                document.getElementById('deathModalSex').textContent = death.sex || 'N/A';
                document.getElementById('deathModalCivilStatus').textContent = death.civil_status || 'N/A';
                document.getElementById('deathModalDateOfDeath').textContent = this.formatDate(death.date_of_death);
                document.getElementById('deathModalDateOfBirth').textContent = this.formatDate(death.date_of_birth);
                document.getElementById('deathModalAge').textContent = this.calculateAge(death.date_of_birth, death.date_of_death);

                // Location Information
                document.getElementById('deathModalPlaceOfDeath').textContent = death.place_of_death || 'N/A';
                document.getElementById('deathModalResidence').textContent = death.residence || 'N/A';
                document.getElementById('deathModalCitizenship').textContent = death.citizenship || 'N/A';

                // Additional Details
                document.getElementById('deathModalReligion').textContent = death.religion || 'N/A';
                document.getElementById('deathModalOccupation').textContent = death.occupation || 'N/A';
                document.getElementById('deathModalFatherName').textContent = death.father_name || 'N/A';
                document.getElementById('deathModalMotherName').textContent = death.mother_maiden_name || 'N/A';

                // Medical Information
                document.getElementById('deathModalImmediateCause').textContent = death.immediate_cause || 'N/A';
                document.getElementById('deathModalAntecedentCause').textContent = death.antecedent_cause || 'N/A';
                document.getElementById('deathModalUnderlyingCause').textContent = death.underlying_cause || 'N/A';
                document.getElementById('deathModalOtherConditions').textContent = death.other_significant_conditions || 'N/A';
                document.getElementById('deathModalMannerOfDeath').textContent = death.manner_of_death || 'N/A';
                document.getElementById('deathModalPlaceOfOccurrence').textContent = death.place_of_occurrence || 'N/A';
                document.getElementById('deathModalAutopsy').textContent = death.autopsy || 'N/A';
                document.getElementById('deathModalAttendant').textContent = death.attendant || 'N/A';

                // Show/hide attendant other
                if (death.attendant_other) {
                    document.getElementById('deathModalAttendantOtherContainer').style.display = 'block';
                    document.getElementById('deathModalAttendantOther').textContent = death.attendant_other;
                } else {
                    document.getElementById('deathModalAttendantOtherContainer').style.display = 'none';
                }

                // Attended duration
                const attendedFrom = death.attended_from ? this.formatDate(death.attended_from) : '';
                const attendedTo = death.attended_to ? this.formatDate(death.attended_to) : '';
                document.getElementById('deathModalAttendedDuration').textContent =
                    attendedFrom && attendedTo ? `${attendedFrom} to ${attendedTo}` : 'N/A';

                // Maternal condition (for females)
                if (death.sex === 'Female' && death.maternal_condition) {
                    document.getElementById('deathModalMaternalConditionContainer').style.display = 'block';
                    document.getElementById('deathModalMaternalCondition').textContent = death.maternal_condition;
                } else {
                    document.getElementById('deathModalMaternalConditionContainer').style.display = 'none';
                }

                // Death Certification
                document.getElementById('deathModalCertifierName').textContent = death.certifier_name || 'N/A';
                document.getElementById('deathModalCertifierTitle').textContent = death.certifier_title || 'N/A';
                document.getElementById('deathModalAttendedDeceased').textContent = death.attended_deceased || 'N/A';
                document.getElementById('deathModalDeathOccurredTime').textContent = death.death_occurred_time || 'N/A';
                document.getElementById('deathModalCertifierDate').textContent = death.certifier_date ? this.formatDate(death.certifier_date) : 'N/A';

                // Burial Details
                document.getElementById('deathModalCorpseDisposal').textContent = death.corpse_disposal || 'N/A';
                document.getElementById('deathModalBurialPermitNumber').textContent = death.burial_permit_number || 'N/A';
                document.getElementById('deathModalBurialPermitDate').textContent = death.burial_permit_date ? this.formatDate(death.burial_permit_date) : 'N/A';
                document.getElementById('deathModalTransferPermitNumber').textContent = death.transfer_permit_number || 'N/A';
                document.getElementById('deathModalCemeteryName').textContent = death.cemetery_name || 'N/A';

                // Informant Information
                document.getElementById('deathModalInformantName').textContent = death.informant_name || 'N/A';
                document.getElementById('deathModalInformantRelationship').textContent = death.informant_relationship || 'N/A';
                document.getElementById('deathModalInformantDate').textContent = death.informant_date ? this.formatDate(death.informant_date) : 'N/A';
                document.getElementById('deathModalInformantAddress').textContent = death.informant_address || 'N/A';
            }
            showDeathModalError(message) {
                document.getElementById('deathModalLoadingState').style.display = 'none';
                document.getElementById('deathModalErrorState').style.display = 'block';
                document.getElementById('deathModalErrorMessage').textContent = message;
            }

            formatFullName(first, middle, last) {
                const names = [first, middle, last].filter(name => name && name.trim() !== '');
                return names.length > 0 ? names.join(' ') : 'N/A';
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

            openDeathCertificateModal(id) {
                if (id && id > 0) {
                    console.log('Opening death certificate for ID:', id);
                } else {
                    this.showError('Invalid record ID');
                }
            }

            printDeathDetails() {
                const printBtn = document.getElementById('deathModalPrintBtn');
                if (printBtn) {
                    printBtn.onclick = () => {
                        this.handlePrintDeathDetails();
                    };
                }
            }

            handlePrintDeathDetails() {
                try {
                    const modalContent = document.getElementById('deathModalRecordDetails');

                    if (!modalContent || modalContent.style.display === 'none') {
                        this.showError('No record details available to print');
                        return;
                    }

                    const printWindow = window.open('', '_blank');
                    if (!printWindow) {
                        this.showError('Please allow pop-ups for printing');
                        return;
                    }

                    const recordData = this.getCurrentRecordDataForPrint();

                    const printHTML = this.generatePrintHTML(recordData);

                    printWindow.document.write(printHTML);
                    printWindow.document.close();

                    printWindow.onload = () => {
                        printWindow.focus();
                        printWindow.print();
                    };

                } catch (error) {
                    console.error('Error printing death details:', error);
                    this.showError('Failed to print record details');
                }
            }

            getCurrentRecordDataForPrint() {
                return {
                    registryNumber: document.getElementById('deathModalRegistryNumber')?.textContent || 'N/A',
                    deceasedName: document.getElementById('deathModalDeceasedName')?.textContent || 'N/A',
                    sex: document.getElementById('deathModalSex')?.textContent || 'N/A',
                    dateOfDeath: document.getElementById('deathModalDateOfDeath')?.textContent || 'N/A',
                    dateOfBirth: document.getElementById('deathModalDateOfBirth')?.textContent || 'N/A',
                    age: document.getElementById('deathModalAge')?.textContent || 'N/A',
                    placeOfDeath: document.getElementById('deathModalPlaceOfDeath')?.textContent || 'N/A',
                    civilStatus: document.getElementById('deathModalCivilStatus')?.textContent || 'N/A',
                    religion: document.getElementById('deathModalReligion')?.textContent || 'N/A',
                    citizenship: document.getElementById('deathModalCitizenship')?.textContent || 'N/A',
                    residence: document.getElementById('deathModalResidence')?.textContent || 'N/A',
                    occupation: document.getElementById('deathModalOccupation')?.textContent || 'N/A',
                    fatherName: document.getElementById('deathModalFatherName')?.textContent || 'N/A',
                    motherName: document.getElementById('deathModalMotherName')?.textContent || 'N/A',
                    immediateCause: document.getElementById('deathModalImmediateCause')?.textContent || 'N/A',
                    antecedentCause: document.getElementById('deathModalAntecedentCause')?.textContent || 'N/A',
                    underlyingCause: document.getElementById('deathModalUnderlyingCause')?.textContent || 'N/A',
                    otherConditions: document.getElementById('deathModalOtherConditions')?.textContent || 'N/A',
                    mannerOfDeath: document.getElementById('deathModalMannerOfDeath')?.textContent || 'N/A',
                    placeOfOccurrence: document.getElementById('deathModalPlaceOfOccurrence')?.textContent || 'N/A',
                    dateRegistered: document.getElementById('deathModalDateRegistered')?.textContent || 'N/A',
                    recordId: document.getElementById('deathModalRecordId')?.textContent || 'N/A'
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
    <title>Death Record Details - ${data.registryNumber}</title>
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
        <h1>DEATH RECORD DETAILS</h1>
        <div class="subtitle">Civil Registration System</div>
        <div class="subtitle">Printed on: ${currentDate}</div>
    </div>

    <div class="section">
        <div class="section-title">PERSONAL INFORMATION</div>
        <div class="row">
            <div class="col-md-6">
                <div class="detail-item"><strong>Registry Number:</strong> ${data.registryNumber}</div>
                <div class="detail-item"><strong>Deceased Name:</strong> ${data.deceasedName}</div>
                <div class="detail-item"><strong>Sex:</strong> ${data.sex}</div>
                <div class="detail-item"><strong>Date of Death:</strong> ${data.dateOfDeath}</div>
                <div class="detail-item"><strong>Date of Birth:</strong> ${data.dateOfBirth}</div>
            </div>
            <div class="col-md-6">
                <div class="detail-item"><strong>Age at Death:</strong> ${data.age}</div>
                <div class="detail-item"><strong>Civil Status:</strong> ${data.civilStatus}</div>
                <div class="detail-item"><strong>Religion:</strong> ${data.religion}</div>
                <div class="detail-item"><strong>Citizenship:</strong> ${data.citizenship}</div>
                <div class="detail-item"><strong>Occupation:</strong> ${data.occupation}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">PLACE OF DEATH & RESIDENCE</div>
        <div class="detail-item"><strong>Place of Death:</strong> ${data.placeOfDeath}</div>
        <div class="detail-item"><strong>Residence:</strong> ${data.residence}</div>
    </div>

    <div class="section">
        <div class="section-title">PARENTS INFORMATION</div>
        <div class="row">
            <div class="col-md-6">
                <div class="detail-item"><strong>Father's Name:</strong> ${data.fatherName}</div>
            </div>
            <div class="col-md-6">
                <div class="detail-item"><strong>Mother's Maiden Name:</strong> ${data.motherName}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">MEDICAL INFORMATION</div>
        <div class="detail-item"><strong>Immediate Cause:</strong> ${data.immediateCause}</div>
        <div class="detail-item"><strong>Antecedent Cause:</strong> ${data.antecedentCause}</div>
        <div class="detail-item"><strong>Underlying Cause:</strong> ${data.underlyingCause}</div>
        <div class="detail-item"><strong>Other Significant Conditions:</strong> ${data.otherConditions}</div>
        <div class="detail-item"><strong>Manner of Death:</strong> ${data.mannerOfDeath}</div>
        <div class="detail-item"><strong>Place of Occurrence:</strong> ${data.placeOfOccurrence}</div>
    </div>

    <div class="section">
        <div class="section-title">REGISTRATION INFORMATION</div>
        <div class="detail-item"><strong>Date Registered:</strong> ${data.dateRegistered}</div>
        <div class="detail-item"><strong>Record ID:</strong> ${data.recordId}</div>
    </div>

    <div class="footer">
        <p>This is a computer-generated document. No signature is required.</p>
        <p>Pagadian City Civil Registry Office</p>
    </div>
</body>
</html>`;
            }

            async generateCertificate(id) {
                if (id && id > 0) {
                    try {
                        Swal.fire({
                            title: 'Generating Certificate',
                            text: 'Please wait while we generate the death certificate...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        const response = await fetch(`../../handlers/fetch-death-details.php?death_id=${id}`);
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

            displayCertificate(data) {
                const death = data.death_record;

                const certificateWindow = window.open('', '_blank', 'width=1000,height=1200,scrollbars=yes');

                if (!certificateWindow) {
                    this.showError('Please allow pop-ups to view the certificate');
                    return;
                }

                const certificateHTML = this.generateCertificateHTML(death);

                certificateWindow.document.write(certificateHTML);
                certificateWindow.document.close();

                certificateWindow.focus();
            }

            generateCertificateHTML(death) {
                const deathDate = death.date_of_death ? new Date(death.date_of_death) : new Date();
                const birthDate = death.date_of_birth ? new Date(death.date_of_birth) : null;

                const age = this.calculateAge(death.date_of_birth, death.date_of_death);
                const ageDisplay = age >= 1 ? `${age} years` : 'Under 1 year';

                return `
<!DOCTYPE html>
<html>
<head>
    <title>Certificate of Death - ${death.registry_number || 'N/A'}</title>
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
        .form-section {
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            background-color: #f0f0f0;
            padding: 5px;
            margin: 10px 0;
            border: 1px solid #000;
        }
        .form-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
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
        .field-label {
            font-weight: bold;
            display: inline-block;
            width: 200px;
        }
        .field-value {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 300px;
            padding: 2px 5px;
        }
        .checkbox-group {
            display: flex;
            gap: 20px;
            margin: 5px 0;
        }
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
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
            <h1>Republic of the Philippines</h1>
            <h2>OFFICE OF THE CIVIL REGISTRAR GENERAL</h2>
            <h2>CERTIFICATE OF DEATH</h2>
            <p><small>(To be accomplished in quadruplicate using black ink)</small></p>
        </div>

        <div class="form-section">
            <table class="form-table">
                <tr>
                    <td style="width: 50%"><strong>Province:</strong> ${death.province || ''}</td>
                    <td style="width: 50%"><strong>Registry No:</strong> ${death.registry_number || ''}</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>City/Municipality:</strong> ${death.city_municipality || ''}</td>
                </tr>
            </table>
        </div>

        <div class="form-section">
            <div class="section-title">1. NAME (First | Middle | Last)</div>
            <div>
                <span class="field-value" style="min-width: 600px;">
                    ${death.first_name || ''} ${death.middle_name || ''} ${death.last_name || ''}
                </span>
            </div>
        </div>

        <div class="form-section">
            <div class="section-title">2. SEX</div>
            <div class="checkbox-group">
                <div class="checkbox-item">
                    <input type="checkbox" ${death.sex === 'Male' ? 'checked' : ''} disabled> Male
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" ${death.sex === 'Female' ? 'checked' : ''} disabled> Female
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="section-title">3. DATE OF DEATH & 4. DATE OF BIRTH</div>
            <table class="form-table">
                <tr>
                    <td style="width: 50%">
                        <strong>Date of Death:</strong><br>
                        ${deathDate.toLocaleDateString()}
                    </td>
                    <td style="width: 50%">
                        <strong>Date of Birth:</strong><br>
                        ${birthDate ? birthDate.toLocaleDateString() : ''}
                    </td>
                </tr>
            </table>
        </div>

        <div class="form-section">
            <div class="section-title">5. AGE AT THE TIME OF DEATH</div>
            <div class="checkbox-group">
                <div class="checkbox-item">
                    <input type="checkbox" ${age >= 1 ? 'checked' : ''} disabled> 
                    <span class="field-value" style="min-width: 50px;">${age >= 1 ? age : ''}</span> Completed years
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" ${age < 1 ? 'checked' : ''} disabled> 
                    If under 1 year: 
                    <span class="field-value" style="min-width: 30px;"></span> Months 
                    <span class="field-value" style="min-width: 30px;"></span> Days 
                    <span class="field-value" style="min-width: 30px;"></span> Hours 
                    <span class="field-value" style="min-width: 30px;"></span> Minutes
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="section-title">6. PLACE OF DEATH</div>
            <div>
                <span class="field-value" style="min-width: 600px;">
                    ${death.place_of_death || ''}
                </span>
            </div>
        </div>

        <div class="form-section">
            <div class="section-title">7. CIVIL STATUS</div>
            <div>
                <span class="field-value" style="min-width: 200px;">
                    ${death.civil_status || ''}
                </span>
            </div>
        </div>

        <div class="form-section">
            <div class="section-title">8. RELIGION/RELIGIOUS SECT & 9. CITIZENSHIP</div>
            <table class="form-table">
                <tr>
                    <td style="width: 50%">
                        <strong>Religion:</strong><br>
                        ${death.religion || ''}
                    </td>
                    <td style="width: 50%">
                        <strong>Citizenship:</strong><br>
                        ${death.citizenship || ''}
                    </td>
                </tr>
            </table>
        </div>

        <div class="form-section">
            <div class="section-title">10. RESIDENCE</div>
            <div>
                <span class="field-value" style="min-width: 600px;">
                    ${death.residence || ''}
                </span>
            </div>
        </div>

        <div class="form-section">
            <div class="section-title">11. OCCUPATION</div>
            <div>
                <span class="field-value" style="min-width: 400px;">
                    ${death.occupation || ''}
                </span>
            </div>
        </div>

        <div class="form-section">
            <div class="section-title">12. NAME OF FATHER & 13. MAIDEN NAME OF MOTHER</div>
            <table class="form-table">
                <tr>
                    <td style="width: 50%">
                        <strong>Father's Name:</strong><br>
                        ${death.father_name || ''}
                    </td>
                    <td style="width: 50%">
                        <strong>Mother's Maiden Name:</strong><br>
                        ${death.mother_maiden_name || ''}
                    </td>
                </tr>
            </table>
        </div>

        <div class="form-section">
            <div class="section-title">MEDICAL CERTIFICATE</div>
            
            <div class="section-title" style="font-size: 14px; margin: 10px 0;">19b. CAUSES OF DEATH</div>
            <table class="form-table">
                <tr>
                    <th>Cause</th>
                    <th>Description</th>
                </tr>
                <tr>
                    <td>I. Immediate cause</td>
                    <td>${death.immediate_cause || ''}</td>
                </tr>
                <tr>
                    <td>Antecedent cause</td>
                    <td>${death.antecedent_cause || ''}</td>
                </tr>
                <tr>
                    <td>Underlying cause</td>
                    <td>${death.underlying_cause || ''}</td>
                </tr>
                <tr>
                    <td>II. Other significant conditions</td>
                    <td>${death.other_significant_conditions || ''}</td>
                </tr>
            </table>

            <div class="section-title" style="font-size: 14px; margin: 10px 0;">19d. DEATH BY EXTERNAL CAUSES</div>
            <table class="form-table">
                <tr>
                    <td style="width: 50%">
                        <strong>Manner of death:</strong><br>
                        ${death.manner_of_death || ''}
                    </td>
                    <td style="width: 50%">
                        <strong>Place of occurrence:</strong><br>
                        ${death.place_of_occurrence || ''}
                    </td>
                </tr>
            </table>
        </div>

        <div class="form-section">
            <div class="section-title">22. CERTIFICATION OF DEATH</div>
            <div style="margin-bottom: 20px; padding: 10px; border: 1px solid #000;">
                "I hereby certify that the foregoing particulars are correct as near as same can be ascertained and I further certify that I 
                [${death.attended_deceased === 'Yes' ? 'X' : ' '}] have attended / 
                [${death.attended_deceased === 'No' ? 'X' : ' '}] have not attended the deceased and that death occurred at 
                ${death.death_occurred_time || ''} on the date of death specified above."
            </div>

            <div class="signature-section">
                <div style="float: left; width: 45%;">
                    <div class="signature-line">
                        ${death.certifier_signature || ''}<br>
                        <small>Signature</small>
                    </div>
                </div>
                <div style="float: right; width: 45%;">
                    <div class="signature-line">
                        ${death.certifier_name || ''}<br>
                        <small>Name in Print</small>
                    </div>
                </div>
                <div style="clear: both;"></div>
                
                <div style="margin-top: 10px;">
                    <strong>Title or Position:</strong> ${death.certifier_title || ''}<br>
                    <strong>Address:</strong> ${death.certifier_address || ''}<br>
                    <strong>Date:</strong> ${death.certifier_date ? new Date(death.certifier_date).toLocaleDateString() : ''}
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="section-title">26. CERTIFICATION OF INFORMANT</div>
            <div style="margin-bottom: 20px; padding: 10px; border: 1px solid #000;">
                "I hereby certify that all information supplied are true and correct to my own knowledge and belief."
            </div>

            <div class="signature-section">
                <div style="float: left; width: 45%;">
                    <div class="signature-line">
                        ${death.informant_signature || ''}<br>
                        <small>Signature</small>
                    </div>
                </div>
                <div style="float: right; width: 45%;">
                    <div class="signature-line">
                        ${death.informant_name || ''}<br>
                        <small>Name in Print</small>
                    </div>
                </div>
                <div style="clear: both;"></div>
                
                <div style="margin-top: 10px;">
                    <strong>Relationship to the Deceased:</strong> ${death.informant_relationship || ''}<br>
                    <strong>Address:</strong> ${death.informant_address || ''}<br>
                    <strong>Date:</strong> ${death.informant_date ? new Date(death.informant_date).toLocaleDateString() : ''}
                </div>
            </div>
        </div>

    </div>

</body>
</html>`;
            }
        }

        let deathManager;
        document.addEventListener('DOMContentLoaded', function() {
            deathManager = new DeathRecordsManager();
        });
    </script>
</body>

</html>