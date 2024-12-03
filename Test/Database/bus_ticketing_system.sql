-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2024 at 02:29 PM
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
-- Database: `bus_ticketing_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bus_id` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `seat_number` varchar(11) NOT NULL,
  `booking_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `bus_id`, `route_id`, `seat_number`, `booking_date`, `created_at`) VALUES
(18, 14, 4, 16, 'A6', '2024-08-24', '2024-08-23 18:58:56'),
(19, 14, 4, 16, 'A1', '2024-08-24', '2024-08-23 19:11:41'),
(20, 14, 4, 16, 'B1', '2024-08-24', '2024-08-23 19:11:41'),
(21, 14, 4, 16, 'A3', '2024-08-24', '2024-08-23 19:19:09'),
(22, 14, 4, 16, 'A2', '2024-08-24', '2024-08-23 19:21:55'),
(23, 14, 4, 16, 'C3', '2024-08-24', '2024-08-23 19:49:08'),
(24, 14, 4, 16, 'C4', '2024-08-24', '2024-08-23 19:51:00'),
(25, 14, 4, 16, 'D1', '2024-08-24', '2024-08-23 20:29:49'),
(26, 14, 4, 16, 'B6', '2024-08-24', '2024-08-23 20:39:56'),
(27, 14, 4, 16, 'B4', '2024-08-24', '2024-08-23 20:45:19'),
(28, 16, 5, 18, 'A1', '2024-08-24', '2024-08-23 21:13:58'),
(29, 1, 4, 16, 'C1', '2024-08-24', '2024-08-23 21:15:25'),
(30, 18, 5, 18, 'A2', '2024-08-24', '2024-08-24 03:22:11'),
(31, 1, 6, 20, 'A1', '2024-08-24', '2024-08-24 03:32:54'),
(32, 19, 13, 21, 'A1', '2024-08-25', '2024-08-25 08:25:08'),
(33, 1, 13, 21, 'A2', '2024-08-25', '2024-08-25 09:24:01'),
(34, 1, 13, 21, 'C1', '2024-08-28', '2024-08-28 11:55:13'),
(35, 1, 14, 23, 'A1', '2024-08-28', '2024-08-28 12:08:30'),
(36, 1, 5, 18, 'D4', '2024-09-22', '2024-09-22 16:03:12'),
(37, 18, 5, 18, 'B1', '2024-09-22', '2024-09-22 16:08:50'),
(38, 19, 5, 18, 'A1', '2024-09-24', '2024-09-23 18:20:28'),
(39, 19, 5, 18, 'A8', '2024-09-24', '2024-09-23 18:43:22'),
(40, 24, 5, 18, 'A2', '2024-09-25', '2024-09-25 04:22:55');

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `bus_number` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`id`, `name`, `bus_number`, `status`, `date_updated`) VALUES
(4, 'Lumbini A/C', 'Lu 4 Kha 0003', 1, '2024-09-24 10:33:23'),
(5, 'Bhairab Darshan', 'Lu 2 kha 1403', 1, '2024-08-24 02:56:00'),
(6, 'Desh Darshan', 'Lu 4 Kha 2002', 1, '2024-08-24 09:11:20'),
(8, 'Rajhdani Deluxe', 'Ba 1 Kha 1010', 1, '2024-08-24 21:48:34'),
(9, 'Kamana Deluxe', 'Lu 3 Kha 1001', 1, '2024-08-24 21:49:56'),
(10, 'Rapti Deluxe', 'Ra 3 Kha 2003', 1, '2024-08-24 21:50:49'),
(11, 'Srinagar Yatayat', 'Lu 4 Kha 429', 1, '2024-08-24 21:52:30'),
(12, 'Gandagi Traveler', 'Ga 5 Kha 2000', 1, '2024-08-24 21:53:58'),
(13, 'Koshi Deluxe', 'Ko 1 Kha 9999', 1, '2024-08-24 21:54:37'),
(14, 'Koshi Deluxe', 'Ko 1 Kha 1000', 1, '2024-08-24 22:02:58'),
(15, 'Mechi Express', 'Me 3 kha 8888', 1, '2024-08-24 22:03:37'),
(16, 'Mechi Express', 'Me 4 kha 1111', 1, '2024-08-24 22:04:02'),
(17, 'Sajha Yatayat', 'Ba 8 Kha 5001', 1, '2024-09-25 10:44:06');

-- --------------------------------------------------------

--
-- Table structure for table `bus_seats`
--

CREATE TABLE `bus_seats` (
  `id` int(11) NOT NULL,
  `bus_id` int(11) DEFAULT NULL,
  `route_id` int(11) DEFAULT NULL,
  `seat_number` varchar(5) DEFAULT NULL,
  `status` enum('available','booked') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus_seats`
--

