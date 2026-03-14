<?php
$isSuperAdmin = ($_SESSION['admin_role'] ?? '') === 'super_admin';
?>

<div class="animate__animated animate__fadeIn px-lg-4">

    <!-- ═══ PAGE HEADER ═══════════════════════════════════════════════ -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-4">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <h2 class="mb-0 fw-extrabold text-dark"><?= __('manage_admins') ?></h2>
                <span class="badge rounded-pill" style="background:rgba(220,38,38,0.08);color:#dc2626;border:1px solid rgba(220,38,38,0.2);font-size:0.72rem;padding:5px 12px;font-weight:800;">
                    <?= count($admins) ?> <?= strtoupper(__('users')) ?>
                </span>
            </div>
            <p class="text-muted small mb-0 fw-medium"><?= __('manage_admins_desc') ?></p>
        </div>

        <div class="d-flex gap-3 flex-wrap align-items-center">
            <!-- Search -->
            <div class="admin-search-box d-flex align-items-center px-3 gap-2">
                <i class="bi bi-search opacity-50" style="color:#64748b;"></i>
                <input type="text" id="adminSearchInput" placeholder="<?= __('search') ?> <?= __('admins') ?>..." class="border-0 bg-transparent outline-none fw-medium" style="outline:none;font-size:0.875rem;color:#334155;min-width:220px;">
            </div>
            <!-- Add button -->
            <button class="btn-add-admin" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                <i class="bi bi-person-plus-fill"></i>
                <span><?= __('add_new') ?></span>
            </button>
        </div>
    </div>

    <!-- ═══ ROLE INFO BANNER (only for regular admins) ══════════════ -->
    <?php if (!$isSuperAdmin): ?>
    <div class="role-info-banner mb-4">
        <i class="bi bi-info-circle-fill"></i>
        <span>You are logged in as <strong>Admin</strong>. You can add and edit administrators, but only Super Admins can delete accounts.</span>
    </div>
    <?php endif; ?>

    <!-- ═══ ADMIN CARDS GRID ══════════════════════════════════════════ -->
    <?php if (empty($admins)): ?>
    <div class="empty-state">
        <div class="empty-icon"><i class="bi bi-shield-lock-fill"></i></div>
        <h5 class="fw-bold text-muted mt-3"><?= __('no_results') ?></h5>
        <p class="small text-muted">No administrators have been registered yet.</p>
    </div>
    <?php else: ?>

    <div class="row g-4 admin-grid" id="adminTable">
        <?php foreach ($admins as $admin): ?>
        <div class="col-sm-6 col-xl-4 admin-card-col" id="row-<?= $admin['id'] ?>">
            <div class="admin-card <?= $admin['id'] == $_SESSION['admin_id'] ? 'is-self' : '' ?>">

                <!-- Card top accent -->
                <div class="card-accent <?= $admin['role'] === 'super_admin' ? 'accent-super' : 'accent-admin' ?>"></div>

                <!-- Avatar + badges -->
                <div class="d-flex align-items-start justify-content-between mb-4 pt-4 px-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="admin-card-avatar">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($admin['name']) ?>&background=<?= $admin['role'] === 'super_admin' ? 'dc2626&color=fff' : '1e293b&color=fff' ?>&bold=true&size=80" alt="">
                            <?php if ($admin['id'] == $_SESSION['admin_id']): ?>
                            <div class="self-badge" title="You"><i class="bi bi-check2"></i></div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <div class="admin-card-name"><?= htmlspecialchars($admin['name']) ?></div>
                            <div class="admin-card-email"><?= htmlspecialchars($admin['email']) ?></div>
                        </div>
                    </div>

                    <!-- Role badge -->
                    <?php if ($admin['role'] === 'super_admin'): ?>
                    <span class="role-badge role-super">
                        <i class="bi bi-shield-fill-check"></i> SUPER
                    </span>
                    <?php else: ?>
                    <span class="role-badge role-admin">
                        <i class="bi bi-person-badge-fill"></i> ADMIN
                    </span>
                    <?php endif; ?>
                </div>

                <!-- Divider -->
                <div class="mx-4 mb-4" style="height:1px;background:#f1f5f9;"></div>

                <!-- Meta info -->
                <div class="px-4 mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="admin-meta-label">Registered</div>
                            <div class="admin-meta-value"><?= date('d M Y', strtotime($admin['created_at'])) ?></div>
                        </div>
                        <div class="text-end">
                            <div class="admin-meta-label">ID</div>
                            <div class="admin-meta-value">#<?= str_pad($admin['id'], 3, '0', STR_PAD_LEFT) ?></div>
                        </div>
                    </div>
                </div>

                <!-- Actions footer -->
                <div class="admin-card-footer">
                    <!-- Edit — available to everyone -->
                    <button class="card-action-btn btn-edit"
                        data-bs-toggle="modal"
                        data-bs-target="#editAdminModal<?= $admin['id'] ?>"
                        title="Edit">
                        <i class="bi bi-pencil-fill"></i>
                        <span>Edit</span>
                    </button>

                    <!-- Delete — Super Admin only, can't delete self -->
                    <?php if ($isSuperAdmin && $admin['id'] != $_SESSION['admin_id']): ?>
                    <a href="<?= BASE_URL ?>/admins/delete?id=<?= $admin['id'] ?>"
                        class="card-action-btn btn-delete ajax-delete"
                        data-row-id="row-<?= $admin['id'] ?>"
                        title="Delete">
                        <i class="bi bi-trash3-fill"></i>
                        <span>Delete</span>
                    </a>
                    <?php elseif (!$isSuperAdmin): ?>
                    <span class="card-action-btn btn-locked" title="Super Admin only">
                        <i class="bi bi-lock-fill"></i>
                        <span>Locked</span>
                    </span>
                    <?php endif; ?>
                </div>

            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</div><!-- end px-lg-4 -->

