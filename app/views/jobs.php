<?php
// Load header utama (Memuat background hero, navbar, dan CSS global)
require_once ROOT_PATH . 'app/views/header_public.php';

$baseUrl = defined('BASEURL') ? BASEURL : (defined('BASE_URL') ? BASE_URL : '');
?>

<!-- Import CDN Bootstrap CSS & Custom Styling Halaman Jobs -->
<style>
    /* Import CDN Bootstrap 5 CSS langsung di dalam tag style */
    @import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
    @import url('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css');

    /* Custom Glassmorphism Theme (Match Homepage) */
    .glass-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .glass-card:hover {
        transform: translateY(-8px);
        background: rgba(255, 255, 255, 0.14);
        border-color: rgba(249, 115, 22, 0.6); /* Glowing Orange Accent */
        box-shadow: 0 20px 35px -10px rgba(249, 115, 22, 0.35);
    }
    .glass-input {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }
    .glass-input::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }
    .glass-input:focus {
        background: rgba(255, 255, 255, 0.2);
        border-color: #f97316;
        outline: none;
        box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.3);
    }
</style>

<!-- Container Utama -->
<div class="container py-8 my-auto relative" style="z-index: 10;">

    <!-- Hero Section / Title -->
    <div class="text-center max-w-3xl mx-auto mb-10 hero-content-anim delay-1">
        <span class="inline-block text-xs font-extrabold uppercase tracking-widest text-orange-400 bg-orange-500/20 px-4 py-1.5 rounded-full border border-orange-500/30 backdrop-blur-md mb-3">
            <i class="bi bi-briefcase-fill mr-1"></i> Peluang Karir Terbaru
        </span>
        <h1 class="text-3xl md:text-5xl font-black text-white tracking-tight leading-tight wavy-text">
            Temukan Pekerjaan Impian Anda
        </h1>
        <p class="text-blue-100/80 text-sm md:text-base mt-3 max-w-2xl mx-auto">
            Jelajahi berbagai lowongan pekerjaan resmi BKK DOSQLA. Terhubung langsung dengan puluhan perusahaan mitra industri terkemuka[cite: 1].
        </p>

        <!-- Live Search & Interactive Filter Bar -->
        <div class="mt-8 max-w-xl mx-auto relative flex items-center">
            <i class="bi bi-search absolute left-4 text-orange-400 text-lg"></i>
            <input type="text" id="jobSearchInput" placeholder="Cari posisi pekerjaan atau nama perusahaan..." 
                   class="glass-input w-full pl-11 pr-10 py-3.5 rounded-2xl text-sm transition-all shadow-lg placeholder:text-blue-100/60">
            <button id="clearSearch" class="absolute right-3 text-white/50 hover:text-white hidden transition-colors">
                <i class="bi bi-x-circle-fill text-lg"></i>
            </button>
        </div>
    </div>

    <!-- Grid List Lowongan Pekerjaan -->
    <div id="jobsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 hero-content-anim delay-2">
        <?php if (!empty($jobs)): ?>
            <?php foreach ($jobs as $j): ?>
                <?php 
                    $id         = $j['id'];
                    $judul      = htmlspecialchars($j['judul'] ?? 'Lowongan Kerja');
                    $perusahaan = htmlspecialchars($j['perusahaan'] ?? 'Perusahaan');
                    $deskripsi  = htmlspecialchars($j['deskripsi'] ?? 'Tidak ada deskripsi rinci.');
                    $tanggal    = !empty($j['created_at']) ? date('d M Y', strtotime($j['created_at'])) : '-';
                ?>
                <div class="job-card glass-card rounded-2xl p-6 flex flex-col justify-between group" 
                     data-title="<?= strtolower($judul); ?>" 
                     data-company="<?= strtolower($perusahaan); ?>">
                    <div>
                        <!-- Header Card & Logo Placeholder -->
                        <div class="flex items-center gap-3.5 mb-4">
                            <div class="w-12 h-12 rounded-xl bg-orange-500/20 border border-orange-500/30 text-orange-400 flex items-center justify-center font-bold text-xl group-hover:bg-orange-500 group-hover:text-white transition-all duration-300 shadow-md">
                                <i class="bi bi-building"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-orange-400 uppercase tracking-wider line-clamp-1"><?= $perusahaan; ?></p>
                                <p class="text-[11px] text-blue-200/60 flex items-center gap-1 mt-0.5">
                                    <i class="bi bi-clock-history text-orange-400/80"></i> <?= $tanggal; ?>
                                </p>
                            </div>
                        </div>

                        <!-- Judul Lowongan -->
                        <h3 class="text-lg font-bold text-white line-clamp-1 mb-2 group-hover:text-orange-300 transition-colors">
                            <?= $judul; ?>
                        </h3>

                        <!-- Deskripsi Singkat -->
                        <p class="text-xs text-blue-100/70 line-clamp-3 leading-relaxed mb-6">
                            <?= $deskripsi; ?>
                        </p>
                    </div>

                    <!-- Action Button & Status Badge -->
                    <div class="pt-4 border-t border-white/10 flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Active
                        </span>
                        
                        <a href="<?= $baseUrl; ?>auth/login" 
                           class="inline-flex items-center gap-2 text-xs font-bold text-white bg-orange-500 hover:bg-orange-600 px-4 py-2.5 rounded-xl transition-all duration-200 shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 hover:scale-[1.02]">
                            Lamar Sekarang <i class="bi bi-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full text-center py-16 glass-card rounded-2xl border border-dashed border-white/20">
                <i class="bi bi-briefcase text-5xl text-orange-400/50 mb-3 block"></i>
                <h3 class="text-white font-bold text-lg">Belum Ada Lowongan Tersedia</h3>
                <p class="text-blue-100/60 text-xs mt-1">Silakan cek kembali secara berkala untuk pembaruan informasi lowongan pekerjaan.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- State Ketika Pencarian Tidak Ditemukan -->
    <div id="noResults" class="hidden text-center py-16 glass-card rounded-2xl border border-dashed border-white/20">
        <i class="bi bi-search text-4xl text-orange-400/50 mb-3 block"></i>
        <h3 class="text-white font-bold text-lg">Lowongan Tidak Ditemukan</h3>
        <p class="text-blue-100/60 text-xs mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
    </div>

