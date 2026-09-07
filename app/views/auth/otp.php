<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - BKK DOSQLA</title>
    <link rel="stylesheet" href="<?= BASE_URL; ?>public/css/login.css">
</head>
<body>

<div class="login-wrapper">
    <div class="form-section" style="max-width: 400px; margin: 0 auto;">
        <h2>Verifikasi OTP</h2>
        <p style="text-align: center; color: #666; font-size: 0.85rem; margin-bottom: 20px;">
            Masukkan 6 digit kode verifikasi yang dikirimkan ke 
            <strong><?= $_SESSION['temp_user']['email'] ?? 'email Anda'; ?></strong>
        </p>

        <?php if (isset($_SESSION['error'])): ?>
            <div style="background-color: #ff4d4d; color: #fff; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; font-size: 0.9rem;">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- UPDATED FORM ACTION -->
        <form action="<?= BASE_URL; ?>pelamar/process_otp" method="POST">
            <div class="input-group">
                <label for="otp_code" style="text-align: center;">Kode OTP</label>
                <div class="input-wrapper">
                    <input type="text" id="otp_code" name="otp_code" maxlength="6" placeholder="123456" 
                           style="text-align: center; font-size: 1.5rem; letter-spacing: 6px;" required autocomplete="off">
                </div>
            </div>

            <button type="submit" class="btn-submit" style="margin-top: 15px;">Verifikasi</button>
        </form>
        
        <div style="text-align: center; margin-top: 15px; font-size: 0.85rem;">
            Tidak menerima kode? 
            <a href="<?= BASE_URL; ?>pelamar/resend_otp" style="color: #00a5e3; font-weight: 700;">Kirim Ulang</a>
        </div>
    </div>
</div>

</body>
</html>