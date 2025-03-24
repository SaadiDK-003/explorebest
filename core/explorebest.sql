-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2025 at 04:15 AM
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
-- Database: `explorebest`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_acc` ()   SELECT
a.id AS 'acc_id',
c.city_name,
a.type,
a.location,
a.accommodation_image AS 'acc_img',
a.services,
a.status
FROM accommodation a
INNER JOIN cities c ON a.city_id=c.id
WHERE a.status = '1'
ORDER BY a.id DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_acc_admin` ()   SELECT
a.id AS 'acc_id',
c.city_name,
a.type,
a.location,
a.accommodation_image,
a.services,
a.status
FROM accommodation a
INNER JOIN cities c ON a.city_id=c.id
ORDER BY a.id DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_acc_types` ()   SELECT
*
FROM accommodation_types$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_cities` ()   SELECT
*
FROM cities c 
ORDER BY c.city_name ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_places` ()   SELECT
p.id AS 'place_id',
c.city_name,
p.type,
p.location,
p.place_img,
p.description,
p.status
FROM places p
INNER JOIN cities c ON p.city_id=c.id
WHERE p.status = '1'
ORDER BY p.id DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_places_admin` ()   SELECT
p.id AS 'place_id',
c.city_name,
p.type,
p.location,
p.place_img,
p.description,
p.status
FROM places p
INNER JOIN cities c ON p.city_id=c.id
ORDER BY p.id DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_place_types` ()   SELECT
*
FROM place_types$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `accommodation`
--

CREATE TABLE `accommodation` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'hotel',
  `location` varchar(255) NOT NULL,
  `accommodation_image` text DEFAULT NULL,
  `services` text NOT NULL,
  `u_id` int(11) NOT NULL,
  `status` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accommodation`
--

INSERT INTO `accommodation` (`id`, `city_id`, `type`, `location`, `accommodation_image`, `services`, `u_id`, `status`) VALUES
(2, 3, 'hotel', 'https://www.elafhotels.com/elaf-al-taqwa', './img/accommodation/hotel.jpg', 'Private parking,Free WiFi', 3, '1');

-- --------------------------------------------------------

--
-- Table structure for table `accommodation_types`
--

CREATE TABLE `accommodation_types` (
  `id` int(11) NOT NULL,
  `types` enum('apartment','hotel','chalet') NOT NULL DEFAULT 'hotel'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accommodation_types`
--

INSERT INTO `accommodation_types` (`id`, `types`) VALUES
(1, 'apartment'),
(2, 'chalet'),
(3, 'hotel');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `city_name`) VALUES
(2, 'Riyadh'),
(3, 'Madina');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `booking_link` varchar(255) DEFAULT NULL,
  `event_img` text DEFAULT NULL,
  `u_id` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT 'restaurant',
  `location` varchar(255) NOT NULL,
  `place_img` text DEFAULT NULL,
  `description` text NOT NULL,
  `u_id` int(11) NOT NULL,
  `status` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `city_id`, `type`, `location`, `place_img`, `description`, `u_id`, `status`) VALUES
(8, 2, 'restaurant', 'https://g.co/kgs/39vddFX', './img/place/restaurant.jpg', 'good coffee that is perfect for work :D', 3, '1'),
(9, 3, 'cafe', 'Beautiful Place', './img/place/hotel.jpg', 'good coffee that is perfect for work :D', 3, '1');

-- --------------------------------------------------------

--
-- Table structure for table `place_types`
--

CREATE TABLE `place_types` (
  `id` int(11) NOT NULL,
  `types` enum('restaurant','cafe') NOT NULL DEFAULT 'restaurant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `place_types`
--

INSERT INTO `place_types` (`id`, `types`) VALUES
(1, 'restaurant'),
(2, 'cafe');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `role` enum('admin','tourist','local') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_nopad_ci NOT NULL DEFAULT 'tourist',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `status`) VALUES
(1, 'admin', 'admin@gmail.com', '4297f44b13955235245b2497399d7a93', 'admin', '1'),
(2, 'tourist', 'tourist@gmail.com', '4297f44b13955235245b2497399d7a93', 'tourist', '1'),
(3, 'local', 'local@gmail.com', '4297f44b13955235245b2497399d7a93', 'local', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accommodation`
--
ALTER TABLE `accommodation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `accommodation_types`
--
ALTER TABLE `accommodation_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `place_types`
--
ALTER TABLE `place_types`
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
-- AUTO_INCREMENT for table `accommodation`
--
ALTER TABLE `accommodation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `accommodation_types`
--
ALTER TABLE `accommodation_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `place_types`
--
ALTER TABLE `place_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accommodation`
--
ALTER TABLE `accommodation`
  ADD CONSTRAINT `accommodation_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `accommodation_ibfk_2` FOREIGN KEY (`u_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `places`
--
ALTER TABLE `places`
  ADD CONSTRAINT `places_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `places_ibfk_2` FOREIGN KEY (`u_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
