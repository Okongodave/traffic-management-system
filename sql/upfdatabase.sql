-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 16, 2014 at 03:03 PM
-- Server version: 5.5.34
-- PHP Version: 5.3.10-1ubuntu3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `upfdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `table_driver`
--

CREATE TABLE IF NOT EXISTS `table_driver` (
  `driver` int(11) NOT NULL,
  `operator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_driver`
--

INSERT INTO `table_driver` (`driver`, `operator`) VALUES
(6, 5),
(0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `table_driverid`
--

CREATE TABLE IF NOT EXISTS `table_driverid` (
  `driverID` int(4) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `profileID` int(100) NOT NULL,
  PRIMARY KEY (`driverID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `table_driverid`
--

INSERT INTO `table_driverid` (`driverID`, `profileID`) VALUES
(0001, 5),
(0002, 6);

-- --------------------------------------------------------

--
-- Table structure for table `table_log`
--

CREATE TABLE IF NOT EXISTS `table_log` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `user` varchar(50) NOT NULL,
  `notes` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `table_log`
--

INSERT INTO `table_log` (`id`, `user`, `notes`, `datetime`) VALUES
(1, 'applicant', 'Added Driver: D D D', '2013-02-07 17:15:26'),
(2, 'ovcca', 'Added Vehicle: ZZZ-000', '2013-02-07 17:19:27'),
(3, 'admin', 'Added Inspection: pass ZZZ-000', '2013-02-07 17:19:52'),
(4, 'admin', 'Approved Vehicle: ZZZ-000', '2013-02-07 17:20:16'),
(5, 'cashier', 'Sticker Payment: ZZZ-000', '2013-02-07 17:22:18'),
(6, 'admin', 'Vehicle Sticker Release: ZZZ-000', '2013-02-07 17:23:01'),
(7, 'ovcca', 'Added Violation: (driver id)0001 (2012-01-01 10:00:00)', '2013-02-07 17:27:00'),
(8, 'admin', 'Added Violation: (driver id)0002 / (plate number)ZZZ-000 (2012-01-01 12:01:31)', '2013-02-07 17:47:29'),
(9, 'admin', 'Added Violation: (driver id)0002 / (plate number)ZZZ-000 (2012-12-15 12:01:31)', '2013-02-07 22:39:20'),
(10, 'admin', 'Updated Applicant: applicant', '2013-02-07 22:40:15'),
(11, 'admin', 'Added Vehicle: QQQ-111', '2013-02-07 22:50:51'),
(12, 'admin', 'Added Inspection: pass QQQ-111', '2013-02-07 22:51:07'),
(13, 'admin', 'Added Inspection: pass ZZZ-000', '2013-02-07 22:51:18'),
(14, 'admin', 'Added Violation: (plate number) (2012-12-15 10:00:00)', '2013-02-07 22:52:27'),
(15, 'admin', 'Updated Driver: D D D', '2013-02-07 22:53:18'),
(16, 'admin', 'Update Violation: (driver id)0002 (2012-12-15 10:00:00)', '2013-02-08 06:14:25'),
(17, 'admin', 'Removed Vehicle: QQQ-111', '2013-02-08 06:15:03'),
(18, 'admin', 'Added Vehicle: QQQ-111', '2013-02-08 06:15:46'),
(19, 'admin', 'Added Vehicle: SS-1234', '2013-02-08 06:17:01'),
(20, 'admin', 'Updated Driver: D D D', '2013-02-08 06:18:03'),
(21, 'admin', 'Update Violation: (driver id)0001 (2012-01-01 10:00:00)', '2013-02-08 06:18:50'),
(22, 'admin', 'Added Violation: (driver id)0002 (2012-12-15 12:01:31)', '2013-02-09 15:48:56'),
(23, 'admin', 'Update Violation: (driver id)0002 (2012-01-01 10:00:00)', '2013-02-09 15:49:58'),
(24, 'admin', 'Update Violation: (driver id)0001 (2012-01-01 10:00:00)', '2013-02-09 15:50:17'),
(25, 'admin', 'Update Violation: (driver id)0001 (2012-12-15 10:00:00)', '2013-02-09 15:50:31'),
(26, 'admin', 'Updated Driver: D D D', '2013-02-09 15:52:30'),
(27, 'admin', 'Update Violation: (driver id)0002 (2012-12-15 10:00:00)', '2013-02-11 17:09:12'),
(28, 'admin', 'Update Violation: (driver id)0002 (2012-01-01 10:00:00)', '2013-02-11 17:09:31'),
(29, 'admin', 'Update Violation: (driver id)0001 (2012-01-01 10:00:00)', '2013-02-12 02:47:03'),
(30, '', 'Add Applicant: rpaycojr', '2013-03-25 03:17:33'),
(31, 'admin', 'Block Vehicle: QQQ-111', '2013-03-25 05:39:47'),
(32, 'admin', 'Unblock Vehicle: QQQ-111', '2013-03-25 05:39:51');

