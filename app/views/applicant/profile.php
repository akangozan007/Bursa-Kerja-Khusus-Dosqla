<?php
require_once ROOT_PATH . 'app/views/ekstra/header.php';
$p = $data['pelamar'] ?? [];
?>

<style>
    @import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
    @import url('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css');

    .glass-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.15);
    }
    .glass-input {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }
    .glass-input:focus {
        background: rgba(255, 255, 255, 0.2);
        border-color: #f97316;
        color: #ffffff;
        outline: none;
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.25);
    }
</style>

<div class="container py-8 my-auto relative" style="z-index: 10;">
    <div class="max-w-2xl mx-auto glass-card rounded-2xl p-6 md:p-8">
        
        <!-- Header -->
        <div class="text-center mb-6">
            <div class="w-20 h-20 mx-auto rounded-full bg-orange-500/20 border-2 border-orange-500 text-orange-400 flex items-center justify-center font-bold text-3xl mb-3">
                <i class="bi bi-person"></i>
            </div>
            <h2 class="text-2xl font-black text-white">Profil Pelamar</h2>
            <p class="text-xs text-blue-100/70">Kelola data pribadi Anda untuk melamar pekerjaan</p>
        </div>

        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="mb-4 p-3 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-xs text-center">
                <?= $_SESSION['flash']; unset($_SESSION['flash']); ?>
            </div>
        <?php endif; ?>

        <!-- Form Profil -->
        <form action="" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-blue-100/80 mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="<?= $p['nama_lengkap'] ?? ''; ?>" required
                       class="glass-input w-full px-4 py-2.5 rounded-xl text-sm">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-blue-100/80 mb-1">No. Telepon / WhatsApp</label>
                    <input type="text" name="no_telepon" value="<?= $p['no_telepon'] ?? ''; ?>" required
                           class="glass-input w-full px-4 py-2.5 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-blue-100/80 mb-1">Pendidikan Terakhir</label>
                    <select name="pendidikan_terakhir" class="glass-input w-full px-4 py-2.5 rounded-xl text-sm">
                        <option value="SMA/SMK" class="bg-slate-800">SMA/SMK</option>
                        <option value="D3" class="bg-slate-800">D3</option>
                        <option value="S1" class="bg-slate-800">S1</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-blue-100/80 mb-1">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" class="glass-input w-full px-4 py-2.5 rounded-xl text-sm"><?= $p['alamat'] ?? ''; ?></textarea>
            </div>

            <button type="submit" 
                    class="w-full mt-4 text-xs font-bold text-white bg-orange-500 hover:bg-orange-600 py-3 rounded-xl transition-all shadow-lg shadow-orange-500/20">
                Simpan Perubahan
            </button>
        </form>

    </div>
</div>

</div> <!-- Penutup .hero-wrapper -->
</body>
</html>