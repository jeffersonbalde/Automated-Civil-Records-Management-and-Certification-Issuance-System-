<?php
// Define colors for LIGHT theme sidebar (ORANGE THEME)
$colors = [
    'primary' => '#FF6B35',        // Main orange color
    'accent' => '#E55A2B',         // Darker orange for accents
    'sidebar-bg' => '#ffffff',     // WHITE sidebar background
    'sidebar-text' => '#333333',   // Dark text for sidebar
    'sidebar-hover' => '#FFF5F2',  // Light orange hover background
    'child-bg' => '#FFF5F2',       // Light orange background for child items
    'border' => '#FFD1C4',         // Light orange border
    'success' => '#28A745',
    'warning' => '#FFC107',
    'danger' => '#DC3545',
    'info' => '#17A2B8'
];

// Navigation items structure for Civil Registry System (unchanged)
$navItems = [
    [
        'id' => 'dashboard',
        'path' => '#',
        'icon' => 'fas fa-tachometer-alt',
        'label' => 'Dashboard',
        'type' => 'single'
    ],
    [
        'id' => 'records',
        'icon' => 'fas fa-archive',
        'label' => 'Civil Records Management',
        'type' => 'group',
        'children' => [
            [
                'path' => '/modules/birth/birth.php',
                'label' => 'Birth Records',
                'icon' => 'fas fa-baby'
            ],
            [
                'path' => '/modules/marriage/marriage.php',
                'label' => 'Marriage Records',
                'icon' => 'fas fa-ring'
            ],
            [
                'path' => '/modules/death/death.php',
                'label' => 'Death Records',
                'icon' => 'fas fa-cross'
            ]
        ]
    ],
    [
        'id' => 'certificates',
        'icon' => 'fas fa-certificate',
        'label' => 'Certificate Issuance',
        'type' => 'group',
        'children' => [
            [
                'path' => '#',
                'label' => 'Issue Certificates',
                'icon' => 'fas fa-print'
            ],
            [
                'path' => '#',
                'label' => 'Certificate Templates',
                'icon' => 'fas fa-file-alt'
            ],
            [
                'path' => '#',
                'label' => 'Issued Certificates',
                'icon' => 'fas fa-list'
            ]
        ]
    ],
    [
        'id' => 'scanning',
        'path' => '#',
        'icon' => 'far fa-address-book',
        'label' => 'Document Scanning',
        'type' => 'single'
    ],
    [
        'id' => 'reports',
        'icon' => 'fas fa-chart-bar',
        'label' => 'Reports & Analytics',
        'type' => 'group',
        'children' => [
            [
                'path' => '#',
                'label' => 'Daily Reports',
                'icon' => 'fas fa-calendar-day'
            ],
            [
                'path' => '#',
                'label' => 'Monthly Reports',
                'icon' => 'fas fa-calendar-alt'
            ],
            [
                'path' => '#',
                'label' => 'Statistics',
                'icon' => 'fas fa-chart-pie'
            ]
        ]
    ],
    [
        'id' => 'system',
        'icon' => 'fas fa-cog',
        'label' => 'System Management',
        'type' => 'group',
        'children' => [
            [
                'path' => '#',
                'label' => 'User Management',
                'icon' => 'fas fa-users-cog'
            ],
            [
                'path' => '#',
                'label' => 'Audit Trail',
                'icon' => 'fas fa-history'
            ],
            [
                'path' => '#',
                'label' => 'Backup & Restore',
                'icon' => 'fas fa-database'
            ],
            [
                'path' => '#',
                'label' => 'System Settings',
                'icon' => 'fas fa-sliders-h'
            ]
        ]
    ],
    [
        'id' => 'validation',
        'path' => '#',
        'icon' => 'fas fa-check-double',
        'label' => 'Data Validation',
        'type' => 'single'
    ],
    [
        'id' => 'corrections',
        'path' => '#',
        'icon' => 'fas fa-edit',
        'label' => 'Correction Module',
        'type' => 'single'
    ]
];

// Function to check active route (unchanged)
function isActiveRoute($path)
{
    $currentPath = $_SERVER['PHP_SELF'];

    // Handle dynamic routes
    if (strpos($path, ':eventId') !== false) {
        $pattern = str_replace(':eventId', '[^/]+', $path);
        return preg_match("#{$pattern}#", $currentPath);
    }

    // Exact match or starts with
    return $currentPath === $path || strpos($currentPath, $path) === 0;
}

