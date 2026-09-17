-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 03, 2025 at 06:38 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smk_yp_colomadu`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin111'),
(2, 'yulia', 'yulia123');

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `isi` text COLLATE utf8mb4_general_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deskripsi_gambar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id`, `judul`, `isi`, `gambar`, `deskripsi_gambar`, `tanggal`) VALUES
(1, 'Pelatihan Teknik Baru', 'Kegiatan pelatihan teknik mesin diadakan pada 20 Juli 2025...', 'berita/pelatihan_2025.jpg', 'Siswa sedang praktek mesin di lab', '2025-07-20 09:00:00'),
(3, 'Test', 'Test', 'assets/img/berita/1753890415.jpg', 'tes', '2025-07-30 15:46:55');

-- --------------------------------------------------------

--
-- Table structure for table `foto`
--

CREATE TABLE `foto` (
  `id` int NOT NULL,
  `nama_file` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_upload` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foto`
--

INSERT INTO `foto` (`id`, `nama_file`, `keterangan`, `tanggal_upload`) VALUES
(1, 'galeri/pelatihan_2025.jpg', 'Pelatihan Teknik Mesin 2025', '2025-07-23 09:00:00'),
(3, 'img/galeri/1753504800.jpg', 'Hut SMK YP Colomadu', '2025-07-26 04:40:00'),
(5, 'assets/img/galeri/1753886418.jpg', 'Info Pencairan Bantuan', '2025-07-30 14:40:18');

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE `komentar` (
  `id` int NOT NULL,
  `pendaftar_id` int NOT NULL,
  `panitia_id` int DEFAULT NULL,
  `komentar` text COLLATE utf8mb4_general_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`id`, `pendaftar_id`, `panitia_id`, `komentar`, `timestamp`) VALUES
(1, 1, 2, 'Dokumen KK kurang jelas, harap upload ulang.', '2025-07-24 18:30:00'),
(2, 1, 11, 'bisa di cek lagi dibagian nomor telfon', '2025-07-26 04:45:21'),
(5, 3, 11, 'Selamat! Anda diterima sebagai siswa SMK Colomadu di jurusan TKJ.', '2025-07-27 04:06:31');

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id` int NOT NULL,
  `pendaftar_id` int DEFAULT NULL,
  `nilai_tes` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id`, `pendaftar_id`, `nilai_tes`) VALUES
(1, 1, 75),
(2, 2, 85),
(3, 3, 95);

-- --------------------------------------------------------

--
-- Table structure for table `pendaftar`
--

CREATE TABLE `pendaftar` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nohp` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nis` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_ortu` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `pekerjaan_ortu` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `jurusan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `berkas` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('menunggu','Diterima','Revisi','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'menunggu',
  `komentar` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reg_number` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `asal_sekolah` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nilai` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendaftar`
--

INSERT INTO `pendaftar` (`id`, `user_id`, `nama`, `nohp`, `email`, `nis`, `nik`, `nama_ortu`, `pekerjaan_ortu`, `jurusan`, `berkas`, `status`, `komentar`, `created_at`, `reg_number`, `asal_sekolah`, `nilai`) VALUES
(1, 0, 'Ananda', '088829928737', 'ananda@gmail.com', 'B23040', '3311098875624311', 'yati Yati', 'Tani', 'Teknik Permesinan', 'berkas/ijazah_1753197047.pdf,berkas/kk_1753197047.pdf,berkas/akta_1753197047.pdf', 'menunggu', NULL, '2025-07-22 08:50:30', '1', 'SMPN 1 Colomadu', '75.00'),
(2, 0, 'yuliaku', '088829928123', 'yulia@gmail.com', 'NIS00100', '3311100030405002', 'Wiryo', 'Pedagang', 'TKJ', 'uploads/berkas/1753505931_laporan_pendaftar.pdf', 'Diterima', '', '2025-07-26 04:58:51', NULL, 'SMP Baki', '85.00'),
(3, 16, 'dipai', '09834746372', 'dipai@gmail.com', 'NIS001123', '3311100030405023', 'wi', 'Pedagang', 'TKJ', 'uploads/berkas/1753588941_Kartu_Member_lembahana (5).pdf,uploads/berkas/1753588995_Kartu_Member_lembahana (5).pdf', 'Diterima', 'kurang kk', '2025-07-27 04:02:21', NULL, 'SMP Grogol', '95.00'),
(4, 17, 'user1', '09484637221', 'user@gmail.com', 'NISUSER112', '3311100030405021', 'User', 'Pedagang', 'TKJ', 'uploads/berkas/1753682489_laporan_pendaftar_ditolak_20250728_020153.pdf', 'menunggu', '', '2025-07-28 06:01:29', NULL, 'SMP USER', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci NOT NULL,
  `nama_ortu` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `pekerjaan_ortu` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `jurusan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `berkas_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nohp` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('menunggu','valid','revisi','diterima','ditolak') COLLATE utf8mb4_general_ci DEFAULT 'menunggu',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`id`, `user_id`, `nik`, `alamat`, `nama_ortu`, `pekerjaan_ortu`, `jurusan`, `berkas_path`, `nohp`, `email`, `status`, `created_at`) VALUES
