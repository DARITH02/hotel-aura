<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="mb-1 fw-bold text-dark"><?= __('manage_admins') ?></h2>
        <p class="text-muted small mb-0">Control system access and administrator roles.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap align-items-center">
        <div class="input-group shadow-sm" style="min-width: 250px;">
            <span class="input-group-text bg-white border-end-0 text-muted">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" id="adminSearchInput" class="form-control border-start-0 ps-0" placeholder="<?= __('search') ?> <?= __('admins') ?>...">
        </div>
        <button class="btn btn-primary shadow-sm px-4 py-2 d-flex align-items-center gap-2 rounded-3 text-nowrap" data-bs-toggle="modal" data-bs-target="#addAdminModal">
            <i class="bi bi-person-plus-fill fs-5"></i>
            <span class="fw-bold"><?= __('add_new_administrator') ?></span>
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="adminTable">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4 py-3 fw-semibold border-0"><?= __('admin_info') ?></th>
                        <th class="py-3 fw-semibold border-0"><?= __('role') ?></th>
                        <th class="py-3 fw-semibold border-0"><?= __('registered_at') ?></th>
                        <th class="pe-4 py-3 fw-semibold border-0 text-end"><?= __('actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($admins)): ?>
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted"><?= __('no_results') ?></td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($admins as $admin): ?>
                        <tr id="row-<?= $admin['id'] ?>">
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($admin['name']) ?>&background=random" class="rounded-circle me-3" width="40">
                                    <div>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($admin['name']) ?></div>
                                        <div class="small text-muted"><?= htmlspecialchars($admin['email']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <?php if($admin['role'] == 'super_admin'): ?>
                                    <span class="badge bg-danger rounded-pill px-3">Super Admin</span>
                                <?php else: ?>
                                    <span class="badge bg-primary rounded-pill px-3">Admin</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 text-muted">
                                <?= date('M d, Y', strtotime($admin['created_at'])) ?>
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <button class="btn btn-icon btn-light border shadow-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#editAdminModal<?= $admin['id'] ?>" title="<?= __('edit') ?>">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </button>
                                    <?php if ($admin['id'] != $_SESSION['admin_id']): ?>
                                    <a href="<?= BASE_URL ?>/admins/delete?id=<?= $admin['id'] ?>" class="btn btn-icon btn-light border shadow-sm rounded-circle ajax-delete" data-row-id="row-<?= $admin['id'] ?>" title="<?= __('delete') ?>">
                                        <i class="bi bi-trash text-danger"></i>
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

<?php if (!empty($admins)): ?>
    <?php foreach ($admins as $admin): ?>
        <!-- Edit Admin Modal -->
        <div class="modal fade" id="editAdminModal<?= $admin['id'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <form action="<?= BASE_URL ?>/admins/update" method="POST" class="ajax-form">
                        <div class="modal-header">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-white bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                    <i class="bi bi-person-fill-gear fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="modal-title mb-0"><?= __('edit') ?> <?= __('admin') ?></h5>
                                    <div class="small text-white-50">Administrator #<?= $admin['id'] ?> Profile</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <input type="hidden" name="id" value="<?= $admin['id'] ?>">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('full_name') ?> *</label>
                                <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-person text-primary"></i></span>
                                    <input type="text" class="form-control border-0 py-2" name="name" value="<?= htmlspecialchars($admin['name']) ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('email_address') ?> *</label>
                                <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-primary"></i></span>
                                    <input type="email" class="form-control border-0 py-2" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase tracking-wider text-muted">New Password (leave blank to keep current)</label>
                                <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-shield-lock text-primary"></i></span>
                                    <input type="password" class="form-control border-0 py-2" name="password" placeholder="••••••••">
                                </div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label small fw-bold text-uppercase tracking-wider text-muted">Role *</label>
                                <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-person-badge text-primary"></i></span>
                                    <select class="form-select border-0 py-2" name="role">
                                        <option value="admin" <?= $admin['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="super_admin" <?= $admin['role'] == 'super_admin' ? 'selected' : '' ?>>Super Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 p-3">
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

<!-- Add Admin Modal -->
<div class="modal fade" id="addAdminModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form action="<?= BASE_URL ?>/admins/store" method="POST" class="ajax-form">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="bi bi-person-plus-fill fs-4"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0"><?= __('add_new_administrator') ?></h5>
                            <div class="small text-white-50">Create System User</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('full_name') ?> *</label>
                        <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-person text-primary"></i></span>
                            <input type="text" class="form-control border-0 py-2" name="name" placeholder="<?= __('name') ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('email_address') ?> *</label>
                        <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-primary"></i></span>
                            <input type="email" class="form-control border-0 py-2" name="email" placeholder="admin@hotel.com" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('password') ?> *</label>
                        <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-shield-lock text-primary"></i></span>
                            <input type="password" class="form-control border-0 py-2" name="password" placeholder="••••••••" required>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted">Role *</label>
                        <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-person-badge text-primary"></i></span>
                            <select class="form-select border-0 py-2" name="role">
                                <option value="admin">Admin</option>
                                <option value="super_admin">Super Admin</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3">
                    <button type="button" class="btn btn-link text-muted text-decoration-none px-4" data-bs-dismiss="modal"><?= __('cancel') ?></button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm fw-bold rounded-3">
                        <i class="bi bi-plus-lg me-1"></i> <?= __('create_admin') ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
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
    background-color: #f8f9fa;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
}
tr {
    transition: all 0.2s ease;
}
tr:hover {
    background-color: rgba(0, 123, 255, 0.02) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof initTableSearch === 'function') {
        initTableSearch('#adminSearchInput', '#adminTable');
    }
});
</script>
