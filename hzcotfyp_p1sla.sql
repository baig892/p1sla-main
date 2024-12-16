-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2023 at 08:06 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hzcotfyp_p1sla`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`) VALUES
(1, 'admin', 'admin@', '12345687');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `labour_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `supervisor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `budget`
--

CREATE TABLE `budget` (
  `id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `date` date NOT NULL,
  `ack` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `budget`
--

INSERT INTO `budget` (`id`, `supervisor_id`, `project_id`, `amount`, `date`, `ack`) VALUES
(1, 13, 1, '10', '2023-01-10', 0),
(2, 14, 2, '20', '2023-01-10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `expense` decimal(10,0) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `bill` varchar(10000) DEFAULT NULL,
  `ack` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`id`, `project_id`, `supervisor_id`, `expense`, `description`, `date`, `bill`, `ack`) VALUES
(79, 1, 13, '100', 'pani', '2023-01-10', '79.png', 0),
(80, 1, 13, '200', 'khana', '2023-01-10', '80.jpg', 0),
(81, 2, 14, '100', 'chawal', '2023-01-10', '81.pdf', 0);

-- --------------------------------------------------------

--
-- Table structure for table `labour`
--

CREATE TABLE `labour` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `pay` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `labour`
--

INSERT INTO `labour` (`id`, `name`, `pay`) VALUES
(1, 'Lb 1 Ali', '100'),
(2, 'Lb 2 Umar', '200');

-- --------------------------------------------------------

--
-- Table structure for table `labour_pay`
--

CREATE TABLE `labour_pay` (
  `id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `labour_id` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `date` date NOT NULL,
  `ack` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `name`) VALUES
(1, '104 GCE'),
(2, '1401 Preatoni'),
(3, '1703 GCE'),
(4, 'Other Expences'),
(5, 'Paid To Labour by Supervisor'),
(6, 'Unpaid Labour');

-- --------------------------------------------------------

--
-- Table structure for table `project_supervisor`
--

CREATE TABLE `project_supervisor` (
  `project_id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_supervisor`
--

INSERT INTO `project_supervisor` (`project_id`, `supervisor_id`) VALUES
(1, 13),
(2, 14);

-- --------------------------------------------------------

--
-- Table structure for table `supervisor`
--

CREATE TABLE `supervisor` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supervisor`
--

INSERT INTO `supervisor` (`id`, `name`, `email`, `password`) VALUES
(13, 'Mr Usman', 'usman', 'usman123@'),
(14, 'Mr Zeeshan', 'zeeshan', 'zeeshan123@');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_id_2` (`project_id`,`labour_id`,`date`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `labour_id` (`labour_id`),
  ADD KEY `attendance_ibfk_3` (`supervisor_id`);

--
-- Indexes for table `budget`
--
ALTER TABLE `budget`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id_index` (`project_id`),
  ADD KEY `supervisor_id_index` (`supervisor_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id_index` (`project_id`),
  ADD KEY `supervisor_id_index` (`supervisor_id`) USING BTREE;

--
-- Indexes for table `labour`
--
ALTER TABLE `labour`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `labour_pay`
--
ALTER TABLE `labour_pay`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supervisor_id` (`supervisor_id`),
  ADD KEY `labour_id` (`labour_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `project_supervisor`
--
ALTER TABLE `project_supervisor`
  ADD UNIQUE KEY `project_id` (`project_id`,`supervisor_id`),
  ADD KEY `project_id_index` (`project_id`) USING BTREE,
  ADD KEY `supervisor_id_index` (`supervisor_id`);

--
-- Indexes for table `supervisor`
--
ALTER TABLE `supervisor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `budget`
--
ALTER TABLE `budget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `labour`
--
ALTER TABLE `labour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `labour_pay`
--
ALTER TABLE `labour_pay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `supervisor`
--
ALTER TABLE `supervisor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`labour_id`) REFERENCES `labour` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_3` FOREIGN KEY (`supervisor_id`) REFERENCES `supervisor` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `budget`
--
ALTER TABLE `budget`
  ADD CONSTRAINT `budget_ibfk_1` FOREIGN KEY (`supervisor_id`) REFERENCES `supervisor` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `budget_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `expense`
--
ALTER TABLE `expense`
  ADD CONSTRAINT `expense_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `expense_ibfk_2` FOREIGN KEY (`supervisor_id`) REFERENCES `supervisor` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `labour_pay`
--
ALTER TABLE `labour_pay`
  ADD CONSTRAINT `labour_pay_ibfk_1` FOREIGN KEY (`labour_id`) REFERENCES `labour` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `labour_pay_ibfk_2` FOREIGN KEY (`supervisor_id`) REFERENCES `supervisor` (`id`) ON DELETE NO ACTION;

--
-- Constraints for table `project_supervisor`
--
ALTER TABLE `project_supervisor`
  ADD CONSTRAINT `project_supervisor_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`),
  ADD CONSTRAINT `project_supervisor_ibfk_2` FOREIGN KEY (`supervisor_id`) REFERENCES `supervisor` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
