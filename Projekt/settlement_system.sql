-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 17, 2026 at 12:08 AM
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
  `role` enum('admin','pracownik','kadrowa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `login`, `password`, `role`) VALUES
(1, 'Tomasz', 'Nowak', 'Jan123', '$2y$10$8G5bizOv1kXd7eiCDwLgzuS/mpN9t1NwkIV9U5ZkRygvHOH2xORUG', 'admin'),
(2, 'Anna', 'Kowalska', 'Anna123', '$2y$10$lOz8rfGhb9MXDd0TljSFUOJ4ZAKk7BAc5RbS/vADOY4Ag//5rqAwy', 'pracownik'),
(3, 'Katarzyna', 'Prus', 'Katarzyna123', '$2y$10$UP9ykUAcsSibNwEJOX5uIuedfwjXLueJEi3mukHzL76hZTcbIUnHu', 'kadrowa');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `work_calendar`
--

CREATE TABLE `work_calendar` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `type` enum('Wolny','Roboczy') DEFAULT 'Roboczy',
  `description` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `work_calendar`
--

INSERT INTO `work_calendar` (`id`, `date`, `type`, `description`, `created_by`, `updated_at`) VALUES
(1, '2026-05-01', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(2, '2026-05-02', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(3, '2026-05-03', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(4, '2026-05-04', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(5, '2026-05-05', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(6, '2026-05-06', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(7, '2026-05-07', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(8, '2026-05-08', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(9, '2026-05-09', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(10, '2026-05-10', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(11, '2026-05-11', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(12, '2026-05-12', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(13, '2026-05-13', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(14, '2026-05-14', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(15, '2026-05-15', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(16, '2026-05-16', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(17, '2026-05-17', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(18, '2026-05-18', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(19, '2026-05-19', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(20, '2026-05-20', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(21, '2026-05-21', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(22, '2026-05-22', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(23, '2026-05-23', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(24, '2026-05-24', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(25, '2026-05-25', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(26, '2026-05-26', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(27, '2026-05-27', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(28, '2026-05-28', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(29, '2026-05-29', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(30, '2026-05-30', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(31, '2026-05-31', 'Roboczy', NULL, 3, '2026-06-16 21:11:30'),
(32, '2026-02-01', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(33, '2026-02-02', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(34, '2026-02-03', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(35, '2026-02-04', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(36, '2026-02-05', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(37, '2026-02-06', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(38, '2026-02-07', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(39, '2026-02-08', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(40, '2026-02-09', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(41, '2026-02-10', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(42, '2026-02-11', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(43, '2026-02-12', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(44, '2026-02-13', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(45, '2026-02-14', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(46, '2026-02-15', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(47, '2026-02-16', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(48, '2026-02-17', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(49, '2026-02-18', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(50, '2026-02-19', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(51, '2026-02-20', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(52, '2026-02-21', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(53, '2026-02-22', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(54, '2026-02-23', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(55, '2026-02-24', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(56, '2026-02-25', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(57, '2026-02-26', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(58, '2026-02-27', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(59, '2026-02-28', 'Roboczy', NULL, 3, '2026-06-16 21:11:33'),
(60, '2026-03-01', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(61, '2026-03-02', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(62, '2026-03-03', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(63, '2026-03-04', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(64, '2026-03-05', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(65, '2026-03-06', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(66, '2026-03-07', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(67, '2026-03-08', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(68, '2026-03-09', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(69, '2026-03-10', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(70, '2026-03-11', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(71, '2026-03-12', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(72, '2026-03-13', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(73, '2026-03-14', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(74, '2026-03-15', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(75, '2026-03-16', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(76, '2026-03-17', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(77, '2026-03-18', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(78, '2026-03-19', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(79, '2026-03-20', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(80, '2026-03-21', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(81, '2026-03-22', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(82, '2026-03-23', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(83, '2026-03-24', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(84, '2026-03-25', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(85, '2026-03-26', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(86, '2026-03-27', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(87, '2026-03-28', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(88, '2026-03-29', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(89, '2026-03-30', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(90, '2026-03-31', 'Roboczy', NULL, 3, '2026-06-16 21:11:35'),
(91, '2026-08-01', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(92, '2026-08-02', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(93, '2026-08-03', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(94, '2026-08-04', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(95, '2026-08-05', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(96, '2026-08-06', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(97, '2026-08-07', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(98, '2026-08-08', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(99, '2026-08-09', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(100, '2026-08-10', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(101, '2026-08-11', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(102, '2026-08-12', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(103, '2026-08-13', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(104, '2026-08-14', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(105, '2026-08-15', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(106, '2026-08-16', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(107, '2026-08-17', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(108, '2026-08-18', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(109, '2026-08-19', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(110, '2026-08-20', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(111, '2026-08-21', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(112, '2026-08-22', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(113, '2026-08-23', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(114, '2026-08-24', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(115, '2026-08-25', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(116, '2026-08-26', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(117, '2026-08-27', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(118, '2026-08-28', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(119, '2026-08-29', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(120, '2026-08-30', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(121, '2026-08-31', 'Roboczy', NULL, 3, '2026-06-16 22:08:08'),
(122, '2026-07-01', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(123, '2026-07-02', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(124, '2026-07-03', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(125, '2026-07-04', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(126, '2026-07-05', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(127, '2026-07-06', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(128, '2026-07-07', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(129, '2026-07-08', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(130, '2026-07-09', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(131, '2026-07-10', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(132, '2026-07-11', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(133, '2026-07-12', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(134, '2026-07-13', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(135, '2026-07-14', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(136, '2026-07-15', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(137, '2026-07-16', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(138, '2026-07-17', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(139, '2026-07-18', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(140, '2026-07-19', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(141, '2026-07-20', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(142, '2026-07-21', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(143, '2026-07-22', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(144, '2026-07-23', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(145, '2026-07-24', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(146, '2026-07-25', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(147, '2026-07-26', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(148, '2026-07-27', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(149, '2026-07-28', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(150, '2026-07-29', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(151, '2026-07-30', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(152, '2026-07-31', 'Roboczy', NULL, 3, '2026-06-16 22:08:10'),
(153, '2026-06-01', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(154, '2026-06-02', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(155, '2026-06-03', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(156, '2026-06-04', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(157, '2026-06-05', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(158, '2026-06-06', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(159, '2026-06-07', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(160, '2026-06-08', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(161, '2026-06-09', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(162, '2026-06-10', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(163, '2026-06-11', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(164, '2026-06-12', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(165, '2026-06-13', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(166, '2026-06-14', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(167, '2026-06-15', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(168, '2026-06-16', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(169, '2026-06-17', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(170, '2026-06-18', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(171, '2026-06-19', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(172, '2026-06-20', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(173, '2026-06-21', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(174, '2026-06-22', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(175, '2026-06-23', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(176, '2026-06-24', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(177, '2026-06-25', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(178, '2026-06-26', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(179, '2026-06-27', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(180, '2026-06-28', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(181, '2026-06-29', 'Roboczy', NULL, 3, '2026-06-16 22:08:12'),
(182, '2026-06-30', 'Roboczy', NULL, 3, '2026-06-16 22:08:12');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `work_calendar_months`
--

CREATE TABLE `work_calendar_months` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `work_calendar_months`
--

INSERT INTO `work_calendar_months` (`id`, `year`, `month`, `created_at`, `created_by`) VALUES
(1, 2026, 5, '2026-06-16 21:11:30', 3),
(2, 2026, 2, '2026-06-16 21:11:33', 3),
(3, 2026, 3, '2026-06-16 21:11:35', 3),
(4, 2026, 8, '2026-06-16 22:08:08', 3),
(5, 2026, 7, '2026-06-16 22:08:10', 3),
(6, 2026, 6, '2026-06-16 22:08:12', 3);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Indeksy dla tabeli `work_calendar`
--
ALTER TABLE `work_calendar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `date` (`date`);

--
-- Indeksy dla tabeli `work_calendar_months`
--
ALTER TABLE `work_calendar_months`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_month` (`year`,`month`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `work_calendar`
--
ALTER TABLE `work_calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `work_calendar_months`
--
ALTER TABLE `work_calendar_months`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
