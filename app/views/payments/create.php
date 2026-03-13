<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 fw-bold">Record Payment</h2>
    <a href="<?= BASE_URL ?>/payments" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to History
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4 p-md-5">
                <form action="<?= BASE_URL ?>/payments/store" method="POST" class="ajax-form">
                    
                    <?php if (!$booking): ?>
                        <!-- Selection mode -->
                        <div class="mb-4 pb-4 border-bottom">
                            <label class="form-label text-muted fw-semibold d-block">Select Booking to Pay For</label>
                            
                            <?php if (empty($allBookings)): ?>
                                <div class="alert alert-warning">No active bookings available for payment.</div>
                            <?php else: ?>
                                <select name="booking_id" class="form-select form-select-lg mb-3" onchange="window.location.href='<?= BASE_URL ?>/payments/create?booking_id='+this.value">
                                    <option value="" selected disabled>-- Select a Booking --</option>
                                    <?php foreach ($allBookings as $b): ?>
                                        <option value="<?= $b['id'] ?>">
                                            Booking #<?= str_pad($b['id'], 5, '0', STR_PAD_LEFT) ?> - 
                                            <?= htmlspecialchars($b['guest_name']) ?> (Room <?= htmlspecialchars($b['room_number']) ?>) - 
                                            Status: <?= htmlspecialchars($b['status']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <!-- Details mode -->
                        <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                        
                        <div class="d-flex align-items-center gap-3 mb-4 p-3 bg-light rounded-3 border">
                            <div class="fs-1 text-primary"><i class="bi bi-receipt"></i></div>
                            <div>
                                <h5 class="mb-1 fw-bold">Booking #<?= str_pad($booking['id'], 5, '0', STR_PAD_LEFT) ?></h5>
                                <div class="text-muted">
                                    Guest: <strong><?= htmlspecialchars($booking['guest_name']) ?></strong> | 
                                    Room: <strong><?= htmlspecialchars($booking['room_number']) ?></strong>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-5">
                            <div class="col-sm-4 border-end">
                                <div class="text-muted small mb-1">Total Bill</div>
                                <div class="fs-4 fw-bold text-dark">$<?= number_format($booking['total_price'], 2) ?></div>
                            </div>
                            <div class="col-sm-4 border-end">
                                <div class="text-muted small mb-1">Total Paid</div>
                                <div class="fs-4 fw-bold text-success">$<?= number_format($booking['total_price'] - $balance, 2) ?></div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-muted small mb-1">Remaining Balance</div>
                                <div class="fs-4 fw-bold <?= $balance > 0 ? 'text-danger' : 'text-success' ?>">$<?= number_format($balance, 2) ?></div>
                            </div>
                        </div>

                        <?php if ($balance > 0): ?>
                            <h5 class="fw-bold mb-3 pb-2 border-bottom">New Payment Detail</h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label text-muted fw-semibold">Amount to Pay ($)</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" min="0.01" max="<?= $balance ?>" class="form-control" name="amount" value="<?= number_format($balance, 2, '.', '') ?>" required>
                                    </div>
                                    <div class="form-text text-primary">Defaults to full remaining balance.</div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label text-muted fw-semibold">Payment Method</label>
                                    <select name="payment_method" class="form-select form-select-lg" required>
                                        <option value="credit_card" selected>Credit Card</option>
                                        <option value="cash">Cash</option>
                                        <option value="debit_card">Debit Card</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="d-grid mt-2">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                    <i class="bi bi-shield-lock me-2"></i> Confirm Payment
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-success d-flex align-items-center mb-0">
                                <i class="bi bi-check-circle-fill fs-3 me-3"></i>
                                <div>
                                    <h5 class="mb-1 fw-bold">Fully Paid</h5>
                                    <p class="mb-0">This booking has no outstanding balance.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mt-4 mt-lg-0">
        <?php if ($booking && !empty($existingPayments)): ?>
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold">Payment History for this Booking</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php foreach ($existingPayments as $ep): ?>
                            <li class="list-group-item p-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold text-success">$<?= number_format($ep['amount'], 2) ?></div>
                                    <div class="small text-muted"><?= date('M d, Y', strtotime($ep['payment_date'])) ?></div>
                                </div>
                                <span class="badge bg-light text-dark border"><i class="bi bi-credit-card me-1"></i> <?= str_replace('_', ' ', $ep['payment_method']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
