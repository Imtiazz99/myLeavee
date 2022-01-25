-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2019 at 02:57 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myleavedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ADMIN_ID` varchar(10) NOT NULL,
  `FIRST_NAME` varchar(50) NOT NULL,
  `LAST_NAME` varchar(50) NOT NULL,
  `ADMIN_TYPE` varchar(10) NOT NULL,
  `ADMIN_DEPT` varchar(50) NOT NULL,
  `ADMIN_PASS` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ADMIN_ID`, `FIRST_NAME`, `LAST_NAME`, `ADMIN_TYPE`, `ADMIN_DEPT`, `ADMIN_PASS`) VALUES
('2017123456', 'Abu', 'Ali', 'Admin', 'Human Resource', 'Admin@123');

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `STAFF_ID` varchar(10) NOT NULL,
  `LEAVE_TYPE` varchar(50) NOT NULL,
  `START_DATE` date NOT NULL,
  `END_DATE` date NOT NULL,
  `DAYS_REQUESTED` int(2) NOT NULL,
  `DATE_APPLIED` date NOT NULL,
  `LEAVE_STATUS` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`STAFF_ID`, `LEAVE_TYPE`, `START_DATE`, `END_DATE`, `DAYS_REQUESTED`, `DATE_APPLIED`, `LEAVE_STATUS`) VALUES
('2017231894', 'Annual Leave', '2019-12-09', '2019-12-11', 3, '2019-12-09', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `leave_statistics`
--

CREATE TABLE `leave_statistics` (
  `STAFF_ID` varchar(10) NOT NULL,
  `LEAVE_TYPE` varchar(50) NOT NULL,
  `MAX_LEAVE` int(2) NOT NULL,
  `LEAVE_TAKEN` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_statistics`
--

INSERT INTO `leave_statistics` (`STAFF_ID`, `LEAVE_TYPE`, `MAX_LEAVE`, `LEAVE_TAKEN`) VALUES
('2017216584', 'Annual Leave', 12, 0),
('2017216584', 'Leave-Without Pay', 10, 0),
('2017224908', 'Annual Leave', 12, 0),
('2017224908', 'Leave-Without Pay', 10, 0),
('2017224909', 'Annual Leave', 12, 0),
('2017224909', 'Leave-Without Pay', 10, 0),
('2017231894', 'Annual Leave', 12, 3),
('2017231894', 'Leave-Without Pay', 10, 0);

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `LEAVE_TYPE` varchar(50) NOT NULL,
  `NO_OF_DAYS` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`LEAVE_TYPE`, `NO_OF_DAYS`) VALUES
('Annual Leave', 12),
('Leave-Without Pay', 10);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `STAFF_ID` varchar(10) NOT NULL,
  `FIRST_NAME` varchar(50) NOT NULL,
  `LAST_NAME` varchar(50) NOT NULL,
  `STAFF_TYPE` varchar(10) NOT NULL,
  `STAFF_DEPT` varchar(50) NOT NULL,
  `STAFF_PASS` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`STAFF_ID`, `FIRST_NAME`, `LAST_NAME`, `STAFF_TYPE`, `STAFF_DEPT`, `STAFF_PASS`) VALUES
('2017216584', 'Faiz', 'Azhar', 'Staff', 'Information Technology', 'Faiz@123'),
('2017224908', 'baqir', 'akif', 'Staff', 'Accounting', 'B@qir123'),
('2017224909', 'baqir', 'akif', 'Staff', 'Information Technology', 'B@qir123'),
('2017231894', 'Afiq', 'Afwan Bin Mohd Zuki', 'Staff', 'Information Technology', 'Test@123456');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ADMIN_ID`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`STAFF_ID`,`START_DATE`,`END_DATE`);

--
-- Indexes for table `leave_statistics`
--
ALTER TABLE `leave_statistics`
  ADD PRIMARY KEY (`STAFF_ID`,`LEAVE_TYPE`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`LEAVE_TYPE`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`STAFF_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
