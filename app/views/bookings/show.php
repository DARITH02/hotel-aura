<div class="animate__animated animate__fadeIn">
    <div class="d-flex align-items-center mb-4 gap-3">
        <a href="<?= BASE_URL ?>/bookings" class="btn btn-icon-premium rounded-circle shadow-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h2 class="mb-0 fw-bold text-dark"><?= __('booking_details') ?> <span class="text-primary">#<?= $booking['id'] ?></span></h2>
            <p class="text-muted small mb-0"><?= __('management_registry') ?></p>
        </div>
        <div class="ms-auto">
            <span class="badge bg-<?= $booking['status'] == 'pending' ? 'warning' : ($booking['status'] == 'cancelled' ? 'danger' : 'success') ?> bg-opacity-10 text-<?= $booking['status'] == 'pending' ? 'warning' : ($booking['status'] == 'cancelled' ? 'danger' : 'success') ?> px-4 py-2 rounded-pill fw-bold border border-<?= $booking['status'] == 'pending' ? 'warning' : ($booking['status'] == 'cancelled' ? 'danger' : 'success') ?> border-opacity-25 shadow-sm">
                <?= strtoupper(__($booking['status'])) ?>
            </span>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column: Guest & Stay Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4 glass-card overflow-hidden">
                <div class="card-header bg-transparent border-0 py-4 px-4">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-pill p-2 me-3">
                            <i class="bi bi-person-badge text-primary"></i>
                        </div>
                        <?= __('guest_info') ?>
                    </h5>
                </div>
                <div class="card-body px-4 pb-4 pt-0">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-light bg-opacity-50 border rounded-4">
                                <label class="small text-muted text-uppercase fw-bold mb-1 d-block opacity-75"><?= __('full_name') ?></label>
                                <div class="fw-bold fs-5 text-dark"><?= htmlspecialchars($booking['guest_name']) ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light bg-opacity-50 border rounded-4">
                                <label class="small text-muted text-uppercase fw-bold mb-1 d-block opacity-75"><?= __('phone_number') ?></label>
                                <div class="fw-bold fs-5 text-dark"><?= htmlspecialchars($booking['guest_phone']) ?></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="p-3 bg-light bg-opacity-50 border rounded-4">
                                <label class="small text-muted text-uppercase fw-bold mb-1 d-block opacity-75"><?= __('email_address') ?></label>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($booking['guest_email'] ?: 'N/A') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 glass-card">
                <div class="card-header bg-transparent border-0 py-4 px-4">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-pill p-2 me-3">
                            <i class="bi bi-calendar-check text-success"></i>
                        </div>
                        <?= __('stay_dates') ?>
                    </h5>
                </div>
                <div class="card-body px-4 pb-4 pt-0">
                    <div class="row align-items-center g-4">
                        <div class="col-md-5">
                            <div class="p-4 border border-light rounded-4 bg-white shadow-sm text-center">
                                <h6 class="text-success fw-bold text-uppercase small mb-3"><?= __('check_in') ?></h6>
                                <div class="display-5 fw-extrabold text-dark mb-0"><?= date('d', strtotime($booking['check_in'])) ?></div>
                                <h4 class="fw-bold mb-1 text-dark"><?= date('M', strtotime($booking['check_in'])) ?></h4>
                                <p class="mb-0 text-muted opacity-75"><?= date('Y', strtotime($booking['check_in'])) ?></p>
                            </div>
                        </div>
                        <div class="col-md-2 text-center text-muted py-4">
                            <div class="nights-indicator mx-auto">
                                <i class="bi bi-moon-stars display-6 text-primary mb-2 d-block"></i>
                                <div class="small fw-extrabold text-uppercase tracking-wider">
                                    <?php 
                                        $start = new DateTime($booking['check_in']);
                                        $end = new DateTime($booking['check_out']);
                                        $nights = $start->diff($end)->days;
                                        echo $nights . " " . ($nights == 1 ? __('night') : __('nights'));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="p-4 border border-light rounded-4 bg-white shadow-sm text-center">
                                <h6 class="text-danger fw-bold text-uppercase small mb-3"><?= __('check_out') ?></h6>
                                <div class="display-5 fw-extrabold text-dark mb-0"><?= date('d', strtotime($booking['check_out'])) ?></div>
                                <h4 class="fw-bold mb-1 text-dark"><?= date('M', strtotime($booking['check_out'])) ?></h4>
                                <p class="mb-0 text-muted opacity-75"><?= date('Y', strtotime($booking['check_out'])) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Room, Services & Payment -->
        <div class="col-lg-4">
            <!-- Room Info -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-dark text-white overflow-hidden position-relative animate__animated animate__pulse">
                <div class="card-body p-4 position-relative" style="z-index: 2;">
                    <label class="small text-white text-opacity-50 text-uppercase fw-bold mb-1 d-block tracking-widest"><?= __('room_assigned') ?></label>
                    <h1 class="fw-extrabold mb-1" style="font-size: 3.5rem;">#<?= $booking['room_number'] ?></h1>
                    <div class="fs-5 text-primary fw-bold mb-3"><?= $booking['room_type'] ?></div>
                    <div class="d-flex justify-content-between align-items-center border-top border-white border-opacity-10 pt-3 mt-3">
                        <span class="small opacity-50"><?= __('nightly_rate') ?></span>
                        <span class="fw-extrabold fs-4">$<?= number_format($booking['room_price'], 2) ?></span>
                    </div>
                </div>
                <i class="bi bi-door-open position-absolute bottom-0 end-0 me-n3 mb-n3 display-1 text-white opacity-10" style="transform: rotate(-15deg); font-size: 8rem;"></i>
            </div>

            <!-- Expense Summary -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 glass-card overflow-hidden">
                <div class="card-header bg-transparent border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><?= __('bill_summary') ?></h5>
                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>
                <div class="card-body px-4 pb-4 pt-0">
                    <div class="mb-3">
                        <?php if (empty($services)): ?>
                            <div class="text-center py-4 bg-light bg-opacity-50 rounded-4">
                                <i class="bi bi-receipt text-muted opacity-25 fs-1 mb-2 d-block"></i>
                                <p class="text-muted small mb-0 font-italic"><?= __('no_additional_services') ?></p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($services as $service): ?>
                                <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-white bg-opacity-40 rounded-3 border border-light">
                                    <div>
                                        <div class="fw-bold text-dark small"><?= $service['name'] ?></div>
                                        <div class="x-small text-muted fw-semibold">QTY: <?= $service['quantity'] ?></div>
                                    </div>
                                    <span class="fw-extrabold text-primary">$<?= number_format($service['price'] * $service['quantity'], 2) ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="bg-primary bg-opacity-10 p-3 rounded-4 d-flex justify-content-between align-items-center mt-4">
                        <h5 class="mb-0 fw-extrabold text-primary"><?= __('total_invoice') ?></h5>
                        <h4 class="mb-0 fw-extrabold text-primary">$<?= number_format($booking['total_price'], 2) ?></h4>
                    </div>
                </div>
            </div>

            <!-- Payments -->
            <div class="card border-0 shadow-sm rounded-4 glass-card">
                <div class="card-header bg-transparent border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><?= __('payment_status') ?></h5>
                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>
                <div class="card-body px-4 pb-4 pt-0">
                    <?php if (empty($payments)): ?>
                        <div class="alert alert-warning bg-warning bg-opacity-10 border-0 rounded-4 p-3 mb-0">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= __('no_payments_found') ?>
                        </div>
                    <?php else: ?>
                        <?php 
                            $paid = 0;
                            foreach($payments as $pmt): $paid += $pmt['amount'];
                        ?>
                            <div class="d-flex align-items-center mb-3 p-2 bg-white rounded-3 shadow-sm border border-light">
                                <div class="payment-icon-box bg-success bg-opacity-10 text-success rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold small text-dark"><?= ucfirst($pmt['payment_method']) ?></div>
                                    <div class="x-small text-muted"><?= date('d M, H:i', strtotime($pmt['payment_date'])) ?></div>
                                </div>
                                <div class="fw-extrabold text-success fs-6">$<?= number_format($pmt['amount'], 2) ?></div>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="payment-summary-box p-3 bg-light rounded-4 mt-4">
                            <div class="d-flex justify-content-between small mb-2">
                                <span class="text-muted fw-bold"><?= __('amount_paid') ?>:</span>
                                <span class="fw-extrabold text-success fs-6">$<?= number_format($paid, 2) ?></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted fw-bold"><?= __('remaining_balance') ?>:</span>
                                <span class="badge bg-<?= ($booking['total_price'] - $paid) > 0 ? 'danger' : 'success' ?> p-2 px-3 rounded-pill fw-extrabold fs-6 shadow-sm">
                                    $<?= number_format($booking['total_price'] - $paid, 2) ?>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="<?= BASE_URL ?>/services/add-to-booking" method="POST" class="ajax-form">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="bi bi-gift-fill text-primary fs-4"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0"><?= __('add_service') ?></h5>
                            <div class="small text-muted"><?= __('select_service_to_add') ?></div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('service') ?></label>
                        <select class="form-select shadow-sm border py-2" name="service_id" required>
                            <option value=""><?= __('select_service') ?>...</option>
                            <?php foreach ($allServices as $svc): ?>
                                <option value="<?= $svc['id'] ?>"><?= $svc['name'] ?> - $<?= number_format($svc['price'], 2) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('quantity') ?></label>
                        <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-123"></i></span>
                            <input type="number" class="form-control border-0 py-2" name="quantity" value="1" min="1" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3">
                    <button type="button" class="btn btn-link text-muted text-decoration-none px-4" data-bs-dismiss="modal"><?= __('cancel') ?></button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm fw-bold rounded-3">
                        <?= __('confirm') ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Payment Modal (Reference only, assuming it exists based on line 150) -->
