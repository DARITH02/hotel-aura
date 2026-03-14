<div class="animate__animated animate__fadeIn px-lg-4">
    <!-- Premium Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-4">
        <div>
            <h2 class="mb-1 fw-extrabold text-dark d-flex align-items-center gap-3">
                <?= __('dashboard') ?>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 px-3 py-1 rounded-pill small" style="font-size: 0.8rem; letter-spacing: 1px;">
                    HOTEL INSIGHTS
                </span>
            </h2>
            <div class="d-flex align-items-center gap-3">
                <div class="luxury-clock-badge">
                    <i class="bi bi-clock-fill me-2 text-primary"></i>
                    <span id="realtimeDashboardClock" class="fw-bold"><?= date('H:i:s') ?></span>
                </div>
                <p class="text-muted mb-0 small fw-medium">
                    <?= __('welcome') ?>, <span class="fw-extrabold text-dark"><?= htmlspecialchars($_SESSION['admin_email'] ?? 'Elite Controller') ?></span>. 
                    <span class="opacity-75"><?= __('welcome_subtitle') ?></span>
                </p>
            </div>
        </div>
        <div class="text-md-end">
            <div id="realtimeDashboardDate" class="fs-4 fw-extrabold text-dark mb-0"><?= date('l, F j, Y') ?></div>
            <div class="small fw-bold text-muted text-uppercase tracking-widest opacity-50"><?= __('aura_experience') ?? 'AURA ELITE CONTROL' ?></div>
        </div>
    </div>

    <!-- Analytics Dashboard Overview -->
    <div class="row g-4 mb-5">
        <!-- Reservations Stats -->
        <div class="col-sm-6 col-xl-3 animate__animated animate__zoomIn" style="animation-delay: 0.1s;">
            <div class="premium-stat-card h-100 shine-effect">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="icon-box bg-primary-gradient shadow-primary">
                        <i class="bi bi-calendar2-check-fill"></i>
                    </div>
                    <div class="text-end">
                        <h6 class="text-muted fw-bold mb-1 small text-uppercase tracking-widest opacity-75"><?= __('bookings') ?></h6>
                        <h2 class="fw-extrabold mb-0 text-dark"><?= number_format($stats['active_bookings']) ?></h2>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 mt-auto">
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 x-small fw-extrabold">
                        <i class="bi bi-graph-up me-1"></i>+12.5%
                    </span>
                    <span class="text-muted x-small fw-bold text-uppercase tracking-wider opacity-50"><?= __('vs_last_week') ?></span>
                </div>
            </div>
        </div>
        
        <!-- Inventory Stats -->
        <div class="col-sm-6 col-xl-3 animate__animated animate__zoomIn" style="animation-delay: 0.2s;">
            <div class="premium-stat-card h-100">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="icon-box bg-success-gradient shadow-success">
                        <i class="bi bi-door-open-fill"></i>
                    </div>
                    <div class="text-end">
                        <h6 class="text-muted fw-bold mb-1 small text-uppercase tracking-widest opacity-75"><?= __('available') ?></h6>
                        <h2 class="fw-extrabold mb-0 text-dark"><?= number_format($stats['available_rooms']) ?></h2>
                    </div>
                </div>
                <?php 
                    $totalRooms = $stats['total_rooms'] ?? 0;
                    $availableRooms = $stats['available_rooms'] ?? 0;
                    $occRate = ($totalRooms > 0) ? round((($totalRooms - $availableRooms) / $totalRooms) * 100) : 0;
                ?>
                <div class="mt-auto">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="x-small fw-extrabold text-muted text-uppercase"><?= __('occupancy_rate') ?></span>
                        <span class="x-small fw-extrabold text-dark"><?= $occRate ?>%</span>
                    </div>
                    <div class="progress" style="height: 6px; border-radius: 10px; background: rgba(0,0,0,0.03);">
                        <div class="progress-bar bg-success" style="width: <?= $occRate ?>%; border-radius: 10px;"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Guest Registry Stats -->
        <div class="col-sm-6 col-xl-3 animate__animated animate__zoomIn" style="animation-delay: 0.3s;">
            <div class="premium-stat-card h-100">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="icon-box bg-info-gradient shadow-info">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="text-end">
                        <h6 class="text-muted fw-bold mb-1 small text-uppercase tracking-widest opacity-75"><?= __('guests') ?></h6>
                        <h2 class="fw-extrabold mb-0 text-dark"><?= number_format($stats['total_guests']) ?></h2>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between mt-auto">
                    <div class="avatar-group d-flex align-items-center">
                        <div class="avatar-mini bg-primary text-white border-white border-2">AD</div>
                        <div class="avatar-mini bg-dark text-white border-white border-2 ms-n2">CH</div>
                        <div class="avatar-mini bg-gold-gradient text-white border-white border-2 ms-n2">+9</div>
                    </div>
                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-1 rounded-pill x-small fw-extrabold text-uppercase tracking-wider">
                        <?= __('registered') ?>
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Financial Performance -->
        <div class="col-sm-6 col-xl-3 animate__animated animate__zoomIn" style="animation-delay: 0.4s;">
            <div class="premium-stat-card h-100 bg-dark text-white border-0 shadow-lg glow-blue">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="icon-box bg-gold-gradient shadow-gold">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="text-end">
                        <h6 class="text-white fw-bold mb-1 small text-uppercase tracking-widest opacity-50"><?= __('today_revenue') ?></h6>
                        <h2 class="fw-extrabold mb-0 text-white">$<?= number_format($stats['today_revenue'], 2) ?></h2>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 mt-auto pt-2">
                    <i class="bi bi-graph-up-arrow text-success"></i>
                    <span class="small fw-bold text-uppercase tracking-wider opacity-75"><?= date('M Y') ?> <?= __('revenue') ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <!-- Main Chart Section -->
        <div class="col-lg-8">
            <div class="premium-card h-100 animate__animated animate__fadeInLeft" style="animation-delay: 0.5s;">
                <div class="card-header bg-transparent border-0 p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-extrabold text-dark mb-1"><?= __('performance_analytics') ?></h5>
                        <p class="text-muted x-small fw-bold text-uppercase tracking-widest mb-0 opacity-75">MONTHLY FINANCIAL & BOOKING FLOW</p>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border-0 rounded-pill px-3 fw-bold" type="button" data-bs-toggle="dropdown">
                            <?= date('Y') ?> <i class="bi bi-chevron-down ms-1"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    <div style="height: 340px;">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Room Inventory Pulse -->
        <div class="col-lg-4">
            <div class="premium-card h-100 animate__animated animate__fadeInRight" style="animation-delay: 0.6s;">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-extrabold text-dark mb-1"><?= __('room_status_overview') ?></h5>
                    <p class="text-muted x-small fw-bold text-uppercase tracking-widest mb-0 opacity-75"><?= __('realtime_metrics') ?></p>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="total-rooms-center-box mb-4 py-4 rounded-4 text-center border">
                        <span class="display-4 fw-extrabold text-dark mb-0"><?= array_sum($roomStatuses) ?></span>
                        <p class="text-muted x-small fw-extrabold text-uppercase tracking-widest mb-0"><?= __('total_rooms') ?></p>
                    </div>
                    
                    <div class="d-flex flex-column gap-3">
                        <?php
                        $statusMeta = [
                            'available' => ['color' => '#10b981', 'icon' => 'bi-door-open-fill'],
                            'booked' => ['color' => '#f43f5e', 'icon' => 'bi-bookmark-star-fill'],
                            'occupied' => ['color' => '#3b82f6', 'icon' => 'bi-person-check-fill'],
                            'cleaning' => ['color' => '#f59e0b', 'icon' => 'bi-stars'],
                            'maintenance' => ['color' => '#64748b', 'icon' => 'bi-tools']
                        ];
                        
                        $maxStatus = array_sum($roomStatuses) ?: 1;
                        foreach ($statusMeta as $status => $meta): 
                            $count = $roomStatuses[$status] ?? 0;
                            $percent = round(($count / $maxStatus) * 100);
                        ?>
                        <div class="status-progress-item">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="mini-status-icon" style="background: <?= $meta['color'] ?>15; color: <?= $meta['color'] ?>">
                                        <i class="bi <?= $meta['icon'] ?>"></i>
                                    </div>
                                    <span class="x-small fw-800 text-uppercase tracking-widest text-muted"><?= __($status) ?></span>
                                </div>
                                <span class="x-small fw-extrabold text-dark"><?= $count ?> <span class="opacity-25 mx-1">/</span> <?= $percent ?>%</span>
                            </div>
                            <div class="progress" style="height: 6px; border-radius: 10px; background: rgba(0,0,0,0.03);">
                                <div class="progress-bar" style="width: <?= $percent ?>%; background: <?= $meta['color'] ?>; border-radius: 10px;"></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Log -->
    <div class="premium-card mb-5 animate__animated animate__fadeInUp" style="animation-delay: 0.7s;">
        <div class="card-header bg-transparent border-0 p-4 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-extrabold text-dark mb-1"><?= __('recent_bookings') ?></h5>
                <p class="text-muted x-small fw-bold text-uppercase tracking-widest mb-0 opacity-75">LIVE RESERVATION FEED</p>
            </div>
            <a href="<?= BASE_URL ?>/bookings" class="btn btn-luxury-action px-4 py-2 w-auto h-auto rounded-pill d-flex align-items-center gap-2">
                <span class="x-small fw-extrabold"><?= strtoupper(__('view_all')) ?></span>
                <i class="bi bi-arrow-right-short fs-5"></i>
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 luxury-table">
                <thead>
                    <tr class="bg-light bg-opacity-50">
                        <th class="ps-4 py-3 fw-extrabold x-small text-uppercase tracking-widest border-0"><?= __('guest') ?></th>
                        <th class="py-3 fw-extrabold x-small text-uppercase tracking-widest border-0"><?= __('rooms') ?></th>
                        <th class="py-3 fw-extrabold x-small text-uppercase tracking-widest border-0"><?= __('stay') ?></th>
                        <th class="py-3 fw-extrabold x-small text-uppercase tracking-widest border-0"><?= __('status') ?></th>
                        <th class="pe-4 py-3 fw-extrabold x-small text-uppercase tracking-widest border-0 text-end"><?= __('total') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($recentBookings)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-database-dash display-4 text-muted opacity-25"></i>
                                <p class="text-muted fw-bold mt-2"><?= __('no_results') ?></p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($recentBookings as $booking): ?>
                        <tr class="booking-luxury-row">
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="guest-avatar-box rounded-circle bg-light border border-2 border-white shadow-sm d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($booking['guest_name']) ?>&background=f8fafc&color=1e293b&size=44" class="rounded-circle" width="40" height="40" alt="">
                                    </div>
                                    <div>
                                        <div class="fw-extrabold text-dark mb-0 d-flex align-items-center gap-2">
                                            <?= htmlspecialchars($booking['guest_name']) ?>
                                            <?php if (!empty($booking['telegram_chat_id'])): ?>
                                                <i class="bi bi-telegram text-info fs-x-small"></i>
                                            <?php endif; ?>
                                        </div>
                                        <span class="x-small text-muted fw-bold text-uppercase tracking-widest opacity-50">ID #<?= str_pad($booking['id'], 5, '0', STR_PAD_LEFT) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-white text-dark border shadow-xs rounded-pill px-3 py-2 x-small fw-extrabold">
                                    <i class="bi bi-door-closed-fill text-primary me-1"></i> <?= htmlspecialchars($booking['room_number']) ?>
                                </span>
                            </td>
                            <td class="py-3">
                                <div class="stay-capsule py-1 px-2" style="width: fit-content;">
                                    <div class="stay-date x-small"><?= date('d M', strtotime($booking['check_in'])) ?></div>
                                    <div class="stay-arrow x-small px-1"><i class="bi bi-arrow-right"></i></div>
                                    <div class="stay-date x-small"><?= date('d M', strtotime($booking['check_out'])) ?></div>
                                </div>
                            </td>
                            <td class="py-3">
                                <?php 
                                    $statusConfig = [
                                        'pending' => ['bg' => 'warning', 'pulse' => true],
                                        'confirmed' => ['bg' => 'primary', 'pulse' => false],
                                        'occupied' => ['bg' => 'info', 'pulse' => true],
                                        'checked_in' => ['bg' => 'success', 'pulse' => true],
                                        'checked_out' => ['bg' => 'secondary', 'pulse' => false],
                                        'cancelled' => ['bg' => 'danger', 'pulse' => false]
                                    ];
                                    $cfg = $statusConfig[$booking['status']] ?? ['bg' => 'secondary', 'pulse' => false];
                                ?>
                                <div class="d-inline-flex align-items-center gap-2 px-2 py-1 rounded-pill bg-<?= $cfg['bg'] ?> bg-opacity-10 border border-<?= $cfg['bg'] ?> border-opacity-10">
                                    <div class="status-dot-premium bg-<?= $cfg['bg'] ?> <?= $cfg['pulse'] ? 'pulse-'.$cfg['bg'] : '' ?>" style="width: 6px; height: 6px;"></div>
                                    <span class="x-small fw-extrabold text-<?= $cfg['bg'] ?> text-uppercase tracking-wider"><?= __($booking['status']) ?></span>
                                </div>
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <div class="fw-extrabold text-dark fs-6">$<?= number_format($booking['total_price'], 2) ?></div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/* LUXURY DASHBOARD STYLES */
.fw-extrabold { font-weight: 800; }
.fw-800 { font-weight: 800; }
.tracking-widest { letter-spacing: 0.15em; }
.fs-x-small { font-size: 0.6rem; }
.x-small { font-size: 0.7rem; }
.ms-n2 { margin-left: -12px !important; }

