-- phpMyAdmin SQL Dump
-- version 3.5.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 03, 2013 at 05:52 PM
-- Server version: 5.0.95
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `event_calendar`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `event_id` int(11) NOT NULL auto_increment,
  `event_user_id` int(11) default NULL,
  `event_title` varchar(20) NOT NULL,
  `event_description` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  PRIMARY KEY  (`event_id`),
  KEY `event_date` (`event_date`),
  KEY `event_user_id` (`event_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_user`
--

DROP TABLE IF EXISTS `event_user`;
CREATE TABLE IF NOT EXISTS `event_user` (
  `user_id` int(11) NOT NULL auto_increment,
  `user_name` varchar(20) NOT NULL,
  `user_fname` varchar(30) default NULL,
  `user_lname` varchar(30) default NULL,
  `user_email` varchar(30) default NULL,
  `user_password` varchar(32) NOT NULL,
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`event_user_id`) REFERENCES `event_user` (`user_id`);
  
INSERT INTO `event_user` (`user_id`, `user_name`, `user_fname`, `user_lname`, `user_email`, `user_password`) VALUES
(1, 'goodm', 'Mari', 'Good', 'goodm@lanecc.edu', '371d1bf34efb640edacbabad9c8b17c2'),
(2, 'mickeyMouse', 'Mickey', 'Mouse', 'mickey@disney.com', '371d1bf34efb640edacbabad9c8b17c2');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
