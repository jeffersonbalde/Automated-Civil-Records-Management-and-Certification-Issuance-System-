-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2025 at 08:01 AM
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
-- Database: `civildb`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

CREATE TABLE `audit_trail` (
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `module` enum('birth','marriage','death','requests','users') DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`audit_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `birth_records`
--

CREATE TABLE `birth_records` (
  `birth_id` int(11) NOT NULL AUTO_INCREMENT,
  `registry_number` varchar(50) DEFAULT NULL,
  `child_full_name` varchar(150) NOT NULL,
  `date_of_birth` date NOT NULL,
  `place_of_birth` varchar(150) DEFAULT NULL,
  `father_name` varchar(150) DEFAULT NULL,
  `mother_name` varchar(150) DEFAULT NULL,
  `date_registered` date NOT NULL,
  `encoded_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`birth_id`),
  UNIQUE KEY `registry_number` (`registry_number`),
  KEY `encoded_by` (`encoded_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `death_records`
--

CREATE TABLE `death_records` (
  `death_id` int(11) NOT NULL AUTO_INCREMENT,
  `registry_number` varchar(50) DEFAULT NULL,
  `deceased_full_name` varchar(150) NOT NULL,
  `date_of_death` date NOT NULL,
  `place_of_death` varchar(150) DEFAULT NULL,
  `cause_of_death` varchar(255) DEFAULT NULL,
  `informant_name` varchar(150) DEFAULT NULL,
  `date_registered` date NOT NULL,
  `encoded_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`death_id`),
  UNIQUE KEY `registry_number` (`registry_number`),
  KEY `encoded_by` (`encoded_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marriage_records`
--

CREATE TABLE `marriage_records` (
  `marriage_id` int(11) NOT NULL AUTO_INCREMENT,
  `registry_number` varchar(50) DEFAULT NULL,
  `groom_full_name` varchar(150) NOT NULL,
  `bride_full_name` varchar(150) NOT NULL,
  `date_of_marriage` date NOT NULL,
  `place_of_marriage` varchar(150) DEFAULT NULL,
  `officiant_name` varchar(150) DEFAULT NULL,
  `date_registered` date NOT NULL,
  `encoded_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`marriage_id`),
  UNIQUE KEY `registry_number` (`registry_number`),
  KEY `encoded_by` (`encoded_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `request_type` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') DEFAULT 'staff',
  `full_name` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `full_name`, `created_at`, `updated_at`, `is_active`) VALUES
(3, 'admin', '$2y$10$p/hUO92n/CE0vFKd.7UGj.tAaoJ19lB2AWjTbTyVG/6oeOSKMU7ou', 'admin', 'System Administrator', '2025-09-04 05:53:55', '2025-09-04 05:53:55', 1);

-- --------------------------------------------------------

--
-- Constraints
--

ALTER TABLE `audit_trail`
  ADD CONSTRAINT `audit_trail_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `birth_records`
  ADD CONSTRAINT `birth_records_ibfk_1` FOREIGN KEY (`encoded_by`) REFERENCES `users` (`user_id`);

ALTER TABLE `death_records`
  ADD CONSTRAINT `death_records_ibfk_1` FOREIGN KEY (`encoded_by`) REFERENCES `users` (`user_id`);

ALTER TABLE `marriage_records`
  ADD CONSTRAINT `marriage_records_ibfk_1` FOREIGN KEY (`encoded_by`) REFERENCES `users` (`user_id`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
 /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
 /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
