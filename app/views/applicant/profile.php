<?php
require_once ROOT_PATH . 'app/views/ekstra/header.php';
$p = $data['pelamar'] ?? [];
?>

<!-- Import CDN Font & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<style>
    :root {
        --color-navy-dark: #0D1033;
        --color-navy-blue: #0F4C81;
        --color-sky-blue: #71C9CE;
        --color-orange: #F2994A;
    }

    body {
        background: linear-gradient(135deg, #0D1033 0%, #0F4C81 50%, #111827 100%);
        min-height: 100vh;
        color: #ffffff;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    /* Glassmorphism Card Container */
    .glass-card {
        background: rgba(13, 16, 51, 0.55);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(113, 201, 206, 0.25);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
    }

    /* Glass Input Field */
    .glass-input {
        background: rgba(255, 255, 255, 0.08) !important;
        border: 1px solid rgba(113, 201, 206, 0.3) !important;
        color: #ffffff !important;
        transition: all 0.25s ease-in-out;
    }

    .glass-input:focus {
        background: rgba(255, 255, 255, 0.15) !important;
        border-color: #F2994A !important;
        box-shadow: 0 0 0 4px rgba(242, 153, 74, 0.25) !important;
        outline: none !important;
    }

    .glass-input::placeholder {
        color: rgba(255, 255, 255, 0.35);
    }

    .badge-sky {
        background: rgba(113, 201, 206, 0.15);
        border: 1px solid rgba(113, 201, 206, 0.4);
        color: #71C9CE;
    }
</style>

<!-- Main Form Container -->
<div class="container mx-auto px-4 py-10 relative z-10">
    <div class="max-w-6xl mx-auto glass-card rounded-3xl p-6 md:p-10 shadow-2xl">
        
        <!-- Header Info Profil -->
        <div class="flex flex-col md:flex-row items-center justify-between pb-6 border-b border-white/10 mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white tracking-wide">Profil Pelamar Kerja</h1>
                <p class="text-xs text-sky-200/70 mt-1">Lengkapi seluruh data pribadi Anda untuk memproses lamaran pekerjaan.</p>
            </div>
            <span class="px-3 py-1 text-xs font-semibold rounded-full badge-sky flex items-center gap-1.5">
                <i class="bi bi-shield-check text-[#71C9CE]"></i> Data Terverifikasi
            </span>
        </div>

        <!-- Flash Message Notification -->
        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="mb-6 p-4 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-200 text-xs flex items-center gap-3 shadow-lg">
                <i class="bi bi-check-circle-fill text-lg text-emerald-400"></i>
                <div class="flex-1"><?= $_SESSION['flash']; unset($_SESSION['flash']); ?></div>
            </div>
        <?php endif; ?>

        <!-- Form Profil Utama -->
        <form action="" method="POST" enctype="multipart/form-[#]">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                
                <!-- Kolom Kiri: Avatar Upload -->
                <div class="md:col-span-3 flex flex-col items-center text-center">
                    <div class="relative group mb-4">
                        <div class="w-36 h-36 rounded-full bg-gradient-to-tr from-[#0F4C81] to-[#71C9CE] p-1 shadow-xl">
                            <div class="w-full h-full rounded-full bg-[#0D1033] flex items-center justify-center text-white text-5xl overflow-hidden">
                                <?php if (!empty($p['foto_profil'])): ?>
                                    <img src="<?= htmlspecialchars($p['foto_profil']); ?>" alt="Foto Profil" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <i class="bi bi-person-fill text-[#71C9CE]"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                        <label class="absolute bottom-1 right-1 w-10 h-10 bg-[#F2994A] hover:bg-orange-600 rounded-full flex items-center justify-center text-white text-sm cursor-pointer shadow-lg transition-all hover:scale-110">
                            <i class="bi bi-camera-fill"></i>
                            <input type="file" name="foto_profil" class="hidden">
                        </label>
                    </div>
                    <p class="text-xs text-sky-200/60">Unggah foto formal (Max 2MB)</p>
                </div>

                <!-- Kolom Kanan: Grid Field (3 Kolom Sesuai Gambar BKK DOSQLA) -->
                <div class="md:col-span-9 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        
                        <!-- Row 1 -->
                        <div>
                            <label class="block text-xs font-semibold text-sky-200/90 mb-2">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($p['nama_lengkap'] ?? ''); ?>" required
                                   placeholder="Nama Lengkap" class="glass-input w-full px-4 py-3 rounded-xl text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-sky-200/90 mb-2">Alamat Lengkap</label>
                            <input type="text" name="alamat" value="<?= htmlspecialchars($p['alamat'] ?? ''); ?>" required
                                   placeholder="Alamat Lengkap" class="glass-input w-full px-4 py-3 rounded-xl text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-sky-200/90 mb-2">Telepon / WhatsApp</label>
                            <input type="text" name="no_telepon" value="<?= htmlspecialchars($p['no_telepon'] ?? ''); ?>" required
                                   placeholder="0812xxxxxxx" class="glass-input w-full px-4 py-3 rounded-xl text-sm">
                        </div>

                        <!-- Row 2 -->
                        <div>
                            <label class="block text-xs font-semibold text-sky-200/90 mb-2">Tempat, Tanggal Lahir</label>
                            <input type="text" name="ttl" value="<?= htmlspecialchars($p['ttl'] ?? ''); ?>"
                                   placeholder="Cirebon, 01 Jan 2000" class="glass-input w-full px-4 py-3 rounded-xl text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-sky-200/90 mb-2">Email</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($p['email'] ?? ''); ?>" required
                                   placeholder="email@domain.com" class="glass-input w-full px-4 py-3 rounded-xl text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-sky-200/90 mb-2">Asal Instansi / Sekolah</label>
                            <input type="text" name="asal_instansi" value="<?= htmlspecialchars($p['asal_instansi'] ?? ''); ?>"
                                   placeholder="Nama Sekolah / Kampus" class="glass-input w-full px-4 py-3 rounded-xl text-sm">
                        </div>

                        <!-- Row 3 -->
                        <div>
                            <label class="block text-xs font-semibold text-sky-200/90 mb-2">Tahun Lulusan</label>
                            <input type="text" name="tahun_lulus" value="<?= htmlspecialchars($p['tahun_lulus'] ?? ''); ?>"
                                   placeholder="Contoh: 2024" class="glass-input w-full px-4 py-3 rounded-xl text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-sky-200/90 mb-2">Pendidikan Terakhir</label>
                            <select name="pendidikan_terakhir" class="glass-input w-full px-4 py-3 rounded-xl text-sm">
                                <?php 
                                $pendidikan = ['SMA/SMK', 'D3', 'D4', 'S1', 'S2'];
                                $selected = $p['pendidikan_terakhir'] ?? 'SMA/SMK';
                                foreach ($pendidikan as $edu): 
                                ?>
                                    <option value="<?= $edu; ?>" class="bg-[#0D1033] text-white" <?= ($selected == $edu) ? 'selected' : ''; ?>>
                                        <?= $edu; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>

                    <!-- Tombol Simpan -->
                    <div class="pt-4 flex justify-end">
                        <button type="submit" 
                                class="w-full md:w-auto px-8 py-3.5 text-sm font-bold text-white bg-[#F2994A] hover:bg-orange-600 active:scale-95 rounded-xl transition-all shadow-lg shadow-orange-500/25 flex items-center justify-center gap-2">
                            <i class="bi bi-floppy-fill"></i> Simpan Perubahan Profil
                        </button>
                    </div>

                </div>
            </div>
        </form>

    </div>
</div>

</div> <!-- Penutup .hero-wrapper -->
</body>
</html>