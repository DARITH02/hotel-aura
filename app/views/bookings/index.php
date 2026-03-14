<div class="animate__animated animate__fadeIn px-lg-4">
    <!-- Header Strategy -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-4">
        <div>
            <h2 class="mb-1 fw-extrabold text-dark d-flex align-items-center gap-3">
                <?= __('manage_bookings') ?>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1 rounded-pill small" style="font-size: 0.8rem;">
                    <?= number_format($stats['total_bookings']) ?> <?= strtoupper(__('reservations')) ?>
                </span>
            </h2>
            <p class="text-muted small mb-0 fw-medium"><?= __('bookings_subtitle') ?? 'Monitor and manage all hotel reservations and guest stays.' ?></p>
        </div>
        
        <div class="d-flex gap-3 flex-wrap align-items-center">
            <div class="premium-search-box shadow-sm border rounded-pill overflow-hidden bg-white d-flex align-items-center px-3" style="min-width: 320px; height: 48px;">
                <i class="bi bi-search text-primary opacity-50 me-2"></i>
                <input type="text" id="bookingSearchInput" class="form-control border-0 shadow-none bg-transparent ps-0" placeholder="<?= __('search_bookings') ?>..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <?php if (!empty($_GET['search'])): ?>
                    <a href="<?= BASE_URL ?>/bookings" class="btn btn-link text-danger p-0 ms-2">
                        <i class="bi bi-x-circle-fill opacity-50"></i>
                    </a>
                <?php endif; ?>
            </div>
            <a href="<?= BASE_URL ?>/bookings/create" class="btn btn-primary shadow-primary px-4 py-2 d-flex align-items-center gap-2 rounded-pill fw-bold h-48">
                <i class="bi bi-plus-lg fs-5"></i>
                <span><?= __('create_booking') ?></span>
            </a>
        </div>
    </div>

    <!-- Premium Stats Row -->
    <div class="row g-4 mb-5 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
        <div class="col-sm-6 col-xl-4">
            <div class="premium-stat-card">
                <div class="d-flex justify-content-between mb-3">
                    <div class="icon-box bg-primary-gradient shadow-primary">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 rounded-pill px-2 py-1 align-self-start small"><?= strtoupper(__('reservations')) ?></span>
                </div>
                <h6 class="text-muted small fw-bold text-uppercase opacity-75 mb-1"><?= __('total_bookings') ?? 'Total Bookings' ?></h6>
                <h3 class="fw-extrabold mb-0 text-dark"><?= number_format($stats['total_bookings']) ?></h3>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="premium-stat-card">
                <div class="d-flex justify-content-between mb-3">
                    <div class="icon-box bg-info-gradient shadow-info">
                        <i class="bi bi-moon-stars-fill"></i>
                    </div>
                </div>
                <h6 class="text-muted small fw-bold text-uppercase opacity-75 mb-1"><?= __('total_nights') ?? 'Total Nights' ?></h6>
                <h3 class="fw-extrabold mb-0 text-dark"><?= number_format($stats['total_nights']) ?></h3>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="premium-stat-card">
                <div class="d-flex justify-content-between mb-3">
                    <div class="icon-box bg-gold-gradient shadow-gold">
                        <i class="bi bi-bank2"></i>
                    </div>
                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-10 rounded-pill px-2 py-1 align-self-start small"><?= strtoupper(__('revenue')) ?></span>
                </div>
                <h6 class="text-muted small fw-bold text-uppercase opacity-75 mb-1"><?= __('total_revenue') ?></h6>
                <h3 class="fw-extrabold mb-0 text-dark">$<?= number_format($stats['total_revenue'], 2) ?></h3>
            </div>
        </div>
    </div>

    <!-- Booking Registry Table -->
    <div class="premium-card mb-5 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle luxury-table" id="bookingTable">
                    <thead>
                        <tr class="text-muted x-small text-uppercase tracking-widest bg-light bg-opacity-50">
                            <th class="ps-4 py-4 fw-extrabold border-0"><?= __('id') ?></th>
                            <th class="py-4 fw-extrabold border-0"><?= __('guests') ?></th>
                            <th class="py-4 fw-extrabold border-0"><?= __('rooms') ?></th>
                            <th class="py-4 fw-extrabold border-0"><?= __('stay_dates') ?></th>
                            <th class="py-4 fw-extrabold border-0"><?= __('financials') ?></th>
                            <th class="py-4 fw-extrabold border-0"><?= __('status') ?></th>
                            <th class="text-end pe-4 py-4 fw-extrabold border-0"><?= __('actions') ?></th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php if (empty($bookings)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-5 opacity-50">
                                    <i class="bi bi-calendar-x display-1 text-muted mb-3 d-block"></i>
                                    <h5 class="fw-bold text-muted"><?= __('no_results') ?></h5>
                                    <p class="small text-muted mb-0">No booking records found matching your criteria</p>
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($bookings as $booking): ?>
                            <tr class="booking-luxury-row" id="row-<?= $booking['id'] ?>">
                                <td class="ps-4 py-4">
                                    <span class="fw-extrabold text-muted x-small">#<?= str_pad($booking['id'], 5, '0', STR_PAD_LEFT) ?></span>
                                </td>
                                <td class="py-4">
                                    <div class="d-flex align-items-center">
                                        <div class="guest-avatar-box me-3 rounded-circle shadow-sm border border-2 border-white overflow-hidden d-flex align-items-center justify-content-center bg-light" style="width: 52px; height: 52px;">
                                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($booking['guest_name']) ?>&background=f1f5f9&color=1f2937&font-size=0.4" width="52" height="52" alt="">
                                        </div>
                                        <div>
                                            <div class="fw-extrabold text-dark mb-1 d-flex align-items-center gap-2">
                                                <?= htmlspecialchars($booking['guest_name']) ?>
                                                <?php if ($booking['online_book']): ?>
                                                    <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-10 d-flex align-items-center gap-1" style="font-size: 0.6rem; font-weight: 800;" title="Website Booking">
                                                        <i class="bi bi-globe fs-x-small"></i>
                                                    </span>
                                                <?php endif; ?>
                                                <?php if (!empty($booking['telegram_chat_id'])): ?>
                                                     <span class="badge rounded-pill bg-info bg-opacity-10 text-info border border-info border-opacity-10 d-flex align-items-center gap-1" style="font-size: 0.6rem; font-weight: 800;" title="Linked with Telegram">
                                                         <i class="bi bi-telegram fs-x-small"></i> <?= strtoupper(__('online')) ?>
                                                     </span>
                                                 <?php endif; ?>
                                            </div>
                                            <div class="x-small text-muted fw-bold text-uppercase tracking-wider">
                                                <i class="bi bi-telephone-fill me-1 opacity-50"></i><?= htmlspecialchars($booking['guest_phone'] ?: 'N/A') ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <div class="d-flex flex-column">
                                        <div class="badge bg-white text-dark border shadow-xs rounded-pill px-3 py-2 x-small fw-extrabold d-inline-flex align-items-center gap-2 mb-1" style="width: fit-content;">
                                            <i class="bi bi-door-closed-fill text-primary"></i> <?= htmlspecialchars($booking['room_number']) ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="stay-capsule">
                                            <div class="stay-date"><?= date('d M', strtotime($booking['check_in'])) ?></div>
                                            <div class="stay-arrow"><i class="bi bi-arrow-right"></i></div>
                                            <div class="stay-date"><?= date('d M', strtotime($booking['check_out'])) ?></div>
                                        </div>
                                        <?php 
                                            $checkInDay = new DateTime($booking['check_in']);
                                            $checkOutDay = new DateTime($booking['check_out']);
                                            $diffNights = $checkInDay->diff($checkOutDay)->days;
                                        ?>
                                        <div class="x-small fw-extrabold text-muted text-uppercase tracking-widest"><?= $diffNights ?><?= strtoupper(__('night')[0]) ?></div>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <div class="fw-extrabold text-dark fs-5">$<?= number_format($booking['total_price'], 2) ?></div>
                                    <div class="x-small text-muted fw-bold text-uppercase tracking-wider">
                                        $<?= number_format($booking['nightly_price'] ?? 0, 2) ?> / <?= strtoupper(__('night')) ?>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <?php 
                                        $statusConfig = [
                                            'pending' => ['bg' => 'warning', 'pulse' => true, 'icon' => 'bi-clock-history'],
                                            'confirmed' => ['bg' => 'primary', 'pulse' => false, 'icon' => 'bi-calendar-check-fill'],
                                            'occupied' => ['bg' => 'info', 'pulse' => true, 'icon' => 'bi-key-fill'],
                                            'checked_in' => ['bg' => 'success', 'pulse' => true, 'icon' => 'bi-person-check-fill'],
                                            'checked_out' => ['bg' => 'secondary', 'pulse' => false, 'icon' => 'bi-door-closed-fill'],
                                            'cancelled' => ['bg' => 'danger', 'pulse' => false, 'icon' => 'bi-x-circle-fill']
                                        ];
                                        $cfg = $statusConfig[$booking['status']] ?? ['bg' => 'secondary', 'pulse' => false, 'icon' => 'bi-info-circle'];
                                        $pulseClass = $cfg['pulse'] ? 'pulse-' . $cfg['bg'] : '';
                                    ?>
                                    <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-<?= $cfg['bg'] ?> bg-opacity-10 border border-<?= $cfg['bg'] ?> border-opacity-10">
                                        <div class="status-dot-premium bg-<?= $cfg['bg'] ?> <?= $pulseClass ?>"></div>
                                        <span class="x-small fw-extrabold text-<?= $cfg['bg'] ?> text-uppercase tracking-wider"><?= __($booking['status']) ?></span>
                                    </div>
                                </td>
                                <td class="text-end pe-4 py-4">
                                    <div class="dropdown">
                                        <button class="btn btn-luxury-action" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2 animate__animated animate__fadeIn animate__faster">
                                            <li><a class="dropdown-item py-2 px-3 rounded-3 text-dark fw-bold d-flex align-items-center gap-2" href="<?= BASE_URL ?>/bookings/show?id=<?= $booking['id'] ?>"><i class="bi bi-eye-fill text-primary"></i><?= __('details') ?></a></li>
                                            <li><hr class="dropdown-divider opacity-50"></li>
                                            <?php if ($booking['status'] == 'pending'): ?>
                                                <li><a class="dropdown-item py-2 px-3 rounded-3 text-primary fw-bold d-flex align-items-center gap-2 ajax-action" href="<?= BASE_URL ?>/bookings/confirm?id=<?= $booking['id'] ?>"><i class="bi bi-calendar-check-fill"></i><?= __('confirm') ?></a></li>
                                            <?php endif; ?>
                                            <?php if ($booking['status'] == 'confirmed'): ?>
                                                <li><a class="dropdown-item py-2 px-3 rounded-3 text-success fw-bold d-flex align-items-center gap-2 ajax-action" href="<?= BASE_URL ?>/bookings/check-in?id=<?= $booking['id'] ?>"><i class="bi bi-person-check-fill"></i><?= __('check_in') ?></a></li>
                                            <?php endif; ?>
                                            <?php if (in_array($booking['status'], ['checked_in', 'occupied'])): ?>
                                                <li><a class="dropdown-item py-2 px-3 rounded-3 text-danger fw-bold d-flex align-items-center gap-2 ajax-action" href="<?= BASE_URL ?>/bookings/check-out?id=<?= $booking['id'] ?>"><i class="bi bi-door-closed-fill"></i><?= __('check_out') ?></a></li>
                                            <?php endif; ?>
                                            <?php if (!in_array($booking['status'], ['cancelled', 'checked_out'])): ?>
                                                <li><a class="dropdown-item py-2 px-3 rounded-3 text-muted fw-bold d-flex align-items-center gap-2 ajax-action" href="<?= BASE_URL ?>/bookings/cancel?id=<?= $booking['id'] ?>" data-row-id="row-<?= $booking['id'] ?>"><i class="bi bi-trash3-fill text-danger"></i><?= strtoupper(__('cancel')) ?></a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
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

<style>
/* LUXURY BOOKING REGISTRY STYLES */
.fw-extrabold { font-weight: 800; }
.fw-800 { font-weight: 800; }
.shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
.shadow-primary { box-shadow: 0 10px 25px -5px rgba(31, 41, 55, 0.2); }
.shadow-info { box-shadow: 0 10px 25px -5px rgba(6, 182, 212, 0.2); }
.shadow-gold { box-shadow: 0 10px 25px -5px rgba(197, 160, 89, 0.2); }

.bg-primary-gradient { background: linear-gradient(135deg, #1f2937 0%, #111827 100%); }
.bg-info-gradient { background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); }
.bg-gold-gradient { background: linear-gradient(135deg, #c5a059 0%, #a88746 100%); }

.premium-card {
    background: #ffffff;
    border: none;
    border-radius: 24px;
    box-shadow: 0 10px 40px -10px rgba(0,0,0,0.05);
    overflow: hidden;
}

.premium-stat-card {
    background: #ffffff;
    padding: 1.75rem;
    border-radius: 24px;
    box-shadow: 0 10px 40px -10px rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.02);
    transition: transform 0.3s ease;
}
.premium-stat-card:hover { transform: translateY(-5px); }

.icon-box {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
}

.premium-search-box {
    border: 1.5px solid #eee;
    transition: all 0.3s ease;
}
.premium-search-box:focus-within {
    border-color: var(--bs-primary);
    box-shadow: 0 10px 20px -10px rgba(31, 41, 55, 0.1) !important;
}

.luxury-table thead th {
    letter-spacing: 0.1em;
    font-size: 0.7rem;
    color: #64748b;
}

.booking-luxury-row {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f8fafc;
}
.booking-luxury-row:hover {
    background-color: #f8fafc;
}

.stay-capsule {
    display: flex;
    align-items: center;
    background: #f1f5f9;
    padding: 4px 12px;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
}
.stay-date {
    font-size: 0.8rem;
    font-weight: 800;
    color: #1e293b;
}
.stay-arrow {
    padding: 0 8px;
    font-size: 0.7rem;
    color: #94a3b8;
}

.status-dot-premium {
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.pulse-primary { animation: pulse-primary 2s infinite; }
.pulse-warning { animation: pulse-warning 2s infinite; }
.pulse-info { animation: pulse-info 2s infinite; }
.pulse-success { animation: pulse-success 2s infinite; }

@keyframes pulse-primary { 0% { box-shadow: 0 0 0 0 rgba(31, 41, 55, 0.4); } 70% { box-shadow: 0 0 0 6px rgba(31, 41, 55, 0); } 100% { box-shadow: 0 0 0 0 rgba(31, 41, 55, 0); } }
@keyframes pulse-warning { 0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); } 70% { box-shadow: 0 0 0 6px rgba(245, 158, 11, 0); } 100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); } }
@keyframes pulse-info { 0% { box-shadow: 0 0 0 0 rgba(14, 165, 233, 0.4); } 70% { box-shadow: 0 0 0 6px rgba(14, 165, 233, 0); } 100% { box-shadow: 0 0 0 0 rgba(14, 165, 233, 0); } }
@keyframes pulse-success { 0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); } 70% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); } 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); } }

.btn-luxury-action {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    border: 1px solid #f1f5f9;
    background: white;
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}
.btn-luxury-action:hover {
    background: #1f2937;
    color: white;
    border-color: #1f2937;
    transform: translateY(-2px);
}

.fs-x-small { font-size: 0.6rem; }
.x-small { font-size: 0.75rem; }
.tracking-widest { letter-spacing: 0.15em; }
.h-48 { height: 48px; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof initTableSearch === 'function') {
        initTableSearch('#bookingSearchInput', '#bookingTable');
    }
});
</script>
