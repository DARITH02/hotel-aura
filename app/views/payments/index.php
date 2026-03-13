<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="mb-1 fw-bold text-dark"><?= __('manage_payments') ?></h2>
        <p class="text-muted small mb-0">Track all hotel transactions and guest payments.</p>
    </div>
    <a href="<?= BASE_URL ?>/payments/create" class="btn btn-primary shadow-sm px-4 py-2 d-flex align-items-center gap-2 rounded-3 text-nowrap">
        <i class="bi bi-credit-card-fill fs-5"></i>
        <span class="fw-bold"><?= __('add_new') ?></span>
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Date</th>
                        <th>Transaction Info</th>
                        <th><?= __('guests') ?></th>
                        <th>Method</th>
                        <th class="text-end pe-4"><?= __('price') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($payments)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">No payments recorded yet.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($payments as $payment): ?>
                        <tr>
                            <td class="ps-4 text-muted">
                                <?= date('M d, Y h:i A', strtotime($payment['payment_date'])) ?>
                            </td>
                            <td>
                                <div class="fw-bold">
                                    <a href="<?= BASE_URL ?>/bookings?search=<?= $payment['booking_id'] ?>" class="text-decoration-none">
                                        Booking #<?= str_pad($payment['booking_id'], 5, '0', STR_PAD_LEFT) ?>
                                    </a>
                                </div>
                                <div class="small text-muted">Room <?= htmlspecialchars($payment['room_number']) ?></div>
                            </td>
                            <td>
                                <div><?= htmlspecialchars($payment['guest_name']) ?></div>
                            </td>
                            <td>
                                <?php
                                    $iconClass = 'bi-credit-card';
                                    if ($payment['payment_method'] == 'cash') $iconClass = 'bi-cash-coin';
                                    if ($payment['payment_method'] == 'bank_transfer') $iconClass = 'bi-bank';
                                ?>
                                <span class="badge bg-light border text-dark text-capitalize">
                                    <i class="bi <?= $iconClass ?> text-primary me-1"></i>
                                    <?= str_replace('_', ' ', $payment['payment_method']) ?>
                                </span>
                            </td>
                            <td class="text-end pe-4 fw-bold text-success fs-5">
                                $<?= number_format($payment['amount'], 2) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
