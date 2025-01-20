-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2025 at 04:51 PM
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
(153, 'AC00001', 'Aiah Arceta logged out.', '01-19-2025 23:51:09');

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
(5, 'Foods', 0)

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `added_at` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `delete_flag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `name`, `quantity`, `description`, `added_at`, `image`, `delete_flag`) VALUES
(1, 'Chocolate Syrup', '8.760l', 'N/A', '03-04-2024 12:54:45', '', 0),
(2, 'Whole Milk', '7.500l', '', '03-04-2024 12:56:12', '', 0),
(5, 'Instant Coffee', '14.400kg', '', '03-04-2024 12:57:39', '', 0),
(6, 'Vanilla Syrup', '14.220l', '', '03-04-2024 10:10:35', '', 0),
(7, 'Large cup', '10', 'N/A', '03-04-2024 11:16:29', '', 0),

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `uid` varchar(10) NOT NULL,
  `products` varchar(999) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `placed_on` varchar(255) NOT NULL,
  `delete_flag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `uid`, `products`, `amount`, `status`, `placed_on`, `delete_flag`) VALUES
(91, 'AC00001', '1 Oreo Frappe', 145.00, 1, '01-15-2025 09:11:28', 0),
(92, 'AC00001', '1 Salted Caramel Latte', 0.00, 1, '01-17-2025 06:25:04', 0),
(97, 'AC00001', '1 Blueberry (16oz)', 125.00, 1, '01-17-2025 11:44:31', 0),
(98, 'AC00001', '1 Blueberry (12oz), 1 Blueberry (16oz)', 240.00, 1, '01-17-2025 11:58:29', 0),
(99, 'AC00001', '1 Blueberry (12oz), 1 Strawberry (Regular), 1 Blueberry (16oz)', 360.00, 1, '01-18-2025 04:35:42', 0),
(101, 'AC00001', '1 Ube Frappe (12oz) (Hot), 1 Double Chocolate Frappe (16oz) (Ice)', 245.00, 1, '01-18-2025 07:14:10', 0),
(102, 'AC00001', '2 Ube Frappe (12oz) (Ice)', 240.00, 2, '01-19-2025 12:52:19', 1),
(106, 'AC00001', '2 Oreo Frappe (12oz) (Hot)', 230.00, 2, '01-19-2025 01:46:17', 1),
(113, 'AC00001', '1 Ube Frappe (12oz) ()', 120.00, 2, '01-19-2025 02:09:45', 1),
(114, 'AC00001', '1 Ube Frappe (12oz) (Hot)', 120.00, 2, '01-19-2025 02:11:07', 1),
(118, 'AC00001', '1 Ube Frappe (12oz) (Hot)', 120.00, 2, '01-19-2025 02:14:54', 1),
(119, 'AC00001', '1 Ube Frappe (12oz) (Hot)', 120.00, 2, '01-19-2025 02:15:32', 1),
(120, 'AC00001', '1 Ube Frappe (12oz) ()', 120.00, 2, '01-19-2025 02:19:28', 1),
(131, 'AC00001', '1 Ube Frappe (12oz)', 120.00, 2, '01-19-2025 02:40:28', 1),
(132, 'AC00001', '1 Ube Frappe (12oz)', 120.00, 2, '01-19-2025 02:41:41', 1),
(133, 'AC00001', '1 Ube Frappe (12oz)', 120.00, 2, '01-19-2025 02:41:53', 1),
(134, 'AC00001', '1 Blueberries and Cream Frappe (12oz) (Hot)', 125.00, 1, '01-19-2025 02:42:26', 0),
(135, 'AC00001', '1 Matcha Latte (Regular) (Hot)', 125.00, 1, '01-19-2025 08:18:56', 0),
(136, 'AC00001', '3 Caramel Latte (Regular) (Hot), 2 Passion Fruit (12oz) (Ice)', 570.00, 1, '01-19-2025 09:44:58', 0),
(137, 'AC00001', '1 Blueberry (16oz)', 125.00, 1, '01-19-2025 22:37:41', 0),
(138, 'AC00001', '1 Strawberry (Regular)', 120.00, 1, '01-19-2025 23:45:41', 0);

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
(2, 'Strawberry', 4, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'SaltedCaramelColdBrew.jpg', 0),
(3, 'Caramel Latte', 2, 'Just before serving, our slow-steeped custom blend Cold Brew is topped with a delicate float of house-made vanilla sweet cream that cascades throughout the cup.\r\n\r\n', 'VanillaSweetCreamColdBrew.jpg', 0),
(4, 'Hazelnut Latte', 2, 'Dark, rich espresso lies in wait under a smoothed and stretched layer of thick milk foam. An alchemy of barista artistry and craft.\r\n\r\n', 'IcedCappuccino.jpg', 0),
(5, 'Mocha Latte', 2, 'Coffee meets milk and ice in a blender for a rumble and tumble and together they create one of our original Frappuccino® beverages.\r\n\r\n', 'CoffeeFrappuccino.jpg', 0),
(6, 'Vanilla Latte', 2, 'Coffee is combined with a shot of espresso and milk, then blended with ice to give you a nice little jolt and lots of sipping joy.\r\n\r\n', 'EspressoFrappuccino.jpg', 0),
(7, 'French Vanilla Latte', 2, 'Coffee Jelly Frappuccino\n', 'CoffeeJellyFrappuccino.jpg', 0),
(8, 'Macadamia Nut Latte', 2, 'A rich and creamy blend of caramel syrup, milk and ice. Topped with whipped cream and a delicious caramel drizzle.\n\n', 'CaramelCreamFrappuccino.jpg', 0),
(9, 'Brown Sugar Latte', 2, 'This rich and creamy blend of vanilla bean, milk and ice topped with whipped cream takes va-va-vanilla flavor to another level.\r\n\r\n', 'VanillaCreamFrappuccino.jpg', 0),
(11, 'Spanish Latte', 2, 'A rich and creamy blend of chocolate flavoured sauce, milk and ice. Topped with whipped cream.\r\n\r\n', 'ChocolateCreamFrappuccino.jpg', 0),
(15, 'Caramel Macchiato', 2, 'Milk and signature mocha topped with whipped cream and a chocolate-flavored drizzle. A timeless classic made to sweeten your spirits..\r\n\r\n', 'IcedSignatureChocolate.jpg', 0),
(31, 'White Chocolate Mocha', 2, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(35, 'Butterscotch Latte', 2, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(36, 'Salted Caramel Latte', 2, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(38, 'Biscoff Latte', 2, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(39, 'Spiced Latte (Agave)', 2, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(40, 'Double Chocolate Frappe', 1, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(41, 'Oreo Frappe', 1, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(42, 'Vanilla Frappe', 1, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(43, 'Mocha Frappe', 1, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(44, 'Java Chip Frappe', 1, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(45, 'Caramel Macchiato Frappe', 1, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(46, 'Matcha Frappe', 1, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(47, 'Strawberries and Cream Frappe', 1, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(48, 'Blueberries and Cream Frappe', 1, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(49, 'Ube Frappe', 1, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(50, 'Chocolate Latte', 3, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(51, 'Matcha Latte', 3, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(52, 'Ube Latte', 3, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(53, 'Strawberry Latte', 3, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(54, 'Blueberry Latte', 3, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(55, 'Green Apple', 4, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(56, 'Passion Fruit', 4, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(57, 'Strawberry', 2, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),
(58, 'Blueberry', 4, 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', 'IcedChocolateMilk.jpg', 0),

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
(10, 2, 'Regular', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(11, 3, 'Regular', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(12, 4, 'Regular', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(13, 5, 'Regular', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(14, 6, 'Regular', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(15, 7, 'Regular', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(16, 8, 'Regular', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(17, 9, 'Regular', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(18, 11, 'Regular', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(19, 15, 'Regular', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(20, 31, 'Regular', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(21, 35, 'Regular', 105.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(22, 36, 'Regular', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(23, 38, 'Regular', 105.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(24, 39, '12oz', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(25, 40, '12oz', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(26, 40, '16oz', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(27, 41, '12oz', 115.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(28, 42, '12oz', 115.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(29, 43, 'Regular', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(30, 44, '12oz', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(31, 45, 'Regular', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(32, 46, '12oz', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(33, 47, 'Regular', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(34, 48, '12oz', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(36, 49, '12oz', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(37, 50, '16oz', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(39, 51, 'Regular', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(40, 52, '12oz', 120.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(56, 53, 'Regular', 5.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(59, 54, '12oz', 115.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(60, 55, '16oz', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(68, 56, '12oz', 105.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(69, 57, '16oz', 125.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(105, 58, '12oz', 115.00, '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup'),
(106, 58, '16oz', 125.00, '8.4g Instant coffee, 100ml whole milk,30ml chocolate syrup');

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
(4, 138, 120.00, '01-19-2025 23:45:55');

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
(1, 'AC00001', 'Aiah Arceta', 91234567, '$2y$10$qoLP7tJ7P9t7COa8Go2ykO97qSY965Kq1BZr7c1uREQ1Ns4Cb0hf.', 'admin@gmail.com', 'female', '01-01-1970', 0, 'admin', '01-19-2025', 'Developed system.drawio.png', 0),
(35, 'AC04158', 'Kim Dami', 9, '$2y$10$Ho7QaHsRPBmIdbaJbJugxeCZMTWsWVoaSHdtvRBBXNcp1zPVpra8m', 'ADMIN@GMAIL.COM', 'male', '02-29-2024', 0, 'ADMIN', '03-06-2024', 'Kim Dami.jpg', 0),
(36, 'AC00000', 'Rolly Raytos', 912312312, '$2y$10$qoLP7tJ7P9t7COa8Go2ykO97qSY965Kq1BZr7c1uREQ1Ns4Cb0hf.', 'raytos.r.bsinfotech@gmail.com', 'male', '02-29-2024', 1, 'ADMIN', '03-06-2024', 'Jisoo.jpg', 0),
(48, 'AC39805', 'Lamoi', 85352434123, '$2y$10$jhA36BS0Ai/.6o4JrfMjaOJPcB6.FJWhYGCHKJ9SIxHawmqpjdP5a', 'lamolamoi@gmail.com', 'female', '10-23-2024', 0, 'dasdasdasdasdas', '10-13-2024', 'lamoi.jpg', 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1009;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `product_variations`
--
ALTER TABLE `product_variations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
