-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 13, 2026 at 04:35 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `erp_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `title` enum('Mr','Mrs','Miss','Dr') NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `district_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `title`, `first_name`, `last_name`, `contact_number`, `district_id`, `created_at`, `updated_at`) VALUES
(1, 'Miss', 'Maneesha', 'Thathsarani', '077123567', 5, '2026-04-14 14:31:34', '2026-04-14 17:16:15'),
(2, 'Mr', 'Damith', 'Kumara', '0762389608', 7, '2026-04-14 14:31:34', '2026-04-14 17:16:27'),
(3, 'Miss', 'Chethana', 'Fernando', '0753456789', 6, '2026-04-14 14:31:34', '2026-04-14 16:49:21'),
(4, 'Miss', 'Lidiya', 'Rajapakse', '0714566890', 11, '2026-04-14 14:31:34', '2026-04-14 17:16:02'),
(5, 'Mr', 'Chamara', 'Bandara', '0705678901', 14, '2026-04-14 14:31:34', '2026-04-14 14:31:34'),
(7, 'Mrs', 'Nimali', 'Silva', '0762345678', 7, '2026-04-14 16:13:37', '2026-04-14 16:13:37'),
(8, 'Miss', 'Kavindya', 'Fernando', '0753456789', 6, '2026-04-14 16:13:37', '2026-04-14 16:52:46'),
(12, 'Miss', 'vinushki', 'Fernando', '0766266161', 30, '2026-07-13 04:28:50', '2026-07-13 04:28:50'),
(13, 'Mr', 'Trevin', 'perera', '0710792377', 35, '2026-07-13 06:03:11', '2026-07-13 12:48:20'),
(14, 'Mrs', 'Chalani', 'somaratne', '0785123540', 5, '2026-07-13 13:27:46', '2026-07-13 13:27:46');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`) VALUES
(1, 'Ampara'),
(2, 'Anuradhapura'),
(3, 'Badulla'),
(4, 'Batticaloa'),
(5, 'Colombo'),
(6, 'Galle'),
(7, 'Gampaha'),
(8, 'Hambantota'),
(9, 'Jaffna'),
(10, 'Kalutara'),
(11, 'Kandy'),
(12, 'Kegalle'),
(13, 'Kilinochchi'),
(14, 'Kurunegala'),
(15, 'Mannar'),
(16, 'Matale'),
(17, 'Matara'),
(18, 'Monaragala'),
(19, 'Mullaitivu'),
(20, 'Nuwara Eliya'),
(21, 'Polonnaruwa'),
(22, 'Puttalam'),
(23, 'Ratnapura'),
(24, 'Trincomalee'),
(25, 'Vavuniya'),
(26, 'Ampara'),
(27, 'Anuradhapura'),
(28, 'Badulla'),
(29, 'Batticaloa'),
(30, 'Colombo'),
(31, 'Galle'),
(32, 'Gampaha'),
(33, 'Hambantota'),
(34, 'Jaffna'),
(35, 'Kalutara'),
(36, 'Kandy'),
(37, 'Kegalle'),
(38, 'Kilinochchi'),
(39, 'Kurunegala'),
(40, 'Mannar'),
(41, 'Matale'),
(42, 'Matara'),
(43, 'Monaragala'),
(44, 'Mullaitivu'),
(45, 'Nuwara Eliya'),
(46, 'Polonnaruwa'),
(47, 'Puttalam'),
(48, 'Ratnapura'),
(49, 'Trincomalee'),
(50, 'Vavuniya');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoice_number` varchar(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `invoice_date` date NOT NULL,
  `total_amount` decimal(14,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `customer_id`, `invoice_date`, `total_amount`, `created_at`) VALUES
(1, 'INV-2024-0001', 1, '2026-01-10', 178750.00, '2026-04-14 14:31:34'),
(2, 'INV-2024-0002', 2, '2026-02-15', 24500.00, '2026-04-14 14:31:34'),
(3, 'INV-2024-0003', 3, '2026-02-01', 208900.00, '2026-04-14 14:31:34'),
(4, 'INV-2025-0001', 4, '2026-01-20', 37800.00, '2026-04-14 14:31:34'),
(5, 'INV-2025-0002', 5, '2026-03-14', 20150.00, '2026-04-14 14:31:34');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `line_total` decimal(14,2) GENERATED ALWAYS AS (`quantity` * `unit_price`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `item_id`, `quantity`, `unit_price`) VALUES
(1, 1, 1, 2, 89500.00),
(2, 2, 3, 1, 24500.00),
(3, 3, 2, 1, 185000.00),
(4, 3, 5, 1, 18900.00),
(5, 3, 4, 4, 1250.00),
(6, 4, 1, 0, 89500.00),
(7, 4, 5, 2, 18900.00),
(8, 5, 4, 10, 1250.00),
(9, 5, 3, 0, 24500.00);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `item_code` varchar(50) NOT NULL,
  `item_name` varchar(150) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `unit_price` decimal(12,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item_code`, `item_name`, `category_id`, `sub_category_id`, `quantity`, `unit_price`, `created_at`, `updated_at`) VALUES
(1, 'ITM-001', 'Samsung Galaxy A55', 1, 1, 50, 89500.00, '2026-04-14 14:31:34', '2026-04-14 14:31:34'),
(2, 'ITM-002', 'Dell Inspiron 15', 1, 2, 20, 185000.00, '2026-04-14 14:31:34', '2026-04-14 14:31:34'),
(3, 'ITM-003', 'Office Executive Chair', 2, 5, 15, 24500.00, '2026-04-14 14:31:34', '2026-04-14 14:31:34'),
(4, 'ITM-004', 'A4 Paper Ream 500s', 5, 15, 200, 1250.00, '2026-04-14 14:31:34', '2026-04-14 14:31:34'),
(5, 'ITM-005', 'Microsoft Office 365', 7, 21, 100, 18900.00, '2026-04-14 14:31:34', '2026-04-14 14:31:34'),
(8, '321', 'macbook', 1, 2, 2, 427000.00, '2026-07-13 05:35:07', '2026-07-13 05:35:07');

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

CREATE TABLE `item_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_categories`
--

INSERT INTO `item_categories` (`id`, `name`) VALUES
(1, 'Electronics'),
(2, 'Furniture'),
(3, 'Clothing'),
(4, 'Food & Beverage'),
(5, 'Stationery'),
(6, 'Hardware'),
(7, 'Software'),
(8, 'Medical'),
(9, 'Automotive'),
(10, 'Sports'),
(11, 'Electronics'),
(12, 'Furniture'),
(13, 'Clothing'),
(14, 'Food & Beverage'),
(15, 'Stationery'),
(16, 'Hardware'),
(17, 'Software'),
(18, 'Medical'),
(19, 'Automotive'),
(20, 'Sports');

-- --------------------------------------------------------

--
-- Table structure for table `item_sub_categories`
--

CREATE TABLE `item_sub_categories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_sub_categories`
--

INSERT INTO `item_sub_categories` (`id`, `category_id`, `name`) VALUES
(1, 1, 'Mobile Phones'),
(2, 1, 'Laptops'),
(3, 1, 'Tablets'),
(4, 1, 'Accessories'),
(5, 2, 'Office Furniture'),
(6, 2, 'Home Furniture'),
(7, 2, 'Outdoor Furniture'),
(8, 3, 'Men'),
(9, 3, 'Women'),
(10, 3, 'Kids'),
(11, 4, 'Beverages'),
(12, 4, 'Snacks'),
(13, 4, 'Fresh Produce'),
(14, 5, 'Pens & Pencils'),
(15, 5, 'Paper Products'),
(16, 5, 'Office Supplies'),
(17, 6, 'Power Tools'),
(18, 6, 'Hand Tools'),
(19, 6, 'Safety Equipment'),
(20, 7, 'Antivirus'),
(21, 7, 'Productivity'),
(22, 7, 'Design Tools'),
(23, 8, 'Medicines'),
(24, 8, 'Equipment'),
(25, 8, 'Supplements'),
(26, 9, 'Car Parts'),
(27, 9, 'Accessories'),
(28, 9, 'Tyres'),
(29, 10, 'Cricket'),
(30, 10, 'Football'),
(31, 10, 'Fitness'),
(32, 1, 'Mobile Phones'),
(33, 1, 'Laptops'),
(34, 1, 'Tablets'),
(35, 1, 'Accessories'),
(36, 2, 'Office Furniture'),
(37, 2, 'Home Furniture'),
(38, 2, 'Outdoor Furniture'),
(39, 3, 'Men'),
(40, 3, 'Women'),
(41, 3, 'Kids'),
(42, 4, 'Beverages'),
(43, 4, 'Snacks'),
(44, 4, 'Fresh Produce'),
(45, 5, 'Pens & Pencils'),
(46, 5, 'Paper Products'),
(47, 5, 'Office Supplies'),
(48, 6, 'Power Tools'),
(49, 6, 'Hand Tools'),
(50, 6, 'Safety Equipment'),
(51, 7, 'Antivirus'),
(52, 7, 'Productivity'),
(53, 7, 'Design Tools'),
(54, 8, 'Medicines'),
(55, 8, 'Equipment'),
(56, 8, 'Supplements'),
(57, 9, 'Car Parts'),
(58, 9, 'Accessories'),
(59, 9, 'Tyres'),
(60, 10, 'Cricket'),
(61, 10, 'Football'),
(62, 10, 'Fitness');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `district_id` (`district_id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `item_code` (`item_code`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `sub_category_id` (`sub_category_id`);

--
-- Indexes for table `item_categories`
--
ALTER TABLE `item_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_sub_categories`
--
ALTER TABLE `item_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `item_categories`
--
ALTER TABLE `item_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `item_sub_categories`
--
ALTER TABLE `item_sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`);

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`),
  ADD CONSTRAINT `invoice_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `item_categories` (`id`),
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`sub_category_id`) REFERENCES `item_sub_categories` (`id`);

--
-- Constraints for table `item_sub_categories`
--
ALTER TABLE `item_sub_categories`
  ADD CONSTRAINT `item_sub_categories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `item_categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
