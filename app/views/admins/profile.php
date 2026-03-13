<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1 fw-bold text-dark"><?= __('profile_settings') ?></h2>
                    <p class="text-muted small mb-0"><?= __('account_info') ?></p>
                </div>
            </div>

            <div class="row">
                <!-- Profile Overview Card -->
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100 overflow-hidden">
                        <div class="pt-4 pb-3">
                            <div class="avatar-container mx-auto mb-4">
                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($admin['name']) ?>&background=f59e0b&color=fff&size=128"
                                    class="rounded-circle shadow" width="128" height="128">
                                <div class="avatar-badge">
                                    <i class="bi bi-shield-check text-white"></i>
                                </div>
                            </div>
                            <h4 class="fw-bold mb-1"><?= htmlspecialchars($admin['name']) ?></h4>
                            <p class="text-muted small mb-3"><?= htmlspecialchars($admin['email']) ?></p>
                            <span class="badge bg-warning bg-opacity-10 text-warning text-uppercase px-3 py-2 rounded-pill fw-bold small">
                                <?= __($admin['role']) ?>
                            </span>
                        </div>
                        <div class="mt-auto pt-4 border-top border-light">
                            <p class="text-muted small mb-1"><?= __('registered_at') ?></p>
                            <p class="fw-bold mb-0"><?= date('M d, Y', strtotime($admin['created_at'])) ?></p>
                        </div>
                    </div>
                </div>

                <!-- Edit Profile Form -->
                <div class="col-md-8 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                        <div class="card-header bg-white border-bottom-0 py-4 px-4">
                            <h5 class="fw-bold mb-0 d-flex align-items-center gap-2">
                                <i class="bi bi-pencil-square text-primary"></i>
                                <?= __('update_profile') ?>
                            </h5>
                        </div>
                        <div class="card-body px-4 pb-4">
                            <form action="<?= BASE_URL ?>/admins/updateProfile" method="POST" class="ajax-form">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold small text-uppercase text-muted"><?= __('name') ?></label>
                                            <div class="input-group input-group-lg shadow-sm">
                                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-person"></i></span>
                                                <input type="text" name="name" class="form-control border-start-0 ps-0" value="<?= htmlspecialchars($admin['name']) ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold small text-uppercase text-muted"><?= __('email') ?></label>
                                            <div class="input-group input-group-lg shadow-sm">
                                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                                <input type="email" name="email" class="form-control border-start-0 ps-0" value="<?= htmlspecialchars($admin['email']) ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-4">
                                            <label class="form-label fw-bold small text-uppercase text-muted"><?= __('password') ?></label>
                                            <div class="input-group input-group-lg shadow-sm">
                                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                                                <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="<?= __('new_password_info') ?>">
                                            </div>
                                            <div class="form-text text-muted small mt-2">
                                                <i class="bi bi-info-circle me-1"></i> <?= __('new_password_info') ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-3 mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg px-5 py-3 rounded-3 shadow-sm d-flex align-items-center gap-2">
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span class="fw-bold"><?= __('save_changes') ?></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-container {
        position: relative;
        width: 128px;
        height: 128px;
    }

    .avatar-badge {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: #f59e0b;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .ajax-form .form-control:focus {
        background: #fff !important;
        border-color: #f59e0b !important;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1) !important;
    }

    .ajax-form .input-group-text {
        border: 1px solid #dee2e6;
        transition: all 0.2s;
    }

    .ajax-form .form-control:focus+.input-group-text,
    .ajax-form .form-control:focus~.input-group-text {
        border-color: #f59e0b !important;
    }
</style>