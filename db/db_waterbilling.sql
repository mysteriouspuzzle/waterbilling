-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2019 at 06:21 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_waterbilling`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `bill_id` int(10) NOT NULL,
  `consumer_id` int(10) NOT NULL,
  `previous_date` date NOT NULL,
  `present_date` date NOT NULL,
  `previous_meter` varchar(10) NOT NULL,
  `present_meter` varchar(10) NOT NULL,
  `consumption` int(5) NOT NULL,
  `bill` float(10,2) NOT NULL,
  `date` date NOT NULL,
  `due_date` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `payment_type` varchar(15) NOT NULL,
  `payment_date` date NOT NULL,
  `notification` varchar(15) NOT NULL,
  `due_notif` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`bill_id`, `consumer_id`, `previous_date`, `present_date`, `previous_meter`, `present_meter`, `consumption`, `bill`, `date`, `due_date`, `status`, `payment_type`, `payment_date`, `notification`, `due_notif`) VALUES
(1, 1, '2019-03-28', '2019-03-28', '0', '11', 11, 38.85, '0000-00-00', '0000-00-00', 'Paid', 'walk-in', '2019-05-01', 'Unsent', 'Unsent'),
(2, 1, '2019-03-28', '2019-03-28', '0000', '12', 12, 42.70, '0000-00-00', '0000-00-00', 'Paid', 'walk-in', '2019-05-01', 'Unsent', 'Unsent'),
(3, 1, '2019-03-28', '2019-03-28', '0000', '10', 10, 35.00, '0000-00-00', '0000-00-00', 'Paid', 'walk-in', '2019-05-01', 'Unsent', 'Unsent'),
(4, 1, '2019-03-28', '2019-03-28', '0000', '30', 30, 116.00, '0000-00-00', '0000-00-00', 'Paid', 'walk-in', '2019-05-01', 'Unsent', 'Unsent'),
(5, 3, '2019-03-30', '2019-03-30', '0000', '12', 12, 42.70, '0000-00-00', '0000-00-00', 'Paid', 'online', '0000-00-00', 'Unsent', 'Unsent'),
(6, 3, '2019-04-25', '2019-04-25', '0012', '35', 23, 86.25, '0000-00-00', '2019-05-09', 'Paid', 'walk-in', '0000-00-00', 'Unsent', 'Unsent'),
(7, 3, '2019-04-27', '2019-04-27', '0035', '45', 10, 35.00, '0000-00-00', '2019-05-11', 'Paid', 'walk-in', '0000-00-00', 'Unsent', 'Unsent'),
(8, 3, '2019-04-27', '2019-04-27', '0045', '50', 5, 35.00, '0000-00-00', '2019-05-11', 'Paid', 'walk-in', '0000-00-00', 'Unsent', 'Unsent'),
(9, 3, '2019-04-27', '2019-04-27', '0050', '64', 14, 50.40, '0000-00-00', '2019-05-11', 'Paid', 'walk-in', '0000-00-00', 'Unsent', 'Unsent'),
(10, 3, '2019-04-27', '2019-04-27', '0064', '70', 6, 35.00, '0000-00-00', '2019-05-11', 'Paid', 'walk-in', '0000-00-00', 'Unsent', 'Unsent'),
(11, 3, '2019-04-27', '2019-04-27', '0070', '71', 1, 35.00, '0000-00-00', '2019-05-11', 'Paid', 'walk-in', '0000-00-00', 'Unsent', 'Unsent'),
(12, 3, '2019-04-27', '2019-04-27', '0071', '72', 1, 35.00, '0000-00-00', '2019-05-11', 'Paid', 'online', '0000-00-00', 'Unsent', 'Unsent'),
(13, 3, '2019-04-27', '2019-04-27', '0072', '73', 1, 35.00, '2019-05-01', '2019-05-11', 'Paid', 'online', '2019-05-03', 'Unsent', 'Unsent'),
(15, 2, '2019-02-01', '2019-05-01', '0000', '25', 25, 94.75, '2019-05-01', '2019-05-15', 'Paid', 'walk-in', '2019-05-05', 'Unsent', 'Unsent'),
(16, 4, '2018-12-15', '2019-01-15', '0000', '23', 23, 86.25, '0000-00-00', '2019-02-01', 'Unpaid', '', '0000-00-00', 'Unsent', 'Sent'),
(17, 4, '2019-05-04', '2019-05-04', '0000', '23', 23, 86.25, '0000-00-00', '2019-05-18', 'Unpaid', '', '0000-00-00', 'Unsent', 'Sent'),
(18, 8, '2019-03-20', '2019-05-06', '0000', '44', 44, 182.90, '0000-00-00', '2019-04-15', 'Unpaid', '', '0000-00-00', 'Unsent', 'Sent'),
(19, 3, '2019-03-27', '2019-04-10', '0073', '80', 7, 35.00, '0000-00-00', '2019-04-24', 'Paid', '', '0000-00-00', 'Unsent', 'Sent');

-- --------------------------------------------------------

--
-- Table structure for table `codes`
--

CREATE TABLE `codes` (
  `id` int(255) NOT NULL,
  `pass_id` int(15) NOT NULL,
  `code` int(15) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `codes`
--

INSERT INTO `codes` (`id`, `pass_id`, `code`, `status`) VALUES
(1, 3, 827493, 'Expired'),
(2, 3, 809348, 'Expired'),
(3, 3, 388192, 'Expired'),
(4, 3, 695636, 'Expired'),
(5, 3, 301444, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `consumers`
--

CREATE TABLE `consumers` (
  `id` int(255) NOT NULL,
  `account_number` int(15) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `contactNumber` text NOT NULL,
  `email` varchar(30) NOT NULL,
  `classification` varchar(15) NOT NULL,
  `password` varchar(100) NOT NULL,
  `online` tinyint(1) NOT NULL,
  `date_added` date NOT NULL,
  `is_disconnected` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `consumers`
--

INSERT INTO `consumers` (`id`, `account_number`, `firstname`, `middlename`, `lastname`, `birthdate`, `address`, `contactNumber`, `email`, `classification`, `password`, `online`, `date_added`, `is_disconnected`) VALUES
(1, 190001, 'Makisig', '', 'Gerero', '2009-03-04', 'Coogn Cogon, Ormoc City', '09342324255', 'mysterious.puzzle15@gmail.com', 'Residential', '', 0, '2019-06-10', 0),
(2, 190002, 'Jake Joseph', 'Malinao', 'Lingatong', '2018-10-22', 'Bogo', '09328478343', 'mysterious.puzzle16@gmail.com', 'Residential', 'cc03e747a6afbbcbf8be7668acfebee5', 1, '2019-04-01', 0),
(3, 190003, 'Apple', 'Orange', 'Lala', '2019-03-18', 'Sitio Pikas', '09097895572', 'mysterious.puzzle15@gmail.com', 'Residential', 'cc03e747a6afbbcbf8be7668acfebee5', 1, '0000-00-00', 0),
(4, 190004, 'Mike', 'Excusemepo', 'Enriquez', '2017-08-15', 'San Vicente, Ormoc City', '0945521986', 'iamstevenjamesb@gmail.com', 'Residential', '', 0, '0000-00-00', 0),
(8, 190005, 'Marlou', '', 'Arizola', '1990-01-01', 'Mandaue, Cebu', '09123846723', 'mysterious.puzzle15@gmail.com', 'Residential', '', 0, '2019-05-01', 0),
(9, 190006, 'Katrina', '', 'Halili', '0000-00-00', '23, Basak Cogon, Ormoc City', '09234784638', 'asd@a.com', 'Residential', '', 0, '2019-06-11', 0),
(10, 190007, 'Xander', '', 'Ford', '0000-00-00', '55 Cogon, Ormoc City', '09091823636', 'x@f.com', 'Residential', '', 0, '2019-06-11', 0),
(11, 190008, 'Sando', '', 'Gaming', '0000-00-00', '48 Cogon, Ormoc City', '09234242344', 'ads@fadsf.com', 'Residential', '', 0, '2019-06-11', 0),
(12, 190009, 'Layla', '', 'De Lima', '0000-00-00', '49, San Diego Cogon, Ormoc City', '0948827384', 'fa@lsdf.com', 'Residential', '', 0, '2019-06-11', 0);

-- --------------------------------------------------------

--
-- Table structure for table `consumer_logs`
--

CREATE TABLE `consumer_logs` (
  `id` int(15) NOT NULL,
  `consumer_id` int(15) NOT NULL,
  `transaction` varchar(50) NOT NULL,
  `details` varchar(50) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

CREATE TABLE `credentials` (
  `id` int(15) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `userLevel` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`id`, `fullname`, `username`, `password`, `userLevel`, `email`) VALUES
(1, 'Administrator', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', 'admin@admin.com'),
(2, 'Mr. James Reid', 'reader', '1de9b0a30075ae8c303eb420c103c320', 'Reader', 'asd@afds.co'),
(3, 'Ms. Sarah Geronimo', 'teller', '8482dfb1bca15b503101eb438f52deed', 'Teller', 'mysterious.puzzle15@gmail.com'),
(4, 'Ms. Lovi Poe', 'accounting', 'd4c143f004d88b7286e6f999dea9d0d7', 'Accounting', 'accounting@gmail.com'),
(5, 'Richard Gomez', 'richard', '6ae199a93c381bf6d5de27491139d3f9', 'Reader', 'asdf@fadd.com');

-- --------------------------------------------------------

--
-- Table structure for table `online_verification`
--

CREATE TABLE `online_verification` (
  `id` int(15) NOT NULL,
  `consumer_id` int(15) NOT NULL,
  `code` varchar(15) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `online_verification`
--

INSERT INTO `online_verification` (`id`, `consumer_id`, `code`, `status`) VALUES
(11, 3, '345172', 'expired'),
(14, 3, '741738', 'expired'),
(15, 3, '397512', 'verified'),
(16, 2, '395146', 'expired'),
(17, 2, '066112', 'verified');

-- --------------------------------------------------------

--
-- Table structure for table `rates`
--

CREATE TABLE `rates` (
  `id` int(10) NOT NULL,
  `cubic_meter` varchar(30) NOT NULL,
  `minimum` int(5) NOT NULL,
  `maximum` int(5) NOT NULL,
  `rate` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rates`
