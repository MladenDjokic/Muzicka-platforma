-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 08:36 PM
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
-- Database: `muzika`
--

-- --------------------------------------------------------

--
-- Table structure for table `albumi`
--

CREATE TABLE `albumi` (
  `id` int(11) NOT NULL,
  `naziv` varchar(255) NOT NULL,
  `godina_izdavanja` year(4) NOT NULL,
  `izvodjac_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `albumi`
--

INSERT INTO `albumi` (`id`, `naziv`, `godina_izdavanja`, `izvodjac_id`) VALUES
(1, 'No angel', '2000', 1),
(2, 'Stronger than pride', '1988', 2),
(3, 'Idealno losa', '2006', 5),
(4, 'Gore od ljubavi', '2004', 5),
(5, 'Autogram', '2016', 5),
(6, 'Ceca 2000', '1999', 5),
(7, 'Seven', '2018', 6),
(8, 'Mi smo tu', '2002', 7),
(9, 'Zbog tebe', '1994', 8),
(10, 'Ove noci', '1995', 8),
(13, 'Milijun milja od nidje', '2001', 9),
(14, 'Najbolje od svega', '2003', 9),
(15, 'Single', '2017', 10),
(16, 'Single', '2020', 11);

-- --------------------------------------------------------

--
-- Table structure for table `izvodjaci`
--

CREATE TABLE `izvodjaci` (
  `id` int(11) NOT NULL,
  `ime` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `izvodjaci`
--

INSERT INTO `izvodjaci` (`id`, `ime`) VALUES
(1, 'Dido'),
(2, 'Sade'),
(5, 'Ceca'),
(6, 'Maya Berovic'),
(7, 'Funky G'),
(8, 'Dr. Iggy'),
(9, 'Colonia'),
(10, 'nipplepeople'),
(11, 'ACRAZE');

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `username`, `password`, `email`) VALUES
(1, 'MrDjokic', '$2y$10$yX.P1nAbZWavB8CiZEdMreL6/Rv3vW/I0Oml7SEeTcktl3TWLVwNy', 'mladendjokicgolub@yahoo.com'),
(2, 'admin', '$2y$10$KEZ6t.6sD74PMKG/LDs7uOBW1CZDvAwgC//qKtNPpOn5UmaRDAWWu', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `korisnicke_preferencije`
--

CREATE TABLE `korisnicke_preferencije` (
  `id` int(11) NOT NULL,
  `korisnicko_ime` varchar(255) NOT NULL,
  `omiljene_pesme` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `korisnicke_preferencije`
--

INSERT INTO `korisnicke_preferencije` (`id`, `korisnicko_ime`, `omiljene_pesme`) VALUES
(1, '1', '1,2,17,14,7'),
(2, '2', '');

-- --------------------------------------------------------

--
-- Table structure for table `pesme`
--

CREATE TABLE `pesme` (
  `id` int(11) NOT NULL,
  `naziv` varchar(255) NOT NULL,
  `trajanje` time NOT NULL,
  `izvodjac_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesme`
--

INSERT INTO `pesme` (`id`, `naziv`, `trajanje`, `izvodjac_id`, `album_id`) VALUES
(1, 'Thank you', '03:38:00', 1, 1),
(2, 'Paradise', '03:37:00', 2, 2),
(3, 'Lepi grome moj', '04:03:00', 5, 3),
(4, 'Gore od ljubavi', '03:56:00', 5, 5),
(5, 'Autogram', '03:43:00', 5, 5),
(6, 'Maskarada', '04:12:00', 5, 6),
(7, 'Pravo vreme', '03:35:00', 6, 7),
(8, 'Pauza', '03:14:00', 6, 7),
(9, 'Nisam je zaboravio', '04:22:00', 7, 8),
(10, 'Iza horizonta', '04:15:00', 7, 8),
(11, 'Uzalud se trudis', '03:50:00', 8, 9),
(12, 'Pusti me da zivim', '04:10:00', 8, 9),
(13, 'Sve oko mene je grijeh', '04:01:00', 9, 13),
(14, 'Frka', '04:04:00', 10, 15),
(17, 'Smooth Operator', '04:58:00', 2, 2),
(18, 'Tebi', '03:56:00', 10, 15),
(19, 'By your side', '04:34:00', 2, 2),
(20, 'White Flag', '04:01:00', 1, 1),
(21, 'Do It To It', '02:37:00', 11, 16),
(22, 'Believe', '03:10:00', 11, 16);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albumi`
--
ALTER TABLE `albumi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test3` (`izvodjac_id`);

--
-- Indexes for table `izvodjaci`
--
ALTER TABLE `izvodjaci`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `korisnicke_preferencije`
--
ALTER TABLE `korisnicke_preferencije`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesme`
--
ALTER TABLE `pesme`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test` (`izvodjac_id`),
  ADD KEY `test2` (`album_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albumi`
--
ALTER TABLE `albumi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `izvodjaci`
--
ALTER TABLE `izvodjaci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `korisnicke_preferencije`
--
ALTER TABLE `korisnicke_preferencije`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pesme`
--
ALTER TABLE `pesme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `albumi`
--
ALTER TABLE `albumi`
  ADD CONSTRAINT `test3` FOREIGN KEY (`izvodjac_id`) REFERENCES `izvodjaci` (`id`);

--
-- Constraints for table `pesme`
--
ALTER TABLE `pesme`
  ADD CONSTRAINT `test` FOREIGN KEY (`izvodjac_id`) REFERENCES `izvodjaci` (`id`),
  ADD CONSTRAINT `test2` FOREIGN KEY (`album_id`) REFERENCES `albumi` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
