<?php 
    // Data Preparation
    $start = new DateTime($booking['check_in']);
    $end = new DateTime($booking['check_out']);
    $nights = $start->diff($end)->days;
    if ($nights == 0) $nights = 1; // Minimum 1 night
    
    $paidAmount = 0;
    foreach($payments as $pmt) $paidAmount += $pmt['amount'];
    $balance = $booking['total_price'] - $paidAmount;
    
    $serviceTotal = 0;
    foreach($services as $svc) $serviceTotal += ($svc['price'] * $svc['quantity']);
    
    $baseRoomPrice = $booking['total_price'] - $serviceTotal;

    $statusColors = [
        'pending' => ['bg' => 'warning', 'icon' => 'hourglass-split', 'label' => __('pending')],
        'confirmed' => ['bg' => 'primary', 'icon' => 'calendar-check-fill', 'label' => __('confirmed')],
        'occupied' => ['bg' => 'info', 'icon' => 'door-open-fill', 'label' => __('occupied')],
        'checked_out' => ['bg' => 'secondary', 'icon' => 'receipt', 'label' => __('checked_out')],
        'cancelled' => ['bg' => 'danger', 'icon' => 'x-circle-fill', 'label' => __('cancelled')]
    ];
    $st = $statusColors[$booking['status']] ?? ['bg' => 'dark', 'icon' => 'info-circle', 'label' => $booking['status']];
?>

