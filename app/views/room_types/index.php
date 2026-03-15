<div class="animate__animated animate__fadeIn px-lg-4">
    <!-- Luxury Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-4">
        <div>
            <h2 class="mb-1 fw-extrabold text-dark d-flex align-items-center gap-3">
                <?= __('manage_room_types') ?>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1 rounded-pill small" style="font-size: 0.8rem;">
                    <?= count($types) ?> <?= strtoupper(__('categories')) ?>
                </span>
            </h2>
            <p class="text-muted small mb-0 fw-medium"><?= __('manage_room_types_desc') ?></p>
        </div>
        
        <div class="d-flex gap-3 flex-wrap align-items-center">
            <div class="premium-search-box shadow-sm border rounded-pill overflow-hidden bg-white d-flex align-items-center px-3" style="min-width: 300px; height: 48px;">
                <i class="bi bi-search text-primary opacity-50 me-2"></i>
                <input type="text" id="roomTypeSearchInput" class="form-control border-0 shadow-none bg-transparent ps-0" placeholder="<?= __('search') ?> <?= __('room_types') ?>...">
            </div>
            <button class="btn btn-primary shadow-primary px-4 py-2 d-flex align-items-center gap-2 rounded-pill fw-bold h-48" data-bs-toggle="modal" data-bs-target="#addRoomTypeModal">
                <i class="bi bi-plus-lg fs-5"></i>
                <span><?= __('add_new') ?></span>
            </button>
        </div>
    </div>

    <!-- Room Categories Table -->
    <div class="premium-card mb-5 animate__animated animate__fadeInUp">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle luxury-table" id="roomTypeTable">
                <thead>
                    <tr class="text-muted x-small text-uppercase tracking-widest bg-light bg-opacity-50">
                        <th class="ps-4 py-4 fw-extrabold border-0"><?= __('image') ?></th>
                        <th class="py-4 fw-extrabold border-0"><?= __('type_name') ?></th>
                        <th class="py-4 fw-extrabold border-0"><?= __('capacity') ?></th>
                        <th class="py-4 fw-extrabold border-0"><?= __('description') ?></th>
                        <th class="py-4 fw-extrabold border-0"><?= __('base_price') ?></th>
                        <th class="text-end pe-4 py-4 fw-extrabold border-0"><?= __('actions') ?></th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if (empty($types)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-5 opacity-50">
                                    <i class="bi bi-collection-play-fill display-1 text-muted mb-3 d-block"></i>
                                    <h5 class="fw-bold text-muted"><?= __('no_results') ?></h5>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($types as $type): ?>
                            <tr class="type-luxury-row" id="row-<?= $type['id'] ?>">
                                <td class="ps-4 py-4">
                                    <div class="type-thumb-container">
                                        <?php if (!empty($type['image'])): ?>
                                            <img src="<?= BASE_URL ?>/uploads/room_types/<?= htmlspecialchars($type['image']) ?>" alt="" class="type-thumb">
                                        <?php else: ?>
                                            <div class="type-thumb-placeholder">
                                                <i class="bi bi-images"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <div class="fw-extrabold text-dark"><?= htmlspecialchars($type['name']) ?></div>
                                    <div class="x-small text-muted fw-bold text-uppercase tracking-widest opacity-50">CAT ID: #<?= str_pad($type['id'], 3, '0', STR_PAD_LEFT) ?></div>
                                </td>
                                <td class="py-4">
                                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-primary bg-opacity-10 text-primary rounded-pill x-small fw-extrabold">
                                        <i class="bi bi-people-fill"></i>
                                        <span><?= htmlspecialchars($type['capacity'] ?? 2) ?> <?= strtoupper(__('person')) ?></span>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <div class="text-muted small text-truncate" style="max-width: 250px;" title="<?= htmlspecialchars($type['description']) ?>">
                                        <?= htmlspecialchars($type['description'] ?: 'N/A') ?>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <div class="fw-extrabold text-dark fs-5">$<?= number_format($type['price'], 2) ?></div>
                                </td>
                                <td class="text-end pe-4 py-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-luxury-action" data-bs-toggle="modal" data-bs-target="#editRoomTypeModal<?= $type['id'] ?>" title="<?= __('edit') ?>">
                                            <i class="bi bi-pencil-square text-primary"></i>
                                        </button>
                                        <?php if (($_SESSION['admin_role'] ?? '') === 'super_admin'): ?>
                                        <a href="<?= BASE_URL ?>/room-types/delete?id=<?= $type['id'] ?>" class="btn btn-luxury-action ajax-delete" data-row-id="row-<?= $type['id'] ?>" title="<?= __('delete') ?>">
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
<?php if (!empty($types)): ?>
    <?php foreach ($types as $type): ?>
        <div class="modal fade" id="editRoomTypeModal<?= $type['id'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 luxury-modal rounded-5 overflow-hidden shadow-lg">
                    <form action="<?= BASE_URL ?>/room-types/update" method="POST" enctype="multipart/form-data" class="ajax-form">
                        <div class="modal-header bg-dark text-white border-0 p-4">
                            <div class="d-flex align-items-center gap-3">
                                <div>
                                    <h5 class="modal-title fw-extrabold mb-0"><?= __('edit_room_type') ?></h5>
                                    <div class="x-small fw-bold opacity-50 text-uppercase tracking-widest"><?= __('adjust_pricing_features') ?></div>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4 pt-5">
                            <input type="hidden" name="id" value="<?= $type['id'] ?>">
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('type_name') ?> *</label>
                                <div class="input-wrapper">
                                    <i class="bi bi-tag-fill icon"></i>
                                    <input type="text" name="name" value="<?= htmlspecialchars($type['name']) ?>" required>
                                </div>
                            </div>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="luxury-input-group">
                                        <label class="luxury-label"><?= __('capacity') ?> *</label>
                                        <div class="input-wrapper">
                                            <i class="bi bi-people-fill icon"></i>
                                            <input type="number" name="capacity" value="<?= $type['capacity'] ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="luxury-input-group">
                                        <label class="luxury-label"><?= __('base_price') ?> ($) *</label>
                                        <div class="input-wrapper">
                                            <i class="bi bi-currency-dollar icon"></i>
                                            <input type="number" step="0.01" name="price" value="<?= $type['price'] ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="luxury-label"><?= __('current_images') ?></label>
                                <div class="d-flex flex-wrap gap-2 p-2 border rounded-4 bg-light bg-opacity-50">
                                    <?php if (!empty($type['image'])): ?>
                                        <div class="position-relative" id="primary-img-<?= $type['id'] ?>">
                                            <img src="<?= BASE_URL ?>/uploads/room_types/<?= htmlspecialchars($type['image']) ?>" class="img-thumbnail rounded-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            <a href="<?= BASE_URL ?>/room-types/deletePrimaryImage?id=<?= $type['id'] ?>" class="btn-img-delete ajax-delete" data-row-id="primary-img-<?= $type['id'] ?>"><i class="bi bi-x"></i></a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($type['gallery'])): ?>
                                        <?php foreach ($type['gallery'] as $gImg): ?>
                                            <div class="position-relative" id="gal-img-<?= $gImg['id'] ?>">
                                                <img src="<?= BASE_URL ?>/uploads/room_types/<?= htmlspecialchars($gImg['image']) ?>" class="img-thumbnail rounded-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                <a href="<?= BASE_URL ?>/room-types/deleteGalleryImage?id=<?= $gImg['id'] ?>" class="btn-img-delete ajax-delete" data-row-id="gal-img-<?= $gImg['id'] ?>"><i class="bi bi-x"></i></a>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('upload_new_images') ?></label>
                                <input type="file" class="form-control luxury-file-input" name="images[]" multiple onchange="previewImages(this)">
                                <div class="preview-container d-flex flex-wrap gap-2 mt-2"></div>
                             </div>

                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('description') ?></label>
                                <div class="input-wrapper align-items-start py-2">
                                    <i class="bi bi-card-text icon pt-1"></i>
                                    <textarea name="description" rows="3"><?= htmlspecialchars($type['description']) ?></textarea>
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

<!-- Add Room Type Modal -->
<div class="modal fade" id="addRoomTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 luxury-modal rounded-5 overflow-hidden shadow-lg">
            <form action="<?= BASE_URL ?>/room-types/store" method="POST" enctype="multipart/form-data" class="ajax-form">
                <div class="modal-header bg-dark text-white border-0 p-4">
                        <div>
                            <h5 class="modal-title fw-extrabold mb-0"><?= __('add_new') ?> <?= __('room_type') ?></h5>
                            <div class="x-small fw-bold opacity-50 text-uppercase tracking-widest"><?= __('define_new_category') ?></div>
                        </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 pt-5">
                    <div class="luxury-input-group mb-4">
                        <label class="luxury-label"><?= __('category_name') ?> *</label>
                        <div class="input-wrapper">
                            <i class="bi bi-tag-fill icon"></i>
                            <input type="text" name="name" required placeholder="e.g. Royal Suite">
                        </div>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('max_capacity') ?> *</label>
                                <div class="input-wrapper">
                                    <i class="bi bi-people-fill icon"></i>
                                    <input type="number" name="capacity" value="2" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('base_price') ?> ($) *</label>
                                <div class="input-wrapper">
                                    <i class="bi bi-currency-dollar icon"></i>
                                    <input type="number" step="0.01" name="price" required placeholder="0.00">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="luxury-input-group mb-4">
                        <label class="luxury-label"><?= __('room_images') ?></label>
                        <input type="file" class="form-control luxury-file-input" name="images[]" multiple onchange="previewImages(this)">
                        <div class="preview-container d-flex flex-wrap gap-2 mt-2"></div>
                    </div>

                    <div class="luxury-input-group">
                        <label class="luxury-label"><?= __('description') ?></label>
                        <div class="input-wrapper align-items-start py-2">
                            <i class="bi bi-card-text icon pt-1"></i>
                            <textarea name="description" rows="3" placeholder="List luxury amenities and highlights..."></textarea>
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
/* LUXURY ROOM TYPES STYLES */
.fw-extrabold { font-weight: 800; }
.x-small { font-size: 0.7rem; }
.tracking-widest { letter-spacing: 0.15em; }

.type-thumb-container {
    width: 60px; height: 60px; border-radius: 14px; overflow: hidden; border: 2px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}
.type-thumb { width: 100%; height: 100%; object-fit: cover; }
.type-thumb-placeholder { background: #f8fafc; height: 100%; display: flex; align-items: center; justify-content: center; color: #cbd5e1; font-size: 1.5rem; }

.premium-card { background: white; border-radius: 24px; box-shadow: 0 10px 40px -10px rgba(0,0,0,0.04); overflow: hidden; }
.luxury-table thead th { font-size: 0.65rem; letter-spacing: 0.1em; color: #64748b; }
.type-luxury-row { transition: all 0.2s; border-bottom: 1px solid #f8fafc; }
.type-luxury-row:hover { background: #f8fafc; }

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
.input-wrapper input, .input-wrapper textarea {
    border: none; background: transparent; padding: 12px 0; width: 100%; font-weight: 600; color: #1e293b; outline: none;
}

.luxury-file-input { border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 10px; font-size: 0.8rem; }
.btn-img-delete { position: absolute; top: -5px; right: -5px; width: 20px; height: 20px; border-radius: 50%; background: #f43f5e; color: white; display: flex; align-items: center; justify-content: center; font-size: 12px; border: 2px solid white; transition: all 0.2s; }
.btn-img-delete:hover { transform: scale(1.2); background: #e11d48; }

.btn-luxury-secondary { background: #f1f5f9; color: #64748b; border: none; padding: 12px; border-radius: 14px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.75rem; }
.btn-primary { border-radius: 14px; padding: 12px; border: none; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; background: #1e293b !important; color: white !important; }
</style>

<script>
function previewImages(input) {
    const container = input.nextElementSibling;
    container.innerHTML = '';
    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail rounded-3';
                img.style = 'width: 50px; height: 50px; object-fit: cover;';
                container.appendChild(img);
            }
            reader.readAsDataURL(file);
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    if (typeof initTableSearch === 'function') {
        initTableSearch('#roomTypeSearchInput', '#roomTypeTable');
    }
});
</script>
