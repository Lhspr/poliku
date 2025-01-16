-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 03, 2025 at 10:10 PM
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
-- Database: `poli`
--

-- --------------------------------------------------------

--
-- Table structure for table `daftar_poli`
--

CREATE TABLE `daftar_poli` (
  `id` int NOT NULL,
  `id_pasien` int NOT NULL,
  `id_jadwal` int NOT NULL,
  `keluhan` text NOT NULL,
  `no_antrian` int NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `daftar_poli`
--

INSERT INTO `daftar_poli` (`id`, `id_pasien`, `id_jadwal`, `keluhan`, `no_antrian`, `tanggal`) VALUES
(51, 53, 26, 'sakit perut pada anak', 1, '2024-12-25 17:26:22'),
(52, 54, 26, 'sakit', 2, '2024-12-26 11:57:10'),
(53, 55, 27, 'step', 1, '2024-12-26 12:00:21'),
(54, 55, 26, 'fuigtp', 3, '2024-12-26 17:15:59'),
(55, 55, 24, 'telinga sakit', 1, '2024-12-26 17:48:12'),
(56, 55, 26, 'sakit\r\n', 4, '2024-12-26 17:59:59'),
(57, 55, 24, 'saya sakit', 2, '2024-12-27 00:26:14'),
(58, 56, 27, 'panas 3 hari', 2, '2024-12-27 06:33:11'),
(59, 55, 32, 'sakit', 1, '2024-12-29 15:28:54'),
(60, 55, 29, 'test 55', 1, '2024-12-29 15:47:08'),
(61, 55, 28, 'test 66', 1, '2024-12-29 15:52:28'),
(62, 55, 27, 'test77', 3, '2024-12-29 16:23:52'),
(63, 55, 27, 'test88', 4, '2024-12-29 16:24:56'),
(64, 55, 29, 'tidak mau makan, setiap diisi makanan selalu muuntah', 2, '2025-01-01 10:38:59');

-- --------------------------------------------------------

--
-- Table structure for table `detail_periksa`
--

CREATE TABLE `detail_periksa` (
  `id` int NOT NULL,
  `id_periksa` int NOT NULL,
  `id_obat` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_periksa`
--

INSERT INTO `detail_periksa` (`id`, `id_periksa`, `id_obat`) VALUES
(47, 45, 32),
(48, 46, 32),
(49, 47, 30),
(50, 49, 30),
(51, 50, 30),
(52, 51, 32),
(53, 52, 30),
(54, 53, 30),
(55, 53, 32),
(56, 53, 35),
(57, 54, 30),
(58, 54, 30),
(59, 54, 32),
(60, 54, 35),
(61, 55, 30),
(62, 56, 30),
(63, 56, 32);

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `id_poli` int NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id`, `nama`, `alamat`, `no_hp`, `id_poli`, `password`) VALUES
(22, 'ana', 'kaltim', '090890980000', 23, 'kaltim'),
(23, 'fadhlyy', 'bogor', '090909087878', 25, 'bogor'),
(27, 'midah', 'semarang', '909988787878', 26, 'semarang');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_periksa`
--

CREATE TABLE `jadwal_periksa` (
  `id` int NOT NULL,
  `id_dokter` int NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `status` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwal_periksa`
--

INSERT INTO `jadwal_periksa` (`id`, `id_dokter`, `hari`, `jam_mulai`, `jam_selesai`, `status`) VALUES
(24, 22, 'Senin', '07:00:00', '12:00:00', 0),
(25, 22, 'Selasa', '14:00:00', '17:00:00', 1),
(26, 23, 'Kamis', '12:00:00', '13:00:00', 0),
(27, 23, 'Selasa', '13:00:00', '07:13:00', 1),
(28, 23, 'Rabu', '12:30:00', '13:50:00', 0),
(29, 23, 'Sabtu', '12:00:00', '15:00:00', 0),
(30, 23, 'Sabtu', '17:20:00', '18:00:00', 0),
(31, 23, 'Selasa', '12:00:00', '13:00:00', 0),
(32, 23, 'Senin', '15:50:00', '16:00:00', 1),
(33, 23, 'Jumat', '07:00:00', '09:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id` int NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `kemasan` varchar(50) NOT NULL,
  `harga` double NOT NULL,
  `Stok` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id`, `nama_obat`, `kemasan`, `harga`, `Stok`) VALUES
(30, 'promagh', 'tablet', 20000, 13),
(32, 'paracetamol', 'tablet', 20000, 13),
(35, 'paratusin', 'plastik', 10000, 10);

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_ktp` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `no_rm` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id`, `nama`, `password`, `alamat`, `no_ktp`, `no_hp`, `no_rm`) VALUES
(50, 'sherly pradana', '$2y$10$XOe79mPlm3HpklzdcSDU5OzAlY8mSeMpqR9mW4Vf1rPjUdI1wu27G', 'talisayan', '123456789087', '1234478900997', '202412-001'),
(51, 'syifa', '$2y$10$ZjtqHXmkxzw1IYBVKA37L.HMTv3RIVAufAwLBShvafUlhWauVek5W', 'solo', '1234567890', '01234567890', '202412-002'),
(52, 'fajriyah', '$2y$10$IYHvfeYavpvZP8kEBX7Nbuhq029EM0TVQRjquv2KkX/yFtxhpuU/G', 'solo', '12345678900', '01234567890', '202412-003'),
(53, 'iyah', '$2y$10$7.SwTLXt8kov9d/7PuoOm.BKrhDUkC835XeB30QYcgtjibLFXIjIe', 'solo', '219038474856473', '210948329000', '202412-004'),
(54, 'iyah', '$2y$10$uwEtbgrGHfCpRMvNUjIkCej3qrnhGqvR3XatJYAjfZjtvqsUNYEBS', 'solo', '12120984209348', '34029358239059', '202412-005'),
(55, 'pradana', '$2y$10$HVNns53FvsLtcCptJl1b3eZhQP9xG6F7P9pEgMJcselK091EvXwji', 'talisayan', '1234556788990', '0909988787878', '202412-006'),
(56, 'ainy', '$2y$10$H1CkYxjUADVCF5yJ6qZ27ugf920aKmeEdIl6lNiDCEVLmf2VvJzt6', 'solo', '123457278093811', '124579701878679', '202412-007');

-- --------------------------------------------------------

--
-- Table structure for table `periksa`
--

CREATE TABLE `periksa` (
  `id` int NOT NULL,
  `id_daftar_poli` int NOT NULL,
  `tgl_periksa` datetime NOT NULL,
  `catatan` text NOT NULL,
  `biaya_periksa` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `periksa`
--

INSERT INTO `periksa` (`id`, `id_daftar_poli`, `tgl_periksa`, `catatan`, `biaya_periksa`) VALUES
(45, 51, '2024-12-25 17:26:57', 'kurang minum air putih dan vitamin saja', 170000),
(46, 53, '2024-12-26 12:00:56', 'sakit diare, harus minum paracetamol. vutamin', 170000),
(47, 54, '2024-12-26 17:21:43', 'jeprpw', 170000),
(48, 56, '2024-12-26 18:05:18', 'sakit', 150000),
(49, 56, '2024-12-26 18:05:23', 'sakit', 170000),
(50, 52, '2024-12-27 00:30:50', 'sakit', 170000),
(51, 58, '2024-12-27 06:34:39', 'istirhat yang cukup', 170000),
(52, 59, '2024-12-29 15:43:43', 'sakit', 170000),
(53, 60, '2024-12-29 15:47:38', 'oke 55', 200000),
(54, 61, '2024-12-29 15:52:58', 'oke 66', 220000),
(55, 63, '2024-12-29 16:25:25', 'oke88', 170000),
(56, 64, '2025-01-01 10:42:22', 'kekurangan cairan', 190000);

-- --------------------------------------------------------

--
-- Table structure for table `poli`
--

CREATE TABLE `poli` (
  `id` int NOT NULL,
  `nama_poli` varchar(25) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `poli`
--

INSERT INTO `poli` (`id`, `nama_poli`, `keterangan`) VALUES
(23, 'POLI UMUM', 'UNTUK UMUM'),
(25, 'POLI ANAK', 'untuk anak-anak'),
(26, 'POLI ORTHO', 'tulang dan saraf');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`) VALUES
(5, 'Sherly', 'sherly', '$2y$10$N62cIW0yK4nVmIY5Tan3M.htfzCRWzp7pTro4NSZBpVcq.7huua3e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pasien_daftar_poli` (`id_pasien`),
  ADD KEY `fk_jadwal_periksa_daftar_poli` (`id_jadwal`);

--
-- Indexes for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detail_periksa_obat` (`id_obat`),
  ADD KEY `fk_periksa_detail_periksa` (`id_periksa`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dokter_poli` (`id_poli`);

--
-- Indexes for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_jadwal_periksa_dokter` (`id_dokter`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periksa`
--
ALTER TABLE `periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_daftar_poli_periksa` (`id_daftar_poli`);

--
-- Indexes for table `poli`
--
ALTER TABLE `poli`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `periksa`
--
ALTER TABLE `periksa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `poli`
--
ALTER TABLE `poli`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD CONSTRAINT `fk_jadwal_periksa_daftar_poli` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_periksa` (`id`),
  ADD CONSTRAINT `fk_pasien_daftar_poli` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`);

--
-- Constraints for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD CONSTRAINT `fk_detail_periksa_obat` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`),
  ADD CONSTRAINT `fk_periksa_detail_periksa` FOREIGN KEY (`id_periksa`) REFERENCES `periksa` (`id`);

--
-- Constraints for table `dokter`
--
ALTER TABLE `dokter`
  ADD CONSTRAINT `fk_dokter_poli` FOREIGN KEY (`id_poli`) REFERENCES `poli` (`id`);

--
-- Constraints for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD CONSTRAINT `fk_jadwal_periksa_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`);

--
-- Constraints for table `periksa`
--
ALTER TABLE `periksa`
  ADD CONSTRAINT `fk_daftar_poli_periksa` FOREIGN KEY (`id_daftar_poli`) REFERENCES `daftar_poli` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
