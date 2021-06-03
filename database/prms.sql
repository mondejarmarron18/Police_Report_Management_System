-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 20, 2021 at 01:21 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prms`
--

-- --------------------------------------------------------

--
-- Table structure for table `crime`
--

CREATE TABLE `crime` (
  `id` int(11) DEFAULT NULL,
  `crime_type_id` int(11) NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `date_occurred` varchar(10) NOT NULL,
  `time_occured` varchar(10) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `crime_type`
--

CREATE TABLE `crime_type` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `description` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lost_item`
--

CREATE TABLE `lost_item` (
  `id` int(11) NOT NULL,
  `surrenderer_id` int(11) NOT NULL,
  `person_to_contact_id` int(11) NOT NULL,
  `image` varchar(50) NOT NULL,
  `type` varchar(100) NOT NULL,
  `descrption` text NOT NULL,
  `location_lost` varchar(150) NOT NULL,
  `date_lost` varchar(10) NOT NULL,
  `time_lost` varchar(10) NOT NULL,
  `date_found` varchar(10) NOT NULL,
  `time_found` varchar(10) NOT NULL,
  `date_claimed` varchar(10) NOT NULL,
  `time_claimed` varchar(10) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lost_person`
--

CREATE TABLE `lost_person` (
  `id` int(11) NOT NULL,
  `person_to_contact_id` int(11) NOT NULL,
  `returned_person_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `name_extention` varchar(50) NOT NULL,
  `birth_date` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_last_seen` varchar(10) NOT NULL,
  `time_last_seen` varchar(10) NOT NULL,
  `address_last_seen` varchar(255) NOT NULL,
  `whom_last_seen` varchar(255) NOT NULL,
  `disability` varchar(255) NOT NULL,
  `date_found` varchar(10) NOT NULL,
  `time_found` varchar(10) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `name_extention` varchar(50) NOT NULL,
  `birth_date` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_number` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `contact_number` varchar(12) NOT NULL DEFAULT '',
  `first_name` varchar(100) NOT NULL DEFAULT '',
  `middle_name` varchar(100) NOT NULL DEFAULT '',
  `last_name` varchar(100) NOT NULL DEFAULT '',
  `name_extention` varchar(30) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `access_level` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`id`, `username`, `password`, `email`, `contact_number`, `first_name`, `middle_name`, `last_name`, `name_extention`, `address`, `access_level`) VALUES
(4, 'mondejarmarron18', '$2y$10$ovpffLT7Aq.kzCDIr1ka9O2uRtt0vRwJHlrB7WagIHqo9A188eR4a', 'mondejarmarron18@gmail.com', '09360417802', 'Marvin', 'Mondejar', 'Ronquillo', '', 'San Francisco, Sto. Domingo, Nueva Ecija', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crime`
--
ALTER TABLE `crime`
  ADD KEY `crime_type_id` (`crime_type_id`);

--
-- Indexes for table `crime_type`
--
ALTER TABLE `crime_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lost_item`
--
ALTER TABLE `lost_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surrenderer_id` (`surrenderer_id`),
  ADD KEY `person_to_contact_id` (`person_to_contact_id`);

--
-- Indexes for table `lost_person`
--
ALTER TABLE `lost_person`
  ADD PRIMARY KEY (`id`),
  ADD KEY `person_to_contact_id` (`person_to_contact_id`),
  ADD KEY `returned_person_id` (`returned_person_id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crime_type`
--
ALTER TABLE `crime_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lost_item`
--
ALTER TABLE `lost_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lost_person`
--
ALTER TABLE `lost_person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `crime`
--
ALTER TABLE `crime`
  ADD CONSTRAINT `crime_ibfk_1` FOREIGN KEY (`crime_type_id`) REFERENCES `crime_type` (`id`);

--
-- Constraints for table `lost_item`
--
ALTER TABLE `lost_item`
  ADD CONSTRAINT `lost_item_ibfk_1` FOREIGN KEY (`surrenderer_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `lost_item_ibfk_2` FOREIGN KEY (`person_to_contact_id`) REFERENCES `person` (`id`);

--
-- Constraints for table `lost_person`
--
ALTER TABLE `lost_person`
  ADD CONSTRAINT `lost_person_ibfk_1` FOREIGN KEY (`person_to_contact_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `lost_person_ibfk_2` FOREIGN KEY (`returned_person_id`) REFERENCES `person` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
