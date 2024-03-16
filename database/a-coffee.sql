-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2024 at 05:39 PM
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
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `uid` varchar(10) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` bigint(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `uid`, `product_id`, `name`, `price`, `quantity`, `image`) VALUES
(59, 'CA04158', 1, 'Iced Caffe Mocha', 200, 1, 'IcedCaffeMocha.jpg'),
(60, 'CA04158', 2, 'Salted Caramel Cold Brew', 150, 1, 'SaltedCaramelColdBrew.jpg'),
(61, 'CA04158', 4, 'Iced Cappuccino', 200, 1, 'IcedCappuccino.jpg'),
(62, 'CA04158', 3, 'Vanilla Sweet Cream Cold Brew', 150, 1, 'VanillaSweetCreamColdBrew.jpg'),
(63, 'CA04158', 7, 'Coffee Jelly Frappuccino', 175, 1, 'CoffeeJellyFrappuccino.jpg'),
(64, 'CA04158', 8, 'Caramel Cream Frappuccino', 175, 1, 'CaramelCreamFrappuccino.jpg'),
(65, 'CA04158', 6, 'Espresso Frappuccino', 95, 1, 'EspressoFrappuccino.jpg'),
(66, 'CA04158', 5, 'Coffee Frappuccino', 150, 1, 'CoffeeFrappuccino.jpg'),
(73, '<br /><b>W', 3, 'Vanilla Sweet Cream Cold Brew', 150, 1, 'VanillaSweetCreamColdBrew.jpg'),
(74, '<br /><b>W', 3, 'Vanilla Sweet Cream Cold Brew', 150, 1, 'VanillaSweetCreamColdBrew.jpg'),
(75, '<br /><b>W', 2, 'Salted Caramel Cold Brew', 150, 1, 'SaltedCaramelColdBrew.jpg');

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
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `name`, `quantity`, `description`, `added_at`, `image`) VALUES
(1, 'Chocolate Syrup', '0.040l', '', '03-04-2024 12:54:45', ''),
(2, 'Whole Milk', '1.900l', '', '03-04-2024 12:56:12', ''),
(5, 'Instant Coffee', '14.752kg', '', '03-04-2024 12:57:39', ''),
(6, 'Vanilla Syrup', '13.250l', '', '03-04-2024 10:10:35', ''),
(7, 'Cup', '1000', '', '03-04-2024 11:16:29', '');

-- --------------------------------------------------------

--
-- Table structure for table `inventory-log`
--

CREATE TABLE `inventory-log` (
  `id` int(11) NOT NULL,
  `uid` varchar(10) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory-log`
--

INSERT INTO `inventory-log` (`id`, `uid`, `item_id`, `quantity`, `date`) VALUES
(1, 'CA00000', 1, '30000', '03-04-2024 12:54:45'),
(2, 'CA00000', 2, '1130000', '03-04-2024 12:56:12'),
(5, 'CA00000', 5, '30000', '03-04-2024 12:57:39'),
(6, 'CA00000', 1, '10000', '03-04-2024 12:57:46'),
(7, 'CA00000', 1, '10000', '03-04-2024 12:57:53'),
(8, 'CA00000', 1, '-10000', '03-04-2024 12:58:00'),
(9, 'CA00001', 1, '-39940', '03-04-2024 09:57:53'),
(10, 'CA00001', 1, '30000', '03-04-2024 09:58:35'),
(30, 'CA00001', 5, '10', '03-04-2024 06:56:57'),
(31, 'CA00001', 5, '1', '03-04-2024 06:57:06'),
(32, 'CA00001', 5, '1', '03-04-2024 07:00:00'),
(33, 'CA00001', 5, '1', '03-04-2024 07:00:58'),
(34, 'CA00001', 5, '1', '03-04-2024 07:08:11'),
(35, 'CA00001', 6, '15', '03-04-2024 10:10:35'),
(36, 'CA00001', 6, '14', '03-04-2024 10:27:04'),
(37, 'CA00001', 6, '10', '03-04-2024 10:27:34'),
(38, 'CA00001', 6, '900', '03-04-2024 10:27:49'),
(39, 'CA00001', 6, '1000', '03-04-2024 10:30:11'),
(40, 'CA00001', 6, '1000', '03-04-2024 10:32:28'),
(41, 'CA00001', 6, '1000', '03-04-2024 10:34:50'),
(42, 'CA00001', 6, '1000', '03-04-2024 10:36:32'),
(43, 'CA00001', 6, '10ml', '03-04-2024 10:40:42'),
(44, 'CA00001', 6, '1000ml', '03-04-2024 10:41:22'),
(45, 'CA00001', 6, '1000ml', '03-04-2024 10:44:30'),
(46, 'CA00001', 6, '1000010l', '03-04-2024 10:47:53'),
(47, 'CA00001', 6, '1000010l', '03-04-2024 10:49:11'),
(48, 'CA00001', 6, '11l', '03-04-2024 10:51:28'),
(49, 'CA00001', 5, '43kg', '03-04-2024 10:52:26'),
(50, 'CA00001', 5, '43kg', '03-04-2024 10:53:04'),
(51, 'CA00001', 5, '44kg', '03-04-2024 10:54:18'),
(52, 'CA00001', 5, '44kg', '03-04-2024 10:54:33'),
(53, 'CA00001', 5, '44.10kg', '03-04-2024 10:57:23'),
(54, 'CA00001', 5, '84.10kg', '03-04-2024 10:58:06'),
(55, 'CA00001', 5, '15.00kg', '03-04-2024 10:59:09'),
(56, 'CA00001', 6, '11.10l', '03-04-2024 11:01:49'),
(57, 'CA00001', 6, '11.20l', '03-04-2024 11:08:33'),
(58, 'CA00001', 6, '11.25l', '03-04-2024 11:08:48'),
(59, 'CA00001', 7, '1000', '03-04-2024 11:16:29'),
(60, 'CA00001', 6, '12.250l', '03-06-2024 08:51:07'),
(61, 'CA00001', 6, '13.250l', '03-06-2024 08:51:09'),
(62, 'CA00001', 1, '0.220l', '03-06-2024 11:10:35');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `uid` varchar(10) NOT NULL,
  `products` varchar(999) NOT NULL,
  `amount` bigint(50) NOT NULL,
  `status` int(10) NOT NULL,
  `placed_on` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `uid`, `products`, `amount`, `status`, `placed_on`) VALUES