--

INSERT INTO `rates` (`id`, `cubic_meter`, `minimum`, `maximum`, `rate`) VALUES
(1, 'Minimum-10 cu. m.', 0, 10, 35),
(2, '11-20 cu. m.', 11, 20, 3.85),
(3, '21-30 cu. m.', 21, 30, 4.25),
(4, '31-40 cu.m.', 31, 40, 4.65),
(5, '41-50 cu.m.', 41, 50, 5.1),
(6, 'Over 50 cu.m.', 50, 9999, 5.65);

-- --------------------------------------------------------

--
-- Table structure for table `reading`
--

CREATE TABLE `reading` (
  `id` int(11) NOT NULL,
  `consumer_id` int(11) NOT NULL,
  `previous_read` varchar(10) NOT NULL,
  `next_read` varchar(10) NOT NULL,
  `rate` int(10) NOT NULL,
  `date` date NOT NULL,
  `payment` float NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reading`
--

INSERT INTO `reading` (`id`, `consumer_id`, `previous_read`, `next_read`, `rate`, `date`, `payment`, `status`) VALUES
(1, 2, '', '0000', 0, '2019-03-01', 0, 0),
(2, 1, '', '0000', 0, '2019-03-01', 0, 0),
(3, 3, '', '0000', 0, '2019-03-30', 0, 0),
(4, 4, '', '0000', 0, '2019-03-30', 0, 0),
(5, 8, '', '0000', 0, '2019-05-01', 0, 0),
(6, 9, '', '0000', 0, '2019-06-11', 0, 0),
(7, 10, '', '0000', 0, '2019-06-11', 0, 0),
(8, 11, '', '0000', 0, '2019-06-11', 0, 0),
(9, 12, '', '0000', 0, '2019-06-11', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sms_api`
--

CREATE TABLE `sms_api` (
  `id` int(10) NOT NULL,
  `endpoint` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms_api`
--

INSERT INTO `sms_api` (`id`, `endpoint`) VALUES
(1, 'http://192.168.1.8:8080/');

-- --------------------------------------------------------

--
-- Table structure for table `user_levels`
--

CREATE TABLE `user_levels` (
  `id` int(255) NOT NULL,
  `user_level` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_levels`
--

INSERT INTO `user_levels` (`id`, `user_level`) VALUES
(1, 'Administrator'),
(2, 'Reader'),
(3, 'Teller'),
(4, 'Accounting'),
(5, 'Consumer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`bill_id`);

--
-- Indexes for table `codes`
--
ALTER TABLE `codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consumers`
--
ALTER TABLE `consumers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consumer_logs`
--
ALTER TABLE `consumer_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credentials`
--
ALTER TABLE `credentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_verification`
--
ALTER TABLE `online_verification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reading`
--
ALTER TABLE `reading`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_api`
--
ALTER TABLE `sms_api`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_levels`
--
ALTER TABLE `user_levels`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `bill_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `codes`
--
ALTER TABLE `codes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `consumers`
--
ALTER TABLE `consumers`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `consumer_logs`
--
ALTER TABLE `consumer_logs`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `credentials`
--
ALTER TABLE `credentials`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `online_verification`
--
ALTER TABLE `online_verification`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `rates`
--
ALTER TABLE `rates`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `reading`
--
ALTER TABLE `reading`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `sms_api`
--
ALTER TABLE `sms_api`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_levels`
--
ALTER TABLE `user_levels`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
