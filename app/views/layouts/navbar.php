            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg border-bottom luxury-nav animate__animated animate__fadeInDown">
                <div class="container-fluid px-4">
                    <button class="btn-toggle-sidebar me-3" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    
                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0 d-flex flex-row align-items-center gap-2">
                        <!-- Language Switcher -->
                        <li class="nav-item dropdown px-2">
                            <a class="nav-link dropdown-toggle premium-nav-link d-flex align-items-center gap-2" id="langDropdown" href="#" role="button" data-bs-toggle="dropdown">
                                <?php if ($_SESSION['lang'] == 'km'): ?>
                                    <img src="https://flagicons.lipis.dev/flags/4x3/kh.svg" width="22" class="rounded-1 shadow-sm">
                                    <span class="d-none d-sm-inline">ភាសាខ្មែរ</span>
                                <?php else: ?>
                                    <img src="https://flagicons.lipis.dev/flags/4x3/us.svg" width="22" class="rounded-1 shadow-sm">
                                    <span class="d-none d-sm-inline">English</span>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 animate__animated animate__fadeIn pf-dropdown">
                                <li><a class="dropdown-item d-flex align-items-center gap-3 py-2 px-3 <?= $_SESSION['lang'] == 'en' ? 'active' : '' ?>" href="<?= BASE_URL ?>/language/switch?lang=en">
                                    <img src="https://flagicons.lipis.dev/flags/4x3/us.svg" width="20"> English
                                </a></li>
                                <li><a class="dropdown-item d-flex align-items-center gap-3 py-2 px-3 <?= $_SESSION['lang'] == 'km' ? 'active' : '' ?>" href="<?= BASE_URL ?>/language/switch?lang=km">
                                    <img src="https://flagicons.lipis.dev/flags/4x3/kh.svg" width="20"> ភាសាខ្មែរ
                                </a></li>
                            </ul>
                        </li>

                        <!-- Notifications -->
                        <li class="nav-item dropdown px-2">
                            <a class="nav-link premium-nav-link position-relative" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-bell-fill fs-5 opacity-75"></i>
                                <span class="notification-badge">3</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 pt-0 pf-dropdown overflow-hidden" style="width: 320px;">
                                <div class="dropdown-header bg-dark text-white py-3 fw-bold d-flex justify-content-between align-items-center">
                                    <span><?= __('notifications') ?></span>
                                    <span class="badge bg-gold">3 New</span>
                                </div>
                                <div class="notification-list">
                                    <a class="dropdown-item py-3 border-bottom d-flex align-items-center gap-3" href="#!">
                                        <div class="notif-icon bg-blue"><i class="bi bi-person-plus-fill"></i></div>
                                        <div>
                                            <div class="fw-bold small">New Guest Registered</div>
                                            <div class="text-muted x-small">2 minutes ago</div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item py-3 border-bottom d-flex align-items-center gap-3" href="#!">
                                        <div class="notif-icon bg-green"><i class="bi bi-calendar-check-fill"></i></div>
                                        <div>
                                            <div class="fw-bold small">Booking Confirmed</div>
                                            <div class="text-muted x-small">1 hour ago</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="dropdown-footer text-center py-2 bg-light">
                                    <a href="#" class="text-decoration-none small fw-bold text-dark opacity-50"><?= __('view_all') ?></a>
                                </div>
                            </div>
                        </li>

                        <!-- Profile -->
                        <li class="nav-item dropdown ms-2">
                            <a class="nav-link profile-trigger d-flex align-items-center gap-2" id="userDropdown" href="#" role="button" data-bs-toggle="dropdown">
                                <div class="profile-avatar border-gold">
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['admin_name'] ?? 'Admin') ?>&background=0f172a&color=c5a059" width="35" height="35">
                                </div>
                                <div class="d-none d-md-block">
                                    <div class="fw-bold small lh-1"><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></div>
                                    <small class="text-muted x-small"><?= $_SESSION['admin_role'] ?? 'Super Admin' ?></small>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 pf-dropdown" style="min-width: 200px;">
                                <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-3" href="<?= BASE_URL ?>/admins/profile">
                                    <i class="bi bi-person-circle text-gold"></i> <?= __('profile') ?>
                                </a>
                                <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-3" href="#!">
                                    <i class="bi bi-gear-fill text-gold"></i> <?= __('settings') ?>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-3 text-danger" href="<?= BASE_URL ?>/logout">
                                    <i class="bi bi-power"></i> <?= __('logout') ?>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <style>
            .luxury-nav {
                background: rgba(255, 255, 255, 0.8) !important;
                backdrop-filter: blur(15px);
                height: 70px;
                border-color: rgba(0,0,0,0.05) !important;
                position: sticky;
                top: 0;
                z-index: 999;
            }

            .btn-toggle-sidebar {
                width: 40px;
                height: 40px;
                border-radius: 12px;
                border: 1px solid rgba(0,0,0,0.08);
                background: white;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                box-shadow: 0 4px 10px rgba(0,0,0,0.03);
            }
            .btn-toggle-sidebar:hover { transform: scale(1.05); background: #f8fafc; border-color: var(--aura-gold); color: var(--aura-gold); }

            .premium-nav-link {
                color: #475569 !important;
                font-weight: 600;
                font-size: 0.9rem;
                padding: 8px 15px !important;
                border-radius: 10px;
                transition: all 0.2s;
            }
            .premium-nav-link:hover { background: rgba(0,0,0,0.04); color: #0f172a !important; }

            .notification-badge {
                position: absolute;
                top: 5px;
                right: 5px;
                background: #ef4444;
                color: white;
                font-size: 0.65rem;
                padding: 2px 5px;
                border-radius: 50%;
                border: 2px solid white;
            }

            .profile-avatar {
                width: 40px;
                height: 40px;
                border-radius: 12px;
                overflow: hidden;
                padding: 2px;
                border: 2px solid transparent;
                transition: all 0.3s;
            }
            .profile-avatar.border-gold { border-color: rgba(197, 160, 89, 0.3); }
            .profile-trigger:hover .profile-avatar { border-color: #c5a059; transform: rotate(5deg); }

            .bg-gold { background-color: #c5a059 !important; }
            .text-gold { color: #c5a059 !important; }
            .x-small { font-size: 0.75rem; }

            .pf-dropdown { border-radius: 16px; padding: 0.5rem; }
            .pf-dropdown .dropdown-item { border-radius: 10px; font-weight: 500; font-size: 0.85rem; }
            .pf-dropdown .dropdown-item.active { background: #c5a059; color: white; }

            .notif-icon {
                width: 35px;
                height: 35px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 0.9rem;
            }
            .bg-blue { background: #3b82f6; }
            .bg-green { background: #10b981; }
            </style>
            <!-- Page content wrapper -->
            <div class="container-fluid p-4 p-md-5 flex-grow-1">
