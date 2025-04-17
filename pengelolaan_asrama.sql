/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS `pengelolaan_asrama` /*!40100 DEFAULT CHARACTER SET armscii8 COLLATE armscii8_bin */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `pengelolaan_asrama`;

CREATE TABLE IF NOT EXISTS `asrama` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) COLLATE armscii8_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `kapasitas` varchar(50) COLLATE armscii8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nama` (`nama`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

INSERT INTO `asrama` (`id`, `nama`, `created_at`, `kapasitas`) VALUES
	(10, 'A', '2025-02-05 08:21:05', '18'),
	(11, 'B', '2025-02-06 00:19:30', '18'),
	(12, 'C', '2025-02-06 00:19:42', '13'),
	(13, 'D', '2025-02-06 00:20:01', '28'),
	(14, 'E', '2025-02-06 00:20:16', '36'),
	(15, 'F', '2025-02-06 00:20:41', '36'),
	(16, 'G', '2025-02-06 00:20:54', '18');

CREATE TABLE IF NOT EXISTS `kamar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `asrama_id` int NOT NULL,
  `nomor_kamar` varchar(10) COLLATE armscii8_bin NOT NULL,
  `status` enum('kosong','terisi','belum bayar') CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT 'kosong',
  `mahasiswa_id` int DEFAULT NULL,
  `kapasitas` int NOT NULL DEFAULT '1',
  `fasilitas` text COLLATE armscii8_bin,
  PRIMARY KEY (`id`),
  KEY `mahasiswa_id` (`mahasiswa_id`),
  KEY `kamar_ibfk_1` (`asrama_id`),
  CONSTRAINT `kamar_ibfk_1` FOREIGN KEY (`asrama_id`) REFERENCES `asrama` (`id`) ON DELETE CASCADE,
  CONSTRAINT `kamar_ibfk_2` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

INSERT INTO `kamar` (`id`, `asrama_id`, `nomor_kamar`, `status`, `mahasiswa_id`, `kapasitas`, `fasilitas`) VALUES
	(25, 10, '1', 'terisi', NULL, 1, 'kasur, meja'),
	(26, 10, '2', 'kosong', NULL, 1, 'Kasur, Lemari, Meja'),
	(27, 10, '5', 'kosong', NULL, 1, 'Meja, Lemari 5 M, Kursi Plastik');

CREATE TABLE IF NOT EXISTS `laporan_fasilitas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` int DEFAULT NULL,
  `lokasi` varchar(255) COLLATE armscii8_bin DEFAULT NULL,
  `deskripsi_laporan` text COLLATE armscii8_bin,
  `status` enum('Diajukan','Diproses','Selesai') COLLATE armscii8_bin DEFAULT 'Diajukan',
  `tanggal_lapor` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `mahasiswa_id` (`mahasiswa_id`),
  CONSTRAINT `laporan_fasilitas_ibfk_1` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

INSERT INTO `laporan_fasilitas` (`id`, `mahasiswa_id`, `lokasi`, `deskripsi_laporan`, `status`, `tanggal_lapor`) VALUES
	(1, 2, 'Kamar Mandi A', 'N6JEJ8zqst9C8/N3gVCMqqAtHxKooJiQEB7R79MRPrs=', 'Diajukan', '2025-04-05 09:28:57'),
	(2, 2, 'Kamar Nomor 5 Asrama A', '5JCjPQwSL7xZbDh4XqHEWVFhRRDN0E6TZwXGRc4f4XJzjnuwhhqOZ7nO/WzS6VvP8/5GHUO83AsM2KJj9bC8dw==', 'Selesai', '2025-04-09 20:35:09');