-- --------------------------------------------------------

--
-- Table structure for table `table_option`
--

CREATE TABLE IF NOT EXISTS `table_option` (
  `option` varchar(30) NOT NULL,
  `value` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_option`
--

INSERT INTO `table_option` (`option`, `value`) VALUES
('maxViolation', '10'),
('maxInspection', '50');

-- --------------------------------------------------------

--
-- Table structure for table `table_profile`
--

CREATE TABLE IF NOT EXISTS `table_profile` (
  `profileID` int(100) NOT NULL AUTO_INCREMENT,
  `licenseNumber` varchar(20) NOT NULL,
  `profileType` text NOT NULL,
  `licenseIssuedLTOBranch` text NOT NULL,
  `licenseIssuedDate` date NOT NULL,
  `licenseExpiryDate` date NOT NULL,
  `userName` varchar(20) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `emailAddress` varchar(30) DEFAULT NULL,
  `contactNumber` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `givenName` varchar(30) NOT NULL,
  `middleName` varchar(30) DEFAULT NULL,
  `age` int(2) DEFAULT NULL,
  `birthDate` date NOT NULL,
  `birthPlace` varchar(50) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `civilStatus` text NOT NULL,
  `citizenship` text NOT NULL,
  `occupation` varchar(30) DEFAULT NULL,
  `homeAddress` varchar(100) NOT NULL,
  `homeBrgy` varchar(30) NOT NULL,
  `homeTown` varchar(30) NOT NULL,
  `homeProvince` varchar(30) NOT NULL,
  `officeAddress` varchar(100) DEFAULT NULL,
  `officeBrgy` varchar(30) DEFAULT NULL,
  `officeTown` varchar(30) DEFAULT NULL,
  `officeProvince` varchar(30) DEFAULT NULL,
  `spouseName` varchar(30) DEFAULT NULL,
  `spouseOccupation` varchar(30) DEFAULT NULL,
  `violation` int(25) NOT NULL,
  `block` int(1) NOT NULL DEFAULT '0',
  `status` varchar(50) NOT NULL DEFAULT 'confirmation',
  `notes` text,
  `picture` varchar(100) NOT NULL DEFAULT 'default.gif',
  PRIMARY KEY (`profileID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `table_profile`
--

INSERT INTO `table_profile` (`profileID`, `licenseNumber`, `profileType`, `licenseIssuedLTOBranch`, `licenseIssuedDate`, `licenseExpiryDate`, `userName`, `password`, `emailAddress`, `contactNumber`, `lastName`, `givenName`, `middleName`, `age`, `birthDate`, `birthPlace`, `gender`, `civilStatus`, `citizenship`, `occupation`, `homeAddress`, `homeBrgy`, `homeTown`, `homeProvince`, `officeAddress`, `officeBrgy`, `officeTown`, `officeProvince`, `spouseName`, `spouseOccupation`, `violation`, `block`, `status`, `notes`, `picture`) VALUES
(1, 'ADMIN', 'ADMIN', 'CALAMBA', '2012-01-01', '2013-01-01', 'admin', 'admin', 'admin@admin.com', '', 'ADMIN', 'ADMIN', 'ADMIN', NULL, '1990-01-01', 'ADMIN', 'F', 'SINGLE', 'ADMIN', 'ADMIN', 'ADMIN', 'ADMIN', 'ADMIN', 'ADMIN', 'ADMIN', 'ADMIN', 'ADMIN', 'ADMIN', 'ADMIN', 'ADMIN', 0, 0, '', NULL, 'default.gif'),
(2, 'CASHIER', 'CASHIER', '', '0000-00-00', '0000-00-00', 'cashier', 'cashier', 'cashier@cashier.com', '', 'CASHIER', 'CASHIER', 'CASHIER', NULL, '0000-00-00', 'CASHIER', 'F', 'CASHIER', 'CASHIER', 'CASHIER', 'CASHIER', 'CASHIER', 'CASHIER', 'CASHIER', 'CASHIER', 'CASHIER', 'CASHIER', 'CASHIER', 'CASHIER', 'CASHIER', 0, 0, '', NULL, 'default.gif'),
(3, 'OVCCA', 'OVCCA', 'CALAMBA', '1990-01-01', '1990-01-01', 'ovcca', 'ovcca', 'ovcca@ovcca.com', '', 'OVCCA', 'OVCCA', 'OVCCA', NULL, '1990-01-01', 'OVCCA', 'F', 'SINGLE', 'OVCCA', 'OVCCA', 'OVCCA', 'OVCCA', 'OVCCA', 'OVCCA', 'OVCCA', 'OVCCA', 'OVCCA', 'OVCCA', NULL, NULL, 0, 0, '', NULL, 'default.gif'),
(4, 'OPERATIONS', 'OPERATIONS', 'OPERATIONS', '1990-01-01', '1990-01-01', 'operations', 'operations', 'operations@operations.com', '', 'operations', 'operations', 'operations', 21, '1990-01-01', 'OPERATIONS', 'F', 'OPERATIONS', 'OPERATIONS', 'OPERATIONS', 'OPERATIONS', 'OPERATIONS', 'OPERATIONS', 'OPERATIONS', 'OPERATIONS', 'OPERATIONS', 'OPERATIONS', 'OPERATIONS', 'OPERATIONS', 'OPERATIONS', 0, 0, '', NULL, 'default.gif'),
(5, 'A11-11-123456', 'APPLICANT', 'Calamba', '1990-01-01', '2016-07-31', 'applicant', 'applicant', 'applicant@applicant.com', '123-45671', 'Applicant', 'Applicant', 'Applicant', NULL, '1990-01-01', 'applicant', 'F', 'SINGLE', 'APPLICANT', 'applicant', 'Applicant', 'Applicant', 'Applicant', 'Applicant', 'Applicant', 'Applicant', 'Applicant', 'Applicant', NULL, NULL, 1, 0, 'active', NULL, 'applicant.png'),
(6, 'A11-11-123456', 'DRIVER', '', '0000-00-00', '2012-12-30', NULL, NULL, NULL, '', 'D', 'D', 'D', 0, '0000-00-00', '', '', 'SINGLE', '', NULL, 'D', 'd', 'D', 'D', NULL, NULL, NULL, NULL, '', '', 0, 0, 'confirmation', NULL, 'ddd.png'),
(7, 'A45-45-456456', 'APPLICANT', 'Calamba', '2012-09-24', '2015-09-24', 'rpaycojr', 'Ayoforfre3', 'yo_ayco@yahoo.com', '09052148420', 'Ayco', 'Ramon, Jr.', 'Palino', NULL, '1988-09-24', 'Fsdfas', 'M', 'Single', 'Filipino', 'Sys Analyst', 'Fsdf', 'Fasdf', 'Fsdfa', 'Fsdfsd', 'Fsadfsda', 'Fsdfas', 'Fsdfa', 'Fdsafs', NULL, NULL, 0, 0, 'confirmation', NULL, 'default.gif');

-- --------------------------------------------------------

--
-- Table structure for table `table_reference`
--

CREATE TABLE IF NOT EXISTS `table_reference` (
  `result` varchar(4) NOT NULL,
  `plateNumber` varchar(30) NOT NULL,
  `referenceNumber` varchar(30) DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_reference`
--

INSERT INTO `table_reference` (`result`, `plateNumber`, `referenceNumber`, `notes`) VALUES
('pass', 'QQQ-111', '0', ''),
('pass', 'ZZZ-000', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `table_request`
--

CREATE TABLE IF NOT EXISTS `table_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request` varchar(25) NOT NULL,
  `profile` int(11) NOT NULL,
  `requestor` int(11) NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `table_vehicle`
--

CREATE TABLE IF NOT EXISTS `table_vehicle` (
  `plateNumber` varchar(7) NOT NULL,
  `vehicleType` text NOT NULL COMMENT 'PRIVATE OR PUBLIC',
  `owner` int(100) NOT NULL,
  `model` varchar(30) NOT NULL,
  `year` year(4) NOT NULL,
  `motor` varchar(30) NOT NULL,
  `chassis` varchar(20) NOT NULL,
  `color` text NOT NULL,
  `stickerNumber` int(5) unsigned zerofill DEFAULT NULL,
  `stickerIssuedDate` date DEFAULT NULL,
  `lastStickerNumber` int(5) DEFAULT NULL,
  `lastStickerIssuedDate` date DEFAULT NULL,
  `reference` int(5) DEFAULT NULL,
  `inspection` date NOT NULL,
  `block` int(1) DEFAULT '0',
  `paid` date DEFAULT '0000-00-00',
  `status` varchar(30) NOT NULL DEFAULT 'pending',
  `condition` text,
  `violation` int(25) NOT NULL,
  `certificationRegistration` text NOT NULL,
  `receiptRegistration` text NOT NULL,
  `LTFRBFranchise` text,
  `insurance` text,
  `driverID` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_vehicle`
--

INSERT INTO `table_vehicle` (`plateNumber`, `vehicleType`, `owner`, `model`, `year`, `motor`, `chassis`, `color`, `stickerNumber`, `stickerIssuedDate`, `lastStickerNumber`, `lastStickerIssuedDate`, `reference`, `inspection`, `block`, `paid`, `status`, `condition`, `violation`, `certificationRegistration`, `receiptRegistration`, `LTFRBFranchise`, `insurance`, `driverID`) VALUES
('ZZZ-000', 'PRIVATE', 5, 'CHANA', 2012, '12', '12', 'RED', 00001, '2012-02-08', NULL, NULL, 0, '0000-00-00', 0, '2013-02-07', 'released', '', 0, 'ZZZ-000_certificationRegistration.png', 'ZZZ-000_receiptRegistration.png', '', '', ''),
('QQQ-111', 'PUBLIC', 5, 'JEEP', 2012, 'MOTOR NUM', 'CHASSIS NUM', 'BLUE', NULL, NULL, NULL, NULL, 0, '0000-00-00', 0, '0000-00-00', 'pending', NULL, 0, 'QQQ-111_certificationRegistration.png', 'QQQ-111_receiptRegistration.png', 'QQQ-111_ltfrbFranchise.png', 'QQQ-111_insurance.png', 'QQQ-111_driverID.png'),
('SS-1234', 'MOTORCYCLE', 5, 'MOTORCYCLE', 2012, 'MOTOR NUM', 'CHASSIS NUM', 'BLACK', NULL, NULL, NULL, NULL, 0, '0000-00-00', 0, '0000-00-00', 'pending', NULL, 0, 'SS-1234_certificationRegistration.png', 'SS-1234_receiptRegistration.png', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `table_violation`
--

CREATE TABLE IF NOT EXISTS `table_violation` (
  `violationNumber` int(50) NOT NULL AUTO_INCREMENT,
  `licenseNumber` varchar(50) NOT NULL,
  `driverID` int(4) unsigned zerofill NOT NULL,
  `plateNumber` varchar(7) NOT NULL,
  `violation` text NOT NULL,
  `violationDate` date NOT NULL,
  `violationTime` time NOT NULL,
  `violationLocation` text NOT NULL,
  `penalty` varchar(50) NOT NULL,
  `reporter` varchar(50) NOT NULL,
  `reporterContact` varchar(20) NOT NULL,
  `approve` int(1) NOT NULL DEFAULT '1',
  `evidence` text,
  PRIMARY KEY (`violationNumber`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `table_violation`
--

INSERT INTO `table_violation` (`violationNumber`, `licenseNumber`, `driverID`, `plateNumber`, `violation`, `violationDate`, `violationTime`, `violationLocation`, `penalty`, `reporter`, `reporterContact`, `approve`, `evidence`) VALUES
(1, '', 0001, '', 'wrong parking', '2012-01-01', '10:00:00', 'uplb', 'to be added', 'Sayao', '', 1, '1.png'),
(5, '', 0002, '', 'overspeeding', '2012-12-15', '10:00:00', 'CEAT', 'to be added', 'Enay', '', 1, ''),
(6, '', 0001, '', 'did not stop on stop sign', '2012-12-15', '12:01:31', 'never ending bridge', '', '', '', 0, NULL),
(7, '', 0002, '', 'no plate number', '2012-12-15', '12:01:31', 'CEAT', 'to be added', 'Enay', '', 1, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
