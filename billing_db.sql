-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2024 at 08:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `billing_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `department_tbl`
--

CREATE TABLE `department_tbl` (
  `deptID` int(11) NOT NULL,
  `Department` varchar(50) NOT NULL,
  `Status` varchar(50) NOT NULL DEFAULT 'Active',
  `registerby` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_tbl`
--

INSERT INTO `department_tbl` (`deptID`, `Department`, `Status`, `registerby`) VALUES
(7, 'Store', 'Active', 'hamxah4u@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `product_tbl`
--

CREATE TABLE `product_tbl` (
  `proID` int(11) NOT NULL,
  `Department` int(11) NOT NULL,
  `Productname` varchar(50) NOT NULL,
  `Price` varchar(200) NOT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'Active',
  `DateRegister` date NOT NULL,
  `TimeRegister` time NOT NULL,
  `RegisterBy` varchar(50) NOT NULL,
  `UpdateBy` varchar(100) DEFAULT NULL,
  `DateUpdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_tbl`
--

INSERT INTO `product_tbl` (`proID`, `Department`, `Productname`, `Price`, `Status`, `DateRegister`, `TimeRegister`, `RegisterBy`, `UpdateBy`, `DateUpdate`) VALUES
(28, 7, 'Beans', '200', 'Active', '0000-00-00', '00:00:00', 'hamxah4u@gmail.com', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supply_tbl`
--

CREATE TABLE `supply_tbl` (
  `SupplyID` int(11) NOT NULL,
  `Department` int(11) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Pprice` decimal(10,2) NOT NULL,
  `ExpiryDate` date NOT NULL,
  `SupplyDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `RecordedBy` varchar(255) DEFAULT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_tbl`
--

CREATE TABLE `transaction_tbl` (
  `TID` int(11) NOT NULL,
  `tCode` varchar(50) NOT NULL,
  `tDepartment` int(50) NOT NULL,
  `Product` int(11) DEFAULT NULL,
  `Price` float DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `Amount` float NOT NULL,
  `Customer` varchar(100) NOT NULL,
  `TransacDate` date NOT NULL DEFAULT current_timestamp(),
  `TransacTime` time NOT NULL DEFAULT current_timestamp(),
  `TrasacBy` varchar(100) NOT NULL,
  `Status` varchar(20) DEFAULT 'Not-Paid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_tbl`
--

CREATE TABLE `users_tbl` (
  `userID` int(11) NOT NULL,
  `Fullname` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `UserPassword` varchar(255) NOT NULL,
  `Department` int(11) NOT NULL,
  `DateRegister` date NOT NULL,
  `TimeRegister` time NOT NULL,
  `Role` varchar(10) NOT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'Active',
  `Phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_tbl`
--

INSERT INTO `users_tbl` (`userID`, `Fullname`, `Email`, `UserPassword`, `Department`, `DateRegister`, `TimeRegister`, `Role`, `Status`, `Phone`) VALUES
(11, 'Hamza Ibrahim Danasabe', 'hamxah4u@gmail.com', '$2y$10$VMpuqM04AMeN4BmfmloT0eyR.RJFdedI2BpCJ0v0429h2veXkA98C', 7, '0000-00-00', '00:00:00', 'Admin', 'Active', '08037856962');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department_tbl`
--
ALTER TABLE `department_tbl`
  ADD PRIMARY KEY (`deptID`);

--
-- Indexes for table `product_tbl`
--
ALTER TABLE `product_tbl`
  ADD PRIMARY KEY (`proID`),
  ADD KEY `Department` (`Department`);

--
-- Indexes for table `supply_tbl`
--
ALTER TABLE `supply_tbl`
  ADD PRIMARY KEY (`SupplyID`),
  ADD UNIQUE KEY `ProductName` (`ProductName`,`ExpiryDate`),
  ADD KEY `Department` (`Department`);

--
-- Indexes for table `transaction_tbl`
--
ALTER TABLE `transaction_tbl`
  ADD PRIMARY KEY (`TID`),
  ADD KEY `Product` (`Product`),
  ADD KEY `transaction_tbl_ibfk_1` (`tDepartment`);

--
-- Indexes for table `users_tbl`
--
ALTER TABLE `users_tbl`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `Department` (`Department`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department_tbl`
--
ALTER TABLE `department_tbl`
  MODIFY `deptID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product_tbl`
--
ALTER TABLE `product_tbl`
  MODIFY `proID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `supply_tbl`
--
ALTER TABLE `supply_tbl`
  MODIFY `SupplyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaction_tbl`
--
ALTER TABLE `transaction_tbl`
  MODIFY `TID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=639;

--
-- AUTO_INCREMENT for table `users_tbl`
--
ALTER TABLE `users_tbl`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_tbl`
--
ALTER TABLE `product_tbl`
  ADD CONSTRAINT `product_tbl_ibfk_1` FOREIGN KEY (`Department`) REFERENCES `department_tbl` (`deptID`);

--
-- Constraints for table `supply_tbl`
--
ALTER TABLE `supply_tbl`
  ADD CONSTRAINT `supply_tbl_ibfk_1` FOREIGN KEY (`Department`) REFERENCES `department_tbl` (`deptID`);

--
-- Constraints for table `transaction_tbl`
--
ALTER TABLE `transaction_tbl`
  ADD CONSTRAINT `transaction_tbl_ibfk_1` FOREIGN KEY (`tDepartment`) REFERENCES `department_tbl` (`deptID`),
  ADD CONSTRAINT `transaction_tbl_ibfk_2` FOREIGN KEY (`Product`) REFERENCES `supply_tbl` (`SupplyID`);

--
-- Constraints for table `users_tbl`
--
ALTER TABLE `users_tbl`
  ADD CONSTRAINT `users_tbl_ibfk_1` FOREIGN KEY (`Department`) REFERENCES `department_tbl` (`deptID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
