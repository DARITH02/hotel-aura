<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('register') ?> - <?= __('hotel_admin_system') ?></title>
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
            overflow: auto;
        }

        .login-wrapper {
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('<?= BASE_URL ?>/img/login-bg.png') no-repeat center center;
            background-size: cover;
            position: relative;
            padding: 40px 20px;
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
            max-width: 500px;
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
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
            transform: rotate(-10deg);
        }

        .login-logo i {
            font-size: 2rem;
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
            margin-bottom: 30px;
        }

        .form-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .input-group {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border: 1px solid var(--glass-border);
            transition: 0.3s;
            overflow: hidden;
            margin-bottom: 20px;
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
            padding: 12px 18px 12px 0;
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
            margin-top: 10px;
            transition: 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(245, 158, 11, 0.3);
            filter: brightness(1.1);
        }

        .login-footer {
            margin-top: 30px;
            text-align: center;
            border-top: 1px solid var(--glass-border);
            padding-top: 20px;
        }

        .login-footer a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 600;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="login-content">
            <div class="login-card">
                <div class="login-logo">
                    <i class="bi bi-person-plus-fill"></i>
                </div>
                
                <div class="login-header">
                    <h2><?= __('create_account') ?></h2>
                    <p><?= __('hotel_admin_system') ?></p>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-20 text-danger small rounded-3 mb-4 d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div><?= htmlspecialchars($error) ?></div>
                    </div>
                <?php endif; ?>

                <form action="<?= BASE_URL ?>/register/post" method="POST">
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label"><?= __('name') ?></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form-control" placeholder="<?= __('full_name') ?>" required autofocus>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label"><?= __('email') ?></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="admin@hotel.com" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?= __('password') ?></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?= __('confirm_password') ?></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                                <input type="password" name="confirm_password" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login w-100">
                        <?= __('create_account') ?>
                    </button>
                </form>

                <div class="login-footer">
                    <p class="text-white text-opacity-50 small mb-0">
                        <?= __('already_have_account') ?> 
                        <a href="<?= BASE_URL ?>/login"><?= __('login') ?></a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
