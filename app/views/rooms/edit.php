<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 fw-bold"><?= __('edit_room') ?> #<?= htmlspecialchars($room['room_number']) ?></h2>
    <a href="<?= BASE_URL ?>/rooms" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> <?= __('back_to_rooms') ?>
    </a>
</div>

<div class="row">
    <div class="col-lg-8 col-xl-6">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4 p-md-5">
                <form action="<?= BASE_URL ?>/rooms/update" method="POST" enctype="multipart/form-data" class="ajax-form">
                    <input type="hidden" name="id" value="<?= $room['id'] ?>">
                    
                    <div class="mb-4">
                        <label class="form-label text-muted fw-semibold"><?= __('room_number_name') ?></label>
                        <input type="text" class="form-control form-control-lg" name="room_number" value="<?= htmlspecialchars($room['room_number']) ?>" required>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <label class="form-label text-muted fw-semibold"><?= __('floor') ?></label>
                            <select name="floor_id" class="form-select form-select-lg" required>
                                <?php foreach ($floors as $floor): ?>
                                    <option value="<?= $floor['id'] ?>" <?= $floor['id'] == $room['floor_id'] ? 'selected' : '' ?>>
                                        <?= __('floor') ?> <?= htmlspecialchars($floor['floor_number']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold"><?= __('room_type') ?></label>
                            <select name="room_type_id" class="form-select form-select-lg" required>
                                <?php foreach ($roomTypes as $type): ?>
                                    <option value="<?= $type['id'] ?>" <?= $type['id'] == $room['room_type_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($type['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-5">
                        <label class="form-label text-muted fw-semibold d-block mt-4 pt-3 border-top"><?= __('current_status') ?></label>
                        <div class="status-selector-group">
                            <input type="radio" class="btn-check" name="status" id="status_avail" value="available" <?= $room['status'] == 'available' ? 'checked' : '' ?>>
                            <label class="btn btn-outline-success status-btn" for="status_avail">
                                <i class="bi bi-check-circle me-1"></i> <?= __('available') ?>
                            </label>

                            <input type="radio" class="btn-check" name="status" id="status_booked" value="booked" <?= $room['status'] == 'booked' ? 'checked' : '' ?>>
                            <label class="btn btn-outline-danger status-btn" for="status_booked">
                                <i class="bi bi-calendar-event me-1"></i> <?= __('booked') ?>
                            </label>

                            <input type="radio" class="btn-check" name="status" id="status_occ" value="occupied" <?= $room['status'] == 'occupied' ? 'checked' : '' ?>>
                            <label class="btn btn-outline-primary status-btn" for="status_occ">
                                <i class="bi bi-person-fill me-1"></i> <?= __('occupied') ?>
                            </label>

                            <input type="radio" class="btn-check" name="status" id="status_clean" value="cleaning" <?= $room['status'] == 'cleaning' ? 'checked' : '' ?>>
                            <label class="btn btn-outline-warning status-btn" for="status_clean">
                                <i class="bi bi-stars me-1"></i> <?= __('cleaning') ?>
                            </label>

                            <input type="radio" class="btn-check" name="status" id="status_maint" value="maintenance" <?= $room['status'] == 'maintenance' ? 'checked' : '' ?>>
                            <label class="btn btn-outline-secondary status-btn" for="status_maint">
                                <i class="bi bi-tools me-1"></i> <?= __('maintenance') ?>
                            </label>
                        </div>
                    </div>

                    <?php if (!empty($room['current_guest'])): ?>
                        <div class="alert alert-primary bg-primary bg-opacity-10 border-0 rounded-4 p-4 mb-5 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="bi bi-person-circle fs-3"></i>
                                </div>
                                <div>
                                     <small class="text-uppercase fw-bold text-muted mb-1 d-block" style="font-size: 0.65rem; letter-spacing: 1px;"><?= __('current_reservation') ?></small>
                                    <div class="fw-bold text-primary fs-5"><?= htmlspecialchars($room['current_guest']) ?></div>
                                    <div class="small text-muted text-uppercase fw-semibold" style="font-size: 0.7rem;"><?= __('status') ?>: <?= __($room['current_booking_status']) ?></div>
                                </div>
                            </div>
                            
                            <?php if ($room['current_booking_status'] != 'checked_in'): ?>
                                <a href="<?= BASE_URL ?>/bookings/check-in?id=<?= $room['current_booking_id'] ?>" class="btn btn-primary rounded-pill px-4 fw-bold ajax-action shadow-sm">
                                    <i class="bi bi-box-arrow-in-right me-2"></i><?= __('check_in') ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="mb-5">
                        <label class="form-label text-muted fw-semibold text-uppercase small"><?= __('update_image') ?></label>
                        <?php if (!empty($room['image'])): ?>
                            <div class="mb-3">
                                <img src="<?= BASE_URL ?>/uploads/rooms/<?= htmlspecialchars($room['image']) ?>" class="img-thumbnail" style="width: 200px; height: 150px; object-fit: cover;">
                            </div>
                        <?php endif; ?>
                        <input type="file" class="form-control" name="image" accept="image/*" onchange="previewRoomImage(this)">
                        <div id="imagePreview" class="mt-3"></div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold"><?= __('update_room') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
.status-selector-group {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}
.status-btn {
    border-radius: 12px !important;
    padding: 10px 18px !important;
    font-weight: 700 !important;
    text-transform: uppercase;
    font-size: 0.75rem !important;
    letter-spacing: 0.5px;
    border-width: 2px !important;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}
.btn-check:checked + .btn-outline-success { background-color: #198754 !important; color: white !important; border-color: #198754 !important; transform: translateY(-3px); box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3); }
.btn-check:checked + .btn-outline-danger { background-color: #dc3545 !important; color: white !important; border-color: #dc3545 !important; transform: translateY(-3px); box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3); }
.btn-check:checked + .btn-outline-primary { background-color: #0d6efd !important; color: white !important; border-color: #0d6efd !important; transform: translateY(-3px); box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3); }
.btn-check:checked + .btn-outline-warning { background-color: #ffc107 !important; color: #000 !important; border-color: #ffc107 !important; transform: translateY(-3px); box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3); }
.btn-check:checked + .btn-outline-secondary { background-color: #6c757d !important; color: white !important; border-color: #6c757d !important; transform: translateY(-3px); box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3); }

</style>

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
