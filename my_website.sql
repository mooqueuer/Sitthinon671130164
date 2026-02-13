-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 13, 2026 at 05:25 AM
-- Server version: 5.7.17-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_website`
--

--
-- Dumping data for table `assessments`
--

INSERT INTO `assessments` (`id`, `evaluator_name`, `target_user`, `c1`, `c2`, `c3`, `c4`, `c5`, `c6`, `c7`, `c8`, `c9`, `c10`, `total_score`, `comment`, `evidence_file`, `created_at`) VALUES
(1, 'Admin', 'Kew', 9, 9, 9, 8, 2, 5, 5, 5, 6, 6, 64, NULL, '1770785102_evidence.png', '2026-02-11 04:45:02'),
(2, 'Admin', 'chaiyaphat', 10, 5, 7, 5, 10, 6, 5, 5, 4, 5, 62, NULL, '1770794443_evidence.png', '2026-02-11 07:20:43'),
(3, 'Admin', 'chaiyaphat', 7, 7, 7, 1, 7, 7, 7, 7, 7, 7, 64, NULL, '1770801147_evidence.png', '2026-02-11 09:12:27'),
(4, 'Admin', 'Kew', 7, 7, 7, 7, 7, 7, 9, 9, 9, 9, 78, NULL, '1770801297_evidence.png', '2026-02-11 09:14:57'),
(5, 'ChaiyaphatSang', 'Sitthinon', 9, 10, 10, 10, 10, 10, 10, 10, 10, 10, 99, NULL, '1770801470_evidence.png', '2026-02-11 09:17:50'),
(6, 'ChaiyaphatSang', 'ChaiyaphatSang', 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 90, NULL, '', '2026-02-11 09:18:11'),
(7, 'Admin', 'Kew', 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 90, NULL, '1770803337_evidence.png', '2026-02-11 09:48:57');

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `fullname`, `department`, `created_at`) VALUES
(4, 'Kew', 'mooqueuer@gmail.com', '$2y$10$OL/M7rTTTcBncCJe307HE.xDWdvv.Q8NjK1QvwSIcnrVLS2SN/H8S', 'student', 'ไม่ได้ระบุชื่อ', '-', '2026-02-11 04:05:05'),
(5, 'Admin', 'zxcqweqwer@gamil', '$2y$10$vL22./fYxpBxuSPw/ygqG.qkZYFMFNEzAqhzxBka8VyqlKeOA1uYS', 'admin', 'ไม่ได้ระบุชื่อ', '-', '2026-02-11 04:14:24'),
(7, 'ChaiyaphatSang', 'ChaiyaphatSang@gmail', '$2y$10$fUI0/en905CYXH8.6p93n.XNqAiHQvzeCe8gNQLub8JY54EFhqk52', 'evaluator', 'ไม่ได้ระบุชื่อ', '-', '2026-02-11 04:19:36'),
(8, 'Sitthinon', 'std671130164@petkasem.ac.th', '$2y$10$cQfepWO3eTcC6aseS6iCc.hkJDsScwLd4IEGOSGi7Bi.IY05pY8au', 'student', 'ไม่ได้ระบุชื่อ', '-', '2026-02-11 04:58:17'),
(9, 'chaiyaphat', 'tau@gmail.com', '$2y$10$JZRoM17eNQR5KCHgRnooBuVXX.slcwX8.C4oXuy6UFn5FWIMk4nVW', 'student', 'ไม่ได้ระบุชื่อ', '-', '2026-02-11 07:17:38');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
