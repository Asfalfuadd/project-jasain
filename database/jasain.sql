-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 11, 2026 at 05:09 PM
-- Server version: 8.4.7
-- PHP Version: 8.5.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coba`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `penyedia_servis_id` int NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `total_harga` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `penyedia_servis_id` (`penyedia_servis_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notfikasi`
--

DROP TABLE IF EXISTS `notfikasi`;
CREATE TABLE IF NOT EXISTS `notfikasi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `judul` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pesan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_read` tinyint(1) DEFAULT '0',
  `crceated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penyedia`
--

DROP TABLE IF EXISTS `penyedia`;
CREATE TABLE IF NOT EXISTS `penyedia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `no_hp` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penyedia`
--

INSERT INTO `penyedia` (`id`, `user_id`, `deskripsi`, `alamat`, `no_hp`, `created_at`) VALUES
(5, 21, 'Saya ingin membangun usaha laundry bintang 5', 'Kekalik Jaya', '081237886574', '2026-05-29 03:36:33'),
(6, 22, 'Saya ingin membangun berbagai macam usaha No 1 di Kota Mataram', 'Jempongx', '085224535889', '2026-05-29 03:39:43');

-- --------------------------------------------------------

--
-- Table structure for table `penyedia_servis`
--

DROP TABLE IF EXISTS `penyedia_servis`;
CREATE TABLE IF NOT EXISTS `penyedia_servis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `penyedia_id` int NOT NULL,
  `servis_id` int NOT NULL,
  `judul` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `harga` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `penyedia_id` (`penyedia_id`),
  KEY `servis_id` (`servis_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penyedia_servis`
--

INSERT INTO `penyedia_servis` (`id`, `penyedia_id`, `servis_id`, `judul`, `deskripsi`, `harga`, `created_at`) VALUES
(16, 6, 2, 'Bahlil Angkut All', 'Bahlil Angkut All adalah Jasa angkut barang NO 1 fi Kota Mataram. Bahlil Angkut All bisa mengangkut berbagai macam barang.', 200000.00, '2026-05-29 03:42:42'),
(15, 6, 1, 'BahRent', 'BahRent adalah tempat Rental kendaraan NO 1 di Kota Mataram yang menyediakan berbagai macam kendaraan.', 300000.00, '2026-05-29 03:40:59'),
(14, 5, 4, 'Tiw Laundryx', 'Tiw Laundryx adalah jasa Laundry terbaik di Kota Mataram', 20000.00, '2026-05-29 03:37:36'),
(17, 6, 3, 'Bah Servis', 'Bah Servis Adalah Jasa servis elektronik yang sangat lengkap. Semua Teknisi di Bah Servis adalah teknisi yang sudah professional semua.', 100000.00, '2026-05-29 03:44:06'),
(18, 6, 4, 'Lil Laundry Bah', 'LLB (Lil Laundry Bah) adalah jasa Laundry terbaik NO 1 di Kota Mataram. Menerima semua barang yang bisa di Laundry, pengerjaan cepat karena LLb sangat Gercep.', 50000.00, '2026-05-29 03:45:55');

-- --------------------------------------------------------

--
-- Table structure for table `servis`
--

DROP TABLE IF EXISTS `servis`;
CREATE TABLE IF NOT EXISTS `servis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `servis`
--

INSERT INTO `servis` (`id`, `nama`) VALUES
(1, 'Rental Kendaraan'),
(2, 'Jasa Angkut Barang'),
(3, 'Servis Elektronik'),
(4, 'Laundry');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user','penyedia') COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `created_at`, `update_at`) VALUES
(22, 'Lil Bahhh', 'bahlilgacor@gmail.com', '$2y$12$uopzFQhbRmb7AoayiQzEnOUJ17XmcO7lEyjmHS1FFWGuBPXpArGou', 'penyedia', '2026-05-29 03:38:28', '2026-05-29 03:38:28'),
(13, 'admin1', 'admin1@gmail.com', '$2y$12$vO0U9CWUVy4WbCMHS4OL.unVrLpPjibXPALlybyRAVqppt4rQvqgu', 'admin', '2026-05-05 17:17:09', '2026-05-05 17:26:25'),
(14, 'admin2', 'admin2@gmail.com', '$2y$12$vO0U9CWUVy4WbCMHS4OL.unVrLpPjibXPALlybyRAVqppt4rQvqgu', 'admin', '2026-05-05 17:17:42', '2026-05-05 17:27:19'),
(21, 'Tiwar', 'tiwar123@gmail.com', '$2y$12$/Fk5/bHGMeH3Bb.DJnAxHekPg8S.dBcCLyzejbi10Lu7xHHXJlgK6', 'penyedia', '2026-05-29 03:35:02', '2026-05-29 03:35:02'),
(20, 'Asfal Fuad', 'fuadasfal32@gmail.com', '$2y$12$q1MCx8rXDV0GSHCsB/Q1O.rHAgrnI04g.q.yqOQUEHnU0.i2k9OS2', 'user', '2026-05-29 03:34:37', '2026-05-29 03:34:37'),
(23, 'Nuri Andriana', 'andriana25@gmail.com', '$2y$12$b3jENYfEJ2SWLUrfmJuOGu4tZYMfeJRQFqvhpYKXA5XEZ.tn7W58W', 'user', '2026-05-29 03:46:36', '2026-05-29 03:46:36');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
