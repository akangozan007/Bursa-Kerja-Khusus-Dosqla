<?php 
$pageTitle = "Panel Admin - BKK DOSQLA";
$allowedRole = "admin"; // Proteksi agar pelamar tidak bisa membuka halaman ini
require_once ROOT_PATH . 'app/views/ekstra/header.php'; 
?>

<!-- TAB 1: DASHBOARD MINI -->
<div id="dashboard" class="tab-content active">
    <h2>Dashboard Ringkasan</h2>
    <p>Total Lowongan: <?= $data['total_jobs'] ?? 0; ?></p>
</div>

<!-- TAB KELOLA LAINNYA... -->

</div> <!-- Penutup .main-content dari header.php -->
</body>
</html>