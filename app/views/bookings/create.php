<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="mb-1 fw-bold text-dark"><?= __('create_booking') ?></h2>
        <p class="text-muted small mb-0">Fill in the details below to register a new guest reservation.</p>
    </div>
    <a href="<?= BASE_URL ?>/bookings" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-1"></i> <?= __('back_to_bookings') ?>
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <form action="<?= BASE_URL ?>/bookings/store" method="POST" id="bookingForm" class="ajax-form">
                    <!-- 1. Guest Section -->
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-person-check-fill fs-5"></i>
                        </div>
                        <h5 class="fw-bold mb-0"><?= __('guest_information') ?></h5>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label text-muted fw-semibold small text-uppercase"><?= __('select_guest') ?></label>
                        <select name="guest_id" class="form-select border-2 py-2" required>
                            <option value="" selected disabled><?= __('select_guest_placeholder') ?></option>
                            <?php foreach ($guests as $guest): ?>
                                <option value="<?= $guest['id'] ?>">
                                    <?= htmlspecialchars($guest['name']) ?> (<?= htmlspecialchars($guest['email'] ?: $guest['phone']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text mt-2">
                            <i class="bi bi-info-circle me-1"></i>
                            <a href="<?= BASE_URL ?>/guests" class="text-decoration-none fw-semibold"><?= __('need_new_guest') ?></a>
                        </div>
                    </div>
                    
                    <hr class="my-5 opacity-50">
                    
                    <!-- 2. Room Section -->
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-door-open-fill fs-5"></i>
                        </div>
                        <h5 class="fw-bold mb-0"><?= __('room_dates') ?></h5>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label text-muted fw-semibold small text-uppercase"><?= __('select_room') ?></label>
                        <select name="room_id" id="roomSelect" class="form-select border-2 py-2" required>
                            <option value="" selected disabled><?= __('select_room_placeholder') ?></option>
                            <?php foreach ($rooms as $room): ?>
                                <?php if ($room['status'] == 'available'): ?>
                                    <option value="<?= $room['id'] ?>" data-price="<?= $room['price'] ?>">
                                        <?= __('room') ?> <?= htmlspecialchars($room['room_number']) ?> - <?= htmlspecialchars($room['type_name']) ?> ($<?= number_format($room['price'], 2) ?>/night)
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="row mb-5">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label text-muted fw-semibold small text-uppercase"><?= __('check_in') ?></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-2 border-end-0"><i class="bi bi-calendar-event"></i></span>
                                <input type="date" class="form-control border-2 border-start-0 py-2" name="check_in" id="checkIn" required min="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold small text-uppercase"><?= __('check_out') ?></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-2 border-end-0"><i class="bi bi-calendar-check text-danger"></i></span>
                                <input type="date" class="form-control border-2 border-start-0 py-2" name="check_out" id="checkOut" required min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                            </div>
                        </div>
                    </div>
                    
                    <!-- 3. Summary Section -->
                    <div class="summary-card p-4 rounded-4 mb-4 border-start border-4 border-success shadow-sm" style="background: #fdfdfd;">
                        <h6 class="text-uppercase small fw-bold text-muted mb-4 border-bottom pb-2">3. <?= __('total_price') ?></h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted"><?= __('stay_duration') ?>:</span>
                            <span class="fw-bold text-dark" id="nightsCount">0 <?= __('nights') ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted"><?= __('room_rate') ?>:</span>
                            <span class="fw-bold text-dark" id="roomRate">$0.00 / <?= __('night') ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <span class="fs-5 fw-bold text-dark"><?= __('estimated_total') ?>:</span>
                            <div class="text-end">
                                <span class="fs-3 fw-bold text-success" id="totalPriceDisplay">$0.00</span>
                                <input type="hidden" name="total_price" id="totalPriceInput" value="0">
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 mt-5">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill py-3 fw-bold shadow d-flex align-items-center justify-content-center gap-2" id="submitBtn" disabled>
                            <i class="bi bi-calendar-check-fill"></i>
                            <?= __('confirm_booking') ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="policy-card card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
            <div class="card-header bg-primary text-white py-3 px-4 border-0">
                <div class="d-flex align-items-center">
                    <i class="bi bi-shield-check fs-4 me-2"></i>
                    <h5 class="fw-bold mb-0 small text-uppercase"><?= __('booking_policy') ?></h5>
                </div>
            </div>
            <div class="card-body p-4 bg-white">
                <ul class="policy-list list-unstyled mb-0">
                    <li><i class="bi bi-check-circle-fill text-success"></i> <?= __('policy_checkin') ?></li>
                    <li><i class="bi bi-check-circle-fill text-success"></i> <?= __('policy_checkout') ?></li>
                    <li><i class="bi bi-info-circle-fill text-primary"></i> <?= __('policy_cancel') ?></li>
                    <li><i class="bi bi-exclamation-triangle-fill text-warning"></i> <?= __('policy_late') ?></li>
                    <li><i class="bi bi-person-badge-fill text-info"></i> <?= __('policy_id') ?></li>
                </ul>
                
                <div class="mt-5 p-3 rounded-3 bg-light border text-center">
                    <i class="bi bi-headset display-6 text-muted mb-2 d-block opacity-50"></i>
                    <p class="small text-muted mb-0">Need assistance? Contact support at <br><strong>+855 12 345 678</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.policy-list li {
    padding: 12px 0;
    border-bottom: 1px dashed #eee;
    font-size: 0.9rem;
    color: #555;
    display: flex;
    align-items: flex-start;
}
.policy-list li:last-child { border-bottom: 0; }
.policy-list i {
    margin-right: 12px;
    margin-top: 2px;
}
.summary-card {
    background-image: linear-gradient(to right, #ffffff, #fafafa);
}
.form-select, .form-control {
    transition: all 0.2s;
}
.form-select:focus, .form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.05);
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roomSelect = document.getElementById('roomSelect');
        const checkIn = document.getElementById('checkIn');
        const checkOut = document.getElementById('checkOut');
        
        const nightsCount = document.getElementById('nightsCount');
        const roomRate = document.getElementById('roomRate');
        const totalPriceDisplay = document.getElementById('totalPriceDisplay');
        const totalPriceInput = document.getElementById('totalPriceInput');
        const submitBtn = document.getElementById('submitBtn');
        
        // Localization markers from PHP (we can improve this by using the Translations object if needed)
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
                roomRate.textContent = '$' + price.toFixed(2) + ' / ' + nightText;
                totalPriceDisplay.textContent = '$' + total.toFixed(2);
                totalPriceInput.value = total;
                
                submitBtn.disabled = false;
            } else {
                nightsCount.textContent = '0 ' + nightsText;
                roomRate.textContent = '$0.00 / ' + nightText;
                totalPriceDisplay.textContent = '$0.00';
                totalPriceInput.value = '0';
                
                submitBtn.disabled = true;
            }
        }
        
        roomSelect.addEventListener('change', calculateTotal);
        checkIn.addEventListener('change', function() {
            if(this.value) {
                const nextDay = new Date(this.value);
                nextDay.setDate(nextDay.getDate() + 1);
                checkOut.min = nextDay.toISOString().split('T')[0];
                
                if(checkOut.value && new Date(checkOut.value) <= new Date(this.value)) {
                    checkOut.value = checkOut.min;
                }
            }
            calculateTotal();
        });
        checkOut.addEventListener('change', calculateTotal);
    });
</script>
