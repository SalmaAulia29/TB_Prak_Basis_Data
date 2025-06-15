-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2025 at 09:50 AM
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
-- Database: `kel10`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_servis`
--

CREATE TABLE `booking_servis` (
  `id_booking` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_kendaraan` int(11) NOT NULL,
  `id_layanan` int(11) NOT NULL,
  `tanggal_booking` date NOT NULL,
  `jam_booking` time NOT NULL,
  `catatan` text DEFAULT NULL,
  `status_booking` enum('menunggu_konfirmasi','dikonfirmasi','sedang_dikerjakan','selesai','dibatalkan') DEFAULT 'menunggu_konfirmasi',
  `total_biaya` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id_kendaraan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `merk` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `no_polisi` varchar(15) NOT NULL,
  `warna` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `layanan_servis`
--

CREATE TABLE `layanan_servis` (
  `id_layanan` int(11) NOT NULL,
  `nama_layanan` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `estimasi_waktu` int(11) NOT NULL COMMENT 'dalam menit',
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layanan_servis`
--

INSERT INTO `layanan_servis` (`id_layanan`, `nama_layanan`, `deskripsi`, `harga`, `estimasi_waktu`, `status`, `created_at`) VALUES
(1, 'Ganti Oli', 'Mengganti oli mesin dan filter oli', 150000.00, 30, 'aktif', '2025-06-10 07:31:20'),
(2, 'Servis Mesin', 'Perawatan menyeluruh mesin kendaraan', 300000.00, 120, 'aktif', '2025-06-10 07:31:20'),
(3, 'Perbaikan AC', 'Perbaikan dan perawatan sistem AC kendaraan', 250000.00, 90, 'aktif', '2025-06-10 07:31:20'),
(4, 'Tune Up', 'Perawatan menyeluruh kendaraan', 400000.00, 180, 'aktif', '2025-06-10 07:31:20'),
(5, 'Ganti Ban', 'Penggantian ban kendaraan', 200000.00, 45, 'aktif', '2025-06-10 07:31:20'),
(6, 'Servis Rem', 'Perawatan sistem rem kendaraan', 180000.00, 60, 'aktif', '2025-06-10 07:31:20');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_servis`
--
ALTER TABLE `booking_servis`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_kendaraan` (`id_kendaraan`),
  ADD KEY `id_layanan` (`id_layanan`);

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id_kendaraan`),
  ADD UNIQUE KEY `no_polisi` (`no_polisi`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `layanan_servis`
--
ALTER TABLE `layanan_servis`
  ADD PRIMARY KEY (`id_layanan`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_servis`
--
ALTER TABLE `booking_servis`
  MODIFY `id_booking` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id_kendaraan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `layanan_servis`
--
ALTER TABLE `layanan_servis`
  MODIFY `id_layanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_servis`
--
ALTER TABLE `booking_servis`
  ADD CONSTRAINT `booking_servis_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_servis_ibfk_2` FOREIGN KEY (`id_kendaraan`) REFERENCES `kendaraan` (`id_kendaraan`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_servis_ibfk_3` FOREIGN KEY (`id_layanan`) REFERENCES `layanan_servis` (`id_layanan`) ON DELETE CASCADE;

--
-- Constraints for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD CONSTRAINT `kendaraan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
