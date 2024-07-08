-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2024 at 12:12 PM
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
-- Database: `insurance_as`
--

-- --------------------------------------------------------

--
-- Table structure for table `claim_info`
--

CREATE TABLE `claim_info` (
  `ClaimID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Category` varchar(50) DEFAULT NULL,
  `SubCategory 1` int(11) DEFAULT NULL,
  `SubCategory 2` int(11) DEFAULT NULL,
  `PerDay` int(11) DEFAULT NULL,
  `PerIncident` float DEFAULT NULL,
  `PerYear` int(11) DEFAULT NULL,
  `PerLife` int(11) DEFAULT NULL,
  `ResetTime` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `claim_info`
--

INSERT INTO `claim_info` (`ClaimID`, `Name`, `Category`, `SubCategory 1`, `SubCategory 2`, `PerDay`, `PerIncident`, `PerYear`, `PerLife`, `ResetTime`) VALUES
(1, 'Room Charges - Government Hospitals', '1', 1, 1, 3000, 30000, NULL, NULL, NULL),
(2, 'Surgical And Medical treatment- Government Hospitals', '1', 1, 2, NULL, 80000, NULL, NULL, NULL),
(3, 'Medical Test - Government Hospitals', '1', 1, 3, NULL, 40000, NULL, NULL, NULL),
(4, 'Room Charges - Government Aryuvedic Hospitals', '1', 2, 1, 3000, 30000, NULL, NULL, NULL),
(5, 'Room Charges - Private Hospitals', '1', 3, 1, 8000, 80000, NULL, NULL, NULL),
(6, 'Surgical And Medical Treatment - Private Hospitals', '1', 3, 2, NULL, 80000, NULL, NULL, NULL),
(7, 'Consultant Fee - Private Hospitals', '1', 3, 3, NULL, 50000, NULL, NULL, NULL),
(8, 'Medical Test - Private Hospitals', '1', 3, 4, NULL, 40000, NULL, NULL, NULL),
(9, 'Room Charges - Private Ayuvedic Hospitals', '1', 4, 1, 8000, 80000, NULL, NULL, NULL),
(10, 'Surgical and Medical Treatment - Private Ayurvedic Hospitals', '1', 4, 2, NULL, 80000, NULL, NULL, NULL),
(11, 'Consultant Fee - Private Ayurvedic Hospitals', '1', 4, 3, NULL, 50000, NULL, NULL, NULL),
(12, 'Medical Tests - Private Ayurvedic Hospitals', '1', 4, 4, NULL, 40000, NULL, NULL, NULL),
(13, 'Heart Surgery - (Dependant)', '1', 5, 0, NULL, 200000, NULL, NULL, NULL),
(14, 'Child Birth - Government Hospital', '2', 1, 0, 3000, 15000, NULL, 30000, NULL),
(15, 'Child Birth | Normal - Private Hospital', '2', 2, 0, NULL, 50000, NULL, 100000, NULL),
(16, 'Child Birth | Ceaser - Private Hospital', '2', 3, 0, NULL, 100000, NULL, 200000, NULL),
(17, 'Heart | Surgery', '3', 1, 0, NULL, NULL, NULL, 1000000, NULL),
(18, 'Heart | Surgery Guarantee', '3', 2, 0, NULL, NULL, NULL, 1000000, NULL),
(19, 'Heart - RF Ablation', '3', 3, 0, NULL, 500000, NULL, 1000000, NULL),
(20, 'Cancer', '4', 0, 0, NULL, NULL, NULL, 600000, NULL),
(21, 'Kidney - Surgery', '5', 1, 0, NULL, NULL, NULL, 1200000, NULL),
(22, 'Kidney - Surgery Guarantee', '5', 2, 0, NULL, NULL, NULL, 1200000, NULL),
(23, 'Brain - Surgery', '6', 1, 0, NULL, NULL, NULL, 1200000, NULL),
(24, 'Brain - Surgery Guarantee', '6', 2, 0, NULL, NULL, NULL, 1200000, NULL),
(25, 'Knee', '7', 0, 0, NULL, NULL, NULL, 250000, NULL),
(26, 'Hip', '8', 0, 0, NULL, NULL, NULL, 250000, NULL),
(27, 'Hearing Aid', '9', 0, 0, NULL, NULL, NULL, 100000, NULL),
(28, 'Spectacles', '10', 0, 0, NULL, 5000, NULL, NULL, 3),
(29, 'Death - Natural', '11', 1, 0, NULL, NULL, NULL, 700000, NULL),
(30, 'Death - Accidental', '11', 2, 0, NULL, NULL, NULL, 2000000, NULL),
(31, 'Accident', '12', 0, 0, NULL, NULL, NULL, 1500000, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `claim_info`
--
ALTER TABLE `claim_info`
  ADD PRIMARY KEY (`ClaimID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `claim_info`
--
ALTER TABLE `claim_info`
  MODIFY `ClaimID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
