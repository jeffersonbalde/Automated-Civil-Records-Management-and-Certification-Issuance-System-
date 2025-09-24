<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

</html>

</html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header - Civil Registration System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="icon" type="image/png" href="../../assets/img/pagadian-logo.png" />


    <style>
        /* AVATAR */

        .avatar-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-menu-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #495057;
            cursor: pointer;
        }

        .profile-upload {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem;
            text-align: center;
        }

        .profile-upload-img-container {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 2px dashed #dee2e6;
        }

        .profile-upload-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .upload-icon {
            font-size: 3rem;
            color: #adb5bd;
        }

        .profile-upload-btn {
            background: #e9ecef;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .profile-upload-btn:hover {
            background: #dee2e6;
        }

        .burger-menu {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            cursor: pointer;
            color: #495057;
            transition: all 0.3s;
        }

        .burger-menu i {
            font-size: 1.2rem;
        }

        .burger-menu:hover {
            color: #0d6efd;
            transform: scale(1.1);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            padding-left: 1rem;
        }

        @media (min-width: 992px) {
            .burger-menu {
                display: flex;
            }
        }
    </style>
</head>

<!-- Top Bar -->
<div class="topbar">
    <div class="topbar-left">
        <div class="burger-menu">
            <i class="fas fa-bars"></i>
        </div>
    </div>
    <div class="topbar-right">
        <div class="user-menu">
            <div class="user-role"><?php echo htmlspecialchars($_SESSION['full_name']); ?></div>
            <div class="user-avatar" id="profileButton" title="<?php echo htmlspecialchars($_SESSION['full_name']); ?>">
                <?php if (!empty($_SESSION['profile_img'])): ?>
                    <img src="../../<?php echo htmlspecialchars($_SESSION['profile_img']); ?>" alt="Profile"
                        class="avatar-img">
                <?php else: ?>
                    <?php
                    $initials = strtoupper(substr($_SESSION['full_name'], 0, 1));
                    echo htmlspecialchars($initials);
                    ?>
                <?php endif; ?>
            </div>
            <!-- Profile Menu -->
            <div class="profile-menu" id="profileMenu">
                <div class="profile-header">
                    <?php if (!empty($_SESSION['profile_img'])): ?>
                        <img src="../../<?php echo htmlspecialchars($_SESSION['profile_img']); ?>" alt="Profile"
                            class="profile-menu-img">
                    <?php endif; ?>
                    <div class="profile-name"><?php echo htmlspecialchars($_SESSION['full_name']); ?></div>
                    <div class="profile-email"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
                </div>
                <div class="profile-menu-items">
                    <a href="#" class="profile-menu-item" id="changeProfileBtn">
                        <i class="fas fa-user-edit"></i>
                        <span>Change Profile</span>
                    </a>
                    <a href="#" class="profile-menu-item" id="changePasswordBtn">
                        <i class="fas fa-key"></i>
                        <span>Change Password</span>
                    </a>
                    <a href="../../handlers/logout.php" class="profile-menu-item danger">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Notification -->
<div class="notification" id="notification">
    <div class="notification-icon">
        <i class="fas"></i>
    </div>
    <div class="notification-content">
        <div class="notification-title"></div>
        <div class="notification-message"></div>
    </div>
</div>

<!-- Change Profile Modal -->
<div class="modal fade" id="changeProfileModal" tabindex="-1">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="profileForm" action="../../handlers/update_profile.php" method="POST"
                    enctype="multipart/form-data">
                    <div class="profile-upload">
                        <div class="profile-upload-img-container">
                            <?php if (!empty($_SESSION['profile_img'])): ?>
                                <img src="../../<?php echo htmlspecialchars($_SESSION['profile_img']); ?>" alt="Profile"
                                    class="profile-upload-img" id="profilePreview">
                            <?php else: ?>
                                <i class="fas fa-cloud-upload-alt upload-icon" id="uploadIcon"></i>
                                <img src="" alt="Profile" class="profile-upload-img" id="profilePreview"
                                    style="display: none;">
                            <?php endif; ?>
                        </div>
                        <label class="profile-upload-btn">
                            <input type="file" name="profile_img" id="profileInput" accept="image/*" hidden>
                            <i class="fas fa-camera"></i> Select New Photo
                        </label>
                        <p class="text-muted small">Recommended: Square image, at least 200x200px</p>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-check me-2"></i>Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="passwordForm" action="../../handlers/update_password.php" method="POST">
                    <div class="form-group">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Burger menu functionality
    document.querySelector('.burger-menu').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('active');
        document.querySelector('.sidebar-overlay').classList.toggle('active');
    });

    document.querySelector('.sidebar-overlay').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.remove('active');
        document.querySelector('.sidebar-overlay').classList.remove('active');
    });

    // Profile Menu Toggle
    const profileButton = document.getElementById('profileButton');
    const profileMenu = document.getElementById('profileMenu');

    profileButton.addEventListener('click', (e) => {
        e.stopPropagation();
        profileMenu.classList.toggle('active');
    });

    document.addEventListener('click', (e) => {
        if (!profileMenu.contains(e.target)) {
            profileMenu.classList.remove('active');
        }
    });

    // Modal handlers
    const changeProfileBtn = document.getElementById('changeProfileBtn');
    const changePasswordBtn = document.getElementById('changePasswordBtn');
    const profileModal = new bootstrap.Modal(document.getElementById('changeProfileModal'));
    const passwordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));

    changeProfileBtn.addEventListener('click', () => {
        profileMenu.classList.remove('active');
        profileModal.show();
    });

    changePasswordBtn.addEventListener('click', () => {
        profileMenu.classList.remove('active');
        passwordModal.show();
    });

    // Update profile image preview
    profileInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const uploadIcon = document.getElementById('uploadIcon');
                const profilePreview = document.getElementById('profilePreview');

                if (uploadIcon) uploadIcon.style.display = 'none';
                profilePreview.style.display = 'block';
                profilePreview.src = e.target.result;
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Show notification function
    function showNotification(type, title, message) {
        const notification = document.getElementById('notification');
        notification.className = 'notification ' + type;
        notification.querySelector('.notification-title').textContent = title;
        notification.querySelector('.notification-message').textContent = message;
        notification.querySelector('.notification-icon i').className =
            type === 'success' ? 'fas fa-check' : 'fas fa-times';

        notification.classList.add('show');
        setTimeout(() => notification.classList.remove('show'), 3000);
    }

    // Handle form submissions with AJAX
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        e.preventDefault();

        fetch(this.action, {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showNotification('success', 'Success!', data.message);
                    document.getElementById('changeProfileModal').querySelector('.btn-close').click();
                } else {
                    showNotification('error', 'Error!', data.message);
                }
            })
            .catch(error => {
                showNotification('error', 'Error!', 'An unexpected error occurred');
            });
    });
</script>


</body>

</html>