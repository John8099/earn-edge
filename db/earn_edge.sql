-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2024 at 07:02 PM
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
-- Database: `earn_edge`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `custom_img` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `date_created`, `date_modified`, `custom_img`) VALUES
(6, 4, 1, 1, '2024-05-21 19:56:40', '2024-05-21 19:56:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `icon` varchar(250) DEFAULT NULL,
  `formatted_name` text NOT NULL,
  `slug` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `icon`, `formatted_name`, `slug`, `date_created`, `date_updated`) VALUES
(1, NULL, 'T-shirt', 't-shirt', '2024-04-04 13:21:38', '2024-04-04 13:21:38'),
(5, NULL, 'Water Refilling', 'water_refilling', '2024-04-04 14:00:48', '2024-04-04 14:01:24'),
(6, NULL, 'Test', 'test', '2024-04-23 10:08:25', '2024-04-23 10:08:25');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_number` varchar(32) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('pending','preparing','to_pickup','paid','canceled','not_claimed','expired') NOT NULL,
  `paypal_paid` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `status`, `paypal_paid`, `date_created`, `date_modified`) VALUES
(1, '20240423120322', 3, 'paid', 0, '2024-04-23 10:03:22', '2024-04-23 10:06:47'),
(2, '20240423120421', 3, 'canceled', 0, '2024-04-23 10:04:21', '2024-04-23 10:04:40'),
(3, '20240428172040', 3, 'not_claimed', 0, '2024-04-28 15:20:40', '2024-05-01 09:39:30'),
(4, '20240519094958', 3, 'expired', 0, '2024-05-19 07:49:58', '2024-05-21 19:51:55'),
(6, '20240522185049', 4, 'to_pickup', 1, '2024-05-22 16:50:49', '2024-05-22 16:52:53');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `custom_img` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `custom_img`) VALUES
(1, 1, 1, 2, 'http://localhost/earn-edge/uploads/custom_design/662787331c3e0_wp2760866.png'),
(2, 1, 1, 1, NULL),
(3, 2, 1, 2, NULL),
(4, 3, 1, 1, NULL),
(5, 4, 1, 1, NULL),
(6, 5, 1, 1, NULL),
(7, 6, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_img` text NOT NULL,
  `name` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `selling_price` double NOT NULL,
  `description` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_img`, `name`, `category_id`, `quantity`, `selling_price`, `description`, `date_created`, `date_modified`) VALUES
(1, 'http://localhost/earn-edge/uploads/products/662786df1ce59_scary.png', 'Sample', 1, 92, 150, 'Test Description<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n', '2024-04-23 10:00:28', '2024-05-22 16:50:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(55) NOT NULL,
  `mname` varchar(55) DEFAULT NULL,
  `lname` varchar(55) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `mname`, `lname`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Super', NULL, 'Admin', 'admin@admin.com', 'c4ca4238a0b923820dcc509a6f75849b', 'admin', '2024-04-10 06:25:08'),
(2, 'User', NULL, 'Test', 'user@test.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'user', '2024-04-10 08:59:43'),
(3, 'test', 'test', 'test', 'test@test.test', '098f6bcd4621d373cade4e832627b4f6', 'user', '2024-04-23 10:01:42'),
(4, 'test', 'test', 'test', 'test@test.com', 'c4ca4238a0b923820dcc509a6f75849b', 'user', '2024-05-21 19:42:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
