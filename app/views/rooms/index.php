<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="mb-1 fw-bold text-dark"><?= __('manage_rooms') ?></h2>
        <p class="text-muted small mb-0">Manage floor-wise room inventory and status.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap align-items-center">
        <div class="input-group shadow-sm" style="min-width: 250px;">
            <span class="input-group-text bg-white border-end-0 text-muted">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" id="roomSearchInput" class="form-control border-start-0 ps-0" placeholder="<?= __('search') ?> <?= __('rooms') ?>...">
        </div>
        <a href="<?= BASE_URL ?>/rooms/create" class="btn btn-primary shadow-sm px-4 py-2 d-flex align-items-center gap-2 rounded-3 text-nowrap">
            <i class="bi bi-plus-lg fs-5"></i>
            <span class="fw-bold"><?= __('add_new_room') ?></span>
        </a>
    </div>
</div>

<!-- Tabs Navigation -->
<ul class="nav nav-tabs mb-4" id="roomTabs" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active fw-bold text-dark" id="visual-tab" data-bs-toggle="tab" data-bs-target="#visual-layout" type="button" role="tab">
        <i class="bi bi-grid-3x3-gap-fill me-2 text-primary"></i><?= __('visual_layout') ?>
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link fw-bold text-dark" id="list-tab" data-bs-toggle="tab" data-bs-target="#list-layout" type="button" role="tab">
        <i class="bi bi-list-task me-2 text-primary"></i><?= __('list_view') ?>
    </button>
  </li>
</ul>

