<div class="animate__animated animate__fadeIn px-lg-4">
    <!-- Header Strategy -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-4">
        <div>
            <h2 class="mb-1 fw-extrabold text-dark d-flex align-items-center gap-3">
                <?= __('manage_guests') ?>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1 rounded-pill small" style="font-size: 0.8rem;">
                    <?= count($guests) ?> <?= strtoupper(__('total')) ?>
                </span>
            </h2>
            <p class="text-muted small mb-0 fw-medium"><?= __('manage_guests_desc') ?></p>
        </div>
        
        <div class="d-flex gap-3 flex-wrap align-items-center">
            <div class="premium-search-box shadow-sm border rounded-pill overflow-hidden bg-white d-flex align-items-center px-3" style="min-width: 320px; height: 48px;">
                <i class="bi bi-search text-primary opacity-50 me-2"></i>
                <input type="text" id="guestSearchInput" class="form-control border-0 shadow-none bg-transparent ps-0" placeholder="<?= __('search') ?> <?= __('guests') ?>..." value="<?= htmlspecialchars($search ?? '') ?>">
                <?php if (!empty($search)): ?>
                    <a href="<?= BASE_URL ?>/guests" class="btn btn-link text-danger p-0 ms-2">
                        <i class="bi bi-x-circle-fill opacity-50"></i>
                    </a>
                <?php endif; ?>
            </div>
            <button class="btn btn-primary shadow-primary px-4 py-2 d-flex align-items-center gap-2 rounded-pill fw-bold h-48" data-bs-toggle="modal" data-bs-target="#addGuestModal">
                <i class="bi bi-person-plus-fill fs-5"></i>
                <span><?= __('add_guest') ?></span>
            </button>
        </div>
    </div>

    <!-- Quick Stats Registry -->
    <div class="row g-4 mb-5 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
        <div class="col-sm-6 col-xl-4">
            <div class="premium-stat-card">
                <div class="d-flex justify-content-between mb-3">
                    <div class="icon-box bg-primary-gradient shadow-primary">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <h6 class="text-muted small fw-bold text-uppercase opacity-75 mb-1"><?= __('total_guests') ?></h6>
                <h3 class="fw-extrabold mb-0 text-dark"><?= number_format($stats['total'] ?? 0) ?></h3>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="premium-stat-card">
                <div class="d-flex justify-content-between mb-3">
                    <div class="icon-box bg-info-gradient shadow-info">
                        <i class="bi bi-telegram"></i>
                    </div>
                    <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-10 rounded-pill px-2 py-1 align-self-start small"><?= strtoupper(__('online')) ?></span>
                </div>
                <h6 class="text-muted small fw-bold text-uppercase opacity-75 mb-1"><?= __('cloud_linked') ?></h6>
                <h3 class="fw-extrabold mb-0 text-dark"><?= number_format($stats['online'] ?? 0) ?></h3>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="premium-stat-card">
                <div class="d-flex justify-content-between mb-3">
                    <div class="icon-box bg-success-gradient shadow-success">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                    <?php if (($stats['new_30_days'] ?? 0) > 0): ?>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-10 rounded-pill px-2 py-1 align-self-start small">+<?= $stats['new_30_days'] ?> <?= __('new_badge') ?></span>
                    <?php endif; ?>
                </div>
                <h6 class="text-muted small fw-bold text-uppercase opacity-75 mb-1"><?= __('last_30_days') ?></h6>
                <h3 class="fw-extrabold mb-0 text-dark"><?= number_format($stats['new_30_days'] ?? 0) ?></h3>
            </div>
        </div>
    </div>

    <!-- Guest Registry Table -->
    <div class="premium-card mb-5 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle luxury-table" id="guestTable">
                    <thead>
                        <tr class="text-muted x-small text-uppercase tracking-widest bg-light bg-opacity-50">
                            <th class="ps-4 py-4 fw-extrabold border-0"><?= __('full_name') ?></th>
                            <th class="py-4 fw-extrabold border-0"><?= __('contact_details') ?></th>
                            <th class="py-4 fw-extrabold border-0"><?= __('address') ?></th>
                            <th class="py-4 fw-extrabold border-0"><?= __('registered_at') ?></th>
                            <th class="text-end pe-4 py-4 fw-extrabold border-0"><?= __('actions') ?></th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php if (empty($guests)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-5 opacity-50">
                                    <i class="bi bi-people display-1 text-muted mb-3 d-block"></i>
                                    <h5 class="fw-bold text-muted"><?= __('no_results') ?></h5>
                                    <p class="small text-muted mb-0"><?= __('guest_registry_empty') ?></p>
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($guests as $guest): ?>
                            <tr id="row-<?= $guest['id'] ?>" class="guest-luxury-row">
                                <td class="ps-4 py-4">
                                    <div class="d-flex align-items-center">
                                        <div class="guest-avatar-box me-3 rounded-circle shadow-sm border border-2 border-white overflow-hidden d-flex align-items-center justify-content-center bg-light" style="width: 52px; height: 52px;">
                                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($guest['name']) ?>&background=f1f5f9&color=1f2937&font-size=0.4" width="52" height="52" alt="">
                                        </div>
                                        <div>
                                            <div class="fw-extrabold text-dark fs-6 d-flex align-items-center gap-2 mb-1">
                                                <?= htmlspecialchars($guest['name']) ?>
                                                <?php if (!empty($guest['telegram_chat_id'])): ?>
                                                    <span class="badge rounded-pill bg-info bg-opacity-10 text-info border border-info border-opacity-10 d-flex align-items-center gap-1" style="font-size: 0.6rem; font-weight: 800;" title="<?= __('cloud_linked') ?>">
                                                        <i class="bi bi-telegram fs-x-small"></i>
                                                    </span>
                                                <?php endif; ?>
                                                <?php if (!empty($guest['online_book'])): ?>
                                                    <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-10 d-flex align-items-center gap-1" style="font-size: 0.6rem; font-weight: 800;" title="<?= __('online_booking') ?>">
                                                        <i class="bi bi-globe fs-x-small"></i> <?= strtoupper(__('online')) ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="x-small text-muted fw-bold text-uppercase tracking-wider">
                                                ID: <span class="text-primary opacity-75">G-<?= str_pad($guest['id'], 3, '0', STR_PAD_LEFT) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <div class="d-flex flex-column gap-2">
                                        <div class="x-small d-flex align-items-center gap-2">
                                            <div class="icon-sm bg-primary bg-opacity-10 text-primary"><i class="bi bi-envelope-fill"></i></div>
                                            <span class="text-dark fw-bold"><?= htmlspecialchars($guest['email'] ?: 'N/A') ?></span>
                                        </div>
                                        <div class="x-small d-flex align-items-center gap-2">
                                            <div class="icon-sm bg-success bg-opacity-10 text-success"><i class="bi bi-telephone-fill"></i></div>
                                            <span class="text-dark fw-bold"><?= htmlspecialchars($guest['phone'] ?: 'No Phone') ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <div class="text-muted small text-wrap lh-base" style="max-width: 250px;">
                                        <i class="bi bi-geo-alt-fill text-muted opacity-25 me-1"></i>
                                        <?= htmlspecialchars($guest['address'] ?: 'No primary address') ?>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <div class="d-inline-flex align-items-center px-3 py-2 bg-white rounded-pill border shadow-xs x-small fw-extrabold text-dark">
                                        <i class="bi bi-clock-history me-2 text-muted opacity-50"></i>
                                        <?= date('d M Y', strtotime($guest['created_at'])) ?>
                                    </div>
                                </td>
                                <td class="text-end pe-4 py-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-luxury-action" data-bs-toggle="modal" data-bs-target="#editGuestModal<?= $guest['id'] ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <?php if (($_SESSION['admin_role'] ?? '') === 'super_admin'): ?>
                                        <a href="<?= BASE_URL ?>/guests/delete?id=<?= $guest['id'] ?>" class="btn btn-luxury-action text-danger ajax-delete" data-row-id="row-<?= $guest['id'] ?>">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>
                                        <?php endif; ?>
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

<?php if (!empty($guests)): ?>
    <?php foreach ($guests as $guest): ?>
    <!-- Edit Guest Modal -->
    <div class="modal fade" id="editGuestModal<?= $guest['id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 luxury-modal rounded-5 overflow-hidden shadow-lg">
                <form action="<?= BASE_URL ?>/guests/update" method="POST" class="ajax-form">
                <div class="modal-header bg-dark text-white border-0 p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div>
                            <h5 class="modal-title fw-extrabold mb-0"><?= strtoupper(__('edit_profile')) ?></h5>
                            <div class="x-small fw-bold opacity-50 text-uppercase tracking-widest"><?= __('update_room_desc') ?></div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-5">
                    <input type="hidden" name="id" value="<?= $guest['id'] ?>">
                    
                    <div class="luxury-input-group">
                        <label class="luxury-label"><?= __('full_name') ?> *</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person icon"></i>
                            <input type="text" name="name" value="<?= htmlspecialchars($guest['name']) ?>" required>
                        </div>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('email') ?></label>
                                <div class="input-wrapper">
                                    <i class="bi bi-envelope icon"></i>
                                    <input type="email" name="email" value="<?= htmlspecialchars($guest['email']) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('phone') ?></label>
                                <div class="input-wrapper">
                                    <i class="bi bi-telephone icon"></i>
                                    <input type="text" name="phone" value="<?= htmlspecialchars($guest['phone']) ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="luxury-input-group mb-0">
                        <label class="luxury-label"><?= __('address') ?></label>
                        <div class="input-wrapper">
                            <i class="bi bi-geo-alt icon"></i>
                            <textarea name="address" rows="3"><?= htmlspecialchars($guest['address']) ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-luxury-secondary flex-grow-1" data-bs-dismiss="modal"><?= __('cancel') ?></button>
                    <button type="submit" class="btn btn-primary flex-grow-1 shadow-primary fw-extrabold">
                        <?= strtoupper(__('save_changes')) ?>
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
        <div class="modal-content border-0 luxury-modal rounded-5 shadow-lg overflow-hidden">
            <form action="<?= BASE_URL ?>/guests/store" method="POST" class="ajax-form">
                <div class="modal-header bg-dark text-white border-0 p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div>
                            <h5 class="modal-title fw-extrabold mb-0"><?= strtoupper(__('add_guest')) ?></h5>
                            <div class="x-small fw-bold opacity-50 text-uppercase tracking-widest"><?= __('manage_guests_desc') ?></div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-5">
                    <div class="luxury-input-group">
                        <label class="luxury-label"><?= __('full_name') ?> *</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person icon"></i>
                            <input type="text" name="name" required placeholder="<?= __('guest_name_placeholder') ?>">
                        </div>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('email') ?></label>
                                <div class="input-wrapper">
                                    <i class="bi bi-envelope icon"></i>
                                    <input type="email" name="email" placeholder="email@example.com">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('phone') ?></label>
                                <div class="input-wrapper">
                                    <i class="bi bi-telephone icon"></i>
                                    <input type="text" name="phone" placeholder="+855...">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-0">
                        <label class="form-label small fw-extrabold text-uppercase opacity-75"><?= __('address') ?></label>
                        <div class="input-group shadow-xs border-0 rounded-4 overflow-hidden bg-white">
                            <span class="input-group-text border-0 bg-white pt-3 align-items-start"><i class="bi bi-geo-alt text-primary"></i></span>
                            <textarea class="form-control border-0 py-3" name="address" rows="3" placeholder="<?= __('address_placeholder') ?>"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0 bg-light bg-opacity-50">
                    <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" data-bs-dismiss="modal"><?= __('cancel') ?></button>
                    <button type="submit" class="btn btn-success px-5 rounded-pill fw-extrabold shadow-sm text-white">
                        <?= strtoupper(__('save_guest')) ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* LUXURY GUEST REGISTRY STYLES */
.fw-extrabold { font-weight: 800; }
.shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
.shadow-primary { box-shadow: 0 10px 25px -5px rgba(31, 41, 55, 0.2); }
.shadow-info { box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.2); }
.shadow-success { box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.2); }