<div class="animate__animated animate__fadeIn px-lg-4">
    <!-- Header Strategy -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-4">
        <div class="d-flex align-items-center gap-3">
            <a href="<?= BASE_URL ?>/bookings" class="premium-back-btn">
                <i class="bi bi-chevron-left"></i>
            </a>
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/bookings" class="text-decoration-none text-muted small fw-bold text-uppercase"><?= __('bookings') ?></a></li>
                        <li class="breadcrumb-item active small fw-bold text-uppercase" aria-current="page">#<?= $booking['id'] ?></li>
                    </ol>
                </nav>
                <h2 class="mb-0 fw-extrabold text-dark d-flex align-items-center gap-3">
                    <?= __('booking_details') ?> 
                    <span class="badge bg-<?= $st['bg'] ?> bg-opacity-10 text-<?= $st['bg'] ?> border border-<?= $st['bg'] ?> border-opacity-25 px-3 py-1 rounded-pill small" style="font-size: 0.8rem;">
                        <i class="bi bi-<?= $st['icon'] ?> me-1"></i> <?= strtoupper($st['label']) ?>
                    </span>
                    <?php if ($booking['online_book']): ?>
                        <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-25 py-1 px-2 d-flex align-items-center gap-1" style="font-size: 0.65rem; font-weight: 800;" title="Website Booking">
                            <i class="bi bi-globe"></i> WEB
                        </span>
                    <?php endif; ?>
                </h2>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-premium-outline d-flex align-items-center gap-2" onclick="window.print()">
                <i class="bi bi-printer"></i> <?= __('print') ?? 'Print' ?>
            </button>
            <?php if ($booking['status'] == 'pending'): ?>
                <a href="<?= BASE_URL ?>/bookings/confirm?id=<?= $booking['id'] ?>" class="btn btn-primary shadow-sm px-4 ajax-action">
                    <i class="bi bi-calendar-check-fill me-1"></i> <?= __('confirm') ?>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Financial Overview Cards -->
    <div class="row g-4 mb-5 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
        <div class="col-sm-6 col-xl-3">
            <div class="premium-stat-card">
                <div class="d-flex justify-content-between mb-3">
                    <div class="icon-box bg-primary-gradient shadow-primary">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
                <h6 class="text-muted small fw-bold text-uppercase opacity-75 mb-1"><?= __('total_price') ?></h6>
                <h3 class="fw-extrabold mb-0 text-dark">$<?= number_format($booking['total_price'], 2) ?></h3>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="premium-stat-card">
                <div class="d-flex justify-content-between mb-3">
                    <div class="icon-box bg-success-gradient shadow-success">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>
                <h6 class="text-muted small fw-bold text-uppercase opacity-75 mb-1"><?= __('amount_paid') ?></h6>
                <h3 class="fw-extrabold mb-0 text-success">$<?= number_format($paidAmount, 2) ?></h3>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="premium-stat-card">
                <div class="d-flex justify-content-between mb-3">
                    <div class="icon-box bg-<?= $balance > 0 ? 'danger' : 'success' ?>-gradient shadow-<?= $balance > 0 ? 'danger' : 'success' ?>">
                        <i class="bi bi-bank"></i>
                    </div>
                </div>
                <h6 class="text-muted small fw-bold text-uppercase opacity-75 mb-1"><?= __('remaining_balance') ?></h6>
                <h3 class="fw-extrabold mb-0 text-<?= $balance > 0 ? 'danger' : 'success' ?>">$<?= number_format($balance, 2) ?></h3>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="premium-stat-card">
                <div class="d-flex justify-content-between mb-3">
                    <div class="icon-box bg-gold-gradient shadow-gold">
                        <i class="bi bi-stars"></i>
                    </div>
                </div>
                <h6 class="text-muted small fw-bold text-uppercase opacity-75 mb-1"><?= __('services') ?></h6>
                <h3 class="fw-extrabold mb-0 text-dark"><?= count($services) ?> <?= __('items') ?? 'Items' ?></h3>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Stay Timeline & Details -->
            <div class="premium-card mb-4 animate__animated animate__fadeInLeft" style="animation-delay: 0.2s;">
                <div class="card-header border-0 bg-transparent py-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-extrabold text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-calendar-range text-primary"></i> <?= __('stay_details') ?>
                    </h5>
                    <span class="badge bg-light text-dark rounded-pill px-3 py-2 border shadow-xs fw-bold">
                        <?= $nights ?> <?= $nights > 1 ? __('nights') : __('night') ?>
                    </span>
                </div>
                <div class="card-body px-4 pb-5 pt-0">
                    <div class="row g-0 stay-timeline justify-content-between align-items-center position-relative my-4">
                        <div class="col-md-5 text-center px-4">
                            <div class="timeline-point check-in-point animate__animated animate__pulse animate__infinite">
                                <div class="date-number"><?= date('d', strtotime($booking['check_in'])) ?></div>
                                <div class="date-month text-uppercase fw-bold opacity-75"><?= date('M Y', strtotime($booking['check_in'])) ?></div>
                                <div class="badge bg-success bg-opacity-10 text-success mt-2 rounded-pill px-3"><?= __('check_in') ?></div>
                                <div class="small fw-bold text-muted mt-2"><i class="bi bi-clock"></i> 14:00</div>
                            </div>
                        </div>
                        <div class="col-md-2 d-none d-md-flex justify-content-center">
                            <div class="timeline-arrow">
                                <i class="bi bi-arrow-right-circle-fill text-primary display-6"></i>
                            </div>
                        </div>
                        <div class="col-md-5 text-center px-4">
                            <div class="timeline-point check-out-point">
                                <div class="date-number"><?= date('d', strtotime($booking['check_out'])) ?></div>
                                <div class="date-month text-uppercase fw-bold opacity-75"><?= date('M Y', strtotime($booking['check_out'])) ?></div>
                                <div class="badge bg-danger bg-opacity-10 text-danger mt-2 rounded-pill px-3"><?= __('check_out') ?></div>
                                <div class="small fw-bold text-muted mt-2"><i class="bi bi-clock"></i> 11:00</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guest Profile -->
            <div class="premium-card mb-4 animate__animated animate__fadeInLeft" style="animation-delay: 0.3s;">
                <div class="card-header border-0 bg-transparent py-4 px-4">
                    <h5 class="mb-0 fw-extrabold text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-person-bounding-box text-primary"></i> <?= __('guest_info') ?>
                    </h5>
                </div>
                <div class="card-body px-4 pb-4 pt-0">
                    <div class="guest-profile-container d-flex flex-column flex-md-row gap-4 align-items-start p-4 bg-light bg-opacity-50 rounded-4 border border-white">
                        <div class="guest-avatar-large shadow-lg bg-primary-gradient text-white">
                            <?= strtoupper($booking['guest_name'][0]) ?>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h4 class="fw-extrabold text-dark mb-1"><?= htmlspecialchars($booking['guest_name']) ?></h4>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <span class="badge bg-white text-dark shadow-xs rounded-pill px-3 py-1 border small">
                                            <i class="bi bi-telephone text-primary me-1"></i> <?= htmlspecialchars($booking['guest_phone']) ?>
                                        </span>
                                        <span class="badge bg-white text-dark shadow-xs rounded-pill px-3 py-1 border small">
                                            <i class="bi bi-envelope text-primary me-1"></i> <?= htmlspecialchars($booking['guest_email'] ?: 'N/A') ?>
                                        </span>
                                    </div>
                                </div>
                                <?php if (!empty($booking['telegram_chat_id'])): ?>
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-2 rounded-pill fw-extrabold d-flex align-items-center gap-1">
                                        <i class="bi bi-telegram fs-6"></i> LINKED
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="mt-4 pt-4 border-top border-white d-flex gap-3">
                                <a href="<?= BASE_URL ?>/guests/edit?id=<?= $booking['guest_id'] ?>" class="btn btn-sm btn-light border rounded-pill px-3">
                                    <i class="bi bi-pencil-square me-1"></i> Edit Profile
                                </a>
                                <a href="https://wa.me/<?= str_replace(['+',' ','-'], '', $booking['guest_phone']) ?>" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                    <i class="bi bi-whatsapp me-1"></i> WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions & Billing -->
        <div class="col-lg-4">
            <!-- Room Designation Card -->
            <div class="room-key-card mb-4 animate__animated animate__fadeInRight" style="animation-delay: 0.2s;">
                <div class="card-body p-4 text-center">
                    <div class="mb-4">
                        <div class="room-icon-outer mx-auto bg-white bg-opacity-20 rounded-pill d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="bi bi-key-fill text-white display-5"></i>
                        </div>
                    </div>
                    <label class="text-white text-opacity-50 small fw-bold text-uppercase tracking-widest mb-1"><?= __('room_assigned') ?></label>
                    <h1 class="display-3 fw-extrabold text-white mb-0">#<?= $booking['room_number'] ?></h1>
                    <div class="text-gold fw-extrabold text-uppercase mb-4" style="color: #f59e0b; letter-spacing: 2px;"><?= $booking['room_type'] ?></div>
                    
                    <div class="d-flex justify-content-between p-3 bg-white bg-opacity-10 rounded-3 text-white border border-white border-opacity-10 shadow-inner">
                        <span class="small fw-bold"><?= __('nightly_rate') ?></span>
                        <span class="fw-extrabold fs-5">$<?= number_format($booking['room_price'], 2) ?></span>
                    </div>
                </div>
                <!-- Abstract pattern overlay -->
                <div class="pattern-overlay"></div>
            </div>

            <!-- Detailed Billing Card -->
            <div class="premium-card mb-4 animate__animated animate__fadeInRight" style="animation-delay: 0.3s;">
                <div class="card-header border-0 bg-transparent py-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-extrabold text-dark"><?= __('bill_summary') ?></h5>
                    <button class="btn btn-sm btn-primary-soft rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                        <i class="bi bi-plus-lg me-1"></i> <?= __('add') ?? 'Add' ?>
                    </button>
                </div>
                <div class="card-body px-4 pb-4 pt-0">
                    <div class="billing-items mb-4">
                        <!-- Accommodation -->
                        <div class="billing-item d-flex justify-content-between align-items-center p-3 mb-2 rounded-3 border-start border-4 border-primary">
                            <div>
                                <div class="fw-extrabold text-dark small"><?= __('accommodation') ?></div>
                                <div class="x-small text-muted"><?= $nights ?> <?= __('nights') ?> x $<?= number_format($booking['room_price'], 2) ?></div>
                            </div>
                            <span class="fw-extrabold text-dark">$<?= number_format($nights * $booking['room_price'], 2) ?></span>
                        </div>
                        
                        <!-- Services -->
                        <?php foreach ($services as $svc): ?>
                            <div class="billing-item d-flex justify-content-between align-items-center p-3 mb-2 rounded-3 border-start border-4 border-info">
                                <div>
                                    <div class="fw-extrabold text-dark small"><?= $svc['name'] ?></div>
                                    <div class="x-small text-muted">QTY: <?= $svc['quantity'] ?> x $<?= number_format($svc['price'], 2) ?></div>
                                </div>
                                <span class="fw-extrabold text-dark">$<?= number_format($svc['price'] * $svc['quantity'], 2) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="pt-4 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0 fw-extrabold text-primary text-uppercase fs-6 tracking-wider"><?= __('total_invoice') ?></h5>
                            <h3 class="mb-0 fw-extrabold text-primary">$<?= number_format($booking['total_price'], 2) ?></h3>
                        </div>
                        
                        <div class="d-grid">
                            <button class="btn btn-success fw-bold py-2 shadow-sm d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                                <i class="bi bi-wallet2"></i> <?= __('add_payment') ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction History -->
            <div class="premium-card mb-4 animate__animated animate__fadeInRight" style="animation-delay: 0.4s;">
                <div class="card-header border-0 bg-transparent py-4 px-4">
                    <h5 class="mb-0 fw-extrabold text-dark"><?= __('payment_status') ?></h5>
                </div>
                <div class="card-body px-4 pb-4 pt-0">
                    <?php if (empty($payments)): ?>
                        <div class="text-center py-5 bg-light bg-opacity-50 rounded-4">
                            <div class="text-muted opacity-25 mb-3">
                                <i class="bi bi-credit-card-2-back display-4"></i>
                            </div>
                            <p class="text-muted fw-bold mb-0 lh-1"><?= __('no_payments_found') ?></p>
                            <small class="text-muted opacity-50">No transactions recorded yet</small>
                        </div>
                    <?php else: ?>
                        <div class="transaction-list">
                            <?php foreach($payments as $pmt): ?>
                                <div class="transaction-item d-flex align-items-center mb-3 p-3 bg-white rounded-4 border shadow-xs">
                                    <div class="pmt-icon bg-<?= $pmt['payment_method'] == 'cash' ? 'success' : 'primary' ?>-gradient text-white rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="bi bi-<?= $pmt['payment_method'] == 'card' ? 'credit-card' : 'cash-stack' ?>"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-extrabold small text-dark"><?= strtoupper($pmt['payment_method']) ?></div>
                                        <div class="x-small text-muted"><?= date('d M Y, H:i', strtotime($pmt['payment_date'])) ?></div>
                                    </div>
                                    <div class="fw-extrabold text-success fs-5">$<?= number_format($pmt['amount'], 2) ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->

