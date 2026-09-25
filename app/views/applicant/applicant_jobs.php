<!-- ============================================================== -->
<!-- VIEW: Halaman Cari Lowongan Kerja (Internal Pelamar)          -->
<!-- File: app/views/applicant/applicant_jobs.php                 -->
<!-- ============================================================== -->

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

    .focus-bkk:focus {
        border-color: #F2994A !important;
        box-shadow: 0 0 0 3px rgba(242, 153, 74, 0.2) !important;
    }

    .badge-sky {
        background: rgba(113, 201, 206, 0.12);
        color: #0F4C81;
        border: 1px solid rgba(113, 201, 206, 0.4);
    }
</style>

<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-bkk-header rounded-2xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-56 h-56 bg-[#71C9CE]/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs text-[#71C9CE] font-semibold mb-2">
                    <i class="fa-solid fa-briefcase"></i> Portal Karir BKK DOSQLA
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Eksplorasi Lowongan Kerja</h1>
                <p class="text-sky-100/80 text-xs sm:text-sm mt-1 max-w-xl">Temukan peluang karier terbaik yang sesuai dengan minat, keahlian, dan kualifikasi Anda.</p>
            </div>
            <div class="flex items-center gap-2.5 bg-white/10 backdrop-blur-md px-4 py-2.5 rounded-xl border border-white/20 text-xs font-semibold self-start md:self-auto">
                <i class="fa-solid fa-layer-group text-[#F2994A] text-base"></i>
                <span>Tersedia: <strong class="text-white text-sm"><?= count($data['jobs'] ?? []); ?></strong> Lowongan</span>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar Section -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 shadow-sm border border-slate-200/80">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <!-- Input Cari -->
            <div class="relative md:col-span-6">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" id="searchKeyword" placeholder="Cari posisi pekerjaan atau nama perusahaan..." 
                       class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus-bkk focus:bg-white transition text-slate-800 placeholder-slate-400">
            </div>

            <!-- Filter Tipe Pekerjaan -->
            <div class="md:col-span-4">
                <select id="filterType" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus-bkk focus:bg-white transition text-slate-700">
                    <option value="">Semua Tipe Pekerjaan</option>
                    <option value="Full Time">Full Time</option>
                    <option value="Part Time">Part Time</option>
                    <option value="Internship">Magang / Internship</option>
                    <option value="Contract">Kontrak</option>
                </select>
            </div>

            <!-- Tombol Reset -->
            <div class="md:col-span-2">
                <button type="button" id="btnResetFilter" class="w-full h-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-rotate-right text-xs"></i> Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Alert Message Flash -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3 shadow-sm">
            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
            <span class="text-sm font-medium"><?= $_SESSION['success']; unset($_SESSION['success']); ?></span>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl flex items-center gap-3 shadow-sm">
            <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg"></i>
            <span class="text-sm font-medium"><?= $_SESSION['error']; unset($_SESSION['error']); ?></span>
        </div>
    <?php endif; ?>

    <!-- Daftar Lowongan Grid -->
    <?php if (!empty($data['jobs'])): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="jobGridContainer">
            <?php foreach ($data['jobs'] as $job): ?>
                <?php 
                    $jobId       = $job['id'] ?? $job['job_id'] ?? 0;
                    $judul       = htmlspecialchars($job['judul_lowongan'] ?? $job['title'] ?? 'Lowongan Kerja');
                    $perusahaan  = htmlspecialchars($job['nama_perusahaan'] ?? $job['company'] ?? 'Mitra BKK');
                    $lokasi      = htmlspecialchars($job['lokasi'] ?? 'Cirebon & Sekitarnya');
                    $tipe        = htmlspecialchars($job['tipe_pekerjaan'] ?? 'Full Time');
                    $gaji        = htmlspecialchars($job['gaji'] ?? 'Kompetitif');
                    $deskripsi   = htmlspecialchars($job['deskripsi'] ?? 'Tidak ada deskripsi rincian lowongan.');
                    $persyaratan = htmlspecialchars($job['persyaratan'] ?? '-');
                    $deadline    = isset($job['deadline']) ? date('d M Y', strtotime($job['deadline'])) : 'Secepatnya';
                ?>
                <div class="job-card bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between"
                     data-title="<?= strtolower($judul); ?>" 
                     data-company="<?= strtolower($perusahaan); ?>"
                     data-type="<?= $tipe; ?>">
                    <div>
                        <!-- Badge Top -->
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <span class="px-3 py-1 font-semibold text-[11px] rounded-full badge-sky">
                                <?= $tipe; ?>
                            </span>
                            <span class="text-xs text-slate-400 font-medium flex items-center gap-1">
                                <i class="fa-regular fa-clock"></i> s/d <?= $deadline; ?>
                            </span>
                        </div>

                        <!-- Card Content -->
                        <h3 class="font-extrabold text-[#0D1033] text-lg hover:text-[#0F4C81] transition line-clamp-1">
                            <?= $judul; ?>
                        </h3>
                        <p class="text-xs font-bold text-[#0F4C81] mt-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-building text-slate-400"></i> <?= $perusahaan; ?>
                        </p>

                        <div class="mt-4 space-y-2 text-xs text-slate-600 border-t border-b border-slate-100 py-3">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-location-dot text-[#F2994A] w-4 text-center"></i>
                                <span><?= $lokasi; ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-money-bill-wave text-emerald-500 w-4 text-center"></i>
                                <span><?= $gaji; ?></span>
                            </div>
                        </div>

                        <p class="text-slate-500 text-xs mt-3 line-clamp-2 leading-relaxed">
                            <?= $deskripsi; ?>
                        </p>
                    </div>

                    <!-- Footer Action -->
                    <div class="mt-6 pt-2 flex items-center gap-2">
                        <button type="button" 
                                onclick='openDetailModal(<?= json_encode([
                                    "id" => $jobId,
                                    "judul" => $judul,
                                    "perusahaan" => $perusahaan,
                                    "lokasi" => $lokasi,
                                    "tipe" => $tipe,
                                    "gaji" => $gaji,
                                    "deskripsi" => nl2br($deskripsi),
                                    "persyaratan" => nl2br($persyaratan),
                                    "deadline" => $deadline
                                ]); ?>)'
                                class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition text-center">
                            Detail
                        </button>
                        
                        <a href="<?= BASE_URL; ?>pelamar/lamar/<?= $jobId; ?>" 
                           class="flex-1 py-2.5 btn-bkk-primary font-bold rounded-xl text-xs transition text-center no-underline flex items-center justify-center gap-1">
                            Lamar Sekarang
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <!-- Empty State -->
        <div class="bg-white rounded-2xl p-12 text-center border border-slate-200/80 shadow-sm">
            <div class="w-20 h-20 bg-sky-50 text-[#0F4C81] rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                <i class="fa-solid fa-folder-open"></i>
            </div>
            <h3 class="text-lg font-bold text-[#0D1033]">Belum Ada Lowongan Tersedia</h3>
            <p class="text-slate-500 text-sm mt-1 max-w-md mx-auto">Saat ini belum ada data lowongan kerja aktif yang dapat dilamar. Silakan cek kembali di lain waktu.</p>
        </div>
    <?php endif; ?>
