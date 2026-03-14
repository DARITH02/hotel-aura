<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 – Page Not Found | Hotel AURA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #070d19;
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated background orbs */
        .bg-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            animation: float 8s ease-in-out infinite;
        }
        .bg-orb-1 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, #c9a96e, transparent);
            top: -100px; left: -150px;
            animation-delay: 0s;
        }
        .bg-orb-2 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, #1e40af, transparent);
            bottom: -100px; right: -100px;
            animation-delay: -4s;
        }
        .bg-orb-3 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, #7c3aed, transparent);
            top: 50%; left: 60%;
            animation-delay: -2s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
        }

        /* Gold grid lines */
        .grid-bg {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(201, 169, 110, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(201, 169, 110, 0.04) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        .content-wrapper {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 2rem;
            max-width: 680px;
            width: 100%;
        }

        /* Hotel badge */
        .hotel-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(201, 169, 110, 0.1);
            border: 1px solid rgba(201, 169, 110, 0.3);
            border-radius: 100px;
            padding: 6px 18px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #c9a96e;
            margin-bottom: 2.5rem;
        }
        .hotel-badge i { font-size: 0.8rem; }

        /* The giant 404 */
        .error-number {
            font-size: clamp(120px, 20vw, 200px);
            font-weight: 900;
            line-height: 0.9;
            background: linear-gradient(135deg, #ffffff 0%, #c9a96e 50%, #ffffff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            background-size: 200% 200%;
            animation: shimmer 4s ease-in-out infinite;
            letter-spacing: -8px;
            margin-bottom: 1.5rem;
        }
        @keyframes shimmer {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .divider-line {
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #c9a96e, transparent);
            margin: 0 auto 1.5rem;
        }

        .error-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 1rem;
            letter-spacing: -0.5px;
        }

        .error-desc {
            font-size: 0.95rem;
            color: rgba(255,255,255,0.45);
            line-height: 1.7;
            margin-bottom: 2.5rem;
            font-weight: 400;
        }

        /* URL display */
        .url-display {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 10px 20px;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.4);
            font-family: 'Courier New', monospace;
            margin-bottom: 2.5rem;
            word-break: break-all;
        }
        .url-display i { color: #ef4444; flex-shrink: 0; }

        /* Action buttons */
        .btn-gold {
            background: linear-gradient(135deg, #c9a96e, #a87f45);
            color: #0a0f1e;
            border: none;
            padding: 14px 32px;
            border-radius: 100px;
            font-weight: 800;
            font-size: 0.8rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 10px 30px rgba(201, 169, 110, 0.3);
        }
        .btn-gold:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(201, 169, 110, 0.4);
            color: #0a0f1e;
        }

        .btn-ghost {
            background: rgba(255,255,255,0.05);
            color: rgba(255,255,255,0.7);
            border: 1px solid rgba(255,255,255,0.1);
            padding: 14px 32px;
            border-radius: 100px;
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-ghost:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateY(-3px);
            border-color: rgba(255,255,255,0.2);
        }

        /* Quick nav links */
        .quick-nav {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.06);
        }
        .quick-nav-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.25);
            margin-bottom: 1rem;
        }
        .quick-nav-links {
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .quick-link {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.07);
            color: rgba(255,255,255,0.45);
            padding: 8px 16px;
            border-radius: 100px;
            font-size: 0.72rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .quick-link:hover {
            background: rgba(201, 169, 110, 0.1);
            border-color: rgba(201, 169, 110, 0.3);
            color: #c9a96e;
        }

        /* Floating particles */
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: #c9a96e;
            border-radius: 50%;
            opacity: 0;
            animation: rise 6s ease-in infinite;
        }
        @keyframes rise {
            0% { opacity: 0; transform: translateY(0) scale(0); }
            10% { opacity: 0.6; }
            90% { opacity: 0.1; }
            100% { opacity: 0; transform: translateY(-80vh) scale(1.5); }
        }
    </style>
</head>
<body>

<div class="grid-bg"></div>

<!-- Background orbs -->
<div class="bg-orb bg-orb-1"></div>
<div class="bg-orb bg-orb-2"></div>
<div class="bg-orb bg-orb-3"></div>

<!-- Floating particles -->
<?php for ($i = 0; $i < 12; $i++): 
    $left = rand(5, 95);
    $delay = rand(0, 6000) / 1000;
    $size = rand(2, 5);
?>
<div class="particle" style="left:<?= $left ?>%;bottom:0;width:<?= $size ?>px;height:<?= $size ?>px;animation-delay:<?= $delay ?>s;animation-duration:<?= rand(5,10) ?>s;"></div>
<?php endfor; ?>

<div class="content-wrapper animate__animated animate__fadeInUp">

    <!-- Hotel badge -->
    <div class="hotel-badge">
        <i class="bi bi-gem"></i>
        Hotel AURA · Luxury Collection
    </div>

    <!-- Giant 404 -->
    <div class="error-number">404</div>

    <div class="divider-line"></div>

    <h1 class="error-title">Page Not Found</h1>

    <p class="error-desc">
        The suite you're looking for has checked out.<br>
        This page doesn't exist or may have been moved.
    </p>

    <!-- URL that was requested -->
    <?php if (!empty($url)): ?>
    <div class="url-display">
        <i class="bi bi-x-circle-fill"></i>
        /<?= htmlspecialchars($url) ?>
    </div>
    <?php endif; ?>

    <!-- Action buttons -->
    <div class="d-flex justify-content-center gap-3 flex-wrap">
        <a href="<?= defined('BASE_URL') ? BASE_URL : '/' ?>/" class="btn-gold">
            <i class="bi bi-house-fill"></i>
            Return Home
        </a>
        <a href="javascript:history.back()" class="btn-ghost">
            <i class="bi bi-arrow-left"></i>
            Go Back
        </a>
    </div>

    <!-- Quick nav -->
    <div class="quick-nav">
        <div class="quick-nav-label">Quick Navigation</div>
        <div class="quick-nav-links">
            <a href="<?= defined('BASE_URL') ? BASE_URL : '' ?>/dashboard" class="quick-link">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            <a href="<?= defined('BASE_URL') ? BASE_URL : '' ?>/bookings" class="quick-link">
                <i class="bi bi-calendar-check-fill"></i> Bookings
            </a>
            <a href="<?= defined('BASE_URL') ? BASE_URL : '' ?>/guests" class="quick-link">
                <i class="bi bi-people-fill"></i> Guests
            </a>
            <a href="<?= defined('BASE_URL') ? BASE_URL : '' ?>/rooms" class="quick-link">
                <i class="bi bi-door-open-fill"></i> Rooms
            </a>
            <a href="<?= defined('BASE_URL') ? BASE_URL : '' ?>/login" class="quick-link">
                <i class="bi bi-person-lock"></i> Login
            </a>
        </div>
    </div>

</div>

</body>
</html>
