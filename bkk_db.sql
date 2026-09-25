-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2026 at 07:17 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bkk_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cv_file` varchar(255) NOT NULL,
  `status` enum('proses','lolos','tidak_lolos') DEFAULT 'proses',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lowongan`
--

CREATE TABLE `lowongan` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `perusahaan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lowongan`
--

INSERT INTO `lowongan` (`id`, `judul`, `deskripsi`, `perusahaan`, `created_at`) VALUES
(1, 'Web Developer (Fullstack)', 'Bertanggung jawab untuk mengembangkan dan memelihara aplikasi web berbasis PHP MVC, Laravel, dan MySQL. Menguasai HTML, CSS, JavaScript, serta REST API.', 'PT Teknologi Nusantara', '2026-09-02 04:58:35'),
(2, 'Teknisi Komputer & Jaringan', 'Melakukan perawatan hardware, troubleshooting sistem operasi Windows/Linux, perakitan PC, serta konfigurasi jaringan LAN/MikroTik di lingkungan kantor.', 'CV Solusi Perkasa', '2026-09-02 04:58:35'),
(3, 'Graphic Designer & UI/UX', 'Membuat desain antarmuka aplikasi web/mobile, aset media sosial, serta banner promosi. Menguasai Figma, Adobe Photoshop, dan Illustrator.', 'Studio Visual Cipta', '2026-09-02 04:58:35'),
(4, 'Staff Administrasi Digital', 'Mengelola data operasional harian, membuat laporan berbasis Excel/Google Sheets, serta melayani komunikasi administratif perusahaan.', 'PT Utama Jaya Mandiri', '2026-09-02 04:58:35'),
(5, 'Customer Support Specialist', 'Memberikan pelayanan dan bantuan teknis kepada pelanggan terkait produk/jasa perusahaan melalui tiket bantuan, live chat, dan telepon.', 'PT Media Karya Sentosa', '2026-09-02 04:58:35');

-- --------------------------------------------------------

--
-- Table structure for table `pelamar`
--

CREATE TABLE `pelamar` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `pendidikan_terakhir` varchar(50) DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT 'default.jpg',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `instansi` varchar(100) NOT NULL,
  `role` enum('pelamar','admin') NOT NULL DEFAULT 'pelamar',
  `status` enum('active','blocked') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `instansi`, `role`, `status`, `created_at`) VALUES
(8, 'pelamar123', 'razanrizqullah@gmail.com', '$2y$10$E9nnb8MacdMh0.co3.CSfuS72us.vLdDcLEDgtl4NURSwpkVGpPz2', 'SMK Muhammadiyah 01 Lemahabang', 'pelamar', 'active', '2026-09-07 03:06:04'),
(9, 'admin', 'razanrizqullah02@gmail.com', '$2y$10$3FEsn/xGrXdnTSIP117.8.7z5qWldMd9fI8p.gyN12jAA5hUyHBBC', 'Pengelola BKK', 'admin', 'active', '2026-09-07 03:13:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `lowongan`
--
ALTER TABLE `lowongan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelamar`
--
ALTER TABLE `pelamar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lowongan`
--
ALTER TABLE `lowongan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pelamar`
--
ALTER TABLE `pelamar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
