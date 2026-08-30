<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lowongan Pekerjaan - BKK DOSQLA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <main class="max-w-4xl mx-auto px-4 py-10">
        <a href="/jobs" class="inline-flex items-center text-sm text-blue-600 hover:underline mb-6">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar Lowongan
        </a>

        <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm mb-8">
            <div class="flex justify-between items-start border-b border-gray-100 pb-6 mb-6">
                <div>
                    <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">Full Time</span>
                    <h1 class="text-2xl font-bold text-gray-900 mt-2">Junior Web Developer</h1>
                    <p class="text-gray-500 text-sm mt-1"><i class="fa-solid fa-building mr-1"></i> PT Teknologi Nusantara</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400">Batas Akhir Pendaftaran</p>
                    <p class="text-sm font-semibold text-rose-600 mt-0.5"><i class="fa-solid fa-calendar-xmark mr-1"></i> 30 Juni 2024</p>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <h3 class="font-bold text-gray-800 text-base mb-2">Deskripsi Pekerjaan:</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Bertanggung jawab dalam pengembangan dan pemeliharaan aplikasi berbasis web perusahaan, bekerja sama dengan tim UI/UX dan Tim Backend untuk memberikan performa sistem yang optimal.
                    </p>
                </div>

                <div>
                    <h3 class="font-bold text-gray-800 text-base mb-2">Kualifikasi Alumni:</h3>
                    <ul class="list-disc list-inside text-sm text-gray-600 leading-relaxed space-y-1">
                        <li>Lulusan SMK Jurusan Rekayasa Perangkat Lunak / TKJ.</li>
                        <li>Memahami konsep dasar PHP (MVC framework sederhana), HTML, CSS, JavaScript.</li>
                        <li>Dapat bekerja secara individu maupun tim.</li>
                        <li>Memiliki kedisiplinan dan semangat belajar tinggi.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Lamar Pekerjaan Ini</h2>

            <form action="/applicant/apply" method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="job_id" value="1">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Unggah Berkas CV / Surat Lamaran (PDF)</label>
                    <input type="file" name="cv_file" required accept=".pdf"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-xl p-1">
                    <p class="text-xs text-gray-400 mt-1">Ukuran berkas maks. 2MB. Format file harus PDF dan disimpan ke folder <code>public/uploads/</code>.</p>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl transition shadow-md">
                    <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Lamaran Sekarang
                </button>
            </form>
        </div>
    </main>

</body>
</html>