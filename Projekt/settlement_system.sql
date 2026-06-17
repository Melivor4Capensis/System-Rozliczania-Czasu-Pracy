-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 17, 2026 at 03:51 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `settlement_system`
--

CREATE DATABASE IF NOT EXISTS settlement_system
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE settlement_system;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `calendar_days`
--

CREATE TABLE `calendar_days` (
  `id` int(11) NOT NULL,
  `day_date` date NOT NULL,
  `day_type` enum('Wolny','Roboczy') NOT NULL DEFAULT 'Wolny',
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `report_month` char(7) NOT NULL COMMENT 'format RRRR-MM',
  `status` enum('Wyslany','Zatwierdzony') NOT NULL DEFAULT 'Wyslany',
  `sent_at` datetime DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `report_days`
--

CREATE TABLE `report_days` (
  `id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `day_date` date NOT NULL,
  `hours` decimal(5,2) NOT NULL DEFAULT 0.00,
  `factor` decimal(4,2) NOT NULL DEFAULT 0.00,
  `comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','pracownik','kadrowa') NOT NULL,
  `must_change_password` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `login`, `password`, `role`, `must_change_password`) VALUES
(1, 'Jan', 'Nowak', 'Jan123', '$2y$10$8G5bizOv1kXd7eiCDwLgzuS/mpN9t1NwkIV9U5ZkRygvHOH2xORUG', 'admin', 0),
(2, 'Anna', 'Kowalska', 'Anna123', '$2y$10$lOz8rfGhb9MXDd0TljSFUOJ4ZAKk7BAc5RbS/vADOY4Ag//5rqAwy', 'pracownik', 0),
(3, 'Katarzyna', 'Prus', 'Katarzyna123', '$2y$10$UP9ykUAcsSibNwEJOX5uIuedfwjXLueJEi3mukHzL76hZTcbIUnHu', 'kadrowa', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `calendar_days`
--
ALTER TABLE `calendar_days`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `day_date` (`day_date`);

--
-- Indeksy dla tabeli `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_month` (`user_id`,`report_month`);

--
-- Indeksy dla tabeli `report_days`
--
ALTER TABLE `report_days`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `report_date` (`report_id`,`day_date`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calendar_days`
--
ALTER TABLE `calendar_days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_days`
--
ALTER TABLE `report_days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_days`
--
ALTER TABLE `report_days`
  ADD CONSTRAINT `report_days_report_fk` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
