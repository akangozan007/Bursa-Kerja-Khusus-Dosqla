<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelamar - BKK DOSQLA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <nav class="bg-blue-600 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <!-- BASE_URL untuk Gambar Logo -->
                    <img src="<?= BASE_URL ?>public/img/logo.png" alt="Logo BKK" class="h-9 w-auto">
                    <span class="font-bold text-xl tracking-wide">BKK DOSQLA</span>
                </div>
                <div class="flex items-center space-x-4 text-sm font-medium">
                    <!-- BASE_URL untuk Link Navigation -->
                    <a href="<?= BASE_URL ?>jobs" class="hover:bg-blue-700 px-3 py-2 rounded-lg transition">Cari Lowongan</a>
                    <a href="<?= BASE_URL ?>pelamar" class="bg-blue-800 px-3 py-2 rounded-lg">Riwayat Lamaran</a>
                    <a href="<?= BASE_URL ?>applicant/profile" class="hover:bg-blue-700 px-3 py-2 rounded-lg transition">Profil Saya</a>
                    <a href="<?= BASE_URL ?>logout" class="bg-orange-500 hover:bg-orange-600 px-3 py-2 rounded-lg transition font-semibold">Keluar</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white mb-8 shadow-lg">
            <h1 class="text-2xl font-bold mb-2">Selamat Datang Kembali, <?= $_SESSION['username'] ?? 'Pelamar'; ?>! 👋</h1>
            <p class="text-blue-100 text-sm">Pantau status lamaran pekerjaan dan kelola profil kelulusan Anda di BKK DOSQLA.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Total Lamaran</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">5</p>
                </div>
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-lg">
                    <i class="fa-solid fa-paper-plane"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Dalam Proses</p>
                    <p class="text-2xl font-bold text-amber-600 mt-1">2</p>
                </div>
                <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center text-lg">
                    <i class="fa-solid fa-spinner"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Diterima / Lolos</p>
                    <p class="text-2xl font-bold text-emerald-600 mt-1">1</p>
                </div>
                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center text-lg">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Tidak Lolos</p>
                    <p class="text-2xl font-bold text-rose-600 mt-1">2</p>
                </div>
                <div class="w-10 h-10 bg-rose-50 text-rose-600 rounded-full flex items-center justify-center text-lg">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h2 class="font-bold text-gray-800 text-lg">Riwayat Lamaran Pekerjaan</h2>
                <a href="<?= BASE_URL ?>jobs" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ Cari Lowongan Baru</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                            <th class="py-3 px-6">Posisi Lowongan</th>
                            <th class="py-3 px-6">Perusahaan</th>
                            <th class="py-3 px-6">Tanggal Apply</th>
                            <th class="py-3 px-6">Berkas Uploaded</th>
                            <th class="py-3 px-6">Status Lamaran</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-6 font-semibold text-gray-900">Teknisi Network Junior</td>
                            <td class="py-4 px-6">PT Telkom Indonesia</td>
                            <td class="py-4 px-6">12 Mei 2024</td>
                            <td class="py-4 px-6">
                                <!-- BASE_URL untuk File Download -->
                                <a href="<?= BASE_URL ?>public/uploads/cv_ahmad.pdf" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1 text-xs">
                                    <i class="fa-solid fa-file-pdf text-rose-500"></i> CV_Ahmad.pdf
                                </a>
                            </td>
                            <td class="py-4 px-6">
                                <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-amber-200">
                                    Dalam Proses
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <a href="<?= BASE_URL ?>jobs/detail/1" class="text-gray-500 hover:text-blue-600 text-xs font-medium border px-2.5 py-1 rounded">Lihat Detail</a>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-6 font-semibold text-gray-900">Operator Produksi</td>
                            <td class="py-4 px-6">PT Astra Honda Motor</td>
                            <td class="py-4 px-6">01 April 2024</td>
                            <td class="py-4 px-6">
                                <a href="<?= BASE_URL ?>public/uploads/cv_ahmad.pdf" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1 text-xs">
                                    <i class="fa-solid fa-file-pdf text-rose-500"></i> CV_Ahmad.pdf
                                </a>
                            </td>
                            <td class="py-4 px-6">
                                <span class="bg-emerald-100 text-emerald-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-emerald-200">
                                    Lolos Seleksi
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <a href="<?= BASE_URL ?>jobs/detail/2" class="text-gray-500 hover:text-blue-600 text-xs font-medium border px-2.5 py-1 rounded">Lihat Detail</a>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-6 font-semibold text-gray-900">Staff Admin Gudang</td>
                            <td class="py-4 px-6">CV Maju Bersama</td>
                            <td class="py-4 px-6">15 Maret 2024</td>
                            <td class="py-4 px-6">
                                <a href="<?= BASE_URL ?>public/uploads/cv_ahmad.pdf" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1 text-xs">
                                    <i class="fa-solid fa-file-pdf text-rose-500"></i> CV_Ahmad.pdf
                                </a>
                            </td>
                            <td class="py-4 px-6">
                                <span class="bg-rose-100 text-rose-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-rose-200">
                                    Tidak Lolos
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <a href="<?= BASE_URL ?>jobs/detail/3" class="text-gray-500 hover:text-blue-600 text-xs font-medium border px-2.5 py-1 rounded">Lihat Detail</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>