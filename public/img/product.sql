-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: 5.79.67.193
-- Generation Time: May 02, 2019 at 02:22 PM
-- Server version: 5.7.13-log
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `regoldi`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price2` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price3` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount2` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount3` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manual` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seguranca` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `details`, `ref`, `price1`, `price2`, `price3`, `amount2`, `amount3`, `category`, `file`, `manual`, `seguranca`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Mega Barbeador', '21412412414', '10', '9', '8', '5', '10', 'Casa De Banho', 'Admin2019-04-25.jpg', 'Admintecnica2019-04-25.jpeg', 'Adminseguranca2019-04-16.pdf', '2019-04-16 09:32:30', '2019-04-25 19:16:45'),
(2, 'Regol 18', 'Lavatudo Pinho', 'R18', '3', '2,5', '1', '5', '10', 'Limpeza', 'Regol 182019-04-26.jpeg', 'Regol 18tecnica2019-04-26.jpg', 'Regol 18seguranca2019-04-26.jpg', '2019-04-26 08:28:23', '2019-04-26 08:28:23'),
(3, 'REGOL 16', 'Detergente Manual de Loiça Profissional', 'r16', '6,00€', '5.10€', '4.80€', '30.60', '48,00', 'LAVAGEM MANUAL DE LOIÇA', 'REGOL 162019-04-29.jpg', 'REGOL 16tecnica2019-04-29.pdf', 'REGOL 16seguranca2019-04-29.pdf', '2019-04-29 11:39:23', '2019-04-29 11:39:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
