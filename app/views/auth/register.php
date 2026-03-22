<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('register') ?> - <?= __('hotel_admin_system') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --gold: #f59e0b;
            --gold-dark: #d97706;
            --dark-bg: #0f172a;
            --glass-border: rgba(255,255,255,0.1);
        }
        *, *::before, *::after { box-sizing: border-box; }
        body, html { height: 100%; margin: 0; font-family: 'Outfit', sans-serif; overflow: auto; }

        .login-wrapper {
            min-height: 100vh; width: 100%;
            display: flex; align-items: center; justify-content: center;
            background: url('<?= BASE_URL ?>/img/login-bg.png') no-repeat center center;
            background-size: cover; position: relative; padding: 40px 20px;
        }
        .login-wrapper::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(circle at center, rgba(15,23,42,0.4) 0%, rgba(15,23,42,0.95) 100%);
            z-index: 1;
        }
        .login-content {
            position: relative; z-index: 2; width: 100%; max-width: 520px;
            animation: fadeInUp 0.7s ease-out;
        }
        .login-card {
            background: rgba(15,23,42,0.75);
            backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--glass-border);
            border-radius: 28px; padding: 44px 40px;
            box-shadow: 0 32px 64px -16px rgba(0,0,0,0.6);
        }

        /* Logo */
        .login-logo {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            border-radius: 20px; display: flex; align-items: center; justify-content: center;
            margin: 0 auto 22px; box-shadow: 0 12px 28px rgba(245,158,11,0.35);
            transform: rotate(-8deg);
        }
        .login-logo i { font-size: 2rem; color: white; }

        .login-header h2 {
            color: white; font-weight: 800; text-align: center;
            letter-spacing: -0.5px; margin-bottom: 6px; font-size: 1.7rem;
        }
        .login-header p { color: rgba(255,255,255,0.45); text-align: center; font-size: 0.88rem; margin-bottom: 32px; }

        /* Alert */
        .auth-alert {
            background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25);
            border-radius: 14px; color: #fca5a5; padding: 12px 16px;
            font-size: 0.83rem; display: flex; align-items: center; gap: 8px; margin-bottom: 24px;
        }

        /* Labels */
        .field-label {
            color: rgba(255,255,255,0.55); font-size: 0.72rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.12em; margin-bottom: 8px; display: block;
        }

        /* Input groups */
        .auth-input-group {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px; overflow: hidden;
            display: flex; align-items: center;
            transition: all 0.3s; margin-bottom: 20px;
            position: relative;
        }
        .auth-input-group:focus-within {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(245,158,11,0.15);
            background: rgba(255,255,255,0.08);
        }
        .auth-input-group .prefix {
            padding: 0 16px; color: var(--gold); font-size: 1rem; flex-shrink: 0;
        }
        .auth-input-group input {
            background: transparent; border: none; color: white;
            padding: 13px 16px 13px 0; font-size: 0.95rem; flex: 1; outline: none;
            font-family: 'Outfit', sans-serif; font-weight: 500;
        }
        .auth-input-group input::placeholder { color: rgba(255,255,255,0.2); }
        .auth-input-group.mb-0 { margin-bottom: 0; }

        .password-toggle {
            padding: 0 16px;
            color: rgba(255,255,255,0.25);
            cursor: pointer;
            transition: all 0.2s;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
        }
        .password-toggle:hover { color: var(--gold); transform: scale(1.1); }

        /* Strength Indicator */
        .strength-p-wrapper { height: 4px; background: rgba(255,255,255,0.05); border-radius: 2px; overflow: hidden; margin: 8px 0; }
        .strength-p-bar { height: 100%; width: 0%; transition: all 0.4s ease; border-radius: 2px; }
        .strength-label { font-size: 0.65rem; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.5px; }

        /* ── ROLE SELECTOR CARDS ───────────── */
        .role-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 24px; }

        .role-card {
            position: relative; cursor: pointer;
            background: rgba(255,255,255,0.04);
            border: 1.5px solid rgba(255,255,255,0.1);
            border-radius: 16px; padding: 18px 14px;
            text-align: center; transition: all 0.25s ease;
            user-select: none; display: block;
        }
        .role-card:hover { background: rgba(255,255,255,0.07); border-color: rgba(255,255,255,0.2); }

        .role-card.selected-admin {
            background: rgba(30,41,59,0.6);
            border-color: rgba(148,163,184,0.6);
            box-shadow: 0 0 0 3px rgba(100,116,139,0.2);
        }
        .role-card.selected-super {
            background: rgba(220,38,38,0.12);
            border-color: rgba(220,38,38,0.5);
            box-shadow: 0 0 0 3px rgba(220,38,38,0.15);
        }
        .role-card input[type="radio"] { position: absolute; opacity: 0; pointer-events: none; }

        .role-icon {
            width: 46px; height: 46px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; margin: 0 auto 10px; transition: all 0.25s;
        }
        .role-icon-admin { background: rgba(100,116,139,0.15); color: #94a3b8; }
        .role-icon-super { background: rgba(220,38,38,0.15); color: #f87171; }
        .selected-admin .role-icon-admin { background: rgba(148,163,184,0.25); color: white; }
        .selected-super .role-icon-super { background: rgba(220,38,38,0.3); color: #fca5a5; }

        .role-title {
            font-size: 0.82rem; font-weight: 800;
            letter-spacing: 0.05em; text-transform: uppercase;
        }
        .role-admin-card .role-title { color: #94a3b8; }
        .role-super-card .role-title { color: #f87171; }
        .selected-admin .role-title { color: white; }
        .selected-super .role-title { color: #fca5a5; }

        .role-desc { font-size: 0.68rem; color: rgba(255,255,255,0.3); margin-top: 4px; line-height: 1.4; }
        .selected-admin .role-desc, .selected-super .role-desc { color: rgba(255,255,255,0.5); }

        .role-check {
            position: absolute; top: 10px; right: 10px;
            width: 18px; height: 18px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.6rem; opacity: 0; transition: opacity 0.2s;
        }
        .selected-admin .role-check { background: #475569; color: white; opacity: 1; }
        .selected-super .role-check { background: #dc2626; color: white; opacity: 1; }

        /* Submit */
        .btn-register {
            width: 100%; padding: 15px;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            border: none; border-radius: 14px; color: white;
            font-weight: 800; font-size: 0.95rem; letter-spacing: 0.05em;
            text-transform: uppercase; cursor: pointer; transition: all 0.3s; margin-top: 4px;
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 20px 28px -8px rgba(245,158,11,0.35); filter: brightness(1.08); }
        .btn-register:disabled { opacity: 0.7; cursor: not-allowed; }

        .spinner-border { width: 1.1rem; height: 1.1rem; border-width: 0.15em; display: none; }

        .login-footer {
            margin-top: 28px; text-align: center;
            border-top: 1px solid var(--glass-border); padding-top: 20px;
        }
        .login-footer p { color: rgba(255,255,255,0.4); font-size: 0.85rem; margin: 0; }
        .login-footer a { color: var(--gold); text-decoration: none; font-weight: 700; }
        .login-footer a:hover { text-decoration: underline; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(28px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
<div class="login-wrapper">
    <div class="login-content">
        <div class="login-card">

            <div class="login-logo">
                <i class="bi bi-shield-lock-fill"></i>
            </div>

            <div class="login-header">
                <h2><?= __('create_account') ?></h2>
                <p><?= __('hotel_admin_system') ?> &middot; System Access Setup</p>
            </div>

            <div id="alert-container">
                <?php if (!empty($error)): ?>
                <div class="auth-alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div><?= htmlspecialchars($error) ?></div>
                </div>
                <?php endif; ?>
            </div>

            <form action="<?= BASE_URL ?>/register/post" method="POST" id="register-form">

                <label class="field-label"><?= __('name') ?></label>
                <div class="auth-input-group">
                    <span class="prefix"><i class="bi bi-person-fill"></i></span>
                    <input type="text" name="name" placeholder="<?= __('full_name') ?>" required autofocus>
                </div>

                <label class="field-label"><?= __('email') ?></label>
                <div class="auth-input-group">
                    <span class="prefix"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" name="email" placeholder="admin@hotel-aura.com" required>
                </div>

                <div class="row g-3">
                    <div class="col-6">
                        <label class="field-label"><?= __('password') ?></label>
                        <div class="auth-input-group mb-0">
                            <span class="prefix"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" name="password" id="password" placeholder="••••••••" required onkeyup="checkStrength(this.value)">
                            <span class="password-toggle" onclick="togglePass('password', this)"><i class="bi bi-eye-slash-fill"></i></span>
                        </div>
                        <div class="strength-p-wrapper">
                            <div class="strength-p-bar" id="strength-bar"></div>
                        </div>
                        <div id="strength-text" class="strength-label">Security check...</div>
                    </div>
                    <div class="col-6">
                        <label class="field-label"><?= __('confirm_password') ?></label>
                        <div class="auth-input-group mb-0">
                            <span class="prefix"><i class="bi bi-shield-check"></i></span>
                            <input type="password" name="confirm_password" id="confirm_password" placeholder="••••••••" required>
                            <span class="password-toggle" onclick="togglePass('confirm_password', this)"><i class="bi bi-eye-slash-fill"></i></span>
                        </div>
                    </div>
                </div>

                <div class="mb-4"></div>

                <!-- Role cards -->
                <label class="field-label"><i class="bi bi-person-badge-fill me-1"></i><?= __('role') ?> *</label>
                <div class="role-grid">

                    <label class="role-card role-admin-card selected-admin" id="card-admin" for="role-admin">
                        <input type="radio" name="role" id="role-admin" value="admin" checked>
                        <div class="role-check"><i class="bi bi-check2"></i></div>
                        <div class="role-icon role-icon-admin"><i class="bi bi-person-badge-fill"></i></div>
                        <div class="role-title">Admin</div>
                        <div class="role-desc">Standard access, manage day-to-day hotel operations</div>
                    </label>

                    <label class="role-card role-super-card" id="card-super" for="role-super">
                        <input type="radio" name="role" id="role-super" value="super_admin">
                        <div class="role-check"><i class="bi bi-check2"></i></div>
                        <div class="role-icon role-icon-super"><i class="bi bi-shield-fill-check"></i></div>
                        <div class="role-title">Super Admin</div>
                        <div class="role-desc">Full access &mdash; Requires Access Key</div>
                    </label>

                </div>

                <!-- ── ACCESS KEY FIELD (Hidden initially) ───────────── -->
                <div id="access-key-wrapper" style="display: none;">
                    <label class="field-label" style="color:#f87171;">
                        <i class="bi bi-key-fill me-1"></i> MASTER ACCESS KEY *
                    </label>
                    <div class="auth-input-group" style="border-color: rgba(220,38,38,0.25);">
                        <span class="prefix" style="color:#f87171;"><i class="bi bi-shield-lock"></i></span>
                        <input type="password" name="access_key" id="access_key_input" placeholder="Enter System Master Key">
                    </div>
                </div>

                <button type="submit" class="btn-register" id="btn-submit">
                    <div class="spinner-border text-light" role="status" id="spinner"></div>
                    <span id="btn-text">
                        <i class="bi bi-person-plus-fill me-2"></i>
                        <?= __('create_account') ?>
                    </span>
                </button>

            </form>

            <div class="login-footer">
                <p><?= __('already_have_account') ?> <a href="<?= BASE_URL ?>/login"><?= __('login') ?></a></p>
            </div>

        </div>
    </div>
</div>

<script>
document.querySelectorAll('.role-card').forEach(function(card) {
    card.addEventListener('click', function() {
        const role = this.querySelector('input[type="radio"]')?.value;
        if (!role) return;

        const cardAdmin = document.getElementById('card-admin');
        const cardSuper = document.getElementById('card-super') || this;
        const accessKeyWrapper = document.getElementById('access-key-wrapper');
        const accessKeyInput = document.getElementById('access_key_input');

        cardAdmin.classList.remove('selected-admin', 'selected-super');
        cardSuper.classList.remove('selected-admin', 'selected-super');

        if (role === 'admin') {
            cardAdmin.classList.add('selected-admin');
            accessKeyWrapper.style.display = 'none';
            accessKeyInput.removeAttribute('required');
        } else if (role === 'super_admin') {
            cardSuper.classList.add('selected-super');
            accessKeyWrapper.style.display = 'block';
            accessKeyInput.setAttribute('required', 'required');
            accessKeyInput.focus();
        }
    });
});

function togglePass(id, el) {
    const input = document.getElementById(id);
    const icon = el.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
    }
}

function checkStrength(password) {
    const bar = document.getElementById('strength-bar');
    const text = document.getElementById('strength-text');
    let strength = 0;
    
    if (password.length > 0) strength += 20; // Base strength if text present
    if (password.length >= 8) strength += 20;
    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 20;
    if (password.match(/\d/)) strength += 20;
    if (password.match(/[^a-zA-Z\d]/)) strength += 20;

    bar.style.width = strength + '%';
    
    if (password.length === 0) {
        bar.style.width = '0%';
        bar.style.background = 'transparent';
        text.innerText = 'Enter your password';
        text.style.color = 'rgba(255,255,255,0.4)';
    } else if (strength <= 20) {
        bar.style.background = '#f87171';
        text.innerText = 'Weak';
        text.style.color = '#f87171';
    } else if (strength <= 40) {
        bar.style.background = '#f59e0b';
        text.innerText = 'Fair';
        text.style.color = '#f59e0b';
    } else if (strength <= 60) {
        bar.style.background = '#60a5fa';
        text.innerText = 'Good';
        text.style.color = '#60a5fa';
    } else if (strength <= 80) {
        bar.style.background = '#a78bfa';
        text.innerText = 'Strong';
        text.style.color = '#a78bfa';
    } else {
        bar.style.background = '#34d399';
        text.innerText = 'Very Secure';
        text.style.color = '#34d399';
    }
}

// ── AJAX REGISTRATION ──────────────────────────
const registerForm = document.getElementById('register-form');
const btnSubmit = document.getElementById('btn-submit');
const btnText = document.getElementById('btn-text');
const spinner = document.getElementById('spinner');
const alertContainer = document.getElementById('alert-container');

if (registerForm) {
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        btnSubmit.disabled = true;
        btnText.style.opacity = '0.5';
        spinner.style.display = 'block';
        alertContainer.innerHTML = '';

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect || '<?= BASE_URL ?>/dashboard';
            } else {
                alertContainer.innerHTML = `
                    <div class="auth-alert">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>${data.message || 'Registration failed.'}</div>
                    </div>
                `;
                btnSubmit.disabled = false;
                btnText.style.opacity = '1';
                spinner.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alertContainer.innerHTML = `
                <div class="auth-alert">
                    <i class="bi bi-bug-fill"></i>
                    <div>Connection error. Please try again.</div>
                </div>
            `;
            btnSubmit.disabled = false;
            btnText.style.opacity = '1';
            spinner.style.display = 'none';
        });
    });
}
</script>
</body>
</html>