</div>

<!-- ============================================================== -->
<!-- MODAL DETAIL LOWONGAN                                          -->
<!-- ============================================================== -->
<div id="modalDetail" class="fixed inset-0 z-50 hidden bg-[#0D1033]/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col shadow-2xl border border-slate-100 animate-in fade-in zoom-in duration-200">
        <!-- Modal Header -->
        <div class="p-5 bg-bkk-header text-white flex items-center justify-between relative">
            <div>
                <span id="modalTipe" class="px-2.5 py-0.5 bg-white/20 text-[#71C9CE] text-[11px] font-semibold rounded-full uppercase tracking-wider border border-white/10"></span>
                <h3 id="modalJudul" class="text-xl font-extrabold mt-1 tracking-tight"></h3>
                <p id="modalPerusahaan" class="text-sky-100/80 text-xs mt-0.5 font-medium flex items-center gap-1">
                    <i class="fa-solid fa-building text-xs"></i> <span id="textPerusahaan"></span>
                </p>
            </div>
            <button onclick="closeDetailModal()" class="text-white/70 hover:text-white text-xl p-2 rounded-lg hover:bg-white/10 transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 overflow-y-auto space-y-5 text-sm">
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 bg-slate-50 p-3.5 rounded-xl text-xs border border-slate-200/70">
                <div>
                    <span class="text-slate-400 block font-medium">Lokasi</span>
                    <strong id="modalLokasi" class="text-[#0D1033]"></strong>
                </div>
                <div>
                    <span class="text-slate-400 block font-medium">Estimasi Gaji</span>
                    <strong id="modalGaji" class="text-[#0D1033]"></strong>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <span class="text-slate-400 block font-medium">Batas Lamaran</span>
                    <strong id="modalDeadline" class="text-[#F2994A]"></strong>
                </div>
            </div>

            <div>
                <h4 class="font-bold text-[#0D1033] border-b border-slate-100 pb-2 flex items-center gap-2">
                    <i class="fa-solid fa-align-left text-[#0F4C81]"></i> Deskripsi Pekerjaan
                </h4>
                <div id="modalDeskripsi" class="text-slate-600 mt-2 leading-relaxed text-xs sm:text-sm"></div>
            </div>

            <div>
                <h4 class="font-bold text-[#0D1033] border-b border-slate-100 pb-2 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-[#0F4C81]"></i> Persyaratan & Kualifikasi
                </h4>
                <div id="modalPersyaratan" class="text-slate-600 mt-2 leading-relaxed text-xs sm:text-sm"></div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
            <button type="button" onclick="closeDetailModal()" class="px-5 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-xl text-xs transition">
                Tutup
            </button>
            <a id="modalBtnLamar" href="#" class="px-6 py-2.5 btn-bkk-primary font-bold rounded-xl text-xs transition shadow-md no-underline">
                Kirim Lamaran
            </a>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- JAVASCRIPT LOGIC (Search, Filter, & Modal)                     -->
