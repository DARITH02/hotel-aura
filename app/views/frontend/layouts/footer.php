<footer class="footer-main py-5 mt-5">
    <div class="container py-4">
        <div class="row g-5">
            <div class="col-lg-4">
                <a href="<?= BASE_URL ?>/" class="footer-logo animate__animated animate__fadeIn" style="text-decoration: none; color: white; font-family: 'Playfair Display', serif; font-size: 2.2rem; font-weight: 800;">
                    <span class="text-uppercase tracking-widest">Aura</span><span class="fw-light opacity-50 ms-1">Luxury</span>
                </a>
                <p class="mb-4 mt-3 opacity-75 fw-light leading-relaxed"><?= __('experience_pinnacle') ?></p>
                <div class="d-flex gap-2">
                    <a href="#" class="social-btn"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-telegram"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
            <div class="col-lg-2">
                <h6 class="footer-title fw-bold text-uppercase small tracking-widest mb-4 opacity-50"><?= __('navigation') ?></h6>
                <ul class="list-unstyled">
                    <li class="mb-3"><a href="<?= BASE_URL ?>/" class="footer-link-premium"><?= __('home') ?></a></li>
                    <li class="mb-3"><a href="<?= BASE_URL ?>/about-us" class="footer-link-premium"><?= __('about_us') ?></a></li>
                    <li class="mb-3"><a href="<?= BASE_URL ?>/our-rooms" class="footer-link-premium"><?= __('rooms') ?></a></li>
                    <li class="mb-3"><a href="<?= BASE_URL ?>/our-services" class="footer-link-premium"><?= __('services') ?></a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h6 class="footer-title fw-bold text-uppercase small tracking-widest mb-4 opacity-50"><?= __('contact_us') ?></h6>
                <div class="d-flex mb-3">
                    <i class="bi bi-geo-alt me-3 text-accent"></i>
                    <span class="small opacity-75">123 Luxury Blvd, Paradise City, PC 54321</span>
                </div>
                <div class="d-flex mb-3">
                    <i class="bi bi-telephone me-3 text-accent"></i>
                    <span class="small opacity-75">+1 (234) 567-890</span>
                </div>
                <div class="d-flex mb-3">
                    <i class="bi bi-envelope me-3 text-accent"></i>
                    <span class="small opacity-75">info@aura-hotel.com</span>
                </div>
            </div>
            <div class="col-lg-3">
                <h6 class="footer-title fw-bold text-uppercase small tracking-widest mb-4 opacity-50"><?= __('newsletter') ?></h6>
                <p class="small mb-4 opacity-75"><?= __('newsletter_desc') ?></p>
                <div class="newsletter-box">
                    <input type="email" placeholder="<?= __('email_address') ?>">
                    <button><i class="bi bi-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <hr class="my-5 border-white border-opacity-10">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <div class="text-center small text-white text-opacity-50">
                &copy; <?= date('Y') ?> AURA Luxury Hotels. <?= __('all_rights_reserved') ?>
            </div>
            <div class="d-flex gap-4 small text-white text-opacity-25">
                <a href="#" class="text-reset text-decoration-none hover-white">Privacy Policy</a>
                <a href="#" class="text-reset text-decoration-none hover-white">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<style>
.social-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    transition: all 0.3s ease;
    text-decoration: none;
    border: 1px solid rgba(255,255,255,0.1);
}
.social-btn:hover {
    background: var(--aura-gold, #c5a059);
    color: white;
    transform: translateY(-5px);
}
.footer-link-premium {
    color: rgba(255,255,255,0.6);
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}
.footer-link-premium:hover {
    color: var(--aura-gold, #c5a059);
    padding-left: 5px;
}
.newsletter-box {
    display: flex;
    background: rgba(255,255,255,0.05);
    border-radius: 12px;
    padding: 5px;
    border: 1px solid rgba(255,255,255,0.1);
}
.newsletter-box input {
    background: transparent;
    border: none;
    padding: 0 15px;
    color: white;
    flex: 1;
    font-size: 0.85rem;
}
.newsletter-box input:focus { outline: none; }
.newsletter-box button {
    background: var(--aura-gold, #c5a059);
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    transition: all 0.3s;
}
.newsletter-box button:hover { background: #b08d4a; transform: scale(1.05); }
.hover-white:hover { color: white !important; }
</style>
