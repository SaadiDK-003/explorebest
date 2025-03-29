-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2025 at 07:16 PM
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_acc_by_id` (IN `acc_id` INT)   SELECT
a.id AS 'acc_id',
c.id AS 'city_id',
c.city_name,
a.type,
a.location,
a.services
FROM accommodation a
INNER JOIN cities c ON a.city_id=c.id
WHERE a.id=acc_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_acc_types` ()   SELECT
*
FROM accommodation_types$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_acc_user` (IN `user_id` INT)   SELECT
a.id AS 'acc_id',
c.city_name,
a.type,
a.location,
a.accommodation_image,
a.services,
a.status
FROM accommodation a
INNER JOIN cities c ON a.city_id=c.id
WHERE a.u_id=user_id
ORDER BY a.id DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_cities` ()   SELECT
*
FROM cities c 
ORDER BY c.city_name ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_comments_by_place` (IN `place_id` INT)   SELECT
c.id AS 'comment_id',
c.comment,
c.rating,
c.comment_date,
u.username
FROM comments c
INNER JOIN places p ON c.place_id=p.id
INNER JOIN users u ON c.tourist_id=u.id
WHERE c.place_id=place_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_events` ()   SELECT
e.id AS 'event_id',
c.city_name,
e.event_name,
e.date,
e.booking_link,
e.event_img,
e.status
FROM events e
INNER JOIN cities c ON e.city_id=c.id
WHERE e.status = '1'
ORDER BY e.id DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_events_admin` ()   SELECT
e.id AS 'event_id',
c.city_name,
e.event_name,
e.date,
e.booking_link,
e.event_img,
e.status
FROM events e
INNER JOIN cities c ON e.city_id=c.id
ORDER BY e.id DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_events_user` (IN `user_id` INT)   SELECT
e.id AS 'event_id',
c.city_name,
e.event_name,
e.date,
e.booking_link,
e.event_img,
e.status
FROM events e
INNER JOIN cities c ON e.city_id=c.id
WHERE e.u_id=user_id
ORDER BY e.id DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_event_by_id` (IN `event_id` INT)   SELECT
e.id AS 'event_id',
c.id AS 'city_id',
c.city_name,
e.event_name,
e.date,
e.booking_link
FROM events e
INNER JOIN cities c ON e.city_id=c.id
WHERE e.id=event_id$$

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_places_by_id` (IN `place_id` INT)   SELECT
p.id AS 'place_id',
c.id AS 'city_id',
c.city_name,
p.type,
p.location,
p.description
FROM places p
INNER JOIN cities c ON p.city_id=c.id
WHERE p.id=place_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_places_user` (IN `user_id` INT)   SELECT
p.id AS 'place_id',
c.city_name,
p.type,
p.location,
p.place_img,
p.description,
p.status
FROM places p
INNER JOIN cities c ON p.city_id=c.id
WHERE p.u_id=user_id ORDER BY p.id DESC$$

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

-- --------------------------------------------------------

--
-- Table structure for table `accommodation_types`
--

CREATE TABLE `accommodation_types` (
  `id` int(11) NOT NULL,
  `types` varchar(255) NOT NULL DEFAULT 'hotel'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accommodation_types`
--

INSERT INTO `accommodation_types` (`id`, `types`) VALUES
(1, 'apartment'),
(2, 'chalet'),
(3, 'hotel'),
(4, 'test_acc');

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
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `tourist_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `comment_date` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `rating`, `tourist_id`, `place_id`, `comment_date`) VALUES
(4, 'very good.', 5, 2, 11, '2025-03-29'),
(5, 'emm coffee was ok.', 4, 4, 11, '2025-03-29'),
(6, 'so so.', 3, 2, 12, '2025-03-29');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
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
(11, 3, 'restaurant', 'Beautiful Place', './img/place/hotel.jpg', 'good coffee that is perfect for work :D', 3, '1'),
(12, 2, 'cafe', 'public_html', './img/place/restaurant.jpg', 'I want cold Coffee on Friday, it should be a best one you got.', 3, '1');

-- --------------------------------------------------------

--
-- Table structure for table `place_types`
--

CREATE TABLE `place_types` (
  `id` int(11) NOT NULL,
  `types` varchar(255) NOT NULL DEFAULT 'restaurant'
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
(3, 'local', 'local@gmail.com', '4297f44b13955235245b2497399d7a93', 'local', '1'),
(4, 'James', 'tourist1@gmail.com', '4297f44b13955235245b2497399d7a93', 'tourist', '1');

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
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_id` (`place_id`),
  ADD KEY `tourist_id` (`tourist_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `u_id` (`u_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accommodation_types`
--
ALTER TABLE `accommodation_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `place_types`
--
ALTER TABLE `place_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`tourist_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`u_id`) REFERENCES `users` (`id`);

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
