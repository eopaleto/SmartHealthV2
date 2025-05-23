-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Nov 14, 2024 at 03:45 PM
-- Server version: 11.5.2-MariaDB-ubu2404
-- PHP Version: 8.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medis`
--

-- --------------------------------------------------------

--
-- Table structure for table `db_jantung`
--

CREATE TABLE `db_jantung` (
  `id_pasien` int(11) NOT NULL,
  `id_jantung` int(11) NOT NULL,
  `DetakJantung` int(11) NOT NULL,
  `SaturasiOksigen` int(11) NOT NULL,
  `KondisiJantung` varchar(255) NOT NULL,
  `z_crips` int(11) DEFAULT NULL,
  `Waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_jantung`
--

INSERT INTO `db_jantung` (`id_pasien`, `id_jantung`, `DetakJantung`, `SaturasiOksigen`, `KondisiJantung`, `z_crips`, `Waktu`) VALUES
(1, 5, 74, 96, 'SEHAT', 70, '2024-11-06 07:18:28'),
(1, 6, 63, 100, 'KURANG SEHAT', 54, '2024-11-06 07:18:33'),
(1, 7, 68, 96, 'SEHAT', 70, '2024-11-06 07:18:38'),
(1, 8, 67, 95, 'SEHAT', 70, '2024-11-06 07:18:43'),
(1, 9, 66, 99, 'SEHAT', 70, '2024-11-06 07:18:48'),
(1, 10, 63, 99, 'KURANG SEHAT', 54, '2024-11-06 07:18:53'),
(1, 11, 67, 98, 'SEHAT', 70, '2024-11-06 07:18:58'),
(1, 12, 77, 99, 'SEHAT', 70, '2024-11-06 07:19:03'),
(1, 13, 78, 99, 'SEHAT', 70, '2024-11-06 07:19:08'),
(1, 14, 63, 99, 'KURANG SEHAT', 54, '2024-11-06 07:19:13'),
(2, 1, 99, 89, 'SEHAT', 68, '2024-11-10 07:03:06'),
(2, 2, 111, 88, 'SEHAT', 70, '2024-11-10 07:03:20'),
(2, 3, 111, 88, 'SEHAT', 70, '2024-11-10 07:03:34'),
(2, 4, 34, 88, 'TIDAK SEHAT', 30, '2024-11-10 07:03:48'),
(2, 5, 34, 88, 'TIDAK SEHAT', 30, '2024-11-10 07:04:02'),
(2, 6, 24, 89, 'TIDAK SEHAT', 30, '2024-11-10 07:04:16'),
(2, 7, 60, 89, 'TIDAK SEHAT', 30, '2024-11-10 07:04:30'),
(2, 8, 82, 89, 'KURANG SEHAT', 50, '2024-11-10 07:04:44'),
(2, 9, 124, 89, 'SEHAT', 70, '2024-11-10 07:04:58'),
(2, 10, 66, 89, 'KURANG SEHAT', 50, '2024-11-10 07:05:12'),
(2, 11, 77, 89, 'KURANG SEHAT', 50, '2024-11-10 07:05:26'),
(2, 12, 74, 89, 'KURANG SEHAT', 50, '2024-11-10 07:05:40'),
(1, 15, 54, 102, 'TIDAK SEHAT', 30, '2024-11-14 14:04:23'),
(1, 16, 89, 103, 'SEHAT', 70, '2024-11-14 14:04:36'),
(1, 17, 90, 103, 'SEHAT', 70, '2024-11-14 14:04:50'),
(1, 18, 44, 101, 'TIDAK SEHAT', 30, '2024-11-14 14:08:40'),
(1, 19, 50, 101, 'TIDAK SEHAT', 30, '2024-11-14 14:08:53'),
(13, 1, 55, 99, 'TIDAK SEHAT', 30, '2024-11-14 14:16:40'),
(14, 1, 53, 89, 'TIDAK SEHAT', 30, '2024-11-14 14:16:44'),
(1, 20, 32, 103, 'TIDAK SEHAT', 30, '2024-11-14 14:16:45'),
(14, 2, 18, 100, 'TIDAK SEHAT', 30, '2024-11-14 14:16:49'),
(13, 2, 83, 99, 'SEHAT', 70, '2024-11-14 14:16:53'),
(14, 3, 96, 91, 'SEHAT', 66, '2024-11-14 14:16:57'),
(1, 21, 63, 102, 'KURANG SEHAT', 54, '2024-11-14 14:17:00'),
(14, 4, 52, 101, 'TIDAK SEHAT', 30, '2024-11-14 14:17:03'),
(13, 3, 63, 99, 'KURANG SEHAT', 54, '2024-11-14 14:17:07'),
(14, 5, 60, 90, 'TIDAK SEHAT', 30, '2024-11-14 14:17:11'),
(14, 6, 74, 99, 'SEHAT', 70, '2024-11-14 14:17:16'),
(13, 4, 50, 101, 'TIDAK SEHAT', 30, '2024-11-14 14:17:21'),
(14, 7, 80, 89, 'SEHAT', 70, '2024-11-14 14:17:24'),
(1, 22, 74, 99, 'SEHAT', 70, '2024-11-14 14:17:25'),
(14, 8, 66, 96, 'SEHAT', 70, '2024-11-14 14:17:30'),
(13, 5, 59, 101, 'TIDAK SEHAT', 30, '2024-11-14 14:17:35'),
(14, 9, 67, 92, 'SEHAT', 63, '2024-11-14 14:17:38'),
(1, 23, 51, 99, 'TIDAK SEHAT', 30, '2024-11-14 14:17:39'),
(14, 10, 77, 97, 'SEHAT', 70, '2024-11-14 14:17:43'),
(13, 6, 56, 100, 'TIDAK SEHAT', 30, '2024-11-14 14:17:48'),
(14, 11, 64, 93, 'KURANG SEHAT', 55, '2024-11-14 14:17:51'),
(1, 24, 55, 99, 'TIDAK SEHAT', 30, '2024-11-14 14:17:52'),
(14, 12, 16, 96, 'TIDAK SEHAT', 30, '2024-11-14 14:19:22'),
(14, 13, 50, 97, 'TIDAK SEHAT', 30, '2024-11-14 14:19:36'),
(14, 14, 10, 86, 'TIDAK SEHAT', 30, '2024-11-14 14:20:18'),
(2, 13, 23, 92, 'TIDAK SEHAT', 30, '2024-11-14 14:21:46'),
(14, 15, 125, 94, 'SEHAT', 70, '2024-11-14 14:21:49'),
(2, 14, 68, 89, 'SEHAT', 70, '2024-11-14 14:21:59'),
(14, 16, 67, 96, 'SEHAT', 70, '2024-11-14 14:22:03'),
(13, 7, 89, 98, 'SEHAT', 70, '2024-11-14 14:22:14'),
(14, 17, 89, 96, 'SEHAT', 70, '2024-11-14 14:22:16'),
(2, 15, 80, 89, 'SEHAT', 70, '2024-11-14 14:22:24'),
(13, 8, 75, 98, 'SEHAT', 70, '2024-11-14 14:22:27'),
(14, 18, 79, 96, 'SEHAT', 70, '2024-11-14 14:22:29'),
(2, 16, 86, 88, 'SEHAT', 70, '2024-11-14 14:22:38'),
(13, 9, 65, 98, 'SEHAT', 70, '2024-11-14 14:22:41'),
(1, 25, 68, 103, 'SEHAT', 70, '2024-11-14 14:22:43'),
(14, 19, 51, 97, 'TIDAK SEHAT', 30, '2024-11-14 14:22:43'),
(2, 17, 73, 88, 'SEHAT', 70, '2024-11-14 14:22:51'),
(13, 10, 71, 98, 'SEHAT', 70, '2024-11-14 14:22:54'),
(1, 26, 68, 102, 'SEHAT', 70, '2024-11-14 14:22:56'),
(14, 20, 47, 97, 'TIDAK SEHAT', 30, '2024-11-14 14:22:56'),
(14, 21, 57, 96, 'TIDAK SEHAT', 30, '2024-11-14 14:23:58'),
(2, 18, 55, 90, 'TIDAK SEHAT', 30, '2024-11-14 14:24:05'),
(13, 11, 54, 100, 'TIDAK SEHAT', 30, '2024-11-14 14:24:07'),
(1, 27, 80, 101, 'SEHAT', 70, '2024-11-14 14:24:10'),
(14, 22, 66, 97, 'SEHAT', 70, '2024-11-14 14:24:11'),
(2, 19, 69, 90, 'SEHAT', 70, '2024-11-14 14:24:18'),
(13, 12, 60, 99, 'TIDAK SEHAT', 30, '2024-11-14 14:24:21'),
(14, 23, 45, 95, 'TIDAK SEHAT', 30, '2024-11-14 14:35:49');

--
-- Triggers `db_jantung`
--
DELIMITER $$
CREATE TRIGGER `fuzzy_kondisi_jantung` BEFORE INSERT ON `db_jantung` FOR EACH ROW BEGIN
    DECLARE pelan, normal, cepat, rendah, tinggi DECIMAL(5,2);
    DECLARE z_pelan_rendah, z_pelan_normal DECIMAL(5,2);
    DECLARE z_normal_rendah, z_normal_normal DECIMAL(5,2);
    DECLARE z_cepat_rendah, z_cepat_normal DECIMAL(5,2);
    DECLARE z_total, sum_weights, z_crisp DECIMAL(5,2);

	-- Fuzzifikasi Detak Jantung
	SET pelan = CASE 
	    WHEN NEW.DetakJantung <= 60 THEN 1
	    WHEN NEW.DetakJantung > 60 AND NEW.DetakJantung < 65 THEN (65 - NEW.DetakJantung) / 5
	    ELSE 0
	END;
	
	SET normal = CASE
	    WHEN NEW.DetakJantung > 60 AND NEW.DetakJantung <= 65 THEN (NEW.DetakJantung - 60) / 5
	    WHEN NEW.DetakJantung > 65 AND NEW.DetakJantung <= 90 THEN 1
	    WHEN NEW.DetakJantung > 90 AND NEW.DetakJantung < 100 THEN (100 - NEW.DetakJantung) / 10
	    ELSE 0
	END;
	
	SET cepat = CASE
	    WHEN NEW.DetakJantung >= 90 AND NEW.DetakJantung <= 100 THEN (NEW.DetakJantung - 90) / 10
	    WHEN NEW.DetakJantung > 100 THEN 1
	    ELSE 0
	END;
	
	-- Fuzzifikasi Saturasi Oksigen
	SET rendah = CASE
	    WHEN NEW.SaturasiOksigen <= 85 THEN 1
	    WHEN NEW.SaturasiOksigen > 90 AND NEW.SaturasiOksigen < 95 THEN (95 - NEW.SaturasiOksigen) / 5
	    ELSE 0
	END;
	
	SET tinggi = CASE
	    WHEN NEW.SaturasiOksigen >= 85 THEN 1
	    WHEN NEW.SaturasiOksigen > 90 AND NEW.SaturasiOksigen < 95 THEN (NEW.SaturasiOksigen - 90) / 5
	    ELSE 0
	END;

    -- Implementasi Aturan Tsukamoto dan perhitungan z (nilai keluaran)
    SET z_pelan_rendah = LEAST(pelan, rendah) * 30; -- 'Tidak Sehat'
    SET z_pelan_normal = LEAST(pelan, tinggi) * 30; -- 'Tidak Sehat'
    SET z_normal_rendah = LEAST(normal, rendah) * 50; -- 'Kurang Sehat'
    SET z_normal_normal = LEAST(normal, tinggi) * 70; -- 'Sehat'
    SET z_cepat_rendah = LEAST(cepat, rendah) * 70; -- 'Sehat'
    SET z_cepat_normal = LEAST(cepat, tinggi) * 70; -- 'Sehat'

    -- Hitung total z dan sum_weights
    SET z_total = z_pelan_rendah + z_pelan_normal +
                  z_normal_rendah + z_normal_normal +
                  z_cepat_rendah + z_cepat_normal;

    SET sum_weights = (LEAST(pelan, rendah) + LEAST(pelan, tinggi) +
                       LEAST(normal, rendah) + LEAST(normal, tinggi) +
                       LEAST(cepat, rendah) + LEAST(cepat, tinggi));

    -- Defuzzifikasi menggunakan rata-rata berbobot
    IF sum_weights > 0 THEN
        SET z_crisp = z_total / sum_weights;
    ELSE
        SET z_crisp = 0; -- Default jika tidak ada keanggotaan
    END IF;
    
    -- Simpan hasil defuzzifikasi
    SET NEW.z_crips = z_crisp;

    -- Kategorisasi hasil defuzzifikasi
    IF z_crisp < 40 THEN
        SET NEW.KondisiJantung = 'TIDAK SEHAT';
    ELSEIF z_crisp BETWEEN 40 AND 60 THEN
        SET NEW.KondisiJantung = 'KURANG SEHAT';
    ELSE
        SET NEW.KondisiJantung = 'SEHAT';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `kamar`
--

CREATE TABLE `kamar` (
  `id_kamar` int(11) NOT NULL,
  `nama_ruang` varchar(200) NOT NULL,
  `id_pasien` int(11) DEFAULT NULL,
  `tgl_masuk` varchar(50) DEFAULT NULL,
  `jam_masuk` varchar(50) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `status_alat` int(11) DEFAULT NULL,
  `last_update` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kamar`
