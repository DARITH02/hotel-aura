<div class="animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark"><?= __('dashboard') ?></h2>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 px-3 py-2 rounded-pill small">
                    <i class="bi bi-clock-history me-1"></i> <?= date('H:i') ?>
                </span>
                <p class="text-muted mb-0 small"><?= __('welcome') ?>, <span class="fw-bold text-dark"><?= htmlspecialchars($_SESSION['admin_email'] ?? 'Admin') ?></span>. <?= __('welcome_subtitle') ?></p>
            </div>
        </div>
        <div class="text-end d-none d-md-block">
            <div class="fs-5 fw-bold text-dark"><?= date('l, F j, Y') ?></div>
            <div class="small text-muted text-uppercase tracking-wider"><?= __('hotel_admin_system') ?></div>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div class="row g-4 mb-4">
        <!-- Active Bookings -->
        <div class="col-sm-6 col-xl-3 animate__animated animate__zoomIn" style="animation-delay: 0.1s;">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden stat-card glass-card">
                <div class="card-body p-4 position-relative z-1">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="stat-icon-box bg-primary-gradient shadow-primary">
                            <i class="bi bi-calendar-check-fill text-white fs-4"></i>
                        </div>
                        <div class="text-end">
                            <h6 class="text-muted fw-bold mb-1 small text-uppercase tracking-widest"><?= __('bookings') ?></h6>
                            <h2 class="fw-bold mb-0 text-dark"><?= number_format($stats['active_bookings']) ?></h2>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 mt-auto pt-2">
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill small px-2 py-1">
                            <i class="bi bi-arrow-up-short"></i> +12%
                        </span>
                        <span class="text-muted x-small">vs last week</span>
                    </div>
                </div>
                <div class="bg-pattern opacity-10"></div>
            </div>
        </div>
        
        <!-- Available Rooms -->
        <div class="col-sm-6 col-xl-3 animate__animated animate__zoomIn" style="animation-delay: 0.2s;">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden stat-card glass-card">
                <div class="card-body p-4 position-relative z-1">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="stat-icon-box bg-success-gradient shadow-success">
                            <i class="bi bi-door-open-fill text-white fs-4"></i>
                        </div>
                        <div class="text-end">
                            <h6 class="text-muted fw-bold mb-1 small text-uppercase tracking-widest"><?= __('available') ?></h6>
                            <h2 class="fw-bold mb-0 text-dark"><?= number_format($stats['available_rooms']) ?></h2>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 mt-auto pt-2">
                        <span class="text-dark fw-bold x-small"><?= round(($stats['available_rooms'] / ($stats['available_rooms'] + $stats['active_bookings'] + 1)) * 100) ?>%</span>
                        <div class="progress flex-grow-1" style="height: 4px;">
                            <div class="progress-bar bg-success" style="width: <?= ($stats['available_rooms'] / ($stats['available_rooms'] + $stats['active_bookings'] + 1)) * 100 ?>%"></div>
                        </div>
                    </div>
                </div>
                <div class="bg-pattern opacity-10"></div>
            </div>
        </div>
        
        <!-- Total Guests -->
        <div class="col-sm-6 col-xl-3 animate__animated animate__zoomIn" style="animation-delay: 0.3s;">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden stat-card glass-card">
                <div class="card-body p-4 position-relative z-1">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="stat-icon-box bg-info-gradient shadow-info">
                            <i class="bi bi-people-fill text-white fs-4"></i>
                        </div>
                        <div class="text-end">
                            <h6 class="text-muted fw-bold mb-1 small text-uppercase tracking-widest"><?= __('guests') ?></h6>
                            <h2 class="fw-bold mb-0 text-dark"><?= number_format($stats['total_guests']) ?></h2>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 mt-auto pt-2">
                        <div class="avatar-stack d-flex">
                            <div class="avatar x-small rounded-circle bg-primary text-white border-2 border-white d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 10px;">JD</div>
                            <div class="avatar x-small rounded-circle bg-success text-white border-2 border-white d-flex align-items-center justify-content-center ms-n2" style="width: 24px; height: 24px; font-size: 10px;">AK</div>
                            <div class="avatar x-small rounded-circle bg-warning text-white border-2 border-white d-flex align-items-center justify-content-center ms-n2" style="width: 24px; height: 24px; font-size: 10px;">+5</div>
                        </div>
                        <span class="text-muted x-small ms-2"><?= __('registered') ?></span>
                    </div>
                </div>
                <div class="bg-pattern opacity-10"></div>
            </div>
        </div>
        
        <!-- Today's Revenue -->
        <div class="col-sm-6 col-xl-3 animate__animated animate__zoomIn" style="animation-delay: 0.4s;">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden stat-card glass-card shine-effect">
                <div class="card-body p-4 position-relative z-1">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="stat-icon-box bg-gold-gradient shadow-gold">
                            <i class="bi bi-currency-dollar text-white fs-4"></i>
                        </div>
                        <div class="text-end">
                            <h6 class="text-muted fw-bold mb-1 small text-uppercase tracking-widest"><?= __('today_revenue') ?></h6>
                            <h2 class="fw-bold mb-0 text-primary">$<?= number_format($stats['today_revenue'], 2) ?></h2>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 mt-auto pt-2">
                        <span class="small text-muted fw-semibold"><?= date('M Y') ?> Revenue</span>
                        <i class="bi bi-graph-up-arrow text-success ms-auto"></i>
                    </div>
                </div>
                <div class="bg-pattern-gold opacity-10"></div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Revenue Trend Chart -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100 glass-card animate__animated animate__fadeInLeft" style="animation-delay: 0.5s;">
                <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1"><?= __('revenue') ?> & <?= __('bookings') ?> Trend</h5>
                        <p class="text-muted small mb-0">Monthly performance analytics at a glance.</p>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div style="height: 300px;">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Room Status Section -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 glass-card animate__animated animate__fadeInRight" style="animation-delay: 0.6s;">
                <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold mb-1"><?= __('status') ?> Overview</h5>
                    <p class="text-muted small mb-0">Real-time room availability metrics.</p>
                </div>
                <div class="card-body p-4 pt-2">
                    <?php 
                        $totalRooms = array_sum($roomStatuses);
                        $totalRoomsCount = $totalRooms > 0 ? $totalRooms : 1; 
                    ?>
                    
                    <div class="status-summary-box my-4 p-4 rounded-4 bg-light bg-opacity-50 text-center border-white border">
                        <div class="display-3 fw-extrabold text-dark mb-0 counter" data-target="<?= $totalRooms ?>"><?= $totalRooms ?></div>
                        <p class="text-muted text-uppercase tracking-widest small mb-0 fw-bold"><?= __('total_rooms') ?></p>
                    </div>
                    
                    <div class="d-flex flex-column gap-4">
                        <?php
                        $statusMeta = [
                            'available' => ['color' => '#10b981', 'gradient' => 'linear-gradient(135deg, #10b981 0%, #059669 100%)', 'icon' => 'bi-door-open'],
                            'booked' => ['color' => '#f43f5e', 'gradient' => 'linear-gradient(135deg, #f43f5e 0%, #e11d48 100%)', 'icon' => 'bi-bookmark-check'],
                            'occupied' => ['color' => '#3b82f6', 'gradient' => 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)', 'icon' => 'bi-person-check'],
                            'cleaning' => ['color' => '#f59e0b', 'gradient' => 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)', 'icon' => 'bi-stars'],
                            'maintenance' => ['color' => '#64748b', 'gradient' => 'linear-gradient(135deg, #64748b 0%, #475569 100%)', 'icon' => 'bi-tools']
                        ];
                        
                        foreach ($statusMeta as $status => $meta): 
                            $count = $roomStatuses[$status] ?? 0;
                            $percentage = round(($count / $totalRoomsCount) * 100);
                        ?>
                        <div class="progress-wrapper">
                            <div class="d-flex justify-content-between mb-2 align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="status-icon-mini" style="background: <?= $meta['color'] ?>15; color: <?= $meta['color'] ?>">
                                        <i class="bi <?= $meta['icon'] ?> small"></i>
                                    </div>
                                    <span class="text-uppercase x-small fw-800 tracking-wider text-muted"><?= __($status) ?></span>
                                </div>
                                <div class="small fw-extrabold text-dark"><?= $count ?> <span class="text-muted opacity-50 x-small px-1">/</span> <?= $percentage ?>%</div>
                            </div>
                            <div class="progress rounded-pill overflow-visible" style="height: 6px; background: rgba(0,0,0,0.03);">
                                <div class="progress-bar rounded-pill shadow-sm" role="progressbar" 
                                     style="width: <?= $percentage ?>%; background: <?= $meta['gradient'] ?>;" 
                                     aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Recent Bookings Table -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 glass-card animate__animated animate__fadeInUp" style="animation-delay: 0.7s;">
                <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1"><?= __('recent_bookings') ?></h5>
                        <p class="text-muted small mb-0">Latest reservation details.</p>
                    </div>
                    <a href="<?= BASE_URL ?>/bookings" class="btn btn-sm btn-light border rounded-pill px-3 py-2 shadow-sm fw-bold">
                        <?= __('view_all') ?> <i class="bi bi-arrow-right ms-1 text-primary"></i>
                    </a>
                </div>
                <div class="card-body p-0 mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 custom-table">
                            <thead>
                                <tr class="text-muted opacity-75 small text-uppercase tracking-wider">
                                    <th class="ps-4 py-3 fw-bold border-0"><?= __('guest') ?></th>
                                    <th class="py-3 fw-bold border-0"><?= __('room') ?></th>
                                    <th class="py-3 fw-bold border-0"><?= __('stay') ?></th>
                                    <th class="py-3 fw-bold border-0"><?= __('status') ?></th>
                                    <th class="pe-4 py-3 fw-bold border-0 text-end"><?= __('total') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($recentBookings)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                            <?= __('no_results') ?>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($recentBookings as $booking): ?>
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar rounded-3 bg-light text-primary d-flex align-items-center justify-content-center shadow-sm border" style="width: 44px; height: 44px; font-weight: 800;">
                                                    <?= strtoupper(substr($booking['guest_name'], 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark mb-0"><?= htmlspecialchars($booking['guest_name']) ?></div>
                                                    <span class="x-small text-muted tracking-widest">#<?= str_pad($booking['id'], 5, '0', STR_PAD_LEFT) ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <span class="badge bg-white text-dark border shadow-sm rounded-pill px-3 py-2 small fw-bold">
                                                <i class="bi bi-door-closed me-1 text-primary"></i> <?= htmlspecialchars($booking['room_number']) ?>
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="text-dark small fw-bold"><?= date('M d', strtotime($booking['check_in'])) ?></div>
                                                <i class="bi bi-arrow-right opacity-25 small"></i>
                                                <div class="text-dark small fw-bold"><?= date('M d', strtotime($booking['check_out'])) ?></div>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <?php 
                                                $badgeClass = 'bg-secondary';
                                                $dotClass = 'bg-secondary-pulse';
                                                if ($booking['status'] == 'pending') { $badgeClass = 'bg-warning text-dark'; $dotClass = 'bg-warning-pulse'; }
                                                if ($booking['status'] == 'confirmed') { $badgeClass = 'bg-primary'; $dotClass = 'bg-primary-pulse'; }
                                                if ($booking['status'] == 'checked_in') { $badgeClass = 'bg-success'; $dotClass = 'bg-success-pulse'; }
                                                if ($booking['status'] == 'occupied') { $badgeClass = 'bg-primary'; $dotClass = 'bg-primary-pulse'; }
                                                if ($booking['status'] == 'cancelled') { $badgeClass = 'bg-danger'; $dotClass = 'bg-danger-pulse'; }
                                            ?>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="status-dot <?= $dotClass ?>"></span>
                                                <span class="badge <?= $badgeClass ?> bg-opacity-10 text-<?= str_replace(' text-dark', '', str_replace('bg-', '', $badgeClass)) ?> border-0 text-uppercase x-small fw-800 tracking-wider p-2 px-3 rounded-pill"><?= __($booking['status']) ?></span>
                                            </div>
                                        </td>
                                        <td class="pe-4 py-3 text-end">
                                            <div class="fw-extrabold text-success fs-5">$<?= number_format($booking['total_price'], 2) ?></div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* CSS Variables for Premium Theme */
:root {
    --hotel-primary: #3b82f6;
    --hotel-primary-dark: #1d4ed8;
    --hotel-gold: #c5a059;
    --hotel-gold-dark: #a88741;
}

/* Glassmorphism Classes */
.glass-card {
    background: rgba(255, 255, 255, 0.7) !important;
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5) !important;
}

/* Stat Card specific styles */
.stat-card {
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    position: relative;
    border-bottom: 0 !important;
}
.stat-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 30px 60px -12px rgba(0,0,0,0.15) !important;
}