<div class="modal fade" id="addPaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="<?= BASE_URL ?>/payments/store" method="POST" class="ajax-form">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="bi bi-wallet2 text-success fs-4"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0"><?= __('add_payment') ?></h5>
                            <div class="small text-muted"><?= __('record_new_transaction') ?></div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('amount') ?></label>
                        <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-currency-dollar"></i></span>
                            <input type="number" step="0.01" class="form-control border-0 py-2" name="amount" value="<?= number_format($booking['total_price'] - $paid, 2, '.', '') ?>" required>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('payment_method') ?></label>
                        <select class="form-select shadow-sm border py-2" name="payment_method" required>
                            <option value="cash">Cash</option>
                            <option value="khqr">KHQR / Bank Transfer</option>
                            <option value="card">Credit Card</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3">
                    <button type="button" class="btn btn-link text-muted text-decoration-none px-4" data-bs-dismiss="modal"><?= __('cancel') ?></button>
                    <button type="submit" class="btn btn-success px-4 shadow-sm fw-bold rounded-3">
                        <?= __('save_payment') ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.fw-extrabold { font-weight: 800; }
.x-small { font-size: 0.7rem; }
.glass-card {
    background: rgba(255, 255, 255, 0.7) !important;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.3) !important;
}
.btn-icon-premium {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border: 1px solid #e2e8f0;
    transition: all 0.3s;
}
.btn-icon-premium:hover {
    background: #f8fafc;
    transform: translateX(-5px);
}
.nights-indicator {
    position: relative;
    padding: 10px;
    border-radius: 50%;
}
</style>

<style>
.fw-600 { font-weight: 600; }
.fw-extrabold { font-weight: 800; }
.x-small { font-size: 0.75rem; }
.italic { font-style: italic; }
</style>
