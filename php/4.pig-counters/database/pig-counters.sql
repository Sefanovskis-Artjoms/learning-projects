-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2024 at 06:58 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pig-counters`
--

-- --------------------------------------------------------

--
-- Table structure for table `maintable`
--

CREATE TABLE `maintable` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `zone` int(2) NOT NULL,
  `Hair` int(6) NOT NULL,
  `Foreign object` int(6) NOT NULL,
  `Sticking area` int(6) NOT NULL,
  `Rail dust/ Other` int(6) NOT NULL,
  `Faceal pingead size` int(6) NOT NULL,
  `Faceal larger size` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintable`
--

INSERT INTO `maintable` (`id`, `date`, `zone`, `Hair`, `Foreign object`, `Sticking area`, `Rail dust/ Other`, `Faceal pingead size`, `Faceal larger size`) VALUES
(1, '2024-02-12', 1, 0, 0, 0, 0, 0, 0),
(2, '2024-02-12', 2, 0, 0, 0, 0, 0, 0),
(3, '2024-02-12', 3, 0, 0, 0, 0, 0, 0),
(4, '2024-02-12', 4, 0, 0, 0, 0, 0, 0),
(5, '2024-02-12', 5, 5, 4, 15, 6, 0, 0),
(6, '2024-02-12', 6, 0, 0, 0, 0, 0, 0),
(7, '2024-02-12', 7, 0, 0, 0, 0, 0, 0),
(8, '2024-02-12', 8, 0, 0, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `maintable`
--
ALTER TABLE `maintable`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `maintable`
--
ALTER TABLE `maintable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
