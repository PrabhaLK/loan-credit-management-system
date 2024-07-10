-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2024 at 10:57 AM
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
-- Table structure for table `user-claim-bills`
--

CREATE TABLE `user-claim-bills` (
  `ClaimID` int(11) NOT NULL,
  `Dates` int(11) NOT NULL,
  `RoomCharges` int(11) NOT NULL,
  `MTest` int(11) NOT NULL,
  `SMTratment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user-claim-bills`
--

INSERT INTO `user-claim-bills` (`ClaimID`, `Dates`, `RoomCharges`, `MTest`, `SMTratment`) VALUES
(1, 4, 12000, 1200, 1200),
(2, 1, 3000, 1412, 410),
(3, 1, 3000, 1412, 410),
(4, 0, 30000, 9000, 5000),
(5, 1, 3000, 1, 2),
(6, 1, 3000, 3, 2),
(7, 1, 3000, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `NIC` varchar(12) NOT NULL,
  `Name` varchar(25) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`NIC`, `Name`, `email`, `password`) VALUES
('200109801790', 'Prabhashana Muthukumarana', 'mudithaid@outlook.com', 'pass');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user-claim-bills`
--
ALTER TABLE `user-claim-bills`
  ADD PRIMARY KEY (`ClaimID`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`NIC`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user-claim-bills`
--
ALTER TABLE `user-claim-bills`
  MODIFY `ClaimID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
