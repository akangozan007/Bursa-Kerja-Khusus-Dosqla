<?php 
$pageTitle = "Dashboard Pelamar - BKK DOSQLA";
$allowedRole = "pelamar"; // Proteksi agar halaman ini hanya bisa dibuka oleh pelamar
require_once ROOT_PATH . 'app/views/ekstra/header.php'; 
?>

<!-- Extra Inline Style untuk Penyesuaian Warna BKK DOSQLA -->
<style>
    :root {
        --bkk-navy-dark: #0D1033;
        --bkk-navy-blue: #0F4C81;
        --bkk-sky-blue: #71C9CE;
        --bkk-orange: #F2994A;
    }

    .bg-bkk-header {
        background: linear-gradient(135deg, #0D1033 0%, #0F4C81 100%);
    }

    .btn-bkk-primary {
        background-color: #F2994A;
        color: #ffffff;
        transition: all 0.2s ease-in-out;
    }

    .btn-bkk-primary:hover {
        background-color: #e08332;
        box-shadow: 0 4px 14px rgba(242, 153, 74, 0.35);
    }

    .text-bkk-navy {
        color: #0D1033;
    }

    .text-bkk-blue {
        color: #0F4C81;
    }
</style>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Hero Welcome Banner -->
    <div class="bg-bkk-header rounded-2xl p-6 sm:p-8 text-white mb-8 shadow-lg relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-56 h-56 bg-[#71C9CE]/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs text-[#71C9CE] font-semibold mb-3">
                <i class="fa-solid fa-graduation-cap"></i> Portal Alumni & Pelamar
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mb-2">
                Selamat Datang Kembali, <?= $_SESSION['username'] ?? 'Pelamar'; ?>! 👋
            </h1>
            <p class="text-sky-100/80 text-xs sm:text-sm max-w-2xl leading-relaxed">
                Pantau status lamaran pekerjaan dan kelola profil kelulusan Anda secara terpadu di BKK DOSQLA.
            </p>
        </div>
    </div>

    <!-- Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <!-- Total Lamaran -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Total Lamaran</p>
                <p class="text-2xl font-extrabold text-[#0D1033] mt-1">5</p>
            </div>
            <div class="w-11 h-11 bg-sky-50 text-[#0F4C81] rounded-xl flex items-center justify-center text-lg border border-sky-100">
                <i class="fa-solid fa-paper-plane"></i>
            </div>
        </div>

        <!-- Dalam Proses -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Dalam Proses</p>
                <p class="text-2xl font-extrabold text-[#F2994A] mt-1">2</p>
            </div>
            <div class="w-11 h-11 bg-amber-50 text-[#F2994A] rounded-xl flex items-center justify-center text-lg border border-amber-100">
                <i class="fa-solid fa-spinner animate-spin"></i>
            </div>
        </div>

        <!-- Diterima / Lolos -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Diterima / Lolos</p>
                <p class="text-2xl font-extrabold text-emerald-600 mt-1">1</p>
            </div>
            <div class="w-11 h-11 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-lg border border-emerald-100">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

        <!-- Tidak Lolos -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Tidak Lolos</p>
                <p class="text-2xl font-extrabold text-rose-600 mt-1">2</p>
            </div>
            <div class="w-11 h-11 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center text-lg border border-rose-100">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
            <div>
                <h2 class="font-extrabold text-[#0D1033] text-lg">Riwayat Lamaran Pekerjaan</h2>
                <p class="text-slate-400 text-xs mt-0.5">Daftar riwayat posisi kerja yang telah Anda lamar.</p>
            </div>
            <a href="<?= BASE_URL ?>jobs" class="inline-flex items-center gap-2 px-4 py-2 btn-bkk-primary rounded-xl text-xs font-bold no-underline self-start sm:self-auto">
                <i class="fa-solid fa-plus text-xs"></i> Cari Lowongan Baru
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#0D1033] text-white text-[11px] uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-6">Posisi Lowongan</th>
                        <th class="py-3.5 px-6">Perusahaan</th>
                        <th class="py-3.5 px-6">Tanggal Apply</th>
                        <th class="py-3.5 px-6">Berkas Uploaded</th>
                        <th class="py-3.5 px-6">Status Lamaran</th>
                        <th class="py-3.5 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs sm:text-sm text-slate-700">
                    <!-- Row 1 -->
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-4 px-6 font-bold text-[#0D1033]">Teknisi Network Junior</td>
                        <td class="py-4 px-6 font-medium text-slate-600">
                            <span class="inline-flex items-center gap-1.5">
                                <i class="fa-solid fa-building text-slate-400 text-xs"></i> PT Telkom Indonesia
                            </span>
                        </td>
                        <td class="py-4 px-6 text-slate-500">12 Mei 2024</td>
                        <td class="py-4 px-6">
                            <a href="<?= BASE_URL ?>public/uploads/cv_ahmad.pdf" target="_blank" class="text-[#0F4C81] hover:underline inline-flex items-center gap-1.5 font-medium text-xs">
                                <i class="fa-solid fa-file-pdf text-rose-500 text-sm"></i> CV_Ahmad.pdf
                            </a>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-50 text-amber-700 text-[11px] font-bold rounded-full border border-amber-200">
                                <i class="fa-solid fa-clock text-[10px]"></i> Dalam Proses
                            </span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <a href="<?= BASE_URL ?>jobs/detail/1" class="inline-flex items-center gap-1 text-slate-600 hover:text-[#0F4C81] bg-slate-100 hover:bg-slate-200 text-xs font-bold px-3 py-1.5 rounded-lg transition no-underline">
                                <i class="fa-solid fa-eye text-xs"></i> Lihat Detail
                            </a>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-4 px-6 font-bold text-[#0D1033]">Operator Produksi</td>
                        <td class="py-4 px-6 font-medium text-slate-600">
                            <span class="inline-flex items-center gap-1.5">
                                <i class="fa-solid fa-building text-slate-400 text-xs"></i> PT Astra Honda Motor
                            </span>
                        </td>
                        <td class="py-4 px-6 text-slate-500">01 April 2024</td>
                        <td class="py-4 px-6">
                            <a href="<?= BASE_URL ?>public/uploads/cv_ahmad.pdf" target="_blank" class="text-[#0F4C81] hover:underline inline-flex items-center gap-1.5 font-medium text-xs">
                                <i class="fa-solid fa-file-pdf text-rose-500 text-sm"></i> CV_Ahmad.pdf
                            </a>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-50 text-emerald-700 text-[11px] font-bold rounded-full border border-emerald-200">
                                <i class="fa-solid fa-circle-check text-[10px]"></i> Lolos Seleksi
                            </span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <a href="<?= BASE_URL ?>jobs/detail/2" class="inline-flex items-center gap-1 text-slate-600 hover:text-[#0F4C81] bg-slate-100 hover:bg-slate-200 text-xs font-bold px-3 py-1.5 rounded-lg transition no-underline">
                                <i class="fa-solid fa-eye text-xs"></i> Lihat Detail
                            </a>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-4 px-6 font-bold text-[#0D1033]">Staff Admin Gudang</td>
                        <td class="py-4 px-6 font-medium text-slate-600">
                            <span class="inline-flex items-center gap-1.5">
                                <i class="fa-solid fa-building text-slate-400 text-xs"></i> CV Maju Bersama
                            </span>
                        </td>
                        <td class="py-4 px-6 text-slate-500">15 Maret 2024</td>
                        <td class="py-4 px-6">
                            <a href="<?= BASE_URL ?>public/uploads/cv_ahmad.pdf" target="_blank" class="text-[#0F4C81] hover:underline inline-flex items-center gap-1.5 font-medium text-xs">
                                <i class="fa-solid fa-file-pdf text-rose-500 text-sm"></i> CV_Ahmad.pdf
                            </a>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-rose-50 text-rose-700 text-[11px] font-bold rounded-full border border-rose-200">
                                <i class="fa-solid fa-circle-xmark text-[10px]"></i> Tidak Lolos
                            </span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <a href="<?= BASE_URL ?>jobs/detail/3" class="inline-flex items-center gap-1 text-slate-600 hover:text-[#0F4C81] bg-slate-100 hover:bg-slate-200 text-xs font-bold px-3 py-1.5 rounded-lg transition no-underline">
                                <i class="fa-solid fa-eye text-xs"></i> Lihat Detail
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>

</body>
</html>