-- phpMyAdmin SQL Dump
-- version 5.2.2
-- Host: localhost
-- Server version: 10.11.11-MariaDB
-- PHP Version: 8.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET NAMES utf8mb4;

-- Database: db_rekam_medis

-- --------------------------------------------------------
-- Table structure for table dokter
-- --------------------------------------------------------

CREATE TABLE `dokter` (
  `id_dokter` int(11) NOT NULL,
  `nama_dokter` varchar(100) NOT NULL,
  `spesialisasi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `dokter` (`id_dokter`, `nama_dokter`, `spesialisasi`) VALUES
(1, 'Dr. Ana Dahlia', 'Dokter Umum'),
(2, 'Dr. Saputra Wijaya', 'Gigi '),
(3, 'Dr. Risa Saputri', 'Bedah'),
(5, 'Dr. Citra Mardiyah', 'Polianak'),
(6, 'Dr. Riski Pratama', 'Dokter Saraf');

-- --------------------------------------------------------
-- Table structure for table obat
-- --------------------------------------------------------

CREATE TABLE `obat` (
  `id_obat` int(11) NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `satuan` varchar(30) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `obat` (`id_obat`, `nama_obat`, `satuan`, `stok`) VALUES
(1, 'Paracetamol', 'Tablet', 55),
(2, 'Mixagrip ', 'Tablet', 1165),
(3, 'Inflagin', 'Tablet', 225),
(6, 'Paramex', 'Tablet', 234),
(7, 'Panadol', 'Tablet', 5566);

-- --------------------------------------------------------
-- Table structure for table pasien
-- --------------------------------------------------------

CREATE TABLE `pasien` (
  `id_pasien` int(11) NOT NULL,
  `no_rm` varchar(20) NOT NULL,
  `nama_pasien` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `pasien` (`id_pasien`, `no_rm`, `nama_pasien`, `jenis_kelamin`, `tanggal_lahir`, `alamat`) VALUES
(1, '005', 'Rina Puspita', 'P', '1998-05-12', 'Ds. Tobo Kec. Merakurak Kab. Tuban'),
(2, '001', 'Uliya Putri', 'P', '2001-11-14', 'Ds.Jarorejo Kec.Kerek Kab.Tuban '),
(3, '002', 'Rohma Auliya', 'P', '2003-12-09', 'Ds. Jarorejo Kec. Kerek Kab. Tuban'),
(5, '003', 'Alexandra Calista', 'P', '2021-06-15', 'Ds. Tuwiri Wetan Kec. Merakurak Kab. Tuban'),
(6, '004', 'Risa Anggiyanti', 'P', '2012-12-04', 'Ds. Margomulyo Kec. Kerek Kab. Tuban'),
(8, '006', 'Ahmad Yanto', 'L', '1987-08-14', 'Ds. Karanglo Kec. Kerek Kab. Tuban'),
(9, '007', 'Sri Puspita', 'P', '1999-08-05', 'Ds. Tobo Kec. Merakurak Kab. Tuban');

-- --------------------------------------------------------
-- Table structure for table rekam_medis
-- --------------------------------------------------------

CREATE TABLE `rekam_medis` (
  `id_rekam` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL,
  `tanggal_periksa` date NOT NULL,
  `keluhan` text NOT NULL,
  `diagnosa` text NOT NULL,
  `tindakan` text NOT NULL,
  `resep` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rekam_medis` (`id_rekam`, `id_pasien`, `id_dokter`, `id_obat`, `tanggal_periksa`, `keluhan`, `diagnosa`, `tindakan`, `resep`) VALUES
(1, 1, 1, 1, '2026-03-06', 'badan rasanya tidak enak dan ada rasa mual', 'Demam', 'Memeriksa keadan pasien dan memberikan obat yang sesuai dengan penyakitnya', '3 X sehari setelah makan'),
(2, 3, 2, 3, '2026-12-11', 'Gigi Berlubang Dan Terasa Ngilu', 'Sakit Gigi', 'Memeriksa Gigi secara Menyeluruh', '3 X 1 Sehari Setelah Makan'),
(4, 5, 5, 6, '2026-11-16', 'Sakit Kepala', 'Migran ', 'Memeriksa Tensi dan Menanaykan apa saja yang di rasakan oleh anak tersebut ', 'Obat di minum 3 X Sehari Setelah Makan'),
(5, 2, 2, 3, '2026-11-12', 'Sakit Gigi, Gigi Berlubang', 'Gigi Kurang Sehat', 'Memeriksa Gigi Secara Keseluruhan', 'Obat Diminum 3 X sehari setelah makan'),
(6, 8, 6, 7, '2026-11-17', 'Sakit Pinggang', 'Saraf Kejepit', 'Memeriksa Bagian yang Sakit ', 'Obat Diminum 3 X sehari setelah makan');

-- --------------------------------------------------------
-- Indexes
-- --------------------------------------------------------

ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id_dokter`);

ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`);

ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id_pasien`);

ALTER TABLE `rekam_medis`
  ADD PRIMARY KEY (`id_rekam`),
  ADD KEY `fk_rekam_pasien` (`id_pasien`),
  ADD KEY `fk_rekam_dokter` (`id_dokter`),
  ADD KEY `fk_rekam_obat` (`id_obat`);

-- --------------------------------------------------------
-- AUTO_INCREMENT
-- --------------------------------------------------------

ALTER TABLE `dokter`
  MODIFY `id_dokter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `obat`
  MODIFY `id_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `pasien`
  MODIFY `id_pasien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `rekam_medis`
  MODIFY `id_rekam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

-- --------------------------------------------------------
-- Foreign Keys
-- --------------------------------------------------------

ALTER TABLE `rekam_medis`
  ADD CONSTRAINT `fk_rekam_dokter`
    FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`),
  ADD CONSTRAINT `fk_rekam_obat`
    FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`),
  ADD CONSTRAINT `fk_rekam_pasien`
    FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`);

COMMIT;