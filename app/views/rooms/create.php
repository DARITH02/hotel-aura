<div class="animate__animated animate__fadeIn px-lg-4">
    <!-- Header Strategy -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-4">
        <div>
            <h2 class="mb-1 fw-extrabold text-dark d-flex align-items-center gap-3">
                <?= __('add_new_room') ?>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1 rounded-pill small" style="font-size: 0.8rem;">
                    <?= strtoupper(__('new')) ?>
                </span>
            </h2>
            <p class="text-muted small mb-0 fw-medium"><?= __('create_room_desc') ?></p>
        </div>
        
        <a href="<?= BASE_URL ?>/rooms" class="btn btn-luxury-secondary shadow-sm px-4 py-2 d-flex align-items-center gap-2 rounded-pill fw-bold h-48">
            <i class="bi bi-arrow-left fs-5"></i>
            <span><?= __('back_to_rooms') ?></span>
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8 col-xl-7">
            <div class="premium-card p-4 p-md-5 animate__animated animate__fadeInUp">
                <form action="<?= BASE_URL ?>/rooms/store" method="POST" enctype="multipart/form-data" class="ajax-form">
                    <div class="luxury-input-group mb-4">
                        <label class="luxury-label"><?= __('room_number_name') ?> *</label>
                        <div class="input-wrapper">
                            <i class="bi bi-door-open icon"></i>
                            <input type="text" name="room_number" required placeholder="e.g. 101 or Presidential Suite">
                        </div>
                    </div>
                    
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('floor') ?> *</label>
                                <div class="input-wrapper">
                                    <i class="bi bi-layers-half icon"></i>
                                    <select name="floor_id" class="luxury-select" required>
                                        <option value="" selected disabled><?= __('select_floor') ?></option>
                                        <?php foreach ($floors as $floor): ?>
                                            <option value="<?= $floor['id'] ?>"><?= __('floor') ?> <?= htmlspecialchars($floor['floor_number']) ?> (<?= htmlspecialchars($floor['description'] ?? 'No text') ?>)</option>
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
                                        <option value="" selected disabled><?= __('select_category') ?></option>
                                        <?php foreach ($roomTypes as $type): ?>
                                            <option value="<?= $type['id'] ?>"><?= htmlspecialchars($type['name']) ?> ($<?= number_format($type['price'], 2) ?>/<?= __('night') ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-5">
                        <label class="luxury-label mb-3"><?= __('initial_status') ?></label>
                        <div class="status-selector-group">
                            <input type="radio" class="btn-check" name="status" id="status_avail" value="available" checked>
                            <label class="btn btn-outline-success status-btn shadow-xs" for="status_avail">
                                <i class="bi bi-check-circle me-1"></i> <?= __('available') ?>
                            </label>

                            <input type="radio" class="btn-check" name="status" id="status_maint" value="maintenance">
                            <label class="btn btn-outline-secondary status-btn shadow-xs" for="status_maint">
                                <i class="bi bi-tools me-1"></i> <?= __('maintenance') ?>
                            </label>
                        </div>
                    </div>

                    <div class="luxury-input-group mb-5">
                        <label class="luxury-label"><?= __('room_cover_image') ?></label>
                        <input type="file" class="form-control luxury-file-input" name="image" accept="image/*" onchange="previewRoomImage(this)">
                        <div id="imagePreview" class="mt-4"></div>
                    </div>
                    
                    <div class="pt-4 border-top">
                        <button type="submit" class="btn btn-primary btn-lg w-100 shadow-primary fw-extrabold rounded-pill py-3">
                            <i class="bi bi-plus-lg me-2"></i><?= strtoupper(__('save_room')) ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-lg-4 d-none d-lg-block">
            <div class="alert alert-primary bg-primary bg-opacity-10 border-0 rounded-5 p-4 animate__animated animate__fadeInRight">
                <div class="icon-box-sm bg-primary text-white mb-3"><i class="bi bi-info-circle-fill"></i></div>
                <h5 class="fw-extrabold text-primary"><?= __('premium_hosting') ?></h5>
                <p class="small text-muted opacity-75 lh-base mb-0">Setting up a new room defines its place in our luxury ecosystem. Ensure category and floor are accurate for optimal management.</p>
            </div>
        </div>
    </div>
</div>

<style>
/* LUXURY FORM STYLES */
.fw-extrabold { font-weight: 800; }
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

.status-selector-group { display: flex; flex-wrap: wrap; gap: 15px; }
.status-btn { 
    border-radius: 16px !important; padding: 12px 24px !important; font-weight: 800 !important; 
    text-transform: uppercase; font-size: 0.75rem !important; letter-spacing: 0.05em; border-width: 2px !important; transition: all 0.2s;
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
