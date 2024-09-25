-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2024 at 10:34 AM
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
  `CategoryName` varchar(255) DEFAULT NULL,
  `SubCategory 1` int(11) DEFAULT NULL,
  `SubCategory 1 Name` varchar(255) DEFAULT NULL,
  `SubCategory 2` int(11) DEFAULT NULL,
  `SubCategory 2 Name` varchar(255) DEFAULT NULL,
  `PerDay` int(11) DEFAULT NULL,
  `PerIncident` int(11) DEFAULT NULL,
  `PerYear` int(11) DEFAULT NULL,
  `PerLife` int(11) DEFAULT NULL,
  `ResetTime` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `claim_info`
--

INSERT INTO `claim_info` (`ClaimID`, `Name`, `Category`, `CategoryName`, `SubCategory 1`, `SubCategory 1 Name`, `SubCategory 2`, `SubCategory 2 Name`, `PerDay`, `PerIncident`, `PerYear`, `PerLife`, `ResetTime`) VALUES
(1, 'Hospitalization', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 350000, NULL, 1),
(2, 'Room Charges - Government Hospitals', '1', 'Hospitalization', 1, 'Government Hospitalization', 1, 'RoomCharges', 3000, 30000, 350000, 0, 0),
(3, 'Surgical And Medical treatment- Government Hospitals', '1', 'Hospitalization', 1, 'Government Hospitalization', 2, 'MedicalTreatment', NULL, 80000, 350000, NULL, NULL),
(4, 'Medical Test - Government Hospitals', '1', 'Hospitalization', 1, 'Government Hospitalization', 3, 'MedicalTest', NULL, 40000, 350000, NULL, NULL),
(5, 'Room Charges - Government Aryuvedic Hospitals', '1', 'Hospitalization', 2, 'Government Ayuvedic Hospitalization', 1, 'RoomCharges', 3000, 30000, 350000, NULL, NULL),
(6, 'Room Charges - Private Hospitals', '1', 'Hospitalization', 3, 'Private Hospitalization', 1, 'RoomCharges', 8000, 80000, 350000, NULL, NULL),
(7, 'Surgical And Medical Treatment - Private Hospitals', '1', 'Hospitalization', 3, 'Private Hospitalization', 2, 'MedicalTreatment', NULL, 80000, 350000, NULL, NULL),
(8, 'Consultant Fee - Private Hospitals', '1', 'Hospitalization', 3, 'Private Hospitalization', 3, 'ConsultantFee', NULL, 50000, 350000, NULL, NULL),
(9, 'Medical Test - Private Hospitals', '1', 'Hospitalization', 3, 'Private Hospitalization', 4, 'MedicalTest', NULL, 40000, 350000, NULL, NULL),
(10, 'Room Charges - Private Ayuvedic Hospitals', '1', 'Hospitalization', 4, 'Private Ayuvedic Hospitalization', 1, 'RoomCharges', 8000, 80000, 200000, NULL, NULL),
(11, 'Surgical and Medical Treatment - Private Ayurvedic Hospitals', '1', 'Hospitalization', 4, 'Private Ayuvedic Hospitalization', 2, 'MedicalTreatment', NULL, 80000, 200000, NULL, NULL),
(12, 'Consultant Fee - Private Ayurvedic Hospitals', '1', 'Hospitalization', 4, 'Private Ayuvedic Hospitalization', 3, 'ConsultantFee', NULL, 50000, 200000, NULL, NULL),
(13, 'Medical Tests - Private Ayurvedic Hospitals', '1', 'Hospitalization', 4, 'Private Ayuvedic Hospitalization', 4, 'MedicalTest', NULL, 40000, 200000, NULL, NULL),
(14, 'Heart Surgery - (Dependant)', '1', 'Hospitalization', 5, 'Heart Surgery - Dependant', 0, 'PerIncident', NULL, 200000, 350000, NULL, NULL),
(15, 'Child Birth - Government Hospital', '2', 'Child Birth', 1, 'Child Birth - Government Hospital', 0, 'RoomCharges', 3000, 15000, NULL, 30000, NULL),
(16, 'Child Birth | Normal - Private Hospital', '2', 'Child Birth', 2, 'Child Birth- Private Hospital (Normal)', 0, 'PerIncident', NULL, 50000, NULL, 100000, NULL),
(17, 'Child Birth | Ceaser - Private Hospital', '2', 'Child Birth', 3, 'Child Birth- Private Hospital (Ceaser)', 0, 'PerIncident', NULL, 100000, NULL, 200000, NULL),
(18, 'Heart - Surgery', '3', 'Heart', 1, 'Heart Surgery', 0, 'PerLife', NULL, NULL, NULL, 1000000, NULL),
(19, 'Heart | Surgery Guarantee', '3', 'Heart', 2, 'Heart Surgery - Guarantee', 0, 'PerLife', NULL, NULL, NULL, 1000000, NULL),
(20, 'Heart - RF Ablation', '3', 'Heart', 3, 'RF Ablation', 0, 'PerIncident', NULL, 500000, NULL, 1000000, NULL),
(21, 'Cancer', '4', 'Cancer', 0, 'Cancer', 0, 'PerLife', NULL, NULL, NULL, 600000, NULL),
(22, 'Kidney - Surgery', '5', 'Kidney', 1, 'Kidney Surgery', 0, 'PerLife', NULL, NULL, NULL, 1200000, NULL),
(23, 'Kidney - Surgery Guarantee', '5', 'Kidney', 2, 'Kidney Surgery - Guarantee', 0, 'PerLife', NULL, NULL, NULL, 1200000, NULL),
(24, 'Brain - Surgery', '6', 'Brain', 1, 'Brain Surgery', 0, 'PerLife', NULL, NULL, NULL, 1200000, NULL),
(25, 'Brain - Surgery Guarantee', '6', 'Brain', 2, 'Brain Surgery - Guarantee', 0, 'PerLife', NULL, NULL, NULL, 1200000, NULL),
(26, 'Knee', '7', 'Knee', 0, 'Knee', 0, 'PerLife', NULL, NULL, NULL, 250000, NULL),
(27, 'Hip', '8', 'Hip', 0, 'Hip', 0, 'PerLife', NULL, NULL, NULL, 250000, NULL),
(28, 'Hearing Aid', '9', 'Hearing Aid', 0, 'Hearing Aid', 0, 'PerLife', NULL, NULL, NULL, 100000, NULL),
(29, 'Spectacles', '10', 'Spectacles', 0, 'Spectacles', 0, 'PerIncident', NULL, 5000, NULL, NULL, 3),
(30, 'Death - Natural', '11', 'Death', 1, 'Natural Death', 0, 'PerLife', NULL, NULL, NULL, 700000, NULL),
(31, 'Death - Accidental', '11', 'Death', 2, 'Accidental Death', 0, 'PerLife', NULL, NULL, NULL, 2000000, NULL),
(32, 'Accident', '12', 'Accident', 0, 'Accident', 0, 'PerLife', NULL, NULL, NULL, 1500000, NULL),

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
  MODIFY `ClaimID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