INSERT INTO `bus_seats` (`id`, `bus_id`, `route_id`, `seat_number`, `status`) VALUES
(2, 4, 16, 'A2', 'available'),
(3, 4, 16, 'A3', 'available'),
(4, 4, 16, 'A4', 'available'),
(5, 4, NULL, 'A5', 'available'),
(6, 4, NULL, 'A6', 'available'),
(7, 4, NULL, 'A7', 'available'),
(8, 4, NULL, 'A8', 'available'),
(9, 4, NULL, 'A9', 'available'),
(10, 4, 16, 'B1', 'available'),
(11, 4, NULL, 'B2', 'available'),
(12, 4, NULL, 'B3', 'available'),
(13, 4, 16, 'B4', 'available'),
(14, 4, NULL, 'B5', 'available'),
(15, 4, 16, 'B6', 'available'),
(16, 4, NULL, 'B7', 'available'),
(17, 4, NULL, 'B8', 'available'),
(18, 4, NULL, 'B9', 'available'),
(19, 4, 16, 'C1', 'available'),
(20, 4, NULL, 'C2', 'available'),
(21, 4, 16, 'C3', 'available'),
(22, 4, 16, 'C4', 'available'),
(23, 4, NULL, 'C5', 'available'),
(24, 4, NULL, 'C6', 'available'),
(25, 4, NULL, 'C7', 'available'),
(26, 4, NULL, 'C8', 'available'),
(27, 4, NULL, 'C9', 'available'),
(28, 4, 16, 'D1', 'available'),
(29, 4, NULL, 'D2', 'available'),
(30, 4, NULL, 'D3', 'available'),
(31, 4, NULL, 'D4', 'available'),
(32, 4, NULL, 'D5', 'available'),
(33, 4, NULL, 'D6', 'available'),
(34, 4, NULL, 'D7', 'available'),
(35, 4, NULL, 'D8', 'available'),
(36, 4, NULL, 'D9', 'available'),
(37, 4, NULL, 'E1', 'available'),
(38, 4, NULL, 'E2', 'available'),
(39, 4, NULL, 'E3', 'available'),
(40, 4, NULL, 'E4', 'available'),
(41, 4, NULL, 'E5', 'available'),
(42, 5, 18, 'A1', 'available'),
(43, 5, 18, 'A2', 'booked'),
(44, 5, NULL, 'A3', 'available'),
(45, 5, NULL, 'A4', 'available'),
(46, 5, NULL, 'A5', 'available'),
(47, 5, NULL, 'A6', 'available'),
(48, 5, NULL, 'A7', 'available'),
(49, 5, 18, 'A8', 'booked'),
(50, 5, NULL, 'A9', 'available'),
(51, 5, 18, 'B1', 'booked'),
(52, 5, NULL, 'B2', 'available'),
(53, 5, NULL, 'B3', 'available'),
(54, 5, NULL, 'B4', 'available'),
(55, 5, NULL, 'B5', 'available'),
(56, 5, NULL, 'B6', 'available'),
(57, 5, NULL, 'B7', 'available'),
(58, 5, NULL, 'B8', 'available'),
(59, 5, NULL, 'B9', 'available'),
(60, 5, NULL, 'C1', 'available'),
(61, 5, NULL, 'C2', 'available'),
(62, 5, NULL, 'C3', 'available'),
(63, 5, NULL, 'C4', 'available'),
(64, 5, NULL, 'C5', 'available'),
(65, 5, NULL, 'C6', 'available'),
(66, 5, NULL, 'C7', 'available'),
(67, 5, NULL, 'C8', 'available'),
(68, 5, NULL, 'C9', 'available'),
(69, 5, NULL, 'D1', 'available'),
(70, 5, NULL, 'D2', 'available'),
(71, 5, NULL, 'D3', 'available'),
(72, 5, 18, 'D4', 'booked'),
(73, 5, NULL, 'D5', 'available'),
(74, 5, NULL, 'D6', 'available'),
(75, 5, NULL, 'D7', 'available'),
(76, 5, NULL, 'D8', 'available'),
(77, 5, NULL, 'D9', 'available'),
(78, 5, NULL, 'E1', 'available'),
(79, 5, NULL, 'E2', 'available'),
(80, 5, NULL, 'E3', 'available'),
(81, 5, NULL, 'E4', 'available'),
(82, 5, NULL, 'E5', 'available'),
(83, 6, 20, 'A1', 'booked'),
(84, 6, NULL, 'A2', 'available'),
(85, 6, NULL, 'A3', 'available'),
(86, 6, NULL, 'A4', 'available'),
(87, 6, NULL, 'A5', 'available'),
(88, 6, NULL, 'A6', 'available'),
(89, 6, NULL, 'A7', 'available'),
(90, 6, NULL, 'A8', 'available'),
(91, 6, NULL, 'A9', 'available'),
(92, 6, NULL, 'B1', 'available'),
(93, 6, NULL, 'B2', 'available'),
(94, 6, NULL, 'B3', 'available'),
(95, 6, NULL, 'B4', 'available'),
(96, 6, NULL, 'B5', 'available'),
(97, 6, NULL, 'B6', 'available'),
(98, 6, NULL, 'B7', 'available'),
(99, 6, NULL, 'B8', 'available'),
(100, 6, NULL, 'B9', 'available'),
(101, 6, NULL, 'C1', 'available'),
(102, 6, NULL, 'C2', 'available'),
(103, 6, NULL, 'C3', 'available'),
(104, 6, NULL, 'C4', 'available'),
(105, 6, NULL, 'C5', 'available'),
(106, 6, NULL, 'C6', 'available'),
(107, 6, NULL, 'C7', 'available'),
(108, 6, NULL, 'C8', 'available'),
(109, 6, NULL, 'C9', 'available'),
(110, 6, NULL, 'D1', 'available'),
(111, 6, NULL, 'D2', 'available'),
(112, 6, NULL, 'D3', 'available'),
(113, 6, NULL, 'D4', 'available'),
(114, 6, NULL, 'D5', 'available'),
(115, 6, NULL, 'D6', 'available'),
(116, 6, NULL, 'D7', 'available'),
(117, 6, NULL, 'D8', 'available'),
(118, 6, NULL, 'D9', 'available'),
(119, 6, NULL, 'E1', 'available'),
(120, 6, NULL, 'E2', 'available'),
(121, 6, NULL, 'E3', 'available'),
(122, 6, NULL, 'E4', 'available'),
(123, 6, NULL, 'E5', 'available'),
(165, 8, NULL, 'A1', 'available'),
(166, 8, NULL, 'A2', 'available'),
(167, 8, NULL, 'A3', 'available'),
(168, 8, NULL, 'A4', 'available'),
(169, 8, NULL, 'A5', 'available'),
(170, 8, NULL, 'A6', 'available'),
(171, 8, NULL, 'A7', 'available'),
(172, 8, NULL, 'A8', 'available'),
(173, 8, NULL, 'A9', 'available'),
(174, 8, NULL, 'B1', 'available'),
(175, 8, NULL, 'B2', 'available'),
(176, 8, NULL, 'B3', 'available'),
(177, 8, NULL, 'B4', 'available'),
(178, 8, NULL, 'B5', 'available'),
(179, 8, NULL, 'B6', 'available'),
(180, 8, NULL, 'B7', 'available'),
(181, 8, NULL, 'B8', 'available'),
(182, 8, NULL, 'B9', 'available'),
(183, 8, NULL, 'C1', 'available'),
(184, 8, NULL, 'C2', 'available'),
(185, 8, NULL, 'C3', 'available'),
(186, 8, NULL, 'C4', 'available'),
(187, 8, NULL, 'C5', 'available'),
(188, 8, NULL, 'C6', 'available'),
(189, 8, NULL, 'C7', 'available'),
(190, 8, NULL, 'C8', 'available'),
(191, 8, NULL, 'C9', 'available'),
(192, 8, NULL, 'D1', 'available'),
(193, 8, NULL, 'D2', 'available'),
(194, 8, NULL, 'D3', 'available'),
(195, 8, NULL, 'D4', 'available'),
(196, 8, NULL, 'D5', 'available'),
(197, 8, NULL, 'D6', 'available'),
(198, 8, NULL, 'D7', 'available'),
(199, 8, NULL, 'D8', 'available'),
(200, 8, NULL, 'D9', 'available'),
(201, 8, NULL, 'E1', 'available'),
(202, 8, NULL, 'E2', 'available'),
(203, 8, NULL, 'E3', 'available'),
(204, 8, NULL, 'E4', 'available'),
(205, 8, NULL, 'E5', 'available'),
(206, 9, NULL, 'A1', 'available'),
(207, 9, NULL, 'A2', 'available'),
(208, 9, NULL, 'A3', 'available'),
(209, 9, NULL, 'A4', 'available'),
(210, 9, NULL, 'A5', 'available'),
(211, 9, NULL, 'A6', 'available'),
(212, 9, NULL, 'A7', 'available'),
(213, 9, NULL, 'A8', 'available'),
(214, 9, NULL, 'A9', 'available'),
(215, 9, NULL, 'B1', 'available'),
(216, 9, NULL, 'B2', 'available'),
(217, 9, NULL, 'B3', 'available'),
(218, 9, NULL, 'B4', 'available'),
(219, 9, NULL, 'B5', 'available'),
(220, 9, NULL, 'B6', 'available'),
(221, 9, NULL, 'B7', 'available'),
(222, 9, NULL, 'B8', 'available'),
(223, 9, NULL, 'B9', 'available'),
(224, 9, NULL, 'C1', 'available'),
(225, 9, NULL, 'C2', 'available'),
(226, 9, NULL, 'C3', 'available'),
(227, 9, NULL, 'C4', 'available'),
(228, 9, NULL, 'C5', 'available'),
(229, 9, NULL, 'C6', 'available'),
(230, 9, NULL, 'C7', 'available'),
(231, 9, NULL, 'C8', 'available'),
(232, 9, NULL, 'C9', 'available'),
(233, 9, NULL, 'D1', 'available'),
(234, 9, NULL, 'D2', 'available'),
(235, 9, NULL, 'D3', 'available'),
(236, 9, NULL, 'D4', 'available'),
(237, 9, NULL, 'D5', 'available'),
(238, 9, NULL, 'D6', 'available'),
(239, 9, NULL, 'D7', 'available'),
(240, 9, NULL, 'D8', 'available'),
(241, 9, NULL, 'D9', 'available'),
(242, 9, NULL, 'E1', 'available'),
(243, 9, NULL, 'E2', 'available'),
(244, 9, NULL, 'E3', 'available'),
(245, 9, NULL, 'E4', 'available'),
(246, 9, NULL, 'E5', 'available'),
(247, 10, NULL, 'A1', 'available'),
(248, 10, NULL, 'A2', 'available'),
(249, 10, NULL, 'A3', 'available'),
(250, 10, NULL, 'A4', 'available'),
(251, 10, NULL, 'A5', 'available'),
(252, 10, NULL, 'A6', 'available'),
(253, 10, NULL, 'A7', 'available'),
(254, 10, NULL, 'A8', 'available'),
(255, 10, NULL, 'A9', 'available'),
(256, 10, NULL, 'B1', 'available'),
(257, 10, NULL, 'B2', 'available'),
(258, 10, NULL, 'B3', 'available'),
(259, 10, NULL, 'B4', 'available'),
(260, 10, NULL, 'B5', 'available'),
(261, 10, NULL, 'B6', 'available'),
(262, 10, NULL, 'B7', 'available'),
(263, 10, NULL, 'B8', 'available'),
(264, 10, NULL, 'B9', 'available'),
(265, 10, NULL, 'C1', 'available'),
(266, 10, NULL, 'C2', 'available'),
(267, 10, NULL, 'C3', 'available'),
(268, 10, NULL, 'C4', 'available'),
(269, 10, NULL, 'C5', 'available'),
(270, 10, NULL, 'C6', 'available'),
(271, 10, NULL, 'C7', 'available'),
(272, 10, NULL, 'C8', 'available'),
(273, 10, NULL, 'C9', 'available'),
(274, 10, NULL, 'D1', 'available'),
(275, 10, NULL, 'D2', 'available'),
(276, 10, NULL, 'D3', 'available'),
(277, 10, NULL, 'D4', 'available'),
(278, 10, NULL, 'D5', 'available'),
(279, 10, NULL, 'D6', 'available'),
(280, 10, NULL, 'D7', 'available'),
(281, 10, NULL, 'D8', 'available'),
(282, 10, NULL, 'D9', 'available'),
(283, 10, NULL, 'E1', 'available'),
(284, 10, NULL, 'E2', 'available'),
(285, 10, NULL, 'E3', 'available'),
(286, 10, NULL, 'E4', 'available'),
(287, 10, NULL, 'E5', 'available'),
(288, 11, NULL, 'A1', 'available'),
(289, 11, NULL, 'A2', 'available'),
(290, 11, NULL, 'A3', 'available'),
(291, 11, NULL, 'A4', 'available'),
(292, 11, NULL, 'A5', 'available'),
(293, 11, NULL, 'A6', 'available'),
(294, 11, NULL, 'A7', 'available'),
(295, 11, NULL, 'A8', 'available'),
(296, 11, NULL, 'A9', 'available'),
(297, 11, NULL, 'B1', 'available'),
(298, 11, NULL, 'B2', 'available'),
(299, 11, NULL, 'B3', 'available'),
(300, 11, NULL, 'B4', 'available'),
(301, 11, NULL, 'B5', 'available'),
(302, 11, NULL, 'B6', 'available'),
(303, 11, NULL, 'B7', 'available'),
(304, 11, NULL, 'B8', 'available'),
(305, 11, NULL, 'B9', 'available'),
(306, 11, NULL, 'C1', 'available'),
(307, 11, NULL, 'C2', 'available'),
(308, 11, NULL, 'C3', 'available'),
(309, 11, NULL, 'C4', 'available'),
(310, 11, NULL, 'C5', 'available'),
(311, 11, NULL, 'C6', 'available'),
(312, 11, NULL, 'C7', 'available'),
(313, 11, NULL, 'C8', 'available'),
(314, 11, NULL, 'C9', 'available'),
(315, 11, NULL, 'D1', 'available'),
(316, 11, NULL, 'D2', 'available'),
(317, 11, NULL, 'D3', 'available'),
(318, 11, NULL, 'D4', 'available'),
(319, 11, NULL, 'D5', 'available'),
(320, 11, NULL, 'D6', 'available'),
(321, 11, NULL, 'D7', 'available'),
(322, 11, NULL, 'D8', 'available'),
(323, 11, NULL, 'D9', 'available'),
(324, 11, NULL, 'E1', 'available'),
(325, 11, NULL, 'E2', 'available'),
(326, 11, NULL, 'E3', 'available'),
(327, 11, NULL, 'E4', 'available'),
(328, 11, NULL, 'E5', 'available'),
(329, 12, NULL, 'A1', 'available'),
(330, 12, NULL, 'A2', 'available'),
(331, 12, NULL, 'A3', 'available'),
(332, 12, NULL, 'A4', 'available'),
(333, 12, NULL, 'A5', 'available'),
(334, 12, NULL, 'A6', 'available'),
(335, 12, NULL, 'A7', 'available'),
(336, 12, NULL, 'A8', 'available'),
(337, 12, NULL, 'A9', 'available'),
(338, 12, NULL, 'B1', 'available'),
(339, 12, NULL, 'B2', 'available'),
(340, 12, NULL, 'B3', 'available'),
(341, 12, NULL, 'B4', 'available'),
(342, 12, NULL, 'B5', 'available'),
(343, 12, NULL, 'B6', 'available'),
(344, 12, NULL, 'B7', 'available'),
(345, 12, NULL, 'B8', 'available'),
(346, 12, NULL, 'B9', 'available'),
(347, 12, NULL, 'C1', 'available'),
(348, 12, NULL, 'C2', 'available'),
(349, 12, NULL, 'C3', 'available'),
(350, 12, NULL, 'C4', 'available'),
(351, 12, NULL, 'C5', 'available'),
(352, 12, NULL, 'C6', 'available'),
(353, 12, NULL, 'C7', 'available'),
(354, 12, NULL, 'C8', 'available'),
(355, 12, NULL, 'C9', 'available'),
(356, 12, NULL, 'D1', 'available'),
(357, 12, NULL, 'D2', 'available'),
(358, 12, NULL, 'D3', 'available'),
(359, 12, NULL, 'D4', 'available'),
(360, 12, NULL, 'D5', 'available'),
(361, 12, NULL, 'D6', 'available'),
(362, 12, NULL, 'D7', 'available'),
(363, 12, NULL, 'D8', 'available'),
(364, 12, NULL, 'D9', 'available'),
(365, 12, NULL, 'E1', 'available'),
(366, 12, NULL, 'E2', 'available'),
(367, 12, NULL, 'E3', 'available'),
(368, 12, NULL, 'E4', 'available'),
(369, 12, NULL, 'E5', 'available'),
(370, 13, 21, 'A1', 'booked'),
(371, 13, 21, 'A2', 'booked'),
(372, 13, NULL, 'A3', 'available'),
(373, 13, NULL, 'A4', 'available'),
(374, 13, NULL, 'A5', 'available'),
(375, 13, NULL, 'A6', 'available'),
(376, 13, NULL, 'A7', 'available'),
(377, 13, NULL, 'A8', 'available'),
(378, 13, NULL, 'A9', 'available'),
(379, 13, NULL, 'B1', 'available'),
(380, 13, NULL, 'B2', 'available'),
(381, 13, NULL, 'B3', 'available'),
(382, 13, NULL, 'B4', 'available'),
(383, 13, NULL, 'B5', 'available'),
(384, 13, NULL, 'B6', 'available'),
(385, 13, NULL, 'B7', 'available'),
(386, 13, NULL, 'B8', 'available'),
(387, 13, NULL, 'B9', 'available'),
(388, 13, 21, 'C1', 'booked'),
(389, 13, NULL, 'C2', 'available'),
(390, 13, NULL, 'C3', 'available'),
(391, 13, NULL, 'C4', 'available'),
(392, 13, NULL, 'C5', 'available'),
(393, 13, NULL, 'C6', 'available'),
(394, 13, NULL, 'C7', 'available'),
(395, 13, NULL, 'C8', 'available'),
(396, 13, NULL, 'C9', 'available'),
(397, 13, NULL, 'D1', 'available'),
(398, 13, NULL, 'D2', 'available'),
(399, 13, NULL, 'D3', 'available'),
(400, 13, NULL, 'D4', 'available'),
(401, 13, NULL, 'D5', 'available'),
(402, 13, NULL, 'D6', 'available'),
(403, 13, NULL, 'D7', 'available'),
(404, 13, NULL, 'D8', 'available'),
(405, 13, NULL, 'D9', 'available'),
(406, 13, NULL, 'E1', 'available'),
(407, 13, NULL, 'E2', 'available'),
(408, 13, NULL, 'E3', 'available'),
(409, 13, NULL, 'E4', 'available'),
(410, 13, NULL, 'E5', 'available'),
(411, 14, 23, 'A1', 'booked'),
(412, 14, NULL, 'A2', 'available'),
(413, 14, NULL, 'A3', 'available'),
(414, 14, NULL, 'A4', 'available'),
(415, 14, NULL, 'A5', 'available'),
(416, 14, NULL, 'A6', 'available'),
(417, 14, NULL, 'A7', 'available'),
(418, 14, NULL, 'A8', 'available'),
(419, 14, NULL, 'A9', 'available'),
(420, 14, NULL, 'B1', 'available'),
(421, 14, NULL, 'B2', 'available'),
(422, 14, NULL, 'B3', 'available'),
(423, 14, NULL, 'B4', 'available'),
(424, 14, NULL, 'B5', 'available'),
(425, 14, NULL, 'B6', 'available'),
(426, 14, NULL, 'B7', 'available'),
(427, 14, NULL, 'B8', 'available'),
(428, 14, NULL, 'B9', 'available'),
(429, 14, NULL, 'C1', 'available'),
(430, 14, NULL, 'C2', 'available'),
(431, 14, NULL, 'C3', 'available'),
(432, 14, NULL, 'C4', 'available'),
(433, 14, NULL, 'C5', 'available'),
(434, 14, NULL, 'C6', 'available'),
(435, 14, NULL, 'C7', 'available'),
(436, 14, NULL, 'C8', 'available'),
(437, 14, NULL, 'C9', 'available'),
(438, 14, NULL, 'D1', 'available'),
(439, 14, NULL, 'D2', 'available'),
(440, 14, NULL, 'D3', 'available'),
(441, 14, NULL, 'D4', 'available'),
(442, 14, NULL, 'D5', 'available'),
(443, 14, NULL, 'D6', 'available'),
(444, 14, NULL, 'D7', 'available'),
(445, 14, NULL, 'D8', 'available'),
(446, 14, NULL, 'D9', 'available'),
(447, 14, NULL, 'E1', 'available'),
(448, 14, NULL, 'E2', 'available'),
(449, 14, NULL, 'E3', 'available'),
(450, 14, NULL, 'E4', 'available'),
(451, 14, NULL, 'E5', 'available'),
(452, 15, NULL, 'A1', 'available'),
(453, 15, NULL, 'A2', 'available'),
(454, 15, NULL, 'A3', 'available'),
(455, 15, NULL, 'A4', 'available'),
(456, 15, NULL, 'A5', 'available'),
(457, 15, NULL, 'A6', 'available'),
(458, 15, NULL, 'A7', 'available'),
(459, 15, NULL, 'A8', 'available'),
(460, 15, NULL, 'A9', 'available'),
(461, 15, NULL, 'B1', 'available'),
(462, 15, NULL, 'B2', 'available'),
(463, 15, NULL, 'B3', 'available'),
(464, 15, NULL, 'B4', 'available'),
(465, 15, NULL, 'B5', 'available'),
(466, 15, NULL, 'B6', 'available'),
(467, 15, NULL, 'B7', 'available'),
(468, 15, NULL, 'B8', 'available'),
(469, 15, NULL, 'B9', 'available'),
(470, 15, NULL, 'C1', 'available'),
(471, 15, NULL, 'C2', 'available'),
(472, 15, NULL, 'C3', 'available'),
(473, 15, NULL, 'C4', 'available'),
(474, 15, NULL, 'C5', 'available'),
(475, 15, NULL, 'C6', 'available'),
(476, 15, NULL, 'C7', 'available'),
(477, 15, NULL, 'C8', 'available'),
(478, 15, NULL, 'C9', 'available'),
(479, 15, NULL, 'D1', 'available'),
(480, 15, NULL, 'D2', 'available'),
(481, 15, NULL, 'D3', 'available'),
(482, 15, NULL, 'D4', 'available'),
(483, 15, NULL, 'D5', 'available'),
(484, 15, NULL, 'D6', 'available'),
(485, 15, NULL, 'D7', 'available'),
(486, 15, NULL, 'D8', 'available'),
(487, 15, NULL, 'D9', 'available'),
(488, 15, NULL, 'E1', 'available'),
(489, 15, NULL, 'E2', 'available'),
(490, 15, NULL, 'E3', 'available'),
(491, 15, NULL, 'E4', 'available'),
(492, 15, NULL, 'E5', 'available'),
(493, 16, NULL, 'A1', 'available'),
(494, 16, NULL, 'A2', 'available'),
(495, 16, NULL, 'A3', 'available'),
(496, 16, NULL, 'A4', 'available'),
(497, 16, NULL, 'A5', 'available'),
(498, 16, NULL, 'A6', 'available'),
(499, 16, NULL, 'A7', 'available'),
(500, 16, NULL, 'A8', 'available'),
(501, 16, NULL, 'A9', 'available'),
(502, 16, NULL, 'B1', 'available'),
(503, 16, NULL, 'B2', 'available'),
(504, 16, NULL, 'B3', 'available'),
(505, 16, NULL, 'B4', 'available'),
(506, 16, NULL, 'B5', 'available'),
(507, 16, NULL, 'B6', 'available'),
(508, 16, NULL, 'B7', 'available'),
(509, 16, NULL, 'B8', 'available'),
(510, 16, NULL, 'B9', 'available'),
(511, 16, NULL, 'C1', 'available'),
(512, 16, NULL, 'C2', 'available'),
(513, 16, NULL, 'C3', 'available'),
(514, 16, NULL, 'C4', 'available'),
(515, 16, NULL, 'C5', 'available'),
(516, 16, NULL, 'C6', 'available'),
(517, 16, NULL, 'C7', 'available'),
(518, 16, NULL, 'C8', 'available'),
(519, 16, NULL, 'C9', 'available'),
(520, 16, NULL, 'D1', 'available'),
(521, 16, NULL, 'D2', 'available'),
(522, 16, NULL, 'D3', 'available'),
(523, 16, NULL, 'D4', 'available'),
(524, 16, NULL, 'D5', 'available'),
(525, 16, NULL, 'D6', 'available'),
(526, 16, NULL, 'D7', 'available'),
(527, 16, NULL, 'D8', 'available'),
(528, 16, NULL, 'D9', 'available'),
(529, 16, NULL, 'E1', 'available'),
(530, 16, NULL, 'E2', 'available'),
(531, 16, NULL, 'E3', 'available'),
(532, 16, NULL, 'E4', 'available'),
(533, 16, NULL, 'E5', 'available'),
(534, 17, NULL, 'A1', 'available'),
(535, 17, NULL, 'A2', 'available'),
(536, 17, NULL, 'A3', 'available'),
(537, 17, NULL, 'A4', 'available'),
(538, 17, NULL, 'A5', 'available'),
(539, 17, NULL, 'A6', 'available'),
(540, 17, NULL, 'A7', 'available'),
(541, 17, NULL, 'A8', 'available'),
(542, 17, NULL, 'A9', 'available'),
(543, 17, NULL, 'A10', 'available'),
(544, 17, NULL, 'A11', 'available'),
(545, 17, NULL, 'A12', 'available'),
(546, 17, NULL, 'A13', 'available'),
(547, 17, NULL, 'A14', 'available'),
(548, 17, NULL, 'A15', 'available'),
(549, 17, NULL, 'A16', 'available'),
(550, 17, NULL, 'B1', 'available'),
(551, 17, NULL, 'B2', 'available'),
(552, 17, NULL, 'B3', 'available'),
(553, 17, NULL, 'B4', 'available'),
(554, 17, NULL, 'B5', 'available'),
(555, 17, NULL, 'B6', 'available'),
(556, 17, NULL, 'B7', 'available'),
(557, 17, NULL, 'B8', 'available'),
(558, 17, NULL, 'B9', 'available'),
(559, 17, NULL, 'B10', 'available'),
(560, 17, NULL, 'B11', 'available'),
(561, 17, NULL, 'B12', 'available'),
(562, 17, NULL, 'B13', 'available'),
(563, 17, NULL, 'B14', 'available'),
(564, 17, NULL, 'B15', 'available'),
(565, 17, NULL, 'B16', 'available'),
(566, 17, NULL, 'C1', 'available'),
(567, 17, NULL, 'C2', 'available'),
(568, 17, NULL, 'C3', 'available'),
(569, 17, NULL, 'C4', 'available'),
(570, 17, NULL, 'C5', 'available'),
(571, 4, NULL, 'A1', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','completed','failed') NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `departure_city` varchar(100) NOT NULL,
  `destination_city` varchar(100) NOT NULL,
  `travel_time` enum('day','night') NOT NULL,
  `date` date DEFAULT NULL,
  `bussno` varchar(50) DEFAULT NULL,
  `priceperseat` int(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `departure_city`, `destination_city`, `travel_time`, `date`, `bussno`, `priceperseat`, `created_at`) VALUES
(16, 'Dhangadi', 'Biratnagar', 'night', '2024-09-23', 'Ra 3 Kha 3001', 2000, '2024-08-23 16:08:19'),
(17, 'Biratnagar', 'Dhangadi', 'night', '2024-08-24', 'Ra 3 Kha 3002', 2000, '2024-08-23 18:39:56'),
(18, 'palpa', 'kathmandu', 'night', '2024-08-26', 'Lu 2 kha 1403', 1300, '2024-08-23 21:12:12'),
(19, 'palpa', 'kathmandu', 'night', '2024-09-23', 'Lu 2 kha 1403', 1300, '2024-08-23 21:12:19'),
(20, 'kathmandu', 'butwal', 'night', '2024-08-26', 'Lu 4 Kha 2002', 1200, '2024-08-24 03:27:15'),
(21, 'Kathmandu', 'Jhapa', 'night', '2024-08-26', 'Ko 1 Kha 9999', 1500, '2024-08-24 16:20:57'),
(22, 'Kathmandu', 'Jhapa', 'night', '2024-08-26', 'Me 3 kha 8888', 1450, '2024-08-24 16:21:43'),
(23, 'Jhapa', 'Kathmandu', 'night', '2024-08-26', 'Ko 1 Kha 1000', 1500, '2024-08-24 16:23:33'),
(24, 'Jhapa', 'Kathmandu', 'night', '2024-08-26', 'Me 4 kha 1111', 1450, '2024-08-24 16:24:10'),
(25, 'Jhapa', 'Kathmandu', 'night', '2024-08-26', 'Me 4 kha 1111', 1450, '2024-08-24 16:24:23'),
(26, 'kathmandu', 'Palpa', 'night', '2024-09-24', 'Lu 4 Kha 429', 1300, '2024-09-22 16:15:30'),
(27, 'Butwal', 'Kathmandu', 'night', '2024-09-25', 'Lu 4 Kha 0003', 1200, '2024-09-24 04:46:51'),
(28, 'Kathmandu', 'Bhairahawa', 'day', '2024-09-26', 'Ba 8 Kha 5001', 1500, '2024-09-25 05:00:30');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_list`
--

CREATE TABLE `schedule_list` (
  `id` int(11) NOT NULL,
  `bus_id` int(11) NOT NULL,
  `from_location` int(11) NOT NULL,
  `to_location` int(11) NOT NULL,
  `departure_time` datetime NOT NULL,
  `eta` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `availability` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule_list`
--

INSERT INTO `schedule_list` (`id`, `bus_id`, `from_location`, `to_location`, `departure_time`, `eta`, `status`, `availability`, `price`, `date_updated`) VALUES
(2, 5, 18, 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 1300.00, '2024-09-23 20:27:32'),
(3, 4, 27, 27, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 1200.00, '2024-09-24 04:51:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `user_type` tinyint(1) NOT NULL DEFAULT 1,
  `username` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(250) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user_type`, `username`, `email`, `password`, `status`, `date_updated`) VALUES
(1, 'Dhiraj Rana', 0, 'Dhiraj', 'dhiraj12@gmail.com', '$2y$10$tV3cfvzor9QZgQgSI5VOF.8kPlqYGrBzIX/a8/WtDauJpelDL/6Dm', 1, '2024-09-22 21:34:09'),
(14, 'Laxmi Deluxe', 0, 'laxmi', 'laxmi123@gmail.com', '$2y$10$toYaXHINiTqY2eRUYhMOwOqhKZRG83BeF1EEPP.t2IWKcLg1ravL.', 1, '2024-08-23 15:49:24'),
(16, 'sita kumari', 1, 'sita', 'sitakumari123@gmail.com', '$2y$10$WaqJvuXD0HqERui4.uHNBeRITdoLB2kcRmTp.N4PL8NHzRQYlNlCK', 1, '2024-08-23 15:49:13'),
(17, 'Binayak Basyal', 0, 'binayak123', 'binayak@gmail.com', '$2y$10$krMjhrbdB.0rA7tqIZeFO.s7RlR/OZhx7HcT6C7bEKqyiHX.DGisC', 1, '2024-08-24 02:32:45'),
(18, 'Ram Bhujel', 0, 'Ram', 'ram123@gmail.com', '$2y$10$.c4otVPfDOrZxVnuuvmx4OtQtDxvpbcySWzHbC7g09F/bPGlLw/ty', 1, '2024-08-24 09:05:47'),
(19, 'Laxman Pathak', 0, 'Laxman', 'laxman123@gmail.com', '$2y$10$U9vbU0aergvZfVqp.kIKQ.JdgsvDQ4Nnq7zx7fRMkQGPzeiFGxGLu', 1, '2024-08-24 22:13:11'),
(21, '', 0, 'bishal', 'bishal123@gmail.com', '$2y$10$InMBxudVQUt/YToxGVfJg.UzFO8zW/5BnDT7a3vhpAEDzkijdNQhK', 1, '2024-09-24 10:26:20'),
(22, '', 0, 'Manish ', 'manish12@gmail.com', '$2y$10$0VzaRJ5TvaHCPbXXzj4JROifh1PvA2E1B0hX.beDvyB.8HHHnu49i', 1, '2024-09-24 10:10:38'),
(23, 'Lokendra Joshi', 0, 'lokendra', 'lokendra12@gmail.com', '$2y$10$XmDxiiA9y6/PptQi9PyQfOJ/CBbKXYIqTVt.cdSBNBqYU3aRpfX3.', 1, '2024-09-24 21:06:23'),
(24, 'Hari Prasad', 0, 'hari', 'hari2@gmail.com', '$2y$10$TfvPThFYNElqgM.yArq6bO3QStCV6.7gK/c1zorY.lmyhitc6z1fO', 1, '2024-09-25 09:50:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `bus_id` (`bus_id`),
  ADD KEY `route_id` (`route_id`);

--
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bus_number` (`bus_number`);

--
-- Indexes for table `bus_seats`
--
ALTER TABLE `bus_seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_list`
--
ALTER TABLE `schedule_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`),
  ADD KEY `from_location` (`from_location`),
  ADD KEY `to_location` (`to_location`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `buses`
--
ALTER TABLE `buses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `bus_seats`
--
ALTER TABLE `bus_seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=572;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `schedule_list`
--
ALTER TABLE `schedule_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`bus_id`) REFERENCES `buses` (`id`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`);

--
-- Constraints for table `bus_seats`
--
ALTER TABLE `bus_seats`
  ADD CONSTRAINT `bus_seats_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `buses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`);

--
-- Constraints for table `schedule_list`
--
ALTER TABLE `schedule_list`
  ADD CONSTRAINT `schedule_list_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `buses` (`id`),
  ADD CONSTRAINT `schedule_list_ibfk_2` FOREIGN KEY (`from_location`) REFERENCES `routes` (`id`),
  ADD CONSTRAINT `schedule_list_ibfk_3` FOREIGN KEY (`to_location`) REFERENCES `routes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
