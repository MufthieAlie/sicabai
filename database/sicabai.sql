-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 01, 2026 at 06:40 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sicabai`
--

-- --------------------------------------------------------

--
-- Table structure for table `aturan_gejalas`
--

CREATE TABLE `aturan_gejalas` (
  `id` bigint UNSIGNED NOT NULL,
  `penyakit_id` bigint UNSIGNED NOT NULL,
  `gejala_id` bigint UNSIGNED NOT NULL,
  `cf_pakar` decimal(4,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `aturan_gejalas`
--

INSERT INTO `aturan_gejalas` (`id`, `penyakit_id`, `gejala_id`, `cf_pakar`, `created_at`, `updated_at`) VALUES
(1, 1, 13, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(2, 1, 14, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(3, 1, 15, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(4, 1, 16, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(5, 2, 1, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(6, 2, 2, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(7, 2, 8, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(8, 2, 29, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(9, 3, 7, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(10, 3, 21, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(11, 3, 25, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(12, 4, 9, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(13, 4, 10, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(14, 4, 11, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(15, 5, 21, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(16, 5, 22, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(17, 5, 23, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(18, 6, 30, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(19, 6, 4, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(20, 6, 25, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(21, 7, 4, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(22, 7, 5, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(23, 7, 6, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(24, 7, 25, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(25, 8, 24, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(26, 8, 26, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(27, 8, 8, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(28, 9, 12, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(29, 9, 13, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(30, 9, 11, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(31, 10, 17, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(32, 10, 18, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(33, 10, 26, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(34, 11, 19, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(35, 11, 20, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(36, 11, 27, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(37, 11, 28, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(38, 12, 3, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(39, 12, 26, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(40, 12, 21, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(41, 13, 31, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(42, 13, 32, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(43, 13, 11, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(44, 14, 33, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(45, 14, 34, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(46, 14, 11, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(47, 15, 35, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(48, 15, 36, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(49, 15, 15, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(50, 16, 37, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(51, 16, 8, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(52, 16, 25, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(53, 17, 38, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(54, 17, 11, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(55, 17, 9, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(56, 18, 39, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(57, 18, 40, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(58, 18, 4, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(59, 19, 41, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(60, 19, 21, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(61, 19, 25, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(62, 20, 42, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(63, 20, 43, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(64, 20, 15, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(65, 21, 44, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(66, 21, 45, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(67, 21, 26, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(68, 22, 46, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(69, 22, 47, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(70, 22, 26, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(71, 23, 48, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(72, 23, 26, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(73, 23, 21, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(74, 24, 49, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(75, 24, 15, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(76, 24, 23, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(77, 25, 50, '1.00', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(78, 25, 11, '0.80', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(79, 25, 23, '0.60', '2026-11-01 10:13:22', '2026-11-01 10:13:22');

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
-- Table structure for table `gejalas`
--

CREATE TABLE `gejalas` (
  `id` bigint UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gejalas`
--

