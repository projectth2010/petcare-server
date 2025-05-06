-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 06, 2025 at 12:45 PM
-- Server version: 10.6.17-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yasupada_petcare`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
  `AdminID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `CreateAt` datetime DEFAULT current_timestamp(),
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`AdminID`, `Username`, `Password`, `Name`, `Email`, `Phone`, `CreateAt`, `CreateBy`, `UpdateAt`, `UpdateBy`) VALUES
(1, 'admin', '123456!', 'Admin 1', 'admin1@example.com', '1234567890', '2024-09-01 19:09:54', 0, '2024-09-01 19:09:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Booking`
--

CREATE TABLE `Booking` (
  `BookingID` int(11) NOT NULL,
  `HouseID` int(11) DEFAULT NULL,
  `RoomID` int(11) DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `NetTotal` decimal(10,2) DEFAULT NULL,
  `PetID` int(11) DEFAULT NULL,
  `ApproveStatus` varchar(10) NOT NULL,
  `PaymentStatus` varchar(10) NOT NULL,
  `CreateAt` datetime DEFAULT current_timestamp(),
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `BookingCheckIn`
--

CREATE TABLE `BookingCheckIn` (
  `BookingCheckInID` int(11) NOT NULL,
  `BookingID` int(11) DEFAULT NULL,
  `HouseID` int(11) DEFAULT NULL,
  `RoomID` int(11) DEFAULT NULL,
  `CheckInDate` date DEFAULT NULL,
  `CheckOutDate` date DEFAULT NULL,
  `CreateAt` datetime DEFAULT current_timestamp(),
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE `Customer` (
  `CustomerID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `ApproveStatus` varchar(10) NOT NULL,
  `CreateAt` datetime DEFAULT current_timestamp(),
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `Customer`
--

INSERT INTO `Customer` (`CustomerID`, `Username`, `Password`, `Name`, `Email`, `Phone`, `ApproveStatus`, `CreateAt`, `CreateBy`, `UpdateAt`, `UpdateBy`) VALUES
(1, 'customer1', 'customer123', 'Customer 1', 'customer1@example.com', '1234567890', 'yes', '2024-09-01 19:09:54', 0, '2024-09-01 19:09:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `CustomerPoint`
--

CREATE TABLE `CustomerPoint` (
  `CustomerPointID` int(11) NOT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `Point` int(11) DEFAULT NULL,
  `CreateAt` datetime DEFAULT current_timestamp(),
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Facility`
--

CREATE TABLE `Facility` (
  `FacilityID` int(11) NOT NULL,
  `FacilityName` varchar(255) NOT NULL,
  `IconUri` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `ApproveStatus` varchar(10) NOT NULL,
  `CreateAt` datetime DEFAULT current_timestamp(),
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `Facility`
--

INSERT INTO `Facility` (`FacilityID`, `FacilityName`, `IconUri`, `Description`, `ApproveStatus`, `CreateAt`, `CreateBy`, `UpdateAt`, `UpdateBy`) VALUES
(1, 'Facility 1', 'icon1.jpg', 'Description 1', 'yes', '2024-09-01 19:09:54', 0, '2024-09-01 19:09:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `House`
--

CREATE TABLE `House` (
  `HouseID` int(11) NOT NULL,
  `MemberID` int(11) DEFAULT NULL,
  `HouseName` varchar(255) NOT NULL,
  `HouseAddress` varchar(255) NOT NULL,
  `HouseEmail` varchar(255) NOT NULL,
  `HouseMobile` varchar(20) NOT NULL,
  `AccessStatus` varchar(10) NOT NULL,
  `CreateAt` datetime DEFAULT current_timestamp(),
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `House`
--

INSERT INTO `House` (`HouseID`, `MemberID`, `HouseName`, `HouseAddress`, `HouseEmail`, `HouseMobile`, `AccessStatus`, `CreateAt`, `CreateBy`, `UpdateAt`, `UpdateBy`) VALUES
(1, 1, 'House 1', 'Address 1', 'house1@example.com', '1234567890', 'yes', '2024-09-01 19:09:54', 0, '2024-09-01 19:09:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `HousePic`
--

CREATE TABLE `HousePic` (
  `HousePicID` int(11) NOT NULL,
  `HouseID` int(11) DEFAULT NULL,
  `PicFile` varchar(255) DEFAULT NULL,
  `CreateAt` datetime DEFAULT current_timestamp(),
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Member`
--

CREATE TABLE `Member` (
  `MemberID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `AccessStatus` varchar(10) NOT NULL,
  `HavePetStatus` varchar(10) NOT NULL,
  `CreateAt` datetime DEFAULT current_timestamp(),
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `Member`
--

INSERT INTO `Member` (`MemberID`, `Username`, `Password`, `Name`, `Email`, `Phone`, `AccessStatus`, `HavePetStatus`, `CreateAt`, `CreateBy`, `UpdateAt`, `UpdateBy`) VALUES
(1, 'member1', 'member123', 'Member 1', 'member1@example.com', '1234567890', 'yes', 'no', '2024-09-01 19:09:54', 0, '2024-09-01 19:09:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `MemberAnswerQuiz`
--

CREATE TABLE `MemberAnswerQuiz` (
  `MemberAnswerID` int(11) NOT NULL,
  `QuizID` int(11) DEFAULT NULL,
  `MemberID` int(11) DEFAULT NULL,
  `Ans` text DEFAULT NULL,
  `Correct` tinyint(1) DEFAULT NULL,
  `CreateAt` datetime DEFAULT current_timestamp(),
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MemberPoint`
--

CREATE TABLE `MemberPoint` (
  `MemberPointID` int(11) NOT NULL,
  `MemberID` int(11) DEFAULT NULL,
  `Point` int(11) DEFAULT NULL,
  `CreateAt` datetime DEFAULT current_timestamp(),
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Pet`
--

CREATE TABLE `Pet` (
  `PetID` int(11) NOT NULL,
  `PetName` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `AccessStatus` varchar(10) NOT NULL,
  `CreateAt` datetime DEFAULT current_timestamp(),
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `Pet`
--

INSERT INTO `Pet` (`PetID`, `PetName`, `Description`, `AccessStatus`, `CreateAt`, `CreateBy`, `UpdateAt`, `UpdateBy`) VALUES
(1, 'Dog', 'Description 1', 'yes', '2024-09-01 19:09:54', 0, '2024-09-01 19:09:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `PetTransport`
--

CREATE TABLE `PetTransport` (
  `PetTransportID` int(11) NOT NULL,
  `MemberID` int(11) DEFAULT NULL,
  `CarName` varchar(255) NOT NULL,
  `CarLicense` varchar(255) NOT NULL,
  `DriverUser` varchar(255) NOT NULL,
  `DriverPass` varchar(255) NOT NULL,
  `AccessStatus` varchar(10) NOT NULL,
  `CreateAt` datetime DEFAULT current_timestamp(),
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Quiz`
--

CREATE TABLE `Quiz` (
  `QuizID` int(11) NOT NULL,
  `PetID` int(11) DEFAULT NULL,
  `QuizDetail` text DEFAULT NULL,
  `ChA` text DEFAULT NULL,
  `ChB` text DEFAULT NULL,
  `ChC` text DEFAULT NULL,
  `ChD` text DEFAULT NULL,
  `Ans` text DEFAULT NULL,
  `CreateAt` datetime DEFAULT current_timestamp(),
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `Quiz`
--

INSERT INTO `Quiz` (`QuizID`, `PetID`, `QuizDetail`, `ChA`, `ChB`, `ChC`, `ChD`, `Ans`, `CreateAt`, `CreateBy`, `UpdateAt`, `UpdateBy`) VALUES
(1, 1, 'Quiz 1?', 'A', 'B', 'C', 'D', 'A', '2024-09-01 19:09:54', 0, '2024-09-01 19:09:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Room`
--

CREATE TABLE `Room` (
  `RoomID` int(11) NOT NULL,
  `FacilityID` int(11) DEFAULT NULL,
  `RoomNumber` int(11) NOT NULL,
  `RoomType` varchar(50) NOT NULL,
  `RoomDescription` text DEFAULT NULL,
  `RoomPrice` decimal(10,2) DEFAULT NULL,
  `CreateAt` datetime DEFAULT current_timestamp(),
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `Room`
--

INSERT INTO `Room` (`RoomID`, `FacilityID`, `RoomNumber`, `RoomType`, `RoomDescription`, `RoomPrice`, `CreateAt`, `CreateBy`, `UpdateAt`, `UpdateBy`) VALUES
(1, 1, 101, 'Single', 'Description 1', 100.00, '2024-09-01 19:09:54', 0, '2024-09-01 19:09:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `RoomFacility`
--

CREATE TABLE `RoomFacility` (
  `RoomFacilityID` int(11) NOT NULL,
  `RoomID` int(11) DEFAULT NULL,
  `FacilityID` int(11) DEFAULT NULL,
  `CreateAt` datetime DEFAULT current_timestamp(),
  `CreateBy` int(11) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UpdateBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `token_blacklist`
--

CREATE TABLE `token_blacklist` (
  `id` int(11) NOT NULL,
  `token` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `Booking`
--
ALTER TABLE `Booking`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `HouseID` (`HouseID`),
  ADD KEY `RoomID` (`RoomID`),
  ADD KEY `PetID` (`PetID`);

--
-- Indexes for table `BookingCheckIn`
--
ALTER TABLE `BookingCheckIn`
  ADD PRIMARY KEY (`BookingCheckInID`),
  ADD KEY `BookingID` (`BookingID`);

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `CustomerPoint`
--
ALTER TABLE `CustomerPoint`
  ADD PRIMARY KEY (`CustomerPointID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `Facility`
--
ALTER TABLE `Facility`
  ADD PRIMARY KEY (`FacilityID`);

--
-- Indexes for table `House`
--
ALTER TABLE `House`
  ADD PRIMARY KEY (`HouseID`),
  ADD KEY `MemberID` (`MemberID`);

--
-- Indexes for table `HousePic`
--
ALTER TABLE `HousePic`
  ADD PRIMARY KEY (`HousePicID`),
  ADD KEY `HouseID` (`HouseID`);

--
-- Indexes for table `Member`
--
ALTER TABLE `Member`
  ADD PRIMARY KEY (`MemberID`);

--
-- Indexes for table `MemberAnswerQuiz`
--
ALTER TABLE `MemberAnswerQuiz`
  ADD PRIMARY KEY (`MemberAnswerID`),
  ADD KEY `QuizID` (`QuizID`),
  ADD KEY `MemberID` (`MemberID`);

--
-- Indexes for table `MemberPoint`
--
ALTER TABLE `MemberPoint`
  ADD PRIMARY KEY (`MemberPointID`),
  ADD KEY `MemberID` (`MemberID`);

--
-- Indexes for table `Pet`
--
ALTER TABLE `Pet`
  ADD PRIMARY KEY (`PetID`);

--
-- Indexes for table `PetTransport`
--
ALTER TABLE `PetTransport`
  ADD PRIMARY KEY (`PetTransportID`),
  ADD KEY `MemberID` (`MemberID`);

--
-- Indexes for table `Quiz`
--
ALTER TABLE `Quiz`
  ADD PRIMARY KEY (`QuizID`),
  ADD KEY `PetID` (`PetID`);

--
-- Indexes for table `Room`
--
ALTER TABLE `Room`
  ADD PRIMARY KEY (`RoomID`),
  ADD KEY `FacilityID` (`FacilityID`);

--
-- Indexes for table `RoomFacility`
--
ALTER TABLE `RoomFacility`
  ADD PRIMARY KEY (`RoomFacilityID`),
  ADD KEY `RoomID` (`RoomID`),
  ADD KEY `FacilityID` (`FacilityID`);

--
-- Indexes for table `token_blacklist`
--
ALTER TABLE `token_blacklist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admin`
--
ALTER TABLE `Admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Booking`
--
ALTER TABLE `Booking`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `BookingCheckIn`
--
ALTER TABLE `BookingCheckIn`
  MODIFY `BookingCheckInID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Customer`
--
ALTER TABLE `Customer`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `CustomerPoint`
--
ALTER TABLE `CustomerPoint`
  MODIFY `CustomerPointID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Facility`
--
ALTER TABLE `Facility`
  MODIFY `FacilityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `House`
--
ALTER TABLE `House`
  MODIFY `HouseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `HousePic`
--
ALTER TABLE `HousePic`
  MODIFY `HousePicID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Member`
--
ALTER TABLE `Member`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `MemberAnswerQuiz`
--
ALTER TABLE `MemberAnswerQuiz`
  MODIFY `MemberAnswerID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `MemberPoint`
--
ALTER TABLE `MemberPoint`
  MODIFY `MemberPointID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Pet`
--
ALTER TABLE `Pet`
  MODIFY `PetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `PetTransport`
--
ALTER TABLE `PetTransport`
  MODIFY `PetTransportID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Quiz`
--
ALTER TABLE `Quiz`
  MODIFY `QuizID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Room`
--
ALTER TABLE `Room`
  MODIFY `RoomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `RoomFacility`
--
ALTER TABLE `RoomFacility`
  MODIFY `RoomFacilityID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `token_blacklist`
--
ALTER TABLE `token_blacklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Booking`
--
ALTER TABLE `Booking`
  ADD CONSTRAINT `Booking_ibfk_1` FOREIGN KEY (`HouseID`) REFERENCES `House` (`HouseID`),
  ADD CONSTRAINT `Booking_ibfk_2` FOREIGN KEY (`RoomID`) REFERENCES `Room` (`RoomID`),
  ADD CONSTRAINT `Booking_ibfk_3` FOREIGN KEY (`PetID`) REFERENCES `Pet` (`PetID`);

--
-- Constraints for table `BookingCheckIn`
--
ALTER TABLE `BookingCheckIn`
  ADD CONSTRAINT `BookingCheckIn_ibfk_1` FOREIGN KEY (`BookingID`) REFERENCES `Booking` (`BookingID`);

--
-- Constraints for table `CustomerPoint`
--
ALTER TABLE `CustomerPoint`
  ADD CONSTRAINT `CustomerPoint_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `Customer` (`CustomerID`);

--
-- Constraints for table `House`
--
ALTER TABLE `House`
  ADD CONSTRAINT `House_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `Member` (`MemberID`);

--
-- Constraints for table `HousePic`
--
ALTER TABLE `HousePic`
  ADD CONSTRAINT `HousePic_ibfk_1` FOREIGN KEY (`HouseID`) REFERENCES `House` (`HouseID`);

--
-- Constraints for table `MemberAnswerQuiz`
--
ALTER TABLE `MemberAnswerQuiz`
  ADD CONSTRAINT `MemberAnswerQuiz_ibfk_1` FOREIGN KEY (`QuizID`) REFERENCES `Quiz` (`QuizID`),
  ADD CONSTRAINT `MemberAnswerQuiz_ibfk_2` FOREIGN KEY (`MemberID`) REFERENCES `Member` (`MemberID`);

--
-- Constraints for table `MemberPoint`
--
ALTER TABLE `MemberPoint`
  ADD CONSTRAINT `MemberPoint_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `Member` (`MemberID`);

--
-- Constraints for table `PetTransport`
--
ALTER TABLE `PetTransport`
  ADD CONSTRAINT `PetTransport_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `Member` (`MemberID`);

--
-- Constraints for table `Quiz`
--
ALTER TABLE `Quiz`
  ADD CONSTRAINT `Quiz_ibfk_1` FOREIGN KEY (`PetID`) REFERENCES `Pet` (`PetID`);

--
-- Constraints for table `Room`
--
ALTER TABLE `Room`
  ADD CONSTRAINT `Room_ibfk_1` FOREIGN KEY (`FacilityID`) REFERENCES `Facility` (`FacilityID`);

--
-- Constraints for table `RoomFacility`
--
ALTER TABLE `RoomFacility`
  ADD CONSTRAINT `RoomFacility_ibfk_1` FOREIGN KEY (`RoomID`) REFERENCES `Room` (`RoomID`),
  ADD CONSTRAINT `RoomFacility_ibfk_2` FOREIGN KEY (`FacilityID`) REFERENCES `Facility` (`FacilityID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
