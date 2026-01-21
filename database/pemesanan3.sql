-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 21, 2026 at 11:48 AM
-- Server version: 8.0.30
-- PHP Version: 8.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pemesanan3`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwals`
--

CREATE TABLE `jadwals` (
  `id` bigint UNSIGNED NOT NULL,
  `lapangan_id` bigint UNSIGNED NOT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `status` enum('available','booked') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwals`
--

INSERT INTO `jadwals` (`id`, `lapangan_id`, `tanggal_mulai`, `tanggal_selesai`, `jam_mulai`, `jam_selesai`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, '2026-01-21', '2026-01-22', NULL, NULL, 'booked', '2026-01-19 22:55:06', '2026-01-20 00:10:01'),
(2, 2, '2026-01-20', '2026-01-20', '00:00:00', '23:59:00', 'available', '2026-01-19 22:56:36', '2026-01-19 22:56:36'),
(3, 3, '2026-01-20', '2026-01-31', NULL, NULL, 'available', '2026-01-19 22:56:58', '2026-01-19 22:56:58'),
(4, 3, '2026-01-20', '2026-01-20', '00:00:00', '23:59:00', 'available', '2026-01-19 22:57:21', '2026-01-19 22:57:21'),
(5, 1, '2026-01-20', '2026-01-20', '00:00:00', '23:59:00', 'available', '2026-01-19 22:58:24', '2026-01-19 22:58:24'),
(6, 1, '2026-01-20', '2026-01-31', NULL, NULL, 'available', '2026-01-19 22:58:42', '2026-01-19 22:58:42'),
(7, 2, '2026-01-20', '2026-01-20', NULL, NULL, 'available', '2026-01-20 00:10:01', '2026-01-20 00:10:01'),
(8, 2, '2026-01-23', '2026-01-31', NULL, NULL, 'available', '2026-01-20 00:10:01', '2026-01-20 00:10:01');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lapangans`
--

CREATE TABLE `lapangans` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_lapangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga_per_jam` int NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lapangans`
--

INSERT INTO `lapangans` (`id`, `nama_lapangan`, `jenis`, `foto`, `harga_per_jam`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Lapangan Basket', 'Basket', 'foto_lapangan/Enc7E0P2I6xU0RJWBSgQCQ7IjBnXfzlS9piw4AOP.jpg', 100000, 'Lapangan basket adalah area permainan bola basket yang digunakan untuk pertandingan atau latihan, baik di dalam ruangan (indoor) maupun luar ruangan (outdoor). Lapangan basket outdoor biasanya memiliki permukaan beton atau aspal agar tahan terhadap cuaca dan penggunaan jangka panjang.\r\nUkuran lapangan basket standar:\r\nPanjang: 28 meter\r\nLebar: 15 meter\r\nTinggi ring: 3,05 meter\r\nDiameter ring: 45 cm\r\nJarak garis lemparan bebas ke papan pantul: 4,6 meter\r\nUkuran papan pantul:\r\nLebar: 1,80 meter\r\nTinggi: 1,05 meter', '2026-01-19 22:47:19', '2026-01-20 07:29:21'),
(2, 'Lapangan Volly Outdoor', 'Volly', 'foto_lapangan/QEYoMNH7iIzwC0xBk3QVTGvInneWHRagwj2qRVV5.jpg', 100000, 'Lapangan voli outdoor adalah area bermain voli yang berada di dalam ruangan terbuka, biasanya digunakan untuk pertandingan resmi maupun latihan. Lapangan ini memiliki permukaan datar dan rata, terbuat dari bahan seperti vinyl, kayu, atau sintetis agar aman dan nyaman bagi pemain.\r\nUkuran lapangan voli indoor standar (sesuai FIVB):\r\nPanjang lapangan: 18 meter\r\nLebar lapangan: 9 meter\r\nLapangan dibagi dua sama besar oleh net, masing-masing 9 × 9 meter\r\nLebar garis lapangan: 5 cm\r\nTinggi net:\r\nPutra: 2,43 meter\r\nPutri: 2,24 meter', '2026-01-19 22:52:58', '2026-01-20 07:29:45'),
(3, 'Lapangan Futsal 1', 'Futsal', 'foto_lapangan/iXoVnUf3cUrMK9jY2prny9TBc4RIyMyo2haSQWVw.jpg', 100000, 'Lapangan futsal adalah lapangan permainan sepak bola mini yang dimainkan oleh dua tim, masing-masing lima pemain, dan biasanya berada di dalam ruangan (indoor) maupun luar ruangan (outdoor). Permukaan lapangan futsal umumnya menggunakan vinyl, semen halus, atau rumput sintetis khusus futsal agar permainan lebih cepat dan terkontrol.\r\nUkuran lapangan futsal standar (FIFA):\r\nPanjang: 25–42 meter\r\nLebar: 15–25 meter\r\nUkuran gawang:\r\nLebar: 3 meter\r\nTinggi: 2 meter\r\nTitik penalti:\r\nPenalti pertama: 6 meter dari garis gawang\r\nPenalti kedua: 10 meter dari garis gawang\r\nLingkaran tengah: Radius 3 meter', '2026-01-19 22:54:09', '2026-01-20 07:30:05');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_19_141656_create_lapangans_table', 1),
(5, '2026_01_19_141717_create_jadwals_table', 1),
(6, '2026_01_19_141735_create_reservasis_table', 1),
(7, '2026_01_19_141748_create_pembayarans_table', 1),
(8, '2026_01_20_005151_add_expired_at_to_pembayarans_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayarans`
--

CREATE TABLE `pembayarans` (
  `id` bigint UNSIGNED NOT NULL,
  `reservasi_id` bigint UNSIGNED NOT NULL,
  `metode` enum('transfer','cash') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `bukti_transfer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('valid','tidak valid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tidak valid',
  `expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayarans`
--

INSERT INTO `pembayarans` (`id`, `reservasi_id`, `metode`, `jumlah`, `bukti_transfer`, `status`, `expired_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'transfer', 4800000, 'bukti_transfer/QwhALsvUKTp6ygdP8hUaGe7Gaf7ZpZhuXRv8TZIB.jpg', 'valid', '2026-01-20 00:40:30', '2026-01-20 00:10:30', '2026-01-20 00:11:25');

-- --------------------------------------------------------

--
-- Table structure for table `reservasis`
--

CREATE TABLE `reservasis` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `lapangan_id` bigint UNSIGNED NOT NULL,
  `jadwal_id` bigint UNSIGNED NOT NULL,
  `tipe_sewa` enum('harian','jam') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `total_harga` int NOT NULL,
  `status` enum('pending','disetujui','ditolak','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservasis`
--

INSERT INTO `reservasis` (`id`, `user_id`, `lapangan_id`, `jadwal_id`, `tipe_sewa`, `tanggal_mulai`, `tanggal_selesai`, `jam_mulai`, `jam_selesai`, `total_harga`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 1, 'harian', '2026-01-21', '2026-01-22', '00:00:00', '23:59:00', 4800000, 'disetujui', '2026-01-20 00:10:01', '2026-01-20 00:11:25');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('cvHR3MlSzM9HF0WqGJNCEPSlDmV0W3KoM8GMKdJK', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 OPR/126.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRFpmYjA4R1RyUkRRSFhHUVJJY1JFR01acEsxZ1VBYkl3S00xU1hRVSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC91c2VyL2xhcGFuZ2FuIjtzOjU6InJvdXRlIjtzOjE5OiJ1c2VyLmxhcGFuZ2FuLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1768919526),
('NOcFEJ9UijUpEYD8YjxXXPmyZLsTgxU8MeiU2TTd', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 OPR/125.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ2RVckVpVWtLTGExVkdrdzFFZlBmNDhRcXhYSE9xak5NYWZWTDdzZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC91c2VyL2xhcGFuZ2FuIjtzOjU6InJvdXRlIjtzOjE5OiJ1c2VyLmxhcGFuZ2FuLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1768893585);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '2026-01-19 22:46:15', '$2y$12$xgT5kQgClz/ZDaR5mCplHO6rqrOizyYlKelJKmkYNpjHIM6hRsM.K', 'admin', 'X4a2VY6MyXtPKpqgYRIeBAPwENpPyJEqwQ5dkHvsYbF5Do8ggMCemj2uf2o8', '2026-01-19 22:46:15', '2026-01-19 22:46:15'),
(2, 'User', 'user@gmail.com', '2026-01-19 22:46:15', '$2y$12$IZaNJKbrZOo3WF5if6Q5teAoGMU01vG2KpJG0jDV14hMixqjTl6Ue', 'user', '4t2YuWqoTbywBlAjjGCnRpXkayL4SzyKSV9nPLRadx2RmL6ExdAxNteFhvuq', '2026-01-19 22:46:16', '2026-01-19 22:46:16'),
(4, 'Bunga ayu', 'bungayu@gmail.com', NULL, '$2y$12$GOY9RyC2MqvMpYocGICs/OP18/6fSkOwEMWF8T3bd6cNtc.Mgpp9a', 'user', NULL, '2026-01-20 07:31:44', '2026-01-20 07:31:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jadwals`
--
ALTER TABLE `jadwals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwals_lapangan_id_foreign` (`lapangan_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lapangans`
--
ALTER TABLE `lapangans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayarans_reservasi_id_foreign` (`reservasi_id`);

--
-- Indexes for table `reservasis`
--
ALTER TABLE `reservasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservasis_user_id_foreign` (`user_id`),
  ADD KEY `reservasis_lapangan_id_foreign` (`lapangan_id`),
  ADD KEY `reservasis_jadwal_id_foreign` (`jadwal_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwals`
--
ALTER TABLE `jadwals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lapangans`
--
ALTER TABLE `lapangans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pembayarans`
--
ALTER TABLE `pembayarans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservasis`
--
ALTER TABLE `reservasis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwals`
--
ALTER TABLE `jadwals`
  ADD CONSTRAINT `jadwals_lapangan_id_foreign` FOREIGN KEY (`lapangan_id`) REFERENCES `lapangans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD CONSTRAINT `pembayarans_reservasi_id_foreign` FOREIGN KEY (`reservasi_id`) REFERENCES `reservasis` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservasis`
--
ALTER TABLE `reservasis`
  ADD CONSTRAINT `reservasis_jadwal_id_foreign` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservasis_lapangan_id_foreign` FOREIGN KEY (`lapangan_id`) REFERENCES `lapangans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservasis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