.stat-icon-box {
    width: 60px;
    height: 60px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Gradients */
.bg-primary-gradient { background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); }
.bg-success-gradient { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
.bg-info-gradient { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); }
.bg-gold-gradient { background: linear-gradient(135deg, #c5a059 0%, #a88741 100%); }

/* Shadows */
.shadow-primary { box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3); }
.shadow-success { box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3); }
.shadow-info { box-shadow: 0 10px 20px rgba(6, 182, 212, 0.3); }
.shadow-gold { box-shadow: 0 10px 20px rgba(197, 160, 89, 0.3); }

/* Patterns & Micro-animations */
.bg-pattern {
    position: absolute; top: 0; right: 0; width: 50%; height: 100%;
    background-image: radial-gradient(circle at 100% 0%, rgba(255,255,255,0.4) 0%, transparent 70%);
    pointer-events: none;
}
.bg-pattern-gold {
    position: absolute; top: 0; right: 0; width: 50%; height: 100%;
    background-image: radial-gradient(circle at 100% 0%, rgba(197, 160, 89, 0.2) 0%, transparent 70%);
    pointer-events: none;
}

.shine-effect {
    position: relative;
    overflow: hidden;
}
.shine-effect::after {
    content: '';
    position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
    background: linear-gradient(45deg, transparent 45%, rgba(255,255,255,0.1) 50%, transparent 55%);
    transform: rotate(-45deg);
    transition: all 0.6s;
    pointer-events: none;
    opacity: 0;
}
.shine-effect:hover::after {
    transition: all 0.6s;
    transform: translateX(100%) translateY(100%) rotate(-45deg);
    opacity: 1;
}

