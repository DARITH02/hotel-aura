<div class="animate__animated animate__fadeIn px-lg-4">
    <!-- Luxury Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-4">
        <div>
            <h2 class="mb-1 fw-extrabold text-dark d-flex align-items-center gap-3">
                <?= __('manage_admins') ?>
                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-1 rounded-pill small" style="font-size: 0.8rem;">
                    <?= count($admins) ?> <?= strtoupper(__('users')) ?>
                </span>
            </h2>
            <p class="text-muted small mb-0 fw-medium"><?= __('manage_admins_desc') ?></p>
        </div>
        
        <div class="d-flex gap-3 flex-wrap align-items-center">
            <div class="premium-search-box shadow-sm border rounded-pill overflow-hidden bg-white d-flex align-items-center px-3" style="min-width: 300px; height: 48px;">
                <i class="bi bi-search text-danger opacity-50 me-2"></i>
                <input type="text" id="adminSearchInput" class="form-control border-0 shadow-none bg-transparent ps-0" placeholder="<?= __('search') ?> <?= __('admins') ?>...">
            </div>
            <button class="btn btn-dark shadow-lg px-4 py-2 d-flex align-items-center gap-2 rounded-pill fw-bold h-48" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                <i class="bi bi-person-plus-fill fs-5"></i>
                <span><?= __('add_new') ?></span>
            </button>
        </div>
    </div>

    <!-- Administrators Registry Table -->
    <div class="premium-card mb-5 animate__animated animate__fadeInUp">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle luxury-table" id="adminTable">
                <thead>
                    <tr class="text-muted x-small text-uppercase tracking-widest bg-light bg-opacity-50">
                        <th class="ps-4 py-4 fw-extrabold border-0"><?= __('admin_info') ?></th>
                        <th class="py-4 fw-extrabold border-0"><?= __('role') ?></th>
                        <th class="py-4 fw-extrabold border-0"><?= __('registered_at') ?></th>
                        <th class="text-end pe-4 py-4 fw-extrabold border-0"><?= __('actions') ?></th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if (empty($admins)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="py-5 opacity-50">
                                    <i class="bi bi-shield-lock-fill display-1 text-muted mb-3 d-block"></i>
                                    <h5 class="fw-bold text-muted"><?= __('no_results') ?></h5>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($admins as $admin): ?>
                            <tr class="admin-luxury-row" id="row-<?= $admin['id'] ?>">
                                <td class="ps-4 py-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="admin-avatar-box">
                                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($admin['name']) ?>&background=f8fafc&color=1e293b&bold=true" alt="" class="admin-avatar shadow-sm">
                                            <?php if ($admin['id'] == $_SESSION['admin_id']): ?>
                                                <div class="self-tag"><i class="bi bi-check-circle-fill"></i></div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="fw-extrabold text-dark"><?= htmlspecialchars($admin['name']) ?></div>
                                            <div class="x-small text-muted fw-bold opacity-75"><?= htmlspecialchars($admin['email']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <?php if($admin['role'] == 'super_admin'): ?>
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-10 rounded-pill px-3 py-2 x-small fw-extrabold tracking-wider">
                                            <i class="bi bi-shield-check me-1"></i> SUPER ADMIN
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 rounded-pill px-3 py-2 x-small fw-extrabold tracking-wider">
                                            <i class="bi bi-person-badge me-1"></i> ADMIN
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-calendar3 text-muted x-small"></i>
                                        <span class="x-small fw-extrabold text-muted text-uppercase"><?= date('M d, Y', strtotime($admin['created_at'])) ?></span>
                                    </div>
                                </td>
                                <td class="text-end pe-4 py-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-luxury-action" data-bs-toggle="modal" data-bs-target="#editAdminModal<?= $admin['id'] ?>" title="<?= __('edit') ?>">
                                            <i class="bi bi-pencil-square text-primary"></i>
                                        </button>
                                        <?php if ($admin['id'] != $_SESSION['admin_id']): ?>
                                        <a href="<?= BASE_URL ?>/admins/delete?id=<?= $admin['id'] ?>" class="btn btn-luxury-action ajax-delete" data-row-id="row-<?= $admin['id'] ?>" title="<?= __('delete') ?>">
                                            <i class="bi bi-trash3-fill text-danger"></i>
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

<!-- Add/Edit Modals Integration -->
<?php if (!empty($admins)): ?>
    <?php foreach ($admins as $admin): ?>
        <div class="modal fade" id="editAdminModal<?= $admin['id'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 luxury-modal rounded-5 overflow-hidden shadow-lg">
                    <form action="<?= BASE_URL ?>/admins/update" method="POST" class="ajax-form">
                        <div class="modal-header bg-dark text-white border-0 p-4">
                            <div class="d-flex align-items-center gap-3">
                                <div>
                                    <h5 class="modal-title fw-extrabold mb-0"><?= __('edit') ?> <?= __('admin') ?></h5>
                                    <div class="x-small fw-bold opacity-50 text-uppercase tracking-widest"><?= __('admin_profile_id') ?> #<?= $admin['id'] ?></div>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4 pt-5">
                            <input type="hidden" name="id" value="<?= $admin['id'] ?>">
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('full_name') ?> *</label>
                                <div class="input-wrapper">
                                    <i class="bi bi-person-fill icon"></i>
                                    <input type="text" name="name" value="<?= htmlspecialchars($admin['name']) ?>" required>
                                </div>
                            </div>
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('email_address') ?> *</label>
                                <div class="input-wrapper">
                                    <i class="bi bi-envelope-fill icon"></i>
                                    <input type="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required>
                                </div>
                            </div>
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('password') ?> (<?= __('leave_blank_to_keep') ?>)</label>
                                <div class="input-wrapper">
                                    <i class="bi bi-shield-lock-fill icon"></i>
                                    <input type="password" name="password" placeholder="••••••••">
                                </div>
                            </div>
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('role') ?> *</label>
                                <div class="input-wrapper">
                                    <i class="bi bi-person-badge-fill icon"></i>
                                    <select name="role" class="luxury-select">
                                        <option value="admin" <?= $admin['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="super_admin" <?= $admin['role'] == 'super_admin' ? 'selected' : '' ?>>Super Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 p-4 pt-0">
                            <button type="button" class="btn btn-luxury-secondary flex-grow-1" data-bs-dismiss="modal"><?= __('cancel') ?></button>
                            <button type="submit" class="btn btn-primary flex-grow-1 shadow-primary fw-extrabold"><?= __('save_changes') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- Add Admin Modal -->
<div class="modal fade" id="addAdminModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 luxury-modal rounded-5 overflow-hidden shadow-lg">
            <form action="<?= BASE_URL ?>/admins/store" method="POST" class="ajax-form">
                <div class="modal-header bg-dark text-white border-0 p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div>
                            <h5 class="modal-title fw-extrabold mb-0"><?= __('add_new') ?> <?= __('admin') ?></h5>
                            <div class="x-small fw-bold opacity-50 text-uppercase tracking-widest"><?= __('create_system_user') ?></div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 pt-5">
                    <div class="luxury-input-group">
                        <label class="luxury-label"><?= __('full_name') ?> *</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person-fill icon"></i>
                            <input type="text" name="name" placeholder="<?= __('full_name') ?>" required>
                        </div>
                    </div>
                    <div class="luxury-input-group">
                        <label class="luxury-label"><?= __('email_address') ?> *</label>
                        <div class="input-wrapper">
                            <i class="bi bi-envelope-fill icon"></i>
                            <input type="email" name="email" placeholder="admin@hotel-aura.com" required>
                        </div>
                    </div>
                    <div class="luxury-input-group">
                        <label class="luxury-label"><?= __('password') ?> *</label>
                        <div class="input-wrapper">
                            <i class="bi bi-shield-lock-fill icon"></i>
                            <input type="password" name="password" placeholder="••••••••" required>
                        </div>
                    </div>
                    <div class="luxury-input-group">
                        <label class="luxury-label"><?= __('role') ?> *</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person-badge-fill icon"></i>
                            <select name="role" class="luxury-select">
                                <option value="admin">Admin</option>
                                <option value="super_admin">Super Admin</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-luxury-secondary flex-grow-1" data-bs-dismiss="modal"><?= __('cancel') ?></button>
                    <button type="submit" class="btn btn-primary flex-grow-1 shadow-primary fw-extrabold"><?= __('save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* LUXURY ADMIN REGISTRY STYLES */
.fw-extrabold { font-weight: 800; }
.x-small { font-size: 0.7rem; }
.tracking-widest { letter-spacing: 0.15em; }

.admin-avatar-box { position: relative; width: 48px; height: 48px; }
.admin-avatar { width: 100%; height: 100%; border-radius: 14px; object-fit: cover; border: 2px solid white; }
.self-tag { position: absolute; bottom: -4px; right: -4px; font-size: 0.8rem; color: #10b981; background: white; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; }

.premium-card { background: white; border-radius: 24px; box-shadow: 0 10px 40px -10px rgba(0,0,0,0.04); overflow: hidden; }
.luxury-table thead th { font-size: 0.65rem; letter-spacing: 0.1em; color: #64748b; }
.admin-luxury-row { transition: all 0.2s; border-bottom: 1px solid #f8fafc; }
.admin-luxury-row:hover { background: #f8fafc; }

.btn-luxury-action {
    width: 38px; height: 38px; border-radius: 12px; border: 1px solid #f1f5f9; background: white; color: #64748b;
    display: flex; align-items: center; justify-content: center; transition: all 0.2s;
}
.btn-luxury-action:hover { background: #1e293b; color: white; transform: translateY(-2px); }

/* LUXURY MODAL STYLES */
.luxury-modal .modal-header { background: #1e293b !important; }
.icon-box-sm { width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }

.luxury-input-group { position: relative; }
.luxury-label { font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 8px; display: block; }

.input-wrapper {
    display: flex; align-items: center; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 0 16px; transition: all 0.3s;
}
.input-wrapper:focus-within { border-color: #1e293b; background: white; box-shadow: 0 10px 20px -10px rgba(0,0,0,0.05); }

.input-wrapper .icon { color: #94a3b8; font-size: 1.1rem; margin-right: 12px; }
.input-wrapper input, .input-wrapper select, .input-wrapper .luxury-select {
    border: none; background: transparent; padding: 12px 0;
    flex: 1; width: 0; min-width: 0;
    font-weight: 600; color: #1e293b; outline: none;
}
.luxury-select, .input-wrapper select { cursor: pointer; -webkit-appearance: none; -moz-appearance: none; appearance: none; }

.btn-luxury-secondary { background: #f1f5f9; color: #64748b; border: none; padding: 12px; border-radius: 14px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.75rem; }
.btn-primary { border-radius: 14px; padding: 12px; border: none; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; background: #1e293b !important; color: white !important; }
.btn-primary:hover { background: #000 !important; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof initTableSearch === 'function') {
        initTableSearch('#adminSearchInput', '#adminTable');
    }
});
</script>
