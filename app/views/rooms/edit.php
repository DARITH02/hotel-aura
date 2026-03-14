<div class="animate__animated animate__fadeIn px-lg-4">
    <!-- Header Strategy -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-4">
        <div>
            <h2 class="mb-1 fw-extrabold text-dark d-flex align-items-center gap-3">
                <?= __('edit_room') ?> #<?= htmlspecialchars($room['room_number']) ?>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1 rounded-pill small" style="font-size: 0.8rem;">
                    <?= strtoupper(__('update')) ?>
                </span>
            </h2>
            <p class="text-muted small mb-0 fw-medium"><?= __('update_room_desc') ?></p>
        </div>
        
        <a href="<?= BASE_URL ?>/rooms" class="btn btn-luxury-secondary shadow-sm px-4 py-2 d-flex align-items-center gap-2 rounded-pill fw-bold h-48">
            <i class="bi bi-arrow-left fs-5"></i>
            <span><?= __('back_to_rooms') ?></span>
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8 col-xl-7">
            <div class="premium-card p-4 p-md-5 animate__animated animate__fadeInUp">
                <form action="<?= BASE_URL ?>/rooms/update" method="POST" enctype="multipart/form-data" class="ajax-form">
                    <input type="hidden" name="id" value="<?= $room['id'] ?>">
                    
                    <div class="luxury-input-group mb-4">
                        <label class="luxury-label"><?= __('room_number_name') ?> *</label>
                        <div class="input-wrapper">
                            <i class="bi bi-door-open icon"></i>
                            <input type="text" name="room_number" value="<?= htmlspecialchars($room['room_number']) ?>" required>
                        </div>
                    </div>
                    
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('floor') ?> *</label>
                                <div class="input-wrapper">
                                    <i class="bi bi-layers-half icon"></i>
                                    <select name="floor_id" class="luxury-select" required>
                                        <?php foreach ($floors as $floor): ?>
                                            <option value="<?= $floor['id'] ?>" <?= $floor['id'] == $room['floor_id'] ? 'selected' : '' ?>>
                                                <?= __('floor') ?> <?= htmlspecialchars($floor['floor_number']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('room_category') ?> *</label>
                                <div class="input-wrapper">
                                    <i class="bi bi-tag-fill icon"></i>
                                    <select name="room_type_id" class="luxury-select" required>
                                        <?php foreach ($roomTypes as $type): ?>
                                            <option value="<?= $type['id'] ?>" <?= $type['id'] == $room['room_type_id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($type['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-5 py-4 border-top">
                        <label class="luxury-label mb-3"><?= __('current_status') ?></label>
                        <div class="status-selector-group">
                            <input type="radio" class="btn-check" name="status" id="status_avail" value="available" <?= $room['status'] == 'available' ? 'checked' : '' ?>>
                            <label class="btn btn-outline-success status-btn shadow-xs" for="status_avail">
                                <i class="bi bi-check-circle me-1"></i> <?= __('available') ?>
                            </label>

                            <input type="radio" class="btn-check" name="status" id="status_booked" value="booked" <?= $room['status'] == 'booked' ? 'checked' : '' ?>>
                            <label class="btn btn-outline-danger status-btn shadow-xs" for="status_booked">
                                <i class="bi bi-calendar-event me-1"></i> <?= __('booked') ?>
                            </label>

                            <input type="radio" class="btn-check" name="status" id="status_occ" value="occupied" <?= $room['status'] == 'occupied' ? 'checked' : '' ?>>
                            <label class="btn btn-outline-primary status-btn shadow-xs" for="status_occ">
                                <i class="bi bi-person-fill me-1"></i> <?= __('occupied') ?>
                            </label>

                            <input type="radio" class="btn-check" name="status" id="status_clean" value="cleaning" <?= $room['status'] == 'cleaning' ? 'checked' : '' ?>>
                            <label class="btn btn-outline-warning status-btn shadow-xs" for="status_clean">
                                <i class="bi bi-stars me-1"></i> <?= __('cleaning') ?>
                            </label>

                            <input type="radio" class="btn-check" name="status" id="status_maint" value="maintenance" <?= $room['status'] == 'maintenance' ? 'checked' : '' ?>>
                            <label class="btn btn-outline-secondary status-btn shadow-xs" for="status_maint">
                                <i class="bi bi-tools me-1"></i> <?= __('maintenance') ?>
                            </label>
                        </div>
                    </div>

                    <?php if (!empty($room['current_guest'])): ?>
                        <div class="alert alert-primary bg-primary bg-opacity-10 border-0 rounded-5 p-4 mb-5 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-4 d-flex align-items-center justify-content-center me-3" style="width: 52px; height: 52px;">
                                    <i class="bi bi-person-circle fs-3"></i>
                                </div>
                                <div>
                                     <small class="x-small fw-extrabold text-muted text-uppercase tracking-widest mb-1 d-block"><?= __('current_reservation') ?></small>
                                    <div class="fw-extrabold text-primary fs-5"><?= htmlspecialchars($room['current_guest']) ?></div>
                                    <div class="x-small text-muted text-uppercase fw-extrabold tracking-wider"><?= __('status') ?>: <span class="text-primary"><?= str_replace('_', ' ', strtoupper(__($room['current_booking_status']))) ?></span></div>
                                </div>
                            </div>
                            
                            <?php if ($room['current_booking_status'] != 'checked_in'): ?>
                                <a href="<?= BASE_URL ?>/bookings/check-in?id=<?= $room['current_booking_id'] ?>" class="btn btn-primary rounded-pill px-4 fw-extrabold ajax-action shadow-primary py-2 text-uppercase x-small">
                                    <i class="bi bi-person-check-fill me-2"></i><?= __('check_in') ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="luxury-input-group mb-5">
                        <label class="luxury-label"><?= __('update_image') ?></label>
                        <?php if (!empty($room['image'])): ?>
                            <div class="mb-4">
                                <img src="<?= BASE_URL ?>/uploads/rooms/<?= htmlspecialchars($room['image']) ?>" class="preview-thumb border-primary border-opacity-25" style="border-width: 2px;">
                            </div>
                        <?php endif; ?>
                        <input type="file" class="form-control luxury-file-input" name="image" accept="image/*" onchange="previewRoomImage(this)">
                        <div id="imagePreview" class="mt-4"></div>
                    </div>
                    
                    <div class="pt-4 border-top">
                        <button type="submit" class="btn btn-primary btn-lg w-100 shadow-primary fw-extrabold rounded-pill py-3">
                            <i class="bi bi-check2-circle me-2"></i><?= strtoupper(__('update_room')) ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="premium-card p-4 mb-4 bg-light border-0 animate__animated animate__fadeInRight">
                <h6 class="fw-extrabold text-uppercase x-small tracking-widest text-muted mb-4"><?= __('room_summary') ?></h6>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="icon-box-sm bg-white rounded-3 shadow-xs"><i class="bi bi-door-closed text-primary"></i></div>
                    <div>
                        <div class="x-small fw-extrabold text-muted text-uppercase"><?= __('room_number') ?></div>
                        <div class="fw-bold text-dark"><?= $room['room_number'] ?></div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="icon-box-sm bg-white rounded-3 shadow-xs"><i class="bi bi-layers text-primary"></i></div>
                    <div>
                        <div class="x-small fw-extrabold text-muted text-uppercase"><?= __('floor') ?></div>
                        <div class="fw-bold text-dark"><?= $room['floor_number'] ?></div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box-sm bg-white rounded-3 shadow-xs"><i class="bi bi-tag text-primary"></i></div>
                    <div>
                        <div class="x-small fw-extrabold text-muted text-uppercase"><?= __('type') ?></div>
                        <div class="fw-bold text-dark"><?= $room['type_name'] ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* LUXURY FORM STYLES */
.fw-extrabold { font-weight: 800; }
.x-small { font-size: 0.7rem; }
.tracking-widest { letter-spacing: 0.15em; }

.premium-card { background: white; border-radius: 32px; box-shadow: 0 20px 60px -10px rgba(0,0,0,0.06); }
.shadow-primary { box-shadow: 0 10px 25px -5px rgba(31, 41, 55, 0.2); }
.shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.02); }