</div>

</div> <!-- Penutup .hero-wrapper -->

<!-- JS Bootstrap 5 & Interaktivitas -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        initWavyText();
        initLiveSearch();
        setTimeout(initSlidingPill, 100);
    });

    function initLiveSearch() {
        const searchInput = document.getElementById('jobSearchInput');
        const clearBtn = document.getElementById('clearSearch');
        const jobCards = document.querySelectorAll('.job-card');
        const noResults = document.getElementById('noResults');

        if (!searchInput) return;

        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            let visibleCount = 0;

            if (query.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }

            jobCards.forEach(card => {
                const title = card.getAttribute('data-title');
                const company = card.getAttribute('data-company');

                if (title.includes(query) || company.includes(query)) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (visibleCount === 0 && jobCards.length > 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        });

        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
            searchInput.focus();
        });
    }

    function initWavyText() {
        const wavyElements = document.querySelectorAll('.wavy-text');
        wavyElements.forEach(el => {
            const nodes = Array.from(el.childNodes);
            el.innerHTML = '';
            nodes.forEach(node => {
                if (node.nodeType === Node.TEXT_NODE) {
                    const text = node.textContent;
                    for (let i = 0; i < text.length; i++) {
                        const char = text[i];
                        if (char === ' ') {
                            el.appendChild(document.createTextNode(' '));
                        } else {
                            const span = document.createElement('span');
                            span.classList.add('wave-char');
                            span.textContent = char;
                            span.style.animationDelay = `${(i * 0.12) % 2}s`;
                            el.appendChild(span);
                        }
                    }
                } else {
                    el.appendChild(node);
                }
            });
        });
    }

    function initSlidingPill() {
        const navMenu = document.getElementById('navMenu');
        const slidingPill = document.getElementById('slidingPill');
        const navLinks = document.querySelectorAll('.nav-link-custom');
        
        if (!navMenu || !slidingPill) return;

        let activeLink = document.querySelector('.nav-link-custom.active-pill') || navLinks[1];

        function movePillTo(element) {
            if (!element) return;
            const menuRect = navMenu.getBoundingClientRect();
            const elemRect = element.getBoundingClientRect();

            slidingPill.style.width = `${elemRect.width}px`;
            slidingPill.style.height = `${elemRect.height}px`;
            slidingPill.style.transform = `translate(${elemRect.left - menuRect.left}px, ${elemRect.top - menuRect.top}px)`;
            slidingPill.style.opacity = '1';
        }

        movePillTo(activeLink);

        navLinks.forEach(link => {
            link.addEventListener('mouseenter', function() { movePillTo(this); });
        });

        navMenu.addEventListener('mouseleave', function() { movePillTo(activeLink); });
        window.addEventListener('resize', function() { movePillTo(activeLink); });
    }
</script>
</body>
</html>