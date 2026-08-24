<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | BKK DOSQLA</title>
    <style>
        :root {
            --primary-blue: #0c4a9e;
            --dark-blue: #092a58;
            --accent-orange: #f26522;
            --accent-orange-hover: #d95318;
            --text-light: #ffffff;
            --text-muted: #d0e1f9;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--primary-blue) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-light);
            text-align: center;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            width: 100%;
        }

        .error-code {
            font-size: 8rem;
            font-weight: 800;
            line-height: 1;
            color: var(--accent-orange);
            text-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            margin-bottom: 10px;
        }

        .brand-name {
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: 2px;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 15px;
            font-weight: 700;
        }

        p {
            font-size: 1rem;
            color: var(--text-muted);
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: var(--accent-orange);
            color: var(--text-light);
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(242, 101, 34, 0.4);
        }

        .btn-home:hover {
            background-color: var(--accent-orange-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(242, 101, 34, 0.6);
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="brand-name">BKK DOSQLA</div>
        <div class="error-code">404</div>
        <h1>Halaman Tidak Ditemukan</h1>
        <p>Maaf, halaman yang Anda cari tidak ada, telah dihapus, atau alamat URL yang Anda masukkan salah.</p>
        <a href="<?= BASE_URL; ?>" class="btn-home">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Kembali ke Beranda
        </a>
    </div>

</body>
</html>