<!-- ═══════════════════════════════════════════════════════════════════
     EDIT MODALS
═══════════════════════════════════════════════════════════════════════ -->
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
                        <?php if ($isSuperAdmin): ?>
                        <div class="luxury-input-group">
                            <label class="luxury-label"><?= __('role') ?> *</label>
                            <div class="input-wrapper">
                                <i class="bi bi-person-badge-fill icon"></i>
                                <select name="role">
                                    <option value="admin" <?= $admin['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                    <option value="super_admin" <?= $admin['role'] == 'super_admin' ? 'selected' : '' ?>>Super Admin</option>
                                </select>
                            </div>
                        </div>
                        <?php else: ?>
                        <input type="hidden" name="role" value="<?= $admin['role'] ?>">
                        <?php endif; ?>
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

<!-- ═══════════════════════════════════════════════════════════════════
     ADD ADMIN MODAL
═══════════════════════════════════════════════════════════════════════ -->
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
                    <?php if ($isSuperAdmin): ?>
                    <div class="luxury-input-group">
                        <label class="luxury-label"><?= __('role') ?> *</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person-badge-fill icon"></i>
                            <select name="role">
                                <option value="admin">Admin</option>
                                <option value="super_admin">Super Admin</option>
                            </select>
                        </div>
                    </div>
                    <?php else: ?>
                    <input type="hidden" name="role" value="admin">
                    <?php endif; ?>
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
/* ═══ UTILITY ═════════════════════════════════════ */
.fw-extrabold { font-weight: 800; }
.x-small { font-size: 0.7rem; }
.tracking-widest { letter-spacing: 0.15em; }

/* ═══ SEARCH BOX ══════════════════════════════════ */
.admin-search-box {
    height: 48px;
    background: white;
    border: 1.5px solid #eef2f7;
    border-radius: 100px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    transition: all 0.3s;
}
.admin-search-box:focus-within {
    border-color: #1e293b;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}
.admin-search-box input { outline: none; }

/* ═══ ADD BUTTON ══════════════════════════════════ */
.btn-add-admin {
    height: 48px; padding: 0 24px;
    background: #1e293b; color: white;
    border: none; border-radius: 100px;
    font-weight: 800; font-size: 0.8rem;
    letter-spacing: 0.05em; text-transform: uppercase;
    display: inline-flex; align-items: center; gap: 8px;
    cursor: pointer; transition: all 0.2s;
    box-shadow: 0 8px 20px rgba(30,41,59,0.25);
}
.btn-add-admin:hover { background: #0f172a; transform: translateY(-2px); box-shadow: 0 12px 28px rgba(30,41,59,0.35); }

/* ═══ ROLE INFO BANNER ════════════════════════════ */
.role-info-banner {
    display: flex; align-items: center; gap: 10px;
    background: rgba(59,130,246,0.05);
    border: 1px solid rgba(59,130,246,0.15);
    border-radius: 14px; padding: 12px 18px;
    font-size: 0.82rem; color: #3b82f6; font-weight: 500;
}
.role-info-banner strong { font-weight: 800; }

/* ═══ ADMIN CARD ══════════════════════════════════ */
.admin-card {
    background: white;
    border-radius: 24px;
    border: 1.5px solid #f1f5f9;
    box-shadow: 0 4px 24px rgba(0,0,0,0.04);
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
}
.admin-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 48px rgba(0,0,0,0.1);
    border-color: #e2e8f0;
}
.admin-card.is-self {
    border-color: rgba(16,185,129,0.3);
    box-shadow: 0 4px 24px rgba(16,185,129,0.08);
}

/* top color accent bar */
.card-accent { height: 4px; }
.accent-super { background: linear-gradient(90deg, #dc2626, #f97316); }
.accent-admin { background: linear-gradient(90deg, #1e293b, #475569); }

/* avatar */
.admin-card-avatar {
    width: 52px; height: 52px; border-radius: 16px;
    overflow: hidden; position: relative;
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    flex-shrink: 0;
}
.admin-card-avatar img { width: 100%; height: 100%; object-fit: cover; }
.self-badge {
    position: absolute; bottom: -3px; right: -3px;
    width: 18px; height: 18px; border-radius: 50%;
    background: #10b981; color: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.6rem; border: 2px solid white;
}

/* text */
.admin-card-name { font-weight: 800; font-size: 0.95rem; color: #1e293b; }
.admin-card-email { font-size: 0.72rem; color: #94a3b8; font-weight: 600; margin-top: 2px; }

/* role badges */
.role-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 11px; border-radius: 100px;
    font-size: 0.65rem; font-weight: 800; letter-spacing: 0.08em;
    white-space: nowrap; flex-shrink: 0;
}
.role-super { background: rgba(220,38,38,0.08); color: #dc2626; border: 1px solid rgba(220,38,38,0.2); }
.role-admin { background: rgba(30,41,59,0.08); color: #1e293b; border: 1px solid rgba(30,41,59,0.15); }

/* meta info */
.admin-meta-label { font-size: 0.62rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #94a3b8; margin-bottom: 3px; }
.admin-meta-value { font-size: 0.82rem; font-weight: 700; color: #334155; }

/* card footer actions */
.admin-card-footer {
    display: flex; gap: 8px;
    padding: 12px 16px;
    background: #f8fafc;
    border-top: 1px solid #f1f5f9;
}
.card-action-btn {
    flex: 1; height: 40px;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    border-radius: 12px; border: 1.5px solid;
    font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
    cursor: pointer; transition: all 0.2s; text-decoration: none;
}
.btn-edit {
    background: rgba(30,41,59,0.04); color: #1e293b;
    border-color: rgba(30,41,59,0.1);
}
.btn-edit:hover { background: #1e293b; color: white; border-color: #1e293b; transform: translateY(-1px); }
.btn-delete {
    background: rgba(220,38,38,0.04); color: #dc2626;
    border-color: rgba(220,38,38,0.15);
}
.btn-delete:hover { background: #dc2626; color: white; border-color: #dc2626; transform: translateY(-1px); }
.btn-locked {
    background: #f8fafc; color: #cbd5e1;
    border-color: #e2e8f0; cursor: not-allowed;
}

/* ═══ EMPTY STATE ═════════════════════════════════ */
.empty-state {
    text-align: center; padding: 80px 20px;
    background: white; border-radius: 24px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.04);
}
.empty-icon {
    width: 72px; height: 72px; border-radius: 20px;
    background: #f8fafc; display: flex; align-items: center; justify-content: center;
    font-size: 2rem; color: #cbd5e1; margin: 0 auto;
}

/* ═══ LUXURY MODAL & INPUT ════════════════════════ */
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
.input-wrapper:focus-within { border-color: #1e293b; background: white; box-shadow: 0 10px 20px -10px rgba(0,0,0,0.08); }
.input-wrapper .icon { color: #94a3b8; font-size: 1.1rem; margin-right: 12px; flex-shrink: 0; }
.input-wrapper input,
.input-wrapper select {
    border: none !important; background: transparent !important;
    padding: 13px 0 !important; flex: 1; width: 0; min-width: 0;
    font-weight: 600 !important; color: #1e293b !important;
    outline: none !important; box-shadow: none !important;
    -webkit-appearance: none; -moz-appearance: none; appearance: none;
}
.btn-luxury-secondary {
    background: #f1f5f9; color: #64748b; border: none;
    padding: 12px 20px; border-radius: 14px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.75rem;
}
.btn-primary {
    border-radius: 14px !important; padding: 12px !important; border: none !important;
    font-size: 0.75rem !important; text-transform: uppercase !important;
    letter-spacing: 0.05em !important; background: #1e293b !important; color: white !important;
}
.btn-primary:hover { background: #0f172a !important; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Live search on admin name/email across cards
    const searchInput = document.getElementById('adminSearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const q = this.value.toLowerCase().trim();
            document.querySelectorAll('.admin-card-col').forEach(col => {
                const text = col.innerText.toLowerCase();
                col.style.display = text.includes(q) ? '' : 'none';
            });
        });
    }
});
</script>
