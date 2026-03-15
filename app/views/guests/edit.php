<div class="animate__animated animate__fadeIn px-lg-4">
    <!-- Header Strategy -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-4">
        <div class="d-flex align-items-center gap-3">
            <a href="<?= BASE_URL ?>/guests" class="premium-back-btn">
                <i class="bi bi-chevron-left"></i>
            </a>
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/guests" class="text-decoration-none text-muted small fw-bold text-uppercase tracking-widest"><?= __('guests') ?></a></li>
                        <li class="breadcrumb-item active small fw-bold text-uppercase tracking-widest" aria-current="page"><?= __('edit') ?></li>
                    </ol>
                </nav>
                <h2 class="mb-0 fw-extrabold text-dark tracking-tight d-flex align-items-center gap-3">
                    <?= __('edit') ?> <?= __('guest') ?>: <span class="text-primary-gradient"><?= htmlspecialchars($guest['name']) ?></span>
                    <?php if ($guest['online_book']): ?>
                        <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-25 py-1 px-2 d-flex align-items-center gap-1" style="font-size: 0.65rem; font-weight: 800;" title="<?= __('online_booking') ?>">
                            <i class="bi bi-globe"></i> <?= strtoupper(__('online')) ?>
                        </span>
                    <?php endif; ?>
                </h2>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="premium-card overflow-hidden border-0 shadow-lg">
                <div class="card-body p-4 p-md-5">
                    <form action="<?= BASE_URL ?>/guests/update" method="POST" class="ajax-form">
                        <input type="hidden" name="id" value="<?= $guest['id'] ?>">
                        
                        <!-- 1. Identity Section -->
                        <div class="section-divider mb-5">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="icon-circle bg-primary-gradient shadow-primary-sm">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>
                                    <h5 class="fw-extrabold text-dark mb-0"><?= __('guest_information') ?></h5>
                                    <p class="text-muted x-small fw-bold text-uppercase tracking-widest mb-0 opacity-50">Profile Identity & Verification</p>
                                </div>
                            </div>
                            
                            <div class="luxury-input-group">
                                <label class="luxury-label"><?= __('full_name') ?> *</label>
                                <div class="input-wrapper">
                                    <i class="bi bi-person icon"></i>
                                    <input type="text" name="name" value="<?= htmlspecialchars($guest['name']) ?>" required placeholder="<?= __('guest_name_placeholder') ?>">
                                </div>
                            </div>
                        </div>

                        <!-- 2. Contact Details -->
                        <div class="section-divider mb-5">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="icon-circle bg-gold-gradient shadow-gold-sm">
                                    <i class="bi bi-telephone-fill"></i>
                                </div>
                                <div>
                                    <h5 class="fw-extrabold text-dark mb-0"><?= __('contact_details') ?></h5>
                                    <p class="text-muted x-small fw-bold text-uppercase tracking-widest mb-0 opacity-50">Reach & Communication</p>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="luxury-input-group">
                                        <label class="luxury-label"><?= __('email') ?></label>
                                        <div class="input-wrapper">
                                            <i class="bi bi-envelope icon"></i>
                                            <input type="email" name="email" value="<?= htmlspecialchars($guest['email']) ?>" placeholder="example@aura.com">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="luxury-input-group">
                                        <label class="luxury-label"><?= __('phone') ?></label>
                                        <div class="input-wrapper">
                                            <i class="bi bi-telephone-plus icon"></i>
                                            <input type="text" name="phone" value="<?= htmlspecialchars($guest['phone']) ?>" placeholder="+855 ...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Address Section -->
                        <div class="section-divider mb-5">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="icon-circle bg-dark-gradient shadow-sm">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <div>
                                    <h5 class="fw-extrabold text-dark mb-0"><?= __('address') ?></h5>
                                    <p class="text-muted x-small fw-bold text-uppercase tracking-widest mb-0 opacity-50">Residence & Locality</p>
                                </div>
                            </div>

                            <div class="luxury-input-group mb-0">
                                <label class="luxury-label"><?= __('address') ?></label>
                                <div class="input-wrapper align-items-start">
                                    <i class="bi bi-map icon mt-3"></i>
                                    <textarea name="address" rows="4" placeholder="<?= __('address_placeholder') ?>"><?= htmlspecialchars($guest['address']) ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 pt-4 border-top">
                            <div class="col-sm-4">
                                <a href="<?= BASE_URL ?>/guests" class="btn btn-luxury-secondary w-100 py-3 rounded-4">
                                    <?= __('cancel') ?>
                                </a>
                            </div>
                            <div class="col-sm-8">
                                <button type="submit" class="btn btn-primary-gradient w-100 py-3 rounded-4 shadow-primary fw-extrabold d-flex align-items-center justify-content-center gap-2">
                                    <i class="bi bi-save2-fill"></i>
                                    <?= strtoupper(__('save_changes')) ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="sticky-top" style="top: 2rem;">
                <!-- Profile Summary Card -->
                <div class="premium-card bg-primary-gradient text-white p-5 text-center shadow-lg border-0 overflow-hidden mb-4 rounded-5">
                    <div class="position-relative z-1">
                        <div class="guest-avatar-ultra mx-auto mb-4 bg-white bg-opacity-20 text-white shadow-inner">
                            <?= strtoupper($guest['name'][0]) ?>
                        </div>
                        <h4 class="fw-extrabold mb-1"><?= htmlspecialchars($guest['name']) ?></h4>
                        <p class="text-white text-opacity-75 small mb-0 fw-bold text-uppercase tracking-widest">
                            <?= __('registered') ?>: <span class="text-white"><?= date('d M Y', strtotime($guest['created_at'])) ?></span>
                        </p>
                    </div>
                    <div class="pattern-overlay opacity-20"></div>
                </div>

                <?php if (!empty($guest['telegram_chat_id'])): ?>
                <div class="premium-card bg-info bg-opacity-10 border border-info border-opacity-25 p-4 mb-4 rounded-5">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="icon-circle-sm bg-info text-white shadow-sm">
                            <i class="bi bi-telegram"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-extrabold text-info"><?= __('cloud_linked') ?></h6>
                            <p class="x-small text-info text-opacity-75 fw-bold mb-0">TELEGRAM SYNCED</p>
                        </div>
                    </div>
                    <p class="small text-muted mb-0 line-height-relaxed">This guest has linked their account for instant notifications and smart booking updates from AURA Bot.</p>
                </div>
                <?php endif; ?>

                <div class="premium-card p-4 rounded-5 border-dashed border-2">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-circle-sm bg-light text-primary border shadow-xs">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-extrabold text-dark small">Contact on WhatsApp</h6>
                            <a href="https://wa.me/<?= str_replace(['+',' ','-'], '', $guest['phone']) ?>" target="_blank" class="small text-primary text-decoration-none fw-bold">Open Direct Chat →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* LUXURY THEME ENHANCEMENTS */
