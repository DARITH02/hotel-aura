<nav class="navbar navbar-expand-lg fixed-top navbar-main animate__animated animate__fadeIn">
    <div class="container">
        <a class="navbar-logo d-flex align-items-center" href="<?= BASE_URL ?>/">
            <span class="fw-extrabold tracking-widest text-uppercase">Aura</span>
            <span class="ms-1 fw-light text-accent opacity-75">Luxury</span>
        </a>
        
        <button class="navbar-toggler border-0 shadow-none px-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <div class="hamburger-icon">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-lg-2">
                <li class="nav-item">
                    <a class="nav-link px-3" href="<?= BASE_URL ?>/"><?= __('home') ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="<?= BASE_URL ?>/about-us"><?= __('about_us') ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="<?= BASE_URL ?>/our-rooms"><?= __('rooms') ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="<?= BASE_URL ?>/our-services"><?= __('services') ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="<?= BASE_URL ?>/luxury-gallery"><?= __('gallery') ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="<?= BASE_URL ?>/contact-us"><?= __('contact') ?></a>
                </li>
                
                <!-- Language Switcher -->
                <li class="nav-item dropdown ms-lg-2">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-1" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-translate fs-5 opacity-75"></i>
                        <span class="small fw-bold"><?= strtoupper($_SESSION['lang']) ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg premium-dropdown animate__animated animate__fadeIn">
                        <li>
                            <a class="dropdown-item d-flex align-items-center justify-content-between py-2 px-3" href="<?= BASE_URL ?>/language/switch?lang=en">
                                <span>English</span>
                                <?php if($_SESSION['lang'] == 'en'): ?><i class="bi bi-check2 text-accent"></i><?php endif; ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center justify-content-between py-2 px-3" href="<?= BASE_URL ?>/language/switch?lang=km">
                                <span>ភាសាខ្មែរ</span>
                                <?php if($_SESSION['lang'] == 'km'): ?><i class="bi bi-check2 text-accent"></i><?php endif; ?>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item ms-lg-4">
                    <a href="<?= BASE_URL ?>/make-reservation" class="btn btn-luxury-nav">
                        <span><?= __('book_now') ?></span>
                        <i class="bi bi-arrow-right-short ms-1"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
.fw-extrabold { font-weight: 800; }
.tracking-widest { letter-spacing: 4px; }
.navbar-logo { transition: all 0.3s ease; }
.navbar-logo:hover { opacity: 0.8; transform: scale(0.98); }

/* Hamburger Menu Icon */
.hamburger-icon {
    width: 25px;
    height: 18px;
    position: relative;
    cursor: pointer;
}
.hamburger-icon span {
    display: block;
    position: absolute;
    height: 2px;
    width: 100%;
    background: white;
    border-radius: 9px;
    opacity: 1;
    left: 0;
    transform: rotate(0deg);
    transition: .25s ease-in-out;
}
.navbar-main.scrolled .hamburger-icon span { background: var(--aura-dark, #0f172a); }
.hamburger-icon span:nth-child(1) { top: 0px; }
.hamburger-icon span:nth-child(2) { top: 7px; }
.hamburger-icon span:nth-child(3) { top: 14px; }

/* Premium Dropdown */
.premium-dropdown {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    margin-top: 15px !important;
    min-width: 140px;
}
.premium-dropdown .dropdown-item {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--aura-dark, #0f172a);
    transition: all 0.2s;
}
.premium-dropdown .dropdown-item:hover {
    background: rgba(197, 160, 89, 0.05);
    color: var(--aura-gold, #c5a059);
}

.btn-luxury-nav {
    background: var(--aura-gold, #c5a059);
    color: white !important;
    border: none;
    padding: 0.7rem 1.8rem;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: flex;
    align-items: center;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0 10px 20px rgba(197, 160, 89, 0.2);
}
.btn-luxury-nav:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(197, 160, 89, 0.3);
    background: #b08d4a;
}
</style>

<script>
window.addEventListener('scroll', function() {
    const nav = document.querySelector('.navbar-main');
    if (window.scrollY > 50) {
        nav.classList.add('scrolled');
    } else {
        nav.classList.remove('scrolled');
    }
});
</script>