INSERT INTO `gejalas` (`id`, `kode`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'G01', 'Warna jaringan akar kecoklatan', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(2, 'G02', 'Akar membusuk dalam tanah', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(3, 'G03', 'Bintil-bintil pada akar', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(4, 'G04', 'Pangkal batang membusuk', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(5, 'G05', 'Muncul benang putih pada pangkal batang', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(6, 'G06', 'Sklerotia coklat seperti biji mustard', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(7, 'G07', 'Batang mengeluarkan lendir bila dipotong', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(8, 'G08', 'Jaringan pembuluh batang berwarna coklat', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(9, 'G09', 'Bercak bulat kering pada daun', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(10, 'G10', 'Bercak daun dengan pusat pucat dan tepi tua', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(11, 'G11', 'Daun menguning dan gugur', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(12, 'G12', 'Bercak gelap cekung pada daun', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(13, 'G13', 'Bercak hitam pada buah', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(14, 'G14', 'Buah keriput dan mengering', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(15, 'G15', 'Buah membusuk lunak', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(16, 'G16', 'Buah berwarna seperti jerami', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(17, 'G17', 'Daun belang hijau tua dan muda (mosaik)', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(18, 'G18', 'Daun mengeriting atau menyempit seperti tali', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(19, 'G19', 'Daun menggulung ke bawah dan keriput', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(20, 'G20', 'Daun hijau pekat mengkilap', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(21, 'G21', 'Daun menguning dan tanaman layu', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(22, 'G22', 'Daun muda menguning cerah dan menebal', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(23, 'G23', 'Daun mengecil dan pertumbuhan terhambat', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(24, 'G24', 'Daun bawah keriting dan menguning', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(25, 'G25', 'Tanaman layu mendadak', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(26, 'G26', 'Tanaman kerdil', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(27, 'G27', 'Ruas batang memendek, daun menumpuk', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(28, 'G28', 'Bunga dan buah berguguran', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(29, 'G29', 'Tanaman layu mulai dari bagian bawah', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(30, 'G30', 'Daun dan batang membusuk saat kelembaban tinggi', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(31, 'G31', 'Bercak coklat konsentris (target spot) pada daun', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(32, 'G32', 'Bercak coklat konsentris pada buah', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(33, 'G33', 'Lapisan putih seperti tepung pada permukaan daun', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(34, 'G34', 'Daun menguning dan kering akibat lapisan tepung', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(35, 'G35', 'Buah membusuk lunak disertai bulu putih', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(36, 'G36', 'Bintik hitam (sporangium) pada buah busuk', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(37, 'G37', 'Batang membusuk coklat dan tanaman mati', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(38, 'G38', 'Bercak kecil coklat dengan titik hitam di tengah daun', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(39, 'G39', 'Tanaman rebah dan mati pada fase semai (damping off)', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(40, 'G40', 'Pangkal batang dekat tanah membusuk coklat', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(41, 'G41', 'Batang mengeluarkan lendir kuning', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(42, 'G42', 'Buah dan batang membusuk lunak berbau busuk', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(43, 'G43', 'Jaringan menjadi berlendir', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(44, 'G44', 'Daun menguning di tepi dan belang kuning', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(45, 'G45', 'Buah kecil dan tidak normal', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(46, 'G46', 'Bercak cincin nekrotik pada daun dan buah', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(47, 'G47', 'Buah cacat akibat bercak cincin', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(48, 'G48', 'Sista (kista) kecil seperti butiran pasir pada akar', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(49, 'G49', 'Ujung buah membusuk kering kecoklatan', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(50, 'G50', 'Daun tua menguning di antara tulang daun (interveinal chlorosis)', '2026-11-01 10:13:22', '2026-11-01 10:13:22');

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
(4, '2026_10_30_035313_create_penyakits_table', 1),
(5, '2026_10_30_035348_create_gejalas_table', 1),
(6, '2026_10_30_035412_create_aturan_gejalas_table', 1),
(7, '2026_10_30_035438_create_riwayat_diagnosis_table', 1),
(8, '2026_10_30_035500_create_sinonim_gejalas_table', 1),
(9, '2026_10_30_041000_add_role_to_users_table', 1),
(10, '2026_10_30_041100_add_user_id_to_riwayat_diagnosis_table', 1),
(11, '2026_10_30_041200_ensure_user_role_column', 1);

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
-- Table structure for table `penyakits`
--

CREATE TABLE `penyakits` (
  `id` bigint UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `penyebab` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rekomendasi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penyakits`
--

INSERT INTO `penyakits` (`id`, `kode`, `nama`, `deskripsi`, `penyebab`, `rekomendasi`, `created_at`, `updated_at`) VALUES
(1, 'P01', 'Antraknosa (Patek)', 'Penyakit akibat jamur Colletotrichum capsici yang menyerang buah cabai hingga busuk dan mengering.', 'Jamur Colletotrichum capsici, C. gloeosporioides', 'Gunakan benih sehat, rendam benih dengan Pseudomonas fluorescens, sanitasi buah terinfeksi, perbaiki drainase, aplikasi fungisida protektif (Bion M1/48 WP) sejak muncul putik.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(2, 'P02', 'Layu Fusarium', 'Tanaman layu dimulai dari bagian bawah akibat jamur Fusarium oxysporum.', 'Jamur Fusarium oxysporum', 'Rotasi tanaman non-inang, gunakan agens hayati Trichoderma spp., perbaiki drainase, gunakan varietas tahan.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(3, 'P03', 'Layu Bakteri', 'Layu mendadak akibat bakteri Ralstonia solanacearum, batang mengeluarkan lendir bila dipotong.', 'Bakteri Ralstonia solanacearum', 'Buang tanaman sakit, rotasi tanaman, sanitasi lahan, hindari luka mekanis pada akar.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(4, 'P04', 'Bercak Daun Cercospora', 'Bercak kecil bulat kering pada daun dengan pusat pucat dan tepi lebih tua.', 'Jamur Cercospora capsici', 'Sanitasi sisa tanaman sakit, gunakan benih bebas patogen, fungisida bila serangan meluas, perbaiki drainase.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(5, 'P05', 'Virus Kuning (Gemini)', 'Daun muda menguning cerah, mengerut, menebal, dan tanaman kerdil akibat virus Gemini.', 'Gemini Virus (TYLCV) via kutu kebul Bemisia tabaci', 'Kendalikan kutu kebul dengan perangkap kuning, insektisida, cabut dan musnahkan tanaman terinfeksi.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(6, 'P06', 'Busuk Daun Phytophthora', 'Daun dan batang membusuk, sering muncul saat kelembaban tinggi dan genangan air.', 'Jamur Phytophthora capsici', 'Perbaiki drainase, hindari genangan, aplikasi fungisida, rotasi tanaman.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(7, 'P07', 'Busuk Pangkal Batang (Sclerotium)', 'Tanaman layu mendadak, pangkal batang membusuk dengan benang putih dan sklerotia coklat.', 'Jamur Sclerotium rolfsii', 'Bajak tanah dalam untuk mengubur sklerotia, rotasi tanaman, aplikasi fungisida tanah.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(8, 'P08', 'Layu Verticillium', 'Daun bawah keriting dan menguning, tanaman kerdil dan layu total akibat jamur Verticillium.', 'Jamur Verticillium albo-atrum, V. dahliae', 'Rotasi tanaman dengan non-inang selama 3-4 tahun, sanitasi lahan.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(9, 'P09', 'Bercak Daun Bakteri', 'Bintik gelap cekung pada daun dan buah akibat bakteri Xanthomonas.', 'Bakteri Xanthomonas vesicatoria', 'Gunakan benih bebas patogen, sanitasi, hindari percikan air antar tanaman.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(10, 'P10', 'Mosaik (Kompleks Virus)', 'Daun belang hijau tua-muda (mosaik), mengeriting, tanaman kerdil, buah mengecil.', 'TMV, CMV, CVMV, PVY', 'Kendalikan vektor kutu daun (Myzus persicae) dengan mulsa plastik perak/jerami, cabut tanaman terinfeksi muda, gunakan varietas toleran.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(11, 'P11', 'Kerupuk (CPSV)', 'Daun menggulung ke bawah, keriput, hijau pekat mengkilap, ruas batang memendek seperti kerupuk.', 'Chilli Puckery Stunt Virus (CPSV)', 'Tekan populasi kutu daun vektor, cabut tanaman sakit, gunakan varietas tahan.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(12, 'P12', 'Bintil Akar (Nematoda)', 'Tanaman kerdil, menguning, layu; pada akar terbentuk bintil-bintil (galls).', 'Nematoda Meloidogyne incognita, M. arenaria, M. hapla', 'Rotasi tanaman jangka panjang dengan non-inang (padi/rumput), nematisida bila populasi tinggi.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(13, 'P13', 'Bercak Kering Alternaria', 'Bercak coklat tua konsentris (target spot) pada daun dan buah, menyebabkan daun gugur dan buah busuk kering.', 'Jamur Alternaria solani', 'Rotasi tanaman, sanitasi sisa tanaman, aplikasi fungisida berbahan aktif mankozeb atau klorotalonil.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(14, 'P14', 'Embun Tepung (Powdery Mildew)', 'Lapisan putih seperti tepung pada permukaan daun, daun menguning dan kering.', 'Jamur Oidium sp. / Leveillula taurica', 'Perbaiki sirkulasi udara, hindari kelembaban tinggi, aplikasi fungisida sulfur atau kalium bikarbonat.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(15, 'P15', 'Busuk Buah Rhizopus', 'Buah membusuk lunak disertai bulu putih dan bintik hitam (sporangium) pada buah.', 'Jamur Rhizopus stolonifer', 'Panen tepat waktu, hindari luka pada buah, simpan di tempat kering, sanitasi buah busuk.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(16, 'P16', 'Busuk Batang Fusarium', 'Batang membusuk coklat, tanaman layu dan mati, jaringan pembuluh berwarna gelap.', 'Jamur Fusarium solani', 'Gunakan agens hayati Trichoderma, rotasi tanaman, perbaiki drainase, hindari luka pada batang.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(17, 'P17', 'Bercak Daun Septoria', 'Bercak kecil coklat dengan titik hitam di tengah (piknidia), daun menguning dan gugur.', 'Jamur Septoria lycopersici', 'Sanitasi daun terinfeksi, rotasi tanaman, aplikasi fungisida tembaga.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(18, 'P18', 'Busuk Leher Akar (Rhizoctonia)', 'Pangkal batang dekat tanah membusuk coklat, tanaman rebah dan mati (damping off).', 'Jamur Rhizoctonia solani', 'Gunakan media semai steril, perbaiki drainase, aplikasi fungisida tanah, rotasi tanaman.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(19, 'P19', 'Layu Bakteri Xanthomonas', 'Tanaman layu, daun menguning, batang membusuk dan mengeluarkan lendir kuning.', 'Bakteri Xanthomonas campestris', 'Buang tanaman sakit, rotasi tanaman, sanitasi alat, hindari irigasi percikan.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(20, 'P20', 'Busuk Lunak Bakteri (Erwinia)', 'Buah dan batang membusuk lunak, berbau busuk, jaringan menjadi berlendir.', 'Bakteri Erwinia carotovora', 'Hindari luka mekanis, sanitasi lahan, simpan hasil panen di tempat kering dan sejuk.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(21, 'P21', 'Virus Belang Kuning (TYLCV)', 'Daun menguning di tepi, belang kuning, tanaman kerdil, buah kecil dan tidak normal.', 'Tomato Yellow Leaf Curl Virus via Bemisia tabaci', 'Kendalikan kutu kebul, gunakan mulsa perak, cabut tanaman terinfeksi, gunakan varietas tahan.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(22, 'P22', 'Virus Bercak Cincin (TSWV)', 'Daun dan buah menunjukkan bercak cincin nekrotik, tanaman kerdil, buah cacat.', 'Tomato Spotted Wilt Virus via thrips', 'Kendalikan thrips dengan perangkap kuning/biru, sanitasi gulma inang, cabut tanaman sakit.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(23, 'P23', 'Nematoda Sista (Heterodera)', 'Tanaman kerdil dan menguning, pada akar terdapat sista (kista) kecil seperti butiran pasir.', 'Nematoda Heterodera sp.', 'Rotasi tanaman non-inang, gunakan varietas tahan, aplikasi nematisida organik.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(24, 'P24', 'Defisiensi Kalsium (Blossom End Rot)', 'Ujung buah membusuk kering kecoklatan (busuk ujung buah), pertumbuhan terhambat.', 'Kekurangan kalsium akibat kelembaban tidak stabil', 'Perbaiki irigasi agar stabil, aplikasi kalsium nitrat, hindari pemupukan nitrogen berlebih.', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(25, 'P25', 'Defisiensi Magnesium', 'Daun tua menguning di antara tulang daun (interveinal chlorosis), daun gugur prematur.', 'Kekurangan magnesium (Mg)', 'Aplikasi pupuk magnesium sulfat (kiserit), perbaiki pH tanah, lakukan uji tanah berkala.', '2026-11-01 10:13:22', '2026-11-01 10:13:22');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_diagnosis`
--

CREATE TABLE `riwayat_diagnosis` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `input_asli` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gejala_terdeteksi` json NOT NULL,
  `cf_pengguna` json NOT NULL,
  `penyakit_id` bigint UNSIGNED DEFAULT NULL,
  `cf_akhir` decimal(4,2) DEFAULT NULL,
  `penjelasan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `riwayat_diagnosis`
--

INSERT INTO `riwayat_diagnosis` (`id`, `user_id`, `input_asli`, `gejala_terdeteksi`, `cf_pengguna`, `penyakit_id`, `cf_akhir`, `penjelasan`, `created_at`, `updated_at`) VALUES
(1, 1, 'kenapa ya tanaman saya daunnya itu menggulung daunnya dan ada bercak putih', '[\"G09\"]', '{\"G09\": 1}', 4, '1.00', 'Tanaman cabai Anda terindikasi **Bercak Daun Cercospora** dengan tingkat keyakinan **100%**.\n\n**Deskripsi:** Bercak kecil bulat kering pada daun dengan pusat pucat dan tepi lebih tua.\n\n**Penyebab:** Jamur Cercospora capsici\n\n**Gejala yang teridentifikasi:**\n- Bercak bulat kering pada daun (CF Pakar: 1, CF User: 1)\n\n**Rekomendasi Penanganan Awal:** Sanitasi sisa tanaman sakit, gunakan benih bebas patogen, fungisida bila serangan meluas, perbaiki drainase.', '2026-11-01 10:15:30', '2026-11-01 10:15:30'),
(2, 1, 'kenapa ya tanaman saya daunnya itu menggulung daunnya dan ada bercak putih', '[\"G09\", \"G19\"]', '{\"G09\": 1, \"G19\": 1}', 4, '1.00', 'Tanaman cabai Anda terindikasi **Bercak Daun Cercospora** dengan tingkat keyakinan **100%**.\n\n**Deskripsi:** Bercak kecil bulat kering pada daun dengan pusat pucat dan tepi lebih tua.\n\n**Penyebab:** Jamur Cercospora capsici\n\n**Gejala yang teridentifikasi:**\n- Bercak bulat kering pada daun (CF Pakar: 1, CF User: 1)\n\n**Rekomendasi Penanganan Awal:** Sanitasi sisa tanaman sakit, gunakan benih bebas patogen, fungisida bila serangan meluas, perbaiki drainase.', '2026-11-01 10:15:35', '2026-11-01 10:15:35'),
(3, 1, 'kenapa ya tanaman saya daunnya itu menggulung daunnya dan ada bercak putih', '[\"G19\"]', '{\"G19\": 1}', 11, '1.00', 'Tanaman cabai Anda terindikasi **Kerupuk (CPSV)** dengan tingkat keyakinan **100%**.\n\n**Deskripsi:** Daun menggulung ke bawah, keriput, hijau pekat mengkilap, ruas batang memendek seperti kerupuk.\n\n**Penyebab:** Chilli Puckery Stunt Virus (CPSV)\n\n**Gejala yang teridentifikasi:**\n- Daun menggulung ke bawah dan keriput (CF Pakar: 1, CF User: 1)\n\n**Rekomendasi Penanganan Awal:** Tekan populasi kutu daun vektor, cabut tanaman sakit, gunakan varietas tahan.', '2026-11-01 10:15:40', '2026-11-01 10:15:40');

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
('rsSIZKpewUtOwPFH0TSZjtATi8UfTGOTMJUb0YdV', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTmw1ZTJIWTVzak5ldENvTTdiM2pERERqb09iVnkyN0ZqbVdoYWdxbiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6IjBjODYyZjg3YTRjYTVhMTRiYTE1MWU4NWQ1YmJjMjI2MzIxMGU4YzRjMGRiMzRlNDBjNTIzOWE5OTNmMjJjYzkiO30=', 1793553340);

-- --------------------------------------------------------

--
-- Table structure for table `sinonim_gejalas`
--

CREATE TABLE `sinonim_gejalas` (
  `id` bigint UNSIGNED NOT NULL,
  `kata_tidak_baku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gejala_id` bigint UNSIGNED DEFAULT NULL,
  `kata_baku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sinonim_gejalas`
--

INSERT INTO `sinonim_gejalas` (`id`, `kata_tidak_baku`, `gejala_id`, `kata_baku`, `created_at`, `updated_at`) VALUES
(1, 'totol-totol', 9, 'bercak', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(2, 'totol totol', 9, 'bercak', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(3, 'toto-toto', 9, 'bercak', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(4, 'bintik-bintik', 9, 'bercak', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(5, 'noda', 9, 'bercak', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(6, 'spot', 9, 'bercak', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(7, 'bintik', 9, 'bercak', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(8, 'buruk', 2, 'busuk', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(9, 'busukan', 2, 'busuk', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(10, 'membusuk', 2, 'busuk', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(11, 'bosok', 2, 'busuk', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(12, 'basi', 2, 'busuk', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(13, 'bau busuk', 2, 'busuk', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(14, 'berlendir', 7, 'lendir', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(15, 'kering kerontang', 9, 'kering', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(16, 'gering', 9, 'kering', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(17, 'mengering', 9, 'kering', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(18, 'kekeringan', 9, 'kering', '2026-11-01 10:13:22', '2026-11-01 10:13:22'),
(19, 'kuning pucat', 11, 'menguning', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(20, 'kekuningan', 11, 'menguning', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(21, 'menguning', 11, 'menguning', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(22, 'kuning', 11, 'menguning', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(23, 'lembek', 21, 'layu', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(24, 'lemas', 21, 'layu', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(25, 'ndak segar', 21, 'layu', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(26, 'tidak segar', 21, 'layu', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(27, 'menggelepar', 21, 'layu', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(28, 'rebah', 21, 'layu', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(29, 'keriputan', 14, 'keriput', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(30, 'kriput', 14, 'keriput', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(31, 'menggulung', 19, 'menggulung', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(32, 'mengkerut', 14, 'keriput', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(33, 'menggulung ke bawah', 19, 'menggulung', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(34, 'kerdil', 26, 'kerdil', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(35, 'pendek', 26, 'kerdil', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(36, 'tidak tumbuh', 26, 'kerdil', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(37, 'kerdilan', 26, 'kerdil', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(38, 'belang-belang', 17, 'mosaik', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(39, 'bercorak', 17, 'mosaik', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(40, 'belang', 17, 'mosaik', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(41, 'corak', 17, 'mosaik', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(42, 'bintilan', 3, 'bintil', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(43, 'benjolan akar', 3, 'bintil', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(44, 'benjolan', 3, 'bintil', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(45, 'kista', 48, 'sista', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(46, 'bertepung', 33, 'tepung', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(47, 'seperti tepung', 33, 'tepung', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(48, 'embun', 33, 'tepung', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(49, 'putih berbedak', 33, 'tepung', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(50, 'berbulu', 8, 'bulu', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(51, 'berjamur', 8, 'bulu', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(52, 'kapang', 8, 'bulu', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(53, 'cincin', 46, 'cincin', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(54, 'lingkaran', 46, 'cincin', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(55, 'bercak cincin', 46, 'cincin', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(56, 'ujung busuk', 49, 'ujung buah', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(57, 'pucuk buah busuk', 49, 'ujung buah', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(58, 'daun kuning garis', 50, 'interveinal', '2026-11-01 10:13:23', '2026-11-01 10:13:23'),
(59, 'kuning di antara tulang daun', 50, 'interveinal', '2026-11-01 10:13:23', '2026-11-01 10:13:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'mufthiealie01', 'mufthiealie01@gmail.com', '2026-11-01 10:13:22', '$2y$12$BLlklXsf2g3GAeT9iziHa.RcotecOE92ivHTUIBlxYZ6HPi9mkpQK', 'admin', NULL, '2026-11-01 10:13:22', '2026-11-01 10:13:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aturan_gejalas`
--
ALTER TABLE `aturan_gejalas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `aturan_gejalas_penyakit_id_gejala_id_unique` (`penyakit_id`,`gejala_id`),
  ADD KEY `aturan_gejalas_gejala_id_foreign` (`gejala_id`);

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
-- Indexes for table `gejalas`
--
ALTER TABLE `gejalas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gejalas_kode_unique` (`kode`);

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
-- Indexes for table `penyakits`
--
ALTER TABLE `penyakits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `penyakits_kode_unique` (`kode`);

--
-- Indexes for table `riwayat_diagnosis`
--
ALTER TABLE `riwayat_diagnosis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `riwayat_diagnosis_penyakit_id_foreign` (`penyakit_id`),
  ADD KEY `riwayat_diagnosis_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sinonim_gejalas`
--
ALTER TABLE `sinonim_gejalas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sinonim_gejalas_kata_tidak_baku_unique` (`kata_tidak_baku`),
  ADD KEY `sinonim_gejalas_gejala_id_foreign` (`gejala_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aturan_gejalas`
--
ALTER TABLE `aturan_gejalas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gejalas`
--
ALTER TABLE `gejalas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `penyakits`
--
ALTER TABLE `penyakits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `riwayat_diagnosis`
--
ALTER TABLE `riwayat_diagnosis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sinonim_gejalas`
--
ALTER TABLE `sinonim_gejalas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aturan_gejalas`
--
ALTER TABLE `aturan_gejalas`
  ADD CONSTRAINT `aturan_gejalas_gejala_id_foreign` FOREIGN KEY (`gejala_id`) REFERENCES `gejalas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `aturan_gejalas_penyakit_id_foreign` FOREIGN KEY (`penyakit_id`) REFERENCES `penyakits` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `riwayat_diagnosis`
--
ALTER TABLE `riwayat_diagnosis`
  ADD CONSTRAINT `riwayat_diagnosis_penyakit_id_foreign` FOREIGN KEY (`penyakit_id`) REFERENCES `penyakits` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `riwayat_diagnosis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sinonim_gejalas`
--
ALTER TABLE `sinonim_gejalas`
  ADD CONSTRAINT `sinonim_gejalas_gejala_id_foreign` FOREIGN KEY (`gejala_id`) REFERENCES `gejalas` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
