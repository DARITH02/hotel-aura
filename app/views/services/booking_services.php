<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark"><?= __('manage_services') ?></h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/bookings" class="text-decoration-none"><?= __('bookings') ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= __('services') ?></li>
                </ol>
            </nav>
        </div>
        <a href="<?= BASE_URL ?>/bookings" class="btn btn-outline-secondary rounded-3 shadow-sm px-4">
            <i class="bi bi-arrow-left me-2"></i> <?= __('back_to_bookings') ?>
        </a>
    </div>

    <div class="row g-4">
        <!-- Booking Context Header -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #1e2937, #111827);">
                <div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
                    <div class="d-flex align-items-center gap-4">
                        <div class="booking-icon-wrapper rounded-4 d-flex align-items-center justify-content-center">
                            <i class="bi bi-calendar-check text-warning fs-1"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold text-white"><?= __('booking_id_label') ?> <?= str_pad($booking['id'], 5, '0', STR_PAD_LEFT) ?></h4>
                            <div class="d-flex flex-wrap gap-3 mt-2">
                                <span class="text-white-50 small"><i class="bi bi-person me-1 text-warning"></i> <?= htmlspecialchars($booking['guest_name']) ?></span>
                                <span class="text-white-50 small"><i class="bi bi-door-closed me-1 text-warning"></i> <?= __('room') ?> <?= htmlspecialchars($booking['room_number']) ?></span>
                                <span class="text-white-50 small"><i class="bi bi-calendar-range me-1 text-warning"></i> <?= date('M d, Y', strtotime($booking['check_in'])) ?> - <?= date('M d, Y', strtotime($booking['check_out'])) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="text-md-end glass-container p-4 rounded-4 border border-white border-opacity-10 text-center">
                        <div class="text-white-50 small fw-bold text-uppercase mb-1"><?= __('current_bill_total') ?></div>
                        <div class="display-6 fw-bold text-warning mb-0">$<?= number_format($booking['total_price'], 2) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Services List -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-header bg-white border-bottom-0 py-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="bi bi-bag-check-fill text-primary me-2"></i>
                        <?= __('purchased_services') ?>
                    </h5>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2"><?= count($bookingServices) ?> <?= __('services') ?></span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4 py-3 border-0"><?= __('service') ?></th>
                                    <th class="py-3 border-0"><?= __('quantity_occurrences') ?></th>
                                    <th class="py-3 border-0"><?= __('price') ?></th>
                                    <th class="pe-4 py-3 border-0 text-end"><?= __('total') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($bookingServices)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="py-4">
                                                <i class="bi bi-inbox text-muted opacity-25 display-1 mb-3"></i>
                                                <p class="text-muted fw-semibold"><?= __('no_booking_services') ?></p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($bookingServices as $bs): ?>
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <?php if (!empty($bs['image'])): ?>
                                                        <img src="<?= BASE_URL ?>/uploads/services/<?= htmlspecialchars($bs['image']) ?>" class="rounded-3 shadow-sm me-3" style="width: 48px; height: 48px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                                                            <i class="bi bi-tag text-muted"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <div class="fw-bold text-dark"><?= htmlspecialchars($bs['name']) ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <span class="badge bg-light text-dark fw-bold px-3 py-2 rounded-pill"><?= $bs['quantity'] ?></span>
                                            </td>
                                            <td class="py-3 text-muted">$<?= number_format($bs['price'], 2) ?></td>
                                            <td class="pe-4 py-3 text-end fw-bold text-success">$<?= number_format($bs['price'] * $bs['quantity'], 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Add New Service Panel -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-header bg-white border-bottom-0 py-4 px-4">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="bi bi-cart-plus-fill text-warning me-2"></i>
                        <?= __('add_service_to_room') ?>
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="<?= BASE_URL ?>/services/add-to-booking" method="POST" id="addServiceForm" class="ajax-form">
                        <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted mb-2"><?= __('select_service') ?></label>
                            <?php if (empty($allServices)): ?>
                                <div class="alert alert-warning border-0 rounded-3 small">
                                    <i class="bi bi-info-circle me-1"></i> No services exist. <a href="<?= BASE_URL ?>/services" class="fw-bold"><?= __('manage_services') ?></a>
                                </div>
                            <?php else: ?>
                                <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                                    <select name="service_id" id="serviceSelect" class="form-select border-start-0 ps-0" required>
                                        <option value="" selected disabled><?= __('select_service') ?>...</option>
                                        <?php foreach ($allServices as $srv): ?>
                                            <option value="<?= $srv['id'] ?>" data-price="<?= $srv['price'] ?>">
                                                <?= htmlspecialchars($srv['name']) ?> ($<?= number_format($srv['price'], 2) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted mb-2"><?= __('quantity_occurrences') ?></label>
                            <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-plus-slash-minus text-muted"></i></span>
                                <input type="number" class="form-control border-start-0 ps-0" name="quantity" id="quantityInput" value="1" min="1" required>
                            </div>
                        </div>
                        
                        <div class="cost-preview-card bg-light p-4 rounded-4 mb-4 text-center">
                            <div class="text-muted small fw-bold text-uppercase mb-2"><?= __('cost_added') ?></div>
                            <div class="display-5 fw-bold text-danger" id="costPreview">$0.00</div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 py-3 shadow d-flex align-items-center justify-content-center gap-2" <?= empty($allServices) ? 'disabled' : '' ?>>
                                <i class="bi bi-plus-circle-fill"></i>
                                <span class="fw-bold"><?= __('bill_to_room') ?></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.booking-icon-wrapper {
    width: 64px;
    height: 64px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
}
.glass-container {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    min-width: 220px;
}
.cost-preview-card {
    border: 2px dashed #dee2e6;
    background-color: #f8fafc !important;
}
.table thead th {
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const serviceSelect = document.getElementById('serviceSelect');
        const quantityInput = document.getElementById('quantityInput');
        const costPreview = document.getElementById('costPreview');
        
        function updatePreview() {
            if (serviceSelect && serviceSelect.selectedIndex > 0) {
                const opt = serviceSelect.options[serviceSelect.selectedIndex];
                const price = parseFloat(opt.getAttribute('data-price'));
                const qty = parseInt(quantityInput.value) || 0;
                
                costPreview.textContent = '$' + (price * qty).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
            } else {
                costPreview.textContent = '$0.00';
            }
        }
        
        if (serviceSelect) serviceSelect.addEventListener('change', updatePreview);
        if (quantityInput) quantityInput.addEventListener('input', updatePreview);
    });
</script>
