-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 26, 2012 at 10:24 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `internships`
--

-- --------------------------------------------------------

--
-- Table structure for table `assigned_opportunities`
--

CREATE TABLE IF NOT EXISTS `assigned_opportunities` (
  `opportunityID` smallint(6) NOT NULL,
  `internID` smallint(6) DEFAULT NULL,
  `date_selected` date DEFAULT NULL,
  `date_approved` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assigned_opportunities`
--

INSERT INTO `assigned_opportunities` (`opportunityID`, `internID`, `date_selected`, `date_approved`) VALUES
(2, 1, '2012-02-26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `interns`
--

CREATE TABLE IF NOT EXISTS `interns` (
  `internID` smallint(6) NOT NULL AUTO_INCREMENT,
  `email` varchar(40) NOT NULL,
  `password_md5` varchar(32) NOT NULL,
  `first` varchar(40) NOT NULL,
  `last` varchar(40) NOT NULL,
  PRIMARY KEY (`internID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `interns`
--

INSERT INTO `interns` (`internID`, `email`, `password_md5`, `first`, `last`) VALUES
(1, 'goodm@lanecc.edu', '7c486a10f0066edace732b8d4a27760e', 'Mari', 'Good'),
(2, 'mickey@disney.com', '802968bef15ac7a862ea63aac464b5c8', 'Mickey', 'Mouse');

-- --------------------------------------------------------

--
-- Table structure for table `opportunities`
--

CREATE TABLE IF NOT EXISTS `opportunities` (
  `opportunityID` smallint(6) NOT NULL AUTO_INCREMENT,
  `company` varchar(40) DEFAULT NULL,
  `city` varchar(25) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `position` varchar(30) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`opportunityID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `opportunities`
--

INSERT INTO `opportunities` (`opportunityID`, `company`, `city`, `start_date`, `end_date`, `position`, `description`) VALUES
(1, 'Ace Technologies', 'Boston', '2012-06-20', '2012-08-31', 'Programmer', 'Assist in a project to convert an online application from CGI to PHP.'),
(2, 'Hometown Bakery', 'Cambridge', '2012-09-15', '2012-12-01', 'Web Developer', 'Implement a Web site for purchasing pastries over the Internet.'),
(3, '123 Accountants, Inc.', 'Boston', '2012-07-01', '2012-09-01', 'Application Developer', 'Develop a Web-based In/Out board for our intranet.'),
(4, 'United Charities', 'Newton', '2012-06-25', '2012-09-02', 'Web Programmer', 'Assist in the development of a PHP sponsorship form for a 5K road race.'),
(5, 'Technology Manufacturing, Inc.', 'Avon', '2012-08-25', '2012-12-20', 'Web Developer', 'Assist in implementing an online documentation library for product manuals.');
