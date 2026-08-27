<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - BKK DOSQLA</title>
    <!-- Memanggil CSS eksternal utama -->
    <link rel="stylesheet" href="/Bursa-Kerja-Khusus-Dosqla/public/css/login.css">
</head>
<body>

<div class="login-wrapper" id="loginWrapper">

    <!-- HERO SECTION (KIRI) -->
    <div class="brand-section">
        <!-- Logo & Header Brand -->
        <div class="logo-area">
            <img src="/Bursa-Kerja-Khusus-Dosqla/public/img/logo.png" 
                 alt="Logo BKK DOSQLA" 
                 class="logo-img" 
                 style="max-height: 40px; width: auto; display: block;"
                 onerror="this.onerror=null; this.src='https://via.placeholder.com/40?text=LOGO';">
            BKK DOSQLA
        </div>

        <div class="hero-text">
            <div class="subtitle">SISTEM INFORMASI BKK</div>
            <h1>Semua mulai dari</h1>
            <h1>dirimu didetik ini</h1>
            <p class="smart-control">Work in Silence</p>
            <div class="hero-divider"></div>
        </div>

        <!-- VEKTOR ANIMATION SHAPES -->
        <div class="vec-capsule"></div>
        <div class="vec-circle-top"></div>
        <div class="vec-grid-top">
            <div></div><div></div><div></div><div></div>
            <div></div><div></div><div></div><div></div>
        </div>
        <div class="vec-large-circle-left"></div>
        <div class="vec-cyan-ball"></div>
        <div class="vec-cross">✕</div>
        <div class="vec-bottom-ring"></div>
        <div class="vec-grid-bottom">
            <div></div><div></div><div></div><div></div><div></div>
            <div></div><div></div><div></div><div></div><div></div>
        </div>

        <!-- SVG ROKET BERKELOK-KELOK -->
        <div class="rocket-container">
            <svg width="60" height="60" viewBox="0 0 64 64" fill="none">
                <path d="M32 4C20 16 16 32 16 44L32 56L48 44C48 32 44 16 32 4Z" fill="#ff4d4d"/>
                <path d="M32 4C26 16 24 32 24 44L32 50L40 44C40 32 38 16 32 4Z" fill="#e60000"/>
                <circle cx="32" cy="26" r="6" fill="#03142c" stroke="#ffffff" stroke-width="2"/>
                <path d="M16 40L6 48L16 52V40Z" fill="#ff9900"/>
                <path d="M48 40L58 48L48 52V40Z" fill="#ff9900"/>
                <path d="M26 54L32 64L38 54H26Z" fill="#ffcc00"/>
            </svg>
        </div>

        <!-- SVG ASTRONOT TEROMBANG-AMBING -->
        <div class="astronaut-container">
            <svg width="50" height="50" viewBox="0 0 64 64" fill="none">
                <circle cx="32" cy="20" r="14" fill="#ffffff"/>
                <rect x="22" y="14" width="20" height="12" rx="6" fill="#03142c" stroke="#00a5e3" stroke-width="2"/>
                <path d="M18 34C18 30 24 28 32 28C40 28 46 30 46 34V48H18V34Z" fill="#ffffff"/>
                <rect x="26" y="34" width="12" height="8" rx="2" fill="#ff4d4d"/>
                <circle cx="20" cy="48" r="4" fill="#cccccc"/>
                <circle cx="44" cy="48" r="4" fill="#cccccc"/>
            </svg>
        </div>
    </div>

    <!-- TOGGLE BUTTON ARROW (TENGAH) -->
    <div class="center-arrow-container" id="arrowContainer">
        <div class="center-arrow-btn" id="togglePanelBtn" title="Klik untuk memperlebar / memperkecil panel">
            <svg id="arrowIcon" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
        </div>
    </div>

    <!-- FORM SECTION (KANAN) -->
    <div class="form-section">
        <h2>Daftar</h2>

        <!-- Posisikan ini tepat di atas <form action="..."> -->
        <?php if (isset($_SESSION['error'])): ?>
            <div style="background-color: #ff4d4d; color: #fff; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; font-size: 0.9rem;">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div style="background-color: #2ec4b6; color: #fff; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; font-size: 0.9rem;">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <form action="<?= BASE_URL; ?>/auth/process_register" method="POST" id="registerForm">
            
            <div class="input-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <input type="email" id="email" name="email" placeholder="Enter your email" required autocomplete="off">
                </div>
            </div>

            <div class="input-group">
                <label for="username">Username</label>
                <div class="input-wrapper">
                    <input type="text" id="username" name="username" placeholder="Enter your username" required autocomplete="off">
                </div>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <span class="toggle-password" onclick="togglePassword()">👁️</span>
                </div>
            </div>

            <div class="input-group">
                <label for="instansi">Asal Instansi</label>
                <div class="input-wrapper">
                    <input type="text" id="instansi" name="instansi" placeholder="Nama instansi" required>
                </div>
            </div>

            <button type="submit" class="btn-submit" id="btnSubmit">
                <span class="spinner" id="btnSpinner"></span>
                <span id="btnText">Daftar</span>
            </button>

            <div class="login-link" style="text-align: center; margin-top: 15px; font-size: 0.9rem;">
                Sudah punya akun? <a href="<?= BASE_URL; ?>/auth/login" style="color: #ffaa77; font-weight: 700; text-decoration: underline;">Login sekarang</a>
            </div>
        </form>
    </div>

</div>

<!-- SCRIPT UTAMA PERILAKU INTERAKTIF -->
<script type="text/javascript" src="/Bursa-Kerja-Khusus-Dosqla/public/js/login.js"></script>

</body>
</html>