CREATE TABLE IF NOT EXISTS `notifikasi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `judul` varchar(255) COLLATE armscii8_bin DEFAULT NULL,
  `pesan` text COLLATE armscii8_bin,
  `icon` varchar(50) COLLATE armscii8_bin DEFAULT NULL,
  `warna` varchar(20) COLLATE armscii8_bin DEFAULT NULL,
  `status` enum('belum_dibaca','dibaca') COLLATE armscii8_bin DEFAULT 'belum_dibaca',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

INSERT INTO `notifikasi` (`id`, `user_id`, `judul`, `pesan`, `icon`, `warna`, `status`, `created_at`) VALUES
	(2, 2, 'Status Laporan Diperbarui', 'Laporan fasilitas Anda kini berstatus: <b>Diajukan</b>.', 'settings', 'info', 'dibaca', '2025-04-05 10:41:46'),
	(3, 2, 'Status Laporan Diperbarui', 'Laporan fasilitas Anda kini berstatus: <b>Selesai</b>.', 'settings', 'info', 'dibaca', '2025-04-06 02:08:15'),
	(4, 2, 'Status Laporan Diperbarui', 'Laporan fasilitas Anda kini berstatus: <b>Diajukan</b>.', 'settings', 'info', 'dibaca', '2025-04-08 13:13:45'),
	(5, 7, 'Bukti Pembayaran Masuk', 'Mahasiswa <b>$nama_mahasiswa</b> telah mengunggah bukti pembayaran.', 'calendar', 'warning', 'dibaca', '2025-04-08 13:40:26'),
	(6, 7, 'Bukti Pembayaran Masuk', 'Mahasiswa Yunita Dwi Ariatna Pua telah mengunggah bukti pembayaran.', 'calendar', 'warning', 'dibaca', '2025-04-08 13:50:33'),
	(7, 7, 'Bukti Pembayaran Masuk', 'Mahasiswa <b>Yunita Dwi Ariatna Pua</b> telah mengunggah bukti pembayaran.', 'calendar', 'warning', 'dibaca', '2025-04-09 12:27:57'),
	(8, 7, 'Bukti Pembayaran Masuk', 'Mahasiswa <b>Yunita Dwi Ariatna Pua</b> telah mengunggah bukti pembayaran.', 'calendar', 'warning', 'dibaca', '2025-04-09 12:28:41'),
	(9, 2, 'Status Laporan Diperbarui', 'Laporan fasilitas Anda kini berstatus: <b>Diproses</b>.', 'settings', 'info', 'dibaca', '2025-04-09 12:38:54'),
	(10, 2, 'Status Laporan Diperbarui', 'Laporan fasilitas Anda kini berstatus: <b>Selesai</b>.', 'settings', 'info', 'dibaca', '2025-04-09 12:40:01'),
	(11, 7, 'Bukti Pembayaran Masuk', 'Mahasiswa <b>Yunita Dwi Ariatna Pua</b> telah mengunggah bukti pembayaran.', 'calendar', 'warning', 'belum_dibaca', '2025-04-17 13:39:37'),
	(12, 7, 'Bukti Pembayaran Masuk', 'Mahasiswa <b>Yunita Dwi Ariatna Pua</b> telah mengunggah bukti pembayaran.', 'calendar', 'warning', 'belum_dibaca', '2025-04-17 14:09:13');

CREATE TABLE IF NOT EXISTS `pembayaran` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` int NOT NULL,
  `kamar_id` int NOT NULL,
  `bulan` varchar(10) COLLATE armscii8_bin NOT NULL,
  `jumlah` decimal(10,2) NOT NULL DEFAULT '400000.00',
  `status` enum('pending','verified','rejected') COLLATE armscii8_bin DEFAULT 'pending',
  `bukti_pembayaran` text COLLATE armscii8_bin,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `password` varchar(50) COLLATE armscii8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mahasiswa_id` (`mahasiswa_id`),
  KEY `kamar_id` (`kamar_id`),
  CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`),
  CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`kamar_id`) REFERENCES `kamar` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

INSERT INTO `pembayaran` (`id`, `mahasiswa_id`, `kamar_id`, `bulan`, `jumlah`, `status`, `bukti_pembayaran`, `created_at`, `updated_at`, `password`) VALUES
	(1, 2, 25, '2025-04', 250000.00, 'verified', '1743813928_lhkpn.pdf', '2025-04-02 09:13:16', '2025-04-05 00:51:47', NULL),
	(2, 2, 25, '2025-05', 250000.00, 'verified', '1744898953_11666_559383.pdf', '2025-05-01 01:51:57', '2025-04-17 14:09:13', '1221');