/* Status Pulse Dots */
.status-dot {
    width: 6px; height: 6px; border-radius: 50%; display: inline-block;
}
.bg-warning-pulse { background: #f59e0b; box-shadow: 0 0 0 rgba(245, 158, 11, 0.4); animation: pulse-warning 2s infinite; }
.bg-primary-pulse { background: #3b82f6; box-shadow: 0 0 0 rgba(59, 130, 246, 0.4); animation: pulse-primary 2s infinite; }
.bg-success-pulse { background: #10b981; box-shadow: 0 0 0 rgba(16, 185, 129, 0.4); animation: pulse-success 2s infinite; }
.bg-danger-pulse { background: #f43f5e; box-shadow: 0 0 0 rgba(244, 63, 94, 0.4); animation: pulse-danger 2s infinite; }

@keyframes pulse-primary { 0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); } 70% { box-shadow: 0 0 0 6px rgba(59, 130, 246, 0); } 100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); } }
@keyframes pulse-success { 0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); } 70% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); } 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); } }
@keyframes pulse-warning { 0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7); } 70% { box-shadow: 0 0 0 6px rgba(245, 158, 11, 0); } 100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); } }
@keyframes pulse-danger { 0% { box-shadow: 0 0 0 0 rgba(244, 63, 94, 0.7); } 70% { box-shadow: 0 0 0 6px rgba(244, 63, 94, 0); } 100% { box-shadow: 0 0 0 0 rgba(244, 63, 94, 0); } }

