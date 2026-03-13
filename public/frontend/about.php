<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('about_us') ?> | AURA Luxury Hotel</title>
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
            <span class="heading-sub">Since 1995</span>
            <h1 class="display-3"><?= __('our_story') ?></h1>
            <p class="lead text-muted mx-auto" style="max-width: 800px;"><?= __('story_description') ?></p>
        </div>
    </header>

    <section class="py-5">
        <div class="container py-5">
            <div class="row align-items-center gx-5">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <img src="https://i.pinimg.com/736x/2a/11/2f/2a112f695462f797da807fa7a03b6f39.jpg" class="img-fluid shadow-lg rounded-2" alt="Hotel Lobby">
                </div>
                <div class="col-lg-6">
                    <h2 class="mb-4"><?= __('legacy_elegance') ?></h2>
                    <p class="text-muted mb-4"><?= __('story_description') ?></p>
                    <div class="row g-4 mt-2">
                        <div class="col-sm-6">
                            <h4 class="fw-bold mb-1" style="color: var(--accent-color);">25+</h4>
                            <p class="small text-uppercase tracking-wider text-muted"><?= __('luxury_awards') ?></p>
                        </div>
                        <div class="col-sm-6">
                            <h4 class="fw-bold mb-1" style="color: var(--accent-color);">300+</h4>
                            <p class="small text-uppercase tracking-wider text-muted"><?= __('dedicated_staff') ?></p>
                        </div>
                        <div class="col-sm-6">
                            <h4 class="fw-bold mb-1" style="color: var(--accent-color);">50k+</h4>
                            <p class="small text-uppercase tracking-wider text-muted"><?= __('happy_guests') ?></p>
                        </div>
                        <div class="col-sm-6">
                            <h4 class="fw-bold mb-1" style="color: var(--accent-color);">10</h4>
                            <p class="small text-uppercase tracking-wider text-muted"><?= __('global_locations') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include APP_DIR . '/views/frontend/layouts/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
