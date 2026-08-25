<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - BKK DOSQLA</title>
    <!-- Memanggil CSS eksternal -->
    <link rel="stylesheet" href="<?= BASE_URL; ?>css/login.css">
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

        /* --- SISI KIRI (ORANGE HERO SECTION) --- */
        .brand-section {
            flex: 1;
            background: var(--bg-orange);
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
            color: #ffffff;
        }

        .hero-text {
            z-index: 5;
            margin-bottom: 20px;
        }

        .hero-text .subtitle {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .hero-text h1 {
            font-size: 2.2rem;
            line-height: 1.25;
            color: var(--text-dark-blue);
            font-weight: 800;
        }

        .hero-text p.smart-control {
            font-size: 2.2rem;
            color: #ffffff;
            font-weight: 800;
        }

        .hero-divider {
            width: 180px;
            height: 3px;
            background: rgba(4, 36, 86, 0.5);
            margin-top: 15px;
            border-radius: 2px;
        }

        /* --- SISI KANAN (BLUE FORM SECTION) --- */
        .form-section {
            flex: 1;
            background-color: var(--bg-blue);
            padding: 45px 65px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #ffffff;
            transition: flex 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
        }

        .form-section h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--bg-orange);
            margin-bottom: 25px;
        }

        .input-group {
            margin-bottom: 18px;
        }

        .input-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 6px;
            color: #ffffff;
        }

        .input-wrapper {
            position: relative;
        }

        .input-group input {
            width: 100%;
            padding: 12px 20px;
            border-radius: 50px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            font-weight: 600;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, 0.6);
            font-weight: 500;
        }

        .input-group input:focus {
            background: rgba(255, 255, 255, 0.3);
            border-color: #ffffff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 50px;
            background: var(--bg-orange);
            color: white;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 0px #b34300, 0 12px 20px rgba(0,0,0,0.25);
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: #e55600;
            transform: translateY(-2px);
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
            font-size: 0.9rem;
            color: #ffffff;
        }

        .login-link a {
            color: #ffaa77;
            text-decoration: underline;
            font-weight: 700;
        }

        /* --- TOGGLE ARROW BUTTON --- */
        .center-arrow-container {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            z-index: 20;
            pointer-events: none;
        }

        .center-arrow-btn {
            pointer-events: auto;
            width: 65px;
            height: 65px;
            background: #ff0044;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        /* --- CANVAS ANIMASI STICKMAN OVERLAY --- */
        #stickmanCanvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 10;
        }

        @media (max-width: 850px) {
            .login-wrapper { flex-direction: column; height: auto; }
            .center-arrow-container, #stickmanCanvas { display: none; }
            .brand-section, .form-section { padding: 40px 30px; }
        }
    </style>
</head>
<body>

<div class="login-wrapper" id="loginWrapper">

    <!-- CANVAS UNTUK ANIMASI STICKMAN BERJALAN MULUS -->
    <canvas id="stickmanCanvas"></canvas>

    <!-- HERO SECTION (KIRI) -->
    <div class="brand-section">
        <div class="logo-area">
           <img src="/Bursa-Kerja-Khusus-Dosqla/public/img/logo.png" 
            alt="Logo BKK DOSQLA" 
            style="max-height: 40px; width: auto;"
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

        <div style="height: 60px;"><!-- Spaceholder untuk lintasan Stickman --></div>
    </div>

    <!-- TOGGLE BUTTON ARROW (TENGAH) -->
    <div class="center-arrow-container">
        <div class="center-arrow-btn">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
        </div>
    </div>

    <!-- FORM SECTION (KANAN) -->
    <div class="form-section">
        <h2>Daftar</h2>

        <form action="<?= BASE_URL; ?>auth/process_register" method="POST">
            
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
                <label for="instansi">Asal Instansi</label>
                <div class="input-wrapper">
                    <input type="text" id="instansi" name="instansi" placeholder="Nama instansi" required>
                </div>
            </div>

            <button type="submit" class="btn-submit">Daftar</button>

            <div class="login-link">
                Sudah punya akun? <a href="<?= BASE_URL; ?>auth/login">Login sekarang</a>
            </div>
        </form>
    </div>

