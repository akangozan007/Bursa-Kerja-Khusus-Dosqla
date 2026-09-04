<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Admin - BKK DOSQLA</title>
    <!-- CSS Utama & FontAwesome untuk icon modal -->
    <link rel="stylesheet" href="<?= BASE_URL; ?>public/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Modern OTP Modal Styles */
        .modal-otp-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(3, 20, 44, 0.75);
            backdrop-filter: blur(5px);
            display: none; align-items: center; justify-content: center;
            z-index: 9999; opacity: 0; transition: opacity 0.3s ease;
        }
        .modal-otp-overlay.active { display: flex; opacity: 1; }
        .modal-otp-card {
            background: #ffffff; width: 90%; max-width: 420px;
            padding: 30px; border-radius: 16px; text-align: center;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.3); transform: translateY(20px);
            transition: transform 0.3s ease;
        }
        .modal-otp-overlay.active .modal-otp-card { transform: translateY(0); }
        .otp-inputs { display: flex; gap: 8px; justify-content: center; margin: 20px 0; }
        .otp-field {
            width: 48px; height: 52px; text-align: center; font-size: 1.4rem; font-weight: 700;
            border: 2px solid #e2e8f0; border-radius: 8px; outline: none; transition: border-color 0.2s;
        }
        .otp-field:focus { border-color: #00a5e3; box-shadow: 0 0 0 3px rgba(0,165,227,0.15); }
        .timer-badge { font-weight: 600; color: #e63946; }
        .btn-modal-verify {
            width: 100%; padding: 12px; background: #00a5e3; color: white; border: none;
            border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s;
        }
        .btn-modal-verify:hover { background: #0088bb; }
    </style>
</head>
<body>

<div class="login-wrapper" id="loginWrapper">

    <!-- HERO SECTION (KIRI) -->
    <div class="brand-section">
        <div class="logo-area">
            <img src="<?= BASE_URL; ?>public/img/logo.png" 
                 alt="Logo BKK DOSQLA" 
                 class="logo-img" 
                 style="max-height: 40px; width: auto; display: block;"
                 onerror="this.onerror=null; this.src='https://via.placeholder.com/40?text=LOGO';">
            BKK DOSQLA
        </div>

        <div class="hero-text">
            <div class="subtitle">PORTAL REGISTRASI PENGELOLA</div>
            <h1>Kelola Sistem</h1>
            <h1>Secara Efisien & Aman</h1>
            <p class="smart-control">Admin Authority Panel</p>
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

        <!-- SVG ROKET -->
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

        <!-- SVG ASTRONOT -->
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
        <h2>Daftar Admin</h2>

        <!-- Alert Container -->
        <div id="alertBox" style="display: none; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; font-size: 0.9rem;"></div>

        <form id="adminRegisterForm" onsubmit="handleRequestOtp(event)">
            <div class="input-group">
                <label for="username">Username Admin</label>
                <div class="input-wrapper">
                    <input type="text" id="username" name="username" placeholder="Masukkan username admin" required autocomplete="off">
                </div>
            </div>

            <div class="input-group">
                <label for="email">Email Official</label>
                <div class="input-wrapper">
                    <input type="email" id="email" name="email" placeholder="email@sekolah.sch.id" required autocomplete="off">
                </div>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                    <span class="toggle-password" onclick="togglePassword()">👁️</span>
                </div>
            </div>

            <button type="submit" class="btn-submit" id="btnSubmit">
                <span class="spinner" id="btnSpinner" style="display:none;"></span>
                <span id="btnText">Kirim Kode OTP</span>
            </button>

            <div class="login-link" style="text-align: center; margin-top: 15px; font-size: 0.9rem;">
                Sudah punya akun? <a href="<?= BASE_URL; ?>auth/login" style="color: #ffaa77; font-weight: 700; text-decoration: underline;">Login sekarang</a>
            </div>
        </form>
    </div>

</div>

<!-- MODAL POPUP OTP -->
<div class="modal-otp-overlay" id="otpModal">
    <div class="modal-otp-card">
        <div style="font-size: 2.5rem; color: #00a5e3; margin-bottom: 10px;">
            <i class="fa-solid fa-envelope-circle-check"></i>
        </div>
        <h3 style="margin: 0; color: #03142c; font-size: 1.3rem;">Verifikasi OTP Admin</h3>
        <p style="font-size: 0.85rem; color: #64748b; margin-top: 6px;">
            Kode verifikasi telah dikirimkan ke <br><strong id="targetEmailDisplay" style="color: #03142c;">email@domain.com</strong>
        </p>

        <div id="modalAlertBox" style="display: none; padding: 8px; border-radius: 5px; margin-top: 10px; font-size: 0.8rem;"></div>

        <form id="otpVerifyForm" onsubmit="handleVerifyOtp(event)">
            <div class="otp-inputs">
                <input type="text" class="otp-field" maxlength="1" pattern="[0-9]" inputmode="numeric" required onkeyup="moveOtpFocus(this, 0, event)" onkeydown="handleOtpBackspace(this, 0, event)">
                <input type="text" class="otp-field" maxlength="1" pattern="[0-9]" inputmode="numeric" required onkeyup="moveOtpFocus(this, 1, event)" onkeydown="handleOtpBackspace(this, 1, event)">
                <input type="text" class="otp-field" maxlength="1" pattern="[0-9]" inputmode="numeric" required onkeyup="moveOtpFocus(this, 2, event)" onkeydown="handleOtpBackspace(this, 2, event)">
                <input type="text" class="otp-field" maxlength="1" pattern="[0-9]" inputmode="numeric" required onkeyup="moveOtpFocus(this, 3, event)" onkeydown="handleOtpBackspace(this, 3, event)">
                <input type="text" class="otp-field" maxlength="1" pattern="[0-9]" inputmode="numeric" required onkeyup="moveOtpFocus(this, 4, event)" onkeydown="handleOtpBackspace(this, 4, event)">
                <input type="text" class="otp-field" maxlength="1" pattern="[0-9]" inputmode="numeric" required onkeyup="moveOtpFocus(this, 5, event)" onkeydown="handleOtpBackspace(this, 5, event)">
            </div>

            <div style="font-size: 0.85rem; color: #64748b; margin-bottom: 15px;">
                Waktu tersisa: <span class="timer-badge" id="otpTimer">05:00</span>
            </div>

            <button type="submit" class="btn-modal-verify" id="btnVerifyOtp">Verifikasi & Selesaikan Pendaftaran</button>
        </form>

        <div style="margin-top: 15px; font-size: 0.8rem; color: #64748b;">
            Tidak menerima kode? 
            <button type="button" id="btnResendOtp" onclick="resendOtpCode()" style="background: none; border: none; color: #00a5e3; font-weight: 700; cursor: pointer;" disabled>Kirim Ulang</button>
        </div>
    </div>
</div>

<!-- SCRIPT JS INTERAKTIF & HANDLER OTP AJAX -->
<script type="text/javascript" src="<?= BASE_URL; ?>public/js/login.js"></script>
<script>
    const BASE_URL = "<?= BASE_URL; ?>";
    let timerInterval = null;

    function showAlert(elementId, message, isError = true) {
        const box = document.getElementById(elementId);
        box.style.display = 'block';
        box.style.backgroundColor = isError ? '#ff4d4d' : '#2ec4b6';
        box.style.color = '#ffffff';
        box.innerText = message;
    }

    // Helper untuk menangani parse JSON aman jika ada output tak diinginkan dari PHP
    async function safeParseJson(response) {
        const rawText = await response.text();
        try {
            return JSON.parse(rawText);
        } catch (e) {
            console.error("Raw response server:", rawText);
            // Mencoba mengekstrak blok JSON saja jika ada text/warning tambahan dari backend
            const jsonMatch = rawText.match(/\{[\s\S]*\}/);
            if (jsonMatch) {
                return JSON.parse(jsonMatch[0]);
            }
            throw new Error("Invalid JSON response from server");
        }
    }

    // Step 1: Kirim data admin -> Minta Kode OTP & Tampilkan Modal
    async function handleRequestOtp(event) {
        event.preventDefault();
        
        const btnSubmit = document.getElementById('btnSubmit');
        const btnSpinner = document.getElementById('btnSpinner');
        const btnText = document.getElementById('btnText');
        const emailVal = document.getElementById('email').value;

        btnSubmit.disabled = true;
        if(btnSpinner) btnSpinner.style.display = 'inline-block';
        if(btnText) btnText.innerText = 'Mengirim OTP...';

        const formData = new FormData(document.getElementById('adminRegisterForm'));

        try {
            const response = await fetch(BASE_URL + 'daftar/send_admin_otp', {
                method: 'POST',
                body: formData
            });

            const result = await safeParseJson(response);

            if (result.status === 'success') {
                document.getElementById('targetEmailDisplay').innerText = emailVal;
                
                // AKTIFKAN MODAL OTP
                const otpModal = document.getElementById('otpModal');
                otpModal.classList.add('active');
                
                // Auto Focus ke input OTP pertama
                setTimeout(() => {
                    document.querySelectorAll('.otp-field')[0].focus();
                }, 100);

                startOtpTimer(300); // 5 Menit
            } else {
                showAlert('alertBox', result.message || 'Gagal mengirim OTP.', true);
            }
        } catch (error) {
            console.error(error);
            showAlert('alertBox', 'Gagal memproses respon server. Cek console browser.', true);
        } finally {
            btnSubmit.disabled = false;
            if(btnSpinner) btnSpinner.style.display = 'none';
            if(btnText) btnText.innerText = 'Kirim Kode OTP';
        }
    }

    // Navigasi Otomatis Input OTP
    function moveOtpFocus(current, currentIndex, event) {
        if (event.key === "Backspace") return;
        if (current.value.length >= 1) {
            const fields = document.querySelectorAll('.otp-field');
            if (currentIndex + 1 < fields.length) {
                fields[currentIndex + 1].focus();
            }
        }
    }

    function handleOtpBackspace(current, currentIndex, event) {
        if (event.key === "Backspace" && current.value.length === 0) {
            const fields = document.querySelectorAll('.otp-field');
            if (currentIndex - 1 >= 0) {
                fields[currentIndex - 1].focus();
            }
        }
    }

    // Timer Penghitung Mundur
    function startOtpTimer(seconds) {
        clearInterval(timerInterval);
        const timerDisplay = document.getElementById('otpTimer');
        const resendBtn = document.getElementById('btnResendOtp');
        resendBtn.disabled = true;

        let timeLeft = seconds;
        timerInterval = setInterval(() => {
            let mins = Math.floor(timeLeft / 60);
            let secs = timeLeft % 60;
            timerDisplay.innerText = `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;

            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                timerDisplay.innerText = "00:00";
                resendBtn.disabled = false;
            }
            timeLeft--;
        }, 1000);
    }

    // Step 2: Verifikasi OTP & Redireksi ke Login
    async function handleVerifyOtp(event) {
        event.preventDefault();

        const otpFields = document.querySelectorAll('.otp-field');
        let otpCode = '';
        otpFields.forEach(field => otpCode += field.value);

        if (otpCode.length < 6) {
            showAlert('modalAlertBox', 'Masukkan 6 digit kode OTP lengkap.', true);
            return;
        }

        const emailVal = document.getElementById('email').value;
        const verifyData = new FormData();
        verifyData.append('email', emailVal);
        verifyData.append('otp_code', otpCode);

        try {
            const response = await fetch(BASE_URL + 'daftar/verify_admin_otp', {
                method: 'POST',
                body: verifyData
            });
            
            const result = await safeParseJson(response);

            if (result.status === 'success') {
                showAlert('modalAlertBox', 'Registrasi Admin Berhasil! Memindahkan halaman...', false);
                setTimeout(() => {
                    window.location.href = BASE_URL + 'auth/login';
                }, 1500);
            } else {
                showAlert('modalAlertBox', result.message || 'Kode OTP Salah / Kadaluarsa.', true);
            }
        } catch (error) {
            console.error(error);
            showAlert('modalAlertBox', 'Gagal memproses verifikasi OTP.', true);
        }
    }

    // Kirim Ulang OTP
    async function resendOtpCode() {
        const emailVal = document.getElementById('email').value;
        const formData = new FormData();
        formData.append('email', emailVal);

        try {
            const response = await fetch(BASE_URL + 'daftar/resend_admin_otp', {
                method: 'POST',
                body: formData
            });

            const result = await safeParseJson(response);

            if (result.status === 'success') {
                showAlert('modalAlertBox', 'Kode OTP baru telah dikirim!', false);
                startOtpTimer(300);
            } else {
                showAlert('modalAlertBox', result.message, true);
            }
        } catch (e) {
            showAlert('modalAlertBox', 'Gagal mengirim ulang OTP.', true);
        }
    }
</script>

</body>
</html>