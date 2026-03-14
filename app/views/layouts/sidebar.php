        <!-- Sidebar -->
        <div class="sidebar luxury-sidebar shadow-lg" id="sidebar-wrapper">
            <div class="sidebar-brand-container py-4 px-4">
                <div class="d-flex align-items-center">
                    <div class="brand-glass-box me-3">
                        <i class="bi bi-buildings-fill text-gold"></i>
                    </div>
                    <div>
                        <h4 class="brand-name mb-0">Aura</h4>
                        <small class="brand-subtext text-gold">Elite Control</small>
                    </div>
                </div>
            </div>
            
            <!-- User Info Sidebar -->
            <div class="sidebar-user-card mx-3 mb-4 p-3 d-flex align-items-center">
                <div class="user-avatar-container me-3">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['admin_name'] ?? 'Admin') ?>&background=c5a059&color=fff" class="rounded-circle shadow-sm" width="45" height="45">
                    <span class="status-indicator online"></span>
                </div>
                <div class="user-info overflow-hidden">
                    <h6 class="mb-0 fw-bold text-white text-truncate"><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></h6>
                    <small class="text-white-50"><?= $_SESSION['admin_role'] ?? 'Administrator' ?></small>
                </div>
            </div>

            <div class="sidebar-nav-container list-group list-group-flush pt-2">
                <div class="menu-label px-4 pb-2"><?= __('main_menu') ?></div>
                <a href="<?= BASE_URL ?>/dashboard" class="sidebar-item <?= (strpos($_SERVER['REQUEST_URI'], '/dashboard') !== false) || $_SERVER['REQUEST_URI'] == BASE_URL.'/' || $_SERVER['REQUEST_URI'] == BASE_URL ? 'active' : '' ?>">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span><?= __('dashboard') ?></span>
                </a>

                <div class="menu-label px-4 pb-2 mt-3"><?= __('inventory') ?></div>
                <a href="<?= BASE_URL ?>/floors" class="sidebar-item <?= (strpos($_SERVER['REQUEST_URI'], '/floors') !== false) ? 'active' : '' ?>">
                    <i class="bi bi-layers-half text-info"></i>
                    <span><?= __('floors') ?></span>
                </a>
                <a href="<?= BASE_URL ?>/room-types" class="sidebar-item <?= (strpos($_SERVER['REQUEST_URI'], '/room-types') !== false) ? 'active' : '' ?>">
                    <i class="bi bi-bookmark-star-fill text-warning"></i>
                    <span><?= __('room_types') ?></span>
                </a>
                <a href="<?= BASE_URL ?>/rooms" class="sidebar-item <?= (strpos($_SERVER['REQUEST_URI'], '/rooms') !== false) ? 'active' : '' ?>">
                    <i class="bi bi-door-closed-fill text-primary"></i>
                    <span><?= __('rooms') ?></span>
                </a>

                <div class="menu-label px-4 pb-2 mt-3"><?= __('operations') ?></div>
                <a href="<?= BASE_URL ?>/guests" class="sidebar-item <?= (strpos($_SERVER['REQUEST_URI'], '/guests') !== false) ? 'active' : '' ?>">
                    <i class="bi bi-people-fill text-success"></i>
                    <span><?= __('guests') ?></span>
                </a>
                <a href="<?= BASE_URL ?>/bookings" class="sidebar-item <?= (strpos($_SERVER['REQUEST_URI'], '/bookings') !== false) ? 'active' : '' ?>">
                    <i class="bi bi-calendar2-check-fill text-danger"></i>
                    <span><?= __('bookings') ?></span>
                </a>
                <a href="<?= BASE_URL ?>/payments" class="sidebar-item <?= (strpos($_SERVER['REQUEST_URI'], '/payments') !== false) ? 'active' : '' ?>">
                    <i class="bi bi-credit-card-2-front-fill text-success"></i>
                    <span><?= __('payments') ?></span>
                </a>
                <a href="<?= BASE_URL ?>/services" class="sidebar-item <?= (strpos($_SERVER['REQUEST_URI'], '/services') !== false) ? 'active' : '' ?>">
                    <i class="bi bi-box-seam-fill text-warning"></i>
                    <span><?= __('services') ?></span>
                </a>

                <div class="menu-label px-4 pb-2 mt-3"><?= __('system') ?></div>
                <a href="<?= BASE_URL ?>/admins" class="sidebar-item <?= (strpos($_SERVER['REQUEST_URI'], '/admins') !== false) ? 'active' : '' ?>">
                    <i class="bi bi-shield-lock-fill text-info"></i>
                    <span><?= __('admins') ?></span>
                </a>
            </div>
        </div>

        <style>
        :root {
            --sidebar-width: 280px;
            --gold-gradient: linear-gradient(135deg, #c5a059 0%, #a88746 100%);
            --glass-bg: rgba(15, 23, 42, 0.95);
        }

        .luxury-sidebar {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto !important;
            overflow-x: hidden !important;
            scrollbar-width: none !important; /* Firefox */
            -ms-overflow-style: none !important; /* IE and Edge */
        }

        .luxury-sidebar::-webkit-scrollbar {
            display: none !important; /* Chrome, Safari and Opera */
        }

        .brand-glass-box {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .text-gold { color: #c5a059 !important; }
        .brand-name {
            font-family: 'Playfair Display', serif !important;
            color: white !important;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 800;
        }
        .brand-subtext {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-weight: 700;
            color: #c5a059 !important;
        }

        .sidebar-user-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        .sidebar-user-card:hover { border-color: rgba(197, 160, 89, 0.3); background: rgba(255, 255, 255, 0.05); }

        .user-avatar-container { position: relative; }
        .status-indicator {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid var(--glass-bg);
        }
        .status-indicator.online { background: #22c55e; box-shadow: 0 0 10px rgba(34, 197, 94, 0.5); }

        .menu-label {
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.3);
            padding: 0 24px;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            margin: 4px 16px;
            border-radius: 14px;
            color: rgba(255, 255, 255, 0.6) !important;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-item i {
            font-size: 1.25rem;
            margin-right: 15px;
            width: 24px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .sidebar-item:hover {
            background: rgba(255, 255, 255, 0.05) !important;
            color: white !important;
            transform: translateX(5px);
        }

        .sidebar-item.active {
            background: var(--gold-gradient) !important;
            color: white !important;
            box-shadow: 0 10px 20px rgba(197, 160, 89, 0.2);
        }
        .sidebar-item.active i { color: white !important; transform: scale(1.1); }
        </style>
        
        <!-- Page Content -->
        <div id="page-content-wrapper" class="w-100 min-vh-100 d-flex flex-column">
