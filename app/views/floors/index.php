<div class="animate__animated animate__fadeIn px-lg-4">
    <!-- Luxury Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-4">
        <div>
            <h2 class="mb-1 fw-extrabold text-dark d-flex align-items-center gap-3">
                <?= __('manage_floors') ?>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1 rounded-pill small" style="font-size: 0.8rem;">
                    <?= count($floors) ?> <?= strtoupper(__('levels')) ?>
                </span>
            </h2>
            <p class="text-muted small mb-0 fw-medium"><?= __('manage_floors_desc') ?></p>
        </div>
        
        <div class="d-flex gap-3 flex-wrap align-items-center">
            <div class="premium-search-box shadow-sm border rounded-pill overflow-hidden bg-white d-flex align-items-center px-3" style="min-width: 300px; height: 48px;">
                <i class="bi bi-search text-primary opacity-50 me-2"></i>
                <input type="text" id="floorSearchInput" class="form-control border-0 shadow-none bg-transparent ps-0" placeholder="<?= __('search') ?> <?= __('floors') ?>...">
            </div>
            <button class="btn btn-primary shadow-primary px-4 py-2 d-flex align-items-center gap-2 rounded-pill fw-bold h-48" data-bs-toggle="modal" data-bs-target="#addFloorModal">
                <i class="bi bi-plus-lg fs-5"></i>
                <span><?= __('add_new') ?></span>
            </button>
        </div>
    </div>

    <!-- Floors Registry Table -->
    <div class="premium-card mb-5 animate__animated animate__fadeInUp">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle luxury-table" id="floorTable">
                <thead>
                    <tr class="text-muted x-small text-uppercase tracking-widest bg-light bg-opacity-50">
                        <th class="ps-4 py-4 fw-extrabold border-0"><?= __('id') ?></th>
                        <th class="py-4 fw-extrabold border-0"><?= __('floor_number') ?></th>
                        <th class="py-4 fw-extrabold border-0"><?= __('description') ?></th>
                        <th class="text-end pe-4 py-4 fw-extrabold border-0"><?= __('actions') ?></th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if (empty($floors)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="py-5 opacity-50">
                                    <i class="bi bi-layers display-1 text-muted mb-3 d-block"></i>
                                    <h5 class="fw-bold text-muted"><?= __('no_results') ?></h5>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($floors as $floor): ?>
                            <tr class="floor-luxury-row" id="row-<?= $floor['id'] ?>">
                                <td class="ps-4 py-4 fw-extrabold text-muted x-small">#<?= str_pad($floor['id'], 3, '0', STR_PAD_LEFT) ?></td>
                                <td class="py-4">
                                    <div class="d-inline-flex align-items-center px-3 py-2 bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 rounded-pill x-small fw-extrabold tracking-wider">
                                        <i class="bi bi-layers-fill me-2"></i>
                                        <?= strtoupper(__('floor')) ?> <?= htmlspecialchars($floor['floor_number']) ?>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <div class="text-muted small fw-medium"><?= htmlspecialchars($floor['description'] ?: 'N/A') ?></div>
                                </td>
                                <td class="text-end pe-4 py-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-luxury-action" data-bs-toggle="modal" data-bs-target="#editFloorModal<?= $floor['id'] ?>" title="<?= __('edit') ?>">
                                            <i class="bi bi-pencil-square text-primary"></i>
                                        </button>
                                        <?php if (($_SESSION['admin_role'] ?? '') === 'super_admin'): ?>
                                        <a href="<?= BASE_URL ?>/floors/delete?id=<?= $floor['id'] ?>" class="btn btn-luxury-action ajax-delete" data-row-id="row-<?= $floor['id'] ?>" title="<?= __('delete') ?>">
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
<?php if (!empty($floors)): ?>
    <?php foreach ($floors as $floor): ?>
        <div class="modal fade" id="editFloorModal<?= $floor['id'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 luxury-modal rounded-5 overflow-hidden shadow-lg">
                    <form action="<?= BASE_URL ?>/floors/update" method="POST" class="ajax-form">
                        <div class="modal-header bg-dark text-white border-0 p-4">
                            <div class="d-flex align-items-center gap-3">
                                <div>
                                    <h5 class="modal-title fw-extrabold mb-0"><?= __('edit') ?> <?= __('floor') ?></h5>
                                    <div class="x-small fw-bold opacity-50 text-uppercase tracking-widest"><?= __('modify_floor_details') ?></div>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4 pt-5">
                            <input type="hidden" name="id" value="<?= $floor['id'] ?>">
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('floor_number') ?> *</label>
                                <div class="input-wrapper">
                                    <i class="bi bi-layers-fill icon"></i>
                                    <input type="number" name="floor_number" value="<?= $floor['floor_number'] ?>" required>
                                </div>
                            </div>
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('description') ?></label>
                                <div class="input-wrapper align-items-start py-2">
                                    <i class="bi bi-chat-left-text-fill icon pt-1"></i>
                                    <textarea name="description" rows="3"><?= htmlspecialchars($floor['description']) ?></textarea>
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

<!-- Add Floor Modal -->
<div class="modal fade" id="addFloorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 luxury-modal rounded-5 overflow-hidden shadow-lg">
            <form action="<?= BASE_URL ?>/floors/store" method="POST" class="ajax-form">
                <div class="modal-header bg-dark text-white border-0 p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div>
                            <h5 class="modal-title fw-extrabold mb-0"><?= __('add_new') ?> <?= __('floor') ?></h5>
                            <div class="x-small fw-bold opacity-50 text-uppercase tracking-widest"><?= __('create_new_floor') ?></div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 pt-5">
                    <div class="luxury-input-group">
                        <label class="luxury-label"><?= __('floor_number') ?> *</label>
                        <div class="input-wrapper">
                            <i class="bi bi-layers-fill icon"></i>
                            <input type="number" name="floor_number" required placeholder="e.g. 1">
                        </div>
                    </div>
                    <div class="luxury-input-group">
                        <label class="luxury-label"><?= __('description') ?></label>
                        <div class="input-wrapper align-items-start py-2">
                            <i class="bi bi-chat-left-text-fill icon pt-1"></i>
                            <textarea name="description" rows="3" placeholder="Additional floor information..."></textarea>
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
/* FLOORS PAGE STYLES */
.fw-extrabold { font-weight: 800; }
.x-small { font-size: 0.7rem; }
.tracking-widest { letter-spacing: 0.15em; }
.h-48 { height: 48px; }

.premium-card { background: white; border-radius: 24px; box-shadow: 0 10px 40px -10px rgba(0,0,0,0.04); overflow: hidden; }
.luxury-table thead th { font-size: 0.65rem; letter-spacing: 0.1em; color: #64748b; }
.floor-luxury-row { transition: all 0.2s; border-bottom: 1px solid #f8fafc; }
.floor-luxury-row:hover { background: #f8fafc; }

.btn-luxury-action {
    width: 38px; height: 38px; border-radius: 12px; border: 1px solid #f1f5f9;
    background: white; color: #64748b; display: flex; align-items: center; justify-content: center; transition: all 0.2s;
}
.btn-luxury-action:hover { background: #1e293b; color: white; transform: translateY(-2px); }

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

.btn-luxury-secondary {
    background: #f1f5f9; color: #64748b; border: none;
    padding: 12px 20px; border-radius: 14px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.75rem;
}
.btn-luxury-secondary:hover { background: #e2e8f0; }
.btn-primary { border-radius: 14px !important; padding: 12px !important; font-size: 0.75rem !important; text-transform: uppercase !important; letter-spacing: 0.05em !important; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof initTableSearch === 'function') {
        initTableSearch('#floorSearchInput', '#floorTable');
    }
});
</script>
