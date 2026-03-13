<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3 animate__animated animate__fadeInDown">
    <div>
        <h2 class="mb-1 fw-bold text-dark"><?= __('manage_guests') ?></h2>
        <p class="text-muted small mb-0">Experience personalized service with our refined guest registry.</p>
    </div>
    
    <div class="d-flex gap-2 flex-wrap align-items-center">
        <div class="input-group shadow-sm border-0 rounded-3 overflow-hidden" style="min-width: 300px;">
            <span class="input-group-text bg-white border-0 text-muted px-3">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" id="guestSearchInput" class="form-control border-0 ps-0" placeholder="<?= __('search') ?> <?= __('guests') ?>..." value="<?= htmlspecialchars($search ?? '') ?>">
            <?php if (!empty($search)): ?>
                <a href="<?= BASE_URL ?>/guests" class="btn btn-white border-0 text-danger">
                    <i class="bi bi-x-lg"></i>
                </a>
            <?php endif; ?>
        </div>
        <button class="btn btn-primary shadow-sm px-4 py-2 d-flex align-items-center gap-2 rounded-3 text-nowrap" data-bs-toggle="modal" data-bs-target="#addGuestModal">
            <i class="bi bi-person-plus-fill fs-5"></i>
            <span class="fw-bold"><?= __('add_guest') ?></span>
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden glass-card animate__animated animate__fadeInUp">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle custom-table" id="guestTable">
                <thead>
                    <tr class="text-muted opacity-75 small text-uppercase tracking-wider">
                        <th class="ps-4 py-3 fw-bold border-0"><?= __('full_name') ?></th>
                        <th class="py-3 fw-bold border-0"><?= __('contact_details') ?></th>
                        <th class="py-3 fw-bold border-0"><?= __('address') ?></th>
                        <th class="py-3 fw-bold border-0"><?= __('registered_at') ?></th>
                        <th class="text-end pe-4 py-3 fw-bold border-0"><?= __('actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($guests)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <div class="py-5">
                                <i class="bi bi-people display-1 text-light opacity-25 mb-3 d-block"></i>
                                <h5 class="fw-bold"><?= __('no_results') ?></h5>
                                <button class="btn btn-sm btn-primary mt-3 px-4 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#addGuestModal">
                                    Register First Guest
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($guests as $guest): ?>
                        <tr id="row-<?= $guest['id'] ?>" class="guest-row">
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-container me-3 shadow-sm border border-light">
                                        <i class="bi bi-person-circle fs-4 text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0 fs-6"><?= htmlspecialchars($guest['name']) ?></div>
                                        <div class="text-muted small d-flex align-items-center gap-1">
                                            <span class="badge bg-light text-muted border py-1 mb-1">#G-<?= str_pad($guest['id'], 3, '0', STR_PAD_LEFT) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="d-flex flex-column gap-1">
                                    <div class="small d-flex align-items-center gap-2">
                                        <i class="bi bi-envelope text-primary opacity-50"></i>
                                        <span class="text-dark fw-medium"><?= htmlspecialchars($guest['email'] ?: 'N/A') ?></span>
                                    </div>
                                    <div class="small d-flex align-items-center gap-2 text-muted">
                                        <i class="bi bi-telephone text-primary opacity-50"></i>
                                        <span class="fw-medium"><?= htmlspecialchars($guest['phone'] ?: 'No Phone') ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="text-muted small text-wrap" style="max-width: 250px;">
                                    <i class="bi bi-geo-alt me-1 opacity-50"></i>
                                    <?= htmlspecialchars($guest['address'] ?: 'No address registered') ?>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="d-inline-flex align-items-center px-3 py-2 bg-light rounded-pill border small fw-bold text-dark">
                                    <i class="bi bi-calendar3 me-2 text-muted"></i>
                                    <?= date('M d, Y', strtotime($guest['created_at'])) ?>
                                </div>
                            </td>
                            <td class="text-end pe-4 py-3">
                                <div class="d-flex justify-content-end gap-2">
                                    <button class="btn btn-icon-premium rounded-circle" data-bs-toggle="modal" data-bs-target="#editGuestModal<?= $guest['id'] ?>" title="<?= __('edit') ?>">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </button>
                                    <a href="<?= BASE_URL ?>/guests/delete?id=<?= $guest['id'] ?>" class="btn btn-icon-premium rounded-circle ajax-delete" data-row-id="row-<?= $guest['id'] ?>" title="<?= __('delete') ?>">
                                        <i class="bi bi-trash text-danger"></i>
                                    </a>
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

<?php if (!empty($guests)): ?>
    <?php foreach ($guests as $guest): ?>
    <!-- Edit Guest Modal -->
    <div class="modal fade" id="editGuestModal<?= $guest['id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form action="<?= BASE_URL ?>/guests/update" method="POST" class="ajax-form">
                    <div class="modal-header border-0 pb-0 pt-4 px-4 bg-white">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                <i class="bi bi-person-fill-gear fs-4 text-primary"></i>
                            </div>
                            <div>
                                <h5 class="modal-title mb-0 fw-bold"><?= __('edit') ?> <?= __('guest') ?></h5>
                                <div class="small text-muted">Customer Profile #<?= $guest['id'] ?></div>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" name="id" value="<?= $guest['id'] ?>">
                        
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('full_name') ?> *</label>
                            <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-person text-primary"></i></span>
                                <input type="text" class="form-control border-0 py-2" name="name" value="<?= htmlspecialchars($guest['name']) ?>" required placeholder="Enter guest full name">
                            </div>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('email') ?></label>
                                <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-primary"></i></span>
                                    <input type="email" class="form-control border-0 py-2" name="email" value="<?= htmlspecialchars($guest['email']) ?>" placeholder="email@address.com">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('phone') ?></label>
                                <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-telephone text-primary"></i></span>
                                    <input type="text" class="form-control border-0 py-2" name="phone" value="<?= htmlspecialchars($guest['phone']) ?>" placeholder="+1 234 567 890">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-0">
                            <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('address') ?> & Notes</label>
                            <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                                <span class="input-group-text bg-light border-0 align-items-start pt-2 px-3"><i class="bi bi-geo-alt text-primary"></i></span>
                                <textarea class="form-control border-0 py-2" name="address" rows="3" placeholder="Residential address or special stay notes..."><?= htmlspecialchars($guest['address']) ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0 bg-white">
                        <button type="button" class="btn btn-link text-muted text-decoration-none px-4" data-bs-dismiss="modal"><?= __('cancel') ?></button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm fw-bold rounded-3">
                            <i class="bi bi-check2-circle me-1"></i> <?= __('save_changes') ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- Add Guest Modal -->
<div class="modal fade" id="addGuestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form action="<?= BASE_URL ?>/guests/store" method="POST" class="ajax-form">
                <div class="modal-header border-0 pb-0 pt-4 px-4 bg-white">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="bi bi-person-plus-fill fs-4 text-primary"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0 fw-bold"><?= __('add_guest') ?></h5>
                            <div class="small text-muted">Register New Customer</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('full_name') ?> *</label>
                        <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-person text-primary"></i></span>
                            <input type="text" class="form-control border-0 py-2" name="name" required placeholder="Enter guest name">
                        </div>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('email') ?></label>
                            <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-primary"></i></span>
                                <input type="email" class="form-control border-0 py-2" name="email" placeholder="john@example.com">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('phone') ?></label>
                            <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-telephone text-primary"></i></span>
                                <input type="text" class="form-control border-0 py-2" name="phone" placeholder="+1 (555) 000-0000">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('address') ?> & Notes</label>
                        <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0 align-items-start pt-2 px-3"><i class="bi bi-geo-alt text-primary"></i></span>
                            <textarea class="form-control border-0 py-2" name="address" rows="3" placeholder="Residential address or special stay notes..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white border-0 p-4 pt-0">
                    <button type="button" class="btn btn-link text-muted text-decoration-none px-4" data-bs-dismiss="modal"><?= __('cancel') ?></button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm fw-bold rounded-3">
                        <i class="bi bi-check2-circle me-1"></i> <?= __('save_guest') ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.avatar-container {
    width: 48px;
    height: 48px;
    background: #f8fafc;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.btn-icon-premium {
    width: 38px;
    height: 38px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border: 1px solid #e2e8f0;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.btn-icon-premium:hover {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
    transform: rotate(10deg) scale(1.1);
}
.btn-icon-premium:hover i {
    color: white !important;
}
.guest-row {
    transition: all 0.2s ease;
    border-left: 4px solid transparent;
}
.guest-row:hover {
    background-color: rgba(15, 23, 42, 0.01) !important;
    border-left-color: var(--bs-primary);
}
.glass-card {
    background: rgba(255, 255, 255, 0.8) !important;
    backdrop-filter: blur(10px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof initTableSearch === 'function') {
        initTableSearch('#guestSearchInput', '#guestTable');
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof initTableSearch === 'function') {
        initTableSearch('#guestSearchInput', '#guestTable');
    }
});
</script>
