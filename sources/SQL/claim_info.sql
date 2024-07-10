-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2024 at 03:05 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

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
  `subcategory` int(11) DEFAULT NULL,
  `PerDay` int(11) DEFAULT NULL,
  `PerIncident` int(11) DEFAULT NULL,
  `PerYear` int(11) DEFAULT NULL,
  `PerLife` int(11) DEFAULT NULL,
  `ResetTime` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `claim_info`
--

INSERT INTO `claim_info` (`ClaimID`, `Name`, `Category`, `subcategory`, `PerDay`, `PerIncident`, `PerYear`, `PerLife`, `ResetTime`) VALUES
(1, 'Room Charges', '11', 1, 3000, 30000, NULL, NULL, NULL),
(2, 'Surgical And Medical treatment', '11', 2, NULL, 80000, NULL, NULL, NULL),
(3, 'Medical Test', '11', 3, NULL, 40000, NULL, NULL, NULL),
(4, 'Room Charges - Government Aryuvedic Hospitals', '12', 1, 3000, 30000, NULL, NULL, NULL),
(5, 'Room Charges - Private Hospitals', '13', 1, 8000, 80000, NULL, NULL, NULL),
(6, 'Surgical And Medical Treatment - Private Hospitals', '13', 2, NULL, 80000, NULL, NULL, NULL),
(7, 'Consultant Fee - Private Hospitals', '13', 3, NULL, 50000, NULL, NULL, NULL),
(8, 'Medical Test - Private Hospitals', '13', 4, NULL, 40000, NULL, NULL, NULL),
(9, 'Room Charges - Private Ayuvedic Hospitals', '14', 1, 8000, 80000, NULL, NULL, NULL);

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
  MODIFY `ClaimID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