.bg-primary-gradient { background: linear-gradient(135deg, #1f2937 0%, #111827 100%); }
.bg-info-gradient { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
.bg-success-gradient { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }

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

.icon-box-sm {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
}

.icon-sm {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
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

.guest-luxury-row {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f8fafc;
}
.guest-luxury-row:hover {
    background-color: #f8fafc;
}

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
    box-shadow: 0 5px 15px -5px rgba(0,0,0,0.1);
}
.btn-luxury-action.text-danger:hover {
    background: #ef4444;
    border-color: #ef4444;
}

.fs-x-small { font-size: 0.6rem; }
.x-small { font-size: 0.75rem; }
.h-48 { height: 48px; }

/* LUXURY MODAL & INPUT SYSTEM */
.luxury-modal { border-radius: 28px !important; overflow: hidden; }
.luxury-modal .modal-header { background: #111827 !important; color: white !important; }

.luxury-input-group { position: relative; margin-bottom: 1.5rem; }
.luxury-label {
    font-size: 0.7rem; font-weight: 800; color: #64748b;
    text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 8px; display: block;
}
.input-wrapper {
    display: flex; align-items: center; background: #f8fafc;
    border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 0 16px; transition: all 0.3s;
}
.input-wrapper:focus-within { border-color: #1e293b; background: white; box-shadow: 0 10px 20px -10px rgba(0,0,0,0.05); }
.input-wrapper .icon { color: #94a3b8; font-size: 1.1rem; margin-right: 12px; flex-shrink: 0; }
.input-wrapper input,
.input-wrapper select,
.input-wrapper textarea {
    border: none !important; background: transparent !important;
    padding: 13px 0 !important; flex: 1; width: 0; min-width: 0;
    font-weight: 600 !important; color: #1e293b !important;
    outline: none !important; box-shadow: none !important; font-size: 0.95rem;
}
.input-wrapper textarea { padding: 12px 0 !important; resize: vertical; }
.btn-luxury-secondary { background: #f1f5f9; color: #64748b; border: none; padding: 12px 20px; border-radius: 14px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.75rem; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof initTableSearch === 'function') {
        initTableSearch('#guestSearchInput', '#guestTable');
    }
});
</script>
