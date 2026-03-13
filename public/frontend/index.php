<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('refined_luxury') ?> | AURA Luxury Hotel</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@300;400;500;600;700;800&family=Kantumruy+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/css/style.css">
    
    <style>
        :root {
            --aura-gold: #c5a059;
            --aura-dark: #0f172a;
            --aura-glass-light: rgba(255, 255, 255, 0.95);
        }

        .hero-premium-luxury {
            height: 100vh;
            background: linear-gradient(rgba(15, 23, 42, 0.5), rgba(15, 23, 42, 0.3)), 
                        url('https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .hero-luxury-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3rem, 8vw, 6rem);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -2px;
            text-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .booking-glass-luxury {
            background: var(--aura-glass-light);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255,255,255,0.4);
            border-radius: 30px;
            padding: 3rem;
            box-shadow: 0 50px 100px -20px rgba(0,0,0,0.2);
            margin-top: -100px;
            position: relative;
            z-index: 100;
            transform: translateY(0);
            transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .luxury-field-label {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--aura-gold);
            margin-bottom: 0.8rem;
            display: block;
        }

        .luxury-input-modern {
            background: #f8fafc !important;
            border: 2px solid transparent !important;
            border-radius: 15px !important;
            padding: 0.8rem 1.2rem !important;
            font-weight: 600 !important;
            color: var(--aura-dark) !important;
            transition: all 0.3s ease;
        }

        .luxury-input-modern:focus {
            background: white !important;
            border-color: var(--aura-gold) !important;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
        }

        .premium-btn-gold {
            background: var(--aura-dark);
            color: white;
            border: none;
            padding: 1.2rem;
            border-radius: 15px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            box-shadow: 0 15px 30px rgba(15, 23, 42, 0.2);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .premium-btn-gold:hover {
            background: var(--aura-gold);
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(197, 160, 89, 0.4);
            color: white;
        }

        .luxury-section-header {
            max-width: 800px;
            margin: 0 auto 5rem;
        }

        .floating-room-price {
            position: absolute;
            top: 30px;
            right: 30px;
            background: var(--aura-gold);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 1rem;
            box-shadow: 0 15px 30px rgba(197, 160, 89, 0.3);
            z-index: 10;
        }

        .luxury-card-img-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 25px;
            height: 450px;
        }

        .luxury-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 1s ease;
        }

        .room-card-premium:hover .luxury-card-img {
            transform: scale(1.1);
        }

        .feature-icon-wrapper {
            width: 80px;
            height: 80px;
            background: #f8fafc;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            transition: all 0.4s;
            color: var(--aura-gold);
            font-size: 2rem;
            border: 1px solid rgba(0,0,0,0.03);
        }

        .experience-card:hover .feature-icon-wrapper {
            background: var(--aura-gold);
            color: white;
            transform: rotateY(180deg);
            box-shadow: 0 10px 30px rgba(197, 160, 89, 0.4);
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <?php include APP_DIR . '/views/frontend/layouts/navbar.php'; ?>

    <!-- Cinematic Hero -->
    <header class="hero-premium-luxury animate__animated animate__fadeIn">
        <div class="container text-center text-white position-relative" style="z-index: 10;">
            <div class="animate__animated animate__fadeInUp">
                <span class="luxury-tag text-uppercase tracking-widest fw-bold mb-3 d-inline-block" style="color: var(--aura-gold); letter-spacing: 5px;"><?= __('welcome_to_aura') ?></span>
                <h1 class="hero-luxury-title mb-4"><?= __('refined_luxury') ?></h1>
                <p class="lead mb-5 opacity-75 fs-4 fw-light max-w-700 mx-auto leading-relaxed"><?= __('experience_pinnacle') ?></p>
                <div class="scroll-indicator animate__animated animate__bounce animate__infinite mt-5">
                    <i class="bi bi-mouse fs-2 opacity-50"></i>
                </div>
            </div>
        </div>
    </header>

    <!-- Elite Booking Interface -->
    <div class="container">
        <div class="booking-glass-luxury animate__animated animate__fadeInUp shadow-2xl">
            <form class="row g-4 align-items-end" action="<?= BASE_URL ?>/make-reservation" method="GET">
                <div class="col-lg-3 col-md-6">
                    <label class="luxury-field-label"><?= __('check_in') ?></label>
                    <input type="date" class="form-control luxury-input-modern" name="check_in" required>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="luxury-field-label"><?= __('check_out') ?></label>
                    <input type="date" class="form-control luxury-input-modern" name="check_out" required>
                </div>
                <div class="col-lg-2 col-md-6">
                    <label class="luxury-field-label"><?= __('guests') ?></label>
                    <select class="form-select luxury-input-modern" name="guests">
                        <option value="1">1 <?= __('adults') ?></option>
                        <option value="2" selected>2 <?= __('adults') ?></option>
                        <option value="3">3 <?= __('adults') ?></option>
                        <option value="4+">4+ <?= __('adults') ?></option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6">
                    <label class="luxury-field-label"><?= __('room_type') ?></label>
                    <select class="form-select luxury-input-modern" name="room_type_id">
                        <?php foreach ($roomTypes as $type): ?>
                            <option value="<?= $type['id'] ?>"><?= $type['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-2">
                    <button type="submit" class="premium-btn-gold w-100"><?= __('book_now') ?></button>
                </div>
            </form>
        </div>
    </div>

    <!-- The Aura Story -->
    <section class="py-5" style="margin-top: 120px;">
        <div class="container py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 mb-5 mb-lg-0 pe-lg-5 animate__animated animate__fadeInLeft">
                    <span class="heading-sub mb-3"><?= __('our_heritage') ?></span>
                    <h2 class="display-3 fw-bold playfair mb-4 leading-tight"><?= __('legacy_elegance') ?></h2>
                    <p class="text-muted fs-5 mb-5 lh-lg opacity-75 fw-light"><?= __('story_description') ?></p>
                    <a href="<?= BASE_URL ?>/about-us" class="btn btn-dark btn-lg px-5 py-3 rounded-pill fw-bold text-uppercase small shadow-lg hover-lift"><?= __('read_our_story') ?></a>
                </div>
                <div class="col-lg-6 animate__animated animate__fadeInRight">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="img-fluid rounded-5 shadow-2xl relative z-10" alt="Legacy">
                        <div class="position-absolute bottom-0 start-0 translate-middle-x mb-5 ms-3 d-none d-md-block" style="z-index: 20;">
                            <div class="glass-card p-4 rounded-4 shadow-xl text-center" style="background: rgba(255,255,255,0.9); backdrop-filter: blur(10px); width: 220px;">
                                <div class="display-4 fw-bold text-accent mb-0">25+</div>
                                <div class="small fw-bold text-uppercase opacity-50 tracking-widest"><?= __('years_excellence') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Premier Showcase -->
    <section class="py-5 bg-light" style="border-radius: 80px 80px 0 0;">
        <div class="container py-5">
            <div class="luxury-section-header text-center mb-5">
                <span class="heading-sub mb-3"><?= __('premier_collections') ?></span>
                <h2 class="display-4 fw-bold playfair"><?= __('luxurious_rooms_suites') ?></h2>
            </div>
            
            <div class="row g-5">
                <?php 
                $displayRooms = array_slice($roomTypes, 0, 3);
                foreach ($displayRooms as $index => $room): 
                    $image = !empty($room['image']) ? BASE_URL . '/uploads/room_types/' . $room['image'] : 'https://images.unsplash.com/photo-1591088398332-8a77d4972844?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="room-card-premium border-0 h-100 position-relative animate__animated animate__fadeInUp" style="animation-delay: <?= $index * 0.2 ?>s">
                        <div class="luxury-card-img-wrapper shadow-2xl">
                            <img src="<?= $image ?>" alt="<?= htmlspecialchars($room['name']) ?>" class="luxury-card-img">
                            <div class="floating-room-price">$<?= number_format($room['price'], 0) ?></div>
                        </div>
                        <div class="room-content-overlay mt-4">
                            <h3 class="fw-bold playfair fs-3 mb-3 text-dark"><?= htmlspecialchars($room['name']) ?></h3>
                            <div class="d-flex gap-4 mb-4 text-muted small fw-bold">
                                <span><i class="bi bi-arrows-fullscreen me-2 text-accent"></i> 45-60 m²</span>
                                <span><i class="bi bi-people me-2 text-accent"></i> 2-4 <?= __('guests') ?></span>
                            </div>
                            <a href="<?= BASE_URL ?>/room-details?id=<?= $room['id'] ?>" class="btn btn-outline-dark w-100 py-3 rounded-pill text-uppercase fw-bold small hover-lift d-flex align-items-center justify-content-center gap-2">
                                <?= __('view_details') ?> <i class="bi bi-arrow-up-right small"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- The Experience -->
    <section class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <span class="luxury-tag text-uppercase tracking-widest fw-bold mb-3 d-inline-block opacity-50" style="letter-spacing: 5px;"><?= __('curated_services') ?></span>
                <h2 class="display-4 fw-bold playfair"><?= __('aura_experience') ?></h2>
            </div>
            <div class="row g-4">
                <?php 
                $experiences = [
                    ['icon' => 'bi-cup-hot', 'title' => 'dining', 'desc' => 'dining_desc'],
                    ['icon' => 'bi-water', 'title' => 'pool', 'desc' => 'pool_desc'],
                    ['icon' => 'bi-gem', 'title' => 'spa', 'desc' => 'spa_desc'],
                    ['icon' => 'bi-car-front', 'title' => 'chauffeur', 'desc' => 'chauffeur_desc']
                ];
                foreach($experiences as $exp):
                ?>
                <div class="col-lg-3 col-md-6">
                    <div class="experience-card feature-card text-center h-100 animate__animated animate__zoomIn">
                        <div class="feature-icon-wrapper shadow-sm">
                            <i class="bi <?= $exp['icon'] ?>"></i>
                        </div>
                        <h4 class="fw-bold mb-3 text-uppercase small tracking-widest"><?= __($exp['title']) ?></h4>
                        <p class="text-muted mb-0 small opacity-75 leading-relaxed"><?= __($exp['desc']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include APP_DIR . '/views/frontend/layouts/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
