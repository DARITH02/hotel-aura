<div class="animate__animated animate__fadeIn px-lg-4">
    <!-- Luxury Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-4">
        <div>
            <h2 class="mb-1 fw-extrabold text-dark d-flex align-items-center gap-3">
                <?= __('manage_services') ?>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1 rounded-pill small" style="font-size: 0.8rem;">
                    <?= count($services) ?> <?= strtoupper(__('services')) ?>
                </span>
            </h2>
            <p class="text-muted small mb-0 fw-medium"><?= __('manage_services_desc') ?></p>
        </div>
        
        <div class="d-flex gap-3 flex-wrap align-items-center">
            <div class="premium-search-box shadow-sm border rounded-pill overflow-hidden bg-white d-flex align-items-center px-3" style="min-width: 300px; height: 48px;">
                <i class="bi bi-search text-primary opacity-50 me-2"></i>
                <input type="text" id="serviceSearchInput" class="form-control border-0 shadow-none bg-transparent ps-0" placeholder="<?= __('search') ?> <?= __('services') ?>...">
            </div>
            <button class="btn btn-primary shadow-primary px-4 py-2 d-flex align-items-center gap-2 rounded-pill fw-bold h-48" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                <i class="bi bi-plus-lg fs-5"></i>
                <span><?= __('add_new') ?></span>
            </button>
        </div>
    </div>

    <!-- Services Registry Table -->
    <div class="premium-card mb-5 animate__animated animate__fadeInUp">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle luxury-table" id="serviceTable">
                <thead>
                    <tr class="text-muted x-small text-uppercase tracking-widest bg-light bg-opacity-50">
                        <th class="ps-4 py-4 fw-extrabold border-0"><?= __('image') ?></th>
                        <th class="py-4 fw-extrabold border-0"><?= __('service_name') ?></th>
                        <th class="py-4 fw-extrabold border-0"><?= __('description') ?></th>
                        <th class="py-4 fw-extrabold border-0"><?= __('unit_price') ?></th>
                        <th class="text-end pe-4 py-4 fw-extrabold border-0"><?= __('actions') ?></th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if (empty($services)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-5 opacity-50">
                                    <i class="bi bi-collection-fill display-1 text-muted mb-3 d-block"></i>
                                    <h5 class="fw-bold text-muted"><?= __('no_results') ?></h5>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($services as $srv): ?>
                            <tr class="service-luxury-row" id="row-<?= $srv['id'] ?>">
                                <td class="ps-4 py-4">
                                    <div class="service-thumb-container">
                                        <?php if (!empty($srv['image'])): ?>
                                            <img src="<?= BASE_URL ?>/uploads/services/<?= htmlspecialchars($srv['image']) ?>" alt="" class="service-thumb">
                                        <?php else: ?>
                                            <div class="service-thumb-placeholder">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <div class="fw-extrabold text-dark"><?= htmlspecialchars($srv['name']) ?></div>
                                    <div class="x-small text-muted fw-bold text-uppercase tracking-widest opacity-50">SKU: #S<?= str_pad($srv['id'], 3, '0', STR_PAD_LEFT) ?></div>
                                </td>
                                <td class="py-4">
                                    <div class="text-muted small text-truncate" style="max-width: 350px;" title="<?= htmlspecialchars($srv['description']) ?>">
                                        <?= htmlspecialchars($srv['description'] ?: __('no_results')) ?>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <div class="fw-extrabold text-dark fs-5">$<?= number_format($srv['price'], 2) ?></div>
                                </td>
                                <td class="text-end pe-4 py-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-luxury-action" data-bs-toggle="modal" data-bs-target="#editServiceModal<?= $srv['id'] ?>" title="<?= __('edit') ?>">
                                            <i class="bi bi-pencil-square text-primary"></i>
                                        </button>
                                        <a href="<?= BASE_URL ?>/services/delete?id=<?= $srv['id'] ?>" class="btn btn-luxury-action ajax-delete" data-row-id="row-<?= $srv['id'] ?>" title="<?= __('delete') ?>">
                                            <i class="bi bi-trash3-fill text-danger"></i>
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

<!-- Add/Edit Modals Integration -->
<?php if (!empty($services)): ?>
    <?php foreach ($services as $srv): ?>
        <div class="modal fade" id="editServiceModal<?= $srv['id'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 luxury-modal rounded-5 overflow-hidden shadow-lg">
                    <form action="<?= BASE_URL ?>/services/update" method="POST" enctype="multipart/form-data" class="ajax-form">
                        <div class="modal-header bg-dark text-white border-0 p-4">
                            <div class="d-flex align-items-center gap-3">
                                <div>
                                    <h5 class="modal-title fw-extrabold mb-0"><?= __('edit') ?> <?= __('service') ?></h5>
                                    <div class="x-small fw-bold opacity-50 text-uppercase tracking-widest"><?= __('update_amenity_details') ?></div>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4 pt-5">
                            <input type="hidden" name="id" value="<?= $srv['id'] ?>">
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('service_name') ?> *</label>
                                <div class="input-wrapper">
                                    <i class="bi bi-tag-fill icon"></i>
                                    <input type="text" name="name" value="<?= htmlspecialchars($srv['name']) ?>" required placeholder="e.g. Airport Shuttle">
                                </div>
                            </div>
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('unit_price') ?> ($) *</label>
                                <div class="input-wrapper">
                                    <i class="bi bi-currency-dollar icon"></i>
                                    <input type="number" step="0.01" min="0" name="price" value="<?= $srv['price'] ?>" required placeholder="0.00">
                                </div>
                            </div>
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('description') ?></label>
                                <div class="input-wrapper align-items-start py-2">
                                    <i class="bi bi-card-text icon pt-1"></i>
                                    <textarea name="description" rows="3" placeholder="Details about this service"><?= htmlspecialchars($srv['description']) ?></textarea>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="luxury-label"><?= __('service_image') ?></label>
                                <div class="image-upload-preview d-flex align-items-center gap-3 mt-2">
                                    <div class="preview-box">
                                        <?php if (!empty($srv['image'])): ?>
                                            <img src="<?= BASE_URL ?>/uploads/services/<?= htmlspecialchars($srv['image']) ?>" class="preview-img">
                                        <?php else: ?>
                                            <div class="placeholder-box"><i class="bi bi-image"></i></div>
                                        <?php endif; ?>
                                    </div>
                                    <input type="file" class="form-control luxury-file-input" name="image" accept="image/*" onchange="previewImage(this)">
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

<!-- Add Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 luxury-modal rounded-5 overflow-hidden shadow-lg">
            <form action="<?= BASE_URL ?>/services/store" method="POST" enctype="multipart/form-data" class="ajax-form">
                <div class="modal-header bg-dark text-white border-0 p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div>
                            <h5 class="modal-title fw-extrabold mb-0"><?= __('add_new') ?> <?= __('service') ?></h5>
                            <div class="x-small fw-bold opacity-50 text-uppercase tracking-widest"><?= __('add_amenity') ?></div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 pt-5">
                    <div class="luxury-input-group">
                        <label class="luxury-label"><?= __('service_name') ?> *</label>
                        <div class="input-wrapper">
                            <i class="bi bi-tag-fill icon"></i>
                            <input type="text" name="name" required placeholder="e.g. In-Room Spa">
                        </div>
                    </div>
                    <div class="luxury-input-group">
                        <label class="luxury-label"><?= __('unit_price') ?> ($) *</label>
                        <div class="input-wrapper">
                            <i class="bi bi-currency-dollar icon"></i>
                            <input type="number" step="0.01" min="0" name="price" required placeholder="0.00">
                        </div>
                    </div>
                    <div class="luxury-input-group">
                        <label class="luxury-label"><?= __('description') ?></label>
                        <div class="input-wrapper align-items-start py-2">
                            <i class="bi bi-card-text icon pt-1"></i>
                            <textarea name="description" rows="3" placeholder="Provide details about the service highlights"></textarea>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="luxury-label"><?= __('service_image') ?></label>
                        <div class="image-upload-preview d-flex align-items-center gap-3 mt-2">
                            <div class="preview-box">
                                <div class="placeholder-box"><i class="bi bi-upload"></i></div>
                            </div>
                            <input type="file" class="form-control luxury-file-input" name="image" accept="image/*" onchange="previewImage(this)">
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
/* LUXURY SERVICES REGISTRY STYLES */
.fw-extrabold { font-weight: 800; }
.x-small { font-size: 0.7rem; }
.tracking-widest { letter-spacing: 0.15em; }

.service-thumb-container {
    width: 60px;
    height: 60px;
    border-radius: 14px;
    overflow: hidden;
    border: 2px solid white;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}
.service-thumb { width:100%; height:100%; object-fit:cover; }
.service-thumb-placeholder { background:#f8fafc; height:100%; display:flex; align-items:center; justify-content:center; color:#cbd5e1; font-size:1.5rem; }

.premium-card { background: white; border-radius: 24px; box-shadow: 0 10px 40px -10px rgba(0,0,0,0.04); overflow: hidden; }
.luxury-table thead th { font-size: 0.65rem; letter-spacing: 0.1em; color: #64748b; }
.service-luxury-row { transition: all 0.2s; border-bottom: 1px solid #f8fafc; }
.service-luxury-row:hover { background: #f8fafc; }

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
.input-wrapper input, .input-wrapper textarea, .input-wrapper select {
    border: none; background: transparent; padding: 12px 0;
    flex: 1; width: 0; min-width: 0;
    font-weight: 600; color: #1e293b; outline: none;
    -webkit-appearance: none; -moz-appearance: none; appearance: none;
}
.input-wrapper input::placeholder { color: #cbd5e1; font-weight: 500; }

.preview-box { width: 64px; height: 64px; border-radius: 12px; background: #f1f5f9; overflow: hidden; border: 2px dashed #e2e8f0; }
.preview-img { width: 100%; height: 100%; object-fit: cover; }
.placeholder-box { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #cbd5e1; font-size: 1.25rem; }

.luxury-file-input { border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 10px; font-size: 0.8rem; }

.btn-luxury-secondary { background: #f1f5f9; color: #64748b; border: none; padding: 12px; border-radius: 14px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.75rem; }
.btn-primary { border-radius: 14px; padding: 12px; border: none; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; }
</style>

<script>
function previewImage(input) {
    const previewBox = input.previousElementSibling;
    previewBox.innerHTML = '';
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'preview-img';
            previewBox.appendChild(img);
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        previewBox.innerHTML = '<div class="placeholder-box"><i class="bi bi-upload"></i></div>';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    if (typeof initTableSearch === 'function') {
        initTableSearch('#serviceSearchInput', '#serviceTable');
    }
});
</script>