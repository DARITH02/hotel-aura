<div class="animate__animated animate__fadeIn px-lg-4">
    <!-- Luxury Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-4">
        <div>
            <h2 class="mb-1 fw-extrabold text-dark d-flex align-items-center gap-3">
                <?= __('manage_rooms') ?>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1 rounded-pill small" style="font-size: 0.8rem;">
                    <?= count($allRooms) ?> <?= strtoupper(__('rooms')) ?>
                </span>
            </h2>
            <p class="text-muted small mb-0 fw-medium"><?= __('manage_inventory_status') ?></p>
        </div>
        
        <div class="d-flex gap-3 flex-wrap align-items-center">
            <div class="premium-search-box shadow-sm border rounded-pill overflow-hidden bg-white d-flex align-items-center px-3" style="min-width: 300px; height: 48px;">
                <i class="bi bi-search text-primary opacity-50 me-2"></i>
                <input type="text" id="roomSearchInput" class="form-control border-0 shadow-none bg-transparent ps-0" placeholder="<?= __('search') ?> <?= __('rooms') ?>...">
            </div>
            <a href="<?= BASE_URL ?>/rooms/create" class="btn btn-primary shadow-primary px-4 py-2 d-flex align-items-center gap-2 rounded-pill fw-bold h-48">
                <i class="bi bi-plus-lg fs-5"></i>
                <span><?= __('add_new_room') ?></span>
            </a>
        </div>
    </div>

    <!-- View Toggle Tabs -->
    <div class="luxury-tabs-container mb-5">
        <ul class="nav nav-pills gap-2" id="roomTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active rounded-pill px-4 fw-extrabold text-uppercase tracking-widest" id="visual-tab" data-bs-toggle="tab" data-bs-target="#visual-layout" type="button">
                    <i class="bi bi-grid-3x3-gap-fill me-2"></i><?= __('visual_layout') ?>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill px-4 fw-extrabold text-uppercase tracking-widest" id="list-tab" data-bs-toggle="tab" data-bs-target="#list-layout" type="button">
                    <i class="bi bi-list-stars me-2"></i><?= __('list_view') ?>
                </button>
            </li>
        </ul>
    </div>

    <!-- Tabs Content -->
    <div class="tab-content border-0 shadow-none bg-transparent" id="roomTabsContent">
        
        <!-- Visual Floor Layout -->
        <div class="tab-pane fade show active" id="visual-layout" role="tabpanel">
            <?php if (empty($floorsLayout)): ?>
                <div class="premium-card py-5 text-center shadow-sm">
                    <i class="bi bi-database-dash display-1 text-muted opacity-25 mb-3"></i>
                    <h5 class="fw-bold text-muted"><?= __('no_results') ?></h5>
                </div>
            <?php else: ?>
                <?php foreach ($floorsLayout as $floorNum => $floorData): ?>
                    <div class="floor-section mb-5 animate__animated animate__fadeInUp">
                        <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-2 border-light">
                            <div class="d-flex align-items-center gap-3">
                                <div class="floor-number-box"><?= htmlspecialchars($floorNum) ?></div>
                                <div>
                                    <h4 class="fw-extrabold text-dark mb-0"><?= __('floor') ?> <?= htmlspecialchars($floorNum) ?></h4>
                                    <p class="text-muted x-small fw-bold text-uppercase tracking-widest mb-0 opacity-75"><?= htmlspecialchars($floorData['description']) ?></p>
                                </div>
                            </div>
                            <span class="badge bg-light text-dark rounded-pill px-3 py-2 fw-extrabold border x-small">
                                <?= count($floorData['rooms']) ?> <?= strtoupper(__('rooms')) ?>
                            </span>
                        </div>
                        
                        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-4">
                            <?php foreach ($floorData['rooms'] as $room): ?>
                                <div class="col">
                                    <a href="<?= BASE_URL ?>/rooms/edit?id=<?= $room['id'] ?>" class="text-decoration-none">
                                        <div class="luxury-room-card room-<?= htmlspecialchars($room['status']) ?>">
                                            <div class="room-status-strip">
                                                <div class="status-dot-premium bg-current shadow-vibrant"></div>
                                                <span class="x-small fw-extrabold text-uppercase tracking-widest"><?= __($room['status']) ?></span>
                                            </div>
                                            <div class="room-visual-container">
                                                <?php if (!empty($room['image'])): ?>
                                                    <img src="<?= BASE_URL ?>/uploads/rooms/<?= htmlspecialchars($room['image']) ?>" class="room-img-v">
                                                <?php else: ?>
                                                    <div class="room-img-placeholder-v">
                                                        <i class="bi bi-door-closed"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="room-id-overlay">
                                                    <span class="fw-extrabold">#<?= htmlspecialchars($room['room_number']) ?></span>
                                                </div>
                                            </div>
                                            <div class="room-details-v">
                                                <div class="room-type-v"><?= htmlspecialchars($room['type_name']) ?></div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="room-price-v">$<?= number_format($room['price'], 0) ?></div>
                                                    <div class="room-capacity-v"><i class="bi bi-people-fill me-1"></i><?= htmlspecialchars($room['capacity'] ?? 2) ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Table List View -->
        <div class="tab-pane fade" id="list-layout" role="tabpanel">
            <div class="premium-card animate__animated animate__fadeInUp">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle luxury-table" id="roomTable">
                        <thead>
                            <tr class="text-muted x-small text-uppercase tracking-widest bg-light bg-opacity-50">
                                <th class="ps-4 py-4 fw-extrabold border-0"><?= __('room') ?></th>
                                <th class="py-4 fw-extrabold border-0"><?= __('floor') ?></th>
                                <th class="py-4 fw-extrabold border-0"><?= __('type') ?></th>
                                <th class="py-4 fw-extrabold border-0"><?= __('capacity') ?></th>
                                <th class="py-4 fw-extrabold border-0"><?= __('price_night') ?></th>
                                <th class="py-4 fw-extrabold border-0"><?= __('status') ?></th>
                                <th class="text-end pe-4 py-4 fw-extrabold border-0"><?= __('actions') ?></th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            <?php if (empty($allRooms)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="py-4 opacity-50">
                                            <i class="bi bi-inbox display-1 text-muted mb-2"></i>
                                            <h5 class="fw-bold text-muted"><?= __('no_rooms_found') ?></h5>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($allRooms as $room): ?>
                                <tr class="room-luxury-row" id="row-<?= $room['id'] ?>">
                                    <td class="ps-4 py-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="room-thumb shadow-sm rounded-3 border-2 border-white overflow-hidden" style="width: 52px; height: 52px;">
                                                <?php if (!empty($room['image'])): ?>
                                                    <img src="<?= BASE_URL ?>/uploads/rooms/<?= htmlspecialchars($room['image']) ?>" width="52" height="52" style="object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="bg-light w-100 h-100 d-flex align-items-center justify-content-center text-muted border">
                                                        <i class="bi bi-door-closed fs-4 opacity-25"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <span class="fw-extrabold text-dark d-block">#<?= htmlspecialchars($room['room_number']) ?></span>
                                                <span class="x-small text-muted fw-bold text-uppercase tracking-widest opacity-50">ID: <?= $room['id'] ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <div class="badge bg-white text-dark border shadow-xs rounded-pill px-3 py-2 x-small fw-extrabold">
                                            <?= strtoupper(__('floor')) ?> <?= htmlspecialchars($room['floor_number']) ?>
                                        </div>
                                    </td>
                                    <td class="py-4 fw-extrabold text-muted x-small text-uppercase tracking-wider"><?= htmlspecialchars($room['type_name']) ?></td>
                                    <td class="py-4 text-center">
                                        <div class="text-primary fw-extrabold small"><i class="bi bi-people-fill me-1"></i><?= htmlspecialchars($room['capacity'] ?? 2) ?></div>
                                    </td>
                                    <td class="py-4">
                                        <div class="fw-extrabold text-dark fs-5">$<?= number_format($room['price'], 2) ?></div>
                                    </td>
                                    <td class="py-4">
                                        <?php 
                                            $statusConfig = [
                                                'available' => ['bg' => 'success', 'pulse' => false],
                                                'booked' => ['bg' => 'danger', 'pulse' => true],
                                                'occupied' => ['bg' => 'primary', 'pulse' => true],
                                                'cleaning' => ['bg' => 'warning', 'pulse' => true],
                                                'maintenance' => ['bg' => 'secondary', 'pulse' => false]
                                            ];
                                            $cfg = $statusConfig[$room['status']] ?? ['bg' => 'secondary', 'pulse' => false];
                                        ?>
                                        <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-<?= $cfg['bg'] ?> bg-opacity-10 border border-<?= $cfg['bg'] ?> border-opacity-10">
                                            <div class="status-dot-premium bg-<?= $cfg['bg'] ?> <?= $cfg['pulse'] ? 'pulse-'.$cfg['bg'] : '' ?>"></div>
                                            <span class="x-small fw-extrabold text-<?= $cfg['bg'] ?> text-uppercase tracking-wider"><?= __($room['status']) ?></span>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4 py-4">
                                        <div class="dropdown">
                                            <button class="btn btn-luxury-action" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2">
                                                <li><a class="dropdown-item py-2 px-3 rounded-3 text-dark fw-bold d-flex align-items-center gap-2" href="<?= BASE_URL ?>/rooms/edit?id=<?= $room['id'] ?>"><i class="bi bi-pencil-square text-primary"></i><?= __('edit') ?></a></li>
                                                <?php if (($_SESSION['admin_role'] ?? '') === 'super_admin'): ?>
                                                <li><a class="dropdown-item py-2 px-3 rounded-3 text-danger fw-bold d-flex align-items-center gap-2 ajax-delete" href="<?= BASE_URL ?>/rooms/delete?id=<?= $room['id'] ?>" data-row-id="row-<?= $room['id'] ?>"><i class="bi bi-trash3-fill"></i><?= __('delete') ?></a></li>
                                                <?php endif; ?>
                                            </ul>
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
    </div>
</div>

<style>
/* LUXURY ROOM MANAGEMENT STYLES */
.fw-extrabold { font-weight: 800; }
.x-small { font-size: 0.7rem; }
.tracking-widest { letter-spacing: 0.15em; }

.luxury-tabs-container .nav-pills .nav-link {
    background: #f1f5f9;
    color: #64748b;
    border: 1px solid transparent;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.luxury-tabs-container .nav-pills .nav-link.active {
    background: #1e293b;
    color: white;
    box-shadow: 0 10px 25px -5px rgba(30, 41, 59, 0.3);
}

.floor-number-box {
    width: 44px;
    height: 44px;
    background: #1e293b;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-weight: 800;
    font-size: 1.25rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

/* Luxury Room Card */
.luxury-room-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid #f1f5f9;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
}
.luxury-room-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px -15px rgba(0,0,0,0.1);
}

.room-status-strip {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 14px;
    border-bottom: 1px solid #f8fafc;
}

.room-visual-container {
    height: 120px;
    position: relative;
    overflow: hidden;
}
.room-img-v { width: 100%; height: 100%; object-fit: cover; transition: all 0.5s; }
.luxury-room-card:hover .room-img-v { transform: scale(1.1); }
.room-img-placeholder-v { background: #f8fafc; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: #e2e8f0; }

.room-id-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    background: rgba(30, 41, 59, 0.9);
    color: white;
    padding: 4px 12px;
    border-top-right-radius: 12px;
    font-size: 0.85rem;
    backdrop-filter: blur(4px);
}

.room-details-v { padding: 12px 14px; }
.room-type-v { font-weight: 800; font-size: 0.75rem; color: #64748b; text-transform: uppercase; margin-bottom: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.room-price-v { font-weight: 800; font-size: 1rem; color: #1e293b; }
.room-capacity-v { color: #3b82f6; font-weight: 800; font-size: 0.7rem; }

/* Status Color Mapping */
.room-available .bg-current { background: #10b981; }
.room-available .room-status-strip { background: #f0fdf4; color: #15803d; }
.room-booked .bg-current { background: #f43f5e; }
.room-booked .room-status-strip { background: #fef2f2; color: #b91c1c; }
.room-occupied .bg-current { background: #3b82f6; }
.room-occupied .room-status-strip { background: #eff6ff; color: #1d4ed8; }
.room-cleaning .bg-current { background: #f59e0b; }
.room-cleaning .room-status-strip { background: #fffbeb; color: #b45309; }

.status-dot-premium { width: 8px; height: 8px; border-radius: 50%; }
.shadow-vibrant { box-shadow: 0 0 10px currentColor; }

/* Table Styles */
.premium-card { background: white; border-radius: 24px; box-shadow: 0 10px 40px -10px rgba(0,0,0,0.04); overflow: hidden; }
.luxury-table thead th { font-size: 0.65rem; letter-spacing: 0.1em; color: #64748b; }
.room-luxury-row { transition: all 0.2s; border-bottom: 1px solid #f8fafc; }
.room-luxury-row:hover { background: #f8fafc; }

.btn-luxury-action {
    width: 38px; height: 38px; border-radius: 12px; border: 1px solid #f1f5f9; background: white; color: #64748b;
    display: flex; align-items: center; justify-content: center; transition: all 0.2s;
}
.btn-luxury-action:hover { background: #1e293b; color: white; transform: translateY(-2px); }

/* Animation Utils */
.pulse-primary { animation: pulse-primary 2s infinite; }
.pulse-danger { animation: pulse-danger 2s infinite; }
.pulse-warning { animation: pulse-warning 2s infinite; }

@keyframes pulse-primary { 0% { box-shadow: 0 0 0 0 rgba(30, 41, 59, 0.4); } 70% { box-shadow: 0 0 0 6px rgba(30, 41, 59, 0); } 100% { box-shadow: 0 0 0 0 rgba(30, 41, 59, 0); } }
@keyframes pulse-danger { 0% { box-shadow: 0 0 0 0 rgba(244, 63, 94, 0.4); } 70% { box-shadow: 0 0 0 6px rgba(244, 63, 94, 0); } 100% { box-shadow: 0 0 0 0 rgba(244, 63, 94, 0); } }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof initTableSearch === 'function') {
        initTableSearch('#roomSearchInput', '#roomTable');
    }
    
    // Grid Search Support
    const searchInput = document.getElementById('roomSearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.col');
            cards.forEach(card => {
                const txt = card.textContent.toLowerCase();
                card.style.display = txt.includes(term) ? '' : 'none';
            });
        });
    }
});
</script>
