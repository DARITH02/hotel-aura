<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 fw-bold"><?= __('add_new_room') ?></h2>
    <a href="<?= BASE_URL ?>/rooms" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> <?= __('back_to_rooms') ?>
    </a>
</div>

<div class="row">
    <div class="col-lg-8 col-xl-6">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4 p-md-5">
                <form action="<?= BASE_URL ?>/rooms/store" method="POST" enctype="multipart/form-data" class="ajax-form">
                    <div class="mb-4">
                        <label class="form-label text-muted fw-semibold"><?= __('room_number_name') ?></label>
                        <input type="text" class="form-control form-control-lg" name="room_number" required placeholder="e.g. 101 or Presidential Suite">
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <label class="form-label text-muted fw-semibold"><?= __('floor') ?></label>
                            <select name="floor_id" class="form-select form-select-lg" required>
                                <option value="" selected disabled><?= __('select_floor') ?></option>
                                <?php foreach ($floors as $floor): ?>
                                    <option value="<?= $floor['id'] ?>"><?= __('floor') ?> <?= htmlspecialchars($floor['floor_number']) ?> 
                                    (<?= htmlspecialchars($floor['description'] ?? 'No text') ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold"><?= __('room_type') ?></label>
                            <select name="room_type_id" class="form-select form-select-lg" required>
                                <option value="" selected disabled><?= __('select_type') ?></option>
                                <?php foreach ($roomTypes as $type): ?>
                                    <option value="<?= $type['id'] ?>"><?= htmlspecialchars($type['name']) ?> 
                                    ($<?= number_format($type['price'], 2) ?>/<?= __('night') ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-5">
                        <label class="form-label text-muted fw-semibold d-block"><?= __('initial_status') ?></label>
                        <div class="d-flex gap-3 flex-wrap">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status1" value="available" checked>
                                <label class="form-check-label badge bg-success text-white px-3 py-2" for="status1"><?= __('available') ?></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status2" value="maintenance">
                                <label class="form-check-label badge bg-secondary text-white px-3 py-2" for="status2"><?= __('maintenance') ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="form-label text-muted fw-semibold text-uppercase small">Room Cover Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*" onchange="previewRoomImage(this)">
                        <div id="imagePreview" class="mt-3"></div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold"><?= __('save_room') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
function previewRoomImage(input) {
    const container = document.getElementById('imagePreview');
    container.innerHTML = '';
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-thumbnail';
            img.style = 'width: 200px; height: 150px; object-fit: cover;';
            container.appendChild(img);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
