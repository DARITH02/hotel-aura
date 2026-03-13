<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('rooms') ?> | AURA Luxury Hotel</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@300;400;500;600&family=Kantumruy+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/css/style.css">
    
    <style>
        :root {
            --aura-gold: #c5a059;
            --aura-dark: #0f172a;
            --aura-glass: rgba(255, 255, 255, 0.9);
        }

        body {
            background-color: #fdfdfd;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        .header-section {
            background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.8)), 
                        url('<?= !empty($roomTypes[0]['image']) ? BASE_URL . '/uploads/room_types/' . $roomTypes[0]['image'] : BASE_URL . '/frontend/img/room3.png' ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            position: relative;
        }

        .header-section::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px;
            background: linear-gradient(to top, #fdfdfd, transparent);
        }

        .room-card-premium {
            border: none;
            border-radius: 30px;
            overflow: hidden;
            background: white;
            box-shadow: 0 15px 45px rgba(0,0,0,0.04);
            transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
            margin-bottom: 80px;
            position: relative;
        }

        .room-card-premium:hover {
            transform: translateY(-15px) scale(1.01);
            box-shadow: 0 40px 80px rgba(15, 23, 42, 0.12);
        }

        .room-img-container {
            height: 550px;
            position: relative;
            overflow: hidden;
        }

        .room-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 2s ease;
        }

        .room-card-premium:hover .room-img-container img {
            transform: scale(1.1);
        }

        .premium-badge {
            position: absolute;
            top: 40px;
            left: 40px;
            background: rgba(197, 160, 89, 0.9);
            backdrop-filter: blur(10px);
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-size: 11px;
            z-index: 10;
            box-shadow: 0 10px 20px rgba(197, 160, 89, 0.3);
        }

        .price-tag-floating {
            position: absolute;
            bottom: 40px;
            right: 40px;
            background: white;
            padding: 20px 35px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            z-index: 10;
            transform: translateY(0);
            transition: all 0.4s ease;
        }

        .room-card-premium:hover .price-tag-floating {
            transform: translateY(-5px);
            background: var(--aura-dark);
            color: white;
        }

        .room-card-premium:hover .price-tag-floating .currency {
            color: rgba(255,255,255,0.6);
        }

        .price-tag-floating .amount {
            color: var(--aura-gold);
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 800;
        }

        .price-tag-floating .currency {
            font-size: 15px;
            color: #64748b;
            font-weight: 600;
        }

        .room-details-pane {
            padding: 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .amenity-icon {
            width: 50px;
            height: 50px;
            background: #f1f5f9;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--aura-gold);
            font-size: 20px;
            transition: all 0.4s;
        }

        .amenity-item:hover .amenity-icon {
            background: var(--aura-gold);
            color: white;
            transform: translateY(-5px);
        }

        .btn-aura {
            background: var(--aura-dark);
            color: white !important;
            padding: 18px 45px;
            border-radius: 15px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-size: 13px;
            transition: all 0.4s;
            border: none;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.2);
        }

        .btn-aura:hover {
            background: var(--aura-gold);
            transform: translateX(10px);
            box-shadow: 0 15px 30px rgba(197, 160, 89, 0.4);
        }

        .btn-aura-outline {
            background: transparent;
            color: var(--aura-dark) !important;
            padding: 18px 45px;
            border-radius: 15px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-size: 13px;
            transition: all 0.4s;
            border: 2px solid #e2e8f0;
        }

        .btn-aura-outline:hover {
            border-color: var(--aura-dark);
            background: rgba(15, 23, 42, 0.05);
        }

        .heading-decoration {
            width: 80px;
            height: 3px;
            background: var(--aura-gold);
            margin-bottom: 25px;
            border-radius: 2px;
        }

        .floating-label {
            position: absolute;
            top: 50%;
            left: -50px;
            transform: rotate(-90deg) translateY(-50%);
            font-size: 80px;
            font-weight: 900;
            color: rgba(0,0,0,0.02);
            pointer-events: none;
            white-space: nowrap;
            letter-spacing: 20px;
        }

        /* Premium Carousel Controls */
        .carousel-control-prev, .carousel-control-next {
            width: 8%;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .room-card-premium:hover .carousel-control-prev,
        .room-card-premium:hover .carousel-control-next {
            opacity: 1;
        }

        .carousel-control-prev-icon, .carousel-control-next-icon {
            background-color: var(--aura-dark);
            background-size: 50% 50%;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .object-fit-cover {
            object-fit: cover;
        }

        @media (max-width: 991px) {
            .room-img-container { height: 400px; }
            .room-details-pane { padding: 40px; }
            .price-tag-floating { bottom: 20px; right: 20px; padding: 15px 25px; }
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <?php include APP_DIR . '/views/frontend/layouts/navbar.php'; ?>

    <!-- Header Section -->
    <header class="header-section animate__animated animate__fadeIn">
        <div class="container relative" style="z-index: 2;">
            <span class="text-uppercase tracking-widest text-white opacity-75 mb-3 d-block animate__animated animate__fadeInDown small fw-bold"><?= __('our_accommodation') ?></span>
            <h1 class="display-1 fw-extrabold mb-4 animate__animated animate__zoomIn" style="font-family: 'Playfair Display', serif;"><?= __('luxurious_rooms_suites') ?></h1>
            <p class="lead text-white opacity-75 mx-auto animate__animated animate__fadeInUp" style="max-width: 700px; font-weight: 300; letter-spacing: 1px;"><?= __('experience_pinnacle') ?></p>
        </div>
    </header>

    <!-- Room List -->
    <section class="py-5">
        <div class="container py-5">
            <div class="row">
                <?php foreach ($roomTypes as $index => $room): 
                    // Robust image logic: Primary -> First Gallery -> Fallback
                    $imagePath = '';
                    if (!empty($room['image'])) {
                        $imagePath = BASE_URL . '/uploads/room_types/' . $room['image'];
                    } elseif (!empty($room['gallery']) && count($room['gallery']) > 0) {
                        $imagePath = BASE_URL . '/uploads/room_types/' . $room['gallery'][0]['image'];
                    } else {
                        // High-quality fallback if no images are uploaded
                        $fallbackId = ($index % 3) + 1;
                        $imagePath = BASE_URL . '/frontend/img/room' . $fallbackId . '.png';
                    }
                    $delay = ($index % 3) * 0.2;
                ?>
                <div class="col-12 animate__animated animate__fadeInUp" style="animation-delay: <?= $delay ?>s;">
                    <div class="room-card-premium">
                        <div class="floating-label uppercase"><?= htmlspecialchars($room['name']) ?></div>
                        <div class="row g-0">
                            <!-- Alternate image side -->
                            <div class="col-lg-7 <?= $index % 2 !== 0 ? 'order-lg-2' : '' ?>">
                                <div class="room-img-container">
                                    <span class="premium-badge"><?= __('exclusive') ?></span>
                                    
                                    <!-- Simple Gallery Slider if multiple images exist -->
                                    <div id="roomCarousel<?= $room['id'] ?>" class="carousel slide h-100" data-bs-ride="carousel">
                                        <div class="carousel-inner h-100">
                                            <div class="carousel-item active h-100">
                                                <img src="<?= $imagePath ?>" class="d-block w-100 h-100 object-fit-cover" alt="<?= htmlspecialchars($room['name']) ?>">
                                            </div>
                                            <?php if (!empty($room['gallery'])): ?>
                                                <?php foreach ($room['gallery'] as $galIndex => $galImg): 
                                                    if ($galImg['image'] == $room['image']) continue; // Skip primary
                                                ?>
                                                    <div class="carousel-item h-100">
                                                        <img src="<?= BASE_URL ?>/uploads/room_types/<?= htmlspecialchars($galImg['image']) ?>" class="d-block w-100 h-100 object-fit-cover" alt="<?= htmlspecialchars($room['name']) ?> gallery">
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (!empty($room['gallery']) && count($room['gallery']) > 1): ?>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel<?= $room['id'] ?>" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel<?= $room['id'] ?>" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            </button>
                                        <?php endif; ?>
                                    </div>

                                    <div class="price-tag-floating">
                                        <span class="currency">$</span>
                                        <span class="amount"><?= number_format($room['price'], 0) ?></span>
                                        <span class="currency">/ <?= __('night') ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 <?= $index % 2 !== 0 ? 'order-lg-1' : '' ?>">
                                <div class="room-details-pane h-100">
                                    <div class="heading-decoration"></div>
                                    <h2 class="display-5 fw-extrabold mb-4" style="font-family: 'Playfair Display', serif; color: var(--aura-dark);"><?= htmlspecialchars($room['name']) ?></h2>
                                    <p class="text-muted mb-5 lh-lg" style="font-size: 1.1rem; font-weight: 300;"><?= htmlspecialchars($room['description']) ?></p>
                                    
                                    <div class="row g-4 mb-5">
                                        <div class="col-4">
                                            <div class="amenity-item">
                                                <div class="amenity-icon mb-3"><i class="bi bi-arrows-fullscreen"></i></div>
                                                <div class="small fw-bold text-dark">45 m²</div>
                                                <div class="x-small text-muted text-uppercase tracking-wider"><?= __('area') ?></div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="amenity-item">
                                                <div class="amenity-icon mb-3"><i class="bi bi-people"></i></div>
                                                <div class="small fw-bold text-dark"><?= $room['capacity'] ?? 2 ?> <?= __('adults') ?></div>
                                                <div class="x-small text-muted text-uppercase tracking-wider"><?= __('capacity') ?></div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="amenity-item">
                                                <div class="amenity-icon mb-3"><i class="bi bi-wifi"></i></div>
                                                <div class="small fw-bold text-dark">Gigabit</div>
                                                <div class="x-small text-muted text-uppercase tracking-wider">Wi-Fi</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-3 mt-auto">
                                        <a href="<?= BASE_URL ?>/make-reservation?room_type_id=<?= $room['id'] ?>" class="btn btn-aura">
                                            <?= __('book_now') ?> <i class="bi bi-arrow-right ms-2"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>/room-details?id=<?= $room['id'] ?>" class="btn btn-aura-outline">
                                            <?= __('details') ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include APP_DIR . '/views/frontend/layouts/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