(4, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-04-2024 03:38:30'),
(5, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-04-2024 04:53:19'),
(6, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-04-2024 05:17:13'),
(7, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-04-2024 05:19:11'),
(8, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-04-2024 05:31:21'),
(9, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-04-2024 05:32:41'),
(10, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-04-2024 05:36:16'),
(11, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-04-2024 05:42:50'),
(12, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-04-2024 05:44:21'),
(13, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-04-2024 05:53:32'),
(14, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-04-2024 05:55:51'),
(15, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-04-2024 06:01:37'),
(16, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-04-2024 06:04:05'),
(17, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-04-2024 06:05:28'),
(18, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-04-2024 06:10:59'),
(19, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-04-2024 06:13:28'),
(20, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-04-2024 06:43:58'),
(21, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 12:16:44'),
(22, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 12:19:50'),
(23, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 12:43:59'),
(24, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 12:49:01'),
(25, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 12:51:31'),
(26, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 12:53:28'),
(27, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 12:54:33'),
(28, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 12:55:54'),
(29, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 12:59:50'),
(30, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 01:04:46'),
(31, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 01:08:29'),
(32, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 01:09:30'),
(33, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 01:10:56'),
(34, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 01:11:49'),
(35, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 01:12:24'),
(36, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 01:13:08'),
(37, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 01:19:46'),
(38, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 01:20:52'),
(39, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 01:22:02'),
(40, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 01:23:09'),
(41, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 01:24:27'),
(42, 'CA00001', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 01:25:26'),
(43, 'CA04158', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 02:12:23'),
(44, 'CA04158', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 02:16:30'),
(45, 'CA04158', '1 Iced Caffe Mocha', 200, 1, '03-05-2024 02:19:22'),
(46, 'CA00001', '3 Iced Caffe Mocha, 1 Iced Cappuccino', 800, 1, '03-06-2024 11:59:20'),
(47, 'CA00001', '1 Iced Caffe Mocha, 1 Salted Caramel Cold Brew, 1 Coffee Frappuccino', 500, 1, '03-13-2024 07:43:11');

-- --------------------------------------------------------

--
-- Table structure for table `pre-orders`
--

CREATE TABLE `pre-orders` (
  `id` int(11) NOT NULL,
  `uid` varchar(10) NOT NULL,
  `products` varchar(999) NOT NULL,
  `amount` double NOT NULL,
  `status` int(11) NOT NULL,
  `placed_on` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pre-orders`
--

INSERT INTO `pre-orders` (`id`, `uid`, `products`, `amount`, `status`, `placed_on`) VALUES
(1, 'CA00000', '1 Iced Caffe Mocha', 200, 2, '03-04-2024 01:23:44'),
(2, 'CA00000', '1 Iced Caffe Mocha', 200, 2, '03-04-2024 01:27:05'),
(3, 'CA00001', '1 Iced Caffe Mocha', 200, 2, '03-04-2024 09:19:33'),
(4, 'CA00001', '1 Iced Caffe Mocha', 200, 2, '03-04-2024 09:19:33'),
(5, 'CA00001', '1 Iced Caffe Mocha', 200, 2, '03-04-2024 09:33:34'),
(6, 'CA00001', '2 Coffee Jelly Frappuccino\n, 1 Iced Caffe Mocha', 550, 2, '03-04-2024 09:40:08'),
(11, 'CA00001', '1 Iced Caffe Mocha', 200, 2, '03-04-2024 04:47:50'),
(12, 'CA00001', '1 Iced Caffe Mocha', 200, 2, '03-04-2024 04:52:05');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `ingredients` varchar(500) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `category`, `description`, `ingredients`, `image`) VALUES
(1, 'Iced Caffe Mocha', '200', 'Iced Coffee', 'Espresso combined with bittersweet mocha sauce and milk over ice. Topped with sweetened whipped cream.\r\n\r\n', '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup', 'IcedCaffeMocha.jpg'),
(2, 'Salted Caramel Cold Brew', '150', 'Hot Coffee', 'Our Signature Starbucks Cold Brew flavored with salted caramel syrup, with a salted caramel flavored foam and drizzle of caramel syrup to finish the drink.\r\n\r\n', '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup', 'SaltedCaramelColdBrew.jpg'),
(3, 'Vanilla Sweet Cream Cold Brew', '150', 'Hot Coffee', 'Just before serving, our slow-steeped custom blend Cold Brew is topped with a delicate float of house-made vanilla sweet cream that cascades throughout the cup.\r\n\r\n', '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup', 'VanillaSweetCreamColdBrew.jpg'),
(4, 'Iced Cappuccino', '200', 'Iced Coffee', 'Dark, rich espresso lies in wait under a smoothed and stretched layer of thick milk foam. An alchemy of barista artistry and craft.\r\n\r\n', '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup', 'IcedCappuccino.jpg'),
(5, 'Coffee Frappuccino', '150', 'Hot Coffee', 'Coffee meets milk and ice in a blender for a rumble and tumble and together they create one of our original Frappuccino® beverages.\r\n\r\n', '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup', 'CoffeeFrappuccino.jpg'),
(6, 'Espresso Frappuccino', '95', 'Hot Coffee', 'Coffee is combined with a shot of espresso and milk, then blended with ice to give you a nice little jolt and lots of sipping joy.\r\n\r\n', '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup', 'EspressoFrappuccino.jpg'),
(7, 'Coffee Jelly Frappuccino\n', '175', 'Iced Coffee', 'Coffee Jelly Frappuccino\n', '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup', 'CoffeeJellyFrappuccino.jpg'),
(8, 'Caramel Cream Frappuccino', '175', 'Iced Coffee', 'A rich and creamy blend of caramel syrup, milk and ice. Topped with whipped cream and a delicious caramel drizzle.\r\n\r\n', '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup', 'CaramelCreamFrappuccino.jpg'),
(9, 'Vanilla Cream Frappuccino', '125', 'Hot Coffee', 'This rich and creamy blend of vanilla bean, milk and ice topped with whipped cream takes va-va-vanilla flavor to another level.\r\n\r\n', '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup', 'VanillaCreamFrappuccino.jpg'),
(11, 'Chocolate Cream Frappuccino', '175', 'Iced Coffee', 'A rich and creamy blend of chocolate flavoured sauce, milk and ice. Topped with whipped cream.\r\n\r\n', '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup', 'ChocolateCreamFrappuccino.jpg'),
(15, 'Iced Signature Chocolate', '95', 'Hot Coffee', 'Milk and signature mocha topped with whipped cream and a chocolate-flavored drizzle. A timeless classic made to sweeten your spirits..\r\n\r\n', '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup', 'IcedSignatureChocolate.jpg'),
(31, 'Iced Chocolate Milk', '120', 'Iced Coffee', 'Cocoas and fresh milk served on ice with whipped cream and chocolate powder.', '8.4g Instant coffee, 100ml whole milk, 30ml chocolate syrup', 'IcedChocolateMilk.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `received_orders` bigint(50) NOT NULL,
  `date` date NOT NULL,
  `amount` bigint(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `user_type` int(2) NOT NULL,
  `address` varchar(255) NOT NULL,
  `joined_at` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uid`, `name`, `pnumber`, `password`, `email`, `gender`, `birthdate`, `user_type`, `address`, `joined_at`, `image`) VALUES
(1, 'CA00001', 'Kim Dami', 9123456789, '$2y$10$qoLP7tJ7P9t7COa8Go2ykO97qSY965Kq1BZr7c1uREQ1Ns4Cb0hf.', 'admin@gmail.com', 'male', '02-28-2024', 1, 'admin', '03-06-2024', 'Kim Dami.jpg'),
(35, 'CA04158', 'Kim Dami', 9, '$2y$10$naC72PHxfR7okQAybAL8hOrxyt6RpQUBDTOY2ed5gi1APn8pT97XC', 'ADMIN@GMAIL.COM', 'male', '02-29-2024', 0, 'ADMIN', '03-06-2024', 'Kim Dami.jpg'),
(36, 'CA00000', 'Rolly Raytos', 912312312, '$2y$10$BARjY.Uz7bEKd/DFFySiuOpamoC7h07iIRM2JylbgyrGypxSYs54C', 'raytos.r.bsinfotech@gmail.com', 'male', '02-29-2024', 1, 'ADMIN', '03-06-2024', 'Kim Dami.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory-log`
--
ALTER TABLE `inventory-log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pre-orders`
--
ALTER TABLE `pre-orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inventory-log`
--
ALTER TABLE `inventory-log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `pre-orders`
--
ALTER TABLE `pre-orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