CREATE TABLE IF NOT EXISTS `pemesanan_kamar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` int NOT NULL,
  `kamar_id` int NOT NULL,
  `status_pembayaran` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_pembayaran` date DEFAULT '1111-11-11',
  PRIMARY KEY (`id`),
  KEY `mahasiswa_id` (`mahasiswa_id`),
  KEY `pemesanan_kamar_ibfk_2` (`kamar_id`),
  CONSTRAINT `pemesanan_kamar_ibfk_1` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`),
  CONSTRAINT `pemesanan_kamar_ibfk_2` FOREIGN KEY (`kamar_id`) REFERENCES `kamar` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

INSERT INTO `pemesanan_kamar` (`id`, `mahasiswa_id`, `kamar_id`, `status_pembayaran`, `created_at`, `tanggal_pembayaran`) VALUES
	(3, 2, 25, 'utR+OwACGgIOu+I3SceXtIm3YcSTpYQbbHNHOIX7SKw=', '2025-03-23 13:20:17', '1111-11-11');

CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_kamar` varchar(50) COLLATE armscii8_bin DEFAULT NULL,
  `nama` varchar(100) COLLATE armscii8_bin DEFAULT NULL,
  `nim` varchar(20) COLLATE armscii8_bin DEFAULT NULL,
  `tempat_lahir` varchar(100) COLLATE armscii8_bin DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jurusan` varchar(100) COLLATE armscii8_bin DEFAULT NULL,
  `fakultas` varchar(100) COLLATE armscii8_bin DEFAULT NULL,
  `no_hp` varchar(20) COLLATE armscii8_bin DEFAULT NULL,
  `email` varchar(100) COLLATE armscii8_bin DEFAULT NULL,
  `password` varchar(255) COLLATE armscii8_bin DEFAULT NULL,
  `level` text COLLATE armscii8_bin,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

INSERT INTO `users` (`id`, `id_kamar`, `nama`, `nim`, `tempat_lahir`, `tanggal_lahir`, `jurusan`, `fakultas`, `no_hp`, `email`, `password`, `level`) VALUES
	(1, NULL, 'Muhamad Zidan Dailer', '20210107', 'Jabar', '2025-01-22', 'TI', 'Fakultas Teknik', '0987654321', 'admikn@gmail.com', '$2y$10$fiQTXRGPMNmqGRxOQB58Ju2E8q607D50fQydNBhaMgcGZgjLO5Md6', 'Operator'),
	(2, '27', 'Yunita Dwi Ariatna Pua', '20210107', 'Lopana', '2003-06-16', 'Teknik Informatika', 'Fakultas Teknik', '0987654321', 'yunitapua79@gmail.com', '$2y$10$fiQTXRGPMNmqGRxOQB58Ju2E8q607D50fQydNBhaMgcGZgjLO5Md6', NULL),
	(3, NULL, 'Zidny', '20210108', 'Jabar', '2001-03-21', 'Teknik Informatika', 'Fakultas Teknik', '085256756057', 'zero.capt21@gmail.com', '$2y$10$TRfUnFK0ORBBVDtD5yJah.UVuKoaUMyY54sNj5QoRgqIOwG/NrSEu', NULL),
	(4, '', 'yunchan', '20210190', 'Lopana', '2004-06-06', 'Teknik Informatika', 'Fakultas Teknik', '0987654321', 'yunchan@gmail.com', '$2y$10$X1nyhVF.XDEB40Nn1cWvHuZw0uabqhGz6Ca2DRBUHl0.EYzme6KI.', NULL),
	(5, '', 'Yuta Okkotsu', '20210108', 'Jepang', '2020-02-05', 'Teknik Informatika', 'Fakultas Teknik', '085256756057', 'yuta@gmail.com', '$2y$10$uZL7WjTthV0oohjG9DDymOlO526rOyYE9KD7jW4O0AosvWoPO7Tg6', NULL),
	(6, '23', 'Setia Sinaga', '21210060', 'Kandis', '2024-08-08', 'Teknik Informatika', 'Fakultas Teknik', '7676767676767676', 'setia@gmail.com', '$2y$10$BLTVFrPnrkJjw6H9fSDgROCj4NK5PZ/JZwvCVlDfJqUDQ/Kbtw.qK', NULL),
	(7, NULL, 'admin', '0000000', 'tttttt', '2025-03-11', 'a', 'Fakultas Ilmu Pendidikan', '0987654321', 'admin@gmail.com', '$2y$10$eXo1aV7WDOYPAxyUlruCk.P63PDF95XiHvY.73E9vPaT6Pp5l.wdG', 'Operator');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
