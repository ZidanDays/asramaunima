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
  PRIMARY KEY (`id`),
  KEY `mahasiswa_id` (`mahasiswa_id`),
  KEY `kamar_ibfk_1` (`asrama_id`),
  CONSTRAINT `kamar_ibfk_1` FOREIGN KEY (`asrama_id`) REFERENCES `asrama` (`id`) ON DELETE CASCADE,
  CONSTRAINT `kamar_ibfk_2` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;


CREATE TABLE IF NOT EXISTS `pemesanan_kamar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` int NOT NULL,
  `kamar_id` int NOT NULL,
  `status_pembayaran` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `mahasiswa_id` (`mahasiswa_id`),
  KEY `pemesanan_kamar_ibfk_2` (`kamar_id`),
  CONSTRAINT `pemesanan_kamar_ibfk_1` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`),
  CONSTRAINT `pemesanan_kamar_ibfk_2` FOREIGN KEY (`kamar_id`) REFERENCES `kamar` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;


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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

INSERT INTO `users` (`id`, `id_kamar`, `nama`, `nim`, `tempat_lahir`, `tanggal_lahir`, `jurusan`, `fakultas`, `no_hp`, `email`, `password`, `level`) VALUES
	(1, NULL, 'Muhamad Zidan Dailer', '20210107', 'Jabar', '2025-01-22', 'TI', 'Fakultas Teknik', '0987654321', 'admin@gmail.com', '$2y$10$WpnzJI2mNNS23Y3tU5qiv.jcvwP82RjesZdiJYOLe9Vlojb3hcp4u', 'Operator'),
	(2, '24', 'Yunita Dwi Ariatna Pua', '20210107', 'Lopana', '2003-06-16', 'Teknik Informatika', 'Fakultas Teknik', '0987654321', 'yunitapua79@gmail.com', '$2y$10$fiQTXRGPMNmqGRxOQB58Ju2E8q607D50fQydNBhaMgcGZgjLO5Md6', NULL),
	(3, NULL, 'Zidny', '20210108', 'Jabar', '2001-03-21', 'Teknik Informatika', 'Fakultas Teknik', '085256756057', 'zero.capt21@gmail.com', '$2y$10$TRfUnFK0ORBBVDtD5yJah.UVuKoaUMyY54sNj5QoRgqIOwG/NrSEu', NULL),
	(4, '', 'yunchan', '20210190', 'Lopana', '2004-06-06', 'Teknik Informatika', 'Fakultas Teknik', '0987654321', 'yunchan@gmail.com', '$2y$10$X1nyhVF.XDEB40Nn1cWvHuZw0uabqhGz6Ca2DRBUHl0.EYzme6KI.', NULL),
	(5, '', 'Yuta Okkotsu', '20210108', 'Jepang', '2020-02-05', 'Teknik Informatika', 'Fakultas Teknik', '085256756057', 'yuta@gmail.com', '$2y$10$uZL7WjTthV0oohjG9DDymOlO526rOyYE9KD7jW4O0AosvWoPO7Tg6', NULL),
	(6, '23', 'Setia Sinaga', '21210060', 'Kandis', '2024-08-08', 'Teknik Informatika', 'Fakultas Teknik', '7676767676767676', 'setia@gmail.com', '$2y$10$BLTVFrPnrkJjw6H9fSDgROCj4NK5PZ/JZwvCVlDfJqUDQ/Kbtw.qK', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
