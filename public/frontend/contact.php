<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('contact') ?> | AURA Luxury Hotel</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@300;400;500;600&family=Kantumruy+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/css/style.css">
</head>
<body class="bg-light">

    <!-- Navigation -->
    <?php include APP_DIR . '/views/frontend/layouts/navbar.php'; ?>

    <div class="container py-5" style="margin-top: 100px;">
        <div class="row g-5">
            <div class="col-lg-6">
                <div class="bg-white p-5 shadow-sm h-100 rounded-3">
                    <span class="heading-sub"><?= __('contact_us') ?></span>
                    <h2 class="display-5 mb-4">Contact AURA</h2>
                    <p class="text-muted mb-5"><?= __('newsletter_desc') ?></p>
                    
                    <div class="d-flex mb-4">
                        <div class="icon-box bg-light p-3 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="bi bi-geo-alt text-warning"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Our Location</h6>
                            <p class="text-muted small">123 Luxury Blvd, Paradise City, PC 54321</p>
                        </div>
                    </div>
                    
                    <div class="d-flex mb-4">
                        <div class="icon-box bg-light p-3 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="bi bi-telephone text-warning"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Call Us</h6>
                            <p class="text-muted small">+1 (234) 567-890</p>
                        </div>
                    </div>
                    
                    <div class="d-flex">
                        <div class="icon-box bg-light p-3 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="bi bi-envelope text-warning"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Email Us</h6>
                            <p class="text-muted small">info@aura-hotel.com</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="bg-white p-5 shadow-sm rounded-3">
                    <h3 class="mb-4">Send a Message</h3>
                    <form action="#">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted"><?= __('full_name') ?></label>
                                <input type="text" class="form-control rounded-1 py-2" placeholder="John Doe">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted"><?= __('email_address') ?></label>
                                <input type="email" class="form-control rounded-1 py-2" placeholder="john@example.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted"><?= __('subject') ?></label>
                                <input type="text" class="form-control rounded-1 py-2" placeholder="Reservation Inquiry">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted"><?= __('message') ?></label>
                                <textarea class="form-control rounded-1" rows="5" placeholder="How can we help you?"></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-book-now w-100 py-3"><?= __('send_message') ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Google Map Placeholder -->
        <div class="mt-5 bg-white p-2 shadow-sm rounded-3 overflow-hidden">
            <div style="height: 450px; width: 100%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #64748b;">
                <div class="text-center">
                    <i class="bi bi-map display-4 mb-2"></i>
                    <p class="small fw-bold text-uppercase">Map Integration Placeholder</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include APP_DIR . '/views/frontend/layouts/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