</div>

<!-- SCRIPT ANIMASI STICKMAN LENGKAP -->
<script>
    const canvas = document.getElementById('stickmanCanvas');
    const ctx = canvas.getContext('2d');

    function resizeCanvas() {
        canvas.width = canvas.parentElement.clientWidth;
        canvas.height = canvas.parentElement.clientHeight;
    }
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    // Variabel Posisi Stickman
    let xPos = 80;
    const yPos = canvas.height - 100; // Jalur berjalan di bagian bawah
    const speed = 1.8;
    let animFrame = 0;

    function drawStickman(x, y, frame) {
        const isSuited = x > (canvas.width / 2); // Berubah di area biru (melewati tengah)
        const walkCycle = Math.sin(frame * 0.12);
        const legAngle = walkCycle * 0.6;
        const armAngle = walkCycle * 0.6;

        ctx.lineWidth = 3.5;
        ctx.lineCap = 'round';
        ctx.strokeStyle = isSuited ? '#ffffff' : '#042456';

        // 1. KEPALA
        ctx.beginPath();
        ctx.arc(x, y - 55, 12, 0, Math.PI * 2);
        ctx.stroke();

        // HELM SAFETY (Jika sudah di area biru)
        if (isSuited) {
            ctx.fillStyle = '#ffcc00'; // Helm Proyek Kuning
            ctx.beginPath();
            ctx.arc(x, y - 57, 14, Math.PI, 0); // Tempurung Helm
            ctx.fill();
            ctx.fillRect(x - 18, y - 58, 36, 4); // Pet Helm
        }

        // 2. BADAN
        ctx.beginPath();
        ctx.moveTo(x, y - 43);
        ctx.lineTo(x, y - 15);
        ctx.stroke();

        // JAS/BAJU KERJA (Area Biru)
        if (isSuited) {
            ctx.fillStyle = '#03142c';
            ctx.fillRect(x - 8, y - 43, 16, 22);
            // Dasi Merah
            ctx.fillStyle = '#ff0044';
            ctx.beginPath();
            ctx.moveTo(x, y - 43);
            ctx.lineTo(x - 3, y - 35);
            ctx.lineTo(x, y - 25);
            ctx.lineTo(x + 3, y - 35);
            ctx.fill();
        }

        // 3. TANGAN
        // Tangan Kiri
        ctx.beginPath();
        ctx.moveTo(x, y - 38);
        const armLeftX = x + Math.sin(-armAngle) * 20;
        const armLeftY = y - 20 + Math.cos(-armAngle) * 15;
        ctx.lineTo(armLeftX, armLeftY);
        ctx.stroke();

        // Tangan Kanan (Membawa Tas jika di area biru)
        ctx.beginPath();
        ctx.moveTo(x, y - 38);
        const armRightX = x + Math.sin(armAngle) * 20;
        const armRightY = y - 20 + Math.cos(armAngle) * 15;
        ctx.lineTo(armRightX, armRightY);
        ctx.stroke();

        if (isSuited) {
            // Tas Kerja Cokelat
            ctx.fillStyle = '#8B4513';
            ctx.fillRect(armRightX - 6, armRightY, 14, 12);
            ctx.strokeStyle = '#5c2d0c';
            ctx.strokeRect(armRightX - 6, armRightY, 14, 12);
        }

        // 4. KAKI
        // Kaki Kiri
        ctx.beginPath();
        ctx.moveTo(x, y - 15);
        ctx.lineTo(x + Math.sin(legAngle) * 22, y + Math.cos(legAngle) * 18);
        ctx.stroke();

        // Kaki Kanan
        ctx.beginPath();
        ctx.moveTo(x, y - 15);
        ctx.lineTo(x + Math.sin(-legAngle) * 22, y + Math.cos(-legAngle) * 18);
        ctx.stroke();
    }

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Update Posisi
        xPos += speed;
        if (xPos > canvas.width - 60) {
            xPos = 60; // Reset kembali ke kiri setelah sampai ujung
        }

        animFrame++;
        drawStickman(xPos, yPos, animFrame);

        requestAnimationFrame(animate);
    }

    animate();
</script>

</body>
</html>