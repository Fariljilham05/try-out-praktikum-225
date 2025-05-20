-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 20, 2025 at 01:12 AM
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
-- Database: `auth_faril`
--

-- --------------------------------------------------------

--
-- Table structure for table `saldo`
--

CREATE TABLE `saldo` (
  `id` int NOT NULL,
  `tipe` enum('pemasukan','pengeluaran') DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `saldo`
--

INSERT INTO `saldo` (`id`, `tipe`, `kategori`, `jumlah`, `tanggal`) VALUES
(16, 'pemasukan', 'Gaji', 5000000, '2025-05-18'),
(17, 'pengeluaran', 'Bayar Listrik', 2500000, '2025-05-17'),
(18, 'pengeluaran', 'Bayar Tagihan', 1000000, '2025-05-19'),
(19, 'pengeluaran', 'Membeli Makanan', 100000, '2025-05-19'),
(20, 'pemasukan', 'Gaji', 3000000, '2025-05-19'),
(21, 'pengeluaran', 'Membeli Sepatu', 1000000, '2025-05-18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `role`) VALUES
(1, 'faril', 'faril@gmail.com', '$2y$10$ZKNOL2sgv77Jlmtfp91KQO8U0Mi.w6ywkAHO9gCJTVB41x2x2bfke', 'user'),
(2, 'faril jilham', 'faril12@gmail.com', '$2y$10$baPmO3G7Y55SJ/PEGqtwYOQqGUq6Pd3S1286MpfPfawSDuLUh3eGW', 'user'),
(3, 'faril jilham', 'faril12@gmail.com', '$2y$10$Ox34ce6PjzFD3uv8NDjjwued1a7ULX25MdMzOhhVB6gZoz3fidoEW', 'user'),
(4, 'faril jilham', 'faril1@gmail.com', '$2y$10$hXqpVVrJQefkPUnqY70MEee2.FXsoJzwg2dgIg9m6E0HNikhXR32W', 'user'),
(5, 'Muhammad Afgan Rizqika', 'afganngann@gmail.com', '$2y$10$CxU3PU3OyRAsEUN6KFFGeuFnbzFCDSTLEy6cZId6BpRi2qx4Bfoca', 'user'),
(6, 'Muhammad Afgan Rizqika', 'afganngann@gmail.com', '$2y$10$T1x8DSIi9VHzxSiIiypTq.XlQOoNzZL4sxMvm1RNmHMnPB0h8DkVK', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `saldo`
--
ALTER TABLE `saldo`
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
-- AUTO_INCREMENT for table `saldo`
--
ALTER TABLE `saldo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
