-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2024 at 10:03 PM
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
-- Database: `be22_exam5_animal_adoption_navidjafartash`
--
CREATE DATABASE IF NOT EXISTS `be22_exam5_animal_adoption_navidjafartash` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `be22_exam5_animal_adoption_navidjafartash`;

-- --------------------------------------------------------

--
-- Table structure for table `animal`
--

CREATE TABLE `animal` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `size` enum('small','medium','large') NOT NULL,
  `age` int(11) NOT NULL,
  `vaccinated` tinyint(1) DEFAULT NULL,
  `breed` varchar(255) DEFAULT NULL,
  `status` enum('Adopted','Available') DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animal`
--

INSERT INTO `animal` (`id`, `name`, `photo`, `location`, `description`, `size`, `age`, `vaccinated`, `breed`, `status`) VALUES
(20, 'Buddy', 'golden-retriever.webp', 'New York, NY', 'Friendly and energetic dog.', 'small', 3, 1, '0', 'Adopted'),
(21, 'Whiskers', 'Siamse.webp', 'Los Angeles, CA', 'Curious and playful cat.', 'small', 2, 1, '0', 'Adopted'),
(22, 'Max', 'German-shepherd.jpg', 'Chicago, IL', 'Loyal and protective dog.', 'small', 5, 1, '0', 'Available'),
(23, 'Luna', 'Maine Coon.jpg', 'Houston, TX', 'Calm and affectionate cat.', 'small', 4, 1, '0', 'Available'),
(24, 'Charlie', '2AE14CDD-1265-470C-9B15F49024186C10_source.webp', 'Phoenix, AZ', 'Happy and playful dog.', 'small', 1, 0, '0', 'Available'),
(25, 'Bella', 'persian cat.jpg', 'Philadelphia, PA', 'Loving and gentle cat.', 'small', 3, 1, '0', 'Available'),
(26, 'Rocky', 'bulldog.jpeg', 'San Antonio, TX', 'Strong and brave dog.', 'small', 9, 1, 'Bulldog', 'Available'),
(27, 'Mittens', 'Tabby.webp', 'San Diego, CA', 'Adventurous and curious cat.', 'small', 10, 0, '0', 'Available'),
(28, 'Daisy', 'poodle.jpg', 'Dallas, TX', 'Sweet and playful dog.', 'small', 2, 1, 'Poodle', 'Available'),
(29, 'Shadow', 'black.jpeg', 'San Jose, CA', 'Mysterious and quiet cat.', 'small', 11, 1, 'Black Cat', 'Available'),
(30, 'Bruno', 'rottweiler-760x570.webp', 'Austin, TX', 'Loyal and strong dog.', 'small', 12, 1, 'Rottweiler', 'Available'),
(31, 'Simba', 'Sphynx-4-645mk062211.jpg', 'Jacksonville, FL', 'King of the house.', 'small', 8, 1, '0', 'Available'),
(32, 'Oliver', 'abyssinian-medium-sized-purebreed-cat.jpg', 'Columbus, OH', 'Curious and playful cat.', 'small', 9, 1, '0', 'Available'),
(33, 'Coco', 'Biewer_Yorkshire_Terrier_OG.jpg', 'Charlotte, NC', 'Playful and energetic dog.', 'small', 13, 1, 'Yorkshire Terrier', 'Available'),
(34, 'Tiger', 'bengalkatze-2-768x582.jpg', 'San Francisco, CA', 'Brave and strong cat.', 'small', 10, 1, 'Bengal', 'Available'),
(35, 'Chill Boy  ', 'chili.webp', 'Hom', 'Chill Boy', 'small', 5, 0, 'Chili', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `pet_adoption`
--

CREATE TABLE `pet_adoption` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `adoption_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet_adoption`
--

INSERT INTO `pet_adoption` (`id`, `user_id`, `pet_id`, `adoption_date`) VALUES
(32, 11, 21, '2024-08-03 11:25:18'),
(33, 11, 20, '2024-08-03 15:44:56');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `address`, `picture`, `password`, `role`) VALUES
(11, 'admin', 'admin', 'admin@gmail.com', '1234444', 'vienna', 'admin.jpg', '$2y$10$UHJt.e7by3QbIgbpawSkG.t5igchbIBJ/ju3fZYWQ65GmpZxSJiz.', 'admin'),
(12, 'user', 'user', 'user@gmail.com', '123344', 'vienna', 'user.png', '$2y$10$SBTVu3IHv1XOJOkfw4FQO.Xs/o3E8/xcLCGvnzsq85N/68hPitBOO', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pet_id` (`pet_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animal`
--
ALTER TABLE `animal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD CONSTRAINT `pet_adoption_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `animal` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pet_adoption_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
