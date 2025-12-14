-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2025 at 01:40 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `roblox`
--

-- --------------------------------------------------------

--
-- Table structure for table `leaderboard`
--

CREATE TABLE `leaderboard` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leaderboard`
--

INSERT INTO `leaderboard` (`id`, `user_id`, `score`, `created_at`) VALUES
(1, 2, 3, '2025-12-10 05:19:01'),
(4, 4, 15, '2025-12-10 11:07:11'),
(5, 5, 23, '2025-12-10 11:08:11'),
(8, 10, 18, '2025-12-14 10:08:45');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('income','expense') NOT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `bought_in` varchar(50) DEFAULT NULL,
  `income_source` varchar(100) DEFAULT NULL,
  `received_from` varchar(100) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `type`, `item_name`, `category`, `bought_in`, `income_source`, `received_from`, `amount`, `date`, `created_at`) VALUES
(1, 2, 'expense', 'Rambut Jokowi', 'Accecory', 'game', NULL, NULL, 1000, '2006-02-12', '2025-12-12 12:39:25'),
(2, 2, 'income', NULL, '0', NULL, 'Youtube', 'Yanto', 1200, '2006-02-12', '2025-12-12 12:39:59'),
(3, 2, 'income', NULL, '0', NULL, 'asd', 'Yanto', 213, '0000-00-00', '2025-12-12 13:03:22'),
(4, 2, 'income', NULL, '0', NULL, 'Youtube', 'Yanto', 1111, '2025-12-14', '2025-12-14 05:50:53'),
(5, 2, 'expense', 'Topi Fedora', 'avatar', 'game', NULL, NULL, 1000, '2025-12-15', '2025-12-14 05:53:48'),
(6, 2, 'expense', 'Tato Naga', 'accessories', 'game', NULL, NULL, 1000, '2025-12-15', '2025-12-14 05:54:21'),
(7, 2, 'income', NULL, '0', NULL, 'Youtube', 'Yanto', 1000, '2025-12-16', '2025-12-14 05:56:06'),
(8, 2, 'expense', 'Topi', 'gamepass', 'game', NULL, NULL, 121211, '2025-12-14', '2025-12-14 05:57:57'),
(9, 2, 'income', NULL, '0', NULL, 'Initial Balance', 'System', 1212, '2025-12-14', '2025-12-14 07:37:29'),
(10, 2, 'income', NULL, '0', NULL, 'asd', 'sd', 1, '2025-12-11', '2025-12-14 07:37:57'),
(11, 2, 'expense', 'Topi', 'avatar', 'game', NULL, NULL, 2147483647, '2025-12-17', '2025-12-14 07:38:51'),
(12, 2, 'income', NULL, '0', NULL, 'Initial Balance', 'System', 1000, '2025-12-14', '2025-12-14 07:40:26'),
(13, 2, 'income', NULL, '0', NULL, 'y', 'Yanto', 10000000, '2025-12-02', '2025-12-14 09:39:47'),
(14, 4, 'income', NULL, '0', NULL, 'Initial Balance', 'System', 10000, '2025-12-14', '2025-12-14 09:48:12'),
(15, 10, 'income', NULL, '0', NULL, 'Initial Balance', 'System', 100, '2025-12-14', '2025-12-14 10:06:54'),
(16, 10, 'expense', 'Topi', 'accessories', 'game', NULL, NULL, 20, '2025-12-14', '2025-12-14 10:07:25'),
(17, 10, 'income', NULL, '0', NULL, 'Teman', 'Game', 10, '2025-12-14', '2025-12-14 10:08:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `robux_balance` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `robux_balance`) VALUES
(2, 'dhim', '$2y$10$GWJyFwuC136PgU9fjaRNbe4yywT/gR76z4FJcRpp6p6wrkcJgwZce', '2025-12-10 05:03:07', 10001000),
(4, 'bahlil', '$2y$10$R6C.yNBoWRTCYJCAKLzXN.kNOLKM5j6Yz2YBpbX26TXjLkrhFxCFK', '2025-12-10 11:06:32', 10000),
(5, 'trump', '$2y$10$2bMfCFxU05m4u7Ky6dQaL.3.Tufud1zc60ofG452xLZZVR4.l.ASa', '2025-12-10 11:07:35', 0),
(9, 'sujiman', '$2y$10$jRZDKwIPt38J0C8mdyj3J.lK5plPN26oAhfi6c2cxNyO0/xlOpVlO', '2025-12-14 10:01:52', 0),
(10, 'sukiman', '$2y$10$bgxO6Tz2xmqYsxK9BgIOwOUI2.jCRyFrcg2SLP.xlEq43baazLzYy', '2025-12-14 10:06:12', 90);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `leaderboard`
--
ALTER TABLE `leaderboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD CONSTRAINT `leaderboard_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
