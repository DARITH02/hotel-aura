<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('services') ?> | AURA Luxury Hotel</title>
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

    <header class="py-5" style="margin-top: 80px; background: var(--background-light);">
        <div class="container py-5 text-center">
            <span class="heading-sub"><?= __('exquisite_services') ?></span>
            <h1 class="display-3"><?= __('aura_experience') ?></h1>
            <p class="lead text-muted mx-auto" style="max-width: 800px;"><?= __('experience_pinnacle') ?></p>
        </div>
    </header>

    <section class="py-5">
        <div class="container py-5">
            <div class="row g-5">
                <?php foreach ($services as $service): 
                    $icon = 'bi-gem';
                    if (stripos($service['name'], 'dining') !== false) $icon = 'bi-cup-hot';
                    if (stripos($service['name'], 'pool') !== false) $icon = 'bi-water';
                    if (stripos($service['name'], 'spa') !== false) $icon = 'bi-gem';
                    if (stripos($service['name'], 'car') !== false || stripos($service['name'], 'trans') !== false) $icon = 'bi-car-front';
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card shadow-sm h-100 p-5">
                        <div class="service-icon mb-4"><i class="bi <?= $icon ?>"></i></div>
                        <h3><?= $service['name'] ?></h3>
                        <p class="text-muted"><?= $service['description'] ?></p>
                        <div class="fw-bold text-accent">$<?= number_format($service['price'], 2) ?></div>
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
