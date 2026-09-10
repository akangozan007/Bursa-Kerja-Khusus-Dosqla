<?php
// Load header utama (Preloader, CSS, dan Navbar sudah ada di header)
require_once ROOT_PATH . 'app/views/header_public.php';

$baseUrl = defined('BASEURL') ? BASEURL : '';
?>

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
                    <a href="<?= $baseUrl; ?>job" class="btn btn-cta fw-bold px-4 py-3 rounded-pill mt-3">
                        <i class="bi bi-search me-2"></i> Cari Lowongan Kerja
                    </a>
                </div>
            </div>
            
            <div class="col-lg-5 text-center mt-4 mt-lg-0 hero-content-anim delay-3">
                <img src="<?= $baseUrl; ?>public/img/logo.png" id="schoolLogo" class="school-logo" alt="Logo SMK Muhammadiyah Lemahabang">
            </div>
        </div>
    </div>

</div> <!-- Penutup .hero-wrapper -->

<!-- Bootstrap 5 JS Bundle & Vanilla Tilt -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>

<script>
    // Fungsi Menyembunyikan Preloader Saat Halaman Selesai Load
    window.addEventListener('load', function() {
        const preloader = document.getElementById('preloader');
        
        if (preloader) {
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.visibility = 'hidden';
            }, 600);
        }
        
        document.body.classList.add('loaded');

        // Inisialisasi Fitur Dynamic
        initWavyText();
        createBubbles(45);
        setTimeout(initSlidingPill, 100);
    });

    // 1. SCRIPT UNTUK MEMBAGI HURUF MENJADI SPAN TEROMBANG-AMBING
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

    // 2. SCRIPT GELEMBUNG AIR
    function createBubbles(count) {
        const container = document.getElementById('bubbles-container');
        if (!container) return;
        
        for (let i = 0; i < count; i++) {
            const bubble = document.createElement('div');
            bubble.classList.add('bubble');
            
            const size = Math.random() * 7 + 3;
            bubble.style.width = `${size}px`;
            bubble.style.height = `${size}px`;
            
            bubble.style.left = `${Math.random() * 100}%`;
            bubble.style.animationDuration = `${Math.random() * 8 + 6}s`;
            bubble.style.animationDelay = `${Math.random() * 5}s`;
            
            container.appendChild(bubble);
        }
    }

    // 3. Vanilla Tilt Logo
    const schoolLogo = document.querySelector("#schoolLogo");
    if (schoolLogo) {
        VanillaTilt.init(schoolLogo, {
            max: 12,
            speed: 400,
            glare: true,
            "max-glare": 0.25
        });
    }

    // 4. SLIDING PILL INDICATOR
    function initSlidingPill() {
        const navMenu = document.getElementById('navMenu');
        const slidingPill = document.getElementById('slidingPill');
        const navLinks = document.querySelectorAll('.nav-link-custom');
        
        if (!navMenu || !slidingPill) return;

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