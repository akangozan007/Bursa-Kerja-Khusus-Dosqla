<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BKK DOSQLA</title>
    <style>
        :root {
            --bg-blue: #0257bc;
            --bg-orange: #ff6000;
            --btn-blue: #004ecc;
            --btn-blue-hover: #003db3;
            --text-dark-blue: #042456;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #03142c;
            padding: 20px;
        }

        .login-wrapper {
            display: flex;
            width: 100%;
            max-width: 1050px;
            height: 600px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,0.5);
            position: relative;
        }

        /* --- SISI KIRI (BLUE HERO SECTION) --- */
        .brand-section {
            flex: 1;
            background: var(--bg-blue);
            padding: 45px 50px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            color: #ffffff;
            transition: flex 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            overflow: hidden;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            font-size: 1.1rem;
            letter-spacing: 1px;
            z-index: 5;
        }

        .hero-text {
            z-index: 5;
            margin-bottom: 20px;
        }

        .hero-text .subtitle {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .hero-text h1 {
            font-size: 2.2rem;
            line-height: 1.25;
            color: #ff7426;
            font-weight: 800;
            text-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .hero-text p.smart-control {
            font-size: 2.2rem;
            color: #ffffff;
            font-weight: 800;
        }

        .hero-divider {
            width: 180px;
            height: 3px;
            background: rgba(255, 116, 38, 0.8);
            margin-top: 15px;
            border-radius: 2px;
        }

        /* --- SHAPE MATERIAL BOUNCING ANIMATIONS --- */
        .vec-capsule {
            position: absolute;
            top: -30px;
            left: 230px;
            width: 65px;
            height: 170px;
            background: #0077fd;
            border-radius: 40px;
            z-index: 1;
            animation: bounceCapsule 4s ease-in-out infinite alternate;
        }

        .vec-circle-top {
            position: absolute;
            top: 130px;
            left: 350px;
            width: 22px;
            height: 22px;
            border: 4px solid #ffffff;
            border-radius: 50%;
            z-index: 1;
            animation: bounceCircle 3.5s cubic-bezier(0.45, 0.05, 0.55, 0.95) infinite alternate;
        }

        .vec-grid-top {
            position: absolute;
            top: 160px;
            left: 390px;
            display: grid;
            grid-template-columns: repeat(4, 6px);
            gap: 8px;
            z-index: 1;
            animation: bounceGrid 5s ease-in-out infinite alternate;
        }

        .vec-grid-top div, .vec-grid-bottom div {
            width: 6px;
            height: 6px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
        }

        .vec-large-circle-left {
            position: absolute;
            top: 150px;
            left: -120px;
            width: 320px;
            height: 320px;
            background: rgba(0, 119, 253, 0.45);
            border-radius: 50%;
            z-index: 2;
            animation: bounceLargeCircle 6s ease-in-out infinite alternate;
        }

        .vec-cyan-ball {
            position: absolute;
            bottom: 120px;
            left: 30px;
            width: 60px;
            height: 60px;
            background: #00a5e3;
            border-radius: 50%;
            z-index: 3;
            animation: bounceCyanBall 3s cubic-bezier(0.68, -0.55, 0.265, 1.55) infinite alternate;
        }

        .vec-cross {
            position: absolute;
            bottom: 80px;
            left: 140px;
            color: #ffffff;
            font-size: 24px;
            font-weight: 900;
            z-index: 3;
            animation: bounceCross 4.5s ease-in-out infinite alternate;
        }

        .vec-bottom-ring {
            position: absolute;
            bottom: -100px;
            left: 190px;
            width: 260px;
            height: 260px;
            border: 35px solid #009be3;
            border-radius: 50%;
            z-index: 3;
            animation: bounceBottomRing 5.5s cubic-bezier(0.37, 0, 0.63, 1) infinite alternate;
        }

        .vec-grid-bottom {
            position: absolute;
            bottom: 40px;
            left: 55px;
            display: grid;
            grid-template-columns: repeat(5, 6px);
            gap: 8px;
            z-index: 3;
            animation: bounceGrid 4s ease-in-out infinite alternate-reverse;
        }

        /* --- ANIMASI ROKET & ASTRONOT --- */
        .rocket-container {
            position: absolute;
            width: 60px;
            height: 60px;
            z-index: 4;
            pointer-events: none;
            animation: rocketPath 8s ease-in-out infinite;
        }

        .astronaut-container {
            position: absolute;
            width: 45px;
            height: 45px;
            bottom: 160px;
            right: 40px;
            z-index: 4;
            pointer-events: none;
            animation: astronautFloat 5s ease-in-out infinite alternate;
        }

        /* Keyframes Bouncing Shapes */
        @keyframes bounceCapsule {
            0% { transform: translateY(0) scaleY(1); }
            50% { transform: translateY(25px) scaleY(1.05); }
            100% { transform: translateY(-15px) scaleY(0.95); }
        }

        @keyframes bounceCircle {
            0% { transform: translateY(0) scale(1); }
            100% { transform: translateY(-20px) scale(1.2); }
        }

        @keyframes bounceGrid {
            0% { transform: translate(0, 0); }
            100% { transform: translate(15px, -10px); }
        }

        @keyframes bounceLargeCircle {
            0% { transform: scale(1) translate(0, 0); }
            100% { transform: scale(1.1) translate(15px, 15px); }
        }

        @keyframes bounceCyanBall {
            0% { transform: translate(0, 0); }
            50% { transform: translate(12px, -20px); }
            100% { transform: translate(-10px, 15px); }
        }

        @keyframes bounceCross {
            0% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.3); }
            100% { transform: rotate(360deg) scale(0.9); }
        }

        @keyframes bounceBottomRing {
            0% { transform: translateY(0) rotate(0deg); }
            100% { transform: translateY(-30px) rotate(45deg); }
        }

        /* Keyframe Roket Berkelok-kelok (Infinity S-Curve) */
        @keyframes rocketPath {
            0% {
                transform: translate(20px, 450px) rotate(-20deg);
            }
            25% {
                transform: translate(260px, 320px) rotate(35deg);
            }
            50% {
                transform: translate(120px, 180px) rotate(-30deg);
            }
            75% {
                transform: translate(280px, 50px) rotate(45deg);
            }
            100% {
                transform: translate(20px, 450px) rotate(-20deg);
            }
        }

        /* Keyframe Astronot Terombang-ambing */
        @keyframes astronautFloat {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }
            33% {
                transform: translate(-15px, -25px) rotate(-15deg);
            }
            66% {
                transform: translate(10px, -40px) rotate(20deg);
            }
            100% {
                transform: translate(-5px, -10px) rotate(-5deg);
            }
        }

        /* --- TOGGLE ARROW BUTTON --- */
        .center-arrow-container {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            z-index: 20;
            pointer-events: none;
            transition: left 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .center-arrow-btn {
            pointer-events: auto;
            width: 75px;
            height: 75px;
            background: #ff0044;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            box-shadow: 
                8px 8px 0px #e04a00,
                16px 16px 0px #4d2300,
                20px 20px 30px rgba(0,0,0,0.4);
            transition: all 0.3s ease;
        }

        .center-arrow-btn:hover {
            transform: scale(1.08);
        }

        .center-arrow-btn svg {
            transition: transform 0.5s ease;
        }

        /* --- SISI KANAN (ORANGE FORM SECTION) --- */
        .form-section {
            flex: 1;
            background-color: var(--bg-orange);
            padding: 45px 65px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #ffffff;
            transition: flex 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
        }

        .form-section h2 {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--text-dark-blue);
            margin-bottom: 35px;
        }

        .input-group {
            margin-bottom: 22px;
        }

        .input-group label {
            display: block;
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text-dark-blue);
        }

        .input-wrapper {
            position: relative;
        }

        .input-group input {
            width: 100%;
            padding: 14px 22px;
            border-radius: 50px;
            border: 2px solid rgba(4, 36, 86, 0.25);
            background: rgba(255, 255, 255, 0.2);
            color: var(--text-dark-blue);
            font-weight: 600;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .input-group input::placeholder {
            color: rgba(4, 36, 86, 0.5);
            font-weight: 500;
        }

        .input-group input:focus {
            background: rgba(255, 255, 255, 0.4);
            border-color: var(--text-dark-blue);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .toggle-password {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--text-dark-blue);
            opacity: 0.7;
            user-select: none;
        }

        .form-options {
            margin-bottom: 25px;
        }

        .remember-me {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: var(--text-dark-blue);
            font-weight: 600;
            font-size: 0.88rem;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #ffcc00;
            cursor: pointer;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 50px;
            background: var(--btn-blue);
            color: white;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 0px #003399, 0 12px 20px rgba(0,0,0,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit:hover {
            background: var(--btn-blue-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 0px #003399, 0 15px 25px rgba(0,0,0,0.3);
        }

        .btn-submit:active {
            transform: translateY(4px);
            box-shadow: 0 4px 0px #003399;
        }

        .spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* EXPAND STATE TRIGGER */
        .login-wrapper.expand-left .brand-section { flex: 1.8; }
        .login-wrapper.expand-left .form-section { flex: 0.7; }
        .login-wrapper.expand-left .center-arrow-container { left: 70%; }
        .login-wrapper.expand-left .center-arrow-btn svg { transform: rotate(180deg); }

        @media (max-width: 850px) {
            .login-wrapper { flex-direction: column; height: auto; }
            .center-arrow-container { display: none; }
            .brand-section, .form-section { padding: 40px 30px; }
        }
    </style>
</head>
<body>

<div class="login-wrapper" id="loginWrapper">

    <!-- HERO SECTION (KIRI) -->
    <div class="brand-section">
        <div class="logo-area">
            <svg class="logo-img" viewBox="0 0 24 24" width="35" height="35" fill="none" stroke="#ffcc00" stroke-width="2.5">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
            </svg>
            BKK DOSQLA
        </div>

        <div class="hero-text">
            <div class="subtitle">SISTEM INFORMASI BKK</div>
            <h1>Raih karir impian.</h1>
            <h1>Terhubung lebih cepat</h1>
            <p class="smart-control">Smarter Control.</p>
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

    <!-- TOGGLE BUTTON ARROW -->
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
        <h2>Welcome Back!</h2>

        <form action="<?= BASE_URL; ?>auth/process_login" method="POST" id="loginForm">
            
            <div class="input-group">
                <label for="username">Username/Email</label>
                <div class="input-wrapper">
                    <input type="text" id="username" name="username" placeholder="Enter your email" required autocomplete="off">
                </div>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <span class="toggle-password" onclick="togglePassword()">👁️</span>
                </div>
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember_me"> Remember me
                </label>
            </div>

            <button type="submit" class="btn-submit" id="btnSubmit">
                <span class="spinner" id="btnSpinner"></span>
                <span id="btnText">Login</span>
            </button>
        </form>
    </div>

</div>

<script>
    // Expand / Collapse Panel
    const togglePanelBtn = document.getElementById('togglePanelBtn');
    const loginWrapper = document.getElementById('loginWrapper');

    togglePanelBtn.addEventListener('click', function() {
        loginWrapper.classList.toggle('expand-left');
    });

    // Toggle Password
    function togglePassword() {
        const passInput = document.getElementById('password');
        passInput.type = passInput.type === 'password' ? 'text' : 'password';
    }

    // Submit Animation
    document.getElementById('loginForm').addEventListener('submit', function() {
        const btnSubmit = document.getElementById('btnSubmit');
        document.getElementById('btnSpinner').style.display = 'inline-block';
        document.getElementById('btnText').textContent = 'Logging in...';
        btnSubmit.style.opacity = '0.85';
        btnSubmit.style.pointerEvents = 'none';
    });
</script>

</body>
</html>