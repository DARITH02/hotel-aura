<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="mb-1 fw-bold text-dark"><?= __('manage_services') ?></h2>
        <p class="text-muted small mb-0">Manage additional hotel services and amenities.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap align-items-center">
        <div class="input-group shadow-sm" style="min-width: 250px;">
            <span class="input-group-text bg-white border-end-0 text-muted">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" id="serviceSearchInput" class="form-control border-start-0 ps-0" placeholder="<?= __('search') ?> <?= __('services') ?>...">
        </div>
        <button class="btn btn-primary shadow-sm px-4 py-2 d-flex align-items-center gap-2 rounded-3 text-nowrap" data-bs-toggle="modal" data-bs-target="#addServiceModal">
            <i class="bi bi-plus-lg fs-5"></i>
            <span class="fw-bold"><?= __('add_new') ?></span>
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle" id="serviceTable">
                <thead class="bg-light bg-gradient border-bottom">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-muted"><?= __('image') ?></th>
                        <th class="py-3 text-uppercase small fw-bold text-muted"><?= __('service_name') ?></th>
                        <th class="py-3 text-uppercase small fw-bold text-muted"><?= __('unit_price') ?></th>
                        <th class="py-3 text-uppercase small fw-bold text-muted"><?= __('description') ?></th>
                        <th class="text-end pe-4 py-3 text-uppercase small fw-bold text-muted"><?= __('actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($services)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted"><?= __('no_results') ?></td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($services as $srv): ?>
                            <tr id="row-<?= $srv['id'] ?>">
                                <td class="ps-4">
                                    <?php if (!empty($srv['image'])): ?>
                                        <img src="<?= BASE_URL ?>/uploads/services/<?= htmlspecialchars($srv['image']) ?>" alt="<?= htmlspecialchars($srv['name']) ?>" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                    <?php else: ?>
                                        <div class="bg-light text-muted d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 6px; border: 1px dashed #ccc;">
                                            <i class="bi bi-image text-muted opacity-50"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-bold text-dark">
                                    <?= htmlspecialchars($srv['name']) ?>
                                </td>
                                <td class="text-muted text-truncate" style="max-width: 300px;">
                                    <?= htmlspecialchars($srv['description'] ?: __('no_results')) ?>
                                </td>
                                <td class="fw-bold text-success fs-5">
                                    $<?= number_format($srv['price'], 2) ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-icon btn-light border shadow-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#editServiceModal<?= $srv['id'] ?>" title="<?= __('edit') ?>">
                                            <i class="bi bi-pencil-square text-primary"></i>
                                        </button>
                                        <a href="<?= BASE_URL ?>/services/delete?id=<?= $srv['id'] ?>" class="btn btn-icon btn-light border shadow-sm rounded-circle ajax-delete" data-row-id="row-<?= $srv['id'] ?>" title="<?= __('delete') ?>">
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

<?php if (!empty($services)): ?>
    <?php foreach ($services as $srv): ?>
        <!-- Edit Service Modal -->
        <div class="modal fade" id="editServiceModal<?= $srv['id'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <form action="<?= BASE_URL ?>/services/update" method="POST" enctype="multipart/form-data" class="ajax-form">
                        <div class="modal-header">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-white bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                    <i class="bi bi-pencil-square fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="modal-title mb-0"><?= __('edit') ?> <?= __('service') ?></h5>
                                    <div class="small text-white-50">Update amenity details</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <input type="hidden" name="id" value="<?= $srv['id'] ?>">
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('service_name') ?> *</label>
                                <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-tag text-primary"></i></span>
                                    <input type="text" class="form-control border-0 py-2" name="name" value="<?= htmlspecialchars($srv['name']) ?>" required placeholder="e.g. Airport Shuttle">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('unit_price') ?> ($) *</label>
                                <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-currency-dollar text-primary"></i></span>
                                    <input type="number" step="0.01" min="0" class="form-control border-0 py-2" name="price" value="<?= $srv['price'] ?>" required placeholder="0.00">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('description') ?></label>
                                <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-0 align-items-start pt-2"><i class="bi bi-card-text text-primary"></i></span>
                                    <textarea class="form-control border-0 py-2" name="description" rows="3" placeholder="Details about this service"><?= htmlspecialchars($srv['description']) ?></textarea>
                                </div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('service_image') ?></label>
                                <?php if (!empty($srv['image'])): ?>
                                    <div class="mb-2">
                                        <img src="<?= BASE_URL ?>/uploads/services/<?= htmlspecialchars($srv['image']) ?>" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="form-control shadow-sm" name="image" accept="image/*" onchange="previewServiceImage(this)">
                                <div class="preview-container mt-2"></div>
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

<!-- Add Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="<?= BASE_URL ?>/services/store" method="POST" enctype="multipart/form-data" class="ajax-form">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="bi bi-plus-lg fs-4"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0"><?= __('add_new') ?> <?= __('service') ?></h5>
                            <div class="small text-white-50">Add a new hotel amenity</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('service_name') ?> *</label>
                        <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-tag text-primary"></i></span>
                            <input type="text" class="form-control border-0 py-2" name="name" required placeholder="e.g. Airport Shuttle">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('unit_price') ?> ($) *</label>
                        <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-currency-dollar text-primary"></i></span>
                            <input type="number" step="0.01" min="0" class="form-control border-0 py-2" name="price" required placeholder="0.00">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('description') ?></label>
                        <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0 align-items-start pt-2"><i class="bi bi-card-text text-primary"></i></span>
                            <textarea class="form-control border-0 py-2" name="description" rows="3" placeholder="Details about this service"></textarea>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('service_image') ?></label>
                        <input type="file" class="form-control shadow-sm" name="image" accept="image/*" onchange="previewServiceImage(this)">
                        <div class="preview-container mt-2"></div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3">
                    <button type="button" class="btn btn-link text-muted text-decoration-none px-4" data-bs-dismiss="modal"><?= __('cancel') ?></button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm fw-bold rounded-3">
                        <i class="bi bi-plus-lg me-1"></i> <?= __('create_service') ?>
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
function previewServiceImage(input) {
    const container = input.nextElementSibling;
    container.innerHTML = '';
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-thumbnail';
            img.style = 'width: 80px; height: 80px; object-fit: cover;';
            container.appendChild(img);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    if (typeof initTableSearch === 'function') {
        initTableSearch('#serviceSearchInput', '#serviceTable');
    }
});
</script>