(1, 1, '3311276192631', 'Ngabean', 'Dwi Umi Yati', 'Buruh Pabrik', 'Teknik Kendaraan Ringan', 'berkas/1753039265_ijazah.pdf', NULL, NULL, 'menunggu', '2025-07-20 19:21:57'),
(2, 12, '3311100030405002', 'Bulak Singke', 'Wiryo', 'Pedagang', 'TKJ', 'uploads/berkas/1753505931_laporan_pendaftar.pdf', NULL, NULL, 'menunggu', '2025-07-26 04:58:51'),
(3, 16, '3311100030405023', 'gedangan', 'wi', 'Pedagang', 'TKJ', 'uploads/berkas/1753588941_Kartu_Member_lembahana (5).pdf,uploads/berkas/1753588995_Kartu_Member_lembahana (5).pdf', '09834746372', 'dipai@gmail.com', 'menunggu', '2025-07-27 04:02:21'),
(4, 17, '3311100030405021', 'Bulak', 'User', 'Pedagang', 'TKJ', 'uploads/berkas/1753682489_laporan_pendaftar_ditolak_20250728_020153.pdf', '09484637221', 'user@gmail.com', 'menunggu', '2025-07-28 06:01:29');

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int NOT NULL,
  `tahun_ajaran` varchar(9) COLLATE utf8mb4_general_ci NOT NULL,
  `kuota` int NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `nilai_minimal` decimal(5,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `tahun_ajaran`, `kuota`, `tanggal_mulai`, `tanggal_akhir`, `nilai_minimal`, `created_at`) VALUES
(1, '2025/2026', 100, '2025-07-01', '2025-08-31', '60.00', '2025-07-24 18:13:53'),
(2, '2025/2026', 10, '2025-07-01', '2025-08-31', '60.00', '2025-07-26 04:42:46'),
(3, '2025/2026', 100, '2025-07-01', '2025-08-31', '85.00', '2025-07-26 04:43:01');

-- --------------------------------------------------------

--
-- Table structure for table `persyaratan`
--

