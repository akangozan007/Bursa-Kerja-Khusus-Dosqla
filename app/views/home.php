<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title']; ?></title>
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --accent-orange: #f26522;
            --accent-orange-hover: #d94e0d;
            --bg-blue-dark: #082c6d;
            --overlay-blue: rgba(8, 44, 109, 0.88);
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background-color: var(--bg-blue-dark);
            color: #fff;
        }

        /* ----- 1. ADVANCED INFINITY LOADER ----- */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: #051d49;
            z-index: 999999;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }

        .infinity-loader {
            width: 120px;
            height: 60px;
        }

        .infinity-path {
            fill: none;
            stroke-width: 6;
            stroke-dasharray: 200;
            stroke-dashoffset: 400;
            animation: dash 2s linear infinite;
        }

        @keyframes dash {
            0% { stroke-dashoffset: 400; }
            100% { stroke-dashoffset: 0; }
        }

        .loader-text {
            margin-top: 15px;
            font-weight: 700;
            letter-spacing: 2px;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
            text-transform: uppercase;
            animation: pulseText 1.5s ease-in-out infinite alternate;
        }

        @keyframes pulseText {
            0% { opacity: 0.4; transform: scale(0.98); }
            100% { opacity: 1; transform: scale(1); }
        }

        /* ----- HERO SECTION WITH BLENDED BACKGROUND ----- */
        .hero-wrapper {
            position: relative;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: 
                linear-gradient(135deg, rgba(8, 44, 109, 0.92) 0%, rgba(11, 94, 215, 0.75) 100%),
                url('<?= defined("BASEURL") ? BASEURL : ""; ?>public/img/dosqla.jpg') center/cover no-repeat fixed;
            overflow: hidden;
        }

        /* ----- 2. FIX NAV MENU & EFEK TIMBUL ----- */
        .navbar-brand-text {
            font-weight: 800;
            font-size: 1.6rem;
            color: var(--accent-orange) !important;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
        }

        .nav-menu-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            padding: 4px;
        }

        .nav-active-bg {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: linear-gradient(145deg, #ff712b, #d95316);
            border-radius: 50px;
            box-shadow: 0 6px 18px rgba(242, 101, 34, 0.6), inset 0 1px 1px rgba(255,255,255,0.4);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            pointer-events: none;
            z-index: 1;
            opacity: 0;
        }

        .nav-link-custom {
            position: relative !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            padding: 10px 24px !important;
            border-radius: 50px;
            display: inline-block !important;
            z-index: 100 !important;
            opacity: 1 !important;
            visibility: visible !important;
            transition: transform 0.2s cubic-bezier(0.25, 0.8, 0.25, 1), text-shadow 0.2s ease;
            text-shadow: 
                0px 2px 4px rgba(0, 0, 0, 0.9),
                0px -1px 1px rgba(255, 255, 255, 0.7);
        }

        .nav-link-custom:hover {
            transform: translateY(-3px);
            color: #ffffff !important;
            text-shadow: 
                0px 5px 8px rgba(0, 0, 0, 0.95),
                0px -1px 2px rgba(255, 255, 255, 0.9);
        }

        .nav-link-custom:active {
            transform: translateY(2px) scale(0.96);
            text-shadow: 
                0px 1px 1px rgba(0, 0, 0, 0.8),
                0px 0px 1px rgba(255, 255, 255, 0.3);
        }

        /* ----- EFEK AIR TEROMBANG-AMBING PER HURUF ----- */
        .wave-char {
            display: inline-block;
            animation: waterWave 3s ease-in-out infinite alternate;
            will-change: transform;
        }

        @keyframes waterWave {
            0% {
                transform: translateY(0px) rotate(0deg) scale(1);
            }
            33% {
                transform: translateY(-4px) rotate(-1.5deg) scale(1.02);
            }
            66% {
                transform: translateY(3px) rotate(1.5deg) scale(0.98);
            }
            100% {
                transform: translateY(-2px) rotate(-0.8deg) scale(1.01);
            }
        }

        /* ----- EFEK GELEMBUNG AIR HALUS DILAYAR ----- */
        #bubbles-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 2;
            overflow: hidden;
        }

        .bubble {
            position: absolute;
            bottom: -20px;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.1));
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            box-shadow: inset 0 0 4px rgba(255, 255, 255, 0.6);
            animation: riseBubble linear infinite;
        }

        @keyframes riseBubble {
            0% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }
            10% {
                opacity: 0.7;
            }
            50% {
                transform: translateY(-50vh) translateX(15px);
            }
            90% {
                opacity: 0.7;
            }
            100% {
                transform: translateY(-105vh) translateX(-15px);
                opacity: 0;
            }
        }

        /* ----- TYPOGRAPHY & HERO SHADOW ----- */
        .hero-title {
            font-weight: 900;
            letter-spacing: 1px;
            line-height: 1.15;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
        }

        .hero-subtitle {
            letter-spacing: 2px;
            text-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
        }

        .hero-desc {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 400;
            font-size: 1.1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            max-width: 580px;
        }

        /* ----- BUTTON CTA WITH GLOW EFX ----- */
        .btn-cta {
            background-color: var(--accent-orange);
            color: #fff;
            border: none;
            box-shadow: 0 8px 25px rgba(242, 101, 34, 0.4);
            transition: all 0.3s ease;
        }

        .btn-cta:hover {
            background-color: var(--accent-orange-hover);
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(242, 101, 34, 0.6);
        }

        .btn-cta:active {
            transform: translateY(1px);
        }

        /* ----- LOGO & GLOW SHADOW ----- */
        .school-logo {
            max-width: 360px;
            width: 100%;
            height: auto;
            filter: drop-shadow(0 20px 30px rgba(0, 0, 0, 0.6)) drop-shadow(0 0 15px rgba(11, 94, 215, 0.4));
            animation: floating 4s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
            100% { transform: translateY(0px); }
        }

        /* ----- 3. FADE-IN DOWN ANIMATIONS FOR BODY CONTENT ----- */
        .hero-content-anim {
            opacity: 0;
            transform: translateY(-35px);
            transition: opacity 0.8s cubic-bezier(0.25, 1, 0.5, 1), transform 0.8s cubic-bezier(0.25, 1, 0.5, 1);
        }

        body.loaded .hero-content-anim {
            opacity: 1;
            transform: translateY(0);
        }

        body.loaded .delay-1 { transition-delay: 0.1s; }
        body.loaded .delay-2 { transition-delay: 0.25s; }
        body.loaded .delay-3 { transition-delay: 0.4s; }
        body.loaded .delay-4 { transition-delay: 0.55s; }
        body.loaded .delay-5 { transition-delay: 0.7s; }
    </style>
