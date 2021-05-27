-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2021 at 12:55 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ebanking`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `acctNo` varchar(200) NOT NULL,
  `balance` bigint(90) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`acctNo`, `balance`) VALUES
('0011574085', 0),
('0011588910', 0);

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

CREATE TABLE `balances` (
  `acctNo` varchar(200) NOT NULL,
  `acctBalance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `balances`
--

INSERT INTO `balances` (`acctNo`, `acctBalance`) VALUES
('0011546909', 90000),
('0011574085', 160000),
('0011588910', 433900);

-- --------------------------------------------------------

--
-- Table structure for table `beneficiaries`
--

CREATE TABLE `beneficiaries` (
  `benID` int(11) NOT NULL,
  `acctNo` varchar(200) NOT NULL,
  `benAcctName` varchar(200) NOT NULL,
  `benAcctNo` varchar(200) NOT NULL,
  `benBank` varchar(200) NOT NULL,
  `benDate` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beneficiaries`
--

INSERT INTO `beneficiaries` (`benID`, `acctNo`, `benAcctName`, `benAcctNo`, `benBank`, `benDate`) VALUES
(1, '0011588910', 'Imo Douglas Etofia', '3065612595', 'First Bank of Nigeria', '1545938711'),
(2, '0011588910', 'Dobem Associates', '0065792619', 'Diamond Bank', '1546167070'),
(3, '0011588910', 'Imo Douglas Etofia', '3065612111', 'Ecobank Nigeria', '1546614091'),
(4, '0011574085', 'Imo Douglas', '3065612595', 'First Bank of Nigeria', '1612869676'),
(5, '0011546909', 'Imo Douglas', '3065612595', 'First Bank of Nigeria', '1612886970');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(200) NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `time_stamp` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `loanID` int(11) NOT NULL,
  `acctNo` varchar(200) NOT NULL,
  `loanAmount` varchar(200) NOT NULL,
  `loanPurpose` varchar(200) NOT NULL,
  `repayRate` varchar(200) NOT NULL,
  `loanDuration` varchar(200) NOT NULL,
  `interestRate` varchar(200) NOT NULL,
  `loanDate` varchar(200) NOT NULL,
  `approvalDate` varchar(200) NOT NULL,
  `loanStatus` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`loanID`, `acctNo`, `loanAmount`, `loanPurpose`, `repayRate`, `loanDuration`, `interestRate`, `loanDate`, `approvalDate`, `loanStatus`) VALUES
(1, '0011588910', '1000000', 'Business startup capital', 'monthly', '12', '6', '1546566196', '', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `repayments`
--

CREATE TABLE `repayments` (
  `repayID` int(11) NOT NULL,
  `acctNo` varchar(200) NOT NULL,
  `loanID` varchar(200) NOT NULL,
  `repayAmount` varchar(200) NOT NULL,
  `repayDate` varchar(200) NOT NULL,
  `repayStatus` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `repayments`
--

INSERT INTO `repayments` (`repayID`, `acctNo`, `loanID`, `repayAmount`, `repayDate`, `repayStatus`) VALUES
(1, '0011588910', '1', '58800', '1546602442', 'complete'),
(2, '0011588910', '1', '100000', '1546602501', 'complete');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transID` int(11) NOT NULL,
  `acctNo` varchar(200) NOT NULL,
  `transMedium` varchar(200) NOT NULL DEFAULT 'admin',
  `transType` varchar(200) NOT NULL,
  `transAmount` varchar(200) NOT NULL,
  `transDate` varchar(200) NOT NULL,
  `transDesc` varchar(200) NOT NULL,
  `acctBalance` varchar(200) NOT NULL,
  `transStatus` varchar(200) NOT NULL DEFAULT 'complete'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(91) NOT NULL,
  `acctNo` varchar(200) DEFAULT NULL,
  `password` varchar(200) NOT NULL,
  `fname` varchar(200) NOT NULL,
  `mname` varchar(200) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `cdate` varchar(200) NOT NULL,
  `privilege` varchar(200) NOT NULL DEFAULT 'user',
  `acctStatus` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `acctNo`, `password`, `fname`, `mname`, `lname`, `address`, `phone`, `email`, `cdate`, `privilege`, `acctStatus`) VALUES
(2, '0011588910', '5b8e1cb41a50d461b8e817d96eefd46a', 'Bank', 'Office', 'Admin', '5 Magnus Oyewale Close, Ajiwe', '08133426889', 'imodouglas@gmail.com', '1545903816', 'admin', 'active'),
(3, '0011574085', '1f8441da63dad3044273d8fd5bde678c', 'John', 'Patrick', 'Doe', '15 Some Street, Somewhere, Nigeria', '08012345678', 'johndoe@email.com', '1549138859', 'user', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`acctNo`);

--
-- Indexes for table `balances`
--
ALTER TABLE `balances`
  ADD PRIMARY KEY (`acctNo`);

--
-- Indexes for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  ADD PRIMARY KEY (`benID`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`loanID`);

--
-- Indexes for table `repayments`
--
ALTER TABLE `repayments`
  ADD PRIMARY KEY (`repayID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `acctNo` (`acctNo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  MODIFY `benID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `loanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `repayments`
--
ALTER TABLE `repayments`
  MODIFY `repayID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(91) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