<!-- ============================================================== -->
<script>
    // Live Search & Filter Logic
    const searchInput = document.getElementById('searchKeyword');
    const filterSelect = document.getElementById('filterType');
    const btnReset = document.getElementById('btnResetFilter');
    const jobCards = document.querySelectorAll('.job-card');

    function filterJobs() {
        const query = searchInput.value.toLowerCase().trim();
        const selectedType = filterSelect.value;

        jobCards.forEach(card => {
            const title = card.getAttribute('data-title');
            const company = card.getAttribute('data-company');
            const type = card.getAttribute('data-type');

            const matchesSearch = title.includes(query) || company.includes(query);
            const matchesType = selectedType === '' || type === selectedType;

            if (matchesSearch && matchesType) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    if(searchInput) searchInput.addEventListener('input', filterJobs);
    if(filterSelect) filterSelect.addEventListener('change', filterJobs);

    if(btnReset) {
        btnReset.addEventListener('click', () => {
            searchInput.value = '';
            filterSelect.value = '';
            filterJobs();
        });
    }

    // Modal Operations
    function openDetailModal(data) {
        document.getElementById('modalJudul').innerText = data.judul;
        document.getElementById('textPerusahaan').innerText = data.perusahaan;
        document.getElementById('modalTipe').innerText = data.tipe;
        document.getElementById('modalLokasi').innerText = data.lokasi;
        document.getElementById('modalGaji').innerText = data.gaji;
        document.getElementById('modalDeadline').innerText = data.deadline;
        document.getElementById('modalDeskripsi').innerHTML = data.deskripsi;
        document.getElementById('modalPersyaratan').innerHTML = data.persyaratan;
        document.getElementById('modalBtnLamar').href = '<?= BASE_URL; ?>pelamar/lamar/' + data.id;

        document.getElementById('modalDetail').classList.remove('hidden');
    }

    function closeDetailModal() {
        document.getElementById('modalDetail').classList.add('hidden');
    }

    // Close modal on outer click
    window.addEventListener('click', (e) => {
        const modal = document.getElementById('modalDetail');
        if (e.target === modal) {
            closeDetailModal();
        }
    });
</script>