-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 07:37 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `homelybakers`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `created_at`, `status`) VALUES
(1, 'admin.hb@gmail.com', '$2y$10$ur42Re5wU1tIjH47cl/brOSw1vOAdpCo1aPoBXXvERn6QagvGS.d2', '2025-04-13 08:56:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bulk_orders`
--

CREATE TABLE `bulk_orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `phone` double NOT NULL,
  `address` text NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `total_price`, `added_at`, `status`) VALUES
(45, 2, 8, 5, '20.00', '2025-05-27 15:29:43', 1),
(46, 2, 11, 1, '60.00', '2025-05-27 15:29:48', 1),
(48, 2, 3, 1, '252.00', '2025-05-27 16:36:03', 1),
(49, 13, 14, 5, '12.00', '2025-05-28 05:22:09', 1),
(50, 13, 16, 5, '10.00', '2025-05-28 05:22:12', 1),
(51, 13, 8, 5, '20.00', '2025-05-28 05:22:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `created_at`, `status`) VALUES
(1, 'Bakery Essentials', '2025-04-14 03:14:11', 1),
(2, 'Cakes', '2025-04-23 02:15:04', 1),
(3, 'Packet Snacks', '2025-04-23 02:15:16', 1),
(4, 'Fried Snacks', '2025-04-23 02:16:48', 1),
(5, 'Steam cooked', '2025-05-28 01:43:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `offer_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date NOT NULL,
  `offer_percent` decimal(5,2) DEFAULT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `offer_name`, `description`, `category_id`, `start_date`, `end_date`, `offer_percent`, `status`) VALUES
(1, 'offer', 'month end offer', 2, '2025-05-05', '2025-05-08', '20.00', 0),
(6, 'Vaccation Offer', 'sample', 3, '2025-05-16', '2025-05-23', '12.00', 0),
(8, 'Big sale', 'sample big sale', 2, '2025-05-19', '2025-05-30', '10.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `payment_mode` enum('cod','card','net banking') DEFAULT NULL,
  `order_status` enum('success','pending','cancel') DEFAULT NULL,
  `user_note` text DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `payment_mode`, `order_status`, `user_note`, `order_date`, `status`) VALUES
