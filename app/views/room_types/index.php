<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="mb-1 fw-bold text-dark"><?= __('manage_room_types') ?></h2>
        <p class="text-muted small mb-0">Define room categories, pricing, and amenities for a bespoke stay.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap align-items-center">
        <div class="input-group shadow-sm" style="min-width: 250px;">
            <span class="input-group-text bg-white border-end-0 text-muted">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" id="roomTypeSearchInput" class="form-control border-start-0 ps-0" placeholder="<?= __('search') ?> <?= __('room_types') ?>...">
        </div>
        <button class="btn btn-primary shadow-sm px-4 py-2 d-flex align-items-center gap-2 rounded-3 text-nowrap" data-bs-toggle="modal" data-bs-target="#addRoomTypeModal">
            <i class="bi bi-plus-lg fs-5"></i>
            <span class="fw-bold"><?= __('add_new') ?></span>
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle" id="roomTypeTable">
                <thead class="bg-light bg-gradient border-bottom">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-muted"><?= __('image') ?></th>
                        <th class="py-3 text-uppercase small fw-bold text-muted"><?= __('type_name') ?></th>
                        <th class="py-3 text-uppercase small fw-bold text-muted"><?= __('capacity') ?></th>
                        <th class="py-3 text-uppercase small fw-bold text-muted"><?= __('description') ?></th>
                        <th class="py-3 text-uppercase small fw-bold text-muted"><?= __('base_price') ?></th>
                        <th class="text-end pe-4 py-3 text-uppercase small fw-bold text-muted"><?= __('actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($types)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <div class="py-5">
                                <i class="bi bi-images display-1 text-light opacity-50 mb-3 d-block"></i>
                                <h5 class="fw-bold mb-1"><?= __('no_results') ?></h5>
                                <p class="small text-muted mb-0">No room categories defined yet.</p>
                            </div>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($types as $type): ?>
                        <tr class="type-row" id="row-<?= $type['id'] ?>">
                            <td class="ps-4">
                                <div class="d-flex flex-wrap gap-2 py-1">
                                    <?php if (!empty($type['image'])): ?>
                                        <div class="position-relative">
                                            <img src="<?= BASE_URL ?>/uploads/room_types/<?= htmlspecialchars($type['image']) ?>" alt="<?= htmlspecialchars($type['name']) ?>" class="rounded-3 shadow-sm border" style="width: 50px; height: 50px; object-fit: cover;" title="<?= __('cover_image') ?>">
                                        </div>
                                    <?php endif; ?>
                                    <?php if (empty($type['image']) && empty($type['gallery'])): ?>
                                        <div class="bg-light text-muted d-flex align-items-center justify-content-center rounded-3 border" style="width: 50px; height: 50px; border: 1px dashed #ccc;">
                                            <i class="bi bi-image text-muted opacity-25"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="fw-bold text-dark fs-6"><?= htmlspecialchars($type['name']) ?></div>
                                <div class="small text-muted">Category #<?= $type['id'] ?></div>
                            </td>
                            <td class="py-3">
                                <div class="d-flex align-items-center gap-1 text-primary fw-bold">
                                    <i class="bi bi-people-fill"></i>
                                    <span><?= htmlspecialchars($type['capacity'] ?? 2) ?></span>
                                </div>
                            </td>
                            <td class="py-3 text-muted">
                                <div class="text-truncate" style="max-width: 300px;"><?= htmlspecialchars($type['description'] ?? 'N/A') ?></div>
                            </td>
                            <td class="py-3 text-success fw-bold fs-5">$<?= number_format($type['price'], 2) ?></td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <button class="btn btn-icon btn-light border shadow-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#editRoomTypeModal<?= $type['id'] ?>" title="<?= __('edit') ?>">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </button>
                                    <a href="<?= BASE_URL ?>/room-types/delete?id=<?= $type['id'] ?>" class="btn btn-icon btn-light border shadow-sm rounded-circle ajax-delete" data-row-id="row-<?= $type['id'] ?>" title="<?= __('delete') ?>">
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
    background-color: #f8f9fa;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
}
.type-row {
    transition: all 0.2s ease;
    border-left: 4px solid transparent;
}
.type-row:hover {
    background-color: rgba(0, 123, 255, 0.02) !important;
    border-left-color: #0d6efd;
}
</style>