CREATE TABLE `persyaratan` (
  `id` int NOT NULL,
  `nama_persyaratan` varchar(255) NOT NULL,
  `deskripsi` text,
  `wajib` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `persyaratan`
--

INSERT INTO `persyaratan` (`id`, `nama_persyaratan`, `deskripsi`, `wajib`, `created_at`) VALUES
(2, 'Rekap Nilai Rapot 5 Semester', 'Rekap Rapot', 0, '2025-07-26 13:40:37'),
(3, 'Hasil Peringkat Kelas', 'peringkat kelas', 1, '2025-07-26 13:41:19'),
(4, 'hasil belajar', 'hasil belajar', 0, '2025-07-27 06:37:20');

-- --------------------------------------------------------

--
-- Table structure for table `sekolah`
--

CREATE TABLE `sekolah` (
  `id` int NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `kontak` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `visi` text COLLATE utf8mb4_general_ci NOT NULL,
  `misi` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sekolah`
--

INSERT INTO `sekolah` (`id`, `alamat`, `kontak`, `visi`, `misi`) VALUES
(1, 'Jl. Raya Colomadu No. 123, Colomadu, Karanganyar', '(0271) 123456', 'Menjadi jadi', 'Mencetak lulusan yang kompeten dan berdaya saing global.');

-- --------------------------------------------------------

--
-- Table structure for table `seleksi_kriteria`
--

CREATE TABLE `seleksi_kriteria` (
  `id` int NOT NULL,
  `kriteria` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bobot` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seleksi_kriteria`
--

INSERT INTO `seleksi_kriteria` (`id`, `kriteria`, `bobot`) VALUES
(1, 'Nilai Tes', 70),
(2, 'Dokumen Lengkap', 30);

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nis` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `kelas` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `jurusan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nama`, `nis`, `kelas`, `jurusan`) VALUES
(1, 'Ahsan', '00982', 'XII', 'Teknik Kendaraan Ringan');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('panitia','siswa') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'siswa',
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `nama`, `created_at`) VALUES
(1, 'ananda', 'siswa123', 'siswa', 'Ananda', '2025-07-20 19:21:05'),
(2, 'dip', 'panitia123', 'panitia', 'Dip', '2025-07-22 16:51:02'),
(10, 'yulia', 'yulia', 'siswa', 'yulia', '2025-07-25 01:41:46'),
(11, 'yuliaaa', 'yuliaaa', 'panitia', 'yuliaaa', '2025-07-26 04:42:10'),
(12, 'yuliaku', 'yuliaku', 'siswa', 'yuliaku', '2025-07-26 04:56:14'),
(14, 'dipaip', 'dipaip', 'siswa', 'dipaip', '2025-07-26 13:48:05'),
(15, 'aaa', 'aaa123', 'siswa', 'aaa', '2025-07-27 03:31:44'),
(16, 'dipai', 'dipai', 'siswa', 'dipai', '2025-07-27 03:39:09'),
(17, 'user', 'user', 'siswa', 'user', '2025-07-28 05:52:40'),
(18, 'panitia', 'panitia', 'panitia', 'panitia', '2025-07-28 21:54:30'),
(19, 'uaku', 'uaku12345', 'siswa', 'uaku', '2025-07-30 15:20:45'),
(20, 'lina123', 'lina123', 'siswa', 'lina', '2025-07-30 16:13:06');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `id` int NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_upload` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`id`, `url`, `judul`, `tanggal_upload`) VALUES
(2, 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'Pelatihan SMK YP COLOMADU 2025', '2025-07-28 21:42:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pendaftar_id` (`pendaftar_id`),
  ADD KEY `panitia_id` (`panitia_id`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pendaftar_id` (`pendaftar_id`);

--
-- Indexes for table `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `persyaratan`
--
ALTER TABLE `persyaratan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sekolah`
--
ALTER TABLE `sekolah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seleksi_kriteria`
--
ALTER TABLE `seleksi_kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `foto`
--
ALTER TABLE `foto`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pendaftar`
--
ALTER TABLE `pendaftar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `persyaratan`
--
ALTER TABLE `persyaratan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sekolah`
--
ALTER TABLE `sekolah`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `seleksi_kriteria`
--
ALTER TABLE `seleksi_kriteria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`pendaftar_id`) REFERENCES `pendaftar` (`id`),
  ADD CONSTRAINT `komentar_ibfk_2` FOREIGN KEY (`panitia_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`pendaftar_id`) REFERENCES `pendaftar` (`id`);

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
