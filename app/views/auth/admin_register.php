<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Admin - BKK DOSQLA</title>
    <link rel="stylesheet" href="<?= BASE_URL; ?>public/css/login.css">
    
    <style>
        /* Reset wrapper agar centering sempurna di layar */
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            box-sizing: border-box;
        }

        /* Override kontainer utama agar fleksibel & tidak pernah kelelep */
        .form-section.admin-card {
            width: 100%;
            max-width: 420px;
            height: auto !important; /* Mencegah tinggi terkunci */
            min-height: min-content;
            background-color: #ff5722 !important; /* Warna oranye sesuai screenshot */
            border-radius: 16px;
            padding: 35px 28px !important;
            box-sizing: border-box !important;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
        }

        .admin-card h2 {
            color: #111827;
            font-size: 2rem;
            font-weight: 800;
            text-align: center;
            margin: 0 0 4px 0;
        }

        .admin-card .sub-title {
            text-align: center;
            color: rgba(0, 0, 0, 0.65); /* Kontras lebih jelas */
            font-size: 0.875rem;
            margin-bottom: 24px;
            font-weight: 500;
        }

        .admin-card .input-group {
            margin-bottom: 16px;
        }

        .admin-card label {
            display: block;
            color: #111827;
            font-weight: 700;
            font-size: 0.875rem;
            margin-bottom: 6px;
        }

        .admin-card input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 25px; /* Sesuai desain membulat di screenshot */
            border: none;
            background-color: #ff8a65; /* Oranye muda sesuai gambar */
            color: #111827;
            font-size: 0.95rem;
            box-sizing: border-box;
            outline: none;
        }

        .admin-card input::placeholder {
            color: rgba(0, 0, 0, 0.45);
        }

        /* Merapikan Tombol agar Tetap di Dalam Kontainer Oranye */
        .admin-card .btn-submit {
            width: 100%;
            padding: 13px;
            background-color: #0d6efd; /* Biru sesuai screenshot */
            color: #ffffff;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 12px;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
            transition: background 0.2s ease;
        }

        .admin-card .btn-submit:hover {
            background-color: #0b5ed7;
        }

        /* Responsif untuk Layar Smartphone Sempit */
        @media (max-width: 480px) {
            .form-section.admin-card {
                padding: 25px 20px !important;
            }
            
            .admin-card h2 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="form-section admin-card">
        <h2>Admin</h2>
        <p class="sub-title">Portal Registrasi Pengelola BKK</p>

        <?php if (isset($_SESSION['error'])): ?>
            <div style="background-color: #d32f2f; color: #fff; padding: 10px 14px; border-radius: 8px; margin-bottom: 18px; text-align: center; font-size: 0.85rem; font-weight: 600;">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL; ?>daftar/process_admin_register" method="POST">
            <div class="input-group">
                <label for="username">Username Admin</label>
                <div class="input-wrapper">
                    <input type="text" id="username" name="username" placeholder="admin" required autocomplete="off">
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
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <div class="input-group">
                <label for="secret_key">Kode Rahasia Admin</label>
                <div class="input-wrapper">
                    <input type="password" id="secret_key" name="secret_key" placeholder="Security Token" required>
                </div>
            </div>

            <button type="submit" class="btn-submit">Daftar Sebagai Admin</button>
        </form>
    </div>
</div>

</body>
</html>