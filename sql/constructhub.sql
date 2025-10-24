-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2025 at 03:30 PM
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
-- Database: `constructhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `material_bought` varchar(100) NOT NULL,
  `rating` int(1) NOT NULL,
  `feedback_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `user_id`, `user_name`, `phone_number`, `address`, `material_bought`, `rating`, `feedback_text`, `created_at`) VALUES
(1, 1, 'bhargavi', '9876543211', 'hyd', 'bricks', 5, '', '2025-10-24 10:00:25'),
(2, 1, 'vijaya', '9876543211', 'bcm', 'SR tiles', 4, '', '2025-10-24 10:10:20'),
(3, 1, 'Hency', '9876543211', 'Bhadrachalam', 'SNB Bricks', 5, '', '2025-10-24 13:26:52'),
(4, 2, 'rama', '9876543211', 'vijayawada', 'SNB Bricks', 5, '', '2025-10-24 13:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `material_id` int(11) NOT NULL,
  `material_name` varchar(100) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(20) DEFAULT 'units'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`material_id`, `material_name`, `seller_id`, `price`, `quantity`, `unit`) VALUES
(1, 'Premium Bricks', 1, 25.50, 100, 'units'),
(2, 'OPC Cement', 2, 350.00, 1, 'units'),
(3, 'Rebar Steel', 3, 55000.00, 1, 'units'),
(5, 'tiles', 5, 15.00, 1, 'units'),
(7, 'electrical', 7, 10000.00, 1, 'units'),
(8, 'bricks', 8, 15000.00, 100, 'pieces'),
(9, 'electrical', 9, 10000.00, 1, 'units'),
(10, 'pipes', 9, 100.00, 1, 'units'),
(12, 'plumbing', 15, 10000.00, 1, 'feet'),
(15, 'plumbing', 19, 15000.00, 1, 'units'),
(16, 'tiles', 20, 1.00, 1, 'units'),
(17, 'cement', 4, 500.00, 40, 'kg'),
(19, 'cement', 22, 1000.00, 100, 'kg'),
(20, 'cement', 23, 500.00, 2, 'bags'),
(21, 'cement', 24, 600.00, 50, 'kg'),
(22, 'tiles', 24, 20.00, 1, 'feet'),
(24, 'bricks', 25, 20000.00, 500, 'pieces'),
(25, 'tiles', 26, 100.00, 1, 'sq ft'),
(28, 'tiles', 29, 100.00, 1, 'feet'),
(29, 'bricks', 30, 25000.00, 500, 'pieces'),
(30, 'electrical', 31, 10000.00, 1, 'sq m');

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `seller_id` int(11) NOT NULL,
  `seller_name` varchar(100) NOT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `whatsapp_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`seller_id`, `seller_name`, `contact_number`, `address`, `whatsapp_number`) VALUES
(1, 'ABC Bricks Supplier', '9876543210', 'Near Main Road, City A', '9199008800'),
(2, 'UltraTech Cement', '9988776655', 'Plot No. 12, Industrial Estate, Autonagar, Vijayawada, AP - 520007', '9988776655'),
(3, 'Vizag Steel Plant (RINL)', '9123456780', 'Main Road, MVP Colony, Visakhapatnam, AP - 530017', '9123456780'),
(4, 'ASK cement', '9876543210', ' road no:1/a,guntur', '919900880099'),
(5, 'Jaquar', '9988776655', 'Bath Studio, Road No. 1, Banjara Hills, Hyderabad, TS - 500034', '8466973477'),
(7, 'Anchor by Panasonic', '9966355441', 'Electrical Market, Governorpet, Vijayawada, AP - 520002', '9966355441'),
(8, 'SNB Bricks', '8466973477', 'ashwapuram,Bharadrikothagudem', '8466973477'),
(9, 'Havells India', '9966331101', 'Authorized Dealer, MG Road, Secunderabad, TS - 500003', '9966331101'),
(15, 'Astral Pipes', '9879879871', 'Distributor, Benz Circle, Vijayawada, AP - 520008	', '9879879871'),
(18, 'Balaji', '9988776655', 'Bhadrachalam', '9988776655'),
(19, 'Ashirvad Pipes', '8897021599', 'Plumbing Hub, Kukatpally, Hyderabad, TS - 500072', '8897021599'),
(20, 'Somany Ceramics', '9876543210', 'Showroom No. 45, Jubliee Hills, Hyderabad, TS - 500033', '9876543210'),
(22, 'ASR cements', '8466973477', 'Near Main Road, City A', '8466973477'),
(23, 'CSK seller', '8466973477', 'hyderabad', '8466973477'),
(24, 'swathi seller', '8466973477', 'Near Main Road, City A', '8466973477'),
(25, 'ND Bricks', '8466973477', 'Bhadrachalam', '8466973477'),
(26, 'Balaji Tiles', '9121201677', 'Near Main Road, City A', '8466973477'),
(28, 'kk', '9876543210', 'Near Main Road, City A', '8466973477'),
(29, 'SR Tiles', '9959089251', 'Bhadrachalam', '8466973477'),
(30, 'Nucon blocks light weight bricks company', '8886677506', 'paritala village,kanchikacherla,ap,507280', '8466973477'),
(31, 'ee', '9876543210', 'Near Main Road, City A', '8466973477');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('customer','vendor','admin') DEFAULT 'customer',
  `contact_number` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `user_type`, `contact_number`, `address`, `created_at`, `updated_at`) VALUES
(1, 'bhargavi', 'bhargaviummanaboina7@gmail.com', '$2y$10$7BpWOZYI0UEl/xOob72PSuxdR5KrPTHMD/dAvN5Io93yHxxmDQjie', 'customer', '9876543210', '', '2025-10-24 09:58:57', '2025-10-24 09:58:57'),
(2, 'Rama', 'rama@gmail.com', '$2y$10$xbeJQi0OgfBVdeSIr125deTdXoFEegGFcsrTx0w2F/1Qg.ud/8hQi', 'customer', '', '', '2025-10-24 13:14:47', '2025-10-24 13:14:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`material_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`seller_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `seller_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`seller_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
