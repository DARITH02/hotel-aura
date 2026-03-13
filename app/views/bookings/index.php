<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="mb-1 fw-bold text-dark"><?= __('manage_bookings') ?></h2>
        <p class="text-muted small mb-0"><?= __('bookings_subtitle') ?></p>
    </div>
    <div class="d-flex gap-2 flex-wrap align-items-center">
        <div class="input-group shadow-sm position-relative" style="min-width: 250px;">
            <span class="input-group-text bg-white border-end-0 text-muted">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" id="bookingSearchInput" class="form-control border-start-0 ps-0 pe-5" 
                   placeholder="<?= __('search_bookings') ?>" 
                   value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted text-decoration-none d-none" 
                    type="button" id="clearSearch" style="z-index: 5;">
                <i class="bi bi-x-circle-fill"></i>
            </button>
        </div>
        <a href="<?= BASE_URL ?>/bookings/create" class="btn btn-primary shadow-sm px-4 py-2 d-flex align-items-center gap-2 rounded-3 text-nowrap">
            <i class="bi bi-plus-lg fs-5"></i>
            <span class="fw-bold"><?= __('create_booking') ?></span>
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden glass-card animate__animated animate__fadeInUp">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle custom-table" id="bookingTable">
                <thead>
                    <tr class="text-muted opacity-75 small text-uppercase tracking-wider">
                        <th class="ps-4 py-3 fw-bold border-0"><?= __('id') ?></th>
                        <th class="py-3 fw-bold border-0"><?= __('guests') ?></th>
                        <th class="py-3 fw-bold border-0"><?= __('rooms') ?></th>
                        <th class="py-3 fw-bold border-0"><?= __('stay_dates') ?></th>
                        <th class="py-3 fw-bold border-0"><?= __('price') ?></th>
                        <th class="py-3 fw-bold border-0"><?= __('status') ?></th>
                        <th class="text-end pe-4 py-3 fw-bold border-0"><?= __('actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($bookings)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <div class="py-5">
                                <i class="bi bi-calendar-x display-4 text-light opacity-50 mb-3"></i>
                                <h5 class="fw-bold mb-1 opacity-75"><?= __('no_results') ?></h5>
                            </div>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($bookings as $booking): ?>
                        <tr class="booking-row" id="row-<?= $booking['id'] ?>">
                            <td class="ps-4 py-3">
                                <span class="fw-extrabold text-muted">#<?= str_pad($booking['id'], 5, '0', STR_PAD_LEFT) ?></span>
                            </td>
                            <td class="py-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 44px; height: 44px; font-weight: 800; border: 2px solid #fff;">
                                        <?= strtoupper($booking['guest_name'] ? $booking['guest_name'][0] : 'G') ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0"><?= htmlspecialchars($booking['guest_name']) ?></div>
                                        <div class="x-small text-muted d-flex align-items-center tracking-widest">
                                            <i class="bi bi-telephone me-1"></i><?= htmlspecialchars($booking['guest_phone'] ?: 'N/A') ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-white text-dark border shadow-sm rounded-pill px-3 py-2 small fw-bold">
                                    <i class="bi bi-door-closed text-primary me-1"></i> <?= htmlspecialchars($booking['room_number']) ?>
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
                                <div class="fw-extrabold text-dark fs-5">$<?= number_format($booking['total_price'], 2) ?></div>
                            </td>
                            <td class="py-3">
                                <?php 
                                    $statusConfig = [
                                        'pending' => ['bg' => 'warning', 'pulse' => true],
                                        'confirmed' => ['bg' => 'primary', 'pulse' => false],
                                        'checked_in' => ['bg' => 'success', 'pulse' => true],
                                        'occupied' => ['bg' => 'primary', 'pulse' => true],
                                        'checked_out' => ['bg' => 'info', 'pulse' => false],
                                        'cancelled' => ['bg' => 'danger', 'pulse' => false]
                                    ];
                                    $cfg = $statusConfig[$booking['status']] ?? ['bg' => 'secondary', 'pulse' => false];
                                    $pulseClass = $cfg['pulse'] ? 'bg-' . $cfg['bg'] . '-pulse' : '';
                                ?>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="status-dot <?= $pulseClass ?> bg-<?= $cfg['bg'] ?>"></span>
                                    <span class="badge bg-<?= $cfg['bg'] ?> bg-opacity-10 text-<?= str_replace('warning', 'warning text-dark', $cfg['bg']) ?> border-0 text-uppercase x-small fw-800 tracking-wider p-2 px-3 rounded-pill">
                                        <?= __($booking['status']) ?>
                                    </span>
                                </div>
                            </td>
                            <td class="text-end pe-4 py-3">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border rounded-pill px-3 shadow-sm fw-bold" type="button" data-bs-toggle="dropdown">
                                        <?= __('actions') ?> <i class="bi bi-chevron-down ms-1 small"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2 animate__animated animate__fadeIn animate__faster">
                                        <li><a class="dropdown-item py-2 rounded-3 text-dark fw-bold" href="<?= BASE_URL ?>/bookings/show?id=<?= $booking['id'] ?>"><i class="bi bi-eye me-2"></i><?= __('details') ?></a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <?php if ($booking['status'] == 'pending'): ?>
                                            <li><a class="dropdown-item py-2 rounded-3 text-primary ajax-action" href="<?= BASE_URL ?>/bookings/confirm?id=<?= $booking['id'] ?>"><i class="bi bi-check2-circle me-2"></i><?= __('confirm') ?></a></li>
                                        <?php endif; ?>
                                        <?php if ($booking['status'] == 'confirmed'): ?>
                                            <li><a class="dropdown-item py-2 rounded-3 text-success ajax-action" href="<?= BASE_URL ?>/bookings/check-in?id=<?= $booking['id'] ?>"><i class="bi bi-box-arrow-in-right me-2"></i><?= __('check_in') ?></a></li>
                                        <?php endif; ?>
                                        <?php if (in_array($booking['status'], ['checked_in', 'occupied'])): ?>
                                            <li><a class="dropdown-item py-2 rounded-3 text-danger ajax-action" href="<?= BASE_URL ?>/bookings/check-out?id=<?= $booking['id'] ?>"><i class="bi bi-door-closed me-2"></i><?= __('check_out') ?></a></li>
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

<style>
.status-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
}
.pulse-warning { box-shadow: 0 0 0 rgba(255, 193, 7, 0.4); animation: pulse-warning 2s infinite; }
@keyframes pulse-warning {
    0% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.4); }
    70% { box-shadow: 0 0 0 8px rgba(255, 193, 7, 0); }
    100% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0); }
}
.pulse-success { box-shadow: 0 0 0 rgba(25, 135, 84, 0.4); animation: pulse-success 2s infinite; }
@keyframes pulse-success {
    0% { box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.4); }
    70% { box-shadow: 0 0 0 8px rgba(25, 135, 84, 0); }
    100% { box-shadow: 0 0 0 0 rgba(25, 135, 84, 0); }
}
.date-chip {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 6px 12px;
    min-width: 110px;
    text-align: center;
    border: 1px solid #eee;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    transition: all 0.2s;
}
.booking-row:hover .date-chip {
    background: #fff;
    border-color: #0d6efd;
    box-shadow: 0 4px 8px rgba(13, 110, 253, 0.05);
}
.date-label {
    display: block;
    font-size: 0.65rem;
    text-transform: uppercase;
    font-weight: 800;
    margin-bottom: 2px;
    letter-spacing: 0.5px;
}
.date-value {
    display: block;
    font-size: 0.85rem;
    font-weight: 700;
    color: #333;
}
.btn-icon {
    width: 36px;
    height: 36px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}
