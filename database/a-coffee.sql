-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2025 at 01:30 PM
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
-- Database: `a-coffee`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `uid` varchar(11) NOT NULL,
  `log` varchar(999) NOT NULL,
  `datetime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `uid`, `log`, `datetime`) VALUES
(1, 'CA00001', 'You added an order.', '11-17-2024 09:03:36'),
(2, 'CA00001', 'You added an order.', '11-17-2024 09:05:02'),
(3, 'CA00001', 'You added an order.', '11-17-2024 09:08:10'),
(4, 'CA00001', 'You deleted an order.', '11-17-2024 02:31:49'),
(5, 'CA00001', 'You updated your profile.', '11-17-2024 02:49:26'),
(6, 'CA00001', 'You logged in your account.', '11-17-2024 09:53:25'),
(7, 'CA00001', 'You logged in your account.', '11-17-2024 09:53:47'),
(8, 'CA00001', 'You marked order 62 as done.', '11-17-2024 10:27:35'),
(9, 'CA00001', 'You updated large cup information in inventory', '11-17-2024 10:28:55'),
(10, 'CA00001', 'You logged out your account.', '11-17-2024 10:36:18'),
(11, 'CA00001', 'You logged out your account.', '11-17-2024 10:40:08'),
(12, 'CA00001', 'You logged in your account.', '11-17-2024 10:40:20'),
(13, 'CA00001', 'You marked order 61 as done.', '11-17-2024 10:40:30'),
(14, 'CA00001', 'You marked order 60 as done.', '11-17-2024 10:40:32'),
(15, 'CA00001', 'You marked order 59 as done.', '11-17-2024 10:40:35'),
(16, 'CA00001', 'You deleted the order 60.', '11-17-2024 10:42:41'),
(17, 'CA00001', 'You deleted the order 59.', '11-17-2024 10:42:43'),
(18, 'CA00001', 'You deleted the order 58.', '11-17-2024 10:42:47'),
(19, 'CA00001', 'You deleted the order 57.', '11-17-2024 10:42:48'),
(20, 'CA00001', 'You deleted the order 56.', '11-17-2024 10:42:49'),
(21, 'CA00001', 'You deleted the order 55.', '11-17-2024 10:42:51'),
(22, 'CA00001', 'You added an order.', '11-17-2024 10:54:44'),
(23, 'CA00001', 'You marked order 64 as done.', '11-17-2024 10:57:14'),
(24, 'CA00001', 'You deleted order 64.', '11-17-2024 10:57:26'),
(25, 'CA00001', 'You added an order.', '11-17-2024 11:13:14'),
(26, 'CA00001', 'You marked order 65 as done.', '11-17-2024 11:13:19'),
(27, 'CA00001', 'You logged in your account.', '11-17-2024 11:42:55'),
(28, 'CA00001', 'You added an order.', '11-17-2024 11:43:32'),
(29, 'CA00001', 'You deleted order 65.', '11-17-2024 11:43:42'),
(30, 'CA00001', 'You deleted order 66.', '11-17-2024 11:43:43'),
(31, 'CA00001', 'You added an order.', '11-17-2024 11:43:49'),
(32, 'CA00001', 'You marked order 67 as done.', '11-17-2024 11:43:54'),
(33, 'CA00001', 'You logged out your account.', '11-17-2024 11:45:58'),
(34, 'CA00000', 'You logged in your account.', '11-17-2024 11:46:02'),
(41, 'CA00001', 'You logged out your account.', '11-17-2024 11:52:33'),
(42, 'CA00000', 'You logged in your account.', '11-17-2024 11:54:37'),
(43, 'CA00000', 'You logged out your account.', '11-18-2024 01:19:30'),
(44, 'CA00001', 'You logged in your account.', '11-18-2024 01:19:34'),
(45, 'CA00001', 'You logged in your account.', '11-18-2024 03:17:51'),
(46, 'CA00001', 'You deleted a product.', '11-18-2024 04:01:30'),
(47, 'CA00001', 'You deleted a product.', '11-18-2024 04:04:38'),
(48, 'CA00001', 'You deleted a product.', '11-18-2024 04:05:17'),
(49, 'CA00001', 'You logged in your account.', '11-18-2024 08:35:46'),
(50, 'CA00001', 'You logged in your account.', '11-19-2024 03:06:14'),
(51, 'CA00001', 'You deleted a product.', '11-19-2024 03:06:32'),
(52, 'CA00001', 'You deleted a product.', '11-19-2024 03:06:34'),
(53, 'CA00001', 'You deleted a product.', '11-19-2024 03:06:37'),
(54, 'CA00001', 'You deleted a product.', '11-19-2024 03:42:29'),
(55, 'CA00001', 'You deleted a product.', '11-19-2024 03:42:31'),
(56, 'CA00001', 'You deleted a product.', '11-19-2024 03:42:33'),
(57, 'CA00001', 'You deleted a product.', '11-19-2024 03:42:35'),
(58, 'CA00001', 'You deleted a product.', '11-19-2024 03:42:36'),
(59, 'CA00001', 'You logged in your account.', '11-19-2024 07:50:39'),
(60, 'CA00001', 'You logged in your account.', '11-20-2024 11:08:47'),
(61, 'CA00001', 'You deleted a product.', '11-20-2024 12:53:08'),
(62, 'CA00001', 'You deleted a product.', '11-20-2024 12:53:10'),
(63, 'CA00001', 'You deleted a product.', '11-20-2024 01:15:07'),
(64, 'CA00001', 'You deleted a product.', '11-20-2024 01:15:09'),
(65, 'CA00001', 'You deleted a product.', '11-20-2024 01:15:10'),
(66, 'CA00001', 'You deleted a product.', '11-20-2024 01:15:11'),
(67, 'CA00001', 'You deleted a product.', '11-20-2024 01:15:23'),
(68, 'CA00001', 'You logged in your account.', '11-20-2024 03:04:23'),
(69, 'CA00001', 'You logged in your account.', '11-20-2024 09:34:13'),
(74, 'AC00001', 'You added new category: dasds', '01-15-2025 03:19:18'),
(75, 'AC00001', 'Aiah Arceta updated a product: Blueberry', '01-18-2025 23:01:39'),
(76, 'AC00001', 'Aiah Arceta updated a product: Blueberry', '01-18-2025 23:01:49'),
(77, 'AC00001', 'Aiah Arceta updated the category: Foodss', '01-18-2025 23:09:26'),
(78, 'AC00001', 'Aiah Arceta updated the category: Foods', '01-18-2025 23:09:34'),
(79, 'AC00001', 'Aiah Arceta updated Pineapple information.', '01-19-2025 01:12:59'),
(80, 'AC00001', 'Aiah Arceta updated Pineapple information.', '01-19-2025 01:13:20'),
(81, 'AC00001', 'Aiah Arceta added a new item: test.', '01-19-2025 01:14:23'),
(82, 'AC00001', 'Aiah Arceta added a new item: test.', '01-19-2025 01:16:14'),
(83, 'AC00001', 'Aiah Arceta updated test information.', '01-19-2025 01:20:05'),
(84, 'AC00001', 'Aiah Arceta added a new item: test1.', '01-19-2025 01:20:16'),
(85, 'AC00001', 'Aiah Arceta deleted a item in inventory: Test1.', '01-19-2025 01:20:26'),
(86, 'AC00001', 'Aiah Arceta deleted a item in inventory: Test.', '01-19-2025 01:20:29'),
(87, 'AC00001', 'Aiah Arceta added a new item: test3.', '01-19-2025 01:20:49'),
(88, 'AC00001', 'Aiah Arceta deleted a item in inventory: Test3.', '01-19-2025 01:20:54'),
(89, 'AC00001', 'Aiah Arceta added new category: Food', '01-19-2025 01:21:51'),
(90, 'AC00001', 'Aiah Arceta updated Pineapple information.', '01-19-2025 01:22:31'),
(91, 'AC00001', 'Aiah Arceta updated Pineapple\'s quantity: 10ml.', '01-19-2025 01:22:31'),
(92, 'AC00001', 'Aiah Arceta added a new product: test', '01-19-2025 01:23:54'),
(93, 'AC00001', 'Aiah Arceta deleted an order: 106.', '01-19-2025 01:46:21'),
(96, 'AC00001', 'Aiah Arceta order placed(131): 1 Ube Frappe (12oz)', '01-19-2025 02:40:28'),
(97, 'AC00001', 'Aiah Arceta order placed(132): 1 Ube Frappe (12oz)', '01-19-2025 02:41:41'),
(98, 'AC00001', 'Aiah Arceta order placed(133): 1 Ube Frappe (12oz)', '01-19-2025 02:41:53'),
(99, 'AC00001', 'Aiah Arceta deleted an order: 113.', '01-19-2025 02:42:02'),
(100, 'AC00001', 'Aiah Arceta deleted an order: 114.', '01-19-2025 02:42:03'),
(101, 'AC00001', 'Aiah Arceta deleted an order: 119.', '01-19-2025 02:42:06'),
(102, 'AC00001', 'Aiah Arceta deleted an order: 120.', '01-19-2025 02:42:08'),
(103, 'AC00001', 'Aiah Arceta deleted an order: 131.', '01-19-2025 02:42:10'),
(104, 'AC00001', 'Aiah Arceta deleted an order: 132.', '01-19-2025 02:42:11'),
(105, 'AC00001', 'Aiah Arceta deleted an order: 118.', '01-19-2025 02:42:13'),
(106, 'AC00001', 'Aiah Arceta deleted an order: 133.', '01-19-2025 02:42:15'),
(107, 'AC00001', 'Aiah Arceta order placed(134): 1 Blueberries and Cream Frappe (12oz) (Hot)', '01-19-2025 02:42:26'),
(108, 'AC00001', 'Rolly Raytos updated staff information: Aiah Arceta', '01-19-2025 03:31:49'),
(109, 'AC00001', 'Aiah Arceta logged in.', '01-19-2025 03:35:53'),
(110, 'AC00001', 'Aiah Arceta logged in.', '01-19-2025 14:50:55'),
(111, 'AC00001', 'Aiah Arceta logged out.', '01-19-2025 14:55:32'),
(112, 'AC00000', 'Rolly Raytos logged in.', '01-19-2025 14:56:15'),
(113, 'AC00000', 'Rolly Raytos logged out.', '01-19-2025 16:12:07'),
(114, 'AC00001', 'Aiah Arceta logged in.', '01-19-2025 16:12:10'),
(115, 'AC00001', 'Aiah Arceta updated the category: Foods', '01-19-2025 17:08:28'),
(116, 'AC00000', 'Rolly Raytos logged in.', '01-19-2025 19:47:36'),
(117, 'AC00000', 'Rolly Raytos logged out.', '01-19-2025 20:18:35'),
(118, 'AC00001', 'Aiah Arceta logged in.', '01-19-2025 20:18:38'),
(119, 'AC00001', 'Aiah Arceta order placed(135): 1 Matcha Latte (Regular) (Hot)', '01-19-2025 20:18:56'),
(120, 'AC00001', 'Aiah Arceta marked order 135 as done.', '01-19-2025 20:19:00'),
(121, 'AC00001', 'Aiah Arceta logged out.', '01-19-2025 20:54:26'),
(122, 'AC00000', 'Rolly Raytos logged in.', '01-19-2025 20:54:29'),
(123, 'AC00000', 'Rolly Raytos logged out.', '01-19-2025 21:36:33'),
(124, 'AC00001', 'Aiah Arceta logged in.', '01-19-2025 21:36:47'),
(125, 'AC00001', 'Aiah Arceta added a new item: White Milk.', '01-19-2025 21:37:42'),
(126, 'AC00001', 'Aiah Arceta deleted an item in inventory: White Milk.', '01-19-2025 21:37:51'),
(127, 'AC00001', 'Aiah Arceta added new category: Frappuccino', '01-19-2025 21:38:17'),
(128, 'AC00001', 'Aiah Arceta deleted an item in inventory: Pineapple.', '01-19-2025 21:40:04'),
(129, 'AC00001', 'Aiah Arceta logged out.', '01-19-2025 21:41:56'),
(130, 'AC00001', 'Aiah Arceta logged in.', '01-19-2025 21:42:05'),
(131, 'AC00001', 'Aiah Arceta added a new item: 12oz cup.', '01-19-2025 21:42:32'),
(132, 'AC00001', 'Aiah Arceta deleted an item in inventory: 12oz Cup.', '01-19-2025 21:42:48'),
(133, 'AC00001', 'Aiah Arceta added new category: Salad', '01-19-2025 21:43:08'),
(134, 'AC00001', 'Aiah Arceta updated the category: Saladd', '01-19-2025 21:43:11'),
(135, 'AC00001', 'Aiah Arceta order placed(136): 3 Caramel Latte (Regular) (Hot), 2 Passion Fruit (12oz) (Ice)', '01-19-2025 21:44:58'),
(136, 'AC00001', 'Aiah Arceta marked order 136 as done.', '01-19-2025 21:45:10'),
(137, 'AC00001', 'Aiah Arceta logged out.', '01-19-2025 21:45:53'),
(138, 'AC00000', 'Rolly Raytos logged in.', '01-19-2025 21:45:56'),
(139, 'AC00000', 'Rolly Raytos logged out.', '01-19-2025 21:47:25'),
(140, 'AC00001', 'Aiah Arceta logged in.', '01-19-2025 21:47:29'),
(141, 'AC00001', 'Aiah Arceta logged out.', '01-19-2025 21:47:41'),
(142, 'AC00001', 'Aiah Arceta logged in.', '01-19-2025 21:55:57'),
(143, 'AC00001', 'Aiah Arceta updated a product: Blueberry', '01-19-2025 22:37:23'),
(144, 'AC00001', 'Aiah Arceta order placed(137): 1 Blueberry (16oz)', '01-19-2025 22:37:41'),
(145, 'AC00001', 'Aiah Arceta marked order 137 as done.', '01-19-2025 22:38:35'),
(146, 'AC00001', 'Aiah Arceta logged in.', '01-19-2025 23:18:04'),
(147, 'AC00001', 'Aiah Arceta logged in.', '01-19-2025 23:44:01'),
(148, 'AC00001', 'Aiah Arceta order placed(138): 1 Strawberry (Regular)', '01-19-2025 23:45:41'),
(149, 'AC00001', 'Aiah Arceta marked order 138 as done.', '01-19-2025 23:45:55'),
(150, 'AC00001', 'Aiah Arceta updated the category: Salad', '01-19-2025 23:46:02'),
(151, 'AC00001', 'Aiah Arceta deleted a category: Salad.', '01-19-2025 23:48:57'),
(152, 'AC00001', 'Aiah Arceta deleted a category: Frappuccino.', '01-19-2025 23:49:14'),
(153, 'AC00001', 'Aiah Arceta logged out.', '01-19-2025 23:51:09'),
(154, 'AC00001', 'Aiah Arceta logged in.', '01-20-2025 20:47:57'),
(155, 'AC00001', 'Aiah Arceta logged in.', '01-22-2025 00:39:38'),
(156, 'AC00001', 'Aiah Arceta logged in.', '01-22-2025 00:58:58'),
(157, 'AC00001', 'Aiah Arceta order placed(139): 1 Passion Fruit (12oz)', '01-22-2025 01:48:08'),
(158, 'AC00001', 'Aiah Arceta order placed(140): 1 Green Apple (16oz), 1 Blueberry (12oz)', '01-22-2025 01:48:48'),
(159, 'AC00001', 'Aiah Arceta order placed(141): 1 Blueberry (12oz)', '01-22-2025 01:49:20'),
(160, 'AC00001', 'Aiah Arceta order placed(142): 1 Blueberry (12oz)', '01-22-2025 01:52:02'),
(161, 'AC00001', 'Aiah Arceta order placed(143): 1 Blueberry (16oz)', '01-22-2025 01:53:41'),
(162, 'AC00001', 'Aiah Arceta order placed(144): 1 Passion Fruit (12oz)', '01-22-2025 01:56:57'),
(163, 'AC00001', 'Aiah Arceta order placed(145): 1 Blueberry (12oz), 1 Passion Fruit (12oz)', '01-22-2025 02:10:56'),
(164, 'AC00001', 'Aiah Arceta order placed(146): 1 Blueberry (12oz)', '01-22-2025 02:15:21'),
(165, 'AC00001', 'Aiah Arceta logged out.', '01-22-2025 03:04:38'),
(166, 'AC00001', 'Aiah Arceta logged in.', '01-22-2025 03:05:03'),
(167, 'AC00001', 'Aiah Arceta order placed(147): 1 Vanilla Frappe (12oz), 1 Caramel Macchiato (Regular)', '01-22-2025 03:09:10'),
(168, 'AC00001', 'Aiah Arceta order placed(148): 1 Spanish Latte (Regular), 1 Caramel Macchiato Frappe (Regular)', '01-22-2025 03:45:07'),
(169, 'AC00001', 'Aiah Arceta order placed(149): 1 Matcha Frappe (12oz)', '01-22-2025 03:45:37'),
(170, 'AC00001', 'Aiah Arceta order placed(150): 1 Vanilla Frappe (12oz), 1 Vanilla Frappe (12oz)', '01-22-2025 03:46:29'),
(171, 'AC00001', 'Aiah Arceta order placed(151): 1 Matcha Frappe (12oz), 1 Caramel Macchiato Frappe (Regular)', '01-22-2025 03:48:53'),
(172, 'AC00001', 'Aiah Arceta order placed(152): 1 Double Chocolate Frappe (12oz), 1 Brown Sugar Latte (Regular), 1 Java Chip Frappe (12oz)', '01-22-2025 04:22:48'),
(173, 'AC00001', 'Aiah Arceta order placed(153): 1 Caramel Macchiato (Regular)', '01-22-2025 04:31:42'),
(174, 'AC00001', 'Aiah Arceta updated Vanilla Syrup information.', '01-22-2025 04:37:59'),
(175, 'AC00001', 'Aiah Arceta updated Vanilla Syrup\'s quantity: 1L.', '01-22-2025 04:37:59'),
(176, 'AC00001', 'Aiah Arceta updated Vanilla Syrup information.', '01-22-2025 04:38:39'),
(177, 'AC00001', 'Aiah Arceta updated Vanilla Syrup\'s quantity: 1L.', '01-22-2025 04:38:39'),
(178, 'AC00001', 'Aiah Arceta updated Vanilla Syrup information.', '01-22-2025 04:39:06'),
(179, 'AC00001', 'Aiah Arceta updated Vanilla Syrup\'s quantity: 1l.', '01-22-2025 04:39:06'),
(180, 'AC00001', 'Aiah Arceta logged in.', '01-22-2025 14:59:34'),
(181, 'AC00001', 'Aiah Arceta logged in.', '01-22-2025 15:23:00'),
(182, 'AC00001', 'Aiah Arceta updated Vanilla Syrup information.', '01-22-2025 15:23:52'),
(183, 'AC00001', 'Aiah Arceta updated Vanilla Syrup\'s quantity: 1L.', '01-22-2025 15:23:52'),
(184, 'AC00001', 'Aiah Arceta updated Vanilla Syrup information.', '01-22-2025 15:25:05'),
(185, 'AC00001', 'Aiah Arceta updated Vanilla Syrup\'s quantity: 1L.', '01-22-2025 15:25:05'),
(186, 'AC00001', 'Aiah Arceta updated Vanilla Syrup information.', '01-22-2025 15:30:31'),
(187, 'AC00001', 'Aiah Arceta updated Vanilla Syrup\'s quantity: 1L.', '01-22-2025 15:30:31'),
(188, 'AC00001', 'Aiah Arceta updated Vanilla Syrup information.', '01-22-2025 15:32:26'),
(189, 'AC00001', 'Aiah Arceta updated Vanilla Syrup\'s quantity: 1L.', '01-22-2025 15:32:26'),
(190, 'AC00001', 'Aiah Arceta updated Vanilla Syrup information.', '01-22-2025 15:33:44'),
(191, 'AC00001', 'Aiah Arceta updated Vanilla Syrup\'s quantity: 1L.', '01-22-2025 15:33:44'),
(192, 'AC00001', 'Aiah Arceta updated Instant Coffee information.', '01-22-2025 15:37:42'),
(193, 'AC00001', 'Aiah Arceta updated Instant Coffee\'s quantity: 1KG.', '01-22-2025 15:37:42'),
(194, 'AC00001', 'Aiah Arceta updated a product: Vanilla Latte', '01-22-2025 15:59:03'),
(195, 'AC00001', 'Aiah Arceta updated a product: Vanilla Latte', '01-22-2025 16:06:32'),
(196, 'AC00001', 'Aiah Arceta updated a product: Vanilla Latte', '01-22-2025 16:11:20'),
(197, 'AC00001', 'Aiah Arceta added a new product: Cappu', '01-22-2025 16:12:32'),
(198, 'AC00001', 'Aiah Arceta updated a product: Cappu', '01-22-2025 16:14:28'),
(199, 'AC00001', 'Aiah Arceta order placed(154): 1  ', '01-22-2025 16:24:49'),
(200, 'AC00001', 'Aiah Arceta deleted a product: .', '01-22-2025 16:26:36'),
(201, 'AC00001', 'Aiah Arceta added a new product: Cappu', '01-22-2025 16:26:54'),
(202, 'AC00001', 'Aiah Arceta updated a product: Cappu', '01-22-2025 16:27:04'),
(203, 'AC00001', 'Aiah Arceta updated a product: Hazelnut Latte', '01-22-2025 16:30:57'),
(204, 'AC00001', 'Aiah Arceta updated a product: Hazelnut Latte', '01-22-2025 16:32:46'),
(205, 'AC00001', 'Aiah Arceta updated a product: Cappu', '01-22-2025 16:33:14'),
(206, 'AC00001', 'Aiah Arceta updated a product: Cappu', '01-22-2025 16:36:09'),
(207, 'AC00001', 'Aiah Arceta updated a product: Cappu', '01-22-2025 16:36:27'),
(208, 'AC00001', 'Aiah Arceta added a new product: erewr', '01-22-2025 16:49:33'),
(209, 'AC00001', 'Aiah Arceta updated a product: erewr', '01-22-2025 16:53:27'),
(210, 'AC00001', 'Aiah Arceta added a new product: terst', '01-22-2025 16:53:43'),
(211, 'AC00001', 'Aiah Arceta deleted a product: .', '01-22-2025 16:56:04'),
(212, 'AC00001', 'Aiah Arceta added a new product: test', '01-22-2025 16:56:15'),
(213, 'AC00001', 'Aiah Arceta deleted a product: .', '01-22-2025 16:57:29'),
(214, 'AC00001', 'Aiah Arceta added a new product: test', '01-22-2025 16:57:38'),
(215, 'AC00001', 'Aiah Arceta updated a product: test', '01-22-2025 16:57:45'),
(216, 'AC00001', 'Aiah Arceta deleted a product: .', '01-22-2025 16:57:54'),
(217, 'AC00001', 'Aiah Arceta updated a product: erewr', '01-22-2025 17:02:35'),
(218, 'AC00001', 'Aiah Arceta order placed(155): 1  ', '01-22-2025 17:04:19'),
(219, 'AC00001', 'Aiah Arceta order placed(156): 1 Mocha Latte (Regular)', '01-22-2025 17:05:12'),
(220, 'AC00001', 'Aiah Arceta order placed(157): 1 erewr ', '01-22-2025 17:06:39'),
(221, 'AC00001', 'Aiah Arceta deleted a product: .', '01-22-2025 17:25:43'),
(222, 'AC00001', 'Aiah Arceta added a new product: test', '01-22-2025 17:27:42'),
(223, 'AC00001', 'Aiah Arceta updated a product: test', '01-22-2025 17:27:55'),
(224, 'AC00001', 'Aiah Arceta updated a product: White Chocolate Mocha', '01-22-2025 17:28:16'),
(225, 'AC00001', 'Aiah Arceta updated a product: Butterscotch Latte', '01-22-2025 17:28:22'),
(226, 'AC00001', 'Aiah Arceta updated a product: Salted Caramel Latte', '01-22-2025 17:28:30'),
(227, 'AC00001', 'Aiah Arceta updated a product: Biscoff Latte', '01-22-2025 17:28:42'),
(228, 'AC00001', 'Aiah Arceta updated a product: Spiced Latte (Agave)', '01-22-2025 17:28:50'),
(229, 'AC00001', 'Aiah Arceta updated a product: Double Chocolate Frappe', '01-22-2025 17:29:26'),
(230, 'AC00001', 'Aiah Arceta updated a product: Oreo Frappe', '01-22-2025 17:29:32'),
(231, 'AC00001', 'Aiah Arceta updated a product: Vanilla Frappe', '01-22-2025 17:29:36'),
(232, 'AC00001', 'Aiah Arceta updated a product: Mocha Frappe', '01-22-2025 17:29:42'),
(233, 'AC00001', 'Aiah Arceta updated a product: Java Chip Frappe', '01-22-2025 17:29:47'),
(234, 'AC00001', 'Aiah Arceta updated a product: Caramel Macchiato Frappe', '01-22-2025 17:29:54'),
(235, 'AC00001', 'Aiah Arceta updated a product: Matcha Frappe', '01-22-2025 17:29:58'),
(236, 'AC00001', 'Aiah Arceta updated a product: Strawberries and Cream Frappe', '01-22-2025 17:30:04'),
(237, 'AC00001', 'Aiah Arceta updated a product: Blueberries and Cream Frappe', '01-22-2025 17:30:11'),
(238, 'AC00001', 'Aiah Arceta updated a product: Ube Frappe', '01-22-2025 17:30:17'),
(239, 'AC00001', 'Aiah Arceta updated a product: Chocolate Latte', '01-22-2025 17:30:21'),
(240, 'AC00001', 'Aiah Arceta updated a product: Ube Latte', '01-22-2025 17:30:33'),
(241, 'AC00001', 'Aiah Arceta updated a product: Matcha Latte', '01-22-2025 17:30:37'),
(242, 'AC00001', 'Aiah Arceta updated a product: Strawberry Latte', '01-22-2025 17:30:44'),
(243, 'AC00001', 'Aiah Arceta updated a product: Blueberry Latte', '01-22-2025 17:30:48'),
(244, 'AC00001', 'Aiah Arceta updated a product: Green Apple', '01-22-2025 17:30:55'),
(245, 'AC00001', 'Aiah Arceta updated a product: Passion Fruit', '01-22-2025 17:31:02'),
(246, 'AC00001', 'Aiah Arceta updated a product: Strawberry', '01-22-2025 17:31:12'),
(247, 'AC00001', 'Aiah Arceta updated a product: Blueberry', '01-22-2025 17:31:18'),
(248, 'AC00001', 'Aiah Arceta added a new product: test', '01-22-2025 17:31:48'),
(249, 'AC00001', 'Aiah Arceta added a new product: test', '01-22-2025 17:34:33'),
(250, 'AC00001', 'Aiah Arceta deleted a product: .', '01-22-2025 17:34:43'),
(251, 'AC00001', 'Aiah Arceta deleted a product: .', '01-22-2025 17:34:48'),
(252, 'AC00001', 'Aiah Arceta deleted a product: .', '01-22-2025 17:34:50'),
(253, 'AC00001', 'Aiah Arceta updated a product: Cappu', '01-22-2025 17:37:05'),
(254, 'AC00001', 'Aiah Arceta logged out.', '01-22-2025 17:43:25'),
(255, 'AC00000', 'Rolly Raytos logged in.', '01-22-2025 17:43:35'),
(256, 'AC00000', 'Rolly Raytos updated Vanilla Syrup information.', '01-22-2025 17:58:02'),
(257, 'AC00000', 'Rolly Raytos updated Vanilla Syrup\'s quantity: 1KG.', '01-22-2025 17:58:02'),
(258, 'AC00000', 'Rolly Raytos undo the changes of an item: Vanilla Syrup.', '01-22-2025 17:58:07'),
(259, 'AC04158', 'Rolly Raytos updated staff information: Kim Dami', '01-22-2025 17:59:05'),
(260, 'AC00000', 'Rolly Raytos updated staff information: Rolly Raytos', '01-22-2025 17:59:51'),
(261, 'AC39805', 'Rolly Raytos updated staff information: Lamoi', '01-22-2025 18:09:37'),
(262, 'AC00000', 'Rolly Raytos updated staff information: Lamoi', '01-22-2025 18:18:37'),
(263, 'AC00000', 'Rolly Raytos updated staff information: Lamoi', '01-22-2025 18:19:19'),
(264, 'AC00000', 'Rolly Raytos updated staff information: Lamoi', '01-22-2025 18:19:31'),
(265, 'AC49132', 'Rolly Raytos added a new staff: test', '01-22-2025 18:19:47'),
(266, 'AC00000', 'Rolly Raytos deleted a user: Test.', '01-22-2025 18:19:55'),
(267, 'AC00000', 'Rolly Raytos deleted a user: Test.', '01-22-2025 18:20:11'),
(268, 'AC00000', 'Rolly Raytos deleted a user: Test.', '01-22-2025 18:22:18'),
(269, 'AC00000', 'Rolly Raytos deleted a user: Test.', '01-22-2025 18:23:14'),
(270, 'AC22791', 'Rolly Raytos added a new staff: ', '01-22-2025 18:26:14'),
(271, 'AC00000', 'Rolly Raytos deleted a user: .', '01-22-2025 18:26:18'),
(272, 'AC00001', 'Aiah Arceta logged in.', '01-22-2025 21:58:57'),
(273, 'AC00001', 'Aiah Arceta order placed(158): 1 Blueberry Latte (12oz)', '01-22-2025 22:01:04'),
(274, 'AC00001', 'Aiah Arceta added new category: ', '01-22-2025 22:04:37'),
(275, 'AC00001', 'Aiah Arceta deleted a category: .', '01-22-2025 22:04:40'),
(276, 'AC00001', 'Aiah Arceta added new category: d', '01-22-2025 22:09:11'),
(277, 'AC00001', 'Aiah Arceta deleted a category: D.', '01-22-2025 22:09:15'),
(278, 'AC00001', 'Aiah Arceta added a new item: .', '01-22-2025 22:10:02'),
(279, 'AC00001', 'Aiah Arceta deleted an item in inventory: .', '01-22-2025 22:10:09'),
(280, 'AC00001', 'Aiah Arceta added a new item: .', '01-22-2025 22:11:02'),
(281, 'AC00001', 'Aiah Arceta deleted an item in inventory: .', '01-22-2025 22:11:05'),
(282, 'AC00001', 'Aiah Arceta added a new product: ', '01-22-2025 22:21:11'),
(283, 'AC00001', 'Aiah Arceta deleted a product: .', '01-22-2025 22:21:18'),
(284, 'AC00001', 'Aiah Arceta added a new product: test', '01-22-2025 22:25:06'),
(285, 'AC00001', 'Aiah Arceta deleted a product: Test.', '01-22-2025 22:25:11'),
(286, 'AC00001', 'Aiah Arceta added a new product: test', '01-22-2025 22:25:17'),
(287, 'AC00001', 'Aiah Arceta deleted a product: Test.', '01-22-2025 22:25:24'),
(288, 'AC00001', 'Aiah Arceta logged out.', '01-22-2025 22:28:54'),
(289, 'AC00000', 'Rolly Raytos logged in.', '01-22-2025 22:28:58'),
(290, 'AC53912', 'Rolly Raytos added a new staff: test', '01-22-2025 22:53:04'),
(291, 'AC00000', 'Rolly Raytos updated staff information: test', '01-22-2025 23:04:37'),
(292, 'AC00000', 'Rolly Raytos updated staff information: test', '01-22-2025 23:05:06'),
(293, 'AC00000', 'Rolly Raytos updated staff information: test', '01-22-2025 23:10:03'),
(294, 'AC00000', 'Rolly Raytos updated staff information: test', '01-22-2025 23:10:11'),
(295, 'AC39867', 'Rolly Raytos added a new staff: test', '01-22-2025 23:11:14'),
(296, 'AC00000', 'Rolly Raytos updated staff information: test', '01-22-2025 23:11:33'),
(297, 'AC00000', 'Rolly Raytos deleted a user: Test.', '01-22-2025 23:21:49'),
(298, 'AC00000', 'Rolly Raytos updated staff information: test', '01-22-2025 23:22:49'),
(299, 'AC00000', 'Rolly Raytos updated staff information: Kim Dami', '01-22-2025 23:29:20'),
(300, 'AC00000', 'Rolly Raytos updated staff information: Kim Dami', '01-22-2025 23:29:30'),
(301, 'AC00000', 'Rolly Raytos logged out.', '01-22-2025 23:38:37'),
(302, 'AC00001', 'Aiah Arceta logged in.', '01-22-2025 23:38:42'),
(303, 'AC00001', 'Aiah Arceta order placed(159): 1 Chocolate Latte (16oz), 1 Blueberry Latte (12oz), 1 Chocolate Latte (16oz)', '01-22-2025 23:38:50'),
(304, 'AC00001', 'Aiah Arceta logged out.', '01-22-2025 23:39:04'),
(305, 'AC00000', 'Rolly Raytos logged in.', '01-22-2025 23:39:10'),
(306, 'AC00000', 'Rolly Raytos logged out.', '01-23-2025 00:34:05'),
(307, 'AC00001', 'Aiah Arceta logged in.', '01-23-2025 00:59:06'),
(308, 'AC00001', 'Aiah Arceta added a new item: 12oz cup.', '01-23-2025 01:03:03'),
(309, 'AC00001', 'Aiah Arceta updated Vanilla Syrup information.', '01-23-2025 02:00:20'),
(310, 'AC00001', 'Aiah Arceta updated Vanilla Syrup\'s quantity: 1L.', '01-23-2025 02:00:20'),
(311, 'AC00001', 'Aiah Arceta undo the changes of an item: Vanilla Syrup.', '01-23-2025 02:00:30'),
(312, 'AC00001', 'Aiah Arceta added new category: test', '01-23-2025 02:24:26'),
(313, 'AC00001', 'Aiah Arceta deleted a category: Test.', '01-23-2025 02:24:29'),
(314, 'AC00001', 'Aiah Arceta order placed(160): 2 Ube Frappe (12oz) (Ice)', '01-23-2025 04:44:13'),
(315, 'AC00001', 'Aiah Arceta logged out.', '01-23-2025 05:55:19'),
(316, 'AC00000', 'Rolly Raytos logged in.', '01-23-2025 05:55:25'),
(317, 'AC00000', 'Rolly Raytos deleted a user: Test.', '01-23-2025 05:55:42'),
(318, 'AC00000', 'Rolly Raytos updated 12oz cup information.', '01-23-2025 06:04:42'),
(319, 'AC00000', 'Rolly Raytos updated 12oz cup\'s quantity: 5.', '01-23-2025 06:04:42'),
(320, 'AC00000', 'Rolly Raytos undo the changes of an item: 12oz Cup.', '01-23-2025 06:11:42'),
(321, 'AC00000', 'Rolly Raytos updated 12oz cup information.', '01-23-2025 06:12:03'),
(322, 'AC00000', 'Rolly Raytos updated 12oz cup\'s quantity: 5.', '01-23-2025 06:12:03'),
(323, 'AC00000', 'Rolly Raytos undo the changes of an item: 12oz Cup.', '01-23-2025 06:12:12'),
(324, 'AC00000', 'Rolly Raytos updated Whole Milk information.', '01-23-2025 06:12:44'),
(325, 'AC00000', 'Rolly Raytos updated Whole Milk\'s quantity: 1000ml.', '01-23-2025 06:12:44'),
(326, 'AC00000', 'Rolly Raytos undo the changes of an item: Whole Milk.', '01-23-2025 06:12:49'),
(327, 'AC00000', 'Rolly Raytos logged out.', '01-23-2025 06:14:05'),
(328, 'AC00001', 'Kim Dami logged in.', '01-23-2025 06:14:09'),
(329, 'AC00001', 'Kim Dami updated 12oz cup information.', '01-23-2025 06:14:57'),
(330, 'AC00001', 'Kim Dami updated 12oz cup\'s quantity: 5.', '01-23-2025 06:14:57'),
(331, 'AC00001', 'Kim Dami undo the changes of an item: 12oz Cup.', '01-23-2025 06:21:37'),
(332, 'AC00001', 'Kim Dami updated 12oz cup information.', '01-23-2025 06:21:42'),
(333, 'AC00001', 'Kim Dami updated 12oz cup\'s quantity: 5.', '01-23-2025 06:21:42'),
(334, 'AC00001', 'Kim Dami updated Vanilla Syrup information.', '01-23-2025 06:21:54'),
(335, 'AC00001', 'Kim Dami updated Vanilla Syrup\'s quantity: 1L.', '01-23-2025 06:21:54'),
(336, 'AC00001', 'Kim Dami undo the changes of an item: Vanilla Syrup.', '01-23-2025 06:22:06'),
(337, 'AC00001', 'Kim Dami undo the changes of an item: 12oz Cup.', '01-23-2025 06:22:08'),
(338, 'AC00001', 'Kim Dami logged in.', '01-23-2025 10:24:56'),
(339, 'AC00001', 'Kim Dami updated 12oz cup information.', '01-23-2025 11:20:30'),
(340, 'AC00001', 'Kim Dami updated 12oz cup\'s quantity: 10.', '01-23-2025 11:20:30'),
(341, 'AC00001', 'Kim Dami logged out.', '01-23-2025 11:22:54'),
(342, 'AC00000', 'Rolly Raytos logged in.', '01-23-2025 11:22:59'),
(343, 'AC00000', 'Rolly Raytos updated Large cup information.', '01-23-2025 11:32:08'),
(344, 'AC00000', 'Rolly Raytos updated Large cup\'s quantity: 1.', '01-23-2025 11:32:08'),
(345, 'AC00000', 'Rolly Raytos undo the changes of an item: Large Cup.', '01-23-2025 11:34:03'),
(346, 'AC00000', 'Rolly Raytos undo the changes of an item: 12oz Cup.', '01-23-2025 11:34:47'),
(438, 'AC00001', 'Kim Dami marked as done the order 164.', '01-25-2025 03:46:53'),
(439, 'AC00001', 'Kim Dami logged out.', '01-25-2025 03:48:43'),
(440, 'AC00000', 'Rolly Raytos logged in.', '01-25-2025 03:48:47'),
(441, 'AC00000', 'Rolly Raytos logged out.', '01-25-2025 03:49:13'),
(442, 'AC00001', 'Kim Dami logged in.', '01-25-2025 03:49:20'),
(443, 'AC00001', 'Kim Dami order placed(165): 1 French Vanilla Latte (Regular)', '01-25-2025 03:53:00'),
(444, 'AC00001', 'Kim Dami marked as done the order 165.', '01-25-2025 03:53:50'),
(445, 'AC00001', 'Kim Dami logged out.', '01-25-2025 03:54:00'),
(446, 'AC00000', 'Rolly Raytos logged in.', '01-25-2025 03:54:05'),
(447, 'AC00000', 'Rolly Raytos marked as done the order 165.', '01-25-2025 03:54:35'),
(448, 'AC00000', 'Rolly Raytos marked as done the order 165.', '01-25-2025 03:55:49'),
(449, 'AC00000', 'Rolly Raytos logged out.', '01-25-2025 03:57:52'),
(450, 'AC00001', 'Kim Dami logged in.', '01-25-2025 03:57:57'),
(451, 'AC00001', 'Kim Dami order placed(166): 1 test , 1 Strawberries and Cream Frappe (Regular)', '01-25-2025 03:58:07'),
(452, 'AC00001', 'Kim Dami order placed(167): 1 Mocha Latte (Regular), 1 test ', '01-25-2025 03:59:35'),
(453, 'AC00001', 'Kim Dami deleted an order: 167.', '01-25-2025 03:59:47'),
(454, 'AC00001', 'Kim Dami deleted an order: 166.', '01-25-2025 03:59:50'),
(455, 'AC00001', 'Kim Dami deleted an order: 165.', '01-25-2025 03:59:53'),
(456, 'AC00001', 'Kim Dami order placed(168): 1 Double Chocolate Frappe (16oz)', '01-25-2025 04:00:35'),
(457, 'AC00001', 'Kim Dami order placed(169): 1 Double Chocolate Frappe (16oz), 1 test ', '01-25-2025 04:00:57'),
(458, 'AC00001', 'Kim Dami deleted an order: 169.', '01-25-2025 04:01:24'),
(459, 'AC00001', 'Kim Dami deleted an order: 168.', '01-25-2025 04:01:27'),
(460, 'AC00000', 'Rolly Raytos logged in.', '01-26-2025 12:34:34'),
(461, 'AC52133', 'Rolly Raytos added a new staff: Staff', '01-26-2025 13:11:09'),
(462, 'AC00000', 'Rolly Raytos deleted a user: Staff.', '01-26-2025 13:27:25'),
(463, 'AC53093', 'Rolly Raytos added a new staff: Staff', '01-26-2025 13:27:46'),
(464, 'AC00000', 'Rolly Raytos deleted a user: Staff.', '01-26-2025 13:28:19'),
(465, 'AC01443', 'Rolly Raytos added a new staff: staff', '01-26-2025 13:28:34'),
(466, 'AC00000', 'Rolly Raytos updated staff information: staff', '01-26-2025 13:30:26'),
(467, 'AC00000', 'Rolly Raytos deleted a user: Staff.', '01-26-2025 13:34:18'),
(468, 'AC19791', 'Rolly Raytos added a new staff: staff', '01-26-2025 13:34:36'),
(469, 'AC00000', 'Rolly Raytos deleted a user: Staff.', '01-26-2025 13:34:49'),
(470, 'AC00000', 'Rolly Raytos updated Instant Noodles information.', '01-26-2025 13:35:05'),
(471, 'AC00000', 'Rolly Raytos updated Instant Noddles\'s quantity: 10.', '01-26-2025 13:35:05'),
(472, 'AC00000', 'Rolly Raytos logged out.', '01-26-2025 13:54:41'),
(473, 'AC00000', 'Rolly Raytos logged in.', '01-26-2025 13:54:45'),
(474, 'AC00000', 'Rolly Raytos logged out.', '01-26-2025 13:54:48'),
(475, 'AC00001', 'Kim Dami logged in.', '01-26-2025 13:54:54'),
(476, 'AC00001', 'Kim Dami order placed(170): 1 test  (Ice)', '01-26-2025 13:55:07'),
(477, 'AC00001', 'Kim Dami order placed(171): 1 White Chocolate Mocha (Regular)', '01-26-2025 13:55:46'),
(478, 'AC00001', 'Kim Dami deleted an order: 170.', '01-26-2025 13:56:18'),
(479, 'AC00001', 'Kim Dami marked as done the order 171.', '01-26-2025 13:58:24'),
(480, 'AC00001', 'Kim Dami marked as done the order 171.', '01-26-2025 14:07:29'),
(481, 'AC00001', 'Kim Dami marked as done the order 171.', '01-26-2025 14:08:30'),
(482, 'AC00001', 'Kim Dami logged out.', '01-26-2025 14:09:01'),
(483, 'AC00000', 'Rolly Raytos logged in.', '01-26-2025 14:55:58'),
(484, 'AC00000', 'Rolly Raytos logged out.', '01-26-2025 14:56:01'),
(485, 'AC00001', 'Kim Dami logged in.', '01-26-2025 14:56:06'),
(486, 'AC00001', 'Kim Dami order placed(172): 1 Caramel Macchiato Frappe (Regular), 1 test ', '01-26-2025 14:56:27'),
(487, 'AC00001', 'Kim Dami marked as done the order 172.', '01-26-2025 15:58:22'),
(488, 'AC00001', 'Kim Dami order placed(173): 1 test ', '01-26-2025 15:58:38'),
(489, 'AC00001', 'Kim Dami order placed(174): 1 test ', '01-26-2025 16:00:44'),
(490, 'AC00001', 'Kim Dami order placed(175): 1 test ', '01-26-2025 16:01:41'),
(491, 'AC00001', 'Kim Dami marked as done the order 175.', '01-26-2025 16:01:46'),
(492, 'AC00001', 'Kim Dami logged out.', '01-26-2025 16:09:29'),
(493, 'AC00000', 'Rolly Raytos logged in.', '01-26-2025 16:09:34'),
(494, 'AC00000', 'Rolly Raytos logged out.', '01-26-2025 17:41:21'),
(495, 'AC00001', 'Kim Dami logged in.', '01-26-2025 17:42:03'),
(496, 'AC00001', 'Kim Dami marked as done the order 174.', '01-26-2025 18:03:11'),
(497, 'AC00001', 'Kim Dami marked as done the order 173.', '01-26-2025 18:08:36'),
(498, 'AC00001', 'Kim Dami order placed(176): 1 Mocha Frappe (Regular)', '01-26-2025 18:09:00'),
(499, 'AC00001', 'Kim Dami marked as done the order 176.', '01-26-2025 18:09:05'),
(500, 'AC00001', 'Kim Dami order placed(177): 1 Macadamia Nut Latte (Regular), 1 White Chocolate Mocha (Regular)', '01-26-2025 18:43:40'),
(501, 'AC00001', 'Kim Dami order placed(178): 1 White Chocolate Mocha (Regular), 1 Caramel Macchiato (Regular)', '01-26-2025 18:44:04'),
(502, 'AC00001', 'Kim Dami order placed(179): 1 Caramel Macchiato (Regular)', '01-26-2025 18:54:08'),
(503, 'AC00001', 'Kim Dami deleted a product: TEST.', '01-26-2025 18:56:34'),
(504, 'AC00001', 'Kim Dami deleted a product: Test.', '01-26-2025 18:56:36'),
(505, 'AC00001', 'Kim Dami added a new item: test.', '01-26-2025 18:58:48'),
(506, 'AC00001', 'Kim Dami updated test information.', '01-26-2025 18:59:50'),
(507, 'AC00001', 'Kim Dami updated test\'s quantity: 1.', '01-26-2025 18:59:50'),
(508, 'AC00001', 'Kim Dami added a new item: tes.', '01-26-2025 19:03:25'),
(509, 'AC00001', 'Kim Dami deleted an item in inventory: Tes.', '01-26-2025 19:04:29'),
(510, 'AC00001', 'Kim Dami deleted an item in inventory: Test.', '01-26-2025 19:04:32'),
(511, 'AC00001', 'Kim Dami deleted an item in inventory: Instant Noodles.', '01-26-2025 19:04:36'),
(512, 'AC00001', 'Kim Dami logged out.', '01-26-2025 19:04:50'),
(513, 'AC00001', 'Kim Dami logged in.', '01-26-2025 19:06:40'),
(514, 'AC00001', 'Kim Dami logged out.', '01-26-2025 19:06:45'),
(515, 'AC00001', 'Kim Dami logged in.', '01-26-2025 20:14:52'),
(516, 'AC00001', 'Kim Dami logged out.', '01-26-2025 20:15:12'),
(517, 'AC00001', 'Kim Dami logged in.', '01-26-2025 20:53:26'),
(518, 'AC00001', 'Kim Dami logged out.', '01-26-2025 20:55:24'),
(519, 'AC00001', 'Kim Dami logged in.', '01-26-2025 20:55:29'),
(520, 'AC00001', 'Kim Dami logged in.', '01-26-2025 21:10:20'),
(521, 'AC00001', 'Kim Dami order placed(180): 1 Oreo Frappe (12oz), 1 Caramel Macchiato (Regular)', '01-26-2025 21:16:36'),
(522, 'AC00001', 'Kim Dami updated 12oz cup information.', '01-26-2025 21:19:12'),
(523, 'AC00001', 'Kim Dami updated 12oz cup\'s quantity: 20.', '01-26-2025 21:19:12'),
(524, 'AC00001', 'Kim Dami updated Large cup information.', '01-26-2025 21:19:17'),
(525, 'AC00001', 'Kim Dami updated Large cup\'s quantity: 20.', '01-26-2025 21:19:17'),
(526, 'AC00001', 'Kim Dami updated Whole Milk information.', '01-26-2025 21:19:31'),
(527, 'AC00001', 'Kim Dami updated Whole Milk\'s quantity: 15.', '01-26-2025 21:19:31'),
(528, 'AC00001', 'Kim Dami deleted a product: Cappu.', '01-26-2025 21:24:31'),
(529, 'AC00001', 'Kim Dami added a new product: test', '01-26-2025 22:04:41'),
(530, 'AC00001', 'Kim Dami deleted a product: Test.', '01-26-2025 22:04:47'),
(531, 'AC00001', 'Kim Dami added a new product: test', '01-26-2025 22:08:17'),
(532, 'AC00001', 'Kim Dami deleted a product: Test.', '01-26-2025 22:08:27'),
(533, 'AC00001', 'Kim Dami logged out.', '01-26-2025 22:39:42'),
(534, 'AC00000', 'Rolly Raytos logged in.', '01-26-2025 22:39:49'),
(535, 'AC00000', 'Rolly Raytos logged out.', '01-26-2025 23:37:03'),
(536, 'AC00001', 'Kim Dami logged in.', '01-26-2025 23:37:11'),
(537, 'AC00001', 'Kim Dami added a new product: test', '01-26-2025 23:37:24'),
(538, 'AC00001', 'Kim Dami logged out.', '01-26-2025 23:39:26'),
(539, 'AC00000', 'Rolly Raytos logged in.', '01-26-2025 23:39:30'),
(540, 'AC00000', 'Rolly Raytos updated staff information: Kim Dami', '01-26-2025 23:43:49'),
(541, 'AC00000', 'Rolly Raytos logged out.', '01-27-2025 00:52:37'),
(542, 'AC00000', 'Rolly Raytos logged in.', '01-27-2025 00:57:29'),
(543, 'AC00000', 'Rolly Raytos deleted a user: Kim Dami.', '01-27-2025 01:00:49'),
(544, 'AC00000', 'Rolly Raytos logged out.', '01-27-2025 01:24:05'),
(545, 'AC00001', 'Kim Dami logged in.', '01-27-2025 01:24:10'),
(546, 'AC00001', 'Kim Dami deleted a product: Test.', '01-27-2025 01:26:25'),
(547, 'AC00001', 'Kim Dami order placed(181): 1 Ube Latte (12oz), 1 Matcha Latte (Regular), 1 Blueberry Latte (12oz)', '01-27-2025 01:28:30'),
(548, 'AC00001', 'Kim Dami added a new product: test', '01-27-2025 01:30:10'),
(549, 'AC00001', 'Kim Dami logged out.', '01-27-2025 01:33:03'),
(550, 'AC00001', 'Kim Dami logged in.', '01-27-2025 01:47:23'),
(551, 'AC00001', 'Kim Dami added a new product: test', '01-27-2025 02:06:04'),
(552, 'AC00001', 'Kim Dami updated a product: test', '01-27-2025 02:18:16'),
(553, 'AC00001', 'Kim Dami order placed(182): 1 test (12oz)', '01-27-2025 02:44:50'),
(554, 'AC00001', 'Kim Dami order placed(183): 1 test (12oz)', '01-27-2025 02:46:35'),
(555, 'AC00001', 'Kim Dami order placed(184): 1 test (12oz)', '01-27-2025 02:47:13'),
(556, 'AC00001', 'Kim Dami updated a product: test', '01-27-2025 02:51:06'),
(557, 'AC00001', 'Kim Dami added a new product: testttest', '01-27-2025 02:51:23'),
(558, 'AC00001', 'Kim Dami deleted a product: Testttest.', '01-27-2025 02:51:41'),
(559, 'AC00001', 'Kim Dami deleted a product: Test.', '01-27-2025 02:51:43'),
(560, 'AC00001', 'Kim Dami deleted a product: Test.', '01-27-2025 02:51:44'),
(561, 'AC00001', 'Kim Dami added a new product: test', '01-27-2025 03:04:46'),
(562, 'AC00001', 'Kim Dami added a new product: test', '01-27-2025 03:12:24'),
(563, 'AC00001', 'Kim Dami updated a product: test', '01-27-2025 03:13:07'),
(564, 'AC00001', 'Kim Dami updated a product: test', '01-27-2025 03:14:42'),
(565, 'AC00001', 'Kim Dami order placed(185): 1 test (test)', '01-27-2025 03:26:00'),
(566, 'AC00001', 'Kim Dami updated a product: test', '01-27-2025 03:34:55'),
(567, 'AC00001', 'Kim Dami updated a product: test', '01-27-2025 03:36:52'),
(568, 'AC00001', 'Kim Dami updated a product: test', '01-27-2025 03:45:03'),
(569, 'AC00001', 'Kim Dami updated a product: test', '01-27-2025 03:57:20'),
(570, 'AC00001', 'Kim Dami order placed(186): 1 test (test)', '01-27-2025 03:58:05'),
(571, 'AC00001', 'Kim Dami order placed(187): 1 test (test)', '01-27-2025 03:58:27'),
(572, 'AC00001', 'Kim Dami order placed(188): 1 test (test)', '01-27-2025 03:58:57'),
(573, 'AC00001', 'Kim Dami updated a product: test', '01-27-2025 03:59:50'),
(574, 'AC00001', 'Kim Dami updated a product: test', '01-27-2025 04:00:07'),
(575, 'AC00001', 'Kim Dami logged in.', '01-27-2025 13:10:35'),
(576, 'AC00001', 'Kim Dami order placed(189): 1 test (test)', '01-27-2025 13:11:30'),
(577, 'AC00001', 'Kim Dami order placed(190): 1 Java Chip Frappe (12oz)', '01-27-2025 13:40:54'),
(578, 'AC00001', 'Kim Dami logged out.', '01-27-2025 13:41:03'),
(579, 'AC00001', 'Kim Dami logged in.', '01-29-2025 16:59:08'),
(580, 'AC00001', 'Kim Dami logged out.', '01-29-2025 17:08:00'),
(581, 'AC00001', 'Kim Dami logged in.', '01-30-2025 16:39:37'),
(582, 'AC00001', 'Kim Dami order placed(191): 1 Double Chocolate Frappe (12oz) (Hot), 3 Strawberries and Cream Frappe (Regular), 2 Strawberry (Regular)', '01-30-2025 16:40:28'),
(583, 'AC00001', 'Kim Dami marked as done the order 191.', '01-30-2025 16:41:04'),
(584, 'AC00001', 'Kim Dami deleted a product: Test.', '01-30-2025 16:42:37'),
(585, 'AC00001', 'Kim Dami deleted a product: Test.', '01-30-2025 16:42:39'),
(586, 'AC00001', 'Kim Dami logged out.', '01-30-2025 16:42:46'),
(587, 'AC00001', 'Kim Dami logged in.', '01-30-2025 16:44:30'),
(588, 'AC00001', 'Kim Dami order placed(192): 2 Mocha Frappe (Regular) (Hot), 1 Butterscotch Latte (Regular) (Hot)', '01-30-2025 16:46:11'),
(589, 'AC00001', 'Kim Dami marked as done the order 192.', '01-30-2025 16:48:00'),
(590, 'AC00001', 'Kim Dami added a new item: Instant Noodles.', '01-30-2025 16:48:45'),
(591, 'AC00001', 'Kim Dami updated Instant Noodles information.', '01-30-2025 16:49:19'),
(592, 'AC00001', 'Kim Dami updated Instant Noodles\'s quantity: 10.', '01-30-2025 16:49:19'),
(593, 'AC00001', 'Kim Dami undo the changes of an item: Instant Noodles.', '01-30-2025 16:49:36'),
(594, 'AC00001', 'Kim Dami deleted an item in inventory: Instant Noodles.', '01-30-2025 16:50:03'),
(595, 'AC00001', 'Kim Dami added new category: Computer Parts', '01-30-2025 16:50:22'),
(596, 'AC00001', 'Kim Dami updated the category: Computer Part', '01-30-2025 16:50:27'),
(597, 'AC00001', 'Kim Dami updated the category: Computer Parts', '01-30-2025 16:53:21'),
(598, 'AC00001', 'Kim Dami deleted a category: Computer Parts.', '01-30-2025 16:53:23'),
(599, 'AC00001', 'Kim Dami added a new product: Test', '01-30-2025 16:54:38'),
(600, 'AC00001', 'Kim Dami updated a product: Test', '01-30-2025 16:54:55'),
(601, 'AC00001', 'Kim Dami deleted a product: Test.', '01-30-2025 16:55:23'),
(602, 'AC00001', 'Kim Dami updated a product: Strawberry', '01-30-2025 16:56:10'),
(603, 'AC00001', 'Kim Dami added new category: Computer Parts', '01-30-2025 16:56:46'),
(604, 'AC00001', 'Kim Dami updated the category: Computer Part', '01-30-2025 16:56:56'),
(605, 'AC00001', 'Kim Dami deleted a category: Computer Part.', '01-30-2025 16:57:04'),
(606, 'AC00001', 'Kim Dami added a new product: Test product', '01-30-2025 16:58:03'),
(607, 'AC00001', 'Kim Dami updated a product: Test product', '01-30-2025 16:58:44'),
(608, 'AC00001', 'Kim Dami logged out.', '01-30-2025 17:00:00'),
(609, 'AC00000', 'Rolly Raytos logged in.', '01-30-2025 17:00:05'),
(610, 'AC00000', 'Rolly Raytos added a new item: Test.', '01-30-2025 17:01:18'),
(611, 'AC00000', 'Rolly Raytos updated Test1 information.', '01-30-2025 17:01:28'),
(612, 'AC00000', 'Rolly Raytos updated Test\'s quantity: 10.', '01-30-2025 17:01:28'),
(613, 'AC00000', 'Rolly Raytos undo the changes of an item: Test1.', '01-30-2025 17:01:34'),
(614, 'AC00000', 'Rolly Raytos deleted an item in inventory: Test1.', '01-30-2025 17:01:42'),
(615, 'AC00000', 'Rolly Raytos added new category: Computer', '01-30-2025 17:01:53'),
(616, 'AC00000', 'Rolly Raytos deleted a category: Computer.', '01-30-2025 17:02:07'),
(617, 'AC00000', 'Rolly Raytos updated staff information: Lamoi', '01-30-2025 17:05:18'),
(618, 'AC00000', 'Rolly Raytos logged out.', '01-30-2025 17:06:58');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `uid` varchar(10) NOT NULL,
  `product_id` int(11) NOT NULL,
  `variation_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `temperature` varchar(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `delete_flag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `delete_flag`) VALUES
(1, 'frappe', 0),
(2, 'espresso', 0),
(3, 'non-coffee', 0),
(4, 'soda series', 0),
(7, 'Foods', 0),
(8, 'Frappuccino', 1),
(9, 'Salad', 1),
(13, 'Tests', 1),
(14, 'Computer Parts', 1),
(15, 'Computer Part', 1),
(16, 'Computer', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `quantity_before` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `added_at` varchar(255) NOT NULL,
  `updated_at` varchar(100) NOT NULL,
  `delete_flag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `name`, `quantity`, `quantity_before`, `description`, `added_at`, `updated_at`, `delete_flag`) VALUES