(3, 2, '280.00', 'card', 'success', 'Happy Anniversary message on cake', '2025-05-26 05:38:56', 1),
(4, 10, '65.00', 'net banking', 'success', '', '2025-05-26 22:01:37', 1),
(5, 12, '105.00', 'cod', 'pending', '', '2025-05-26 23:38:31', 1),
(6, 13, '280.00', 'cod', 'cancel', 'Happy Anniversary', '2025-05-27 00:21:10', 0),
(7, 2, '45.00', 'cod', 'pending', '', '2025-05-27 00:29:50', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `total_price`, `status`) VALUES
(6, 3, 3, 1, '280.00', '280.00', 1),
(7, 3, 1, 6, '12.00', '72.00', 0),
(8, 3, 10, 2, '25.00', '50.00', 0),
(9, 4, 9, 1, '65.00', '65.00', 1),
(10, 4, 8, 1, '20.00', '20.00', 0),
(11, 5, 6, 1, '45.00', '45.00', 1),
(12, 5, 11, 1, '60.00', '60.00', 1),
(13, 6, 3, 1, '280.00', '280.00', 0),
(14, 7, 6, 1, '45.00', '45.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `payment_mode` enum('card','cod','net banking') DEFAULT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `payment_id`, `order_id`, `amount_paid`, `payment_mode`, `status`) VALUES
(3, NULL, 3, '280.00', 'card', 1),
(4, NULL, 4, '65.00', 'net banking', 1),
(5, NULL, 5, '105.00', 'cod', 0),
(6, NULL, 6, '280.00', 'cod', 0),
(7, NULL, 7, '45.00', 'cod', 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `availability` varchar(100) DEFAULT NULL,
  `offer_id` int(11) DEFAULT NULL,
  `offer_price` float DEFAULT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `image` varchar(300) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `description`, `availability`, `offer_id`, `offer_price`, `original_price`, `image`, `added_at`, `status`) VALUES
(1, 'Cream Bun', 1, 'A sweet, pillowy bun, sliced and filled with a smooth, rich cream.', 'Available', NULL, 12, '12.00', 'cream_bun.jpg', '2025-04-14 03:21:03', 1),
(3, 'Black forest cake', 2, 'Rich black forest cake layered with cherries and cream', 'Available', 8, 252, '280.00', 'black_forest_cake.jpg', '2025-04-23 02:26:02', 1),
(4, 'Chocolate Cup Cake', 2, 'Moist and decadent chocolate cupcakes, baked fresh with premium cocoa.', 'Available', 8, 18, '20.00', 'cupcake.jpeg', '2025-04-24 02:42:43', 1),
(5, 'Veg. Cutlet', 1, 'Golden-brown veg cutlets, packed with a medley of fresh vegetables and spices.', 'Not Available', NULL, 15, '15.00', 'Veg_Cutlet.jpg', '2025-04-24 02:44:55', 1),
(6, 'Twisted Snack', 3, 'Traditional twisted snacks, a crunchy and flavorful South Indian favorite.', 'Available', NULL, 45, '45.00', 'murukku.jpg', '2025-04-24 02:47:34', 1),
(7, 'Roated Peanuts', 3, 'Crunchy roasted peanuts, a simple yet satisfyingly savory snack.', 'Not Available', NULL, 30, '30.00', 'roasted_peanuts.jpg', '2025-04-24 02:49:14', 1),
(8, 'beef Cutlet', 1, 'Crispy pan-fried beef cutlets, seasoned to perfection for a hearty bite.', 'Available', NULL, 20, '20.00', 'beef_cutlet.jpg', '2025-04-25 03:55:56', 1),
(9, 'multi grain bread', 1, 'Nutritious multigrain bread, baked with a blend of wholesome grains for a rich texture and flavor.', 'Available', NULL, 65, '65.00', 'multigrain_bread.jpg', '2025-04-25 03:58:52', 1),
(10, 'Red Velvet Cup Cake', 2, 'Classic red velvet cupcakes, a visually stunning and deliciously decadent bite.', 'Available', 8, 22.5, '25.00', 'Red_Velvet_Cupcakes1.jpg', '2025-04-25 04:35:53', 1),
(11, 'banana Chips', 3, 'Thinly sliced and perfectly fried banana chips, a crunchy taste of the tropics.', 'Available', NULL, 60, '60.00', 'banana_chips.jpg', '2025-04-25 04:41:03', 1),
(12, 'jackfruit chips', 3, 'crispy jackfruit snacks', 'Not Available', NULL, 70, '70.00', 'jackfruit_chips.jpg', '2025-05-16 03:22:13', 1),
(13, 'Elayappam', 5, 'Soft and aromatic Elayappam, a delicate steamed treat with sweet coconut filling.', 'Available', NULL, 10, '10.00', 'elayappam.jpeg', '2025-05-28 01:45:09', 1),
(14, 'Sukhyan', 4, 'A beloved Kerala delicacy, Sukhiyan offers a unique blend of sweetness and earthy flavors in every fried bite.', 'Available', NULL, 12, '12.00', 'sukhiyan.jpg', '2025-05-28 01:47:09', 1),
(15, 'Egg puffs', 1, 'Golden, buttery puffs filled with a delicious, seasoned whole egg.', 'Available', NULL, 15, '15.00', 'egg_puffs.jpg', '2025-05-28 01:49:18', 1),
(16, 'Kozhukatta', 5, 'Soft and tender Kozhukkatta, a wholesome and comforting steamed treat.', 'Available', NULL, 10, '10.00', 'kozhukkatta.jpg', '2025-05-28 01:50:47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `ratings` int(11) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `posted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `ratings`, `review`, `posted_at`, `status`) VALUES
(5, 2, 3, 5, 'Perfect finishing and its very tasty', '2025-05-26 04:45:12', 1),
(9, 10, 9, 3, 'Good', '2025-05-26 22:20:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `created_at`, `status`) VALUES
(2, 'Princy J', 'princyjames1810@gmail.com', '$2y$10$bXRxyfSq1qdUFWRdF34Uw.dI2JNOu3WP3jSvqXUTW.CIJ4XSeo/Jy', '9188572656,8547236134', 'kunnel house lakshmicovil P.O peerumade idukki 685531', '2025-05-13 09:17:16', 1),
(8, 'Deepika', 'deepika123@gmail.com', '$2y$10$zFcYur/uhS5J0VmXxynP0um19z.eOUZTtn07ldBI6Y568Ftcg0LMG', '1234567890', 'ABC building house no123 Kottayam 675432', '2025-05-24 08:53:41', 0),
(9, 'Amith', 'amith@gmail.com', '$2y$10$v08DmynHVD2Rk.TYdt2sleIXFLM3iw2bjsLV.6yr5Hb8P6lE3LASa', '1234567891', 'XYZ building 2nd Floor Kochi 682028', '2025-05-25 06:18:07', 1),
(10, 'Keziya', 'keziya9188@gmail.com', '$2y$10$a7euZGOx4NV3raI9CI6Xae1DmGGWjASOcqFXzHZY8AmWAUX1C1MBG', '9188786534', 'PRA C16, Sreekala road, Palarivattom, Kochi 682029', '2025-05-25 07:37:24', 1),
(11, 'Aju', 'aju1234@gmail.com', '$2y$10$tNVZwnqnZ2o.OwQcHPbYNubA7cGsYFsxNKpFy81QbUW99uTOGNqFe', '7865432656', 'CRA 42 MGM Road, kochi 678854', '2025-05-26 21:10:51', 0),
(12, 'David', 'daviddavid@gmail.com', '$2y$10$R6TeHgd6KrrvUS18/XfPHODqbSrv9I4NHTAMspyffS8/X3bSqNo4i', '9188786534', '4th Floor Oberon Mall, Edappally, Kochi, Kerala 682024, India', '2025-05-26 23:37:45', 1),
(13, 'Amala', 'amala0810@gmail.com', '$2y$10$k9XLSBJUvDEbllLnnsIHxeO7COF5MxzftnXO.0IN8om3kSKb9t1mC', '7865432901', 'Revathy Plaza, Perandoor Road, LFC Rd, Kaloor, Kochi, Kerala 682017, India', '2025-05-27 00:19:43', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bulk_orders`
--
ALTER TABLE `bulk_orders`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bulk_orders`
--
ALTER TABLE `bulk_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