.btn-icon:hover {
    background-color: #f0f0f0;
    transform: translateY(-1px);
}
.booking-row {
    transition: all 0.2s ease;
    border-left: 4px solid transparent;
}
.booking-row:hover {
    background-color: rgba(0, 123, 255, 0.03) !important;
    border-left-color: #0d6efd;
}
.avatar-sm { font-size: 1rem; text-shadow: 0 1px 2px rgba(0,0,0,0.1); }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialize table search
    if (typeof initTableSearch === 'function') {
        const searchInput = document.getElementById('bookingSearchInput');
        const clearBtn = document.getElementById('clearSearch');
        
        initTableSearch('#bookingSearchInput', '#bookingTable');
        
        const updateClearBtn = () => {
            if (searchInput.value) {
                clearBtn.classList.remove('d-none');
            } else {
                clearBtn.classList.add('d-none');
            }
        };

        searchInput.addEventListener('input', updateClearBtn);
        
        clearBtn.addEventListener('click', () => {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
            searchInput.focus();
            // Optional: update URL to remove search param without reload
            const url = new URL(window.location);
            url.searchParams.delete('search');
            window.history.replaceState({}, '', url);
        });

        // Initial state
        if (searchInput.value) {
            searchInput.dispatchEvent(new Event('input'));
            updateClearBtn();
        }
    }

    // 2. Handle Booking actions securely via AJAX (Now handled globally in app.js via .ajax-action class)
});
</script>