<?php if (!empty($types)): ?>
    <?php foreach ($types as $type): ?>
        <!-- Edit Room Type Modal -->
        <div class="modal fade" id="editRoomTypeModal<?= $type['id'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <form action="<?= BASE_URL ?>/room-types/update" method="POST" enctype="multipart/form-data" class="ajax-form">
                        <div class="modal-header">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-white bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                    <i class="bi bi-pencil-square fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="modal-title mb-0"><?= __('edit_room_type') ?></h5>
                                    <div class="small text-white-50">Adjust pricing and features</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <input type="hidden" name="id" value="<?= $type['id'] ?>">
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('type_name') ?> *</label>
                                <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-tag text-primary"></i></span>
                                    <input type="text" class="form-control border-0 py-2" name="name" value="<?= htmlspecialchars($type['name']) ?>" required placeholder="Room Type Name">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('capacity') ?> (<?= __('person') ?>) *</label>
                                <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-people text-primary"></i></span>
                                    <input type="number" min="1" class="form-control border-0 py-2" name="capacity" value="<?= htmlspecialchars($type['capacity'] ?? 2) ?>" required placeholder="2">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('base_price') ?> ($) *</label>
                                <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-currency-dollar text-primary"></i></span>
                                    <input type="number" step="0.01" min="0" class="form-control border-0 py-2" name="price" value="<?= htmlspecialchars($type['price']) ?>" required placeholder="0.00">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('current_images') ?></label>
                                <div class="d-flex flex-wrap gap-2 mb-2 p-2 border rounded bg-light">
                                    <?php if (!empty($type['image'])): ?>
                                        <div class="position-relative" id="primary-img-<?= $type['id'] ?>">
                                            <span class="badge bg-primary position-absolute top-0 start-0" style="z-index:10; font-size:0.6rem;"><?= __('cover') ?></span>
                                            <img src="<?= BASE_URL ?>/uploads/room_types/<?= htmlspecialchars($type['image']) ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                            <a href="<?= BASE_URL ?>/room-types/deletePrimaryImage?id=<?= $type['id'] ?>" class="btn btn-sm btn-danger position-absolute top-0 end-0 translate-middle rounded-circle ajax-delete" style="width:20px; height:20px; padding:0; line-height:18px; font-size:10px;" data-row-id="primary-img-<?= $type['id'] ?>"><i class="bi bi-x"></i></a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($type['gallery'])): ?>
                                        <?php foreach ($type['gallery'] as $gImg): ?>
                                            <div class="position-relative" id="gal-img-<?= $gImg['id'] ?>">
                                                <img src="<?= BASE_URL ?>/uploads/room_types/<?= htmlspecialchars($gImg['image']) ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                <a href="<?= BASE_URL ?>/room-types/deleteGalleryImage?id=<?= $gImg['id'] ?>" class="btn btn-sm btn-danger position-absolute top-0 end-0 translate-middle rounded-circle ajax-delete" style="width:20px; height:20px; padding:0; line-height:18px; font-size:10px;" data-row-id="gal-img-<?= $gImg['id'] ?>"><i class="bi bi-x"></i></a>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php if(empty($type['image']) && empty($type['gallery'])): ?>
                                        <span class="text-muted small"><?= __('no_results') ?></span>
                                    <?php endif; ?>
                                </div>
                                <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('upload_new_images') ?></label>
                                <input type="file" class="form-control shadow-sm" name="images[]" accept="image/*" multiple onchange="previewImages(this)">
                                <div class="form-text small opacity-75"><?= __('gallery_info') ?></div>
                                <div class="preview-container d-flex flex-wrap gap-2 mt-2"></div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('description') ?></label>
                                <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-0 align-items-start pt-2"><i class="bi bi-card-text text-primary"></i></span>
                                    <textarea class="form-control border-0 py-2" name="description" rows="3" placeholder="Amenities, features..."><?= htmlspecialchars($type['description']) ?></textarea>
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

<!-- Add Room Type Modal -->
<div class="modal fade" id="addRoomTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form action="<?= BASE_URL ?>/room-types/store" method="POST" enctype="multipart/form-data" class="ajax-form">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="bi bi-plus-lg fs-4"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0"><?= __('add_new') ?> <?= __('room_type') ?></h5>
                            <div class="small text-white-50">Define a new category</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('type_name') ?> *</label>
                        <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-tag text-primary"></i></span>
                            <input type="text" class="form-control border-0 py-2" name="name" required placeholder="Room Type Name">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('capacity') ?> (<?= __('person') ?>) *</label>
                        <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-people text-primary"></i></span>
                            <input type="number" min="1" class="form-control border-0 py-2" name="capacity" value="2" required placeholder="2">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('base_price') ?> ($) *</label>
                        <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-currency-dollar text-primary"></i></span>
                            <input type="number" step="0.01" min="0" class="form-control border-0 py-2" name="price" required placeholder="0.00">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('room_images') ?></label>
                        <input type="file" class="form-control shadow-sm" name="images[]" accept="image/*" multiple onchange="previewImages(this)">
                        <div class="form-text small opacity-75"><?= __('cover_info') ?></div>
                        <div class="preview-container d-flex flex-wrap gap-2 mt-2"></div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-uppercase tracking-wider text-muted"><?= __('description') ?></label>
                        <div class="input-group shadow-sm border rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0 align-items-start pt-2"><i class="bi bi-card-text text-primary"></i></span>
                            <textarea class="form-control border-0 py-2" name="description" rows="3" placeholder="Amenities, bed size..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3">
                    <button type="button" class="btn btn-link text-muted text-decoration-none px-4" data-bs-dismiss="modal"><?= __('cancel') ?></button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm fw-bold rounded-3">
                        <i class="bi bi-plus-lg me-1"></i> <?= __('create_type') ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImages(input) {
    const container = input.nextElementSibling.nextElementSibling; // the .preview-container
    if (!container) return;
    container.innerHTML = '';
    if (input.files) {
        Array.from(input.files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail';
                    img.style = 'width: 60px; height: 60px; object-fit: cover;';
                    container.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    if (typeof initTableSearch === 'function') {
        initTableSearch('#roomTypeSearchInput', '#roomTypeTable');
    }
});
</script>