.luxury-input-group { position: relative; }
.luxury-label { font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.1em; display: block; }

.input-wrapper {
    display: flex; align-items: center; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 0 20px; transition: all 0.3s;
}
.input-wrapper:focus-within { border-color: #1e293b; background: white; box-shadow: 0 15px 30px -10px rgba(0,0,0,0.05); }

.input-wrapper .icon { color: #94a3b8; font-size: 1.2rem; margin-right: 15px; }
.input-wrapper input, .input-wrapper .luxury-select {
    border: none; background: transparent; padding: 15px 0; width: 100%; font-weight: 600; color: #1e293b; outline: none;
}
.luxury-select { cursor: pointer; }

.luxury-file-input { border-radius: 18px; border: 1.5px solid #e2e8f0; padding: 12px; font-size: 0.85rem; font-weight: 600; }

.status-selector-group { display: flex; flex-wrap: wrap; gap: 12px; }
.status-btn { 
    border-radius: 14px !important; padding: 10px 18px !important; font-weight: 800 !important; 
    text-transform: uppercase; font-size: 0.7rem !important; letter-spacing: 0.05em; border-width: 2px !important; transition: all 0.2s;
}

.icon-box-sm { width: 38px; height: 38px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
.btn-luxury-secondary { background: #f1f5f9; color: #64748b; border: none; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.75rem; }
.btn-primary { background: #1e293b !important; border: none; color: white !important; }
.btn-primary:hover { transform: translateY(-3px); box-shadow: 0 15px 35px -10px rgba(0,0,0,0.2) !important; }

.preview-thumb { width: 220px; height: 160px; object-fit: cover; border-radius: 20px; border: 4px solid white; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
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
            img.className = 'preview-thumb animate__animated animate__zoomIn';
            container.appendChild(img);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