.luxury-clock-badge {
    background: white;
    padding: 6px 16px;
    border-radius: 100px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.03);
    font-size: 0.85rem;
    color: #1e293b;
}

.premium-card {
    background: #ffffff;
    border: none;
    border-radius: 24px;
    box-shadow: 0 10px 40px -10px rgba(0,0,0,0.04);
    overflow: hidden;
}

.premium-stat-card {
    background: #ffffff;
    padding: 1.75rem;
    border-radius: 24px;
    box-shadow: 0 10px 40px -10px rgba(0,0,0,0.04);
    border: 1px solid rgba(0,0,0,0.02);
    transition: all 0.3s ease;
}
.premium-stat-card:hover { transform: translateY(-5px); box-shadow: 0 20px 50px -15px rgba(0,0,0,0.1); }

.icon-box {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.4rem;
}

.bg-primary-gradient { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); }
.bg-success-gradient { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
.bg-info-gradient { background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); }
.bg-gold-gradient { background: linear-gradient(135deg, #c5a059 0%, #a88746 100%); }

.shadow-primary { box-shadow: 0 12px 20px -5px rgba(30, 41, 59, 0.3); }
.shadow-success { box-shadow: 0 12px 20px -5px rgba(16, 185, 129, 0.3); }
.shadow-info { box-shadow: 0 12px 20px -5px rgba(14, 165, 233, 0.3); }
.shadow-gold { box-shadow: 0 12px 20px -5px rgba(197, 160, 89, 0.3); }

.glow-blue { box-shadow: 0 15px 40px -10px rgba(0,0,0,0.3), 0 0 20px rgba(30, 41, 59, 0.2); }

.avatar-mini {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.6rem;
    font-weight: 800;
}

.total-rooms-center-box {
    background: #f8fafc;
    border-color: #e2e8f0 !important;
}

.mini-status-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
}

.luxury-table thead th {
    font-size: 0.65rem;
    letter-spacing: 0.1em;
    color: #64748b;
}
.booking-luxury-row {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f8fafc;
}
.booking-luxury-row:hover { background-color: #f8fafc; }

.btn-luxury-action {
    background: #f1f5f9;
    color: #1e293b;
    border: none;
    transition: all 0.3s;
}
.btn-luxury-action:hover { background: #1e293b; color: white; transform: scale(1.05); }

/* Animation Overrides */
.pulse-primary { animation: pulse-primary 2s infinite; }
.pulse-warning { animation: pulse-warning 2s infinite; }
.pulse-info { animation: pulse-info 2s infinite; }
.pulse-success { animation: pulse-success 2s infinite; }

@keyframes pulse-primary { 0% { box-shadow: 0 0 0 0 rgba(30, 41, 59, 0.4); } 70% { box-shadow: 0 0 0 6px rgba(30, 41, 59, 0); } 100% { box-shadow: 0 0 0 0 rgba(30, 41, 59, 0); } }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('performanceChart').getContext('2d');
    const blueGradient = ctx.createLinearGradient(0, 0, 0, 400);
    blueGradient.addColorStop(0, 'rgba(30, 41, 59, 0.1)');
    blueGradient.addColorStop(1, 'rgba(30, 41, 59, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: '<?= __('revenue') ?> ($)',
                data: [4200, 5100, 4800, 6200, 7500, 8100, 9400, 8800, 10500, 12000, 11500, 14500],
                borderColor: '#1e293b',
                borderWidth: 4,
                backgroundColor: blueGradient,
                fill: true,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 6,
                yAxisID: 'y'
            }, {
                label: '<?= __('bookings') ?>',
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
            plugins: {
                legend: { display: true, position: 'top', align: 'end', labels: { usePointStyle: true, font: { size: 11, weight: '800' } } },
                tooltip: { backgroundColor: '#1e293b', titleFont: { weight: 'bold' }, padding: 12, displayColors: false }
            },
            scales: {
                y: { display: true, grid: { color: 'rgba(0,0,0,0.03)' }, ticks: { font: { weight: 'bold' }, callback: v => '$' + v/1000 + 'k' } },
                y1: { position: 'right', display: true, grid: { display: false } },
                x: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
            }
        }
    });

    setInterval(function() {
        const now = new Date();
        const clock = document.getElementById('realtimeDashboardClock');
        if (clock) clock.textContent = now.toLocaleTimeString('en-US', { hour12: false });
    }, 1000);
});
</script>
