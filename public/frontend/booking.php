<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('book_now') ?> | AURA Luxury Hotel</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Animate Config -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@300;400;500;600;700&family=Kantumruy+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/css/style.css">
    <style>
        :root {
            --aura-gold: #c5a059;
            --aura-dark: #0f172a;
            --aura-glass: rgba(255, 255, 255, 0.9);
            --aura-glass-border: rgba(255, 255, 255, 0.2);
        }

        body {
            background-color: var(--aura-dark);
            background-image: 
                linear-gradient(rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.8)),
                url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            font-family: 'Inter', 'Kantumruy Pro', sans-serif;
            color: white;
            min-height: 100vh;
        }

        .playfair { font-family: 'Playfair Display', serif; }

        .booking-hero {
            padding-top: 160px;
            padding-bottom: 80px;
        }

        .glass-card {
            background: var(--aura-glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--aura-glass-border);
            border-radius: 30px;
            color: var(--aura-dark);
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.5);
        }

        .telegram-premium-card {
            background: linear-gradient(135deg, #0088cc 0%, #00a2ed 100%);
            border-radius: 25px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .telegram-premium-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            z-index: 1;
        }

        .floating-label-luxury {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-luxury {
            background: #f8fafc !important;
            border: 2px solid transparent !important;
            border-radius: 15px !important;
            padding: 1.2rem 1.2rem 1.2rem 3.5rem !important;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .input-luxury:focus {
            border-color: var(--aura-gold) !important;
            background: white !important;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
        }

        .input-icon-luxury {
            position: absolute;
            left: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--aura-gold);
            font-size: 1.3rem;
            z-index: 10;
        }

        .luxury-btn {
            background: var(--aura-dark);
            color: white;
            border: none;
            border-radius: 15px;
            padding: 1.2rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 15px 30px rgba(15, 23, 42, 0.2);
        }

        .luxury-btn:hover {
            background: var(--aura-gold);
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(197, 160, 89, 0.3);
            color: white;
        }

        .summary-receipt {
            border: 2px dashed rgba(15, 23, 42, 0.1);
            border-radius: 20px;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.5);
        }

        .line-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .total-badge {
            background: var(--aura-dark);
            color: var(--aura-gold);
            padding: 1.5rem;
            border-radius: 20px;
            text-align: center;
        }

        .section-tag {
            font-family: 'Playfair Display', serif;
            color: var(--aura-gold);
            font-style: italic;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .breadcrumb-luxury {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 3rem;
        }

        .breadcrumb-step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            border: 2px solid rgba(255,255,255,0.2);
            transition: all 0.3s;
        }

        .breadcrumb-step.active {
            background: var(--aura-gold);
            border-color: var(--aura-gold);
            transform: scale(1.2);
            box-shadow: 0 0 20px rgba(197, 160, 89, 0.5);
        }

        /* Concierge Floating Styles */
        .concierge-floating-widget {
            position: fixed;
            bottom: 40px;
            right: 40px;
            z-index: 9999;
        }

        .concierge-toggle {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: var(--aura-gold);
            border: none;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            cursor: pointer;
            position: relative;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 30px rgba(197, 160, 89, 0.4);
        }

        .concierge-toggle:hover {
            transform: scale(1.05) rotate(5deg);
        }

        .toggle-icon {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-icon {
            position: absolute;
            opacity: 0;
            transform: rotate(-90deg);
            transition: all 0.3s;
        }

        .main-icon {
            transition: all 0.3s;
        }

        .concierge-floating-widget.active .main-icon {
            opacity: 0;
            transform: rotate(90deg);
        }

        .concierge-floating-widget.active .close-icon {
            opacity: 1;
            transform: rotate(0);
        }

        .pulse-ring {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 2px solid var(--aura-gold);
            animation: ring-pulse 2s infinite;
        }

        @keyframes ring-pulse {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(1.6); opacity: 0; }
        }

        .concierge-menu {
            position: absolute;
            bottom: 90px;
            right: 5px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            pointer-events: none;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .concierge-floating-widget.active .concierge-menu {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .concierge-action {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.4rem;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .concierge-action:hover {
            transform: scale(1.1) translateX(-5px);
            color: white;
        }

        .concierge-action.wa { background: #25D366; }
        .concierge-action.tg { background: #0088cc; }
        .concierge-action.phone { background: #0f172a; }

        .bg-gold-light {
            background: rgba(197, 160, 89, 0.1);
        }

        .text-accent {
            color: var(--aura-gold);
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <?php include APP_DIR . '/views/frontend/layouts/navbar.php'; ?>

    <div class="container booking-hero">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center animate__animated animate__fadeIn">
                <span class="section-tag"><?= __('reservation_enquiry') ?></span>
                <h1 class="playfair display-3 fw-bold mb-4"><?= __('complete_reservation') ?></h1>
                
                <div class="breadcrumb-luxury">
                    <div class="breadcrumb-step active">1</div>
                    <div class="breadcrumb-step">2</div>
                    <div class="breadcrumb-step">3</div>
                </div>
            </div>
        </div>

        <div class="row g-5 justify-content-center">
            <!-- Main Form -->
            <div class="col-lg-7">
                <div class="telegram-premium-card p-4 p-md-5 text-white mb-5 animate__animated animate__fadeInUp shadow-lg">
                    <div class="position-relative" style="z-index: 2;">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-white bg-opacity-20 p-3 d-flex justify-content-center align-items-center rounded-circle me-3" style="width: 100px; height: 100px;">
                                <i class="bi bi-telegram fs-1 text-secondary"></i>
                            </div>
                            <h3 class="fw-bold mb-0"><?= __('book_via_telegram') ?></h3>
                        </div>
                        <p class="opacity-90 lead mb-4"><?= __('telegram_desc') ?></p>
                        <a href="https://t.me/aura_hotel_bot" target="_blank" class="btn btn-light btn-lg px-5 py-3 rounded-pill fw-bold text-primary shadow-lg hover-lift">
                            <?= __('open_telegram') ?> <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <div class="glass-card p-4 p-md-5 animate__animated animate__fadeInLeft">
                    <form id="reservationForm">
                        <h4 class="playfair fw-bold mb-4 border-bottom pb-3"><?= __('stay_details') ?></h4>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="floating-label-luxury">
                                    <i class="bi  bi-calendar-check input-icon-luxury" style="top: 35%;"></i>
                                    <input type="date" class="form-control input-luxury" name="check_in" id="checkIn" required>
                                    <label class="small fw-bold text-muted ms-5 mt-1 d-block"><?= __('check_in') ?></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="floating-label-luxury">
                                    <i class="bi  bi-calendar-x input-icon-luxury" style="top: 35%;"></i>
                                    <input type="date" class="form-control input-luxury" name="check_out" id="checkOut" required>
                                    <label class="small fw-bold text-muted ms-5 mt-1 d-block"><?= __('check_out') ?></label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="floating-label-luxury">
                                    <i class="bi bi-door-open input-icon-luxury"></i>
                                    <select class="form-select input-luxury" id="roomTypeSelect" name="room_type_id" required>
                                        <option value="" disabled selected><?= __('select_room_type') ?></option>
                                        <?php foreach ($roomTypes as $type): ?>
                                        <option value="<?= $type['id'] ?>" data-price="<?= $type['price'] ?>" data-name="<?= htmlspecialchars($type['name']) ?>">
                                            <?= $type['name'] ?> - $<?= number_format($type['price'], 0) ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h4 class="playfair fw-bold mb-4 mt-2 border-bottom pb-3"><?= __('personal_info') ?></h4>
                        
                        <div class="floating-label-luxury">
                            <i class="bi bi-person input-icon-luxury"></i>
                            <input type="text" class="form-control input-luxury" name="full_name" placeholder="<?= __('enter_full_name') ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="floating-label-luxury">
                                    <i class="bi bi-envelope input-icon-luxury"></i>
                                    <input type="email" class="form-control input-luxury" name="email" placeholder="email@address.com" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="floating-label-luxury">
                                    <i class="bi bi-telephone input-icon-luxury"></i>
                                    <input type="tel" class="form-control input-luxury" name="phone" placeholder="+855 XX XXX XXX" required>
                                </div>
                            </div>
                        </div>

                        <div class="floating-label-luxury">
                            <i class="bi bi-chat-left-dots input-icon-luxury"></i>
                            <textarea class="form-control input-luxury" name="description" rows="3" placeholder="<?= __('special_requests') ?>"></textarea>
                        </div>

                        <button type="submit" class="luxury-btn w-100 mt-3 d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-shield-lock-fill fs-5"></i>
                            <?= __('confirm_reservation_request') ?>
                        </button>
                        
                        <div class="text-center mt-3">
                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-25 py-2 px-3 d-inline-flex align-items-center gap-2" style="font-size: 0.8rem; font-weight: 600;">
                                <i class="bi bi-globe"></i> <?= __('online_reservation_system') ?>
                            </span>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Sidebar -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 130px;">
                    <div class="glass-card p-4 p-md-5 animate__animated animate__fadeInRight shadow-lg">
                        <h4 class="playfair fw-bold mb-4 text-center"><?= __('booking_summary') ?></h4>
                        
                        <div class="summary-receipt mb-4">
                            <div class="line-item">
                                <span class="text-muted"><?= __('accommodation') ?></span>
                                <span id="summaryRoom" class="fw-bold fw-bold">--</span>
                            </div>
                            <div class="line-item">
                                <span class="text-muted"><?= __('duration') ?></span>
                                <span id="summaryNights" class="fw-bold">0 <?= __('nights') ?></span>
                            </div>
                            <div class="line-item">
                                <span class="text-muted"><?= __('nightly_rate') ?></span>
                                <span id="summaryRate" class="fw-bold">$0.00</span>
                            </div>
                            <div class="line-item mt-3 pt-3 border-top">
                                <span class="text-muted"><?= __('service_fee') ?> (10%)</span>
                                <span id="summaryService" class="fw-bold text-success">+$0.00</span>
                            </div>
                        </div>

                        <div class="total-badge animate__animated animate__pulse animate__infinite animate__slow">
                            <div class="small fw-bold text-uppercase tracking-widest opacity-75 mb-1"><?= __('estimated_total') ?></div>
                            <div class="display-5 fw-bold" id="summaryTotal">$0.00</div>
                        </div>

                        <div class="mt-4 p-3 rounded-4 bg-light border text-center small text-muted">
                            <i class="bi bi-info-circle me-2"></i> <?= __('price_not_final_msg') ?>
                        </div>
                    </div>

                    <!-- Enhanced Contact UX: Sidebar Support Card -->
                    <div class="glass-card p-4 mt-4 animate__animated animate__fadeInRight shadow-lg" style="animation-delay: 0.3s;">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-gold-light p-2 rounded-3 me-3">
                                <i class="bi bi-headset fs-4 text-accent"></i>
                            </div>
                            <h5 class="playfair fw-bold mb-0"><?= __('concierge_247') ?></h5>
                        </div>
                        <p class="small text-muted mb-4"><?= __('concierge_desc') ?></p>
                        <div class="d-grid gap-2">
                            <a href="https://wa.me/1234567890" target="_blank" class="btn btn-outline-success border-2 rounded-pill fw-bold small py-2">
                                <i class="bi bi-whatsapp me-2"></i> <?= __('whatsapp_support') ?>
                            </a>
                            <a href="tel:+1234567890" class="btn btn-outline-dark border-2 rounded-pill fw-bold small py-2">
                                <i class="bi bi-telephone me-2"></i> <?= __('call_us') ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content glass-card border-0 shadow-lg overflow-hidden">
                <div class="modal-body text-center p-5">
                    <div class="display-1 text-success mb-4 animate__animated animate__heartBeat">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h2 class="playfair display-6 fw-bold mb-3"><?= __('booking_received') ?></h2>
                    <p class="text-muted mb-4 fs-5"><?= __('msg_booking_created') ?></p>
                    
                    <div class="bg-dark text-white p-4 rounded-4 mb-4 text-start">
                        <p class="small fw-bold text-gold text-uppercase mb-2 tracking-widest" style="color: var(--aura-gold);"><?= __('next_steps') ?></p>
                        <ul class="small mb-0 opacity-75 list-unstyled">
                            <li class="mb-2"><i class="bi bi-1-circle-fill me-2"></i> <?= __('step_telegram_confirm') ?></li>
                            <li><i class="bi bi-2-circle-fill me-2"></i> <?= __('step_wait_agent') ?></li>
                        </ul>
                    </div>

                    <a href="https://t.me/aura_hotel_bot" id="telegramConfirmBtn" target="_blank" class="luxury-btn text-decoration-none d-block w-100 mb-3" style="background: #0088cc;">
                        <i class="bi bi-telegram me-2"></i> <?= __('open_telegram_confirm') ?>
                    </a>
                    <button type="button" class="btn btn-link link-secondary text-decoration-none border-0 fw-bold" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Concierge Widget -->
    <div class="concierge-floating-widget">
        <div class="concierge-menu animate__animated" id="conciergeMenu">
            <a href="https://wa.me/1234567890" target="_blank" class="concierge-action wa" title="<?= __('whatsapp_support') ?>">
                <i class="bi bi-whatsapp"></i>
            </a>
            <a href="https://t.me/aura_hotel_bot" target="_blank" class="concierge-action tg" title="<?= __('open_telegram') ?>">
                <i class="bi bi-telegram"></i>
            </a>
            <a href="tel:+1234567890" class="concierge-action phone" title="<?= __('call_us') ?>">
                <i class="bi bi-telephone-fill"></i>
            </a>
        </div>
        <button class="concierge-toggle shadow-lg" onclick="toggleConcierge()">
            <div class="toggle-icon">
                <i class="bi bi-chat-dots-fill main-icon"></i>
                <i class="bi bi-x-lg close-icon"></i>
            </div>
            <span class="pulse-ring"></span>
        </button>
    </div>

    <!-- Footer -->
    <?php include APP_DIR . '/views/frontend/layouts/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('reservationForm');
            const roomSelect = document.getElementById('roomTypeSelect');
            const checkInInput = document.getElementById('checkIn');
            const checkOutInput = document.getElementById('checkOut');
            
            const summaryRoom = document.getElementById('summaryRoom');
            const summaryNights = document.getElementById('summaryNights');
            const summaryRate = document.getElementById('summaryRate');
            const summaryService = document.getElementById('summaryService');
            const summaryTotal = document.getElementById('summaryTotal');

            // Handle URL Parameters
            const urlParams = new URLSearchParams(window.location.search);
            const paramRoomId = urlParams.get('room_type_id');
            const paramCheckIn = urlParams.get('check_in');
            const paramCheckOut = urlParams.get('check_out');

            if (paramRoomId) roomSelect.value = paramRoomId;
            if (paramCheckIn) checkInInput.value = paramCheckIn;
            if (paramCheckOut) checkOutInput.value = paramCheckOut;

            function calculateTotals() {
                const selected = roomSelect.options[roomSelect.selectedIndex];
                if (!selected || selected.value === "") return;
                
                const price = parseFloat(selected.dataset.price) || 0;
                const name = selected.dataset.name || "--";
                
                const start = new Date(checkInInput.value);
                const end = new Date(checkOutInput.value);
                let nights = 1;

                if (start && end && end > start) {
                    const diffTime = Math.abs(end - start);
                    nights = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                }

                summaryRoom.textContent = name;
                summaryNights.textContent = nights + ' <?= __('nights') ?>';
                summaryRate.textContent = '$' + (price * nights).toLocaleString(undefined, {minimumFractionDigits: 2});
                
                const serviceFee = (price * nights) * 0.1;
                summaryService.textContent = '+$' + serviceFee.toLocaleString(undefined, {minimumFractionDigits: 2});
                
                const total = (price * nights) + serviceFee;
                summaryTotal.textContent = '$' + total.toLocaleString(undefined, {minimumFractionDigits: 2});
            }

            [roomSelect, checkInInput, checkOutInput].forEach(el => el.addEventListener('change', calculateTotals));
            calculateTotals();

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const btn = this.querySelector('button[type="submit"]');
                const originalContent = btn.innerHTML;
                
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Processing...';
                
                const formData = new FormData(this);

                fetch('<?= BASE_URL ?>/make-reservation/submit', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update Telegram link with guest ID
                        const tgBtn = document.getElementById('telegramConfirmBtn');
                        if (tgBtn && data.guestId) {
                            tgBtn.href = `https://t.me/aura_hotel_bot?start=${data.guestId}`;
                        }
                        
                        const modal = new bootstrap.Modal(document.getElementById('successModal'));
                        modal.show();
                        this.reset();
                        calculateTotals();
                    } else {
                        alert(data.message || '<?= __('error') ?>');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalContent;
                });
            });
        });

        function toggleConcierge() {
            const widget = document.querySelector('.concierge-floating-widget');
            const menu = document.getElementById('conciergeMenu');
            widget.classList.toggle('active');
            
            if(widget.classList.contains('active')) {
                menu.classList.add('animate__fadeInUp');
            } else {
                menu.classList.remove('animate__fadeInUp');
            }
        }
    </script>
</body>
</html>