// Function to check if group is active (unchanged)
function isGroupActive($children)
{
    foreach ($children as $child) {
        if (isActiveRoute($child['path'])) {
            return true;
        }
    }
    return false;
}

// Check if mobile (unchanged)
$isMobile = preg_match('/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $_SERVER['HTTP_USER_AGENT']);

// Get user data (you would replace this with actual user data from your session/database)
$userName = "John Doe"; // Replace with actual user name
$userRole = "Administrator"; // Replace with actual user role
$userInitials = "JD"; // Get initials from user name
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Civil Registry System - Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* CSS Variables for ORANGE THEME */
        :root {
            --primary: <?php echo $colors['primary']; ?>;
            --accent: <?php echo $colors['accent']; ?>;
            --sidebar-bg: <?php echo $colors['sidebar-bg']; ?>;
            --sidebar-text: <?php echo $colors['sidebar-text']; ?>;
            --sidebar-hover: <?php echo $colors['sidebar-hover']; ?>;
            --child-bg: <?php echo $colors['child-bg']; ?>;
            --border: <?php echo $colors['border']; ?>;
        }

        /* Simplified sidebar styles for ORANGE THEME */
        .sidebar {
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            color: var(--sidebar-text);
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            background: var(--primary);
            border-bottom: 3px solid var(--accent);
        }

        .logo-text {
            color: white;
            font-size: 1.1rem;
            margin: 0;
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.8rem;
            margin: 0;
        }

        .nav-link,
        .nav-group-btn {
            color: var(--sidebar-text);
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
            background: transparent;
        }

        .nav-link:hover,
        .nav-group-btn:hover {
            background: var(--sidebar-hover);
            color: var(--sidebar-text);
            border-left-color: var(--primary);
        }

        .nav-link.active,
        .nav-group-btn.active {
            background: var(--primary);
            color: white;
            border-left-color: var(--accent);
            font-weight: 600;
        }

        .nav-child-link {
            color: var(--sidebar-text);
            background: var(--child-bg);
            padding-left: 3rem !important;
            border-left: 3px solid transparent;
        }

        .nav-child-link:hover {
            background: var(--sidebar-hover);
            color: var(--sidebar-text);
            border-left-color: var(--primary);
        }

        .nav-child-link.active {
            background: var(--primary);
            color: white;
            border-left-color: var(--accent);
        }

        .logout-btn {
            background: var(--primary);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: var(--accent);
            color: white;
            transform: translateY(-1px);
        }

        .developer-credits {
            color: rgba(0, 0, 0, 0.6);
            font-size: 0.75rem;
        }

        .developer-credits span {
            color: var(--primary);
            font-weight: bold;
        }

        /* Mobile menu button */
        .mobile-menu-btn {
            background: var(--primary);
            color: white;
            border: 2px solid var(--accent);
        }

        .sidebar-overlay.active {
            background: rgba(0, 0, 0, 0.5);
        }

        /* Chevron colors */
        .nav-group-btn i.fa-chevron-right,
        .nav-group-btn i.fa-chevron-down {
            color: var(--primary);
        }

        /* Logo section improvements */
        .logo-section {
            text-align: center;
            padding: 1rem 0;
        }

        .logo-img {
            max-width: 60px;
            margin-bottom: 0.5rem;
            filter: brightness(0) invert(1);
        }

        /* Sidebar footer light theme */
        .sidebar-footer {
            background: var(--child-bg);
            border-top: 1px solid var(--border);
        }

        /* Ensure proper contrast for all sidebar elements */
        .sidebar-content {
            background: var(--sidebar-bg);
        }

        .nav-group-children {
            background: var(--sidebar-bg);
        }

        /* Active state improvements */
        .nav-link.active i,
        .nav-group-btn.active i,
        .nav-child-link.active i {
            color: white;
        }

        /* Hover state for icons */
        .nav-link:hover i,
        .nav-group-btn:hover i,
        .nav-child-link:hover i {
            color: var(--primary);
        }

        /* Profile Avatar Styles */
        .profile-avatar {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
        }

        .profile-avatar:hover {
            background: var(--sidebar-hover);
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }

        .profile-info {
            flex: 1;
            overflow: hidden;
        }

        .profile-name {
            font-weight: 600;
            font-size: 0.9rem;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .profile-role {
            font-size: 0.75rem;
            color: var(--sidebar-text);
            opacity: 0.8;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .profile-dropdown {
            position: relative;
        }

        .profile-menu {
            position: absolute;
            bottom: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 0.5rem 0;
            margin-bottom: 0.5rem;
            z-index: 1000;
            display: none;
            border: 1px solid var(--border);
        }

        .profile-menu.active {
            display: block;
        }

        .profile-menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
            font-size: 0.9rem;
        }

        .profile-menu-item:hover {
            background: var(--sidebar-hover);
            color: var(--primary);
        }

        .profile-menu-item i {
            margin-right: 0.75rem;
            width: 16px;
            text-align: center;
        }

        .profile-menu-divider {
            height: 1px;
            background: var(--border);
            margin: 0.25rem 0;
        }

        /* Mobile adjustments for profile menu */
        @media (max-width: 768px) {
            .profile-menu {
                position: fixed;
                bottom: 70px;
                left: 10px;
                right: 10px;
                width: auto;
            }
        }
    </style>
    <link rel="stylesheet" href="../../assets/css/sidebar-styles.css">
</head>

<body>
    <div class="admin-container">
        <!-- Mobile Hamburger Button -->
        <button class="mobile-menu-btn" onclick="toggleSidebar()" aria-label="Toggle menu">
            <i class="fas fa-bars" id="menu-icon"></i>
        </button>

        <!-- Overlay for mobile -->
        <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-inner">
                <!-- Sidebar Header -->
                <div class="sidebar-header">
                    <div class="header-content">
                        <div class="header-main">
                            <div class="logo-section">
                                <img src="../../assets/img/pagadian-logo-remove.png" alt="Pagadian City Logo" class="logo-img">
                                <h2 class="logo-text">CIVIL REGISTRY OFFICE</h2>
                            </div>

                            <p class="subtitle">
                                Automated Records Management System
                                <span class="underline"></span>
                            </p>

                            <!-- Mobile close button -->
                            <button class="mobile-close-btn" onclick="toggleSidebar()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Content -->
                <div class="sidebar-content">
                    <nav class="sidebar-nav">
                        <?php foreach ($navItems as $item): ?>
                            <?php if ($item['type'] === 'single'): ?>
                                <a href="<?php echo $item['path']; ?>"
                                    class="nav-link <?php echo isActiveRoute($item['path']) ? 'active' : ''; ?>"
                                    onclick="handleNavClick()">
                                    <i class="<?php echo $item['icon']; ?>"></i>
                                    <span><?php echo $item['label']; ?></span>
                                </a>
                            <?php elseif ($item['type'] === 'group'): ?>
                                <?php
                                $isGroupActive = isGroupActive($item['children']);
                                $isExpanded = $isGroupActive;
                                ?>
                                <div class="nav-group">
                                    <button class="nav-group-btn <?php echo $isGroupActive ? 'active' : ''; ?>"
                                        onclick="toggleNavGroup('<?php echo $item['id']; ?>')">
                                        <div class="group-main">
                                            <i class="<?php echo $item['icon']; ?>"></i>
                                            <span><?php echo $item['label']; ?></span>
                                        </div>
                                        <i class="fas fa-chevron-<?php echo $isExpanded ? 'down' : 'right'; ?>"
                                            id="chevron-<?php echo $item['id']; ?>"></i>
                                    </button>

                                    <div class="nav-group-children <?php echo $isExpanded ? 'expanded' : ''; ?>"
                                        id="children-<?php echo $item['id']; ?>">
                                        <?php foreach ($item['children'] as $child): ?>
                                            <a href="<?php echo $child['path']; ?>"
                                                class="nav-child-link <?php echo isActiveRoute($child['path']) ? 'active' : ''; ?>"
                                                onclick="handleNavClick()">
                                                <i class="<?php echo $child['icon']; ?>"></i>
                                                <span><?php echo $child['label']; ?></span>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </nav>
                </div>

                <!-- Sidebar Footer with Profile Avatar -->
                <div class="sidebar-footer">
                    <div class="profile-dropdown">
                        <button class="profile-avatar" onclick="toggleProfileMenu()">
                            <div class="avatar-circle">
                                <?php echo $userInitials; ?>
                            </div>
                            <div class="profile-info">
                                <p class="profile-name"><?php echo $userName; ?></p>
                                <p class="profile-role"><?php echo $userRole; ?></p>
                            </div>
                            <i class="fas fa-chevron-up" id="profile-chevron"></i>
                        </button>
                        
                        <div class="profile-menu" id="profile-menu">
                            <a href="#" class="profile-menu-item">
                                <i class="fas fa-user"></i>
                                <span>My Profile</span>
                            </a>
                            <a href="#" class="profile-menu-item">
                                <i class="fas fa-cog"></i>
                                <span>Account Settings</span>
                            </a>
                            <a href="#" class="profile-menu-item">
                                <i class="fas fa-bell"></i>
                                <span>Notifications</span>
                            </a>
                            <div class="profile-menu-divider"></div>
                            <button class="profile-menu-item" onclick="confirmLogout()">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content" id="main-content">
            <!-- Your page content will be included here -->
            <?php
            // This is where your main content will be included
            // For example: include 'dashboard-content.php';
            ?>
        </main>
    </div>

    <script>
        // Toggle sidebar on mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            const menuIcon = document.getElementById('menu-icon');

            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');

            // Change menu icon
            if (sidebar.classList.contains('mobile-open')) {
                menuIcon.className = 'fas fa-times';
            } else {
                menuIcon.className = 'fas fa-bars';
            }
            
            // Close profile menu when sidebar is toggled
            closeProfileMenu();
        }

        // Toggle navigation groups
        function toggleNavGroup(groupId) {
            const children = document.getElementById(`children-${groupId}`);
            const chevron = document.getElementById(`chevron-${groupId}`);

            children.classList.toggle('expanded');

            if (children.classList.contains('expanded')) {
                chevron.className = 'fas fa-chevron-down';
            } else {
                chevron.className = 'fas fa-chevron-right';
            }
        }

        // Toggle profile menu
        function toggleProfileMenu() {
            const profileMenu = document.getElementById('profile-menu');
            const profileChevron = document.getElementById('profile-chevron');
            
            profileMenu.classList.toggle('active');
            
            if (profileMenu.classList.contains('active')) {
                profileChevron.className = 'fas fa-chevron-down';
            } else {
                profileChevron.className = 'fas fa-chevron-up';
            }
        }
        
        // Close profile menu
        function closeProfileMenu() {
            const profileMenu = document.getElementById('profile-menu');
            const profileChevron = document.getElementById('profile-chevron');
            
            profileMenu.classList.remove('active');
            profileChevron.className = 'fas fa-chevron-up';
        }

        // Handle navigation clicks on mobile
        function handleNavClick() {
            if (window.innerWidth <= 768) {
                toggleSidebar();
            }
        }

        // Confirm logout
        function confirmLogout() {
            if (confirm("Are you sure you want to logout?")) {
                // Show loading state
                const loading = document.createElement('div');
                loading.innerHTML = 'Logging out...';
                loading.style.position = 'fixed';
                loading.style.top = '50%';
                loading.style.left = '50%';
                loading.style.transform = 'translate(-50%, -50%)';
                loading.style.background = 'white';
                loading.style.padding = '20px';
                loading.style.borderRadius = '8px';
                loading.style.zIndex = '10000';
                document.body.appendChild(loading);
                // Simulate logout process
                setTimeout(() => {
                    window.location.href = '../../handlers/logout.php';
                }, 1000);
            }
        }

        // Close sidebar when clicking on overlay
        document.querySelector('.sidebar-overlay').addEventListener('click', toggleSidebar);

        // Close profile menu when clicking outside
        document.addEventListener('click', function(event) {
            const profileDropdown = document.querySelector('.profile-dropdown');
            const profileMenu = document.getElementById('profile-menu');
            
            if (!profileDropdown.contains(event.target) && profileMenu.classList.contains('active')) {
                closeProfileMenu();
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.querySelector('.sidebar-overlay');
                const menuIcon = document.getElementById('menu-icon');

                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
                menuIcon.className = 'fas fa-bars';
            }
        });

        // Initialize sidebar state
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-expand active groups
            const activeGroups = document.querySelectorAll('.nav-group-btn.active');
            activeGroups.forEach(btn => {
                const groupId = btn.id.replace('btn-', '');
                const children = document.getElementById(`children-${groupId}`);
                const chevron = document.getElementById(`chevron-${groupId}`);

                if (children && chevron) {
                    children.classList.add('expanded');
                    chevron.className = 'fas fa-chevron-down';
                }
            });
        });
    </script>
</body>

</html>