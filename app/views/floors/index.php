<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="mb-1 fw-bold text-dark"><?= __('manage_floors') ?></h2>
        <p class="text-muted small mb-0">Organize and manage hotel floor sections with precision.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap align-items-center">
        <div class="input-group shadow-sm" style="min-width: 250px;">
            <span class="input-group-text bg-white border-end-0 text-muted">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" id="floorSearchInput" class="form-control border-start-0 ps-0" placeholder="<?= __('search') ?> <?= __('floors') ?>...">
        </div>
        <button class="btn btn-primary shadow-sm px-4 py-2 d-flex align-items-center gap-2 rounded-3 text-nowrap" data-bs-toggle="modal" data-bs-target="#addFloorModal">
            <i class="bi bi-plus-lg fs-5"></i>
            <span class="fw-bold"><?= __('add_new') ?></span>
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle" id="floorTable">
                <thead class="bg-light bg-gradient border-bottom">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-muted"><?= __('id') ?></th>
                        <th class="py-3 text-uppercase small fw-bold text-muted"><?= __('floor_number') ?></th>
                        <th class="py-3 text-uppercase small fw-bold text-muted"><?= __('description') ?></th>
                        <th class="text-end pe-4 py-3 text-uppercase small fw-bold text-muted"><?= __('actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($floors)): ?>
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <div class="py-5">
                                <div class="mb-3">
                                    <i class="bi bi-layers display-4 text-light opacity-50"></i>
                                </div>
                                <h5 class="fw-bold mb-1 opacity-75"><?= __('no_results') ?></h5>
                                <p class="small mb-0 opacity-50">No floor levels have been configured yet.</p>
                            </div>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($floors as $floor): ?>
                        <tr class="floor-row" id="row-<?= $floor['id'] ?>">
                            <td class="ps-4 py-3 fw-medium text-secondary">#<?= htmlspecialchars($floor['id']) ?></td>
                            <td class="py-3">
                                <div class="d-inline-flex align-items-center px-3 py-1 bg-white border rounded-pill shadow-sm">
                                    <i class="bi bi-layers-fill text-primary me-2 small"></i>
                                    <span class="fw-bold small text-dark"><?= __('floor') ?> <?= htmlspecialchars($floor['floor_number']) ?></span>
                                </div>
                            </td>
                            <td class="py-3 text-muted"><?= htmlspecialchars($floor['description'] ?? 'N/A') ?></td>
                            <td class="text-end pe-4 py-3">
                                <div class="d-flex justify-content-end gap-2">
                                    <button class="btn btn-icon btn-light border shadow-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#editFloorModal<?= $floor['id'] ?>" title="<?= __('edit') ?>">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </button>
                                    <a href="<?= BASE_URL ?>/floors/delete?id=<?= $floor['id'] ?>" class="btn btn-icon btn-light border shadow-sm rounded-circle ajax-delete" data-row-id="row-<?= $floor['id'] ?>" title="<?= __('delete') ?>">
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
    background-color: #f0f0f0;
    transform: translateY(-1px);
}
.floor-row {
    transition: all 0.2s ease;
    border-left: 4px solid transparent;
}
.floor-row:hover {
    background-color: rgba(0, 123, 255, 0.03) !important;
    border-left-color: #0d6efd;
}
</style>

<?php if (!empty($floors)): ?>
    <?php foreach ($floors as $floor): ?>
        <!-- Edit Floor Modal -->
        <div class="modal fade" id="editFloorModal<?= $floor['id'] ?>" tabindex="-1" aria-labelledby="editFloorModalLabel<?= $floor['id'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <form action="<?= BASE_URL ?>/floors/update" method="POST" class="ajax-form">
                        <div class="modal-header">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-white bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                    <i class="bi bi-pencil-square fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="modal-title mb-0" id="editFloorModalLabel<?= $floor['id'] ?>"><?= __('edit') ?> <?= __('floor') ?></h5>
                                    <div class="small text-white-50">Modify floor details</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <input type="hidden" name="id" value="<?= $floor['id'] ?>">
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('floor_number') ?> *</label>
                                <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-layers text-primary"></i></span>
                                    <input type="number" class="form-control border-0 py-2" name="floor_number" value="<?= htmlspecialchars($floor['floor_number']) ?>" required placeholder="e.g. 1">
                                </div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('description') ?></label>
                                <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-0 align-items-start pt-2"><i class="bi bi-chat-left-text text-primary"></i></span>
                                    <textarea class="form-control border-0 py-2" name="description" rows="3" placeholder="Optional floor details..."><?= htmlspecialchars($floor['description']) ?></textarea>
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

<!-- Add Floor Modal -->
<div class="modal fade" id="addFloorModal" tabindex="-1" aria-labelledby="addFloorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="<?= BASE_URL ?>/floors/store" method="POST" class="ajax-form">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="bi bi-plus-lg fs-4"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0" id="addFloorModalLabel"><?= __('add_new') ?> <?= __('floor') ?></h5>
                            <div class="small text-white-50">Create a new hotel floor</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('floor_number') ?> *</label>
                        <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-layers text-primary"></i></span>
                            <input type="number" class="form-control border-0 py-2" name="floor_number" required placeholder="e.g. 1">
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('description') ?></label>
                        <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0 align-items-start pt-2"><i class="bi bi-chat-left-text text-primary"></i></span>
                            <textarea class="form-control border-0 py-2" name="description" rows="3" placeholder="Optional floor details..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3">
                    <button type="button" class="btn btn-link text-muted text-decoration-none px-4" data-bs-dismiss="modal"><?= __('cancel') ?></button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm fw-bold rounded-3">
                        <i class="bi bi-plus-lg me-1"></i> <?= __('create_floor') ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof initTableSearch === 'function') {
        initTableSearch('#floorSearchInput', '#floorTable');
    }
});
</script>
