<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $room['name'] ?> | AURA Luxury Hotel</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@300;400;500;600&family=Kantumruy+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/css/style.css">
</head>
<body>

    <!-- Navigation -->
    <?php include APP_DIR . '/views/frontend/layouts/navbar.php'; ?>

    <!-- Room Details Content -->
    <div class="container py-5" style="margin-top: 100px;">
        <div class="row g-5">
            <!-- Left Side: Images & Info -->
            <div class="col-lg-8">
                <!-- Main Gallery Image -->
                <?php $mainImg = !empty($room['image']) ? BASE_URL . '/uploads/room_types/' . $room['image'] : BASE_URL . '/frontend/img/room1.png'; ?>
                <div class="mb-4 shadow-sm rounded-3 overflow-hidden" style="height: 500px;">
                    <img src="<?= $mainImg ?>" class="w-100 h-100 object-fit-cover" alt="<?= $room['name'] ?>">
                </div>
                
                <div class="row g-3 mb-5">
                    <?php foreach (array_slice($gallery, 0, 3) as $img): ?>
                    <div class="col-4">
                        <img src="<?= BASE_URL ?>/uploads/room_types/<?= $img['image'] ?>" class="img-fluid shadow-sm rounded-2 object-fit-cover" style="height: 150px; width: 100%;" alt="Room View">
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="bg-white p-5 shadow-sm rounded-3">
                    <span class="heading-sub"><?= __('experience_comfort') ?></span>
                    <h2 class="display-5 mb-4"><?= $room['name'] ?></h2>
                    <p class="text-muted fs-5 mb-5"><?= $room['description'] ?></p>
                    
                    <h4 class="mb-4"><?= __('room_amenities') ?></h4>
                    <div class="row g-4 mb-5">
                        <div class="col-md-4 col-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-wifi text-warning me-2 fs-5"></i>
                                <span class="small fw-bold">Free High-Speed Wifi</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-tv text-warning me-2 fs-5"></i>
                                <span class="small fw-bold">4K Smart TV</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-cup-hot text-warning me-2 fs-5"></i>
                                <span class="small fw-bold">Nespresso Machine</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-safe text-warning me-2 fs-5"></i>
                                <span class="small fw-bold">Laptop Safe</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-thermometer-half text-warning me-2 fs-5"></i>
                                <span class="small fw-bold">Climate Control</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-water text-warning me-2 fs-5"></i>
                                <span class="small fw-bold">Rain Shower</span>
                            </div>
                        </div>
                    </div>
                    
                    <h4 class="mb-4"><?= __('general_policies') ?></h4>
                    <ul class="list-unstyled text-muted small">
                        <li class="mb-2"><i class="bi bi-info-circle me-2"></i> Check-in: 2:00 PM</li>
                        <li class="mb-2"><i class="bi bi-info-circle me-2"></i> Check-out: 11:00 AM</li>
                        <li class="mb-2"><i class="bi bi-info-circle me-2"></i> No smoking allowed in rooms.</li>
                    </ul>
                </div>
            </div>

            <!-- Right Side: Booking Widget -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 120px;">
                    <div class="bg-primary text-white p-5 shadow-lg mb-4 text-center rounded-3">
                        <span class="small text-uppercase tracking-wider opacity-75"><?= __('from') ?></span>
                        <div class="display-4 fw-bold mb-4">$<?= number_format($room['price'], 0) ?><small class="fs-6 opacity-50">/<?= __('night') ?></small></div>
                        <a href="<?= BASE_URL ?>/make-reservation?room_type_id=<?= $room['id'] ?>" class="btn btn-warning w-100 py-3 fw-bold rounded-1 uppercase"><?= __('check_availability') ?></a>
                    </div>
                    
                    <div class="bg-white p-4 shadow-sm rounded-3">
                        <h6 class="fw-bold mb-3 border-bottom pb-2">Why Book Direct?</h6>
                        <ul class="list-unstyled mb-0 small text-muted">
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i> Guaranteed Lowest Price</li>
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i> Free Room Upgrade</li>
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i> Welcome Drink</li>
                            <li><i class="bi bi-check2 text-success me-2"></i> Late Check-out</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include APP_DIR . '/views/frontend/layouts/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
