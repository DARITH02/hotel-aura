<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('login') ?> - <?= __('hotel_admin_system') ?></title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --gold: #f59e0b;
            --gold-dark: #d97706;
            --dark-bg: #0f172a;
            --glass: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Outfit', sans-serif;
            overflow: hidden;
        }

        .login-wrapper {
            height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('<?= BASE_URL ?>/img/login-bg.png') no-repeat center center;
            background-size: cover;
            position: relative;
        }

        .login-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, rgba(15, 23, 42, 0.4) 0%, rgba(15, 23, 42, 0.9) 100%);
            z-index: 1;
        }

        .login-content {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 450px;
            padding: 20px;
            animation: fadeInUp 0.8s ease-out;
        }

        .login-card {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .login-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
            transform: rotate(-10deg);
            transition: 0.3s;
        }

        .login-logo:hover {
            transform: rotate(0deg) scale(1.1);
        }

        .login-logo i {
            font-size: 2.5rem;
            color: white;
        }

        .login-header h2 {
            color: white;
            font-weight: 700;
            text-align: center;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.5);
            text-align: center;
            font-size: 0.95rem;
            margin-bottom: 32px;
        }

        .form-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .input-group {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border: 1px solid var(--glass-border);
            transition: 0.3s;
            overflow: hidden;
        }

        .input-group:focus-within {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.15);
            background: rgba(255, 255, 255, 0.08);
        }

        .input-group-text {
            background: transparent !important;
            border: none !important;
            color: var(--gold) !important;
            padding-left: 18px;
        }

        .form-control {
            background: transparent !important;
            border: none !important;
            color: white !important;
            padding: 14px 18px 14px 0;
            font-size: 1rem;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.2);
        }

        .form-control:focus {
            box-shadow: none !important;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            border: none;
            color: white;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 0.5px;
            margin-top: 24px;
            transition: 0.3s;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(245, 158, 11, 0.3);
            filter: brightness(1.1);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            margin-top: 32px;
            text-align: center;
            border-top: 1px solid var(--glass-border);
            padding-top: 24px;
        }

        .login-footer a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 600;
            transition: 0.2s;
        }

        .login-footer a:hover {
            color: white;
        }

        .credentials-box {
            background: rgba(245, 158, 11, 0.05);
            border: 1px dashed rgba(245, 158, 11, 0.2);
            border-radius: 12px;
            padding: 12px;
            margin-top: 24px;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="login-content">
            <div class="login-card">
                <div class="login-logo">
                    <i class="bi bi-buildings-fill"></i>
                </div>
                
                <div class="login-header">
                    <h2><?= __('welcome') ?></h2>
                    <p><?= __('hotel_admin_system') ?></p>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-20 text-danger small rounded-3 mb-4 d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div><?= htmlspecialchars($error) ?></div>
                    </div>
                <?php endif; ?>

                <form action="<?= BASE_URL ?>/login/post" method="POST">
                    <div class="mb-4">
                        <label class="form-label"><?= __('email') ?></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="admin@hotel.com" required autofocus>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label"><?= __('password') ?></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login w-100">
                        <?= __('login') ?>
                    </button>
                    
                    <div class="credentials-box">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Admin Access:</span>
                            <code class="text-warning">chandarith002@gmail.com / 00000000</code>
                        </div>
                    </div>
                </form>

                <div class="login-footer">
                    <p class="text-white text-opacity-50 small mb-0">
                        <?= __('dont_have_account') ?> 
                        <a href="<?= BASE_URL ?>/register"><?= __('register') ?></a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
