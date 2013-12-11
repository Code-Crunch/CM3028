-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 24, 2013 at 07:48 PM
-- Server version: 5.6.14
-- PHP Version: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `WebDev1`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `BID` char(4) NOT NULL,
  `title` varchar(30) NOT NULL,
  `author1` varchar(20) NOT NULL,
  `author2` varchar(20) NOT NULL,
  `publisher` varchar(20) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `keyword` varchar(100) NOT NULL,
  PRIMARY KEY (`BID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`BID`, `title`, `author1`, `author2`, `publisher`, `year`, `keyword`) VALUES
('B001', 'HTML Book', 'Sam Cusson', '', 'RGU', 2000, 'HTML,Web Apps,Starter'),
('B002', 'PHP Book', 'Florin Mazilu', 'Sam Cusson', 'RGU2', 2001, 'PHP,WebApps,Starter'),
('B005', 'Web Programming', 'Marina', 'Jonny', 'RGU1', 2001, 'Web, Dev, Interwebs'),
('B101', 'Sam Title', 'Sam Author1', 'Sam Author2', 'Sam Publisher', 1992, 'Test'),
('B999', 'To Orphan Module', 'To Orphan Module', 'To Orphan Module', 'To Orphan Module', 0, 'To Orphan Module');

-- --------------------------------------------------------

--
-- Table structure for table `courseModules`
--

CREATE TABLE IF NOT EXISTS `courseModules` (
  `CID` char(4) NOT NULL,
  `MID` char(6) NOT NULL,
  `year` int(11) DEFAULT NULL,
  PRIMARY KEY (`CID`,`MID`),
  KEY `MID` (`MID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courseModules`
--

INSERT INTO `courseModules` (`CID`, `MID`, `year`) VALUES
('C001', 'M00001', 1),
('C001', 'M00002', 2);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `CID` char(4) NOT NULL,
  `title` varchar(30) NOT NULL,
  `startYear` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  PRIMARY KEY (`CID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`CID`, `title`, `startYear`, `duration`) VALUES
('C001', 'Web Development', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `moduleBooks`
--

CREATE TABLE IF NOT EXISTS `moduleBooks` (
  `MID` char(6) NOT NULL,
  `BID` char(4) NOT NULL,
  PRIMARY KEY (`MID`,`BID`),
  KEY `BID` (`BID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `moduleBooks`
--

INSERT INTO `moduleBooks` (`MID`, `BID`) VALUES
('M00001', 'B001'),
('M00002', 'B002'),
('M00001', 'B005'),
('M00003', 'B999');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `MID` char(6) NOT NULL,
  `title` varchar(30) NOT NULL,
  `descr` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`MID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`MID`, `title`, `descr`) VALUES
('M00001', 'HTML Scripting', 'An introduction to HTML'),
('M00002', 'PHP Programming', 'An introduction to PHP'),
('M00003', 'Java Programming', 'An introduction to Java');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courseModules`
--
ALTER TABLE `courseModules`
  ADD CONSTRAINT `coursemodules_ibfk_1` FOREIGN KEY (`CID`) REFERENCES `courses` (`CID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `coursemodules_ibfk_2` FOREIGN KEY (`MID`) REFERENCES `modules` (`MID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `moduleBooks`
--
ALTER TABLE `moduleBooks`
  ADD CONSTRAINT `modulebooks_ibfk_1` FOREIGN KEY (`MID`) REFERENCES `modules` (`MID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `modulebooks_ibfk_2` FOREIGN KEY (`BID`) REFERENCES `books` (`BID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