</head>
<body>

    <!-- PRELOADER LOADER INFINITY CANGGIH -->
    <div id="preloader">
        <svg class="infinity-loader" viewBox="0 0 100 50">
            <defs>
                <linearGradient id="infinityGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#0b5ed7" />
                    <stop offset="50%" stop-color="#f26522" />
                    <stop offset="100%" stop-color="#0b5ed7" />
                </linearGradient>
            </defs>
            <path class="infinity-path" 
                  stroke="url(#infinityGrad)" 
                  d="M25,25 C10,25 10,40 25,40 C40,40 60,10 75,10 C90,10 90,25 75,25 C60,25 40,40 25,40 C10,40 10,25 25,25 Z M75,25 C90,25 90,40 75,40 C60,40 40,10 25,10 C10,10 10,25 25,25 C40,25 60,40 75,40 C90,40 90,25 75,25 Z"/>
        </svg>
        <div class="loader-text">MEMUAT BKK DOSQLA...</div>
    </div>

    <div class="hero-wrapper">
        <!-- WADAH GELEMBUNG AIR HASIL GENERATE JS -->
        <div id="bubbles-container"></div>

        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg navbar-dark py-4" style="z-index: 10;">
            <div class="container">
                <a class="navbar-brand navbar-brand-text hero-content-anim delay-1 wavy-text" href="<?= defined('BASEURL') ? BASEURL : ''; ?>">
                    BKK DOSQLA
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav align-items-center gap-2 nav-menu-wrapper" id="navMenu">
                        <div class="nav-active-bg" id="slidingPill"></div>

                        <li class="nav-item">
                            <a class="nav-link nav-link-custom wavy-text" href="home">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom active-pill wavy-text" href="job">Lowongan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom wavy-text" href="artikel">Artikel</a>
                        </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom wavy-text" href="<?= BASE_URL ?>daftar">daftar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom wavy-text" href="<?= BASE_URL ?>auth/login">login</a>
                    </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- HERO CONTENT -->
        <div class="container my-auto py-5" style="z-index: 10;">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h5 class="fw-bold text-uppercase hero-subtitle text-white-50 hero-content-anim delay-2 wavy-text">BERGABUNGLAH!</h5>
                    <h1 class="display-3 hero-title text-uppercase hero-content-anim delay-3 wavy-text">SOLUSI BKK<br>TERBAIK CIRTIM</h1>
                    <p class="mt-3 hero-desc hero-content-anim delay-4">
                        Menghubungkan talenta muda berbakat dengan puluhan perusahaan mitra terkemuka. Dapatkan kemudahan akses informasi lowongan kerja, seleksi terpadu, dan pendampingan karir profesional.
                    </p>
                    <div class="hero-content-anim delay-5">
                        <a href="job" class="btn btn-cta fw-bold px-4 py-3 rounded-pill mt-3">
                            <i class="bi bi-search me-2"></i> Cari Lowongan Kerja
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-5 text-center mt-4 mt-lg-0 hero-content-anim delay-3">
                    <img src="<?= defined('BASEURL') ? BASEURL : ''; ?>public/img/logo.png" id="schoolLogo" class="school-logo" alt="Logo SMK Muhammadiyah Lemahabang">
                </div>
            </div>
        </div>

        <div></div>
    </div>

    <!-- Bootstrap 5 JS Bundle & Vanilla Tilt -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
    
    <script>
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            
            preloader.style.opacity = '0';
            preloader.style.visibility = 'hidden';
            
            document.body.classList.add('loaded');

            // Inisialisasi Fitur Dynamic
            initWavyText();
            createBubbles(45); // Generate 45 gelembung halus & kecil
            setTimeout(initSlidingPill, 100);
        });

        // 1. SCRIPT UNTUK MEMBAGI HURUFT MENJADI SPAN TEROMBANG-AMBING
        function initWavyText() {
            const wavyElements = document.querySelectorAll('.wavy-text');
            wavyElements.forEach(el => {
                const nodes = Array.from(el.childNodes);
                el.innerHTML = '';
                nodes.forEach(node => {
                    if (node.nodeType === Node.TEXT_NODE) {
                        const text = node.textContent;
                        for (let i = 0; i < text.length; i++) {
                            const char = text[i];
                            if (char === ' ') {
                                el.appendChild(document.createTextNode(' '));
                            } else {
                                const span = document.createElement('span');
                                span.classList.add('wave-char');
                                span.textContent = char;
                                // Delay acak per huruf untuk sensasi air alami
                                span.style.animationDelay = `${(i * 0.12) % 2}s`;
                                el.appendChild(span);
                            }
                        }
                    } else {
                        el.appendChild(node);
                    }
                });
            });
        }

        // 2. SCRIPT SPINNER GELEMBUNG AIR HALUS & KECIL
        function createBubbles(count) {
            const container = document.getElementById('bubbles-container');
            for (let i = 0; i < count; i++) {
                const bubble = document.createElement('div');
                bubble.classList.add('bubble');
                
                // Ukuran halus & kecil (3px - 10px)
                const size = Math.random() * 7 + 3;
                bubble.style.width = `${size}px`;
                bubble.style.height = `${size}px`;
                
                // Posisi & Animasi Acak
                bubble.style.left = `${Math.random() * 100}%`;
                bubble.style.animationDuration = `${Math.random() * 8 + 6}s`; // 6s - 14s
                bubble.style.animationDelay = `${Math.random() * 5}s`;
                
                container.appendChild(bubble);
            }
        }

        // 3. Vanilla Tilt Logo
        VanillaTilt.init(document.querySelector("#schoolLogo"), {
            max: 12,
            speed: 400,
            glare: true,
            "max-glare": 0.25
        });

        // 4. SCRIPT NAVIGASI ORANYE DINAMIS (SLIDING PILL INDICATOR)
        function initSlidingPill() {
            const navMenu = document.getElementById('navMenu');
            const slidingPill = document.getElementById('slidingPill');
            const navLinks = document.querySelectorAll('.nav-link-custom');
            let activeLink = document.querySelector('.nav-link-custom.active-pill') || navLinks[0];

            function movePillTo(element) {
                if (!element) return;
                const menuRect = navMenu.getBoundingClientRect();
                const elemRect = element.getBoundingClientRect();

                slidingPill.style.width = `${elemRect.width}px`;
                slidingPill.style.height = `${elemRect.height}px`;
                slidingPill.style.transform = `translate(${elemRect.left - menuRect.left}px, ${elemRect.top - menuRect.top}px)`;
                slidingPill.style.opacity = '1';
            }

            movePillTo(activeLink);

            navLinks.forEach(link => {
                link.addEventListener('mouseenter', function() {
                    movePillTo(this);
                });
            });

            navMenu.addEventListener('mouseleave', function() {
                movePillTo(activeLink);
            });

            window.addEventListener('resize', function() {
                movePillTo(activeLink);
            });
        }
    </script>
</body>
</html>