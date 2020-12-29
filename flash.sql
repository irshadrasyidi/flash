-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2020 at 06:06 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flash`
--

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(10) UNSIGNED NOT NULL,
  `deck_id` int(10) NOT NULL,
  `frontside` varchar(70) DEFAULT NULL,
  `backside` varchar(70) DEFAULT NULL,
  `difficulty` int(10) DEFAULT NULL,
  `time` int(10) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `decks`
--

CREATE TABLE `decks` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(70) DEFAULT NULL,
  `score` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `decks`
--

INSERT INTO `decks` (`id`, `title`, `score`, `user_id`) VALUES
(9, 'boii', NULL, 22);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(70) NOT NULL,
  `email` varchar(70) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `active` int(10) DEFAULT NULL,
  `created` varchar(50) DEFAULT NULL,
  `updated` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `active`, `created`, `updated`) VALUES
(1, 'Whaaat', 'yis', NULL, NULL, NULL, NULL),
(2, 'a', 'wd', NULL, NULL, NULL, NULL),
(3, 'ayo', '', NULL, NULL, NULL, NULL),
(4, 'arif', 'ayy', NULL, NULL, NULL, NULL),
(5, 'arif', 'ef', NULL, NULL, NULL, NULL),
(6, 'arif', 'd', NULL, NULL, NULL, NULL),
(14, 'f', 'a', NULL, NULL, NULL, NULL),
(15, 'afew', 'dsga', NULL, NULL, NULL, NULL),
(16, 'awd', 'sfw', NULL, NULL, NULL, NULL),
(17, 'we', 'ds', NULL, NULL, NULL, NULL),
(18, 'Arif Rahman', 'curiousarmand@gmail.com', NULL, NULL, NULL, NULL),
(19, 'peculiarnewbie', 'peculiarnewbie@gmail.com', NULL, NULL, NULL, NULL),
(20, 'bolt', 'bolt@bolt.bolt', NULL, NULL, NULL, NULL),
(21, 'bolt', 'bolt@bolt.boolt', '$2y$10$WDN6K0xNUlIydnAwTkNGSeqXiZrmb0AyT2nqwItDGs5Oidm6UHbIu', 1, '1609217265', '1609217265'),
(22, 'a', 'a@a.a', '$2y$10$RDJkOUVkTEFjajloS3prR.AHkr21dkGkyCcVHsE.Au6wwKL6N4jbC', 1, '1609218280', '1609218280');

-- --------------------------------------------------------

--
-- Table structure for table `weights`
--

CREATE TABLE `weights` (
  `id` int(10) UNSIGNED NOT NULL,
  `weight` decimal(10,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `weights`
--

INSERT INTO `weights` (`id`, `weight`) VALUES
(1, '1.0'),
(2, '1.5'),
(3, '5.0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `decks`
--
ALTER TABLE `decks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`,`email`);

--
-- Indexes for table `weights`
--
ALTER TABLE `weights`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `decks`
--
ALTER TABLE `decks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `weights`
--
ALTER TABLE `weights`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