<style>
/* PREMIUM DESIGN SYSTEM */
.fw-extrabold { font-weight: 800; }
.shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
.shadow-primary { box-shadow: 0 10px 25px -5px rgba(31, 41, 55, 0.2); }
.shadow-success { box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.2); }
.shadow-danger { box-shadow: 0 10px 25px -5px rgba(239, 68, 68, 0.2); }
.shadow-gold { box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.2); }

.bg-primary-gradient { background: linear-gradient(135deg, #1f2937 0%, #111827 100%); }
.bg-success-gradient { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
.bg-danger-gradient { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
.bg-info-gradient { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
.bg-gold-gradient { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }

.premium-card {
    background: #ffffff;
    border: none;
    border-radius: 24px;
    box-shadow: 0 10px 40px -10px rgba(0,0,0,0.05);
    overflow: hidden;
    transition: all 0.3s ease;
}

.premium-stat-card {
    background: #ffffff;
    padding: 1.75rem;
    border-radius: 24px;
    box-shadow: 0 10px 40px -10px rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.02);
    transition: transform 0.3s ease;
}
.premium-stat-card:hover { 
    transform: translateY(-5px); 
    box-shadow: 0 20px 40px -10px rgba(0,0,0,0.1);
}

.icon-box {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    color: white;
}

.premium-back-btn {
    width: 44px;
    height: 44px;
    border-radius: 14px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #475569;
    text-decoration: none;
    transition: all 0.2s;
}
.premium-back-btn:hover { background: #f8fafc; color: #1e293b; transform: scale(1.05); }

.room-key-card {
    background: #111827;
    border-radius: 30px;
    border: none;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}
.pattern-overlay {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background-image: radial-gradient(circle at 10% 20%, rgba(255,255,255,0.03) 0%, transparent 20%),
                      radial-gradient(circle at 80% 80%, rgba(255,255,255,0.03) 0%, transparent 20%);
    pointer-events: none;
}

.timeline-point {
    padding: 1.5rem;
    border-radius: 24px;
    background: #ffffff;
    border: 1px solid #f1f5f9;
    box-shadow: 0 10px 25px -5px rgba(0,0,0,0.03);
}
.date-number { font-size: 3rem; font-weight: 900; line-height: 1; color: #1e293b; }
.date-month { font-size: 0.9rem; color: #64748b; letter-spacing: 1px; }

.guest-avatar-large {
    width: 90px;
    height: 90px;
    border-radius: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    font-weight: 900;
}

.billing-item { background: #fdfdfd; transition: all 0.2s; }
.billing-item:hover { background: #ffffff; box-shadow: 0 5px 15px rgba(0,0,0,0.05); transform: translateY(-2px); }

.btn-primary-soft {
    background: rgba(31, 41, 55, 0.05);
    color: #1f2937;
    border: none;
    font-weight: 700;
}
.btn-primary-soft:hover { background: #1f2937; color: white; }

/* Print Overrides */
@media print {
    .btn, .premium-back-btn, #wrapper sidebar { display: none !important; }
    #page-content-wrapper { padding: 0 !important; width: 100% !important; margin: 0 !important; }
    .premium-card, .premium-stat-card { box-shadow: none !important; border: 1px solid #eee !important; }
}

/* ═══════════════════════════════════════
   LUXURY MODAL & INPUT SYSTEM
   (Same as room_types — self-contained)
═══════════════════════════════════════ */
.luxury-modal { border-radius: 28px !important; overflow: hidden; }
.luxury-modal .modal-header { background: #111827 !important; color: white !important; }

.luxury-input-group { position: relative; margin-bottom: 1.5rem; }
.luxury-label {
    font-size: 0.7rem; font-weight: 800; color: #64748b;
    text-transform: uppercase; letter-spacing: 0.1em;
    margin-bottom: 8px; display: block;
}

.input-wrapper {
    display: flex; align-items: center;
    background: #f8fafc; border: 1.5px solid #e2e8f0;
    border-radius: 14px; padding: 0 16px; transition: all 0.3s;
}
.input-wrapper:focus-within {
    border-color: #1e293b; background: white;
    box-shadow: 0 10px 20px -10px rgba(0,0,0,0.08);
}
.input-wrapper .icon { color: #94a3b8; font-size: 1.1rem; margin-right: 12px; flex-shrink: 0; }
.input-wrapper input,
.input-wrapper select,
.input-wrapper textarea {
    border: none !important; background: transparent !important;
    padding: 13px 0 !important; flex: 1; width: 0; min-width: 0;
    font-weight: 600 !important; color: #1e293b !important;
    outline: none !important; box-shadow: none !important; font-size: 0.95rem;
}
.input-wrapper select {
    cursor: pointer;
    -webkit-appearance: none; -moz-appearance: none; appearance: none;
}
.input-wrapper textarea { padding: 12px 0 !important; resize: vertical; }

.btn-luxury-secondary {
    background: #f1f5f9; color: #64748b; border: none;
    padding: 12px 20px; border-radius: 14px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.75rem;
    transition: all 0.2s;
}
.btn-luxury-secondary:hover { background: #e2e8f0; }
</style>

<!-- Enhanced Luxury Modals -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 luxury-modal rounded-5 overflow-hidden shadow-lg">
            <form action="<?= BASE_URL ?>/services/add-to-booking" method="POST" class="ajax-form">
                <div class="modal-header bg-dark text-white border-0 p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div>
                            <h5 class="modal-title fw-extrabold mb-0"><?= strtoupper(__('add_service')) ?></h5>
                            <div class="x-small fw-bold opacity-50 text-uppercase tracking-widest"><?= __('add_amenity') ?></div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-5">
                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                    <div class="luxury-input-group">
                        <label class="luxury-label"><?= __('service') ?></label>
                        <div class="input-wrapper">
                            <i class="bi bi-stars icon"></i>
                            <select name="service_id" required>
                                <option value=""><?= __('select_service') ?>...</option>
                                <?php foreach ($allServices as $svc): ?>
                                    <option value="<?= $svc['id'] ?>"><?= $svc['name'] ?> - $<?= number_format($svc['price'], 2) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="luxury-input-group">
                        <label class="luxury-label"><?= __('quantity') ?></label>
                        <div class="input-wrapper">
                            <i class="bi bi-hash icon"></i>
                            <input type="number" name="quantity" value="1" min="1" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-luxury-secondary flex-grow-1" data-bs-dismiss="modal"><?= __('cancel') ?></button>
                    <button type="submit" class="btn btn-primary flex-grow-1 shadow-primary fw-extrabold px-4">
                        <?= strtoupper(__('confirm')) ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addPaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 luxury-modal rounded-5 overflow-hidden shadow-lg">
            <form action="<?= BASE_URL ?>/payments/store" method="POST" class="ajax-form">
                <div class="modal-header bg-dark text-white border-0 p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div>
                            <h5 class="modal-title fw-extrabold mb-0"><?= strtoupper(__('add_payment')) ?></h5>
                            <div class="x-small fw-bold opacity-50 text-uppercase tracking-widest"><?= __('manage_payments_desc') ?></div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-5">
                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                    <div class="luxury-input-group">
                        <label class="luxury-label"><?= __('amount') ?></label>
                        <div class="input-wrapper">
                            <i class="bi bi-currency-dollar icon"></i>
                            <input  type="number" step="0.01" name="amount" value="<?= number_format($balance, 2, '.', '') ?>" required>
                        </div>
                    </div>
                    <div class="luxury-input-group">
                        <label class="luxury-label"><?= __('payment_method') ?></label>
                        <div class="input-wrapper">
                            <i class="bi bi-credit-card-2-front icon"></i>
                            <select name="payment_method" required>
                                <option value="cash"><?= __('cash') ?></option>
                                <option value="khqr"><?= __('khqr') ?></option>
                                <option value="card"><?= __('card') ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-luxury-secondary flex-grow-1" data-bs-dismiss="modal"><?= __('cancel') ?></button>
                    <button type="submit" class="btn btn-primary flex-grow-1 shadow-primary fw-extrabold px-4">
                        <?= strtoupper(__('save_payment')) ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