.section-divider { position: relative; }
.icon-circle {
    width: 48px; height: 48px; border-radius: 16px; 
    display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: white;
}
.icon-circle-sm {
    width: 36px; height: 36px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center; font-size: 1rem;
}

.bg-primary-gradient { background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%); }
.bg-gold-gradient { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
.bg-dark-gradient { background: linear-gradient(135deg, #1f2937 0%, #111827 100%); }

.text-primary-gradient { 
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    -webkit-background-clip: text; 
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

.shadow-primary-sm { box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
.shadow-gold-sm { box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); }

/* LUXURY INPUT SYSTEM */
.luxury-input-group { position: relative; margin-bottom: 0.5rem; }
.luxury-label {
    font-size: 0.75rem; font-weight: 800; color: #64748b;
    text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 10px; display: block;
}
.input-wrapper {
    display: flex; align-items: center; background: #f8fafc;
    border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 0 18px; transition: all 0.3s;
}
.input-wrapper:focus-within { 
    border-color: #3b82f6; background: white; 
    box-shadow: 0 10px 30px -15px rgba(59, 130, 246, 0.2); 
}
.input-wrapper .icon { color: #94a3b8; font-size: 1.2rem; margin-right: 15px; flex-shrink: 0; }

.input-wrapper input, .input-wrapper textarea {
    border: none !important; background: transparent !important;
    padding: 16px 0 !important; flex: 1; width: 0; min-width: 0;
    font-weight: 700 !important; color: #1e293b !important;
    outline: none !important; box-shadow: none !important; font-size: 0.95rem;
}

/* AVATAR SYSTEM */
.guest-avatar-ultra {
    width: 100px; height: 100px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 2.5rem; font-weight: 800; border: 4px solid rgba(255,255,255,0.2);
}

/* BUTTONS */
.btn-primary-gradient {
    background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
    border: none; color: white; transition: all 0.3s;
}
.btn-primary-gradient:hover {
    transform: translateY(-2px); box-shadow: 0 10px 20px rgba(59, 130, 246, 0.4);
}
.btn-luxury-secondary {
    background: #f1f5f9; color: #64748b; border: none; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.8rem; transition: all 0.2s;
}
.btn-luxury-secondary:hover { background: #e2e8f0; color: #1e293b; }

.line-height-relaxed { line-height: 1.6; }
.tracking-tight { letter-spacing: -0.025em; }
.shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
.border-dashed { border-style: dashed !important; }
</style>
