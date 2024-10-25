-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_latihan
CREATE DATABASE IF NOT EXISTS `db_latihan` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_latihan`;

-- Dumping structure for table db_latihan.tabel_dosen
CREATE TABLE IF NOT EXISTS `tabel_dosen` (
  `kode_dosen` int NOT NULL,
  `nama_dosen` varchar(50) DEFAULT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `alamat` text,
  `telepon` int DEFAULT NULL,
  PRIMARY KEY (`kode_dosen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_latihan.tabel_jadwal
CREATE TABLE IF NOT EXISTS `tabel_jadwal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_matakuliah` int DEFAULT NULL,
  `kode_dosen` int DEFAULT NULL,
  `hari` varchar(10) DEFAULT NULL,
  `jam` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kode_matakuliah` (`kode_matakuliah`),
  KEY `kode_dosen` (`kode_dosen`),
  CONSTRAINT `tabel_jadwal_ibfk_1` FOREIGN KEY (`kode_matakuliah`) REFERENCES `tabel_matakuliah` (`kode_matakuliah`),
  CONSTRAINT `tabel_jadwal_ibfk_2` FOREIGN KEY (`kode_dosen`) REFERENCES `tabel_dosen` (`kode_dosen`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_latihan.tabel_krs
CREATE TABLE IF NOT EXISTS `tabel_krs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nim` varchar(50) DEFAULT NULL,
  `id_jadwal` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nim` (`nim`),
  KEY `id_jadwal` (`id_jadwal`),
  CONSTRAINT `tabel_krs_ibfk_2` FOREIGN KEY (`id_jadwal`) REFERENCES `tabel_jadwal` (`id`),
  CONSTRAINT `tabel_mhs_fk` FOREIGN KEY (`nim`) REFERENCES `tabel_mahasiswa` (`nim`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_latihan.tabel_mahasiswa
CREATE TABLE IF NOT EXISTS `tabel_mahasiswa` (
  `nim` varchar(50) NOT NULL DEFAULT '',
  `nama_mahasiswa` varchar(50) DEFAULT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `alamat` text,
  `jurusan` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_latihan.tabel_matakuliah
CREATE TABLE IF NOT EXISTS `tabel_matakuliah` (
  `kode_matakuliah` int NOT NULL,
  `nama_matakuliah` varchar(20) DEFAULT NULL,
  `sks` int DEFAULT NULL,
  PRIMARY KEY (`kode_matakuliah`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