--

INSERT INTO `kamar` (`id_kamar`, `nama_ruang`, `id_pasien`, `tgl_masuk`, `jam_masuk`, `status`, `status_alat`, `last_update`) VALUES
(1, 'Melati', 14, '2024-10-14 16:06:28', '2024-10-14 16:06:28', 1, NULL, '2024-11-14 15:43:10'),
(2, 'Mawar', 2, '2024-10-14 21:46:48', '2024-10-14 21:46:48', 1, NULL, '2024-11-14 15:39:01'),
(3, 'Anggrek', 1, '2024-10-14 21:50:04', '2024-10-14 21:50:04', 1, NULL, '2024-11-14 15:39:01'),
(4, 'Copere', 13, '2024-10-13 12:43:16', '2024-10-13 12:43:16', 1, NULL, '2024-11-14 15:39:01');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL,
  `nama_pegawai` varchar(30) NOT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `level` varchar(20) DEFAULT 'Pasien',
  `tanggal_daftar` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `foto` varchar(255) DEFAULT 'assets/img/avatar/avatar-1.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `username`, `password`, `nama_pegawai`, `jenis_kelamin`, `alamat`, `level`, `tanggal_daftar`, `foto`) VALUES
(11, 'eo', '123', 'Satryo Pangestu', 'Laki-Laki', 'JALAN KAPTEN ROBANI KADIR', 'Administrator', '2024-02-06 15:40:04', 'uploads/WIN_20240206_19_23_56_Pro.jpg'),
(18, 'ajah', '123', 'Azza Adliyah', 'Laki-Laki', 'JALANIN AJAH', 'Administrator', '2024-02-06 12:59:30', 'assets/img/avatar/avatar-1.png'),
(22, 'admin', '123', 'ADMIN WEBSITE', 'Laki-Laki', 'JLN JEND. SUDIRMAN NO 22 KOTA PALEMBANG', 'Administrator', '2024-02-18 08:02:08', 'assets/img/avatar/avatar-1.png'),
(23, 'saodah', '123', 'Saodah', 'Perempuan', 'JALAN KAPTEN ROBANI KADIR RT 29 RW 08 NO 74 TALANG PUTRI PLAJU KEL TALANG PUTRI', 'Pasien', '2024-02-18 08:02:48', 'assets/img/avatar/avatar-1.png'),
(24, 'isa', '123', 'Khalisah', 'Perempuan', 'JLN KOLONEL SULAIMAN AMIN NO 13. KEC ALANG-ALANG LEBAR , KOTA PALEMBANG', 'Pasien', '2024-02-18 08:03:55', 'assets/img/avatar/avatar-1.png'),
(25, 'Ivan', '123', 'Muhammad Ivan', 'Laki-Laki', 'JALAN PANCA USAHA NO12', 'Pasien', '2024-03-13 03:12:30', 'assets/img/avatar/avatar-1.png');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_kamar`
--

CREATE TABLE `riwayat_kamar` (
  `id` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `nama_ruangan` varchar(255) NOT NULL,
  `tgl_masuk` varchar(255) NOT NULL,
  `tgl_keluar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat_kamar`
--

INSERT INTO `riwayat_kamar` (`id`, `id_pasien`, `nama_ruangan`, `tgl_masuk`, `tgl_keluar`) VALUES
(1, 1, 'Melati', '2024-06-15 16:06:29', '2024-10-13 12:39:44'),
(2, 1, 'Melati', '2024-06-15 16:20:29', '2024-10-13 12:39:44'),
(3, 2, 'Mawar', '2024-06-15 16:21:59', '2024-10-14 21:45:26'),
(4, 2, 'Melati', '2024-07-10 20:02:21', '2024-10-14 21:45:26'),
(5, 1, 'Melati', '2024-07-11 15:01:09', '2024-10-13 12:39:44'),
(6, 2, 'Melati', '2024-07-17 14:25:56', '2024-10-14 21:45:26'),
(7, 2, 'Melati', '2024-07-17 14:27:53', '2024-10-14 21:45:26'),
(8, 2, 'Melati', '2024-07-18 11:47:13', '2024-10-14 21:45:26'),
(9, 4, 'Coper', '2024-07-18 11:51:26', '2024-10-13 12:39:52'),
(10, 2, 'Melati', '2024-10-10 20:48:03', '2024-10-14 21:45:26'),
(11, 1, 'Mawar', '2024-10-10 20:48:06', '2024-10-13 12:39:44'),
(12, 3, 'Coper', '2024-10-10 20:48:13', '2024-10-13 12:39:49'),
(13, 4, 'Copere', '2024-10-10 20:48:16', '2024-10-13 12:39:52'),
(14, 3, 'Anggrek', '2024-10-10 21:33:30', '2024-10-13 12:39:49'),
(15, 2, 'Melati', '2024-10-11 13:29:51', '2024-10-14 21:45:26'),
(16, 2, 'Melati', '2024-10-12 10:01:45', '2024-10-14 21:45:26'),
(17, 3, 'Anggrek', '2024-10-12 13:13:37', '2024-10-13 12:39:49'),
(18, 1, 'Mawar', '2024-10-12 13:36:01', '2024-10-13 12:39:44'),
(19, 4, 'Copere', '2024-10-12 13:55:22', '2024-10-13 12:39:52'),
(20, 2, 'Melati', '2024-10-12 13:59:00', '2024-10-14 21:45:26'),
(21, 2, 'Melati', '2024-10-12 14:10:36', '2024-10-14 21:45:26'),
(22, 5, 'Anggrek', '2024-10-12 14:10:54', '2024-10-12 15:39:05'),
(23, 1, 'Melati', '2024-10-12 15:44:03', '2024-10-13 12:39:44'),
(24, 2, 'Mawar', '2024-10-12 15:44:08', '2024-10-14 21:45:26'),
(25, 3, 'Anggrek', '2024-10-12 15:44:12', '2024-10-13 12:39:49'),
(26, 13, 'Copere', '2024-10-13 12:43:16', ''),
(27, 14, 'Melati', '2024-10-14 16:06:28', ''),
(28, 2, 'Mawar', '2024-10-14 21:37:30', '2024-10-14 21:45:26'),
(29, 2, 'Mawar', '2024-10-14 21:46:48', ''),
(30, 1, 'Anggrek', '2024-10-14 21:50:04', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama_pasien` varchar(50) NOT NULL,
  `nik` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `tgl_lahir` varchar(200) NOT NULL,
  `umur` int(11) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `tinggi_badan` int(11) NOT NULL,
  `berat_badan` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `level` varchar(20) NOT NULL DEFAULT 'Pasien',
  `waktu` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama_pasien`, `nik`, `password`, `tgl_lahir`, `umur`, `jenis_kelamin`, `tinggi_badan`, `berat_badan`, `alamat`, `level`, `waktu`) VALUES
(1, 'Satryo Pangestu', 'admin', 'eokpaleto', '2004-12-15', 19, 'Laki-Laki', 171, 61, 'JALAN KAPTEN ROBANI KADIR RT 29 RW 08', 'Administrator', '2024-11-14 14:34:28'),
(2, 'Azza Adliyah', '1671141512040001', 'ec019e33', '2004-02-15', 20, 'Perempuan', 161, 51, 'JALAN KOLONEL SULAIMAN AMIN BLOK A1 NO 12 ', 'Pasien', '2024-11-13 13:02:56'),
(3, 'Sri Rizky Wahyuni', '1671141502040002', '123', '1996-05-04', 28, 'Perempuan', 161, 55, 'JALAN KAPTEN ROBANI KADIR RT 29 RW 08 NO 74 TALANG PUTRI KEC PLAJU KEL TALANG PUTRI KOTA PALEMBANG', 'Pasien', '2024-10-12 02:29:56'),
(4, 'Aji Fitrianto', '1671141512040005', '123', '1999-01-25', 25, 'Laki-Laki', 180, 75, 'JALAN MATRAMAN NO 12 BLOK A KEC MATRAMAN TIMUR', 'Pasien', '2024-10-12 02:29:51'),
(5, 'Edi Sumarianto', '3206001230004500', 'Td4sTcVX', '1967-01-20', 57, 'Laki-Laki', 170, 87, 'JALAN KAPTEN ROBANI KADIR RT 29 RW 08 NO 74 LORONG SEKOLAH', 'Pasien', '2024-10-12 02:29:45'),
(6, 'Saodah', '3100050200030070', 'Lv7b06MI', '1967-12-07', 56, 'Perempuan', 160, 77, 'JALAN KAPTEN ROBANI KADIR RT 29 RW 08 NO 74 TALANG PUTRI KEC PLAJU KEL TALANG PUTRI KOTA PALEMBANG', 'Pasien', '2024-10-12 02:29:42'),
(13, 'Muhammad Adzkan Zayyandra', '1671141512040010', 'd4dbd980', '2023-11-04', 0, 'Laki-Laki', 85, 12, 'JALAN KAPTEN ROBANI KADIR RT 29 RW 08 NO 74 KEL TALANG PUTRI KEC PLAJU', 'Pasien', '2024-10-13 05:42:47'),
(14, 'Dummy Pasien', 'dummy_pasien', 'dummy', '1970-05-05', 54, 'Perempuan', 160, 66, 'JALAN KOLONEL SULAIMAN AMIN NO 12 BLOK A1 ', 'Pasien', '2024-11-14 14:35:13');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `generate_random_password` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
    IF NEW.password IS NULL OR NEW.password = '' THEN
        SET NEW.password = SUBSTRING(MD5(RAND()), 1, 8);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_umur_before_update` BEFORE UPDATE ON `users` FOR EACH ROW BEGIN
    DECLARE umur INT;

    IF NEW.tgl_lahir IS NOT NULL THEN
        SET umur = TIMESTAMPDIFF(YEAR, NEW.tgl_lahir, CURDATE());
    ELSE
        SET umur = NULL; -- Jika tgl_lahir NULL, set umur menjadi NULL
    END IF;

    SET NEW.umur = umur; -- Mengatur nilai umur yang baru
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`id_kamar`),
  ADD UNIQUE KEY `id_pasien` (`id_pasien`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat_kamar`
--
ALTER TABLE `riwayat_kamar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kamar`
--
ALTER TABLE `kamar`
  MODIFY `id_kamar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `riwayat_kamar`
--
ALTER TABLE `riwayat_kamar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`%` EVENT `update_status_to_null` ON SCHEDULE EVERY 5 SECOND STARTS '2024-11-14 22:40:25' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE kamar
  SET status_alat = NULL
  WHERE TIMESTAMPDIFF(SECOND, last_update, NOW()) > 5$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