/* Helper classes */
.fw-800 { font-weight: 800; }
.x-small { font-size: 0.65rem; }
.avatar-stack .avatar { border: 2px solid white; transition: all 0.2s; cursor: pointer; }
.avatar-stack .avatar:hover { transform: scale(1.1) translateY(-2px); z-index: 10; font-weight: bold; }
.ms-n2 { margin-left: -10px !important; }

.hover-primary:hover {
    color: var(--hotel-primary) !important;
    text-decoration: underline !important;
}

.status-icon-mini {
    width: 24px;
    height: 24px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.custom-table tr { border-bottom: 5px solid transparent; }
.custom-table td { padding-top: 1rem; padding-bottom: 1rem; }

.modern-btn {
    transition: all 0.3s;
    border: 1px solid rgba(59, 130, 246, 0.1);
}
.modern-btn:hover {
    background-color: var(--hotel-primary);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2) !important;
}

.status-summary-box {
    background: linear-gradient(135deg, rgba(255,255,255,0.8) 0%, rgba(243,244,246,0.8) 100%);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Performance Chart Logic
    const ctx = document.getElementById('performanceChart').getContext('2d');
    const purpleGradient = ctx.createLinearGradient(0, 0, 0, 400);
    purpleGradient.addColorStop(0, 'rgba(59, 130, 246, 0.2)');
    purpleGradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Revenue ($)',
                data: [4200, 5100, 4800, 6200, 7500, 8100, 9400, 8800, 10500, 12000, 11500, 14500],
                borderColor: '#3b82f6',
                borderWidth: 3,
                backgroundColor: purpleGradient,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#3b82f6',
                pointBorderWidth: 2,
                pointHoverRadius: 6,
                yAxisID: 'y'
            }, {
                label: 'Bookings',
                data: [45, 52, 48, 65, 78, 85, 98, 92, 110, 125, 118, 150],
                borderColor: '#c5a059',
                borderWidth: 2,
                borderDash: [5, 5],
                fill: false,
                tension: 0.4,
                pointRadius: 0,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index',
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    align: 'end',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 6,
                        font: { size: 11, weight: '600' }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleFont: { size: 13, weight: 'bold' },
                    bodyFont: { size: 12 },
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) label += ': ';
                            if (context.datasetIndex === 0) label += '$' + context.parsed.y.toLocaleString();
                            else label += context.parsed.y;
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    grid: { drawBorder: false, color: 'rgba(0,0,0,0.05)' },
                    ticks: { callback: value => '$' + value / 1000 + 'k', font: { size: 11 } }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: { drawOnChartArea: false },
                    ticks: { font: { size: 11 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                }
            }
        }
    });

    // Counter Animation Logic
    const counters = document.querySelectorAll('.counter');
    const speed = 200;

    counters.forEach(counter => {
        const updateCount = () => {
            const targetStr = counter.getAttribute('data-target');
            const target = parseFloat(targetStr);
            const countStr = counter.innerText.replace('$', '').replace(',', '');
            const count = parseFloat(countStr) || 0;
            const inc = target / speed;

            if (count < target) {
                const nextCount = count + inc;
                if (targetStr.includes('.')) {
                    counter.innerText = (targetStr.startsWith('$') ? '$' : '') + nextCount.toFixed(2);
                } else {
                    counter.innerText = (targetStr.startsWith('$') ? '$' : '') + Math.ceil(nextCount);
                }
                setTimeout(updateCount, 1);
            } else {
                counter.innerText = (targetStr.startsWith('$') ? '$' : '') + target.toLocaleString(undefined, {
                    minimumFractionDigits: targetStr.includes('.') ? 2 : 0,
                    maximumFractionDigits: targetStr.includes('.') ? 2 : 0
                });
            }
        };
        updateCount();
    });
});
</script>
