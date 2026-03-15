<div class="animate__animated animate__fadeIn px-lg-4">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-4">
        <div class="d-flex align-items-center gap-3">
            <a href="<?= BASE_URL ?>/bookings/show?id=<?= $booking['id'] ?>" class="premium-back-btn">
                <i class="bi bi-chevron-left"></i>
            </a>
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/bookings" class="text-decoration-none text-muted small fw-bold text-uppercase tracking-widest"><?= __('bookings') ?></a></li>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/bookings/show?id=<?= $booking['id'] ?>" class="text-decoration-none text-muted small fw-bold text-uppercase tracking-widest">#<?= $booking['id'] ?></a></li>
                        <li class="breadcrumb-item active small fw-bold text-uppercase tracking-widest" aria-current="page"><?= __('edit') ?></li>
                    </ol>
                </nav>
                <h2 class="mb-0 fw-extrabold text-dark tracking-tight">
                    <?= __('edit') ?> <?= __('booking') ?> <span class="text-primary-gradient">#<?= $booking['id'] ?></span>
                </h2>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="premium-card overflow-hidden border-0 shadow-lg">
                <div class="card-body p-4 p-md-5">
                    <form action="<?= BASE_URL ?>/bookings/update" method="POST" id="bookingEditForm" class="ajax-form">
                        <input type="hidden" name="id" value="<?= $booking['id'] ?>">
                        
                        <!-- 1. Guest Section -->
                        <div class="section-divider mb-5">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="icon-circle bg-primary-gradient shadow-primary-sm">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>
                                    <h5 class="fw-extrabold text-dark mb-0"><?= __('guest_information') ?></h5>
                                    <p class="text-muted x-small fw-bold text-uppercase tracking-widest mb-0 opacity-50">Identity & Contact Profile</p>
                                </div>
                            </div>
                            
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('select_guest') ?></label>
                                <div class="input-wrapper">
                                    <i class="bi bi-person-check icon"></i>
                                    <select name="guest_id" required>
                                        <?php foreach ($guests as $guest): ?>
                                            <option value="<?= $guest['id'] ?>" <?= $booking['guest_id'] == $guest['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($guest['name']) ?> (<?= htmlspecialchars($guest['phone'] ?: 'No Phone') ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- 2. Stay Details Section -->
                        <div class="section-divider mb-5">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="icon-circle bg-gold-gradient shadow-gold-sm">
                                    <i class="bi bi-calendar-range-fill"></i>
                                </div>
                                <div>
                                    <h5 class="fw-extrabold text-dark mb-0"><?= __('stay_details') ?></h5>
                                    <p class="text-muted x-small fw-bold text-uppercase tracking-widest mb-0 opacity-50">Room allocation & Timeline</p>
                                </div>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="luxury-input-group">
                                        <label class="luxury-label"><?= __('room') ?></label>
                                        <div class="input-wrapper">
                                            <i class="bi bi-door-closed icon"></i>
                                            <select name="room_id" id="roomSelect" required>
                                                <?php foreach ($rooms as $room): ?>
                                                    <option value="<?= $room['id'] ?>" data-price="<?= $room['price'] ?>" <?= $booking['room_id'] == $room['id'] ? 'selected' : '' ?>>
                                                        <?= __('room') ?> <?= htmlspecialchars($room['room_number']) ?> - <?= htmlspecialchars($room['type_name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="luxury-input-group">
                                        <label class="luxury-label"><?= __('status') ?></label>
                                        <div class="input-wrapper">
                                            <i class="bi bi-shield-check icon"></i>
                                            <select name="status" required>
                                                <option value="pending" <?= $booking['status'] == 'pending' ? 'selected' : '' ?>><?= __('pending') ?></option>
                                                <option value="confirmed" <?= $booking['status'] == 'confirmed' ? 'selected' : '' ?>><?= __('confirmed') ?></option>
                                                <option value="occupied" <?= $booking['status'] == 'occupied' ? 'selected' : '' ?>><?= __('occupied') ?></option>
                                                <option value="checked_out" <?= $booking['status'] == 'checked_out' ? 'selected' : '' ?>><?= __('checked_out') ?></option>
                                                <option value="cancelled" <?= $booking['status'] == 'cancelled' ? 'selected' : '' ?>><?= __('cancelled') ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="luxury-input-group">
                                        <label class="luxury-label"><?= __('check_in') ?></label>
                                        <div class="input-wrapper">
                                            <i class="bi bi-calendar-plus icon"></i>
                                            <input type="date" name="check_in" id="checkIn" value="<?= date('Y-m-d', strtotime($booking['check_in'])) ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="luxury-input-group">
                                        <label class="luxury-label"><?= __('check_out') ?></label>
                                        <div class="input-wrapper">
                                            <i class="bi bi-calendar-minus icon text-danger"></i>
                                            <input type="date" name="check_out" id="checkOut" value="<?= date('Y-m-d', strtotime($booking['check_out'])) ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Tracking System -->
                        <div class="section-divider mb-5">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="icon-circle bg-dark-gradient shadow-sm">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <div>
                                    <h5 class="fw-extrabold text-dark mb-0"><?= __('performance_analytics') ?? 'Registry Tracking' ?></h5>
                                    <p class="text-muted x-small fw-bold text-uppercase tracking-widest mb-0 opacity-50">Actual Operation Timestamps</p>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="luxury-input-group">
                                        <label class="luxury-label"><?= __('actual_check_in') ?></label>
                                        <div class="input-wrapper bg-light bg-opacity-50">
                                            <i class="bi bi-clock icon text-primary"></i>
                                            <input type="datetime-local" name="actual_check_in" value="<?= $booking['actual_check_in'] ? date('Y-m-d\TH:i', strtotime($booking['actual_check_in'])) : '' ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="luxury-input-group">
                                        <label class="luxury-label"><?= __('actual_check_out') ?></label>
                                        <div class="input-wrapper bg-light bg-opacity-50">
                                            <i class="bi bi-clock icon text-danger"></i>
                                            <input type="datetime-local" name="actual_check_out" value="<?= $booking['actual_check_out'] ? date('Y-m-d\TH:i', strtotime($booking['actual_check_out'])) : '' ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- 4. Price Summary -->
                        <div class="summary-card-premium border-0 overflow-hidden mb-5">
                            <div class="p-4 d-flex justify-content-between align-items-center position-relative z-1">
                                <div>
                                    <h6 class="text-uppercase x-small fw-extrabold text-muted opacity-75 mb-1"><?= __('estimated_total') ?></h6>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="nights-badge" id="nightsCount">0 <?= __('nights') ?></span>
                                        <span class="text-muted x-small fw-bold">Calculated Price</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <h2 class="display-6 fw-extrabold text-dark mb-0" id="totalPriceDisplay">$<?= number_format($booking['total_price'], 2) ?></h2>
                                    <input type="hidden" name="total_price" id="totalPriceInput" value="<?= $booking['total_price'] ?>">
                                </div>
                            </div>
                            <div class="summary-pattern-overlay"></div>
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-4">
                                <a href="<?= BASE_URL ?>/bookings/show?id=<?= $booking['id'] ?>" class="btn btn-luxury-secondary w-100 py-3 rounded-4">
                                    <?= __('cancel') ?>
                                </a>
                            </div>
                            <div class="col-sm-8">
                                <button type="submit" class="btn btn-primary-gradient w-100 py-3 rounded-4 shadow-primary fw-extrabold d-flex align-items-center justify-content-center gap-2">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <?= strtoupper(__('save_changes')) ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="sticky-top" style="top: 2rem;">
                <div class="premium-card bg-dark text-white p-5 text-center shadow-lg border-0 overflow-hidden mb-4 rounded-5">
                    <div class="position-relative z-1">
                        <div class="icon-circle bg-white bg-opacity-10 mx-auto mb-4" style="width: 80px; height: 80px;">
                            <i class="bi bi-shield-lock display-5 text-primary"></i>
                        </div>
                        <h5 class="fw-extrabold text-uppercase tracking-widest mb-3"><?= __('notice') ?? 'Edit Protocol' ?></h5>
                        <p class="text-white text-opacity-50 small mb-0 line-height-relaxed">
                            Changes saved here will immediately update room availability across the system. Ensure all stay durations and status transitions are double-checked for accuracy.
                        </p>
                    </div>
                    <div class="pattern-overlay opacity-10"></div>
                </div>

                <div class="premium-card p-4 rounded-5 border-dashed border-2">
                    <h6 class="fw-extrabold text-dark text-uppercase tracking-wider mb-3 small">Need Help?</h6>
                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-4">
                        <div class="bg-primary-soft p-2 rounded-3">
                            <i class="bi bi-headset text-primary"></i>
                        </div>
                        <div class="small fw-bold text-muted">Concierge Desk<br><span class="text-dark">+855 12 345 678</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* LUXURY THEME ENHANCEMENTS */
.section-divider { position: relative; }
.icon-circle {
    width: 48px; height: 48px; border-radius: 16px; 
    display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: white;
}
.bg-primary-gradient { background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%); }
.bg-gold-gradient { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
.bg-dark-gradient { background: linear-gradient(135deg, #1f2937 0%, #111827 100%); }
.text-primary-gradient { 
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    -webkit-background-clip: text; 
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

.shadow-primary-sm { box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
.shadow-gold-sm { box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); }

/* LUXURY INPUT SYSTEM */
.luxury-input-group { position: relative; margin-bottom: 0.5rem; }
.luxury-label {
    font-size: 0.75rem; font-weight: 800; color: #64748b;
    text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 10px; display: block;
}
.input-wrapper {
    display: flex; align-items: center; background: #f8fafc;
    border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 0 18px; transition: all 0.3s;
}
.input-wrapper:focus-within { 
    border-color: #3b82f6; background: white; 
    box-shadow: 0 10px 30px -15px rgba(59, 130, 246, 0.2); 
}
.input-wrapper .icon { color: #94a3b8; font-size: 1.2rem; margin-right: 15px; flex-shrink: 0; }

.input-wrapper input, .input-wrapper select, .input-wrapper textarea {
    border: none !important; background: transparent !important;
    padding: 16px 0 !important; flex: 1; width: 0; min-width: 0;
    font-weight: 700 !important; color: #1e293b !important;
    outline: none !important; box-shadow: none !important; font-size: 0.95rem;
}

/* PREMIUM SUMMARY CARD */
.summary-card-premium {
    background-color: #f1f5f9; border-radius: 24px; position: relative;
}
.summary-pattern-overlay {
    position: absolute; top: 0; right: 0; bottom: 0; left: 0;
    background-image: radial-gradient(#3b82f6 0.5px, transparent 0.5px);
    background-size: 10px 10px; opacity: 0.05;
}
.nights-badge {
    background: #3b82f6; color: white; padding: 4px 12px; 
    border-radius: 8px; font-size: 0.75rem; font-weight: 800;
}

/* BUTTONS */
.btn-primary-gradient {
    background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
    border: none; color: white; transition: all 0.3s;
}
.btn-primary-gradient:hover {
    transform: translateY(-2px); box-shadow: 0 10px 20px rgba(59, 130, 246, 0.4);
}
.btn-luxury-secondary {
    background: #f1f5f9; color: #64748b; border: none; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.8rem; transition: all 0.2s;
}
.btn-luxury-secondary:hover { background: #e2e8f0; color: #1e293b; }

.line-height-relaxed { line-height: 1.6; }
.tracking-tight { letter-spacing: -0.025em; }
.bg-primary-soft { background-color: rgba(59, 130, 246, 0.1); }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roomSelect = document.querySelector('select[name="room_id"]');
        const checkIn = document.getElementById('checkIn');
        const checkOut = document.getElementById('checkOut');
        const nightsCount = document.getElementById('nightsCount');
        const totalPriceDisplay = document.getElementById('totalPriceDisplay');
        const totalPriceInput = document.getElementById('totalPriceInput');
        
        const nightText = "<?= __('night') ?>";
        const nightsText = "<?= __('nights') ?>";
        
        function calculateTotal() {
            const room = roomSelect.options[roomSelect.selectedIndex];
            const inDate = new Date(checkIn.value);
            const outDate = new Date(checkOut.value);
            
            if (room.value && !isNaN(inDate.getTime()) && !isNaN(outDate.getTime()) && outDate > inDate) {
                const price = parseFloat(room.getAttribute('data-price'));
                const diffTime = Math.abs(outDate - inDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                const total = price * diffDays;
                
                nightsCount.textContent = diffDays + ' ' + (diffDays === 1 ? nightText : nightsText);
                totalPriceDisplay.textContent = '$' + total.toLocaleString(undefined, {minimumFractionDigits: 2});
                totalPriceInput.value = total;
            }
        }
        
        roomSelect.addEventListener('change', calculateTotal);
        checkIn.addEventListener('change', calculateTotal);
        checkOut.addEventListener('change', calculateTotal);
        
        // Initial calculation
        calculateTotal();
    });
</script>