(1, 'Chocolate Syrup', '4.080l', '', 'N/A', '03-04-2024 12:54:45', '', 0),
(2, 'Whole Milk', '16.148l', '2.800l', 'NA', '03-04-2024 12:56:12', '01-26-2025 21:19:31', 0),
(5, 'Instant Coffee', '6.452kg', '', '', '03-04-2024 12:57:39', '', 0),
(6, 'Vanilla Syrup', '16.220l', '', 'Vanilla syrup', '03-04-2024 10:10:35', '', 0),
(7, 'Large cup', '29.000', '10', 'N/A', '03-04-2024 11:16:29', '01-26-2025 21:19:17', 0),
(8, 'Pineapple', '100.010l', '', 'Good morning Pineapple', '01-10-2025 04:41:34', '', 1),
(9, 'test', '10l', '', 'test', '01-19-2025 01:04:31', '', 1),
(10, 'test', '10l', '', 'test', '01-19-2025 01:14:23', '', 1),
(11, 'test', '10l', '', 'testt', '01-19-2025 01:16:14', '', 1),
(12, 'test1', '10l', '', 'test1', '01-19-2025 01:20:16', '', 1),
(13, 'test3', '10kg', '', 'test3', '01-19-2025 01:20:49', '', 1),
(14, 'White Milk', '100L', '', '', '01-19-2025 09:37:42', '', 1),
(15, '12oz cup', '23.000', '', 'Cup', '01-19-2025 09:42:32', '', 1),
(16, '', '', '', '', '01-22-2025 22:10:02', '', 1),
(17, '', '', '', '', '01-22-2025 22:11:02', '', 1),
(18, '12oz cup', '23.000', '10', 'For Frappe', '01-23-2025 01:03:03', '01-26-2025 21:19:12', 0),
(19, 'NA', '10', '', 'NA', '01-23-2025 21:07:03', '', 1),
(20, 'Instant Noodles', '410.000', '400', 'Instant Noddles', '01-24-2025 16:01:50', '01-26-2025 13:35:05', 1),
(21, 'Test', '5', '', 'test', '01-24-2025 17:21:44', '', 1),
(22, 'Test', '6.000', '1', 'test', '01-24-2025 17:22:36', '01-24-2025 17:22:42', 1),
(23, 'Instant Choco', '100ml', '', 'Test', '01-25-2025 01:09:11', '', 1),
(24, 'test', '2.000', '1', '', '01-26-2025 18:58:48', '01-26-2025 18:59:50', 1),
(25, 'tes', '12kg', '', '', '01-26-2025 19:03:25', '', 1),
(26, 'Instant Noodles', '100', '', '', '01-30-2025 16:48:45', '', 1),
(27, 'Test1', '100', '', 'test1', '01-30-2025 17:01:18', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `uid` varchar(10) NOT NULL,
  `products` varchar(999) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `cash` decimal(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `placed_on` varchar(255) NOT NULL,
  `delete_flag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `uid`, `products`, `amount`, `cash`, `status`, `placed_on`, `delete_flag`) VALUES
(91, 'AC00001', '1 Oreo Frappe', 145.00, 1000.00, 1, '01-15-2025 09:11:28', 0),
(92, 'AC00001', '1 Salted Caramel Latte', 0.00, 1000.00, 1, '01-17-2025 06:25:04', 0),
(97, 'AC00001', '1 Blueberry (16oz)', 125.00, 1000.00, 1, '01-17-2025 11:44:31', 0),
(98, 'AC00001', '1 Blueberry (12oz), 1 Blueberry (16oz)', 240.00, 1000.00, 1, '01-17-2025 11:58:29', 0),
(99, 'AC00001', '1 Blueberry (12oz), 1 Strawberry (Regular), 1 Blueberry (16oz)', 360.00, 1000.00, 1, '01-18-2025 04:35:42', 0),
(101, 'AC00001', '1 Ube Frappe (12oz) (Hot), 1 Double Chocolate Frappe (16oz) (Ice)', 245.00, 1000.00, 1, '01-18-2025 07:14:10', 0),
(102, 'AC00001', '2 Ube Frappe (12oz) (Ice)', 240.00, 1000.00, 2, '01-19-2025 12:52:19', 1),
(106, 'AC00001', '2 Oreo Frappe (12oz) (Hot)', 230.00, 1000.00, 2, '01-19-2025 01:46:17', 1),
(113, 'AC00001', '1 Ube Frappe (12oz) ()', 120.00, 1000.00, 2, '01-19-2025 02:09:45', 1),
(114, 'AC00001', '1 Ube Frappe (12oz) (Hot)', 120.00, 1000.00, 2, '01-19-2025 02:11:07', 1),
(118, 'AC00001', '1 Ube Frappe (12oz) (Hot)', 120.00, 1000.00, 2, '01-19-2025 02:14:54', 1),
(119, 'AC00001', '1 Ube Frappe (12oz) (Hot)', 120.00, 1000.00, 2, '01-19-2025 02:15:32', 1),
(120, 'AC00001', '1 Ube Frappe (12oz) ()', 120.00, 1000.00, 2, '01-19-2025 02:19:28', 1),
(131, 'AC00001', '1 Ube Frappe (12oz)', 120.00, 1000.00, 2, '01-19-2025 02:40:28', 1),
(132, 'AC00001', '1 Ube Frappe (12oz)', 120.00, 1000.00, 2, '01-19-2025 02:41:41', 1),
(133, 'AC00001', '1 Ube Frappe (12oz)', 120.00, 1000.00, 2, '01-19-2025 02:41:53', 1),
(134, 'AC00001', '1 Blueberries and Cream Frappe (12oz) (Hot)', 125.00, 1000.00, 1, '01-19-2025 02:42:26', 0),
(135, 'AC00001', '1 Matcha Latte (Regular) (Hot)', 125.00, 1000.00, 1, '01-19-2025 08:18:56', 0),
(136, 'AC00001', '3 Caramel Latte (Regular) (Hot), 2 Passion Fruit (12oz) (Ice)', 570.00, 1000.00, 1, '01-19-2025 09:44:58', 0),
(137, 'AC00001', '1 Blueberry (16oz)', 125.00, 1000.00, 1, '01-19-2025 22:37:41', 0),
(138, 'AC00001', '1 Strawberry (Regular)', 120.00, 1000.00, 1, '01-19-2025 23:45:41', 0),
(139, 'AC00001', '1 Passion Fruit (12oz)', 105.00, 1000.00, 1, '01-22-2025 01:48:08', 0),
(140, 'AC00001', '1 Green Apple (16oz), 1 Blueberry (12oz)', 240.00, 1000.00, 1, '01-22-2025 01:48:48', 0),
(141, 'AC00001', '1 Blueberry (12oz)', 115.00, 1000.00, 1, '01-22-2025 01:49:20', 0),
(142, 'AC00001', '1 Blueberry (12oz)', 115.00, 1000.00, 1, '01-22-2025 01:52:02', 0),
(143, 'AC00001', '1 Blueberry (16oz)', 125.00, 1000.00, 1, '01-22-2025 01:53:41', 0),
(162, 'AC00001', '2 Caramel Latte (Regular) (Hot), 1 Macadamia Nut Latte (Regular) (Ice), 2 Blueberry (16oz) (Hot)', 610.00, 610.00, 1, '01-25-2025 01:05:56', 0),
(163, 'AC00001', '1 test , 1 Caramel Macchiato (Regular)', 120.00, 120.00, 2, '01-25-2025 03:42:29', 1),
(164, 'AC00001', '1 Macadamia Nut Latte (Regular)', 120.00, 120.00, 1, '01-25-2025 03:42:42', 0),
(165, 'AC00001', '1 French Vanilla Latte (Regular)', 120.00, 120.00, 2, '01-25-2025 03:53:00', 1),
(166, 'AC00001', '1 test , 1 Strawberries and Cream Frappe (Regular)', 125.00, 125.00, 2, '01-25-2025 03:58:07', 1),
(167, 'AC00001', '1 Mocha Latte (Regular), 1 test ', 120.00, 120.00, 2, '01-25-2025 03:59:35', 1),
(168, 'AC00001', '1 Double Chocolate Frappe (16oz)', 125.00, 125.00, 2, '01-25-2025 04:00:35', 1),
(169, 'AC00001', '1 Double Chocolate Frappe (16oz), 1 test ', 125.00, 125.00, 2, '01-25-2025 04:00:57', 1),
(171, 'AC00001', '1 White Chocolate Mocha (Regular)', 125.00, 1255.00, 1, '01-26-2025 13:55:46', 0),
(172, 'AC00001', '1 Caramel Macchiato Frappe (Regular), 1 test ', 125.00, 125.00, 1, '01-26-2025 14:56:27', 0),
(176, 'AC00001', '1 Mocha Frappe (Regular)', 125.00, 125.00, 1, '01-26-2025 18:09:00', 0),
(177, 'AC00001', '1 Macadamia Nut Latte (Regular), 1 White Chocolate Mocha (Regular)', 245.00, 250.00, 2, '01-26-2025 18:43:40', 0),
(178, 'AC00001', '1 White Chocolate Mocha (Regular), 1 Caramel Macchiato (Regular)', 245.00, 250.00, 2, '01-26-2025 18:44:04', 0),
(179, 'AC00001', '1 Caramel Macchiato (Regular)', 120.00, 200.00, 2, '01-26-2025 18:54:08', 0),
(180, 'AC00001', '1 Oreo Frappe (12oz), 1 Caramel Macchiato (Regular)', 235.00, 500.00, 2, '01-26-2025 21:16:36', 0),
(181, 'AC00001', '1 Ube Latte (12oz), 1 Matcha Latte (Regular), 1 Blueberry Latte (12oz)', 360.00, 1000.00, 2, '01-27-2025 01:28:30', 0),
(182, 'AC00001', '1 test (12oz)', 12.00, 12.00, 2, '01-27-2025 02:44:50', 0),
(183, 'AC00001', '1 test (12oz)', 12.00, 12.00, 2, '01-27-2025 02:46:35', 0),
(184, 'AC00001', '1 test (12oz)', 12.00, 12.00, 2, '01-27-2025 02:47:13', 0),
(185, 'AC00001', '1 test (test)', 120.00, 120.00, 2, '01-27-2025 03:26:00', 0),
(186, 'AC00001', '1 test (test)', 120.00, 120.00, 2, '01-27-2025 03:58:05', 0),
(187, 'AC00001', '1 test (test)', 120.00, 120.00, 2, '01-27-2025 03:58:27', 0),
(188, 'AC00001', '1 test (test)', 120.00, 120.00, 2, '01-27-2025 03:58:57', 0),
(189, 'AC00001', '1 test (test)', 120.00, 120.00, 2, '01-27-2025 13:11:30', 0),
(190, 'AC00001', '1 Java Chip Frappe (12oz)', 125.00, 200.00, 2, '01-27-2025 13:40:54', 0),
(191, 'AC00001', '1 Double Chocolate Frappe (12oz) (Hot), 3 Strawberries and Cream Frappe (Regular), 2 Strawberry (Regular)', 740.00, 800.00, 1, '01-30-2025 16:40:28', 0),
(192, 'AC00001', '2 Mocha Frappe (Regular) (Hot), 1 Butterscotch Latte (Regular) (Hot)', 355.00, 400.00, 1, '01-30-2025 16:46:11', 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `delete_flag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `description`, `image`, `delete_flag`) VALUES
(1, 'adasd', 1, 'test', 'IcedCaffeMocha.jpg', 1),
(2, 'Strawberry', 4, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '164922261-EspressoFrappuccino.jpg', 0),
(3, 'Caramel Latte', 2, 'Just before serving, our slow-steeped custom blend Cold Brew is topped with a delicate float of house-made vanilla sweet cream that cascades throughout the cup.\r\n\r\n', 'VanillaSweetCreamColdBrew.jpg', 0),
(4, 'Hazelnut Latte', 2, 'Dark, rich espresso lies in wait under a smoothed and stretched layer of thick milk foam. An alchemy of barista artistry and craft.\r\n\r\n', '328129355-VanillaCreamFrappuccino.jpg', 0),
(5, 'Mocha Latte', 2, 'Coffee meets milk and ice in a blender for a rumble and tumble and together they create one of our original Frappuccino® beverages.\r\n\r\n', 'CoffeeFrappuccino.jpg', 0),
(6, 'Vanilla Latte', 2, 'Coffee is combined with a shot of espresso and milk, then blended with ice to give you a nice little jolt and lots of sipping joy.\r\n\r\n', 'EspressoFrappuccino.jpg', 0),
(7, 'French Vanilla Latte', 2, 'Coffee Jelly Frappuccino\n', 'CoffeeJellyFrappuccino.jpg', 0),
(8, 'Macadamia Nut Latte', 2, 'A rich and creamy blend of caramel syrup, milk and ice. Topped with whipped cream and a delicious caramel drizzle.\n\n', 'CaramelCreamFrappuccino.jpg', 0),
(9, 'Brown Sugar Latte', 2, 'This rich and creamy blend of vanilla bean, milk and ice topped with whipped cream takes va-va-vanilla flavor to another level.\r\n\r\n', 'VanillaCreamFrappuccino.jpg', 0),
(11, 'Spanish Latte', 2, 'A rich and creamy blend of chocolate flavoured sauce, milk and ice. Topped with whipped cream.\r\n\r\n', 'ChocolateCreamFrappuccino.jpg', 0),
(15, 'Caramel Macchiato', 2, 'Milk and signature mocha topped with whipped cream and a chocolate-flavored drizzle. A timeless classic made to sweeten your spirits..\r\n\r\n', 'IcedSignatureChocolate.jpg', 0),
(31, 'White Chocolate Mocha', 2, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '676709817-CoffeeFrappuccino.jpg', 0),
(35, 'Butterscotch Latte', 2, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '258851287-VanillaCreamFrappuccino.jpg', 0),
(36, 'Salted Caramel Latte', 2, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '772813420-ChocolateCreamFrappuccino.jpg', 0),
(38, 'Biscoff Latte', 2, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '275287549-CoffeeJellyFrappuccino.jpg', 0),
(39, 'Spiced Latte (Agave)', 2, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '20766623-CoffeeFrappuccino.jpg', 0),
(40, 'Double Chocolate Frappe', 1, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '468077248-IcedCaramelMacchiato.jpg', 0),
(41, 'Oreo Frappe', 1, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '671870875-CaramelCreamFrappuccino.jpg', 0),
(42, 'Vanilla Frappe', 1, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '906869471-ChocolateCreamFrappuccino.jpg', 0),
(43, 'Mocha Frappe', 1, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '533429700-IcedCaramelMacchiato.jpg', 0),
(44, 'Java Chip Frappe', 1, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '79734012-IcedSignatureChocolate.jpg', 0),
(45, 'Caramel Macchiato Frappe', 1, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '379374930-EspressoFrappuccino.jpg', 0),
(46, 'Matcha Frappe', 1, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '146655748-IcedCaffeMocha.jpg', 0),
(47, 'Strawberries and Cream Frappe', 1, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '624212637-IcedSignatureChocolate.jpg', 0),
(48, 'Blueberries and Cream Frappe', 1, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '489491774-VanillaSweetCreamColdBrew.jpg', 0),
(49, 'Ube Frappe', 1, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '238887303-CaramelCreamFrappuccino.jpg', 0),
(50, 'Chocolate Latte', 3, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '831334557-CoffeeJellyFrappuccino.jpg', 0),
(51, 'Matcha Latte', 3, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '359802584-EspressoFrappuccino.jpg', 0),
(52, 'Ube Latte', 3, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '572362850-IcedCaffeMocha.jpg', 0),
(53, 'Strawberry Latte', 3, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '883935522-IcedCaffeMocha.jpg', 0),
(54, 'Blueberry Latte', 3, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '334334798-ChocolateCreamFrappuccino.jpg', 0),
(55, 'Green Apple', 4, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '632449452-SaltedCaramelColdBrew.jpg', 0),
(56, 'Passion Fruit', 4, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '529652468-CoffeeFrappuccino.jpg', 0),
(57, 'Strawberry', 2, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '747702962-IcedCaffeMocha.jpg', 0),
(58, 'Blueberry', 4, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '445608010-VanillaCreamFrappuccino.jpg', 0),
(106, 'adasd', 1, 'test', NULL, 1),
(107, 'test', 1, 'test', NULL, 1),
(108, 'test', 2, 'test', NULL, 1),
(109, 'test', 3, 'test', NULL, 1),
(110, 'Cappu', 3, 'test', 'Screenshot 2024-12-23 001634.png', 1),
(111, 'Cappu', 1, 'test', '674977829-CoffeeFrappuccino.jpg', 1),
(112, 'erewr', 3, 'test', '91519261-lamoi.jpg', 1),
(113, 'terst', 3, 'test', '298509531-Kim Dami.jpg', 1),
(114, 'test', 3, 'test', '499509361-Jisoo.jpg', 1),
(115, 'test', 2, 'test', '677516121-Jisoo.jpg', 1),
(116, 'test', 1, 'test', '416888805-Jisoo.jpg', 1),
(117, 'test', 7, 'test', NULL, 1),
(118, 'test', 7, 'test', NULL, 1),
(119, '', 1, '', NULL, 1),
(120, 'test', 1, 'test', NULL, 1),
(121, 'test', 3, 'test', NULL, 1),
(122, 'test', 1, 'tetsttes', NULL, 1),
(123, 'test', 2, 'test', NULL, 1),
(124, 'test', 1, 'test', NULL, 1),
(125, 'test', 1, 'test', NULL, 1),
(126, 'TEST', 7, 'TEST', '920622049-CoffeeJellyFrappuccino.jpg', 1),
(127, 'test', 1, 'test', '31517050-EspressoFrappuccino.jpg', 1),
(128, 'test', 1, 'test', NULL, 1),
(129, 'test', 1, 'test', NULL, 1),
(130, 'test', 1, 'test', NULL, 1),
(131, 'test', 1, 'test', NULL, 1),
(132, 'test', 1, 'test', NULL, 1),
(133, 'testttest', 2, 'tetest', NULL, 1),
(134, 'test', 1, 'test', NULL, 1),
(135, 'test', 1, 'test', NULL, 1),
(136, 'Test', 2, 'Test ', '518670862-Context Diagram.drawio.png', 1),
(137, 'Test product', 7, 'Test product', '293749244-ChocolateCreamFrappuccino.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_variations`
--

CREATE TABLE `product_variations` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `ingredients` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variations`
--

INSERT INTO `product_variations` (`id`, `product_id`, `size`, `price`, `ingredients`) VALUES
(11, 3, 'Regular', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(13, 5, 'Regular', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(15, 7, 'Regular', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(16, 8, 'Regular', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(17, 9, 'Regular', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(18, 11, 'Regular', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(19, 15, 'Regular', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(83, 1, 'test', 120.00, 'test'),
(91, 106, 'testt', 120.00, 'test'),
(92, 107, 'test', 120.00, 'test'),
(93, 108, 'test', 120.00, 'test'),
(104, 109, 'test', 120.00, 'test'),
(111, 6, 'Regular', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(112, 6, '12oz', 135.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(117, 4, 'Regular', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(123, 113, 'test', 23.00, 'test'),
(124, 114, 'test', 23.00, 'test'),
(126, 31, 'Regular', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(127, 35, 'Regular', 105.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(128, 36, 'Regular', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(129, 38, 'Regular', 105.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(130, 39, '12oz', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(131, 40, '12oz', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(132, 40, '16oz', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(133, 41, '12oz', 115.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(134, 42, '12oz', 115.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(135, 43, 'Regular', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(136, 44, '12oz', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(137, 45, 'Regular', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(138, 46, '12oz', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(139, 47, 'Regular', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(140, 48, '12oz', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(141, 49, '12oz', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(142, 50, '16oz', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(143, 52, '12oz', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(144, 51, 'Regular', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(145, 53, 'Regular', 5.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(146, 54, '12oz', 115.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(147, 55, '16oz', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(148, 56, '12oz', 105.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(149, 57, '16oz', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(150, 58, '12oz', 115.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(151, 58, '16oz', 125.00, '8.4g Instant coffee, 100ml whole milk,30ml chocolate syrup'),
(152, 126, '12oz', 120.00, '8.4 Instant Noddles, 100ml Whole Milk'),
(153, 127, 'test', 120.00, ''),
(154, 131, 'test', 120.00, '1 Large cup'),
(157, 132, '12oz', 12.00, '1 12oz cup, 84ml Whole Milk'),
(158, 133, '12oz', 12.00, '1 12oz cup, 84ml Whole Milk'),
(167, 135, 'test', 120.00, '100ml Whole Milk, 1.5 kg Instant Coffee, 1 12oz cup'),
(169, 2, 'Regular', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(170, 137, 'Test Variation', 100.00, '8.4g Instant Coffee, 100ml Whole Milk');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `datetime` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `order_id`, `amount`, `datetime`) VALUES
(1, 135, 125.00, '01-19-2025 20:19:00'),
(2, 136, 570.00, '01-19-2025 21:45:10'),
(3, 137, 125.00, '01-19-2025 22:38:35'),
(4, 138, 120.00, '01-19-2025 23:45:55'),
(5, 159, 365.00, '01-22-2025 23:38:50'),
(6, 160, 240.00, '01-23-2025 04:44:13'),
(12, 165, 120.00, '01-25-2025 03:53:50'),
(13, 165, 120.00, '01-25-2025 03:54:35'),
(14, 165, 120.00, '01-25-2025 03:55:49'),
(15, 171, 125.00, '01-26-2025 13:58:24'),
(16, 171, 125.00, '01-26-2025 14:07:29'),
(17, 171, 125.00, '01-26-2025 14:08:30'),
(18, 172, 125.00, '01-26-2025 15:58:22'),
(19, 175, 0.00, '01-26-2025 16:01:46'),
(20, 174, 0.00, '01-26-2025 18:03:11'),
(21, 173, 0.00, '01-26-2025 18:08:36'),
(22, 176, 125.00, '01-26-2025 18:09:05'),
(23, 191, 740.00, '01-30-2025 16:41:04'),
(24, 192, 355.00, '01-30-2025 16:48:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `uid` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `pnumber` bigint(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `birthdate` varchar(255) NOT NULL,
  `user_type` tinyint(1) NOT NULL,
  `address` varchar(255) NOT NULL,
  `joined_at` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `delete_flag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uid`, `name`, `pnumber`, `password`, `email`, `gender`, `birthdate`, `user_type`, `address`, `joined_at`, `image`, `delete_flag`) VALUES
(1, 'AC00001', 'Lamoi', 9123456721, '$2y$10$Y.W7O.f2dVtHtGP/nJhVmucopMuYfiKTZreqGBMhALF2PqU4nzTFq', 'admin@gmail.com', 'male', '2025-01-30', 0, 'admin', '01-30-2025', '../uploaded_img/679b3f8873108-91519261-lamoi.jpg', 0),
(35, 'AC04158', 'Kim Dami', 9321313323, '$2y$10$Ho7QaHsRPBmIdbaJbJugxeCZMTWsWVoaSHdtvRBBXNcp1zPVpra8m', 'ADMIN@GMAIL.COM', 'male', '2023-06-05', 0, 'ADMIN', '01-26-2025', '3541-Kim Dami.jpg', 1),
(36, 'AC00000', 'Rolly Raytos', 91231231211, '$2y$10$qoLP7tJ7P9t7COa8Go2ykO97qSY965Kq1BZr7c1uREQ1Ns4Cb0hf.', 'raytos.r.bsinfotech@gmail.com', 'male', '01-14-2025', 1, 'ADMIN', '01-22-2025', '13881-Jisoo.jpg', 0),
(48, 'AC39805', 'Lamoi', 85352434123, '$2y$10$jhA36BS0Ai/.6o4JrfMjaOJPcB6.FJWhYGCHKJ9SIxHawmqpjdP5a', 'lamolamoi@gmail.com', 'female', '2020-03-19', 0, 'dasdasdasdasdas', '01-22-2025', '85541-Kim Dami.jpg', 0),
(49, 'AC49132', 'test', 0, '$2y$10$ibB0JIO9aL7ipjEGmIlD7uIsDZ8utF69G07iZfzOM2yNkKkBK5cBm', '', 'male', '', 0, '', '01-22-2025', NULL, 1),
(50, 'AC22791', '', 0, '$2y$10$rg4SKQNTCCdwtT3a9b.SR.yPT8nRURQ2jwadEnbbCOtW9YCc0gk52', '', 'male', '', 0, '', '01-22-2025', NULL, 1),
(51, 'AC53912', 'test', 91321231344, '$2y$10$i/8.HUdGwLWNgS6rj/46kukzsBi6xbgS0FdbgYS2UWG9Qg.t9qsSe', 'test@gmail.com', 'male', '2025-01-06', 0, 'test', '01-22-2025', '94039-EspressoFrappuccino.jpg', 1),
(52, 'AC39867', 'test', 0, '$2y$10$E3rcjzuspXbI6dQCzANE.uKagpXiQrU8DbLfUz/.WqjVksmvdS9XO', 'test@gmail.com', 'male', '2025-01-15', 0, 'test', '01-22-2025', NULL, 1),
(53, 'AC97242', 'Test', 9999999999, '$2y$10$Mv69a4heYrAPFWYiGrp8OuEQi5raE6iIogi7Wk.hlGpsL2.YtoctC', 'test@gmail.com', 'male', '2025-01-15', 0, 'test', '01-25-2025', '74969-EspressoFrappuccino.jpg', 1),
(54, 'AC52133', 'Staff', 9999999999, '$2y$10$.FHeuLQUDbWPJ/7yK7KZp.GJt5kkUutdJQNyFcAbRphnY6dsCkrIu', 'ra@gmail.com', 'male', '2025-01-26', 0, 'as', '01-26-2025', NULL, 1),
(55, 'AC53093', 'Staff', 9999999999, '$2y$10$s4MuYs5IAmQdwK2igj4VwunJ3sS3qY6TIDl9X4F1ArtU6kuh97QVu', 'rarara@gmail.com', 'male', '2025-01-23', 0, 'adaa', '01-26-2025', NULL, 1),
(56, 'AC01443', 'staff', 9999999999, '$2y$10$rrt2/K2GR02RBZg4iELL1uCZP/7pwrCcM4EKLUVTvsTF7LKanWLRW', 'rar@gmail.com', 'male', '2025-01-14', 0, 'ads', '01-26-2025', NULL, 1),
(57, 'AC19791', 'staff', 9999999999, '$2y$10$vL4rjEnT8JQ76odIm8JAHOkIVdLjjrMGmtKjXCE7gooja/wJjdeFi', 'sd@gmail.com', 'male', '2025-01-07', 0, 'staff', '01-26-2025', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=619;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1182;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `product_variations`
--
ALTER TABLE `product_variations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
