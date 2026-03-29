-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2025 at 01:43 PM
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
-- Database: `key_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_keys`
--

CREATE TABLE `access_keys` (
  `id` int(11) NOT NULL,
  `access_key` varchar(255) NOT NULL,
  `used` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `device_id` varchar(255) DEFAULT NULL,
  `key_type` enum('vĩnh viễn','gia hạn') NOT NULL DEFAULT 'vĩnh viễn',
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `access_keys`
--

INSERT INTO `access_keys` (`id`, `access_key`, `used`, `created_at`, `device_id`, `key_type`, `expires_at`) VALUES
(11, '123', 0, '2025-07-14 09:49:30', '', 'gia hạn', '2025-08-13 16:49:32');

-- --------------------------------------------------------

--
-- Table structure for table `admin_account`
--

CREATE TABLE `admin_account` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_account`
--

INSERT INTO `admin_account` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'tinhios', '$2y$10$SSNVYVq9yS8t/dK45b2EsOLLj43Ex.kHWD3RKf1huh0AXh5m8YaOC', '2025-07-14 11:30:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_keys`
--
ALTER TABLE `access_keys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `access_key` (`access_key`);

--
-- Indexes for table `admin_account`
--
ALTER TABLE `admin_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_keys`
--
ALTER TABLE `access_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `admin_account`
--
ALTER TABLE `admin_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
