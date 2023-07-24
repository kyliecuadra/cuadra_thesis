-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2023 at 05:23 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `contribution_monitoring_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `contributionfee`
--

CREATE TABLE `contributionfee` (
  `id` int(11) NOT NULL,
  `newAMF` decimal(20,2) NOT NULL,
  `oldAMF` decimal(20,2) NOT NULL,
  `MCF` decimal(20,2) NOT NULL,
  `dateNewAMF` datetime NOT NULL,
  `dateOldAMF` datetime NOT NULL,
  `dateMCF` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `contribution_records`
--

CREATE TABLE `contribution_records` (
  `id` int(20) NOT NULL,
  `empNo` int(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contributionType` varchar(255) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `month` varchar(255) NOT NULL,
  `year` int(20) NOT NULL,
  `date` date NOT NULL,
  `collected_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `contribution_summary`
--

CREATE TABLE `contribution_summary` (
  `id` int(20) NOT NULL,
  `empNo` int(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `Annual_Membership_Fee` decimal(20,2) NOT NULL DEFAULT 0.00,
  `Monthly_Contribution` decimal(20,2) NOT NULL DEFAULT 0.00,
  `Voluntary_Contribution` decimal(20,2) NOT NULL DEFAULT 0.00,
  `Special_Contribution` decimal(20,2) NOT NULL DEFAULT 0.00,
  `contributionOut` decimal(20,2) NOT NULL DEFAULT 0.00,
  `month` varchar(255) NOT NULL,
  `year` int(20) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `empNo` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `empNo` int(20) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `suffix` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dateJoined` date NOT NULL,
  `empStats` varchar(255) NOT NULL,
  `staffLvl` varchar(20) NOT NULL,
  `userLvl` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `empNo`, `fname`, `mname`, `lname`, `suffix`, `username`, `password`, `dateJoined`, `empStats`, `staffLvl`, `userLvl`, `status`) VALUES
(0, 0, 'Admin', '', '', '', 'admin', 'secretAdmin123', '0000-00-00', '', '', 'Admin', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contributionfee`
--
ALTER TABLE `contributionfee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contribution_records`
--
ALTER TABLE `contribution_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contribution_summary`
--
ALTER TABLE `contribution_summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
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
-- AUTO_INCREMENT for table `contributionfee`
--
ALTER TABLE `contributionfee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contribution_records`
--
ALTER TABLE `contribution_records`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contribution_summary`
--
ALTER TABLE `contribution_summary`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `START_SUMMARY` ON SCHEDULE EVERY 1 MONTH STARTS '2022-09-01 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO INSERT INTO contribution_summary (empNo, name, month, year, date) SELECT users.empNo, CONCAT(users.fname, ' ', users.mname, ' ', users.lname, ' ', users.suffix), MONTHNAME(NOW()), YEAR(NOW()), CAST(NOW() AS date) FROM users WHERE users.status = 1$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
