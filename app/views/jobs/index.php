<?php 
  // Tambahkan ini sementara di baris paling atas file index.php view
//   var_dump($jobs); 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lowongan Pekerjaan - BKK Dosqla</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 900px; margin: 0 auto; }
        .header-title { text-align: center; margin-bottom: 25px; color: #2c3e50; }
        .search-box { background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .search-box form { display: flex; gap: 10px; }
        .search-box input[type="text"] { flex: 1; padding: 12px 15px; border: 1px solid #ced4da; border-radius: 6px; font-size: 0.95rem; }
        .btn-search { padding: 12px 24px; background: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; transition: background 0.2s; text-decoration: none; }
        .btn-search:hover { background: #0056b3; }
        .btn-reset { padding: 12px 20px; background: #6c757d; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; text-decoration: none; display: inline-flex; align-items: center; }
        .btn-reset:hover { background: #5a6268; }
        .job-card { background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); border-left: 4px solid #007bff; }
        .job-card h3 { margin-top: 0; margin-bottom: 8px; color: #1a252f; }
        .company { color: #007bff; font-weight: 600; margin-bottom: 12px; font-size: 0.95rem; }
        .job-card p { color: #555; line-height: 1.6; margin-bottom: 15px; font-size: 0.9rem; }
        .card-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 15px; padding-top: 12px; border-top: 1px solid #eee; }
        .posted-date { font-size: 0.8rem; color: #888; }
        .btn-detail { display: inline-block; padding: 8px 18px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; font-size: 0.88rem; font-weight: bold; transition: background 0.2s; }
        .btn-detail:hover { background: #218838; }
        .no-data { text-align: center; color: #6c757d; padding: 30px; }
        .search-info { margin-bottom: 15px; font-size: 0.9rem; color: #555; }
    </style>
</head>
<body>

<div class="container">
    <h2 class="header-title">Cari Lowongan Pekerjaan</h2>

    <!-- Form Pencarian -->
    <div class="search-box">
        <form action="<?= BASE_URL ?>jobs" method="GET">
            <input type="text" name="q" placeholder="Cari posisi atau nama perusahaan..." value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">
            <button type="submit" class="btn-search">Cari</button>
            
            <!-- Tombol Reset / Tampilkan Semua (Otomatis tampil saat ada filter pencarian) -->
            <?php if (isset($_GET['q']) && $_GET['q'] !== ''): ?>
                <a href="<?= BASE_URL ?>jobs" class="btn-reset">Tampilkan Semua</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Informasi Pencarian -->
    <?php if (isset($_GET['q']) && $_GET['q'] !== ''): ?>
        <div class="search-info">
            Menampilkan hasil pencarian untuk kata kunci: <strong>"<?= htmlspecialchars($_GET['q']); ?>"</strong>
        </div>
    <?php endif; ?>

    <!-- Daftar Lowongan -->
    <div class="job-list">
        <?php if (!empty($jobs)): ?>
            <?php foreach ($jobs as $job): ?>
                <div class="job-card">
                    <h3><?= htmlspecialchars($job['judul'] ?? 'Posisi Tidak Spesifik'); ?></h3>
                    <div class="company">🏢 <?= htmlspecialchars($job['perusahaan'] ?? 'Perusahaan'); ?></div>
                    <p><?= htmlspecialchars(substr($job['deskripsi'] ?? '', 0, 150)) . (strlen($job['deskripsi'] ?? '') > 150 ? '...' : ''); ?></p>
                    
                    <div class="card-footer">
                        <span class="posted-date">📅 <?= isset($job['created_at']) ? date('d M Y', strtotime($job['created_at'])) : '-'; ?></span>
                        <a href="<?= BASE_URL ?>jobs/detail?id=<?= $job['id'] ?>" class="btn-detail">Lihat Detail</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="job-card no-data">
                <p>Tidak ada lowongan pekerjaan yang ditemukan.</p>
                <a href="<?= BASE_URL ?>jobs" class="btn-detail">Tampilkan Semua Lowongan</a>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>