-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 10 Mei 2017 pada 11.49
-- Versi Server: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `suratsdm`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tdposisi`
--

CREATE TABLE `tdposisi` (
  `id` int(11) NOT NULL,
  `dari` int(11) NOT NULL,
  `tujuan` int(11) NOT NULL,
  `dposisi` text NOT NULL,
  `tgldposisi` date NOT NULL,
  `tglentri` date NOT NULL,
  `noagenda` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tdposisi`
--

INSERT INTO `tdposisi` (`id`, `dari`, `tujuan`, `dposisi`, `tgldposisi`, `tglentri`, `noagenda`) VALUES
(14, 1, 3, 'Silahkan di banting', '2017-01-21', '2017-04-18', '00004'),
(11, 1, 2, 'Select up to 20 PDF files and images from your computer or drag them to the drop area.', '2017-01-20', '2017-01-20', '00001'),
(12, 1, 2, 'Drag-and-drop file blocks to change the order. When you are ready to proceed, click COMBINE button.', '2017-01-20', '2017-01-20', '00002'),
(15, 1, 2, 'hredherheh', '2017-03-08', '2017-04-17', '00001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tsatker`
--

CREATE TABLE `tsatker` (
  `id` int(11) NOT NULL,
  `satker` varchar(50) NOT NULL,
  `dari` tinyint(1) NOT NULL,
  `tujuan` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tsatker`
--

INSERT INTO `tsatker` (`id`, `satker`, `dari`, `tujuan`) VALUES
(1, 'Direktur Utama', 1, 0),
(2, 'Direktur Medik dan Keperawatan', 1, 1),
(3, 'Direktur Umum, SDM &amp; Pendidikan', 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tsurat`
--

CREATE TABLE `tsurat` (
  `id` int(11) NOT NULL,
  `noagenda` varchar(5) NOT NULL,
  `nosurat` varchar(35) NOT NULL,
  `tglsurat` date NOT NULL,
  `tglterima` date NOT NULL,
  `sifat` varchar(10) NOT NULL,
  `asal` varchar(50) NOT NULL,
  `hal` text NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `tglentri` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tsurat`
--

INSERT INTO `tsurat` (`id`, `noagenda`, `nosurat`, `tglsurat`, `tglterima`, `sifat`, `asal`, `hal`, `status`, `tglentri`) VALUES
(2, '00002', '012', '2017-01-14', '2017-01-14', 'Biasa', 'some body', 'everything', 1, '2017-01-14'),
(3, '00003', '12032', '2017-01-13', '2017-01-14', 'Cito', 'boliwood', 'This optional parameter is a constant indicating what type of array should be produced', 0, '2017-04-17'),
(8, '00004', 'BK.01.02/8343/2017', '2017-01-19', '2017-01-20', 'Rahasia', 'Bebek', 'Bebek suka mbebek-i', 1, '2017-01-20'),
(1, '00001', 'AD22334', '2017-01-13', '2017-01-15', 'Cito', 'sosro', 'W3Schools is optimized for learning', 1, '2017-01-16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tuser`
--

CREATE TABLE `tuser` (
  `id` tinyint(4) NOT NULL,
  `userid` varchar(15) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `sandi` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tuser`
--

INSERT INTO `tuser` (`id`, `userid`, `nama`, `sandi`) VALUES
(1, 'admin', 'santoso', 'kampret');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tdposisi`
--
ALTER TABLE `tdposisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tsatker`
--
ALTER TABLE `tsatker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tsurat`
--
ALTER TABLE `tsurat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `noagenda` (`noagenda`),
  ADD UNIQUE KEY `nosurat` (`nosurat`);

--
-- Indexes for table `tuser`
--
ALTER TABLE `tuser`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userid` (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tdposisi`
--
ALTER TABLE `tdposisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `tsatker`
--
ALTER TABLE `tsatker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tsurat`
--
ALTER TABLE `tsurat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tuser`
--
ALTER TABLE `tuser`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
