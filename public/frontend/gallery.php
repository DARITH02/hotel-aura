<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('gallery') ?> | AURA Luxury Hotel</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@300;400;500;600&family=Kantumruy+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/css/style.css">
    <style>
        .gallery-item {
            position: relative;
            cursor: pointer;
            height: 350px;
            overflow: hidden;
            margin-bottom: 24px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }
        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.7);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: var(--transition);
            backdrop-filter: blur(4px);
        }
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <?php include APP_DIR . '/views/frontend/layouts/navbar.php'; ?>

    <header class="py-5" style="margin-top: 80px; background: var(--background-light);">
        <div class="container py-5 text-center">
            <span class="heading-sub">Visual Stories</span>
            <h1 class="display-3"><?= __('gallery') ?></h1>
            <p class="lead text-muted"><?= __('experience_pinnacle') ?></p>
        </div>
    </header>

    <section class="py-5">
        <div class="container py-4">
            <div class="row g-4">
                <?php if (empty($images)): ?>
                    <div class="col-12 text-center py-5">
                        <p class="text-muted"><?= __('no_images_found') ?></p>
                    </div>
                <?php else: ?>
                    <?php foreach ($images as $img): 
                        $src = (strpos($img['src'], 'http') === 0) ? $img['src'] : BASE_URL . '/uploads/room_types/' . $img['src'];
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="gallery-item" data-bs-toggle="modal" data-bs-target="#galleryModal" onclick="setModalImage('<?= $src ?>')">
                            <img src="<?= $src ?>" alt="<?= $img['title'] ?>">
                            <div class="gallery-overlay">
                                <div class="text-center">
                                    <i class="bi bi-search fs-2 mb-2"></i>
                                    <div class="small fw-bold text-uppercase"><?= $img['title'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Modal Lightbox -->
    <div class="modal fade" id="galleryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0 position-relative text-center">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>
                    <img id="modalImage" src="" class="img-fluid rounded shadow-lg max-vh-90">
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include APP_DIR . '/views/frontend/layouts/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function setModalImage(src) {
            document.getElementById('modalImage').src = src;
        }
    </script>
</body>
</html>