<<!-- Tabs Content -->
<div class="tab-content border-0 shadow-none bg-transparent" id="roomTabsContent">
    
    <!-- Visual Floor Layout -->
    <div class="tab-pane fade show active" id="visual-layout" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-4 mb-4 glass-card animate__animated animate__fadeInUp">
            <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-muted text-uppercase tracking-widest small"><?= __('floor_grid_view') ?></h6>
                <div class="d-flex gap-3 text-muted small fw-semibold">
                    <div><span class="status-dot bg-success-pulse me-1"></span><?= __('available') ?></div>
                    <div><span class="status-dot bg-danger-pulse me-1"></span><?= __('booked') ?></div>
                </div>
            </div>
            <div class="card-body p-4 pt-2">
                <?php if (empty($floorsLayout)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                        <h5><?= __('no_results') ?></h5>
                    </div>
                <?php else: ?>
                    <?php foreach ($floorsLayout as $floorNum => $floorData): ?>
                        <div class="mb-5 last-mb-0 animate__animated animate__fadeIn" style="animation-delay: 0.1s;">
                            <h5 class="fw-bold mb-4 pb-3 border-bottom d-flex justify-content-between align-items-center">
                                <span class="d-flex align-items-center">
                                    <i class="bi bi-layers text-primary me-2"></i>
                                    <?= __('floor') ?> <?= htmlspecialchars($floorNum) ?> 
                                    <small class="text-muted fw-normal ms-3 fs-6 d-none d-md-inline opacity-75"><?= htmlspecialchars($floorData['description']) ?></small>
                                </span>
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 small fw-bold"><?= count($floorData['rooms']) ?> <?= __('rooms') ?></span>
                            </h5>
                            
                            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-4">
                                <?php foreach ($floorData['rooms'] as $room): ?>
                                    <div class="col">
                                        <a href="<?= BASE_URL ?>/rooms/edit?id=<?= $room['id'] ?>" class="text-decoration-none">
                                            <div class="room-card room-<?= htmlspecialchars($room['status']) ?> h-100">
                                                <div class="room-card-header">
                                                    <span class="status-indicator"></span>
                                                    <span class="status-text"><?= __($room['status']) ?></span>
                                                </div>
                                                <div class="room-image-container">
                                                    <?php if (!empty($room['image'])): ?>
                                                        <img src="<?= BASE_URL ?>/uploads/rooms/<?= htmlspecialchars($room['image']) ?>" class="room-img">
                                                    <?php else: ?>
                                                        <div class="room-img-placeholder">
                                                            <i class="bi bi-door-closed"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="room-number-badge"><?= htmlspecialchars($room['room_number']) ?></div>
                                                </div>
                                                <div class="room-card-footer">
                                                    <div class="room-type-name"><?= htmlspecialchars($room['type_name']) ?></div>
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <div class="room-price fw-bold text-dark">$<?= number_format($room['price'], 0) ?></div>
                                                        <div class="text-primary fw-bold" style="font-size: 0.75rem;">
                                                            <i class="bi bi-people-fill"></i> <?= htmlspecialchars($room['capacity'] ?? 2) ?>
                                                        </div>
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
        </div>
    </div>
    
    <!-- Table List View -->
    <div class="tab-pane fade" id="list-layout" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden glass-card animate__animated animate__fadeInUp">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle custom-table" id="roomTable">
                        <thead>
                            <tr class="text-muted opacity-75 small text-uppercase tracking-wider">
                                <th class="ps-4 py-3 fw-bold border-0"><?= __('room') ?></th>
                                <th class="py-3 fw-bold border-0"><?= __('floor') ?></th>
                                <th class="py-3 fw-bold border-0"><?= __('type') ?></th>
                                <th class="py-3 fw-bold border-0"><?= __('capacity') ?></th>
                                <th class="py-3 fw-bold border-0"><?= __('price_night') ?></th>
                                <th class="py-3 fw-bold border-0"><?= __('status') ?></th>
                                <th class="text-end pe-4 py-3 fw-bold border-0"><?= __('actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($allRooms)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                    <h5>No rooms found</h5>
                                </td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($allRooms as $room): ?>
                                <tr class="room-row" id="row-<?= $room['id'] ?>">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <?php if (!empty($room['image'])): ?>
                                                <img src="<?= BASE_URL ?>/uploads/rooms/<?= htmlspecialchars($room['image']) ?>" class="rounded-3 shadow-sm border" style="width: 48px; height: 48px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-light text-muted d-flex align-items-center justify-content-center rounded-3 border" style="width: 48px; height: 48px;">
                                                    <i class="bi bi-door-closed opacity-25"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <span class="fw-bold text-dark d-block mb-0"><?= htmlspecialchars($room['room_number']) ?></span>
                                                <span class="x-small text-muted tracking-widest opacity-75">ID: <?= $room['id'] ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-light text-dark fw-bold border rounded-pill px-3"><?= __('floor') ?> <?= htmlspecialchars($room['floor_number']) ?></span>
                                    </td>
                                    <td class="py-3 fw-semibold"><?= htmlspecialchars($room['type_name']) ?></td>
                                    <td class="py-3">
                                        <span class="text-primary fw-bold small"><i class="bi bi-people-fill me-1"></i><?= htmlspecialchars($room['capacity'] ?? 2) ?></span>
                                    </td>
                                    <td class="py-3">
                                        <div class="fw-extrabold text-success fs-5">$<?= number_format($room['price'], 2) ?></div>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <?php 
                                                $statusBadge = 'bg-secondary';
                                                $dotClass = 'bg-secondary-pulse';
                                                if ($room['status'] == 'available') { $statusBadge = 'bg-success'; $dotClass = 'bg-success-pulse'; }
                                                if ($room['status'] == 'booked') { $statusBadge = 'bg-danger'; $dotClass = 'bg-danger-pulse'; }
                                                if ($room['status'] == 'occupied') { $statusBadge = 'bg-primary'; $dotClass = 'bg-primary-pulse'; }
                                                if ($room['status'] == 'cleaning') { $statusBadge = 'bg-warning text-dark'; $dotClass = 'bg-warning-pulse'; }
                                            ?>
                                            <span class="status-dot <?= $dotClass ?>"></span>
                                            <span class="badge <?= $statusBadge ?> bg-opacity-10 text-<?= str_replace(' text-dark', '', str_replace('bg-', '', $statusBadge)) ?> border-0 text-uppercase x-small fw-800 tracking-wider p-2 px-3 rounded-pill">
                                                <?= __($room['status']) ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4 py-3">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="<?= BASE_URL ?>/rooms/edit?id=<?= $room['id'] ?>" class="btn btn-sm btn-light border shadow-sm rounded-pill px-3 py-2 fw-bold text-primary">
                                                <i class="bi bi-pencil-square me-1"></i> <?= __('edit') ?>
                                            </a>
                                            <a href="<?= BASE_URL ?>/rooms/delete?id=<?= $room['id'] ?>" class="btn btn-sm btn-light border shadow-sm rounded-pill px-3 py-2 fw-bold text-danger ajax-delete" data-row-id="row-<?= $room['id'] ?>">
                                                <i class="bi bi-trash me-1"></i> <?= __('delete') ?>
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
.room-row {
    transition: all 0.2s ease;
    border-left: 4px solid transparent;
}
.room-row:hover {
    background-color: rgba(0, 123, 255, 0.02) !important;
    border-left-color: #0d6efd;
}

/* Enhanced Room Card Styling */
.room-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    position: relative;
    border: 1px solid #edf2f7;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

.room-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.room-card-header {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 8px;
    font-size: 0.65rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid rgba(0,0,0,0.03);
}

.status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.room-image-container {
    position: relative;
    height: 100px;
    overflow: hidden;
}

.room-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.room-card:hover .room-img {
    transform: scale(1.1);
}

.room-img-placeholder {
    width: 100%;
    height: 100%;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #cbd5e1;
}

.room-number-badge {
    position: absolute;
    bottom: 0;
    left: 0;
    background: rgba(15, 23, 42, 0.85);
    backdrop-filter: blur(4px);
    color: white;
    padding: 4px 12px;
    border-top-right-radius: 12px;
    font-weight: 800;
    font-size: 0.9rem;
    box-shadow: 2px -2px 10px rgba(0,0,0,0.1);
}

.room-card-footer {
    padding: 12px;
    text-align: center;
}

.room-type-name {
    font-weight: 700;
    color: #1e293b;
    font-size: 0.8rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 2px;
}

.room-price {
    font-size: 0.7rem;
    color: #64748b;
    font-weight: 500;
}

/* Status Color Themes */
.room-available .room-card-header { background: #f0fdf4; color: #166534; }
.room-available .status-indicator { background: #22c55e; box-shadow: 0 0 10px rgba(34, 197, 94, 0.4); }
.room-available { border-bottom: 4px solid #22c55e; }

.room-booked .room-card-header { background: #fef2f2; color: #991b1b; }
.room-booked .status-indicator { background: #ef4444; animation: status-pulse-red 2s infinite; }
.room-booked { border-bottom: 4px solid #ef4444; }

.room-occupied .room-card-header { background: #eff6ff; color: #1e40af; }
.room-occupied .status-indicator { background: #3b82f6; animation: status-pulse-blue 2s infinite; }
.room-occupied { border-bottom: 4px solid #3b82f6; }

.room-cleaning .room-card-header { background: #fffbeb; color: #92400e; }
.room-cleaning .status-indicator { background: #f59e0b; }
.room-cleaning { border-bottom: 4px solid #f59e0b; }

.room-maintenance .room-card-header { background: #f8fafc; color: #475569; }
.room-maintenance .status-indicator { background: #64748b; }
.room-maintenance { border-bottom: 4px solid #64748b; }

@keyframes status-pulse-red {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.5); opacity: 0.6; }
    100% { transform: scale(1); opacity: 1; }
}

@keyframes status-pulse-blue {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.5); opacity: 0.6; }
    100% { transform: scale(1); opacity: 1; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof initTableSearch === 'function') {
        initTableSearch('#roomSearchInput', '#roomTable');
    }
    
    // Custom search that also filters the Visual Layout grid
    const searchInput = document.getElementById('roomSearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const visuals = document.querySelectorAll('#visual-layout .col');
            let hasMatch = false;
            
            visuals.forEach(visual => {
                const text = visual.textContent.toLowerCase();
                const match = text.includes(searchTerm);
                visual.style.display = match ? '' : 'none';
                if (match) hasMatch = true;
            });

            // Handle Empty State for Visual Layout
            let visualBody = document.querySelector('#visual-layout .card-body');
            let noVisualRes = visualBody.querySelector('.visual-no-results');
            
            if (!hasMatch && searchTerm !== "") {
                if (!noVisualRes) {
                    noVisualRes = document.createElement('div');
                    noVisualRes.className = 'visual-no-results text-center py-5 w-100';
                    noVisualRes.innerHTML = `
                        <i class="bi bi-search display-3 text-light opacity-50 mb-3"></i>
                        <h5 class="text-muted">No rooms matching "${searchTerm}"</h5>
                    `;
                    visualBody.appendChild(noVisualRes);
                } else {
                    noVisualRes.querySelector('h5').innerText = `No rooms matching "${searchTerm}"`;
                }
            } else if (noVisualRes) {
                noVisualRes.remove();
            }
        });
    }
});
</script>
